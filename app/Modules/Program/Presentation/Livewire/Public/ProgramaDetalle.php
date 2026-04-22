<?php

namespace App\Modules\Program\Presentation\Livewire\Public;

use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Modules\Tag\Infrastructure\Models\Tag;
use App\Modules\Program\Infrastructure\Models\Program;

class ProgramaDetalle extends Component
{
    public string $slug;
    public string $route_tipo;
    public ?Tag $categoria = null;
    public ?int $selectedYear = null;
    public array $sidebarContent = [];

    public function mount(string $slug, string $route_tipo)
    {
        $this->slug = $slug;
        $this->route_tipo = $route_tipo;

        // If route_tipo is 'tag', find the tag by slug
        if ($route_tipo === 'tag') {
            $this->categoria = Tag::with(['multimedia', 'thumbnail'])
                ->where('slug', $slug)
                ->whereIn('type', ['programa-local', 'programa-externo'])
                ->firstOrFail();
        } 
        // If route_tipo is 'programa-local' or 'programa-externa', find tag by slug and type
        elseif (in_array($route_tipo, ['programa-local', 'programa-externa'])) {
            $type = $route_tipo === 'programa-externa' ? 'programa-externo' : 'programa-local';
            
            $this->categoria = Tag::with(['multimedia', 'thumbnail'])
                ->where('slug', $slug)
                ->where('type', $type)
                ->firstOrFail();
        }

        // Parse sidebar content
        $this->parseSidebarContent();
    }

    protected function parseSidebarContent(): void
    {
        if (!$this->categoria || !$this->categoria->sidebar) {
            return;
        }

        $sidebar = $this->categoria->sidebar;
        
        // Parse Aliados
        if (preg_match('/ALIADOS:(.*?)(?=COLABORADORES:|$)/s', $sidebar, $matches)) {
            $aliados = array_filter(array_map('trim', explode(';', $matches[1])));
            if (!empty($aliados)) {
                $this->sidebarContent['aliados'] = $aliados;
            }
        }

        // Parse Colaboradores
        if (preg_match('/COLABORADORES:(.*?)$/s', $sidebar, $matches)) {
            $colaboradores = array_filter(array_map('trim', explode(';', $matches[1])));
            if (!empty($colaboradores)) {
                $this->sidebarContent['colaboradores'] = $colaboradores;
            }
        }
    }

    #[Computed]
    public function programas()
    {
        if (!$this->categoria) {
            return collect();
        }

        $query = $this->categoria->programas()
            ->with(['multimedia.multimedia', 'tags'])
            ->where('estado', 'public');

        // Filter by year if selected
        if ($this->selectedYear) {
            $query->whereRaw('CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(fecha, "-", 1), "-", -1) AS UNSIGNED) = ?', [$this->selectedYear]);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    #[Computed]
    public function anosDisponibles()
    {
        if (!$this->categoria) {
            return collect();
        }

        $programas = $this->categoria->programas()
            ->where('estado', 'public')
            ->whereNotNull('fecha')
            ->get();

        $years = collect();
        
        foreach ($programas as $programa) {
            $yearFromFecha = $programa->year_from_fecha;
            if ($yearFromFecha) {
                if (is_array($yearFromFecha)) {
                    foreach ($yearFromFecha as $year) {
                        $years->push($year);
                    }
                } else {
                    $years->push($yearFromFecha);
                }
            }
        }

        return $years->unique()->sort()->values();
    }

    #[Computed]
    public function totalActividades()
    {
        if (!$this->categoria) {
            return 0;
        }

        return $this->categoria->programas()
            ->where('estado', 'public')
            ->count();
    }

    public function filterByYear(int $year): void
    {
        $this->selectedYear = $year;
    }

    public function clearFilter(): void
    {
        $this->selectedYear = null;
    }

    public function render()
    {
        return view('livewire.public.programa-detalle');
    }
}
