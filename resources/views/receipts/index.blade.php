@extends('master')

@section('content')
<div class="receipts-container">
    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card total">
            <div class="stat-icon">📊</div>
            <div class="stat-details">
                <div class="stat-value">{{ $stats['total'] }}</div>
                <div class="stat-label">Total Receipts</div>
            </div>
        </div>

        <div class="stat-card pending">
            <div class="stat-icon">⏳</div>
            <div class="stat-details">
                <div class="stat-value">{{ $stats['pending'] }}</div>
                <div class="stat-label">Pending</div>
            </div>
        </div>

        <div class="stat-card claimed">
            <div class="stat-icon">✅</div>
            <div class="stat-details">
                <div class="stat-value">{{ $stats['claimed'] }}</div>
                <div class="stat-label">Claimed</div>
            </div>
        </div>

        <div class="stat-card expired">
            <div class="stat-icon">⌛</div>
            <div class="stat-details">
                <div class="stat-value">{{ $stats['expired'] }}</div>
                <div class="stat-label">Expired</div>
            </div>
        </div>
    </div>

    <!-- Points Summary -->
    <div class="points-summary">
        <div class="summary-card">
            <h3>Points Issued</h3>
            <div class="points-value">{{ number_format($stats['total_points_issued']) }} pts</div>
            <p>Total points created in receipts</p>
        </div>
        <div class="summary-card claimed-points">
            <h3>Points Claimed</h3>
            <div class="points-value">{{ number_format($stats['total_points_claimed']) }} pts</div>
            <p>Points successfully claimed by consumers</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="filters-section">
        <form method="GET" class="filters-form">
            <div class="filter-group">
                <label for="status">Status:</label>
                <select name="status" id="status" onchange="this.form.submit()">
                    <option value="all" {{ $status === 'all' ? 'selected' : '' }}>All Receipts</option>
                    <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="claimed" {{ $status === 'claimed' ? 'selected' : '' }}>Claimed</option>
                    <option value="expired" {{ $status === 'expired' ? 'selected' : '' }}>Expired</option>
                </select>
            </div>

            <div class="filter-group">
                <label for="search">Search:</label>
                <input type="text" name="search" id="search" placeholder="Receipt code..."
                       onchange="this.form.submit()">
            </div>

            <div class="filter-group">
                <label for="date_from">From:</label>
                <input type="date" name="date_from" id="date_from"
                       value="{{ $dateFrom }}" onchange="this.form.submit()">
            </div>

            <div class="filter-group">
                <label for="date_to">To:</label>
                <input type="date" name="date_to" id="date_to"
                       value="{{ $dateTo }}" onchange="this.form.submit()">
            </div>

            <div class="filter-actions">
                <a href="{{ route('seller.receipts.index') }}" class="clear-filters">Clear</a>
                <a href="{{ route('seller.receipts.export') }}" class="export-btn">
                    <span class="btn-icon">📊</span>
                    Export CSV
                </a>
            </div>
        </form>
    </div>

    <!-- Receipts List -->
    <div class="receipts-section">
        @if($receipts->count() > 0)
            <div class="receipts-list">
                @foreach($receipts as $receipt)
                    <div class="receipt-card {{ $receipt->status }}" data-receipt-id="{{ $receipt->id }}">
                        <div class="receipt-header">
                            <div class="receipt-code">
                                <span class="code-text">{{ $receipt->receipt_code }}</span>
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
                            <div class="receipt-actions">
                                <a href="{{ route('seller.receipts.show', $receipt->id) }}" class="view-btn" title="View Details">
                                    👁️
                                </a>
                                @if($receipt->status === 'pending')
                                    <a href="{{ route('seller.receipts.qr', $receipt->id) }}" class="qr-btn" title="Show QR Code" target="_blank">
                                        📱
                                    </a>
                                    <button onclick="cancelReceipt({{ $receipt->id }})" class="cancel-btn" title="Cancel Receipt">
                                        ❌
                                    </button>
                                @endif
                            </div>
                        </div>

                        <div class="receipt-details">
                            <div class="detail-row">
                                <span class="detail-label">Items:</span>
                                <span class="detail-value">{{ count($receipt->items) }} items ({{ $receipt->total_quantity }} total)</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Points:</span>
                                <span class="detail-value points">{{ $receipt->total_points }} pts</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Created:</span>
                                <span class="detail-value">{{ $receipt->formatted_created_at }}</span>
                            </div>
                            @if($receipt->expires_at)
                                <div class="detail-row">
                                    <span class="detail-label">Expires:</span>
                                    <span class="detail-value">{{ $receipt->formatted_expires_at }}</span>
                                </div>
                            @endif
                            @if($receipt->claimed_at)
                                <div class="detail-row">
                                    <span class="detail-label">Claimed:</span>
                                    <span class="detail-value">{{ $receipt->formatted_claimed_at }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Items Preview -->
                        @if(count($receipt->items) > 0)
                            <div class="items-preview">
                                <div class="items-label">Items:</div>
                                <div class="items-list">
                                    @foreach(array_slice($receipt->items, 0, 3) as $item)
                                        <span class="item-tag">{{ $item['quantity'] }}x {{ $item['name'] }}</span>
                                    @endforeach
                                    @if(count($receipt->items) > 3)
                                        <span class="more-items">+{{ count($receipt->items) - 3 }} more</span>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="pagination-wrapper">
                {{ $receipts->appends(request()->query())->links() }}
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">📄</div>
                <h3>No receipts found</h3>
                <p>You haven't created any receipts yet.</p>
                <a href="{{ route('seller.receipts.create') }}" class="btn-primary">Create Your First Receipt</a>
            </div>
        @endif
    </div>

    <!-- Floating Action Button (FAB) for Mobile -->
    <a href="{{ route('seller.receipts.create') }}" class="fab" title="Create Receipt">
        <span class="fab-icon">+</span>
    </a>
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
/* Modern Color Palette */
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
    background: linear-gradient(135deg, var(--background) 0%, #e0f2fe 100%);
    margin: 0;
    padding: 0;
    position: relative;
    min-height: 100vh;
}

body::before {
    content: '';
    position: fixed;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(16, 185, 129, 0.03) 1px, transparent 1px);
    background-size: 40px 40px;
    animation: floatPattern 60s linear infinite;
    pointer-events: none;
    z-index: 0;
}

