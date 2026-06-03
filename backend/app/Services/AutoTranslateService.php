<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AutoTranslateService
{
    protected string $model  = 'llama-3.1-8b-instant';
    protected string $apiUrl = 'https://api.groq.com/openai/v1/chat/completions';

    protected function apiKey(): string
    {
        return config('services.groq.api_key', '');
    }

    /**
     * Returns true when a Groq API key is configured.
     */
    public function isConfigured(): bool
    {
        return trim($this->apiKey()) !== '';
    }

    /**
     * Detect the language of the given fields and translate into MK, EN, and SQ in ONE API call.
     *
     * @param  array  $fields  e.g. ['title' => '...', 'content' => '...']
     * @return array  ['mk' => [...], 'en' => [...], 'sq' => [...]]
     * @throws \RuntimeException  when no API key is configured
     */
    public function translateAll(array $fields): array
    {
        $fields = array_filter($fields, fn($v) => is_string($v) && $v !== '');

        if (empty($fields)) {
            return ['mk' => $fields, 'en' => $fields, 'sq' => $fields];
        }

        if (!$this->isConfigured()) {
            throw new \RuntimeException(
                'Groq API key is not configured. Add GROQ_API_KEY to your .env file. Get a free key at https://console.groq.com'
            );
        }

        $inputJson = json_encode($fields, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        $fieldKeys = implode(', ', array_keys($fields));

        $systemPrompt = <<<PROMPT
You are a professional translator for a Macedonian government institution website.

You will receive a JSON object. Your job:
1. Detect the language of the text (Macedonian, English, or Albanian).
2. Translate every field into ALL THREE languages: Macedonian (mk), English (en), Albanian (sq).
3. Return ONLY a raw JSON object - no markdown, no explanation, no extra text, just the JSON.

Output structure must be exactly:
{"mk":{"FIELD":"..."},"en":{"FIELD":"..."},"sq":{"FIELD":"..."}}

Replace FIELD with the actual key names from the input: {$fieldKeys}

Rules:
- Same key names as input.
- If the source is already one of the three languages, copy it as-is for that locale.
- Preserve newlines and formatting within field values.
- Output ONLY the JSON. Nothing before or after it.
PROMPT;

        $response = Http::withToken($this->apiKey())
            ->timeout(30)
            ->post($this->apiUrl, [
                'model'       => $this->model,
                'messages'    => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user',   'content' => $inputJson],
                ],
                'temperature' => 0.1,
                'max_tokens'  => 3000,
            ]);

        if (!$response->successful()) {
            $body = $response->json();
            $msg  = $body['error']['message'] ?? $response->body();
            Log::error('Groq API error', ['status' => $response->status(), 'body' => $msg]);
            throw new \RuntimeException('Groq API error ' . $response->status() . ': ' . $msg);
        }

        $raw  = trim($response->json('choices.0.message.content') ?? '');
        // Strip any markdown fences the model may add despite instructions
        $raw  = preg_replace('/^```(?:json)?\s*/i', '', $raw);
        $raw  = preg_replace('/\s*```\s*$/i', '', trim($raw));
        $data = json_decode($raw, true);

        if (!is_array($data) || !isset($data['mk'], $data['en'], $data['sq'])) {
            Log::error('Groq returned unexpected structure', ['raw' => $raw]);
            throw new \RuntimeException('AI returned an unexpected response format. Try again.');
        }

        return $data;
    }

    /**
     * Spatie-style wrapper: ['field' => ['mk'=>'...','en'=>'...','sq'=>'...']]
     */
    public function createTranslatableData(array $sourceData): array
    {
        $all    = $this->translateAll($sourceData);
        $result = [];

        foreach (array_keys($sourceData) as $field) {
            $result[$field] = [
                'mk' => $all['mk'][$field] ?? $sourceData[$field],
                'en' => $all['en'][$field] ?? $sourceData[$field],
                'sq' => $all['sq'][$field] ?? $sourceData[$field],
            ];
        }

        return $result;
    }
}
