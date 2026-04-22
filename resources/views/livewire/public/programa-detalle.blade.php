<div class="programa-detalle">

        <!-- Hero Banner Section -->
        <div class="w-full h-[20vh] relative">
            @if($categoria->multimedia)
                <img src="{{ asset('storage/' . $categoria->multimedia->filename) }}" alt="{{ $categoria->nombre }}" class="w-full h-full object-cover">
            @else
                <img src="{{ asset('assets/images/casa/banner.jpg') }}" alt="{{ $categoria->nombre }}" class="w-full h-full object-cover">
            @endif
        </div>

        <!-- Intro Section -->
        <section class="pt-8">
            <div class="container mx-auto">
                <div class="flex flex-col py-8 ">
                    <div class="">
                        <!-- Section Title -->
                        <div class="text-center border-b-2 border-green-600 pb-2 mb-2">
                            <span class="bg-green-600 px-8 py-2 text-white font-serif text-2xl leading-4">
                                {{ $categoria->nombre }}
                            </span>
                        </div>

                        <!-- Intro Text -->
                        @if($categoria->descripcion)
                        <div class="font-serif text-green-600 text-xl leading-6 pt-4 md:px-16 text-center">
                            {!! $categoria->descripcion !!}
                        </div>
                        @else
                        <div class="font-serif text-green-600 text-xl leading-6 pt-4 md:px-16 pb-2 text-center">
                            Explora las actividades y programas desarrollados dentro de esta categoría, organizadas por año para facilitar tu navegación.
                        </div>
                        @endif

                        @if($categoria->texto)
                        <div class="font-serif text-gray-600 text-lg leading-6 md:px-16 pb-2 text-center">
                            {!! $categoria->texto !!}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content Section with Sidebar -->
        <section class="pb-12">
            <div class="container mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

                    <!-- Sidebar -->
                    <div class="lg:col-span-1">
                        <div class="bg-white border-t-2 border-green-600 py-6 px-4">
                            {!! $categoria->sidebar !!}

                            @if($this->sidebarContent['aliados'] ?? false)
                                <div class="text-sm font-bold text-green-600 uppercase mb-2 mt-4">ALIADOS</div>
                                <div class="text-sm text-gray-700 mb-4">{{ implode('; ', $this->sidebarContent['aliados']) }}</div>
                            @endif

                            @if($this->sidebarContent['colaboradores'] ?? false)
                                <div class="text-sm font-bold text-green-600 uppercase mb-2 mt-4">COLABORADORES</div>
                                <div class="text-sm text-gray-700 mb-4">{{ implode('; ', $this->sidebarContent['colaboradores']) }}</div>
                            @endif
                        </div>
                    </div>

                    <!-- Main Content Area -->
                    <div class="lg:col-span-3 py-6 border-t-2 border-green-600">

                        <!-- Year Filter -->
                        <div class="mb-8 bg-white">
                            <div class="flex flex-wrap items-center gap-4">
                                <label class="text-sm font-bold text-green-600 uppercase m-0">Filtrar por año</label>
                                <div class="flex flex-wrap items-center gap-2">
                                    <!-- All Years Button -->
                                    <button wire:click="clearFilter"
                                            class="px-3 py-1 text-sm font-medium rounded-md transition-colors duration-200
                                                   {{ !$selectedYear ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                        Todos ({{ $this->totalActividades }})
                                    </button>

                                    <!-- Year Buttons -->
                                    @foreach($this->anosDisponibles as $ano)
                                        <button wire:click="filterByYear({{ $ano }})"
                                                class="px-3 py-1 text-sm font-medium rounded-md transition-colors duration-200
                                                       {{ $selectedYear == $ano ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                            {{ $ano }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Loading Indicator -->
                        <div wire:loading class="text-center py-4">
                            <div class="inline-flex items-center px-4 py-2 font-semibold leading-6 text-sm transition ease-in-out duration-150">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Cargando...
                            </div>
                        </div>

                        <!-- Activities Grid -->
                        <div wire:loading.remove>
                            @if($this->programas->count() > 0)
                                <div class="grid grid-cols-1 gap-6">
                                    @foreach($this->programas as $programa)
                                        <div class="flex flex-col gap-6">
                                            <div class="flex flex-col md:flex-row gap-6">
                                                <!-- Image Carousel -->
                                                @if($programa->multimedia && $programa->multimedia->count() > 0)
                                                    <div class="relative h-60 md:h-48 w-full md:w-80 overflow-hidden group" x-data="{ currentIndex: 0, totalImages: {{ $programa->multimedia->count() }} }">
                                                        <!-- Images Container -->
                                                        <div class="relative w-full h-full">
                                                            @foreach($programa->multimedia as $index => $multimedia)
                                                                <div class="absolute inset-0 transition-opacity duration-300"
                                                                     x-show="currentIndex === {{ $index }}"
                                                                     x-transition:enter="transition-opacity duration-300"
                                                                     x-transition:enter-start="opacity-0"
                                                                     x-transition:enter-end="opacity-100"
                                                                     x-transition:leave="transition-opacity duration-300"
                                                                     x-transition:leave-start="opacity-100"
                                                                     x-transition:leave-end="opacity-0">
                                                                    <img src="{{ asset('storage/' . ($multimedia->multimedia?->filename ?? 'default-programa.jpg')) }}"
                                                                         alt="{{ $programa->titulo }} - Imagen {{ $index + 1 }}"
                                                                         class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                                                                        loading="lazy">
                                                                </div>
                                                            @endforeach
                                                        </div>

                                                        <!-- Navigation Controls (visible on hover) -->
                                                        @if($programa->multimedia->count() > 1)
                                                            <div class="absolute inset-0 flex items-center justify-between p-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                                                <!-- Previous Button -->
                                                                <button @click="currentIndex = currentIndex > 0 ? currentIndex - 1 : totalImages - 1"
                                                                        class="bg-green-600 hover:bg-green-700 text-white p-2 rounded-full transition-all duration-200">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                                                    </svg>
                                                                </button>

                                                                <!-- Next Button -->
                                                                <button @click="currentIndex = currentIndex < totalImages - 1 ? currentIndex + 1 : 0"
                                                                        class="bg-green-600 hover:bg-green-700 text-white p-2 rounded-full transition-all duration-200">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                                    </svg>
                                                                </button>
                                                            </div>

                                                            <!-- Image Counter -->
                                                            <div class="absolute top-2 right-2 bg-green-600 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                                                <span x-text="currentIndex + 1"></span>/<span x-text="totalImages"></span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endif

                                                <!-- Content -->
                                                <div class="flex flex-col gap-2 max-w-sm">
                                                    <h3 class="!text-xl font-serif text-green-600 leading-tight programa-title">
                                                        {!! $programa->titulo !!}
                                                    </h3>

                                                    <div class="flex flex-col gap-2 font-serif">
                                                        <div class="text-gray-600 text-base m-0 programa-metadata">
                                                            {!! $programa->metadatos !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="font-serif text-gray-600 text-[0.9rem] space-y-4 py-2 px-2">
                                                {!! $programa->contenido !!}
                                            </div>
                                        </div>

                                        <div class="mx-auto w-60 pb-4">
                                            <div class="h-[2px] bg-green-600 w-full"></div>
                                        </div>
                                    @endforeach
                                </div>

                            @else
                                <!-- No Results -->
                                <div class="text-center py-8 bg-gray-50 rounded-xl mx-auto max-w-lg mt-16">
                                    <svg class="mx-auto h-12 w-12 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <h3 class="mt-2 !text-xl font-medium text-green-600">No hay programas disponibles</h3>
                                    <p class="!text-sm text-gray-600 mt-2">
                                        @if($selectedYear)
                                            No se encontraron programas para el año {{ $selectedYear }} en esta categoría.
                                        @else
                                            No hay programas disponibles en esta categoría en este momento.
                                        @endif
                                    </p>
                                    @if($selectedYear)
                                        <div class="mt-4">
                                            <button wire:click="clearFilter" class="text-green-600 hover:text-green-700 font-medium text-sm">
                                                Ver todos los programas
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
</div>
