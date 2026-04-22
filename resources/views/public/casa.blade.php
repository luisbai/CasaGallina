@extends('layouts.boilerplate')

@section('content')
    <div id="casa-index">
        <section id="casa-banner">
            <img loading="lazy" src="/assets/images/casa/banner.jpg" class="img-fluid">
        </section>
        
        <section id="casa-intro">
            <div class="container">
                <div class="section-title text-center">
                    <span>Historia</span>
                </div>

                <div class="intro-text">
                    Casa Gallina comenzó en 2013 en una casa en la colonia Santa María la Ribera de la Ciudad de México. Durante la última década, el espacio se ha transformado para albergar una serie de programas que crean un diálogo entre los vecinos para intercambiar perspectivas sobre cuestiones y acciones culturales en la vida cotidiana a través del arte.
                </div>
        
                <div class="intro-description">
                    <p>Los visitantes y huéspedes de Casa Gallina son bienvenidos al espacio comunitario como si vinieran a su propia casa, su hogar. Si bien el nombre "Casa Gallina" comenzó como una referencia interna por parte de los fundadores de la organización, el nombre habla de la naturaleza colaborativa de su programación y la conexión con la naturaleza en un entorno urbano.</p>

                    <p>Desde 2019, Casa Gallina se ha expandido a través de alianzas estratégicas con organizaciones aliadas en todo México para activar nuevas comunidades en torno a la protección del medio ambiente y la expresión cultural.</p>
                </div>
            </div>
        </section>
        
        <div id="casa-info">
            <div class="container">
                <div class="section-title text-center">
                    <span>Poblaciones atendidas</span>
                </div>
            </div>

            <div class="casa-info-banner">
                <img loading="lazy" src="/assets/images/casa/info-banner.jpg" class="img-fluid">
            </div>

            <div class="container">
                <div class="row justify-content-center mt-4">
                    <div class="col-md-6">
                        <div class="intro-text">
                            Arraigada en la colonia Santa María la Ribera, el impacto de Casa Gallina se extiende a través de 21 estados en todo México a través de sólidas alianzas con escuelas locales, museos y otros aliados estratégicos.
                        </div>

                        <div class="intro-description">
                            <p>Los aliados incluyen una red de organizaciones comunitarias, instituciones públicas y privadas, y colectivos en Aguascalientes, Campeche, Chiapas, Ciudad de México, Estado de México, Guerrero, Hidalgo, Jalisco, Michoacán, Morelos, Nayarit, Nuevo León, Oaxaca, Puebla, Querétaro, Quintana Roo, Sonora, Tabasco, Tlaxcala, Veracruz y Yucatán.</p>
                            
                            <p>Miles de vecinos de la comunidad de Santa María la Ribera visitan Casa Gallina cada año, con una programación diseñada para que los residentes de todas las edades (0-90 años) participen y disfruten. Los espacios comunitarios y la programación de Casa Gallina son especialmente beneficiosos para los residentes de bajos ingresos que de otro modo tendrían dificultades para acceder a servicios como el laboratorio de informática, la biblioteca y las clases de cocina saludable.</p>
                            
                            <p>Más allá del centro físico, la mayoría (65 %) de los participantes del programa de Casa Gallina son jóvenes menores de 20 años. Casa Gallina garantiza que las generaciones futuras crezcan con una comprensión intencional de su impacto en el mundo que los rodea, al centrarse en el desarrollo del liderazgo y la educación. El enfoque de Casa Gallina en preservar las tradiciones indígenas es particularmente relevante para las comunidades indígenas que enfrentan desafíos comunes en la sociedad mexicana.</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="casa-direccion">
                            <div class="casa-direccion-title">Casa Gallina</div>
                            <div class="casa-direccion-text">
                                Sabino 190, Santa María la Ribera, Ciudad de México, 06400. <br>
                                +52 55 2630 2601<br>
                                +52 55 6813 9568<br>
                                <a href="mailto:info@casagallina.org.mx">info@casagallina.org.mx</a>
                            </div>
                            <div class="casa-direccion-mapa">
                                <img loading="lazy" src="/assets/images/casa/mapa.jpg" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        <div id="casa-marco">
            <div class="container">
                <div class="section-title text-center">
                    <span>Necesidades, metas y objetivos</span>
                </div>
            </div>

            <div class="casa-marco-banner">
                <img loading="lazy" src="/assets/images/casa/marco-banner.jpg" class="img-fluid">
            </div>

            <div class="container">
                <div class="intro-text">
                    En el mundo actual, el 56 % de las personas viven en áreas urbanas, el porcentaje más alto registrado en la historia reciente. A medida que la urbanización ha aumentado, la cobertura arbórea ha disminuido gradualmente y es más difícil para la gente común sentirse conectada con el mundo natural o reconocer el impacto de las acciones humanas en el medio ambiente.
                </div>

                <div class="intro-description">
                    <p>La urbanización y el crecimiento de la población también han contribuido a una serie de males sociales, como el consumo excesivo, la contaminación del aire, el aislamiento social entre los adultos mayores, la pérdida de tradiciones indígenas y la inseguridad alimentaria, además de la abrumadora amenaza de la crisis climática.</p>
                    
                    <p>Los enfoques centrados en la comunidad son esenciales para abordar los problemas interconectados del aislamiento social, la pérdida de tradiciones indígenas y la inseguridad alimentaria, y para generar acciones contra la crisis climática. Fomentar conexiones más profundas con la naturaleza y el acceso a los espacios verdes urbanos puede ayudar a frenar la pérdida de biodiversidad y ayudar a influir en las acciones y creencias proambientales de las personas, y generar acciones contra la crisis climática.</p>
                    
                    <p>El objetivo general de Casa Gallina es fomentar fuertes conexiones con el mundo natural, así como con las culturas indígenas con el fin de promover la protección del medio ambiente y la expresión cultural en todo México. Para lograr este objetivo, cada programa de Casa Gallina crea experiencias colaborativas y diálogo a través del arte que inspira a las personas a tomar medidas para mejorar el mundo que las rodea. Los diversos programas de Casa Gallina buscan alcanzar los siguientes objetivos:</p>
                    
                    <ol>
                        <li>Fomentar la empatía y la comprensión entre vecinos a través de eventos comunitarios, programas y exhibiciones de arte para que puedan colaborar para mejorar la vida diaria y promover el bien común.</li>
                        <li>Capacitar a los educadores para integrar perspectivas ambientales relevantes para el contexto en los planes de lecciones para mejorar las habilidades de pensamiento crítico de los jóvenes y acercar a los estudiantes a información sobre la naturaleza y el medio ambiente.</li>
                        <li>Operar un laboratorio innovador para satisfacer las necesidades de todos los miembros de la comunidad, incluidos los jóvenes, los ancianos y las poblaciones indígenas marginadas.</li>
                        <li>Proporcionar un marco metodológico y promover la sostenibilidad ambiental y fomentar la cohesión social para que las organizaciones aliadas adapten y extiendan el impacto de Casa Gallina en todo el país para fortalecer el tejido social.</li>
                    </ol>
                </div>
            </div>
        </div>

        <div id="casa-marco">
            <div class="container">
                <div class="section-title text-center">
                    <span>Nuestro modelo</span>
                </div>
            </div>

            <div class="casa-marco-banner">
                <img loading="lazy" src="/assets/images/casa/areas-banner.jpg" class="img-fluid">
            </div>
             
            <div class="container">
               <div class="intro-text">
               Nuestro trabajo ayuda a desarrollar la resiliencia de la comunidad, aumentar el aprendizaje colaborativo y fomentar las conexiones entre
                los miembros de la comunidad y las organizaciones aliadas, especialmente los jóvenes, los educadores, las personas mayores y las comunidades
                 indígenas, para impulsar el cuidado y la conexión con el mundo natural. 
                </div>
                <div class="intro-description">
                    <h3>Teoría de cambio</h3>
                    
                    <p class="casa-marco-text">
                        Nuestra teoría del cambio se basa en la creencia de que fomentar el aprendizaje colaborativo y las interacciones interdisciplinarias entre profesionales de diversos campos conduce a soluciones innovadoras y un impacto social positivo. A través del diálogo facilitado, el intercambio de ideas, eventos y proyectos interdisciplinarios, Casa Gallina tiene como objetivo crear un entorno dinámico que fomente la creatividad, la resolución de problemas y la participación comunitaria.   
                    </p>    

                    <h3>Metodologías centradas en la comunidad</h3>

                    <p>
                        El compromiso y la colaboración de la comunidad son fundamentales para el modelo de Casa Gallina. Nuestra organización no pretende ser
                        un "referente intelectual", sino más bien un conector y articulador de la rica red de líderes comunitarios activos, gestores de cambio y protectores de territorios de México. Todo el trabajo de Casa Gallina se desarrolla en función de las necesidades específicas de las comunidades atendidas, a través de retroalimentación y conversaciones con vecinos, socios y participantes a través de actividades como el mapeo colectivo. Nos dedicamos a trabajar con otros en todas las iniciativas para crear comunidad, confianza y un ambiente colaborativo.   
                    </p>
                </div>
            </div>
        </div>

        <div id="casa-marco">
            <div class="container">
                <div class="section-title text-center">
                    <span>Seguimiento y evaluación</span>
                </div>
            </div>

            <div class="casa-marco-banner">
                <img loading="lazy" src="/assets/images/casa/seguimiento-banner.jpg" class="img-fluid">
            </div>
             
            <div class="container">
               <div class="intro-text ">
                    Casa Gallina mide los resultados de la programación a través de una combinación de métricas cuantitativas y cualitativas. Registramos el número de escuelas, maestros y estudiantes que interactúan con las iniciativas de Casa Gallina, incluyendo el número de territorios y organizaciones aliadas donde se lleva a cabo la programación.
                </div>
                <div class="intro-description">
                    <p>
                        También se mide el número de exposiciones de arte y murales producidos, junto con el número de visitantes (presenciales y virtuales) en cada exposición. Para hacer un seguimiento del éxito de las publicaciones, registramos el número de libros publicados y el porcentaje de libros que se imprimen en lenguas indígenas. También empleamos métricas cualitativas e innovadoras como mapeo colectivo, cuestionarios y dibujos pautados donde los jóvenes pueden compartir sus opiniones sinceras y aprendizajes de los programas.
                    </p>
                    <p>
                        Para medir el impacto de la programación en nuestra sede, realizamos un seguimiento del número promedio de asistentes a la Casa, incluido el número de participantes en las reuniones del vecindario, los mercados de agricultores y las clases de agroecología, y métricas adicionales relacionadas con el consumo responsable, como el número de variedades de semillas agroecológicas recolectadas, la producción de suelo fértil derivado del compost y los jardines del vecindario vinculados a las lecciones de Casa Gallina. Los miembros de la comunidad participan en encuestas frecuentes y brindan testimonios sobre sus experiencias, y pueden dejar comentarios en el centro.
                    </p>
                </div>
            </div>
        </div>

        <div id="casa-equipo">
            <div class="container">
                <div class="section-title text-center">
                    <span>Quiénes somos</span>
                </div>

                <div class="row pt-4">
                    <div class="col-md-7">
                        <div class="equipo-image">
                            <img loading="lazy" src="/assets/images/casa/equipocg31.png" class="img-fluid">
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="equipo-title">
                            Equipo
                        </div>

                        <div class="equipo-wrapper">
                            @isset ($miembros_agrupados['equipo'])
                                @foreach ($miembros_agrupados['equipo'] as $miembro)
                                    <div class="equipo-member" {{ strip_tags($miembro->biografia) !== '' ? 'data-action=toggle-miembro' : '' }} data-miembro="{{ $miembro->id }}">
                                        <div class="equipo-member-name">{{ $miembro->nombre }}</div>
                                        @if ($miembro->titulo !== '')
                                            <div class="equipo-member-title">{{ $miembro->titulo }}</div>
                                        @endif
                                    </div>
                                @endforeach
                            @endisset
                        </div>
                    </div>
                </div>

                <div class="row pt-4">
                    <div class="col-md-7">
                        <div class="equipo-image">
                            <img loading="lazy" src="/assets/images/casa/equipo-2.jpg" class="img-fluid">
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="equipo-title">
                            Mesa directiva
                        </div>

                        <div class="equipo-wrapper">
                            @isset ($miembros_agrupados['presidente'])
                                @foreach ($miembros_agrupados['presidente'] as $miembro)
                                    <div class="equipo-member" {{ strip_tags($miembro->biografia) !== '' ? 'data-action=toggle-miembro' : '' }} data-miembro="{{ $miembro->id }}">
                                        <div class="equipo-member-name">{{ $miembro->nombre }}</div>
                                        @if ($miembro->titulo !== '')
                                            <div class="equipo-member-title">{{ $miembro->titulo }}</div>
                                        @endif
                                    </div>
                                @endforeach
                            @endisset
                            <div class="equipo-member">
                                <div class="equipo-member-title">Miembros:</div>
                                @isset ($miembros_agrupados['directivos'])
                                    @foreach ($miembros_agrupados['directivos'] as $miembro)
                                        <div class="equipo-member mb-0" {{ strip_tags($miembro->biografia) !== '' ? 'data-action=toggle-miembro' : '' }} data-miembro="{{ $miembro->id }}">
                                            <div class="equipo-member-name">{{ $miembro->nombre }}</div>
                                        </div>
                                    @endforeach
                                @endisset
                            </div>
                            <div class="equipo-member">
                                <div class="equipo-member-title">Miembros honorarios:</div>
                                @isset ($miembros_agrupados['honorarios'])
                                    @foreach ($miembros_agrupados['honorarios'] as $miembro)
                                        <div class="equipo-member mb-0" {{ strip_tags($miembro->biografia) !== '' ? 'data-action=toggle-miembro' : '' }} data-miembro="{{ $miembro->id }}">
                                            <div class="equipo-member-name">{{ $miembro->nombre }}</div>
                                        </div>
                                    @endforeach
                                @endisset
                            </div>    
                        </div>
					
                        @if (isset($miembros_agrupados['patronos']) && count($miembros_agrupados['patronos']) > 0)
                            <div class="equipo-title">
                                Patronos fundadores
                            </div>

                            <div class="equipo-wrapper">
                                @isset ($miembros_agrupados['patronos'])
                                    @foreach ($miembros_agrupados['patronos'] as $miembro)
                                        <div class="equipo-member mb-0" {{ strip_tags($miembro->biografia) !== '' ? 'data-action=toggle-miembro' : '' }} data-miembro="{{ $miembro->id }}">
                                            <div class="equipo-member-name">{{ $miembro->nombre }}</div>
                                        </div>
                                    @endforeach
                                @endisset
                            </div>
                        
                        @endif
                   
					</div>
                </div>
            </div>
        </div>

        <div id="casa-apoyos">
            <div class="container">
                <div class="section-title text-center">
                    <span>Apoyos</span>
                </div>

                <style>
                    #casa-apoyos .card p {
                        text-indent: 0 !important;
                    }
                </style>

                <div class="intro-description">
                    <p>Casa Gallina, está constituida como asociación civil sin fines de lucro y cuenta con la autorización de la Secretaría de Hacienda para recibir donativos deducibles. Si bien los patronos fundadores de Casa Gallina aportan una parte importante del financiamiento operativo del proyecto, la búsqueda de apoyos y de aliados para el desarrollo y la implementación de todos los programas es clave para el proyecto. La búsqueda de nuevos aliados, fondos asociados y plataformas con las que desarrollar proyectos colaborativos, son fundamentales para el crecimiento de nuestras acciones y de sus impactos.</p>
                    <div class="row">
                        <!-- Patronos Fundadores Card -->
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-left">
                                    <h5 class="card-title">Patronos Fundadores</h5>
                                    <p class="card-text">Casa Gallina agradece el apoyo de sus patronos fundadores:</p>
                                    <ul class="list-unstyled">
                                        <li><strong>Hans Schoepflin</strong><br>Panta Rhea Fund</li>
                                        <li class="mt-2"><strong>Aimée Labarrère de Servitje</strong></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Asesoría Legal Card -->
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-left">
                                    <h5 class="card-title">Asesoría Legal</h5>
                                    <p class="card-text">Casa Gallina agradece la asesoría legal de:</p>
                                    <ul class="list-unstyled">
                                        <li>Elias Calles Abogados</li>
                                        <li>Graue Abogados</li>
                                        <li>Cristian Valencia Riou</li>
                                        <li>Alejandra González Silva</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- 2021/2022 Programs Card -->
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-left">
                                    <h5 class="card-title">Programas 2021/2022</h5>
                                    <p class="card-text">Para el desarrollo de los programas de 2021/2022 se agradece el apoyo directo de:</p>
                                    <ul class="list-unstyled">
                                        <li>SERVAX BLEU a través del EFIARTES (Estímulo fiscal del artículo 190 de la LISR)</li>
                                        <li class="mt-2">
                                            <a href="https://casagallina.org.mx/estrategia/recreo-la-ciudad-por-donadora/23" target="_blank" style="font-family: 'Playfair Display', serif; color: #68945c; font-weight: bold; text-decoration: none; font-size: 16px;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Campaña de fondeo colectivo: Recreo la ciudad en Donadora</a>
                                        </li>
                                        <li class="mt-2">
                                            <a href="https://casagallina.org.mx/estrategia/campana-de-fondeo-colectivo-rinconcito-de-la-tierra/25" target="_blank" style="font-family: 'Playfair Display', serif; color: #68945c; font-weight: bold; text-decoration: none; font-size: 16px;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Campaña de fondeo colectivo: Rinconcito de la Tierra en Donadora</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- 2023 Programs Card -->
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-left">
                                    <h5 class="card-title">Programas 2023</h5>
                                    <p class="card-text">Para el desarrollo de los programas de 2023 se agradece el apoyo directo de:</p>
                                    <ul class="list-unstyled">
                                        <li>XTRA Congelados Naturales SA de CV a través del EFIARTES (Estímulo fiscal del artículo 190 de la LISR)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- 2024 Programs Card -->
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-left">
                                    <h5 class="card-title">Programas 2024</h5>
                                    <p class="card-text">Para el desarrollo de los programas de 2024 se agradece el apoyo directo de:</p>
                                    <ul class="list-unstyled">
                                        <li>Fundación Coppel a través de su programa Caleidoscopio</li>
                                        <li class="mt-2">
                                            <a href="https://casagallina.org.mx/estrategia/campana-de-fondeo-colectivo-recrea/26" target="_blank" style="font-family: 'Playfair Display', serif; color: #68945c; font-weight: bold; text-decoration: none; font-size: 16px;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Campaña de fondeo colectivo: Recrea</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- 2025 Programs Card -->
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-left">
                                    <h5 class="card-title">Programas 2025</h5>
                                    <p class="card-text">Para el desarrollo de los programas de 2025 se agradece el apoyo directo de:</p>
                                    <ul class="list-unstyled">
                                        <li>Programa de Desarrollo de Arte y Cultura Citibanamex (DAC)</li>
                                        <li class="mt-2">
                                            <a href="https://casagallina.org.mx/donaciones/campaign" target="_blank" style="font-family: 'Playfair Display', serif; color: #68945c; font-weight: bold; text-decoration: none; font-size: 16px;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Campaña de fondeo colectivo: 10 años de trabajo comunitario</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Call to Action Section -->
                    <div class="row mt-5">
                        <div class="col-12">
                            <div class="card" style="background-color: #f8f9fa; border: 2px solid #68945c;">
                                <div class="card-body text-center" style="padding: 2rem;">
                                    <h5 class="card-title" style="color: #68945c; font-size: 1.5rem; margin-bottom: 1rem;">¡Únete a nuestra causa!</h5>
                                    <p class="card-text" style="color: #4e5f61; font-size: 1rem; line-height: 1.5; margin-bottom: 1.5rem;">Casa Gallina es un proyecto que se construye gracias a la suma de voluntades. Con tu generosa contribución podremos seguir construyendo experiencias que puedan contribuir a fortalecer la comunidad y el medio ambiente desde la cultura y la vida cotidiana.</p>
                                    <div class="btn-container">
                                        <a href="https://casagallina.org.mx/donaciones" target="_blank" style="background-color: #68945c; color: white; text-decoration: none; padding: 12px 30px; border-radius: 25px; display: inline-block; font-size: 16px; font-weight: 600; transition: all 0.3s; box-shadow: 0 2px 4px rgba(104, 148, 92, 0.3);" onmouseover="this.style.backgroundColor='#5d8452'; this.style.boxShadow='0 4px 8px rgba(104, 148, 92, 0.4)'" onmouseout="this.style.backgroundColor='#68945c'; this.style.boxShadow='0 2px 4px rgba(104, 148, 92, 0.3)'">
                                            Dona Ahora
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @foreach ($miembros as $miembro)
            <div class="modal fade modal-equipo" tabindex="-1" role="dialog" id="miembro-{{ $miembro->id }}-modal">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <div class="equipo-nombre">{{ $miembro->nombre }}</div>
                            @if ($miembro->titulo !== '')
                                <div class="equipo-subtitulo">{{ $miembro->titulo }}</div>
                            @endif
                            @if ($miembro->biografia !== '')
                                <div class="equipo-biografia">{!! $miembro->biografia !!}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection