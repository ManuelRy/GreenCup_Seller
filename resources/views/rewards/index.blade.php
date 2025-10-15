@extends('layouts.app')

@section('title', 'Rewards Management')
@section('page-title', 'Rewards')

@push('styles')
<style>
/* Modern Professional Design */
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    --danger-gradient: linear-gradient(135deg, #eb3349 0%, #f45c43 100%);
    --warning-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.page-wrapper {
    min-height: 100vh;
    padding: 2rem 0;
}

/* Header Card */
.header-card {
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(20px);
    border-radius: 24px;
    border: none;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    margin-bottom: 2rem;
    overflow: hidden;
}

.header-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--primary-gradient);
}

/* Stats Cards */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    border: none;
    padding: 2rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, transparent 0%, rgba(102, 126, 234, 0.05) 100%);
    opacity: 0;
    transition: opacity 0.4s;
}

.stat-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 20px 60px rgba(102, 126, 234, 0.25);
}

.stat-card:hover::before {
    opacity: 1;
}

.stat-icon {
    width: 64px;
    height: 64px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    margin-bottom: 1rem;
    background: var(--primary-gradient);
    color: white;
    box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);
}

.stat-value {
    font-size: 2.5rem;
    font-weight: 800;
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    line-height: 1.2;
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Rewards Grid */
.rewards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 1.5rem;
    margin-top: 2rem;
}

.reward-card {
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(20px);
    border-radius: 24px;
    border: none;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
}

.reward-card::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    border-radius: 24px;
    padding: 2px;
    background: var(--primary-gradient);
    -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
    mask-composite: exclude;
    opacity: 0;
    transition: opacity 0.4s;
    pointer-events: none;
}

.reward-card:hover {
    transform: translateY(-12px);
    box-shadow: 0 20px 60px rgba(102, 126, 234, 0.25);
}

.reward-card:hover::after {
    opacity: 1;
}

.reward-image-container {
    height: 220px;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 80px;
    position: relative;
    overflow: hidden;
}

.reward-image-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.reward-card:hover .reward-image-container img {
    transform: scale(1.1);
}

.reward-image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, transparent 0%, rgba(0, 0, 0, 0.7) 100%);
    opacity: 0;
    transition: opacity 0.4s;
}

.reward-card:hover .reward-image-overlay {
    opacity: 1;
}

.points-badge {
    position: absolute;
    top: 16px;
    right: 16px;
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(10px);
    padding: 12px 20px;
    border-radius: 16px;
    font-weight: 800;
    font-size: 1rem;
    color: #667eea;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
    border: 2px solid rgba(255, 255, 255, 0.9);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 2;
}

.reward-card:hover .points-badge {
    transform: scale(1.1) rotate(-5deg);
    box-shadow: 0 12px 32px rgba(102, 126, 234, 0.4);
}

.reward-body {
    padding: 1.5rem;
}

.reward-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.5rem;
}

.reward-description {
    font-size: 0.875rem;
    color: #64748b;
    margin-bottom: 1rem;
    line-height: 1.6;
}

.reward-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 1rem;
    border-top: 2px solid #f1f5f9;
    font-size: 0.8125rem;
    color: #64748b;
    font-weight: 600;
}

/* Status Badges */
.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transition: all 0.3s;
}

.status-badge i {
    font-size: 0.875rem;
}

.status-active {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    color: #065f46;
}

.status-inactive {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    color: #991b1b;
}

.status-expired {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    color: #92400e;
}

/* Action Buttons */
.btn-modern {
    padding: 0.875rem 1.75rem;
    border-radius: 14px;
    border: none;
    font-weight: 600;
    font-size: 0.9375rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.625rem;
    position: relative;
    overflow: hidden;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
}

.btn-modern::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}

.btn-modern:hover::before {
    width: 300px;
    height: 300px;
}

.btn-modern:hover {
    transform: translateY(-3px);
    box-shadow: 0 16px 40px rgba(0, 0, 0, 0.25);
}

