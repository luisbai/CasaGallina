<?php

namespace App\Modules\Member\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Member\Domain\Interfaces\MemberRepositoryInterface;
use App\Modules\Member\Infrastructure\Repositories\MemberRepository;

class MemberServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(MemberRepositoryInterface::class, MemberRepository::class);
    }

    public function boot()
    {
        \App\Modules\Member\Infrastructure\Models\Member::observe(\App\Modules\Member\Infrastructure\Observers\MemberObserver::class);
        \Livewire\Livewire::component('admin.member.member-page', \App\Modules\Member\Presentation\Livewire\Admin\MemberPage::class);
    }
}
