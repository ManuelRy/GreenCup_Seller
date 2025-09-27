@extends('layouts.app')

@section('title', 'Items - Green Cup App')
@section('page-title', 'Items')
@section('page-subtitle', 'Manage your items')

@push('styles')
<style>
/* Reset and Base Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    -webkit-tap-highlight-color: transparent;
}

html {
    font-size: 16px;
    -webkit-text-size-adjust: 100%;
}

body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
    background: #ffffff;
    color: #333333;
    line-height: 1.6;
    min-height: 100vh;
    overflow-x: hidden;
    -webkit-font-smoothing: antialiased;
}

/* Container with Gradient Background */
.dashboard-container {
    min-height: 100vh;
    background: linear-gradient(135deg, #00b09b 0%, #00cdac 50%, #00dfa8 100%);
    padding-bottom: 40px;
}

/* Header */
.dashboard-header {
    background: #374151;
    padding: 20px;
    position: sticky;
    top: 0;
    z-index: 100;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.header-content {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 16px;
}

.header-back-btn {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.1);
    border: none;
    color: white;
    font-size: 18px;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
}

.header-back-btn:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateX(-2px);
    color: white;
    text-decoration: none;
}

.header-title-section {
    color: white;
}

.app-title {
    font-size: 24px;
    font-weight: 700;
    margin: 0;
    color: white;
}

.app-subtitle {
    font-size: 14px;
    color: rgba(255, 255, 255, 0.8);
    margin: 0;
}

.back-button {
    background: rgba(255, 255, 255, 0.1);
    color: white;
    padding: 10px 20px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s ease;
}

.back-button:hover {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    text-decoration: none;
}

/* Main Content */
.main-content {
    max-width: 1200px;
    margin: 0 auto;
    padding: 24px 20px;
}

/* Alerts */
.alert {
    padding: 16px;
    border-radius: 12px;
    margin-bottom: 20px;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 8px;
}

.alert-success {
    background: #d1fae5;
    color: #065f46;
    border: 1px solid #a7f3d0;
}

.alert-error {
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid #fca5a5;
}

/* Items Management Card */
.items-management-card {
    background: white;
    border-radius: 20px;
    padding: 32px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.12);
    margin-bottom: 24px;
}

.items-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
    flex-wrap: wrap;
    gap: 16px;
}

.items-title {
    font-size: 28px;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0;
}

.items-subtitle {
    font-size: 16px;
    color: #666;
    margin: 4px 0 0 0;
}

.add-item-btn {
    background: #10b981;
    color: white;
    padding: 12px 24px;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 8px;
    border: none;
    cursor: pointer;
}

.add-item-btn:hover {
    background: #059669;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    color: white;
    text-decoration: none;
}

/* Search Section */
.search-section {
    margin-bottom: 24px;
}

.search-form {
    display: flex;
    gap: 12px;
    max-width: 400px;
}

.search-input {
    flex: 1;
    padding: 12px 16px;
    border: 2px solid #e5e5e5;
    border-radius: 12px;
    font-size: 16px;
    transition: border-color 0.2s ease;
}

.search-input:focus {
    outline: none;
    border-color: #10b981;
}

.search-btn {
    background: #10b981;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s ease;
}

.search-btn:hover {
    background: #059669;
}

/* Items Grid */
.items-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
    margin-bottom: 32px;
}

.item-card {
    background: white;
    border: 2px solid #f0f0f0;
    border-radius: 16px;
    padding: 24px;
    transition: all 0.2s ease;
    position: relative;
}

.item-card:hover {
    border-color: #10b981;
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
}

.item-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 16px;
}

.item-info h3 {
    font-size: 20px;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0 0 4px 0;
}

.item-points {
    font-size: 16px;
    color: #10b981;
    font-weight: 600;
}

.item-actions {
    display: flex;
    gap: 8px;
}

.action-btn {
    padding: 8px 12px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s ease;
    border: none;
    cursor: pointer;
}

.btn-edit {
    background: #f3f4f6;
    color: #374151;
}

.btn-edit:hover {
    background: #e5e7eb;
    color: #374151;
    text-decoration: none;
}

.btn-delete {
    background: #fee2e2;
    color: #dc2626;
}

.btn-delete:hover {
    background: #fecaca;
    color: #dc2626;
}

.item-image {
    width: 100%;
    height: 120px;
    background: #f8f8f8;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 16px;
    overflow: hidden;
}

.item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.item-image-placeholder {
    font-size: 48px;
    color: #ccc;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #666;
}

.empty-state-icon {
    font-size: 64px;
    margin-bottom: 16px;
    color: #ccc;
}

.empty-state h3 {
    font-size: 24px;
    font-weight: 600;
    margin-bottom: 8px;
    color: #1a1a1a;
}

.empty-state p {
    font-size: 16px;
    margin-bottom: 24px;
}

/* Pagination */
.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 32px;
}

