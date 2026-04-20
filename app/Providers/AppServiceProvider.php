<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Donation\Infrastructure\Models\Donor as Donador;
use Laravel\Cashier\Cashier;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Cashier::useCustomerModel(Donador::class);
    }
}
