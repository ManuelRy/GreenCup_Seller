@extends('master')

@section('content')
<div class="consumers-container">
    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card total">
            <div class="stat-icon">👥</div>
            <div class="stat-details">
                <div class="stat-value">{{ $stats->total_consumers ?? 0 }}</div>
                <div class="stat-label">Total Consumers</div>
            </div>
        </div>

        <div class="stat-card points">
            <div class="stat-icon">⭐</div>
            <div class="stat-details">
                <div class="stat-value">{{ number_format($stats->total_points_given ?? 0) }}</div>
                <div class="stat-label">Points Given</div>
            </div>
        </div>

        <div class="stat-card receipts">
            <div class="stat-icon">📋</div>
            <div class="stat-details">
                <div class="stat-value">{{ $stats->total_receipts_claimed ?? 0 }}</div>
                <div class="stat-label">Receipts Claimed</div>
            </div>
        </div>

        <div class="stat-card items">
            <div class="stat-icon">📦</div>
            <div class="stat-details">
                <div class="stat-value">{{ number_format($stats->total_items_sold ?? 0) }}</div>
                <div class="stat-label">Items Sold</div>
            </div>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="filters-section">
        <form method="GET" class="filters-form">
            <div class="filter-group">
                <label for="search">Search:</label>
                <input type="text" name="search" id="search" placeholder="Name, email, or phone..."
                       value="{{ $search }}" oninput="handleSearchInput(this)">
            </div>

            <div class="filter-group">
                <label for="sort_by">Sort By:</label>
                <select name="sort_by" id="sort_by" onchange="this.form.submit()">
                    <option value="earned" {{ $sortBy === 'earned' ? 'selected' : '' }}>Points Earned</option>
                    <option value="transactions" {{ $sortBy === 'transactions' ? 'selected' : '' }}>Transaction Count</option>
                    <option value="recent" {{ $sortBy === 'recent' ? 'selected' : '' }}>Recent Activity</option>
                    <option value="name" {{ $sortBy === 'name' ? 'selected' : '' }}>Name (A-Z)</option>
                </select>
            </div>

            <div class="filter-group">
                <label for="sort_order">Order:</label>
                <select name="sort_order" id="sort_order" onchange="this.form.submit()">
                    <option value="desc" {{ $sortOrder === 'desc' ? 'selected' : '' }}>Descending</option>
                    <option value="asc" {{ $sortOrder === 'asc' ? 'selected' : '' }}>Ascending</option>
                </select>
            </div>

            <div class="filter-actions">
                <a href="{{ route('seller.consumers.index') }}" class="clear-filters">Clear</a>
            </div>
        </form>
    </div>

    <!-- Consumers List -->
    <div class="consumers-section">
        @if($consumers->count() > 0)
            <div class="consumers-list">
                @foreach($consumers as $consumer)
                    <div class="consumer-card">
                        <div class="consumer-header">
                            <div class="consumer-avatar">
                                {{ strtoupper(substr($consumer->full_name, 0, 1)) }}
                            </div>
                            <div class="consumer-info">
                                <div class="consumer-name">{{ $consumer->full_name }}</div>
                                <div class="consumer-contact">
                                    @if($consumer->email)
                                        <span class="contact-item">📧 {{ $consumer->email }}</span>
                                    @endif
                                    @if($consumer->phone_number)
                                        <span class="contact-item">📱 {{ $consumer->phone_number }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="consumer-stats">
                            <div class="stat-item">
                                <div class="stat-label">Points Earned</div>
                                <div class="stat-value points">{{ number_format($consumer->total_points_earned) }}</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-label">Transactions</div>
                                <div class="stat-value">{{ $consumer->total_transactions }}</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-label">Items Purchased</div>
                                <div class="stat-value">{{ $consumer->total_items_purchased }}</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-label">Last Visit</div>
                                <div class="stat-value small">{{ \Carbon\Carbon::parse($consumer->last_transaction_at)->diffForHumans() }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="pagination-wrapper">
                {{ $consumers->appends(request()->query())->links() }}
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">👥</div>
                <h3>No consumers yet</h3>
                <p>Consumers who claim your receipts will appear here.</p>
                <a href="{{ route('seller.receipts.create') }}" class="btn-primary">Create Your First Receipt</a>
            </div>
        @endif
    </div>
</div>

<style>
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
}

* {
    box-sizing: border-box;
}

body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
    line-height: 1.5;
    color: var(--text-primary);
    margin: 0;
    padding: 0;
    position: relative;
    min-height: 100vh;
}

