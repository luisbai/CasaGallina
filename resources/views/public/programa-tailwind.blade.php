@extends('layouts.boilerplate')

@section('content')
    <div class="programa-index">
        <!-- Banner Section -->
        <section class="programa-banner">
            <img loading="lazy" src="/assets/images/casa/banner.jpg" class="w-full h-auto">
        </section>

        <!-- Intro Section -->
        <section class="pt-2.5">
            <div class="container mx-auto px-4">
                <!-- Section Title -->
                <div class="border-b-2 border-green-600 py-1.5 my-8 mb-4 text-center">
                    <span class="bg-green-600 px-8 py-2 text-white font-serif text-xl leading-6">Programa</span>
                </div>

                <!-- Intro Text -->
                <div class="font-serif text-green-600 text-xl leading-6 text-center py-4 lg:px-28">
                    Casa Gallina desarrolla programas transdisciplinarios que conectan cultura, comunidad y medio ambiente a
                    través de experiencias colectivas de resiliencia, regeneración ecológica y creatividad social en el
                    barrio de Santa María la Ribera.
                </div>

                <!-- Intro Description -->
                <div class="font-serif text-gray-600 text-sm leading-5 py-4 lg:px-28 tracking-wide">
                    <p>Nuestros programas se construyen mediante procesos de intercambio colectivo que involucran a la
                        comunidad local en colaboración con profesionales, artistas, científicos y gestores de diversas
                        disciplinas. Cada programa está diseñado para generar experiencias transformadoras que fortalezcan
                        las redes comunitarias y promuevan el cambio sostenible.</p>
                </div>
            </div>
        </section>

        <!-- Estrategias Section -->
        <section>
            <div class="container mx-auto px-4">
                <!-- Section Title -->
                <div class="border-b-2 border-green-600 py-1.5 my-8 mb-4 text-center">
                    <span class="bg-green-600 px-8 py-2 text-white font-serif text-xl leading-6">Estrategias</span>
                </div>

                <!-- Intro Text -->
                <div class="font-serif text-green-600 text-xl leading-6 text-center py-4 lg:px-28">
                    Desarrollamos estrategias de intervención comunitaria que se adaptan a las necesidades específicas del
                    territorio y sus habitantes.
                </div>

                <!-- Local Strategies -->
                <div class="mt-12">
                    <h3 class="font-sans text-green-600 text-xl leading-6 text-center py-4 mb-0 lg:px-28">Estrategias
                        Locales</h3>
                    <p class="font-serif text-gray-600 text-sm leading-5 py-0 pb-4 mb-1 lg:px-20 tracking-wide mb-4">
                        Iniciativas desarrolladas específicamente para el barrio de Santa María la Ribera, enfocadas en
                        fortalecer las redes vecinales y promover la participación comunitaria en temas de sustentabilidad y
                        cuidado mutuo.
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @forelse ($estrategias_locales as $estrategia)
                            <div class="mb-4">
                                <div class="estrategia-item">
                                    <div class="w-full mb-4 h-75 bg-cover bg-center cursor-pointer"
                                        style="background-image: url('{{ $estrategia->destacada_multimedia?->url }}')"
                                        onclick="window.location = '/estrategia/{{ \Str::slug($estrategia->titulo) }}/{{ $estrategia->id }}'">
                                    </div>
                                    <div class="font-sans text-green-600 text-xl leading-5 tracking-tight text-center mb-2">
                                        <a href="/estrategia/{{ \Str::slug($estrategia->titulo) }}/{{ $estrategia->id }}"
                                            class="text-green-600 hover:no-underline">{{ $estrategia->titulo }}</a>
                                    </div>
                                    <div class="font-sans text-gray-600 text-lg leading-5 tracking-tight text-center mb-6">
                                        {{ $estrategia->fecha }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full">
                                <p class="text-center">No hay estrategias locales disponibles.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- External Strategies -->
                <div class="mt-12">
                    <h3 class="font-sans text-green-600 text-xl leading-6 text-center py-4 mb-0 lg:px-28">Estrategias
                        Externas</h3>
                    <p class="font-serif text-gray-600 text-sm leading-5 py-0 pb-4 mb-1 lg:px-20 tracking-wide mb-4">
                        Colaboraciones con otras comunidades y organizaciones del país que comparten intereses similares,
                        creando redes de intercambio y aprendizaje que trascienden las fronteras territoriales.
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @forelse ($estrategias_externas as $estrategia)
                            <div class="mb-4">
                                <div class="estrategia-item">
                                    <div class="w-full mb-4 h-75 bg-cover bg-center cursor-pointer"
                                        style="background-image: url('{{ $estrategia->destacada_multimedia?->url }}')"
                                        onclick="window.location = '/estrategia/{{ \Str::slug($estrategia->titulo) }}/{{ $estrategia->id }}'">
                                    </div>
                                    <div class="font-sans text-green-600 text-xl leading-5 tracking-tight text-center mb-2">
                                        <a href="/estrategia/{{ \Str::slug($estrategia->titulo) }}/{{ $estrategia->id }}"
                                            class="text-green-600 hover:no-underline">{{ $estrategia->titulo }}</a>
                                    </div>
                                    <div class="font-sans text-gray-600 text-lg leading-5 tracking-tight text-center mb-6">
                                        {{ $estrategia->fecha }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full">
                                <p class="text-center">No hay estrategias externas disponibles.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Read More Links -->
                <div class="text-center mt-4">
                    <a href="/programa/local"
                        class="font-sans text-sm leading-6 tracking-tight text-gray-600 flex flex-col items-center">
                        <span class="flex items-center">
                            Ver todas las estrategias locales
                            <div class="inline-block text-white bg-green-600 h-5 w-5 text-lg rounded-full leading-4 ml-1">+
                            </div>
                        </span>
                    </a>
                    <a href="/programa/externo"
                        class="font-sans text-sm leading-6 tracking-tight text-gray-600 flex flex-col items-center ml-3">
                        <span class="flex items-center">
                            Ver todas las estrategias externas
                            <div class="inline-block text-white bg-green-600 h-5 w-5 text-lg rounded-full leading-4 ml-1">+
                            </div>
                        </span>
                    </a>
                </div>
            </div>
        </section>

        <!-- Exposiciones Section -->
        <section class="mt-12">
            <div class="container mx-auto px-4">
                <!-- Section Title -->
                <div class="border-b-2 border-green-600 py-1.5 my-8 mb-4 text-center">
                    <span class="bg-green-600 px-8 py-2 text-white font-serif text-xl leading-6">Exposiciones</span>
                </div>

                <!-- Intro Text -->
                <div class="font-serif text-green-600 text-xl leading-6 text-center py-4 lg:px-28">
                    Espacios de encuentro y reflexión que visibilizan los procesos comunitarios y las narrativas locales a
                    través del arte y la cultura.
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
                    @forelse ($exposiciones as $exposicion)
                        <div class="mb-4">
                            <div class="exposicion-item">
                                @if($exposicion->multimedia->first())
                                    <div class="w-full mb-4 h-75 bg-cover bg-center cursor-pointer"
                                        style="background-image: url('{{ $exposicion->multimedia->first()?->multimedia?->url }}')"
                                        onclick="window.location = '/exposicion/{{ $exposicion->slug }}'">
                                    </div>
                                @endif
                                <div class="font-sans text-green-600 text-xl leading-5 tracking-tight text-center mb-2">
                                    <a href="/exposicion/{{ $exposicion->slug }}"
                                        class="text-green-600 hover:no-underline">{{ $exposicion->titulo }}</a>
                                </div>
                                <div class="font-sans text-gray-600 text-lg leading-5 tracking-tight text-center mb-6">
                                    {{ $exposicion->fecha }}
                                </div>
                                @if($exposicion->metadatos)
                                    <div class="font-serif text-gray-600 text-sm leading-5 tracking-wide">
                                        {{ \Str::limit(strip_tags($exposicion->metadatos), 100) }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full">
                            <p class="text-center">No hay exposiciones disponibles.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Read More Link -->
                <div class="text-center mt-4">
                    <a href="/exposiciones"
                        class="font-sans text-lg leading-6 tracking-tight text-gray-600 flex flex-col items-center">
                        <span class="flex items-center">
                            Ver todas las exposiciones
                            <div class="inline-block text-white bg-green-600 h-5 w-5 text-2xl rounded-full leading-5 ml-1">+
                            </div>
                        </span>
                    </a>
                </div>
            </div>
        </section>

        <!-- Proyectos Artísticos Section -->
        <section class="mt-12">
            <div class="container mx-auto px-4">
                <!-- Section Title -->
                <div class="border-b-2 border-green-600 py-1.5 my-8 mb-4 text-center">
                    <span class="bg-green-600 px-8 py-2 text-white font-serif text-xl leading-6">Proyectos Artísticos</span>
                </div>

                <!-- Intro Text -->
                <div class="font-serif text-green-600 text-xl leading-6 text-center py-4 lg:px-28">
                    Iniciativas creativas que surgen del diálogo entre artistas y la comunidad, generando obras que reflejan
                    las experiencias y saberes locales.
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
                    @forelse ($proyectos_artisticos as $proyecto)
                        <div class="mb-4">
                            <div class="proyecto-item">
                                @if($proyecto->multimedia->first())
                                    <div class="w-full mb-4 h-75 bg-cover bg-center cursor-pointer"
                                        style="background-image: url('{{ $proyecto->multimedia->first()?->multimedia?->url }}')"
                                        onclick="window.location = '/proyecto-artistico/{{ \Str::slug($proyecto->titulo) }}/{{ $proyecto->id }}'">
                                    </div>
                                @endif
                                <div class="font-sans text-green-600 text-xl leading-5 tracking-tight text-center mb-2">
                                    <a href="/proyecto-artistico/{{ \Str::slug($proyecto->titulo) }}/{{ $proyecto->id }}"
                                        class="text-green-600 hover:no-underline">{{ $proyecto->titulo }}</a>
                                </div>
                                <div class="font-sans text-gray-600 text-lg leading-5 tracking-tight text-center mb-6">
                                    {{ $proyecto->fecha }}
                                </div>
                                @if($proyecto->metadatos)
                                    <div class="font-serif text-gray-600 text-sm leading-5 tracking-wide">
                                        {{ \Str::limit(strip_tags($proyecto->metadatos), 100) }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full">
                            <p class="text-center">No hay proyectos artísticos disponibles.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Read More Link -->
                <div class="text-center mt-4">
                    <a href="/proyectos-artisticos"
                        class="font-sans text-lg leading-6 tracking-tight text-gray-600 flex flex-col items-center">
                        <span class="flex items-center">
                            Ver todos los proyectos artísticos
                            <div class="inline-block text-white bg-green-600 h-5 w-5 text-2xl rounded-full leading-5 ml-1">+
                            </div>
                        </span>
                    </a>
                </div>
            </div>
        </section>
    </div>
@endsection