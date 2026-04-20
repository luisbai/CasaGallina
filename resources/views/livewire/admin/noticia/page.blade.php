<div class="grid grid-cols-1 md:grid-cols-12 gap-6">
    <div class="md:col-span-8">
        <div class="flex justify-between items-center mb-4">
            <flux:heading size="xl" class="!text-forest-800 font-serif">
                Noticias
            </flux:heading>
        </div>

        <div class="flex items-center justify-between mb-4 gap-8">
            <flux:input placeholder="Buscar noticia..." wire:model.live="search" size="sm" icon="magnifying-glass" />

            <flux:modal.trigger name="createNoticia">
                <flux:tooltip content="Crear noticia">
                    <flux:button size="sm" icon="plus" variant="primary" wire:click="openCreateModal"></flux:button>
                </flux:tooltip>
            </flux:modal.trigger>
        </div>

        <flux:card class="!px-5 !pt-1.5 !pb-4 shadow-sm">
            <flux:table :paginate="$this->noticias">
                <flux:table.columns>
                    <flux:table.column sortable :sorted="$sortBy === 'titulo'" :direction="$sortDirection"
                        wire:click="sort('titulo')">Título</flux:table.column>
                    <flux:table.column class="w-16">Estado</flux:table.column>
                    <flux:table.column class="w-16">Acciones</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @forelse ($this->noticias as $noticia)
                        <flux:table.row :key="$noticia->id" class="group">
                            <flux:table.cell wire:click.prevent="editNoticia({{ $noticia->id }})">
                                <span class="group-hover:underline cursor-pointer">
                                    {{ $noticia->titulo }}
                                </span>
                            </flux:table.cell>

                            <flux:table.cell>
                                @if($noticia->activo)
                                    <flux:badge size="sm" color="green">Activa</flux:badge>
                                @else
                                    <flux:badge size="sm" color="gray">Borrador</flux:badge>
                                @endif
                            </flux:table.cell>

                            <flux:table.cell class="space-x-1">
                                <flux:tooltip content="Ver">
                                    <a href="{{ route('noticia', $noticia->slug) }}" target="_blank">
                                        <flux:button size="xs" variant="ghost" icon="eye"
                                            class="!text-forest-800 !cursor-pointer">
                                        </flux:button>
                                    </a>
                                </flux:tooltip>
                                <flux:tooltip content="Editar">
                                    <flux:button wire:click="editNoticia({{ $noticia->id }})" size="xs" variant="ghost"
                                        icon="pencil" class="!text-forest-800 !cursor-pointer">
                                    </flux:button>
                                </flux:tooltip>
                                <flux:button x-on:click="window.Swal.fire({
                                                            title: '¿Estás seguro?',
                                                            text: '¿Deseas eliminar esta noticia? Esta acción no se puede deshacer.',
                                                            icon: 'warning',
                                                            showCancelButton: true,
                                                            confirmButtonText: 'Si, eliminar',
                                                            cancelButtonText: 'Cancelar',
                                                            confirmButtonColor: '#d33',
                                                        }).then((result) => {
                                                            if (result.isConfirmed) {
                                                                $wire.delete({{ $noticia->id }})
                                                            }
                                                        })" variant="ghost" size="xs" icon="trash"
                                    class="!text-forest-800 !cursor-pointer">
                                </flux:button>
                            </flux:table.cell>
                        </flux:table.row>
                    @empty
                        <flux:table.row>
                            <flux:table.cell colspan="3" class="text-center">
                                No hay noticias registradas
                            </flux:table.cell>
                        </flux:table.row>
                    @endforelse
                </flux:table.rows>
            </flux:table>
        </flux:card>
    </div>

    <div class="md:col-span-4">
        <div class="flex justify-between items-center mb-4">
            <flux:heading size="xl" class="!text-forest-800 font-serif">
                Categorías
            </flux:heading>
        </div>

        <div class="flex items-center justify-between mb-4 gap-8">
            <flux:input placeholder="Buscar categoría..." wire:model.live="searchTag" size="sm"
                icon="magnifying-glass" />

            <flux:modal.trigger name="createCategoria">
                <flux:tooltip content="Crear categoría">
                    <flux:button size="sm" icon="plus" variant="primary" wire:click="openCreateCategoriaModal">
                    </flux:button>
                </flux:tooltip>
            </flux:modal.trigger>
        </div>

        <flux:card class="!px-5 !pt-1.5 !pb-4 shadow-sm">
            <flux:table :paginate="$this->categorias" class="!text-sm">
                <flux:table.columns>
                    <flux:table.column>Nombre</flux:table.column>
                    <flux:table.column>Acciones</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @forelse ($this->categorias as $categoria)
                        <flux:table.row :key="$categoria->id">
                            <flux:table.cell>{{ $categoria->nombre }}</flux:table.cell>
                            <flux:table.cell class="space-x-1">
                                <flux:tooltip content="Editar">
                                    <flux:button wire:click="editCategoria({{ $categoria->id }})" size="xs" variant="ghost"
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
                                                                $wire.deleteCategoria({{ $categoria->id }})
                                                            }
                                                        })" variant="ghost" size="xs" icon="trash"
                                    class="!text-forest-800 !cursor-pointer">
                                </flux:button>
                            </flux:table.cell>
                        </flux:table.row>
                    @empty
                        <flux:table.row>
                            <flux:table.cell colspan="2" class="text-center">
                                No hay categorías
                            </flux:table.cell>
                        </flux:table.row>
                    @endforelse
                </flux:table.rows>
            </flux:table>
        </flux:card>
    </div>

    <!-- Create Category Modal -->
    <flux:modal name="createCategoria" variant="flyout" class="md:max-w-4xl">
        <flux:heading size="lg">
            Crear Categoría
        </flux:heading>
        <flux:subheading>
            Crea una nueva categoría para noticias (bilingüe: español e inglés)
        </flux:subheading>
        <div class="flex flex-col gap-4 w-full mt-6">
            <form wire:submit="storeCategoria" class="space-y-6">

                {{-- Bilingual Fields Section --}}
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

                        <flux:input type="text" wire:model="tagNombre" label="Nombre de la Categoría *"
                            placeholder="Ej. Artículo, Crónica, Entrevista" required />

                        <flux:textarea wire:model="tagDescripcion" label="Descripción (opcional)"
                            placeholder="Breve descripción de la categoría" rows="3" />
                    </flux:card>

                    {{-- ENGLISH COLUMN --}}
                    <flux:card class="space-y-4">
                        <div class="flex items-center gap-2 mb-4 pb-2 border-b border-gray-200">
                            <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 2a8 8 0 100 16 8 8 0 000-16zM8 9a1 1 0 112 0v4a1 1 0 11-2 0V9zm3-1a1 1 0 10-2 0 1 1 0 002 0z" />
                            </svg>
                            <span class="font-semibold text-gray-700">English</span>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <flux:label>Category Name</flux:label>
                                <flux:button wire:click="translateTagNombre" size="xs" variant="ghost" icon="language"
                                    class="!text-purple-600 hover:!text-purple-700">
                                    Traducir
                                </flux:button>
                            </div>
                            <flux:input type="text" wire:model="tagNombre_en"
                                placeholder="E.g. Article, Chronicle, Interview" />
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <flux:label>Description</flux:label>
                                <flux:button wire:click="translateTagDescripcion" size="xs" variant="ghost"
                                    icon="language" class="!text-purple-600 hover:!text-purple-700">
                                    Traducir
                                </flux:button>
                            </div>
                            <flux:textarea wire:model="tagDescripcion_en" placeholder="Brief category description"
                                rows="3" />
                        </div>
                    </flux:card>
                </div>

                <div class="flex justify-end mt-6">
                    <flux:button type="button" variant="ghost" wire:click="resetCategoriaForm" class="mr-2">
                        Cancelar
                    </flux:button>
                    <flux:button type="submit" variant="primary">
                        Guardar
                    </flux:button>
                </div>
            </form>
        </div>
    </flux:modal>

    <!-- Edit Category Modal -->
    <flux:modal name="editCategoria" variant="flyout" class="md:max-w-5xl">
        <flux:heading size="lg">
            Editar Categoría
        </flux:heading>
        <flux:subheading>
            Actualiza la información de la categoría (bilingüe: español e inglés)
        </flux:subheading>
        <div class="flex flex-col gap-4 w-full mt-6">
            <form wire:submit="updateCategoria" class="space-y-6">

                {{-- Bilingual Fields Section --}}
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

                        <flux:input type="text" wire:model="tagNombre" label="Nombre de la Categoría *"
                            placeholder="Ej. Artículo, Crónica, Entrevista" required />

                        <flux:textarea wire:model="tagDescripcion" label="Descripción (opcional)"
                            placeholder="Breve descripción de la categoría" rows="3" />
                    </flux:card>

                    {{-- ENGLISH COLUMN --}}
                    <flux:card class="space-y-4">
                        <div class="flex items-center gap-2 mb-4 pb-2 border-b border-gray-200">
                            <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 2a8 8 0 100 16 8 8 0 000-16zM8 9a1 1 0 112 0v4a1 1 0 11-2 0V9zm3-1a1 1 0 10-2 0 1 1 0 002 0z" />
                            </svg>
                            <span class="font-semibold text-gray-700">English</span>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <flux:label>Category Name</flux:label>
                                <flux:button wire:click="translateTagNombre" size="xs" variant="ghost" icon="language"
                                    class="!text-purple-600 hover:!text-purple-700">
                                    Traducir
                                </flux:button>
                            </div>
                            <flux:input type="text" wire:model="tagNombre_en"
                                placeholder="E.g. Article, Chronicle, Interview" />
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <flux:label>Description</flux:label>
                                <flux:button wire:click="translateTagDescripcion" size="xs" variant="ghost"
                                    icon="language" class="!text-purple-600 hover:!text-purple-700">
                                    Traducir
                                </flux:button>
                            </div>
                            <flux:textarea wire:model="tagDescripcion_en" placeholder="Brief category description"
                                rows="3" />
                        </div>
                    </flux:card>
                </div>

                <div class="flex justify-end mt-6">
                    <flux:button type="button" variant="ghost" wire:click="cancelCategoriaEdit" class="mr-2">
                        Cancelar
                    </flux:button>
                    <flux:button type="submit" variant="primary">
                        Actualizar
                    </flux:button>
                </div>
            </form>
        </div>
    </flux:modal>

    <!-- Create Noticia Modal -->
    <flux:modal name="createNoticia" class="md:max-w-7xl md:w-full">
        <flux:heading size="lg">
            Crear Noticia
        </flux:heading>
        <flux:subheading>
            Llena los campos para crear la noticia (bilingüe: español e inglés)
        </flux:subheading>
        <div class="flex flex-col gap-4 w-full mt-6">
            <form wire:submit="store" class="space-y-6">

                {{-- Metadata Section --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4 bg-gray-50 rounded-lg">
                    <div class="space-y-4">
                        <flux:radio.group wire:model="activo" label="Estado">
                            <flux:radio value="activa" label="Activa" />
                            <flux:radio value="borrador" label="Borrador" />
                        </flux:radio.group>

                        <flux:input type="text" wire:model="autor" label="Autor (opcional)"
                            placeholder="Nombre del autor" />
                    </div>

                    <div class="space-y-4">
                        <flux:date-picker wire:model="fecha_publicacion" label="Fecha de Publicación"
                            placeholder="Selecciona la fecha de publicación" required />

                        <flux:select label="Categorías" wire:model="selectedTags" variant="listbox" multiple
                            selected-suffix="categorías seleccionadas" placeholder="Seleccione categorías">
                            @foreach($this->availableTags as $tag)
                                <flux:select.option value="{{ $tag->id }}">{{ $tag->nombre }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </div>
                </div>

                {{-- Gallery Images Section --}}
                <flux:card class="space-y-4">
                    <flux:heading size="lg" class="!text-base">Galería de Imágenes</flux:heading>

                    <flux:file-upload wire:model="multimedia" multiple label="Imágenes (opcional)">
                        <flux:file-upload.dropzone heading="Arrastra y suelta imágenes o haz clic para seleccionar"
                            text="JPG, PNG, GIF hasta 10MB" />
                    </flux:file-upload>

                    @if($multimedia)
                        <div class="mt-4 flex flex-col gap-2">
                            @foreach($multimedia as $index => $image)
                                @if($image)
                                    <flux:file-item heading="{{ $image->getClientOriginalName() }}" :image="$image->temporaryUrl()"
                                        size="{{ $image->getSize() }}">
                                        <x-slot name="actions">
                                            <flux:file-item.remove wire:click="$set('multimedia.{{ $index }}', null)" />
                                        </x-slot>
                                    </flux:file-item>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </flux:card>

                {{-- Content Image & Video Section --}}
                <flux:card class="space-y-4">
                    <flux:heading size="lg" class="!text-base">Contenido Adicional</flux:heading>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Content Image --}}
                        <div class="space-y-2">
                            <flux:file-upload wire:model="content_image" label="Imagen de contenido (opcional)">
                                <flux:file-upload.dropzone heading="Arrastra o haz clic para seleccionar"
                                    text="Imagen que se muestra debajo del contenido" />
                            </flux:file-upload>

                            @if($content_image)
                                <flux:file-item heading="{{ $content_image->getClientOriginalName() }}"
                                    :image="$content_image->temporaryUrl()" size="{{ $content_image->getSize() }}">
                                    <x-slot name="actions">
                                        <flux:file-item.remove wire:click="$set('content_image', null)" />
                                    </x-slot>
                                </flux:file-item>
                            @endif
                        </div>

                        {{-- YouTube Video --}}
                        <div class="space-y-2">
                            <flux:input type="url" wire:model="video_url" label="Video de YouTube (opcional)"
                                placeholder="https://www.youtube.com/watch?v=..." />
                            <flux:subheading size="sm" class="text-gray-500 !text-xs">
                                El video aparecerá como primera diapositiva en el carrusel
                            </flux:subheading>
                        </div>
                    </div>
                </flux:card>

                {{-- Donations Section --}}
                <div class="p-4 bg-gray-50 rounded-lg">
                    <flux:checkbox wire:model.live="enable_donations" label="Habilitar donaciones para esta noticia" />

                    @if($enable_donations)
                        <div class="mt-4 space-y-4">
                            {{-- Donation Content - Bilingual Cards --}}
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

                                    <flux:editor wire:model="donation_content" label="Contenido de donación"
                                        placeholder="Escribe el texto personalizado para la sección de donaciones..." />
                                </flux:card>

                                {{-- ENGLISH COLUMN --}}
                                <flux:card class="space-y-4">
                                    <div class="flex items-center gap-2 mb-4 pb-2 border-b border-gray-200">
                                        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M10 2a8 8 0 100 16 8 8 0 000-16zM8 9a1 1 0 112 0v4a1 1 0 11-2 0V9zm3-1a1 1 0 10-2 0 1 1 0 002 0z" />
                                        </svg>
                                        <span class="font-semibold text-gray-700">English</span>
                                    </div>

                                    <div>
                                        <div class="flex items-center justify-between mb-2">
                                            <flux:label>Donation Content</flux:label>
                                            <flux:button wire:click="translateDonationContent" size="xs" variant="ghost"
                                                icon="language" class="!text-purple-600 hover:!text-purple-700">
                                                Traducir
                                            </flux:button>
                                        </div>
                                        <flux:editor wire:model="donation_content_en"
                                            placeholder="Write the custom text for the donations section..." />
                                    </div>
                                </flux:card>
                            </div>

                            <div class="space-y-2">
                                <flux:file-upload wire:model="donation_image" label="Imagen para donación (opcional)">
                                    <flux:file-upload.dropzone heading="Arrastra o haz clic para seleccionar"
                                        text="Imagen para la sección de donaciones" />
                                </flux:file-upload>

                                @if($donation_image)
                                    <flux:file-item heading="{{ $donation_image->getClientOriginalName() }}"
                                        :image="$donation_image->temporaryUrl()" size="{{ $donation_image->getSize() }}">
                                        <x-slot name="actions">
                                            <flux:file-item.remove wire:click="$set('donation_image', null)" />
                                        </x-slot>
                                    </flux:file-item>
                                @endif
                            </div>
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

                        <flux:input type="text" wire:model="titulo" label="Título *" placeholder="Título de la noticia"
                            required />

                        <flux:textarea wire:model="descripcion" label="Descripción (opcional)"
                            placeholder="Breve descripción de la noticia" rows="3" />

                        <flux:editor wire:model="contenido" label="Contenido *"
                            placeholder="Escribe el contenido de la noticia..." required />
                    </flux:card>

                    {{-- ENGLISH COLUMN --}}
                    <flux:card class="space-y-4">
                        <div class="flex items-center gap-2 mb-4 pb-2 border-b border-gray-200">
                            <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 2a8 8 0 100 16 8 8 0 000-16zM8 9a1 1 0 112 0v4a1 1 0 11-2 0V9zm3-1a1 1 0 10-2 0 1 1 0 002 0z" />
                            </svg>
                            <span class="font-semibold text-gray-700">English</span>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <flux:label>Title</flux:label>
                                <flux:button wire:click="translateFields" size="xs" variant="ghost" icon="language"
                                    class="!text-purple-600 hover:!text-purple-700">
                                    Traducir
                                </flux:button>
                            </div>
                            <flux:input type="text" wire:model="titulo_en" placeholder="News title" />
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <flux:label>Description</flux:label>
                            </div>
                            <flux:textarea wire:model="descripcion_en" placeholder="Brief news description" rows="3" />
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <flux:label>Content</flux:label>
                            </div>
                            <flux:editor wire:model="contenido_en" placeholder="Main news content (optional)" />
                        </div>
                    </flux:card>
                </div>

                <div class="flex justify-end mt-6">
                    <flux:button type="button" variant="ghost" wire:click="resetForm" class="mr-2">
                        Cancelar
                    </flux:button>
                    <flux:button type="submit" variant="primary">
                        Guardar
                    </flux:button>
                </div>
            </form>
        </div>
    </flux:modal>

    <!-- Edit Noticia Modal -->
    <flux:modal name="editNoticia" class="md:max-w-7xl md:w-full">
        <flux:heading size="lg">
            Editar Noticia
        </flux:heading>
        <flux:subheading>
            Actualiza la información de la noticia (bilingüe: español e inglés)
        </flux:subheading>
        <div class="flex flex-col gap-4 w-full mt-6">
            <form wire:submit="update" class="space-y-6">

                {{-- Metadata Section --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4 bg-gray-50 rounded-lg">
                    <div class="space-y-4">
                        <flux:radio.group wire:model="activo" label="Estado">
                            <flux:radio value="activa" label="Activa" />
                            <flux:radio value="borrador" label="Borrador" />
                        </flux:radio.group>

                        <flux:input type="text" wire:model="autor" label="Autor (opcional)"
                            placeholder="Nombre del autor" />
                    </div>

                    <div class="space-y-4">
                        <flux:date-picker wire:model="fecha_publicacion" label="Fecha de Publicación"
                            placeholder="Selecciona la fecha de publicación" required />

                        <flux:select label="Categorías" wire:model="selectedTags" variant="listbox" multiple
                            selected-suffix="categorías seleccionadas" placeholder="Seleccione categorías">
                            @foreach($this->availableTags as $tag)
                                <flux:select.option value="{{ $tag->id }}">{{ $tag->nombre }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </div>
                </div>

                {{-- Gallery Images Section --}}
                <flux:card class="space-y-4">
                    <flux:heading size="lg" class="!text-base">Galería de Imágenes</flux:heading>

                    {{-- Existing Images --}}
                    @if($editId && $this->currentNoticia?->multimedia->count() > 0)
                        <div class="space-y-2">
                            <flux:label>Imágenes actuales</flux:label>
                            <div class="flex flex-col gap-2">
                                @foreach($this->currentNoticia->multimedia as $image)
                                    <flux:file-item heading="{{ $image->filename }}"
                                        image="{{ asset('storage/' . $image->filename) }}">
                                        <x-slot name="actions">
                                            <flux:file-item.remove x-on:click="window.Swal.fire({
                                                                                            title: '¿Estás seguro?',
                                                                                            text: '¿Deseas eliminar esta imagen?',
                                                                                            icon: 'warning',
                                                                                            showCancelButton: true,
                                                                                            confirmButtonText: 'Si, eliminar',
                                                                                            cancelButtonText: 'Cancelar',
                                                                                            confirmButtonColor: '#d33',
                                                                                        }).then((result) => {
                                                                                            if (result.isConfirmed) {
                                                                                                $wire.removeImage({{ $image->id }})
                                                                                            }
                                                                                        })" />
                                        </x-slot>
                                    </flux:file-item>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Upload New Gallery Images --}}
                    <flux:file-upload wire:model="multimedia" multiple label="Nuevas imágenes (opcional)">
                        <flux:file-upload.dropzone heading="Arrastra y suelta imágenes o haz clic para seleccionar"
                            text="JPG, PNG, GIF hasta 10MB" />
                    </flux:file-upload>

                    @if($multimedia)
                        <div class="mt-4 flex flex-col gap-2">
                            @foreach($multimedia as $index => $image)
                                @if($image)
                                    <flux:file-item heading="{{ $image->getClientOriginalName() }}" :image="$image->temporaryUrl()"
                                        size="{{ $image->getSize() }}">
                                        <x-slot name="actions">
                                            <flux:file-item.remove wire:click="$set('multimedia.{{ $index }}', null)" />
                                        </x-slot>
                                    </flux:file-item>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </flux:card>

                {{-- Content Image & Video Section --}}
                <flux:card class="space-y-4">
                    <flux:heading size="lg" class="!text-base">Contenido Adicional</flux:heading>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Content Image --}}
                        <div class="space-y-2">
                            @if($editId && $this->currentNoticia?->contentImage)
                                <div class="space-y-2">
                                    <flux:label>Imagen de contenido actual</flux:label>
                                    <flux:file-item heading="{{ $this->currentNoticia->contentImage->filename }}"
                                        image="{{ asset('storage/' . $this->currentNoticia->contentImage->filename) }}">
                                        <x-slot name="actions">
                                            <flux:file-item.remove x-on:click="window.Swal.fire({
                                                                        title: '¿Estás seguro?',
                                                                        text: '¿Deseas eliminar esta imagen de contenido?',
                                                                        icon: 'warning',
                                                                        showCancelButton: true,
                                                                        confirmButtonText: 'Si, eliminar',
                                                                        cancelButtonText: 'Cancelar',
                                                                        confirmButtonColor: '#d33',
                                                                    }).then((result) => {
                                                                        if (result.isConfirmed) {
                                                                            $wire.removeContentImage()
                                                                        }
                                                                    })" />
                                        </x-slot>
                                    </flux:file-item>
                                </div>
                            @endif

                            <flux:file-upload wire:model="content_image" label="Nueva imagen de contenido (opcional)">
                                <flux:file-upload.dropzone heading="Arrastra o haz clic para seleccionar"
                                    text="Imagen que se muestra debajo del contenido" />
                            </flux:file-upload>

                            @if($content_image)
                                <flux:file-item heading="{{ $content_image->getClientOriginalName() }}"
                                    :image="$content_image->temporaryUrl()" size="{{ $content_image->getSize() }}">
                                    <x-slot name="actions">
                                        <flux:file-item.remove wire:click="$set('content_image', null)" />
                                    </x-slot>
                                </flux:file-item>
                            @endif
                        </div>

                        {{-- YouTube Video --}}
                        <div class="space-y-2">
                            <flux:input type="url" wire:model="video_url" label="Video de YouTube (opcional)"
                                placeholder="https://www.youtube.com/watch?v=..." />
                            <flux:subheading size="sm" class="text-gray-500 !text-xs">
                                El video aparecerá como primera diapositiva en el carrusel
                            </flux:subheading>
                        </div>
                    </div>
                </flux:card>

                {{-- Donations Section --}}
                <div class="p-4 bg-gray-50 rounded-lg">
                    <flux:checkbox wire:model.live="enable_donations" label="Habilitar donaciones para esta noticia" />

                    @if($enable_donations)
                        <div class="mt-4 space-y-4">
                            {{-- Donation Content - Bilingual Cards --}}
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

                                    <flux:editor wire:model="donation_content" label="Contenido de donación"
                                        placeholder="Escribe el texto personalizado para la sección de donaciones..." />
                                </flux:card>

                                {{-- ENGLISH COLUMN --}}
                                <flux:card class="space-y-4">
                                    <div class="flex items-center gap-2 mb-4 pb-2 border-b border-gray-200">
                                        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M10 2a8 8 0 100 16 8 8 0 000-16zM8 9a1 1 0 112 0v4a1 1 0 11-2 0V9zm3-1a1 1 0 10-2 0 1 1 0 002 0z" />
                                        </svg>
                                        <span class="font-semibold text-gray-700">English</span>
                                    </div>

                                    <div>
                                        <div class="flex items-center justify-between mb-2">
                                            <flux:label>Donation Content</flux:label>
                                            <flux:button wire:click="translateDonationContent" size="xs" variant="ghost"
                                                icon="language" class="!text-purple-600 hover:!text-purple-700">
                                                Traducir
                                            </flux:button>
                                        </div>
                                        <flux:editor wire:model="donation_content_en"
                                            placeholder="Write the custom text for the donations section..." />
                                    </div>
                                </flux:card>
                            </div>

                            <div class="space-y-2">
                                @if($editId && $this->currentNoticia?->donationMultimedia)
                                    <div class="space-y-2">
                                        <flux:label>Imagen de donación actual</flux:label>
                                        <flux:file-item heading="{{ $this->currentNoticia->donationMultimedia->filename }}"
                                            image="{{ asset('storage/' . $this->currentNoticia->donationMultimedia->filename) }}">
                                            <x-slot name="actions">
                                                <flux:file-item.remove x-on:click="window.Swal.fire({
                                                                                                title: '¿Estás seguro?',
                                                                                                text: '¿Eliminar esta imagen de donación?',
                                                                                                icon: 'warning',
                                                                                                showCancelButton: true,
                                                                                                confirmButtonText: 'Si, eliminar',
                                                                                                cancelButtonText: 'Cancelar',
                                                                                                confirmButtonColor: '#d33',
                                                                                            }).then((result) => {
                                                                                                if (result.isConfirmed) {
                                                                                                    $wire.removeDonationImage()
                                                                                                }
                                                                                            })" />
                                            </x-slot>
                                        </flux:file-item>
                                    </div>
                                @endif

                                <flux:file-upload wire:model="donation_image" label="Nueva imagen para donación (opcional)">
                                    <flux:file-upload.dropzone heading="Arrastra o haz clic para seleccionar"
                                        text="Imagen para la sección de donaciones" />
                                </flux:file-upload>

                                @if($donation_image)
                                    <flux:file-item heading="{{ $donation_image->getClientOriginalName() }}"
                                        :image="$donation_image->temporaryUrl()" size="{{ $donation_image->getSize() }}">
                                        <x-slot name="actions">
                                            <flux:file-item.remove wire:click="$set('donation_image', null)" />
                                        </x-slot>
                                    </flux:file-item>
                                @endif
                            </div>
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

                        <flux:input type="text" wire:model="titulo" label="Título *" placeholder="Título de la noticia"
                            required />

                        <flux:textarea wire:model="descripcion" label="Descripción (opcional)"
                            placeholder="Breve descripción de la noticia" rows="3" />

                        <flux:editor wire:model="contenido" label="Contenido *"
                            placeholder="Escribe el contenido de la noticia..." required />
                    </flux:card>

                    {{-- ENGLISH COLUMN --}}
                    <flux:card class="space-y-4">
                        <div class="flex items-center gap-2 mb-4 pb-2 border-b border-gray-200">
                            <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 2a8 8 0 100 16 8 8 0 000-16zM8 9a1 1 0 112 0v4a1 1 0 11-2 0V9zm3-1a1 1 0 10-2 0 1 1 0 002 0z" />
                            </svg>
                            <span class="font-semibold text-gray-700">English</span>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <flux:label>Title</flux:label>
                                <flux:button wire:click="translateFields" size="xs" variant="ghost" icon="language"
                                    class="!text-purple-600 hover:!text-purple-700">
                                    Traducir
                                </flux:button>
                            </div>
                            <flux:input type="text" wire:model="titulo_en" placeholder="News title" />
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <flux:label>Description</flux:label>
                            </div>
                            <flux:textarea wire:model="descripcion_en" placeholder="Brief news description" rows="3" />
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <flux:label>Content</flux:label>
                            </div>
                            <flux:editor wire:model="contenido_en" placeholder="Main news content (optional)" />
                        </div>
                    </flux:card>
                </div>

                <div class="flex justify-end mt-6">
                    <flux:button type="button" variant="ghost" wire:click="cancelEdit" class="mr-2">
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