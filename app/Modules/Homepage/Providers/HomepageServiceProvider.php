<?php

namespace App\Modules\Homepage\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Homepage\Domain\Interfaces\HomepageRepositoryInterface;
use App\Modules\Homepage\Infrastructure\Repositories\HomepageRepository;

class HomepageServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            HomepageRepositoryInterface::class,
            HomepageRepository::class
        );
    }

    public function boot()
    {
        \Livewire\Livewire::component('admin.homepage.homepage-page', \App\Modules\Homepage\Presentation\Livewire\Admin\HomepagePage::class);
    }
}