.consumers-container {
    min-height: 100vh;
    padding: 0 0 2rem;
    position: relative;
    z-index: 1;
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

.stat-card.points .stat-icon {
    background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-light) 100%);
}

.stat-card.receipts .stat-icon {
    background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
}

.stat-card.items .stat-icon {
    background: linear-gradient(135deg, #ec4899 0%, #f472b6 100%);
}

.stat-value {
    font-size: 2.25rem;
    font-weight: 800;
    line-height: 1;
    background: linear-gradient(135deg, var(--text-primary) 0%, #374151 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.stat-label {
    font-size: 0.875rem;
    color: var(--text-secondary);
    margin-top: 0.25rem;
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

.clear-filters {
    padding: 0.75rem 1rem;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    background: var(--border-light);
    color: var(--text-secondary);
}

.clear-filters:hover {
    background: var(--border);
    color: var(--text-primary);
    text-decoration: none;
}

/* Consumers List */
.consumers-section {
    padding: 0 1.5rem;
    max-width: 1200px;
    margin: 0 auto;
}

.consumers-list {
    display: grid;
    gap: 1rem;
}

.consumer-card {
    background: var(--card-bg);
    border-radius: 20px;
    padding: 1.75rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06), 0 0 0 1px rgba(0, 0, 0, 0.02);
    transition: all 0.15s ease;
    border-left: 4px solid var(--primary-green);
}

.consumer-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1), 0 0 0 1px rgba(16, 185, 129, 0.1);
}

.consumer-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.consumer-avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-dark) 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    font-weight: 700;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

.consumer-info {
    flex: 1;
}

.consumer-name {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
}

.consumer-contact {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.contact-item {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
}

.consumer-actions {
    display: flex;
    gap: 0.5rem;
}

.view-btn {
    background: var(--primary-green);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.view-btn:hover {
    background: var(--primary-green-dark);
    transform: translateY(-1px);
    color: white;
    text-decoration: none;
}

.consumer-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    padding-top: 1rem;
    border-top: 1px solid var(--border-light);
}

.stat-item {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.stat-item .stat-label {
    font-size: 0.75rem;
    color: var(--text-secondary);
    font-weight: 500;
}

.stat-item .stat-value {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-primary);
}

.stat-item .stat-value.points {
    color: var(--primary-green);
}

.stat-item .stat-value.small {
    font-size: 0.875rem;
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

.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    background: var(--primary-green);
    color: white;
}

.btn-primary:hover {
    background: var(--primary-green-dark);
    transform: translateY(-1px);
    color: white;
    text-decoration: none;
}

/* Responsive Design */
@media (max-width: 991px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        padding: 1rem;
    }

    .filters-section {
        padding: 0 1rem;
    }

    .consumers-section {
        padding: 0 1rem;
    }
}

@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        padding: 1rem;
    }

    .stat-card {
        padding: 1.5rem 1rem;
    }

    .stat-icon {
        font-size: 2rem;
        width: 50px;
        height: 50px;
    }

    .stat-details .stat-value {
        font-size: 1.5rem;
    }

    .stat-details .stat-label {
        font-size: 0.75rem;
    }

    .filters-form {
        flex-direction: column;
        align-items: stretch;
        gap: 0.75rem;
    }

    .filter-group {
        width: 100%;
    }

    .filter-group input,
    .filter-group select {
        width: 100%;
    }

    .filter-actions {
        margin-left: 0;
        justify-content: center;
        width: 100%;
    }

    .filters-section {
        padding: 0 1rem;
        margin-bottom: 1rem;
    }

    .consumers-section {
        padding: 0 1rem;
    }

    .consumer-header {
        flex-wrap: wrap;
    }

    .consumer-avatar {
        width: 50px;
        height: 50px;
        font-size: 1.25rem;
    }

    .consumer-name {
        font-size: 1.1rem;
    }

    .consumer-stats {
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
    }

    .consumer-contact {
        flex-direction: column;
        gap: 0.5rem;
        font-size: 0.8rem;
    }

    .stat-item .stat-value {
        font-size: 1.1rem;
    }
}

