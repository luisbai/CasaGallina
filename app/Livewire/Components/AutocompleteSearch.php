<?php

namespace App\Livewire\Components;

use App\Modules\Exhibition\Infrastructure\Models\Exhibition;
use Livewire\Component;
use Livewire\Attributes\Computed;

class AutocompleteSearch extends Component
{
    public string $search = '';
    public ?int $selectedId = null;
    public string $selectedTitle = '';
    public bool $showDropdown = false;
    public string $placeholder = 'Search exposiciones and proyectos artisticos...';
    public string $name = 'exposicion_search';

    public function mount(?int $selectedId = null, string $placeholder = '')
    {
        $this->selectedId = $selectedId;
        
        if ($this->selectedId) {
            $exposicion = Exhibition::find($this->selectedId);
            
            if ($exposicion) {
                $this->selectedTitle = strip_tags($exposicion->titulo);
                $this->search = $this->selectedTitle;
            }
        }
        
        if ($placeholder) {
            $this->placeholder = $placeholder;
        }
    }

    public function updatedSearch()
    {
        $this->showDropdown = !empty($this->search);
        
        // Clear selection if search doesn't match selected title
        if ($this->search !== $this->selectedTitle) {
            $this->selectedId = null;
            $this->selectedTitle = '';
        }
    }

    public function selectItem($id, $title)
    {
        $this->selectedId = $id;
        $this->selectedTitle = $title;
        $this->search = $title;
        $this->showDropdown = false;
        
        // Dispatch event to parent component
        $this->dispatch('exposicion-selected', id: $id, title: $title);
    }

    public function clearSelection()
    {
        $this->selectedId = null;
        $this->selectedTitle = '';
        $this->search = '';
        $this->showDropdown = false;
        
        // Dispatch event to parent component
        $this->dispatch('exposicion-selected', id: null, title: '');
    }

    public function focusInput()
    {
        $this->showDropdown = !empty($this->search);
    }

    public function hideDropdown()
    {
        // Small delay to allow click events to fire before hiding
        $this->js('setTimeout(() => { $wire.showDropdown = false; }, 150)');
    }

    #[Computed]
    public function results()
    {
        if (empty($this->search) || strlen($this->search) < 2) {
            return collect([]);
        }

        return Exhibition::where('titulo', 'like', '%' . $this->search . '%')
            ->where('estado', 'public')
            ->select('id', 'titulo', 'type')
            ->orderBy('titulo')
            ->limit(10)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'titulo' => strip_tags($item->titulo),
                    'type' => $item->type === 'proyecto-artistico' ? 'Proyecto Artístico' : 'Exposición'
                ];
            });
    }

    public function render()
    {
        return view('livewire.components.autocomplete-search');
    }
}