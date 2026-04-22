<?php

namespace App\Modules\Homepage\Presentation\Livewire\Admin;

use App\Modules\Homepage\Application\Services\HomepageService;
use Flux\Flux;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;

class HomepagePage extends Component
{
    use WithPagination, WithFileUploads;

    public string $search = '';
    public int $perPage = 10;

    // Banner form fields
    public string $content_es = '';
    public string $content_en = '';
    public string $cta_text_es = '';
    public string $cta_text_en = '';
    public string $cta_url_es = '';
    public string $cta_url_en = '';
    public bool $is_active = false;
    public $background_image = null;
    public ?int $background_image_id = null;
    public ?int $editId = null;

    // Content form fields
    public string $main_text_es = '';
    public string $main_text_en = '';
    public string $secondary_text_es = '';
    public string $secondary_text_en = '';
    public ?int $contentEditId = null;

    public bool $quotaExceeded = false;

    protected $homepageService;

    public function boot(HomepageService $homepageService)
    {
        $this->homepageService = $homepageService;
    }

    protected array $queryString = [
        'search' => ['except' => ''],
    ];

    #[Computed]
    public function banners(): LengthAwarePaginator
    {
        return $this->homepageService->getBanners($this->perPage, $this->search);
    }

    #[Computed]
    public function introContent()
    {
        return $this->homepageService->getIntroContent();
    }

    public function delete($id): void
    {
        if ($this->homepageService->deleteBanner($id)) {
            Flux::toast("El banner ha sido eliminado.");
        }
    }

    public function toggleActive($id): void
    {
        if ($this->homepageService->toggleBannerActive($id)) {
            Flux::toast("El estado del banner ha cambiado.");
        }
    }

    public function openCreateModal(): void
    {
        $this->resetForm();
        $this->quotaExceeded = false;
        Flux::modal('createBanner')->show();
    }

    public function cancelCreate(): void
    {
        $this->resetForm();
        Flux::modal('createBanner')->close();
    }

    public function cancelEdit(): void
    {
        $this->resetForm();
        Flux::modal('editBanner')->close();
    }

    public function resetForm(): void
    {
        $this->reset([
            'content_es',
            'content_en',
            'cta_text_es',
            'cta_text_en',
            'cta_url_es',
            'cta_url_en',
            'is_active',
            'background_image',
            'background_image_id',
            'editId'
        ]);
    }

    public function editBanner($id): void
    {
        $this->editId = $id;
        $this->quotaExceeded = false;
        $banner = $this->homepageService->getBanners(1, '')->items()[0]->find($id); // Refetch via repo ideally but service access ok

        // Quick fix to find via service directly
        // In real world better expose find method in service
        // For now relying on direct access pattern or loop
        // Let's rely on repo method exposed via service if possible or existing query

        // Actually, let's use the repo logic via service or just query for editing since it is admin
        $banner = \App\Modules\Homepage\Infrastructure\Models\HomepageBanner::find($id);

        if ($banner) {
            $this->content_es = $banner->content_es;
            $this->content_en = $banner->content_en;
            $this->cta_text_es = $banner->cta_text_es ?? '';
            $this->cta_text_en = $banner->cta_text_en ?? '';
            $this->cta_url_es = $banner->cta_url_es ?? '';
            $this->cta_url_en = $banner->cta_url_en ?? '';
            $this->is_active = $banner->is_active;
            $this->background_image_id = $banner->background_image_id;
        }

        Flux::modal('editBanner')->show();
    }

    public function store(): void
    {
        $this->validate([
            'content_es' => 'required|string',
            'content_en' => 'required|string',
            'cta_text_es' => 'nullable|string|max:255',
            'cta_text_en' => 'nullable|string|max:255',
            'cta_url_es' => 'nullable|string|max:255',
            'cta_url_en' => 'nullable|string|max:255',
            'background_image' => 'nullable|image|max:10240',
        ]);

        $data = [
            'content_es' => $this->content_es,
            'content_en' => $this->content_en,
            'cta_text_es' => $this->cta_text_es,
            'cta_text_en' => $this->cta_text_en,
            'cta_url_es' => $this->cta_url_es,
            'cta_url_en' => $this->cta_url_en,
            'is_active' => $this->is_active,
        ];

        $this->homepageService->createBanner($data, $this->background_image);

        Flux::toast("El banner ha sido creado.");
        Flux::modal('createBanner')->close();
        $this->resetForm();
    }

    public function update(): void
    {
        $this->validate([
            'content_es' => 'required|string',
            'content_en' => 'required|string',
            'cta_text_es' => 'nullable|string|max:255',
            'cta_text_en' => 'nullable|string|max:255',
            'cta_url_es' => 'nullable|string|max:255',
            'cta_url_en' => 'nullable|string|max:255',
            'background_image' => 'nullable|image|max:10240',
        ]);

        if ($this->editId) {
            $data = [
                'content_es' => $this->content_es,
                'content_en' => $this->content_en,
                'cta_text_es' => $this->cta_text_es,
                'cta_text_en' => $this->cta_text_en,
                'cta_url_es' => $this->cta_url_es,
                'cta_url_en' => $this->cta_url_en,
                'is_active' => $this->is_active,
            ];

            $this->homepageService->updateBanner($this->editId, $data, $this->background_image);

            Flux::toast("El banner ha sido actualizado.");
            Flux::modal('editBanner')->close();
            $this->resetForm();
        }
    }