.btn-primary-modern {
    background: var(--primary-gradient);
    color: white;
}

.btn-success-modern {
    background: var(--success-gradient);
    color: white;
}

.btn-modern-outline {
    background: rgba(255, 255, 255, 0.98);
    color: #667eea;
    border: 2px solid #667eea;
}

.btn-modern-outline:hover {
    background: #667eea;
    color: white;
    border-color: #667eea;
}

/* Empty State */
.empty-state {
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(20px);
    border-radius: 24px;
    padding: 4rem 2rem;
    text-align: center;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
}

.empty-state-icon {
    font-size: 6rem;
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 1.5rem;
}

.empty-state-title {
    font-size: 2rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 1rem;
}

.empty-state-text {
    font-size: 1.125rem;
    color: #64748b;
    margin-bottom: 2rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .page-wrapper {
        padding: 1rem 0;
    }

    .stats-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .rewards-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .stat-card {
        padding: 1.5rem;
    }

    .stat-icon {
        width: 56px;
        height: 56px;
        font-size: 24px;
    }

    .stat-value {
        font-size: 2rem;
    }
}

@media (max-width: 480px) {
    .btn-modern {
        width: 100%;
        justify-content: center;
    }

    .header-card .d-flex {
        flex-direction: column;
        gap: 1rem;
    }
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fadeInUp 0.6s ease-out;
}
</style>
@endpush

