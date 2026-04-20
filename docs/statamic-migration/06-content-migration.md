# Content Migration Process

This document outlines the process for migrating content from the existing database to Statamic CMS.

## Migration Strategy

The migration process will use Laravel Artisan commands to extract data from the current database models and transform it into Statamic entries, assets, and taxonomies.

## Migration Script

Create a migration command that will handle the transfer of content:

```php
// app/Console/Commands/MigrateToStatamic.php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Estrategia;
use App\Models\Publicacion;
use App\Models\Boletin;
use App\Models\Espacio;
use App\Models\Miembro;
use App\Models\Multimedia;
use Statamic\Facades\Entry;
use Statamic\Facades\Asset;
use Statamic\Facades\Term;
use Illuminate\Support\Str;
use DOMDocument;
use DOMXPath;

class MigrateToStatamic extends Command
{
    protected $signature = 'migrate:statamic {type?}';
    protected $description = 'Migrate content from database to Statamic';

    public function handle()
    {
        $type = $this->argument('type');
        
        if (!$type || $type === 'programa') {
            $this->migratePrograma();
        }
        
        if (!$type || $type === 'publicaciones') {
            $this->migratePublicaciones();
        }
        
        if (!$type || $type === 'boletines') {
            $this->migrateBoletines();
        }

        if (!$type || $type === 'miembros') {
            $this->migrateMiembros();
        }

        if (!$type || $type === 'espacios') {
            $this->migrateEspacios();
        }

        if (!$type || $type === 'assets') {
            $this->migrateAssets();
        }
        
        $this->info('Migration complete!');
    }
    
    protected function migratePrograma()
    {
        $this->info('Migrating Estrategias to Programa...');
        
        $estrategias = Estrategia::with('destacada_multimedia', 'multimedia')->get();
        $bar = $this->output->createProgressBar(count($estrategias));
        
        $totalActivities = 0;
        
        foreach ($estrategias as $estrategia) {
            // Determine program type
            $programType = $this->determineProgramType($estrategia);
            
            // Create term if it doesn't exist
            $term = Term::findBySlug($programType, 'program_types') ?? 
                   Term::make()->taxonomy('program_types')->slug($programType)->save();

            // Extract year from date
            $year = date('Y', strtotime($estrategia->fecha));
            $yearTerm = Term::findBySlug($year, 'years') ?? 
                        Term::make()->taxonomy('years')->slug($year)->save();
            
            // Create parent entry (category)
            $parentEntry = Entry::make()
                ->collection('programa')
                ->blueprint('category')
                ->locale('es')
                ->slug(Str::slug($estrategia->titulo))
                ->data([
                    'title' => $estrategia->titulo,
                    'description' => $this->extractMainDescription($estrategia->contenido),
                    'program_type' => [$term->id()],
                    'years' => [$yearTerm->id()],
                    'original_id' => $estrategia->id,
                    // SEO metadata
                    'meta_title' => $estrategia->titulo,
                    'meta_description' => Str::limit(strip_tags($this->extractMainDescription($estrategia->contenido)), 160),
                ]);
            
            $parentEntry->save();
            
            // Create English version if available
            if ($estrategia->titulo_en) {
                $parentEntryEn = Entry::make()
                    ->collection('programa')
                    ->blueprint('category')
                    ->locale('en')
                    ->slug(Str::slug($estrategia->titulo_en))
                    ->data([
                        'title' => $estrategia->titulo_en,
                        'description' => $this->extractMainDescription($estrategia->contenido_en),
                        'program_type' => [$term->id()],
                        'years' => [$yearTerm->id()],
                        'original_id' => $estrategia->id,
                        // SEO metadata
                        'meta_title' => $estrategia->titulo_en,
                        'meta_description' => Str::limit(strip_tags($this->extractMainDescription($estrategia->contenido_en)), 160),
                    ]);
                
                $parentEntryEn->save();
                
                // Associate as translations
                $parentEntry->addLocalization($parentEntryEn);
                $parentEntry->save();
            }
            
            // Migrate primary image to the parent
            if ($estrategia->destacada_multimedia) {
                $this->migrateMedia($estrategia->destacada_multimedia, $parentEntry, 'featured_image');
            }
            
            // Extract and create child activities
            $activities = $this->extractActivities($estrategia->contenido);
            
            foreach ($activities as $index => $activity) {
                $activityEntry = Entry::make()
                    ->collection('programa')
                    ->blueprint('activity')
                    ->locale('es')
                    ->slug(Str::slug($activity['title'] . '-' . $index))
                    ->data([
                        'title' => $activity['title'],
                        'content' => $activity['content'],
                        'date' => $activity['date'] ?? $estrategia->fecha,
                        'location' => $activity['location'] ?? $estrategia->lugar,
                        'facilitators' => $activity['facilitators'] ?? null,
                        'participants' => $activity['participants'] ?? null,
                        'format' => $activity['format'] ?? 'presencial',
                        'parent' => $parentEntry->id(),
                        'years' => [$yearTerm->id()],
                        // SEO metadata
                        'meta_title' => $activity['title'],
                        'meta_description' => Str::limit(strip_tags($activity['content']), 160),
                    ]);
                
                $activityEntry->save();
                
                $totalActivities++;
                
                // Handle English version if available
                if ($estrategia->contenido_en) {
                    $englishActivities = $this->extractActivities($estrategia->contenido_en);
                    
                    if (isset($englishActivities[$index])) {
                        $activityEntryEn = Entry::make()
                            ->collection('programa')
                            ->blueprint('activity')
                            ->locale('en')
                            ->slug(Str::slug($englishActivities[$index]['title'] . '-' . $index))
                            ->data([
                                'title' => $englishActivities[$index]['title'],
                                'content' => $englishActivities[$index]['content'],
                                'date' => $englishActivities[$index]['date'] ?? $estrategia->fecha_en ?? $estrategia->fecha,
                                'location' => $englishActivities[$index]['location'] ?? $estrategia->lugar_en ?? $estrategia->lugar,
                                'facilitators' => $englishActivities[$index]['facilitators'] ?? null,
                                'participants' => $englishActivities[$index]['participants'] ?? null,
                                'format' => $englishActivities[$index]['format'] ?? 'presencial',
                                'parent' => $parentEntryEn->id(),
                                'years' => [$yearTerm->id()],
                                // SEO metadata
                                'meta_title' => $englishActivities[$index]['title'],
                                'meta_description' => Str::limit(strip_tags($englishActivities[$index]['content']), 160),
                            ]);
                        
                        $activityEntryEn->save();
                        
                        // Associate as translations
                        $activityEntry->addLocalization($activityEntryEn);
                        $activityEntry->save();
                    }
                }
            }
            
            // Distribute multimedia among activities
            if ($estrategia->multimedia && count($activities) > 0) {
                $mediaPerActivity = floor(count($estrategia->multimedia) / count($activities));
                
                if ($mediaPerActivity > 0) {
                    $activityEntries = Entry::query()
                        ->where('collection', 'programa')
                        ->where('parent', $parentEntry->id())
                        ->get();
                    
                    foreach ($estrategia->multimedia as $index => $media) {
                        $activityIndex = min(floor($index / $mediaPerActivity), count($activityEntries) - 1);
                        $this->migrateMedia($media, $activityEntries[$activityIndex], 'multimedia');
                    }
                } else {
                    // If not enough media for all activities, assign to parent
                    foreach ($estrategia->multimedia as $media) {
                        $this->migrateMedia($media, $parentEntry, 'multimedia');
                    }
                }
            }
            
            $bar->advance();
        }
        
        $bar->finish();
        $this->info("\nMigrated " . count($estrategias) . " program categories and " . $totalActivities . " activities");
    }
    
    // Helper method to extract main description from content
    protected function extractMainDescription($content)
    {
        if (empty($content)) {
            return '';
        }
        
        // Extract intro paragraph before first heading
        if (preg_match('/(.*?)(?=<h[1-6]|$)/s', $content, $matches)) {
            return trim($matches[1]);
        }
        
        return $content;
    }
    
    // Helper method to extract activities from content
    protected function extractActivities($content)
    {
        $activities = [];
        
        if (empty($content)) {
            return $activities;
        }
        
        // Create DOM document to parse HTML
        libxml_use_internal_errors(true); // Suppress HTML5 errors
        $dom = new DOMDocument();
        $dom->loadHTML('<?xml encoding="UTF-8">' . $content);
        $xpath = new DOMXPath($dom);
        
        // Find all headings
        $headings = $xpath->query('//h1 | //h2');
        
        if ($headings->length === 0) {
            return $activities;
        }
        
        // Process each heading and its content until next heading
        for ($i = 0; $i < $headings->length; $i++) {
            $heading = $headings->item($i);
            $title = trim($heading->textContent);
            
            $content = '';
            $node = $heading->nextSibling;
            
            // Collect all nodes until next heading or end
            while ($node) {
                if ($node->nodeName === 'h1' || $node->nodeName === 'h2') {
                    break;
                }
                
                // Clone the node to avoid modifying the original
                $clone = $node->cloneNode(true);
                
                // Append to content
                if ($clone->nodeType === XML_ELEMENT_NODE) {
                    $content .= $dom->saveHTML($clone);
                } elseif ($clone->nodeType === XML_TEXT_NODE) {
                    $content .= $clone->textContent;
                }
                
                $node = $node->nextSibling;
            }
            
            // Extract metadata from content
            $date = $this->extractDate($content);
            $location = $this->extractLocation($content);
            $facilitators = $this->extractFacilitators($content);
            $participants = $this->extractParticipants($content);
            $partners = $this->extractPartners($content);
            $format = $this->determineFormat($content);
            
            $activities[] = [
                'title' => $title,
                'content' => $content,
                'date' => $date,
                'location' => $location,
                'facilitators' => $facilitators,
                'participants' => $participants,
                'partners' => $partners,
                'format' => $format
            ];
        }
        
        return $activities;
    }
    
    // Helper method to extract dates from content
    protected function extractDate($content)
    {
        // Look for "Fecha:" or "Fechas:" followed by a date
        if (preg_match('/(Fecha|Fechas)\s*:\s*([^<\n]+)/i', $content, $matches)) {
            $dateStr = trim($matches[2]);
            
            // Try standard date formats
            $date = date_parse($dateStr);
            if ($date['year'] && $date['month'] && $date['day']) {
                return sprintf('%04d-%02d-%02d', $date['year'], $date['month'], $date['day']);
            }
            
            // Try Spanish date formats (examples: "9 noviembre de 2024", "mayo a septiembre de 2021")
            $months = [
                'enero' => '01', 'febrero' => '02', 'marzo' => '03', 'abril' => '04',
                'mayo' => '05', 'junio' => '06', 'julio' => '07', 'agosto' => '08',
                'septiembre' => '09', 'octubre' => '10', 'noviembre' => '11', 'diciembre' => '12'
            ];
            
            foreach ($months as $month => $monthNum) {
                if (stripos($dateStr, $month) !== false) {
                    if (preg_match('/(\d{1,2})\s+' . $month . '.*?(\d{4})/i', $dateStr, $dateParts)) {
                        return sprintf('%04d-%02d-%02d', $dateParts[2], $monthNum, $dateParts[1]);
                    } elseif (preg_match('/' . $month . '.*?(\d{4})/i', $dateStr, $dateParts)) {
                        return sprintf('%04d-%02d-%02d', $dateParts[1], $monthNum, '01');
                    }
                }
            }
        }
        
        return null;
    }
    
    // Helper method to extract location from content
    protected function extractLocation($content)
    {
        if (preg_match('/Lugar\s*:\s*([^<\n]+)/i', $content, $matches)) {
            return trim($matches[1]);
        }
        
        return null;
    }
    
    // Helper method to extract facilitators from content
    protected function extractFacilitators($content)
    {
        if (preg_match('/(Facilitador(es|a|as)?|Tallerista(s)?)\s*:\s*([^<\n]+)/i', $content, $matches)) {
            return trim($matches[4]);
        }
        
        return null;
    }
    
    // Helper method to extract participants from content
    protected function extractParticipants($content)
    {
        if (preg_match('/Participantes\s*:\s*([^<\n]+)/i', $content, $matches)) {
            return trim($matches[1]);
        }
        
        return null;
    }
    
    // Helper method to extract partners from content
    protected function extractPartners($content)
    {
        if (preg_match('/(Aliados?|Colabora(n|dores))\s*:\s*([^<\n]+)/i', $content, $matches)) {
            return trim($matches[3]);
        }
        
        return null;
    }
    
    // Helper method to determine format from content
    protected function determineFormat($content)
    {
        $content = strtolower($content);
        
        if (strpos($content, 'en línea') !== false || strpos($content, 'virtual') !== false || strpos($content, 'zoom') !== false) {
            return 'online';
        } elseif (strpos($content, 'mixto') !== false || strpos($content, 'híbrido') !== false) {
            return 'mixto';
        }
        
        return 'presencial';
    }
    
    // Helper method to determine program type
    protected function determineProgramType($estrategia)
    {
        // Logic to determine program type based on estrategia content or tags
        $content = strtolower($estrategia->titulo . ' ' . $estrategia->contenido);
        
        // First check for program categories
        if (strpos($content, 're-conocer los territorios') !== false) {
            return 'programa_externo.intercambios_territoriales';
        } elseif (strpos($content, 'barrio intercultural') !== false) {
            return 'programa_externo';
        } elseif (strpos($content, 'entre vecinos') !== false) {
            return 'programa_local';
        } elseif (strpos($content, 'maíz: biodiversidad') !== false || 
                 strpos($content, 'nutrición y resiliencia') !== false) {
            return 'programa_local.cocina';
        } elseif (strpos($content, 'saberes intergeneracionales') !== false || 
                 strpos($content, 'producir y recrear la escuela') !== false) {
            return 'programa_local.infancias';
        } elseif (strpos($content, 'engranar la energía social') !== false) {
            return 'programa_local.talleres_comunitarios';
        }
        
        // More generic pattern matching
        if (strpos($content, 'exposición') !== false || strpos($content, 'exposiciones') !== false || 
            strpos($content, 'exhibit') !== false || strpos($content, 'muestra') !== false) {
            return 'exposiciones';
        } elseif (strpos($content, 'huerto') !== false || strpos($content, 'garden') !== false || 
                 strpos($content, 'planta') !== false || strpos($content, 'cultivo') !== false) {
            return 'programa_local.huerto';
        } elseif (strpos($content, 'cocina') !== false || strpos($content, 'kitchen') !== false || 
                 strpos($content, 'taller') !== false || strpos($content, 'receta') !== false ||
                 strpos($content, 'comida') !== false || strpos($content, 'alimento') !== false) {
            return 'programa_local.cocina';
        } elseif (strpos($content, 'infantil') !== false || strpos($content, 'niños') !== false || 
                 strpos($content, 'infancia') !== false || strpos($content, 'children') !== false ||
                 strpos($content, 'escuela') !== false || strpos($content, 'school') !== false) {
            return 'programa_local.infancias';
        } elseif (strpos($content, 'mapeo') !== false || strpos($content, 'mapa') !== false || 
                 strpos($content, 'map') !== false || strpos($content, 'territorio') !== false) {
            return 'programa_externo.mapeos';
        } elseif (strpos($content, 'arte') !== false || strpos($content, 'artístico') !== false || 
                 strpos($content, 'artistic') !== false || strpos($content, 'art') !== false) {
            return 'proyectos_artisticos';
        }
        
        // Default based on name
        if (strpos($content, 'resiliencia en comunidad') !== false) {
            return 'programa_local';
        } elseif (strpos($content, 'biodiversidad') !== false) {
            return 'programa_local.huerto';
        } elseif (strpos($content, 'consumo') !== false) {
            return 'programa_local';
        }
        
        // Default fallback
        return 'programa_local';
    }
    
    protected function migratePublicaciones()
    {
        $this->info('Migrating Publicaciones...');
        
        $publicaciones = Publicacion::with('publicacion_multimedia', 'publicacion_thumbnail')->get();
        $bar = $this->output->createProgressBar(count($publicaciones));
        
        foreach ($publicaciones as $publicacion) {
            // Extract year from publication date
            $year = date('Y', strtotime($publicacion->fecha_publicacion));
            $yearTerm = Term::findBySlug($year, 'years') ?? 
                        Term::make()->taxonomy('years')->slug($year)->save();
            
            // Create entry for Spanish
            $entry = Entry::make()
                ->collection('publicaciones')
                ->locale('es')
                ->slug(Str::slug($publicacion->titulo))
                ->data([
                    'title' => $publicacion->titulo,
                    'status' => $publicacion->status ?? 'published',
                    'subtitle' => $publicacion->subtitulo,
                    'publication_date' => $publicacion->fecha_publicacion,
                    'editorial_coordination' => $publicacion->coordinacion_editorial,
                    'design' => $publicacion->diseno,
                    'page_count' => $publicacion->numero_paginas,
                    'type' => $publicacion->tipo,
                    'texts' => $publicacion->textos,
                    'synopsis' => $this->cleanContent($publicacion->sinopsis),
                    'years' => [$yearTerm->id()],
                    // Add remaining fields including optional fields
                    'original_id' => $publicacion->id,
                    // SEO metadata
                    'meta_title' => $publicacion->titulo,
                    'meta_description' => Str::limit(strip_tags($publicacion->sinopsis), 160),
                ]);
            
            $entry->save();
            
            // Create entry for English
            if ($publicacion->titulo_en) {
                $entryEn = Entry::make()
                    ->collection('publicaciones')
                    ->locale('en')
                    ->slug(Str::slug($publicacion->titulo_en))
                    ->data([
                        'title' => $publicacion->titulo_en,
                        'status' => $publicacion->status ?? 'published',
                        'subtitle' => $publicacion->subtitulo_en,
                        'publication_date' => $publicacion->fecha_publicacion_en ?? $publicacion->fecha_publicacion,
                        'editorial_coordination' => $publicacion->coordinacion_editorial_en,
                        'design' => $publicacion->diseno_en,
                        'texts' => $publicacion->textos_en,
                        'synopsis' => $this->cleanContent($publicacion->sinopsis_en),
                        'years' => [$yearTerm->id()],
                        // Add remaining fields including optional fields
                        'original_id' => $publicacion->id,
                        // SEO metadata
                        'meta_title' => $publicacion->titulo_en,
                        'meta_description' => Str::limit(strip_tags($publicacion->sinopsis_en), 160),
                    ]);
                
                $entryEn->save();
                
                // Associate the two entries as translations
                $entry->addLocalization($entryEn);
                $entry->save();
            }

            // Migrate associated media
            if ($publicacion->publicacion_thumbnail) {
                $this->migrateMedia($publicacion->publicacion_thumbnail, $entry, 'featured_image');
            }

            if ($publicacion->publicacion_multimedia) {
                foreach ($publicacion->publicacion_multimedia as $index => $media) {
                    $this->migrateMedia($media, $entry, 'multimedia');
                }
            }
            
            $bar->advance();
        }
        
        $bar->finish();
        $this->info("\nMigrated " . count($publicaciones) . " publication entries");
    }

    protected function migrateBoletines()
    {
        $this->info('Migrating Boletines...');
        
        $boletines = Boletin::with('boletin_multimedia')->get();
        $bar = $this->output->createProgressBar(count($boletines));
        
        foreach ($boletines as $boletin) {
            // Extract year from date
            $year = date('Y', strtotime($boletin->fecha));
            $yearTerm = Term::findBySlug($year, 'years') ?? 
                        Term::make()->taxonomy('years')->slug($year)->save();
            
            // Create entry for Spanish
            $entry = Entry::make()
                ->collection('boletines')
                ->locale('es')
                ->slug(Str::slug($boletin->titulo))
                ->data([
                    'title' => $boletin->titulo,
                    'status' => $boletin->status ?? 'published',
                    'date' => $boletin->fecha,
                    'content' => $this->cleanContent($boletin->contenido),
                    'years' => [$yearTerm->id()],
                    'original_id' => $boletin->id,
                    // SEO metadata
                    'meta_title' => $boletin->titulo,
                    'meta_description' => Str::limit(strip_tags($boletin->contenido), 160),
                ]);
            
            $entry->save();
            
            // Create entry for English if it exists
            if ($boletin->titulo_en) {
                $entryEn = Entry::make()
                    ->collection('boletines')
                    ->locale('en')
                    ->slug(Str::slug($boletin->titulo_en))
                    ->data([
                        'title' => $boletin->titulo_en,
                        'status' => $boletin->status ?? 'published',
                        'date' => $boletin->fecha_en ?? $boletin->fecha,
                        'content' => $this->cleanContent($boletin->contenido_en),
                        'years' => [$yearTerm->id()],
                        'original_id' => $boletin->id,
                        // SEO metadata
                        'meta_title' => $boletin->titulo_en,
                        'meta_description' => Str::limit(strip_tags($boletin->contenido_en), 160),
                    ]);
                
                $entryEn->save();
                
                // Associate the two entries as translations
                $entry->addLocalization($entryEn);
                $entry->save();
            }

            // Migrate associated media
            if ($boletin->boletin_multimedia) {
                foreach ($boletin->boletin_multimedia as $index => $media) {
                    $this->migrateMedia($media, $entry, 'multimedia');
                }
            }
            
            $bar->advance();
        }
        
        $bar->finish();
        $this->info("\nMigrated " . count($boletines) . " newsletter entries");
    }

    // Helper method to clean HTML content
    protected function cleanContent($content)
    {
        if (empty($content)) {
            return '';
        }
        
        // Ensure UTF-8 encoding
        $content = mb_convert_encoding($content, 'UTF-8', 'UTF-8');
        
        // Fix common issues
        $content = str_replace('&nbsp;', ' ', $content);
        
        // Additional cleaning if needed
        
        return $content;
    }

    // Helper method to migrate media files
    protected function migrateMedia($mediaModel, $entry, $fieldName)
    {
        try {
            // Skip if no media
            if (!$mediaModel || !$mediaModel->filename) {
                return;
            }

            $sourcePath = storage_path('app/public/' . $mediaModel->filename);
            
            // Skip if file doesn't exist
            if (!file_exists($sourcePath)) {
                $this->warn("Media file not found: {$sourcePath}");
                return;
            }
            
            // Determine container based on mime type
            $container = 'images'; // Default
            $mimeType = mime_content_type($sourcePath);
            
            if (strpos($mimeType, 'video/') === 0) {
                $container = 'videos';
            } elseif (strpos($mimeType, 'application/') === 0) {
                $container = 'documents';
            }
            
            // Create asset
            $asset = Asset::make()
                ->container($container)
                ->path(basename($mediaModel->filename));
            
            // Copy file to Statamic assets location
            $targetDir = public_path("assets/{$container}");
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }
            
            copy($sourcePath, $targetDir . '/' . basename($mediaModel->filename));
            
            $asset->save();
            
            // Update entry with asset reference
            $entryData = $entry->data();
            
            if ($fieldName == 'featured_image') {
                // Single asset field
                $entryData[$fieldName] = $asset->path();
            } else {
                // Multiple assets field
                if (!isset($entryData[$fieldName]) || !is_array($entryData[$fieldName])) {
                    $entryData[$fieldName] = [];
                }
                $entryData[$fieldName][] = $asset->path();
            }
            
            $entry->data($entryData);
            $entry->save();
            
        } catch (\Exception $e) {
            $this->error("Error migrating media: " . $e->getMessage());
        }
    }
}
```

