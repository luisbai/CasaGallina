<?php

namespace App\Modules\Homepage\Domain\Interfaces;

use App\Modules\Homepage\Infrastructure\Models\HomepageBanner;
use App\Modules\Homepage\Infrastructure\Models\HomepageContent;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface HomepageRepositoryInterface
{
    public function getBanners(int $perPage = 10, string $search = ''): LengthAwarePaginator;
    public function getActiveBanners();
    public function findBanner(int $id): ?HomepageBanner;
    public function createBanner(array $data): HomepageBanner;
    public function updateBanner(HomepageBanner $banner, array $data): bool;
    public function deleteBanner(HomepageBanner $banner): bool;
    public function setActiveBanner(HomepageBanner $banner): void;

    public function getIntroContent(): ?HomepageContent;
    public function findContent(int $id): ?HomepageContent;
    public function createContent(array $data): HomepageContent;
    public function updateContent(HomepageContent $content, array $data): bool;
}
