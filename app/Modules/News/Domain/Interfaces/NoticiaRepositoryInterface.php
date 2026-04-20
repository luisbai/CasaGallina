<?php

namespace App\Modules\News\Domain\Interfaces;

use App\Modules\News\Infrastructure\Models\Noticia;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface NoticiaRepositoryInterface
{
    public function paginate(int $perPage, string $search = '', string $sortBy = 'fecha_publicacion', string $sortDirection = 'desc'): LengthAwarePaginator;
    public function find(int $id): ?Noticia;
    public function findBySlug(string $slug): ?Noticia;
    public function create(array $data): Noticia;
    public function update(Noticia $noticia, array $data): bool;
    public function delete(Noticia $noticia): bool;
    public function getActive(): Collection;
}
