<?php

namespace App\Livewire\Admin\Tag;

use App\Modules\Tag\Infrastructure\Models\Tag;
use App\Modules\Shared\Application\Services\ImageService;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Computed;
use Flux\Flux;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Page extends Component
{
    use WithPagination, WithFileUploads;

    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 10;
    public $search = '';

    // Form fields - Spanish
    public $nombre = '';
    public $descripcion = '';
    public $texto = '';
    public $sidebar = '';

    // Form fields - English
    public $nombre_en = '';
    public $descripcion_en = '';
    public $texto_en = '';
    public $sidebar_en = '';

    public $type = 'noticia';
    public $imagen; // For file upload
    public $editId; // For storing the ID of the item being edited

    protected $queryString = [
        'search' => ['except' => ''],
        'sortBy' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc']
    ];

    public function sort($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    #[Computed]
    public function tags()
    {
        return Tag::query()
            ->with('multimedia')
            ->when($this->search, function($query, $search) {
                return $query->where('nombre', 'like', "%{$search}%")
                           ->orWhere('type', 'like', "%{$search}%")
                           ->orWhere('descripcion', 'like', "%{$search}%");
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function delete($id)
    {
        $tag = Tag::find($id);

        if ($tag) {
            $nombre = $tag->nombre;
            
            // Delete associated multimedia if exists
            if ($tag->multimedia) {
                Storage::disk('public')->delete($tag->multimedia->filename);
                $tag->multimedia->delete();
            }
            
            $tag->delete();

            Flux::toast("El tag '{$nombre}' ha sido eliminado.");
        }
    }

    public function resetForm()
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
            'editId'
        ]);
        Flux::modal('createTag')->close();
    }

    public function cancelEdit()
    {
        $this->reset([
            'editId',
            'nombre',
            'nombre_en',
            'descripcion',
            'descripcion_en',
            'texto',
            'texto_en',
            'sidebar',
            'sidebar_en',
            'type',
            'imagen'
        ]);
        Flux::modal('editTag')->close();
    }

    public function editTag($id)
    {
        $this->editId = $id;
        $tag = Tag::with('multimedia')->find($id);

        if ($tag) {
            $this->nombre = $tag->nombre;
            $this->nombre_en = $tag->nombre_en;
            $this->descripcion = $tag->descripcion;
            $this->descripcion_en = $tag->descripcion_en;
            $this->texto = $tag->texto;
            $this->texto_en = $tag->texto_en;
            $this->sidebar = $tag->sidebar;
            $this->sidebar_en = $tag->sidebar_en;
            $this->type = $tag->type;
        }

        Flux::modal('editTag')->show();
    }

    public function store()
    {
        $this->validate([
            'nombre' => 'required|min:2|max:255',
            'nombre_en' => 'nullable|min:2|max:255',
            'descripcion' => 'nullable|max:1000',
            'descripcion_en' => 'nullable|max:1000',
            'texto' => 'nullable',
            'texto_en' => 'nullable',
            'sidebar' => 'nullable',
            'sidebar_en' => 'nullable',
            'type' => 'required|string|max:50',
            'imagen' => 'nullable|image|max:10240', // Max 10MB
        ]);

        $multimediaId = null;

        // Process and upload image if provided
        if ($this->imagen) {
            $imageService = new ImageService();
            $multimedia = $imageService->processAndStore(
                $this->imagen,
                'tags',
                600, // max width
                400, // max height
                85   // quality
            );
            $multimediaId = $multimedia->id;
        }

        Tag::create([
            'nombre' => $this->nombre,
            'nombre_en' => $this->nombre_en,
            'slug' => Str::slug($this->nombre),
            'slug_en' => $this->nombre_en ? Str::slug($this->nombre_en) : null,
            'descripcion' => $this->descripcion,
            'descripcion_en' => $this->descripcion_en,
            'texto' => $this->texto,
            'texto_en' => $this->texto_en,
            'sidebar' => $this->sidebar,
            'sidebar_en' => $this->sidebar_en,
            'type' => $this->type,
            'multimedia_id' => $multimediaId,
        ]);

        $this->resetForm();
        Flux::toast("El tag '{$this->nombre}' ha sido creado.");
    }

    public function update()
    {
        $this->validate([
            'nombre' => 'required|min:2|max:255',
            'nombre_en' => 'nullable|min:2|max:255',
            'descripcion' => 'nullable|max:1000',
            'descripcion_en' => 'nullable|max:1000',
            'texto' => 'nullable',
            'texto_en' => 'nullable',
            'sidebar' => 'nullable',
            'sidebar_en' => 'nullable',
            'type' => 'required|string|max:50',
            'imagen' => 'nullable|image|max:10240', // Max 10MB
        ]);

        $tag = Tag::with('multimedia')->find($this->editId);

        if ($tag) {
            $updateData = [
                'nombre' => $this->nombre,
                'nombre_en' => $this->nombre_en,
                'slug' => Str::slug($this->nombre),
                'slug_en' => $this->nombre_en ? Str::slug($this->nombre_en) : null,
                'descripcion' => $this->descripcion,
                'descripcion_en' => $this->descripcion_en,
                'texto' => $this->texto,
                'texto_en' => $this->texto_en,
                'sidebar' => $this->sidebar,
                'sidebar_en' => $this->sidebar_en,
                'type' => $this->type,
            ];

            // Process and upload new image if provided
            if ($this->imagen) {
                // Delete old multimedia if exists
                if ($tag->multimedia) {
                    Storage::disk('public')->delete($tag->multimedia->filename);
                    $tag->multimedia->delete();
                }

                $imageService = new ImageService();
                $multimedia = $imageService->processAndStore(
                    $this->imagen,
                    'tags',
                    600, // max width
                    400, // max height
                    85   // quality
                );
                $updateData['multimedia_id'] = $multimedia->id;
            }

            $tag->update($updateData);

            Flux::toast("El tag '{$this->nombre}' ha sido actualizado.");
            $this->cancelEdit();
        }
    }

    public function removeImage()
    {
        if ($this->editId) {
            $tag = Tag::with('multimedia')->find($this->editId);
            
            if ($tag && $tag->multimedia) {
                // Delete the file from storage
                Storage::disk('public')->delete($tag->multimedia->filename);
                
                // Delete the multimedia record
                $tag->multimedia->delete();
                
                // Remove the multimedia_id from the tag
                $tag->update(['multimedia_id' => null]);
                
                Flux::toast("Imagen eliminada correctamente.");
            }
        }
    }

    #[Computed]
    public function currentImage()
    {
        if ($this->editId) {
            $tag = Tag::with('multimedia')->find($this->editId);
            return $tag ? $tag->multimedia : null;
        }
        return null;
    }

    public function render()
    {
        return view('livewire.admin.tag.page');
    }
} 