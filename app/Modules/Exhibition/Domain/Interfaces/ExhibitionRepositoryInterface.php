<?php

namespace App\Modules\Exhibition\Domain\Interfaces;

use App\Modules\Exhibition\Infrastructure\Models\Exhibition;

interface ExhibitionRepositoryInterface
{
    public function paginate(int $perPage, string $search = '', string $sortBy = 'created_at', string $sortDirection = 'desc');
    public function getPublic(string $type = null);
    public function find(int $id): ?Exhibition;
    public function findBySlug(string $slug): ?Exhibition;
    public function create(array $data): Exhibition;
    public function update(Exhibition $exhibition, array $data): bool;
    public function delete(Exhibition $exhibition): bool;
}
