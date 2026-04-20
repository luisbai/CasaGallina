<?php

namespace App\Modules\Publication\Presentation\Livewire\Admin;

use App\Modules\Publication\Application\Services\PublicationService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
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

    protected $publicationService;

    public function boot(PublicationService $publicationService)
    {
        $this->publicationService = $publicationService;
    }

    protected array $queryString = [
        'search' => ['except' => ''],
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
    public function publications(): LengthAwarePaginator
    {
        return $this->publicationService->paginate(
            $this->perPage,
            $this->search,
            $this->sortBy,
            $this->sortDirection
        );
    }

    public function delete($id): void
    {
        try {
            $publication = $this->publicationService->find($id);

            if ($publication) {
                $name = strip_tags($publication->titulo);
                // Limit name length for toast
                $shortName = strlen($name) > 30 ? substr($name, 0, 30) . '...' : $name;

                $this->publicationService->delete($id);

                Flux::toast(
                    text: "La publicación ha sido eliminada.",
                    heading: $shortName,
                    variant: 'success'
                );
            }
        } catch (\Exception $e) {
            Flux::toast(
                text: "No se pudo eliminar la publicación.",
                heading: "Error",
                variant: 'danger'
            );
        }
    }

    public function render(): View
    {
        return view('livewire.admin.publication.page');
    }
}
