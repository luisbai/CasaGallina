<?php

namespace App\Modules\Strategy\Infrastructure\Models;

use App\Modules\Multimedia\Infrastructure\Models\Multimedia;
use Illuminate\Database\Eloquent\Model;

class StrategyMultimedia extends Model
{
    protected $table = 'estrategia_multimedia';

    protected $fillable = [
        'estrategia_id', 'multimedia_id',
    ];

    public function multimedia()
    {
        return $this->hasOne(Multimedia::class, 'id', 'multimedia_id');
    }
}
