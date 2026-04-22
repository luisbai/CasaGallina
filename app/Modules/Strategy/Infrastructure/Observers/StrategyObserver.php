<?php

namespace App\Modules\Strategy\Infrastructure\Observers;

use App\Modules\Strategy\Infrastructure\Models\Strategy;
use Illuminate\Support\Facades\Cache;

class StrategyObserver
{
    public function created(Strategy $strategy)
    {
        $this->clearCache();
    }

    public function updated(Strategy $strategy)
    {
        $this->clearCache();
    }

    public function deleted(Strategy $strategy)
    {
        $this->clearCache();
    }

    public function restored(Strategy $strategy)
    {
        $this->clearCache();
    }

    public function forceDeleted(Strategy $strategy)
    {
        $this->clearCache();
    }

    protected function clearCache()
    {
        Cache::forget('home');
        Cache::forget('estrategias');
    }
}
