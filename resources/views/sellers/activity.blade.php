@extends('master')

@section('content')
<style>
/* Activity Page - Dashboard Style */
.activity-page {
    min-height: 100vh;
    padding-bottom: 40px;
}

.activity-container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 32px 20px;
}

.activity-header-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(25px);
    border-radius: 20px;
    padding: 32px;
    margin-bottom: 24px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
}

.filter-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(25px);
    border-radius: 20px;
    padding: 24px;
    margin-bottom: 24px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.08);
}

.filter-tabs {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.filter-tab {
    padding: 10px 20px;
    border-radius: 10px;
    background: #f8fafc;
    border: none;
    color: #64748b;
    text-decoration: none;
    transition: all 0.2s ease;
    font-weight: 600;
    font-size: 14px;
}

.filter-tab:hover {
    background: #e2e8f0;
    text-decoration: none;
}

.filter-tab.active {
    background: linear-gradient(135deg, #00b09b, #00cdac);
    color: white;
    box-shadow: 0 4px 12px rgba(0, 176, 155, 0.3);
}

/* Activity Card - Matching Dashboard */
.activity-card {
    background: white;
    border-radius: 20px;
    padding: 24px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}

.activity-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.activity-title {
    font-size: 18px;
    font-weight: 600;
    color: #333;
}

.activity-list {
    display: flex;
    flex-direction: column;
    gap: 0;
}

.activity-item {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 12px;
    border-radius: 12px;
    transition: background-color 0.2s ease;
    cursor: pointer;
}

.activity-item:hover {
    background: #f8f9fa;
}

.activity-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #f0f0f0, #e0e0e0);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
}

.activity-details {
    flex: 1;
    min-width: 0;
}

.activity-name {
    font-size: 14px;
    font-weight: 600;
    color: #333;
    margin-bottom: 2px;
}

.activity-desc {
    font-size: 12px;
    color: #666;
}

.activity-points {
    font-size: 14px;
    font-weight: 700;
    color: #10b981;
    white-space: nowrap;
}

/* Stats */
.stat-box {
    background: rgba(255, 255, 255, 0.9);
    border-radius: 16px;
    padding: 24px;
    transition: all 0.3s ease;
}

.stat-box:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0, 176, 155, 0.15);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 64px 32px;
}

.empty-icon {
    font-size: 64px;
    margin-bottom: 20px;
    opacity: 0.6;
}

.btn-primary {
    background: linear-gradient(135deg, #00b09b, #00cdac);
    color: white;
    border: none;
    padding: 12px 28px;
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 176, 155, 0.4);
    color: white;
    text-decoration: none;
}

/* Pagination */
.pagination {
    display: flex;
    justify-content: center;
    gap: 8px;
    margin-top: 24px;
}

.pagination .page-link {
    background: white;
    border: 2px solid #e2e8f0;
    color: #64748b;
    padding: 8px 16px;
    border-radius: 8px;
    font-weight: 600;
}

.pagination .page-link:hover {
    background: #00b09b;
    border-color: #00b09b;
    color: white;
}

.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #00b09b, #00cdac);
    border-color: #00b09b;
    color: white;
}

/* Responsive */
@media (max-width: 768px) {
    .activity-container {
        padding: 24px 16px;
    }

    .activity-header-card,
    .filter-card,
    .activity-card {
        padding: 20px;
    }
}
</style>

