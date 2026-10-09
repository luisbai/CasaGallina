<?php

namespace App\Modules\Contact\Presentation\Livewire\Admin;

use App\Modules\Contact\Application\Services\ContactService;
use Flux\Flux;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use App\Modules\Contact\Infrastructure\Models\Lead;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

    public function exportLeads(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $fileName = 'leads_casagallina_' . now()->format('Y_m_d') . '.csv';

        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');

            fputs($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
                'ID',
                'Fecha',
                'Nombre',
                'Email',
                'Teléfono',
                'Organización',
                'Formulario / Origen',
                'Mensaje / Publicación',
                'Newsletter',
            ]);

            $submissions = $this->contactService->paginate(
                10000,
                $this->search,
                $this->filterType,
                'created_at',
                'desc'
            );

            foreach ($submissions as $item) {
                $metadata = is_array($item->metadata)
                    ? $item->metadata
                    : json_decode($item->metadata ?? '[]', true);


                $publicacion = $item->publication?->titulo ?? null;

                $mensaje = $metadata['mensaje']
                    ?? ($metadata['message']
                    ?? ($publicacion ? 'Descarga: ' . $publicacion : 'Sin mensaje'));

                $newsletterStatus = ($item->subscribed_to_mailrelay ?? false)
                    ? 'Suscrito'
                    : 'No suscrito';

                fputcsv($handle, [
                    $item->id,
                    $item->created_at ? $item->created_at->format('d/m/Y H:i') : '',
                    $item->nombre ?? '',
                    $item->email ?? '',
                    $item->telefono ?? '',
                    $item->organizacion ?? '',
                    $item->form_type ?? '',
                    $mensaje,
                    $newsletterStatus,
                ]);
            }

            fclose($handle);
        }, $fileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}

