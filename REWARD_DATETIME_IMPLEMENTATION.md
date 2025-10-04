# Reward Date & Time Implementation Guide

## Overview
This document provides the complete implementation guide for adding **date AND time** support to reward validity, including countdown timers visible to consumers.

---

## 🔧 Backend Implementation (GreenCup_Admin Project)

### 1. Database Migration

Create a new migration file in `GreenCup_Admin/database/migrations/`:

**File: `YYYY_MM_DD_HHMMSS_change_rewards_valid_dates_to_datetime.php`**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('rewards', function (Blueprint $table) {
            // Change date columns to datetime
            $table->dateTime('valid_from')->change();
            $table->dateTime('valid_until')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rewards', function (Blueprint $table) {
            // Revert back to date
            $table->date('valid_from')->change();
            $table->date('valid_until')->change();
        });
    }
};
```

**Run the migration:**
```bash
cd path/to/GreenCup_Admin
php artisan migrate
```

---

### 2. SQL Alternative (If migration fails)

If the Laravel migration doesn't work due to SQLite limitations, run this SQL directly:

```sql
-- For MySQL/MariaDB
ALTER TABLE rewards 
MODIFY COLUMN valid_from DATETIME NOT NULL,
MODIFY COLUMN valid_until DATETIME NOT NULL;

-- For PostgreSQL
ALTER TABLE rewards 
ALTER COLUMN valid_from TYPE TIMESTAMP,
ALTER COLUMN valid_until TYPE TIMESTAMP;

-- For SQLite (requires recreation)
-- Step 1: Create new table with datetime
CREATE TABLE rewards_new (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    points_required INTEGER NOT NULL,
    quantity INTEGER NOT NULL,
    quantity_redeemed INTEGER DEFAULT 0,
    image_path VARCHAR(255),
    valid_from DATETIME NOT NULL,
    valid_until DATETIME NOT NULL,
    is_active BOOLEAN DEFAULT 1,
    seller_id INTEGER NOT NULL,
    created_at DATETIME,
    updated_at DATETIME,
    FOREIGN KEY (seller_id) REFERENCES sellers(id) ON DELETE CASCADE
);

-- Step 2: Copy data (converting date to datetime at midnight)
INSERT INTO rewards_new 
SELECT 
    id, name, description, points_required, quantity, quantity_redeemed, 
    image_path,
    datetime(valid_from) as valid_from,
    datetime(valid_until, '+23 hours +59 minutes +59 seconds') as valid_until,
    is_active, seller_id, created_at, updated_at
FROM rewards;

-- Step 3: Drop old table and rename
DROP TABLE rewards;
ALTER TABLE rewards_new RENAME TO rewards;
```

---

### 3. Model Updates (GreenCup_Admin)

**File: `GreenCup_Admin/app/Models/Reward.php`**

```php
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
        'valid_from' => 'datetime',  // ✅ Changed from 'date' to 'datetime'
        'valid_until' => 'datetime', // ✅ Changed from 'date' to 'datetime'
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

    /**
     * Check if reward is currently valid
     * Now checks DATETIME not just DATE
     */
    public function isValid()
    {
        $now = now();
        return $this->is_active &&
               $this->valid_from <= $now &&
               $this->valid_until >= $now &&
               $this->available_quantity > 0;
    }

    /**
     * Get time remaining with hours, minutes, seconds
     */
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

    /**
     * Check if expiring soon (within specified hours)
     */
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
```

---

### 4. Controller Validation (GreenCup_Admin)

**File: `GreenCup_Admin/app/Http/Controllers/RewardController.php`**

Update the validation rules in `store()` and `update()` methods:

```php
public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'points_required' => 'required|integer|min:1',
        'quantity' => 'required|integer|min:1',
        'valid_from' => 'required|date', // ✅ Accepts datetime format
        'valid_until' => 'required|date|after:valid_from', // ✅ Ensures valid_until is after valid_from
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        'is_active' => 'nullable|boolean',
        'seller_id' => 'required|exists:sellers,id',
    ]);

    // The datetime will be automatically cast by Laravel
    $reward = Reward::create($validated);

    return response()->json([
        'success' => true,
        'message' => 'Reward created successfully',
        'reward' => $reward,
    ]);
}

