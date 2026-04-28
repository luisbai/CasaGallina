@extends('layouts.boilerplate')

@section('meta')
    <!-- add alpinejs -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection

@section('content')
    <div class="programa-index">

        <div class="w-full h-[35vh] relative">
            <img src="{{ asset('assets/images/casa/banner.jpg') }}" alt="Programa Casa Gallina"
                class="w-full h-full object-cover">
        </div>

        <!-- Intro Section -->
        <section class="pt-8">
            <div class="container mx-auto">

                <!-- Two Column Layout -->
                <div class="flex flex-col py-8">

                    <!-- Right Column - Content -->
                    <div class="">
                        <!-- Section Title -->
                        <div class="text-center border-b-2 border-green-600 pb-2 mb-2">
                            <span class="bg-green-600 px-8 py-2 text-white font-serif text-2xl leading-4">Programa</span>
                        </div>
                        <!-- Intro Text -->
                        <div class="font-serif text-green-600 text-xl leading-6 py-4 md:px-16 pb-2 text-center">
                            Casa Gallina desarrolla programas transdisciplinarios que conectan cultura, comunidad y medio
                            ambiente a través de experiencias colectivas de resiliencia, regeneración ecológica y
                            creatividad social en el barrio de Santa María la Ribera.
                        </div>

                        <!-- Intro Description -->
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

        <!-- Estrategias Section -->
        <section class="">
            <div class="container mx-auto">
                <div class="flex flex-col py-8 gap-6">
                    <div class="flex flex-col">
                        <!-- Section Title -->
                        <div class="text-center border-b-2 border-green-600 pb-2 mb-2">
                            <span class="bg-green-600 px-8 py-2 text-white font-serif text-2xl leading-4">Programa
                                local</span>
                        </div>
                        <!-- Intro Text -->
                        <div class="font-serif text-green-600 text-xl leading-6 py-4 md:px-16 pb-2 text-center">
                            Desarrollamos estrategias de intervención comunitaria que se adaptan a las necesidades
                            específicas del territorio y sus habitantes.
                        </div>

                        <!-- Intro Description -->
                        <div class="font-libre text-gray-600 leading-5 py-2 md:px-16 tracking-wide space-y-2">
                            <p>Nuestras estrategias se dividen en dos enfoques complementarios: locales y externas, cada una
                                diseñada para crear impacto significativo en diferentes escalas territoriales.</p>
                        </div>
                    </div>

                    <div class="relative mb-12" x-data="{
                            currentIndex: 0,
                            itemsPerPage: window.innerWidth >= 1024 ? 3 : (window.innerWidth >= 768 ? 2 : 1),
                            totalItems: {{ $estrategias_locales_tags->count() }},
                            get totalSlides() { return Math.ceil(this.totalItems / this.itemsPerPage) },
                            get canGoNext() { return this.currentIndex < this.totalSlides - 1 },
                            get canGoPrev() { return this.currentIndex > 0 },
                            get translateX() { return -(this.currentIndex * (100 / this.itemsPerPage)) },
                            next() { if (this.canGoNext) this.currentIndex++ },
                            prev() { if (this.canGoPrev) this.currentIndex-- },
                            goToSlide(index) { this.currentIndex = index },
                            updateItemsPerPage() {
                                const oldItemsPerPage = this.itemsPerPage;
                                this.itemsPerPage = window.innerWidth >= 1024 ? 3 : (window.innerWidth >= 768 ? 2 : 1);
                                if (oldItemsPerPage !== this.itemsPerPage) {
                                    this.currentIndex = Math.min(this.currentIndex, this.totalSlides - 1);
                                }
                            }
                        }" x-init="
                            updateItemsPerPage();
                            window.addEventListener('resize', () => updateItemsPerPage());
                        ">
                        <!-- Carousel Container -->
                        <div class="overflow-hidden">
                            <div class="flex transition-transform duration-500 ease-in-out"
                                :style="`transform: translateX(${translateX}%)`">
                                @foreach($estrategias_locales_tags as $tag)
                                    <div class="w-full md:w-1/2 lg:w-1/3 flex-shrink-0 px-3">
                                        <a href="{{ route('programa.estrategia-local.detalle', $tag->slug) }}"
                                            class="block text-center hover:opacity-80 transition-opacity duration-300">
                                            <div class="mb-3 h-64">
                                                @if($tag->thumbnail)
                                                    <img src="{{ asset('storage/' . $tag->thumbnail->filename) }}"
                                                        alt="{{ $tag->nombre }}" class="w-full h-full object-cover">
                                                @elseif($tag->multimedia)
                                                    <img src="{{ asset('storage/' . $tag->multimedia->filename) }}"
                                                        alt="{{ $tag->nombre }}" class="w-full h-full object-cover">
                                                @else
                                                    <img src="{{ asset('assets/images/logo.png') }}" alt="{{ $tag->nombre }}"
                                                        class="w-full h-full object-cover">
                                                @endif
                                            </div>
                                            <h3 class="font-sans text-green-600 !text-xl leading-5 tracking-tight mb-2">
                                                {{ $tag->nombre }}</h3>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Navigation Buttons -->
                        <button @click="prev()" x-show="canGoPrev"
                            class="absolute -left-6 top-26 bg-green-600 hover:bg-green-700 shadow-lg rounded-full p-3 transition-colors duration-200 z-10">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>

                        <button @click="next()" x-show="canGoNext"
                            class="absolute -right-6 top-26 bg-green-600 hover:bg-green-700 shadow-lg rounded-full p-3 transition-colors duration-200 z-10">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>

                        <!-- Dots Indicator -->
                        <div class="absolute -bottom-4 left-1/2 -translate-x-1/2 translate-y-4 flex justify-center gap-3"
                            x-show="totalSlides > 1">
                            <template x-for="(slide, index) in Array.from({length: totalSlides}, (_, i) => i)" :key="index">
                                <button @click="goToSlide(index)"
                                    class="w-3 h-3 rounded-full transition-colors duration-200"
                                    :class="currentIndex === index ? 'bg-green-600' : 'bg-gray-400 hover:bg-gray-500'">
                                </button>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Estrategias Externas Section -->
        <section class="">
            <div class="container mx-auto">
                <div class="flex flex-col py-8 gap-6">
                    <div class="flex flex-col">
                        <!-- Section Title -->
                        <div class="text-center border-b-2 border-green-600 pb-2 mb-2">
                            <span class="bg-green-600 px-8 py-2 text-white font-serif text-2xl leading-4">Programa
                                externo</span>
                        </div>
                        <!-- Intro Text -->
                        <div class="font-serif text-green-600 text-xl leading-6 py-4 md:px-16 pb-2 text-center">
                            Iniciativas que trascienden los límites del barrio para generar redes de colaboración y
                            intercambio con otras comunidades y territorios.
                        </div>

                        <!-- Intro Description -->
                        <div class="font-libre text-gray-600 leading-5 py-2 md:px-16 tracking-wide space-y-2">
                            <p>Las estrategias externas amplían el alcance de nuestro trabajo, creando puentes entre
                                diferentes contextos y fortaleciendo la red de colaboradores que comparten nuestra visión de
                                transformación social.</p>
                        </div>
                    </div>

                    <div class="relative mb-12" x-data="{
                            currentIndex: 0,
                            itemsPerPage: window.innerWidth >= 1024 ? 3 : (window.innerWidth >= 768 ? 2 : 1),
                            totalItems: {{ $estrategias_externas_tags->count() }},
                            get totalSlides() { return Math.ceil(this.totalItems / this.itemsPerPage) },
                            get canGoNext() { return this.currentIndex < this.totalSlides - 1 },
                            get canGoPrev() { return this.currentIndex > 0 },
                            get translateX() { return -(this.currentIndex * (100 / this.itemsPerPage)) },
                            next() { if (this.canGoNext) this.currentIndex++ },
                            prev() { if (this.canGoPrev) this.currentIndex-- },
                            goToSlide(index) { this.currentIndex = index },
                            updateItemsPerPage() {
                                const oldItemsPerPage = this.itemsPerPage;
                                this.itemsPerPage = window.innerWidth >= 1024 ? 3 : (window.innerWidth >= 768 ? 2 : 1);
                                if (oldItemsPerPage !== this.itemsPerPage) {
                                    this.currentIndex = Math.min(this.currentIndex, this.totalSlides - 1);
                                }
                            }
                        }" x-init="
                            updateItemsPerPage();
                            window.addEventListener('resize', () => updateItemsPerPage());
                        ">
                        <!-- Carousel Container -->
                        <div class="overflow-hidden">
                            <div class="flex transition-transform duration-500 ease-in-out"
                                :style="`transform: translateX(${translateX}%)`">
                                @foreach($estrategias_externas_tags as $tag)
                                    <div class="w-full md:w-1/2 lg:w-1/3 flex-shrink-0 px-3">
                                        <a href="{{ route('programa.estrategia-externa.detalle', $tag->slug) }}"
                                            class="block text-center hover:opacity-80 transition-opacity duration-300">
                                            <div class="mb-3 h-64">
                                                @if($tag->thumbnail)
                                                    <img src="{{ asset('storage/' . $tag->thumbnail->filename) }}"
                                                        alt="{{ $tag->nombre }}" class="w-full h-full object-cover">
                                                @elseif($tag->multimedia)
                                                    <img src="{{ asset('storage/' . $tag->multimedia->filename) }}"
                                                        alt="{{ $tag->nombre }}" class="w-full h-full object-cover">
                                                @else
                                                    <img src="{{ asset('assets/images/logo.png') }}" alt="{{ $tag->nombre }}"
                                                        class="w-full h-full object-cover">
                                                @endif
                                            </div>
                                            <h3 class="font-sans text-green-600 !text-xl leading-5 tracking-tight mb-2">
                                                {{ $tag->nombre }}</h3>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Navigation Buttons -->
                        <button @click="prev()" x-show="canGoPrev"
                            class="absolute -left-6 top-26 bg-green-600 hover:bg-green-700 shadow-lg rounded-full p-3 transition-colors duration-200 z-10">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>

                        <button @click="next()" x-show="canGoNext"
                            class="absolute -right-6 top-26 bg-green-600 hover:bg-green-700 shadow-lg rounded-full p-3 transition-colors duration-200 z-10">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>

                        <!-- Dots Indicator -->
                        <div class="absolute -bottom-4 left-1/2 -translate-x-1/2 translate-y-4 flex justify-center gap-3"
                            x-show="totalSlides > 1">
                            <template x-for="(slide, index) in Array.from({length: totalSlides}, (_, i) => i)" :key="index">
                                <button @click="goToSlide(index)"
                                    class="w-3 h-3 rounded-full transition-colors duration-200"
                                    :class="currentIndex === index ? 'bg-green-600' : 'bg-gray-400 hover:bg-gray-500'">
                                </button>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Exposiciones Section -->
        <section class="">
            <div class="container mx-auto">
                <div class="flex flex-col py-8 gap-6">
                    <div class="flex flex-col">
                        <!-- Section Title -->
                        <div class="text-center border-b-2 border-green-600 pb-2 mb-2">
                            <span class="bg-green-600 px-8 py-2 text-white font-serif text-2xl leading-4">Exposiciones</span>
                        </div>
                        <!-- Intro Text -->
                        <div class="font-serif text-green-600 text-xl leading-6 py-4 md:px-16 pb-2 text-center">
                        Montajes abiertos al público donde se presentan procesos de investigación y creación desarrollados por
                         artistas en diálogo con investigaciones científicas sobre temas de la vida cotidiana. Funcionan como
                          espacios de encuentro que articulan reflexión, experiencia estética y conversación.
                        </div>

                        <!-- Intro Description -->
                        <div class="font-libre text-gray-600 leading-5 py-2 md:px-16 tracking-wide space-y-2">
                            <p>A través de las muestras y de un programa público de actividades, las exposiciones abordan temas
                                 vinculados con el territorio, la ecología, la memoria y la vida comunitaria, propiciando
                                  lecturas críticas y sensibles sobre el contexto que habitamos.</p>

                            
                        </div>
                    </div>

                    @if($exposiciones->count() > 0)
                        <div class="relative mb-12" x-data="{
                                currentIndex: 0,
                                itemsPerPage: window.innerWidth >= 1024 ? 3 : (window.innerWidth >= 768 ? 2 : 1),
                                totalItems: {{ $exposiciones->count() }},
                                get totalSlides() { return Math.ceil(this.totalItems / this.itemsPerPage) },
                                get canGoNext() { return this.currentIndex < this.totalSlides - 1 },
                                get canGoPrev() { return this.currentIndex > 0 },
                                get translateX() { return -(this.currentIndex * (100 / this.itemsPerPage)) },
                                next() { if (this.canGoNext) this.currentIndex++ },
                                prev() { if (this.canGoPrev) this.currentIndex-- },
                                goToSlide(index) { this.currentIndex = index },
                                updateItemsPerPage() {
                                    const oldItemsPerPage = this.itemsPerPage;
                                    this.itemsPerPage = window.innerWidth >= 1024 ? 3 : (window.innerWidth >= 768 ? 2 : 1);
                                    if (oldItemsPerPage !== this.itemsPerPage) {
                                        this.currentIndex = Math.min(this.currentIndex, this.totalSlides - 1);
                                    }
                                }
                            }" x-init="
                                updateItemsPerPage();
                                window.addEventListener('resize', () => updateItemsPerPage());
                            ">
                            <!-- Carousel Container -->
                            <div class="overflow-hidden">
                                <div class="flex transition-transform duration-500 ease-in-out"
                                    :style="`transform: translateX(${translateX}%)`">
                                    @foreach($exposiciones as $exposicion)
                                        <div class="w-full md:w-1/2 lg:w-1/3 flex-shrink-0 px-3">
                                            <a href="{{ route('exposicion', $exposicion->slug) }}"
                                                class="block text-center hover:opacity-80 transition-opacity duration-300">
                                                <div class="mb-3 h-64">
                                                    @if($exposicion->multimedia->first() && $exposicion->multimedia->first()->multimedia)
                                                        <img src="{{ asset('storage/' . $exposicion->multimedia->first()->multimedia->filename) }}"
                                                            alt="{{ $exposicion->titulo }}" class="w-full h-full object-cover">
                                                    @else
                                                        <img src="{{ asset('images/no-image.svg') }}" alt="{{ $exposicion->titulo }}" class="w-full h-full object-cover">
                                                    @endif
                                                </div>
                                                <h3 class="font-sans text-gray-600 !text-xl leading-5 tracking-tight mb-2">
                                                    {!! str_replace(['<p>', '</p>'], '', $exposicion->titulo) !!}
                                                </h3>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Navigation Buttons -->
                            <button @click="prev()" x-show="canGoPrev"
                                class="absolute -left-6 top-26 bg-gray-600 hover:bg-gray-700 shadow-lg rounded-full p-3 transition-colors duration-200 z-10">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>

                            <button @click="next()" x-show="canGoNext"
                                class="absolute -right-6 top-26 bg-gray-600 hover:bg-gray-700 shadow-lg rounded-full p-3 transition-colors duration-200 z-10">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>

                            <!-- Dots Indicator -->
                            <div class="absolute -bottom-4 left-1/2 -translate-x-1/2 translate-y-4 flex justify-center gap-3"
                                x-show="totalSlides > 1">
                                <template x-for="(slide, index) in Array.from({length: totalSlides}, (_, i) => i)" :key="index">
                                    <button @click="goToSlide(index)"
                                        class="w-3 h-3 rounded-full transition-colors duration-200"
                                        :class="currentIndex === index ? 'bg-gray-600' : 'bg-gray-400 hover:bg-gray-500'">
                                    </button>
                                </template>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="font-libre text-gray-500">Próximamente nuevas exposiciones</p>
                        </div>
                    @endif

                    <!-- Read More Link -->
                    <div class="text-center mt-4">
                        <a href="{{ route('exposiciones') }}"
                            class="font-libre text-lg leading-6 tracking-tight !text-gray-50 !bg-gray-600 px-4 py-2.5 hover:!bg-gray-600/90 transition-all duration-300 inline-flex items-center justify-center hover:!no-underline">
                            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            Ver todas las exposiciones
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Proyectos Artísticos Section -->
        <section class="">
            <div class="container mx-auto">
                <div class="flex flex-col py-8 gap-6">
                    <div class="flex flex-col">
                        <!-- Section Title -->
                        <div class="text-center border-b-2 border-green-600 pb-2 mb-2">
                            <span class="bg-red-600 px-8 py-2 text-white font-serif text-2xl leading-4">Proyectos
                                artísticos</span>
                        </div>
                        <!-- Intro Text -->
                        <div class="font-serif text-green-600 text-xl leading-6 py-4 md:px-16 pb-2 text-center">
                        Procesos de investigación y creación desarrollados en colaboración con artistas invitados.
                         Se construyen en diálogo con comunidades específicas, ya sea del barrio o de otros territorios
                          con los que el artista mantiene un vínculo significativo.
                        </div>

                        <!-- Intro Description -->
                        <div class="font-libre text-gray-600 leading-5 py-2 md:px-16 tracking-wide space-y-2">
                            <p>Más allá de la producción de obra, estos proyectos priorizan el proceso, el intercambio y
                                 la experimentación, integrando metodologías participativas que fortalecen la relación
                                  entre práctica artística, territorio y comunidad.</p>

                            
                        </div>
                    </div>

                    @if($proyectos_artisticos->count() > 0)
                        <div class="relative mb-12" x-data="{
                                currentIndex: 0,
                                itemsPerPage: window.innerWidth >= 1024 ? 3 : (window.innerWidth >= 768 ? 2 : 1),
                                totalItems: {{ $proyectos_artisticos->count() }},
                                get totalSlides() { return Math.ceil(this.totalItems / this.itemsPerPage) },
                                get canGoNext() { return this.currentIndex < this.totalSlides - 1 },
                                get canGoPrev() { return this.currentIndex > 0 },
                                get translateX() { return -(this.currentIndex * (100 / this.itemsPerPage)) },
                                next() { if (this.canGoNext) this.currentIndex++ },
                                prev() { if (this.canGoPrev) this.currentIndex-- },
                                goToSlide(index) { this.currentIndex = index },
                                updateItemsPerPage() {
                                    const oldItemsPerPage = this.itemsPerPage;
                                    this.itemsPerPage = window.innerWidth >= 1024 ? 3 : (window.innerWidth >= 768 ? 2 : 1);
                                    if (oldItemsPerPage !== this.itemsPerPage) {
                                        this.currentIndex = Math.min(this.currentIndex, this.totalSlides - 1);
                                    }
                                }
                            }" x-init="
                                updateItemsPerPage();
                                window.addEventListener('resize', () => updateItemsPerPage());
                            ">
                            <!-- Carousel Container -->
                            <div class="overflow-hidden">
                                <div class="flex transition-transform duration-500 ease-in-out"
                                    :style="`transform: translateX(${translateX}%)`">
                                    @foreach($proyectos_artisticos as $proyecto)
                                        <div class="w-full md:w-1/2 lg:w-1/3 flex-shrink-0 px-3">
                                            <a href="{{ route('proyecto-artistico', [\Str::slug($proyecto->titulo), $proyecto->id]) }}"
                                                class="block text-center hover:opacity-80 transition-opacity duration-300">
                                                <div class="mb-3 h-64">
                                                    @if($proyecto->multimedia->first() && $proyecto->multimedia->first()->multimedia)
                                                        <img src="{{ asset('storage/' . $proyecto->multimedia->first()->multimedia->filename) }}"
                                                            alt="{{ $proyecto->titulo }}" class="w-full h-full object-cover">
                                                    @else
                                                    <img src="{{ asset('images/no-image.svg') }}" alt="{{ $tag->nombre }}" class="w-full h-full object-cover">
                                                 @endif
                                                </div>
                                                <h3 class="font-sans text-red-600 !text-xl leading-5 tracking-tight mb-2">
                                                    {!! str_replace(['<p>', '</p>'], '', $proyecto->titulo) !!}
                                                </h3>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Navigation Buttons -->
                            <button @click="prev()" x-show="canGoPrev"
                                class="absolute -left-6 top-26 bg-red-600 hover:bg-red-700 shadow-lg rounded-full p-3 transition-colors duration-200 z-10">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>

                            <button @click="next()" x-show="canGoNext"
                                class="absolute -right-6 top-26 bg-red-600 hover:bg-red-700 shadow-lg rounded-full p-3 transition-colors duration-200 z-10">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>

                            <!-- Dots Indicator -->
                            <div class="absolute -bottom-4 left-1/2 -translate-x-1/2 translate-y-4 flex justify-center gap-3"
                                x-show="totalSlides > 1">
                                <template x-for="(slide, index) in Array.from({length: totalSlides}, (_, i) => i)" :key="index">
                                    <button @click="goToSlide(index)"
                                        class="w-3 h-3 rounded-full transition-colors duration-200"
                                        :class="currentIndex === index ? 'bg-red-600' : 'bg-gray-400 hover:bg-gray-500'">
                                    </button>
                                </template>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="font-libre text-gray-500">Próximamente nuevos proyectos artísticos</p>
                        </div>
                    @endif

                    <!-- Read More Link -->
                    <div class="text-center mt-4">
                        <a href="{{ route('proyectos-artisticos') }}"
                            class="font-libre text-lg leading-6 tracking-tight !text-gray-50 !bg-red-600 px-4 py-2.5 hover:!bg-red-600/90 transition-all duration-300 inline-flex items-center justify-center hover:!no-underline">
                            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            Ver todos los proyectos artísticos
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection