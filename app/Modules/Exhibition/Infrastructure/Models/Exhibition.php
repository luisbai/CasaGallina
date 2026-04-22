<?php

namespace App\Modules\Exhibition\Infrastructure\Models;

use App\Modules\Multimedia\Infrastructure\Models\Multimedia;
use App\Modules\Tag\Infrastructure\Models\Tag;
use App\Modules\Program\Infrastructure\Models\Program;
use App\Modules\Publication\Infrastructure\Models\Publication;
use App\Modules\News\Infrastructure\Models\Noticia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class Exhibition extends Model
{
    use HasTranslations;

    public $translatable = ['titulo', 'contenido', 'metadatos'];

    protected $table = 'exposiciones';

    protected $fillable = [
        'estado',
        'type',
        'fecha',
        'titulo',
        'metadatos',
        'contenido',
    ];

    /**
     * Get years from the fecha string
     */
    public function getYearsFromFechaAttribute()
    {
        if (!$this->fecha) {
            return null;
        }

        preg_match_all('/\b(19|20)\d{2}\b/', $this->fecha, $matches);
        
        if (empty($matches[0])) {
            return null;
        }

        $years = array_map('intval', $matches[0]);
        $years = array_unique($years);
        sort($years);

        return count($years) === 1 ? $years[0] : $years;
    }

    public function getYearFromFechaAttribute()
    {
        $years = $this->years_from_fecha;
        
        if (is_array($years)) {
            return $years[0];
        }
        
        return $years;
    }

    public function getSlugAttribute()
    {
        return Str::slug($this->titulo);
    }

    public function getCleanTitleAttribute()
    {
        return strip_tags($this->titulo);
    }

    public function cleanTitle()
    {
        return strip_tags($this->titulo);
    }

    public function featured_multimedia()
    {
        return $this->hasOne(ExhibitionMultimedia::class, 'exposicion_id')
            ->with('multimedia')
            ->latest('created_at');
    }

    public function featured_multimedia_direct()
    {
        return $this->hasOneThrough(
            Multimedia::class,
            ExhibitionMultimedia::class,
            'exposicion_id',
            'id',
            'id',
            'multimedia_id'
        )->latest('exposicion_multimedia.created_at');
    }

    public function multimedia()
    {
        return $this->hasMany(ExhibitionMultimedia::class, 'exposicion_id', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'exposicion_tag', 'exposicion_id', 'tag_id');
    }

    public function videos()
    {
        return $this->hasMany(ExhibitionVideo::class, 'exposicion_id', 'id');
    }

    public function files()
    {
        return $this->hasMany(ExhibitionFile::class, 'exposicion_id', 'id');
    }

    public function publications()
    {
        return $this->hasMany(Publication::class, 'exposicion_id');
    }

    public function news()
    {
        return $this->hasMany(Noticia::class, 'exposicion_id');
    }

    public function programs()
    {
        return $this->hasMany(Program::class, 'exposicion_id');
    }

    // Aliases for legacy Spanish code
    public function publicaciones() { return $this->publications(); }
    public function noticias() { return $this->news(); }
    public function programas() { return $this->programs(); }
    public function etiquetas() { return $this->tags(); }
    public function archivos() { return $this->files(); }
}
