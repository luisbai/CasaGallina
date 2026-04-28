@extends('layouts.boilerplate')

@section('meta')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection

@section('content')
    <div class="programa-index">

        <div class="w-full h-[35vh] relative">
            <img src="{{ asset('assets/images/casa/banner.jpg') }}" alt="Programa Casa Gallina"
                class="w-full h-full object-cover">
        </div>

        <section class="pt-8">
            <div class="container mx-auto">
                <div class="flex flex-col py-8">
                    <div class="">
                        <div class="text-center border-b-2 border-green-600 pb-2 mb-2">
                            <span class="bg-green-600 px-8 py-2 text-white font-serif text-2xl leading-4">Programa</span>
                        </div>
                        <div class="font-serif text-green-600 text-xl leading-6 py-4 md:px-16 pb-2 text-center">
                            Casa Gallina desarrolla programas transdisciplinarios que conectan cultura, comunidad y medio
                            ambiente a través de experiencias colectivas de resiliencia, regeneración ecológica y
                            creatividad social en el barrio de Santa María la Ribera.
                        </div>
                        <div class="font-libre text-gray-600 leading-5 py-2 md:px-16 tracking-wide space-y-2">
                            <p>Nuestros programas se construyen mediante procesos de intercambio colectivo que involucran a
                                la comunidad local en colaboración con profesionales, artistas, científicos y gestores de
                                diversas disciplinas.</p>
                            <p>Cada programa está diseñado para generar experiencias transformadoras que fortalezcan las
                                redes comunitarias y promuevan el cambio sostenible.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-8">
            <div class="container mx-auto">
                <div class="text-center border-b-2 border-green-600 pb-2 mb-6">
                    <span class="bg-green-600 px-8 py-2 text-white font-serif text-2xl leading-4">Programa local</span>
                </div>

                <div class="relative mb-12" x-data="{
                        currentIndex: 0,
                        itemsPerPage: window.innerWidth >= 1024 ? 3 : (window.innerWidth >= 768 ? 2 : 1),
                        totalItems: {{ $estrategias_locales_tags->count() }},
                        get totalSlides() { return Math.ceil(this.totalItems / this.itemsPerPage) },
                        get translateX() { return -(this.currentIndex * (100 / this.itemsPerPage)) },
                        next() { if (this.currentIndex < this.totalSlides - 1) this.currentIndex++ },
                        prev() { if (this.currentIndex > 0) this.currentIndex-- }
                    }" x-init="window.addEventListener('resize', () => { itemsPerPage = window.innerWidth >= 1024 ? 3 : (window.innerWidth >= 768 ? 2 : 1) })">
                    
                    <div class="overflow-hidden">
                        <div class="flex transition-transform duration-500 ease-in-out" :style="`transform: translateX(${translateX}%)`">
                            @foreach($estrategias_locales_tags as $tag)
                                <div class="w-full md:w-1/2 lg:w-1/3 flex-shrink-0 px-3">
                                    <a href="{{ route('programa.estrategia-local.detalle', $tag->slug) }}" class="block text-center hover:opacity-80">
                                        <div class="mb-3 h-64">
                                            <img src="{{ $tag->thumbnail ? asset('storage/' . $tag->thumbnail->filename) : asset('assets/images/logo.png') }}" class="w-full h-full object-cover">
                                        </div>
                                        <h3 class="font-sans text-green-600 text-xl">{{ $tag->nombre }}</h3>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <button @click="prev()" x-show="currentIndex > 0" class="absolute -left-4 top-1/2 -translate-y-1/2 bg-green-600 p-3 rounded-full text-white z-10">←</button>
                    <button @click="next()" x-show="currentIndex < totalSlides - 1" class="absolute -right-4 top-1/2 -translate-y-1/2 bg-green-600 p-3 rounded-full text-white z-10">→</button>
                </div>
            </div>
        </section>

        <section class="py-8 bg-gray-50">
            <div class="container mx-auto">
                <div class="text-center border-b-2 border-green-600 pb-2 mb-6">
                    <span class="bg-green-600 px-8 py-2 text-white font-serif text-2xl leading-4">Exposiciones</span>
                </div>

                @if($exposiciones->count() > 0)
                    <div class="relative" x-data="{ currentIndex: 0, itemsPerPage: window.innerWidth >= 1024 ? 3 : 1, totalItems: {{ $exposiciones->count() }}, get totalSlides() { return Math.ceil(this.totalItems / this.itemsPerPage) } }">
                        <div class="overflow-hidden">
                            <div class="flex transition-transform duration-500" :style="`transform: translateX(-${currentIndex * (100 / itemsPerPage)}%)`">
                                @foreach($exposiciones as $exposicion)
                                    <div class="w-full md:w-1/3 flex-shrink-0 px-3">
                                        <a href="{{ route('exposicion', $exposicion->slug) }}" class="block text-center">
                                            <div class="mb-3 h-64">
                                                @php $media = $exposicion->multimedia->first(); @endphp
                                                <img src="{{ ($media && $media->multimedia) ? asset('storage/' . $media->multimedia->filename) : asset('assets/images/logo.png') }}" class="w-full h-full object-cover">
                                            </div>
                                            <h3 class="text-gray-600 font-bold">{!! strip_tags($exposicion->titulo) !!}</h3>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
                <div class="text-center mt-6">
                    <a href="{{ route('exposiciones') }}" class="inline-block bg-gray-600 text-white px-6 py-2">Ver todas</a>
                </div>
            </div>
        </section>

        <section class="py-12">
            <div class="container mx-auto">
                <div class="text-center border-b-2 border-red-600 pb-2 mb-6">
                    <span class="bg-red-600 px-8 py-2 text-white font-serif text-2xl leading-4">Proyectos artísticos</span>
                </div>

                @if($proyectos_artisticos->count() > 0)
                    <div class="relative" x-data="{ currentIndex: 0, totalItems: {{ $proyectos_artisticos->count() }}, itemsPerPage: window.innerWidth >= 1024 ? 3 : 1 }">
                        <div class="overflow-hidden">
                            <div class="flex transition-transform duration-500" :style="`transform: translateX(-${currentIndex * (100 / itemsPerPage)}%)`">
                                @foreach($proyectos_artisticos as $proyecto)
                                    <div class="w-full md:w-1/3 flex-shrink-0 px-3">
                                        <a href="{{ route('proyecto-artistico', [\Str::slug($proyecto->titulo), $proyecto->id]) }}" class="block text-center">
                                            <div class="mb-3 h-64">
                                                @php $pMedia = $proyecto->multimedia->first(); @endphp
                                                <img src="{{ ($pMedia && $pMedia->multimedia) ? asset('storage/' . $pMedia->multimedia->filename) : asset('assets/images/logo.png') }}" class="w-full h-full object-cover">
                                            </div>
                                            <h3 class="text-red-600 font-bold">{!! strip_tags($proyecto->titulo) !!}</h3>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
                <div class="text-center mt-8">
                    <a href="{{ route('proyectos-artisticos') }}" class="inline-block bg-red-600 text-white px-6 py-2">Ver más proyectos</a>
                </div>
            </div>
        </section>

    </div>
@endsection