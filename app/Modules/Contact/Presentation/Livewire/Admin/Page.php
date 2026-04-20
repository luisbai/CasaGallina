<?php

namespace App\Modules\Contact\Presentation\Livewire\Admin;

use App\Modules\Contact\Application\Services\ContactService;
use Flux\Flux;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;

class Page extends Component
{
    use WithPagination;

    public string $sortBy = 'created_at';
    public string $sortDirection = 'desc';
    public int $perPage = 15;
    public string $search = '';
    public string $filterType = '';

    protected $contactService;

    public function boot(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    protected array $queryString = [
        'search' => ['except' => ''],
        'filterType' => ['except' => ''],
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

    public string $currentSubject = '';
    public string $currentMessage = '';

    public function delete(int $id): void
    {
        if ($this->contactService->delete($id)) {
            Flux::toast('Registro eliminado exitosamente.');
        }
    }

    public function viewDetails(int $id): void
    {
        $submission = $this->contactService->find($id);
        
        if ($submission) {
            $this->currentSubject = 'Mensaje de ' . $submission->nombre;
            
            $metadata = is_array($submission->metadata) ? $submission->metadata : json_decode($submission->metadata, true) ?? [];
            $this->currentMessage = $metadata['mensaje'] ?? ($metadata['message'] ?? 'Sin mensaje');
            
            Flux::modal('messageDetails')->show();
        }
    }

    public function closeMessageDetails(): void
    {
        Flux::modal('messageDetails')->close();
    }

    public function subscribeToNewsletter(int $id): void
    {
        $result = $this->contactService->subscribeToNewsletter($id);
        
        Flux::toast($result['message'], $result['type'] ?? 'info');
    }

    #[Computed]
    public function submissions(): LengthAwarePaginator
    {
        return $this->contactService->paginate(
            $this->perPage, 
            $this->search, 
            $this->filterType, 
            $this->sortBy, 
            $this->sortDirection
        );
    }

    public function render(): View
    {
        return view('livewire.admin.contact-submission.page');
    }
}
