<?php

namespace App\Modules\Program\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Multimedia\Infrastructure\Models\Multimedia;

class ProgramMultimedia extends Model
{
    protected $table = 'programa_images';

    protected $fillable = [
        'programa_id', 'multimedia_id'
    ];

    public function multimedia()
    {
        return $this->hasOne(Multimedia::class, 'id', 'multimedia_id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'programa_id', 'id');
    }
}
