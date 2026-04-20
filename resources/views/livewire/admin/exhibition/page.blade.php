<div>
    <div class="flex justify-between items-center mb-4">
        <flux:heading size="xl" class="!text-forest-800 font-serif">
            Exposiciones & Proyectos
        </flux:heading>
    </div>

    <div class="flex items-center justify-between mb-4 gap-8">
        <flux:input placeholder="Buscar exposición..." wire:model.live="search" size="sm" icon="magnifying-glass" />

        <flux:tooltip content="Crear exposición">
            <a href="{{ route('admin.exhibitions.create') }}">
                <flux:button size="sm" icon="plus" variant="primary">Crear Exposición</flux:button>
            </a>
        </flux:tooltip>
    </div>

    <flux:card class="!px-5 !pt-1.5 !pb-4 shadow-sm">
        <flux:table :paginate="$this->exhibitions">
            <flux:table.columns>
                <flux:table.column sortable :sorted="$sortBy === 'titulo'" :direction="$sortDirection"
                    wire:click="sort('titulo')">Título</flux:table.column>
                <flux:table.column>Tipo</flux:table.column>
                <flux:table.column>Estado</flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'created_at'" :direction="$sortDirection"
                    wire:click="sort('created_at')">Fecha</flux:table.column>
                <flux:table.column>Acciones</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($this->exhibitions as $exhibition)
                    <flux:table.row :key="$exhibition->id" class="group">
                        <flux:table.cell>
                            <a href="{{ route('admin.exhibitions.edit', $exhibition->id) }}"
                                class="group-hover:underline cursor-pointer">
                                {{ $exhibition->clean_title }}
                            </a>
                        </flux:table.cell>

                        <flux:table.cell>
                            @if ($exhibition->type === 'exposicion')
                                <flux:badge size="sm" color="blue">Exposición</flux:badge>
                            @else
                                <flux:badge size="sm" color="purple">Proyecto Artístico</flux:badge>
                            @endif
                        </flux:table.cell>

                        <flux:table.cell>
                            @if ($exhibition->estado === 'public')
                                <flux:badge size="sm" color="green">Público</flux:badge>
                            @else
                                <flux:badge size="sm" color="gray">Privado</flux:badge>
                            @endif
                        </flux:table.cell>

                        <flux:table.cell>{{ $exhibition->created_at->diffForHumans() }}</flux:table.cell>

                        <flux:table.cell class="space-x-1">
                            <flux:tooltip content="Editar">
                                <a href="{{ route('admin.exhibitions.edit', $exhibition->id) }}">
                                    <flux:button size="xs" variant="subtle" icon="pencil"
                                        class="!text-forest-800 !cursor-pointer">
                                    </flux:button>
                                </a>
                            </flux:tooltip>
                            <flux:button x-on:click="window.Swal.fire({
                                            title: '¿Estás seguro?',
                                            text: '¿Deseas eliminar esta exposición? Esta acción no se puede deshacer.',
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonText: 'Si, eliminar',
                                            cancelButtonText: 'Cancelar',
                                            confirmButtonColor: '#d33',
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                $wire.delete({{ $exhibition->id }})
                                            }
                                        })" variant="subtle" size="xs" icon="trash"
                                class="!text-forest-800 !cursor-pointer">
                            </flux:button>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="5" class="text-center">
                            No hay exposiciones registradas
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>
    </flux:card>
</div>