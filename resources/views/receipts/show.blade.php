@extends('master')

@section('content')
<div class="receipt-show-page">
    <!-- Back Button (Floating) -->
    <a href="{{ route('seller.receipts.index') }}" class="back-fab" title="Back">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M19 12H5M12 19l-7-7 7-7"/>
        </svg>
    </a>

    <!-- Receipt Header Card -->
    <div class="receipt-header-card">
        <div class="receipt-code-section">
            <div class="code-label">Receipt Code</div>
            <div class="code-value">{{ $receipt->receipt_code }}</div>
        </div>
        <div class="status-section">
            <span class="status-badge status-{{ $receipt->status }}">
                @if($receipt->status === 'pending')
                    ⏳ Pending
                @elseif($receipt->status === 'claimed')
                    ✅ Claimed
                @else
                    ⌛ Expired
                @endif
            </span>
        </div>
    </div>

    <!-- Receipt Summary -->
    <div class="summary-cards">
        <div class="summary-card">
            <div class="summary-icon">📦</div>
            <div class="summary-content">
                <div class="summary-value">{{ $receipt->total_quantity }}</div>
                <div class="summary-label">Items</div>
            </div>
        </div>
        <div class="summary-card">
            <div class="summary-icon">⭐</div>
            <div class="summary-content">
                <div class="summary-value">{{ $receipt->total_points }}</div>
                <div class="summary-label">Points</div>
            </div>
        </div>
        <div class="summary-card">
            <div class="summary-icon">📅</div>
            <div class="summary-content">
                <div class="summary-value">{{ $receipt->created_at->format('M j') }}</div>
                <div class="summary-label">Created</div>
            </div>
        </div>
    </div>

    <!-- Items List -->
    <div class="items-container">
        <h2 class="section-title">Items</h2>
        <div class="items-grid">
            @foreach($receipt->items as $item)
                <div class="product-card">
                    <div class="product-image">
                        @if(isset($item['image_url']) && $item['image_url'])
                            <img src="{{ $item['image_url'] }}" alt="{{ $item['name'] }}">
                        @else
                            <div class="product-placeholder">{{ getItemIcon($item['name']) }}</div>
                        @endif
                    </div>
                    <div class="product-info">
                        <div class="product-name">{{ $item['name'] }}</div>
                        <div class="product-meta">
                            <span class="product-qty">{{ $item['quantity'] }}x</span>
                            <span class="product-points">{{ $item['total_points'] }} pts</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Customer Info (if claimed) -->
    @if($receipt->consumer)
        <div class="customer-card">
            <h2 class="section-title">Customer</h2>
            <div class="customer-content">
                <div class="customer-avatar">{{ substr($receipt->consumer->full_name, 0, 1) }}</div>
                <div class="customer-info">
                    <div class="customer-name">{{ $receipt->consumer->full_name }}</div>
                    <div class="customer-email">{{ $receipt->consumer->email }}</div>
                    <div class="claimed-date">Claimed: {{ $receipt->claimed_at->format('M j, Y g:i A') }}</div>
                </div>
            </div>
        </div>
    @endif

    <!-- Action Buttons -->
    @if($receipt->status === 'pending')
        <div class="action-buttons">
            <a href="{{ route('seller.receipts.qr', $receipt->id) }}" class="action-btn qr-btn" target="_blank">
                <span class="btn-icon">📱</span>
                <span>Show QR Code</span>
            </a>
            <button onclick="cancelReceipt({{ $receipt->id }})" class="action-btn cancel-btn">
                <span class="btn-icon">❌</span>
                <span>Cancel Receipt</span>
            </button>
        </div>
    @endif
</div>

<!-- Success Toast -->
<div id="success-toast" class="toast toast-success">
    <span class="toast-icon">✅</span>
    <span id="success-message"></span>
</div>

<!-- Error Toast -->
<div id="error-toast" class="toast toast-error">
    <span class="toast-icon">❌</span>
    <span id="error-message"></span>
</div>

<style>
/* Reset & Base */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.receipt-show-page {
    max-width: 800px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    padding: 2rem;
}

/* Floating Back Button */
.back-fab {
    position: fixed;
    top: 2rem;
    left: 2rem;
    width: 56px;
    height: 56px;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    text-decoration: none;
    color: #667eea;
    transition: all 0.3s ease;
    z-index: 100;
}

.back-fab:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
    color: #667eea;
}

