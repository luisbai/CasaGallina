<?php

namespace App\Modules\Strategy\Application\Services;

use App\Modules\Strategy\Domain\Interfaces\StrategyRepositoryInterface;
use App\Modules\Strategy\Infrastructure\Models\Strategy;
use App\Modules\Strategy\Infrastructure\Models\StrategyMultimedia;
use App\Modules\Multimedia\Infrastructure\Models\Multimedia;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class StrategyService
{
    public function __construct(
        protected StrategyRepositoryInterface $repository
    ) {}

    public function getAll()
    {
        return $this->repository->getAll();
    }

    public function getPublic()
    {
        return $this->repository->getPublic();
    }

    public function find(int $id)
    {
        return $this->repository->find($id);
    }

    public function create(array $data, array $images = [], ?UploadedFile $featuredImage = null): Strategy
    {
        // 1. Prepare translatable data
        $preparedData = $this->prepareTranslatableData($data);
        
        // 2. Handle featured image
        if ($featuredImage) {
            $multimedia = $this->processImage($featuredImage);
            $preparedData['destacada_multimedia_id'] = $multimedia->id;
        }

        // 3. Set order
        $preparedData['orden'] = Strategy::count() + 1;

        // 4. Create Strategy
        $strategy = $this->repository->create($preparedData);

        // 5. Handle gallery images
        if (!empty($images)) {
            foreach ($images as $image) {
                $multimedia = $this->processImage($image);
                StrategyMultimedia::create([
                    'estrategia_id' => $strategy->id,
                    'multimedia_id' => $multimedia->id
                ]);
            }
        }

        return $strategy;
    }

    public function update(int $id, array $data, array $images = [], ?UploadedFile $featuredImage = null): bool
    {
        $strategy = $this->repository->find($id);
        if (!$strategy) return false;

        // 1. Prepare translatable data
        $preparedData = $this->prepareTranslatableData($data);

        // 2. Handle featured image
        if ($featuredImage) {
             $multimedia = $this->processImage($featuredImage);
             $preparedData['destacada_multimedia_id'] = $multimedia->id;
        }

        // 3. Update Strategy
        $updated = $this->repository->update($strategy, $preparedData);

        // 4. Handle gallery images (add new ones)
        if (!empty($images)) {
            foreach ($images as $image) {
                $multimedia = $this->processImage($image);
                StrategyMultimedia::create([
                    'estrategia_id' => $strategy->id,
                    'multimedia_id' => $multimedia->id
                ]);
            }
        }

        return $updated;
    }

    public function delete(int $id): bool
    {
        $strategy = $this->repository->find($id);
        if (!$strategy) return false;
        
        // 1. Delete associated images (optional, depends on retention policy, but let's stick to legacy behavior which might not delete files)
        // Legacy: $strategy->multimedia()->delete(); which deletes the Pivot/Relation, but not the Multimedia entry or file?
        // Let's implement full cleanup for multimedia relation
        $strategy->multimedia()->delete();
        
        return $this->repository->delete($strategy);
    }

    public function deleteImage(int $strategyId, int $multimediaId, string $type)
    {
        $strategy = $this->repository->find($strategyId);
        if (!$strategy) return false;

        if ($type == 'banner') {
            $strategyMultimedia = StrategyMultimedia::where('estrategia_id', $strategyId)
                ->where('multimedia_id', $multimediaId)
                ->first();
            
            if ($strategyMultimedia) {
                $strategyMultimedia->delete();
            }
        } else if ($type == 'destacada') {
            $strategy->update(['destacada_multimedia_id' => null]);
        }
    }

    protected function processImage(UploadedFile $file): Multimedia
    {
        $filename = md5($file->getClientOriginalName() . uniqid()) . '.' . $file->getClientOriginalExtension();
        
        // Legacy path: storage_path() . /app/public/cache/
        $path = storage_path('app/public/cache/' . $filename);
        
        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }

        $img = Image::make($file->getRealPath());
        $img->resize(1110, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($path);

        return Multimedia::create([
            'filename' => $filename,
            'mime' => $file->getClientMimeType(),
            'size' => $file->getSize(),
        ]);
    }

    /**
     * Maps flat input (titulo, titulo_en) to JSON structure (titulo: ['es' => ..., 'en' => ...])
     */
    protected function prepareTranslatableData(array $data): array
    {
        $translatableFields = [
            'titulo', 'subtitulo', 'contenido', 'programas', 
            'colaboradores', 'lugar', 
            'campo_opcional_1_titulo', 'campo_opcional_1',
            'campo_opcional_2_titulo', 'campo_opcional_2',
            'campo_opcional_3_titulo', 'campo_opcional_3',
            'campo_opcional_4_titulo', 'campo_opcional_4',
            'campo_opcional_5_titulo', 'campo_opcional_5',
        ];

        foreach ($translatableFields as $field) {
            // Determine English field name
            // Special cases based on original controller/model structure:
            // campo_opcional_1_titulo -> campo_opcional_1_en_titulo
            if (str_contains($field, 'campo_opcional') && str_contains($field, '_titulo')) {
                 $parts = explode('_titulo', $field);
                 $enField = $parts[0] . '_en_titulo';
            } elseif(str_contains($field, 'campo_opcional')) {
                $enField = $field . '_en';
            } else {
                $enField = $field . '_en';
            }

            // Only process if base field exists in data (even if empty, to allow clearing)
            // But if we want to update partials, check existence vs null.
            // Assuming form sends all fields.
            if (array_key_exists($field, $data) || array_key_exists($enField, $data)) {
                $es = $data[$field] ?? '';
                $en = $data[$enField] ?? '';
                
                $data[$field] = [
                    'es' => $es,
                    'en' => $en
                ];
                
                // Remove the _en field
                unset($data[$enField]);
            }
        }

        return $data;
    }
}
