<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reward extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'points_required',
        'quantity',
        'quantity_redeemed',
        'image_path',
        'valid_from',
        'valid_until',
        'is_active',
        'seller_id',
    ];

    protected $casts = [
        'valid_from' => 'date',
        'valid_until' => 'date',
        'is_active' => 'boolean',
    ];

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function getAvailableQuantityAttribute()
    {
        return $this->quantity - $this->quantity_redeemed;
    }

    public function isValid()
    {
        $today = now()->toDateString();
        return $this->is_active &&
               $this->valid_from <= $today &&
               $this->valid_until >= $today &&
               $this->available_quantity > 0;
    }
}
