<?php

namespace App\Modules\Exhibition\Presentation\Livewire\Admin;

use App\Modules\Exhibition\Application\Services\ExhibitionService;
use App\Modules\Exhibition\Infrastructure\Models\Exhibition;
use App\Modules\Shared\Application\Services\ImageService;
use App\Modules\Shared\Application\Services\GeminiTranslationService;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Computed;
use Flux\Flux;
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
    use WithFileUploads;

    public ?int $id = null;

    // Form fields
    public string $estado = 'public';
    public string $type = 'exposicion';
    public string $titulo = '';
    public string $titulo_en = '';
    public string $metadatos = '';
    public string $metadatos_en = '';
    public string $contenido = '';
    public string $contenido_en = '';
    public ?string $fecha = null;
    public array $multimedia = []; // New uploads

    // Video management
    public array $videos = [];
    public string $newVideoTitle = '';
    public string $newVideoDescription = '';
    public string $newVideoUrl = '';

    // File management
    public array $files = []; // Renamed from archivos
    public array $editingFiles = [];
    public ?string $translationError = null;

    protected ExhibitionService $service;

    public function boot(ExhibitionService $service)
    {
        $this->service = $service;
    }

    public function mount($id = null)
    {
        if ($id) {
            $this->id = $id;
            $this->loadExhibition($id);
        } else {
            $this->estado = 'public';
            $this->type = 'exposicion';
        }
    }

    public function loadExhibition($id)
    {
        $exhibition = $this->service->find($id);

        if ($exhibition) {
            $this->estado = $exhibition->estado;
            $this->type = $exhibition->type;

            $this->titulo = $exhibition->getTranslation('titulo', 'es');
            $this->titulo_en = $exhibition->getTranslation('titulo', 'en');

            $this->contenido = $exhibition->getTranslation('contenido', 'es');
            $this->contenido_en = $exhibition->getTranslation('contenido', 'en');

            $this->metadatos = $exhibition->getTranslation('metadatos', 'es');
            $this->metadatos_en = $exhibition->getTranslation('metadatos', 'en');

            $this->metadatos = $exhibition->getTranslation('metadatos', 'es');
            $this->metadatos_en = $exhibition->getTranslation('metadatos', 'en');

            $this->fecha = $this->formatDateForPicker($exhibition->fecha);


            // Load videos
            if ($exhibition->videos && $exhibition->videos->isNotEmpty()) {
                $this->videos = $exhibition->videos->map(function ($video) {
                    return [
                        'id' => $video->id,
                        'titulo' => $video->titulo,
                        'descripcion' => $video->descripcion,
                        'youtube_url' => $video->youtube_url,
                        'orden' => $video->orden
                    ];
                })->toArray();
            }

            // Load files
            if ($exhibition->files && $exhibition->files->isNotEmpty()) {
                $this->files = $exhibition->files->map(function ($file) {
                    return [
                        'id' => $file->id,
                        'titulo' => $file->titulo,
                        'descripcion' => $file->descripcion,
                        'contenido' => $file->contenido, // some robust desc
                        'filename' => $file->filename,
                        'stored_filename' => $file->stored_filename,
                        'thumbnail' => $file->thumbnail,
                        'mime_type' => $file->mime_type,
                        'file_size' => $file->file_size,
                        'orden' => $file->orden,
                        'file' => null // For new uploads
                    ];
                })->toArray();
            }
        }
    }



    public function translateAllFields(): void
    {
        $fieldsToTranslate = [
            'titulo' => $this->titulo,
            'metadatos' => $this->metadatos,
            'contenido' => $this->contenido,
        ];

        // Filter out empty values
        $fieldsToTranslate = array_filter($fieldsToTranslate, fn($value) => !empty($value));

        if (empty($fieldsToTranslate)) {
            Flux::toast('No hay campos en español para traducir', variant: 'warning');
            return;
        }

        $this->translationError = null;

        try {
            $translator = new GeminiTranslationService();
            $translatedFields = $translator->translateBatch($fieldsToTranslate);

            foreach ($translatedFields as $field => $translatedContent) {
                if ($translatedContent !== null) {
                    $this->{$field . '_en'} = $translatedContent;
                }
            }

            $count = count($fieldsToTranslate);
            Flux::toast(
                heading: 'Traducción completada',
                text: "Se tradujeron {$count} campos correctamente",
                variant: 'success'
            );
        } catch (\Exception $e) {
            \Log::error('Translation error', ['message' => $e->getMessage()]);
            $this->translationError = 'Error de traducción: ' . $e->getMessage();
            Flux::toast(
                heading: 'Error de traducción',
                text: $e->getMessage(),
                variant: 'danger'
            );
        }
    }

    public function save()
    {
        $this->validate([
            'estado' => 'required|in:public,private',
            'type' => 'required|in:exposicion,proyecto-artistico',
            'titulo' => 'required|min:3|max:255',
            'titulo_en' => 'nullable|min:3|max:255',
            'contenido' => 'required|min:10|max:50000',
            'contenido_en' => 'nullable|max:50000',
            'metadatos' => 'nullable|string|max:1000',
            'metadatos_en' => 'nullable|string|max:1000',
            'fecha' => 'nullable|string|max:255',
            'multimedia.*' => 'nullable|image|max:10240|dimensions:min_width=400,min_height=300,max_width=4000,max_height=4000',
            'files.*.file' => 'nullable|file|max:51200',
            'files.*.titulo' => 'nullable|string|max:255',
        ], [
            'fecha.regex' => 'El formato de fecha debe ser: YYYY, YYYY-YYYY, o YYYY-MM-DD',
            'multimedia.*.dimensions' => 'Las imágenes deben tener un mínimo de 400x300 píxeles y un máximo de 4000x4000 píxeles.',
        ]);

        $data = [
            'estado' => $this->estado,
            'type' => $this->type,
            'titulo' => $this->titulo,
            'titulo_en' => $this->titulo_en,
            'contenido' => $this->contenido,
            'contenido_en' => $this->contenido_en,
            'metadatos' => $this->metadatos,
            'metadatos_en' => $this->metadatos_en,
            'fecha' => $this->fecha,
        ];

        if ($this->id) {
            $this->service->update($this->id, $data);
            $exhibition = $this->service->find($this->id);
            $message = 'Exposición actualizada correctamente.';
        } else {
            $exhibition = $this->service->create($data);
            $this->id = $exhibition->id;
            $message = 'Exposición creada correctamente.';
        }

        $this->handleMultimedia($exhibition);
        $this->handleVideos($exhibition);
        $this->handleFiles($exhibition);

        Flux::toast($message);
        return redirect()->route('admin.exhibitions.index');
    }

    protected function handleMultimedia($exhibition)
    {
        if ($this->multimedia) {
            $imageService = new ImageService();
            foreach ($this->multimedia as $file) {
                // Use generic 'exhibition' folder
                $multimedia = $imageService->processAndStore($file, 'exhibition');

                $exhibition->multimedia()->create([
                    'multimedia_id' => $multimedia->id
                ]);
            }
        }
    }

    protected function handleVideos($exhibition)
    {
        // For updates, we might want to sync. Simple approach: delete all and recreate (lossy if id needed)
        // Better approach: Update existing, create new.
        // But for simplicity given UI structure usually sends full list:

        // However, we want to keep IDs if possible.
        // Let's iterate and update or create.

        // First, get current IDs
        $currentIds = collect($this->videos)->pluck('id')->filter()->toArray();
        // Delete removed videos
        $exhibition->videos()->whereNotIn('id', $currentIds)->delete();

        foreach ($this->videos as $index => $video) {
            if (!empty($video['titulo']) && !empty($video['youtube_url'])) {
                $videoData = [
                    'titulo' => $video['titulo'],
                    'descripcion' => $video['descripcion'] ?? '',
                    'youtube_url' => $video['youtube_url'],
                    'orden' => $index
                ];

                if (isset($video['id']) && $video['id']) {
                    $exhibition->videos()->where('id', $video['id'])->update($videoData);
                } else {
                    $exhibition->videos()->create($videoData);
                }
            }
        }
    }

    protected function handleFiles($exhibition)
    {
        // Similar to videos, sync files.
        $currentIds = collect($this->files)->pluck('id')->filter()->toArray();
        // We do NOT simple delete removed files from DB immediately because we need to delete file from disk.
        // So first find deleted ones.
        $deletedFiles = $exhibition->files()->whereNotIn('id', $currentIds)->get();
        foreach ($deletedFiles as $delFile) {
            if ($delFile->stored_filename)
                Storage::disk('public')->delete($delFile->stored_filename);
            if ($delFile->thumbnail)
                Storage::disk('public')->delete($delFile->thumbnail);
            $delFile->delete();
        }

        foreach ($this->files as $index => $fileData) {
            // New Upload
            if (isset($fileData['file']) && $fileData['file']) {
                $file = $fileData['file'];
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('exhibition/files', $filename, 'public');

                $thumbnailPath = null;
                if (isset($fileData['thumbnail']) && $fileData['thumbnail']) {
                    $thumbnailFile = $fileData['thumbnail'];
                    // Check if it's an uploaded file object
                    if (!is_string($thumbnailFile)) {
                        $thumbnailFilename = time() . '_thumb_' . $thumbnailFile->getClientOriginalName();
                        $thumbnailPath = $thumbnailFile->storeAs('exhibition/files/thumbnails', $thumbnailFilename, 'public');
                    }
                }

                $exhibition->files()->create([
                    'titulo' => $fileData['titulo'] ?? $file->getClientOriginalName(),
                    'descripcion' => $fileData['descripcion'] ?? '',
                    'contenido' => $fileData['contenido'] ?? '',
                    'filename' => $file->getClientOriginalName(),
                    'stored_filename' => $path,
                    'thumbnail' => $thumbnailPath,
                    'mime_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                    'orden' => $index
                ]);
            }
            // Update Existing
            elseif (isset($fileData['id']) && $fileData['id']) {
                $existingFile = $exhibition->files()->find($fileData['id']);
                if ($existingFile) {
                    $updateData = [
                        'titulo' => $fileData['titulo'],
                        'descripcion' => $fileData['descripcion'],
                        'contenido' => $fileData['contenido'] ?? '',
                        'orden' => $index
                    ];

                    if (isset($fileData['thumbnail']) && !is_string($fileData['thumbnail'])) {
                        if ($existingFile->thumbnail)
                            Storage::disk('public')->delete($existingFile->thumbnail);

                        $thumbnailFile = $fileData['thumbnail'];
                        $thumbnailFilename = time() . '_thumb_' . $thumbnailFile->getClientOriginalName();
                        $thumbnailPath = $thumbnailFile->storeAs('exhibition/files/thumbnails', $thumbnailFilename, 'public');
                        $updateData['thumbnail'] = $thumbnailPath;
                    }

                    $existingFile->update($updateData);
                }
            }
        }
    }

    // UI Helpers for removing media (immediate action for multimedia, deferred for videos/files unless specific remove action)

    public function removeMultimedia(int $multimediaId)
    {
        if ($this->id) {
            $exhibition = $this->service->find($this->id);
            if ($exhibition) {
                // Find the ExhibitionMultimedia join record
                $pm = $exhibition->multimedia()->where('multimedia_id', $multimediaId)->first();
                if ($pm) {
                    $multimedia = $pm->multimedia;

                    if ($multimedia) {
                        $filename = $multimedia->filename;

                        // Delete the actual file from storage
                        if ($filename) {
                            \Illuminate\Support\Facades\Storage::disk('public')->delete($filename);
                        }

                        // Delete the multimedia record
                        $multimedia->delete();
                    }

                    // Delete the join record
                    $pm->delete();

                    Flux::toast("Imagen eliminada.");
                }
            }
        }
    }

    #[Computed]
    public function existingMultimedia()
    {
        if ($this->id) {
            $exhibition = $this->service->find($this->id);
            return $exhibition ? $exhibition->multimedia : collect();
        }
        return collect();
    }

    // Video/File Array Manipulation Helpers
    public function addVideo()
    {
        // Validate that at least title and URL are provided
        if (empty($this->newVideoTitle) || empty($this->newVideoUrl)) {
            Flux::toast('Por favor, ingresa al menos el título y la URL del video.', variant: 'danger');
            return;
        }

        // Add the video with the form field values
        $this->videos[] = [
            'id' => null,
            'titulo' => $this->newVideoTitle,
            'descripcion' => $this->newVideoDescription,
            'youtube_url' => $this->newVideoUrl,
            'orden' => count($this->videos)
        ];

        // Clear the form fields
        $this->newVideoTitle = '';
        $this->newVideoDescription = '';
        $this->newVideoUrl = '';

        Flux::toast('Video agregado correctamente.');
    }

    public function removeVideo($index)
    {
        unset($this->videos[$index]);
        $this->videos = array_values($this->videos);
    }

    public function addFile()
    {
        $this->files[] = [
            'id' => null,
            'titulo' => '',
            'descripcion' => '',
            'file' => null,
            'orden' => count($this->files)
        ];
    }

    public function removeFile($index)
    {
        unset($this->files[$index]);
        $this->files = array_values($this->files);
    }

    public function render(): View
    {
        return view('livewire.admin.exhibition.edit');
    }

    private function formatDateForPicker(?string $date): string
    {
        if (empty($date)) {
            return '';
        }

        if (preg_match('/^\d{4}$/', $date)) {
            return "{$date}-01-01";
        }

        return $date;
    }
}
