<?php

namespace App\Livewire\Admin\Noticia;

use App\Modules\News\Infrastructure\Models\Noticia;
use App\Modules\News\Infrastructure\Models\NoticiaArchivo;
use App\Modules\News\Infrastructure\Models\NoticiaVideo;
use App\Modules\Tag\Infrastructure\Models\Tag;
use App\Modules\Shared\Application\Services\ImageService;
use App\Modules\Shared\Application\Services\GeminiTranslationService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Computed;
use Flux\Flux;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Page extends Component
{
    use WithPagination, WithFileUploads;

    public string $sortBy = 'fecha_publicacion';
    public string $sortDirection = 'desc';
    public int $perPage = 10;
    public string $search = '';
    public string $searchTag = '';

    // Form fields - Spanish
    public string $titulo = '';
    public string $contenido = '';
    public string $descripcion = '';

    // Form fields - English
    public string $titulo_en = '';
    public string $contenido_en = '';
    public string $descripcion_en = '';

    // Other form fields
    public string $autor = '';
    public string $fecha_publicacion = '';
    public string $activo = 'activa';
    public bool $enable_donations = false;
    public string $donation_content = '';
    public string $donation_content_en = '';
    public $donation_image = null;
    public ?int $donation_multimedia_id = null;
    public $content_image = null;
    public ?int $content_image_id = null;
    public array $multimedia = [];
    public array $selectedTags = [];
    public ?int $exposicion_id = null;
    public ?int $editId = null;
    public ?string $translationError = null;

    // Single video field
    public string $video_url = '';

    // File management
    public array $archivos = [];
    public array $editingArchivos = [];

    // Tag management fields - Spanish
    public string $tagNombre = '';
    public string $tagDescripcion = '';

    // Tag management fields - English
    public string $tagNombre_en = '';
    public string $tagDescripcion_en = '';

    public ?int $editTagId = null;

    protected array $queryString = [
        'search' => ['except' => ''],
        'searchTag' => ['except' => ''],
        'sortBy' => ['except' => 'fecha_publicacion'],
        'sortDirection' => ['except' => 'desc']
    ];


    public function mount()
    {
        $this->fecha_publicacion = now()->format('Y-m-d');
    }

    public function getListeners()
    {
        return [
            'exposicion-selected' => 'handleExposicionSelected',
        ];
    }

    public function handleExposicionSelected($id, $title)
    {
        $this->exposicion_id = $id;
    }

    /**
     * Clean HTML content that may have been escaped by the editor
     * Detects and fixes double-escaped HTML entities
     */
    private function cleanHtmlContent(string $content): string
    {
        // Check if content has escaped HTML entities
        if (strpos($content, '&lt;') !== false || strpos($content, '&gt;') !== false) {
            // Decode HTML entities
            $content = html_entity_decode($content, ENT_QUOTES | ENT_HTML5, 'UTF-8');

            // If it's a full HTML document, extract only the body content
            if (preg_match('/<body[^>]*>(.*?)<\/body>/is', $content, $matches)) {
                $content = $matches[1];
            }

            // Remove unnecessary wrapper paragraphs that the editor might add
            $content = preg_replace('/<p>\s*<\/p>/i', '', $content);

            // Clean up any remaining DOCTYPE, html, head tags
            $content = preg_replace('/<!DOCTYPE[^>]*>/i', '', $content);
            $content = preg_replace('/<\/?html[^>]*>/i', '', $content);
            $content = preg_replace('/<head[^>]*>.*?<\/head>/is', '', $content);

            // Trim whitespace
            $content = trim($content);
        }

        return $content;
    }

    // Archivo management methods
    public function addArchivo()
    {
        $this->archivos[] = [
            'titulo' => '',
            'descripcion' => '',
            'file' => null,
            'thumbnail' => null,
        ];
    }

    public function removeArchivo($index)
    {
        unset($this->archivos[$index]);
        $this->archivos = array_values($this->archivos);

        // Remove from editing state
        if (isset($this->editingArchivos[$index])) {
            unset($this->editingArchivos[$index]);
        }
    }

    public function toggleEditArchivo($index)
    {
        if (isset($this->editingArchivos[$index])) {
            unset($this->editingArchivos[$index]);
        } else {
            $this->editingArchivos[$index] = true;
        }
    }

    public function isEditingArchivo($index)
    {
        return isset($this->editingArchivos[$index]);
    }

    public function removeExistingArchivo($archivoId)
    {
        $archivo = NoticiaArchivo::find($archivoId);
        if ($archivo) {
            // Delete files from storage
            if ($archivo->stored_filename) {
                Storage::disk('public')->delete($archivo->stored_filename);
            }
            if ($archivo->thumbnail) {
                Storage::disk('public')->delete($archivo->thumbnail);
            }
            $archivo->delete();
        }

        // Remove from archivos array
        $this->archivos = array_filter($this->archivos, function ($archivo) use ($archivoId) {
            return !isset($archivo['id']) || $archivo['id'] != $archivoId;
        });
        $this->archivos = array_values($this->archivos);
    }

    public function sort(string $column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    #[Computed]
    public function noticias(): LengthAwarePaginator
    {
        return Noticia::query()
            ->when($this->search, function ($query, $search) {
                return $query->where('titulo', 'like', "%$search%")
                    ->orWhere('contenido', 'like', "%$search%")
                    ->orWhere('autor', 'like', "%$search%");
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage, pageName: 'noticiasPage');
    }

    #[Computed]
    public function availableTags()
    {
        return Tag::where('type', 'noticia')->orderBy('nombre')->get();
    }

    #[Computed]
    public function categorias()
    {
        return Tag::query()
            ->where('type', 'noticia')
            ->when($this->searchTag, function ($query, $search) {
                return $query->where('nombre', 'like', "%{$search}%");
            })
            ->orderBy('nombre', 'asc')
            ->paginate($this->perPage, pageName: 'categoriasPage');
    }

    #[Computed]
    public function currentNoticia()
    {
        if ($this->editId) {
            return Noticia::with(['multimedia', 'contentImage', 'donationMultimedia'])->find($this->editId);
        }
        return null;
    }

    public function translateFields(GeminiTranslationService $translator): void
    {
        $fieldsToTranslate = [];

        if ($this->titulo && empty($this->titulo_en)) {
            $fieldsToTranslate['titulo'] = $this->titulo;
        }
        if ($this->contenido && empty($this->contenido_en)) {
            $fieldsToTranslate['contenido'] = $this->contenido;
        }
        if ($this->descripcion && empty($this->descripcion_en)) {
            $fieldsToTranslate['descripcion'] = $this->descripcion;
        }

        if (empty($fieldsToTranslate)) {
            Flux::toast('No hay campos en español para traducir', variant: 'warning');
            return;
        }

        $this->translationError = null;

        try {
            $translated = $translator->translateBatch($fieldsToTranslate);

            if (!empty($translated)) {
                if (isset($translated['titulo']))
                    $this->titulo_en = $translated['titulo'];
                if (isset($translated['contenido']))
                    $this->contenido_en = $translated['contenido'];
                if (isset($translated['descripcion']))
                    $this->descripcion_en = $translated['descripcion'];

                $count = count($fieldsToTranslate);
                Flux::toast(
                    heading: 'Traducción completada',
                    text: "Se tradujeron {$count} campos correctamente",
                    variant: 'success'
                );
            } else {
                $this->translationError = 'El servicio de traducción no devolvió resultados.';
                Flux::toast(
                    heading: 'Servicio de traducción',
                    text: 'El servicio no devolvió resultados.',
                    variant: 'warning'
                );
            }
        } catch (\Exception $e) {
            \Log::error('Translation Error Catch:', ['message' => $e->getMessage()]);
            $this->translationError = 'Error de traducción: ' . $e->getMessage();
            Flux::toast(
                heading: 'Error de traducción',
                text: $e->getMessage(),
                variant: 'danger'
            );
        }
    }

    public function delete($id): void
    {
        $service = app(\App\Modules\News\Application\Services\NoticiaService::class);
        $noticia = $service->find($id);

        if ($noticia) {
            $titulo = strip_tags($noticia->titulo);
            $service->delete($id);

            Flux::toast("La noticia '$titulo' ha sido eliminada.");
        }
    }

    public function openCreateModal(): void
    {
        $this->resetForm();
        $this->translationError = null;
        Flux::modal('createNoticia')->show();
    }

    public function cancelEdit(): void
    {
        $this->resetForm();
        Flux::modal('editNoticia')->close();
    }

    public function resetForm(): void
    {
        $this->reset([
            'titulo',
            'titulo_en',
            'contenido',
            'contenido_en',
            'descripcion',
            'descripcion_en',
            'autor',
            'fecha_publicacion',
            'activo',
            'enable_donations',
            'donation_content',
            'donation_content_en',
            'donation_image',
            'donation_multimedia_id',
            'content_image',
            'content_image_id',
            'multimedia',
            'video_url',
            'selectedTags',
            'exposicion_id',
            'editId',
            'archivos',
            'editingArchivos'
        ]);
        $this->activo = 'activa';
        $this->fecha_publicacion = now()->format('Y-m-d');
        Flux::modal('createNoticia')->close();
    }

    public function editNoticia($id): void
    {
        $this->translationError = null;
        $this->editId = $id;
        $service = app(\App\Modules\News\Application\Services\NoticiaService::class);
        $noticia = $service->find($id);

        if ($noticia) {
            $this->titulo = $noticia->getTranslation('titulo', 'es');
            $this->titulo_en = $noticia->getTranslation('titulo', 'en', false);
            $this->contenido = $noticia->getTranslation('contenido', 'es');
            $this->contenido_en = $noticia->getTranslation('contenido', 'en', false);
            $this->descripcion = $noticia->getTranslation('descripcion', 'es');
            $this->descripcion_en = $noticia->getTranslation('descripcion', 'en', false);

            $this->autor = $noticia->autor ?? '';
            $this->fecha_publicacion = $noticia->fecha_publicacion->format('Y-m-d');
            $this->activo = $noticia->activo ? 'activa' : 'borrador'; // Assuming 'activo' is boolean in DB but handled as string in form?
            // Page.php shows public string $activo = 'activa';
            // Wait, existing code: $this->activo = $noticia->activo ? 'activa' : 'borrador';

            $this->enable_donations = $noticia->enable_donations;
            $this->donation_content = $noticia->donation_content ?? '';
            $this->donation_content_en = $noticia->donation_content_en ?? '';
            $this->donation_multimedia_id = $noticia->donation_multimedia_id;
            $this->content_image_id = $noticia->content_image_id;

            // Only include tags that are of type 'noticia'
            $this->selectedTags = $noticia->tags()
                ->where('type', 'noticia')
                ->pluck('tags.id')
                ->toArray();
            $this->exposicion_id = $noticia->exposicion_id;

            // Load single video
            $video = $noticia->videos->first();
            if ($video) {
                $this->video_url = $video->youtube_url;
            }

            // Load archivos
            $this->archivos = $noticia->archivos->map(function ($archivo) {
                return [
                    'id' => $archivo->id,
                    'titulo' => $archivo->titulo,
                    'descripcion' => $archivo->descripcion,
                    'filename' => $archivo->filename,
                    'stored_filename' => $archivo->stored_filename,
                    'thumbnail' => $archivo->thumbnail,
                    'mime_type' => $archivo->mime_type,
                    'file_size' => $archivo->file_size,
                    'orden' => $archivo->orden,
                    'file' => null // For new uploads
                ];
            })->toArray();
        }

        Flux::modal('editNoticia')->show();
    }

    public function store(): void
    {
        $this->validate([
            'titulo' => 'required|min:3|max:255',
            'titulo_en' => 'nullable|min:3|max:255',
            'contenido' => 'required',
            'contenido_en' => 'nullable',
            'descripcion' => 'nullable|string|max:500',
            'descripcion_en' => 'nullable|string|max:500',
            'autor' => 'nullable|string|max:255',
            'fecha_publicacion' => 'required|date_format:Y-m-d',
            'exposicion_id' => 'nullable|exists:exposiciones,id',
            'multimedia.*' => 'nullable|image|max:10240',
            'archivos.*.file' => 'nullable|file|max:51200',
            'archivos.*.titulo' => 'nullable|string|max:255',
            'archivos.*.descripcion' => 'nullable|string|max:1000',
            'archivos.*.thumbnail' => 'nullable|image|max:2048',
        ]);

        // Clean HTML content before saving
        $cleanedContenido = $this->cleanHtmlContent($this->contenido);
        $cleanedContenidoEn = $this->contenido_en ? $this->cleanHtmlContent($this->contenido_en) : '';
        $cleanedDonationContent = $this->donation_content ? $this->cleanHtmlContent($this->donation_content) : '';
        $cleanedDonationContentEn = $this->donation_content_en ? $this->cleanHtmlContent($this->donation_content_en) : '';

        $data = [
            'titulo' => $this->titulo,
            'titulo_en' => $this->titulo_en,
            'contenido' => $cleanedContenido,
            'contenido_en' => $cleanedContenidoEn,
            'descripcion' => $this->descripcion,
            'descripcion_en' => $this->descripcion_en,
            'autor' => $this->autor,
            'fecha_publicacion' => $this->fecha_publicacion,
            'activo' => $this->activo === 'activa',
            'enable_donations' => $this->enable_donations,
            'donation_content' => $cleanedDonationContent,
            'donation_content_en' => $cleanedDonationContentEn,
            'exposicion_id' => $this->exposicion_id,
        ];

        $service = app(\App\Modules\News\Application\Services\NoticiaService::class);
        $noticia = $service->create($data);

        // Process donation image
        $this->processDonationImage();
        if ($this->donation_multimedia_id) {
            $noticia->update(['donation_multimedia_id' => $this->donation_multimedia_id]);
        }

        // Process content image
        $this->processContentImage();
        if ($this->content_image_id) {
            $noticia->update(['content_image_id' => $this->content_image_id]);
        }

        // Process multimedia
        if ($this->multimedia) {
            $imageService = new ImageService();

            foreach ($this->multimedia as $file) {
                $multimedia = $imageService->processAndStore($file, 'noticia');
                $noticia->multimedia()->attach($multimedia->id);
            }
        }

        // Handle single video
        if (!empty($this->video_url)) {
            $noticia->videos()->create([
                'titulo' => 'Video',
                'descripcion' => '',
                'youtube_url' => $this->video_url,
                'orden' => 0
            ]);
        }

        // Handle file uploads
        if (!empty($this->archivos)) {
            foreach ($this->archivos as $index => $archivo) {
                if (isset($archivo['file']) && $archivo['file']) {
                    $file = $archivo['file'];
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('noticia/archivos', $filename, 'public');

                    // Handle thumbnail upload
                    $thumbnailPath = null;
                    if (isset($archivo['thumbnail']) && $archivo['thumbnail']) {
                        $thumbnailFile = $archivo['thumbnail'];
                        $thumbnailFilename = time() . '_thumb_' . $thumbnailFile->getClientOriginalName();
                        $thumbnailPath = $thumbnailFile->storeAs('noticia/archivos/thumbnails', $thumbnailFilename, 'public');
                    }

                    $noticia->archivos()->create([
                        'titulo' => $archivo['titulo'] ?? $file->getClientOriginalName(),
                        'descripcion' => $archivo['descripcion'] ?? '',
                        'filename' => $file->getClientOriginalName(),
                        'stored_filename' => $path,
                        'thumbnail' => $thumbnailPath,
                        'mime_type' => $file->getMimeType(),
                        'file_size' => $file->getSize(),
                        'orden' => $index
                    ]);
                }
            }
        }

        // Attach tags
        if ($this->selectedTags) {
            $noticia->tags()->attach($this->selectedTags);
        }

        Flux::toast("La noticia ha sido creada.");
        Flux::modal('createNoticia')->close();
        $this->resetForm();
    }

    public function update(): void
    {
        $this->validate([
            'titulo' => 'required|min:3|max:255',
            'titulo_en' => 'nullable|min:3|max:255',
            'contenido' => 'required',
            'contenido_en' => 'nullable',
            'descripcion' => 'nullable|string|max:500',
            'descripcion_en' => 'nullable|string|max:500',
            'autor' => 'nullable|string|max:255',
            'fecha_publicacion' => 'required|date_format:Y-m-d',
            'exposicion_id' => 'nullable|exists:exposiciones,id',
            'multimedia.*' => 'nullable|image|max:10240',
            'archivos.*.file' => 'nullable|file|max:51200',
            'archivos.*.titulo' => 'nullable|string|max:255',
            'archivos.*.descripcion' => 'nullable|string|max:1000',
            'archivos.*.thumbnail' => 'nullable|image|max:2048',
        ]);

        // Clean HTML content before saving
        $cleanedContenido = $this->cleanHtmlContent($this->contenido);
        $cleanedContenidoEn = $this->contenido_en ? $this->cleanHtmlContent($this->contenido_en) : '';
        $cleanedDonationContent = $this->donation_content ? $this->cleanHtmlContent($this->donation_content) : '';
        $cleanedDonationContentEn = $this->donation_content_en ? $this->cleanHtmlContent($this->donation_content_en) : '';

        $data = [
            'titulo' => $this->titulo,
            'titulo_en' => $this->titulo_en,
            'contenido' => $cleanedContenido,
            'contenido_en' => $cleanedContenidoEn,
            'descripcion' => $this->descripcion,
            'descripcion_en' => $this->descripcion_en,
            'autor' => $this->autor,
            'fecha_publicacion' => $this->fecha_publicacion,
            'activo' => $this->activo === 'activa',
            'enable_donations' => $this->enable_donations,
            'donation_content' => $cleanedDonationContent,
            'donation_content_en' => $cleanedDonationContentEn,
            'exposicion_id' => $this->exposicion_id,
        ];

        $service = app(\App\Modules\News\Application\Services\NoticiaService::class);
        $success = $service->update($this->editId, $data);

        if ($success) {
            $noticia = $service->find($this->editId);

            // Process donation image
            $this->processDonationImage();
            if ($this->donation_multimedia_id) {
                $noticia->update(['donation_multimedia_id' => $this->donation_multimedia_id]);
            }

            // Process content image
            $this->processContentImage();
            if ($this->content_image_id) {
                $noticia->update(['content_image_id' => $this->content_image_id]);
            }

            // Process new multimedia
            if ($this->multimedia) {
                $imageService = new ImageService();

                foreach ($this->multimedia as $file) {
                    $multimedia = $imageService->processAndStore($file, 'noticia');
                    $noticia->multimedia()->attach($multimedia->id);
                }
            }

            // Update single video - first delete existing ones
            $noticia->videos()->delete();
            if (!empty($this->video_url)) {
                $noticia->videos()->create([
                    'titulo' => 'Video',
                    'descripcion' => '',
                    'youtube_url' => $this->video_url,
                    'orden' => 0
                ]);
            }

            // Handle downloadables updates
            if (!empty($this->archivos)) {
                foreach ($this->archivos as $index => $archivo) {
                    // If it's a new file upload
                    if (isset($archivo['file']) && $archivo['file']) {
                        $file = $archivo['file'];
                        $filename = time() . '_' . $file->getClientOriginalName();
                        $path = $file->storeAs('noticia/archivos', $filename, 'public');

                        // Handle thumbnail upload
                        $thumbnailPath = null;
                        if (isset($archivo['thumbnail']) && $archivo['thumbnail']) {
                            $thumbnailFile = $archivo['thumbnail'];
                            $thumbnailFilename = time() . '_thumb_' . $thumbnailFile->getClientOriginalName();
                            $thumbnailPath = $thumbnailFile->storeAs('noticia/archivos/thumbnails', $thumbnailFilename, 'public');
                        }

                        $noticia->archivos()->create([
                            'titulo' => $archivo['titulo'] ?? $file->getClientOriginalName(),
                            'descripcion' => $archivo['descripcion'] ?? '',
                            'filename' => $file->getClientOriginalName(),
                            'stored_filename' => $path,
                            'thumbnail' => $thumbnailPath,
                            'mime_type' => $file->getMimeType(),
                            'file_size' => $file->getSize(),
                            'orden' => $index
                        ]);
                    }
                    // If it's an existing file being updated (title/description/thumbnail)
                    elseif (isset($archivo['id']) && $archivo['id']) {
                        $existingArchivo = $noticia->archivos()->find($archivo['id']);
                        if ($existingArchivo) {
                            $updateData = [
                                'titulo' => $archivo['titulo'],
                                'descripcion' => $archivo['descripcion'],
                                'orden' => $index
                            ];

                            // Handle thumbnail update
                            if (isset($archivo['thumbnail']) && $archivo['thumbnail']) {
                                // Delete old thumbnail if it exists
                                if ($existingArchivo->thumbnail) {
                                    Storage::disk('public')->delete($existingArchivo->thumbnail);
                                }

                                $thumbnailFile = $archivo['thumbnail'];
                                $thumbnailFilename = time() . '_thumb_' . $thumbnailFile->getClientOriginalName();
                                $thumbnailPath = $thumbnailFile->storeAs('noticia/archivos/thumbnails', $thumbnailFilename, 'public');
                                $updateData['thumbnail'] = $thumbnailPath;
                            }

                            $existingArchivo->update($updateData);
                        }
                    }
                }
            }

            // Update tags
            $noticia->tags()->sync($this->selectedTags);

            Flux::toast("La noticia ha sido actualizada.");
            Flux::modal('editNoticia')->close();
            $this->resetForm();
        }
    }


    #[Computed]
    public function existingMultimedia()
    {
        if ($this->editId) {
            $noticia = Noticia::with('multimedia')->find($this->editId);
            return $noticia ? $noticia->multimedia : collect();
        }
        return collect();
    }

    public function processDonationImage()
    {
        if ($this->donation_image) {
            $imageService = new ImageService();
            $multimedia = $imageService->processAndStore($this->donation_image, 'noticia');
            $this->donation_multimedia_id = $multimedia->id;
        }
    }

    public function removeDonationImage()
    {
        if ($this->donation_multimedia_id) {
            $multimedia = \App\Modules\Multimedia\Infrastructure\Models\Multimedia::find($this->donation_multimedia_id);
            if ($multimedia) {
                Storage::disk('public')->delete($multimedia->filename);
                $multimedia->delete();
            }
            $this->donation_multimedia_id = null;
        }
        $this->donation_image = null;
    }

    public function processContentImage()
    {
        if ($this->content_image) {
            $imageService = new ImageService();
            $multimedia = $imageService->processAndStore($this->content_image, 'noticia');
            $this->content_image_id = $multimedia->id;
        }
    }

    public function removeContentImage()
    {
        if ($this->content_image_id) {
            $multimedia = \App\Modules\Multimedia\Infrastructure\Models\Multimedia::find($this->content_image_id);
            if ($multimedia) {
                Storage::disk('public')->delete($multimedia->filename);
                $multimedia->delete();
            }
            $this->content_image_id = null;
        }
        $this->content_image = null;
    }

    public function removeImage(int $multimediaId): void
    {
        if ($this->editId) {
            $noticia = Noticia::find($this->editId);

            if ($noticia) {
                // Find the multimedia relationship
                $multimedia = $noticia->multimedia()->where('multimedia_id', $multimediaId)->first();

                if ($multimedia) {
                    $filename = $multimedia->filename;

                    // Detach from noticia
                    $noticia->multimedia()->detach($multimediaId);

                    // Delete the actual file from storage
                    if ($filename) {
                        Storage::disk('public')->delete($filename);
                    }

                    // Delete the multimedia record
                    $multimedia->delete();

                    Flux::toast("Imagen eliminada correctamente.");
                }
            }
        }
    }


    // Tag management methods
    public function openCreateCategoriaModal(): void
    {
        $this->reset([
            'tagNombre',
            'tagNombre_en',
            'tagDescripcion',
            'tagDescripcion_en',
            'editTagId'
        ]);

        Flux::modal('createCategoria')->show();
    }

    public function resetCategoriaForm(): void
    {
        $this->reset([
            'tagNombre',
            'tagNombre_en',
            'tagDescripcion',
            'tagDescripcion_en',
            'editTagId'
        ]);
        Flux::modal('createCategoria')->close();
    }

    public function cancelCategoriaEdit(): void
    {
        $this->reset([
            'tagNombre',
            'tagNombre_en',
            'tagDescripcion',
            'tagDescripcion_en',
            'editTagId'
        ]);
        Flux::modal('editCategoria')->close();
    }

    public function editCategoria($id): void
    {
        $this->editTagId = $id;
        $categoria = Tag::find($id);

        if ($categoria) {
            $this->tagNombre = $categoria->nombre;
            $this->tagNombre_en = $categoria->nombre_en ?? '';
            $this->tagDescripcion = $categoria->descripcion ?? '';
            $this->tagDescripcion_en = $categoria->descripcion_en ?? '';
        }

        Flux::modal('editCategoria')->show();
    }

    public function storeCategoria(): void
    {
        $this->validate([
            'tagNombre' => 'required|min:3|max:255',
            'tagNombre_en' => 'nullable|min:3|max:255',
            'tagDescripcion' => 'nullable|string|max:1000',
            'tagDescripcion_en' => 'nullable|string|max:1000',
        ]);

        $slug = Str::slug($this->tagNombre);

        // Check if tag with this slug already exists (optionally scoped by type if needed, but unique constraint is likely global or composite)
        // Based on user error: Duplicate entry 'categoria-ejemplo' for key 'tags.tags_slug_unique' -> likely unique on slug column.
        $exists = Tag::where('slug', $slug)->exists();

        if ($exists) {
            $this->addError('tagNombre', 'Esta categoría ya existe.');
            return;
        }

        $categoria = Tag::create([
            'nombre' => $this->tagNombre,
            'nombre_en' => $this->tagNombre_en,
            'slug' => $slug,
            'slug_en' => $this->tagNombre_en ? Str::slug($this->tagNombre_en) : null,
            'descripcion' => $this->tagDescripcion,
            'descripcion_en' => $this->tagDescripcion_en,
            'type' => 'noticia',
        ]);

        Flux::toast("La categoría '{$this->tagNombre}' ha sido creada.");
        $this->resetCategoriaForm();
    }

    public function updateCategoria(): void
    {
        $this->validate([
            'tagNombre' => 'required|min:3|max:255',
            'tagNombre_en' => 'nullable|min:3|max:255',
            'tagDescripcion' => 'nullable|string|max:1000',
            'tagDescripcion_en' => 'nullable|string|max:1000',
        ]);

        $categoria = Tag::find($this->editTagId);

        if ($categoria) {
            $slug = Str::slug($this->tagNombre);

            // Check if ANY OTHER tag has this slug
            $exists = Tag::where('slug', $slug)
                ->where('id', '!=', $this->editTagId)
                ->exists();

            if ($exists) {
                $this->addError('tagNombre', 'Esta categoría ya existe.');
                return;
            }

            $categoria->update([
                'nombre' => $this->tagNombre,
                'nombre_en' => $this->tagNombre_en,
                'slug' => $slug,
                'slug_en' => $this->tagNombre_en ? Str::slug($this->tagNombre_en) : null,
                'descripcion' => $this->tagDescripcion,
                'descripcion_en' => $this->tagDescripcion_en,
            ]);

            Flux::toast("La categoría '{$this->tagNombre}' ha sido actualizada.");
            $this->cancelCategoriaEdit();
        }
    }


    public function deleteCategoria($id): void
    {
        $categoria = Tag::find($id);

        if ($categoria) {
            $nombre = $categoria->nombre;

            if ($categoria->multimedia_id) {
                $multimedia = $categoria->multimedia;
                if ($multimedia && $multimedia->filename) {
                    Storage::disk('public')->delete($multimedia->filename);
                    $multimedia->delete();
                }
            }

            $categoria->delete();
            Flux::toast("La categoría '{$nombre}' ha sido eliminada.");
        }
    }

    /**
     * Translate titulo from Spanish to English using AI.
     *
     * @return void
     */
    public function translateTitulo(): void
    {
        if (empty($this->titulo)) {
            Flux::toast('El título en español está vacío', 'warning');
            return;
        }

        try {
            $translator = new \App\Modules\Shared\Application\Services\TranslationService();
            $this->titulo_en = $translator->translateToEnglish($this->titulo);
            Flux::toast('Título traducido correctamente');
        } catch (\Exception $e) {
            Flux::toast('Error al traducir: ' . $e->getMessage(), 'danger');
        }
    }

    /**
     * Translate contenido from Spanish to English using AI.
     *
     * @return void
     */
    public function translateContenido(): void
    {
        if (empty($this->contenido)) {
            Flux::toast('El contenido en español está vacío', 'warning');
            return;
        }

        try {
            $translator = new \App\Modules\Shared\Application\Services\TranslationService();
            $this->contenido_en = $translator->translateToEnglish($this->contenido);
            Flux::toast('Contenido traducido correctamente');
        } catch (\Exception $e) {
            Flux::toast('Error al traducir: ' . $e->getMessage(), 'danger');
        }
    }

    /**
     * Translate descripcion from Spanish to English using AI.
     *
     * @return void
     */
    public function translateDescripcion(): void
    {
        if (empty($this->descripcion)) {
            Flux::toast('La descripción en español está vacía', 'warning');
            return;
        }

        try {
            $translator = new \App\Modules\Shared\Application\Services\TranslationService();
            $this->descripcion_en = $translator->translateToEnglish($this->descripcion);
            Flux::toast('Descripción traducida correctamente');
        } catch (\Exception $e) {
            Flux::toast('Error al traducir: ' . $e->getMessage(), 'danger');
        }
    }

    /**
     * Translate categoria nombre from Spanish to English using AI.
     *
     * @return void
     */
    public function translateTagNombre(): void
    {
        if (empty($this->tagNombre)) {
            Flux::toast('El nombre en español está vacío', 'warning');
            return;
        }

        try {
            $translator = new \App\Modules\Shared\Application\Services\TranslationService();
            $this->tagNombre_en = $translator->translateToEnglish($this->tagNombre);
            Flux::toast('Nombre traducido correctamente');
        } catch (\Exception $e) {
            Flux::toast('Error al traducir: ' . $e->getMessage(), 'danger');
        }
    }

    /**
     * Translate categoria descripcion from Spanish to English using AI.
     *
     * @return void
     */
    public function translateTagDescripcion(): void
    {
        if (empty($this->tagDescripcion)) {
            Flux::toast('La descripción en español está vacía', 'warning');
            return;
        }

        try {
            $translator = new \App\Modules\Shared\Application\Services\TranslationService();
            $this->tagDescripcion_en = $translator->translateToEnglish($this->tagDescripcion);
            Flux::toast('Descripción traducida correctamente');
        } catch (\Exception $e) {
            Flux::toast('Error al traducir: ' . $e->getMessage(), 'danger');
        }
    }

    /**
     * Translate donation_content from Spanish to English using AI.
     *
     * @return void
     */
    public function translateDonationContent(): void
    {
        if (empty($this->donation_content)) {
            Flux::toast('El contenido de donación en español está vacío', 'warning');
            return;
        }

        try {
            $translator = new \App\Modules\Shared\Application\Services\TranslationService();
            $this->donation_content_en = $translator->translateToEnglish($this->donation_content);
            Flux::toast('Contenido de donación traducido correctamente');
        } catch (\Exception $e) {
            Flux::toast('Error al traducir: ' . $e->getMessage(), 'danger');
        }
    }

    public function render(): View
    {
        return view('livewire.admin.noticia.page');
    }
}
