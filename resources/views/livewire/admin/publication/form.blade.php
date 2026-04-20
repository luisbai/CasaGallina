<div class="min-h-screen">
    <!-- Header with Navigation -->
    <flux:card class="bg-white border-b border-gray-200 sticky top-0 z-10">
        <div class="w-full">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <flux:button href="/admin/publicaciones" wire:navigate variant="ghost" icon="arrow-left">
                        Volver a Publicaciones
                    </flux:button>
                </div>

                <div class="flex items-center gap-3">
                    @if ($publicationId)
                        <flux:button type="button" variant="ghost" x-on:click="window.Swal.fire({
                                                                                                title: '¿Estás seguro?',
                                                                                                text: '¿Deseas eliminar esta publicación? Esta acción no se puede deshacer.',
                                                                                                icon: 'warning',
                                                                                                showCancelButton: true,
                                                                                                confirmButtonText: 'Si, eliminar',
                                                                                                cancelButtonText: 'Cancelar',
                                                                                                confirmButtonColor: '#d33',
                                                                                            }).then((result) => {
                                                                                                if (result.isConfirmed) {
                                                                                                    $wire.deletePublication()
                                                                                                }
                                                                                            })"
                            class="px-4 !text-red-500 hover:!text-red-600">
                            Eliminar Publicación
                        </flux:button>
                    @endif
                    <flux:button type="button" variant="ghost" href="/admin/publicaciones" wire:navigate class="px-4">
                        Cancelar
                    </flux:button>
                    <flux:button wire:click="save" wire:loading.attr="disabled" variant="primary" icon="check"
                        class="px-6 !bg-forest-600 hover:!bg-forest-700">
                        <span wire:loading.remove wire:target="save">
                            {{ $publicationId ? 'Actualizar' : 'Crear' }} Publicación
                        </span>
                        <span wire:loading wire:target="save" class="flex items-center gap-2">
                            <flux:icon.loading class="w-4 h-4 animate-spin" />
                            Guardando...
                        </span>
                    </flux:button>
                </div>
            </div>
        </div>
    </flux:card>

    <!-- Main Content -->
    <div class="w-full py-8">
        <form class="space-y-8">
            <!-- Basic Information Section -->
            <flux:card class="!p-8 !bg-white border border-gray-200 shadow-sm">
                <div class="mb-8">
                    <flux:heading size="lg" class="!text-forest-700 flex items-center gap-3 mb-2">
                        Información General
                    </flux:heading>
                    <flux:subheading class="!text-gray-600 mt-2">
                        Configura los datos básicos de la publicación
                    </flux:subheading>
                </div>

                <div class="grid grid-cols-1 xl:grid-cols-4 gap-8">
                    <div class="lg:col-span-2 space-y-8">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <flux:select label="Status" wire:model="status" placeholder="Seleccionar Status">
                                <flux:select.option value="public">Pública</flux:select.option>
                                <flux:select.option value="private">Acceso sólo con link</flux:select.option>
                            </flux:select>

                            <flux:select label="Tipo" wire:model="type" placeholder="Seleccionar Tipo">
                                <flux:select.option value="impreso">Impreso</flux:select.option>
                                <flux:select.option value="digital">Digital</flux:select.option>
                            </flux:select>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <flux:input label="Número de Páginas" wire:model="pages_count" placeholder="Ej: 54" />

                            <flux:select label="Previsualización" wire:model="preview" placeholder="Seleccionar opción">
                                <flux:select.option value="1">Activada</flux:select.option>
                                <flux:select.option value="0">Desactivada</flux:select.option>
                            </flux:select>
                        </div>

                        <!-- Exposición Relationship -->
                        <div class="space-y-4">
                            <flux:label class="!font-semibold !text-gray-800 !text-base">Exposición Asociada (Opcional)
                            </flux:label>
                            <flux:subheading size="sm" class="!text-gray-600">
                                Asocia esta publicación con una exposición o proyecto artístico específico
                            </flux:subheading>
                            <div class="relative">
                                <flux:input wire:model.live.debounce.300ms="exhibitionSearch"
                                    wire:keyup="searchExhibitions"
                                    placeholder="Buscar exposición o proyecto artístico..." icon="magnifying-glass" />

                                @if($showExhibitionResults && !empty($exhibitionSearchResults))
                                    <div
                                        class="absolute z-10 w-full bg-white border border-gray-300 rounded-lg shadow-xl max-h-60 overflow-y-auto mt-1">
                                        @foreach($exhibitionSearchResults as $result)
                                            <div wire:mousedown="selectExhibition({{ $result['id'] }}, '{{ addslashes($result['title'] ?? $result['titulo']) }}')"
                                                class="p-4 hover:bg-forest-50 cursor-pointer border-b border-gray-100 last:border-0 transition-colors">
                                                <div class="font-medium text-gray-900 mb-1">
                                                    {{ $result['title'] ?? $result['titulo'] }}
                                                </div>
                                                <div class="text-sm text-gray-500 flex items-center gap-2">
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-forest-100 text-forest-700 font-medium">
                                                        {{ ucfirst($result['type']) }}
                                                    </span>
                                                    <span>{{ $result['date'] }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                @if($exhibition_id)
                                    <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-3">
                                                <flux:icon name="check-circle" class="w-5 h-5 text-green-600" />
                                                <div>
                                                    <div class="text-sm font-medium text-green-800">Exposición seleccionada
                                                    </div>
                                                    <div class="text-sm text-green-700">{{ $exhibitionSearch }}</div>
                                                </div>
                                            </div>
                                            <flux:button type="button" wire:click="clearExhibition" variant="ghost"
                                                icon="x-mark" size="xs" class="text-green-600 hover:text-green-800">
                                            </flux:button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-2">
                        <div class="bg-gray-50 border border-gray-200 rounded-xl p-6">
                            <div class="flex items-center gap-3 mb-6">
                                <flux:icon name="document" class="w-6 h-6 text-forest-600" />
                                <div>
                                    <flux:subheading size="md" class="!font-semibold !text-gray-800">Archivos
                                    </flux:subheading>
                                    <div class="text-sm text-gray-600">PDF y thumbnail</div>
                                </div>
                            </div>
                            <div class="space-y-6">
                                <div class="space-y-2">
                                    <flux:label>Publicación (PDF/DOC)</flux:label>
                                    @if ($currentMultimedia)
                                        <div class="relative group inline-block">
                                            <div
                                                class="flex items-center gap-2 p-2 bg-white border border-gray-200 rounded-lg pr-8">
                                                <flux:icon name="document-text" class="w-5 h-5 text-gray-400" />
                                                <span
                                                    class="text-sm text-gray-600">{{ $currentMultimedia->filename }}</span>
                                            </div>
                                            <button type="button" x-on:click="window.Swal.fire({
                                                                                                                    title: '¿Estás seguro?',
                                                                                                                    text: '¿Deseas eliminar este archivo?',
                                                                                                                    icon: 'warning',
                                                                                                                    showCancelButton: true,
                                                                                                                    confirmButtonText: 'Si, eliminar',
                                                                                                                    cancelButtonText: 'Cancelar',
                                                                                                                    confirmButtonColor: '#d33',
                                                                                                                }).then((result) => {
                                                                                                                    if (result.isConfirmed) {
                                                                                                                        $wire.removeMultimedia()
                                                                                                                    }
                                                                                                                })"
                                                class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-1 shadow-sm opacity-0 group-hover:opacity-100 transition-opacity">
                                                <flux:icon name="x-mark" class="w-3 h-3" />
                                            </button>
                                        </div>
                                    @endif
                                    <flux:input type="file" wire:model="publication_multimedia"
                                        accept=".pdf,.doc,.docx" />
                                    @error('publication_multimedia')
                                        <div class="text-red-500 text-sm font-medium mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <flux:label>Thumbnail</flux:label>
                                    @if ($currentThumbnail)
                                        <div class="relative group inline-block">
                                            <img src="/storage/{{ $currentThumbnail->filename }}"
                                                class="w-32 h-32 object-cover rounded-lg border border-gray-200 shadow-sm" />
                                            <button type="button" x-on:click="window.Swal.fire({
                                                                                                                    title: '¿Estás seguro?',
                                                                                                                    text: '¿Deseas eliminar este thumbnail?',
                                                                                                                    icon: 'warning',
                                                                                                                    showCancelButton: true,
                                                                                                                    confirmButtonText: 'Si, eliminar',
                                                                                                                    cancelButtonText: 'Cancelar',
                                                                                                                    confirmButtonColor: '#d33',
                                                                                                                }).then((result) => {
                                                                                                                    if (result.isConfirmed) {
                                                                                                                        $wire.removeThumbnail()
                                                                                                                    }
                                                                                                                })"
                                                class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-1 shadow-sm opacity-0 group-hover:opacity-100 transition-opacity">
                                                <flux:icon name="x-mark" class="w-3 h-3" />
                                            </button>
                                        </div>
                                    @endif
                                    <flux:input type="file" wire:model="publication_thumbnail" accept="image/*" />
                                    @error('publication_thumbnail')
                                        <div class="text-red-500 text-sm font-medium mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </flux:card>

            <!-- Content Fields - Spanish and English -->
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
                <!-- Spanish Column -->
                <flux:card class="!p-8 !bg-white border border-gray-200">
                    <div class="mb-8">
                        <flux:heading size="lg" class="!text-forest-700 flex items-center gap-3 mb-2">
                            Contenido en Español
                        </flux:heading>
                        <flux:subheading class="!text-gray-700 mt-2">
                            Información de la publicación en español
                        </flux:subheading>
                    </div>

                    <div class="space-y-6">
                        <flux:editor toolbar="italic bold" label="Título" wire:model.blur="title"
                            placeholder="Título de la publicación" class="h-32" />

                        <flux:date-picker label="Fecha Publicación" wire:model="publication_date"
                            placeholder="Selecciona una fecha" />

                        <flux:textarea label="Detalles de la Publicación" wire:model="editorial_coordination"
                            placeholder="Coordinación Editorial" rows="4" />



                        <flux:editor label="Sinopsis" wire:model.blur="synopsis"
                            placeholder="Sinopsis de la publicación" />

                        <flux:editor label="Contenido Adicional" wire:model.blur="additional_content"
                            placeholder="Contenido adicional de la publicación"
                            toolbar="heading | bold italic underline | bullet ordered" />
                    </div>

                    {{-- Optional Fields Accordion for Spanish - Hidden after migration --}}
                    {{--
                    <flux:accordion class="mt-8">
                        <flux:accordion.item heading="Campos Opcionales (1-7)">
                            <div class="space-y-6 pt-4">
                                @for($i = 1; $i <= 7; $i++) <div
                                    class="p-5 bg-white/80 rounded-lg border border-blue-200/60">
                                    <div class="space-y-4">
                                        <flux:input wire:model="campo_opcional_{{ $i }}_titulo"
                                            placeholder="Campo Opcional {{ $i }} - Título" />
                                        <flux:textarea wire:model="campo_opcional_{{ $i }}"
                                            placeholder="Campo Opcional {{ $i }} - Contenido" rows="3" />
                                    </div>
                            </div>
                            @endfor
            </div>
            </flux:accordion.item>
            </flux:accordion>
            --}}
            </flux:card>

            <!-- English Column -->
            <flux:card class="!p-8 !bg-white border border-gray-200">
                <div class="mb-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <flux:heading size="lg" class="!text-forest-700 flex items-center gap-3 mb-2">
                                English Content
                            </flux:heading>
                            <flux:subheading class="!text-gray-700 mt-2">
                                Publication information in English
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

                    @if($translationError)
                        <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded shadow-sm">
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
                </div>


                <div class="space-y-6">
                    <div>
                        <flux:label>Title (EN)</flux:label>
                        <flux:editor toolbar="italic bold" wire:model.blur="title_en"
                            placeholder="Publication title (EN)" class="h-32" />
                    </div>

                    <div>
                        <flux:label>Publication Date (EN)</flux:label>
                        <flux:date-picker wire:model="publication_date_en" placeholder="Select a date" />
                    </div>

                    <div>
                        <flux:label>Publication Details (EN)</flux:label>
                        <flux:textarea wire:model="editorial_coordination_en" placeholder="Editorial Coordination (EN)"
                            rows="4" />
                    </div>



                    <div>
                        <flux:label>Synopsis (EN)</flux:label>
                        <flux:editor wire:model.blur="synopsis_en" placeholder="Publication synopsis (EN)" />
                    </div>
                </div>

                <div>
                    <flux:label>Additional Content</flux:label>
                    <flux:editor wire:model.blur="additional_content_en"
                        placeholder="Additional publication content (EN)"
                        toolbar="heading | bold italic underline | bullet ordered" />
                </div>
    </div>

    {{-- Optional Fields Accordion for English - Hidden after migration --}}
    {{--
    <flux:accordion class="mt-8">
        <flux:accordion.item heading="Optional Fields (1-7)">
            <div class="space-y-6 pt-4">
                @for($i = 1; $i <= 7; $i++) <div class="p-5 bg-white/80 rounded-lg border border-green-200/60">
                    <div class="space-y-4">
                        <flux:input wire:model="campo_opcional_{{ $i }}_en_titulo"
                            placeholder="Optional Field {{ $i }} - Title (EN)" />
                        <flux:textarea wire:model="campo_opcional_{{ $i }}_en"
                            placeholder="Optional Field {{ $i }} - Content (EN)" rows="3" />
                    </div>
            </div>
            @endfor
</div>
</flux:accordion.item>
</flux:accordion>
--}}
</flux:card>
</div>
</form>
</div>
</div>