<?php

namespace App\Modules\Exhibition\Presentation\Livewire\Admin;

use App\Modules\Exhibition\Application\Services\ExhibitionService;
use App\Modules\Exhibition\Infrastructure\Models\Exhibition;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Flux\Flux;

class Page extends Component
{
    use WithPagination;

    public string $sortBy = 'created_at';
    public string $sortDirection = 'desc';
    public int $perPage = 10;
    public string $search = '';

    protected $listeners = ['refresh' => '$refresh'];

    public function boot(ExhibitionService $service)
    {
        $this->service = $service;
    }

    protected ExhibitionService $service;

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
    public function exhibitions()
    {
        return $this->service->paginate($this->perPage, $this->search, $this->sortBy, $this->sortDirection);
    }

    public function delete($id): void
    {
        $this->service->delete($id);
        Flux::toast("Exposición eliminada correctamente.");
    }

    public function render(): View
    {
        return view('livewire.admin.exhibition.page', [
            'exhibitions' => $this->exhibitions
        ]);
    }
}
