<?php

namespace App\Modules\Member\Application\Services;

use App\Modules\Member\Domain\Interfaces\MemberRepositoryInterface;

class MemberService
{
    protected $memberRepository;

    public function __construct(MemberRepositoryInterface $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }

    public function all()
    {
        return $this->memberRepository->all();
    }

    public function getOrdered()
    {
        return $this->memberRepository->getOrdered();
    }

    public function find(int $id)
    {
        return $this->memberRepository->find($id);
    }

    public function create(array $data)
    {
        return $this->memberRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->memberRepository->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->memberRepository->delete($id);
    }
    
    public function reorder(array $items)
    {
        foreach ($items as $item) {
             if (isset($item['id']) && isset($item['orden'])) {
                 $this->memberRepository->update($item['id'], ['orden' => $item['orden']]);
             }
        }
    }
}
