<?php

namespace App\Services;

use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Log;

class AutoTranslateService
{
    protected $translator;

    public function __construct()
    {
        try {
            $this->translator = new GoogleTranslate();
        } catch (\Exception $e) {
            Log::error('Failed to initialize GoogleTranslate: ' . $e->getMessage());
            $this->translator = null;
        }
    }

    /**
     * Translate text from source language to target language
     *
     * @param string $text
     * @param string $from Source language code (mk, en, sq)
     * @param string $to Target language code (mk, en, sq)
     * @return string|null
     */
    public function translate($text, $from = 'mk', $to = 'en')
    {
        try {
            if (!$this->translator || empty($text)) {
                return $text;
            }

            // Map language codes to Google Translate language codes if needed
            $fromLang = $this->mapLanguageCode($from);
            $toLang = $this->mapLanguageCode($to);

            // Translate the text
            $translated = $this->translator
                ->setSource($fromLang)
                ->setTarget($toLang)
                ->translate($text);

            return $translated ?? $text;
        } catch (\Exception $e) {
            Log::warning("Translation failed from {$from} to {$to}: " . $e->getMessage());
            return $text;
        }
    }

    /**
     * Translate array of fields
     *
     * @param array $fields Key-value pairs to translate
     * @param string $from Source language
     * @param array $targetLanguages Target languages
     * @return array
     */
    public function translateFields($fields, $from = 'mk', $targetLanguages = ['en', 'sq'])
    {
        $translations = [];

        foreach ($targetLanguages as $targetLang) {
            $translations[$targetLang] = [];

            foreach ($fields as $field => $value) {
                $translations[$targetLang][$field] = $this->translate($value, $from, $targetLang);
            }
        }

        return $translations;
    }

    /**
     * Map custom language codes to Google Translate language codes
     *
     * @param string $code
     * @return string
     */
    protected function mapLanguageCode($code)
    {
        $mapping = [
            'mk' => 'mk', // Macedonian
            'en' => 'en', // English
            'sq' => 'sq', // Albanian
        ];

        return $mapping[$code] ?? $code;
    }

    /**
     * Create translatable data structure for a model
     *
     * @param array $sourceData Data in source language
     * @param string $sourceLang Source language
     * @param array $targetLangs Target languages
     * @return array
     */
    public function createTranslatableData($sourceData, $sourceLang = 'mk', $targetLangs = ['en', 'sq'])
    {
        $translatableFields = ['title', 'description', 'content'];
        $translations = [];

        // Add the source language data
        foreach ($translatableFields as $field) {
            if (isset($sourceData[$field])) {
                if (!isset($translations[$field])) {
                    $translations[$field] = [];
                }
                $translations[$field][$sourceLang] = $sourceData[$field];
            }
        }

        // Auto-translate to target languages
        foreach ($targetLangs as $targetLang) {
            foreach ($translatableFields as $field) {
                if (isset($sourceData[$field])) {
                    if (!isset($translations[$field])) {
                        $translations[$field] = [];
                    }
                    $translations[$field][$targetLang] = $this->translate(
                        $sourceData[$field],
                        $sourceLang,
                        $targetLang
                    );
                }
            }
        }

        return $translations;
    }
}
