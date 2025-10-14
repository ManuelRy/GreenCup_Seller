<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'points_per_unit',
        'seller_id',
        'image_url',
    ];
    protected $casts = [
        'points_per_unit' => 'integer',
    ];

    protected $appends = ['image_full_url'];

    public function qrCodes(): HasMany
    {
        return $this->hasMany(QrCode::class);
    }

    /**
     * Get the full image URL
     * Converts stored path to full URL using FileRepository
     */
    public function getImageFullUrlAttribute(): ?string
    {
        if (!$this->image_url) {
            return null;
        }

        $fRepo = app(\App\Repository\FileRepository::class);
        return $fRepo->get($this->image_url);
    }
}
