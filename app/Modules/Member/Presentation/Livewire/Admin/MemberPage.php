<?php

namespace App\Modules\Member\Presentation\Livewire\Admin;

use App\Modules\Member\Infrastructure\Models\Member;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Flux\Flux;

class MemberPage extends Component
{
    use WithPagination;

    public string $sortBy = 'orden';
    public string $sortDirection = 'asc';
    public int $perPage = 10;
    public string $search = '';
    public string $filterTipo = '';

    // Form fields
    public string $nombre = '';
    public string $titulo = '';
    public string $biografia = '';
    public string $titulo_en = '';
    public string $biografia_en = '';
    public string $tipo = '';
    public ?int $orden = 0;
    public ?int $editId = null;
    public ?int $editingOrderId = null;

    public ?string $translationError = null;

    // Available types for team members
    public array $tipoOptions = [
        'equipo' => 'Equipo',
        'presidente' => 'Presidente',
        'directivos' => 'Directivos',
        'patronos' => 'Patronos',
        'honorarios' => 'Honorarios'
    ];

    protected array $queryString = [
        'search' => ['except' => ''],
        'filterTipo' => ['except' => ''],
        'sortBy' => ['except' => 'orden'],
        'sortDirection' => ['except' => 'asc']
    ];

    public function mount()
    {
        $this->orden = $this->getNextOrder();
    }

    private function getNextOrder(): int
    {
        return (Member::max('orden') ?? 0) + 1;
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
    public function members(): LengthAwarePaginator
    {
        return Member::query()
            ->when($this->search, function ($query, $search) {
                return $query->where('nombre', 'like', "%$search%")
                    ->orWhere('titulo', 'like', "%$search%")
                    ->orWhere('titulo_en', 'like', "%$search%");
            })
            ->when($this->filterTipo, function ($query, $tipo) {
                return $query->where('tipo', $tipo);
            })
            ->orderByRaw("FIELD(tipo, 'equipo', 'directivos', 'presidente', 'patronos', 'honorarios')") // Custom sort or just alpha
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);
    }

    #[Computed]
    public function currentMember()
    {
        if ($this->editId) {
            return Member::find($this->editId);
        }
        return null;
    }

    public function delete($id): void
    {
        $member = Member::find($id);

        if ($member) {
            $nombre = $member->nombre;
            $member->delete();

            Flux::toast("El miembro '$nombre' ha sido eliminado.");
        }
    }

    public function openCreateModal(): void
    {
        $this->translationError = null;
        $this->resetForm();
        $this->orden = $this->getNextOrder();
        Flux::modal('createMember')->show();
    }

    public function cancelCreate(): void
    {
        $this->resetForm();
        Flux::modal('createMember')->close();
    }

    public function cancelEdit(): void
    {
        $this->resetForm();
        Flux::modal('editMember')->close();
    }

    public function resetForm(): void
    {
        $this->reset([
            'nombre',
            'titulo',
            'biografia',
            'titulo_en',
            'biografia_en',
            'tipo',
            'orden',
            'editId',
            'translationError'
        ]);
    }

    public function editMember($id): void
    {
        $this->translationError = null;
        $this->editId = $id;
        $member = Member::find($id);

        if ($member) {
            $this->nombre = $member->nombre;
            $this->titulo = $member->titulo ?? '';
            $this->biografia = $member->biografia ?? '';
            $this->titulo_en = $member->titulo_en ?? '';
            $this->biografia_en = $member->biografia_en ?? '';
            $this->tipo = $member->tipo;
            $this->orden = $member->orden ?? 0;
        }

        Flux::modal('editMember')->show();
    }

