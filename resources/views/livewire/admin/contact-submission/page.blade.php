<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <flux:heading size="xl" class="!text-forest-800 font-serif">
                Formularios de Contacto
            </flux:heading>
            <p class="text-sm text-zinc-600 mt-1">
                Administra los mensajes recibidos a través del sitio web
            </p>
        </div>
    </div>

    <flux:card class="!p-6">
        <div class="flex flex-col md:flex-row gap-4 mb-6 justify-between items-start md:items-center">
            <!-- Search -->
            <div class="w-full md:w-64">
                <flux:input wire:model.live.debounce.300ms="search" placeholder="Buscar..." icon="magnifying-glass" />
            </div>

            <!-- Filters -->
            <div class="flex gap-2 w-full md:w-auto">
                <select wire:model.live="filterType"
                    class="rounded-lg border-zinc-200 text-sm focus:ring-forest-600 focus:border-forest-600">
                    <option value="">Todos los tipos</option>
                    <option value="contact">Contacto General</option>
                    <option value="aliados">Aliados</option>
                    <option value="newsletter">Newsletter</option>
                </select>
            </div>
        </div>

        <!-- Table -->
        <flux:table :paginate="$this->submissions">
            <flux:table.columns>
                <flux:table.column sortable :sorted="$sortBy === 'created_at'" :direction="$sortDirection"
                    wire:click="sort('created_at')">Fecha</flux:table.column>
                <flux:table.column sortable :sorted="$sortBy === 'nombre'" :direction="$sortDirection"
                    wire:click="sort('nombre')">Nombre</flux:table.column>
                <flux:table.column>Email</flux:table.column>
                <flux:table.column>Tipo</flux:table.column>
                <flux:table.column>Mensaje</flux:table.column>
                <flux:table.column>Newsletter</flux:table.column>
                <flux:table.column>Acciones</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($this->submissions as $submission)
                    <flux:table.row :key="$submission->id">
                        <flux:table.cell class="whitespace-nowrap text-zinc-500 text-xs">
                            {{ $submission->created_at->format('d M Y, H:i') }}
                        </flux:table.cell>

                        <flux:table.cell>
                            <div class="font-medium text-zinc-900">{{ $submission->nombre }}</div>
                            @if($submission->organizacion)
                                <div class="text-xs text-zinc-500">{{ $submission->organizacion }}</div>
                            @endif
                        </flux:table.cell>

                        <flux:table.cell class="text-zinc-600">
                            {{ $submission->email }}
                            @if($submission->telefono)
                                <div class="text-xs text-zinc-400 mt-0.5">{{ $submission->telefono }}</div>
                            @endif
                        </flux:table.cell>

                        <flux:table.cell>
                            <flux:badge size="sm"
                                :color="$submission->form_type === 'aliados' ? 'purple' : ($submission->form_type === 'newsletter' ? 'blue' : 'green')">
                                {{ ucfirst($submission->form_type ?? 'General') }}
                            </flux:badge>
                        </flux:table.cell>

                        <flux:table.cell>
                            @php
                                $metadata = is_array($submission->metadata) ? $submission->metadata : json_decode($submission->metadata, true) ?? [];
                                $msgSource = $metadata['mensaje'] ?? ($metadata['message'] ?? null);
                            @endphp

                            @if($msgSource)
                                <div class="max-w-xs truncate text-zinc-600 cursor-pointer hover:text-forest-700 underline decoration-dashed"
                                    wire:click="viewDetails({{ $submission->id }})">
                                    {{ Str::limit($msgSource, 50) }}
                                </div>
                            @else
                                <span class="text-zinc-400 italic text-xs">Sin mensaje</span>
                            @endif
                        </flux:table.cell>

                        <flux:table.cell>
                            @if($submission->subscribed_to_mailrelay)
                                <flux:badge size="sm" color="green" icon="check">Suscrito</flux:badge>
                            @else
                                <flux:button size="xs" variant="ghost" class="text-zinc-400 hover:text-blue-600"
                                    wire:click="subscribeToNewsletter({{ $submission->id }})" title="Suscribir manualmente">
                                    No suscrito
                                </flux:button>
                            @endif
                        </flux:table.cell>

                        <flux:table.cell>
                            <flux:button x-on:click="window.Swal.fire({
                                        title: '¿Estás seguro?',
                                        text: '¿Deseas eliminar este registro?',
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonText: 'Si, eliminar',
                                        cancelButtonText: 'Cancelar',
                                        confirmButtonColor: '#d33',
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            $wire.delete({{ $submission->id }})
                                        }
                                    })" variant="ghost" size="sm" icon="trash"
                                class="text-red-600 hover:text-red-700 hover:bg-red-50" />
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="7" class="text-center py-8 text-zinc-500">
                            No se encontraron registros.
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>
    </flux:card>

    <!-- Details Modal -->
    <flux:modal name="messageDetails" class="md:w-1/2 max-w-2xl">
        <div class="p-6 space-y-4">
            <h3 class="text-lg font-bold text-forest-800">{{ $this->currentSubject }}</h3>
            <div class="bg-zinc-50 p-4 rounded-lg text-zinc-700 whitespace-pre-wrap font-sans text-sm leading-relaxed">
                {{ $this->currentMessage }}
            </div>
            <div class="flex justify-end">
                <flux:button variant="ghost" wire:click="closeMessageDetails">Cerrar</flux:button>
            </div>
        </div>
    </flux:modal>
</div>