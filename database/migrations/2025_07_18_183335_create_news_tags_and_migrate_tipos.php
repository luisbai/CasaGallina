<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // First, create news tags for each existing tipo
        $newsTagsData = [
            [
                'nombre' => 'Artículo',
                'slug' => 'articulo',
                'type' => 'noticia',
                'descripcion' => 'Artículos de opinión y análisis',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Crónica',
                'slug' => 'cronica',
                'type' => 'noticia',
                'descripcion' => 'Relatos y crónicas de eventos',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Entrevista',
                'slug' => 'entrevista',
                'type' => 'noticia',
                'descripcion' => 'Entrevistas y conversaciones',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Otras Experiencias',
                'slug' => 'otras-experiencias',
                'type' => 'noticia',
                'descripcion' => 'Experiencias y testimonios diversos',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Reseña e Invitación',
                'slug' => 'resena-invitacion',
                'type' => 'noticia',
                'descripcion' => 'Reseñas e invitaciones a eventos',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Noticias',
                'slug' => 'noticias',
                'type' => 'noticia',
                'descripcion' => 'Noticias generales',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Enlaces',
                'slug' => 'enlaces',
                'type' => 'noticia',
                'descripcion' => 'Enlaces de interés',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Newsletter',
                'slug' => 'newsletter',
                'type' => 'noticia',
                'descripcion' => 'Boletines informativos',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert news tags
        $insertedTagIds = [];
        foreach ($newsTagsData as $tagData) {
            $tagId = DB::table('tags')->insertGetId($tagData);
            $insertedTagIds[$tagData['slug']] = $tagId;
        }

        // Now migrate existing noticias to use tags instead of tipo
        $tipoToSlugMap = [
            'articulo' => 'articulo',
            'cronica' => 'cronica',
            'entrevista' => 'entrevista',
            'otras_experiencias' => 'otras-experiencias',
            'resena_invitacion' => 'resena-invitacion',
            'noticias' => 'noticias',
            'enlaces' => 'enlaces',
            'newsletter' => 'newsletter',
        ];

        // Get all noticias and their current tipos
        $noticias = DB::table('noticias')->select('id', 'tipo')->get();

        // Create tag associations for each noticia
        $tagAssociations = [];
        foreach ($noticias as $noticia) {
            if (isset($tipoToSlugMap[$noticia->tipo]) && isset($insertedTagIds[$tipoToSlugMap[$noticia->tipo]])) {
                $tagAssociations[] = [
                    'noticia_id' => $noticia->id,
                    'tag_id' => $insertedTagIds[$tipoToSlugMap[$noticia->tipo]],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insert all tag associations
        if (!empty($tagAssociations)) {
            DB::table('noticia_tag')->insert($tagAssociations);
        }
    }

    public function down(): void
    {
        // Remove the news tag associations
        DB::table('noticia_tag')
            ->whereIn('tag_id', function ($query) {
                $query->select('id')
                    ->from('tags')
                    ->where('type', 'noticia');
            })
            ->delete();

        // Remove the news tags
        DB::table('tags')->where('type', 'noticia')->delete();
    }
};