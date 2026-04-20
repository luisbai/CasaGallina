<?php

namespace App\Modules\Exhibition\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;

class ExhibitionVideo extends Model
{
    protected $table = 'exposicion_videos';

    protected $fillable = [
        'exposicion_id',
        'titulo',
        'descripcion',
        'youtube_url',
        'orden'
    ];

    /**
     * Get the YouTube video ID from the URL
     */
    public function getYoutubeIdAttribute()
    {
        $url = $this->youtube_url;

        if (preg_match('/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $url, $matches)) {
            return $matches[1];
        }

        return null;
    }

    /**
     * Get the thumbnail URL for this video
     */
    public function getThumbnailUrlAttribute()
    {
        $videoId = $this->youtube_id;

        if ($videoId) {
            return "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg";
        }

        return null;
    }

    /**
     * Get the fallback thumbnail URL
     */
    public function getFallbackThumbnailUrlAttribute()
    {
        $videoId = $this->youtube_id;

        if ($videoId) {
            return "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg";
        }

        return null;
    }

    public function exhibition()
    {
        return $this->belongsTo(Exhibition::class, 'exposicion_id');
    }
}