.pagination {
    display: flex;
    gap: 8px;
    list-style: none;
    margin: 0;
    padding: 0;
}

.pagination li {
    margin: 0;
}

.pagination a,
.pagination span {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.2s ease;
}

.pagination a {
    background: white;
    color: #374151;
    border: 1px solid #e5e5e5;
}

.pagination a:hover {
    background: #10b981;
    color: white;
    border-color: #10b981;
    text-decoration: none;
}

.pagination .active span {
    background: #10b981;
    color: white;
    border: 1px solid #10b981;
}

.pagination .disabled span {
    background: #f8f8f8;
    color: #ccc;
    border: 1px solid #e5e5e5;
    cursor: not-allowed;
}

/* Stats Section */
.stats-section {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
    margin-bottom: 32px;
}

.stat-card {
    background: white;
    border-radius: 16px;
    padding: 24px;
    text-align: center;
    box-shadow: 0 4px 16px rgba(0,0,0,0.08);
}

.stat-value {
    font-size: 32px;
    font-weight: 700;
    color: #10b981;
    margin-bottom: 4px;
}

.stat-label {
    font-size: 14px;
    color: #666;
    font-weight: 500;
}

/* Mobile Responsiveness */
@media (max-width: 768px) {
    .main-content {
        padding: 16px;
    }

    .items-management-card {
        padding: 24px 20px;
    }

    .items-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
    }

    .items-grid {
        grid-template-columns: 1fr;
        gap: 16px;
    }

    .search-form {
        max-width: 100%;
    }

    .stats-section {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 480px) {
    .header-content {
        flex-direction: column;
        gap: 16px;
        align-items: flex-start;
    }

    .stats-section {
        grid-template-columns: 1fr;
    }

    .item-header {
        flex-direction: column;
        gap: 12px;
        align-items: flex-start;
    }

    .item-actions {
        width: 100%;
        justify-content: space-between;
    }
}

/* Animations */
.fade-in {
    animation: fadeIn 0.3s ease-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
@endpush

@section('content')
<!-- Alerts -->
@if(session('success'))
    <div class="alert alert-success fade-in">
        ✅ {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-error fade-in">
        ❌ {{ session('error') }}
    </div>
@endif

<!-- Items Management Card -->
<div class="items-management-card fade-in">
    <!-- Header with Add Button -->
    <div class="items-header">
        <div>
            <h2 class="items-title">Items Catalog</h2>
            <p class="items-subtitle">Items available for receipt generation based on point values</p>
        </div>
                <a href="{{ route('item.create') }}" class="add-item-btn">
                    ➕ Add New Item
                </a>
            </div>

            <!-- Stats Section -->
            <div class="stats-section">
                <div class="stat-card">
                    <div class="stat-value">{{ $items->total() }}</div>
                    <div class="stat-label">Total Items</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">{{ $items->sum('points_per_unit') }}</div>
                    <div class="stat-label">Total Points</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">{{ number_format($items->avg('points_per_unit'), 1) }}</div>
                    <div class="stat-label">Avg Points</div>
                </div>
            </div>

            <!-- Search Section -->
            <div class="search-section">
                <form method="GET" action="{{ route('item.index') }}" class="search-form">
                    <input
                        type="text"
                        name="search"
                        placeholder="Search items by name..."
                        value="{{ request('search') }}"
                        class="search-input"
                    >
                    <button type="submit" class="search-btn">🔍 Search</button>
                </form>
            </div>

            @if($items->count() > 0)
                <!-- Items Grid -->
                <div class="items-grid">
                    @foreach($items as $item)
                        <div class="item-card">
                            <div class="item-image">
                                @if($item->image_url)
                                    <img src="{{ $item->image_url }}" alt="{{ $item->name }}">
                                @else
                                    <div class="item-image-placeholder">📦</div>
                                @endif
                            </div>

                            <div class="item-header">
                                <div class="item-info">
                                    <h3>{{ $item->name }}</h3>
                                    <div class="item-points">{{ $item->points_per_unit }} points each</div>
                                </div>

                                <div class="item-actions">
                                    <a href="{{ route('item.edit', $item) }}" class="action-btn btn-edit">
                                        ✏️ Edit
                                    </a>
                                    <form method="POST" action="{{ route('item.destroy', $item) }}" style="display: inline;"
                                          onsubmit="return confirm('Are you sure you want to delete this item?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn btn-delete">
                                            🗑️ Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($items->hasPages())
                    <div class="pagination-wrapper">
                        {{ $items->appends(request()->query())->links() }}
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="empty-state">
                    <div class="empty-state-icon">📦</div>
                    <h3>No Items Found</h3>
                    <p>
                        @if(request('search'))
                            No items match your search criteria. Try a different search term.
                        @else
                            Start building your catalog by adding your first item.
                        @endif
                    </p>
                    <a href="{{ route('item.create') }}" class="add-item-btn">
                        ➕ Add Your First Item
                    </a>
                </div>
            @endif
        </div>
    </main>
</div>
@endsection
