<?php

namespace App\Livewire\Public;

use App\Modules\News\Infrastructure\Models\Noticia;
use App\Modules\Tag\Infrastructure\Models\Tag;
use Livewire\Component;
use Livewire\WithPagination;

class NoticiasPage extends Component
{
    use WithPagination;

    protected string $paginationView = 'components.pagination';

    public $selectedCategory = 'all';
    public $search = '';
    public $perPage = 9;

    protected $queryString = [
        'selectedCategory' => ['except' => 'all'],
        'search' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedCategory()
    {
        $this->resetPage();
    }

    public function filterByCategory($category)
    {
        $this->selectedCategory = $category;
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->selectedCategory = 'all';
        $this->search = '';
        $this->resetPage();
    }

    public function render()
    {
        $query = Noticia::with(['multimedia', 'tags' => function($query) {
                $query->where('type', 'noticia');
            }, 'archivos', 'videos'])
            ->activa()
            ->recientes();

        // Filter by tag instead of tipo
        if ($this->selectedCategory !== 'all') {
            $query->whereHas('tags', function($q) {
                $q->where('type', 'noticia')
                  ->where('slug', $this->selectedCategory);
            });
        }

        if ($this->search) {
            $query->where(function($q) {
                $q->where('titulo', 'like', '%' . $this->search . '%')
                  ->orWhere('contenido', 'like', '%' . $this->search . '%')
                  ->orWhere('descripcion', 'like', '%' . $this->search . '%');
            });
        }

        $noticias = $query->paginate($this->perPage);

        // Get all news tags for the filter dropdown
        $newsTagsQuery = Tag::where('type', 'noticia')
            ->whereHas('noticias', function($query) {
                $query->where('activo', true);
            })
            ->orderBy('nombre');

        $newsTags = $newsTagsQuery->get();

        // Build categories array for the dropdown
        $categories = ['all' => 'Todas'];
        foreach ($newsTags as $tag) {
            $categories[$tag->slug] = $tag->nombre;
        }

        return view('livewire.public.noticias-page', [
            'noticias' => $noticias,
            'categories' => $categories,
            'newsTags' => $newsTags,
        ]);
    }
}
