@extends('layouts.boilerplate')

@section('meta')
    {{-- Alpine.js is provided by Livewire, no need to load it separately --}}
@endsection

@section('title', ' - ' . strip_tags($noticia->titulo))

@section('content')
    <div class="container mx-auto px-4">
        <div id="noticia-index">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('noticias') }}" 
                   class="inline-flex items-center !text-green-600 hover:!text-green-800 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Volver a noticias
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div>
                    <!-- Image/Video Carousel -->
                    @php
                        $video = $noticia->videos->first();
                        $totalSlides = $noticia->multimedia->count() + ($video ? 1 : 0);
                    @endphp

                    @if($totalSlides > 0)
                        <div x-data="{
                            currentImageIndex: 0,
                            totalImages: {{ $totalSlides }},
                            isPlayingVideo: false,
                            playVideo() {
                                this.isPlayingVideo = true;
                            },
                            stopVideo() {
                                this.isPlayingVideo = false;
                            }
                        }">
                            <div class="relative h-96 w-full overflow-hidden group rounded-lg shadow-md">
                                <!-- Video Slide (First slide if video exists) -->
                                @if($video)
                                    <div class="absolute inset-0 transition-opacity duration-300 z-10"
                                         x-show="currentImageIndex === 0"
                                         x-transition:enter="transition-opacity duration-300"
                                         x-transition:enter-start="opacity-0"
                                         x-transition:enter-end="opacity-100"
                                         x-transition:leave="transition-opacity duration-300"
                                         x-transition:leave-start="opacity-100"
                                         x-transition:leave-end="opacity-0">

                                        <!-- Video Thumbnail (shown when not playing) -->
                                        <div x-show="!isPlayingVideo" class="relative w-full h-full cursor-pointer z-10" @click="playVideo()">
                                            <img src="{{ $video->thumbnail_url }}"
                                                 alt="{{ strip_tags($noticia->titulo) }} - Video"
                                                 class="w-full h-full object-cover"
                                                 loading="lazy">

                                            <!-- Play Button Overlay -->
                                            <div class="absolute inset-0 flex items-center justify-center bg-black/20">
                                                <div class="bg-green-600 hover:bg-green-700 text-white rounded-full p-4 transform hover:scale-110 transition-all duration-300 shadow-lg">
                                                    <svg class="w-8 h-8 ml-1" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M8 5v14l11-7z"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Video Player (shown when playing) -->
                                        <div x-show="isPlayingVideo" class="relative w-full h-full">
                                            <button @click="stopVideo()"
                                                    class="absolute top-4 right-4 z-20 bg-black bg-opacity-75 hover:bg-opacity-90 text-white p-3 rounded-full transition-all duration-200">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>

                                            <iframe x-show="isPlayingVideo"
                                                    :src="isPlayingVideo ? 'https://www.youtube.com/embed/{{ $video->youtube_id }}?autoplay=1' : ''"
                                                    title="Video Player"
                                                    allowfullscreen
                                                    allow="autoplay"
                                                    class="w-full h-full">
                                            </iframe>
                                        </div>
                                    </div>
                                @endif

                                <!-- Images Container -->
                                <div class="relative w-full h-full">
                                    @foreach($noticia->multimedia as $index => $multimedia)
                                        @php
                                            $slideIndex = $video ? $index + 1 : $index;
                                        @endphp
                                        <div class="absolute inset-0 transition-opacity duration-300 z-10"
                                             x-show="currentImageIndex === {{ $slideIndex }}"
                                             x-transition:enter="transition-opacity duration-300"
                                             x-transition:enter-start="opacity-0"
                                             x-transition:enter-end="opacity-100"
                                             x-transition:leave="transition-opacity duration-300"
                                             x-transition:leave-start="opacity-100"
                                             x-transition:leave-end="opacity-0">
                                            <img src="{{ $multimedia?->url }}"
                                                 alt="{{ strip_tags($noticia->titulo) }} - Imagen {{ $index + 1 }}"
                                                 class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                                                 loading="lazy">
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Navigation Controls (visible on hover) -->
                                @if($totalSlides > 1)
                                    <div class="absolute inset-0 flex items-center justify-between p-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none z-20">
                                        <!-- Previous Button -->
                                        <button @click="currentImageIndex = currentImageIndex > 0 ? currentImageIndex - 1 : totalImages - 1"
                                                class="bg-green-600 hover:bg-green-700 text-white p-2 rounded-full transition-all duration-200 pointer-events-auto">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                            </svg>
                                        </button>

                                        <!-- Next Button -->
                                        <button @click="currentImageIndex = currentImageIndex < totalImages - 1 ? currentImageIndex + 1 : 0"
                                                class="bg-green-600 hover:bg-green-700 text-white p-2 rounded-full transition-all duration-200 pointer-events-auto">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- Image Counter -->
                                    <div class="absolute top-2 right-2 bg-green-600 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-20">
                                        <span x-text="currentImageIndex + 1"></span>/<span x-text="totalImages"></span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="mb-6">
                            <img src="{{ asset('assets/images/casa/banner.jpg') }}"
                                 class="w-full h-80 object-cover rounded-lg shadow-md"
                                 alt="{{ strip_tags($noticia->titulo) }}">
                        </div>
                    @endif
                </div>

                <div>
                    <div class="flex flex-col gap-2">

                        <!-- Title -->
                        <h1 class="!text-3xl !font-bold text-green-600 !tracking-tight mb-6 leading-tight">
                            {!! str_replace(['<p>', '</p>'], '', $noticia->titulo) !!}
                        </h1>

                        <!-- Description -->
                        @if($noticia->descripcion)
                            <div class="font-libre text-gray-700 text-lg leading-6 mb-6">
                                {{ $noticia->descripcion }}
                            </div>
                        @endif

                        <!-- Author -->
                        @if($noticia->autor)
                            <div class="flex items-center gap-2 text-green-600 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                  </svg>
                                  
                                <span class="!text-gray-600">{{ $noticia->autor }}</span>
                            </div>
                        @endif

                        <div class="flex items-center gap-2 text-green-600 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                              </svg>

                            <time class="!text-gray-600">{{ $noticia->fecha_publicacion->isoFormat('D MMMM Y') }}</time>
                        </div>

                        <!-- Tag Display -->
                        @if($noticia->primary_tag_name)
                            <div class="flex items-center gap-2 text-green-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                                </svg>
                                <span class="!text-gray-600 bg-green-100 px-2 py-1 rounded-md text-sm font-medium">{{ $noticia->primary_tag_name }}</span>
                                
                                
                            </div>
                        @endif

                        @if($noticia->enable_donations)
                            <button onclick="document.getElementById('donation-section').scrollIntoView({behavior: 'smooth'})" 
                                    class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition-colors duration-200 mt-4 mr-auto inline-block">
                                Apoya a esta causa
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Content Separator -->
                <div class="noticia-content col-span-2 pb-16">
                    <!-- Main Content -->
                    @if($noticia->contenido)
                        <div class="noticia-content">
                            {!! $noticia->contenido !!}
                        </div>
                    @endif

                    <!-- Content Image (centered below main content) -->
                    @if($noticia->contentImage)
                        <div class="flex justify-center mt-12">
                            <div class="w-full md:w-1/2">
                                <img src="{{ $noticia->contentImage?->url }}"
                                     alt="{{ strip_tags($noticia->titulo) }}"
                                     class="w-full h-auto object-cover rounded-lg shadow-md">
                            </div>
                        </div>
                    @endif
                </div>


            </div>
        </div>
    </div>

    <!-- Donation Section -->
    @if($noticia->enable_donations)
        <section class="py-20 bg-green-800" id="donation-section">
            <div class="container mx-auto px-4">
                <div class="max-w-6xl mx-auto">

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                        <!-- Left side - Image -->
                        <div class="flex flex-col rounded-xl overflow-hidden donation-section">
                            <div class="relative h-[450px] bg-green-600 overflow-hidden">
                                @if($noticia->donationMultimedia)
                                    <img src="{{ $noticia->donationMultimedia?->url }}" 
                                         alt="Apoya esta causa" 
                                         class="w-full h-full object-cover">
                                @elseif($noticia->featured_image)
                                    <img src="{{ $noticia->featured_image?->url }}" 
                                         alt="Apoya esta causa" 
                                         class="w-full h-full object-cover">
                                @else
                                    <img src="{{ asset('assets/images/donaciones/modal-bg4.jpg') }}" 
                                         alt="Apoya esta causa" 
                                         class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="donation-content">
                                {!! $noticia->donation_content !!}
                            </div>  
                        </div>

                        <!-- Right side - Donation Form -->
                        <livewire:components.donation-form :noticia="$noticia" />
                    </div>
                </div>
            </div>
        </section>

    @endif

    <!-- Related Articles -->
    @if($relacionadas->count() > 0)
        <section class="py-20 bg-gray-50">
            <div class="container mx-auto">
                <!-- Section Title -->
                <div class="text-center border-b-2 border-green-600 pb-2 mb-8">
                    <span class="bg-green-600 px-8 py-2 text-white font-serif text-2xl leading-4">Noticias relacionadas</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($relacionadas as $relacionada)
                        <div class="">
                            <a href="{{ route('noticia', $relacionada->slug) }}" class="block text-center hover:opacity-80 transition-opacity duration-300 !no-underline hover:!no-underline">
                                <div class="mb-3 h-64">
                                    @if($relacionada->featured_image)
                                        <img src="{{ $relacionada->featured_image?->url }}" 
                                             alt="{{ strip_tags($relacionada->titulo) }}" 
                                             class="w-full h-full object-cover rounded-lg shadow-md">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center rounded-lg shadow-md">
                                            <!-- Generic news icon -->
                                            <svg class="w-16 h-16 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 002 2H4a2 2 0 01-2-2V5zm3 1h6v4H5V6zm6 6H5v2h6v-2z" clip-rule="evenodd"/>
                                                <path d="M15 7h1a2 2 0 012 2v5.5a1.5 1.5 0 01-3 0V9a1 1 0 00-1-1h-1v-1z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="text-left">
                                    <!-- Title -->
                                    <h3 class="font-sans text-green-600 !text-xl leading-6 tracking-tight mb-2">
                                        {{ strip_tags($relacionada->titulo) }}
                                    </h3>
                                    <!-- Excerpt -->
                                    <p class="text-gray-600 text-sm mb-2">{{ $relacionada->excerpt }}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Thank You Modal -->
    <div class="modal fade" id="modal-gracias-donacion" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="donacion-imagen">
                                @if($noticia->donationMultimedia)
                                    <img src="{{ $noticia->donationMultimedia?->url }}" alt="¡Muchas gracias!">
                                @elseif($noticia->featured_image)
                                    <img src="{{ $noticia->featured_image?->url }}" alt="¡Muchas gracias!">
                                @else
                                    <img src="{{ asset('assets/images/donaciones/modal-bg4.jpg') }}" alt="¡Muchas gracias!">
                                @endif
                            </div>

                            <div class="donacion-text-wrapper">
                                <h3>¡Muchas gracias!</h3>

                                <p>Tu aportación para <strong>{{ strip_tags($noticia->titulo) }}</strong> <span>ayudará</span> a seguir creando un <span>cambio social</span> a través de <span>procesos comunitarios y culturales</span> en favor del bien común y el medio ambiente.</p>

                                <div class="text-right mt-12">
                                    <a href="{{ route('donaciones') }}"
                                       class="px-4 py-2 rounded-xl bg-forest text-white mt-4 hover:no-underline hover:bg-green-800/90 transition">
                                        Más información
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="donacion-content">
                                <h3>Casa Gallina: 10 años de trabajo comunitario</h3>
                                
                                @if($noticia->donation_content)
                                    <div class="donation-custom-content">
                                        {!! $noticia->donation_content !!}
                                    </div>
                                @else
                                    <div class="default-content">
                                        <p>Gracias por apoyar nuestro trabajo comunitario. Tu contribución nos ayuda a seguir construyendo espacios de transformación social y cultural.</p>
                                    </div>
                                @endif

                                <div class="text-center mt-4">
                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                                        Cerrar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(request()->has('gracias'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Show thank you modal if payment was successful
                const modal = new bootstrap.Modal(document.getElementById('modal-gracias-donacion'));
                modal.show();
                
                // Clean up URL after showing modal
                const url = new URL(window.location);
                url.searchParams.delete('gracias');
                url.searchParams.delete('donation_id');
                window.history.replaceState({}, document.title, url.pathname);
            });
        </script>
    @endif
@endsection