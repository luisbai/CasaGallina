<div>
    <!-- Header Sections -->
    <section class="pt-8">
        <div class="container mx-auto">
            <div class="flex flex-col py-8">
                <!-- Section Title -->
                <div class="text-center border-b-2 border-green-600 pb-2 mb-2">
                    <span class="bg-green-600 px-8 py-2 text-white font-serif text-2xl leading-4">
                        {{ $language === 'en' ? 'Cartography' : 'Cartografía' }}
                    </span>
                </div>

                <!-- Intro Text -->
                <div class="font-serif text-green-600 text-xl leading-6 py-4 md:px-16 pb-2 text-center">
                    @if($language === 'en')
                        Casa Gallina works to build and strengthen alliance networks with collectives, individuals, civil associations, and public and private institutions with shared interests. Through various formats and collaboration frameworks, collaborative processes are built that weave networks to share resources, strategies, and methodologies.
                    @else
                        Casa Gallina trabaja en construir y fortalecer redes de alianzas con colectivos, individuos, asociaciones civiles e instituciones públicas y privadas con los que existen intereses compartidos. En diversos formatos y marcos de colaboración se construyen procesos de colaboración que tejen redes para compartir recursos, estrategias y metodologías.
                    @endif
                </div>

                <!-- Description Text -->
                <div class="font-libre text-gray-600 leading-5 py-2 md:px-16 tracking-wide space-y-2">
                    @if($language === 'en')
                        <p>The different alliances are built to activate processes and actions around critical narratives with the aim of activating collective experiences on ecology, resilience, community articulation and creativity in daily life.</p>
                        <p>The collaboration network is built through the implementation of Casa Gallina's strategies and programs that constantly have allies of very diverse nature. This network is deepened through the creation of new programs and work formats in co-participation with the agents and organizations with which we collaborate. In search of constant expansion, the network is open to constantly integrate new organizations, collectives and institutions that share interests in creating projects for the common good, culture, community and the environment.</p>
                    @else
                        <p>Las distintas alianzas se construyen para activar procesos y acciones en torno a narrativas críticas con el fin de activar experiencias colectivas sobre ecología, resiliencia, articulación comunitaria y creatividad en la vida cotidiana.</p>
                        <p>La red de colaboración se construye a través de la implementación de las estrategias y programas de Casa Gallina que constantemente cuentan con aliados de muy diversa índole. Esta red se profundiza a través de la creación de nuevos programas y formatos de trabajo en coparticipación con los agentes y organizaciones con las que se colabora. En búsqueda de expansión constante la red está abierta para integrar constantemente nuevas organizaciones, colectivos e instituciones que compartan los intereses por crear proyectos a favor del bien común, la cultura, la comunidad y el medio ambiente.</p>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Map and Info Panel Grid -->
    <section class="pb-8">
        <div class="container mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Map Container (9/12 on desktop) -->
                <div class="lg:col-span-9">
                    <div id="cartografia-map" wire:ignore class="h-[600px] lg:h-[700px] rounded-lg overflow-hidden"></div>

                    <!-- Legend/References for mobile -->
                    <div id="cartografia-referencias" class="lg:hidden mt-4 p-4 bg-green-600 bg-opacity-50 rounded-lg">
                        <div class="cartografia-marker mb-2">
                            <img src="/assets/images/casa/marker-red.png" class="inline-block mr-2" alt="Red marker">
                            <span class="text-green-600 font-serif text-xl">{{ $language === 'en' ? 'Allies' : 'Aliados' }}</span>
                        </div>
                        <div class="cartografia-marker">
                            <img src="/assets/images/casa/marker-orange.png" class="inline-block mr-2" alt="Orange marker">
                            <span class="text-green-600 font-serif text-xl">{{ $language === 'en' ? 'Related initiatives' : 'Iniciativas afines' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Info Panel (3/12 on desktop) -->
                <div class="lg:col-span-3">
                    <div class="sticky top-4">
                        <!-- Legend/References for desktop -->
                        <div class="hidden lg:block mb-6 p-4 bg-black bg-opacity-50 rounded-lg">
                            <div class="cartografia-marker mb-2">
                                <img src="/assets/images/casa/marker-red.png" class="inline-block mr-2" alt="Red marker">
                                <span class="text-white text-sm">{{ $language === 'en' ? 'Allies' : 'Aliados' }}</span>
                            </div>
                            <div class="cartografia-marker">
                                <img src="/assets/images/casa/marker-orange.png" class="inline-block mr-2" alt="Orange marker">
                                <span class="text-white text-sm">{{ $language === 'en' ? 'Related initiatives' : 'Iniciativas afines' }}</span>
                            </div>
                        </div>

                        <!-- Info Panel Content -->
                        <div class="cartografia-info-panel">
                            @if($selectedEspacio)
                                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                                    <!-- Header with status color -->
                                    <div class="p-4 text-white {{ $selectedEspacio['status'] === 'activo' ? 'bg-red-600' : 'bg-orange-500' }}">
                                        <h3 class="font-serif text-lg font-semibold mb-1">
                                            {{ $selectedEspacio['nombre'] }}
                                        </h3>
                                        @if($selectedEspacio['ubicacion'])
                                            <p class="text-sm opacity-90">{{ $selectedEspacio['ubicacion'] }}</p>
                                        @endif
                                    </div>

                                    <!-- Content -->
                                    <div class="p-4">
                                        @if($selectedEspacio['url'])
                                            <div class="mb-3">
                                                <a href="{{ $selectedEspacio['url'] }}" target="_blank"
                                                   class="inline-flex items-center text-green-600 hover:text-green-700 font-medium text-sm">
                                                    {{ $language === 'en' ? 'Visit website' : 'Visitar sitio web' }}
                                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                                    </svg>
                                                </a>
                                            </div>
                                        @endif

                                        @if($selectedEspacio['estrategias'] && count($selectedEspacio['estrategias']) > 0)
                                            <div>
                                                <h4 class="font-medium text-gray-900 mb-2 text-sm">
                                                    {{ $language === 'en'
                                                        ? (count($selectedEspacio['estrategias']) === 1 ? 'Collaboration strategy' : 'Collaboration strategies')
                                                        : (count($selectedEspacio['estrategias']) === 1 ? 'Estrategia de colaboración' : 'Estrategias de colaboración')
                                                    }}
                                                </h4>
                                                <div class="space-y-2">
                                                    @foreach($selectedEspacio['estrategias'] as $estrategia)
                                                        <div class="text-sm">
                                                            @if($estrategia['url'])
                                                                @php
                                                                    $estrategiaUrl = $language === 'en' ? $estrategia['url']['en'] : $estrategia['url']['es'];
                                                                    $estrategiaTitle = $language === 'en' ? $estrategia['titulo_en'] : $estrategia['titulo'];
                                                                @endphp
                                                                <a href="{{ $estrategiaUrl }}"
                                                                   class="text-gray-700 hover:text-green-600 border-l-2 border-green-200 pl-2 block transition-colors">
                                                                    {{ $estrategiaTitle }}
                                                                </a>
                                                            @else
                                                                <div class="text-gray-700 border-l-2 border-green-200 pl-2">
                                                                    {{ $language === 'en' ? $estrategia['titulo_en'] : $estrategia['titulo'] }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <!-- Default message when no marker is selected -->
                                <div class="bg-gray-50 rounded-lg p-6 text-center">
                                    <div class="text-gray-400 mb-3">
                                        <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-gray-600 text-sm">
                                        {{ $language === 'en'
                                            ? 'Click on a marker to see information about the space and collaboration strategies.'
                                            : 'Haz clic en un marcador para ver información sobre el espacio y las estrategias de colaboración.'
                                        }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Hidden data for JavaScript -->
    <script type="application/json" id="espacios-data">
        @json($espacios)
    </script>
</div>