/* Receipt Header Card */
.receipt-header-card {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.code-label {
    font-size: 0.9rem;
    color: #6b7280;
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.code-value {
    font-family: 'Courier New', monospace;
    font-size: 1.5rem;
    font-weight: 700;
    color: #667eea;
}

.status-badge {
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.95rem;
}

.status-pending {
    background: rgba(245, 158, 11, 0.2);
    color: #f59e0b;
    border: 2px solid rgba(245, 158, 11, 0.3);
}

.status-claimed {
    background: rgba(16, 185, 129, 0.2);
    color: #10b981;
    border: 2px solid rgba(16, 185, 129, 0.3);
}

.status-expired {
    background: rgba(107, 114, 128, 0.2);
    color: #6b7280;
    border: 2px solid rgba(107, 114, 128, 0.3);
}

/* Summary Cards */
.summary-cards {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
}

.summary-card {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    display: flex;
    align-items: center;
    gap: 1rem;
}

.summary-icon {
    font-size: 2.5rem;
}

.summary-value {
    font-size: 1.75rem;
    font-weight: 700;
    color: #667eea;
}

.summary-label {
    font-size: 0.9rem;
    color: #6b7280;
}

/* Items Container */
.items-container {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.section-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 1.5rem;
}

.items-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

/* Product Card */
.product-card {
    border: 2px solid #e5e7eb;
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.product-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.15);
    border-color: #667eea;
}

.product-image {
    width: 100%;
    height: 150px;
    background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
    display: flex;
    align-items: center;
    justify-content: center;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.product-placeholder {
    font-size: 4rem;
}

.product-info {
    padding: 1rem;
}

.product-name {
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.5rem;
}

.product-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.9rem;
}

.product-qty {
    color: #6b7280;
}

.product-points {
    color: #667eea;
    font-weight: 600;
}

/* Customer Card */
.customer-card {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.customer-content {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    margin-top: 1rem;
}

.customer-avatar {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    font-weight: 700;
}

.customer-name {
    font-weight: 600;
    font-size: 1.1rem;
    color: #1f2937;
    margin-bottom: 0.25rem;
}

.customer-email {
    color: #6b7280;
    font-size: 0.9rem;
    margin-bottom: 0.25rem;
}

.claimed-date {
    color: #10b981;
    font-size: 0.85rem;
    font-weight: 500;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 1rem;
}

.action-btn {
    flex: 1;
    padding: 1.25rem;
    border-radius: 16px;
    border: none;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    text-decoration: none;
    transition: all 0.3s ease;
}

.qr-btn {
    background: #667eea;
    color: white;
}

.qr-btn:hover {
    background: #5568d3;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(102, 126, 234, 0.3);
}

.cancel-btn {
    background: white;
    color: #ef4444;
    border: 2px solid #ef4444;
}

.cancel-btn:hover {
    background: #ef4444;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(239, 68, 68, 0.3);
}

.btn-icon {
    font-size: 1.25rem;
}

/* Toast Notifications */
.toast {
    position: fixed;
    top: 2rem;
    right: 2rem;
    padding: 1rem 1.5rem;
    border-radius: 12px;
    display: none;
    align-items: center;
    gap: 0.75rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    z-index: 1000;
    animation: slideIn 0.3s ease;
}

.toast-success {
    background: #10b981;
    color: white;
}

.toast-error {
    background: #ef4444;
    color: white;
}

.toast.show {
    display: flex;
}

.toast-icon {
    font-size: 1.5rem;
}

@keyframes slideIn {
    from {
        transform: translateX(400px);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

/* Responsive */
@media (max-width: 768px) {
    .receipt-show-page {
        padding: 1rem;
    }

    .back-fab {
        top: 1rem;
        left: 1rem;
        width: 44px;
        height: 44px;
    }

    .receipt-header-card {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }

    .summary-cards {
        grid-template-columns: 1fr;
    }

    .items-grid {
        grid-template-columns: 1fr;
    }

    .action-buttons {
        flex-direction: column;
    }
}
</style>

<script>
// Cancel receipt function
async function cancelReceipt(receiptId) {
    if (!confirm('Are you sure you want to cancel this receipt? This action cannot be undone.')) {
        return;
    }

    try {
        const response = await fetch(`/seller/receipts/${receiptId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (response.ok) {
            showToast(data.message || 'Receipt cancelled successfully', 'success');
            setTimeout(() => {
                window.location.href = '{{ route("seller.receipts.index") }}';
            }, 1500);
        } else {
            showToast(data.message || 'Failed to cancel receipt', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('An error occurred while cancelling the receipt', 'error');
    }
}

// Toast notification function
function showToast(message, type = 'success') {
    const toast = document.getElementById(type === 'success' ? 'success-toast' : 'error-toast');
    const messageEl = document.getElementById(type === 'success' ? 'success-message' : 'error-message');

    messageEl.textContent = message;
    toast.style.display = 'flex';
    toast.classList.add('show');

    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => {
            toast.style.display = 'none';
        }, 300);
    }, 4000);
}

// Handle URL success messages
@if(session('success'))
    showToast('{{ session('success') }}', 'success');
@endif

@if(session('error'))
    showToast('{{ session('error') }}', 'error');
@endif

// PHP helper function for item icons
@php
function getItemIcon($itemName) {
    $icons = [
        'Reusable Cup' => '♻️',
        'Coffee Cup' => '☕',
        'Water Bottle' => '🥤',
        'Food Container' => '🍽️',
        'Shopping Bag' => '🛍️',
        'Takeout Container' => '📦',
        'Straw' => '🥤',
        'Utensils Set' => '🍴'
    ];
    return $icons[$itemName] ?? '📦';
}
@endphp
</script>
@endsection
