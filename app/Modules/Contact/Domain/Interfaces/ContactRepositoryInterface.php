<?php

namespace App\Modules\Contact\Domain\Interfaces;

use App\Modules\Contact\Infrastructure\Models\ContactSubmission;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ContactRepositoryInterface
{
    public function paginate(int $perPage = 15, string $search = '', string $filterType = '', string $sortBy = 'created_at', string $sortDirection = 'desc'): LengthAwarePaginator;
    public function find(int $id): ?ContactSubmission;
    public function create(array $data): ContactSubmission;
    public function update(ContactSubmission $submission, array $data): bool;
    public function delete(ContactSubmission $submission): bool;
}
