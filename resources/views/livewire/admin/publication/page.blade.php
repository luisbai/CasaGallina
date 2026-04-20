<div class="grid grid-cols-1 gap-6">
    <div class="col-span-1">
        <div class="flex justify-between items-center mb-4">
            <flux:heading size="xl" class="!text-forest-800 font-serif">
                Publicaciones
            </flux:heading>
        </div>

        <div class="flex items-center justify-between mb-4 gap-8">
            <flux:input placeholder="Buscar publicación..." wire:model.live="search" size="sm"
                icon="magnifying-glass" />

            <flux:tooltip content="Crear publicación">
                <flux:button size="sm" icon="plus" variant="primary" href="/admin/publicaciones/create" wire:navigate>
                </flux:button>
            </flux:tooltip>
        </div>

        <flux:card class="!px-5 !pt-1.5 !pb-4 shadow-sm">
            <flux:table :paginate="$this->publications">
                <flux:table.columns>
                    <flux:table.column sortable :sorted="$sortBy === 'titulo'" :direction="$sortDirection"
                        wire:click="sort('titulo')">Título</flux:table.column>
                    <flux:table.column>Tipo</flux:table.column>
                    <flux:table.column sortable :sorted="$sortBy === 'created_at'" :direction="$sortDirection"
                        wire:click="sort('created_at')">Fecha</flux:table.column>
                    <flux:table.column>Descargas</flux:table.column>
                    <flux:table.column>Vistas</flux:table.column>
                    <flux:table.column>Acciones</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @forelse ($this->publications as $publication)
                        <flux:table.row :key="$publication->id" class="group">
                            <flux:table.cell>
                                <a href="/admin/publicaciones/{{ $publication->id }}/edit" wire:navigate class="flex gap-2">
                                    <span class="group-hover:underline cursor-pointer">
                                        {{ $publication->clean_title }}
                                    </span>

                                    @if ($publication->status === 'public')
                                        <flux:badge size="sm" color="green">Pública</flux:badge>
                                    @else
                                        <flux:badge size="sm" color="gray">Solo link</flux:badge>
                                    @endif
                                </a>
                            </flux:table.cell>

                            <flux:table.cell>
                                @if ($publication->tipo === 'impreso')
                                    <flux:badge size="sm" color="blue">Impreso</flux:badge>
                                @else
                                    <flux:badge size="sm" color="orange">Digital</flux:badge>
                                @endif
                            </flux:table.cell>

                            <flux:table.cell>{{ $publication->created_at->diffForHumans() }}</flux:table.cell>
                            <flux:table.cell>{{ $publication->downloads }}</flux:table.cell>
                            <flux:table.cell>{{ $publication->views }}</flux:table.cell>

                            <flux:table.cell class="space-x-1">
                                <flux:tooltip content="Editar">
                                    <flux:button href="/admin/publicaciones/{{ $publication->id }}/edit" wire:navigate
                                        size="xs" variant="subtle" icon="pencil" class="!text-forest-800 !cursor-pointer">
                                    </flux:button>
                                </flux:tooltip>
                                <flux:button x-on:click="window.Swal.fire({
                                            title: '¿Estás seguro?',
                                            text: 'Esta acción no se puede deshacer.',
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonText: 'Si, eliminar',
                                            cancelButtonText: 'Cancelar',
                                            confirmButtonColor: '#d33',
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                $wire.delete({{ $publication->id }})
                                            }
                                        })" variant="subtle" size="xs" icon="trash"
                                    class="!text-forest-800 !cursor-pointer">
                                </flux:button>
                            </flux:table.cell>
                        </flux:table.row>
                    @empty
                        <flux:table.row>
                            <flux:table.cell colspan="6" class="text-center">
                                No hay publicaciones
                            </flux:table.cell>
                        </flux:table.row>
                    @endforelse
                </flux:table.rows>
            </flux:table>
        </flux:card>
    </div>


</div>