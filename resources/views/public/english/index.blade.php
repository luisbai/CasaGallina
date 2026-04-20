@extends('layouts.english.boilerplate')

@section('content')
    <div id="home-index">
        @if($banners && $banners->count() > 0)
            <!-- Custom Banner Slider -->
            <section id="home-banner-slider" class="relative" x-data="{ 
                                activeSlide: 0, 
                                totalSlides: {{ $banners->count() }},
                                autoplayInterval: null,
                                intervalDuration: 5000,
                                startAutoplay() {
                                    this.autoplayInterval = setInterval(() => {
                                        this.nextSlide();
                                    }, this.intervalDuration);
                                },
                                stopAutoplay() {
                                    clearInterval(this.autoplayInterval);
                                },
                                nextSlide() {
                                    this.activeSlide = (this.activeSlide + 1) % this.totalSlides;
                                },
                                prevSlide() {
                                    this.activeSlide = (this.activeSlide - 1 + this.totalSlides) % this.totalSlides;
                                }
                            }" x-init="startAutoplay()" @mouseenter="stopAutoplay()" @mouseleave="startAutoplay()">

                <div class="grid grid-cols-1 grid-rows-1">
                    @foreach($banners as $index => $banner)
                        <div class="col-start-1 row-start-1 relative bg-cover bg-center bg-no-repeat flex items-center transition-opacity duration-1000 ease-in-out"
                            x-show="activeSlide === {{ $index }}" x-transition:enter="transition ease-out duration-1000"
                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                            x-transition:leave="transition ease-in duration-1000" x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            style="background-image: url('{{ $banner->backgroundImage ? $banner->backgroundImage->url : '/assets/images/casa/banner.jpg' }}'); min-height: 60vh;">

                            <!-- Content with overlay background -->
                            <div class="container mx-auto px-4 py-16">
                                <div class="bg-green-900/90 p-10 mx-auto max-w-2xl text-center space-y-6 rounded-xl">
                                    <div class="banner-content">
                                        {!! $banner->content_en !!}
                                    </div>
                                    @if($banner->cta_text_en && $banner->cta_url_en)
                                        <div>
                                            <a href="{{ $banner->cta_url_en }}"
                                                class="inline-block !bg-green-600 text-white !px-7 !py-2 rounded-3xl hover:!bg-green-700 hover:!no-underline transition-colors font-medium text-lg">
                                                {{ $banner->cta_text_en }}
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Navigation Arrows -->
                @if($banners->count() > 1)
                    <button @click="prevSlide()"
                        class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/30 hover:bg-white/50 text-white rounded-full p-2 transition-colors z-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button @click="nextSlide()"
                        class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/30 hover:bg-white/50 text-white rounded-full p-2 transition-colors z-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>


                    <!-- Dots Indicator -->
                    <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex space-x-2 z-10">
                        @foreach($banners as $index => $banner)
                            <button @click="activeSlide = {{ $index }}" class="w-3 h-3 rounded-full transition-colors duration-300"
                                :class="activeSlide === {{ $index }} ? 'bg-white' : 'bg-white/50 hover:bg-white/80'">
                            </button>
                        @endforeach
                    </div>
                @endif
            </section>
        @else
            <!-- Default Video Banner -->
            <section id="home-banner">
                <div class="video-container">
                    <video class="jquery-background-video" loop autoplay muted playsinline
                        poster="/assets/images/home/home-banner.jpg" data-bgvideo="true">
                        <source src="/assets/images/home/home-banner.mp4" type="video/mp4">
                    </video>
                </div>
            </section>
        @endif

        <section id="home-intro">
            <div class="container">
                @if($introContent)
                    <div class="intro-text">
                        {!! $introContent->main_text_en !!}
                    </div>

                    <div class="intro-description">
                        {!! $introContent->secondary_text_en !!}
                    </div>
                @else
                    {{-- Fallback content if no database content exists --}}
                    <div class="intro-text">
                        Casa Gallina is a transdisciplinary cultural project whose programming is focused on learnings and
                        actions relating culture, community, and the environment. The project is located in Santa María la
                        Ribera, a neighborhood of Mexico City, where it seeks to facilitate synergies inside the local
                        communities.
                    </div>

                    <div class="intro-description">
                        Through its platforms, Casa Gallina seeks to promote, inoculate, encourage, and revitalize initiatives
                        and proposals about resilience, the environment, creative models of associations, life styles of
                        responsible consumption, as well as alternative models of social interaction. Casa Gallina also seeks to
                        strengthen local community networks, as well as alliances with initiatives from other areas that share
                        similar interests to establish processes of dialogue, work, and exchange.
                    </div>
                @endif

                <div class="intro-readmore">
                    <a href="/en/the-house">Read more<div class="plus-sign">+</div></a>
                </div>
            </div>
        </section>

        <section id="home-estrategias" class="py-16 bg-white" x-data="{
                currentIndex: 0,
                itemsPerPage: window.innerWidth >= 1024 ? 3 : (window.innerWidth >= 768 ? 2 : 1),
                totalItems: {{ $programa_tags->count() }},
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
            <div class="container mx-auto">
                <!-- Section Title -->
                <div class="text-center border-b-2 border-green-600 pb-2 mb-2">
                    <span class="bg-green-600 px-8 py-2 text-white font-serif text-2xl leading-4">Program</span>
                </div>

                <!-- Intro Text -->
                <div class="font-serif text-green-600 text-xl leading-6 py-4 md:px-16 pb-2 text-center">
                    Casa Gallina develops transdisciplinary programs that connect culture, community, and
                    environment through collective experiences of resilience, ecological regeneration, and social
                    creativity in the Santa María la Ribera neighborhood.
                </div>

                <!-- Intro Description -->
                <div class="font-libre text-gray-600 leading-5 py-2 md:px-16 tracking-wide space-y-2 pb-8">
                    <p>Our programs are built through collective exchange processes that involve the local
                        community in collaboration with professionals, artists, scientists, and managers from diverse
                        disciplines.</p>

                    <p>Each program is designed to generate transformative experiences that strengthen community
                        networks and promote sustainable change.</p>
                </div>

                <!-- Carousel -->
                <div class="relative mb-12">
                    <!-- Carousel Container -->
                    <div class="overflow-hidden">
                        <div class="flex transition-transform duration-500 ease-in-out"
                            :style="`transform: translateX(${translateX}%)`">
                            @foreach($programa_tags as $tag)
                                                    <div class="w-full md:w-1/2 lg:w-1/3 flex-shrink-0 px-3">
                                                        <a href="{{ $tag->type === 'programa-local' ?
                                    route('english.programa.estrategia-local.detalle', $tag->slug) :
                                    route('english.programa.estrategia-externa.detalle', $tag->slug) }}" class="block text-center hover:opacity-80 transition-opacity duration-300 !no-underline
                                hover:!no-underline">
                                                            <div class="mb-3 h-64">
                                                                @if($tag->thumbnail)
                                                                                            <img src="{{ $tag->thumbnail?->url }}" alt="{{ $tag->nombre_en ??
                                                                    $tag->nombre }}" class="w-full h-full object-cover">
                                                                @elseif($tag->multimedia)
                                                                                            <img src="{{ $tag->multimedia?->url }}" alt="{{ $tag->nombre_en ??
                                                                    $tag->nombre }}" class="w-full h-full object-cover">
                                                                @else
                                                                                            <img src="{{ asset('images/no-image.svg') }}" alt="{{
                                                                    $tag->nombre_en ?? $tag->nombre }}" class="w-full h-full object-cover">
                                                                @endif
                                                            </div>
                                                            <h3 class="font-sans text-green-600 !text-xl leading-5 tracking-tight mb-2">{{ $tag->nombre_en
                                    ?? $tag->nombre }}</h3>
                                                        </a>
                                                    </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <button @click="prev()" x-show="canGoPrev" class="absolute -left-6 top-26 bg-green-600 hover:bg-green-700 shadow-lg rounded-full p-3
        transition-colors duration-200 z-10">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>

                    <button @click="next()" x-show="canGoNext" class="absolute -right-6 top-26 bg-green-600 hover:bg-green-700 shadow-lg rounded-full p-3
        transition-colors duration-200 z-10">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>

                    <!-- Dots Indicator -->
                    <div class="absolute -bottom-4 left-1/2 -translate-x-1/2 translate-y-4 flex justify-center
        gap-3" x-show="totalSlides > 1">
                        <template x-for="(slide, index) in Array.from({length: totalSlides}, (_, i) => i)" :key="index">
                            <button @click="goToSlide(index)" class="w-3 h-3 rounded-full transition-colors duration-200"
                                :class="currentIndex === index ? 'bg-green-600' : 'bg-gray-400 hover:bg-gray-500'">
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Read More Link -->
                <div class="text-center mt-8">
                    <a href="{{ route('english.programa') }}" class="inline-flex items-center !text-green-600 hover:!text-green-700 transition-colors
        duration-200 !no-underline hover:!no-underline">
                        <span class="text-lg font-medium mr-2">Read more</span>
                        <div class="w-6 h-6 !bg-green-600 hover:!bg-green-700 !text-white rounded-full flex
        items-center justify-center text-sm font-bold transition-colors duration-200">
                            +</div>
                    </a>
                </div>
            </div>
        </section>

        <section id="home-publicaciones">
            <div class="container">
                <div class="section-title text-center">
                    <span>Publications</span>
                </div>

                <div class="publicaciones-carousel row">
                    @foreach ($publicaciones as $publicacion)
                                <div class="publicacion-item col-md-6 col-lg-4">
                                    <div class="publicacion-image"
                                        style="background-image: url('{{ $publicacion->publicacion_thumbnail?->url }}')"
                                        onclick="window.location = '/en/publication/{{ \Str::slug($publicacion->titulo_en) }}/{{ $publicacion->id }}'">
                                    </div>
                                    <div class="publicacion-title">
                                        <a
                                            href="/en/publication/{{ \Str::slug(strip_tags($publicacion->titulo_en)) }}/{{ $publicacion->id }}">{!!
                        $publicacion->titulo_en !!}</a>
                                    </div>
                                    <div class="publicacion-subtitle">
                                        {{ $publicacion->subtitulo_en }}
                                    </div>
                                </div>
                    @endforeach
                </div>

                <div class="publicaciones-readmore">
                    <a href="/en/publications">Read more<div class="plus-sign">+</div></a>
                </div>
            </div>
        </section>

        <section id="home-noticias" class="py-16 bg-gray-50">
            <div class="container mx-auto">
                <!-- Section Title -->
                <div class="text-center border-b-2 border-green-600 pb-2 mb-8">
                    <span class="bg-green-600 px-8 py-2 text-white font-serif text-2xl leading-4">News</span>
                </div>

                <!-- Intro Text -->
                <div class="font-serif text-green-600 text-xl leading-6 py-4 md:px-16 pb-8 text-center">
                    Stay up to date with the latest news, events, and activities from Casa Gallina and the community.
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                    @foreach ($noticias as $noticia)
                        <div class="text-center">
                            <a href="/en/news/{{ $noticia->slug }}"
                                class="block hover:opacity-80 transition-opacity duration-300 !no-underline hover:!no-underline">
                                <div class="mb-3 h-64">
                                    @if($noticia->featured_image)
                                        <img src="{{ $noticia->featured_image?->url }}" alt="{{ strip_tags($noticia->titulo) }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <img src="{{ asset('assets/images/casa/banner.jpg') }}"
                                            alt="{{ strip_tags($noticia->titulo) }}" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <h3 class="font-sans text-green-600 !text-xl leading-6 tracking-tight mb-2">
                                    {{ \Str::limit(strip_tags($noticia->titulo), 60) }}
                                </h3>
                                <p class="text-gray-600 text-sm leading-5">
                                    {{ \Str::limit($noticia->excerpt, 100) }}
                                </p>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-8">
                    <a href="/en/news"
                        class="inline-flex items-center !text-green-600 hover:!text-green-700 transition-colors duration-200 !no-underline hover:!no-underline">
                        <span class="text-lg font-medium mr-2">Read more</span>
                        <div
                            class="w-6 h-6 !bg-green-600 hover:!bg-green-700 !text-white rounded-full flex items-center justify-center text-sm font-bold transition-colors duration-200">
                            +</div>
                    </a>
                </div>
            </div>
        </section>

        <section id="home-numeralia">

            <div class="container">
                <div class="section-title text-center">
                    <span>Impact</span>
                </div>
            </div>

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-11">
                        <div class="numeralia-content">
                            <div class="fechas-header">
                                Since 2019
                            </div>
                            <div class="container" style="border: 0px solid gray">
                                <div
                                    style="text-align: center; color: #073D8C;font-size: 50px; line-height: 120px; font-weight: 700;">
                                    COMMUNITY REACH
                                </div>
                                <div class="row" style="text-align: center; padding-top: 0px; padding-bottom: 35;">

                                    <div class="col-md-6">
                                        <br><br>
                                        <img loading="lazy" src="/assets/images/home/numeralia/object-01.png"><br>
                                        <br>
                                        <span style="color: #073D8C; font-size: 70px; line-height: 90px; font-weight: 700;"
                                            class="countup-element" data-number="13121">13,121</span>
                                        <br>
                                        <span
                                            style="color: #4a5d5a; font-size: 22px; line-height: 30px; font-weight: 400;">neighbors
                                            actively<br>participating in programs</span><br><br>
                                        <span
                                            style="color: #4a5d5a; font-size: 22px; line-height: 30px; font-weight: 400;">An
                                            average of</span><br>
                                        <span style="color: #073D8C; font-size: 70px; line-height: 90px; font-weight: 700;"
                                            class="countup-element" data-number="307">307</span>
                                        <br>
                                        <span
                                            style="color: #4a5d5a; font-size: 22px; line-height: 30px; font-weight: 400;">monthly
                                            visitors to the House</span>
                                    </div>
                                    <div class="col-md-6">
                                        <span
                                            style="color: #073D8C; font-size: 70px; line-height: 80px; font-weight: 700; ">49,000</span><br>
                                        <span
                                            style="color: #4a5d5a; font-size: 22px; line-height: 30px; font-weight: 400;">indirect
                                            beneficiaries<br>(number of inhabitants<br>of Santa María la Ribera)</span><br>
                                        <div class="row" style="padding-top: 35px;">
                                            <div class="col-sm-4" style="text-align: right;">
                                                <span
                                                    style="color: #073D8C; font-size: 80px; line-height: 123px; font-weight: 700;"
                                                    class="countup-element" data-number="24">24</span>
                                            </div>
                                            <div class="col-sm-8" style="text-align: left;">
                                                <span
                                                    style="color: #073D8C; font-size: 30px; line-height: 30px; font-weight: 600;"><br>neighborhood<br></span><span
                                                    style="color: #073D8C; font-size: 44px; line-height: 40px; font-weight: 600;">initiatives</span>
                                            </div>

                                        </div>
                                        <span
                                            style="color: #073D8C; font-size: 25px; line-height:0px; font-weight: 600;">&nbspfor
                                            the common good</span><br><br><br><br>

                                        <span
                                            style="color: #4a5d5a; font-size: 22px; line-height: 33px; font-weight: 400;">Collaborations
                                            with<br> <span
                                                style="color: #073D8C; font-size: 30px; line-height: 10px; font-weight: 600;">19
                                                local schools</span>, supporting<br>the creative and meaningful
                                            education<br>of <span
                                                style="color: #073D8C; font-size: 30px; line-height: 10px; font-weight: 600;">9,981
                                                children,</span> and<br>the work of<span
                                                style="color: #073D8C; font-size: 30px; line-height: 10px; font-weight: 600;">
                                                556 teachers</span></span>
                                        </span>

                                    </div>
                                </div>
                                <div style="text-align: center;padding-top: 20px; padding-bottom: 35px">

                                    <br><br>
                                    <span
                                        style="color: #073D8C; font-size: 38px; line-height: 40px; font-weight: 650;">Testimony<br></span>
                                    <br>
                                    <span
                                        style="color: #4a5d5a; font-size: 22px; line-height: 24px; font-weight: 400;"><span
                                            style="color: #073D8C; font-size: 30px; line-height: 24px; font-weight: 700;">“</span>
                                        We live from an adult-centric perspective,<br>which is the basis for teaching, but
                                        here they
                                        <br>have another pedagogical outlook, where the children can<br>foster their sense
                                        of community, that feeling of support,
                                        <br>it generates a space where they feel safe, and where<br>we can express ourselves
                                        as children or as adults<span
                                            style="color: #073D8C; font-size: 30px; line-height:24px; font-weight: 700;">”<br><br></span><span
                                            style="color: #073D8C; font-size: 18px; line-height:24px; font-weight:450;">-
                                            Jessica Martínez, mother of a child participating in the summer course <i>Life
                                                In My Environment</i>, August 2022</span></span>
                                </div>


                            </div>
                            <br><br>
                            <div class="container" style="border: 0px solid gray">
                                <div class="row" style="text-align: center; padding-top: 20px; padding-bottom: 35;">
                                    <div class="col-md-6">
                                        <br><br>
                                        <span
                                            style="text-align: center; color: #F4B519;font-size: 50px; line-height: 50px; font-weight: 700;">EXPANSION<br>IN
                                            TO OTHER<br>TERRITORIES</span><br><br>
                                        <span
                                            style="color: #4a5d5a; font-size: 22px; line-height: 28px; font-weight: 400;">Link
                                            with <b>333 community<br>organizations</b> and <b>agents<br>258</b>
                                            allies have expanded<br>Casa Gallina's work in <br><b>151 communities</b>
                                            across<br><b>23 states</b></span><br><br>
                                        <img src="/assets/images/home/numeralia/pais.png"><br><br>
                                        <span
                                            style="color: #4a5d5a; font-size: 22px; line-height: 28px; font-weight: 400;">Reaching<b>
                                                56,275 people<br> in other territories</b><br></span>

                                        <div class="row">
                                            <div class="col-sm-4" style="text-align: right;">
                                                <span
                                                    style="color: #F4B519; font-size: 130px; line-height: 170px; font-weight: 700;"
                                                    class="countup-element" data-number="8">8</span>
                                            </div>
                                            <div class="col-sm-8" style="text-align: left;">
                                                <span
                                                    style="color: #F4B519; font-size: 30px; line-height: 35px; font-weight: 600;"><br>Programs
                                                    of<br>Environmental<br>Education</span>
                                            </div>


                                            <div class="row">

                                                <div class="col-sm-2"></div>
                                                <div class="col-sm-6" style="text-align: left;"> <span
                                                        style="color: #4a5d5a; font-size: 22px; line-height: 28px; font-weight: 400;"><br><b>103</b>
                                                        schools<br><b>512</b> teachers<br><b>9958</b> students<br></span>
                                                </div>
                                                <div class="col-sm-4">

                                                    <img loading="lazy" src="/assets/images/home/numeralia/maestra.png"><br>
                                                </div>
                                            </div>

                                            <span
                                                style="color: #4a5d5a; font-size: 22px; line-height: 28px; font-weight: 400; text-align: left;"><b>In
                                                    Oaxaca, Campeche,<br>Guerrero, Mexico City, Puebla<br>Veracruz and
                                                    Jalisco</b></span>



                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <span
                                                    style="color: #F4B519; font-size: 130px; line-height: 175px; font-weight: 700; text-align: left;"
                                                    class="countup-element" data-number="9">9</span>
                                            </div>
                                            <div class="col-sm-4" style="text-align: left;">
                                                <span
                                                    style="color: #F4B519; font-size: 28px; line-height: 28px; font-weight: 600;"><br>community<br>exhibitions<br>activated<br>in
                                                    8 states</span>
                                            </div>
                                            <div class="col-sm-5" style="text-align: left;">
                                                <img loading="lazy" src="/assets/images/home/numeralia/expomaiz.png">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <span
                                                style="color: #4a5d5a; font-size: 24px; line-height: 34px; font-weight: 400; text-align: left;">Mexico
                                                City, State<br>of Mexico, Nayarit, Tabasco,<br>Quintana Roo,
                                                Oaxaca,<br>Chiapas and Puebla<br></span>
                                        </div>

                                    </div>

                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <span
                                                    style="color: #F4B519; font-size: 130px; line-height: 170px; font-weight: 700;"
                                                    class="countup-element" data-number="15">15</span>
                                            </div>
                                            <div class="col-sm-8" style="text-align: left;">
                                                <span
                                                    style="color: #F4B519; font-size: 30px; line-height: 35px; font-weight: 600;"><br>books
                                                    published<br>and distributed<br>nationwide:</span>
                                            </div>
                                            <div style="text-align: left;"> <span
                                                    style="color: #4a5d5a; font-size: 30px; line-height: 40px; font-weight: 500;">&nbsp&nbsp<i>We
                                                        Are Maize &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</i></span>
                                                <img loading="lazy" src="/assets/images/home/numeralia/maiz.png"><br>
                                            </div>
                                            <div class="col-sm-9" style="text-align: left;">
                                                <span
                                                    style="color: #4a5d5a; font-size: 28px; line-height: 36px; font-weight: 500;"><i>Constellations:<br>A
                                                        Manual of Tools<br>for Collective Mapping</i></span>
                                            </div>
                                            <div class="col-sm-3" style="text-align: : left;">
                                                <img loading="lazy" src="/assets/images/home/numeralia/constelaciones.png">
                                            </div>
                                            <br>
                                            <div class="col-sm-9" style="text-align: left; padding-top: 25px;">
                                                <span
                                                    style="color: #4a5d5a; font-size: 28px; line-height: 36px; font-weight: 500;"><i>Interconnections:
                                                        Big<br>and Small Creatures<br>in the Same World</i></span>
                                            </div>
                                            <div class="col-sm-3"
                                                style="text-align: : left; padding-top: 35px; padding-left: 1px;">
                                                <img loading="lazy" src="/assets/images/home/numeralia/colibiinter.png">
                                            </div>
                                            <div style="text-align: left;"> <span
                                                    style="color: #4a5d5a; font-size: 28px; line-height: 40px; font-weight: 500;">&nbsp&nbsp<i>Life
                                                        in My Environment
                                                        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</i></span>
                                                <img src="/assets/images/home/numeralia/tlaco.png"><br>
                                            </div>
                                            <div style="text-align: left;"> <span
                                                    style="color: #4a5d5a; font-size: 28px; line-height: 40px; font-weight: 500;">&nbsp&nbsp<i>We
                                                        Make Our River &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</i></span>
                                                <img src="/assets/images/home/numeralia/rio.png"><br>
                                            </div>
                                            <div style="text-align: left;"> <span
                                                    style="color: #4a5d5a; font-size: 28px; line-height: 40px; font-weight: 500;">&nbsp&nbsp<i>The
                                                        Distributed Orchard
                                                        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</i></span>
                                                <img src="/assets/images/home/numeralia/hoja.png"><br>
                                            </div>
                                            <div class="col-sm-9" style="text-align: left;"> <span
                                                    style="color: #4a5d5a; font-size: 28px; line-height: 36px; font-weight: 500;"><i>Flavors
                                                        and Knowledge<br>from the Maize Field</i></span>
                                            </div>
                                            <div class="col-sm-3"><img src="/assets/images/home/numeralia/ejote.png"><br>
                                            </div>
                                            <div class="col-sm-10" style="text-align: left;"> <span
                                                    style="color: #4a5d5a; font-size: 28px; line-height: 36px; font-weight: 500;"><i>Tracing
                                                        the Common.<br>The Territories that Inhabit Us</i></span>
                                            </div>
                                            <div class="col-sm-2"><img src="/assets/images/home/numeralia/ave.png"><br>
                                            </div>
                                            <div class="col-sm-9" style="text-align: left;"> <span
                                                    style="color: #4a5d5a; font-size: 28px; line-height: 36px; font-weight: 500;"><i>Recreate.
                                                        A Compilation of<br>Educational Strategies</i></span>
                                            </div>
                                            <div class="col-sm-3"><img src="/assets/images/home/numeralia/recrea.png"><br>
                                            </div>
                                            <div class="col-sm-9" style="text-align: left;"> <span
                                                    style="color: #4a5d5a; font-size: 28px; line-height: 36px; font-weight: 500;"><i>The
                                                        Sense of the Garden</i></span>
                                            </div>
                                            <div class="col-sm-3"><img src="/assets/images/home/numeralia/sentido.png"><br>
                                            </div>
                                            <div class="col-sm-9" style="text-align: left;"> <span
                                                    style="color: #4a5d5a; font-size: 28px; line-height: 36px; font-weight: 500;"><i>Breaths:
                                                        Seven Notes<br>on Reading Mediation</i></span>
                                            </div>
                                            <div class="col-sm-3"><img src="/assets/images/home/numeralia/alientos.png"><br>
                                            </div>

                                            <br>
                                            <br>
                                            <div class="col-sm-5" style="padding-top: 25px; padding-bottom: 10;">
                                                <span
                                                    style="color: #F4B519; font-size: 95px; line-height: 100px; font-weight: 650;">32%</span>
                                            </div>
                                            <div class="col-sm-7"
                                                style="text-align: left; padding-top: 25px; padding-bottom: 10;">
                                                <span
                                                    style="color: #F4B519; font-size: 22px; line-height: 30px; font-weight: 500;">of
                                                    the print run<br> consists of editions in 8<br>indigenous
                                                    languages:</span>
                                            </div>
                                            <span
                                                style="text-align: left;color: #4a5d5a; font-size: 26px; line-height: 39px; font-weight: 400;">&nbsp&nbsp&nbsp&nbspZapoteco,
                                                Maya, Náhuatl, Wixárika,<br>&nbsp&nbsp&nbsp&nbspPurépecha, Ombeayiüts,
                                                Tsotsil<br>&nbsp&nbsp&nbsp&nbspTseltal, Mazatec and Totonac</span><br><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="text-center mt-8">
                                <a href="{{ route('english.impacto') }}"
                                    class="inline-flex items-center !text-green-600 hover:!text-green-700 transition-colors duration-200 !no-underline hover:!no-underline">
                                    <span class="text-lg font-medium mr-2">View full impact</span>
                                    <div
                                        class="w-5 h-5 !bg-green-600 hover:!bg-green-700 !text-white rounded-full flex items-center justify-center text-lg font-bold transition-colors duration-200">
                                        +</div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="home-cartografia">
            @livewire('components.cartografia-map')
        </section>

        <section id="home-aliados">
            <div class="container">
                <div class="section-title text-center">
                    <span>Allies</span>
                </div>
            </div>

            <div class="aliados-banner">
                <img loading="lazy" src="/assets/images/home/aliados/banner.jpg" class="img-fluid">
            </div>

            <div class="container">
                <div class="aliados-text">
                    <p>Casa Gallina strives to build and strengthen networks of alliances with collectives, individuals,
                        civil society organizations and public or private institutions with whom we share common interests.
                        Collaborative processes are built in different formats and frameworks, which weave networks to share
                        resources, strategies and methodologies.</p>
                </div>

                <div class="aliados-description">
                    <p>These different alliances aim to enable processes and actions related to critical narratives, so as
                        to trigger collective experiences on ecology, resilience, community liassons and creativity in daily
                        life.</p>

                    <p>This network is deepened through the creation of new programs and work formats in co-participation
                        with the agents and organizations with which it collaborates. In search of constant expansion, the
                        network is open to constantly integrate new organizations, groups and institutions that share the
                        interests of creating projects in favor of the common good, culture, community and the environment.
                    </p>
                </div>

                <div class="text-center mt-8">
                    <a href="{{ route('english.aliados') }}"
                        class="inline-flex items-center !text-green-600 hover:!text-green-700 transition-colors duration-200 !no-underline hover:!no-underline">
                        <span class="text-lg font-medium mr-2">Read more</span>
                        <div
                            class="w-5 h-5 !bg-green-600 hover:!bg-green-700 !text-white rounded-full flex items-center justify-center text-lg font-bold transition-colors duration-200">
                            +</div>
                    </a>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('pre_scripts')
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGklE-iy0n4O0x8SxRtDy4Q_lr7Cx2WPA&callback=initGoogleMaps"
        async defer></script>
    <script>
        window.initGoogleMaps = function () {
            console.log('Google Maps loaded');
            // Google Maps is now loaded, HomeIndex will initialize the map
        };
    </script>
@endsection