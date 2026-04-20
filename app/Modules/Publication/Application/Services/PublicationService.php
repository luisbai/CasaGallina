<?php

namespace App\Modules\Publication\Application\Services;

use App\Modules\Publication\Domain\Interfaces\PublicationRepositoryInterface;
use App\Modules\Publication\Infrastructure\Models\Publication;
use App\Modules\Shared\Application\Services\ImageService;
use App\Modules\Multimedia\Infrastructure\Models\Multimedia;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PublicationService
{
    public function __construct(
        protected PublicationRepositoryInterface $repository,
        protected ImageService $imageService
    ) {
    }

    public function paginate(int $perPage = 15, string $search = '', string $sortBy = 'created_at', string $sortDirection = 'desc')
    {
        return $this->repository->paginate($perPage, $search, $sortBy, $sortDirection);
    }

    public function getPublic(string $type = null)
    {
        return $this->repository->getPublic($type);
    }

    public function find(int $id)
    {
        return $this->repository->find($id);
    }

    public function create(array $data): Publication
    {
        return $this->repository->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $publication = $this->repository->find($id);
        if (!$publication)
            return false;

        return $this->repository->update($publication, $data);
    }

    public function delete(int $id): bool
    {
        $publication = $this->repository->find($id);
        if (!$publication)
            return false;

        // Cleanup files if needed, tough current legacy code keeps them often.
        // Let's implement basic file cleanup if we created them.

        return $this->repository->delete($publication);
    }

    public function processFile(UploadedFile $file, string $title, bool $resize = false): int
    {
        $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $filename = Str::slug($name) . '_' . Str::random(4) . '.' . $file->getClientOriginalExtension();

        if ($resize) {
            $multimedia = $this->imageService->processAndStore(
                $file,
                'cache',
                800,  // max width
                600,  // max height
                85    // quality
            );

            return $multimedia->id;
        } else {
            // Store file directly
            $file->storeAs('public/cache', $filename);

            $multimedia = Multimedia::create([
                'filename' => 'cache/' . $filename,
                'mime' => $file->getClientMimeType(),
                'size' => $file->getSize(),
            ]);

            return $multimedia->id;
        }
    }
}
