<?php

namespace App\Modules\Strategy\Domain\Interfaces;

use App\Modules\Strategy\Infrastructure\Models\Strategy;
use Illuminate\Database\Eloquent\Collection;

interface StrategyRepositoryInterface
{
    public function getAll();
    public function getPublic();
    public function find(int $id): ?Strategy;
    public function create(array $data): Strategy;
    public function update(Strategy $strategy, array $data): bool;
    public function delete(Strategy $strategy): bool;
}
