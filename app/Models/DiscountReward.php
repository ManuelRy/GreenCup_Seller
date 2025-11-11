<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DiscountReward extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'name',
        'discount_percentage',
        'points_cost',
        'is_active',
    ];

    protected $casts = [
        'discount_percentage' => 'decimal:2',
        'points_cost' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Get the seller that owns the discount reward
     */
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    /**
     * Get receipts that used this discount
     */
    public function receipts()
    {
        return $this->hasMany(Receipt::class, 'discount_reward_id');
    }

    /**
     * Scope for active discount rewards only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
