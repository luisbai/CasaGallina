<?php

namespace App\Modules\Exhibition\Infrastructure\Repositories;

use App\Modules\Exhibition\Domain\Interfaces\ExhibitionRepositoryInterface;
use App\Modules\Exhibition\Infrastructure\Models\Exhibition;

class ExhibitionRepository implements ExhibitionRepositoryInterface
{
    public function paginate(int $perPage, string $search = '', string $sortBy = 'created_at', string $sortDirection = 'desc')
    {
        return Exhibition::query()
            ->when($search, function($query, $search) {
                return $query->where('titulo', 'like', "%$search%");
            })
            ->orderBy($sortBy, $sortDirection)
            ->paginate($perPage);
    }

    public function getPublic(string $type = null)
    {
        return Exhibition::where('estado', 'public')
            ->when($type, function($query, $type) {
                return $query->where('type', $type);
            })
            ->with(['featured_multimedia.multimedia', 'tags'])
            ->orderBy('fecha', 'DESC')
            ->get();
    }

    public function find(int $id): ?Exhibition
    {
        return Exhibition::with(['tags', 'videos', 'files', 'multimedia', 'programs', 'publications', 'news'])->find($id);
    }

    public function findBySlug(string $slug): ?Exhibition
    {
        // Add robust eager loading for public detail view
        return Exhibition::where('titulo', 'like', '%' . str_replace('-', ' ', $slug) . '%') // Fallback approximation or use actual slug logic if stored
            // Ideally we should store slug or search exact title match from slug if reversible
            // But for now, let's use the same logic as original controller if it used dynamic slugs:
            // The original used `firstWhere('slug', $slug)` but slug is an accessor. 
            // Accessors can't be queried directly in SQL. 
            // So we must iterate or if valid, use id lookup if possible.
            // Wait, original PublicController:
            // $exposicion = Exposicion::...->get()->firstWhere('slug', $slug); 
            // This retrieves ALL records and filters in memory! Use careful filtering.
            ->get()
            ->firstWhere('slug', $slug);
    }

    public function create(array $data): Exhibition
    {
        return Exhibition::create($data);
    }

    public function update(Exhibition $exhibition, array $data): bool
    {
        return $exhibition->update($data);
    }

    public function delete(Exhibition $exhibition): bool
    {
        return $exhibition->delete();
    }
}
