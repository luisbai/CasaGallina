<?php

namespace App\Modules\Homepage\Application\Services;

use App\Modules\Homepage\Domain\Interfaces\HomepageRepositoryInterface;
use App\Modules\Shared\Application\Services\ImageService;
use Illuminate\Support\Facades\Storage;

class HomepageService
{
    public function __construct(
        protected HomepageRepositoryInterface $repository,
        protected ImageService $imageService
    ) {
    }

    public function getBanners(int $perPage = 10, string $search = '')
    {
        return $this->repository->getBanners($perPage, $search);
    }

    public function getIntroContent()
    {
        return $this->repository->getIntroContent();
    }

    public function getActiveBanners()
    {
        return $this->repository->getActiveBanners();
    }

    public function toggleBannerActive(int $id)
    {
        $banner = $this->repository->findBanner($id);
        if ($banner) {
            if (!$banner->is_active) {
                $this->repository->setActiveBanner($banner);
            } else {
                $this->repository->updateBanner($banner, ['is_active' => false]);
            }
            return true;
        }
        return false;
    }

    public function deleteBanner(int $id)
    {
        $banner = $this->repository->findBanner($id);
        if ($banner) {
            // Delete background image if exists
            if ($banner->background_image_id) {
                $multimedia = $banner->backgroundImage;
                if ($multimedia && $multimedia->filename) {
                    Storage::disk('public')->delete($multimedia->filename);
                    $multimedia->delete();
                }
            }
            return $this->repository->deleteBanner($banner);
        }
        return false;
    }

    public function createBanner(array $data, $image = null)
    {
        if ($image) {
            $multimedia = $this->imageService->processAndStore($image, 'homepage');
            $data['background_image_id'] = $multimedia->id;
        }

        $banner = $this->repository->createBanner($data);

        if (isset($data['is_active']) && $data['is_active']) {
            $this->repository->setActiveBanner($banner);
        }

        return $banner;
    }

    public function updateBanner(int $id, array $data, $image = null)
    {
        $banner = $this->repository->findBanner($id);
        if (!$banner)
            return false;

        if ($image) {
            // Delete old image
            if ($banner->background_image_id) {
                $oldMultimedia = $banner->backgroundImage;
                if ($oldMultimedia && $oldMultimedia->filename) {
                    Storage::disk('public')->delete($oldMultimedia->filename);
                    $oldMultimedia->delete();
                }
            }

            $multimedia = $this->imageService->processAndStore($image, 'homepage');
            $data['background_image_id'] = $multimedia->id;
        }

        $this->repository->updateBanner($banner, $data);

        if (isset($data['is_active']) && $data['is_active']) {
            $this->repository->setActiveBanner($banner);
        }

        return true;
    }

    public function removeBannerImage(int $id)
    {
        $banner = $this->repository->findBanner($id);
        if ($banner && $banner->backgroundImage) {
            $multimedia = $banner->backgroundImage;
            Storage::disk('public')->delete($multimedia->filename);
            $multimedia->delete();
            $this->repository->updateBanner($banner, ['background_image_id' => null]);
            return true;
        }
        return false;
    }

    public function saveIntroContent(array $data)
    {
        // Simple create or update logic for 'intro' section
        $content = $this->repository->getIntroContent();
        $data['section'] = 'intro';
        $data['is_active'] = true;

        if ($content) {
            return $this->repository->updateContent($content, $data);
        } else {
            return $this->repository->createContent($data);
        }
    }
}