@section('content')
<div class="page-wrapper">
    <div class="container-fluid px-4">

        <!-- Header Card -->
        <div class="header-card position-relative animate-fade-in">
            <div class="p-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <h1 class="h2 fw-bold mb-2" style="color: #1e293b;">
                            <i class="fas fa-gift me-2" style="color: #667eea;"></i>
                            Rewards Management
                        </h1>
                        <p class="text-muted mb-0">Create and manage loyalty rewards for your customers</p>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('reward.create') }}" class="btn-modern btn-primary-modern">
                            <i class="fas fa-plus"></i>
                            <span>Add Reward</span>
                        </a>
                        <a href="{{ route('reward.redemptions') }}" class="btn-modern btn-success-modern">
                            <i class="fas fa-receipt"></i>
                            <span>Redemptions</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-grid animate-fade-in">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-gift"></i>
                </div>
                <div class="stat-value">{{ $rewards->total() }}</div>
                <div class="stat-label">Total Rewards</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: var(--success-gradient);">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-value" style="background: var(--success-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                    {{ $rewards->where('is_active', true)->count() }}
                </div>
                <div class="stat-label">Active Rewards</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: var(--warning-gradient);">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stat-value" style="background: var(--warning-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                    {{ $rewards->sum('quantity_redeemed') }}
                </div>
                <div class="stat-label">Total Redeemed</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stat-value" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                    {{ $rewards->sum(function($reward) { return $reward->available_quantity; }) }}
                </div>
                <div class="stat-label">Available Stock</div>
            </div>
        </div>

        <!-- Rewards Grid -->
        @if($rewards->count() > 0)
        <div class="rewards-grid">
            @foreach($rewards as $reward)
            <div class="reward-card animate-fade-in" style="animation-delay: {{ $loop->index * 0.1 }}s;">
                <div class="reward-image-container">
                    @if($reward->image_path)
                        <img src="{{ $reward->image_path }}" alt="{{ $reward->name }}">
                    @else
                        <i class="fas fa-gift" style="color: #cbd5e1;"></i>
                    @endif
                    <div class="reward-image-overlay"></div>
                    <div class="points-badge">
                        <i class="fas fa-coins"></i>
                        {{ number_format($reward->points_required) }} pts
                    </div>
                </div>

                <div class="reward-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h3 class="reward-title mb-0">{{ $reward->name }}</h3>
                        @if($reward->is_active)
                            <span class="status-badge status-active">
                                <i class="fas fa-check"></i>
                                Active
                            </span>
                        @else
                            <span class="status-badge status-inactive">
                                <i class="fas fa-times"></i>
                                Inactive
                            </span>
                        @endif
                    </div>

                    <p class="reward-description">
                        {{ Str::limit($reward->description ?? 'No description available', 100) }}
                    </p>

                    <div class="reward-meta mb-3">
                        <span>
                            <i class="fas fa-box me-1"></i>
                            Stock: <strong>{{ $reward->available_quantity }}/{{ $reward->quantity }}</strong>
                        </span>
                        <span>
                            <i class="fas fa-calendar-alt me-1"></i>
                            Redeemed: <strong>{{ $reward->quantity_redeemed }}</strong>
                        </span>
                    </div>

                    <!-- Time Remaining Display -->
                    @php
                        $now = \Carbon\Carbon::now('Asia/Phnom_Penh');
                        $hasStarted = $now->isAfter($reward->valid_from);
                        $isExpired = $now->isAfter($reward->valid_until);
                        $isValid = $reward->isValid();

                        // Determine status and border color
                        if (!$hasStarted) {
                            $borderColor = '#3b82f6'; // Blue for coming soon
                            $statusIcon = 'fa-hourglass-start';
                            $statusLabel = 'Coming Soon';
                        } elseif ($isExpired) {
                            $borderColor = '#ef4444'; // Red for expired
                            $statusIcon = 'fa-times-circle';
                            $statusLabel = 'Expired';
                        } elseif ($reward->isExpiringSoon(48)) {
                            $borderColor = '#f59e0b'; // Amber for expiring soon
                            $statusIcon = 'fa-clock';
                            $statusLabel = 'Time Remaining';
                        } else {
                            $borderColor = '#10b981'; // Green for active
                            $statusIcon = 'fa-clock';
                            $statusLabel = 'Time Remaining';
                        }
                    @endphp
                    <div class="mb-2 reward-time-container" style="background: #f8fafc; padding: 0.75rem; border-radius: 12px; border-left: 4px solid {{ $borderColor }};">
                        <div style="font-size: 0.75rem; color: #64748b; font-weight: 600; text-transform: uppercase; margin-bottom: 0.25rem;">
                            <i class="fas {{ $statusIcon }} me-1"></i>{{ $statusLabel }}
                        </div>
                        <div style="font-size: 0.875rem; font-weight: 700; color: #1e293b;"
                             class="time-remaining-live"
                             data-expiry="{{ \Carbon\Carbon::parse($reward->valid_until)->toIso8601String() }}"
                             data-start="{{ \Carbon\Carbon::parse($reward->valid_from)->toIso8601String() }}">
                            @if(!$hasStarted)
                                Starts {{ \Carbon\Carbon::parse($reward->valid_from)->diffForHumans() }}
                            @elseif($isExpired)
                                Expired {{ \Carbon\Carbon::parse($reward->valid_until)->diffForHumans() }}
                            @else
                                {{ $reward->getHumanReadableTimeRemaining() }}
                            @endif
                        </div>
                        <div style="font-size: 0.75rem; color: #64748b; margin-top: 0.25rem;">
                            Valid: {{ \Carbon\Carbon::parse($reward->valid_from)->format('M d, Y g:i A') }} - {{ \Carbon\Carbon::parse($reward->valid_until)->format('M d, Y g:i A') }}
                        </div>
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('reward.edit', $reward) }}" class="btn-modern btn-modern-outline w-100">
                            <i class="fas fa-edit"></i>
                            <span>Edit Reward</span>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="empty-state animate-fade-in">
            <div class="empty-state-icon">
                <i class="fas fa-gift"></i>
            </div>
            <h2 class="empty-state-title">No Rewards Yet</h2>
            <p class="empty-state-text">Start creating rewards to engage your customers</p>
            <a href="{{ route('reward.create') }}" class="btn-modern btn-primary-modern">
                <i class="fas fa-plus"></i>
                <span>Create Your First Reward</span>
            </a>
        </div>
        @endif

    </div>
</div>
@endsection