## Register the Command

Add the command to the Console Kernel:

```php
// app/Console/Kernel.php
protected $commands = [
    // ...
    \App\Console\Commands\MigrateToStatamic::class,
];
```

## Running the Migration

Execute the migration command for all content:

```bash
php artisan migrate:statamic
```

Or for specific content types:

```bash
php artisan migrate:statamic programa
php artisan migrate:statamic publicaciones
php artisan migrate:statamic boletines
```

## Handling Special Cases

### Troubleshooting UTF-8 Issues

If you encounter character encoding issues, ensure that content is properly normalized before importing:

```php
// Add this to your migration method
function normalizeEncoding($text) {
    // Remove invalid UTF-8 characters
    $text = mb_convert_encoding($text, 'UTF-8', 'UTF-8');
    
    // Fix common encoding issues
    $text = str_replace([
        'Ã¡', 'Ã©', 'Ã­', 'Ã³', 'Ãº',
        'Ã', 'Ã‰', 'Ã', 'Ã"', 'Ãš',
        'Ã±', 'Ã'', '&nbsp;'
    ], [
        'á', 'é', 'í', 'ó', 'ú',
        'Á', 'É', 'Í', 'Ó', 'Ú',
        'ñ', 'Ñ', ' '
    ], $text);
    
    return $text;
}
```

### Post-Migration Verification

After running the migration, verify that all content has been properly migrated:

```php
protected function verifyMigration()
{
    $this->info('Verifying migration...');
    
    $estrategiasCount = Estrategia::count();
    $programaCount = Entry::query()->where('collection', 'programa')->where('blueprint', 'category')->count();
    $activityCount = Entry::query()->where('collection', 'programa')->where('blueprint', 'activity')->count();
    
    $this->info("Original Estrategias: {$estrategiasCount}");
    $this->info("Migrated Programa categories: {$programaCount}");
    $this->info("Migrated Programa activities: {$activityCount}");
    
    $publicacionesCount = Publicacion::count();
    $publicacionesMigratedCount = Entry::query()->where('collection', 'publicaciones')->count();
    
    $this->info("Original Publicaciones: {$publicacionesCount}");
    $this->info("Migrated Publicaciones entries: {$publicacionesMigratedCount}");
    
    // Add checks for other content types
    
    // Verify asset migration
    $originalMediaCount = Multimedia::count();
    $migratedAssetsCount = Asset::all()->count();
    
    $this->info("Original media files: {$originalMediaCount}");
    $this->info("Migrated assets: {$migratedAssetsCount}");
}
``` 