<main class="activity-page">
    <div class="activity-container">
        <!-- Header Card -->
        <div class="activity-header-card">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <div>
                    <h1 style="font-size: 28px; font-weight: 700; color: #333; margin-bottom: 8px;">⚡ Recent Activity</h1>
                    <p style="color: #64748b; margin-bottom: 0;">All transactions for {{ $seller->business_name }}</p>
                </div>
                <a href="{{ route('seller.account.export') }}" class="btn-primary" style="padding: 10px 20px; font-size: 14px;">
                    <i class="fas fa-download me-2"></i>Export
                </a>
            </div>

            <!-- Stats -->
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="stat-box">
                        <div class="d-flex align-items-center gap-3">
                            <div style="font-size: 2.5rem;">📤</div>
                            <div>
                                <div class="h3 fw-bold mb-0" style="color: #00b09b;">{{ number_format($pointsGiven) }}</div>
                                <div class="small" style="color: #64748b; font-weight: 600;">Points Given</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-box">
                        <div class="d-flex align-items-center gap-3">
                            <div style="font-size: 2.5rem;">📥</div>
                            <div>
                                <div class="h3 fw-bold mb-0" style="color: #00b09b;">{{ number_format($pointsFromRedemptions) }}</div>
                                <div class="small" style="color: #64748b; font-weight: 600;">From Redemptions</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-box">
                        <div class="d-flex align-items-center gap-3">
                            <div style="font-size: 2.5rem;">👥</div>
                            <div>
                                <div class="h3 fw-bold mb-0" style="color: #00b09b;">{{ number_format($totalCustomers) }}</div>
                                <div class="small" style="color: #64748b; font-weight: 600;">Total Consumers</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity List Card -->
        <div class="activity-card">
            @if($transactions->count() > 0)
                <div class="activity-list">
                    @foreach($transactions as $transaction)
                    <div class="activity-item" onclick='showTransactionModal(@json($transaction))'>
                        <div class="activity-avatar">
                            @if($transaction->status === 'pending')
                                🎁
                            @elseif($transaction->status === 'approved')
                                ✨
                            @elseif($transaction->status === 'rejected')
                                ❌
                            @else
                                🎁
                            @endif
                        </div>
                        <div class="activity-details">
                            <div class="activity-name">{{ $transaction->consumer_name ?? 'Customer' }}</div>
                            <div class="activity-desc">
                                @if($transaction->status === 'pending')
                                    Requested reward
                                @elseif($transaction->status === 'approved')
                                    Reward approved
                                @elseif($transaction->status === 'rejected')
                                    Reward rejected
                                @else
                                    Reward activity
                                @endif
                                @if($transaction->reward_name)
                                    • {{ $transaction->reward_name }}
                                @endif
                            </div>
                        </div>
                        <div class="activity-points">
                            {{ number_format(($transaction->points_required ?? 0) * ($transaction->quantity ?? 1)) }} pts
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $transactions->links() }}
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">🚀</div>
                    <h3 style="font-weight: 700; color: #333; margin-bottom: 12px;">
                        Ready to Get Started?
                    </h3>
                    <p style="color: #666; margin-bottom: 24px;">
                        Create your first receipt to start tracking your green impact!
                    </p>
                    <a href="{{ route('seller.receipts.create') }}" class="btn-primary">Create Receipt</a>
                </div>
            @endif
        </div>
    </div>
</main>

