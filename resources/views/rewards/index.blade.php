@extends('layouts.app')

@section('title', 'Rewards - Green Cup App')
@section('page-title', 'Rewards')
@section('page-subtitle', 'Manage your rewards')

@push('styles')
<style>
.dashboard-container {
    min-height: 100vh;
    background: linear-gradient(-45deg, #00b09b, #00c9a1, #00d9a6, #00e8ab, #00b09b);
    background-size: 400% 400%;
    animation: gradientShift 20s ease infinite;
    padding-bottom: 40px;
}

@keyframes gradientShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.main-content {
    max-width: 1100px;
    margin: 0 auto;
    padding: 32px 20px;
}

.rewards-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(25px);
    -webkit-backdrop-filter: blur(25px);
    border-radius: 20px;
    padding: 32px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    border: 1px solid rgba(255,255,255,0.3);
    margin-bottom: 32px;
}

.action-btn {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    color: white;
    padding: 12px 24px;
    border-radius: 12px;
    border: none;
    font-weight: 600;
    transition: all 0.3s;
    text-decoration: none;
    display: inline-block;
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
    color: white;
    text-decoration: none;
}

.btn-orange {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
}

.btn-orange:hover {
    box-shadow: 0 8px 20px rgba(245, 158, 11, 0.3);
}

.stats-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 32px;
}

.stat-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(25px);
    border-radius: 18px;
    padding: 28px 24px;
    text-align: center;
    box-shadow: 0 15px 40px rgba(0,0,0,0.1);
    border: 1px solid rgba(255,255,255,0.3);
    transition: all 0.4s;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 25px 60px rgba(0,0,0,0.15);
}

.rewards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 24px;
}

.reward-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 15px 40px rgba(0,0,0,0.1);
    border: 1px solid rgba(255,255,255,0.3);
    transition: all 0.4s;
}

.reward-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 60px rgba(0,0,0,0.15);
}

.reward-image {
    height: 200px;
    background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 80px;
    position: relative;
    overflow: hidden;
}

.reward-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s;
}

.reward-card:hover .reward-image img {
    transform: scale(1.1);
}

.points-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    background: rgba(255,255,255,0.95);
    padding: 8px 16px;
    border-radius: 20px;
    font-weight: 700;
    color: #00b09b;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.status-badge {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
}

.status-active {
    background: #d1fae5;
    color: #065f46;
}

.status-inactive {
    background: #fee2e2;
    color: #991b1b;
}

.status-expired {
    background: #fef3c7;
    color: #92400e;
}

@media (max-width: 768px) {
    .stats-row {
        grid-template-columns: 1fr;
    }
    .rewards-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush

@section('content')
<div class="dashboard-container">
    <div class="main-content">

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="rewards-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1">Rewards</h2>
                    <p class="text-muted mb-0">Manage your rewards</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('reward.create') }}" class="action-btn">
                        <i class="fas fa-plus me-2"></i>Add Reward
                    </a>
                    <a href="{{ route('reward.redemptions') }}" class="action-btn btn-orange">
                        <i class="fas fa-gift me-2"></i>Redemptions
                    </a>
                </div>
            </div>
        </div>

        <div class="stats-row">
            <div class="stat-card">
                <div style="font-size: 2.5rem;">🎁</div>
                <h3 class="fw-bold mt-2">{{ $rewards->total() }}</h3>
                <p class="text-muted mb-0 small">TOTAL REWARDS</p>
            </div>
            <div class="stat-card">
                <div style="font-size: 2.5rem;">✅</div>
                <h3 class="fw-bold mt-2">{{ $rewards->where('is_active', true)->count() }}</h3>
                <p class="text-muted mb-0 small">ACTIVE</p>
            </div>
            <div class="stat-card">
                <div style="font-size: 2.5rem;">⭐</div>
                <h3 class="fw-bold mt-2">{{ $rewards->sum('quantity_redeemed') }}</h3>
                <p class="text-muted mb-0 small">TOTAL REDEEMED</p>
            </div>
            <div class="stat-card">
                <div style="font-size: 2.5rem;">📦</div>
                <h3 class="fw-bold mt-2">{{ $rewards->sum('quantity') - $rewards->sum('quantity_redeemed') }}</h3>
                <p class="text-muted mb-0 small">AVAILABLE STOCK</p>
            </div>
        </div>

        @if($rewards->count() > 0)
        <div class="rewards-grid">
            @foreach($rewards as $reward)
            <div class="reward-card">
                <div class="reward-image">
                    @if($reward->image_path)
                        <img src="{{ $reward->image_path }}" alt="{{ $reward->name }}">
                    @else
                        🎁
                    @endif
                    <div class="points-badge">{{ number_format($reward->points_required) }} pts</div>
                </div>
                <div class="p-4">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="fw-bold mb-0">{{ $reward->name }}</h5>
                        @if($reward->isValid())
                            <span class="status-badge status-active">Active</span>
                        @elseif($reward->valid_until < now()->toDateString())
                            <span class="status-badge status-expired">Expired</span>
                        @else
                            <span class="status-badge status-inactive">Inactive</span>
                        @endif
                    </div>
                    <p class="text-muted small mb-3">{{ Str::limit($reward->description ?? 'Reward', 80) }}</p>
                    <div class="d-flex justify-content-between mb-3 small">
                        <span class="text-muted">Available: <strong>{{ $reward->available_quantity }}</strong></span>
                        <span class="text-muted">Valid until: <strong>{{ $reward->valid_until->format('M d, Y') }}</strong></span>
                    </div>
                    <a href="{{ route('reward.edit', $reward) }}" class="action-btn w-100 text-center">Edit Reward</a>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="rewards-card text-center py-5">
            <div style="font-size: 5rem;">🎁</div>
            <h3 class="fw-bold mt-3">No Rewards</h3>
            <p class="text-muted">Create your first reward</p>
            <a href="{{ route('reward.create') }}" class="action-btn mt-3">Add Reward</a>
        </div>
        @endif
    </div>
</div>
@endsection
