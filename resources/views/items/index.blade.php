@extends('layouts.app')

@section('title', 'Items - Green Cup App')
@section('page-title', 'Items')
@section('page-subtitle', 'Manage your items')

@push('styles')
<style>
/* Modern Professional Design */
:root {
    --primary-gradient: linear-gradient(135deg, #00b09b 0%, #00d9a6 100%);
    --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    --danger-gradient: linear-gradient(135deg, #eb3349 0%, #f45c43 100%);
}

.inventory-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 2rem 1.5rem;
}

/* Header Card */
.inventory-header {
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

.inventory-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--primary-gradient);
}

.inventory-header-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    flex-wrap: wrap;
}

.inventory-title-section h1 {
    font-size: 2rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0 0 0.5rem 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.inventory-title-section h1 i {
    color: #00b09b;
    font-size: 1.75rem;
}

.inventory-subtitle {
    font-size: 0.875rem;
    color: #64748b;
    margin: 0;
}

.add-new-btn {
    background: var(--primary-gradient);
    color: white;
    padding: 0.875rem 1.75rem;
    border-radius: 14px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9375rem;
    display: inline-flex;
    align-items: center;
    gap: 0.625rem;
    border: none;
    cursor: pointer;
    box-shadow: 0 8px 24px rgba(0, 176, 155, 0.3);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.add-new-btn::before {
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

.add-new-btn:hover::before {
    width: 300px;
    height: 300px;
}

.add-new-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 16px 40px rgba(0, 176, 155, 0.4);
    color: white;
    text-decoration: none;
}

/* Statistics Cards */
.inventory-stats-bar {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-item {
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 1.75rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    border: none;
    display: flex;
    align-items: center;
    gap: 1.25rem;
}

.stat-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, transparent 0%, rgba(0, 176, 155, 0.05) 100%);
    opacity: 0;
    transition: opacity 0.4s;
}

.stat-item:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 20px 60px rgba(0, 176, 155, 0.25);
}

.stat-item:hover::before {
    opacity: 1;
}

.stat-icon {
    width: 64px;
    height: 64px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    background: var(--primary-gradient);
    color: white;
    box-shadow: 0 8px 24px rgba(0, 176, 155, 0.3);
    flex-shrink: 0;
}

.stat-content {
    flex: 1;
}

.stat-item-value {
    font-size: 2.25rem;
    font-weight: 800;
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    line-height: 1.2;
    margin-bottom: 0.25rem;
}

.stat-item-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Search and Filter Bar */
.search-filter-bar {
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    border: none;
}

.search-filter-row {
    display: flex;
    gap: 1rem;
    align-items: stretch;
}

.search-input-group {
    flex: 1;
    position: relative;
}

.search-input-group i {
    position: absolute;
    left: 1.25rem;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
    font-size: 1rem;
}

.search-input-group input {
    width: 100%;
    padding: 0.875rem 1rem 0.875rem 3rem;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    font-size: 0.9375rem;
    font-weight: 500;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.search-input-group input:focus {
    outline: none;
    border-color: #00b09b;
    box-shadow: 0 0 0 4px rgba(0, 176, 155, 0.1);
    transform: translateY(-2px);
}

.search-btn {
    background: var(--primary-gradient);
    color: white;
    padding: 0.875rem 2rem;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.9375rem;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    white-space: nowrap;
    box-shadow: 0 4px 12px rgba(0, 176, 155, 0.25);
}

.search-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 176, 155, 0.35);
}

/* Items Grid */
.items-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 1.5rem;
}

.item-card {
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(20px);
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
}

.item-card::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    border-radius: 24px;
    padding: 2px;
    background: var(--primary-gradient);
    -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
    mask-composite: exclude;
    opacity: 0;
    transition: opacity 0.4s;
    pointer-events: none;
}

.item-card:hover {
    transform: translateY(-12px);
    box-shadow: 0 20px 60px rgba(0, 176, 155, 0.25);
}

.item-card:hover::after {
    opacity: 1;
}

.item-image-container {
    height: 220px;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 80px;
    position: relative;
    overflow: hidden;
}

.item-image-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.item-card:hover .item-image-container img {
    transform: scale(1.1);
}

