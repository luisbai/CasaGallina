<?php

namespace App\Modules\Newsletter\Infrastructure\Repositories;

use App\Modules\Newsletter\Domain\Interfaces\NewsletterRepositoryInterface;
use App\Modules\Newsletter\Infrastructure\Models\Newsletter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class NewsletterRepository implements NewsletterRepositoryInterface
{
    public function paginate(int $perPage, string $search = '', string $sortBy = 'boletin_fecha', string $sortDirection = 'desc'): LengthAwarePaginator
    {
        return Newsletter::query()
            ->when($search, function($query, $search) {
                return $query->whereDate('boletin_fecha', 'like', "%$search%");
            })
            ->orderBy($sortBy, $sortDirection)
            ->paginate($perPage);
    }

    public function find(int $id): ?Newsletter
    {
        return Newsletter::with(['multimedia_es', 'multimedia_en'])->find($id);
    }

    public function create(array $data): Newsletter
    {
        return Newsletter::create($data);
    }

    public function update(Newsletter $newsletter, array $data): bool
    {
        return $newsletter->update($data);
    }

    public function delete(Newsletter $newsletter): bool
    {
        return $newsletter->delete();
    }
}
