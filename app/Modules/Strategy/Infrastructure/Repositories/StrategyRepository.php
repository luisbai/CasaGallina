<?php

namespace App\Modules\Strategy\Infrastructure\Repositories;

use App\Modules\Strategy\Domain\Interfaces\StrategyRepositoryInterface;
use App\Modules\Strategy\Infrastructure\Models\Strategy;

class StrategyRepository implements StrategyRepositoryInterface
{
    public function getAll()
    {
        return Strategy::orderBy('orden', 'asc')->get();
    }

    public function getPublic()
    {
        return Strategy::where('status', 'public')->orderBy('orden', 'asc')->get();
    }

    public function find(int $id): ?Strategy
    {
        return Strategy::find($id);
    }

    public function create(array $data): Strategy
    {
        return Strategy::create($data);
    }

    public function update(Strategy $strategy, array $data): bool
    {
        return $strategy->update($data);
    }

    public function delete(Strategy $strategy): bool
    {
        return $strategy->delete();
    }
}
