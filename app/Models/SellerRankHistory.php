<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerRankHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'rank_id',
        'achieved_at',
    ];

    protected $casts = [
        'achieved_at' => 'datetime',
    ];

    /**
     * Get the seller that owns the rank history.
     */
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    /**
     * Get the rank associated with this history entry.
     */
    public function rank()
    {
        return $this->belongsTo(Rank::class);
    }
}
