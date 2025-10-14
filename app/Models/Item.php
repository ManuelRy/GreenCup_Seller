<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\NormalizesRemoteUrl;

class Item extends Model
{
    use HasFactory, NormalizesRemoteUrl;

    protected $fillable = [
        'name',
        'points_per_unit',
        'seller_id',
        'image_url',
    ];
    protected $casts = [
        'points_per_unit' => 'integer',
    ];

    public function qrCodes(): HasMany
    {
        return $this->hasMany(QrCode::class);
    }

    public function getImageUrlAttribute($value): ?string
    {
        return $this->normalizeRemoteUrl($value);
    }
}
