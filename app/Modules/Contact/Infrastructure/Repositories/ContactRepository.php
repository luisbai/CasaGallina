<?php

namespace App\Modules\Contact\Infrastructure\Repositories;

use App\Modules\Contact\Domain\Interfaces\ContactRepositoryInterface;
use App\Modules\Contact\Infrastructure\Models\ContactSubmission;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ContactRepository implements ContactRepositoryInterface
{
    public function paginate(int $perPage = 15, string $search = '', string $filterType = '', string $sortBy = 'created_at', string $sortDirection = 'desc'): LengthAwarePaginator
    {
        return ContactSubmission::query()
            ->with('publication')
            ->when($search, function($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('nombre', 'like', "%$search%")
                      ->orWhere('email', 'like', "%$search%")
                      ->orWhere('telefono', 'like', "%$search%")
                      ->orWhere('organizacion', 'like', "%$search%");
                });
            })
            ->when($filterType, function($query, $type) {
                return $query->where('form_type', $type);
            })
            ->orderBy($sortBy, $sortDirection)
            ->paginate($perPage);
    }

    public function find(int $id): ?ContactSubmission
    {
        return ContactSubmission::find($id);
    }

    public function create(array $data): ContactSubmission
    {
        return ContactSubmission::create($data);
    }

    public function update(ContactSubmission $submission, array $data): bool
    {
        return $submission->update($data);
    }

    public function delete(ContactSubmission $submission): bool
    {
        return $submission->delete();
    }
}
