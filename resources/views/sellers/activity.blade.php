@extends('master')

@section('content')
<style>
/* Activity Page Styles */
.activity-page {
    position: relative;
    z-index: 1;
}

.activity-header-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(102, 126, 234, 0.3);
    margin-bottom: 1.5rem;
}

.stat-box {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    border-radius: 12px;
    padding: 1.5rem;
    transition: all 0.3s ease;
}

.stat-box:hover {
    background: rgba(255, 255, 255, 0.25);
    transform: translateY(-2px);
}

.filter-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    padding: 1rem;
    margin-bottom: 1.5rem;
}

.filter-tabs {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.filter-tab {
    padding: 0.6rem 1.5rem;
    border-radius: 20px;
    background: #f8fafc;
    border: 2px solid transparent;
    color: #64748b;
    text-decoration: none;
    transition: all 0.3s ease;
    font-weight: 600;
    font-size: 0.9rem;
}

.filter-tab:hover {
    background: #e2e8f0;
    color: #475569;
    text-decoration: none;
}

.filter-tab.active {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white !important;
    border-color: transparent;
}

.transactions-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    padding: 1.5rem;
}

.transaction-row {
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 1rem;
    margin-bottom: 0.75rem;
    transition: all 0.3s ease;
    cursor: pointer;
}

.transaction-row:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    border-color: #667eea;
}

.transaction-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.transaction-icon.earn {
    background: linear-gradient(135deg, #10b981, #059669);
}

.transaction-icon.spend {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
}

.points-badge {
    font-size: 1rem;
    font-weight: 700;
    padding: 0.5rem 1rem;
    border-radius: 10px;
    white-space: nowrap;
}

.points-badge.earn {
    background: #d1fae5;
    color: #065f46;
}

.points-badge.spend {
    background: #dbeafe;
    color: #1e40af;
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-state-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
}

/* Modal Styles */
.modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.6);
    z-index: 99999;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    backdrop-filter: blur(4px);
    overflow-y: auto;
}

.modal-backdrop.active {
    opacity: 1;
    visibility: visible;
}

.modal-content {
    transform: scale(0.9);
    transition: transform 0.3s ease;
}

.modal-backdrop.active .modal-content {
    transform: scale(1);
}

/* Responsive */
@media (max-width: 768px) {
    .activity-header-card {
        padding: 1.5rem !important;
    }

    .stat-box {
        padding: 1rem;
    }

    .transaction-row {
        padding: 0.875rem;
    }

    .transaction-icon {
        width: 40px;
        height: 40px;
        font-size: 1.25rem;
    }

    .points-badge {
        font-size: 0.875rem;
        padding: 0.375rem 0.75rem;
    }

    .filter-tab {
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
    }
}

@media (max-width: 576px) {
    .activity-header-card .d-flex {
        flex-direction: column !important;
        align-items: flex-start !important;
        gap: 1rem;
    }

    .transaction-row .d-flex {
        flex-wrap: wrap;
    }

    .points-badge {
        margin-top: 0.5rem;
        width: 100%;
        text-align: center;
    }
}
</style>

