<?php

namespace App\Modules\Exhibition\Application\Services;

use App\Modules\Exhibition\Domain\Interfaces\ExhibitionRepositoryInterface;
use App\Modules\Exhibition\Infrastructure\Models\Exhibition;
use Illuminate\Support\Facades\Storage;
use App\Modules\Multimedia\Infrastructure\Models\Multimedia;

class ExhibitionService
{
    public function __construct(
        protected ExhibitionRepositoryInterface $repository
    ) {}

    public function paginate(int $perPage, string $search = '', string $sortBy = 'created_at', string $sortDirection = 'desc')
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

    public function findBySlug(string $slug)
    {
        return $this->repository->findBySlug($slug);
    }

    public function findBySlugWithDetails(string $slug)
    {
        return Exhibition::with([
            'multimedia.multimedia', 
            'videos', 
            'files', 
            'tags', 
            'publications.publicacion_thumbnail', // Assuming publications is correct relation name in new model? Let's check Exhibition model again. 'publications' method exists.
            'programs' => function($query) {
                $query->where('assign_to_expo_proyecto', true)
                      ->where('estado', 'public')
                      ->with(['tags', 'multimedia.multimedia']); // Updated eager load logic. Model has programs() method.
            },
            'news' => function($query) { // Model has news() method.
                $query->where('activo', true)
                      ->with('multimedia')
                      ->orderBy('fecha_publicacion', 'desc');
            }
        ])->get()->firstWhere('slug', $slug);
    }

    public function create(array $data): Exhibition
    {
        $data = $this->prepareTranslatableData($data);
        return $this->repository->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $exhibition = $this->repository->find($id);
        if (!$exhibition) return false;

        $data = $this->prepareTranslatableData($data);
        return $this->repository->update($exhibition, $data);
    }

    public function delete(int $id): bool
    {
        $exhibition = $this->repository->find($id);
        if (!$exhibition) return false;
        
        // Delete related files
        foreach ($exhibition->files as $file) {
             if ($file->stored_filename && Storage::disk('public')->exists($file->stored_filename)) {
                 Storage::disk('public')->delete($file->stored_filename);
             }
             if ($file->thumbnail && Storage::disk('public')->exists($file->thumbnail)) {
                 Storage::disk('public')->delete($file->thumbnail);
             }
        }
        
        return $this->repository->delete($exhibition);
    }

    protected function prepareTranslatableData(array $data): array
    {
        $fields = ['titulo', 'contenido', 'metadatos'];

        foreach ($fields as $field) {
            $enField = $field . '_en';
            if (isset($data[$field]) || isset($data[$enField])) {
                $es = $data[$field] ?? '';
                $en = $data[$enField] ?? '';
                
                $data[$field] = [
                    'es' => $es,
                    'en' => $en
                ];
                unset($data[$enField]);
            }
        }

        return $data;
    }
}
