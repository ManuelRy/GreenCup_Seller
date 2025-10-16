@extends('layouts.app')

@section('title', 'Redemptions - Green Cup App')
@section('page-title', 'Redemptions')

@push('styles')
<style>
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    --danger-gradient: linear-gradient(135deg, #eb3349 0%, #f45c43 100%);
}

.redemptions-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 2rem 1.5rem;
}

/* Header Card */
.header-card {
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(20px);
    border-radius: 24px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    border: none;
    position: relative;
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

/* Stats Grid */
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
    padding: 2rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.stat-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 20px 60px rgba(102, 126, 234, 0.25);
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

/* Redemptions Grid */
.redemptions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 1.5rem;
}

.redemption-card {
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(20px);
    border-radius: 24px;
    padding: 1.5rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border: none;
}

.redemption-card:hover {
    transform: translateY(-12px);
    box-shadow: 0 20px 60px rgba(102, 126, 234, 0.25);
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
}

.status-pending {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    color: #92400e;
}

.status-approved {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    color: #065f46;
}

.status-rejected {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    color: #991b1b;
}

/* Buttons */
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
    cursor: pointer;
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

.btn-danger-modern {
    background: var(--danger-gradient);
    color: white;
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
</style>
@endpush

@section('content')
<div class="redemptions-container">

    <!-- Header Card -->
    <div class="header-card">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1 class="h2 fw-bold mb-2" style="color: #1e293b;">
                    <i class="fas fa-receipt me-2" style="color: #667eea;"></i>
                    Redemptions
                </h1>
                <p class="text-muted mb-0">Review and approve redemption requests</p>
            </div>
            <a href="{{ route('reward.index') }}" class="btn-modern btn-primary-modern">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Rewards</span>
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-hourglass-half"></i>
            </div>
            <div class="stat-value">{{ $redemptions->where('is_redeemed', false)->count() }}</div>
            <div class="stat-label">Pending</div>
        </div
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                <i class="fas fa-chart-bar"></i>
            </div>
            <div class="stat-value" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">{{ $redemptions->count() }}</div>
            <div class="stat-label">Total Requests</div>
        </div>
    </div>

    <!-- Redemptions Grid -->
    @if($redemptions->count() > 0)
    <div class="redemptions-grid">
        @foreach($redemptions as $redemption)
        <div class="redemption-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="fw-bold" style="color: #64748b; font-size: 0.875rem;">#{{ str_pad($redemption->id, 4, '0', STR_PAD_LEFT) }}</span>
                @if($redemption->is_redeemed === false)
                    <span class="status-badge status-pending">
                        <i class="fas fa-hourglass-half"></i>
                        Pending
                    </span>
                @elseif($redemption->is_redeemed === true)
                    <span class="status-badge status-approved">
                        <i class="fas fa-check"></i>
                        Approved
                    </span>
                @else
                    <span class="status-badge status-rejected">
                        <i class="fas fa-times"></i>
                        Rejected
                    </span>
                @endif
            </div>

            <div class="mb-3">
                <h5 class="fw-bold mb-2" style="color: #1e293b;">{{ $redemption->consumer->name }}</h5>
                <p class="text-muted mb-1" style="font-size: 0.875rem;">
                    <i class="fas fa-envelope me-2"></i>{{ $redemption->consumer->email }}
                </p>
                <p class="text-muted mb-0" style="font-size: 0.875rem;">
                    <i class="fas fa-phone me-2"></i>{{ $redemption->consumer->phone_number }}
                </p>
            </div>

            <div style="background: #f8fafc; padding: 1rem; border-radius: 16px; margin-bottom: 1rem;">
                <h6 class="fw-bold mb-1" style="color: #1e293b;">{{ $redemption->reward->name }}</h6>
                <p class="text-muted mb-1" style="font-size: 0.875rem;">
                    <i class="fas fa-coins me-2"></i>{{ number_format($redemption->reward->points_required) }} points each
                </p>
                <p class="text-muted mb-0" style="font-size: 0.875rem;">
                    <i class="fas fa-box me-2"></i>Quantity: {{ $redemption->quantity ?? 1 }} item(s)
                    <strong class="ms-2" style="color: #667eea;">Total: {{ number_format(($redemption->reward->points_required * ($redemption->quantity ?? 1))) }} points</strong>
                </p>
            </div>

            <p class="text-muted mb-2" style="font-size: 0.875rem;">
                <i class="fas fa-clock me-2"></i>Redeemed {{ $redemption->created_at->diffForHumans() }}
            </p>

            <!-- Expiration Status -->
            @if($redemption->expires_at)
            <div class="mb-3" style="background:
                @if($redemption->isExpired())
                    #fee2e2
                @else
                    #eff6ff
                @endif
            ; padding: 0.75rem; border-radius: 12px; border-left: 4px solid
                @if($redemption->isExpired())
                    #ef4444
                @else
                    #3b82f6
                @endif
            ;">
                <div style="font-size: 0.75rem; font-weight: 600; text-transform: uppercase; color:
                    @if($redemption->isExpired())
                        #991b1b
                    @else
                        #1e40af
                    @endif
                ; margin-bottom: 0.25rem;">
                    @if($redemption->isExpired())
                        <i class="fas fa-times-circle me-1"></i>EXPIRED
                    @else
                        <i class="fas fa-check-circle me-1"></i>VALID
                    @endif
                </div>
                <div style="font-size: 0.875rem; font-weight: 700; color: #1e293b;">
                    @if($redemption->isExpired())
                        Expired {{ \Carbon\Carbon::parse($redemption->expires_at)->diffForHumans() }}
                    @else
                        Expires {{ \Carbon\Carbon::parse($redemption->expires_at)->diffForHumans() }}
                    @endif
                </div>
                <div style="font-size: 0.7rem; color: #64748b; margin-top: 0.25rem;">
                    {{ \Carbon\Carbon::parse($redemption->expires_at)->format('M d, Y g:i A') }}
                </div>
            </div>
            @endif

            @if($redemption->is_redeemed === false)
            <!-- Show expired warning if receipt has expired -->
            @if($redemption->isExpired())
            <div style="background: #fee2e2; color: #991b1b; padding: 0.75rem; border-radius: 12px; font-size: 0.875rem; font-weight: 600; margin-bottom: 1rem;">
                <i class="fas fa-exclamation-triangle me-2"></i>This receipt has expired and cannot be approved
            </div>
            @endif

            <div class="d-flex gap-2">
                <form method="POST" action="{{ route('reward.redemptions.approve', $redemption->id) }}" class="flex-fill">
                    @csrf
                    <button type="submit" class="btn-modern btn-success-modern w-100"
                            @if($redemption->isExpired()) disabled style="opacity: 0.5; cursor: not-allowed;" @endif
                            onclick="return confirm('Approve this redemption?')">
                        <i class="fas fa-check"></i>
                        <span>{{ $redemption->isExpired() ? 'Expired' : 'Approve' }}</span>
                    </button>
                </form>
                <form method="POST" action="{{ route('reward.redemptions.reject', $redemption->id) }}" class="flex-fill">
                    @csrf
                    <button type="submit" class="btn-modern btn-danger-modern w-100" onclick="return confirm('Reject this redemption?')">
                        <i class="fas fa-times"></i>
                        <span>Reject</span>
                    </button>
                </form>
            </div>
            @elseif($redemption->is_redeemed === true)
            <div style="background: #d1fae5; color: #065f46; padding: 0.75rem; border-radius: 12px; font-size: 0.875rem; font-weight: 600;">
                <i class="fas fa-check-circle me-2"></i>Approved {{ isset($redemption->approved_at) ? $redemption->approved_at->diffForHumans() : 'recently' }}
            </div>
            @else
            <div style="background: #fee2e2; color: #991b1b; padding: 0.75rem; border-radius: 12px; font-size: 0.875rem; font-weight: 600;">
                <i class="fas fa-times-circle me-2"></i>Rejected
            </div>
            @endif
        </div>
        @endforeach
    </div>
    @else
    <div class="empty-state">
        <div class="empty-state-icon">
            <i class="fas fa-receipt"></i>
        </div>
        <h3 class="empty-state-title">No Redemptions Yet</h3>
        <p class="empty-state-text">Redemption requests will appear here</p>
    </div>
    @endif

</div>
@endsection
