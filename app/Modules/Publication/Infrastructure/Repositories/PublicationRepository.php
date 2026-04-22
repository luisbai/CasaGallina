<?php

namespace App\Modules\Publication\Infrastructure\Repositories;

use App\Modules\Publication\Domain\Interfaces\PublicationRepositoryInterface;
use App\Modules\Publication\Infrastructure\Models\Publication;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class PublicationRepository implements PublicationRepositoryInterface
{
    public function all(): Collection
    {
        return Publication::with(['multimedia', 'thumbnail', 'exhibition'])->get();
    }

    public function paginate(int $perPage = 15, string $search = '', string $sortBy = 'created_at', string $sortDirection = 'desc'): LengthAwarePaginator
    {
        return Publication::with(['exhibition'])
            ->when($search, function ($query, $search) {
                return $query->where('titulo', 'like', "%{$search}%")
                    ->orWhere('titulo_en', 'like', "%{$search}%");
            })
            ->orderBy($sortBy, $sortDirection)
            ->paginate($perPage);
    }

    public function find(int $id): ?Publication
    {
        return Publication::with(['multimedia', 'thumbnail', 'exhibition'])->find($id);
    }

    public function findBySlug(string $slug): ?Publication
    {
        // Note: Slugs are generated dynamically in Accessors, query by title? 
        // Or better, rely on ID as current routing uses ID too.
        // Implementation plan suggested ID usage, keeping it simple.
        return null;
    }

    public function create(array $data): Publication
    {
        return Publication::create($data);
    }

    public function update(Publication $publication, array $data): bool
    {
        return $publication->update($data);
    }

    public function delete(Publication $publication): bool
    {
        return $publication->delete();
    }

    public function getPublic(string $type = null): Collection
    {
        return Publication::where('status', 'public')
            ->when($type, function ($query) use ($type) {
                return $query->where('tipo', $type);
            })
            ->orderBy('orden', 'ASC')
            ->get();
    }
}
