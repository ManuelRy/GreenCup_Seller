<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;

class Seller extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'business_name',
        'email',
        'description',
        'working_hours',
        'password',
        'address',
        'latitude',
        'longitude',
        'phone',
        'is_active',
        'total_points',
        'photo_url',
        'photo_caption',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        // Remove 'password' => 'hashed' - this is causing the issue
        'is_active' => 'boolean',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'total_points' => 'integer',
    ];

    /**
     * Automatically hash password when setting it
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    // Relationships
    public function pointTransactions()
    {
        return $this->hasMany(PointTransaction::class);
    }

    public function qrCodes()
    {
        return $this->hasMany(QrCode::class);
    }

    public function rankHistories()
    {
        return $this->hasMany(SellerRankHistory::class);
    }

    /**
     * Get the photos for the seller.
     * THIS IS THE METHOD YOU WERE MISSING!
     */
    public function photos()
    {
        return $this->hasMany(SellerPhoto::class);
    }

    // Rank methods
    public function getCurrentRank()
    {
        return Rank::where('min_points', '<=', $this->total_points)
            ->orderBy('min_points', 'desc')
            ->first();
    }

    public function getNextRank()
    {
        return Rank::where('min_points', '>', $this->total_points)
            ->orderBy('min_points', 'asc')
            ->first();
    }

    // Helper methods for dashboard metrics
    public function getPointsGivenAttribute()
    {
        return $this->pointTransactions()
            ->where('type', 'earn')
            ->sum('points');
    }

    public function getPointsFromRedemptionsAttribute()
    {
        return $this->pointTransactions()
            ->where('type', 'spend')
            ->sum('points');
    }

    public function getTotalCustomersAttribute()
    {
        return $this->pointTransactions()
            ->distinct('consumer_id')
            ->count('consumer_id');
    }

    public function getTotalTransactionsAttribute()
    {
        return $this->pointTransactions()->count();
    }

    // Method to update rank when points change
    public function updateRank()
    {
        $newRank = $this->getCurrentRank();
        if ($newRank) {
            // Check if this rank hasn't been achieved before
            $existingHistory = SellerRankHistory::where('seller_id', $this->id)
                ->where('rank_id', $newRank->id)
                ->exists();

            if (!$existingHistory) {
                SellerRankHistory::create([
                    'seller_id' => $this->id,
                    'rank_id' => $newRank->id,
                    'achieved_at' => now(),
                ]);
            }
        }
    }
}