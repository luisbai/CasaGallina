<?php

namespace App\Modules\Exhibition\Infrastructure\Models;

use App\Modules\Multimedia\Infrastructure\Models\Multimedia;
use Illuminate\Database\Eloquent\Model;

class ExhibitionMultimedia extends Model
{
    protected $table = 'exposicion_multimedia';

    protected $fillable = [
        'exposicion_id',
        'multimedia_id',
    ];

    public function multimedia()
    {
        return $this->hasOne(Multimedia::class, 'id', 'multimedia_id');
    }
}
