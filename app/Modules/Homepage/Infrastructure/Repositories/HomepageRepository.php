<?php

namespace App\Modules\Homepage\Infrastructure\Repositories;

use App\Modules\Homepage\Domain\Interfaces\HomepageRepositoryInterface;
use App\Modules\Homepage\Infrastructure\Models\HomepageBanner;
use App\Modules\Homepage\Infrastructure\Models\HomepageContent;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class HomepageRepository implements HomepageRepositoryInterface
{
    public function getBanners(int $perPage = 10, string $search = ''): LengthAwarePaginator
    {
        return HomepageBanner::query()
            ->with('backgroundImage')
            ->when($search, function ($query, $search) {
                return $query->where('content_es', 'like', "%$search%")
                    ->orWhere('content_en', 'like', "%$search%")
                    ->orWhere('cta_text_es', 'like', "%$search%")
                    ->orWhere('cta_text_en', 'like', "%$search%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function findBanner(int $id): ?HomepageBanner
    {
        return HomepageBanner::with('backgroundImage')->find($id);
    }

    public function createBanner(array $data): HomepageBanner
    {
        return HomepageBanner::create($data);
    }

    public function updateBanner(HomepageBanner $banner, array $data): bool
    {
        return $banner->update($data);
    }

    public function deleteBanner(HomepageBanner $banner): bool
    {
        return $banner->delete();
    }

    public function setActiveBanner(HomepageBanner $banner): void
    {
        // Don't deactivate others, just toggle this one or ensure it's active
        // Logic might need to be toggle or just set true depending on caller
        // The service calls this when toggling, so if we just want to set it active:
        $banner->update(['is_active' => true]);
    }

    public function getActiveBanners()
    {
        return HomepageBanner::where('is_active', true)
            ->with('backgroundImage')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getIntroContent(): ?HomepageContent
    {
        return HomepageContent::where('section', 'intro')
            ->where('is_active', true)
            ->first();
    }

    public function findContent(int $id): ?HomepageContent
    {
        return HomepageContent::find($id);
    }

    public function createContent(array $data): HomepageContent
    {
        return HomepageContent::create($data);
    }

    public function updateContent(HomepageContent $content, array $data): bool
    {
        return $content->update($data);
    }
}
