<?php

namespace App\Modules\Publication\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Publication\Domain\Interfaces\PublicationRepositoryInterface;
use App\Modules\Publication\Infrastructure\Repositories\PublicationRepository;
use App\Modules\Publication\Presentation\Livewire\Admin\Page;
use App\Modules\Publication\Presentation\Livewire\Admin\Form;

class PublicationServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            PublicationRepositoryInterface::class,
            PublicationRepository::class
        );
    }

    public function boot()
    {
        \App\Modules\Publication\Infrastructure\Models\Publication::observe(\App\Modules\Publication\Infrastructure\Observers\PublicationObserver::class);
        
        \Livewire\Livewire::component('admin.publication.form', Form::class);
        \Livewire\Livewire::component('admin.publication.page', Page::class);
    }
}
