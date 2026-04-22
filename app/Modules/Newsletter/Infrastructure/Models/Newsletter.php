<?php

namespace App\Modules\Newsletter\Infrastructure\Models;

use App\Modules\Multimedia\Infrastructure\Models\Multimedia;
use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    protected $table = 'boletines';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'boletin_fecha',
        'multimedia_en_id',
        'multimedia_es_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'boletin_fecha' => 'date',
    ];

    public static $rules = [
        'boletin_fecha' => ['required'],
        'multimedia_en_id' => ['required', 'mimes:pdf'],
        'multimedia_es_id' => ['required', 'mimes:pdf'],
    ];

    public function multimedia_en()
    {
        return $this->hasOne(Multimedia::class, 'id', 'multimedia_en_id');
    }

    public function multimedia_es()
    {
        return $this->hasOne(Multimedia::class, 'id', 'multimedia_es_id');
    }
}