@media (max-width: 576px) {
    .stats-grid {
        grid-template-columns: 1fr;
        gap: 0.75rem;
        padding: 0.75rem;
    }

    .stat-card {
        padding: 1.25rem 1rem;
        gap: 1rem;
    }

    .consumers-section {
        padding: 0 0.75rem;
    }

    .consumer-card {
        padding: 1rem;
    }

    .consumer-avatar {
        width: 45px;
        height: 45px;
        font-size: 1.1rem;
    }

    .consumer-name {
        font-size: 1rem;
    }

    .consumer-contact {
        font-size: 0.75rem;
    }

    .consumer-stats {
        grid-template-columns: 1fr;
        gap: 0.5rem;
    }

    .stat-item .stat-label {
        font-size: 0.7rem;
    }

    .stat-item .stat-value {
        font-size: 1rem;
    }

    .filter-group label {
        font-size: 0.875rem;
    }

    .filter-group input,
    .filter-group select {
        padding: 0.6rem;
        font-size: 0.875rem;
    }
}

@media (max-width: 480px) {
    .consumers-container {
        padding: 0 0 1.5rem;
    }

    .stats-grid {
        padding: 0.5rem;
        gap: 0.5rem;
    }

    .stat-card {
        padding: 1rem 0.75rem;
    }

    .stat-icon {
        font-size: 1.75rem;
        width: 45px;
        height: 45px;
    }

    .stat-value {
        font-size: 1.5rem;
    }

    .stat-label {
        font-size: 0.7rem;
    }

    .filters-section {
        padding: 0 0.5rem;
        margin-bottom: 1rem;
    }

    .consumers-section {
        padding: 0 0.5rem;
    }

    .consumer-card {
        padding: 0.875rem;
        border-radius: 12px;
    }

    .consumer-name {
        font-size: 0.95rem;
    }

    .consumer-avatar {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }

    .consumer-contact {
        font-size: 0.7rem;
    }

    .consumer-stats {
        padding-top: 0.75rem;
    }

    .stat-item .stat-value {
        font-size: 0.95rem;
    }

    .stat-item .stat-label {
        font-size: 0.65rem;
    }
}

@media (max-width: 360px) {
    .stats-grid {
        padding: 0.5rem;
    }

    .stat-card {
        padding: 0.875rem 0.625rem;
    }

    .stat-icon {
        font-size: 1.5rem;
        width: 40px;
        height: 40px;
    }

    .stat-value {
        font-size: 1.25rem;
    }

    .stat-label {
        font-size: 0.65rem;
    }

    .filters-section {
        padding: 0 0.5rem;
    }

    .consumers-section {
        padding: 0 0.5rem;
    }

    .consumer-card {
        padding: 0.75rem;
    }

    .consumer-header {
        gap: 0.75rem;
    }

    .consumer-avatar {
        width: 36px;
        height: 36px;
        font-size: 0.9rem;
    }

    .consumer-name {
        font-size: 0.9rem;
    }

    .consumer-contact {
        font-size: 0.65rem;
    }

    .stat-item .stat-value {
        font-size: 0.875rem;
    }

    .stat-item .stat-label {
        font-size: 0.6rem;
    }

    .filter-group input,
    .filter-group select {
        padding: 0.5rem;
        font-size: 0.8rem;
    }

    .clear-filters {
        padding: 0.5rem 1rem;
        font-size: 0.8rem;
    }
}
</style>

<script>
// Debounce timer for search
let searchTimeout;

function handleSearchInput(input) {
    // Clear previous timeout
    clearTimeout(searchTimeout);

    // Set new timeout to submit form after 500ms of no typing
    searchTimeout = setTimeout(function() {
        input.form.submit();
    }, 500);
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('Consumers page loaded');
});
</script>
@endsection
