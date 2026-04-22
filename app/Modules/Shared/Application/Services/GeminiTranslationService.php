<?php

namespace App\Modules\Shared\Application\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiTranslationService
{
    protected $apiKey;
    protected $model;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.key');
        $this->model = config('services.gemini.model', 'gemini-1.5-flash');
        $this->baseUrl = config('services.gemini.base_url', 'https://generativelanguage.googleapis.com/v1/models/');
    }

    /**
     * Translate text from source language to target language.
     *
     * @param string $text
     * @param string $targetLang
     * @param string $sourceLang
     * @return string|null
     */
    public function translate(string $text, string $targetLang = 'en', string $sourceLang = 'es'): ?string
    {
        if (empty($text) || !$this->apiKey) {
            return null;
        }

        try {
            $prompt = "Translate the following {$sourceLang} text to {$targetLang}. Preserve all HTML tags and structure provided in the text. Return ONLY the translated text, do not add any explanations, markdown code blocks, or quotes:\n\n" . $text;

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . $this->model . ':generateContent?key=' . $this->apiKey, [
                        'contents' => [
                            [
                                'parts' => [
                                    ['text' => $prompt]
                                ]
                            ]
                        ],
                        'generationConfig' => [
                            'temperature' => 0.3,
                        ]
                    ]);

            if ($response->successful()) {
                $data = $response->json();
                $content = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
                return $content ? trim($content) : null;
            }

            if ($response->status() === 429) {
                Log::error('Gemini Translation Error (429): Quota Exceeded');
                throw new \Exception('Se ha agotado la cuota de traducción (Error 429). Por favor, intente más tarde.');
            }

            Log::error('Gemini Translation Error: ' . $response->body());
            return null;

        } catch (\Exception $e) {
            Log::error('Gemini Translation Exception: ' . $e->getMessage());
            return null;
        }
    }
    /**
     * Translate an array of texts.
     *
     * @param array $texts Key-value pair of texts to translate
     * @param string $targetLang
     * @param string $sourceLang
     * @return array
     */
    public function translateBatch(array $texts, string $targetLang = 'en', string $sourceLang = 'es'): array
    {
        if (empty($texts) || !$this->apiKey) {
            return $texts;
        }

        try {
            // Filter out empty values to save tokens
            $itemsToTranslate = array_filter($texts, fn($value) => !empty($value));

            if (empty($itemsToTranslate)) {
                return $texts;
            }

            $jsonContent = json_encode($itemsToTranslate);
            $prompt = "You are a professional translator. Translate the values of the following JSON object from {$sourceLang} to {$targetLang}. " .
                "Preserve keys exactly. Preserve HTML tags and structure. Return ONLY a valid JSON object with the translated values:\n\n" .
                $jsonContent;

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . $this->model . ':generateContent?key=' . $this->apiKey, [
                        'contents' => [
                            [
                                'parts' => [
                                    ['text' => $prompt]
                                ]
                            ]
                        ],
                        'generationConfig' => [
                            'temperature' => 0.3,
                            'responseMimeType' => 'application/json'
                        ]
                    ]);

            if ($response->successful()) {
                $data = $response->json();
                $content = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;

                if ($content) {
                    $translatedItems = json_decode($content, true);
                    if (is_array($translatedItems)) {
                        // Merge translated items back into the original array (to keep keys of empty items)
                        return array_merge($texts, $translatedItems);
                    }
                }
            }

            if ($response->status() === 429) {
                throw new \Exception('Se ha agotado la cuota de traducción (Error 429). Por favor, intente más tarde o verifique su plan de Gemini.');
            }

            Log::error('Gemini Batch Translation Error: ' . $response->body());
            throw new \Exception('Translation service failed: ' . $response->status());

        } catch (\Exception $e) {
            Log::error('Gemini Batch Translation Exception: ' . $e->getMessage());
            throw $e;
        }
    }
}
