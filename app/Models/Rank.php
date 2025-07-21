<?php

// app/Models/Rank.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'min_points',
    ];

    protected $casts = [
        'min_points' => 'integer',
    ];

    // Get the next rank after this one
    public function getNextRank()
    {
        return static::where('min_points', '>', $this->min_points)
                    ->orderBy('min_points', 'asc')
                    ->first();
    }

    // Get all sellers with this rank
    public function sellers()
    {
        $nextRank = $this->getNextRank();
        
        return \App\Models\Seller::where('total_points', '>=', $this->min_points)
                    ->when($nextRank, function($query) use ($nextRank) {
                        return $query->where('total_points', '<', $nextRank->min_points);
                    });
    }

    // Static method to get rank by points
    public static function getRankByPoints($points)
    {
        return static::where('min_points', '<=', $points)
                    ->orderBy('min_points', 'desc')
                    ->first();
    }

    // Static method to get next rank by current points
    public static function getNextRankByPoints($points)
    {
        return static::where('min_points', '>', $points)
                    ->orderBy('min_points', 'asc')
                    ->first();
    }
}