public function update(Request $request, Reward $reward)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'points_required' => 'required|integer|min:1',
        'quantity' => 'required|integer|min:' . $reward->quantity_redeemed,
        'valid_from' => 'required|date',
        'valid_until' => 'required|date|after:valid_from',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        'is_active' => 'nullable|boolean',
    ]);

    $reward->update($validated);

    return response()->json([
        'success' => true,
        'message' => 'Reward updated successfully',
        'reward' => $reward,
    ]);
}
```

---

### 5. API Response Format (GreenCup_Admin)

**File: `GreenCup_Admin/app/Http/Controllers/Api/RewardController.php`**

Ensure API returns datetime in proper format:

```php
public function index(Request $request)
{
    $rewards = Reward::currentlyValid()
        ->with('seller')
        ->get()
        ->map(function ($reward) {
            return [
                'id' => $reward->id,
                'name' => $reward->name,
                'description' => $reward->description,
                'points_required' => $reward->points_required,
                'quantity' => $reward->quantity,
                'available_quantity' => $reward->available_quantity,
                'image_path' => $reward->image_path,
                'valid_from' => $reward->valid_from->toIso8601String(), // ✅ Full datetime
                'valid_until' => $reward->valid_until->toIso8601String(), // ✅ Full datetime
                'is_active' => $reward->is_active,
                'time_remaining' => $reward->time_remaining, // ✅ Include countdown data
                'is_expiring_soon' => $reward->isExpiringSoon(),
                'seller' => [
                    'id' => $reward->seller->id,
                    'business_name' => $reward->seller->business_name,
                ],
            ];
        });

    return response()->json([
        'success' => true,
        'rewards' => $rewards,
    ]);
}

public function show(Reward $reward)
{
    return response()->json([
        'success' => true,
        'reward' => [
            'id' => $reward->id,
            'name' => $reward->name,
            'description' => $reward->description,
            'points_required' => $reward->points_required,
            'available_quantity' => $reward->available_quantity,
            'image_path' => $reward->image_path,
            'valid_from' => $reward->valid_from->toIso8601String(),
            'valid_until' => $reward->valid_until->toIso8601String(),
            'time_remaining' => $reward->time_remaining,
            'human_readable_time' => $reward->getHumanReadableTimeRemaining(),
            'is_valid' => $reward->isValid(),
            'is_expiring_soon' => $reward->isExpiringSoon(),
        ],
    ]);
}
```

---

## 🎨 Frontend Implementation (GreenCup_Consumer Project)

### 1. Reward Card with Countdown Timer

**File: `GreenCup_Consumer/resources/views/rewards/index.blade.php`**

```blade
<div class="rewards-grid">
    @foreach($rewards as $reward)
        <div class="reward-card" data-reward-id="{{ $reward->id }}">
            <div class="reward-image">
                @if($reward->image_path)
                    <img src="{{ asset($reward->image_path) }}" alt="{{ $reward->name }}">
                @else
                    <div class="placeholder-image">🎁</div>
                @endif
            </div>

            <div class="reward-content">
                <h3 class="reward-name">{{ $reward->name }}</h3>
                <p class="reward-description">{{ $reward->description }}</p>

                <div class="reward-info">
                    <div class="points-badge">
                        {{ $reward->points_required }} pts
                    </div>
                    <div class="quantity-badge">
                        {{ $reward->available_quantity }} left
                    </div>
                </div>

                <!-- ✅ COUNTDOWN TIMER -->
                <div class="countdown-timer" data-expires-at="{{ $reward->valid_until->toIso8601String() }}">
                    <div class="timer-label">⏰ Expires in:</div>
                    <div class="timer-display">
                        <span class="timer-days">0d</span>
                        <span class="timer-hours">0h</span>
                        <span class="timer-minutes">0m</span>
                        <span class="timer-seconds">0s</span>
                    </div>
                </div>

                <div class="validity-info">
                    <div class="validity-dates">
                        <div class="validity-item">
                            <span class="validity-label">From:</span>
                            <span class="validity-value">{{ $reward->valid_from->format('M j, Y g:i A') }}</span>
                        </div>
                        <div class="validity-item">
                            <span class="validity-label">Until:</span>
                            <span class="validity-value">{{ $reward->valid_until->format('M j, Y g:i A') }}</span>
                        </div>
                    </div>
                </div>

                <button class="redeem-btn" onclick="redeemReward({{ $reward->id }})">
                    Redeem Now
                </button>
            </div>
        </div>
    @endforeach
</div>

<style>
.countdown-timer {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1rem;
    border-radius: 12px;
    margin: 1rem 0;
    text-align: center;
}

.timer-label {
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    opacity: 0.9;
}

.timer-display {
    display: flex;
    justify-content: center;
    gap: 0.75rem;
    font-size: 1.25rem;
    font-weight: 700;
}

.timer-display span {
    background: rgba(255, 255, 255, 0.2);
    padding: 0.5rem 0.75rem;
    border-radius: 8px;
    min-width: 50px;
}

