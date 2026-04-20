<?php

namespace App\Modules\Donation\Providers;

use Illuminate\Support\ServiceProvider;

class DonationServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Bind repositories if any
    }

    public function boot()
    {
        \Livewire\Livewire::component('admin.donation.page', \App\Modules\Donation\Presentation\Livewire\Admin\Page::class);
    }
}
