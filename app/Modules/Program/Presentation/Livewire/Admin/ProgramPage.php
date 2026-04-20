<?php

namespace App\Modules\Program\Presentation\Livewire\Admin;

use App\Modules\Program\Infrastructure\Models\Program;
use App\Modules\Tag\Infrastructure\Models\Tag;
use App\Modules\Shared\Application\Services\ImageService;
use App\Modules\Shared\Application\Services\GeminiTranslationService;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Computed;
use Flux\Flux;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Modules\Program\Application\Services\ProgramService;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Illuminate\Support\Str;

class ProgramPage extends Component
{
    use WithPagination, WithFileUploads;

    public string $sortBy = 'created_at';
    public string $sortDirection = 'desc';
    public int $perPage = 10;
    public string $search = '';
    public string $searchTag = '';

    // Form fields - Spanish
    public string $estado = 'public';
    public string $tipo = 'local';
    public string $titulo = '';
    public string $metadatos = '';
    public string $contenido = '';

    // Form fields - English
    public string $titulo_en = '';
    public string $metadatos_en = '';
    public string $contenido_en = '';

    public ?string $fecha = null;
    public array $selectedTags = [];
    public array $multimedia = []; // For file uploads
    public ?int $editId = null; // For storing the ID of the item being edited
    public bool $assign_to_expo_proyecto = false;
    public ?int $exposicion_id = null;

    // Categoria fields - Spanish
    public ?string $nombre = '';
    public ?string $descripcion = '';
    public ?string $texto = '';
    public ?string $sidebar = '';

    // Categoria fields - English
    public ?string $nombre_en = '';
    public ?string $descripcion_en = '';
    public ?string $texto_en = '';
    public ?string $sidebar_en = '';

    public string $type = 'programa-local';
    public ?\App\Modules\Multimedia\Infrastructure\Models\Multimedia $currentImage = null;
    public ?\Livewire\Features\SupportFileUploads\TemporaryUploadedFile $imagen = null; // For image uploads in categories
    public ?\App\Modules\Multimedia\Infrastructure\Models\Multimedia $currentThumbnail = null;
    public ?\Livewire\Features\SupportFileUploads\TemporaryUploadedFile $thumbnail = null; // For thumbnail uploads in categories
    public ?string $translationError = null;

    protected array $queryString = [
        'search' => ['except' => ''],
        'searchTag' => ['except' => ''],
        'sortBy' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc']
    ];

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
    public function programTags(): Collection
    {
        $type = 'programa-' . $this->tipo;
        return Tag::where('type', $type)->orderBy('nombre', 'asc')->get();
    }

