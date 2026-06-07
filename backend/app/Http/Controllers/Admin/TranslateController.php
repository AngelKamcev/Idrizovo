<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AutoTranslateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TranslateController extends Controller
{
    public function __construct(protected AutoTranslateService $translator) {}

    public function translate(Request $request): JsonResponse
    {
        $request->validate([
            'fields'   => 'required|array|min:1',
            'fields.*' => 'nullable|string|max:10000',
        ]);

        $fields = array_filter(
            $request->input('fields'),
            fn($v) => is_string($v) && trim($v) !== ''
        );

        if (empty($fields)) {
            return response()->json(['error' => 'Нема текст за преведување.'], 422);
        }

        if (!$this->translator->isConfigured()) {
            return response()->json([
                'error' => 'GROQ_API_KEY не е поставен во .env фајлот. Земи бесплатен клуч на https://console.groq.com и додади го.'
            ], 503);
        }

        try {
            $result = $this->translator->translateAll($fields);
            return response()->json($result);
        } catch (\RuntimeException $e) {
            return response()->json(['error' => $e->getMessage()], 502);
        }
    }
}
