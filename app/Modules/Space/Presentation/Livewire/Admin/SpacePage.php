<?php

namespace App\Modules\Space\Presentation\Livewire\Admin;

use App\Modules\Space\Infrastructure\Models\Space;
use App\Modules\Shared\Application\Services\ImageService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Computed;
use Flux\Flux;
use Illuminate\Support\Facades\Storage;

class SpacePage extends Component
{
    use WithPagination, WithFileUploads;

    public string $sortBy = 'nombre';
    public string $sortDirection = 'asc';
    public int $perPage = 10;
    public string $search = '';

    // Form fields for create modal only
    public string $nombre = '';
    public string $url = '';
    public string $ubicacion = '';
    public string $ubicacion_lat = '';
    public string $ubicacion_long = '';
    public string $status = 'activo';
    public $multimedia = null;

    protected array $queryString = [
        'search' => ['except' => ''],
        'sortBy' => ['except' => 'nombre'],
        'sortDirection' => ['except' => 'asc']
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
    public function spaces(): LengthAwarePaginator
    {
        return Space::query()
            ->when($this->search, function($query, $search) {
                return $query->where('nombre', 'like', "%$search%")
                           ->orWhere('ubicacion', 'like', "%$search%")
                           ->orWhere('url', 'like', "%$search%");
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);
    }


    public function delete($id): void
    {
        $space = Space::find($id);

        if ($space) {
            $nombre = $space->nombre;
            
            // Delete associated multimedia
            if ($space->multimedia) {
                Storage::disk('public')->delete($space->multimedia->filename);
                $space->multimedia->delete();
            }
            
            // Detach strategies
            $space->strategies()->detach();
            
            $space->delete();

            Flux::toast("El espacio '$nombre' ha sido eliminado.");
        }
    }

    public function openCreateModal(): void
    {
        $this->resetForm();
        Flux::modal('createSpace')->show();
    }

    public function cancelCreate(): void
    {
        $this->resetForm();
        Flux::modal('createSpace')->close();
    }

    public function resetForm(): void
    {
        $this->reset([
            'nombre',
            'url',
            'ubicacion',
            'ubicacion_lat',
            'ubicacion_long',
            'status',
            'multimedia'
        ]);
        
        $this->status = 'activo';
    }


    public function store(): void
    {
        $this->validate([
            'nombre' => 'required|min:3|max:255',
            'url' => 'nullable|url|max:255',
            'ubicacion' => 'required|max:255',
            'ubicacion_lat' => 'required|numeric',
            'ubicacion_long' => 'required|numeric',
            'status' => 'required|in:activo,finalizado',
            'multimedia' => 'nullable|image|max:10240',
        ]);

        // Process multimedia
        $multimedia_id = null;
        if ($this->multimedia) {
            $imageService = new ImageService();
            $multimedia = $imageService->processAndStore($this->multimedia, 'espacio');
            $multimedia_id = $multimedia->id;
        }

        $space = Space::create([
            'nombre' => $this->nombre,
            'url' => $this->url,
            'ubicacion' => $this->ubicacion,
            'ubicacion_lat' => $this->ubicacion_lat,
            'ubicacion_long' => $this->ubicacion_long,
            'status' => $this->status,
            'multimedia_id' => $multimedia_id,
        ]);

        Flux::toast("El espacio ha sido creado. Redirigiendo a edición...");
        $this->resetForm();
        
        // Redirect to edit page
        $this->redirectRoute('admin.spaces.edit', $space->id);
    }


    public function render(): View
    {
        return view('livewire.admin.space.page');
    }
}