<!-- Transaction Detail Modal -->
<div id="transactionModal" style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.6); z-index: 99999; opacity: 0; visibility: hidden; transition: all 0.3s; backdrop-filter: blur(8px); display: flex; align-items: center; justify-content: center; padding: 20px;" onclick="closeTransactionModal(event)">
    <div style="background: white; border-radius: 20px; padding: 32px; max-width: 550px; width: 100%; box-shadow: 0 20px 60px rgba(0,0,0,0.3);" onclick="event.stopPropagation();">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 style="font-size: 20px; font-weight: 700; margin: 0;">
                <i class="fas fa-receipt" style="color: #00b09b; margin-right: 8px;"></i>Transaction Details
            </h3>
            <button onclick="closeTransactionModal(event)" style="background: #f8f9fa; border: none; width: 36px; height: 36px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="row g-3">
            <div class="col-6">
                <div style="color: #666; font-size: 12px; margin-bottom: 4px;">Transaction ID</div>
                <div style="font-weight: 600;" id="modalTransactionId">#000000</div>
            </div>
            <div class="col-6">
                <div style="color: #666; font-size: 12px; margin-bottom: 4px;">Type</div>
                <div style="font-weight: 600;" id="modalTransactionType">-</div>
            </div>
            <div class="col-12">
                <div style="color: #666; font-size: 12px; margin-bottom: 4px;">Total Points</div>
                <div style="font-weight: 700; color: #10b981; font-size: 18px;" id="modalPoints">0 pts</div>
            </div>
            <div class="col-12">
                <div style="color: #666; font-size: 12px; margin-bottom: 4px;">Consumer</div>
                <div style="font-weight: 600;" id="modalCustomerName">-</div>
            </div>
            <div class="col-12" id="modalItemsSection">
                <div style="color: #666; font-size: 12px; margin-bottom: 8px;" id="modalItemsLabel">Items</div>
                <div id="modalItemsList">-</div>
            </div>
            <div class="col-12" id="modalRewardSection" style="display: none;">
                <div style="color: #666; font-size: 12px; margin-bottom: 8px;">Reward</div>
                <div id="modalRewardInfo">-</div>
            </div>
            <div class="col-12">
                <div style="color: #666; font-size: 12px; margin-bottom: 4px;">Date & Time</div>
                <div style="font-weight: 600;" id="modalDateTime">-</div>
            </div>
        </div>

        <div class="text-center mt-4">
            <button onclick="closeTransactionModal(event)" class="btn-primary" style="padding: 10px 24px;">Close</button>
        </div>
    </div>
</div>

<script>
function showTransactionModal(transaction) {
    document.getElementById('modalTransactionId').textContent = '#' + String(transaction.id).padStart(6, '0');

    const isRewardRedemption = transaction.activity_type === 'reward_redemption';
    const isPointTransaction = transaction.activity_type === 'point_transaction';

    let transactionType = '';
    let totalPoints = 0;

    if (isRewardRedemption) {
        transactionType = '🎁 Reward Redemption';
        totalPoints = (transaction.points_required || 0) * (transaction.quantity || 1);
    } else if (isPointTransaction) {
        totalPoints = transaction.points || 0;
        transactionType = transaction.type === 'spend' ? '💳 Redeemed' : '✅ Earned';
    }

    document.getElementById('modalTransactionType').textContent = transactionType;
    document.getElementById('modalPoints').textContent = totalPoints + ' pts';
    document.getElementById('modalDateTime').textContent = new Date(transaction.created_at).toLocaleString();
    document.getElementById('modalCustomerName').textContent = transaction.consumer_name || 'Customer';

    const itemsSection = document.getElementById('modalItemsSection');
    const rewardSection = document.getElementById('modalRewardSection');

    if (isRewardRedemption) {
        itemsSection.style.display = 'none';
        rewardSection.style.display = 'block';
        document.getElementById('modalRewardInfo').innerHTML = `
            <div style="background: #f8f9fa; padding: 16px; border-radius: 12px;">
                <div style="font-weight: 600;">${transaction.reward_name || 'Reward'}</div>
                <div style="color: #666; font-size: 12px; margin-top: 4px;">Qty: ${transaction.quantity || 1}</div>
            </div>
        `;
    } else {
        itemsSection.style.display = 'block';
        rewardSection.style.display = 'none';
        document.getElementById('modalItemsList').innerHTML = `
            <div style="background: #f8f9fa; padding: 16px; border-radius: 12px;">
                <div style="font-weight: 600;">${transaction.item_name || 'Item'}</div>
            </div>
        `;
    }

    const modal = document.getElementById('transactionModal');
    modal.style.opacity = '1';
    modal.style.visibility = 'visible';
}

function closeTransactionModal(event) {
    if (!event || event.target.id === 'transactionModal' || event.target.closest('button')) {
        const modal = document.getElementById('transactionModal');
        modal.style.opacity = '0';
        modal.style.visibility = 'hidden';
    }
}
</script>
@endsection
