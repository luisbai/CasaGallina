<?php

namespace App\Modules\Program\Application\Services;

use App\Modules\Program\Domain\Interfaces\ProgramRepositoryInterface;
use Illuminate\Http\UploadedFile;
use App\Modules\Multimedia\Infrastructure\Models\Multimedia;
use App\Modules\Program\Infrastructure\Models\ProgramMultimedia;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class ProgramService
{
    protected $programRepository;

    public function __construct(ProgramRepositoryInterface $programRepository)
    {
        $this->programRepository = $programRepository;
    }

    public function all()
    {
        return $this->programRepository->all();
    }

    public function find(int $id)
    {
        return $this->programRepository->find($id);
    }

    public function create(array $data)
    {
        $data = $this->prepareTranslatableData($data);
        return $this->programRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        $data = $this->prepareTranslatableData($data);
        return $this->programRepository->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->programRepository->delete($id);
    }

    public function getActivePrograms()
    {
        return $this->programRepository->getActivePrograms();
    }

    /**
     * Handle image processing (upload, resize, associate)
     */
    public function processImage(UploadedFile $file, $programId)
    {
        // 1. Store Original
        $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('public/programas', $filename);

        // 2. Create Multimedia Record
        $multimedia = Multimedia::create([
            'filename' => $filename,
            'mime' => $file->getClientMimeType(),
            'size' => $file->getSize(),
            'width' => 0, // Placeholder
            'height' => 0, // Placeholder
        ]);

        // 3. Resize/Generate Variants (optional, if using Intervention)
        // For now, implementing basic resizing for thumbnails if needed
        // Simulating the legacy logic or ImageService logic

        // 4. Associate with Program
        ProgramMultimedia::create([
            'programa_id' => $programId,
            'multimedia_id' => $multimedia->id
        ]);

        return $multimedia;
    }

    public function removeImage($programMultimediaId)
    {
        $pm = ProgramMultimedia::find($programMultimediaId);
        if ($pm) {
            $multimedia = Multimedia::find($pm->multimedia_id);
            if ($multimedia && $multimedia->filename) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($multimedia->filename);
                $multimedia->delete();
            }
            $pm->delete();
            return true;
        }
        return false;
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
