<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <flux:heading size="xl" class="!text-forest-800 font-serif">
                Homepage
            </flux:heading>
            <p class="text-sm text-zinc-600 mt-1">
                Gestiona el contenido de la página de inicio
            </p>
        </div>
    </div>

    <!-- Intro Content Section -->
    <div class="grid grid-cols-1 gap-6">
        <flux:card class="p-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <flux:heading size="lg" class="!text-forest-800 font-serif mb-2">
                        Contenido Introductorio
                    </flux:heading>
                    <p class="text-sm text-zinc-600">
                        Edita el texto principal y secundario que aparece en el inicio.
                    </p>
                </div>
                <flux:button variant="primary" wire:click="editContent">
                    <flux:icon.pencil-square class="w-4 h-4 mr-2" />
                    Editar Contenido
                </flux:button>
            </div>

            @if($this->introContent)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                    <div class="bg-zinc-50 p-4 rounded-lg">
                        <h4 class="font-medium text-forest-700 mb-2">Texto Principal (ES)</h4>
                        <div class="prose prose-sm max-w-none text-zinc-600">
                            {!! $this->introContent->main_text_es !!}
                        </div>
                    </div>
                    <div class="bg-zinc-50 p-4 rounded-lg">
                        <h4 class="font-medium text-forest-700 mb-2">Texto Secundario (ES)</h4>
                        <div class="prose prose-sm max-w-none text-zinc-600">
                            {!! $this->introContent->secondary_text_es !!}
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-8 bg-zinc-50 rounded-lg text-zinc-500">
                    No hay contenido introductorio configurado.
                </div>
            @endif
        </flux:card>
    </div>

    <!-- Banners Section -->
    <div class="grid grid-cols-1 gap-6">
        <flux:card class="p-6">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <flux:heading size="lg" class="!text-forest-800 font-serif">
                        Banners
                    </flux:heading>
                    <p class="text-sm text-zinc-600 mt-1">
                        Gestiona los banners rotativos del inicio.
                    </p>
                </div>
                <flux:button variant="filled" wire:click="openCreateModal">
                    <flux:icon.plus class="w-4 h-4 mr-2" />
                    Nuevo Banner
                </flux:button>
            </div>

            <!-- Search -->
            <div class="mb-6">
                <flux:input wire:model.live="search" placeholder="Buscar banners..." icon="magnifying-glass" />
            </div>

            <!-- Table -->
            <flux:table>
                <flux:table.columns>
                    <flux:table.column>Imagen</flux:table.column>
                    <flux:table.column>Contenido (ES)</flux:table.column>
                    <flux:table.column>Estado</flux:table.column>
                    <flux:table.column>Acciones</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @forelse($this->banners as $banner)
                        <flux:table.row :key="$banner->id">
                            <flux:table.cell>
                                <div class="h-16 w-24 bg-zinc-100 rounded overflow-hidden">
                                    @if($banner->backgroundImage)
                                        <img src="{{ asset('storage/' . $banner->backgroundImage->filename) }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-zinc-400">
                                            <flux:icon.photo class="w-6 h-6" />
                                        </div>
                                    @endif
                                </div>
                            </flux:table.cell>
                            <flux:table.cell>
                                <div class="max-w-md truncate">
                                    {{ Str::limit(strip_tags($banner->content_es), 50) }}
                                </div>
                            </flux:table.cell>
                            <flux:table.cell>
                                <flux:badge :color="$banner->is_active ? 'green' : 'zinc'" size="sm">
                                    {{ $banner->is_active ? 'Activo' : 'Inactivo' }}
                                </flux:badge>
                            </flux:table.cell>
                            <flux:table.cell>
                                <div class="flex gap-2">
                                    <flux:button size="sm" variant="ghost" icon="pencil-square"
                                        wire:click="editBanner({{ $banner->id }})" />

                                    <flux:button size="sm" variant="ghost"
                                        icon="{{ $banner->is_active ? 'eye-slash' : 'eye' }}"
                                        wire:click="toggleActive({{ $banner->id }})" />

                                    <flux:button size="sm" variant="ghost" icon="trash"
                                        class="text-red-600 hover:text-red-700" x-on:click="window.Swal.fire({
                                                            title: '¿Estás seguro?',
                                                            text: '¿Deseas eliminar este banner?',
                                                            icon: 'warning',
                                                            showCancelButton: true,
                                                            confirmButtonText: 'Si, eliminar',
                                                            cancelButtonText: 'Cancelar',
                                                            confirmButtonColor: '#d33',
                                                        }).then((result) => {
                                                            if (result.isConfirmed) {
                                                                $wire.delete({{ $banner->id }})
                                                            }
                                                        })" />
                                </div>
                            </flux:table.cell>
                        </flux:table.row>
                    @empty
                        <flux:table.row>
                            <flux:table.cell colspan="4" class="text-center py-8 text-zinc-500">
                                No se encontraron banners.
                            </flux:table.cell>
                        </flux:table.row>
                    @endforelse
                </flux:table.rows>
            </flux:table>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $this->banners->links() }}
            </div>
        </flux:card>
    </div>

    <!-- Create Banner Modal -->
    <flux:modal name="createBanner" class="md:w-3/4 max-w-4xl">
        <div class="p-6">
            <h2 class="text-xl font-bold text-forest-800 mb-6">Crear Nuevo Banner</h2>

            @if($quotaExceeded)
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg flex items-center gap-3 text-red-800">
                    <flux:icon.exclamation-triangle class="w-5 h-5 text-red-500" />
                    <div>
                        <p class="font-bold text-sm">Cuota de traducción excedida</p>
                        <p class="text-xs">Se ha alcanzado el límite diario. Espere a que se reinicie o traduzca
                            manualmente.</p>
                    </div>
                </div>
            @endif

            <form wire:submit="store" class="space-y-6">
                <!-- Image Upload -->
                <div>
                    <flux:label>Imagen de Fondo</flux:label>
                    <div
                        class="mt-2 flex items-center justify-center border-2 border-dashed border-zinc-300 rounded-lg p-6 hover:bg-zinc-50 transition-colors">
                        @if ($background_image)
                            <div class="relative w-full">
                                <img src="{{ $background_image->temporaryUrl() }}" class="max-h-64 mx-auto rounded">
                                <button type="button" wire:click="$set('background_image', null)"
                                    class="absolute top-2 right-2 bg-red-500 text-white p-1 rounded-full shadow hover:bg-red-600">
                                    <flux:icon.x-mark class="w-4 h-4" />
                                </button>
                            </div>
                        @else
                            <label class="cursor-pointer flex flex-col items-center">
                                <flux:icon.cloud-arrow-up class="w-8 h-8 text-zinc-400 mb-2" />
                                <span class="text-sm text-zinc-600">Click para subir imagen</span>
                                <input type="file" wire:model="background_image" class="hidden" accept="image/*">
                            </label>
                        @endif
                    </div>
                    @error('background_image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Español -->
                    <div class="space-y-4">
                        <flux:heading size="md" class="text-forest-700 border-b pb-2">Español</flux:heading>

                        <flux:textarea label="Contenido (HTML)" wire:model="content_es" rows="4" />

                        <flux:input label="Texto Botón" wire:model="cta_text_es" />

                        <flux:input label="URL Botón" wire:model="cta_url_es" />
                    </div>

                    <!-- English -->
                    <div class="space-y-4">
                        <div class="flex justify-between items-center border-b pb-2">
                            <flux:heading size="md" class="text-forest-700">English</flux:heading>
                            <flux:button size="sm" variant="ghost" icon="language" wire:click="translateCreateBanner"
                                wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="translateCreateBanner">Traducir</span>
                                <flux:icon.loading wire:loading wire:target="translateCreateBanner"
                                    class="w-4 h-4 animate-spin" />
                                <span wire:loading wire:target="translateCreateBanner">Traduciendo...</span>
                            </flux:button>
                        </div>

                        <flux:textarea label="Contenido (HTML)" wire:model="content_en" rows="4" />

                        <flux:input label="Texto Botón" wire:model="cta_text_en" />

                        <flux:input label="URL Botón" wire:model="cta_url_en" />
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <flux:checkbox wire:model="is_active" label="Banner Activo" />
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <flux:button variant="ghost" wire:click="cancelCreate">Cancelar</flux:button>
                    <flux:button type="submit" variant="primary">Guardar</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>

    <!-- Edit Banner Modal -->
    <flux:modal name="editBanner" class="md:w-3/4 max-w-4xl">
        <div class="p-6">
            <h2 class="text-xl font-bold text-forest-800 mb-6">Editar Banner</h2>

            @if($quotaExceeded)
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg flex items-center gap-3 text-red-800">
                    <flux:icon.exclamation-triangle class="w-5 h-5 text-red-500" />
                    <div>
                        <p class="font-bold text-sm">Cuota de traducción excedida</p>
                        <p class="text-xs">Se ha alcanzado el límite diario. Espere a que se reinicie o traduzca
                            manualmente.</p>
                    </div>
                </div>
            @endif

            <form wire:submit="update" class="space-y-6">
                <!-- Image Upload -->
                <div>
                    <flux:label>Imagen de Fondo</flux:label>
                    <div
                        class="mt-2 flex items-center justify-center border-2 border-dashed border-zinc-300 rounded-lg p-6 hover:bg-zinc-50 transition-colors">
                        @if ($background_image)
                            <div class="relative w-full">
                                <img src="{{ $background_image->temporaryUrl() }}" class="max-h-64 mx-auto rounded">
                                <button type="button" wire:click="$set('background_image', null)"
                                    class="absolute top-2 right-2 bg-red-500 text-white p-1 rounded-full shadow hover:bg-red-600">
                                    <flux:icon.x-mark class="w-4 h-4" />
                                </button>
                            </div>
                        @elseif($background_image_id && $this->banners->firstWhere('id', $editId)?->backgroundImage)
                            <div class="relative w-full">
                                <img src="{{ asset('storage/' . $this->banners->firstWhere('id', $editId)->backgroundImage->filename) }}"
                                    class="max-h-64 mx-auto rounded">
                                <button type="button" wire:click="removeBackgroundImage"
                                    class="absolute top-2 right-2 bg-red-500 text-white p-1 rounded-full shadow hover:bg-red-600"
                                    title="Eliminar imagen actual">
                                    <flux:icon.trash class="w-4 h-4" />
                                </button>
                            </div>
                        @else
                            <label class="cursor-pointer flex flex-col items-center">
                                <flux:icon.cloud-arrow-up class="w-8 h-8 text-zinc-400 mb-2" />
                                <span class="text-sm text-zinc-600">Click para subir nueva imagen</span>
                                <input type="file" wire:model="background_image" class="hidden" accept="image/*">
                            </label>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Español -->
                    <div class="space-y-4">
                        <flux:heading size="md" class="text-forest-700 border-b pb-2">Español</flux:heading>

                        <flux:textarea label="Contenido (HTML)" wire:model="content_es" rows="4" />

                        <flux:input label="Texto Botón" wire:model="cta_text_es" />

                        <flux:input label="URL Botón" wire:model="cta_url_es" />
                    </div>

                    <!-- English -->
                    <div class="space-y-4">
                        <div class="flex justify-between items-center border-b pb-2">
                            <flux:heading size="md" class="text-forest-700">English</flux:heading>
                            <flux:button size="sm" variant="ghost" icon="language" wire:click="translateCreateBanner"
                                wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="translateCreateBanner">Traducir</span>
                                <flux:icon.loading wire:loading wire:target="translateCreateBanner"
                                    class="w-4 h-4 animate-spin" />
                                <span wire:loading wire:target="translateCreateBanner">Traduciendo...</span>
                            </flux:button>
                        </div>

                        <flux:textarea label="Contenido (HTML)" wire:model="content_en" rows="4" />

                        <flux:input label="Texto Botón" wire:model="cta_text_en" />

                        <flux:input label="URL Botón" wire:model="cta_url_en" />
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <flux:checkbox wire:model="is_active" label="Banner Activo" />
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <flux:button variant="ghost" wire:click="cancelEdit">Cancelar</flux:button>
                    <flux:button type="submit" variant="primary">Actualizar</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>

    <!-- Edit Content Modal -->
    <flux:modal name="editContent" class="md:w-3/4 max-w-4xl">
        <div class="p-6">
            <h2 class="text-xl font-bold text-forest-800 mb-6">Editar Contenido Introductorio</h2>

            @if($quotaExceeded)
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg flex items-center gap-3 text-red-800">
                    <flux:icon.exclamation-triangle class="w-5 h-5 text-red-500" />
                    <div>
                        <p class="font-bold text-sm">Cuota de traducción excedida</p>
                        <p class="text-xs">Se ha alcanzado el límite diario. Espere a que se reinicie o traduzca
                            manualmente.</p>
                    </div>
                </div>
            @endif

            <form wire:submit="saveContent" class="space-y-6">
                <!-- Text Editor -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <flux:heading size="md" class="text-forest-700 border-b pb-2">Texto Principal</flux:heading>
                        <flux:textarea label="Español" wire:model="main_text_es" rows="6" />
                        <flux:textarea label="English" wire:model="main_text_en" rows="6" />
                    </div>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center border-b pb-2">
                            <flux:heading size="md" class="text-forest-700">Texto Secundario</flux:heading>
                            <flux:button size="sm" variant="ghost" icon="language" wire:click="translateIntroContent"
                                wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="translateIntroContent">Traducir</span>
                                <flux:icon.loading wire:loading wire:target="translateIntroContent"
                                    class="w-4 h-4 animate-spin" />
                                <span wire:loading wire:target="translateIntroContent">Traduciendo...</span>
                            </flux:button>
                        </div>
                        <flux:textarea label="Español" wire:model="secondary_text_es" rows="6" />
                        <flux:textarea label="English" wire:model="secondary_text_en" rows="6" />
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <flux:button variant="ghost" wire:click="cancelContentEdit">Cancelar</flux:button>
                    <flux:button type="submit" variant="primary">Guardar Cambios</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>