@keyframes floatPattern {
    from { transform: translate(0, 0) rotate(0deg); }
    to { transform: translate(40px, 40px) rotate(360deg); }
}

.receipts-container {
    min-height: 100vh;
    padding: 0 0 2rem;
    position: relative;
    z-index: 1;
}

/* Header */
.receipts-header {
    background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
    color: white;
    padding: 2rem 1.5rem;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
}

.receipts-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 100%;
    height: 200%;
    background: radial-gradient(circle, rgba(16, 185, 129, 0.15) 0%, transparent 70%);
    transform: rotate(-15deg);
    pointer-events: none;
    animation: pulse 4s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 0.5; }
    50% { opacity: 1; }
}

.header-content {
    position: relative;
    z-index: 2;
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1200px;
    margin: 0 auto;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 1rem;
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
}

.back-button:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateX(-2px);
}

.header-left h1 {
    font-size: 1.75rem;
    font-weight: 700;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.header-left p {
    font-size: 0.875rem;
    margin: 0.25rem 0 0;
    opacity: 0.9;
}

.create-receipt-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: var(--primary-green);
    color: white;
    text-decoration: none;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: var(--shadow);
}

.create-receipt-btn:hover {
    background: var(--primary-green-dark);
    transform: translateY(-1px);
    box-shadow: var(--shadow-lg);
    color: white;
    text-decoration: none;
}

