<?php

namespace App\Modules\Newsletter\Domain\Interfaces;

use App\Modules\Newsletter\Infrastructure\Models\Newsletter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface NewsletterRepositoryInterface
{
    public function paginate(int $perPage, string $search = '', string $sortBy = 'boletin_fecha', string $sortDirection = 'desc'): LengthAwarePaginator;
    public function find(int $id): ?Newsletter;
    public function create(array $data): Newsletter;
    public function update(Newsletter $newsletter, array $data): bool;
    public function delete(Newsletter $newsletter): bool;
}
