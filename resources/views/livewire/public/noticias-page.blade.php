<div>
    <!-- Banner -->
    <div class="w-full h-[35vh] relative">
        <img src="{{ asset('assets/images/casa/banner.jpg') }}" alt="Noticias Casa Gallina" class="w-full h-full object-cover">
    </div>

    <!-- Intro Section -->
    <section class="pt-8">
        <div class="container mx-auto">
            <div class="flex flex-col py-8">
                <div class="">
                    <!-- Section Title -->
                    <div class="text-center border-b-2 border-green-600 pb-2 mb-2">
                        <span class="bg-green-600 px-8 py-2 text-white font-serif text-2xl leading-4">Noticias</span>
                    </div>
                    <!-- Intro Text -->
                    <div class="font-serif text-green-600 text-xl leading-6 py-4 md:px-16 pb-2 text-center">
                        Mantente al día con las últimas noticias, eventos y actividades de Casa Gallina y la comunidad.
                    </div>

                    <!-- Intro Description -->
                    <div class="font-libre text-gray-600 leading-5 py-2 md:px-16 tracking-wide space-y-2">
                        <p>Aquí encontrarás artículos, crónicas, entrevistas y reseñas sobre nuestros programas, exposiciones y la vida comunitaria en Santa María la Ribera.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Filters Section -->
    <section class="pb-8">
        <div class="container mx-auto">
            <div class="flex flex-col md:flex-row justify-end gap-4 mb-6">

                <flux:label>Filtrar por:</flux:label>

                <!-- Category Filter -->
                <div class="md:w-64">
                    <flux:select wire:model.live="selectedCategory">
                        @foreach($categories as $value => $label)
                            <flux:select.option value="{{ $value }}">{{ $label }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>

                <!-- Reset Filters -->
                <flux:button wire:click="resetFilters" color="secondary">
                    Limpiar
                </flux:button>
            </div>

            <!-- Noticias Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @forelse($noticias as $noticia)
                    <div class="">
                        <a href="{{ route('noticia', $noticia->slug) }}" class="block text-center hover:opacity-80 transition-opacity duration-300 !no-underline hover:!no-underline">
                            <div class="mb-3 h-64 relative">
                                @if($noticia->featured_image)
                                    <img src="{{ asset('storage/' . $noticia->featured_image->filename) }}" 
                                         alt="{{ strip_tags($noticia->titulo) }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center">
                                        <!-- Generic news icon -->
                                        <svg class="w-16 h-16 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 002 2H4a2 2 0 01-2-2V5zm3 1h6v4H5V6zm6 6H5v2h6v-2z" clip-rule="evenodd"/>
                                            <path d="M15 7h1a2 2 0 012 2v5.5a1.5 1.5 0 01-3 0V9a1 1 0 00-1-1h-1v-1z"/>
                                        </svg>
                                    </div>
                                @endif
                                
                                <!-- Tag Badge on top-right -->
                                @if($noticia->primary_tag_name)
                                    <div class="absolute top-2 right-2 bg-green-600 text-white px-2 py-1 text-xs font-medium rounded-md shadow-lg">
                                        {{ $noticia->primary_tag_name }}
                                    </div>
                                @endif
                            </div>
                            <div class="text-left">

                                <!-- Title -->
                                <h3 class="font-sans text-green-600 !text-xl leading-6 tracking-tight mb-2">
                                    {{ strip_tags($noticia->titulo) }}
                                </h3>

                                <!-- Excerpt -->
                                <p class="text-gray-600 text-sm mb-2">{{ $noticia->excerpt }}</p>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <div class="text-gray-500 text-lg">No se encontraron noticias</div>
                        @if($search || $selectedCategory !== 'all')
                            <button wire:click="resetFilters" 
                                    class="mt-4 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                Mostrar todas las noticias
                            </button>
                        @endif
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $noticias->links('components.pagination') }}
            </div>
        </div>
    </section>
</div>
