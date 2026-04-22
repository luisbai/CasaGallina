<?php

namespace App\Modules\Space\Providers;

use App\Modules\Space\Infrastructure\Models\Space;
use App\Modules\Space\Infrastructure\Observers\SpaceObserver;
use Illuminate\Support\ServiceProvider;

class SpaceServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Bind repositories if any
    }

    public function boot()
    {
        Space::observe(SpaceObserver::class);
        \Livewire\Livewire::component('admin.space.space-page', \App\Modules\Space\Presentation\Livewire\Admin\SpacePage::class);
        \Livewire\Livewire::component('admin.space.space-edit', \App\Modules\Space\Presentation\Livewire\Admin\SpaceEdit::class);
    }
}