.countdown-timer.expiring-soon {
    background: linear-gradient(135deg, #f59e0b 0%, #ef4444 100%);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.8; }
}

.validity-info {
    background: #f8fafc;
    padding: 0.75rem;
    border-radius: 8px;
    margin-top: 1rem;
}

.validity-dates {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.validity-item {
    display: flex;
    justify-content: space-between;
    font-size: 0.875rem;
}

.validity-label {
    color: #6b7280;
    font-weight: 600;
}

.validity-value {
    color: #111827;
    font-weight: 500;
}
</style>

<script>
// ✅ COUNTDOWN TIMER LOGIC
function initializeCountdowns() {
    const timers = document.querySelectorAll('.countdown-timer');
    
    timers.forEach(timer => {
        const expiresAt = new Date(timer.dataset.expiresAt);
        
        function updateCountdown() {
            const now = new Date();
            const diff = expiresAt - now;
            
            if (diff <= 0) {
                timer.innerHTML = '<div class="timer-expired">⏰ EXPIRED</div>';
                timer.classList.add('expired');
                return;
            }
            
            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);
            
            timer.querySelector('.timer-days').textContent = `${days}d`;
            timer.querySelector('.timer-hours').textContent = `${hours}h`;
            timer.querySelector('.timer-minutes').textContent = `${minutes}m`;
            timer.querySelector('.timer-seconds').textContent = `${seconds}s`;
            
            // Mark as expiring soon (less than 24 hours)
            if (diff < 24 * 60 * 60 * 1000) {
                timer.classList.add('expiring-soon');
            }
        }
        
        // Update immediately and then every second
        updateCountdown();
        setInterval(updateCountdown, 1000);
    });
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', initializeCountdowns);
</script>
```

---

### 2. Reward Detail Page with Live Timer

**File: `GreenCup_Consumer/resources/views/rewards/show.blade.php`**

```blade
<div class="reward-detail">
    <div class="reward-header">
        <img src="{{ asset($reward->image_path) }}" alt="{{ $reward->name }}">
    </div>

    <div class="reward-body">
        <h1 class="reward-title">{{ $reward->name }}</h1>
        <p class="reward-description">{{ $reward->description }}</p>

        <!-- ✅ LARGE COUNTDOWN DISPLAY -->
        <div class="large-countdown" data-expires-at="{{ $reward->valid_until->toIso8601String() }}">
            <div class="countdown-title">⏰ Time Remaining</div>
            <div class="countdown-digits">
                <div class="digit-group">
                    <div class="digit-value days">0</div>
                    <div class="digit-label">Days</div>
                </div>
                <div class="digit-separator">:</div>
                <div class="digit-group">
                    <div class="digit-value hours">00</div>
                    <div class="digit-label">Hours</div>
                </div>
                <div class="digit-separator">:</div>
                <div class="digit-group">
                    <div class="digit-value minutes">00</div>
                    <div class="digit-label">Minutes</div>
                </div>
                <div class="digit-separator">:</div>
                <div class="digit-group">
                    <div class="digit-value seconds">00</div>
                    <div class="digit-label">Seconds</div>
                </div>
            </div>
        </div>

        <div class="validity-section">
            <div class="validity-row">
                <span class="validity-icon">🟢</span>
                <div>
                    <div class="validity-label">Active From</div>
                    <div class="validity-date">{{ $reward->valid_from->format('l, F j, Y \a\t g:i A') }}</div>
                </div>
            </div>
            <div class="validity-row">
                <span class="validity-icon">🔴</span>
                <div>
                    <div class="validity-label">Expires On</div>
                    <div class="validity-date">{{ $reward->valid_until->format('l, F j, Y \a\t g:i A') }}</div>
                </div>
            </div>
        </div>

        <button class="redeem-btn-large" onclick="redeemReward({{ $reward->id }})">
            🎁 Redeem for {{ $reward->points_required }} Points
        </button>
    </div>
</div>

<style>
.large-countdown {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    border-radius: 20px;
    margin: 2rem 0;
    text-align: center;
    box-shadow: 0 10px 40px rgba(102, 126, 234, 0.3);
}

.countdown-title {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
}

.countdown-digits {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 1rem;
}

.digit-group {
    text-align: center;
}

.digit-value {
    font-size: 3rem;
    font-weight: 900;
    background: rgba(255, 255, 255, 0.2);
    padding: 1rem 1.5rem;
    border-radius: 16px;
    min-width: 100px;
    backdrop-filter: blur(10px);
}

.digit-label {
    font-size: 0.875rem;
    margin-top: 0.5rem;
    opacity: 0.9;
    font-weight: 600;
}

.digit-separator {
    font-size: 2rem;
    font-weight: 700;
    opacity: 0.7;
}

.large-countdown.expiring-soon {
    background: linear-gradient(135deg, #f59e0b 0%, #ef4444 100%);
    animation: pulse 2s infinite;
}

.validity-section {
    background: #f8fafc;
    padding: 1.5rem;
    border-radius: 16px;
    margin: 2rem 0;
}

.validity-row {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    margin-bottom: 0.5rem;
}

.validity-icon {
    font-size: 1.5rem;
}

.validity-label {
    font-size: 0.875rem;
    color: #6b7280;
    font-weight: 600;
}

.validity-date {
    font-size: 1.125rem;
    color: #111827;
    font-weight: 700;
}
</style>

<script>
function initializeLargeCountdown() {
    const countdown = document.querySelector('.large-countdown');
    if (!countdown) return;
    
    const expiresAt = new Date(countdown.dataset.expiresAt);
    
    function updateCountdown() {
        const now = new Date();
        const diff = expiresAt - now;
        
        if (diff <= 0) {
            countdown.innerHTML = '<div class="countdown-expired">⏰ THIS REWARD HAS EXPIRED</div>';
            countdown.classList.add('expired');
            document.querySelector('.redeem-btn-large').disabled = true;
            return;
        }
        
        const days = Math.floor(diff / (1000 * 60 * 60 * 24));
        const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((diff % (1000 * 60)) / 1000);
        
        countdown.querySelector('.digit-value.days').textContent = days;
        countdown.querySelector('.digit-value.hours').textContent = String(hours).padStart(2, '0');
        countdown.querySelector('.digit-value.minutes').textContent = String(minutes).padStart(2, '0');
        countdown.querySelector('.digit-value.seconds').textContent = String(seconds).padStart(2, '0');
        
        // Mark as expiring soon
        if (diff < 24 * 60 * 60 * 1000) {
            countdown.classList.add('expiring-soon');
        }
    }
    
    updateCountdown();
    setInterval(updateCountdown, 1000);
}

document.addEventListener('DOMContentLoaded', initializeLargeCountdown);
</script>
```

---

## 🧪 Testing Checklist

### Backend (GreenCup_Admin)
- [ ] Migration runs successfully
- [ ] `valid_from` and `valid_until` columns are now DATETIME type
- [ ] Creating new reward with date+time works
- [ ] Updating existing reward with date+time works
- [ ] API returns ISO8601 datetime strings
- [ ] `isValid()` method checks datetime not just date
- [ ] `time_remaining` attribute returns correct countdown data

### Frontend (GreenCup_Seller)
- [ ] Create reward form has datetime-local inputs
- [ ] Edit reward form has datetime-local inputs  
- [ ] Form validation prevents valid_until before valid_from
- [ ] Datetime values are properly displayed and saved

### Frontend (GreenCup_Consumer)
- [ ] Reward cards show countdown timer
- [ ] Countdown updates every second
- [ ] Timer shows days, hours, minutes, seconds
- [ ] Expiring soon rewards show warning style
- [ ] Expired rewards show "EXPIRED" message
- [ ] Reward detail page shows large countdown
- [ ] Validity dates show full datetime format

---

## 🚨 Critical Bug Fixes

### 1. Timezone Consistency
Ensure all projects use the same timezone in `config/app.php`:

```php
'timezone' => 'Asia/Phnom_Penh', // or your timezone
```

### 2. Date Format Consistency
Use ISO8601 format for API responses:
```php
$reward->valid_until->toIso8601String(); // 2025-10-04T23:59:59+07:00
```

### 3. JavaScript Date Parsing
Always use ISO8601 strings in JavaScript:
```javascript
const expiresAt = new Date(timer.dataset.expiresAt); // Must be ISO8601
```

### 4. Server-Side Validation
```php
'valid_from' => 'required|date',
'valid_until' => 'required|date|after:valid_from',
```

---

## 📝 Deployment Steps

1. **Backup Database**
   ```bash
   # For SQLite
   cp database/database.sqlite database/database.backup.sqlite
   
   # For MySQL
   mysqldump -u username -p database_name > backup.sql
   ```

2. **Apply Migration (GreenCup_Admin)**
   ```bash
   cd GreenCup_Admin
   php artisan migrate
   ```

3. **Update Model** - Apply changes to `Reward.php`

4. **Update Controllers** - Apply validation changes

5. **Clear Cache**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan view:clear
   ```

6. **Test API Endpoints**
   - GET /api/rewards
   - GET /api/rewards/{id}
   - POST /api/rewards
   - PUT /api/rewards/{id}

7. **Deploy Consumer Frontend** - Update reward views with countdown timers

8. **Verify Countdown** - Check that timers update in real-time

---

## 📚 Additional Notes

- **Performance**: Countdown timers run client-side, no server load
- **Accuracy**: JavaScript timers may drift slightly; refresh periodically
- **Mobile**: Countdown continues even when app is backgrounded
- **Notifications**: Consider adding push notifications when rewards are expiring soon
- **Analytics**: Track how countdown affects redemption rates

---

**Status**: Ready for implementation ✅
**Priority**: HIGH - Dead serious part as specified 🔥
**Last Updated**: October 4, 2025
