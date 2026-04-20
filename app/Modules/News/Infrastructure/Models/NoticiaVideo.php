<?php

namespace App\Modules\News\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;

class NoticiaVideo extends Model
{
    protected $fillable = [
        'noticia_id',
        'titulo',
        'descripcion',
        'youtube_url',
        'orden',
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

    public function noticia()
    {
        return $this->belongsTo(Noticia::class);
    }
}
