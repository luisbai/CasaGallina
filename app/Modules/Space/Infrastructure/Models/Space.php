<?php

namespace App\Modules\Space\Infrastructure\Models;

use App\Modules\Strategy\Infrastructure\Models\Strategy;
use App\Modules\Multimedia\Infrastructure\Models\Multimedia;
use Illuminate\Database\Eloquent\Model;

class Space extends Model
{
    protected $table = 'espacios';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'url', 'multimedia_id', 'status', 'ubicacion', 'ubicacion_lat', 'ubicacion_long'
    ];

    public static $rules = [
        'nombre' => ['required'],
        'status' => ['required'],
        'ubicacion' => ['required'],
        'ubicacion_lat' => ['required'],
        'ubicacion_long' => ['required'],
    ];

    public static $categorias = [
        'activo' => 'Aliados',
        'finalizado' => 'Iniciativas Afines',
    ];

    public function multimedia()
    {
        return $this->hasOne(Multimedia::class, 'id', 'multimedia_id');
    }

    public function strategies()
    {
        // Assuming Estrategia is not refactored yet, so using App\Modules\Strategy\Infrastructure\Models\Strategy
        // Relationship table 'espacio_estrategias'
        return $this->belongsToMany(Strategy::class, 'espacio_estrategias', 'espacio_id', 'estrategia_id')->select('titulo');
    }

    public function estrategias()
    {
        return $this->strategies();
    }
}