.btn-icon {
    font-size: 1.25rem;
    line-height: 1;
}

/* Statistics Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    padding: 1.5rem;
    max-width: 1200px;
    margin: 0 auto;
}

.stat-card {
    background: linear-gradient(135deg, var(--card-bg) 0%, #fafbfc 100%);
    border-radius: 20px;
    padding: 2rem 1.5rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08), 0 0 0 1px rgba(0, 0, 0, 0.02);
    display: flex;
    align-items: center;
    gap: 1.25rem;
    transition: all 0.15s ease;
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
    transition: none;
    display: none;
}

.stat-card:hover {
    transform: translateY(-6px) scale(1.02);
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.12), 0 0 0 1px rgba(16, 185, 129, 0.1);
}

.stat-icon {
    width: 70px;
    height: 70px;
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    flex-shrink: 0;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.15s ease;
}

.stat-card:hover .stat-icon {
    transform: scale(1.1) rotate(5deg);
}

.stat-card.total .stat-icon {
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
}

.stat-card.pending .stat-icon {
    background: linear-gradient(135deg, var(--warning) 0%, #fbbf24 100%);
}

.stat-card.claimed .stat-icon {
    background: linear-gradient(135deg, var(--success) 0%, var(--primary-green-light) 100%);
}

.stat-card.expired .stat-icon {
    background: linear-gradient(135deg, #6b7280 0%, #9ca3af 100%);
}

.stat-value {
    font-size: 2.25rem;
    font-weight: 800;
    line-height: 1;
    background: linear-gradient(135deg, var(--text-primary) 0%, #374151 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    transition: transform 0.3s;
}

.stat-card:hover .stat-value {
    transform: scale(1.05);
}

.stat-label {
    font-size: 0.875rem;
    color: var(--text-secondary);
    margin-top: 0.25rem;
}

/* Points Summary */
.points-summary {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    padding: 0 1.5rem 1.5rem;
    max-width: 1200px;
    margin: 0 auto;
}

.summary-card {
    background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-dark) 100%);
    color: white;
    border-radius: 20px;
    padding: 2rem 1.5rem;
    text-align: center;
    box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
    position: relative;
    overflow: hidden;
    transition: all 0.15s ease;
}

.summary-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 200%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
    transition: none;
    display: none;
}

.summary-card:hover {
    transform: translateY(-6px) scale(1.02);
    box-shadow: 0 20px 50px rgba(16, 185, 129, 0.4);
}

.summary-card.claimed-points {
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
}

.summary-card h3 {
    margin: 0 0 0.5rem;
    font-size: 1rem;
    font-weight: 600;
    opacity: 0.9;
}

.points-value {
    font-size: 2.75rem;
    font-weight: 900;
    line-height: 1;
    margin-bottom: 0.5rem;
    position: relative;
    z-index: 1;
}

.summary-card h3 {
    position: relative;
    z-index: 1;
}

.summary-card p {
    position: relative;
    z-index: 1;
}

.summary-card p {
    margin: 0;
    font-size: 0.875rem;
    opacity: 0.8;
}

/* Filters */
.filters-section {
    padding: 0 1.5rem 1.5rem;
    max-width: 1200px;
    margin: 0 auto;
}

.filters-form {
    background: var(--card-bg);
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: var(--shadow);
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    align-items: end;
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.filter-group label {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-secondary);
}

.filter-group select,
.filter-group input {
    padding: 0.75rem;
    border: 2px solid var(--border);
    border-radius: 8px;
    font-size: 0.875rem;
    background: var(--background);
    transition: all 0.3s ease;
    min-width: 150px;
}

.filter-group select:focus,
.filter-group input:focus {
    outline: none;
    border-color: var(--primary-green);
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
}

.filter-actions {
    display: flex;
    gap: 0.75rem;
    margin-left: auto;
}

