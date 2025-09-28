@extends('master')

@section('content')
<style>
.profile-avatar {
    width: 120px; height: 120px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: 4px solid #fff;
    box-shadow: 0 8px 32px rgba(0,0,0,0.12);
    position: relative; overflow: hidden; cursor: pointer;
    transition: all 0.3s ease;
}
.profile-avatar:hover { transform: translateY(-2px); box-shadow: 0 12px 40px rgba(0,0,0,0.15); }
.profile-avatar img { width: 100%; height: 100%; object-fit: cover; }
.profile-overlay {
    position: absolute; top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.7); opacity: 0; transition: opacity 0.3s ease; cursor: pointer;
}
.profile-avatar:hover .profile-overlay { opacity: 1; }
.profile-file-input { position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; }
.rank-badge {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white; border: none;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}
.rank-badge.platinum { background: linear-gradient(135deg, #c0c0c0, #a8a8a8); }
.rank-badge.gold { background: linear-gradient(135deg, #ffd700, #ffb300); }
.rank-badge.silver { background: linear-gradient(135deg, #c0c0c0, #999999); }
.rank-badge.bronze { background: linear-gradient(135deg, #cd7f32, #a0522d); }
.progress-bar-fill { background: linear-gradient(90deg, #667eea, #764ba2) !important; }
.stat-card {
    border: 1px solid #e8ecf4;
    transition: all 0.3s ease;
    background: linear-gradient(135deg, #fff 0%, #f8fafc 100%);
}
.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.08);
    border-color: #667eea;
}
.transaction-card { cursor: pointer; transition: all 0.3s ease; border: 1px solid #e8ecf4; }
.transaction-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    border-color: #667eea;
}
.btn-gradient {
    background: linear-gradient(135deg, #667eea, #764ba2);
    border: none; color: white;
    transition: all 0.3s ease;
}
.btn-gradient:hover {
    background: linear-gradient(135deg, #5a67d8, #6b46c1);
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
}
.card-premium {
    border: 1px solid #e8ecf4;
    box-shadow: 0 4px 20px rgba(0,0,0,0.04);
    background: linear-gradient(135deg, #fff 0%, #f8fafc 100%);
}
.fade-in { animation: fadeIn 0.6s ease-out; }
@keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
.modal-backdrop { position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.6); z-index: 9999; opacity: 0; visibility: hidden; transition: all 0.3s ease; backdrop-filter: blur(4px); }
.modal-backdrop.active { opacity: 1; visibility: visible; }
.modal-content { transform: scale(0.9); transition: transform 0.3s ease; }
.modal-backdrop.active .modal-content { transform: scale(1); }
.text-gradient { background: linear-gradient(135deg, #667eea, #764ba2); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
</style>

<main class="container-fluid px-3 px-lg-5 py-4">
    <!-- Alerts -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show fade-in border-0 shadow-sm">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show fade-in border-0 shadow-sm">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Business Profile Card -->
    <div class="card card-premium border-0 mb-4 fade-in">
        <div class="card-body p-5 text-center">
            <div class="d-flex justify-content-center mb-4">
                <div class="profile-avatar rounded-circle d-flex align-items-center justify-content-center">
                    @if ($seller->photo_url)
                        <img src="{{ asset($seller->photo_url) }}" alt="Profile" id="profileImage" class="rounded-circle">
                    @else
                        <span id="profileInitials" class="fs-1 fw-bold text-white">{{ strtoupper(substr($seller->business_name ?? 'NA', 0, 2)) }}</span>
                    @endif
                    <div class="profile-overlay rounded-circle d-flex align-items-center justify-content-center" onclick="document.getElementById('profilePictureInput').click();">
                        <div class="text-white text-center">
                            <i class="fas fa-camera fs-4 mb-2"></i>
                            <div class="small fw-semibold">Change Photo</div>
                        </div>
                    </div>
                    <input type="file" id="profilePictureInput" name="image" class="profile-file-input" accept="image/*" onchange="previewAndSubmitImage(this)" form="profilePhotoForm">
                </div>
            </div>

            <div class="d-flex align-items-center justify-content-center mb-4 text-muted">
                <i class="fas fa-upload me-2"></i>
                <span>Click on the avatar to upload a profile picture (JPG, PNG, max 5MB)</span>
            </div>

            <form id="profilePhotoForm" action="{{ route('seller.photo.update') }}" method="POST" enctype="multipart/form-data" class="d-none">@csrf</form>

            <h1 class="h2 fw-bold mb-2 text-gradient">{{ $seller->business_name }}</h1>
            <p class="text-muted mb-4 fs-5">{{ $seller->email }}</p>

            <button type="button" class="btn btn-outline-primary me-3 mb-3" onclick="toggleProfileEdit()">
                <i class="fas fa-edit me-2"></i>Edit Profile
            </button>

            <!-- Quick Actions -->
            <div class="row g-3 mb-4 mt-3">
                <div class="col-12 col-md-4">
                    <a href="{{ route('location.show') }}" class="btn btn-success w-100 py-3">
                        <i class="fas fa-map-marker-alt me-2"></i>Shop Location
                    </a>
                </div>
                <div class="col-12 col-md-4">
                    <a href="{{ route('seller.photos') }}" class="btn btn-warning w-100 py-3">
                        <i class="fas fa-images me-2"></i>Photo Gallery
                    </a>
                </div>
                <div class="col-12 col-md-4">
                    <a href="{{ route('dashboard') }}" class="btn btn-info w-100 py-3">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                </div>
            </div>

            <!-- Edit Profile Form -->
            <div id="profile-edit-form" class="d-none mt-4">
                <div class="bg-light p-4 rounded-3 border">
                    <form action="{{ route('seller.profile.update') }}" method="POST">
                        @csrf @method('PUT')
                        <div class="row g-4">
                            <div class="col-12 col-md-6">
                                <label for="business_name" class="form-label fw-semibold">Business Name</label>
                                <input type="text" class="form-control form-control-lg" id="business_name" name="business_name" value="{{ $seller->business_name }}" required>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="email" class="form-label fw-semibold">Email</label>
                                <input type="email" class="form-control form-control-lg" id="email" name="email" value="{{ $seller->email }}" required>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="phone" class="form-label fw-semibold">Phone</label>
                                <input type="text" class="form-control form-control-lg" id="phone" name="phone" value="{{ $seller->phone }}">
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="address" class="form-label fw-semibold">Address</label>
                                <textarea class="form-control form-control-lg" id="address" name="address" rows="3">{{ $seller->address }}</textarea>
                            </div>
                        </div>
                        <div class="d-flex gap-3 mt-4">
                            <button type="submit" class="btn btn-gradient px-4 py-2">
                                <i class="fas fa-save me-2"></i>Save Changes
                            </button>
                            <button type="button" class="btn btn-outline-secondary px-4 py-2" onclick="toggleProfileEdit()">
                                <i class="fas fa-times me-2"></i>Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Rank Badge -->
            <div class="d-flex justify-content-center mt-4">
                <div class="rank-badge badge fs-5 fw-semibold px-4 py-3 rounded-pill d-flex align-items-center gap-2 {{ strtolower($currentRank->name) }}">
                    <span class="fs-4">
                        @switch($currentRank->name)
                            @case('Platinum') 💎 @break
                            @case('Gold') 🏆 @break
                            @case('Silver') 🥈 @break
                            @case('Bronze') 🥉 @break
                            @default ⭐
                        @endswitch
                    </span>
                    <span>{{ $currentRank->name }} Seller</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="row g-4 mb-5 fade-in">
        <div class="col-6 col-lg-3">
            <div class="card stat-card border-0 h-100">
                <div class="card-body text-center p-4">
                    <div class="text-primary mb-3" style="font-size: 3rem;">🏆</div>
                    <div class="h2 text-primary fw-bold mb-2">{{ number_format($totalRankPoints) }}</div>
                    <div class="text-muted fw-semibold">Total Rank Points</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card stat-card border-0 h-100">
                <div class="card-body text-center p-4">
                    <div class="text-success mb-3" style="font-size: 3rem;">📤</div>
                    <div class="h2 text-success fw-bold mb-2">{{ number_format($pointsGiven) }}</div>
                    <div class="text-muted fw-semibold">Points Given</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card stat-card border-0 h-100">
                <div class="card-body text-center p-4">
                    <div class="text-info mb-3" style="font-size: 3rem;">📥</div>
                    <div class="h2 text-info fw-bold mb-2">{{ number_format($pointsFromRedemptions) }}</div>
                    <div class="text-muted fw-semibold">From Redemptions</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card stat-card border-0 h-100">
                <div class="card-body text-center p-4">
                    <div class="text-warning mb-3" style="font-size: 3rem;">👥</div>
                    <div class="h2 text-warning fw-bold mb-2">{{ number_format($totalCustomers) }}</div>
                    <div class="text-muted fw-semibold">Total Customers</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rank Progress -->
    @if ($nextRank)
        <div class="card card-premium border-0 mb-5 fade-in">
            <div class="card-body p-5">
                <h3 class="h4 fw-bold text-center mb-4 text-gradient">
                    <i class="fas fa-target me-2"></i>Progress to {{ $nextRank->name }}
                </h3>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <span class="badge bg-primary fs-6 px-3 py-2">{{ $currentRank->name }}</span>
                    <span class="badge bg-secondary fs-6 px-3 py-2">{{ $nextRank->name }}</span>
                </div>
                <div class="progress mb-3" style="height: 16px;">
                    <div class="progress-bar progress-bar-fill" style="width: {{ min(100, (($totalRankPoints - $currentRank->min_points) / ($nextRank->min_points - $currentRank->min_points)) * 100) }}%"></div>
                </div>
                <div class="text-center text-muted fw-semibold">{{ number_format($pointsToNext) }} points needed to reach {{ $nextRank->name }}</div>
            </div>
        </div>
    @endif

    <!-- Transaction History -->
    <div class="card card-premium border-0 fade-in">
        <div class="card-header bg-white border-0 p-4">
            <div class="row align-items-center">
                <div class="col-12 col-md-6">
                    <h3 class="h4 fw-bold mb-0 text-gradient">
                        <i class="fas fa-chart-line me-2"></i>Transaction History
                    </h3>
                </div>
                <div class="col-12 col-md-6 mt-3 mt-md-0">
                    <div class="d-flex gap-3 justify-content-md-end">
                        <button class="btn btn-outline-secondary" onclick="exportTransactions()">
                            <i class="fas fa-download me-2"></i>Export CSV
                        </button>
                        <select class="form-select" style="width: 200px;" onchange="filterTransactions(this.value)">
                            <option value="all" {{ $filter == 'all' ? 'selected' : '' }}>All Transactions</option>
                            <option value="earn" {{ $filter == 'earn' ? 'selected' : '' }}>Points Given</option>
                            <option value="spend" {{ $filter == 'spend' ? 'selected' : '' }}>Redemptions</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body p-4">
            @forelse($transactions as $transaction)
                <div class="transaction-card card mb-4" onclick="showTransactionModal({{ json_encode($transaction) }})">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center fw-bold fs-5">
                                @if ($transaction->type === 'earn')
                                    @if ($transaction->receipt_code)
                                        <i class="fas fa-receipt text-primary me-3"></i>Receipt Transaction
                                    @else
                                        <i class="fas fa-share text-primary me-3"></i>Points Given
                                    @endif
                                @else
                                    <i class="fas fa-download text-success me-3"></i>Points Redeemed
                                @endif
                            </div>
                            <div class="h4 fw-bold {{ $transaction->type === 'earn' ? 'text-danger' : 'text-success' }} mb-0">
                                {{ $transaction->type === 'earn' ? '-' : '+' }}{{ number_format($transaction->points) }}
                            </div>
                        </div>

                        <div class="row g-3 text-muted mb-3">
                            <div class="col-12 col-md-6">
                                <i class="fas fa-user me-2"></i>
                                <strong>{{ $transaction->consumer_name ?? 'Customer #' . $transaction->consumer_id }}</strong>
                            </div>
                            <div class="col-12 col-md-6">
                                <i class="fas fa-box me-2"></i>
                                @if ($transaction->item_name)
                                    {{ $transaction->item_name }}
                                @elseif(isset($transaction->extracted_items))
                                    {{ $transaction->extracted_items }}
                                @elseif($transaction->description && str_contains($transaction->description, 'Purchased:'))
                                    @php
                                        $desc = $transaction->description;
                                        if (preg_match('/Purchased:\s*([^f]+?)\s+from/i', $desc, $matches)) {
                                            $items = trim($matches[1]);
                                            echo strlen($items) > 30 ? substr($items, 0, 30) . '...' : $items;
                                        } else {
                                            echo 'Receipt Items';
                                        }
                                    @endphp
                                @elseif($transaction->receipt_code)
                                    Receipt #{{ $transaction->receipt_code }}
                                @elseif($transaction->qr_code_id)
                                    Item #{{ $transaction->qr_code_id }}
                                @else
                                    Direct Transaction
                                @endif
                            </div>
                            <div class="col-12 col-md-6">
                                <i class="fas fa-sort-numeric-up me-2"></i>{{ $transaction->units_scanned ?? 1 }} units scanned
                            </div>
                            <div class="col-12 col-md-6">
                                <i class="fas fa-bolt me-2"></i>
                                @if ($transaction->points_per_unit)
                                    {{ $transaction->points_per_unit }} pts/unit
                                @else
                                    {{ number_format($transaction->points / ($transaction->units_scanned ?? 1), 1) }} pts/unit
                                @endif
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <span class="badge bg-light text-dark">ID: {{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}</span>
                            <span class="text-muted">{{ \Carbon\Carbon::parse($transaction->scanned_at ?? $transaction->created_at)->format('M d, Y • h:i A') }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <div class="display-1 mb-4 opacity-50">📊</div>
                    <h3 class="h4 fw-bold mb-3">No transactions yet</h3>
                    <p class="text-muted mb-4 fs-5">Start scanning customer QR codes to see your transaction history and earn rank points!</p>
                    <a href="{{ route('seller.scanner') }}" class="btn btn-gradient btn-lg px-5 py-3">
                        <i class="fas fa-qrcode me-2"></i>Open QR Scanner
                    </a>
                </div>
            @endforelse

            @if ($transactions->count() > 0)
                <div class="d-flex justify-content-between align-items-center pt-4 border-top">
                    <div class="text-muted">Showing {{ $transactions->count() }} of {{ $transactions->total() }} transactions</div>
                    @if ($transactions->hasMorePages())
                        <a href="{{ $transactions->nextPageUrl() }}" class="btn btn-outline-primary">
                            Load More <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</main>

<!-- Transaction Detail Modal -->
<div id="transactionModal" class="modal-backdrop d-flex align-items-center justify-content-center p-4" onclick="closeTransactionModal(event)">
    <div class="modal-content bg-white rounded-4 shadow-lg border-0" style="max-width: 700px; width: 100%; max-height: 90vh; overflow-y: auto;" onclick="event.stopPropagation()">
        <div class="text-white p-4 rounded-top-4 d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #667eea, #764ba2);">
            <h3 class="h4 mb-0 fw-bold"><i class="fas fa-receipt me-2"></i>Transaction Details</h3>
            <button class="btn btn-link text-white p-0 fs-3" onclick="closeTransactionModal()" style="text-decoration: none;">&times;</button>
        </div>

        <div class="p-5">
            <!-- Transaction Summary -->
            <div class="mb-5 pb-4 border-bottom">
                <h4 class="h5 fw-bold mb-4 text-gradient"><i class="fas fa-credit-card me-2"></i>Transaction Summary</h4>
                <div class="row g-4">
                    <div class="col-6 col-md-3">
                        <div class="text-muted text-uppercase fw-semibold mb-1" style="font-size: 0.75rem;">Transaction ID</div>
                        <div class="fw-bold" id="modalTransactionId">-</div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="text-muted text-uppercase fw-semibold mb-1" style="font-size: 0.75rem;">Type</div>
                        <div class="fw-bold" id="modalTransactionType">-</div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="text-muted text-uppercase fw-semibold mb-1" style="font-size: 0.75rem;">Points</div>
                        <div class="fw-bold" id="modalPoints">-</div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="text-muted text-uppercase fw-semibold mb-1" style="font-size: 0.75rem;">Date & Time</div>
                        <div class="fw-bold" id="modalDateTime">-</div>
                    </div>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="mb-5 pb-4 border-bottom">
                <h4 class="h5 fw-bold mb-4 text-gradient"><i class="fas fa-user me-2"></i>Customer Information</h4>
                <div class="row g-4">
                    <div class="col-6">
                        <div class="text-muted text-uppercase fw-semibold mb-1" style="font-size: 0.75rem;">Customer Name</div>
                        <div class="fw-bold" id="modalCustomerName">-</div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted text-uppercase fw-semibold mb-1" style="font-size: 0.75rem;">Customer ID</div>
                        <div class="fw-bold" id="modalCustomerId">-</div>
                    </div>
                </div>
            </div>

            <!-- Item Details -->
            <div class="mb-5 pb-4 border-bottom">
                <h4 class="h5 fw-bold mb-4 text-gradient"><i class="fas fa-box me-2"></i>Item Details</h4>
                <div class="row g-4">
                    <div class="col-6">
                        <div class="text-muted text-uppercase fw-semibold mb-1" style="font-size: 0.75rem;">Item Name</div>
                        <div class="fw-bold" id="modalItemName">-</div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted text-uppercase fw-semibold mb-1" style="font-size: 0.75rem;">Quantity Scanned</div>
                        <div class="fw-bold" id="modalUnitsScanned">-</div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted text-uppercase fw-semibold mb-1" style="font-size: 0.75rem;">Points Per Unit</div>
                        <div class="fw-bold" id="modalPointsPerUnit">-</div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted text-uppercase fw-semibold mb-1" style="font-size: 0.75rem;">Total Points</div>
                        <div class="fw-bold" id="modalTotalPoints">-</div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted text-uppercase fw-semibold mb-1" style="font-size: 0.75rem;">QR Code ID</div>
                        <div class="fw-bold" id="modalQRCodeId">-</div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted text-uppercase fw-semibold mb-1" style="font-size: 0.75rem;">Receipt Code</div>
                        <div class="fw-bold" id="modalReceiptCode">-</div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted text-uppercase fw-semibold mb-1" style="font-size: 0.75rem;">Transaction Source</div>
                        <div class="fw-bold" id="modalTransactionSource">-</div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted text-uppercase fw-semibold mb-1" style="font-size: 0.75rem;">Description</div>
                        <div class="fw-bold" id="modalDescription">-</div>
                    </div>
                </div>
            </div>

            <!-- Impact Information -->
            <div class="mb-0">
                <h4 class="h5 fw-bold mb-4 text-gradient"><i class="fas fa-trophy me-2"></i>Business Impact</h4>
                <div class="row g-4">
                    <div class="col-6">
                        <div class="text-muted text-uppercase fw-semibold mb-1" style="font-size: 0.75rem;">Rank Points Impact</div>
                        <div class="fw-bold" id="modalRankImpact">-</div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted text-uppercase fw-semibold mb-1" style="font-size: 0.75rem;">Current Total Points</div>
                        <div class="fw-bold">{{ number_format($totalRankPoints) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showTransactionModal(transaction) {
    document.getElementById('modalTransactionId').textContent = '#' + String(transaction.id).padStart(6, '0');

    let transactionType = transaction.type === 'earn' ? (transaction.receipt_code ? 'Receipt Transaction' : 'Points Given') : 'Points Redeemed';
    document.getElementById('modalTransactionType').textContent = transactionType;
    document.getElementById('modalPoints').textContent = (transaction.type === 'earn' ? '-' : '+') + transaction.points + ' points';
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
    document.getElementById('modalTotalPoints').textContent = transaction.points + ' points';
    document.getElementById('modalQRCodeId').textContent = transaction.qr_code_id ? '#' + transaction.qr_code_id : 'N/A';

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
    document.getElementById('modalRankImpact').textContent = '+' + transaction.points + ' points';

    document.getElementById('transactionModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeTransactionModal(event) {
    if (!event || event.target === document.getElementById('transactionModal')) {
        document.getElementById('transactionModal').classList.remove('active');
        document.body.style.overflow = 'auto';
    }
}

function filterTransactions(type) {
    const url = new URL(window.location);
    url.searchParams.set('filter', type);
    window.location.href = url.toString();
}

function exportTransactions() {
    const url = new URL('{{ route('seller.account.export') }}', window.location.origin);
    const currentFilter = new URLSearchParams(window.location.search).get('filter');
    if (currentFilter && currentFilter !== 'all') url.searchParams.set('filter', currentFilter);
    window.location.href = url.toString();
}

function toggleProfileEdit() {
    const editForm = document.getElementById('profile-edit-form');
    const editBtn = document.querySelector('.btn[onclick="toggleProfileEdit()"]');

    if (editForm.classList.contains('d-none')) {
        editForm.classList.remove('d-none');
        editBtn.innerHTML = '<i class="fas fa-times me-2"></i>Cancel Edit';
        editBtn.className = 'btn btn-outline-secondary me-3 mb-3';
    } else {
        editForm.classList.add('d-none');
        editBtn.innerHTML = '<i class="fas fa-edit me-2"></i>Edit Profile';
        editBtn.className = 'btn btn-outline-primary me-3 mb-3';
    }
}

function previewAndSubmitImage(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];

        if (file.size > 5 * 1024 * 1024) {
            alert('File size must be less than 5MB');
            input.value = '';
            return;
        }

        if (!file.type.match('image.*')) {
            alert('Please select a valid image file');
            input.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            const profileAvatar = document.querySelector('.profile-avatar');
            const existingImg = profileAvatar.querySelector('#profileImage');
            const initials = profileAvatar.querySelector('#profileInitials');

            if (existingImg) {
                existingImg.src = e.target.result;
            } else {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = 'Profile';
                img.id = 'profileImage';
                img.className = 'rounded-circle';
                profileAvatar.insertBefore(img, profileAvatar.firstChild);
            }

            if (initials) initials.style.display = 'none';
        };
        reader.readAsDataURL(file);

        setTimeout(() => {
            if (confirm('Upload this profile picture?')) {
                document.getElementById('profilePhotoForm').submit();
            } else {
                input.value = '';
                location.reload();
            }
        }, 100);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const fadeElements = document.querySelectorAll('.fade-in');
    fadeElements.forEach((el, index) => {
        el.style.opacity = '0';
        setTimeout(() => el.style.opacity = '1', index * 100);
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeTransactionModal();
    });
});
</script>

@endsection
