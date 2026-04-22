<?php

namespace App\Modules\News\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

use Spatie\Translatable\HasTranslations;
use App\Modules\Multimedia\Infrastructure\Models\Multimedia;
use App\Modules\Tag\Infrastructure\Models\Tag;
use App\Modules\Donation\Infrastructure\Models\Donation as Donacion;

class Noticia extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['titulo', 'contenido', 'descripcion'];

    protected $fillable = [
        'tipo',
        'titulo',
        'titulo_en',
        'contenido',
        'contenido_en',
        'descripcion',
        'descripcion_en',
        'palabras_clave',
        'enlaces_externos',
        'video_url',
        'transcripcion',
        'datos_evento',
        'autor',
        'fecha_publicacion',
        'activo',
        'slug',
        'slug_en',
        'orden',
        'exposicion_id',
        'banner_articulo',
        'banner_noticias',
        'banner_entrevista',
        'banner_cronica',
        'banner_otras_experiencias',
        'banner_resena_invitacion',
        'banner_enlaces',
        'banner_newsletter',
        'enable_donations',
        'donation_content',
        'donation_content_en',
        'donation_multimedia_id',
        'content_image_id'
    ];

    protected $casts = [
        'enlaces_externos' => 'array',
        'datos_evento' => 'array',
        'fecha_publicacion' => 'datetime',
        'activo' => 'boolean',
        'enable_donations' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($noticia) {
            if (empty($noticia->slug)) {
                $noticia->slug = Str::slug(strip_tags($noticia->titulo));
            }
            if (!empty($noticia->titulo_en) && empty($noticia->slug_en)) {
                $noticia->slug_en = Str::slug(strip_tags($noticia->titulo_en));
            }
        });

        static::updating(function ($noticia) {
            if ($noticia->isDirty('titulo')) {
                $noticia->slug = Str::slug(strip_tags($noticia->titulo));
            }
            if ($noticia->isDirty('titulo_en')) {
                $noticia->slug_en = $noticia->titulo_en ? Str::slug(strip_tags($noticia->titulo_en)) : null;
            }
        });
    }

    public function multimedia(): BelongsToMany
    {
        return $this->belongsToMany(Multimedia::class, 'noticia_multimedia')
            ->withPivot('orden')
            ->orderBy('noticia_multimedia.orden');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'noticia_tag');
    }

    public function exposicion(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Exhibition\Infrastructure\Models\Exhibition::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeActiva($query)
    {
        return $query->where('activo', true);
    }

    public function scopeRecientes($query)
    {
        return $query->orderBy('fecha_publicacion', 'desc');
    }

    public function scopeTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    public function scopeWithTag($query, $tagSlug)
    {
        return $query->whereHas('tags', function ($q) use ($tagSlug) {
            $q->where('slug', $tagSlug);
        });
    }

    public function scopeWithNewsTag($query, $tagSlug)
    {
        return $query->whereHas('tags', function ($q) use ($tagSlug) {
            $q->where('type', 'noticia')->where('slug', $tagSlug);
        });
    }

    public function getExcerptAttribute()
    {
        return $this->descripcion ?: Str::limit(strip_tags($this->contenido), 150);
    }

    public function getFeaturedImageAttribute()
    {
        return $this->multimedia->first();
    }

    public function getPrimaryTagAttribute()
    {
        return $this->tags()->where('type', 'noticia')->first();
    }

    public function getPrimaryTagSlugAttribute()
    {
        $tag = $this->getPrimaryTagAttribute();
        return $tag ? $tag->slug : null;
    }

    public function getPrimaryTagNameAttribute()
    {
        $tag = $this->getPrimaryTagAttribute();
        return $tag ? $tag->nombre : null;
    }

    /**
     * Get the English title from translations
     */
    public function getTituloEnAttribute()
    {
        return $this->getTranslation('titulo', 'en', false) ?: null;
    }

    /**
     * Get the English content from translations
     */
    public function getContenidoEnAttribute()
    {
        return $this->getTranslation('contenido', 'en', false) ?: null;
    }

    /**
     * Get the English description from translations
     */
    public function getDescripcionEnAttribute()
    {
        return $this->getTranslation('descripcion', 'en', false) ?: null;
    }

    /**
     * Get the English slug
     */
    public function getSlugEnAttribute()
    {
        // First try to get from the slug_en column
        $slugEn = $this->attributes['slug_en'] ?? null;

        // If not set, generate from English title
        if (!$slugEn && $this->titulo_en) {
            return Str::slug(strip_tags($this->titulo_en));
        }

        return $slugEn;
    }

    /**
     * Get the archivos for this noticia
     */
    public function archivos()
    {
        return $this->hasMany(NoticiaArchivo::class);
    }

    /**
     * Get the videos for this noticia
     */
    public function videos()
    {
        return $this->hasMany(NoticiaVideo::class);
    }

    /**
     * Get the donations for this noticia
     */
    public function donaciones()
    {
        return $this->hasMany(Donacion::class);
    }

    /**
     * Get total donations amount for this noticia
     */
    public function getTotalDonationsAttribute()
    {
        return $this->donaciones()->completed()->sum('amount');
    }

    /**
     * Get donations count for this noticia
     */
    public function getDonationsCountAttribute()
    {
        return $this->donaciones()->completed()->count();
    }

    /**
     * Get the donation multimedia for this noticia
     */
    public function donationMultimedia()
    {
        return $this->belongsTo(Multimedia::class, 'donation_multimedia_id');
    }

    /**
     * Get the content image for this noticia
     */
    public function contentImage()
    {
        return $this->belongsTo(Multimedia::class, 'content_image_id');
    }
}