<main class="activity-page container-fluid px-3 px-lg-5 py-4">
    <!-- Header Card -->
    <div class="activity-header-card p-4 p-lg-5">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div>
                <h1 class="h2 fw-bold mb-2">⚡ Activity History</h1>
                <p class="mb-0 opacity-90">Complete transaction history for {{ $seller->business_name }}</p>
            </div>
            <a href="{{ route('seller.account.export') }}" class="btn btn-light">
                <i class="fas fa-download me-2"></i>Export
            </a>
        </div>

        <!-- Stats -->
        <div class="row g-3">
            <div class="col-md-4">
                <div class="stat-box">
                    <div class="d-flex align-items-center gap-3">
                        <div style="font-size: 2rem;">📤</div>
                        <div>
                            <div class="h3 fw-bold mb-0">{{ number_format($pointsGiven) }}</div>
                            <div class="small opacity-90">Points Given</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-box">
                    <div class="d-flex align-items-center gap-3">
                        <div style="font-size: 2rem;">📥</div>
                        <div>
                            <div class="h3 fw-bold mb-0">{{ number_format($pointsFromRedemptions) }}</div>
                            <div class="small opacity-90">From Redemptions</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-box">
                    <div class="d-flex align-items-center gap-3">
                        <div style="font-size: 2rem;">👥</div>
                        <div>
                            <div class="h3 fw-bold mb-0">{{ number_format($totalCustomers) }}</div>
                            <div class="small opacity-90">Total Consumers</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="filter-card">
        <div class="filter-tabs">
            <a href="{{ route('seller.activity') }}" class="filter-tab {{ $filter === 'all' ? 'active' : '' }}">
                All Transactions
            </a>
            <a href="{{ route('seller.activity', ['filter' => 'earn']) }}" class="filter-tab {{ $filter === 'earn' ? 'active' : '' }}">
                📤 Points Given
            </a>
            <a href="{{ route('seller.activity', ['filter' => 'spend']) }}" class="filter-tab {{ $filter === 'spend' ? 'active' : '' }}">
                📥 Redemptions
            </a>
        </div>
    </div>

    <!-- Transactions List -->
    <div class="transactions-card">
        @if($transactions->count() > 0)
            @foreach($transactions as $transaction)
            <div class="transaction-row" onclick='showTransactionModal(@json($transaction))'>
                <div class="d-flex align-items-center gap-3">
                    <!-- Icon -->
                    <div class="transaction-icon {{ $transaction->type }}">
                        @if($transaction->type === 'earn')
                            ✅
                        @else
                            💳
                        @endif
                    </div>

                    <!-- Transaction Details -->
                    <div class="flex-grow-1">
                        <div class="fw-bold text-dark mb-1">
                            {{ $transaction->consumer_name ?? 'Customer #' . $transaction->consumer_id }}
                        </div>
                        <div class="d-flex flex-wrap gap-2 align-items-center text-muted small">
                            <span>
                                @if($transaction->type === 'earn')
                                    @if($transaction->receipt_code)
                                        📄 Receipt Transaction
                                    @else
                                        Points Given
                                    @endif
                                @else
                                    Redeemed Points
                                @endif
                            </span>
                            @if($transaction->item_name)
                                <span class="text-muted">•</span>
                                <span>{{ $transaction->item_name }}</span>
                            @endif
                            <span class="text-muted">•</span>
                            <span>{{ \Carbon\Carbon::parse($transaction->scanned_at ?? $transaction->created_at)->format('M d, Y g:i A') }}</span>
                        </div>
                    </div>

                    <!-- Points Badge -->
                    <div class="points-badge {{ $transaction->type }}">
                        {{ number_format($transaction->points) }} pts
                    </div>
                </div>
            </div>
            @endforeach

            <!-- Pagination -->
            <div class="mt-4">
                {{ $transactions->links() }}
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">📭</div>
                <h3 class="h5 fw-bold mb-2">No Transactions Found</h3>
                <p class="text-muted mb-3">
                    @if($filter !== 'all')
                        No transactions match the selected filter.
                    @else
                        Start scanning QR codes to see your activity here!
                    @endif
                </p>
                @if($filter !== 'all')
                    <a href="{{ route('seller.activity') }}" class="btn btn-primary">View All Transactions</a>
                @endif
            </div>
        @endif
    </div>
</main>

<!-- Transaction Detail Modal -->
<div id="transactionModal" class="modal-backdrop" onclick="closeTransactionModal(event)">
    <div class="container py-5">
        <div class="modal-content bg-white rounded-4 shadow-lg p-4 p-lg-5 mx-auto" style="max-width: 700px;" onclick="event.stopPropagation();">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="h4 fw-bold mb-0">
                    <i class="fas fa-receipt text-primary me-2"></i>Transaction Details
                </h3>
                <button class="btn btn-light rounded-circle" onclick="closeTransactionModal(event)" style="width: 40px; height: 40px;">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="d-flex align-items-start gap-3">
                        <div class="text-primary" style="font-size: 1.5rem;">🆔</div>
                        <div>
                            <div class="text-muted small mb-1">Transaction ID</div>
                            <div class="fw-semibold" id="modalTransactionId">#000000</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex align-items-start gap-3">
                        <div class="text-success" style="font-size: 1.5rem;">📊</div>
                        <div>
                            <div class="text-muted small mb-1">Type</div>
                            <div class="fw-semibold" id="modalTransactionType">Points Given</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex align-items-start gap-3">
                        <div class="text-warning" style="font-size: 1.5rem;">⭐</div>
                        <div>
                            <div class="text-muted small mb-1">Points</div>
                            <div class="fw-semibold" id="modalPoints">0 points</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex align-items-start gap-3">
                        <div class="text-info" style="font-size: 1.5rem;">🕐</div>
                        <div>
                            <div class="text-muted small mb-1">Date & Time</div>
                            <div class="fw-semibold" id="modalDateTime">-</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex align-items-start gap-3">
                        <div class="text-primary" style="font-size: 1.5rem;">👤</div>
                        <div>
                            <div class="text-muted small mb-1">Consumer</div>
                            <div class="fw-semibold" id="modalCustomerName">-</div>
                            <div class="text-muted small" id="modalCustomerId">-</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex align-items-start gap-3">
                        <div class="text-success" style="font-size: 1.5rem;">🛍️</div>
                        <div>
                            <div class="text-muted small mb-1">Item</div>
                            <div class="fw-semibold" id="modalItemName">-</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex align-items-start gap-3">
                        <div class="text-info" style="font-size: 1.5rem;">📦</div>
                        <div>
                            <div class="text-muted small mb-1">Quantity</div>
                            <div class="fw-semibold" id="modalUnitsScanned">-</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex align-items-start gap-3">
                        <div class="text-warning" style="font-size: 1.5rem;">💰</div>
                        <div>
                            <div class="text-muted small mb-1">Points Per Unit</div>
                            <div class="fw-semibold" id="modalPointsPerUnit">-</div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="p-3 rounded-3 bg-light">
                        <div class="text-muted small mb-2">Description</div>
                        <div class="fw-semibold" id="modalDescription">-</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex align-items-start gap-3">
                        <div style="font-size: 1.5rem;">📄</div>
                        <div>
                            <div class="text-muted small mb-1">Receipt Code</div>
                            <div class="fw-semibold" id="modalReceiptCode">-</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex align-items-start gap-3">
                        <div style="font-size: 1.5rem;">📱</div>
                        <div>
                            <div class="text-muted small mb-1">Source</div>
                            <div class="fw-semibold" id="modalTransactionSource">-</div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="p-3 rounded-3" style="background: linear-gradient(135deg, #667eea15, #764ba215);">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-semibold">Rank Impact</span>
                            <span class="fw-bold text-primary" id="modalRankImpact">0 points</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <button class="btn btn-primary px-4" onclick="closeTransactionModal(event)">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
