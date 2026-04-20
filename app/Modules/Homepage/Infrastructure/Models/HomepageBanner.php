<?php

namespace App\Modules\Homepage\Infrastructure\Models;

use App\Modules\Multimedia\Infrastructure\Models\Multimedia;
use Illuminate\Database\Eloquent\Model;

class HomepageBanner extends Model
{
    protected $table = 'homepage_banners';

    protected $fillable = [
        'background_image_id',
        'content_es',
        'content_en',
        'cta_text_es',
        'cta_text_en',
        'cta_url_es',
        'cta_url_en',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function backgroundImage()
    {
        return $this->belongsTo(Multimedia::class, 'background_image_id');
    }

    // Retaining helper method for now as it might be used in views
    public function getTitleFromContent(?string $content = null): string
    {
        $content = $content ?? $this->content_es;
        
        if (preg_match('/<h1[^>]*>(.*?)<\/h1>/i', $content, $matches)) {
            return strip_tags($matches[1]);
        }
        
        if (preg_match('/<h2[^>]*>(.*?)<\/h2>/i', $content, $matches)) {
            return strip_tags($matches[1]);
        }
        
        return \Illuminate\Support\Str::limit(strip_tags($content), 80);
    }
}
