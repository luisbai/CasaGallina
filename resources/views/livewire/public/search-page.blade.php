<div>

    @if($hasQuery)
        <!-- Filters and Results Section -->
        <section class="pb-8">
            <div class="container mx-auto">

                <div class="flex justify-between items-center mb-6">
                    @if($hasQuery)
                        <!-- Search Stats -->
                        <div class="text-center text-gray-600">
                            @if($totalResults > 0)
                                <p class="mb-0">{{ $totalResults }} {{ $language === 'en' ? 'results found for' : 'resultados encontrados para' }} "<strong>{{ $query }}</strong>"</p>
                            @else
                                <p class="mb-0">{{ $language === 'en' ? 'No results found for' : 'No se encontraron resultados para' }} "<strong>{{ $query }}</strong>"</p>
                            @endif
                        </div>
                    @endif
                    <!-- Filter Buttons -->
                    <div class="flex flex-col md:flex-row justify-center items-center gap-4">
                        <label class="font-medium">{{ $language === 'en' ? 'Filter by' : 'Filtrar por' }}:</label>

                        <div class="flex flex-wrap gap-2 justify-center">
                            <button
                                wire:click="filterBy('all')"
                                class="px-3 py-1 text-sm rounded {{ $filter === 'all' ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700' }}"
                            >
                                {{ $language === 'en' ? 'All' : 'Todos' }} ({{ $typeCounts['all'] }})
                            </button>

                            <button
                                wire:click="filterBy('noticias')"
                                class="px-3 py-1 text-sm rounded {{ $filter === 'noticias' ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700' }}"
                            >
                                {{ $language === 'en' ? 'News' : 'Noticias' }} ({{ $typeCounts['noticias'] }})
                            </button>

                            <button
                                wire:click="filterBy('programas')"
                                class="px-3 py-1 text-sm rounded {{ $filter === 'programas' ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700' }}"
                            >
                                {{ $language === 'en' ? 'Programs' : 'Programas' }} ({{ $typeCounts['programas'] }})
                            </button>

                            <button
                                wire:click="filterBy('exposiciones')"
                                class="px-3 py-1 text-sm rounded {{ $filter === 'exposiciones' ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700' }}"
                            >
                                {{ $language === 'en' ? 'Exhibitions' : 'Exposiciones' }} ({{ $typeCounts['exposiciones'] }})
                            </button>

                            <button
                                wire:click="filterBy('publicaciones')"
                                class="px-3 py-1 text-sm rounded {{ $filter === 'publicaciones' ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700' }}"
                            >
                                {{ $language === 'en' ? 'Publications' : 'Publicaciones' }} ({{ $typeCounts['publicaciones'] }})
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Results Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    @forelse($results as $result)
                        <div class="">
                            <a href="{{ $result['url'] }}" class="block text-center hover:opacity-80 transition-opacity duration-300 !no-underline hover:!no-underline">
                                <div class="mb-3 h-64 relative {{ $result['type'] === 'publicacion' ? 'flex justify-center' : '' }}">
                                    @if($result['image'])
                                        <img src="{{ $result['image'] }}"
                                             alt="{{ $result['title'] }}"
                                             class="{{ $result['type'] === 'publicacion' ? 'h-full w-auto object-contain' : 'w-full h-full object-cover' }}">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center">
                                            @if($result['type'] === 'noticia')
                                                <!-- News icon -->
                                                <svg class="size-14 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-newspaper-icon lucide-newspaper"><path d="M15 18h-5"/><path d="M18 14h-8"/><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-4 0v-9a2 2 0 0 1 2-2h2"/><rect width="8" height="4" x="10" y="6" rx="1"/></svg>
                                            @elseif($result['type'] === 'programa')
                                                <!-- Program icon -->
                                                <svg class="size-14 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-leaf-icon lucide-leaf"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/></svg>
                                            @else
                                                <!-- Publication icon -->
                                                <svg class="size-14 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-book-heart-icon lucide-book-heart"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20"/><path d="M8.62 9.8A2.25 2.25 0 1 1 12 6.836a2.25 2.25 0 1 1 3.38 2.966l-2.626 2.856a.998.998 0 0 1-1.507 0z"/></svg>
                                            @endif
                                        </div>
                                    @endif

                                    <!-- Content Type Badge -->
                                    <div class="absolute top-2 right-2 px-2 py-1 text-xs font-medium rounded-md shadow-lg text-white
                                        @if($result['type'] === 'noticia') bg-green-600
                                        @elseif($result['type'] === 'programa') bg-blue-600
                                        @elseif($result['type'] === 'exposicion') bg-purple-600
                                        @else bg-orange-600
                                        @endif">
                                        @if($result['type'] === 'noticia')
                                            {{ $language === 'en' ? 'News' : 'Noticia' }}
                                        @elseif($result['type'] === 'programa')
                                            {{ $language === 'en' ? 'Program' : 'Programa' }}
                                        @elseif($result['type'] === 'exposicion')
                                            {{ $language === 'en' ? 'Exhibition' : 'Exposición' }}
                                        @else
                                            {{ $language === 'en' ? 'Publication' : 'Publicación' }}
                                        @endif
                                    </div>
                                </div>
                                <div class="text-left">
                                    <!-- Title -->
                                    <h3 class="font-sans text-green-600 !text-xl leading-6 tracking-tight mb-2">
                                        {{ $result['title'] }}
                                    </h3>

                                    <!-- Excerpt -->
                                    <p class="text-gray-600 text-sm mb-2">{{ $result['excerpt'] }}</p>
                                </div>
                            </a>
                        </div>
                    @empty
                        @if($hasQuery)
                            <div class="col-span-full text-center py-12">
                                <div class="text-gray-500 text-lg">
                                    {{ $language === 'en' ? 'No results found for your search.' : 'No se encontraron resultados para tu búsqueda.' }}
                                </div>
                                <p class="text-gray-400 mt-2">
                                    {{ $language === 'en' ? 'Try different keywords or check the spelling.' : 'Intenta con otras palabras clave o verifica la ortografía.' }}
                                </p>
                            </div>
                        @endif
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($results->hasPages())
                    <div class="mt-12">
                        {{ $results->links('components.pagination') }}
                    </div>
                @endif
            </div>
        </section>
    @else
        <!-- Empty State - No Query -->
        <section class="pb-16">
            <div class="container mx-auto text-center">
                <div class="max-w-md mx-auto">
                    <svg class="mx-auto h-24 w-24 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">
                        {{ $language === 'en' ? 'Start your search' : 'Comienza tu búsqueda' }}
                    </h3>
                    <p class="text-gray-500">
                        {{ $language === 'en'
                            ? 'Enter a search term to find relevant content.'
                            : 'Ingresa un término de búsqueda para encontrar contenido relevante.' }}
                    </p>
                </div>
            </div>
        </section>
    @endif
</div>