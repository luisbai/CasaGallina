<?php

namespace App\Modules\Space\Infrastructure\Observers;

use App\Modules\Space\Infrastructure\Models\Space;
use Illuminate\Support\Facades\Cache;

class SpaceObserver
{
    /**
     * Handle the Space "created" event.
     *
     * @param  \App\Modules\Space\Infrastructure\Models\Space  $space
     * @return void
     */
    public function created(Space $space)
    {
        $this->clearCache();
    }

    /**
     * Handle the Space "updated" event.
     *
     * @param  \App\Modules\Space\Infrastructure\Models\Space  $space
     * @return void
     */
    public function updated(Space $space)
    {
        $this->clearCache();
    }

    /**
     * Handle the Space "deleted" event.
     *
     * @param  \App\Modules\Space\Infrastructure\Models\Space  $space
     * @return void
     */
    public function deleted(Space $space)
    {
        $this->clearCache();
    }

    /**
     * Handle the Space "restored" event.
     *
     * @param  \App\Modules\Space\Infrastructure\Models\Space  $space
     * @return void
     */
    public function restored(Space $space)
    {
        $this->clearCache();
    }

    /**
     * Handle the Space "force deleted" event.
     *
     * @param  \App\Modules\Space\Infrastructure\Models\Space  $space
     * @return void
     */
    public function forceDeleted(Space $space)
    {
        $this->clearCache();
    }

    protected function clearCache()
    {
        Cache::forget('home');
        Cache::forget('espacios');
    }
}
