<?php

namespace App\Modules\News\Infrastructure\Repositories;

use App\Modules\News\Infrastructure\Models\Noticia;
use App\Modules\News\Domain\Interfaces\NoticiaRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class NoticiaRepository implements NoticiaRepositoryInterface
{
    public function paginate(int $perPage, string $search = '', string $sortBy = 'fecha_publicacion', string $sortDirection = 'desc'): LengthAwarePaginator
    {
        return Noticia::query()
            ->when($search, function($query, $search) {
                return $query->where('titulo', 'like', "%{$search}%");
            })
            ->orderBy($sortBy, $sortDirection)
            ->paginate($perPage);
    }

    public function find(int $id): ?Noticia
    {
        return Noticia::with(['multimedia', 'tags', 'archivos', 'videos', 'donaciones'])->find($id);
    }

    public function findBySlug(string $slug): ?Noticia
    {
        return Noticia::with(['multimedia', 'tags', 'archivos', 'videos', 'donaciones'])
            ->where('slug', $slug)
            ->first();
    }

    public function create(array $data): Noticia
    {
        return Noticia::create($data);
    }

    public function update(Noticia $noticia, array $data): bool
    {
        return $noticia->update($data);
    }

    public function delete(Noticia $noticia): bool
    {
        return $noticia->delete();
    }

    public function getActive(): Collection
    {
        return Noticia::activa()->recientes()->get();
    }
}
