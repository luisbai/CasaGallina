<?php

namespace App\Modules\Member\Infrastructure\Observers;

use App\Modules\Member\Infrastructure\Models\Member;
use Illuminate\Support\Facades\Cache;

class MemberObserver
{
    public function created(Member $member)
    {
        Cache::forget('members');
        Cache::forget('dashboard.total_miembros');
    }

    public function updated(Member $member)
    {
        Cache::forget('members');
    }

    public function deleted(Member $member)
    {
        Cache::forget('members');
        Cache::forget('dashboard.total_miembros');
    }

    public function restored(Member $member)
    {
        Cache::forget('members');
        Cache::forget('dashboard.total_miembros');
    }

    public function forceDeleted(Member $member)
    {
        Cache::forget('members');
        Cache::forget('dashboard.total_miembros');
    }
}
