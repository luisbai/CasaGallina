<div>
    <div class="flex justify-between items-center mb-4">
        <flux:heading size="xl" class="!text-forest-800 font-serif">
            Miembros del Equipo
        </flux:heading>
    </div>

    <div class="flex items-center justify-between mb-4 gap-4">
        <div class="flex items-center gap-4 w-1/2">
            <flux:input placeholder="Buscar miembro..." wire:model.live="search" size="sm" icon="magnifying-glass"
                class="w-64" />

            <flux:select wire:model.live="filterTipo" size="sm" placeholder="Filtrar por tipo" class="w-48">
                <option value="">Todos los tipos</option>
                @foreach($tipoOptions as $key => $label)
                    <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
            </flux:select>
        </div>

        <flux:modal.trigger name="createMember">
            <flux:button size="sm" icon="plus" variant="primary" wire:click="openCreateModal">
                Nuevo Miembro
            </flux:button>
        </flux:modal.trigger>
    </div>

    <flux:card class="!px-5 !pt-1.5 !pb-4 shadow-sm">
        <flux:table :paginate="$this->members">
            <flux:table.columns>
                <flux:table.column sortable :sorted="$sortBy === 'orden'" :direction="$sortDirection"
                    wire:click="sort('orden')" class="text-center">Orden</flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'nombre'" :direction="$sortDirection"
                    wire:click="sort('nombre')">Nombre</flux:table.column>
                <flux:table.column>Título</flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'tipo'" :direction="$sortDirection"
                    wire:click="sort('tipo')">Tipo</flux:table.column>
                <flux:table.column>Acciones</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($this->members as $member)
                    <flux:table.row :key="$member->id" class="group">
                        <flux:table.cell class="text-center" x-data="{ showEdit: false }">
                            <div class="flex items-center justify-center space-x-2">
                                <span class="text-sm font-medium">{{ $member->orden }}</span>

                                @if($editingOrderId === $member->id)
                                    <!-- Order arrows when editing -->
                                    <div class="flex flex-col space-y-1">
                                        <flux:button wire:click="moveUp({{ $member->id }})" size="xs" variant="subtle"
                                            icon="chevron-up" class="!text-forest-800">
                                        </flux:button>
                                        <flux:button wire:click="moveDown({{ $member->id }})" size="xs" variant="subtle"
                                            icon="chevron-down" class="!text-forest-800">
                                        </flux:button>
                                    </div>
                                @else
                                    <!-- Pencil icon on hover -->
                                    <flux:button wire:click="toggleOrderEdit({{ $member->id }})" size="xs" variant="subtle"
                                        icon="pencil"
                                        class="!text-forest-800 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                    </flux:button>
                                @endif
                            </div>
                        </flux:table.cell>

                        <flux:table.cell wire:click.prevent="editMember({{ $member->id }})">
                            <span class="group-hover:underline cursor-pointer">
                                {{ $member->nombre }}
                            </span>
                        </flux:table.cell>

                        <flux:table.cell>
                            {{ \Str::limit($member->titulo, 40) }}
                        </flux:table.cell>

                        <flux:table.cell>
                            <flux:badge size="sm" color="blue">
                                {{ $tipoOptions[$member->tipo] ?? $member->tipo }}
                            </flux:badge>
                        </flux:table.cell>

                        <flux:table.cell class="space-x-1">
                            <flux:tooltip content="Editar">
                                <flux:button wire:click="editMember({{ $member->id }})" size="xs" variant="subtle"
                                    icon="pencil" class="!text-forest-800 !cursor-pointer">
                                </flux:button>
                            </flux:tooltip>
                            <flux:button x-on:click="window.Swal.fire({
                                            title: '¿Estás seguro?',
                                            text: '¿Deseas eliminar este miembro? Esta acción no se puede deshacer.',
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonText: 'Si, eliminar',
                                            cancelButtonText: 'Cancelar',
                                            confirmButtonColor: '#d33',
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                $wire.delete({{ $member->id }})
                                            }
                                        })" variant="subtle" size="xs" icon="trash"
                                class="!text-forest-800 !cursor-pointer">
                            </flux:button>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="5" class="text-center">
                            No hay miembros registrados
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>
    </flux:card>

    <!-- Create Modal -->
    <flux:modal name="createMember" class="md:w-2xl">
        <div class="flex justify-between items-center mb-6">
            <flux:heading size="lg">Crear Miembro del Equipo</flux:heading>
        </div>

        <form wire:submit="store" class="space-y-6">
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
            <flux:field>
                <flux:label>Nombre</flux:label>
                <flux:input wire:model="nombre" placeholder="Nombre completo..." />
                <flux:error name="nombre" />
            </flux:field>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <flux:field>
                    <flux:label>Tipo</flux:label>
                    <flux:select wire:model="tipo">
                        <option value="">Seleccionar tipo...</option>
                        @foreach($tipoOptions as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </flux:select>
                    <flux:error name="tipo" />
                </flux:field>

                <flux:field>
                    <flux:label>Orden</flux:label>
                    <flux:input wire:model="orden" type="number" min="1" />
                    <flux:error name="orden" />
                </flux:field>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <flux:field>
                    <flux:label>Título (Español)</flux:label>
                    <flux:input wire:model="titulo" placeholder="Cargo o título..." />
                    <flux:error name="titulo" />
                </flux:field>

                <flux:field>
                    <div class="flex items-center justify-between mb-2">
                        <flux:label>Título (Inglés)</flux:label>
                        <flux:button wire:click="translateMember" size="xs" variant="ghost" icon="language"
                            class="!text-purple-600 hover:!text-purple-700">
                            Traducir
                        </flux:button>
                    </div>
                    <flux:input wire:model="titulo_en" placeholder="Title in English..." />
                    <flux:error name="titulo_en" />
                </flux:field>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <flux:field>
                    <flux:label>Biografía (Español)</flux:label>
                    <flux:textarea wire:model="biografia" rows="4" placeholder="Biografía del miembro..." />
                    <flux:error name="biografia" />
                </flux:field>

                <flux:field>
                    <flux:label>Biografía (Inglés)</flux:label>
                    <flux:textarea wire:model="biografia_en" rows="4" placeholder="Member biography..." />
                    <flux:error name="biografia_en" />
                </flux:field>
            </div>

            <div class="flex justify-end space-x-2">
                <flux:button type="button" variant="ghost" wire:click="cancelCreate">Cancelar</flux:button>
                <flux:button type="submit" variant="primary">Crear Miembro</flux:button>
            </div>
        </form>
    </flux:modal>

    <!-- Edit Modal -->
    <flux:modal name="editMember" class="md:w-2xl">
        <div class="flex justify-between items-center mb-6">
            <flux:heading size="lg">Editar Miembro del Equipo</flux:heading>
        </div>

        <form wire:submit="update" class="space-y-6">
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
            <flux:field>
                <flux:label>Nombre</flux:label>
                <flux:input wire:model="nombre" placeholder="Nombre completo..." />
                <flux:error name="nombre" />
            </flux:field>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <flux:field>
                    <flux:label>Tipo</flux:label>
                    <flux:select wire:model="tipo">
                        <option value="">Seleccionar tipo...</option>
                        @foreach($tipoOptions as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </flux:select>
                    <flux:error name="tipo" />
                </flux:field>

                <flux:field>
                    <flux:label>Orden</flux:label>
                    <flux:input wire:model="orden" type="number" min="1" />
                    <flux:error name="orden" />
                </flux:field>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <flux:field>
                    <flux:label>Título (Español)</flux:label>
                    <flux:input wire:model="titulo" placeholder="Cargo o título..." />
                    <flux:error name="titulo" />
                </flux:field>

                <flux:field>
                    <div class="flex items-center justify-between mb-2">
                        <flux:label>Título (Inglés)</flux:label>
                        <flux:button wire:click="translateMember" size="xs" variant="ghost" icon="language"
                            class="!text-purple-600 hover:!text-purple-700">
                            Traducir
                        </flux:button>
                    </div>
                    <flux:input wire:model="titulo_en" placeholder="Title in English..." />
                    <flux:error name="titulo_en" />
                </flux:field>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <flux:field>
                    <flux:label>Biografía (Español)</flux:label>
                    <flux:textarea wire:model="biografia" rows="4" placeholder="Biografía del miembro..." />
                    <flux:error name="biografia" />
                </flux:field>

                <flux:field>
                    <flux:label>Biografía (Inglés)</flux:label>
                    <flux:textarea wire:model="biografia_en" rows="4" placeholder="Member biography..." />
                    <flux:error name="biografia_en" />
                </flux:field>
            </div>

            <div class="flex justify-end space-x-2">
                <flux:button type="button" variant="ghost" wire:click="cancelEdit">Cancelar</flux:button>
                <flux:button type="submit" variant="primary">Actualizar Miembro</flux:button>
            </div>
        </form>
    </flux:modal>
</div>