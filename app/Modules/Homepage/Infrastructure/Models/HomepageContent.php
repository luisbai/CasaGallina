<?php

namespace App\Modules\Homepage\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageContent extends Model
{
    protected $table = 'homepage_contents';

    protected $fillable = [
        'section',
        'main_text_es',
        'main_text_en',
        'secondary_text_es',
        'secondary_text_en',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Retaining helper method for now
    public function getTitleFromContent(?string $content = null): string
    {
        $content = $content ?? $this->main_text_es;
        return \Illuminate\Support\Str::limit(strip_tags($content), 80);
    }
}