function showTransactionModal(transaction) {
    document.getElementById('modalTransactionId').textContent = '#' + String(transaction.id).padStart(6, '0');

    let transactionType = transaction.type === 'earn' ? (transaction.receipt_code ? 'Receipt Transaction' : 'Points Given') : 'Points Redeemed';
    document.getElementById('modalTransactionType').textContent = transactionType;
    document.getElementById('modalPoints').textContent = transaction.points + ' points';
    document.getElementById('modalDateTime').textContent = new Date(transaction.scanned_at || transaction.created_at).toLocaleString();

    document.getElementById('modalCustomerName').textContent = transaction.consumer_name || 'Customer #' + transaction.consumer_id;
    document.getElementById('modalCustomerId').textContent = '#' + String(transaction.consumer_id).padStart(6, '0');

    let itemName = 'Direct Transaction';
    if (transaction.item_name) {
        itemName = transaction.item_name;
    } else if (transaction.extracted_items) {
        itemName = transaction.extracted_items;
    } else if (transaction.description && transaction.description.includes('Purchased:')) {
        const match = transaction.description.match(/Purchased:\s*([^f]+?)\s+from/i);
        itemName = match && match[1] ? match[1].trim() : 'Receipt Items';
    } else if (transaction.receipt_code) {
        itemName = 'Receipt #' + transaction.receipt_code;
    } else if (transaction.qr_code_id) {
        itemName = 'Item #' + transaction.qr_code_id;
    }
    document.getElementById('modalItemName').textContent = itemName;

    const quantity = transaction.units_scanned || 1;
    document.getElementById('modalUnitsScanned').textContent = quantity + ' unit' + (quantity > 1 ? 's' : '');

    let pointsPerUnit = transaction.points_per_unit || (transaction.points && quantity ? Math.round((transaction.points / quantity) * 10) / 10 : 0);
    document.getElementById('modalPointsPerUnit').textContent = pointsPerUnit + ' points/unit';

    let receiptCode = 'N/A', transactionSource = 'Unknown';
    if (transaction.receipt_code) {
        receiptCode = transaction.receipt_code;
        transactionSource = 'Receipt System';
    } else if (transaction.qr_code_id) {
        transactionSource = 'QR Code Scan';
    } else if (transaction.description && transaction.description.includes('from ')) {
        const match = transaction.description.match(/from\s+(.+?)$/i);
        if (match) {
            receiptCode = 'LEGACY_' + String(transaction.id).padStart(6, '0');
            transactionSource = 'Legacy Transaction (' + match[1].trim() + ')';
        } else {
            transactionSource = 'Legacy Direct Entry';
        }
    } else {
        transactionSource = 'Direct Entry';
    }

    document.getElementById('modalReceiptCode').textContent = receiptCode;
    document.getElementById('modalTransactionSource').textContent = transactionSource;
    document.getElementById('modalDescription').textContent = transaction.description || 'No description available';
    document.getElementById('modalRankImpact').textContent = transaction.points + ' points';

    // Hide navbar to prevent z-index issues
    const navbar = document.querySelector('.navbar');
    if (navbar) {
        navbar.style.zIndex = '0';
    }

    document.getElementById('transactionModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeTransactionModal(event) {
    if (!event || event.target === document.getElementById('transactionModal') || event.target.closest('.btn')) {
        // Restore navbar z-index
        const navbar = document.querySelector('.navbar');
        if (navbar) {
            navbar.style.zIndex = '1000';
        }

        document.getElementById('transactionModal').classList.remove('active');
        document.body.style.overflow = 'auto';
    }
}
</script>
@endsection
