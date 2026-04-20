<?php

namespace App\Modules\Newsletter\Application\Services;

use App\Modules\Multimedia\Infrastructure\Models\Multimedia;
use App\Modules\Newsletter\Domain\Interfaces\NewsletterRepositoryInterface;
use App\Modules\Newsletter\Infrastructure\Models\Newsletter;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class NewsletterService
{
    public function __construct(
        protected NewsletterRepositoryInterface $repository
    ) {}

    public function getAllNewsletters(int $perPage, string $search = '', string $sortBy = 'boletin_fecha', string $sortDirection = 'desc')
    {
        return $this->repository->paginate($perPage, $search, $sortBy, $sortDirection);
    }

    public function getNewsletter(int $id): ?Newsletter
    {
        return $this->repository->find($id);
    }

    public function createNewsletter(array $data, UploadedFile $fileEs, UploadedFile $fileEn): Newsletter
    {
        return DB::transaction(function () use ($data, $fileEs, $fileEn) {
            // Process files
            $multimediaEs = $this->processAndStorePDF($fileEs, 'es');
            $multimediaEn = $this->processAndStorePDF($fileEn, 'en');

            $data['multimedia_es_id'] = $multimediaEs->id;
            $data['multimedia_en_id'] = $multimediaEn->id;

            return $this->repository->create($data);
        });
    }

    public function updateNewsletter(int $id, array $data, ?UploadedFile $fileEs = null, ?UploadedFile $fileEn = null): bool
    {
        $newsletter = $this->repository->find($id);

        if (!$newsletter) {
            return false;
        }

        return DB::transaction(function () use ($newsletter, $data, $fileEs, $fileEn) {
            if ($fileEs) {
                $this->deleteAssociatedFile($newsletter->multimedia_es);
                $multimediaEs = $this->processAndStorePDF($fileEs, 'es');
                $data['multimedia_es_id'] = $multimediaEs->id;
            }

            if ($fileEn) {
                $this->deleteAssociatedFile($newsletter->multimedia_en);
                $multimediaEn = $this->processAndStorePDF($fileEn, 'en');
                $data['multimedia_en_id'] = $multimediaEn->id;
            }

            return $this->repository->update($newsletter, $data);
        });
    }

    public function deleteNewsletter(int $id): bool
    {
        $newsletter = $this->repository->find($id);

        if (!$newsletter) {
            return false;
        }

        return DB::transaction(function () use ($newsletter) {
            $this->deleteAssociatedFile($newsletter->multimedia_es);
            $this->deleteAssociatedFile($newsletter->multimedia_en);
            
            return $this->repository->delete($newsletter);
        });
    }

    public function removeFile(int $newsletterId, string $language): bool
    {
        $newsletter = $this->repository->find($newsletterId);

        if (!$newsletter) {
            return false;
        }

        $multimediaField = "multimedia_{$language}";
        $multimediaIdField = "multimedia_{$language}_id";

        if ($newsletter->$multimediaField) {
            $this->deleteAssociatedFile($newsletter->$multimediaField);
            return $this->repository->update($newsletter, [$multimediaIdField => null]);
        }

        return false;
    }

    protected function processAndStorePDF(UploadedFile $file, string $language): Multimedia
    {
        $filename = time() . '_boletin_' . $language . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('boletines', $filename, 'public');

        return Multimedia::create([
            'filename' => $path,
            'mime' => $file->getMimeType(),
            'size' => $file->getSize(),
        ]);
    }

    protected function deleteAssociatedFile(?Multimedia $multimedia): void
    {
        if ($multimedia) {
            Storage::disk('public')->delete($multimedia->filename);
            $multimedia->delete();
        }
    }
}
