<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PendingTransaction extends Model
{
    protected $fillable = [
        'receipt_code',
        'seller_id',
        'items',
        'total_points',
        'total_quantity',
        'status',
        'expires_at',
        'claimed_at',
        'claimed_by_consumer_id',
    ];

    protected $casts = [
        'items' => 'array',
        'expires_at' => 'datetime',
        'claimed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Format created_at in Cambodia timezone with readable format
     */
    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at
            ? $this->created_at->timezone('Asia/Phnom_Penh')->format('M d, Y g:i A')
            : null;
    }

    /**
     * Format expires_at in Cambodia timezone
     */
    public function getFormattedExpiresAtAttribute()
    {
        return $this->expires_at
            ? $this->expires_at->timezone('Asia/Phnom_Penh')->format('M d, Y g:i A')
            : null;
    }

    /**
     * Format claimed_at in Cambodia timezone
     */
    public function getFormattedClaimedAtAttribute()
    {
        return $this->claimed_at
            ? $this->claimed_at->timezone('Asia/Phnom_Penh')->format('M d, Y g:i A')
            : null;
    }

    public function consumer()
    {
        return $this->belongsTo(Consumer::class, 'claimed_by_consumer_id');
    }

    public function seller() {
        return $this->belongsTo(Seller::class);
    }
}
