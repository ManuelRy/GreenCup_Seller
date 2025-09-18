@extends('master')

@section('content')
<div class="receipt-detail-container">
    <!-- Header -->
    <div class="detail-header">
        <div class="header-content">
            <a href="{{ route('seller.receipts.index') }}" class="back-button">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
            </a>
            <div class="header-title">
                <h1>Receipt Details</h1>
                <p>{{ $receipt->receipt_code }}</p>
            </div>
            <div class="status-display">
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
    </div>

    <!-- Main Content -->
    <div class="detail-content">
        <!-- Receipt Information -->
        <div class="receipt-info-section">
            <div class="info-card">
                <div class="card-header">
                    <h2>📋 Receipt Information</h2>
                    <div class="header-actions">
                        @if($receipt->status === 'pending')
                            <a href="{{ route('seller.receipts.qr', $receipt->id) }}" class="qr-btn" target="_blank">
                                <span class="btn-icon">📱</span>
                                Show QR Code
                            </a>
                            <button onclick="cancelReceipt({{ $receipt->id }})" class="cancel-btn">
                                <span class="btn-icon">❌</span>
                                Cancel Receipt
                            </button>
                        @endif
                    </div>
                </div>

                <div class="info-grid">
                    <div class="info-item">
                        <label>Receipt Code</label>
                        <div class="info-value code-value">{{ $receipt->receipt_code }}</div>
                    </div>

                    <div class="info-item">
                        <label>Status</label>
                        <div class="info-value status-value">
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

                    <div class="info-item">
                        <label>Total Points</label>
                        <div class="info-value points-value">{{ $receipt->total_points }} pts</div>
                    </div>

                    <div class="info-item">
                        <label>Total Quantity</label>
                        <div class="info-value">{{ $receipt->total_quantity }} items</div>
                    </div>

                    <div class="info-item">
                        <label>Created</label>
                        <div class="info-value">{{ $receipt->created_at }}</div>
                    </div>

                    @if($receipt->expires_at)
                        <div class="info-item">
                            <label>Expires</label>
                            <div class="info-value">{{ $receipt->expires_at }}</div>
                        </div>
                    @endif

                    @if($receipt->claimed_at)
                        <div class="info-item">
                            <label>Claimed</label>
                            <div class="info-value">{{ $receipt->claimed_at }}</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Customer Information (if claimed) -->
            @if($receipt->consumer)
                <div class="info-card">
                    <div class="card-header">
                        <h2>👤 Customer Information</h2>
                    </div>

                    <div class="customer-info">
                        <div class="customer-avatar">
                            {{ substr($receipt->consumer->full_name, 0, 1) }}
                        </div>
                        <div class="customer-details">
                            <div class="customer-name">{{ $receipt->consumer->full_name }}</div>
                            <div class="customer-email">{{ $receipt->consumer->email }}</div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Items List -->
        <div class="items-section">
            <div class="items-card">
                <div class="card-header">
                    <h2>📦 Items ({{ count($receipt->items) }})</h2>
                    <div class="items-summary">
                        Total: {{ $receipt->total_quantity }} qty • {{ $receipt->total_points }} pts
                    </div>
                </div>

                <div class="items-list">
                    @if(count($receipt->items) > 0)
                        @foreach($receipt->items as $item)
                            <div class="item-row">
                                <div class="item-info">
                                    <div class="item-icon">{{ getItemIcon($item['name']) }}</div>
                                    <div class="item-details">
                                        <div class="item-name">{{ $item['name'] }}</div>
                                        <div class="item-meta">{{ $item['points_per_unit'] }} pts per unit</div>
                                    </div>
                                </div>
                                <div class="item-quantity">
                                    <span class="qty-badge">{{ $item['quantity'] }}x</span>
                                </div>
                                <div class="item-total">
                                    {{ $item['total_points'] }} pts
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="no-items">
                            <div class="no-items-icon">📦</div>
                            <p>No items found in this receipt</p>
                        </div>
                    @endif
                </div>

                @if(count($receipt->items) > 0)
                    <div class="items-total">
                        <div class="total-row">
                            <span>Total Items:</span>
                            <span>{{ count($receipt->items) }}</span>
                        </div>
                        <div class="total-row">
                            <span>Total Quantity:</span>
                            <span>{{ $receipt->total_quantity }}</span>
                        </div>
                        <div class="total-row grand-total">
                            <span>Total Points:</span>
                            <span>{{ $receipt->total_points }} pts</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Actions Footer -->
    <div class="actions-footer">
        <div class="footer-content">
            <div class="action-buttons">
                <a href="{{ route('seller.receipts.index') }}" class="btn-secondary">
                    <span class="btn-icon">📋</span>
                    Back to Receipts
                </a>
                
                @if($receipt->status === 'pending')
                    <a href="{{ route('seller.receipts.qr', $receipt->id) }}" class="btn-primary" target="_blank">
                        <span class="btn-icon">📱</span>
                        Show QR Code
                    </a>
                @else
                    <button class="btn-disabled" disabled>
                        <span class="btn-icon">📱</span>
                        QR Code Unavailable
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Success Toast -->
<div id="success-toast" class="toast success-toast" style="display: none;">
    <div class="toast-content">
        <span class="toast-icon">✅</span>
        <span class="toast-message" id="success-message">Success!</span>
    </div>
