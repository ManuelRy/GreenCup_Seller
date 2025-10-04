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
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
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
        $now = now();
        return $this->is_active &&
               $this->valid_from <= $now &&
               $this->valid_until >= $now &&
               $this->available_quantity > 0;
    }

    public function getTimeRemainingAttribute()
    {
        if (!$this->isValid()) {
            return null;
        }

        $now = now();
        $diff = $now->diff($this->valid_until);

        return [
            'days' => $diff->days,
            'hours' => $diff->h,
            'minutes' => $diff->i,
            'seconds' => $diff->s,
            'total_seconds' => $now->diffInSeconds($this->valid_until),
            'human_readable' => $this->getHumanReadableTimeRemaining(),
        ];
    }

    /**
     * Get human readable time remaining
     */
    public function getHumanReadableTimeRemaining()
    {
        if (!$this->isValid()) {
            return 'Expired';
        }

        $now = now();
        $diff = $now->diff($this->valid_until);

        if ($diff->days > 0) {
            return "{$diff->days}d {$diff->h}h {$diff->i}m";
        } elseif ($diff->h > 0) {
            return "{$diff->h}h {$diff->i}m {$diff->s}s";
        } elseif ($diff->i > 0) {
            return "{$diff->i}m {$diff->s}s";
        } else {
            return "{$diff->s}s";
        }
    }

    public function isExpiringSoon($hours = 24)
    {
        if (!$this->isValid()) {
            return false;
        }

        return now()->diffInHours($this->valid_until) <= $hours;
    }

    /**
     * Scope for active rewards only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for currently valid rewards (datetime check)
     */
    public function scopeCurrentlyValid($query)
    {
        $now = now();
        return $query->where('is_active', true)
                    ->where('valid_from', '<=', $now)
                    ->where('valid_until', '>=', $now)
                    ->whereRaw('quantity > quantity_redeemed');
    }
}
