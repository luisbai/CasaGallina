<?php

namespace App\Modules\Donation\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Cashier\Billable;

class Donor extends Model
{
    use Billable;

    protected $table = 'donadores';

    protected $fillable = [
        'name',
        'email',
        'comprobante',
        'stripe_id',
        'pm_type',
        'pm_last_four',
        'trial_ends_at',
    ];

    /**
     * Get the donations for this donador
     */
    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class, 'donador_id');
    }

    /**
     * Get total donations amount for this donador
     */
    public function getTotalDonationsAttribute()
    {
        return $this->donations()->completed()->sum('amount');
    }
}