    #[Computed]
    public function programs(): LengthAwarePaginator
    {
        return Program::query()
            ->when($this->search, function ($query) {
                $query->where('titulo', 'like', '%' . $this->search . '%')
                    ->orWhere('contenido', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function delete($id): void
    {
        $service = app(ProgramService::class);
        $program = $service->find($id);

        if ($program) {
            // Get title using accessor logic or raw attribute
            $titulo = $program->getTranslation('titulo', 'es');
            $service->delete($id);
            Flux::toast("El programa '{$titulo}' ha sido eliminado.");
        }
    }

    public function editProgram($id): void
    {
        $this->translationError = null;
        $this->editId = $id;
        $service = app(ProgramService::class);
        $program = $service->find($id);

        if ($program) {
            $this->estado = $program->estado;
            $this->tipo = $program->tipo;

            $this->titulo = $program->getTranslation('titulo', 'es');
            $this->titulo_en = $program->getTranslation('titulo', 'en', false);
            $this->contenido = $program->getTranslation('contenido', 'es');
            $this->contenido_en = $program->getTranslation('contenido', 'en', false);
            $this->metadatos = $program->getTranslation('metadatos', 'es');
            $this->metadatos_en = $program->getTranslation('metadatos', 'en', false);

            $this->metadatos_en = $program->getTranslation('metadatos', 'en', false);

            $this->fecha = $this->formatDateForPicker($program->fecha);
            $this->selectedTags = $program->tags->pluck('id')->toArray();
            $this->assign_to_expo_proyecto = $program->assign_to_expo_proyecto;
            $this->exposicion_id = $program->exposicion_id;
        }

        Flux::modal('editProgram')->show();
    }

    public function store(): void
    {
        $this->validate([
            'estado' => 'required|in:public,private',
            'tipo' => 'required|in:local,externo',
            'titulo' => 'required|min:3|max:255',
            'titulo_en' => 'nullable|min:3|max:255',
            'contenido' => 'required|min:10|max:50000',
            'contenido_en' => 'nullable|max:50000',
            'metadatos' => 'nullable|string|max:1000',
            'metadatos_en' => 'nullable|string|max:1000',

            'fecha' => 'required|string|max:255',

            'multimedia' => 'nullable|array',
            'multimedia.*' => 'image|max:10240|dimensions:min_width=400,min_height=300,max_width=4000,max_height=4000',

            'assign_to_expo_proyecto' => 'nullable|boolean',
            'exposicion_id' => 'nullable|exists:exposiciones,id',
        ]);

        $data = [
            'estado' => $this->estado,
            'tipo' => $this->tipo,
            'titulo' => $this->titulo,
            'titulo_en' => $this->titulo_en,
            'contenido' => $this->contenido,
            'contenido_en' => $this->contenido_en,
            'metadatos' => $this->metadatos,
            'metadatos_en' => $this->metadatos_en,
            'fecha' => $this->fecha,
            'assign_to_expo_proyecto' => $this->assign_to_expo_proyecto,
            'exposicion_id' => $this->assign_to_expo_proyecto ? $this->exposicion_id : null,
        ];

        $service = app(ProgramService::class);
        $program = $service->create($data);

        // Multimedia handling - preserving mostly logic from Page but using service potentially later
        if ($this->multimedia) {
            $imageService = new ImageService();
            foreach ($this->multimedia as $file) {
                $multimedia = $imageService->processAndStore($file, 'programa', 1200, 800, 85);
                $program->multimedia()->create(['multimedia_id' => $multimedia->id]);
            }
        }

        if (!empty($this->selectedTags)) {
            $program->tags()->attach($this->selectedTags);
        }

        Flux::toast("El programa '{$this->titulo}' ha sido creado.");
        $this->resetForm();
    }

    public function update(): void
    {
        $this->validate([
            'estado' => 'required|in:public,private',
            'tipo' => 'required|in:local,externo',
            'titulo' => 'required|min:3|max:255',
            'titulo_en' => 'nullable|min:3|max:255',
            'contenido' => 'required|min:10|max:50000',
            'contenido_en' => 'nullable|max:50000',
            'metadatos' => 'nullable|string|max:1000',
            'metadatos_en' => 'nullable|string|max:1000',
            'fecha' => 'required|string|max:255',
            'multimedia.*' => 'nullable|image|max:10240|dimensions:min_width=400,min_height=300,max_width=4000,max_height=4000',
            'assign_to_expo_proyecto' => 'boolean',
            'exposicion_id' => 'nullable|exists:exposiciones,id',
        ], [
            'multimedia.*.dimensions' => 'Las imágenes deben tener un mínimo de 400x300 píxeles y un máximo de 4000x4000 píxeles.',
        ]);

        $data = [
            'estado' => $this->estado,
            'tipo' => $this->tipo,
            'titulo' => $this->titulo,
            'titulo_en' => $this->titulo_en,
            'contenido' => $this->contenido,
            'contenido_en' => $this->contenido_en,
            'metadatos' => $this->metadatos,
            'metadatos_en' => $this->metadatos_en,
            'fecha' => $this->fecha,
            'assign_to_expo_proyecto' => $this->assign_to_expo_proyecto,
            'exposicion_id' => $this->assign_to_expo_proyecto ? $this->exposicion_id : null,
        ];

        $service = app(ProgramService::class);
        $program = $service->update($this->editId, $data);

        if ($program) {
            if ($this->multimedia) {
                $imageService = new ImageService();
                foreach ($this->multimedia as $file) {
                    $multimedia = $imageService->processAndStore($file, 'programa', 1200, 800, 85);
                    $program->multimedia()->create(['multimedia_id' => $multimedia->id]);
                }
            }
            $program->tags()->sync($this->selectedTags);
            Flux::toast("El programa '{$this->titulo}' ha sido actualizado.");
            $this->cancelEdit();
        }
    }

    public function removeThumbnail(): void
    {
        $category = Tag::find($this->editId);

        if ($category && $category->thumbnail_id) {
            $thumbnail = $category->thumbnail;

            if ($thumbnail && $thumbnail->filename) {
                Storage::disk('public')->delete($thumbnail->filename);
                $thumbnail->delete();
            }

            $category->thumbnail_id = null;
            $category->save();

            $this->currentThumbnail = null;

            Flux::toast("Thumbnail eliminado correctamente.");
        }
    }

    public function deleteCategory($id): void
    {
        $category = Tag::find($id);

        if ($category) {
            $nombre = $category->nombre;

            // Delete associated banner image if exists
            if ($category->multimedia_id) {
                $multimedia = $category->multimedia;
                if ($multimedia && $multimedia->filename) {
                    Storage::disk('public')->delete($multimedia->filename);
                    $multimedia->delete();
                }
            }

            // Delete associated thumbnail if exists
            if ($category->thumbnail_id) {
                $thumbnail = $category->thumbnail;
                if ($thumbnail && $thumbnail->filename) {
                    Storage::disk('public')->delete($thumbnail->filename);
                    $thumbnail->delete();
                }
            }

            $category->delete();

            Flux::toast("La categoría '{$nombre}' ha sido eliminada.");
        }
    }

    /**
     * Translate all program fields at once
     */
    public function translateAllProgramFields(): void
    {
        $fieldsToTranslate = [];

        if (!empty($this->titulo)) {
            $fieldsToTranslate['titulo'] = $this->titulo;
        }

        if (!empty($this->metadatos)) {
            $fieldsToTranslate['metadatos'] = $this->metadatos;
        }

        if (!empty($this->contenido)) {
            $fieldsToTranslate['contenido'] = $this->contenido;
        }

        if (empty($fieldsToTranslate)) {
            Flux::toast('No hay campos en español para traducir', variant: 'warning');
            return;
        }

        $this->translationError = null;

        try {
            $translator = new GeminiTranslationService();

            // Translate all fields in a single batch
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
            \Log::error('Translation Error Catch:', ['message' => $e->getMessage()]);
            $this->translationError = 'Error de traducción: ' . $e->getMessage();
            Flux::toast('Error de traducción: ' . $e->getMessage(), variant: 'danger');
        }
    }

    /**
     * Translate all category fields at once
     */
    public function translateAllCategoryFields(): void
    {
        $fieldsToTranslate = [];

        if (!empty($this->nombre)) {
            $fieldsToTranslate['nombre'] = $this->nombre;
        }

        if (!empty($this->descripcion)) {
            $fieldsToTranslate['descripcion'] = $this->descripcion;
        }

        if (!empty($this->texto)) {
            $fieldsToTranslate['texto'] = $this->texto;
        }

        if (!empty($this->sidebar)) {
            $fieldsToTranslate['sidebar'] = $this->sidebar;
        }

        if (empty($fieldsToTranslate)) {
            Flux::toast('No hay campos en español para traducir', variant: 'warning');
            return;
        }

        try {
            $translator = new GeminiTranslationService();

            // Translate all fields in a single batch
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
            \Log::error('Category Translation Error Catch:', ['message' => $e->getMessage()]);
            $this->translationError = 'Error de traducción: ' . $e->getMessage();
            Flux::toast('Error de traducción: ' . $e->getMessage(), variant: 'danger');
        }
    }

    #[Computed]
    public function categories(): LengthAwarePaginator
    {
        return Tag::query()
            ->where(function ($query) {
                $query->where('type', 'programa-local')
                    ->orWhere('type', 'programa-externo');
            })
            ->when($this->searchTag, function ($query, $search) {
                return $query->where('nombre', 'like', "%{$search}%");
            })
            ->orderBy('type', 'asc')
            ->orderBy('nombre', 'asc')
            ->paginate($this->perPage, pageName: 'categoriasPage');
    }

    public function openCreateProgramModal(): void
    {
        $this->translationError = null;
        $this->reset([
            'estado',
            'tipo',
            'titulo',
            'titulo_en',
            'contenido',
            'contenido_en',
            'metadatos',
            'metadatos_en',
            'fecha',
            'selectedTags',
            'multimedia',
            'editId'
        ]);
        $this->estado = 'public';
        $this->tipo = 'local';
        Flux::modal('createProgram')->show();
    }

    public function resetForm(): void
    {
        $this->reset([
            'estado',
            'tipo',
            'titulo',
            'titulo_en',
            'contenido',
            'contenido_en',
            'metadatos',
            'metadatos_en',
            'fecha',
            'selectedTags',
            'multimedia',
            'editId',
            'assign_to_expo_proyecto',
            'exposicion_id'
        ]);
        Flux::modal('createProgram')->close();
    }

    public function cancelEdit(): void
    {
        $this->reset([
            'editId',
            'estado',
            'tipo',
            'titulo',
            'titulo_en',
            'contenido',
            'contenido_en',
            'metadatos',
            'metadatos_en',
            'fecha',
            'selectedTags',
            'multimedia',
            'assign_to_expo_proyecto',
            'exposicion_id'
        ]);
        Flux::modal('editProgram')->close();
    }

    // Category logic ... keeping mostly same but ensuring types match new logic if any
    public function editCategory($id): void
    {
        $this->translationError = null;
        $this->editId = $id;
        $categoria = Tag::with(['multimedia', 'thumbnail'])->find($id);

        if ($categoria) {
            $this->nombre = $categoria->nombre;
            $this->nombre_en = $categoria->nombre_en ?? '';
            $this->descripcion = $categoria->descripcion ?? '';
            $this->descripcion_en = $categoria->descripcion_en ?? '';
            $this->texto = $categoria->texto ?? '';
            $this->texto_en = $categoria->texto_en ?? '';
            $this->sidebar = $categoria->sidebar ?? '';
            $this->sidebar_en = $categoria->sidebar_en ?? '';
            $this->type = $categoria->type;
            $this->currentImage = $categoria->multimedia;
            $this->currentThumbnail = $categoria->thumbnail;
        }

        Flux::modal('editCategory')->show();
    }

    public function cancelCategoryEdit(): void
    {
        $this->resetCategoryForm();
        Flux::modal('editCategory')->close();
    }

    public function openCreateCategoryModal(): void
    {
        $this->translationError = null;
        $this->resetCategoryForm();
        Flux::modal('createCategory')->show();
    }

    public function resetCategoryForm(): void
    {
        $this->reset([
            'nombre',
            'nombre_en',
            'descripcion',
            'descripcion_en',
            'texto',
            'texto_en',
            'sidebar',
            'sidebar_en',
            'type',
            'imagen',
            'thumbnail',
            'editId',
            'currentImage',
            'currentThumbnail'
        ]);
        Flux::modal('createCategory')->close();
        Flux::modal('editCategory')->close();
    }

    public function storeCategory(): void
    {
        $this->validate([
            'nombre' => 'required|min:3|max:255',
            'type' => 'required|in:programa-local,programa-externo,exposicion,proyecto-artistico',
            'imagen' => 'nullable|image|max:10240',
            'thumbnail' => 'nullable|image|max:10240',
        ]);

        $categoria = Tag::create([
            'nombre' => $this->nombre,
            'nombre_en' => $this->nombre_en,
            'slug' => Str::slug($this->nombre),
            'descripcion' => $this->descripcion,
            'descripcion_en' => $this->descripcion_en,
            'texto' => $this->texto,
            'texto_en' => $this->texto_en,
            'sidebar' => $this->sidebar,
            'sidebar_en' => $this->sidebar_en,
            'type' => $this->type
        ]);

        $imageService = new ImageService();

        if ($this->imagen) {
            $multimedia = $imageService->processAndStore($this->imagen, 'tags', 1920, 400, 85);
            $categoria->multimedia_id = $multimedia->id;
            $categoria->save();
        }

        if ($this->thumbnail) {
            $thumbnail = $imageService->processAndStore($this->thumbnail, 'tags', 400, 400, 80);
            $categoria->thumbnail_id = $thumbnail->id;
            $categoria->save();
        }

        Flux::toast("Categoría '{$this->nombre}' creada existosamente.");
        $this->resetCategoryForm();
    }

    public function updateCategory(): void
    {
        $this->validate([
            'nombre' => 'required|min:3|max:255',
            'type' => 'required|in:programa-local,programa-externo,exposicion,proyecto-artistico',
            'imagen' => 'nullable|image|max:10240',
            'thumbnail' => 'nullable|image|max:10240',
        ]);

        $categoria = Tag::find($this->editId);

        if ($categoria) {
            $categoria->update([
                'nombre' => $this->nombre,
                'nombre_en' => $this->nombre_en,
                'slug' => Str::slug($this->nombre),
                'descripcion' => $this->descripcion,
                'descripcion_en' => $this->descripcion_en,
                'texto' => $this->texto,
                'texto_en' => $this->texto_en,
                'sidebar' => $this->sidebar,
                'sidebar_en' => $this->sidebar_en,
                'type' => $this->type
            ]);

            $imageService = new ImageService();

            if ($this->imagen) {
                // Delete old image if exists
                if ($categoria->multimedia_id && $categoria->multimedia) {
                    Storage::disk('public')->delete($categoria->multimedia->filename);
                    $categoria->multimedia->delete();
                }

                $multimedia = $imageService->processAndStore($this->imagen, 'tags', 1920, 400, 85);
                $categoria->multimedia_id = $multimedia->id;
                $categoria->save();
            }

            if ($this->thumbnail) {
                // Delete old thumbnail if exists
                if ($categoria->thumbnail_id && $categoria->thumbnail) {
                    Storage::disk('public')->delete($categoria->thumbnail->filename);
                    $categoria->thumbnail->delete();
                }

                $thumbnail = $imageService->processAndStore($this->thumbnail, 'tags', 400, 400, 80);
                $categoria->thumbnail_id = $thumbnail->id;
                $categoria->save();
            }

            Flux::toast("Categoría '{$this->nombre}' actualizada correctamente.");
            $this->resetCategoryForm();
        }
    }

    // ... updateCategory ...

    public function removeImage(): void
    {
        $category = Tag::find($this->editId);

        if ($category && $category->multimedia_id) {
            $multimedia = $category->multimedia;

            if ($multimedia && $multimedia->filename) {
                Storage::disk('public')->delete($multimedia->filename);
                $multimedia->delete();
            }

            $category->multimedia_id = null;
            $category->save();

            $this->currentImage = null;

            Flux::toast("Imagen eliminada correctamente.");
        }
    }

    public function removeMultimedia(int $multimediaId): void
    {
        if ($this->editId) {
            $program = Program::find($this->editId);
            if ($program) {
                // Find the ProgramMultimedia join record
                $pm = $program->multimedia()->where('multimedia_id', $multimediaId)->first();
                if ($pm) {
                    $multimedia = $pm->multimedia;

                    if ($multimedia) {
                        $filename = $multimedia->filename;

                        // Delete the actual file from storage
                        if ($filename) {
                            Storage::disk('public')->delete($filename);
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
        if ($this->editId) {
            $program = Program::with('multimedia.multimedia')->find($this->editId);
            return $program ? $program->multimedia : collect();
        }
        return collect();
    }

    public function updatedTipo(): void
    {
        $this->selectedTags = [];
    }

    #[\Livewire\Attributes\On('exposicion-selected')]
    public function handleExhibitionSelected(?int $id, string $title): void
    {
        $this->exposicion_id = $id;
    }

    public function updatedAssignToExpoProyecto(): void
    {
        if (!$this->assign_to_expo_proyecto) {
            $this->exposicion_id = null;
        }
    }

    public function render(): View
    {
        return view('livewire.admin.program.page');
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
