@extends('layouts.app')

@section('title', 'Redemptions - Green Cup App')
@section('page-title', 'Redemptions')

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

.redemptions-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(25px);
    -webkit-backdrop-filter: blur(25px);
    border-radius: 20px;
    padding: 32px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    border: 1px solid rgba(255,255,255,0.3);
    margin-bottom: 32px;
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

.redemptions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 24px;
}

.redemption-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 24px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.1);
    border: 1px solid rgba(255,255,255,0.3);
    transition: all 0.4s;
}

.redemption-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 25px 60px rgba(0,0,0,0.15);
}

.redemption-card.pending {
    border-left: 4px solid #f59e0b;
}

.redemption-card.approved {
    border-left: 4px solid #10b981;
}

.redemption-card.rejected {
    border-left: 4px solid #ef4444;
}

.status-badge {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
}

.status-pending {
    background: #fef3c7;
    color: #92400e;
}

.status-approved {
    background: #d1fae5;
    color: #065f46;
}

.status-rejected {
    background: #fee2e2;
    color: #991b1b;
}

.action-btn {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    color: white;
    padding: 10px 20px;
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

.btn-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}

.btn-success:hover {
    box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
}

.btn-danger {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
}

.btn-danger:hover {
    box-shadow: 0 8px 20px rgba(239, 68, 68, 0.3);
}

@media (max-width: 768px) {
    .stats-row {
        grid-template-columns: 1fr;
    }
    .redemptions-grid {
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

        @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="redemptions-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1">Redemptions</h2>
                    <p class="text-muted mb-0">Review and approve redemption requests</p>
                </div>
                <a href="{{ route('reward.index') }}" class="action-btn">
                    <i class="fas fa-arrow-left me-2"></i>Back to Rewards
                </a>
            </div>
        </div>

        <div class="stats-row">
            <div class="stat-card">
                <div style="font-size: 2.5rem;">⏳</div>
                <h3 class="fw-bold mt-2">{{ $redemptions->where('is_redeemed', false)->count() }}</h3>
                <p class="text-muted mb-0 small">PENDING</p>
            </div>
            <div class="stat-card">
                <div style="font-size: 2.5rem;">✅</div>
                <h3 class="fw-bold mt-2">{{ $redemptions->where('is_redeemed', true)->count() }}</h3>
                <p class="text-muted mb-0 small">APPROVED</p>
            </div>
            <div class="stat-card">
                <div style="font-size: 2.5rem;">📊</div>
                <h3 class="fw-bold mt-2">{{ $redemptions->count() }}</h3>
                <p class="text-muted mb-0 small">TOTAL REQUESTS</p>
            </div>
        </div>

        @if($redemptions->count() > 0)
        <div class="redemptions-grid">
            @foreach($redemptions as $redemption)
            <div class="redemption-card {{ $redemption->status }}">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted small fw-bold">#{{ str_pad($redemption->id, 4, '0', STR_PAD_LEFT) }}</span>
                    @if($redemption->is_redeemed === false)
                        <span class="status-badge status-pending">Pending</span>
                    @elseif($redemption->is_redeemed === true)
                        <span class="status-badge status-approved">Approved</span>
                    @else
                        <span class="status-badge status-rejected">Rejected</span>
                    @endif
                </div>

                <div class="mb-3">
                    <h5 class="fw-bold mb-1">{{ $redemption->consumer->name }}</h5>
                    <p class="text-muted small mb-1"><i class="fas fa-envelope me-1"></i>{{ $redemption->consumer->email }}</p>
                    <p class="text-muted small mb-0"><i class="fas fa-phone me-1"></i>{{ $redemption->consumer->phone_number }}</p>
                </div>

                <div class="bg-light p-3 rounded mb-3">
                    <h6 class="fw-bold mb-1">{{ $redemption->reward->name }}</h6>
                    <p class="text-muted small mb-0"><i class="fas fa-star me-1"></i>{{ number_format($redemption->reward->points_required) }} points</p>
                </div>

                <p class="text-muted small mb-3">
                    <i class="fas fa-clock me-1"></i>{{ $redemption->created_at->diffForHumans() }}
                </p>

                @if($redemption->is_redeemed === false)
                <div class="d-flex gap-2">
                    <form method="POST" action="{{ route('reward.redemptions.approve', $redemption->id) }}" class="flex-fill">
                        @csrf
                        <button type="submit" class="action-btn btn-success w-100" onclick="return confirm('Approve this redemption?')">
                            <i class="fas fa-check me-1"></i>Approve
                        </button>
                    </form>
                    <form method="POST" action="{{ route('reward.redemptions.reject', $redemption->id) }}" class="flex-fill">
                        @csrf
                        <button type="submit" class="action-btn btn-danger w-100" onclick="return confirm('Reject this redemption?')">
                            <i class="fas fa-times me-1"></i>Reject
                        </button>
                    </form>
                </div>
                @elseif($redemption->is_redeemed === true)
                <div class="alert alert-success mb-0 small">
                    <i class="fas fa-check-circle me-1"></i>Approved {{ isset($redemption->approved_at) ? $redemption->approved_at->diffForHumans() : 'recently' }}
                </div>
                @else
                <div class="alert alert-danger mb-0 small">
                    <i class="fas fa-times-circle me-1"></i>Rejected
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @else
        <div class="redemptions-card text-center py-5">
            <div style="font-size: 5rem;">🎁</div>
            <h3 class="fw-bold mt-3">No Redemptions</h3>
            <p class="text-muted">Redemption requests will appear here</p>
        </div>
        @endif
    </div>
</div>
@endsection
