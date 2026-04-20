<?php

namespace App\Modules\Shared\Application\Services;

use Prism\Prism\Enums\Provider;
use Prism\Prism\Prism;
use Prism\Prism\Schema\ObjectSchema;
use Prism\Prism\Schema\StringSchema;
use Prism\Prism\ValueObjects\Usage;

class TranslationService
{
    private Provider|string $provider;
    private string $model;

    public function __construct(
        Provider|string|null $provider = null,
        ?string $model = null
    ) {
        // Default to Gemini if not specified
        $this->provider = $provider ?? Provider::Gemini;
        $this->model = $model ?? 'gemini-2.5-flash';
    }

    /**
     * Translate text from Spanish to English using structured output.
     * Preserves HTML formatting if present in the text.
     */
    public function translateToEnglish(string $spanishText, bool $preserveHtml = true): string
    {
        // Define the schema for the translation response
        $schema = new ObjectSchema(
            name: 'translation',
            description: 'A translation from Spanish to English',
            properties: [
                new StringSchema(
                    name: 'translated_text',
                    description: 'The English translation of the Spanish text'
                ),
            ],
            requiredFields: ['translated_text']
        );

        // Build the prompt based on whether we need to preserve HTML
        $prompt = $preserveHtml
            ? "Translate the following Spanish text to English. IMPORTANT: Preserve all HTML tags exactly as they appear (including <p>, <strong>, <em>, <br>, etc.). Only translate the text content, not the HTML tags or attributes. Maintain the original tone and meaning:\n\n{$spanishText}"
            : "Translate the following Spanish text to English. Provide only the translation, maintaining the original tone and meaning:\n\n{$spanishText}";

        $response = Prism::structured()
            ->using($this->provider, $this->model)
            ->withSchema($schema)
            ->withPrompt($prompt)
            ->withMaxTokens(10000)
            ->asStructured();

        $structured = $response->structured;

        // Handle response structure - Prism returns the schema fields directly
        if (is_array($structured) && isset($structured['translated_text'])) {
            return $structured['translated_text'];
        }

        throw new \Exception('Unexpected response structure: ' . json_encode($structured));
    }

    /**
     * Get the usage information from the last translation
     */
    public function getUsage(): ?Usage
    {
        return Prism::structured()
            ->using($this->provider, $this->model)
            ->withSchema(new ObjectSchema('usage', description: 'Usage information', properties: []))
            ->withPrompt('test')
            ->asStructured()
            ->usage;
    }
}