.clear-filters,
.export-btn {
    padding: 0.75rem 1rem;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.clear-filters {
    background: var(--border-light);
    color: var(--text-secondary);
}

.clear-filters:hover {
    background: var(--border);
    color: var(--text-primary);
    text-decoration: none;
}

.export-btn {
    background: var(--primary-green);
    color: white;
}

.export-btn:hover {
    background: var(--primary-green-dark);
    transform: translateY(-1px);
    color: white;
    text-decoration: none;
}

/* Receipts List */
.receipts-section {
    padding: 0 1.5rem;
    max-width: 1200px;
    margin: 0 auto;
}

.receipts-list {
    display: grid;
    gap: 1rem;
}

.receipt-card {
    background: var(--card-bg);
    border-radius: 20px;
    padding: 1.75rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06), 0 0 0 1px rgba(0, 0, 0, 0.02);
    transition: all 0.15s ease;
    border-left: 4px solid transparent;
    position: relative;
    overflow: hidden;
}

.receipt-card::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    border-radius: 20px;
    padding: 2px;
    background: linear-gradient(135deg, transparent, rgba(16, 185, 129, 0.3));
    -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
    mask-composite: exclude;
    opacity: 0;
    transition: none;
    pointer-events: none;
    z-index: 0;
    display: none;
}

.receipt-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1), 0 0 0 1px rgba(16, 185, 129, 0.1);
}

.receipt-card.pending {
    border-left-color: var(--warning);
}

.receipt-card.claimed {
    border-left-color: var(--success);
}

.receipt-card.expired {
    border-left-color: var(--text-muted);
}

.receipt-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    position: relative;
    z-index: 1;
}

.receipt-code {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.code-text {
    font-family: 'SF Mono', Monaco, 'Cascadia Code', monospace;
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--text-primary);
}

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
}

.status-pending {
    background: rgba(245, 158, 11, 0.1);
    color: var(--warning);
}

.status-claimed {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success);
}

.status-expired {
    background: rgba(107, 114, 128, 0.1);
    color: var(--text-muted);
}

.receipt-actions {
    display: flex;
    gap: 0.5rem;
    position: relative;
    z-index: 2;
}

.view-btn,
.qr-btn,
.cancel-btn {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    text-decoration: none;
    border: none;
    cursor: pointer;
    font-size: 1rem;
    position: relative;
    z-index: 2;
}

.view-btn {
    background: var(--border-light);
    color: var(--text-secondary);
}

.view-btn:hover {
    background: var(--primary-green);
    color: white;
    text-decoration: none;
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
    color: var(--error);
}

.cancel-btn:hover {
    background: var(--error);
    color: white;
}

.receipt-details {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 0.75rem;
    margin-bottom: 1rem;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.detail-label {
    font-size: 0.875rem;
    color: var(--text-secondary);
    font-weight: 500;
}

.detail-value {
    font-size: 0.875rem;
    color: var(--text-primary);
    font-weight: 600;
}

.detail-value.points {
    color: var(--primary-green);
    font-weight: 700;
}

.items-preview {
    border-top: 1px solid var(--border-light);
    padding-top: 1rem;
}

.items-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-secondary);
    margin-bottom: 0.5rem;
}

