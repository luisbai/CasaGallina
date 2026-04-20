<?php

namespace App\Modules\Space\Application\Services;

use App\Modules\Space\Infrastructure\Models\Space;
use App\Modules\Multimedia\Infrastructure\Models\Multimedia;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class SpaceService
{
    public function getAllSpaces()
    {
        return Space::all();
    }

    public function findSpace($id): Space
    {
        return Space::findOrFail($id);
    }

    public function createSpace(array $data, ?UploadedFile $image = null): Space
    {
        if ($image) {
            $multimedia = $this->processImage($image);
            $data['multimedia_id'] = $multimedia->id;
        }

        return Space::create($data);
    }

    public function updateSpace(Space $space, array $data, ?UploadedFile $image = null): Space
    {
        if ($image) {
            $multimedia = $this->processImage($image);
            $data['multimedia_id'] = $multimedia->id;
        }

        $space->update($data);

        return $space;
    }

    public function deleteSpace(Space $space): bool
    {
        // Should we delete multimedia? Legacy code didn't seem to explicitly delete it in 'delete' method,
        // but 'delete' in controller was just Space::where(...)->delete().
        // Observer handles cache clearing.
        return $space->delete();
    }

    public function assignStrategy(Space $space, $strategyId)
    {
        return $space->strategies()->syncWithoutDetaching($strategyId);
    }

    public function removeStrategy(Space $space, $strategyId)
    {
        return $space->strategies()->detach($strategyId);
    }

    protected function processImage(UploadedFile $file): Multimedia
    {
        $filename = md5($file->getClientOriginalName() . uniqid()) . '.' . $file->getClientOriginalExtension();
        
        // This logic mimics the legacy EspaciosController logic
        // It saves to 'storage_path() . /app/public/cache/'
        // In Laravel, conventionally we should use Storage facade, but I will stick to the logic 
        // or improve it to use Storage::disk('public')->put... 
        // Legacy code used Image::make ... save(...)
        
        $path = storage_path('app/public/cache/' . $filename);
        
        // Ensure directory exists
        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }

        $img = Image::make($file->getRealPath());
        $img->resize(500, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($path);

        return Multimedia::create([
            'filename' => $filename,
            'mime' => $file->getClientMimeType(),
            'size' => $file->getSize(),
        ]);
    }
}