.item-image-container i {
    color: #cbd5e1;
    font-size: 80px;
}

.item-image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, transparent 0%, rgba(0, 0, 0, 0.7) 100%);
    opacity: 0;
    transition: opacity 0.4s;
    pointer-events: none;
}

.item-card:hover .item-image-overlay {
    opacity: 1;
}

.item-points-badge {
    position: absolute;
    top: 16px;
    right: 16px;
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(10px);
    padding: 12px 20px;
    border-radius: 16px;
    font-weight: 800;
    font-size: 1rem;
    color: #00b09b;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
    border: 2px solid rgba(255, 255, 255, 0.9);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 2;
}

.item-card:hover .item-points-badge {
    transform: scale(1.1) rotate(-5deg);
    box-shadow: 0 12px 32px rgba(0, 176, 155, 0.4);
}

.item-body {
    padding: 1.5rem;
}

.item-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.5rem;
    margin: 0;
}

.item-meta {
    padding-top: 1rem;
    border-top: 2px solid #f1f5f9;
    margin-top: 1rem;
    margin-bottom: 1rem;
}

.item-id-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: #64748b;
    font-weight: 600;
}

.item-id-badge i {
    font-size: 0.75rem;
}

/* Status Badge */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 12px;
    font-weight: 700;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.status-active {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    color: #065f46;
}

.status-inactive {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    color: #991b1b;
}

/* Action Buttons */
.item-actions {
    display: flex;
    gap: 0.75rem;
    margin-top: 1rem;
}

.item-actions form {
    display: flex;
    margin: 0;
    flex: 1;
}

.action-btn {
    padding: 0.75rem 1.25rem;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.875rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    white-space: nowrap;
    flex: 1;
    position: relative;
    overflow: hidden;
}

