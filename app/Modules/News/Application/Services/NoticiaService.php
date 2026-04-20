<?php

namespace App\Modules\News\Application\Services;

use App\Modules\News\Domain\Interfaces\NoticiaRepositoryInterface;
use App\Modules\News\Infrastructure\Models\Noticia;
use App\Modules\Shared\Application\Services\GeminiTranslationService;

class NoticiaService
{
    public function __construct(
        protected NoticiaRepositoryInterface $repository,
        protected GeminiTranslationService $translationService
    ) {}

    public function paginate(int $perPage, string $search = '', string $sortBy = 'fecha_publicacion', string $sortDirection = 'desc')
    {
        return $this->repository->paginate($perPage, $search, $sortBy, $sortDirection);
    }

    public function find(int $id)
    {
        return $this->repository->find($id);
    }

    public function create(array $data): Noticia
    {
        $data = $this->prepareTranslatableData($data);
        return $this->repository->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $noticia = $this->repository->find($id);
        if (!$noticia) return false;

        $data = $this->prepareTranslatableData($data);
        return $this->repository->update($noticia, $data);
    }

    public function delete(int $id): bool
    {
        $noticia = $this->repository->find($id);
        if (!$noticia) return false;
        
        return $this->repository->delete($noticia);
    }

    protected function prepareTranslatableData(array $data): array
    {
        $fields = ['titulo', 'contenido', 'descripcion'];

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
