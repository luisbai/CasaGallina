<?php

namespace App\Modules\Newsletter\Providers;

use App\Modules\Newsletter\Domain\Interfaces\NewsletterRepositoryInterface;
use App\Modules\Newsletter\Infrastructure\Repositories\NewsletterRepository;
use Illuminate\Support\ServiceProvider;

class NewsletterServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(NewsletterRepositoryInterface::class, NewsletterRepository::class);
    }

    public function boot()
    {
        \Livewire\Livewire::component('admin.newsletter.page', \App\Modules\Newsletter\Presentation\Livewire\Admin\Page::class);
    }
}