</div>

<!-- Error Toast -->
<div id="error-toast" class="toast error-toast" style="display: none;">
    <div class="toast-content">
        <span class="toast-icon">❌</span>
        <span class="toast-message" id="error-message">Error occurred</span>
    </div>
</div>

<style>
/* Color System */
:root {
    --primary-green: #10b981;
    --primary-green-dark: #059669;
    --primary-green-light: #34d399;
    --background: #f8fafc;
    --card-bg: #ffffff;
    --text-primary: #111827;
    --text-secondary: #6b7280;
    --text-muted: #9ca3af;
    --border: #e5e7eb;
    --border-light: #f3f4f6;
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    --warning: #f59e0b;
    --success: #10b981;
    --error: #ef4444;
}

* {
    box-sizing: border-box;
}

body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
    line-height: 1.5;
    color: var(--text-primary);
    background: var(--background);
    margin: 0;
    padding: 0;
}

.receipt-detail-container {
    min-height: 100vh;
    padding-bottom: 100px; /* Space for fixed footer */
}

/* Header */
.detail-header {
    background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
    color: white;
    padding: 1.5rem;
    position: relative;
    overflow: hidden;
}

.detail-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 100%;
    height: 200%;
    background: radial-gradient(circle, rgba(16, 185, 129, 0.1) 0%, transparent 70%);
    transform: rotate(-15deg);
    pointer-events: none;
}

.header-content {
    position: relative;
    z-index: 2;
    display: flex;
    align-items: center;
    gap: 1rem;
    max-width: 1200px;
    margin: 0 auto;
}

.back-button {
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-decoration: none;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    width: 44px;
    height: 44px;
    border-radius: 12px;
    transition: all 0.3s ease;
    flex-shrink: 0;
}

.back-button:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateX(-2px);
    color: white;
    text-decoration: none;
}

.header-title {
    flex: 1;
    text-align: center;
}

.header-title h1 {
    font-size: 1.75rem;
    font-weight: 700;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.header-title p {
    font-family: 'SF Mono', Monaco, 'Cascadia Code', monospace;
    font-size: 1rem;
    margin: 0.25rem 0 0;
    opacity: 0.9;
    font-weight: 600;
}

.status-display {
    flex-shrink: 0;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 12px;
    font-size: 0.875rem;
    font-weight: 600;
    backdrop-filter: blur(10px);
}

.status-pending {
    background: rgba(245, 158, 11, 0.2);
    color: #fbbf24;
    border: 1px solid rgba(245, 158, 11, 0.3);
}

.status-claimed {
    background: rgba(16, 185, 129, 0.2);
    color: #34d399;
    border: 1px solid rgba(16, 185, 129, 0.3);
}

.status-expired {
    background: rgba(107, 114, 128, 0.2);
    color: #d1d5db;
    border: 1px solid rgba(107, 114, 128, 0.3);
}

/* Main Content */
.detail-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
    padding: 2rem;
    max-width: 1200px;
    margin: 0 auto;
    align-items: start;
}

/* Receipt Information */
.receipt-info-section {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.info-card,
.items-card {
    background: var(--card-bg);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: var(--shadow-lg);
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    background: linear-gradient(135deg, var(--border-light) 0%, var(--card-bg) 100%);
    border-bottom: 1px solid var(--border-light);
}

.card-header h2 {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-primary);
}

.header-actions {
    display: flex;
    gap: 0.75rem;
}

.qr-btn,
.cancel-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 600;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.qr-btn {
    background: rgba(99, 102, 241, 0.1);
    color: #6366f1;
}

.qr-btn:hover {
    background: #6366f1;
    color: white;
    text-decoration: none;
}

.cancel-btn {
    background: rgba(239, 68, 68, 0.1);
    color: #ef4444;
}

.cancel-btn:hover {
    background: #ef4444;
    color: white;
}

.info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    padding: 1.5rem;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.info-item label {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.info-value {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-primary);
}

.code-value {
    font-family: 'SF Mono', Monaco, 'Cascadia Code', monospace;
    background: var(--background);
    padding: 0.75rem;
    border-radius: 8px;
    border: 2px solid var(--primary-green);
    color: var(--primary-green);
    font-weight: 700;
}

.points-value {
    color: var(--primary-green);
    font-weight: 700;
    font-size: 1.125rem;
}

/* Customer Information */
.customer-info {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
}

.customer-avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-dark) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    font-weight: 700;
    color: white;
    flex-shrink: 0;
}

.customer-details {
    flex: 1;
}

.customer-name {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
}

.customer-email {
    font-size: 0.875rem;
    color: var(--text-secondary);
}

/* Items Section */
.items-section {
    position: sticky;
    top: 2rem;
}

.items-summary {
    font-size: 0.875rem;
    color: var(--text-secondary);
    font-weight: 500;
}

