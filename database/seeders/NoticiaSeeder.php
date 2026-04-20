<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Noticia;
use App\Modules\Tag\Infrastructure\Models\Tag;
use Carbon\Carbon;

class NoticiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $noticias = [
            // ARTICULOS (2-3 items)
            [
                'tipo' => 'articulo',
                'titulo' => 'El Huerto Comunitario: Un Espacio de Resistencia Verde en Santa María la Ribera',
                'contenido' => '<p>En medio del concreto y el asfalto de la Ciudad de México, el huerto comunitario de Casa Gallina se ha convertido en un oasis verde que desafía la lógica urbana dominante. Este espacio, que ocupa una pequeña parcela en el corazón de Santa María la Ribera, representa mucho más que un simple jardín: es un acto de resistencia, una declaración de principios y una invitación a reimaginar nuestra relación con la naturaleza en el contexto urbano.</p><p>Desde su creación hace tres años, el huerto ha sido testigo de múltiples transformaciones. Lo que comenzó como un terreno baldío se ha convertido en un ecosistema próspero donde conviven hortalizas, plantas medicinales y flores de ornato. Pero más allá de la producción de alimentos, este espacio ha generado una red de relaciones comunitarias que trasciende las barreras generacionales y socioeconómicas del barrio.</p><p>María Elena Rodríguez, vecina de 68 años, recuerda cómo llegó al huerto por primera vez: "Yo vivía muy sola después de que murió mi esposo. Una vecina me invitó a venir y al principio pensé que no sabría nada de plantas, pero aquí aprendí que todos tenemos conocimientos que compartir". Hoy, María Elena es una de las coordinadoras del área de plantas medicinales y comparte con los más jóvenes el conocimiento ancestral sobre herbolaria que heredó de su abuela.</p>',
                'descripcion' => 'Una reflexión profunda sobre el impacto social y ambiental del huerto comunitario de Casa Gallina en la transformación del barrio de Santa María la Ribera.',
                'palabras_clave' => 'huerto comunitario, sustentabilidad urbana, Santa María la Ribera, agricultura urbana, comunidad, medio ambiente',
                'autor' => 'Ana Lucía Mendoza',
                'fecha_publicacion' => Carbon::now()->subDays(45),
                'activo' => true,
                'tags' => ['Huerto', 'Encuentros Vecinales']
            ],
            [
                'tipo' => 'articulo',
                'titulo' => 'Arte y Memoria: La Importancia de los Archivos Comunitarios en la Construcción de Identidad',
                'contenido' => '<p>Los archivos no son solo depósitos de documentos polvorientos; son la memoria viva de las comunidades, espacios donde se preservan y recrean las identidades colectivas. En Casa Gallina, hemos comprendido que la documentación y preservación de nuestras experiencias comunitarias es fundamental para la construcción de una memoria colectiva que trascienda las individualidades y genere procesos de identificación y pertenencia.</p><p>El archivo comunitario de Casa Gallina nació de la necesidad de sistematizar y preservar los múltiples procesos que han surgido en este espacio a lo largo de los años. Fotografías de talleres, grabaciones de conversatorios, dibujos de los niños, recetas intercambiadas entre vecinas, mapas colectivos del barrio: todo esto forma parte de un acervo que cuenta la historia no oficial de Santa María la Ribera.</p><p>Sofía Martínez, historiadora y colaboradora del proyecto, explica: "Los archivos oficiales cuentan la historia desde arriba, desde las instituciones y los poderes establecidos. Los archivos comunitarios nos permiten contar nuestra propia historia, desde abajo, desde la experiencia cotidiana de quienes habitamos y transformamos estos territorios".</p>',
                'descripcion' => 'Análisis sobre la importancia de los archivos comunitarios como herramientas de construcción de memoria e identidad colectiva en los barrios.',
                'palabras_clave' => 'archivo comunitario, memoria colectiva, identidad, historia oral, patrimonio intangible',
                'autor' => 'Carlos Hernández Vila',
                'fecha_publicacion' => Carbon::now()->subDays(62),
                'activo' => true,
                'tags' => ['Exposiciones Comunitarias']
            ],
            [
                'tipo' => 'articulo',
                'titulo' => 'Educación Popular y Transformación Social: Reflexiones desde la Práctica Comunitaria',
                'contenido' => '<p>La educación popular no es solo una metodología pedagógica; es una filosofía de vida que reconoce en cada persona un sujeto capaz de transformar su realidad. En Casa Gallina, esta perspectiva ha guiado nuestros procesos formativos desde el inicio, partiendo del principio de que todos aprendemos de todos y que el conocimiento se construye colectivamente.</p><p>Los talleres que desarrollamos no siguen el modelo tradicional de enseñanza vertical, donde una persona que "sabe" transmite conocimientos a otras que "no saben". Por el contrario, creamos círculos de diálogo donde cada participante aporta desde su experiencia, creando un conocimiento colectivo que es más rico y complejo que la suma de las partes.</p><p>Rosa María Gómez, educadora popular con más de 20 años de experiencia, reflexiona: "En la educación popular no hay maestros y alumnos, hay compañeros de aprendizaje. Cada taller es una oportunidad de descubrir que todos tenemos algo que enseñar y algo que aprender".</p>',
                'descripcion' => 'Reflexión teórica y práctica sobre los principios de la educación popular implementados en los programas formativos de Casa Gallina.',
                'palabras_clave' => 'educación popular, pedagogía crítica, transformación social, aprendizaje colectivo, diálogo de saberes',
                'autor' => 'Laura Beatriz Santos',
                'fecha_publicacion' => Carbon::now()->subDays(23),
                'activo' => true,
                'tags' => ['Escuelas', 'Encuentros Vecinales']
            ],

            // CRONICAS (2-3 items)
            [
                'tipo' => 'cronica',
                'titulo' => 'Sábado de Tequio: Crónica de una Jornada de Trabajo Colectivo',
                'contenido' => '<p>Son las 8:30 de la mañana de un sábado que promete ser caluroso. Los primeros rayos de sol ya calientan el patio de Casa Gallina mientras llegan los primeros participantes del tequio mensual. Doña Carmen trae una olla de café de olla humeante, mientras que Javier, el joven estudiante de arquitectura, carga una caja de herramientas que ha conseguido prestadas en su facultad.</p><p>El tequio es una tradición ancestral mesoamericana que consiste en el trabajo colectivo no remunerado para el beneficio común. En Casa Gallina lo hemos adaptado a nuestro contexto urbano: cada mes nos reunimos para realizar tareas de mantenimiento, mejoras al espacio y proyectos que requieren de muchas manos.</p><p>Mientras esperamos a que lleguen más personas, Lupita organiza las tareas del día en una cartulina pegada en la pared: "Necesitamos terminar de pintar la barda del huerto, reparar las macetas que se rompieron con la lluvia de la semana pasada, y si alcanza el tiempo, instalar los nuevos bebederos para los colibríes".</p><p>A las 9:15 ya somos cerca de 25 personas de todas las edades. Los niños corretean entre los adultos mientras sus padres se organizan en equipos. La señora Estela, con sus 73 años, se encarga de coordinar el equipo de jardinería junto con tres adolescentes que han llegado con sus uniformes de preparatoria recién cambiados por ropa de trabajo.</p>',
                'descripcion' => 'Relato vivencial de una jornada de trabajo colectivo (tequio) en Casa Gallina, describiendo la organización comunitaria y el trabajo colaborativo.',
                'palabras_clave' => 'tequio, trabajo colectivo, comunidad, tradiciones ancestrales, organización vecinal',
                'autor' => 'Patricia Morales',
                'fecha_publicacion' => Carbon::now()->subDays(12),
                'activo' => true,
                'tags' => ['Encuentros Vecinales', 'Huerto']
            ],
            [
                'tipo' => 'cronica',
                'titulo' => 'El Día que Llovió Maíz: Crónica del Taller de Nixtamalización',
                'contenido' => '<p>El aroma del cal se mezcla con el vapor que sale de las ollas de peltre mientras doña Esperanza explica por quinta vez el proceso de nixtamalización a un grupo de veinte personas que la escuchamos con la atención de quien descubre un secreto ancestral. Es jueves por la tarde en Casa Gallina y estamos en el taller "Del maíz a la tortilla: recuperando saberes alimentarios".</p><p>"El nixtamal no es solo una técnica para hacer tortillas", dice doña Esperanza mientras revuelve el maíz con una cuchara de madera heredada de su abuela. "Es una tecnología que nuestros ancestros desarrollaron para mejorar las propiedades nutritivas del maíz. Sin nixtamalización, el maíz no nos daría toda su proteína".</p><p>Entre los participantes hay de todo: una familia completa con tres niños pequeños, dos estudiantes de nutrición que toman notas en sus cuadernos, una pareja de arquitectos recién llegados al barrio, y varios vecinos de toda la vida que confiesan no haber hecho tortillas desde que llegaron las tortillerías mecánicas al barrio.</p><p>Pedro, de ocho años, es quien hace las preguntas más incisivas: "¿Por qué el maíz cambia de color cuando le echas la cal?" Doña Esperanza sonríe y le explica que la cal "despierta" al maíz, ablanda su cáscara y libera nutrientes que antes estaban dormidos.</p>',
                'descripcion' => 'Relato de un taller de nixtamalización en Casa Gallina, explorando la recuperación de saberes alimentarios tradicionales y su impacto comunitario.',
                'palabras_clave' => 'nixtamalización, maíz, saberes ancestrales, alimentación tradicional, soberanía alimentaria, tortillas',
                'autor' => 'Miguel Angel Ruiz',
                'fecha_publicacion' => Carbon::now()->subDays(38),
                'activo' => true,
                'tags' => ['Cocina y Salud', 'Encuentros Vecinales']
            ],
            [
                'tipo' => 'cronica',
                'titulo' => 'Una Tarde de Lluvia y Cuentos: Crónica del Círculo de Lectura Intergeneracional',
                'contenido' => '<p>La lluvia tamborilea sobre el techo de lámina de Casa Gallina mientras adentro se forma un círculo perfecto de sillas dispares: dos sillas de plástico rojas, una mecedora de mimbre, varios banquitos de madera y hasta un par de cojines en el suelo donde se acomodan los más jóvenes. Es miércoles por la tarde y el círculo de lectura intergeneracional está por comenzar.</p><p>Guadalupe, de 12 años, ha elegido leer un fragmento de "Pedro Páramo" que no entiende del todo pero que le gusta por la sonoridad de las palabras. Su voz se mezcla con el sonido de la lluvia mientras lee: "Vine a Comala porque me dijeron que acá vivía mi padre, un tal Pedro Páramo". Al terminar, levanta la vista y pregunta: "¿Por qué dice que vino si ya está muerto?"</p><p>Don Roberto, jubilado de 78 años y ex profesor de secundaria, sonríe antes de responder. Ha participado en el círculo desde el primer día hace dos años y ha aprendido a escuchar antes de explicar. "Esa es una muy buena pregunta, Lupita. ¿Qué opinan los demás?"</p><p>Así transcurre cada sesión: entre preguntas que no tienen respuesta única, interpretaciones que se suman y complementan, y la certeza de que leer en comunidad multiplica los significados de cualquier texto.</p>',
                'descripcion' => 'Relato íntimo de una sesión del círculo de lectura intergeneracional, mostrando el intercambio cultural entre diferentes edades a través de la literatura.',
                'palabras_clave' => 'círculo de lectura, intergeneracional, literatura, diálogo, educación popular, intercambio cultural',
                'autor' => 'Elena Castellanos',
                'fecha_publicacion' => Carbon::now()->subDays(29),
                'activo' => true,
                'tags' => ['Infancias Adolescencias', 'Adultos Mayores']
            ],

            // ENTREVISTAS (2 items)
            [
                'tipo' => 'entrevista',
                'titulo' => 'Entrevista con María del Socorro Martínez: "El Huerto me Devolvió la Conexión con mis Raíces"',
                'contenido' => '<p><strong>Casa Gallina:</strong> María del Socorro, cuéntanos cómo llegaste al huerto comunitario.</p><p><strong>María del Socorro:</strong> Llegué hace como año y medio, cuando acababa de jubilarme del ISSSTE. Me sentía muy perdida, sin saber qué hacer con tanto tiempo libre. Una vecina me invitó y al principio pensé "yo qué voy a saber de plantas", pero resulta que sabía más de lo que creía.</p><p><strong>CG:</strong> ¿Cómo ha sido tu experiencia?</p><p><strong>MdS:</strong> Ha sido transformadora. Yo crecí en un pueblo de Hidalgo y mi abuela tenía un huerto enorme. Cuando llegué a la ciudad, perdí esa conexión con la tierra. Aquí la he recuperado, pero ahora también aprendo técnicas nuevas, como el compostaje y la asociación de cultivos.</p><p><strong>CG:</strong> ¿Qué es lo que más te gusta del trabajo en el huerto?</p><p><strong>MdS:</strong> Las mañanas de sábado cuando llegamos y revisamos cómo van las plantas. Es como si cada planta te contara una historia. Y también me gusta mucho compartir conocimientos con los más jóvenes. Ellos me enseñan sobre permacultura y yo les enseño sobre las fases de la luna para sembrar.</p>',
                'descripcion' => 'Conversación con María del Socorro Martínez sobre su experiencia en el huerto comunitario y la recuperación de saberes ancestrales en el contexto urbano.',
                'palabras_clave' => 'huerto comunitario, saberes ancestrales, jubilación activa, intergeneracional, agricultura urbana',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'transcripcion' => 'Transcripción completa disponible. Duración: 24 minutos. La entrevista aborda temas de soberanía alimentaria, intercambio intergeneracional de conocimientos y el impacto personal de la participación en proyectos comunitarios.',
                'autor' => 'Equipo Casa Gallina',
                'fecha_publicacion' => Carbon::now()->subDays(56),
                'activo' => true,
                'tags' => ['Huerto', 'Adultos Mayores']
            ],
            [
                'tipo' => 'entrevista',
                'titulo' => 'Entrevista con el Colectivo "Raíces Urbanas": Mapeo Colectivo y Territorio',
                'contenido' => '<p><strong>Casa Gallina:</strong> ¿Cómo nació la idea de hacer mapeos colectivos en Santa María la Ribera?</p><p><strong>Andrea (Raíces Urbanas):</strong> Nos dimos cuenta de que cada persona vive el barrio de manera diferente. Los niños conocen rutas y lugares que los adultos no ven, las mujeres mayores tienen memorias de cómo era el barrio hace 40 años. Queríamos crear un mapa que incluyera todas esas miradas.</p><p><strong>CG:</strong> ¿Cuál ha sido la metodología?</p><p><strong>Javier (RU):</strong> Hacemos caminatas grupales donde cada participante va señalando lugares significativos para él o ella. Puede ser el árbol donde jugaba de niño, la esquina donde está su puesto de quesadillas favorito, o el lugar donde sintió miedo alguna vez. Todo eso se va marcando en un mapa base.</p><p><strong>CG:</strong> ¿Qué han descubierto?</p><p><strong>Andrea:</strong> Que el barrio es mucho más complejo de lo que pensábamos. Hay microterritorios, hay lugares que para algunos son de encuentro y para otros de evitación. Hemos identificado al menos 15 espacios que la gente usa como lugares de reunión informal, pero que no aparecen en ningún mapa oficial.</p>',
                'descripcion' => 'Diálogo con el colectivo Raíces Urbanas sobre su trabajo de mapeo colectivo del territorio y la construcción participativa de cartografías comunitarias.',
                'palabras_clave' => 'mapeo colectivo, territorio, cartografía participativa, barrio, memoria urbana, geografía crítica',
                'video_url' => 'https://www.youtube.com/watch?v=oHg5SJYRHA0',
                'transcripcion' => 'Entrevista completa de 31 minutos donde se profundiza en las metodologías de mapeo participativo, los hallazgos sobre microterritorios barriales y la importancia de la cartografía comunitaria para la construcción de identidad territorial.',
                'autor' => 'Sandra López Vega',
                'fecha_publicacion' => Carbon::now()->subDays(72),
                'activo' => true,
                'tags' => ['Mapeos Colectivos', 'Encuentros Vecinales']
            ],

            // OTRAS EXPERIENCIAS (2 items)
            [
                'tipo' => 'otras_experiencias',
                'titulo' => 'La Casa de las Flores: Una Experiencia de Vivienda Colaborativa en Xochimilco',
                'contenido' => '<p>A 45 minutos en transporte público desde Casa Gallina, en el pueblo de San Gregorio Atlapulco, Xochimilco, existe una experiencia que nos inspira y nos reta: La Casa de las Flores, un proyecto de vivienda colaborativa que desde hace cinco años experimenta con formas alternativas de habitar la ciudad.</p><p>La Casa de las Flores es una construcción de dos plantas que alberga a ocho adultos y tres niños, quienes han decidido compartir no solo el espacio físico, sino también las tareas domésticas, los gastos, las decisiones y los sueños. "No es una comuna hippie", aclara con humor Fernanda, una de las fundadoras. "Es una respuesta práctica a la crisis de vivienda y al individualismo urbano".</p><p>El proyecto surgió cuando un grupo de amigos se dio cuenta de que, trabajando por separado, ninguno podría acceder a una vivienda digna en la Ciudad de México. Juntaron recursos, compraron una casa en ruinas y durante dos años la fueron reconstruyendo los fines de semana, aprendiendo albañilería, plomería y electricidad en el proceso.</p><p>Lo que más nos llama la atención de esta experiencia es su modelo de toma de decisiones. Cada mes se reúnen en asamblea para discutir desde los gastos hasta las reglas de convivencia. Han desarrollado protocolos para resolver conflictos y han creado espacios privados dentro del espacio compartido.</p>',
                'descripcion' => 'Relato de la experiencia de La Casa de las Flores en Xochimilco, un proyecto de vivienda colaborativa que experimenta con formas alternativas de habitar la ciudad.',
                'palabras_clave' => 'vivienda colaborativa, economía solidaria, autogestión, crisis habitacional, vida comunitaria',
                'autor' => 'Colectivo Casa Gallina',
                'fecha_publicacion' => Carbon::now()->subDays(84),
                'activo' => true,
                'tags' => ['Encuentros Vecinales']
            ],
            [
                'tipo' => 'otras_experiencias',
                'titulo' => 'Mercado de Trueque en Tlatelolco: Intercambio sin Dinero en Pleno Centro Urbano',
                'contenido' => '<p>Cada último domingo del mes, la Plaza de las Tres Culturas en Tlatelolco se transforma en un espacio donde el dinero no existe. Es el día del Mercado de Trueque, una iniciativa que desde hace tres años ha logrado crear una economía alternativa en pleno corazón de la Ciudad de México.</p><p>La dinámica es simple pero revolucionaria: las personas llevan objetos, alimentos, conocimientos o servicios que quieren intercambiar, sin mediar dinero de por medio. Un libro de cocina puede cambiarse por una clase de guitarra, una maceta con hierbas aromáticas puede intercambiarse por una sesión de masaje, o una blusa tejida a mano puede trocarse por verduras orgánicas.</p><p>Carmen Delgado, coordinadora del mercado, explica: "Al principio la gente llegaba con la mentalidad de que todo tiene que valer lo mismo en pesos. Poco a poco hemos aprendido que el valor no siempre se puede medir en dinero. A veces una conversación vale más que cualquier objeto".</p><p>Lo que más nos impresiona es la diversidad de participantes: desde estudiantes universitarios hasta adultos mayores jubilados, desde artesanos tradicionales hasta programadores de software. Todos encuentran algo que ofrecer y algo que necesitan.</p>',
                'descripcion' => 'Exploración del Mercado de Trueque en Tlatelolco como ejemplo de economía solidaria y intercambio no monetario en el contexto urbano.',
                'palabras_clave' => 'mercado de trueque, economía solidaria, intercambio no monetario, economía alternativa, comunidad urbana',
                'autor' => 'Raquel Herrera Soto',
                'fecha_publicacion' => Carbon::now()->subDays(91),
                'activo' => true,
                'tags' => ['Encuentros Vecinales']
            ],

            // RESEÑA INVITACION (2-3 items)
            [
                'tipo' => 'resena_invitacion',
                'titulo' => 'Invitación: Festival de Documentales Comunitarios "Otras Miradas"',
                'contenido' => '<p>Del 15 al 17 de marzo, Casa Gallina será sede del primer Festival de Documentales Comunitarios "Otras Miradas", un encuentro que busca visibilizar las narrativas audiovisuales creadas desde y para las comunidades.</p><p>Durante tres días proyectaremos 12 documentales realizados por colectivos, organizaciones sociales y comunidades de diferentes estados de la República Mexicana. Los trabajos abordan temáticas como defensa del territorio, soberanía alimentaria, medicina tradicional, y resistencias culturales.</p><p>El festival incluye también talleres de producción audiovisual comunitaria, círculos de diálogo con los realizadores, y espacios de intercambio metodológico para quienes quieren aprender a documentar sus propios procesos organizativos.</p><p>Destacamos especialmente la proyección de "Semillas de Resistencia", documental realizado por mujeres indígenas de Oaxaca sobre la defensa del maíz criollo, y "Río Abajo", producido por jóvenes de Veracruz sobre la contaminación del río Coatzacoalcos por empresas petroquímicas.</p>',
                'descripcion' => 'Invitación al Festival de Documentales Comunitarios "Otras Miradas" que se realizará en Casa Gallina del 15 al 17 de marzo.',
                'datos_evento' => [
                    'fecha' => '15-17 de marzo',
                    'ubicacion' => 'Casa Gallina - Dr. Atl 46, Santa María la Ribera',
                    'costo' => 'Entrada libre con cooperación voluntaria',
                    'horarios' => 'Viernes y sábado 16:00-21:00hrs, Domingo 11:00-18:00hrs'
                ],
                'palabras_clave' => 'documentales comunitarios, cine social, narrativas populares, festival, audiovisual',
                'autor' => 'Comité Organizador',
                'fecha_publicacion' => Carbon::now()->subDays(18),
                'activo' => true,
                'tags' => ['Exposiciones Comunitarias']
            ],
            [
                'tipo' => 'resena_invitacion',
                'titulo' => 'Reseña: "Bordando Resistencias" - Taller de Textil y Memoria Histórica',
                'contenido' => '<p>El pasado sábado concluyó el taller "Bordando Resistencias", un espacio de seis sesiones donde 15 mujeres de diferentes edades exploramos la relación entre el textil tradicional y la construcción de memoria histórica.</p><p>Facilitado por Esperanza Mayans, maestra textilera de origen zapoteco, el taller nos permitió aprender técnicas básicas de bordado mientras reflexionábamos sobre las historias que pueden contarse a través de hilos y agujas.</p><p>Cada participante desarrolló una pieza textil que narrara algún aspecto de la historia de su familia o de su barrio. Surgieron bordados que hablan de migración, de oficios perdidos, de árboles que ya no están, de fiestas que se dejaron de celebrar.</p><p>La riqueza del taller no estuvo solo en aprender técnicas, sino en descubrir que bordar puede ser una forma de escribir historia. Como dijo una de las participantes: "Cada puntada es una palabra, cada bordado es una página de un libro que escribimos entre todas".</p><p>Las piezas realizadas durante el taller estarán expuestas en Casa Gallina durante el mes de abril, como parte de la muestra "Historias Bordadas: Memoria Textil de Santa María la Ribera".</p>',
                'descripcion' => 'Reseña del taller "Bordando Resistencias" y anuncio de la exposición "Historias Bordadas" que exhibirá los trabajos realizados.',
                'datos_evento' => [
                    'fecha' => 'Todo abril',
                    'ubicacion' => 'Casa Gallina - Sala de exposiciones',
                    'costo' => 'Entrada libre',
                    'horarios' => 'Lunes a viernes 10:00-18:00hrs, Sábados 10:00-14:00hrs'
                ],
                'palabras_clave' => 'textil tradicional, bordado, memoria histórica, mujeres, tradiciones, exposición',
                'autor' => 'Colectivo de Mujeres Casa Gallina',
                'fecha_publicacion' => Carbon::now()->subDays(35),
                'activo' => true,
                'tags' => ['Exposiciones Comunitarias', 'Encuentros Vecinales']
            ],
            [
                'tipo' => 'resena_invitacion',
                'titulo' => 'Invitación: Círculo de Sanación con Plantas Medicinales',
                'contenido' => '<p>Te invitamos al Círculo de Sanación con Plantas Medicinales que realizaremos cada viernes de febrero en Casa Gallina, de 17:00 a 19:00 horas.</p><p>Estos encuentros están dirigidos por la curandera tradicional Felicitas Moreno, quien desde hace 40 años trabaja con medicina herbolaria en diferentes comunidades del Estado de México y la Ciudad de México.</p><p>En cada sesión exploraremos diferentes plantas medicinales de uso común: manzanilla para la digestión y los nervios, ruda para limpias energéticas, gordolobo para afecciones respiratorias, hierbabuena para dolores estomacales, entre otras.</p><p>El círculo incluye preparación de tés e infusiones, técnicas básicas de herbolaria, identificación de plantas, y un espacio de diálogo sobre la importancia de recuperar estos saberes ancestrales en el contexto urbano.</p><p>Es importante mencionar que estas prácticas complementan pero no sustituyen la atención médica profesional. El círculo es un espacio de conocimiento tradicional y acompañamiento comunitario.</p>',
                'descripcion' => 'Invitación al Círculo de Sanación con Plantas Medicinales que se realizará todos los viernes de febrero en Casa Gallina.',
                'datos_evento' => [
                    'fecha' => 'Todos los viernes de febrero',
                    'ubicacion' => 'Casa Gallina - Área de huerto',
                    'costo' => 'Cooperación voluntaria de $100 pesos',
                    'horarios' => '17:00 a 19:00 horas'
                ],
                'palabras_clave' => 'plantas medicinales, herbolaria tradicional, sanación, medicina ancestral, círculo de mujeres',
                'autor' => 'Área de Salud Comunitaria',
                'fecha_publicacion' => Carbon::now()->subDays(8),
                'activo' => true,
                'tags' => ['Cocina y Salud', 'Encuentros Vecinales']
            ],

            // NOTICIAS (3-4 items)
            [
                'tipo' => 'noticias',
                'titulo' => 'Casa Gallina Recibe Reconocimiento por Proyecto de Educación Ambiental',
                'contenido' => '<p>El pasado martes, Casa Gallina recibió el reconocimiento "Comunidad Sustentable 2024" otorgado por la Secretaría del Medio Ambiente de la Ciudad de México, por el desarrollo del proyecto "Huertos Escolares: Sembrando Futuro".</p><p>Este proyecto, que hemos desarrollado durante los últimos dos años en colaboración con tres escuelas primarias de Santa María la Ribera, ha beneficiado a más de 200 niños y niñas, quienes han aprendido técnicas de agricultura urbana, compostaje y cuidado del agua.</p><p>La ceremonia de reconocimiento se realizó en el Museo de Historia Natural, donde también fueron reconocidas otras 15 organizaciones de la ciudad que desarrollan proyectos innovadores en materia ambiental.</p><p>Ana María Pérez, coordinadora del área de educación ambiental de Casa Gallina, recibió el reconocimiento y comentó: "Este premio no es solo nuestro, es de toda la comunidad educativa que ha participado: niños, maestros, padres de familia y vecinos que han hecho posible que los huertos escolares sean una realidad".</p>',
                'descripcion' => 'Casa Gallina recibe reconocimiento oficial por su proyecto de educación ambiental "Huertos Escolares: Sembrando Futuro" desarrollado con escuelas primarias del barrio.',
                'palabras_clave' => 'reconocimiento, educación ambiental, huertos escolares, sustentabilidad, SEDEMA',
                'autor' => 'Área de Comunicación',
                'fecha_publicacion' => Carbon::now()->subDays(5),
                'activo' => true,
                'tags' => ['Escuelas', 'Educación Ambiental']
            ],
            [
                'tipo' => 'noticias',
                'titulo' => 'Nueva Alianza con Mercado San Cosme para Intercambio de Productos del Huerto',
                'contenido' => '<p>A partir de este mes, Casa Gallina establece una alianza con el Mercado San Cosme para el intercambio semanal de productos frescos del huerto comunitario por insumos necesarios para nuestras actividades.</p><p>Cada miércoles, llevaremos al mercado la cosecha semanal del huerto: lechugas, rábanos, acelgas, hierbas aromáticas y flores comestibles, que intercambiaremos por productos básicos como frijol, arroz, aceite y otros insumos que utilizamos en nuestros talleres de cocina.</p><p>Esta alianza surge del acuerdo establecido con Aurelio Campos, administrador del mercado, quien se ha mostrado muy interesado en apoyar proyectos de agricultura urbana y comercio justo en el barrio.</p><p>"Es una forma de cerrar ciclos", explica Margarita Torres, coordinadora del huerto. "Nuestros productos llegan a la mesa de los vecinos del barrio, y nosotros obtenemos los insumos que necesitamos para seguir creando comunidad a través de la comida".</p>',
                'descripcion' => 'Anuncio de nueva alianza entre Casa Gallina y Mercado San Cosme para intercambio semanal de productos del huerto comunitario.',
                'palabras_clave' => 'alianza comercial, mercado local, intercambio, huerto comunitario, comercio justo, economía local',
                'autor' => 'Coordinación General',
                'fecha_publicacion' => Carbon::now()->subDays(15),
                'activo' => true,
                'tags' => ['Huerto', 'Encuentros Vecinales']
            ],
            [
                'tipo' => 'noticias',
                'titulo' => 'Inauguración de Nueva Biblioteca Comunitaria con Más de 2,000 Libros Donados',
                'contenido' => '<p>El próximo sábado 20 de enero inauguraremos oficialmente la Biblioteca Comunitaria de Casa Gallina, un espacio que ha crecido gracias a las donaciones de más de 150 familias del barrio y organizaciones aliadas.</p><p>La biblioteca cuenta actualmente con más de 2,000 libros clasificados en las áreas de literatura mexicana y latinoamericana, ciencias sociales, agricultura y medio ambiente, salud natural, arte y cultura, además de una sección especial de literatura infantil y juvenil.</p><p>El espacio también incluye una zona de lectura silenciosa, una mesa grande para trabajo en grupo, y un rincón especial para los más pequeños con cojines y libros álbum.</p><p>La inauguración incluirá una lectura de cuentos para niños a cargo del grupo de teatro "Los Tlacuaches", una presentación del sistema de préstamo (totalmente gratuito para vecinos del barrio), y una merienda comunitaria.</p><p>Los horarios de la biblioteca serán: lunes a viernes de 15:00 a 20:00 horas, sábados de 10:00 a 16:00 horas. El préstamo de libros es gratuito para todos los vecinos de Santa María la Ribera.</p>',
                'descripcion' => 'Anuncio de la inauguración de la Biblioteca Comunitaria de Casa Gallina con más de 2,000 libros donados por la comunidad.',
                'datos_evento' => [
                    'fecha' => 'Sábado 20 de enero',
                    'ubicacion' => 'Casa Gallina - Nueva biblioteca',
                    'costo' => 'Entrada libre',
                    'horarios' => '11:00 a 14:00 horas'
                ],
                'palabras_clave' => 'biblioteca comunitaria, inauguración, donación de libros, acceso a la cultura, educación popular',
                'autor' => 'Comité de Biblioteca',
                'fecha_publicacion' => Carbon::now()->subDays(3),
                'activo' => true,
                'tags' => ['Infancias Adolescencias', 'Encuentros Vecinales']
            ],
            [
                'tipo' => 'noticias',
                'titulo' => 'Taller de Reparación de Bicicletas Atrae a Más de 50 Participantes en su Primera Edición',
                'contenido' => '<p>El taller "Manos a la Bici: Reparación y Mantenimiento Básico" realizado el pasado fin de semana superó todas las expectativas al recibir a 52 participantes de todas las edades interesados en aprender a cuidar y reparar sus bicicletas.</p><p>Organizado en colaboración con el Colectivo Ciclista Ribereño, el taller ofreció conocimientos básicos sobre cambio de llantas, ajuste de frenos, lubricación de cadenas y afinación general de bicicletas.</p><p>Los participantes trajeron sus propias bicicletas para practicar las técnicas aprendidas, desde niños de 10 años con sus bicis de montaña hasta adultos mayores con bicicletas clásicas de los años 80.</p><p>"La respuesta de la comunidad ha sido increíble", comenta Jorge Ramírez del Colectivo Ciclista Ribereño. "Muchas personas tienen bicicletas guardadas que no usan porque creen que están muy dañadas, pero con conocimientos básicos pueden volverlas funcionales".</p><p>Debido al éxito de esta primera edición, el taller se realizará ahora cada último sábado del mes, siempre de 10:00 a 14:00 horas.</p>',
                'descripcion' => 'Reporte del éxito del primer taller de reparación de bicicletas, que contó con más de 50 participantes y se convertirá en actividad mensual.',
                'palabras_clave' => 'taller de bicicletas, movilidad sustentable, reparación, colectivo ciclista, transporte alternativo',
                'autor' => 'Área de Comunicación',
                'fecha_publicacion' => Carbon::now()->subDays(21),
                'activo' => true,
                'tags' => ['Encuentros Vecinales', 'Educación Ambiental']
            ],

            // ENLACES (2 items)
            [
                'tipo' => 'enlaces',
                'titulo' => 'Recursos Digitales para la Agricultura Urbana y la Permacultura',
                'contenido' => '<p>Compartimos una selección de recursos digitales que hemos estado consultando para enriquecer nuestras prácticas de agricultura urbana y permacultura en Casa Gallina.</p><p>Estos sitios web, canales de YouTube y plataformas educativas ofrecen información valiosa tanto para principiantes como para personas con experiencia en huertos urbanos, compostaje, captación de agua de lluvia y diseño permacultural.</p><p>La mayoría de estos recursos están en español y han sido validados por nuestro equipo de educación ambiental. Los recomendamos especialmente para complementar la formación práctica que ofrecemos en nuestros talleres presenciales.</p>',
                'descripcion' => 'Compilación de recursos digitales útiles para el aprendizaje de agricultura urbana, permacultura y prácticas sustentables.',
                'enlaces_externos' => [
                    [
                        'titulo' => 'Huerto Urbano México - Portal de agricultura urbana',
                        'url' => 'https://www.huertourbano.mx'
                    ],
                    [
                        'titulo' => 'Instituto de Permacultura México',
                        'url' => 'https://www.permacultura.org.mx'
                    ],
                    [
                        'titulo' => 'Ecotécnias - Manual de construcción sustentable',
                        'url' => 'https://www.ecotecnias.com'
                    ],
                    [
                        'titulo' => 'Red de Huertos Urbanos CDMX',
                        'url' => 'https://www.redhuertosmx.org'
                    ]
                ],
                'palabras_clave' => 'agricultura urbana, permacultura, recursos digitales, educación ambiental, sustentabilidad',
                'autor' => 'Área de Educación Ambiental',
                'fecha_publicacion' => Carbon::now()->subDays(67),
                'activo' => true,
                'tags' => ['Huerto', 'Educación Ambiental']
            ],
            [
                'tipo' => 'enlaces',
                'titulo' => 'Organizaciones Hermanas: Proyectos Comunitarios Inspiradores en la Ciudad de México',
                'contenido' => '<p>Como parte de nuestro compromiso con el fortalecimiento del tejido comunitario en la Ciudad de México, compartimos los sitios web y redes sociales de organizaciones que, como Casa Gallina, desarrollan proyectos comunitarios transformadores en diferentes colonias de la ciudad.</p><p>Estas organizaciones nos inspiran con su trabajo cotidiano y nos recuerdan que en muchos rincones de la ciudad existen experiencias de organización vecinal, educación popular, arte comunitario y economía solidaria.</p><p>Los invitamos a conocer su trabajo, participar en sus actividades cuando sea posible, y tejer redes de colaboración y aprendizaje mutuo.</p>',
                'descripcion' => 'Directorio de organizaciones comunitarias inspiradoras que desarrollan proyectos similares a Casa Gallina en diferentes colonias de la Ciudad de México.',
                'enlaces_externos' => [
                    [
                        'titulo' => 'Huerto Roma Verde - Agricultura urbana en la Roma Norte',
                        'url' => 'https://www.huertoromaverde.org'
                    ],
                    [
                        'titulo' => 'Casa Vecina - Arte y comunidad en el Centro Histórico',
                        'url' => 'https://www.casavecina.org'
                    ],
                    [
                        'titulo' => 'Cooperativa Palo Alto - Economía solidaria en la Doctores',
                        'url' => 'https://www.cooperativapalolato.mx'
                    ],
                    [
                        'titulo' => 'Colectivo Azcapotzalco - Cultura comunitaria en el norte de la ciudad',
                        'url' => 'https://www.colectivoazcapotzalco.org'
                    ],
                    [
                        'titulo' => 'Jardín Comunitario Tlatelolco - Agricultura urbana en Nonoalco',
                        'url' => 'https://www.jardincomunitariotlatelolco.mx'
                    ]
                ],
                'palabras_clave' => 'organizaciones comunitarias, proyectos sociales, redes de colaboración, Ciudad de México, movimiento social urbano',
                'autor' => 'Coordinación General',
                'fecha_publicacion' => Carbon::now()->subDays(43),
                'activo' => true,
                'tags' => ['Encuentros Vecinales']
            ],

            // NEWSLETTER (2 items)
            [
                'tipo' => 'newsletter',
                'titulo' => 'Newsletter Enero 2024: Nuevos Proyectos y Celebración de Comunidad',
                'contenido' => '<p><strong>¡Hola, comunidad de Casa Gallina!</strong></p><p>Iniciamos 2024 con mucha energía y proyectos emocionantes que queremos compartir con ustedes.</p><p><strong>🌱 Huerto Comunitario</strong><br>Este mes estaremos sembrando la cosecha de invierno: lechugas, rábanos, acelgas y espinacas. Las jornadas de trabajo en el huerto son todos los sábados de 9:00 a 12:00 horas. ¡Nuevos participantes siempre bienvenidos!</p><p><strong>📚 Nueva Biblioteca</strong><br>¡Ya tenemos más de 2,000 libros! La inauguración oficial será el 20 de enero. Necesitamos voluntarios para el sistema de préstamos.</p><p><strong>🎭 Talleres de Enero</strong><br>- Círculo de sanación con plantas medicinales (viernes)<br>- Reparación de bicicletas (último sábado)<br>- Cocina tradicional mexicana (miércoles)</p><p><strong>💚 Gracias</strong><br>A todas las personas que han donado libros, plantas, tiempo y cariño para hacer crecer este proyecto colectivo.</p><p>¡Nos vemos en Casa Gallina!</p>',
                'descripcion' => 'Newsletter mensual de enero 2024 con actividades, proyectos nuevos y agradecimientos a la comunidad de Casa Gallina.',
                'palabras_clave' => 'newsletter, actividades mensuales, comunidad, voluntariado, proyectos 2024',
                'autor' => 'Equipo de Comunicación',
                'fecha_publicacion' => Carbon::now()->subDays(28),
                'activo' => true,
                'tags' => ['Encuentros Vecinales']
            ],
            [
                'tipo' => 'newsletter',
                'titulo' => 'Newsletter Diciembre 2023: Balance del Año y Planes Futuros',
                'contenido' => '<p><strong>Querida comunidad,</strong></p><p>Al cerrar 2023, queremos hacer un balance de todo lo que hemos construido juntos y compartir nuestros sueños para 2024.</p><p><strong>🏆 Logros 2023</strong><br>- 48 talleres realizados con 850+ participantes<br>- 15 toneladas de composta producida<br>- 3 nuevas alianzas con escuelas del barrio<br>- 200 familias beneficiadas con intercambio de productos del huerto</p><p><strong>🎉 Celebración de Fin de Año</strong><br>El 16 de diciembre tendremos nuestra fiesta anual con posada, intercambio de regalos hechos a mano, cena comunitaria y música en vivo. ¡Toda la familia está invitada!</p><p><strong>🌟 Proyectos 2024</strong><br>- Biblioteca comunitaria<br>- Programa de becas para talleres<br>- Festival de documentales comunitarios<br>- Intercambio con organizaciones rurales</p><p><strong>🙏 Infinitas gracias</strong><br>Por hacer de Casa Gallina un espacio vivo, diverso y transformador.</p><p>Con cariño,<br>El equipo de Casa Gallina</p>',
                'descripcion' => 'Newsletter de diciembre 2023 con balance anual de actividades, celebración de fin de año y presentación de proyectos para 2024.',
                'datos_evento' => [
                    'fecha' => '16 de diciembre',
                    'ubicacion' => 'Casa Gallina - Patio principal',
                    'costo' => 'Entrada libre, traer platillo para compartir',
                    'horarios' => '16:00 a 22:00 horas'
                ],
                'palabras_clave' => 'newsletter, balance anual, celebración, proyectos futuros, fiesta comunitaria',
                'autor' => 'Coordinación General',
                'fecha_publicacion' => Carbon::now()->subDays(95),
                'activo' => true,
                'tags' => ['Encuentros Vecinales']
            ]
        ];

        // Create noticias and associate tags
        foreach ($noticias as $noticiaData) {
            $tags = $noticiaData['tags'] ?? [];
            unset($noticiaData['tags']);
            
            $noticia = Noticia::create($noticiaData);
            
            // Associate tags if they exist
            if (!empty($tags)) {
                $tagIds = Tag::whereIn('nombre', $tags)->pluck('id')->toArray();
                if (!empty($tagIds)) {
                    $noticia->tags()->attach($tagIds);
                }
            }
        }
    }
}