<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Receipt extends Model
{
    protected $fillable = [
        'seller_id',
        'receipt_code',
        'items',
        'total_points',
        'total_quantity',
        'status',
        'expires_at',
        'claimed_at',
        'claimed_by_consumer_id',
        'discount_reward_id'
    ];

    protected $casts = [
        'items' => 'array',
        'total_points' => 'integer',
        'total_quantity' => 'integer',
        'expires_at' => 'datetime',
        'claimed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Format date in Cambodia timezone with readable format
     */
    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at ? $this->created_at->timezone('Asia/Phnom_Penh')->format('M d, Y g:i A') : null;
    }

    /**
     * Format expires_at in Cambodia timezone
     */
    public function getFormattedExpiresAtAttribute()
    {
        return $this->expires_at ? $this->expires_at->timezone('Asia/Phnom_Penh')->format('M d, Y g:i A') : null;
    }

    /**
     * Format claimed_at in Cambodia timezone
     */
    public function getFormattedClaimedAtAttribute()
    {
        return $this->claimed_at ? $this->claimed_at->timezone('Asia/Phnom_Penh')->format('M d, Y g:i A') : null;
    }

    /**
     * Get seller relationship
     */
    public function seller()
    {
        return $this->belongsTo(\App\Models\Seller::class);
    }

    /**
     * Get consumer relationship
     */
    public function consumer()
    {
        return $this->belongsTo(\App\Models\Consumer::class, 'claimed_by_consumer_id');
    }

    /**
     * Get discount reward relationship
     */
    public function discountReward()
    {
        return $this->belongsTo(\App\Models\DiscountReward::class, 'discount_reward_id');
    }
}
