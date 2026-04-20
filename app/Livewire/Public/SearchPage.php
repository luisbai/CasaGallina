<?php

namespace App\Livewire\Public;

use App\Modules\Exhibition\Infrastructure\Models\Exhibition;
use App\Modules\News\Infrastructure\Models\Noticia;
use App\Modules\Program\Infrastructure\Models\Program;
use App\Modules\Publication\Infrastructure\Models\Publication;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class SearchPage extends Component
{
    use WithPagination;

    protected string $paginationView = 'components.pagination';

    public $query = '';
    public $filter = 'all'; // all, noticias, programas, publicaciones
    public $perPage = 12;
    public $language = 'es';

    protected $queryString = [
        'query' => ['except' => ''],
        'filter' => ['except' => 'all'],
    ];

    public function mount($query = '', $language = 'es')
    {
        // Accept query and language as props from parent view
        $this->query = $query ?: request()->get('q', '');
        $this->language = $language;

    }

    public function updatingQuery()
    {
        $this->resetPage();
    }

    public function updatingFilter()
    {
        $this->resetPage();
    }

    public function filterBy($type)
    {
        $this->filter = $type;
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->filter = 'all';
        $this->resetPage();
    }

    public function getSearchResults()
    {
        if (empty($this->query)) {
            return collect();
        }

        $results = collect();
        $searchTerm = '%' . $this->query . '%';

        // Search Noticias
        if ($this->filter === 'all' || $this->filter === 'noticias') {
            $noticias = Noticia::with(['multimedia', 'tags'])
                ->activa()
                ->where(function($q) use ($searchTerm) {
                    $q->where('titulo', 'like', $searchTerm)
                      ->orWhere('contenido', 'like', $searchTerm)
                      ->orWhere('descripcion', 'like', $searchTerm);
                })
                ->get()
                ->map(function($noticia) {
                    return [
                        'id' => $noticia->id,
                        'type' => 'noticia',
                        'title' => strip_tags($noticia->titulo),
                        'excerpt' => $noticia->excerpt,
                        'image' => $noticia->featured_image ? asset('storage/' . $noticia->featured_image->filename) : null,
                        'url' => $this->language === 'en'
                            ? url('/en/news/' . $noticia->slug)
                            : url('/noticia/' . $noticia->slug),
                        'created_at' => $noticia->fecha_publicacion ?? $noticia->created_at,
                    ];
                });
            $results = $results->merge($noticias);
        }

        // Search Programas
        if ($this->filter === 'all' || $this->filter === 'programas') {
            $programas = Program::with(['multimedia.multimedia', 'tags.multimedia', 'destacada_multimedia_direct'])
                ->where(function($q) use ($searchTerm) {
                    $q->where('titulo', 'like', $searchTerm)
                      ->orWhere('contenido', 'like', $searchTerm)
                      ->orWhere('metadatos', 'like', $searchTerm);
                })
                ->get()
                ->map(function($programa) {
                    // Find the appropriate tag for URL generation
                    $localTag = $programa->tags->where('type', 'programa-local')->first();
                    $externaTag = $programa->tags->where('type', 'programa-externo')->first();

                    $estrategiaTipo = $localTag ? 'local' : 'externa';
                    $tag = $localTag ?: $externaTag;
                    $tagSlug = $tag ? $tag->slug : 'sin-categoria';

                    // Clean title for display
                    $cleanTitle = strip_tags($programa->titulo);

                    // Debug logging for programa
                    \Log::info('Programa Search Debug', [
                        'id' => $programa->id,
                        'original_title' => $programa->titulo,
                        'clean_title' => $cleanTitle,
                        'estrategia_tipo' => $estrategiaTipo,
                        'tag_slug' => $tagSlug,
                        'tag_texto' => $tag?->texto,
                        'tag_has_multimedia' => $tag && $tag->multimedia ? true : false,
                        'tag_multimedia_filename' => $tag?->multimedia?->filename,
                        'tags_count' => $programa->tags->count()
                    ]);

                    // Get the first image from programa's multimedia gallery
                    $firstImage = $programa->multimedia->first();
                    $imageUrl = null;
                    if ($firstImage && $firstImage->multimedia) {
                        $imageUrl = asset('storage/' . $firstImage->multimedia->filename);
                    }

                    return [
                        'id' => $programa->id,
                        'type' => 'programa',
                        'title' => $cleanTitle,
                        'excerpt' => Str::limit(strip_tags($programa->metadatos ?? $programa->contenido), 150),
                        'image' => $imageUrl,
                        'url' => $this->language === 'en'
                            ? url('/en/program/' . ($estrategiaTipo === 'local' ? 'local-strategy' : 'external-strategy') . '/' . $tagSlug)
                            : url('/programa/estrategia-' . $estrategiaTipo . '/' . $tagSlug),
                        'created_at' => $programa->created_at,
                    ];
                });
            $results = $results->merge($programas);
        }

        // Search Exhibitions
        if ($this->filter === 'all' || $this->filter === 'exposiciones') {
            $exposiciones = Exhibition::where('estado', 'public')
                ->where(function($q) use ($searchTerm) {
                    $q->where('titulo', 'like', $searchTerm)
                      ->orWhere('contenido', 'like', $searchTerm)
                      ->orWhere('metadatos', 'like', $searchTerm);
                })
                ->get()
                ->map(function($exposicion) {
                    return [
                        'id' => $exposicion->id,
                        'type' => 'exposicion',
                        'title' => strip_tags($exposicion->titulo),
                        'excerpt' => Str::limit(strip_tags($exposicion->metadatos ?? $exposicion->contenido), 150),
                        'image' => $exposicion->featured_multimedia_direct ? asset('storage/' . $exposicion->featured_multimedia_direct->filename) : null,
                        'url' => $this->language === 'en'
                            ? url('/en/exhibition/' . $exposicion->slug)
                            : url('/exposicion/' . $exposicion->slug),
                        'created_at' => $exposicion->fecha ?? $exposicion->created_at,
                    ];
                });
            $results = $results->merge($exposiciones);
        }

        // Search Publicaciones
        if ($this->filter === 'all' || $this->filter === 'publicaciones') {
            $titleField = $this->language === 'en' ? 'titulo_en' : 'titulo';
            $textField = $this->language === 'en' ? 'textos_en' : 'textos';
            $synopsisField = $this->language === 'en' ? 'sinopsis_en' : 'sinopsis';

            $publicaciones = Publication::with(['publicacion_multimedia', 'publicacion_thumbnail'])
                ->where('status', 'public')
                ->where(function($q) use ($searchTerm, $titleField, $textField, $synopsisField) {
                    $q->whereRaw("LOWER(REPLACE(REPLACE(REPLACE(REPLACE($titleField, '&iacute;', 'í'), '&aacute;', 'á'), '&eacute;', 'é'), '&oacute;', 'ó')) LIKE LOWER(?)", [$searchTerm])
                      ->orWhereRaw("LOWER(REPLACE(REPLACE(REPLACE(REPLACE($textField, '&iacute;', 'í'), '&aacute;', 'á'), '&eacute;', 'é'), '&oacute;', 'ó')) LIKE LOWER(?)", [$searchTerm])
                      ->orWhereRaw("LOWER(REPLACE(REPLACE(REPLACE(REPLACE($synopsisField, '&iacute;', 'í'), '&aacute;', 'á'), '&eacute;', 'é'), '&oacute;', 'ó')) LIKE LOWER(?)", [$searchTerm]);
                })
                ->get()
                ->map(function($publicacion) use ($titleField, $synopsisField) {
                    return [
                        'id' => $publicacion->id,
                        'type' => 'publicacion',
                        'title' => html_entity_decode(strip_tags($publicacion->$titleField), ENT_QUOTES, 'UTF-8'),
                        'excerpt' => Str::limit(html_entity_decode(strip_tags($publicacion->$synopsisField), ENT_QUOTES, 'UTF-8'), 150),
                        'image' => $publicacion->publicacion_thumbnail ? asset('storage/cache/' . $publicacion->publicacion_thumbnail->filename) : null,
                        'url' => $publicacion->url[$this->language],
                        'created_at' => $publicacion->created_at,
                    ];
                });
            $results = $results->merge($publicaciones);
        }

        // Sort by relevance/date
        return $results->sortByDesc('created_at');
    }

    public function render()
    {
        $results = $this->getSearchResults();


        // Paginate the collection
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentResults = $results->slice(($currentPage - 1) * $this->perPage, $this->perPage)->values();

        $paginatedResults = new LengthAwarePaginator(
            $currentResults,
            $results->count(),
            $this->perPage,
            $currentPage,
            [
                'path' => request()->url(),
                'pageName' => 'page',
            ]
        );

        // Get result counts by type
        $typeCounts = [
            'all' => $results->count(),
            'noticias' => $results->where('type', 'noticia')->count(),
            'programas' => $results->where('type', 'programa')->count(),
            'exposiciones' => $results->where('type', 'exposicion')->count(),
            'publicaciones' => $results->where('type', 'publicacion')->count(),
        ];



        return view('livewire.public.search-page', [
            'results' => $paginatedResults,
            'typeCounts' => $typeCounts,
            'hasQuery' => !empty($this->query),
            'totalResults' => $results->count(),
        ]);
    }
}