@push('scripts')
<script>
// Live countdown timer for rewards
function updateCountdowns() {
    document.querySelectorAll('.reward-card').forEach((card, index) => {
        const timeDisplay = card.querySelector('.time-remaining-live');
        if (!timeDisplay) return;

        const startTime = new Date(timeDisplay.dataset.start).getTime();
        const expiryTime = new Date(timeDisplay.dataset.expiry).getTime();
        const now = new Date().getTime();
        const container = timeDisplay.closest('.reward-time-container');
        const statusLabel = container.querySelector('.fas').parentElement;

        // Check if reward hasn't started yet
        if (now < startTime) {
            const distanceToStart = startTime - now;
            const days = Math.floor(distanceToStart / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distanceToStart % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distanceToStart % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distanceToStart % (1000 * 60)) / 1000);

            let timeString = 'Starts in ';
            if (days > 0) {
                timeString += `${days}d ${hours}h ${minutes}m ${seconds}s`;
            } else if (hours > 0) {
                timeString += `${hours}h ${minutes}m ${seconds}s`;
            } else if (minutes > 0) {
                timeString += `${minutes}m ${seconds}s`;
            } else {
                timeString += `${seconds}s`;
            }

            timeDisplay.textContent = timeString;
            container.style.borderLeftColor = '#3b82f6'; // Blue for coming soon
            statusLabel.innerHTML = '<i class="fas fa-hourglass-start me-1"></i>COMING SOON';
            return;
        }

        // Check if reward has expired
        const distanceToExpiry = expiryTime - now;
        if (distanceToExpiry < 0) {
            // Calculate how long ago it expired
            const expiredAgo = Math.abs(distanceToExpiry);
            const days = Math.floor(expiredAgo / (1000 * 60 * 60 * 24));
            const hours = Math.floor((expiredAgo % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));

            let expiredText = 'Expired ';
            if (days > 0) {
                expiredText += `${days} day${days > 1 ? 's' : ''} ago`;
            } else if (hours > 0) {
                expiredText += `${hours} hour${hours > 1 ? 's' : ''} ago`;
            } else {
                expiredText += 'recently';
            }

            timeDisplay.innerHTML = `<span style="color: #ef4444;">${expiredText}</span>`;
            container.style.borderLeftColor = '#ef4444'; // Red for expired
            statusLabel.innerHTML = '<i class="fas fa-times-circle me-1"></i>EXPIRED';
            return;
        }

        // Reward is active - show time remaining
        const days = Math.floor(distanceToExpiry / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distanceToExpiry % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distanceToExpiry % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distanceToExpiry % (1000 * 60)) / 1000);

        let timeString = '';
        if (days > 0) {
            timeString = `${days}d ${hours}h ${minutes}m ${seconds}s`;
        } else if (hours > 0) {
            timeString = `${hours}h ${minutes}m ${seconds}s`;
        } else if (minutes > 0) {
            timeString = `${minutes}m ${seconds}s`;
        } else {
            timeString = `${seconds}s`;
        }

        timeDisplay.textContent = timeString;

        // Update border color based on urgency
        const totalHours = distanceToExpiry / (1000 * 60 * 60);
        if (totalHours <= 24) {
            container.style.borderLeftColor = '#ef4444'; // Red - urgent!
            statusLabel.innerHTML = '<i class="fas fa-exclamation-triangle me-1"></i>TIME REMAINING';
        } else if (totalHours <= 48) {
            container.style.borderLeftColor = '#f59e0b'; // Amber - expiring soon
            statusLabel.innerHTML = '<i class="fas fa-clock me-1"></i>TIME REMAINING';
        } else {
            container.style.borderLeftColor = '#10b981'; // Green - plenty of time
            statusLabel.innerHTML = '<i class="fas fa-clock me-1"></i>TIME REMAINING';
        }
    });
}

// Update every second
setInterval(updateCountdowns, 1000);
updateCountdowns(); // Initial call
</script>
@endpush