    public function store(): void
    {
        $this->validate([
            'nombre' => 'required|min:2|max:255',
            'titulo' => 'nullable|min:3|max:255',
            'biografia' => 'nullable|min:10|max:2000',
            'titulo_en' => 'nullable|min:3|max:255',
            'biografia_en' => 'nullable|min:10|max:2000',
            'tipo' => 'required|in:' . implode(',', array_keys($this->tipoOptions)),
            'orden' => 'required|integer|min:1|unique:equipo_miembros,orden',
        ], [
            'orden.unique' => 'Ya existe un miembro con este número de orden. Por favor, elige otro número.',
        ]);

        Member::create([
            'nombre' => $this->nombre,
            'titulo' => $this->titulo,
            'biografia' => $this->biografia,
            'titulo_en' => $this->titulo_en,
            'biografia_en' => $this->biografia_en,
            'tipo' => $this->tipo,
            'orden' => $this->orden,
        ]);

        Flux::toast("El miembro ha sido creado.");
        Flux::modal('createMember')->close();
        $this->resetForm();
    }

    public function update(): void
    {
        $this->validate([
            'nombre' => 'required|min:2|max:255',
            'titulo' => 'nullable|min:3|max:255',
            'biografia' => 'nullable|min:10|max:2000',
            'titulo_en' => 'nullable|min:3|max:255',
            'biografia_en' => 'nullable|min:10|max:2000',
            'tipo' => 'required|in:' . implode(',', array_keys($this->tipoOptions)),
            'orden' => 'required|integer|min:1|unique:equipo_miembros,orden,' . $this->editId,
        ], [
            'orden.unique' => 'Ya existe un miembro con este número de orden. Por favor, elige otro número.',
        ]);

        $member = Member::find($this->editId);

        if ($member) {
            $member->update([
                'nombre' => $this->nombre,
                'titulo' => $this->titulo,
                'biografia' => $this->biografia,
                'titulo_en' => $this->titulo_en,
                'biografia_en' => $this->biografia_en,
                'tipo' => $this->tipo,
                'orden' => $this->orden,
            ]);

            Flux::toast("El miembro ha sido actualizado.");
            Flux::modal('editMember')->close();
            $this->resetForm();
        }
    }

    public function moveUp($id): void
    {
        $member = Member::find($id);
        if ($member && $member->orden > 1) {
            $previousMember = Member::where('orden', $member->orden - 1)->first();
            if ($previousMember) {
                $previousMember->update(['orden' => $member->orden]);
                $member->update(['orden' => $member->orden - 1]);
                Flux::toast("Orden actualizado.");
            }
        }
    }

    public function moveDown($id): void
    {
        $member = Member::find($id);
        $maxOrder = Member::max('orden');

        if ($member && $member->orden < $maxOrder) {
            $nextMember = Member::where('orden', $member->orden + 1)->first();
            if ($nextMember) {
                $nextMember->update(['orden' => $member->orden]);
                $member->update(['orden' => $member->orden + 1]);
                Flux::toast("Orden actualizado.");
            }
        }
    }

    public function toggleOrderEdit($id): void
    {
        $this->editingOrderId = $this->editingOrderId === $id ? null : $id;
    }

    public function translateMember(\App\Modules\Shared\Application\Services\GeminiTranslationService $translator): void
    {
        $this->translationError = null;

        try {
            if ($this->titulo) {
                $this->titulo_en = $translator->translate($this->titulo) ?? $this->titulo_en;
            }

            if ($this->biografia) {
                $this->biografia_en = $translator->translate($this->biografia) ?? $this->biografia_en;
            }

            Flux::toast(
                heading: 'Traducción completada',
                text: 'La biografía y el título han sido traducidos.',
                variant: 'success'
            );
        } catch (\Exception $e) {
            \Log::error('Member Translation Error:', ['message' => $e->getMessage()]);
            $this->translationError = 'Error de traducción: ' . $e->getMessage();
            Flux::toast(
                heading: 'Error de traducción',
                text: $e->getMessage(),
                variant: 'danger'
            );
        }
    }

    public function render(): View
    {
        return view('livewire.admin.member.page');
    }
}
