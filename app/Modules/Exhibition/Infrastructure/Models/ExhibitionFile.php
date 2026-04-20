<?php

namespace App\Modules\Exhibition\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ExhibitionFile extends Model
{
    protected $table = 'exposicion_archivos';

    protected $fillable = [
        'exposicion_id',
        'titulo',
        'descripcion',
        'contenido',
        'filename',
        'stored_filename',
        'thumbnail',
        'mime_type',
        'file_size',
        'orden'
    ];

    /**
     * Get the human-readable file size
     */
    public function getHumanFileSizeAttribute()
    {
        $bytes = $this->file_size;

        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 1) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 1) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    /**
     * Get the file extension
     */
    public function getFileExtensionAttribute()
    {
        return pathinfo($this->filename, PATHINFO_EXTENSION);
    }

    /**
     * Get the download URL for this file
     */
    public function getDownloadUrlAttribute()
    {
        if ($this->stored_filename && Storage::disk('public')->exists($this->stored_filename)) {
            return Storage::disk('public')->url($this->stored_filename);
        }
        return '#';
    }

    /**
     * Get the thumbnail URL for this file
     */
    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail && Storage::disk('public')->exists($this->thumbnail)) {
            return Storage::disk('public')->url($this->thumbnail);
        }

        // Return a default file icon based on file type
        $extension = $this->file_extension;
        $iconMap = [
            'pdf' => 'assets/images/icons/pdf.png',
            'doc' => 'assets/images/icons/doc.png',
            'docx' => 'assets/images/icons/doc.png',
            'xls' => 'assets/images/icons/excel.png',
            'xlsx' => 'assets/images/icons/excel.png',
            'ppt' => 'assets/images/icons/powerpoint.png',
            'pptx' => 'assets/images/icons/powerpoint.png',
            'txt' => 'assets/images/icons/text.png',
            'zip' => 'assets/images/icons/zip.png',
            'rar' => 'assets/images/icons/zip.png',
        ];

        return asset($iconMap[$extension] ?? 'assets/images/icons/file.png');
    }

    /**
     * Check if the file exists on disk
     */
    public function fileExists()
    {
        return Storage::disk('public')->exists($this->stored_filename);
    }

    public function exhibition()
    {
        return $this->belongsTo(Exhibition::class, 'exposicion_id');
    }
}
