<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerPhoto extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'seller_photos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'seller_id',
        'photo_url',
        'photo_caption',
        'caption',
        'category',
        'is_featured',
        'sort_order'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_featured' => 'boolean',
        'sort_order' => 'integer'
    ];

    /**
     * Get the seller that owns the photo.
     */
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    /**
     * Check if photo is frozen by admin
     */
    public function isFrozen(): bool
    {
        return str_starts_with($this->photo_caption ?? '', '[FROZEN] ');
    }

    /**
     * Get the original caption without the frozen prefix
     */
    public function getOriginalCaptionAttribute(): ?string
    {
        $caption = $this->photo_caption ?? '';

        if (str_starts_with($caption, '[FROZEN] ')) {
            return substr($caption, 9);
        }

        return $caption ?: null;
    }

    /**
     * Get caption with frozen prefix removed (for backward compatibility)
     */
    public function trimCaption(): string
    {
        return $this->original_caption ?? '';
    }
}
