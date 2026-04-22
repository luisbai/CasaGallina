<?php

namespace App\Modules\Publication\Domain\Interfaces;

use App\Modules\Publication\Infrastructure\Models\Publication;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface PublicationRepositoryInterface
{
    public function all(): Collection;
    
    public function paginate(int $perPage = 15, string $search = '', string $sortBy = 'created_at', string $sortDirection = 'desc'): LengthAwarePaginator;
    
    public function find(int $id): ?Publication;

    public function findBySlug(string $slug): ?Publication;
    
    public function create(array $data): Publication;
    
    public function update(Publication $publication, array $data): bool;
    
    public function delete(Publication $publication): bool;

    public function getPublic(string $type = null): Collection;
}
