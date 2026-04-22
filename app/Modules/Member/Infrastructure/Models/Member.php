<?php

namespace App\Modules\Member\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'equipo_miembros';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'titulo',
        'biografia',
        'titulo_en',
        'biografia_en',
        'tipo',
        'orden',
    ];

    public static $rules = [
        'nombre' => ['required'],
        'tipo' => ['required'],
        'orden' => ['integer'],
    ];
}
