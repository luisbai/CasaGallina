<div>
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <flux:heading size="xl" class="!text-forest-800 font-serif">
                {{ $id ? 'Editar' : 'Crear' }} Exposición/Proyecto
            </flux:heading>
            @if($id)
                <flux:subheading class="mt-1">
                    {{ strip_tags($titulo) }}
                </flux:subheading>
            @endif
        </div>

        <a href="{{ route('admin.exhibitions.index') }}">
            <flux:button variant="ghost" icon="arrow-left" size="sm">
                Volver al listado
            </flux:button>
        </a>
    </div>

    <form wire:submit="save">
        <div class="space-y-6">
            @if($translationError)
                <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded shadow-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <flux:icon name="exclamation-circle" class="h-5 w-5 text-red-400" />
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
                                    <flux:icon name="x-mark" class="h-4 w-4" />
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- General Information (Top Section) -->
            <flux:card>
                <div class="mb-4">
                    <flux:heading size="lg" class="!text-forest-700 mb-2">
                        Información General
                    </flux:heading>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <flux:radio.group wire:model="estado" label="Estado">
                        <flux:radio value="public" label="Publicada" />
                        <flux:radio value="private" label="Privada" />
                    </flux:radio.group>

                    <flux:radio.group wire:model="type" label="Tipo">
                        <flux:radio value="exposicion" label="Exposición"
                            description="Exhibiciones de arte y muestras culturales" />
                        <flux:radio value="proyecto-artistico" label="Proyecto Artístico"
                            description="Proyectos creativos comunitarios" />
                    </flux:radio.group>

                    <div class="space-y-2">
                        <flux:date-picker wire:model="fecha" label="Fecha"
                            placeholder="Selecciona una fecha o escribe texto libre" />
                        <flux:subheading size="sm" class="text-gray-500 !text-xs">
                            Selecciona una fecha o escribe texto (2024, verano 2024)
                        </flux:subheading>
                    </div>
                </div>
            </flux:card>

            <!-- Bilingual Content (2 Column Grid) -->
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                <!-- Left Column: Spanish Content -->
                <flux:card>
                    <div class="mb-6">
                        <flux:heading size="lg" class="!text-forest-700 mb-2">
                            Contenido en Español
                        </flux:heading>
                        <flux:subheading class="!text-gray-700">
                            Información principal en español
                        </flux:subheading>
                    </div>

                    <div class="space-y-6">
                        <div class="space-y-2">
                            <flux:label>Título</flux:label>
                            <flux:editor toolbar="italic bold" wire:model.blur="titulo" placeholder="Título en Español"
                                class="h-20" />
                        </div>

                        <div class="space-y-2">
                            <flux:label>Ficha/Metadatos</flux:label>
                            <flux:editor wire:model.blur="metadatos" placeholder="Ficha técnica o metadatos"
                                class="h-[200px] overflow-y-auto" />
                        </div>

                        <div class="space-y-2">
                            <flux:label>Contenido Principal</flux:label>
                            <flux:editor wire:model.blur="contenido" placeholder="Desarrollo del contenido"
                                class="h-[300px] overflow-y-auto" />
                        </div>
                    </div>
                </flux:card>

                <!-- Right Column: English Content -->
                <flux:card>
                    <div class="mb-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <flux:heading size="lg" class="!text-forest-700 mb-2">
                                    English Content
                                </flux:heading>
                                <flux:subheading class="!text-gray-700">
                                    Translations for international visitors
                                </flux:subheading>
                            </div>
                            <flux:button type="button" wire:click="translateAllFields" wire:target="translateAllFields"
                                wire:loading.attr="disabled" size="sm" variant="ghost" icon="language"
                                class="!text-purple-600 hover:!text-purple-700">
                                <span wire:loading.remove wire:target="translateAllFields">Traducir Todo</span>
                                <span wire:loading wire:target="translateAllFields" class="flex items-center gap-2">
                                    <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Traduciendo...
                                </span>
                            </flux:button>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="space-y-2">
                            <flux:label>Title (EN)</flux:label>
                            <flux:editor toolbar="italic bold" wire:model.blur="titulo_en"
                                placeholder="Title in English" class="h-20" />
                        </div>

                        <div class="space-y-2">
                            <flux:label>Metadata (EN)</flux:label>
                            <flux:editor wire:model.blur="metadatos_en" placeholder="Metadata in English"
                                class="h-[200px] overflow-y-auto" />
                        </div>

                        <div class="space-y-2">
                            <flux:label>Content (EN)</flux:label>
                            <flux:editor wire:model.blur="contenido_en" placeholder="Content in English"
                                class="h-[300px] overflow-y-auto" />
                        </div>
                    </div>
                </flux:card>
            </div>

            <!-- Media Management (Bottom Section) -->
            <flux:accordion>
                <flux:accordion.item heading="Videos de YouTube">
                    <flux:card class="grid grid-cols-1 gap-2 p-2 bg-gray-50 mb-4 border border-gray-200">
                        <flux:input size="sm" type="text" wire:model="newVideoTitle" placeholder="Título del video" />
                        <flux:input size="sm" type="text" wire:model="newVideoDescription"
                            placeholder="Descripción (opcional)" />
                        <div class="flex gap-2">
                            <flux:input size="sm" type="url" wire:model="newVideoUrl" placeholder="URL de YouTube"
                                class="flex-1" />
                            <flux:button size="sm" type="button" wire:click="addVideo" variant="primary">Agregar
                            </flux:button>
                        </div>
                    </flux:card>

                    @if(!empty($videos))
                        <div class="space-y-2">
                            @foreach($videos as $index => $video)
                                <div class="flex items-center gap-2 p-2 bg-white border border-gray-200 rounded shadow-sm">
                                    <div class="flex-1">
                                        <div class="text-sm font-medium">{{ $video['titulo'] }}</div>
                                        @if($video['descripcion'])
                                            <div class="text-xs text-gray-600">{{ $video['descripcion'] }}</div>
                                        @endif
                                    </div>
                                    <flux:button type="button" wire:click="removeVideo({{ $index }})" size="xs" variant="danger"
                                        icon="trash">
                                    </flux:button>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </flux:accordion.item>

                <flux:accordion.item heading="Galería de Imágenes">
                    <div class="space-y-4">
                        @if($this->existingMultimedia->count() > 0)
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Imágenes Actuales</label>
                                <div class="grid grid-cols-3 gap-2">
                                    @foreach($this->existingMultimedia as $multimedia)
                                        <div class="relative group" wire:key="media-{{ $multimedia->id }}">
                                            <img src="{{ Storage::url($multimedia->multimedia->filename) }}" alt="Imagen"
                                                class="w-full h-20 object-cover rounded border border-gray-200">
                                            <flux:button size="xs" variant="danger" icon="x-mark"
                                                x-on:click="if (! confirm('¿Estás seguro que deseas eliminar esta imagen?')) { event.preventDefault(); event.stopImmediatePropagation(); }"
                                                wire:click="removeMultimedia({{ $multimedia->multimedia->id }})"
                                                class="absolute -top-2 -right-2 rounded-full shadow-sm opacity-0 group-hover:opacity-100 transition-opacity duration-200" />
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <flux:input type="file" wire:model="multimedia" label="Agregar Nuevas Imágenes" multiple />
                    </div>
                </flux:accordion.item>

                <flux:accordion.item heading="Archivos Descargables">
                    <div class="mb-4">
                        <flux:button size="xs" type="button" wire:click="addFile" variant="primary" icon="plus">
                            Agregar Archivo
                        </flux:button>
                    </div>

                    @if(!empty($files))
                        <div class="space-y-3">
                            @foreach($files as $index => $file)
                                <div class="p-3 bg-white rounded border shadow-sm">
                                    <div class="flex justify-between items-start gap-2">
                                        <div class="flex-1 space-y-2">
                                            <flux:input size="sm" type="text" wire:model="files.{{ $index }}.titulo"
                                                placeholder="Título" />
                                            <flux:input size="sm" type="text" wire:model="files.{{ $index }}.descripcion"
                                                placeholder="Descripción" />

                                            @if(isset($file['stored_filename']) && $file['stored_filename'])
                                                <div
                                                    class="flex items-center gap-2 text-xs text-forest-600 bg-forest-50 p-2 rounded border border-forest-100">
                                                    <flux:icon name="document" variant="micro" />
                                                    <span class="truncate max-w-[200px]"
                                                        title="{{ $file['filename'] }}">{{ $file['filename'] }}</span>
                                                    <a href="{{ Storage::url($file['stored_filename']) }}" target="_blank"
                                                        class="text-forest-800 hover:underline font-medium ml-auto">Ver archivo</a>
                                                </div>
                                            @endif

                                            @if(!isset($file['id']) || !$file['id'])
                                                <flux:input size="sm" type="file" wire:model="files.{{ $index }}.file"
                                                    label="Archivo" />
                                            @else
                                                <flux:subheading size="sm" class="!text-xs">Para reemplazar el archivo, elimina este
                                                    elemento y agrega uno nuevo.</flux:subheading>
                                            @endif

                                            <!-- Thumbnail for files -->
                                            <div class="pt-2">
                                                <flux:label>Thumbnail (Opcional)</flux:label>
                                                @if(isset($file['thumbnail']) && $file['thumbnail'] && is_string($file['thumbnail']))
                                                    <div class="mb-2 mt-1">
                                                        <img src="{{ Storage::url($file['thumbnail']) }}" alt="Thumbnail"
                                                            class="h-16 w-16 object-cover rounded border border-gray-200">
                                                    </div>
                                                @endif
                                                <flux:input size="sm" type="file" wire:model="files.{{ $index }}.thumbnail"
                                                    accept="image/*" />
                                            </div>
                                        </div>
                                        <flux:button type="button" wire:click="removeFile({{ $index }})" size="xs"
                                            variant="danger" icon="trash">
                                        </flux:button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </flux:accordion.item>
            </flux:accordion>
        </div>

        <div class="flex justify-end gap-4 mt-8 pt-4 border-t border-gray-200">
            <a href="{{ route('admin.exhibitions.index') }}">
                <flux:button type="button" variant="ghost">Cancelar</flux:button>
            </a>
            <flux:button type="submit" variant="primary">Guardar</flux:button>
        </div>
    </form>
</div>