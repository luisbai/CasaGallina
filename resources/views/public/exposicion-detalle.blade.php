@extends('layouts.boilerplate')

@section('meta')
    <!-- add alpinejs -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection

@section('title', ' - ' . strip_tags($exposicion->titulo))

@section('content')
    <div class="container mx-auto px-4">
        <div id="exposicion-index">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div>
                    <!-- Image Carousel -->
                    @if($exposicion->multimedia && $exposicion->multimedia->count() > 0)
                        <div class="mb-6"
                            x-data="{ currentImageIndex: 0, totalImages: {{ $exposicion->multimedia->count() }} }">
                            <div class="relative h-80 w-full overflow-hidden group rounded-lg shadow-md">
                                <!-- Images Container -->
                                <div class="relative w-full h-full">
                                    @foreach($exposicion->multimedia as $index => $multimedia)
                                        <div class="absolute inset-0 transition-opacity duration-300"
                                            x-show="currentImageIndex === {{ $index }}"
                                            x-transition:enter="transition-opacity duration-300"
                                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                            x-transition:leave="transition-opacity duration-300"
                                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                            <img src="{{ $multimedia->multimedia?->url }}"
                                                alt="{{ strip_tags($exposicion->titulo) }} - Imagen {{ $index + 1 }}"
                                                class="w-full h-full object-cover transition-transform duration-300" loading="lazy">
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Navigation Controls (visible on hover) -->
                                @if($exposicion->multimedia->count() > 1)
                                    <div
                                        class="absolute inset-0 flex items-center justify-between p-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                                        <!-- Previous Button -->
                                        <button
                                            @click="currentImageIndex = currentImageIndex > 0 ? currentImageIndex - 1 : totalImages - 1"
                                            class="bg-green-600 hover:bg-green-700 text-white p-2 rounded-full transition-all duration-200 pointer-events-auto">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 19l-7-7 7-7"></path>
                                            </svg>
                                        </button>

                                        <!-- Next Button -->
                                        <button
                                            @click="currentImageIndex = currentImageIndex < totalImages - 1 ? currentImageIndex + 1 : 0"
                                            class="bg-green-600 hover:bg-green-700 text-white p-2 rounded-full transition-all duration-200 pointer-events-auto">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- Image Counter -->
                                    <div
                                        class="absolute top-2 right-2 bg-green-600 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <span x-text="currentImageIndex + 1"></span>/<span x-text="totalImages"></span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="mb-6">
                            <img src="{{ asset('assets/images/casa/banner.jpg') }}" class="w-full h-auto rounded-lg shadow-md"
                                alt="{{ strip_tags($exposicion->titulo) }}">
                        </div>
                    @endif
                </div>

                <div>

                    <div class="flex flex-col gap-4">
                        <h1 class="!text-3xl !font-bold text-green-600 !tracking-tight mb-6 leading-tight">
                            {!! str_replace(['<p>', '</p>'], '', $exposicion->titulo) !!}
                        </h1>
                        @if($exposicion->metadatos)
                            <div class="exposicion-metadata">
                                {!! $exposicion->metadatos !!}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="exposicion-content col-span-2">
                    <div class="h-[2px] bg-green-600/50 mb-8 w-2/3 mx-auto"></div>

                    @if($exposicion->contenido)
                        {!! $exposicion->contenido !!}
                    @endif

                    <div class="h-[2px] bg-green-600/50 mt-8 w-2/3 mx-auto"></div>
                </div>

                {{-- Assigned Programas Section --}}
                @if($exposicion->programs && $exposicion->programs->where('assign_to_expo_proyecto', true)->count())
                    <div class="col-span-2 mt-8">
                        <div class="space-y-8">
                            @foreach($exposicion->programs->where('assign_to_expo_proyecto', true) as $programa)
                                <div class="grid grid-cols-12 gap-8 items-start">
                                    {{-- Image column --}}
                                    <div class="col-span-5">
                                        @if($programa->multimedia && $programa->multimedia->count() > 0)
                                            {{-- Image carousel if multiple images --}}
                                            @if($programa->multimedia->count() > 1)
                                                <div x-data="{ currentImageIndex: 0, totalImages: {{ $programa->multimedia->count() }} }"
                                                    class="relative">
                                                    <div class="relative h-64 w-full overflow-hidden group rounded-lg shadow-md">
                                                        {{-- Images Container --}}
                                                        <div class="relative w-full h-full">
                                                            @foreach($programa->multimedia as $index => $multimedia)
                                                                <div class="absolute inset-0 transition-opacity duration-300"
                                                                    x-show="currentImageIndex === {{ $index }}"
                                                                    x-transition:enter="transition-opacity duration-300"
                                                                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                                                    x-transition:leave="transition-opacity duration-300"
                                                                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                                                    <img src="{{ $multimedia->multimedia?->url }}"
                                                                        alt="{{ strip_tags($programa->titulo) }} - Imagen {{ $index + 1 }}"
                                                                        class="w-full h-full object-cover">
                                                                </div>
                                                            @endforeach
                                                        </div>

                                                        {{-- Navigation Controls --}}
                                                        <div
                                                            class="absolute inset-0 flex items-center justify-between p-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                                                            {{-- Previous Button --}}
                                                            <button
                                                                @click="currentImageIndex = currentImageIndex > 0 ? currentImageIndex - 1 : totalImages - 1"
                                                                class="bg-green-600 hover:bg-green-700 text-white p-2 rounded-full transition-all duration-200 pointer-events-auto">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                        d="M15 19l-7-7 7-7"></path>
                                                                </svg>
                                                            </button>

                                                            {{-- Next Button --}}
                                                            <button
                                                                @click="currentImageIndex = currentImageIndex < totalImages - 1 ? currentImageIndex + 1 : 0"
                                                                class="bg-green-600 hover:bg-green-700 text-white p-2 rounded-full transition-all duration-200 pointer-events-auto">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                        d="M9 5l7 7-7 7"></path>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                {{-- Single image --}}
                                                <div class="mb-4">
                                                    <img src="{{ $programa->multimedia->first()?->multimedia?->url }}"
                                                        alt="{{ strip_tags($programa->titulo) }}"
                                                        class="w-full h-64 object-cover rounded-lg shadow-md">
                                                </div>
                                            @endif
                                        @else
                                            {{-- Placeholder when no images --}}
                                            <div class="w-full h-64 bg-gray-100 flex items-center justify-center rounded-lg shadow-md">
                                                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Content column --}}
                                    <div class="col-span-7">
                                        {{-- Program title --}}
                                        <h3 class="!text-lg !font-libre !font-bold !text-green-600 mb-4">
                                            {{ strip_tags($programa->titulo) }}
                                        </h3>

                                        {{-- Program metadata --}}
                                        @if($programa->metadatos)
                                            <div class="text-sm text-gray-700 mb-4 leading-relaxed">
                                                {!! $programa->metadatos !!}
                                            </div>
                                        @endif

                                        {{-- Program content/description --}}
                                        @if($programa->contenido)
                                            <div class="!text-sm text-gray-600 leading-relaxed mb-4">
                                                {!! $programa->contenido !!}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="h-[2px] bg-green-600/50 mt-8 w-2/3 mx-auto"></div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($exposicion->archivos && $exposicion->archivos->count())
                    <div class="space-y-8">
                        @foreach($exposicion->archivos as $archivo)
                            <div class="grid grid-cols-12 gap-6 items-start">
                                <!-- Book-style image column -->
                                <div class="col-span-4">
                                    <div class="mb-4">
                                        <img src="{{ $archivo->thumbnail_url }}" alt="Archivo descargable"
                                            class="w-full h-auto rounded-lg shadow-md">
                                    </div>
                                </div>

                                <!-- Rich text content column -->
                                <div class="col-span-8">
                                    <div class="">
                                        @if($archivo->contenido)
                                            <div class="markdown-content">
                                                {!! $archivo->contenido !!}
                                            </div>
                                        @else
                                            <!-- Fallback for existing archivos without contenido -->
                                            @if($archivo->titulo)
                                                <h3 class="text-lg font-bold text-green-600 mb-2">{{ $archivo->titulo }}</h3>
                                            @endif
                                            @if($archivo->descripcion)
                                                <p class="text-gray-700 mb-3">{{ $archivo->descripcion }}</p>
                                            @endif
                                        @endif
                                    </div>

                                    @if($archivo->fileExists())
                                        <div class="flex gap-3">
                                            <a href="{{ $archivo->download_url }}"
                                                class="px-6 !py-1.5 !bg-green-600 hover:bg-green-700 text-white font-semibold rounded-full transition-all duration-200 shadow-sm hover:shadow-md text-sm hover:!no-underline hover:opacity-80"
                                                data-action="descargar-archivo" target="_blank">
                                                Descargar
                                            </a>

                                            @if(strtolower($archivo->file_extension) === 'pdf')
                                                <a href="#"
                                                    class="px-6 !py-1.5 !bg-green-600 hover:bg-green-700 text-white font-semibold rounded-full transition-all duration-200 shadow-sm hover:shadow-md text-sm hover:!no-underline hover:opacity-80"
                                                    data-action="ver-archivo"
                                                    data-archivo-url="{{ route('exposicion.archivo.viewer', ['archivo' => $archivo->id]) }}">
                                                    Previsualizar
                                                </a>
                                            @endif
                                        </div>
                                    @else
                                        <div x-data="{ show: true }" x-show="show" class="bg-red-50 border border-red-200 rounded-lg p-4">
                                            <div class="flex items-start justify-between">
                                                <div class="flex items-start">
                                                    <svg class="w-5 h-5 text-red-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                    </svg>
                                                    <div>
                                                        <h4 class="text-sm font-semibold text-red-800 mb-1">Archivo no disponible</h4>
                                                        <p class="text-sm text-red-700">
                                                            El archivo solicitado no se encuentra disponible para descarga en este momento. 
                                                            Por favor, contacte al administrador del sitio.
                                                        </p>
                                                    </div>
                                                </div>
                                                <button @click="show = false" type="button" class="ml-3 inline-flex text-red-400 hover:text-red-600 focus:outline-none">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Publications Section --}}
                @if($exposicion->publicaciones && $exposicion->publicaciones->count())
                    <div class="space-y-8">@foreach($exposicion->publicaciones as $publicacion)
                        <div class="grid grid-cols-12 gap-6 items-start">
                            <!-- Book-style image column -->
                            <div class="col-span-4">
                                <div class="mb-4">
                                    <img src="{{ $publicacion->publicacion_thumbnail?->url }}"
                                        alt="{{ strip_tags($publicacion->titulo) }}" class="w-full h-auto rounded-lg shadow-md">
                                </div>
                            </div>

                            <!-- Content column -->
                            <div class="col-span-8">
                                <h3 class="!text-lg !font-libre !font-bold !text-green-600 mb-2">
                                    {{ strip_tags($publicacion->titulo) }}
                                </h3>

                                <div class="flex gap-3">
                                    <!-- Associated publications show link button, not download -->
                                    <a href="{{ $publicacion->url[app()->getLocale() === 'en' ? 'en' : 'es'] }}"
                                        class="px-6 !py-1.5 !bg-green-600 hover:bg-green-700 text-white font-semibold rounded-full transition-all duration-200 shadow-sm hover:shadow-md text-sm hover:!no-underline hover:opacity-80"
                                        target="_blank">
                                        Ver Publicación
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </div>
                @endif

                {{-- Video Section --}}
                @if($exposicion->videos && $exposicion->videos->count())
                    <div x-data="{
                                                currentIndex: 0,
                                                totalVideos: {{ $exposicion->videos->count() }},
                                                isPlaying: false,
                                                currentVideoId: '',
                                                playVideo(videoId) {
                                                    this.isPlaying = true;
                                                    this.currentVideoId = videoId;
                                                },
                                                stopVideo() {
                                                    this.isPlaying = false;
                                                    this.currentVideoId = '';
                                                }
                                            }">

                        <!-- Video Thumbnail Carousel (shown when not playing) -->
                        <div x-show="!isPlaying" class="flex flex-col gap-4">
                            <!-- Thumbnail Carousel -->
                            <div class="relative h-68 w-full overflow-hidden group">
                                <!-- Thumbnails Container -->
                                <div class="relative w-full h-full">
                                    @foreach($exposicion->videos as $index => $video)
                                        <div class="absolute inset-0 transition-opacity duration-300"
                                            x-show="currentIndex === {{ $index }}"
                                            x-transition:enter="transition-opacity duration-300"
                                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                            x-transition:leave="transition-opacity duration-300"
                                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

                                            <div class="relative w-full h-full cursor-pointer group/video"
                                                @click="playVideo('{{ $video->youtube_id }}')">

                                                <img src="{{ $video->thumbnail_url }}" alt="{{ strip_tags($video->titulo) }}"
                                                    class="w-full h-full object-cover hover:scale-105 transition-transform duration-300 rounded"
                                                    loading="lazy"
                                                    onerror="this.onerror=null; this.src='{{ $video->fallback_thumbnail_url }}'; if(!this.complete || this.naturalWidth===0) { this.nextElementSibling.style.display='block'; }">

                                                <!-- Fallback when all thumbnails fail to load -->
                                                <div class="w-full h-full bg-gray-800 flex items-center justify-center rounded"
                                                    style="display: none;">
                                                    <div class="text-center text-white">
                                                        <svg class="w-16 h-16 mx-auto mb-2 opacity-50" fill="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path d="M8 5v14l11-7z" />
                                                        </svg>
                                                        <p class="text-sm opacity-75">{{ strip_tags($video->titulo) }}</p>
                                                    </div>
                                                </div>

                                                <!-- Play Button Overlay -->
                                                <div
                                                    class="absolute inset-0 flex items-center justify-center transition-all duration-300 rounded bg-black/20 ">
                                                    <div
                                                        class="bg-green-600 hover:bg-green-700 text-white rounded-full p-4 transform group-hover/video:scale-110 transition-all duration-300 shadow-lg">
                                                        <svg class="w-8 h-8 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M8 5v14l11-7z" />
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Navigation Controls (visible on hover) -->
                                @if($exposicion->videos->count() > 1)
                                    <div
                                        class="absolute inset-0 flex items-center justify-between p-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                                        <!-- Previous Button -->
                                        <button @click="currentIndex = currentIndex > 0 ? currentIndex - 1 : totalVideos - 1"
                                            class="bg-green-600 hover:bg-green-700 text-white p-2 rounded-full transition-all duration-200 pointer-events-auto">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 19l-7-7 7-7"></path>
                                            </svg>
                                        </button>

                                        <!-- Next Button -->
                                        <button @click="currentIndex = currentIndex < totalVideos - 1 ? currentIndex + 1 : 0"
                                            class="bg-green-600 hover:bg-green-700 text-white p-2 rounded-full transition-all duration-200 pointer-events-auto">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- Video Counter -->
                                    <div
                                        class="absolute top-2 right-2 bg-green-600 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <span x-text="currentIndex + 1"></span>/<span x-text="totalVideos"></span>
                                    </div>
                                @endif
                            </div>

                            <!-- Video Info (current video) -->
                            <div class="flex flex-col gap-2 px-4">
                                @foreach($exposicion->videos as $index => $video)
                                    <div x-show="currentIndex === {{ $index }}">
                                        <h4 class="!text-lg text-green-600 !font-bold leading-tight text-center !mb-1">
                                            {{ strip_tags($video->titulo) }}
                                        </h4>
                                        @if($video->descripcion)
                                            <p class="text-gray-600 text-base text-center leading-tight">
                                                {{ $video->descripcion }}
                                            </p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Video Player (shown when playing) -->
                        <div x-show="isPlaying" x-transition class="relative">
                            <!-- Close Button -->
                            <button @click="stopVideo()"
                                class="absolute top-4 right-4 z-20 bg-black bg-opacity-75 hover:bg-opacity-90 text-white p-3 rounded-full transition-all duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>

                            <!-- Video Iframe -->
                            <div class="relative w-full" style="padding-bottom: 56.25%;">
                                <iframe x-show="isPlaying"
                                    :src="isPlaying ? 'https://www.youtube.com/embed/' + currentVideoId + '?autoplay=1' : ''"
                                    title="Video Player" allowfullscreen allow="autoplay"
                                    class="absolute top-0 left-0 w-full h-full rounded">
                                </iframe>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Noticias Carousel Section --}}
                @if($exposicion->noticias && $exposicion->noticias->count())
                    <div x-data="{ 
                                                currentIndex: 0, 
                                                totalNoticias: {{ $exposicion->noticias->count() }},
                                                nextSlide() {
                                                    this.currentIndex = this.currentIndex < this.totalNoticias - 1 ? this.currentIndex + 1 : 0;
                                                },
                                                prevSlide() {
                                                    this.currentIndex = this.currentIndex > 0 ? this.currentIndex - 1 : this.totalNoticias - 1;
                                                }
                                            }" class="">

                        <div class="relative w-full">
                            <!-- Single column container with carousel navigation -->
                            <div class="relative w-full overflow-hidden group">
                                <!-- Noticias Container -->
                                <div class="relative w-full h-96">
                                    @foreach($exposicion->noticias as $index => $noticia)
                                        <div class="absolute inset-0 transition-opacity duration-300 h-full"
                                            x-show="currentIndex === {{ $index }}"
                                            x-transition:enter="transition-opacity duration-300"
                                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                            x-transition:leave="transition-opacity duration-300"
                                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

                                            <a href="{{ route('noticia', $noticia->slug) }}"
                                                class="block text-center hover:opacity-80 transition-opacity duration-300 !no-underline hover:!no-underline">
                                                <!-- Image -->
                                                <div class="w-full h-full mx-auto mb-3 overflow-hidden rounded-lg">
                                                    @if($noticia->featured_image)
                                                        <img src="{{ $noticia->featured_image?->url }}"
                                                            alt="{{ strip_tags($noticia->titulo) }}" class="w-full h-68 object-cover">
                                                    @else
                                                        <div class="w-full h-68 bg-green-600 flex items-center justify-center">
                                                            <img src="{{ asset('assets/images/logo-white.png') }}" alt="Casa Gallina"
                                                                class="w-16 h-auto opacity-80">
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- Title -->
                                                <h3
                                                    class="font-sans text-green-600 !text-lg !font-semibold leading-6 tracking-tight px-4">
                                                    {{ strip_tags($noticia->titulo) }}
                                                </h3>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Navigation Controls (visible on hover) for multiple noticias -->
                                @if($exposicion->noticias->count() > 1)
                                    <div
                                        class="absolute inset-0 flex items-center justify-between p-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                                        <!-- Previous Button -->
                                        <button @click="prevSlide()"
                                            class="bg-green-600 hover:bg-green-700 text-white p-2 rounded-full transition-all duration-200 pointer-events-auto">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 19l-7-7 7-7"></path>
                                            </svg>
                                        </button>

                                        <!-- Next Button -->
                                        <button @click="nextSlide()"
                                            class="bg-green-600 hover:bg-green-700 text-white p-2 rounded-full transition-all duration-200 pointer-events-auto">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- PDF Viewer Modal -->
    <div x-data="{ showModal: false, archivoUrl: '' }" x-show="showModal"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[9999]" style="display: none;"
        @keydown.escape.window="showModal = false" @ver-archivo.window="showModal = true; archivoUrl = $event.detail.url">

        <div class="bg-white rounded-lg w-full max-w-4xl mx-4 max-h-[90vh] overflow-hidden"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95"
            @click.stop>

            <div class="relative">
                <button @click="showModal = false; archivoUrl = ''"
                    class="absolute top-4 right-4 z-10 bg-black bg-opacity-75 hover:bg-opacity-90 text-white p-2 rounded-full transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>

                <div class="w-full">
                    <iframe x-bind:src="archivoUrl" width="100%" height="700" frameborder="0" scrolling="no"
                        marginheight="0" marginwidth="0">
                    </iframe>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Handle PDF viewer modal
                document.querySelectorAll('[data-action="ver-archivo"]').forEach(function (element) {
                    element.addEventListener('click', function (e) {
                        e.preventDefault();

                        const archivoUrl = this.getAttribute('data-archivo-url');

                        // Dispatch custom event for Alpine.js modal
                        window.dispatchEvent(new CustomEvent('ver-archivo', {
                            detail: { url: archivoUrl }
                        }));
                    });
                });
            });
        </script>
    @endsection
@endsection