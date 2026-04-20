<?php

namespace App\Modules\Donation\Infrastructure\Models;

use App\Modules\News\Infrastructure\Models\Noticia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Donation extends Model
{
    protected $table = 'donaciones';

    protected $fillable = [
        'donador_id',
        'noticia_id',
        'amount',
        'stripe_payment_intent_id',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function donor(): BelongsTo
    {
        return $this->belongsTo(Donor::class, 'donador_id');
    }

    public function noticia(): BelongsTo
    {
        return $this->belongsTo(Noticia::class);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeForNoticia($query, $noticiaId)
    {
        return $query->where('noticia_id', $noticiaId);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year);
    }
}
