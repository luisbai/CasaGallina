<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Tag\Infrastructure\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if there are any existing tags and delete them safely
        // We'll use DB facade to disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Tag::query()->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        
        // Tags for programas (estrategias)
        $programaTags = [
            "programa-local" => [
                'Escuelas',
                'Infancias Adolescencias',
                'Adultos Mayores',
                'Encuentros Vecinales',
                'Huerto',
                'Cocina y Salud',
            ],
            
            // Programa externo
            "programa-externo" => [
                'Educación Ambiental',
                'Mapeos Colectivos',
            ],
        ];
        
        // Tags for exposiciones
        $exposicionTags = [
            'Archivo a Cielo Abierto (vol.1)',
            'Maíz',
            'Lluvias y Secas. La Visión Ancestral del Tiempo',
            'Hacemos Nuestro Río',
            'Mondosyi',
            '¿Dónde está nuestro abrigo? Biodiversidad en los Altos de Chiapas',
            'Devenir',
            'Colibríes/ huitziltin/ ts\'unu\'uno\'ob',
            'Exposiciones Comunitarias',
        ];
        
        // Tags for proyectos artísticos
        $proyectoTags = [
            'Circe Irasema',
            'Sofía Echeverri',
            'Perla Krauze',
        ];
        
        // Create tags by type
        foreach ($programaTags as $type => $tags) {
            foreach ($tags as $tag) {
                Tag::create([
                    'nombre' => $tag,
                    'slug' => Str::slug($tag),
                    'type' => $type
                ]);
            }
        }
        
        foreach ($exposicionTags as $tag) {
            Tag::create([
                'nombre' => $tag,
                'slug' => Str::slug($tag),
                'type' => 'exposicion'
            ]);
        }
        
        foreach ($proyectoTags as $tag) {
            Tag::create([
                'nombre' => $tag,
                'slug' => Str::slug($tag),
                'type' => 'proyecto-artistico'
            ]);
        }
    }
}
