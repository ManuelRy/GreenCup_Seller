<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;
use App\Traits\NormalizesRemoteUrl;

class Seller extends Authenticatable
{
    use HasFactory, NormalizesRemoteUrl;

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_SUSPENDED = 'suspended';
    const STATUS_REJECTED = 'rejected';

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
        'status',
        'rejection_reason',
        'rejected_at',
        'total_points',
        'photo_url',
        'photo_caption',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'total_points' => 'integer',
    ];

    /**
     * Check if seller is active (approved status)
     */
    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }

    /**
     * Check if seller is pending approval
     */
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Check if seller is suspended
     */
    public function isSuspended(): bool
    {
        return $this->status === self::STATUS_SUSPENDED;
    }

    /**
     * Check if seller is rejected
     */
    public function isRejected(): bool
    {
        return $this->status === self::STATUS_REJECTED;
    }

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

    public function photos()
    {
        return $this->hasMany(SellerPhoto::class);
    }

    /**
     * Ensure the stored profile photo URL is always HTTPS and fully qualified.
     */
    public function getPhotoUrlAttribute($value): ?string
    {
        return $this->normalizeRemoteUrl($value);
    }

    // === FIXED POINT METHODS ===

    /**
     * Manually update seller's total_points after transactions
     * Call this after creating new transactions
     */
    public function updateTotalPoints()
    {
        $correctTotal = $this->pointTransactions()
            ->where('type', 'earn')
            ->sum('points') ?? 0;
            
        $this->update(['total_points' => $correctTotal]);
        return $correctTotal;
    }

    // === RANK METHODS ===

    public function getCurrentRank()
    {
        $rank = Rank::where('min_points', '<=', $this->total_points)
            ->orderBy('min_points', 'desc')
            ->first();

        // If no rank found, get the lowest rank (should be Bronze at 0 points)
        if (!$rank) {
            $rank = Rank::orderBy('min_points', 'asc')->first();
        }

        // Last resort fallback if ranks table is completely empty
        if (!$rank) {
            return (object)[
                'name' => 'Standard',
                'min_points' => 0
            ];
        }

        return $rank;
    }

    public function getNextRank()
    {
        return Rank::where('min_points', '>', $this->total_points)
            ->orderBy('min_points', 'asc')
            ->first();
    }

    // === DASHBOARD METRICS ===

    public function getPointsGivenAttribute()
    {
        return $this->pointTransactions()
            ->where('type', 'earn')
            ->sum('points') ?? 0;
    }

    public function getPointsFromRedemptionsAttribute()
    {
        return $this->pointTransactions()
            ->where('type', 'spend')
            ->sum('points') ?? 0;
    }

    public function getTotalCustomersAttribute()
    {
        return $this->pointTransactions()
            ->distinct('consumer_id')
            ->count('consumer_id') ?? 0;
    }

    public function getTotalTransactionsAttribute()
    {
        return $this->pointTransactions()->count() ?? 0;
    }

    // === RANK UPDATE METHOD ===

    public function updateRank()
    {
        $newRank = $this->getCurrentRank();
        if ($newRank && isset($newRank->id)) {
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

    /**
     * Safely update seller points and adjust rank accordingly
     * Used for error corrections and fraud recovery (called from admin panel)
     */
    public function updatePointsAndRank($newPoints, $reason = null)
    {
        $oldPoints = $this->total_points;
        $oldRank = $this->getCurrentRank();

        // Update the points
        $this->update(['total_points' => $newPoints]);

        // Update rank after points change
        $this->updateRank();

        $newRank = $this->getCurrentRank();

        // Log this change for audit purposes
        \Log::info("Seller points manually updated", [
            'seller_id' => $this->id,
            'seller_name' => $this->business_name,
            'old_points' => $oldPoints,
            'new_points' => $newPoints,
            'old_rank' => $oldRank ? $oldRank->name : 'No Rank',
            'new_rank' => $newRank ? $newRank->name : 'No Rank',
            'reason' => $reason,
            'updated_by' => 'Admin',
            'updated_at' => now()
        ]);

        return [
            'old_points' => $oldPoints,
            'new_points' => $newPoints,
            'old_rank' => $oldRank,
            'new_rank' => $newRank,
            'rank_changed' => ($oldRank?->id !== $newRank?->id)
        ];
    }
}
