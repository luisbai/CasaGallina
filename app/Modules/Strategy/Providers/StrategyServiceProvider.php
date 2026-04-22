<?php

namespace App\Modules\Strategy\Providers;

use App\Modules\Strategy\Domain\Interfaces\StrategyRepositoryInterface;
use App\Modules\Strategy\Infrastructure\Repositories\StrategyRepository;
use App\Modules\Strategy\Infrastructure\Models\Strategy;
use App\Modules\Strategy\Infrastructure\Observers\StrategyObserver;
use Illuminate\Support\ServiceProvider;

class StrategyServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(StrategyRepositoryInterface::class, StrategyRepository::class);
    }

    public function boot()
    {
        Strategy::observe(StrategyObserver::class);
    }
}