.items-list {
    max-height: 400px;
    overflow-y: auto;
}

.item-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--border-light);
    transition: all 0.3s ease;
}

.item-row:hover {
    background: var(--border-light);
}

.item-row:last-child {
    border-bottom: none;
}

.item-info {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex: 1;
}

.item-icon {
    font-size: 1.5rem;
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: var(--background);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.item-details {
    flex: 1;
}

.item-name {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
}

.item-meta {
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.item-quantity {
    margin: 0 1rem;
}

.qty-badge {
    background: var(--primary-green);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.875rem;
    font-weight: 600;
}

.item-total {
    font-size: 1rem;
    font-weight: 700;
    color: var(--primary-green);
    text-align: right;
    min-width: 80px;
}

.no-items {
    text-align: center;
    padding: 3rem 1.5rem;
    color: var(--text-secondary);
}

.no-items-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.items-total {
    border-top: 1px solid var(--border-light);
    padding: 1.5rem;
    background: var(--background);
}

.total-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.total-row.grand-total {
    border-top: 2px solid var(--border);
    margin-top: 0.5rem;
    padding-top: 1rem;
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--primary-green);
}

/* Actions Footer */
.actions-footer {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: var(--card-bg);
    border-top: 1px solid var(--border-light);
    box-shadow: 0 -4px 6px -1px rgba(0, 0, 0, 0.1), 0 -2px 4px -1px rgba(0, 0, 0, 0.06);
    z-index: 100;
}

.footer-content {
    max-width: 1200px;
    margin: 0 auto;
    padding: 1.5rem 2rem;
}

.action-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
}

.btn-primary,
.btn-secondary,
.btn-disabled {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-size: 1rem;
    font-weight: 600;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-primary {
    background: var(--primary-green);
    color: white;
    box-shadow: var(--shadow);
}

.btn-primary:hover {
    background: var(--primary-green-dark);
    transform: translateY(-1px);
    box-shadow: var(--shadow-lg);
    color: white;
    text-decoration: none;
}

.btn-secondary {
    background: var(--border-light);
    color: var(--text-secondary);
}

.btn-secondary:hover {
    background: var(--border);
    color: var(--text-primary);
    text-decoration: none;
}

.btn-disabled {
    background: var(--border-light);
    color: var(--text-muted);
    cursor: not-allowed;
    opacity: 0.6;
}

.btn-icon {
    font-size: 1.125rem;
}

/* Toast Messages */
.toast {
    position: fixed;
    top: 2rem;
    right: 2rem;
    background: var(--card-bg);
    border-radius: 12px;
    padding: 1rem;
    box-shadow: var(--shadow-lg);
    z-index: 1000;
    transform: translateX(400px);
    transition: transform 0.3s ease;
    max-width: 350px;
    min-width: 280px;
}

.toast.show {
    transform: translateX(0);
}

.toast.success-toast {
    background: #ecfdf5;
    border-left: 4px solid var(--success);
}

.toast.error-toast {
    background: #fef2f2;
    border-left: 4px solid var(--error);
}

.toast-content {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.toast-icon {
    font-size: 1.25rem;
    flex-shrink: 0;
}

.toast-message {
    font-weight: 500;
    color: var(--text-primary);
    line-height: 1.4;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .detail-content {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .items-section {
        position: static;
    }
}

@media (max-width: 768px) {
    .detail-header {
        padding: 1rem;
    }
    
    .header-content {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .detail-content {
        padding: 1rem;
        gap: 1rem;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
        padding: 1rem;
    }
    
    .card-header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
        padding: 1rem;
    }
    
    .header-actions {
        justify-content: center;
    }
    
    .item-row {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
        padding: 1rem;
    }
    
    .item-info {
        justify-content: center;
    }
    
    .footer-content {
        padding: 1rem;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .toast {
        top: 1rem;
        right: 1rem;
        left: 1rem;
        max-width: none;
        transform: translateY(-100px);
    }
    
    .toast.show {
        transform: translateY(0);
    }
}

@media (max-width: 480px) {
    .header-title h1 {
        font-size: 1.5rem;
    }
    
    .header-title p {
        font-size: 0.875rem;
    }
    
    .customer-info {
        flex-direction: column;
        text-align: center;
        padding: 1rem;
    }
    
    .customer-avatar {
        width: 50px;
        height: 50px;
        font-size: 1.25rem;
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

        if (data.success) {
            showToast(data.message, 'success');
            
            // Redirect to receipts list after delay
            setTimeout(() => {
                window.location.href = '{{ route("seller.receipts.index") }}';
            }, 2000);
        } else {
            showToast(data.message || 'Failed to cancel receipt', 'error');
        }
    } catch (error) {
        console.error('Cancel receipt error:', error);
        showToast('Network error. Please try again.', 'error');
    }
}

// Toast notification function
function showToast(message, type = 'success') {
    const toast = document.getElementById(type === 'success' ? 'success-toast' : 'error-toast');
    const messageEl = document.getElementById(type === 'success' ? 'success-message' : 'error-message');
    
    messageEl.textContent = message;
    toast.style.display = 'block';
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