    public function removeBackgroundImage(): void
    {
        if ($this->editId) {
            if ($this->homepageService->removeBannerImage($this->editId)) {
                $this->background_image_id = null;
                Flux::toast("Imagen de fondo eliminada.");
            }
        }
        $this->background_image = null;
    }

    // Content management methods
    public function editContent(): void
    {
        $this->quotaExceeded = false;
        $introContent = $this->introContent;

        if ($introContent) {
            $this->contentEditId = $introContent->id;
            $this->main_text_es = $introContent->main_text_es;
            $this->main_text_en = $introContent->main_text_en;
            $this->secondary_text_es = $introContent->secondary_text_es;
            $this->secondary_text_en = $introContent->secondary_text_en;
        } else {
            $this->contentEditId = null;
            $this->main_text_es = '';
            $this->main_text_en = '';
            $this->secondary_text_es = '';
            $this->secondary_text_en = '';
        }

        Flux::modal('editContent')->show();
    }

    public function saveContent(): void
    {
        $this->validate([
            'main_text_es' => 'required|string',
            'main_text_en' => 'required|string',
            'secondary_text_es' => 'required|string',
            'secondary_text_en' => 'required|string',
        ]);

        $data = [
            'main_text_es' => $this->main_text_es,
            'main_text_en' => $this->main_text_en,
            'secondary_text_es' => $this->secondary_text_es,
            'secondary_text_en' => $this->secondary_text_en,
        ];

        $this->homepageService->saveIntroContent($data);

        Flux::toast("El contenido ha sido actualizado.");
        Flux::modal('editContent')->close();
        $this->resetContentForm();
    }

    public function cancelContentEdit(): void
    {
        $this->resetContentForm();
        Flux::modal('editContent')->close();
    }

    public function resetContentForm(): void
    {
        $this->reset([
            'main_text_es',
            'main_text_en',
            'secondary_text_es',
            'secondary_text_en',
            'contentEditId'
        ]);
    }

    public function translateCreateBanner(\App\Modules\Shared\Application\Services\GeminiTranslationService $translator): void
    {
        $textsToTranslate = [
            'content' => $this->content_es,
            'cta_text' => $this->cta_text_es,
        ];

        // Filter out empty values
        $textsToTranslate = array_filter($textsToTranslate);

        if (empty($textsToTranslate)) {
            Flux::toast("No hay texto para traducir.", variant: "warning");
            return;
        }

        try {
            $translations = $translator->translateBatch($textsToTranslate);
            $this->quotaExceeded = false;

            if (empty($translations) || $translations === $textsToTranslate) {
                // If service returns identical or empty result when input was not empty, 
                // it usually means it failed silently or API key is missing.
                Flux::toast("La traducción no devolvió resultados. Verifique la configuración del servicio.", variant: "danger");
                return;
            }

            if (isset($translations['content']) && !empty($translations['content'])) {
                $this->content_en = $translations['content'];
            }

            if (isset($translations['cta_text']) && !empty($translations['cta_text'])) {
                $this->cta_text_en = $translations['cta_text'];
            }

            Flux::toast(
                heading: 'Traducción completada',
                text: 'Los textos han sido traducidos.',
                variant: 'success'
            );
        } catch (\Exception $e) {
            if (strpos($e->getMessage(), '429') !== false) {
                $this->quotaExceeded = true;
            }
            Flux::toast(
                heading: 'Error de traducción',
                text: $e->getMessage(),
                variant: 'danger'
            );
        }
    }

    public function translateIntroContent(\App\Modules\Shared\Application\Services\GeminiTranslationService $translator): void
    {
        $textsToTranslate = [
            'main_text' => $this->main_text_es,
            'secondary_text' => $this->secondary_text_es,
        ];

        // Filter out empty values
        $textsToTranslate = array_filter($textsToTranslate);

        if (empty($textsToTranslate)) {
            Flux::toast("No hay texto para traducir.", variant: "warning");
            return;
        }

        try {
            $translations = $translator->translateBatch($textsToTranslate);
            $this->quotaExceeded = false;

            if (empty($translations) || $translations === $textsToTranslate) {
                Flux::toast("La traducción no devolvió resultados. Verifique la configuración del servicio.", variant: "danger");
                return;
            }

            if (isset($translations['main_text']) && !empty($translations['main_text'])) {
                $this->main_text_en = $translations['main_text'];
            }

            if (isset($translations['secondary_text']) && !empty($translations['secondary_text'])) {
                $this->secondary_text_en = $translations['secondary_text'];
            }

            Flux::toast(
                heading: 'Traducción completada',
                text: 'Los textos de introducción han sido traducidos.',
                variant: 'success'
            );
        } catch (\Exception $e) {
            if (strpos($e->getMessage(), '429') !== false) {
                $this->quotaExceeded = true;
            }
            Flux::toast(
                heading: 'Error de traducción',
                text: $e->getMessage(),
                variant: 'danger'
            );
        }
    }

    public function render(): View
    {
        return view('livewire.admin.homepage.page');
    }
}
