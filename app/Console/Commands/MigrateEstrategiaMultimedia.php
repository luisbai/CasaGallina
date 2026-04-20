<?php

namespace App\Console\Commands;

use App\Modules\Strategy\Infrastructure\Models\Strategy;
use App\Modules\Program\Infrastructure\Models\Program;
use App\Modules\Tag\Infrastructure\Models\Tag;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrateEstrategiaMultimedia extends Command
{
    protected $signature = 'migrate:estrategia-multimedia {--dry-run}';
    protected $description = 'Migrate multimedia from estrategias to existing programas';

    private array $estrategiaTagMapping = [
        'Entre vecinos: encuentros, diálogos e intercambios' => 'encuentros-vecinales',
        'Nutrición y resiliencia: consumo responsable y empatía ambiental' => 'cocina',
        'Producir y recrear la escuela: modelos para fortalecer los saberes escolares' => 'escuelas',
        'Saberes intergeneracionales y procesos de educación no formal' => 'adultos-mayores',
        'Engranar la energía social: Laboratorios, prototipos y proyectos barriales' => 'encuentros-vecinales',
        'Diversidad biocultural' => 'educacion-ambiental',
        'Re-conocer los territorios' => 'mapeos-colectivos',
        'Maíz: biodiversidad y cultura en el consumo cotidiano' => 'educacion-ambiental',
        'Barrio intercultural' => 'educacion-ambiental',
        'Repensando el consumo, cultura de la reparación' => 'cultura-reparacion',
        'Resiliencia en comunidad: herramientas y redes durante el distanciamiento físico' => 'resiliencia-comunitaria'
    ];

    public function handle(): int
    {
        $dryRun = $this->option('dry-run');

        if ($dryRun) {
            $this->warn('DRY RUN MODE - No data will be saved');
        }

        $this->info('Starting multimedia migration from estrategias to programas...');

        $estrategias = Estrategia::where('status', 'public')->get();
        $totalMigrated = 0;

        foreach ($estrategias as $estrategia) {
            $migrated = $this->migrateEstrategiaMultimedia($estrategia, $dryRun);
            $totalMigrated += $migrated;
        }

        $this->info("Migration completed! Total multimedia relationships created: {$totalMigrated}");
        return 0;
    }

    private function migrateEstrategiaMultimedia(Estrategia $estrategia, bool $dryRun): int
    {
        $this->info("\n--- Processing: {$estrategia->titulo} (ID: {$estrategia->id}) ---");

        // Get the tag mapping for this estrategia
        $tagSlug = $this->estrategiaTagMapping[$estrategia->titulo] ?? null;
        if (!$tagSlug) {
            $this->warn("No tag mapping found for: {$estrategia->titulo}");
            return 0;
        }

        $tag = Tag::where('slug', $tagSlug)->first();
        if (!$tag) {
            $this->error("Tag not found: {$tagSlug}");
            return 0;
        }

        // Get all programas that belong to this tag (these are the migrated programas)
        $programas = Programa::where('estado', 'public')
            ->whereHas('tags', function($q) use ($tag) {
                $q->where('tags.id', $tag->id);
            })
            ->where('id', '>=', 69) // Only migrated programas
            ->get();

        if ($programas->isEmpty()) {
            $this->warn("No programas found for tag: {$tag->nombre}");
            return 0;
        }

        // Get all multimedia from the estrategia
        $estrategiaImages = $estrategia->multimedia()->get();

        if ($estrategiaImages->isEmpty()) {
            $this->line("No multimedia found for estrategia {$estrategia->id}");
            return 0;
        }

        $this->info("Found {$estrategiaImages->count()} multimedia items");
        $this->info("Distributing to {$programas->count()} programas in category: {$tag->nombre}");

        if ($dryRun) {
            return $estrategiaImages->count();
        }

        return $this->distributeMultimedia($estrategiaImages, $programas);
    }

    private function distributeMultimedia($estrategiaImages, $programas): int
    {
        $totalImages = $estrategiaImages->count();
        $totalProgramas = $programas->count();
        $imagesPerPrograma = max(1, intval($totalImages / $totalProgramas));

        $imageIndex = 0;
        $migratedCount = 0;

        // First pass: distribute evenly
        foreach ($programas as $programa) {
            $imagesToAssign = min($imagesPerPrograma, $totalImages - $imageIndex);

            for ($i = 0; $i < $imagesToAssign; $i++) {
                if ($imageIndex < $totalImages) {
                    $multimedia = $estrategiaImages[$imageIndex];

                    // Check if relationship already exists
                    $exists = DB::table('programa_images')
                        ->where('programa_id', $programa->id)
                        ->where('multimedia_id', $multimedia->multimedia_id)
                        ->exists();

                    if (!$exists) {
                        DB::table('programa_images')->insert([
                            'programa_id' => $programa->id,
                            'multimedia_id' => $multimedia->multimedia_id,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                        $migratedCount++;
                    }

                    $imageIndex++;
                }
            }
        }

        // Second pass: distribute remaining images
        while ($imageIndex < $totalImages) {
            foreach ($programas->shuffle()->take(3) as $programa) {
                if ($imageIndex < $totalImages) {
                    $multimedia = $estrategiaImages[$imageIndex];

                    $exists = DB::table('programa_images')
                        ->where('programa_id', $programa->id)
                        ->where('multimedia_id', $multimedia->multimedia_id)
                        ->exists();

                    if (!$exists) {
                        DB::table('programa_images')->insert([
                            'programa_id' => $programa->id,
                            'multimedia_id' => $multimedia->multimedia_id,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                        $migratedCount++;
                    }

                    $imageIndex++;
                }
            }
        }

        $this->line("✓ Migrated {$migratedCount} multimedia relationships");
        return $migratedCount;
    }
}