.action-btn::before {
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

.action-btn:hover::before {
    width: 300px;
    height: 300px;
}

.action-btn i {
    font-size: 0.875rem;
    position: relative;
    z-index: 1;
}

.action-btn span {
    position: relative;
    z-index: 1;
}

.btn-edit {
    background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
    color: #1e293b;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.btn-edit:hover {
    background: linear-gradient(135deg, #e5e7eb, #d1d5db);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    color: #1e293b;
    text-decoration: none;
}

.btn-delete {
    background: var(--danger-gradient);
    color: white;
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
}

.btn-delete:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(220, 38, 38, 0.4);
    color: white;
}

/* Empty State */
.empty-state-container {
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(20px);
    border-radius: 24px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    overflow: hidden;
}

.empty-inventory-state {
    padding: 5rem 2.5rem;
    text-align: center;
}

.empty-icon {
    font-size: 6rem;
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 1.5rem;
}

.empty-title {
    font-size: 2rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0 0 1rem 0;
}

.empty-text {
    font-size: 1.125rem;
    color: #64748b;
    margin: 0 0 2rem 0;
}

/* Pagination */
.pagination-wrapper {
    margin-top: 2rem;
    display: flex;
    justify-content: center;
}

.pagination {
    display: flex;
    gap: 0.5rem;
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
    min-width: 42px;
    height: 42px;
    padding: 0 0.75rem;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.875rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.pagination a {
    background: white;
    color: #1e293b;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.pagination a:hover {
    background: var(--primary-gradient);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 176, 155, 0.3);
    text-decoration: none;
}

.pagination .active span {
    background: var(--primary-gradient);
    color: white;
    box-shadow: 0 4px 12px rgba(0, 176, 155, 0.3);
}

.pagination .disabled span {
    background: #f9fafb;
    color: #d1d5db;
    cursor: not-allowed;
    box-shadow: none;
}

/* Animations */
@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive Design */
@media (max-width: 1024px) {
    .items-grid {
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.25rem;
    }
}

@media (max-width: 768px) {
    .inventory-container {
        padding: 1rem 0.5rem;
    }

    .inventory-header {
        padding: 1.75rem 1rem;
        margin-bottom: 1.25rem;
    }

    .inventory-header-row {
        flex-direction: column;
        align-items: stretch;
        gap: 1rem;
    }

    .inventory-title-section h1 {
        font-size: 1.75rem;
    }

    .inventory-title-section h1 i {
        font-size: 1.5rem;
    }

    .add-new-btn {
        width: 100%;
        justify-content: center;
        padding: 1rem 1.75rem;
        font-size: 1rem;
    }

    .inventory-stats-bar {
        grid-template-columns: 1fr;
        gap: 1.25rem;
        margin-bottom: 1.25rem;
    }

    .stat-item {
        padding: 1.75rem;
    }

    .stat-icon {
        width: 64px;
        height: 64px;
        font-size: 28px;
    }

    .stat-item-value {
        font-size: 2.25rem;
    }

    .stat-item-label {
        font-size: 0.9375rem;
    }

    .search-filter-bar {
        padding: 1.25rem;
        margin-bottom: 1.25rem;
    }

    .search-filter-row {
        flex-direction: column;
        gap: 1rem;
    }

    .search-input-group input {
        padding: 1rem 1rem 1rem 3rem;
        font-size: 1rem;
    }

    .search-input-group i {
        font-size: 1.125rem;
    }

    .search-btn {
        width: 100%;
        padding: 1rem 1.75rem;
        font-size: 1rem;
    }

    .items-grid {
        grid-template-columns: 1fr;
        gap: 1.25rem;
    }

    .item-image-container {
        height: 240px;
    }

    .item-image-container i {
        font-size: 80px;
    }

    .item-points-badge {
        padding: 12px 20px;
        font-size: 1rem;
    }

    .item-body {
        padding: 1.5rem;
    }

    .item-title {
        font-size: 1.375rem;
    }

    .item-meta {
        margin-top: 1.25rem;
        margin-bottom: 1.25rem;
        padding-top: 1.25rem;
    }

    .item-id-badge {
        font-size: 1rem;
    }

    .status-badge {
        padding: 0.625rem 1rem;
        font-size: 0.8125rem;
    }

    .item-actions {
        gap: 1rem;
        margin-top: 1.25rem;
    }

    .action-btn {
        padding: 0.875rem 1.25rem;
        font-size: 0.9375rem;
    }

    .pagination-wrapper {
        margin-top: 1.5rem;
    }

    .pagination {
        gap: 0.5rem;
    }

    .pagination a,
    .pagination span {
        min-width: 40px;
        height: 40px;
        font-size: 0.9375rem;
    }

    .empty-inventory-state {
        padding: 4rem 2rem;
    }

    .empty-icon {
        font-size: 5rem;
    }

    .empty-title {
        font-size: 1.75rem;
    }

    .empty-text {
        font-size: 1.125rem;
    }
}

@media (max-width: 480px) {
    .inventory-container {
        padding: 0.875rem 0.375rem;
    }

    .inventory-header {
        padding: 1.5rem 1rem;
        border-radius: 18px;
    }

    .inventory-title-section h1 {
        font-size: 1.5rem;
    }

    .inventory-title-section h1 i {
        font-size: 1.375rem;
    }

    .inventory-subtitle {
        font-size: 0.875rem;
    }

    .add-new-btn {
        padding: 0.9375rem 1.5rem;
        font-size: 0.9375rem;
    }

    .stat-item {
        padding: 1.5rem;
    }

    .stat-icon {
        width: 56px;
        height: 56px;
        font-size: 24px;
    }

    .stat-item-value {
        font-size: 2rem;
    }

    .stat-item-label {
        font-size: 0.875rem;
    }

    .search-filter-bar {
        padding: 1rem;
        border-radius: 18px;
    }

    .search-input-group input {
        padding: 0.9375rem 0.9375rem 0.9375rem 2.75rem;
        font-size: 0.9375rem;
    }

    .search-input-group i {
        left: 1rem;
        font-size: 1rem;
    }

    .search-btn {
        padding: 0.9375rem 1.75rem;
        font-size: 0.9375rem;
    }

    .item-image-container {
        height: 220px;
    }

    .item-image-container i {
        font-size: 72px;
    }

    .item-points-badge {
        padding: 10px 18px;
        font-size: 0.9375rem;
    }

    .item-body {
        padding: 1.375rem;
    }

    .item-title {
        font-size: 1.25rem;
    }

    .item-id-badge {
        font-size: 0.9375rem;
    }

    .status-badge {
        padding: 0.5rem 0.875rem;
        font-size: 0.75rem;
    }

    .action-btn {
        padding: 0.8125rem 1.125rem;
        font-size: 0.875rem;
    }

    .empty-inventory-state {
        padding: 3.5rem 2rem;
    }

    .empty-icon {
        font-size: 4.5rem;
    }

    .empty-title {
        font-size: 1.5rem;
    }

    .empty-text {
        font-size: 1rem;
    }

    .pagination a,
    .pagination span {
        min-width: 38px;
        height: 38px;
        font-size: 0.875rem;
        padding: 0 0.625rem;
    }
}
</style>
@endpush

@section('content')
<div class="inventory-container">
    <!-- Inventory Header -->
    <div class="inventory-header">
        <div class="inventory-header-row">
            <div class="inventory-title-section">
                <h1>
                    <i class="fas fa-warehouse"></i>
                    Items Inventory
                </h1>
                <p class="inventory-subtitle">Manage and track your recyclable items catalog</p>
            </div>
            <a href="{{ route('item.create') }}" class="add-new-btn">
                <i class="fas fa-plus"></i>
                Add New Item
            </a>
        </div>
    </div>

    <!-- Inventory Stats -->
    <div class="inventory-stats-bar">
        <div class="stat-item">
            <div class="stat-icon">
                <i class="fas fa-warehouse"></i>
            </div>
            <div class="stat-content">
                <div class="stat-item-value">{{ $items->total() }}</div>
                <div class="stat-item-label">Total Items</div>
            </div>
        </div>
        <div class="stat-item">
            <div class="stat-icon">
                <i class="fas fa-coins"></i>
            </div>
            <div class="stat-content">
                <div class="stat-item-value">{{ $items->total() }}</div>
                <div class="stat-item-label">Total Points (1:1)</div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Bar -->
    <div class="search-filter-bar">
        <form method="GET" action="{{ route('item.index') }}" class="search-filter-row">
            <div class="search-input-group">
                <i class="fas fa-search"></i>
                <input
                    type="text"
                    name="search"
                    placeholder="Search by item name..."
                    value="{{ request('search') }}"
                >
            </div>
            <button type="submit" class="search-btn">
                <i class="fas fa-search"></i> Search
            </button>
        </form>
    </div>

    @if($items->count() > 0)
        <!-- Items Grid -->
        <div class="items-grid">
            @foreach($items as $item)
            <div class="item-card">
                <div class="item-image-container">
                    @if($item->image_url)
                        <img src="{{ $item->image_url }}" alt="{{ $item->name }}">
                    @else
                        <i class="fas fa-box"></i>
                    @endif
                    <div class="item-image-overlay"></div>
                    <div class="item-points-badge">
                        <i class="fas fa-coins"></i>
                        1 Point
                    </div>
                </div>

                <div class="item-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h3 class="item-title">{{ $item->name }}</h3>
                        <span class="status-badge status-active">
                            <i class="fas fa-check-circle"></i>
                            Active
                        </span>
                    </div>

                    <div class="item-meta">
                        <span class="item-id-badge">
                            <i class="fas fa-hashtag"></i>
                            {{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}
                        </span>
                    </div>

                    <div class="item-actions">
                        <a href="{{ route('item.edit', $item) }}" class="action-btn btn-edit">
                            <i class="fas fa-edit"></i>
                            <span>Edit</span>
                        </a>
                        <form method="POST" action="{{ route('item.destroy', $item) }}"
                              onsubmit="return confirm('Are you sure you want to delete {{ $item->name }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn btn-delete">
                                <i class="fas fa-trash-alt"></i>
                                <span>Delete</span>
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
        <div class="empty-state-container">
            <div class="empty-inventory-state">
                <div class="empty-icon">
                    <i class="fas fa-inbox"></i>
                </div>
                <h3 class="empty-title">No Items Found</h3>
                <p class="empty-text">
                    @if(request('search'))
                        No items match your search criteria "{{ request('search') }}". Try a different search term.
                    @else
                        Your inventory is empty. Start by adding your first recyclable item to the catalog.
                    @endif
                </p>
                <a href="{{ route('item.create') }}" class="add-new-btn">
                    <i class="fas fa-plus"></i>
                    <span>Add Your First Item</span>
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
