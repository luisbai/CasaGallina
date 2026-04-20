<?php

namespace App\Modules\Newsletter\Presentation\Livewire\Admin;

use App\Modules\Newsletter\Application\Services\NewsletterService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Computed;
use Flux\Flux;

class Page extends Component
{
    use WithPagination, WithFileUploads;

    public string $sortBy = 'boletin_fecha';
    public string $sortDirection = 'desc';
    public int $perPage = 10;
    public string $search = '';

    // Form fields
    public string $boletin_fecha = '';
    public $multimedia_es = null;
    public $multimedia_en = null;
    public ?int $multimedia_es_id = null;
    public ?int $multimedia_en_id = null;
    public ?int $editId = null;

    protected array $queryString = [
        'search' => ['except' => ''],
        'sortBy' => ['except' => 'boletin_fecha'],
        'sortDirection' => ['except' => 'desc']
    ];

    public function boot(NewsletterService $newsletterService)
    {
        $this->newsletterService = $newsletterService;
    }

    protected NewsletterService $newsletterService;

    public function mount()
    {
        $this->boletin_fecha = now()->format('Y-m-d');
    }

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
    public function boletines(): LengthAwarePaginator
    {
        return $this->newsletterService->getAllNewsletters(
            $this->perPage,
            $this->search,
            $this->sortBy,
            $this->sortDirection
        );
    }

    #[Computed]
    public function currentBoletin()
    {
        if ($this->editId) {
            return $this->newsletterService->getNewsletter($this->editId);
        }
        return null;
    }

    public function delete($id): void
    {
        $newsletter = $this->newsletterService->getNewsletter($id);

        if ($newsletter) {
            $fecha = $newsletter->boletin_fecha->format('Y-m-d');
            
            if ($this->newsletterService->deleteNewsletter($id)) {
                Flux::toast("El boletín del '$fecha' ha sido eliminado.");
            } else {
                Flux::toast("Error al eliminar el boletín.", "danger");
            }
        }
    }

    public function openCreateModal(): void
    {
        $this->resetForm();
        Flux::modal('createBoletin')->show();
    }

    public function cancelCreate(): void
    {
        $this->resetForm();
        Flux::modal('createBoletin')->close();
    }

    public function cancelEdit(): void
    {
        $this->resetForm();
        Flux::modal('editBoletin')->close();
    }

    public function resetForm(): void
    {
        $this->reset([
            'boletin_fecha',
            'multimedia_es',
            'multimedia_en',
            'multimedia_es_id',
            'multimedia_en_id',
            'editId'
        ]);
        
        $this->boletin_fecha = now()->format('Y-m-d');
    }

    public function editBoletin($id): void
    {
        $this->editId = $id;
        $newsletter = $this->newsletterService->getNewsletter($id);

        if ($newsletter) {
            $this->boletin_fecha = $newsletter->boletin_fecha->format('Y-m-d');
            $this->multimedia_es_id = $newsletter->multimedia_es_id;
            $this->multimedia_en_id = $newsletter->multimedia_en_id;
        }

        Flux::modal('editBoletin')->show();
    }

    public function store(): void
    {
        $this->validate([
            'boletin_fecha' => [
                'required',
                'date',
                'unique:boletines,boletin_fecha',
                'before_or_equal:today'
            ],
            'multimedia_es' => 'required|file|mimes:pdf|max:51200', // 50MB max
            'multimedia_en' => 'required|file|mimes:pdf|max:51200', // 50MB max
        ], [
            'boletin_fecha.unique' => 'Ya existe un boletín para esta fecha.',
            'boletin_fecha.before_or_equal' => 'La fecha del boletín no puede ser futura.',
        ]);

        $this->newsletterService->createNewsletter(
            ['boletin_fecha' => $this->boletin_fecha],
            $this->multimedia_es,
            $this->multimedia_en
        );

        Flux::toast("El boletín ha sido creado.");
        Flux::modal('createBoletin')->close();
        $this->resetForm();
    }

    public function update(): void
    {
        $this->validate([
            'boletin_fecha' => [
                'required',
                'date',
                'unique:boletines,boletin_fecha,' . $this->editId,
                'before_or_equal:today'
            ],
            'multimedia_es' => 'nullable|file|mimes:pdf|max:51200',
            'multimedia_en' => 'nullable|file|mimes:pdf|max:51200',
        ], [
            'boletin_fecha.unique' => 'Ya existe un boletín para esta fecha.',
            'boletin_fecha.before_or_equal' => 'La fecha del boletín no puede ser futura.',
        ]);

        // Validate that at least one PDF exists or is being uploaded
        if (!$this->multimedia_es && !$this->multimedia_en && !$this->multimedia_es_id && !$this->multimedia_en_id) {
            $this->addError('multimedia_es', 'Debe proporcionar al menos un PDF (español o inglés).');
            return;
        }

        if ($this->editId) {
            $this->newsletterService->updateNewsletter(
                $this->editId,
                ['boletin_fecha' => $this->boletin_fecha],
                $this->multimedia_es,
                $this->multimedia_en
            );

            Flux::toast("El boletín ha sido actualizado.");
            Flux::modal('editBoletin')->close();
            $this->resetForm();
        }
    }

    public function removePDF($language): void
    {
        if ($this->editId) {
            if ($this->newsletterService->removeFile($this->editId, $language)) {
                $multimedia_id_field = "multimedia_{$language}_id";
                $this->$multimedia_id_field = null;
                
                $lang_name = $language === 'es' ? 'español' : 'inglés';
                Flux::toast("PDF en $lang_name eliminado correctamente.");
            }
        }
    }

    public function downloadPDF($newsletterId, $language)
    {
        $newsletter = $this->newsletterService->getNewsletter($newsletterId);
        
        if ($newsletter) {
            $multimedia_field = "multimedia_{$language}";
            
            if ($newsletter->$multimedia_field) {
                $path = storage_path('app/public/' . $newsletter->$multimedia_field->filename);
                
                if (file_exists($path)) {
                    return response()->download($path);
                }
            }
        }
        
        Flux::toast("Archivo no encontrado.", 'error');
        return null;
    }

    public function render(): View
    {
        return view('livewire.admin.newsletter.page'); // Renamed view
    }
}
