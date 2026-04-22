<?php

namespace Database\Seeders;

use App\Models\HomepageContent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HomepageContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create intro content with the current hardcoded text
        HomepageContent::updateOrCreate(
            ['section' => 'intro'],
            [
                'main_text_es' => 'Casa Gallina es un proyecto cultural transdisciplinario cuyo programa se enfoca en aprendizajes y acciones sobre cultura, comunidad y medio ambiente. El proyecto se ubica en Santa María la Ribera, un barrio de la Ciudad de México, y busca facilitar sinergias al interior de las comunidades locales.',
                'main_text_en' => 'Casa Gallina is a transdisciplinary cultural project whose programming is focused on learnings and actions relating culture, community, and the environment. The project is located in Santa María la Ribera, a neighborhood of Mexico City, where it seeks to facilitate synergies inside the local communities.',
                'secondary_text_es' => 'A través de sus plataformas, Casa Gallina busca inocular, impulsar y vitalizar iniciativas y propuestas sobre resiliencia, medio ambiente, creatividad en modelos alternos de asociación, y estilos de vida de consumo responsable. Casa Gallina también busca el robustecimiento de redes comunitarias locales, así como la alianza con iniciativas que compartan intereses similares con las que establecer procesos de diálogo, trabajo e intercambio.',
                'secondary_text_en' => 'Through its platforms, Casa Gallina seeks to promote, inoculate, encourage, and revitalize initiatives and proposals about resilience, the environment, creative models of associations, life styles of responsible consumption, as well as alternative models of social interaction. Casa Gallina also seeks to strengthen local community networks, as well as alliances with initiatives from other areas that share similar interests to establish processes of dialogue, work, and exchange.',
                'is_active' => true,
            ]
        );
    }
}
