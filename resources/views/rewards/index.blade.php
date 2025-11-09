@extends('layouts.app')

@section('title', 'Rewards Management')
@section('page-title', 'Rewards')

@push('styles')
<style>
/* Optimized scrolling performance */
html {
    scroll-behavior: auto;
}

body {
    overflow-x: hidden;
    -webkit-overflow-scrolling: touch;
}

/* GPU acceleration for better scrolling */
.page-wrapper,
.reward-card,
.stat-card {
    transform: translateZ(0);
    will-change: auto;
    backface-visibility: hidden;
}

.page-wrapper *,
.reward-card *,
.stat-card * {
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

/* Ensure navbar stays fixed */
nav.navbar {
    position: sticky !important;
    top: 0 !important;
    z-index: 9999 !important;
}

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
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
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
    background: #667eea;
}

/* Stats Cards */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    padding: 2rem;
    position: relative;
    contain: layout style paint;
}

.stat-card::before {
    display: none;
}

.stat-card:hover {
    border-color: #667eea;
}

.stat-icon {
    width: 64px;
    height: 64px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    margin-bottom: 1rem;
    background: #667eea;
    color: white;
}

.stat-value {
    font-size: 2.5rem;
    font-weight: 800;
    color: #667eea;
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
    background: #ffffff;
    border-radius: 24px;
    border: 2px solid #e2e8f0;
    overflow: hidden;
    position: relative;
    contain: layout style paint;
}

.reward-card::after {
    display: none;
}

.reward-card:hover {
    border-color: #667eea;
}

.reward-image-container {
    height: 220px;
    background: #f5f7fa;
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
}

.reward-card:hover .reward-image-container img {
    transform: none;
}

.reward-image-overlay {
    display: none;
}

.points-badge {
    position: absolute;
    top: 16px;
    right: 16px;
    background: #ffffff;
    padding: 12px 20px;
    border-radius: 16px;
    font-weight: 800;
    font-size: 1rem;
    color: #667eea;
    border: 2px solid #667eea;
    z-index: 2;
}

.reward-card:hover .points-badge {
    /* No hover effect */
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
    border: 1px solid;
}

.status-badge i {
    font-size: 0.875rem;
}

.status-active {
    background: #d1fae5;
    color: #065f46;
    border-color: #a7f3d0;
}

.status-inactive {
    background: #fee2e2;
    color: #991b1b;
    border-color: #fecaca;
}

.status-expired {
    background: #fef3c7;
    color: #92400e;
    border-color: #fde68a;
}

/* Action Buttons */
.btn-modern {
    padding: 0.875rem 1.75rem;
    border-radius: 14px;
    border: 2px solid;
    font-weight: 600;
    font-size: 0.9375rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.625rem;
    position: relative;
}

.btn-modern::before {
    display: none;
}

.btn-modern:hover {
    opacity: 0.9;
}

.btn-primary-modern {
    background: #667eea;
    color: white;
    border-color: #667eea;
}

.btn-success-modern {
    background: #10b981;
    color: white;
    border-color: #10b981;
}

.btn-modern-outline {
    background: #ffffff;
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
    background: #ffffff;
    border-radius: 24px;
    padding: 4rem 2rem;
    text-align: center;
    border: 2px solid #e2e8f0;
}

.empty-state-icon {
    font-size: 6rem;
    color: #667eea;
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

/* Animations - Disabled for performance */
.animate-fade-in {
    animation: none;
    opacity: 1;
}
</style>
@endpush

@section('content')
<div class="page-wrapper">
    <div class="container-fluid px-4">

        <!-- Header Card -->
        <div class="header-card position-relative">
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
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-gift"></i>
                </div>
                <div class="stat-value">{{ $rewards->total() }}</div>
                <div class="stat-label">Total Rewards</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: #10b981;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-value" style="color: #10b981;">
                    {{ $rewards->where('is_active', true)->count() }}
                </div>
                <div class="stat-label">Active Rewards</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: #f59e0b;">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stat-value" style="color: #f59e0b;">
                    {{ $rewards->sum('quantity_redeemed') }}
                </div>
                <div class="stat-label">Total Redeemed</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: #ec4899;">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stat-value" style="color: #ec4899;">
                    {{ $rewards->sum(function($reward) { return $reward->available_quantity; }) }}
                </div>
                <div class="stat-label">Available Stock</div>
            </div>
        </div>

        <!-- Rewards Grid -->
        @if($rewards->count() > 0)
        <div class="rewards-grid">
            @foreach($rewards as $reward)
            <div class="reward-card">
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
        <div class="empty-state">
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
// Countdown disabled for performance - static display only
document.addEventListener('DOMContentLoaded', function() {
    console.log('Reward page loaded - live countdown disabled for better performance');
});
</script>
@endpush
