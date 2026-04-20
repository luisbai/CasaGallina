<?php

namespace App\Modules\Program\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Tag\Infrastructure\Models\Tag;
use App\Modules\Exhibition\Infrastructure\Models\Exhibition;
use App\Modules\Multimedia\Infrastructure\Models\Multimedia;
use Spatie\Translatable\HasTranslations;

class Program extends Model
{
    use HasTranslations;

    protected $table = 'programas';

    public $translatable = ['titulo', 'contenido', 'metadatos'];

    protected $fillable = [
        'estado',
        'tipo',
        'fecha',
        'titulo',
        'metadatos',
        'contenido',
        'assign_to_expo_proyecto',
        'exposicion_id',
    ];

    protected $casts = [
        'assign_to_expo_proyecto' => 'boolean',
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

    public function getCleanTitleAttribute()
    {
        return strip_tags($this->titulo);
    }

    public function destacada_multimedia()
    {
        return $this->hasOne(ProgramMultimedia::class, 'programa_id')
            ->with('multimedia')
            ->latest('created_at');
    }

    public function destacada_multimedia_direct()
    {
        return $this->hasOneThrough(
            Multimedia::class,
            ProgramMultimedia::class,
            'programa_id',
            'id',
            'id',
            'multimedia_id'
        )->latest('programa_images.created_at');
    }

    public function multimedia()
    {
        return $this->hasMany(ProgramMultimedia::class, 'programa_id', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'programa_tag', 'programa_id', 'tag_id');
    }

    public function exhibition()
    {
        return $this->belongsTo(Exhibition::class, 'exposicion_id');
    }

    // Aliases for legacy Spanish code
    public function etiquetas()
    {
        return $this->tags();
    }
    public function exposicion()
    {
        return $this->exhibition();
    }
}
