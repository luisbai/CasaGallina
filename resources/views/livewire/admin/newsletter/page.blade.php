<div>
    <div class="flex justify-between items-center mb-4">
        <flux:heading size="xl" class="!text-forest-800 font-serif">
            Boletines
        </flux:heading>
    </div>

    <div class="flex items-center justify-between mb-4 gap-8">
        <flux:input placeholder="Buscar por fecha..." wire:model.live="search" size="sm" icon="magnifying-glass" />

        <flux:modal.trigger name="createBoletin">
            <flux:tooltip content="Crear boletín">
                <flux:button size="sm" icon="plus" variant="primary" wire:click="openCreateModal"></flux:button>
            </flux:tooltip>
        </flux:modal.trigger>
    </div>

    <flux:card class="!px-5 !pt-1.5 !pb-4 shadow-sm">
        <flux:table :paginate="$this->boletines">
            <flux:table.columns>
                <flux:table.column sortable :sorted="$sortBy === 'boletin_fecha'" :direction="$sortDirection"
                    wire:click="sort('boletin_fecha')">Fecha</flux:table.column>
                <flux:table.column>PDF Español</flux:table.column>
                <flux:table.column>PDF Inglés</flux:table.column>
                <flux:table.column>Acciones</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($this->boletines as $boletin)
                    <flux:table.row :key="$boletin->id" class="group">
                        <flux:table.cell wire:click.prevent="editBoletin({{ $boletin->id }})">
                            <span class="group-hover:underline cursor-pointer">
                                {{ $boletin->boletin_fecha ? $boletin->boletin_fecha->format('d/m/Y') : 'Sin fecha' }}
                            </span>
                        </flux:table.cell>

                        <flux:table.cell>
                            @if($boletin->multimedia_es)
                                <div class="flex items-center space-x-2">
                                    <flux:badge size="sm" color="green">Disponible</flux:badge>
                                    <a href="{{ asset('storage/' . $boletin->multimedia_es->filename) }}" target="_blank">
                                        <flux:button size="xs" variant="subtle" icon="arrow-down-tray" class="!text-forest-800">
                                        </flux:button>
                                    </a>
                                </div>
                            @else
                                <flux:badge size="sm" color="red">No disponible</flux:badge>
                            @endif
                        </flux:table.cell>

                        <flux:table.cell>
                            @if($boletin->multimedia_en)
                                <div class="flex items-center space-x-2">
                                    <flux:badge size="sm" color="green">Disponible</flux:badge>
                                    <a href="{{ asset('storage/' . $boletin->multimedia_en->filename) }}" target="_blank">
                                        <flux:button size="xs" variant="subtle" icon="arrow-down-tray" class="!text-forest-800">
                                        </flux:button>
                                    </a>
                                </div>
                            @else
                                <flux:badge size="sm" color="red">No disponible</flux:badge>
                            @endif
                        </flux:table.cell>

                        <flux:table.cell class="space-x-1">
                            <flux:tooltip content="Editar">
                                <flux:button wire:click="editBoletin({{ $boletin->id }})" size="xs" variant="subtle"
                                    icon="pencil" class="!text-forest-800 !cursor-pointer">
                                </flux:button>
                            </flux:tooltip>
                            <flux:button x-on:click="window.Swal.fire({
                                        title: '¿Estás seguro?',
                                        text: '¿Deseas eliminar este boletín? Esta acción no se puede deshacer.',
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonText: 'Si, eliminar',
                                        cancelButtonText: 'Cancelar',
                                        confirmButtonColor: '#d33',
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            $wire.delete({{ $boletin->id }})
                                        }
                                    })" variant="subtle" size="xs" icon="trash" class="!text-forest-800 !cursor-pointer">
                            </flux:button>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="4" class="text-center">
                            No hay boletines registrados
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>
    </flux:card>

    <!-- Create Modal -->
    <flux:modal name="createBoletin" class="md:w-2xl">
        <div class="flex justify-between items-center mb-6">
            <flux:heading size="lg">Crear Boletín</flux:heading>
        </div>

        <form wire:submit="store" class="space-y-6">
            <flux:field>
                <flux:label>Fecha del Boletín</flux:label>
                <flux:date-picker wire:model="boletin_fecha" placeholder="Selecciona una fecha" />
                <flux:error name="boletin_fecha" />
            </flux:field>

            <flux:field>
                <flux:label>PDF en Español</flux:label>
                <flux:input type="file" wire:model="multimedia_es" accept=".pdf" />
                <flux:error name="multimedia_es" />
                <div wire:loading wire:target="multimedia_es" class="text-sm text-gray-600 mt-1">
                    Subiendo archivo...
                </div>
                @if ($multimedia_es)
                    <div class="mt-2 text-sm text-green-600">
                        ✓ Archivo seleccionado: {{ $multimedia_es->getClientOriginalName() }}
                        ({{ number_format($multimedia_es->getSize() / 1024, 0) }} KB)
                    </div>
                @endif
            </flux:field>

            <flux:field>
                <flux:label>PDF en Inglés</flux:label>
                <flux:input type="file" wire:model="multimedia_en" accept=".pdf" />
                <flux:error name="multimedia_en" />
                <div wire:loading wire:target="multimedia_en" class="text-sm text-gray-600 mt-1">
                    Subiendo archivo...
                </div>
                @if ($multimedia_en)
                    <div class="mt-2 text-sm text-green-600">
                        ✓ Archivo seleccionado: {{ $multimedia_en->getClientOriginalName() }}
                        ({{ number_format($multimedia_en->getSize() / 1024, 0) }} KB)
                    </div>
                @endif
            </flux:field>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex">
                    <flux:icon name="information-circle" class="h-5 w-5 text-blue-400" />
                    <div class="ml-3 text-sm text-blue-700">
                        <p>Los archivos PDF deben tener un tamaño máximo de 50MB.</p>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-2">
                <flux:button type="button" variant="ghost" wire:click="cancelCreate">Cancelar</flux:button>
                <flux:button type="submit" variant="primary" wire:loading.attr="disabled">
                    <span wire:loading.remove>Crear Boletín</span>
                    <span wire:loading>Creando...</span>
                </flux:button>
            </div>
        </form>
    </flux:modal>

    <!-- Edit Modal -->
    <flux:modal name="editBoletin" class="md:w-2xl">
        <div class="flex justify-between items-center mb-6">
            <flux:heading size="lg">Editar Boletín</flux:heading>
        </div>

        <form wire:submit="update" class="space-y-6">
            <flux:field>
                <flux:label>Fecha del Boletín</flux:label>
                <flux:date-picker wire:model="boletin_fecha" placeholder="Selecciona una fecha" />
                <flux:error name="boletin_fecha" />
            </flux:field>

            <flux:field>
                <flux:label>PDF en Español</flux:label>
                @if($this->currentBoletin && $this->currentBoletin->multimedia_es)
                    <div class="mb-2 flex items-center space-x-2 p-3 bg-gray-50 rounded-lg">
                        <flux:icon.document-text class="h-5 w-5 text-gray-500" />
                        <span class="text-sm text-gray-700 flex-1">
                            {{ basename($this->currentBoletin->multimedia_es->filename) }}
                        </span>
                        <a href="{{ asset('storage/' . $this->currentBoletin->multimedia_es->filename) }}" target="_blank">
                            <flux:button type="button" size="xs" variant="subtle" icon="eye">Ver</flux:button>
                        </a>
                        <flux:button type="button" size="xs" variant="danger" wire:click="removePDF('es')">
                            Eliminar
                        </flux:button>
                    </div>
                @endif
                <flux:input type="file" wire:model="multimedia_es" accept=".pdf" />
                <flux:error name="multimedia_es" />
                <div wire:loading wire:target="multimedia_es" class="text-sm text-gray-600 mt-1">
                    Subiendo archivo...
                </div>
                @if ($multimedia_es)
                    <div class="mt-2 text-sm text-green-600">
                        ✓ Nuevo archivo seleccionado: {{ $multimedia_es->getClientOriginalName() }}
                        ({{ number_format($multimedia_es->getSize() / 1024, 0) }} KB)
                    </div>
                @endif
            </flux:field>

            <flux:field>
                <flux:label>PDF en Inglés</flux:label>
                @if($this->currentBoletin && $this->currentBoletin->multimedia_en)
                    <div class="mb-2 flex items-center space-x-2 p-3 bg-gray-50 rounded-lg">
                        <flux:icon.document-text class="h-5 w-5 text-gray-500" />
                        <span class="text-sm text-gray-700 flex-1">
                            {{ basename($this->currentBoletin->multimedia_en->filename) }}
                        </span>
                        <a href="{{ asset('storage/' . $this->currentBoletin->multimedia_en->filename) }}" target="_blank">
                            <flux:button type="button" size="xs" variant="subtle" icon="eye">Ver</flux:button>
                        </a>
                        <flux:button type="button" size="xs" variant="danger" wire:click="removePDF('en')">
                            Eliminar
                        </flux:button>
                    </div>
                @endif
                <flux:input type="file" wire:model="multimedia_en" accept=".pdf" />
                <flux:error name="multimedia_en" />
                <div wire:loading wire:target="multimedia_en" class="text-sm text-gray-600 mt-1">
                    Subiendo archivo...
                </div>
                @if ($multimedia_en)
                    <div class="mt-2 text-sm text-green-600">
                        ✓ Nuevo archivo seleccionado: {{ $multimedia_en->getClientOriginalName() }}
                        ({{ number_format($multimedia_en->getSize() / 1024, 0) }} KB)
                    </div>
                @endif
            </flux:field>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex">
                    <flux:icon name="information-circle" class="h-5 w-5 text-blue-400" />
                    <div class="ml-3 text-sm text-blue-700">
                        <p>Solo selecciona archivos PDF si deseas reemplazar los existentes. Los archivos deben tener un
                            tamaño máximo de 50MB.</p>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-2">
                <flux:button type="button" variant="ghost" wire:click="cancelEdit">Cancelar</flux:button>
                <flux:button type="submit" variant="primary" wire:loading.attr="disabled">
                    <span wire:loading.remove>Actualizar Boletín</span>
                    <span wire:loading>Actualizando...</span>
                </flux:button>
            </div>
        </form>
    </flux:modal>
</div>