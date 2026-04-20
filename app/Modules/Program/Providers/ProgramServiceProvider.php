<?php

namespace App\Modules\Program\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Program\Domain\Interfaces\ProgramRepositoryInterface;
use App\Modules\Program\Infrastructure\Repositories\ProgramRepository;

class ProgramServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ProgramRepositoryInterface::class, ProgramRepository::class);
    }

    public function boot()
    {
        \Livewire\Livewire::component('admin.program.program-page', \App\Modules\Program\Presentation\Livewire\Admin\ProgramPage::class);
        \Livewire\Livewire::component('public.programa-detalle', \App\Modules\Program\Presentation\Livewire\Public\ProgramaDetalle::class);
    }
}
