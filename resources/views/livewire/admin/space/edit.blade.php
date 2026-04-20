<div>
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <flux:heading size="xl" class="!text-forest-800 font-serif">
                Editar Espacio de Colaboración
            </flux:heading>
            <flux:subheading class="mt-1">
                {{ $space->nombre }}
            </flux:subheading>
        </div>

        <flux:button wire:click="cancel" variant="ghost" icon="arrow-left" size="sm">
            Volver al listado
        </flux:button>
    </div>

    <!-- Full width layout -->
    <div class="w-full">
        <flux:card class="p-6">
            <form wire:submit="update" class="space-y-6">

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
                    <flux:label>Imagen</flux:label>
                    @if($this->currentMultimedia)
                        <div class="mb-4 flex items-center space-x-4">
                            <img src="{{ asset('storage/' . $this->currentMultimedia->filename) }}"
                                class="w-24 h-24 object-cover rounded-lg" alt="Imagen actual">
                            <div class="flex-1">
                                <p class="text-sm text-gray-600 mb-2">Imagen actual</p>
                                <flux:button type="button" size="sm" variant="danger" wire:click="removeMultimedia">
                                    Eliminar imagen
                                </flux:button>
                            </div>
                        </div>
                    @endif
                    <flux:input type="file" wire:model="multimedia" accept="image/*" />
                    <flux:error name="multimedia" />
                    @if ($multimedia)
                        <div class="mt-2">
                            <img src="{{ $multimedia->temporaryUrl() }}" class="w-32 h-32 object-cover rounded"
                                alt="Preview">
                        </div>
                    @endif
                </flux:field>

                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <flux:button type="button" variant="ghost" wire:click="cancel">
                        Cancelar
                    </flux:button>
                    <flux:button type="submit" variant="primary">
                        Guardar Cambios
                    </flux:button>
                </div>
            </form>
        </flux:card>
    </div>
</div>