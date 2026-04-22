<?php

namespace App\Modules\Contact\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Contact\Domain\Interfaces\ContactRepositoryInterface;
use App\Modules\Contact\Infrastructure\Repositories\ContactRepository;

class ContactServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            ContactRepositoryInterface::class,
            ContactRepository::class
        );
    }

    public function boot()
    {
        \Livewire\Livewire::component('admin.contact.page', \App\Modules\Contact\Presentation\Livewire\Admin\Page::class);
    }
}
