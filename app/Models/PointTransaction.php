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

// app/Models/Consumer.php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Consumer extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'email',
        'phone_number',
        'gender',
        'date_of_birth',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
        'date_of_birth' => 'date',
    ];

    // Relationships
    public function pointTransactions()
    {
        return $this->hasMany(PointTransaction::class);
    }

    public function qrCodes()
    {
        return $this->hasMany(QrCode::class);
    }
}

// app/Models/Item.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'points_per_unit',
    ];

    protected $casts = [
        'points_per_unit' => 'integer',
    ];

    // Relationships
    public function qrCodes()
    {
        return $this->hasMany(QrCode::class);
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