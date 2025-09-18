<?php

// app/Models/PointTransaction.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'consumer_id',
        'seller_id',
        'qr_code_id',
        'units_scanned',
        'points',
        'type',
        'description',
        'scanned_at',
    ];

    protected $casts = [
        'units_scanned' => 'integer',
        'points' => 'integer',
        'scanned_at' => 'datetime',
    ];

    // Relationships
    public function consumer()
    {
        return $this->belongsTo(Consumer::class);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function qrCode()
    {
        return $this->belongsTo(QrCode::class);
    }
}




// app/Models/QrCode.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'item_id',
        'consumer_id',
        'type',
        'code',
        'active',
        'expires_at',
    ];

    protected $casts = [
        'active' => 'boolean',
        'expires_at' => 'datetime',
    ];

    // Relationships
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function consumer()
    {
        return $this->belongsTo(Consumer::class);
    }

    public function pointTransactions()
    {
        return $this->hasMany(PointTransaction::class);
    }
}

// app/Models/SellerRankHistory.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerRankHistory extends Model
{
    use HasFactory;

    protected $table = 'seller_rank_history';

    public $timestamps = false; // This table only has achieved_at

    protected $fillable = [
        'seller_id',
        'rank_id',
        'achieved_at',
    ];

    protected $casts = [
        'achieved_at' => 'datetime',
    ];

    // Relationships
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function rank()
    {
        return $this->belongsTo(Rank::class);
    }
}
