<?php

namespace App\Modules\Multimedia\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;

class Multimedia extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'filename',
        'mime',
        'size',
    ];

    /**
     * Get the URL for the multimedia file.
     *
     * @return string
     */
    public function getUrlAttribute(): string
    {
        if ($this->filename) {
            /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
            $disk = \Illuminate\Support\Facades\Storage::disk('public');

            // Check direct filename
            if ($disk->exists($this->filename)) {
                return $disk->url($this->filename);
            }

            // Fallback for legacy publication images (saved without prefix)
            if ($disk->exists('cache/' . $this->filename)) {
                return $disk->url('cache/' . $this->filename);
            }
        }

        return asset('storage/no-image.svg');
    }
}
