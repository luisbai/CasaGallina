<div>
    <div class="flex justify-between items-center mb-4">
        <flux:heading size="xl" class="!text-forest-800 font-serif">
            Gestión de Tags
        </flux:heading>

        <flux:modal.trigger name="createTag">
            <flux:button size="sm" icon="plus" variant="primary">Nuevo Tag</flux:button>
        </flux:modal.trigger>
    </div>

    <div class="flex items-center mb-4">
        <flux:input placeholder="Buscar tag..." wire:model.live.debounce.300ms="search" class="w-full max-w-sm mr-2"
            icon="magnifying-glass" />
    </div>

    <flux:card class="!px-5 !pt-1.5 !pb-4 shadow-sm">
        <flux:table :paginate="$this->tags">
            <flux:table.columns>
                <flux:table.column>Imagen</flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'nombre'" :direction="$sortDirection"
                    wire:click="sort('nombre')">Nombre</flux:table.column>
                <flux:table.column>Descripción</flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'type'" :direction="$sortDirection"
                    wire:click="sort('type')">Tipo</flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'created_at'" :direction="$sortDirection"
                    wire:click="sort('created_at')">Fecha de Creación</flux:table.column>
                <flux:table.column>Acciones</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($this->tags as $tag)
                    <flux:table.row :key="$tag->id">
                        <flux:table.cell>
                            @if($tag->multimedia)
                                <img src="{{ asset('storage/' . $tag->multimedia->filename) }}" alt="{{ $tag->nombre }}"
                                    class="w-12 h-12 object-cover rounded">
                            @else
                                <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                            @endif
                        </flux:table.cell>

                        <flux:table.cell>
                            <a href="#" wire:click.prevent="editTag({{ $tag->id }})"
                                class="text-forest-800 hover:underline">
                                {{ $tag->nombre }}
                            </a>
                        </flux:table.cell>

                        <flux:table.cell>
                            <div class="text-sm text-gray-600 max-w-xs truncate">
                                {{ $tag->descripcion ?? '-' }}
                            </div>
                        </flux:table.cell>

                        <flux:table.cell>
                            <flux:badge size="sm" color="green" class="!bg-green-600 !text-green-50">
                                {{ ucfirst(str_replace('-', ' ', $tag->type)) }}
                            </flux:badge>
                        </flux:table.cell>

                        <flux:table.cell>{{ $tag->created_at->diffForHumans() }}</flux:table.cell>

                        <flux:table.cell class="space-x-1">
                            <flux:button wire:click="editTag({{ $tag->id }})" size="xs" variant="subtle" icon="pencil"
                                class="!text-forest-800 !cursor-pointer">
                            </flux:button>
                            <flux:button x-on:click="window.Swal.fire({
                                        title: '¿Estás seguro?',
                                        text: '¿Deseas eliminar este tag? Esta acción no se puede deshacer.',
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonText: 'Si, eliminar',
                                        cancelButtonText: 'Cancelar',
                                        confirmButtonColor: '#d33',
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            $wire.delete({{ $tag->id }})
                                        }
                                    })" variant="subtle" size="xs" icon="trash" class="!text-forest-800 !cursor-pointer">
                            </flux:button>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="6" class="text-center">
                            No hay tags registrados
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>
    </flux:card>

    {{-- CREATE MODAL --}}
    <flux:modal name="createTag" variant="flyout" class="md:max-w-7xl">
        <flux:heading size="lg">
            Crear Tag
        </flux:heading>
        <flux:subheading>
            Crea un nuevo tag para categorizar contenido (bilingüe: español e inglés)
        </flux:subheading>

        <div class="flex flex-col gap-4 w-full mt-6">
            <form wire:submit="store" class="space-y-6">

                {{-- Type Selection - Full Width --}}
                <flux:input type="text" wire:model="type" label="Tipo de Tag"
                    placeholder="Ej. noticia, programa-local, programa-externo, exposicion" required />

                {{-- Side by Side Spanish/English Cards --}}
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

                        <flux:input type="text" wire:model="nombre" label="Nombre del Tag *"
                            placeholder="Ej. Infancias Adolescencias" required />

                        <flux:textarea wire:model="descripcion" label="Descripción"
                            placeholder="Breve descripción del tag (opcional)" rows="3" />

                        <flux:textarea wire:model="texto" label="Texto Adicional"
                            placeholder="Contenido adicional (opcional)" rows="4" />

                        <flux:textarea wire:model="sidebar" label="Contenido Lateral"
                            placeholder="Información para barra lateral (opcional)" rows="4" />
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

                        <flux:input type="text" wire:model="nombre_en" label="Tag Name"
                            placeholder="Ex. Children & Teens" />

                        <flux:textarea wire:model="descripcion_en" label="Description"
                            placeholder="Brief tag description (optional)" rows="3" />

                        <flux:textarea wire:model="texto_en" label="Additional Text"
                            placeholder="Additional content (optional)" rows="4" />

                        <flux:textarea wire:model="sidebar_en" label="Sidebar Content"
                            placeholder="Information for sidebar (optional)" rows="4" />
                    </flux:card>
                </div>

                {{-- Image Upload - Full Width --}}
                <div class="space-y-2">
                    <flux:label>Imagen (opcional)</flux:label>
                    <flux:input type="file" wire:model="imagen" accept="image/*" />
                    @if ($imagen)
                        <div class="mt-2">
                            <img src="{{ $imagen->temporaryUrl() }}" alt="Preview" class="w-32 h-32 object-cover rounded">
                        </div>
                    @endif
                </div>

                <div class="flex justify-end mt-6 pt-4 border-t border-gray-200">
                    <flux:button type="button" variant="subtle" wire:click="resetForm" class="mr-2">
                        Cancelar
                    </flux:button>
                    <flux:button type="submit" variant="primary">
                        Guardar Tag
                    </flux:button>
                </div>
            </form>
        </div>
    </flux:modal>

    {{-- EDIT MODAL --}}
    <flux:modal name="editTag" variant="flyout" class="md:max-w-7xl">
        <flux:heading size="lg">
            Editar Tag
        </flux:heading>
        <flux:subheading>
            Actualiza la información del tag (bilingüe: español e inglés)
        </flux:subheading>

        <div class="flex flex-col gap-4 w-full mt-6">
            <form wire:submit="update" class="space-y-6">

                {{-- Type Selection - Full Width --}}
                <flux:input type="text" wire:model="type" label="Tipo de Tag"
                    placeholder="Ej. noticia, programa-local, programa-externo, exposicion" required />

                {{-- Side by Side Spanish/English Cards --}}
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

                        <flux:input type="text" wire:model="nombre" label="Nombre del Tag *"
                            placeholder="Ej. Infancias Adolescencias" required />

                        <flux:textarea wire:model="descripcion" label="Descripción"
                            placeholder="Breve descripción del tag (opcional)" rows="3" />

                        <flux:textarea wire:model="texto" label="Texto Adicional"
                            placeholder="Contenido adicional (opcional)" rows="4" />

                        <flux:textarea wire:model="sidebar" label="Contenido Lateral"
                            placeholder="Información para barra lateral (opcional)" rows="4" />
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

                        <flux:input type="text" wire:model="nombre_en" label="Tag Name"
                            placeholder="Ex. Children & Teens" />

                        <flux:textarea wire:model="descripcion_en" label="Description"
                            placeholder="Brief tag description (optional)" rows="3" />

                        <flux:textarea wire:model="texto_en" label="Additional Text"
                            placeholder="Additional content (optional)" rows="4" />

                        <flux:textarea wire:model="sidebar_en" label="Sidebar Content"
                            placeholder="Information for sidebar (optional)" rows="4" />
                    </flux:card>
                </div>

                {{-- Image Upload - Full Width --}}
                <div class="space-y-2">
                    <flux:label>Imagen (opcional)</flux:label>

                    @if ($this->currentImage)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $this->currentImage->filename) }}" alt="Imagen actual"
                                class="w-32 h-32 object-cover rounded">
                            <flux:button type="button" variant="danger" size="xs" x-on:click="window.Swal.fire({
                                        title: '¿Estás seguro?',
                                        text: '¿Deseas eliminar la imagen?',
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonText: 'Si, eliminar',
                                        cancelButtonText: 'Cancelar',
                                        confirmButtonColor: '#d33',
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            $wire.removeImage()
                                        }
                                    })" class="mt-2">
                                Eliminar imagen
                            </flux:button>
                        </div>
                    @endif

                    <flux:input type="file" wire:model="imagen" accept="image/*" />
                    @if ($imagen)
                        <div class="mt-2">
                            <img src="{{ $imagen->temporaryUrl() }}" alt="Preview" class="w-32 h-32 object-cover rounded">
                        </div>
                    @endif
                </div>

                <div class="flex justify-end mt-6 pt-4 border-t border-gray-200">
                    <flux:button type="button" variant="subtle" wire:click="cancelEdit" class="mr-2">
                        Cancelar
                    </flux:button>
                    <flux:button type="submit" variant="primary">
                        Actualizar Tag
                    </flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>