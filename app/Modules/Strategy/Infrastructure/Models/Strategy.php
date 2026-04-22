<?php

namespace App\Modules\Strategy\Infrastructure\Models;

use App\Modules\Multimedia\Infrastructure\Models\Multimedia;
use App\Modules\Tag\Infrastructure\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class Strategy extends Model
{
    use HasTranslations;

    protected $table = 'estrategias';

    protected $appends = ['url'];

    public $translatable = [
        'titulo',
        'subtitulo',
        'contenido',
        'programas',
        'colaboradores',
        'lugar',
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
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'titulo',
        'subtitulo',
        'contenido',
        'programas',
        'colaboradores',
        'fecha',
        'lugar',
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
        'destacada_multimedia_id',
        'orden',
    ];

    public static $rules = [
        'titulo' => ['required'],
        'subtitulo' => ['required'],
        'contenido' => ['required'],
        'colaboradores' => ['required'],
        'fecha' => ['required'],
        'lugar' => ['required'],
        'destacada_multimedia_id' => ['required'],
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at', 'created_at', 'pivot',
    ];

    public function featured_multimedia()
    {
        return $this->hasOne(Multimedia::class, 'id', 'destacada_multimedia_id');
    }

    public function multimedia()
    {
        return $this->hasMany(StrategyMultimedia::class, 'estrategia_id', 'id')->orderBy('created_at', 'desc');
    }

    public function getUrlAttribute()
    {
        return [
            'es' => '/estrategia/' . Str::slug($this->getTranslation('titulo', 'es')) . '/' . $this->id,
            'en' => '/en/strategy/' . Str::slug($this->getTranslation('titulo', 'en')) . '/' . $this->id
        ];
    }
}
