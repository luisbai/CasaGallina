<?php

namespace App\Modules\Contact\Infrastructure\Models;

use App\Modules\Publication\Infrastructure\Models\Publication;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactSubmission extends Model
{
    protected $table = 'contact_submissions';

    protected $fillable = [
        'form_type',
        'nombre',
        'email',
        'telefono',
        'organizacion',
        'publicacion_id',
        'subscribed_to_mailrelay',
        'metadata',
    ];

    protected $casts = [
        'subscribed_to_mailrelay' => 'boolean',
        'metadata' => 'array',
    ];

    public function publication(): BelongsTo
    {
        return $this->belongsTo(Publication::class, 'publicacion_id');
    }
    
    // Legacy relationship alias
    public function publicacion(): BelongsTo
    {
        return $this->publication();
    }
}
