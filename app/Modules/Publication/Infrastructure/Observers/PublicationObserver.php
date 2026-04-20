<?php

namespace App\Modules\Publication\Infrastructure\Observers;

use App\Modules\Publication\Infrastructure\Models\Publication;
use Illuminate\Support\Facades\Cache;

class PublicationObserver
{
    /**
     * Handle the Publication "created" event.
     */
    public function created(Publication $publication)
    {
        $this->clearCache();
    }

    /**
     * Handle the Publication "updated" event.
     */
    public function updated(Publication $publication)
    {
        $this->clearCache();
    }

    /**
     * Handle the Publication "deleted" event.
     */
    public function deleted(Publication $publication)
    {
       $this->clearCache();
    }

    /**
     * Handle the Publication "restored" event.
     */
    public function restored(Publication $publication)
    {
        $this->clearCache();
    }

    /**
     * Handle the Publication "force deleted" event.
     */
    public function forceDeleted(Publication $publication)
    {
        $this->clearCache();
    }

    protected function clearCache()
    {
        Cache::forget('home');
        Cache::forget('publicaciones');
        Cache::forget('dashboard.total_publicaciones');
    }
}
