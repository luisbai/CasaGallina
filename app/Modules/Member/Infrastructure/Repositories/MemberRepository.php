<?php

namespace App\Modules\Member\Infrastructure\Repositories;

use App\Modules\Member\Domain\Interfaces\MemberRepositoryInterface;
use App\Modules\Member\Infrastructure\Models\Member;

class MemberRepository implements MemberRepositoryInterface
{
    public function all()
    {
        return Member::all();
    }

    public function find(int $id)
    {
        return Member::find($id);
    }

    public function create(array $data)
    {
        return Member::create($data);
    }

    public function update(int $id, array $data)
    {
        $member = Member::find($id);
        if ($member) {
            $member->update($data);
            return $member;
        }
        return null;
    }

    public function delete(int $id)
    {
        $member = Member::find($id);
        if ($member) {
            return $member->delete();
        }
        return false;
    }

    public function getOrdered()
    {
        return Member::orderBy('orden', 'asc')->get();
    }
}
