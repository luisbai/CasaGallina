<?php

namespace App\Modules\Space\Presentation\Livewire\Admin;

use App\Modules\Space\Infrastructure\Models\Space;

use App\Modules\Shared\Application\Services\ImageService;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Computed;
use Flux\Flux;
use Illuminate\Support\Facades\Storage;

class SpaceEdit extends Component
{
    use WithFileUploads;

    public Space $space;
    public int $spaceId;

    // Form fields
    public string $nombre = '';
    public string $url = '';
    public string $ubicacion = '';
    public string $ubicacion_lat = '';
    public string $ubicacion_long = '';
    public string $status = 'activo';
    public $multimedia = null;
    public ?int $multimedia_id = null;



    public function mount($id)
    {
        $this->spaceId = $id;
        $this->space = Space::with(['multimedia', 'strategies'])->findOrFail($id);

        // Load form data
        $this->nombre = $this->space->nombre;
        $this->url = $this->space->url ?? '';
        $this->ubicacion = $this->space->ubicacion;
        $this->ubicacion_lat = $this->space->ubicacion_lat;
        $this->ubicacion_long = $this->space->ubicacion_long;
        $this->status = $this->space->status;
        $this->multimedia_id = $this->space->multimedia_id;


    }



    public function update()
    {
        $this->validate([
            'nombre' => 'required|min:3|max:255',
            'url' => 'nullable|url|max:255',
            'ubicacion' => 'required|min:3|max:255',
            'ubicacion_lat' => 'required|numeric|between:-90,90',
            'ubicacion_long' => 'required|numeric|between:-180,180',
            'status' => 'required|in:activo,finalizado',
            'multimedia' => 'nullable|image|max:10240',
        ]);

        // Process new multimedia if uploaded
        $multimedia_id = $this->multimedia_id;
        if ($this->multimedia) {
            // Delete old multimedia if exists
            if ($this->space->multimedia) {
                Storage::disk('public')->delete($this->space->multimedia->filename);
                $this->space->multimedia->delete();
            }

            $imageService = new ImageService();
            $multimedia = $imageService->processAndStore($this->multimedia, 'espacio');
            $multimedia_id = $multimedia->id;
        }

        $this->space->update([
            'nombre' => $this->nombre,
            'url' => $this->url,
            'ubicacion' => $this->ubicacion,
            'ubicacion_lat' => $this->ubicacion_lat,
            'ubicacion_long' => $this->ubicacion_long,
            'status' => $this->status,
            'multimedia_id' => $multimedia_id,
        ]);

        Flux::toast("El espacio ha sido actualizado.");
    }

    public function removeMultimedia()
    {
        if ($this->multimedia_id && $this->space->multimedia) {
            Storage::disk('public')->delete($this->space->multimedia->filename);
            $this->space->multimedia->delete();

            $this->space->update(['multimedia_id' => null]);
            $this->multimedia_id = null;

            Flux::toast("Imagen eliminada correctamente.");
        }
    }

    public function cancel()
    {
        return redirect()->route('admin.spaces.index');
    }

    #[Computed]
    public function currentMultimedia()
    {
        return $this->space->multimedia;
    }

    public function render(): View
    {
        return view('livewire.admin.space.edit');
    }
}
