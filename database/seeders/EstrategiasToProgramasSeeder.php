<?php

namespace Database\Seeders;

use App\Models\Programa;
use App\Models\ProgramaMultimedia;
use App\Models\Estrategia;
use App\Models\EstrategiaMultimedia;
use App\Modules\Tag\Infrastructure\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EstrategiasToProgramasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Use existing programa tags or create if they don't exist
        $programaLocalTag = Tag::where('type', 'programa-local')->first() ?? 
            Tag::firstOrCreate([
                'nombre' => 'Programas Locales',
                'type' => 'programa-local'
            ], [
                'slug' => 'programas-locales',
                'descripcion' => 'Programas desarrollados localmente en Casa Gallina',
                'texto' => 'Actividades y talleres realizados en las instalaciones de Casa Gallina y la comunidad de Santa María la Ribera.'
            ]);

        $programaExternoTag = Tag::where('type', 'programa-externo')->first() ?? 
            Tag::firstOrCreate([
                'nombre' => 'Programas Externos',
                'type' => 'programa-externo'
            ], [
                'slug' => 'programas-externos',
                'descripcion' => 'Programas realizados en colaboración externa',
                'texto' => 'Actividades desarrolladas en colaboración con otras instituciones y espacios fuera de Casa Gallina.'
            ]);

        // Get additional specific tags to assign based on content
        $availableTags = Tag::whereIn('type', ['programa-local', 'programa-externo'])->get();

        // Get all estrategias
        $estrategias = Estrategia::where('status', 'public')->get();

        foreach ($estrategias as $estrategia) {
            // Determine program type based on content analysis
            $tipo = $this->determineType($estrategia);
            
            // Create metadatos from optional fields
            $metadatos = $this->buildMetadatos($estrategia);

            // Build main content from estrategia fields
            $contenido = $this->buildContent($estrategia);

            // Create programa
            $programa = Programa::create([
                'estado' => 'activo',
                'tipo' => $tipo,
                'fecha' => $estrategia->fecha ?: 'Ongoing',
                'titulo' => $estrategia->titulo,
                'metadatos' => $metadatos,
                'contenido' => $contenido,
                'created_at' => $estrategia->created_at,
                'updated_at' => $estrategia->updated_at,
            ]);

            // Assign primary tag based on type
            $primaryTag = ($tipo === 'local') ? $programaLocalTag : $programaExternoTag;
            $programa->tags()->attach($primaryTag->id);
            
            // Assign additional specific tags based on content
            $additionalTags = $this->getRelevantTags($estrategia, $availableTags);
            foreach ($additionalTags as $tag) {
                if ($tag->id !== $primaryTag->id) {
                    $programa->tags()->attach($tag->id);
                }
            }

            // Migrate multimedia relationships
            if ($estrategia->destacada_multimedia_id) {
                ProgramaMultimedia::create([
                    'programa_id' => $programa->id,
                    'multimedia_id' => $estrategia->destacada_multimedia_id,
                    'created_at' => $estrategia->created_at,
                    'updated_at' => $estrategia->updated_at,
                ]);
            }

            // Migrate associated images from estrategia_images
            $estrategiaImages = EstrategiaMultimedia::where('estrategia_id', $estrategia->id)->get();
            foreach ($estrategiaImages as $image) {
                ProgramaMultimedia::create([
                    'programa_id' => $programa->id,
                    'multimedia_id' => $image->multimedia_id,
                    'created_at' => $image->created_at,
                    'updated_at' => $image->updated_at,
                ]);
            }

            echo "Migrated: {$estrategia->titulo} -> {$programa->titulo}\n";
        }
    }

    /**
     * Determine program type based on content analysis
     */
    private function determineType(Estrategia $estrategia): string
    {
        $content = strtolower($estrategia->contenido . ' ' . $estrategia->programas . ' ' . $estrategia->lugar);
        
        // Keywords that suggest external collaboration
        $externalKeywords = [
            'colaboraci', 'alianza', 'convenio', 'museo', 'universidad', 'instituto',
            'fundación', 'asociación', 'a.c.', 'planetario', 'biblioteca', 'centro'
        ];
        
        foreach ($externalKeywords as $keyword) {
            if (strpos($content, $keyword) !== false) {
                return 'externo';
            }
        }
        
        return 'local';
    }

    /**
     * Build metadatos HTML string from estrategia optional fields
     */
    private function buildMetadatos(Estrategia $estrategia): string
    {
        $html = '';

        // Add basic info
        if ($estrategia->subtitulo) {
            $html .= '<h2>Descripción</h2>';
            $html .= '<p>' . $estrategia->subtitulo . '</p>';
        }
        
        if ($estrategia->lugar) {
            $html .= '<h2>Lugar</h2>';
            $html .= '<p>' . $estrategia->lugar . '</p>';
        }
        
        if ($estrategia->colaboradores) {
            $html .= '<h2>Colaboradores</h2>';
            $html .= '<p>' . str_replace(["\r\n", "\n"], '<br>', $estrategia->colaboradores) . '</p>';
        }

        // Add optional fields
        for ($i = 1; $i <= 5; $i++) {
            $tituloField = "campo_opcional_{$i}_titulo";
            $contentField = "campo_opcional_{$i}";
            
            if ($estrategia->$tituloField && $estrategia->$contentField) {
                $html .= '<h2>' . $estrategia->$tituloField . '</h2>';
                $html .= '<p>' . str_replace(["\r\n", "\n"], '<br>', $estrategia->$contentField) . '</p>';
            }
        }

        // Add English versions if available
        if ($estrategia->titulo_en || $estrategia->subtitulo_en || $estrategia->lugar_en || $estrategia->colaboradores_en) {
            $html .= '<h2>English Information</h2>';
            
            if ($estrategia->titulo_en) {
                $html .= '<h3>Title</h3>';
                $html .= '<p>' . $estrategia->titulo_en . '</p>';
            }
            
            if ($estrategia->subtitulo_en) {
                $html .= '<h3>Description</h3>';
                $html .= '<p>' . $estrategia->subtitulo_en . '</p>';
            }
            
            if ($estrategia->lugar_en) {
                $html .= '<h3>Location</h3>';
                $html .= '<p>' . $estrategia->lugar_en . '</p>';
            }
            
            if ($estrategia->colaboradores_en) {
                $html .= '<h3>Collaborators</h3>';
                $html .= '<p>' . str_replace(["\r\n", "\n"], '<br>', $estrategia->colaboradores_en) . '</p>';
            }
        }

        return $html;
    }

    /**
     * Build main content from estrategia fields with HTML structure
     */
    private function buildContent(Estrategia $estrategia): string
    {
        $content = '';

        // Main description
        if ($estrategia->contenido) {
            $content .= '<h2>Descripción</h2>';
            $content .= $estrategia->contenido;
        }

        // Programs section
        if ($estrategia->programas) {
            $content .= '<h2>Actividades y Programas</h2>';
            $content .= $estrategia->programas;
        }

        // English content if available
        if ($estrategia->contenido_en) {
            $content .= '<h2>Description (English)</h2>';
            $content .= $estrategia->contenido_en;
        }

        if ($estrategia->programas_en) {
            $content .= '<h2>Activities and Programs (English)</h2>';
            $content .= $estrategia->programas_en;
        }

        return $content;
    }

    /**
     * Get relevant tags based on estrategia content
     */
    private function getRelevantTags(Estrategia $estrategia, $availableTags): array
    {
        $content = strtolower($estrategia->titulo . ' ' . $estrategia->contenido . ' ' . $estrategia->programas);
        $relevantTags = [];

        foreach ($availableTags as $tag) {
            $tagName = strtolower($tag->nombre);
            
            // Match based on keywords
            $keywords = $this->getTagKeywords($tagName);
            
            foreach ($keywords as $keyword) {
                if (strpos($content, $keyword) !== false) {
                    $relevantTags[] = $tag;
                    break;
                }
            }
        }
        
        return $relevantTags;
    }

    /**
     * Get keywords for tag matching
     */
    private function getTagKeywords(string $tagName): array
    {
        $keywords = [
            'escuelas' => ['escuela', 'educación', 'estudiante', 'maestro', 'primaria', 'secundaria'],
            'infancias' => ['niño', 'niña', 'infancia', 'adolescente', 'joven'],
            'adultos mayores' => ['adulto mayor', 'tercera edad', 'abuelo', 'abuela'],
            'encuentros vecinales' => ['vecino', 'comunidad', 'barrio', 'encuentro', 'diálogo'],
            'huerto' => ['huerto', 'plantas', 'siembra', 'cultivo', 'jardín'],
            'cocina y salud' => ['cocina', 'comida', 'nutrición', 'salud', 'alimentación', 'receta'],
            'educación ambiental' => ['ambiente', 'ambiental', 'ecología', 'sustentable', 'biodiversidad'],
            'mapeos colectivos' => ['mapeo', 'territorio', 'cartografía', 'espacial']
        ];

        return $keywords[$tagName] ?? [];
    }
}