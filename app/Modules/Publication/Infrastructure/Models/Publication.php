<?php

namespace App\Modules\Publication\Infrastructure\Models;

use App\Modules\Multimedia\Infrastructure\Models\Multimedia;
use App\Modules\Exhibition\Infrastructure\Models\Exhibition;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Publication extends Model
{
    protected $table = 'publicaciones';

    protected $appends = ['url'];

    protected $fillable = [
        'status',
        'titulo',
        'fecha_publicacion',
        'coordinacion_editorial',
        'diseno',
        'numero_paginas',
        'tipo',

        'textos',
        'sinopsis',
        'additional_content',

        'exposicion_id',
        'publicacion_multimedia_id',
        'publicacion_thumbnail_id',

        'campo_opcional_1_titulo',
        'campo_opcional_1',
        'campo_opcional_2_titulo',
        'campo_opcional_2',
        'campo_opcional_3_titulo',
        'campo_opcional_3',
        'campo_opcional_4_titulo',
        'campo_opcional_4',
        'campo_opcional_5_titulo',
        'campo_opcional_5',
        'campo_opcional_6_titulo',
        'campo_opcional_6',
        'campo_opcional_7_titulo',
        'campo_opcional_7',

        'downloads',
        'views',

        'titulo_en',
        'fecha_publicacion_en',
        'coordinacion_editorial_en',
        'diseno_en',

        'textos_en',
        'sinopsis_en',
        'additional_content_en',

        'campo_opcional_1_en_titulo',
        'campo_opcional_1_en',
        'campo_opcional_2_en_titulo',
        'campo_opcional_2_en',
        'campo_opcional_3_en_titulo',
        'campo_opcional_3_en',
        'campo_opcional_4_en_titulo',
        'campo_opcional_4_en',
        'campo_opcional_5_en_titulo',
        'campo_opcional_5_en',
        'campo_opcional_6_en_titulo',
        'campo_opcional_6_en',
        'campo_opcional_7_en_titulo',
        'campo_opcional_7_en',

        'orden',

        'previsualizacion',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at',
        'created_at'
    ];

    public function multimedia()
    {
        return $this->hasOne(Multimedia::class, 'id', 'publicacion_multimedia_id');
    }

    public function thumbnail()
    {
        return $this->hasOne(Multimedia::class, 'id', 'publicacion_thumbnail_id');
    }

    public function exhibition()
    {
        return $this->belongsTo(Exhibition::class, 'exposicion_id');
    }

    public function exposicion()
    {
        return $this->exhibition();
    }

    // Accessors for compatibility with existing views if needed, or better use new names
    // For now keeping accessors similar to old model logic but using new structure if applicable

    public function getCleanTitleAttribute()
    {
        return strip_tags($this->titulo);
    }

    public function getUrlAttribute()
    {
        return [
            'es' => '/publicacion/' . Str::slug($this->titulo) . '/' . $this->id,
            'en' => '/en/publication/' . Str::slug($this->titulo_en) . '/' . $this->id
        ];
    }

    // Backward compatibility relationships if views are not fully migrated at once
    public function publicacion_multimedia()
    {
        return $this->multimedia();
    }

    public function publicacion_thumbnail()
    {
        return $this->thumbnail();
    }
}
