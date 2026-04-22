<?php

namespace App\Modules\Exhibition\Providers;

use App\Modules\Exhibition\Domain\Interfaces\ExhibitionRepositoryInterface;
use App\Modules\Exhibition\Infrastructure\Repositories\ExhibitionRepository;
use Illuminate\Support\ServiceProvider;

class ExhibitionServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ExhibitionRepositoryInterface::class, ExhibitionRepository::class);
    }

    public function boot()
    {
        \Livewire\Livewire::component('admin.exhibition.page', \App\Modules\Exhibition\Presentation\Livewire\Admin\Page::class);
        \Livewire\Livewire::component('admin.exhibition.edit', \App\Modules\Exhibition\Presentation\Livewire\Admin\Edit::class);
    }
}
