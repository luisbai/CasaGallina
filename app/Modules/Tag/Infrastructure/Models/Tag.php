<?php

namespace App\Modules\Tag\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;

use App\Modules\Multimedia\Infrastructure\Models\Multimedia;
use App\Modules\News\Infrastructure\Models\Noticia;
use App\Modules\Program\Infrastructure\Models\Program as Programa;

class Tag extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'nombre_en', 'slug', 'slug_en', 'type', 'descripcion', 'descripcion_en', 'texto', 'texto_en', 'multimedia_id', 'thumbnail_id', 'sidebar', 'sidebar_en'
    ];

    /**
     * Get all programas associated with this tag
     */
    public function programas()
    {
        return $this->belongsToMany(Programa::class, 'programa_tag', 'tag_id', 'programa_id');
    }

    /**
     * Get all noticias associated with this tag
     */
    public function noticias()
    {
        return $this->belongsToMany(Noticia::class);
    }

    /**
     * Get the multimedia associated with this tag
     */
    public function multimedia()
    {
        return $this->belongsTo(Multimedia::class, 'multimedia_id', 'id');
    }

    /**
     * Get the thumbnail associated with this tag
     */
    public function thumbnail()
    {
        return $this->belongsTo(Multimedia::class, 'thumbnail_id', 'id');
    }
}
