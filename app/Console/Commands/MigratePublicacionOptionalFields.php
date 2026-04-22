<?php

namespace App\Console\Commands;

use App\Modules\Publication\Infrastructure\Models\Publication;
use Illuminate\Console\Command;

class MigratePublicacionOptionalFields extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:publicacion-optional-fields {--test-id= : Test with a specific publication ID} {--dry-run : Show what would be migrated without saving}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate optional fields from publicaciones to new additional_content fields';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $testId = $this->option('test-id');
        $dryRun = $this->option('dry-run');
        
        if ($testId) {
            $this->info("Testing migration with publication ID: {$testId}");
            $publicaciones = Publicacion::where('id', $testId)->get();
        } else {
            $this->info('Starting migration for all publications...');
            $publicaciones = Publicacion::all();
        }
        
        if ($publicaciones->isEmpty()) {
            $this->error('No publications found.');
            return;
        }
        
        $this->info("Found {$publicaciones->count()} publication(s) to migrate.");
        
        $bar = $this->output->createProgressBar($publicaciones->count());
        $bar->start();
        
        $migratedCount = 0;
        
        foreach ($publicaciones as $publicacion) {
            $spanishContent = $this->consolidateOptionalFields($publicacion, 'es');
            $englishContent = $this->consolidateOptionalFields($publicacion, 'en');
            
            if (!empty($spanishContent) || !empty($englishContent)) {
                if ($dryRun) {
                    $this->newLine();
                    $this->info("Publication #{$publicacion->id}: {$publicacion->titulo}");
                    if ($spanishContent) {
                        $this->line("Spanish content: {$spanishContent}");
                    }
                    if ($englishContent) {
                        $this->line("English content: {$englishContent}");
                    }
                } else {
                    $publicacion->update([
                        'additional_content' => $spanishContent ?: null,
                        'additional_content_en' => $englishContent ?: null
                    ]);
                }
                $migratedCount++;
            }
            
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine();
        
        if ($dryRun) {
            $this->info("Dry run completed. Would migrate {$migratedCount} publication(s).");
        } else {
            $this->info("Migration completed! Migrated {$migratedCount} publication(s).");
        }
    }
    
    private function consolidateOptionalFields(Publicacion $publicacion, string $language): string
    {
        $content = [];
        
        for ($i = 1; $i <= 7; $i++) {
            $titleField = $language === 'es' ? "campo_opcional_{$i}_titulo" : "campo_opcional_{$i}_en_titulo";
            $contentField = $language === 'es' ? "campo_opcional_{$i}" : "campo_opcional_{$i}_en";
            
            $title = trim($publicacion->{$titleField} ?? '');
            $fieldContent = trim($publicacion->{$contentField} ?? '');
            
            if (!empty($title) && !empty($fieldContent)) {
                // Clean HTML from title if present
                $cleanTitle = strip_tags($title);
                
                // Clean and format content
                $cleanContent = strip_tags($fieldContent);
                
                $content[] = "<h3>{$cleanTitle}</h3>";
                $content[] = "<p>{$cleanContent}</p>";
                $content[] = ''; // Empty line for spacing
            }
        }
        
        // Remove the last empty line
        if (!empty($content)) {
            array_pop($content);
        }
        
        return implode("\n", $content);
    }
}
