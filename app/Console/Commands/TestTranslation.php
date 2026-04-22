<?php

namespace App\Console\Commands;

use App\Modules\Shared\Application\Services\TranslationService;
use Illuminate\Console\Command;

class TestTranslation extends Command
{
    protected $signature = 'translate:test {text? : Spanish text to translate}';

    protected $description = 'Test the translation service by translating Spanish text to English';

    public function handle(TranslationService $translator): int
    {
        $spanishText = $this->argument('text') ?? 'Hola, ¿cómo estás? Este es un texto de prueba para traducir del español al inglés.';

        $this->info('Original Spanish text:');
        $this->line($spanishText);
        $this->newLine();

        $this->info('Translating...');

        try {
            $englishText = $translator->translateToEnglish($spanishText);

            $this->newLine();
            $this->info('English translation:');
            $this->line($englishText);

            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Translation failed: ' . $e->getMessage());
            return self::FAILURE;
        }
    }
}
