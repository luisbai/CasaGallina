<div class="grid grid-cols-1 md:grid-cols-12 gap-6">
    <div class="md:col-span-7">
        <div class="flex justify-between items-center mb-4">
            <flux:heading size="xl" class="!text-forest-800 font-serif">
                Programa
            </flux:heading>
        </div>

        <div class="flex items-center justify-between mb-4 gap-8">
            <flux:input placeholder="Buscar programa..." wire:model.live="search" size="sm" icon="magnifying-glass" />

            <flux:modal.trigger name="createProgram">
                <flux:tooltip content="Crear programa">
                    <flux:button size="sm" icon="plus" variant="primary" wire:click="openCreateProgramModal">
                    </flux:button>
                </flux:tooltip>
            </flux:modal.trigger>
        </div>

        <flux:card class="!px-5 !pt-1.5 !pb-4 shadow-sm">
            <flux:table :paginate="$this->programs">
                <flux:table.columns>
                    <flux:table.column>Categoría</flux:table.column>
                    <flux:table.column sortable :sorted="$sortBy === 'titulo'" :direction="$sortDirection"
                        wire:click="sort('titulo')">Título</flux:table.column>
                    <flux:table.column>Acciones</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @forelse ($this->programs as $program)
                        <flux:table.row :key="$program->id" class="group">
                            <flux:table.cell>
                                @if ($program->tags->first())
                                    <flux:badge size="sm" color="green">{{ $program->tags->first()->nombre }}</flux:badge>
                                @endif
                            </flux:table.cell>

                            <flux:table.cell wire:click.prevent="editProgram({{ $program->id }})">
                                <span class="group-hover:underline cursor-pointer">
                                    {{ Str::of($program->clean_title)->limit(45) }}
                                </span>
                            </flux:table.cell>

                            <flux:table.cell class="space-x-1">
                                <flux:tooltip content="Editar">
                                    <flux:button wire:click="editProgram({{ $program->id }})" size="xs" variant="subtle"
                                        icon="pencil" class="!text-forest-800 !cursor-pointer">
                                    </flux:button>
                                </flux:tooltip>
                                <flux:button x-on:click="window.Swal.fire({
                                                            title: '¿Estás seguro?',
                                                            text: '¿Deseas eliminar este programa? Esta acción no se puede deshacer.',
                                                            icon: 'warning',
                                                            showCancelButton: true,
                                                            confirmButtonText: 'Si, eliminar',
                                                            cancelButtonText: 'Cancelar',
                                                            confirmButtonColor: '#d33',
                                                        }).then((result) => {
                                                            if (result.isConfirmed) {
                                                                $wire.delete({{ $program->id }})
                                                            }
                                                        })" size="xs" variant="subtle" icon="trash"
                                    class="!text-forest-800 !cursor-pointer">
                                </flux:button>
                            </flux:table.cell>
                        </flux:table.row>
                    @empty
                        <flux:table.row>
                            <flux:table.cell colspan="5" class="text-center">
                                No hay programas
                            </flux:table.cell>
                        </flux:table.row>
                    @endforelse
                </flux:table.rows>
            </flux:table>
        </flux:card>
    </div>
    <div class="md:col-span-5">
        <div class="flex justify-between items-center mb-4">
            <flux:heading size="xl" class="!text-forest-800 font-serif">
                Categorías
            </flux:heading>
        </div>

        <div class="flex items-center justify-between mb-4 gap-8">
            <flux:input placeholder="Buscar categoría..." wire:model.live="searchTag" size="sm"
                icon="magnifying-glass" />

            <flux:modal.trigger name="createCategory">
                <flux:tooltip content="Crear categoría">
                    <flux:button size="sm" icon="plus" variant="primary" wire:click="openCreateCategoryModal">
                    </flux:button>
                </flux:tooltip>
            </flux:modal.trigger>
        </div>

        <flux:card class="!px-5 !pt-1.5 !pb-4 shadow-sm">
            <flux:table :paginate="$this->categories" class="!text-sm">
                <flux:table.columns>
                    <flux:table.column>Nombre</flux:table.column>
                    <flux:table.column>Tipo</flux:table.column>
                    <flux:table.column>Acciones</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @forelse ($this->categories as $category)
                        <flux:table.row :key="$category->id">
                            <flux:table.cell>{{ $category->nombre }}</flux:table.cell>
                            <flux:table.cell>
                                @if ($category->type === 'programa-local')
                                    <flux:badge size="sm" color="green">Local</flux:badge>
                                @elseif ($category->type === 'programa-externo')
                                    <flux:badge size="sm" color="blue">Externo</flux:badge>
                                @endif
                            </flux:table.cell>
                            <flux:table.cell class="space-x-1">
                                <flux:tooltip content="Editar">
                                    <flux:button wire:click="editCategory({{ $category->id }})" size="xs" variant="subtle"
                                        icon="pencil" class="!text-forest-800 !cursor-pointer">
                                    </flux:button>
                                </flux:tooltip>
                                <flux:button x-on:click="window.Swal.fire({
                                                            title: '¿Estás seguro?',
                                                            text: '¿Deseas eliminar esta categoría? Esta acción no se puede deshacer.',
                                                            icon: 'warning',
                                                            showCancelButton: true,
                                                            confirmButtonText: 'Si, eliminar',
                                                            cancelButtonText: 'Cancelar',
                                                            confirmButtonColor: '#d33',
                                                        }).then((result) => {
                                                            if (result.isConfirmed) {
                                                                $wire.deleteCategory({{ $category->id }})
                                                            }
                                                        })" size="xs" variant="subtle" icon="trash"
                                    class="!text-forest-800 !cursor-pointer">
                                </flux:button>
                            </flux:table.cell>
                        </flux:table.row>
                    @empty
                        <flux:table.row>
                            <flux:table.cell colspan="3" class="text-center">
                                No hay categorías
                            </flux:table.cell>
                        </flux:table.row>
                    @endforelse
                </flux:table.rows>
            </flux:table>
        </flux:card>
    </div>

    {{-- CREATE PROGRAMA MODAL --}}
    <flux:modal name="createProgram" class="md:max-w-7xl">
        <flux:heading size="lg">
            Crear Actividad
        </flux:heading>
        <flux:subheading>
            Llena los campos para crear la actividad (bilingüe: español e inglés)
        </flux:subheading>
        <div class="flex flex-col gap-4 w-full mt-6">
            <form wire:submit="store" class="space-y-6">

                {{-- Metadata Section --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4 bg-gray-50 rounded-lg">
                    <div class="space-y-4">
                        <flux:radio.group wire:model="estado" label="Estado">
                            <flux:radio value="public" label="Publicada" />
                            <flux:radio value="private" label="Privada" />
                        </flux:radio.group>

                        <flux:radio.group wire:model.live="tipo" label="Tipo">
                            <flux:radio value="local" label="Programa Local"
                                description="Huerto, Cocina, Infancias, Talleres Comunitarios, etc." />
                            <flux:radio value="externo" label="Programa Externo"
                                description="Mapeos, Intercambios territoriales, Educación Ambiental, etc." />
                        </flux:radio.group>
                    </div>

                    <div class="space-y-4">
                        <flux:select label="Categorías" wire:model="selectedTags" wire:key="program-tags-{{ $tipo }}"
                            variant="listbox" multiple selected-suffix="categorías seleccionadas"
                            placeholder="Seleccione categorías">
                            @foreach($this->programTags as $tag)
                                <flux:select.option value="{{ $tag->id }}">{{ $tag->nombre }}</flux:select.option>
                            @endforeach
                        </flux:select>

                        <div class="space-y-2">
                            <flux:date-picker wire:model="fecha" label="Fecha *"
                                placeholder="Selecciona una fecha o escribe texto libre" />
                            <flux:subheading size="sm" class="text-gray-500 !text-xs">
                                Puedes seleccionar una fecha o escribir cualquier texto (2024, verano del 2024, del 2023
                                al 2024, etc.)
                            </flux:subheading>
                        </div>
                    </div>
                </div>

                {{-- Image Upload Section --}}
                <div class="p-4 bg-gray-50 rounded-lg">
                    <flux:input type="file" wire:model="multimedia" label="Imágenes" multiple />
                </div>

                {{-- Assignment Section --}}
                <div class="space-y-3 p-4 bg-gray-50 rounded-lg">
                    <flux:checkbox wire:model.live="assign_to_expo_proyecto"
                        label="Asignar a Exposición o Proyecto Artístico" />

                    @if($assign_to_expo_proyecto)
                        <div class="space-y-2">
                            <flux:field>
                                <flux:label>Buscar Exposición o Proyecto Artístico</flux:label>
                                <livewire:components.autocomplete-search :selectedId="$exposicion_id"
                                    placeholder="Buscar exposiciones y proyectos artísticos..." />
                            </flux:field>
                        </div>
                    @endif
                </div>

                {{-- Bilingual Content Section --}}
                @if($translationError)
                    <div class="mb-4 bg-red-50 border-l-4 border-red-400 p-4 rounded shadow-sm">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <flux:icon.exclamation-circle class="h-5 w-5 text-red-400" />
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700">
                                    {{ $translationError }}
                                </p>
                            </div>
                            <div class="ml-auto pl-3">
                                <div class="-mx-1.5 -my-1.5">
                                    <button type="button" wire:click="$set('translationError', null)"
                                        class="inline-flex bg-red-50 rounded-md p-1.5 text-red-500 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-red-50 focus:ring-red-600">
                                        <span class="sr-only">Close</span>
                                        <flux:icon.x-mark class="h-4 w-4" />
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                    {{-- SPANISH COLUMN --}}
                    <flux:card class="space-y-4">
                        <div class="flex items-center gap-2 mb-4 pb-2 border-b border-gray-200">
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 2a8 8 0 100 16 8 8 0 000-16zM8 9a1 1 0 112 0v4a1 1 0 11-2 0V9zm3-1a1 1 0 10-2 0 1 1 0 002 0z" />
                            </svg>
                            <span class="font-semibold text-gray-700">Español</span>
                        </div>

                        <flux:editor toolbar="italic bold" wire:model="titulo" label="Título *"
                            placeholder="Título del Programa" class="h-28 mb-4" />

                        <flux:editor wire:model="metadatos" label="Ficha"
                            placeholder="Metadatos del programa (opcional)" />

                        <flux:editor wire:model="contenido" label="Contenido *"
                            placeholder="Contenido principal del programa" />
                    </flux:card>

                    {{-- ENGLISH COLUMN --}}
                    <flux:card class="space-y-4">
                        <div class="flex items-center justify-between mb-4 pb-2 border-b border-gray-200">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 2a8 8 0 100 16 8 8 0 000-16zM8 9a1 1 0 112 0v4a1 1 0 11-2 0V9zm3-1a1 1 0 10-2 0 1 1 0 002 0z" />
                                </svg>
                                <span class="font-semibold text-gray-700">English</span>
                            </div>
                            <flux:button wire:click="translateAllProgramFields" wire:loading.attr="disabled" size="xs"
                                variant="ghost" icon="language" class="!text-purple-600 hover:!text-purple-700">
                                <flux:icon.loading wire:loading class="mr-1" />
                                Traducir Todo
                            </flux:button>
                        </div>

                        <div>
                            <flux:label>Title</flux:label>
                            <flux:editor toolbar="italic bold" wire:model="titulo_en" placeholder="Program Title"
                                class="h-28 mb-4" />
                        </div>

                        <div>
                            <flux:label>Metadata</flux:label>
                            <flux:editor wire:model="metadatos_en" placeholder="Program metadata (optional)" />
                        </div>

                        <div>
                            <flux:label>Content</flux:label>
                            <flux:editor wire:model="contenido_en" placeholder="Main program content (optional)" />
                        </div>
                    </flux:card>
                </div>

                <div class="flex justify-end mt-6 pt-4 border-t border-gray-200">
                    <flux:button type="submit" variant="primary">
                        Guardar
                    </flux:button>
                </div>
            </form>
        </div>
    </flux:modal>

    {{-- EDIT PROGRAMA MODAL --}}
    <flux:modal name="editProgram" class="md:w-full md:max-w-5xl">
        <flux:heading size="lg">
            Editar Actividad
        </flux:heading>
        <flux:subheading>
            Actualiza los campos de la actividad (bilingüe: español e inglés)
        </flux:subheading>
        <div class="flex flex-col gap-4 w-full mt-6">
            <form wire:submit="update" class="space-y-6">

                {{-- Metadata Section --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4 bg-gray-50 rounded-lg">
                    <div class="space-y-4">
                        <flux:radio.group wire:model="estado" label="Estado">
                            <flux:radio value="public" label="Publicada" />
                            <flux:radio value="private" label="Privada" />
                        </flux:radio.group>

                        <flux:radio.group wire:model.live="tipo" label="Tipo">
                            <flux:radio value="local" label="Programa Local"
                                description="Huerto, Cocina, Infancias, Talleres Comunitarios, etc." />
                            <flux:radio value="externo" label="Programa Externo"
                                description="Mapeos, Intercambios territoriales, Educación Ambiental, etc." />
                        </flux:radio.group>
                    </div>

                    <div class="space-y-4">
                        <flux:select label="Categorías" wire:model="selectedTags"
                            wire:key="program-tags-edit-{{ $tipo }}" variant="listbox" multiple
                            selected-suffix="categorías seleccionadas" placeholder="Seleccione categorías">
                            @foreach($this->programTags as $tag)
                                <flux:select.option value="{{ $tag->id }}">{{ $tag->nombre }}</flux:select.option>
                            @endforeach
                        </flux:select>

                        <div class="space-y-2">
                            <flux:date-picker wire:model="fecha" label="Fecha *"
                                placeholder="Selecciona una fecha o escribe texto libre" />
                            <flux:subheading size="sm" class="text-gray-500 !text-xs">
                                Puedes seleccionar una fecha o escribir cualquier texto (2024, verano del 2024, del 2023
                                al 2024, etc.)
                            </flux:subheading>
                        </div>
                    </div>
                </div>

                {{-- Image Management Section --}}
                <flux:accordion>
                    <flux:accordion.item expanded heading="Gestión de Imágenes">
                        <div class="space-y-4">
                            @if($this->existingMultimedia->count() > 0)
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700">Imágenes Actuales</label>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                        @foreach($this->existingMultimedia as $multimedia)
                                            <div class="relative group" wire:key="media-{{ $multimedia->id }}">
                                                <img src="{{ Storage::url($multimedia->multimedia->filename) }}"
                                                    alt="Imagen del programa"
                                                    class="w-full h-24 object-cover rounded-lg border border-gray-200">
                                                <button type="button"
                                                    x-on:click="if (! confirm('¿Estás seguro que deseas eliminar esta imagen?')) { event.preventDefault(); event.stopImmediatePropagation(); }"
                                                    wire:click="removeMultimedia({{ $multimedia->multimedia->id }})"
                                                    class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <flux:input type="file" wire:model="multimedia" label="Agregar Nuevas Imágenes" multiple />
                        </div>
                    </flux:accordion.item>
                </flux:accordion>

                {{-- Assignment Section --}}
                <div class="space-y-3 p-4 bg-gray-50 rounded-lg">
                    <flux:checkbox wire:model.live="assign_to_expo_proyecto"
                        label="Asignar a Exposición o Proyecto Artístico" />

                    @if($assign_to_expo_proyecto)
                        <div class="space-y-2">
                            <flux:field>
                                <flux:label>Buscar Exposición o Proyecto Artístico</flux:label>
                                <livewire:components.autocomplete-search :selectedId="$exposicion_id"
                                    placeholder="Buscar exposiciones y proyectos artísticos..." />
                            </flux:field>
                        </div>
                    @endif
                </div>

                {{-- Bilingual Content Section --}}
                @if($translationError)
                    <div class="mb-4 bg-red-50 border-l-4 border-red-400 p-4 rounded shadow-sm">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <flux:icon.exclamation-circle class="h-5 w-5 text-red-400" />
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700">
                                    {{ $translationError }}
                                </p>
                            </div>
                            <div class="ml-auto pl-3">
                                <div class="-mx-1.5 -my-1.5">
                                    <button type="button" wire:click="$set('translationError', null)"
                                        class="inline-flex bg-red-50 rounded-md p-1.5 text-red-500 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-red-50 focus:ring-red-600">
                                        <span class="sr-only">Close</span>
                                        <flux:icon.x-mark class="h-4 w-4" />
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                    {{-- SPANISH COLUMN --}}
                    <flux:card class="space-y-4">
                        <div class="flex items-center gap-2 mb-4 pb-2 border-b border-gray-200">
                            <span class="font-semibold text-gray-700">Español</span>
                        </div>

                        <flux:editor toolbar="italic bold" wire:model="titulo" label="Título *"
                            placeholder="Título del Programa" class="h-28 mb-4" />

                        <flux:editor wire:model="metadatos" label="Ficha"
                            placeholder="Metadatos del programa (opcional)" />

                        <flux:editor wire:model="contenido" label="Contenido *"
                            placeholder="Contenido principal del programa" />
                    </flux:card>

                    {{-- ENGLISH COLUMN --}}
                    <flux:card class="space-y-4">
                        <div class="flex items-center justify-between mb-4 pb-2 border-b border-gray-200">
                            <span class="font-semibold text-gray-700">English</span>
                            <flux:button wire:click="translateAllProgramFields" wire:loading.attr="disabled" size="xs"
                                variant="ghost" icon="language" class="!text-purple-600 hover:!text-purple-700">
                                <flux:icon.loading wire:loading class="mr-1" />
                                Traducir Todo
                            </flux:button>
                        </div>

                        <div>
                            <flux:label>Title</flux:label>
                            <flux:editor toolbar="italic bold" wire:model="titulo_en" placeholder="Program Title"
                                class="h-28 mb-4" />
                        </div>

                        <div>
                            <flux:label>Metadata</flux:label>
                            <flux:editor wire:model="metadatos_en" placeholder="Program metadata (optional)" />
                        </div>

                        <div>
                            <flux:label>Content</flux:label>
                            <flux:editor wire:model="contenido_en" placeholder="Main program content (optional)" />
                        </div>
                    </flux:card>
                </div>

                <div class="flex justify-end mt-6 pt-4 border-t border-gray-200">
                    <flux:button type="button" variant="subtle" wire:click="cancelEdit" class="mr-2">
                        Cancelar
                    </flux:button>
                    <flux:button type="submit" variant="primary">
                        Actualizar
                    </flux:button>
                </div>
            </form>
        </div>
    </flux:modal>

    {{-- CREATE CATEGORIA MODAL --}}
    <flux:modal name="createCategory" class="md:max-w-7xl">
        <flux:heading size="lg">
            Crear Categoría
        </flux:heading>
        <flux:subheading>
            Crea una nueva categoría para organizar contenido (bilingüe: español e inglés)
        </flux:subheading>
        <div class="flex flex-col gap-4 w-full mt-6">
            <form wire:submit="storeCategory" class="space-y-6">

                {{-- Metadata Section --}}
                <div class="p-4 bg-gray-50 rounded-lg space-y-4">
                    <flux:radio.group wire:model="type" label="Tipo de Categoría" required>
                        <flux:radio value="programa-local" label="Programa Local" />
                        <flux:radio value="programa-externo" label="Programa Externo" />
                    </flux:radio.group>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <flux:label>Banner (opcional)</flux:label>
                            <flux:input type="file" wire:model="imagen" accept="image/*" />
                        </div>

                        <div class="space-y-2">
                            <flux:label>Thumbnail (opcional)</flux:label>
                            <flux:input type="file" wire:model="thumbnail" accept="image/*" />
                        </div>
                    </div>
                </div>

                {{-- Bilingual Content Section --}}
                @if($translationError)
                    <div class="mb-4 bg-red-50 border-l-4 border-red-400 p-4 rounded shadow-sm">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <flux:icon.exclamation-circle class="h-5 w-5 text-red-400" />
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700">
                                    {{ $translationError }}
                                </p>
                            </div>
                            <div class="ml-auto pl-3">
                                <div class="-mx-1.5 -my-1.5">
                                    <button type="button" wire:click="$set('translationError', null)"
                                        class="inline-flex bg-red-50 rounded-md p-1.5 text-red-500 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-red-50 focus:ring-red-600">
                                        <span class="sr-only">Close</span>
                                        <flux:icon.x-mark class="h-4 w-4" />
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                    {{-- SPANISH COLUMN --}}
                    <flux:card class="space-y-4">
                        <div class="flex items-center gap-2 mb-4 pb-2 border-b border-gray-200">
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 2a8 8 0 100 16 8 8 0 000-16zM8 9a1 1 0 112 0v4a1 1 0 11-2 0V9zm3-1a1 1 0 10-2 0 1 1 0 002 0z" />
                            </svg>
                            <span class="font-semibold text-gray-700">Español</span>
                        </div>

                        <flux:input type="text" wire:model="nombre" label="Nombre de la Categoría *"
                            placeholder="Ej. Talleres" required />

                        <flux:editor toolbar="bold italic" wire:model="descripcion" label="Descripción"
                            placeholder="Introducción de la categoría" class="!h-32" />

                        <flux:editor toolbar="heading | bold italic underline" wire:model="texto" label="Texto"
                            placeholder="Descripción más detallada de la categoría (opcional)" />

                        <flux:editor toolbar="heading | bold italic underline | bullet ordered" wire:model="sidebar"
                            label="Sidebar" placeholder="Contenido del sidebar de la categoría" />
                    </flux:card>

                    {{-- ENGLISH COLUMN --}}
                    <flux:card class="space-y-4">
                        <div class="flex items-center justify-between mb-4 pb-2 border-b border-gray-200">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 2a8 8 0 100 16 8 8 0 000-16zM8 9a1 1 0 112 0v4a1 1 0 11-2 0V9zm3-1a1 1 0 10-2 0 1 1 0 002 0z" />
                                </svg>
                                <span class="font-semibold text-gray-700">English</span>
                            </div>
                            <flux:button wire:click="translateAllCategoryFields" wire:loading.attr="disabled" size="xs"
                                variant="ghost" icon="language" class="!text-purple-600 hover:!text-purple-700">
                                <flux:icon.loading wire:loading class="mr-1" />
                                Traducir Todo
                            </flux:button>
                        </div>

                        <div>
                            <flux:label>Category Name</flux:label>
                            <flux:input type="text" wire:model="nombre_en" placeholder="Ex. Workshops" />
                        </div>

                        <div>
                            <flux:label>Description</flux:label>
                            <flux:editor toolbar="bold italic" wire:model="descripcion_en"
                                placeholder="Category introduction (optional)" class="!h-32" />
                        </div>

                        <div>
                            <flux:label>Text</flux:label>
                            <flux:editor toolbar="heading | bold italic underline" wire:model="texto_en"
                                placeholder="More detailed category description (optional)" />
                        </div>

                        <div>
                            <flux:label>Sidebar</flux:label>
                            <flux:editor toolbar="heading | bold italic underline | bullet ordered"
                                wire:model="sidebar_en" placeholder="Category sidebar content (optional)" />
                        </div>
                    </flux:card>
                </div>

                <div class="flex justify-end mt-6 pt-4 border-t border-gray-200">
                    <flux:button type="button" variant="subtle" wire:click="resetCategoryForm" class="mr-2">
                        Cancelar
                    </flux:button>
                    <flux:button type="submit" variant="primary">
                        Guardar
                    </flux:button>
                </div>
            </form>
        </div>
    </flux:modal>

    {{-- EDIT CATEGORIA MODAL --}}
    <flux:modal name="editCategory" class="md:w-full md:max-w-5xl">
        <flux:heading size="lg">
            Editar Categoría
        </flux:heading>
        <flux:subheading>
            Actualiza la información de la categoría (bilingüe: español e inglés)
        </flux:subheading>
        <div class="flex flex-col gap-4 w-full mt-6">
            <form wire:submit="updateCategory" class="space-y-6">

                {{-- Metadata Section --}}
                <div class="p-4 bg-gray-50 rounded-lg space-y-4">
                    <flux:radio.group wire:model="type" label="Tipo de Categoría" required>
                        <flux:radio value="programa-local" label="Programa Local" />
                        <flux:radio value="programa-externo" label="Programa Externo" />
                    </flux:radio.group>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <flux:label>Banner (opcional)</flux:label>

                            @if ($this->currentImage)
                                <div class="relative group mb-3">
                                    <img src="{{ asset('storage/' . $this->currentImage->filename) }}" alt="Imagen actual"
                                        class="w-32 h-32 object-cover rounded">
                                    <button type="button"
                                        x-on:click="if (! confirm('¿Estás seguro que deseas eliminar la imagen?')) { event.preventDefault(); event.stopImmediatePropagation(); }"
                                        wire:click="removeImage"
                                        class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            @endif

                            <flux:input type="file" wire:model="imagen" accept="image/*" />
                        </div>

                        <div class="space-y-2">
                            <flux:label>Thumbnail (opcional)</flux:label>

                            @if ($this->currentThumbnail)
                                <div class="relative group mb-3">
                                    <img src="{{ asset('storage/' . $this->currentThumbnail->filename) }}"
                                        alt="Thumbnail actual" class="w-32 h-32 object-cover rounded">
                                    <button type="button"
                                        x-on:click="if (! confirm('¿Estás seguro que deseas eliminar el thumbnail?')) { event.preventDefault(); event.stopImmediatePropagation(); }"
                                        wire:click="removeThumbnail"
                                        class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            @endif

                            <flux:input type="file" wire:model="thumbnail" accept="image/*" />
                        </div>
                    </div>
                </div>

                {{-- Bilingual Content Section --}}
                @if($translationError)
                    <div class="mb-4 bg-red-50 border-l-4 border-red-400 p-4 rounded shadow-sm">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <flux:icon.exclamation-circle class="h-5 w-5 text-red-400" />
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700">
                                    {{ $translationError }}
                                </p>
                            </div>
                            <div class="ml-auto pl-3">
                                <div class="-mx-1.5 -my-1.5">
                                    <button type="button" wire:click="$set('translationError', null)"
                                        class="inline-flex bg-red-50 rounded-md p-1.5 text-red-500 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-red-50 focus:ring-red-600">
                                        <span class="sr-only">Close</span>
                                        <flux:icon.x-mark class="h-4 w-4" />
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                    {{-- SPANISH COLUMN --}}
                    <flux:card class="space-y-4">
                        <div class="flex items-center gap-2 mb-4 pb-2 border-b border-gray-200">
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 2a8 8 0 100 16 8 8 0 000-16zM8 9a1 1 0 112 0v4a1 1 0 11-2 0V9zm3-1a1 1 0 10-2 0 1 1 0 002 0z" />
                            </svg>
                            <span class="font-semibold text-gray-700">Español</span>
                        </div>

                        <flux:input type="text" wire:model="nombre" label="Nombre de la Categoría *"
                            placeholder="Ej. Talleres" required />

                        <flux:editor toolbar="bold italic" wire:model="descripcion" label="Descripción"
                            placeholder="Introducción de la categoría" class="!h-32" />

                        <flux:editor toolbar="heading | bold italic underline" wire:model="texto" label="Texto"
                            placeholder="Descripción más detallada de la categoría (opcional)" />

                        <flux:editor toolbar="heading | bold italic underline | bullet ordered" wire:model="sidebar"
                            label="Sidebar" placeholder="Contenido del sidebar de la categoría" />
                    </flux:card>

                    {{-- ENGLISH COLUMN --}}
                    <flux:card class="space-y-4">
                        <div class="flex items-center justify-between mb-4 pb-2 border-b border-gray-200">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 2a8 8 0 100 16 8 8 0 000-16zM8 9a1 1 0 112 0v4a1 1 0 11-2 0V9zm3-1a1 1 0 10-2 0 1 1 0 002 0z" />
                                </svg>
                                <span class="font-semibold text-gray-700">English</span>
                            </div>
                            <flux:button wire:click="translateAllCategoryFields" wire:loading.attr="disabled" size="xs"
                                variant="ghost" icon="language" class="!text-purple-600 hover:!text-purple-700">
                                <flux:icon.loading wire:loading class="mr-1" />
                                Traducir Todo
                            </flux:button>
                        </div>

                        <div>
                            <flux:label>Category Name</flux:label>
                            <flux:input type="text" wire:model="nombre_en" placeholder="Ex. Workshops" />
                        </div>

                        <div>
                            <flux:label>Description</flux:label>
                            <flux:editor toolbar="bold italic" wire:model="descripcion_en"
                                placeholder="Category introduction (optional)" class="!h-32" />
                        </div>

                        <div>
                            <flux:label>Text</flux:label>
                            <flux:editor toolbar="heading | bold italic underline" wire:model="texto_en"
                                placeholder="More detailed category description (optional)" />
                        </div>

                        <div>
                            <flux:label>Sidebar</flux:label>
                            <flux:editor toolbar="heading | bold italic underline | bullet ordered"
                                wire:model="sidebar_en" placeholder="Category sidebar content (optional)" />
                        </div>
                    </flux:card>
                </div>

                <div class="flex justify-end mt-6 pt-4 border-t border-gray-200">
                    <flux:button type="button" variant="subtle" wire:click="cancelCategoryEdit" class="mr-2">
                        Cancelar
                    </flux:button>
                    <flux:button type="submit" variant="primary">
                        Actualizar
                    </flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>