<div>
    <div class="flex justify-between items-center mb-4">
        <flux:heading size="xl" class="!text-forest-800 font-serif">
            Espacios de Colaboración
        </flux:heading>
    </div>

    <div class="flex items-center justify-between mb-4 gap-8">
        <flux:input placeholder="Buscar espacio..." wire:model.live="search" size="sm" icon="magnifying-glass" />

        <flux:modal.trigger name="createSpace">
            <flux:tooltip content="Crear espacio">
                <flux:button size="sm" icon="plus" variant="primary" wire:click="openCreateModal"></flux:button>
            </flux:tooltip>
        </flux:modal.trigger>
    </div>

    <flux:card class="!px-5 !pt-1.5 !pb-4 shadow-sm">
        <flux:table :paginate="$this->spaces">
            <flux:table.columns>
                <flux:table.column sortable :sorted="$sortBy === 'nombre'" :direction="$sortDirection"
                    wire:click="sort('nombre')">Nombre</flux:table.column>
                <flux:table.column>Ubicación</flux:table.column>
                <flux:table.column>Estado</flux:table.column>
                <flux:table.column>Acciones</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($this->spaces as $space)
                    <flux:table.row :key="$space->id" class="group">
                        <flux:table.cell>
                            <a href="{{ route('admin.spaces.edit', $space->id) }}"
                                class="group-hover:underline cursor-pointer">
                                {{ $space->nombre }}
                            </a>
                        </flux:table.cell>

                        <flux:table.cell>
                            {{ \Str::limit($space->ubicacion, 50) }}
                        </flux:table.cell>

                        <flux:table.cell>
                            @if($space->status === 'activo')
                                <flux:badge size="sm" color="green">Aliados</flux:badge>
                            @else
                                <flux:badge size="sm" color="gray">Iniciativas Afines</flux:badge>
                            @endif
                        </flux:table.cell>

                        <flux:table.cell class="space-x-1">
                            @if($space->url)
                                <flux:tooltip content="Ver sitio web">
                                    <a href="{{ $space->url }}" target="_blank">
                                        <flux:button size="xs" variant="subtle" icon="globe-alt"
                                            class="!text-forest-800 !cursor-pointer">
                                        </flux:button>
                                    </a>
                                </flux:tooltip>
                            @endif
                            <flux:tooltip content="Editar">
                                <a href="{{ route('admin.spaces.edit', $space->id) }}">
                                    <flux:button size="xs" variant="subtle" icon="pencil"
                                        class="!text-forest-800 !cursor-pointer">
                                    </flux:button>
                                </a>
                            </flux:tooltip>
                            <flux:button x-on:click="window.Swal.fire({
                                            title: '¿Estás seguro?',
                                            text: '¿Deseas eliminar este espacio? Esta acción no se puede deshacer.',
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonText: 'Si, eliminar',
                                            cancelButtonText: 'Cancelar',
                                            confirmButtonColor: '#d33',
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                $wire.delete({{ $space->id }})
                                            }
                                        })" variant="subtle" size="xs" icon="trash"
                                class="!text-forest-800 !cursor-pointer">
                            </flux:button>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="4" class="text-center">
                            No hay espacios registrados
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>
    </flux:card>

    <!-- Create Modal -->
    <flux:modal name="createSpace" class="md:w-2xl">
        <div class="flex justify-between items-center mb-6">
            <flux:heading size="lg">Crear Espacio</flux:heading>
        </div>

        <form wire:submit="store" class="space-y-6">
            <flux:field>
                <flux:label>Nombre del Espacio</flux:label>
                <flux:input wire:model="nombre" placeholder="Nombre del espacio..." />
                <flux:error name="nombre" />
            </flux:field>

            <flux:field>
                <flux:label>URL (opcional)</flux:label>
                <flux:input wire:model="url" placeholder="https://..." />
                <flux:error name="url" />
            </flux:field>

            <flux:field>
                <flux:label>Ubicación</flux:label>
                <flux:input wire:model="ubicacion" placeholder="Dirección del espacio..." />
                <flux:error name="ubicacion" />
            </flux:field>

            <div class="grid grid-cols-2 gap-4">
                <flux:field>
                    <flux:label>Latitud</flux:label>
                    <flux:input wire:model="ubicacion_lat" type="number" step="any" placeholder="19.4326" />
                    <flux:error name="ubicacion_lat" />
                </flux:field>

                <flux:field>
                    <flux:label>Longitud</flux:label>
                    <flux:input wire:model="ubicacion_long" type="number" step="any" placeholder="-99.1332" />
                    <flux:error name="ubicacion_long" />
                </flux:field>
            </div>

            <flux:field>
                <flux:label>Estado</flux:label>
                <flux:select wire:model="status">
                    <option value="activo">Aliados</option>
                    <option value="finalizado">Iniciativas Afines</option>
                </flux:select>
                <flux:error name="status" />
            </flux:field>

            <flux:field>
                <flux:label>Imagen (opcional)</flux:label>
                <flux:input type="file" wire:model="multimedia" accept="image/*" />
                <flux:error name="multimedia" />
                @if ($multimedia)
                    <div class="mt-2">
                        <img src="{{ $multimedia->temporaryUrl() }}" class="w-32 h-32 object-cover rounded" alt="Preview">
                    </div>
                @endif
            </flux:field>



            <div class="flex justify-end space-x-2">
                <flux:button type="button" variant="ghost" wire:click="cancelCreate">Cancelar</flux:button>
                <flux:button type="submit" variant="primary">Crear Espacio</flux:button>
            </div>
        </form>
    </flux:modal>

</div>