.items-list {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.item-tag {
    background: var(--border-light);
    color: var(--text-secondary);
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
}

.more-items {
    background: var(--primary-green);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: var(--text-secondary);
}

.empty-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.empty-state h3 {
    font-size: 1.5rem;
    margin: 0 0 0.5rem;
    color: var(--text-primary);
}

.empty-state p {
    font-size: 1rem;
    margin: 0 0 1.5rem;
}

.btn-primary,
.btn-secondary {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-primary {
    background: var(--primary-green);
    color: white;
}

.btn-primary:hover {
    background: var(--primary-green-dark);
    transform: translateY(-1px);
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

/* Floating Action Button (FAB) */
.fab {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-dark) 100%);
    color: white;
    border-radius: 50%;
    display: flex; /* Always visible */
    align-items: center;
    justify-content: center;
    text-decoration: none;
    box-shadow: 0 8px 24px rgba(16, 185, 129, 0.4), 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: all 0.2s ease;
    z-index: 100;
    cursor: pointer;
    animation: fabBounce 0.3s ease-out;
}

.fab:hover {
    transform: scale(1.1);
    box-shadow: 0 12px 32px rgba(16, 185, 129, 0.5), 0 6px 12px rgba(0, 0, 0, 0.3);
    color: white;
    text-decoration: none;
}

.fab:active {
    transform: scale(0.95);
}

.fab-icon {
    font-size: 2rem;
    font-weight: 300;
    line-height: 1;
}

@keyframes fabBounce {
    0% {
        transform: scale(0.8) rotate(0deg);
        opacity: 0;
    }
    100% {
        transform: scale(1) rotate(0deg);
        opacity: 1;
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
    }

    .header-left {
        justify-content: center;
        text-align: center;
    }

    .stats-grid {
        grid-template-columns: 1fr;
        padding: 1rem;
    }

    .points-summary {
        grid-template-columns: 1fr;
        padding: 0 1rem 1rem;
    }

    .filters-form {
        flex-direction: column;
        align-items: stretch;
    }

    .filter-actions {
        margin-left: 0;
        justify-content: center;
    }

    .receipts-section {
        padding: 0 1rem;
    }

    .receipt-details {
        grid-template-columns: 1fr;
    }

    .receipt-header {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }

    .receipt-actions {
        align-self: flex-end;
    }

    .toast {
        top: 1rem;
        right: 1rem;
        left: 1rem;
        max-width: none;
        min-width: auto;
        transform: translateY(-100px);
    }

    .toast.show {
        transform: translateY(0);
    }
}

@media (max-width: 480px) {
    .header-left h1 {
        font-size: 1.5rem;
    }

    .stat-value {
        font-size: 1.75rem;
    }

    .points-value {
        font-size: 2rem;
    }

    .code-text {
        font-size: 1rem;
    }

    .items-list {
        flex-direction: column;
    }

    .item-tag,
    .more-items {
        display: inline-block;
        width: fit-content;
    }
}
</style>

<script>
// Auto-refresh functionality
let refreshInterval;

document.addEventListener('DOMContentLoaded', function() {
    // Auto-refresh every 30 seconds if there are pending receipts
    const pendingCount = {{ $stats['pending'] }};
    if (pendingCount > 0) {
        refreshInterval = setInterval(() => {
            // Only refresh if user is still on the page and not interacting
            if (!document.hidden && Date.now() - lastUserActivity > 10000) {
                window.location.reload();
            }
        }, 30000);
    }
});

// Track user activity
let lastUserActivity = Date.now();
document.addEventListener('mousemove', () => lastUserActivity = Date.now());
document.addEventListener('keypress', () => lastUserActivity = Date.now());

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

            // Update the receipt card
            const receiptCard = document.querySelector(`[data-receipt-id="${receiptId}"]`);
            if (receiptCard) {
                receiptCard.classList.remove('pending');
                receiptCard.classList.add('expired');

                // Update status badge
                const statusBadge = receiptCard.querySelector('.status-badge');
                statusBadge.className = 'status-badge status-expired';
                statusBadge.innerHTML = '⌛ Expired';

                // Remove action buttons
                const qrBtn = receiptCard.querySelector('.qr-btn');
                const cancelBtn = receiptCard.querySelector('.cancel-btn');
                if (qrBtn) qrBtn.remove();
                if (cancelBtn) cancelBtn.remove();
            }

            // Refresh page after delay to update stats
            setTimeout(() => window.location.reload(), 2000);
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

// Cleanup interval on page unload
window.addEventListener('beforeunload', function() {
    if (refreshInterval) {
        clearInterval(refreshInterval);
    }
});
</script>
@endsection
