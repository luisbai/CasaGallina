<?php

namespace Database\Seeders;

use App\Models\Exposicion;
use App\Models\ExposicionVideo;
use App\Modules\Tag\Infrastructure\Models\Tag;
use Illuminate\Database\Seeder;

class ProyectoArtisticoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create proyecto-artistico tag
        $proyectoTag = Tag::firstOrCreate([
            'nombre' => 'Proyectos Artísticos',
            'type' => 'proyecto-artistico'
        ], [
            'slug' => 'proyectos-artisticos',
            'descripcion' => 'Proyectos artísticos de la comunidad',
            'texto' => 'Espacio dedicado a los proyectos artísticos desarrollados por artistas contemporáneos en colaboración con Casa Gallina.'
        ]);

        // Circe Irasema Project
        $circeProject = Exposicion::create([
            'estado' => 'activo',
            'type' => 'proyecto-artistico',
            'fecha' => '2024',
            'titulo' => 'Cosmic Paintings - Circe Irasema',
            'metadatos' => '<h2>Información del Artista</h2>
<p><strong>Artista:</strong> Circe Irasema</p>
<p><strong>Nacionalidad:</strong> Mexicana</p>
<p><strong>Año de nacimiento:</strong> 1987</p>
<p><strong>Lugar de nacimiento:</strong> Ciudad de México</p>
<p><strong>Técnica:</strong> Pintura vertical en tela con maquillaje</p>
<p><strong>Formación:</strong> Licenciatura en Artes Visuales y Plásticas, FAD-UNAM (2006-2010) y La Esmeralda (2013-2017)</p>',
            'contenido' => '<h2>Cosmic Paintings</h2>
<p>Circe Irasema (Ciudad de México, 1987) presenta su innovadora serie "Cosmic Paintings", un conjunto de pinturas verticales de diversos tamaños en tela con marcas mínimas, cada una explorando una paleta de colores única. Los matices variados consisten en maquillaje aplicado comprado en tiendas del centro de la Ciudad de México.</p>

<h2>Práctica Artística</h2>
<p>Su trabajo constituye un estudio multidisciplinario sobre las tensiones genealógicas entre la cultura popular y el arte, una reflexión que reverbera en los conocimientos locales "no legítimos" de la educación sentimental y el espacio doméstico, basándose en el género de naturaleza muerta y los conflictos de representación en la pintura occidental.</p>

<h2>Investigación de la Memoria Colectiva</h2>
<p>A través de su práctica artística, Irasema investiga la memoria colectiva a través de objetos aparentemente mundanos: por un lado, enfatiza objetos que forman parte de nuestras rutinas diarias que a menudo pasan desapercibidos, y por el otro, desmantela paisajes histórico-artísticos abstrayendo sus elementos visuales en estuches de sombras para ojos.</p>

<h2>Técnica del Papel Carbón</h2>
<p>A lo largo de su práctica artística, Circe Irasema ha utilizado papel carbón para copiar artefactos arqueológicos y antropológicos de libros dedicados al patrimonio mesoamericano. Este proceso ha dejado cientos de hojas de carbón usadas con figuras ocultas que solo pueden apreciarse a contraluz.</p>'
        ]);

        $circeProject->tags()->attach($proyectoTag->id);

        // Add video for Circe Irasema
        ExposicionVideo::create([
            'exposicion_id' => $circeProject->id,
            'titulo' => 'Cosmic Paintings: Proceso Creativo',
            'descripcion' => 'Documental sobre el proceso creativo de Circe Irasema y su técnica de pintura con maquillaje',
            'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'orden' => 1
        ]);

        // Sofía Echeverri Project
        $sofiaProject = Exposicion::create([
            'estado' => 'activo',
            'type' => 'proyecto-artistico',
            'fecha' => '2023-2024',
            'titulo' => 'Formas Orgánicas - Sofía Echeverri',
            'metadatos' => '<h2>Información del Artista</h2>
<p><strong>Artista:</strong> Sofía Echeverri</p>
<p><strong>Nacionalidad:</strong> Mexicana</p>
<p><strong>Lugar de nacimiento:</strong> Guadalajara, Jalisco</p>
<p><strong>Año de nacimiento:</strong> 1971</p>
<p><strong>Técnica:</strong> Pintura y dibujo</p>
<p><strong>Formación:</strong> Licenciatura en Artes Visuales - Universidad de Guadalajara</p>
<p><strong>Estudios adicionales:</strong> Técnicas de dibujo antiguas y modernas en París, Francia (2000-2001)</p>',
            'contenido' => '<h2>Formas Orgánicas</h2>
<p>Sofía Echeverri, nacida en Guadalajara, Jalisco, presenta una serie de obras que exploran formas orgánicas como una celebración a la diversidad y una declaración de libertad para disfrutar del placer sexual femenino en oposición al control patriarcal.</p>

<h2>Formación y Trayectoria</h2>
<p>Con una Licenciatura en Artes Visuales de la Universidad de Guadalajara, Echeverri ha estudiado técnicas de dibujo antiguas y modernas en París, Francia (2000-2001). Ha sido seleccionada para participar en varias Bienales Nacionales como la Bienal Nacional de Artes Visuales de Yucatán en tres ediciones (2009, 2006 y 2004) en la categoría de Pintura.</p>

<h2>Narrativa Artística</h2>
<p>Su narrativa artística crea una dialéctica entre lo figurativo (representado en blanco y negro) y lo abstracto (representado en color). Esta dialéctica está diseñada para conferir dinamismo al sujeto y crear imágenes enigmáticas que evocan nostalgia.</p>

<h2>Obra Actual</h2>
<p>Su trabajo actual incluye una serie de pinturas y dibujos que celebran la diversidad del cuerpo femenino y cuestionan las normas sociales establecidas a través de formas fluidas y colores vibrantes, explorando temas de identidad, género y libertad sexual.</p>'
        ]);

        $sofiaProject->tags()->attach($proyectoTag->id);

        // Add video for Sofía Echeverri
        ExposicionVideo::create([
            'exposicion_id' => $sofiaProject->id,
            'titulo' => 'Formas Orgánicas: Libertad y Diversidad',
            'descripcion' => 'Entrevista con Sofía Echeverri sobre su exploración del cuerpo femenino y la libertad sexual a través del arte',
            'youtube_url' => 'https://www.youtube.com/watch?v=jNQXAC9IVRw',
            'orden' => 1
        ]);

        // Perla Krauze Project
        $perlaProject = Exposicion::create([
            'estado' => 'activo',
            'type' => 'proyecto-artistico',
            'fecha' => '2023',
            'titulo' => 'Huellas y Recorridos - Perla Krauze',
            'metadatos' => '<h2>Información del Artista</h2>
<p><strong>Artista:</strong> Perla Krauze Kleimbort</p>
<p><strong>Nacionalidad:</strong> Mexicana</p>
<p><strong>Año de nacimiento:</strong> 1953</p>
<p><strong>Lugar de nacimiento:</strong> Ciudad de México</p>
<p><strong>Técnica:</strong> Instalación, escultura, pintura</p>
<p><strong>Formación:</strong> MFA Chelsea College of Art London (1993), ENAP-UNAM, Estudios en antropología ENAH</p>
<p><strong>Residencias:</strong> MacDowell Colony (2012)</p>',
            'contenido' => '<h2>Huellas y Recorridos</h2>
<p>Perla Krauze Kleimbort (Ciudad de México, 1953) presenta "Huellas y Recorridos", una instalación que explora la naturaleza, el paisaje urbano, el tiempo y la memoria a través de diversos materiales incluyendo plomo, arcilla, agua y piedra.</p>

<h2>Metodología Artística</h2>
<p>Con una Maestría en Bellas Artes de Chelsea College of Art en Londres (1993) y estudios en antropología en la ENAH, Krauze utiliza frotados de grafito de piedras y pavimentos, así como rocas volcánicas grabadas de El Pedregal para crear pinturas que son topografías abstractas y mapeos.</p>

<h2>Conexión con la Geografía Mexicana</h2>
<p>Su trabajo mantiene una conexión particular con la geografía e historia mexicana, especialmente con la región de El Pedregal en la Ciudad de México, que alberga las ruinas de Cuicuilco, la ciudad más antigua de México, y Copilco, ambas cubiertas por lava de la erupción del volcán Xitle hace tres mil años.</p>

<h2>Instalaciones Site-Specific</h2>
<p>En años recientes, Krauze se ha enfocado cada vez más en instalaciones específicas al sitio que mantienen un diálogo con el lugar y el espacio, trabajando con planos pintados y marcos metálicos que crean experiencias inmersivas para el espectador.</p>

<h2>Colecciones y Reconocimientos</h2>
<p>Su obra forma parte de importantes colecciones públicas como el Museo de Arte Moderno en Ciudad de México, el Museo de Arte Contemporáneo en Oaxaca, Museo de Arte Carrillo Gil, y el Scottsdale Museum of Contemporary Art en Arizona.</p>'
        ]);

        $perlaProject->tags()->attach($proyectoTag->id);

        // Add video for Perla Krauze
        ExposicionVideo::create([
            'exposicion_id' => $perlaProject->id,
            'titulo' => 'Huellas y Recorridos: El Pedregal como Inspiración',
            'descripcion' => 'Documental sobre la conexión de Perla Krauze con el paisaje volcánico de El Pedregal y su influencia en su obra',
            'youtube_url' => 'https://www.youtube.com/watch?v=ScMzIvxBSi4',
            'orden' => 1
        ]);

        ExposicionVideo::create([
            'exposicion_id' => $perlaProject->id,
            'titulo' => 'Retrospectiva: Museo de Arte Moderno 2010',
            'descripcion' => 'Recorrido por la retrospectiva "Huellas y Recorridos" en el Museo de Arte Moderno de México',
            'youtube_url' => 'https://www.youtube.com/watch?v=YQHsXMglC9A',
            'orden' => 2
        ]);
    }
}