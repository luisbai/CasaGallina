<?php

namespace App\Livewire\Components;

use App\Modules\Space\Infrastructure\Models\Space as Espacio;
use Livewire\Component;
use Livewire\Attributes\On;

class CartografiaMap extends Component
{
    public ?array $selectedEspacio = null;
    public string $language = 'es';

    public function mount(): void
    {
        // Detect language from current route
        $routeName = request()->route() ? request()->route()->getName() : '';
        if ($routeName && str_starts_with($routeName, 'english.')) {
            $this->language = 'en';
        }
    }

    #[On('markerSelected')]
    public function markerSelected($espacioId): void
    {
        if ($espacioId) {
            $espacio = Espacio::with('estrategias')->find($espacioId);
            if ($espacio) {
                $this->selectedEspacio = $espacio->toArray();
            }
        }
    }

    public function clearSelection(): void
    {
        $this->selectedEspacio = null;
    }

    public function getEspaciosProperty()
    {
        return Espacio::orderBy('created_at', 'DESC')->with('estrategias')->get();
    }

    public function render()
    {
        return view('livewire.components.cartografia-map', [
            'espacios' => $this->espacios
        ]);
    }
}