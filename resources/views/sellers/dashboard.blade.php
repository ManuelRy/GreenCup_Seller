@extends('master')

@section('content')
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
    background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
    padding: 16px 20px;
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

.app-title {
    color: white;
    font-size: 20px;
    font-weight: 600;
    margin: 0;
}

.user-section {
    display: flex;
    align-items: center;
    gap: 12px;
    cursor: pointer;
    padding: 8px;
    border-radius: 8px;
    transition: background-color 0.2s ease;
}

.user-section:hover {
    background: rgba(255,255,255,0.1);
}

.user-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    font-weight: 600;
    color: #333;
    cursor: pointer;
    transition: all 0.2s ease;
}

.user-avatar:hover {
    transform: scale(1.05);
}

.user-name {
    color: white;
    font-size: 14px;
    font-weight: 500;
}

/* Main Content */
.main-content {
    max-width: 1000px;
    margin: 0 auto;
    padding: 24px 16px;
}

/* Points Card */
.points-card {
    background: white;
    border-radius: 20px;
    padding: 32px;
    text-align: center;
    margin-bottom: 24px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.12);
    position: relative;
    overflow: hidden;
}

.points-card::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: conic-gradient(from 0deg, #00b09b, #00cdac, #00dfa8, #00b09b);
    opacity: 0.05;
    animation: rotate 20s linear infinite;
}

@keyframes rotate {
    to { transform: rotate(360deg); }
}

.points-value {
    font-size: 56px;
    font-weight: 700;
    color: #1a1a1a;
    line-height: 1;
    margin-bottom: 8px;
    position: relative;
    z-index: 2;
}

.points-label {
    font-size: 12px;
    color: #666;
    text-transform: uppercase;
    letter-spacing: 1px;
    position: relative;
    z-index: 2;
}

/* Progress Section */
.progress-card {
    background: white;
    border-radius: 20px;
    padding: 20px;
    margin-bottom: 24px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    border: 2px solid #f0f0f0;
}

.progress-section {
    position: relative;
}

.progress-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}

.rank-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    color: #92400e;
    padding: 8px 16px;
    border-radius: 25px;
    font-size: 13px;
    font-weight: 600;
    border: 1px solid #f59e0b;
}

.progress-text {
    font-size: 12px;
    color: #666;
    font-weight: 500;
}

.progress-bar {
    width: 100%;
    height: 10px;
    background: #e5e7eb;
    border-radius: 5px;
    overflow: hidden;
    margin-bottom: 12px;
    box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #fbbf24 0%, #f59e0b 100%);
    border-radius: 5px;
    transition: width 0.8s ease;
    box-shadow: 0 2px 4px rgba(251, 191, 36, 0.4);
}

.progress-labels {
    display: flex;
    justify-content: space-between;
    font-size: 11px;
    color: #999;
    font-weight: 500;
}

/* Receipt Management Card */
.receipt-stats-card {
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    border-radius: 20px;
    padding: 24px;
    margin-bottom: 24px;
    box-shadow: 0 8px 32px rgba(16, 185, 129, 0.15);
    border: 1px solid rgba(16, 185, 129, 0.2);
    position: relative;
    overflow: hidden;
}

.receipt-stats-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -30%;
    width: 100%;
    height: 200%;
    background: radial-gradient(circle, rgba(16, 185, 129, 0.1) 0%, transparent 70%);
    transform: rotate(15deg);
    pointer-events: none;
}

.receipt-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    position: relative;
    z-index: 2;
}

.receipt-title {
    font-size: 18px;
    font-weight: 700;
    color: #064e3b;
    display: flex;
    align-items: center;
    gap: 10px;
}

.receipt-icon {
    font-size: 22px;
}

.receipt-stats-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-bottom: 20px;
    position: relative;
    z-index: 2;
}

.receipt-stat {
    text-align: center;
    background: white;
    padding: 20px;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    border: 1px solid rgba(16, 185, 129, 0.1);
}

.receipt-stat-value {
    font-size: 36px;
    font-weight: 800;
    color: #10b981;
    line-height: 1;
    margin-bottom: 6px;
}

.receipt-stat-label {
    font-size: 12px;
    color: #047857;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.receipt-actions {
    display: flex;
    gap: 12px;
    position: relative;
    z-index: 2;
}

.receipt-btn {
    flex: 1;
    padding: 14px 18px;
    border-radius: 12px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    text-align: center;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.receipt-btn-primary {
    background: #10b981;
    color: white;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

.receipt-btn-primary:hover {
    background: #059669;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
    color: white;
    text-decoration: none;
}

.receipt-btn-secondary {
    background: white;
    color: #047857;
    border: 2px solid rgba(16, 185, 129, 0.3);
}

.receipt-btn-secondary:hover {
    background: #f0fdf4;
    color: #064e3b;
    text-decoration: none;
    transform: translateY(-2px);
    border-color: rgba(16, 185, 129, 0.5);
}

/* Analytics Card */
.analytics-card {
    background: white;
    border-radius: 20px;
    padding: 24px;
    margin-bottom: 24px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}

.analytics-header {
    text-align: center;
    margin-bottom: 24px;
}

.analytics-title {
    font-size: 18px;
    font-weight: 600;
    color: #333;
}

/* Donut Chart Container */
.chart-container {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 24px;
    position: relative;
}

.donut-chart {
    width: 200px;
    height: 200px;
    filter: drop-shadow(0 4px 8px rgba(0,0,0,0.1));
}

.chart-center {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
}

.chart-value {
    font-size: 36px;
    font-weight: 700;
    color: #1a1a1a;
    line-height: 1;
}

.chart-label {
    font-size: 12px;
    color: #666;
    margin-top: 4px;
    font-weight: 500;
}

.chart-legend {
    display: flex;
    justify-content: center;
    gap: 40px;
    margin-top: 20px;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    color: #666;
    font-weight: 500;
}

.legend-dot {
    width: 14px;
    height: 14px;
    border-radius: 4px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

.legend-dot.green {
    background: #10b981;
}

.legend-dot.red {
    background: #ef4444;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-bottom: 24px;
}

.stat-card {
    background: white;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.08);
    text-align: center;
    transition: transform 0.2s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
}

.stat-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
}

.stat-title {
    font-size: 14px;
    color: #666;
    font-weight: 500;
}

.stat-icon {
    font-size: 20px;
}

.stat-value {
    font-size: 32px;
    font-weight: 700;
    color: #1a1a1a;
    line-height: 1;
    margin-bottom: 4px;
}

.stat-subtitle {
    font-size: 12px;
    color: #999;
}

/* Quick Actions Grid - Now 5 items */
.actions-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr); /* Changed from 5 to 4 to match 2x2 layout */
    gap: 16px; /* Changed from 12px to 16px to match stats-grid */
    margin-bottom: 24px;
}

@media (max-width: 768px) {
    .actions-grid {
        grid-template-columns: repeat(2, 1fr); /* 2x2 on tablet */
    }
    
    .stats-grid {
        grid-template-columns: 1fr; /* Stack stats vertically on tablet */
        gap: 12px;
    }
}

@media (max-width: 480px) {
    .actions-grid {
        grid-template-columns: repeat(2, 1fr); /* Keep 2x2 on mobile */
        gap: 12px;
    }
    
    .stats-grid {
        grid-template-columns: 1fr; /* Stack stats vertically on mobile */
        gap: 12px;
    }
}

.action-card {
    background: white;
    border-radius: 16px;
    padding: 20px 12px;
    text-align: center;
    text-decoration: none;
    color: #333;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    border: 2px solid transparent;
}

.action-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    color: #333;
    text-decoration: none;
    border-color: #00b09b;
}

.action-card.receipt-action {
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    border: 2px solid rgba(16, 185, 129, 0.2);
}

.action-card.receipt-action:hover {
    background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
    border-color: #10b981;
}

.action-card.scanner-action {
    background: linear-gradient(135deg, #ede9fe 0%, #ddd6fe 100%);
    border: 2px solid rgba(139, 92, 246, 0.2);
}

.action-card.scanner-action:hover {
    background: linear-gradient(135deg, #ddd6fe 0%, #c4b5fd 100%);
    border-color: #8b5cf6;
}

.action-icon {
    font-size: 28px;
    margin-bottom: 8px;
}

.action-label {
    font-size: 13px;
    font-weight: 600;
    line-height: 1.2;
}

/* Recent Activity */
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

.view-all {
    font-size: 14px;
    color: #00b09b;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.2s ease;
}

.view-all:hover {
    color: #009688;
    text-decoration: none;
}

.activity-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.activity-item {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 12px;
    border-radius: 12px;
    transition: background-color 0.2s ease;
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
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 48px 24px;
}

.empty-icon {
    font-size: 48px;
    margin-bottom: 16px;
    opacity: 0.5;
}

.empty-title {
    font-size: 18px;
    font-weight: 600;
    color: #333;
    margin-bottom: 8px;
}

.empty-text {
    font-size: 14px;
    color: #666;
    margin-bottom: 24px;
    line-height: 1.5;
}

.btn-primary {
    background: linear-gradient(135deg, #00b09b, #00cdac);
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(0, 176, 155, 0.3);
}

.btn-primary:hover {
    background: linear-gradient(135deg, #009688, #00b09b);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 176, 155, 0.4);
    color: white;
    text-decoration: none;
}

/* Getting Started Card */
.getting-started-card {
    background: linear-gradient(135deg, #fff7ed 0%, #fed7aa 100%);
    border-radius: 20px;
    padding: 24px;
    margin-top: 24px;
    box-shadow: 0 4px 20px rgba(251, 146, 60, 0.15);
    border: 1px solid rgba(251, 146, 60, 0.2);
}

.getting-started-title {
    font-size: 18px;
    font-weight: 700;
    color: #9a3412;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.getting-started-steps {
    line-height: 2;
    color: #7c2d12;
    font-weight: 500;
}

.getting-started-steps p {
    margin-bottom: 8px;
    padding-left: 8px;
}

/* Utility Classes */
.text-center { text-align: center; }
.text-muted { color: #666; }

/* Mobile Optimizations */
@media (max-width: 640px) {
    .main-content {
        padding: 16px 12px;
    }
    
    .points-value {
        font-size: 48px;
    }
    
    .stat-value {
        font-size: 28px;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .chart-legend {
        gap: 20px;
    }
    
    .receipt-stats-grid {
        grid-template-columns: 1fr;
    }
    
    .receipt-actions {
        flex-direction: column;
    }
    
    .progress-header {
        flex-direction: column;
        gap: 8px;
        text-align: center;
    }
}

/* Animations */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-in {
    animation: fadeIn 0.6s ease-out;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.slide-in {
    animation: slideIn 0.5s ease-out;
}

/* Loading States */
.loading {
    opacity: 0.7;
    pointer-events: none;
}

/* Toast Notifications */
.toast {
    position: fixed;
    top: 20px;
    right: 20px;
    background: white;
    border-radius: 12px;
    padding: 16px 20px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    border-left: 4px solid #10b981;
    z-index: 1000;
    transform: translateX(400px);
    transition: transform 0.3s ease;
}

.toast.show {
    transform: translateX(0);
}

.toast.error {
    border-left-color: #ef4444;
}
</style>

<div class="dashboard-container">
    <!-- Header -->
    <header class="dashboard-header">
        <div class="header-content">
            <h1 class="app-title">🌱 Green Cup Seller</h1>
            
            <div class="user-section" onclick="showLogoutConfirm()">
                <span class="user-name">{{ $seller->business_name }}</span>
                <div class="user-avatar" title="Click to logout">{{ substr($seller->business_name, 0, 1) }}</div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Points Card -->
        <div class="points-card fade-in">
            <div class="points-value" id="totalPoints">{{ number_format($totalRankPoints) }}</div>
            <div class="points-label">Total Points Earned</div>
        </div>

        <!-- Progress Section -->
        @if($currentRank)
        <div class="progress-card fade-in">
            <div class="progress-section">
                <div class="progress-header">
                    <span class="rank-badge">
                        🏆 {{ $currentRank->name }} Seller
                    </span>
                    <span class="progress-text">
                        @if($nextRank)
                            {{ number_format($pointsToNext) }} points to {{ $nextRank->name }}
                        @else
                            🎉 Maximum rank achieved!
                        @endif
                    </span>
                </div>
                
                @if($nextRank)
                <div class="progress-bar">
                    <div class="progress-fill" style="width: {{ min(100, (($totalRankPoints - $currentRank->min_points) / ($nextRank->min_points - $currentRank->min_points)) * 100) }}%"></div>
                </div>
                <div class="progress-labels">
                    <span>{{ $currentRank->name }} ({{ number_format($currentRank->min_points) }})</span>
                    <span>{{ $nextRank->name }} ({{ number_format($nextRank->min_points) }})</span>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Receipt Management Card -->
        <div class="receipt-stats-card fade-in">
            <div class="receipt-header">
                <div class="receipt-title">
                    <span class="receipt-icon">📄</span>
                    Receipt Management
                </div>
            </div>
            
            <div class="receipt-stats-grid">
                @php
                    try {
                        $pendingReceipts = DB::table('pending_transactions')
                            ->where('seller_id', Auth::guard('seller')->user()->id)
                            ->where('status', 'pending')
                            ->count();
                        $claimedToday = DB::table('pending_transactions')
                            ->where('seller_id', Auth::guard('seller')->user()->id)
                            ->where('status', 'claimed')
                            ->whereDate('claimed_at', today())
                            ->count();
                    } catch (\Exception $e) {
                        $pendingReceipts = 0;
                        $claimedToday = 0;
                    }
                @endphp
                <div class="receipt-stat">
                    <div class="receipt-stat-value">{{ $pendingReceipts }}</div>
                    <div class="receipt-stat-label">Pending</div>
                </div>
                <div class="receipt-stat">
                    <div class="receipt-stat-value">{{ $claimedToday }}</div>
                    <div class="receipt-stat-label">Claimed Today</div>
                </div>
            </div>
            
            <div class="receipt-actions">
                <a href="{{ route('seller.receipts') }}" class="receipt-btn receipt-btn-secondary">
                    <span>📋</span>
                    View All Receipts
                </a>
                <a href="{{ route('seller.receipts.create') }}" class="receipt-btn receipt-btn-primary">
                    <span>➕</span>
                    Create Receipt
                </a>
            </div>
        </div>

        <!-- Analytics Card -->
        @if($totalTransactions > 0)
        <div class="analytics-card fade-in">
            <div class="analytics-header">
                <h3 class="analytics-title">📊 Points Analytics</h3>
            </div>
            
            <div class="chart-container">
                <svg class="donut-chart" viewBox="0 0 200 200">
                    <circle cx="100" cy="100" r="80" fill="none" stroke="#e5e7eb" stroke-width="20"/>
                    <circle cx="100" cy="100" r="80" fill="none" 
                            stroke="#10b981" 
                            stroke-width="20"
                            stroke-dasharray="{{ ($givingPercentage / 100) * 502.65 }} 502.65"
                            stroke-dashoffset="0"
                            transform="rotate(-90 100 100)"/>
                    <circle cx="100" cy="100" r="80" fill="none" 
                            stroke="#ef4444" 
                            stroke-width="20"
                            stroke-dasharray="{{ ($redemptionPercentage / 100) * 502.65 }} 502.65"
                            stroke-dashoffset="-{{ ($givingPercentage / 100) * 502.65 }}"
                            transform="rotate(-90 100 100)"/>
                </svg>
                <div class="chart-center">
                    <div class="chart-value">{{ number_format($totalActivity) }}</div>
                    <div class="chart-label">Total Activity</div>
                </div>
            </div>
            
            <div class="chart-legend">
                <div class="legend-item">
                    <span class="legend-dot green"></span>
                    <span>Points Given ({{ number_format($pointsGiven) }})</span>
                </div>
                <div class="legend-item">
                    <span class="legend-dot red"></span>
                    <span>Points from Redemptions ({{ number_format($pointsFromRedemptions) }})</span>
                </div>
            </div>
        </div>
        @endif

        <!-- Stats Grid -->
        <div class="stats-grid fade-in">
            <div class="stat-card">
                <div class="stat-header">
                    <span class="stat-title">Total Customers</span>
                    <span class="stat-icon">👥</span>
                </div>
                <div class="stat-value">{{ number_format($totalCustomers) }}</div>
                <div class="stat-subtitle">Unique customers served</div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <span class="stat-title">Total Transactions</span>
                    <span class="stat-icon">📋</span>
                </div>
                <div class="stat-value">{{ number_format($totalTransactions) }}</div>
                <div class="stat-subtitle">All time transactions</div>
            </div>
        </div>

        <!-- Quick Actions - All 5 main features -->
        <div class="actions-grid fade-in">
            <a href="{{ route('seller.account') }}" class="action-card">
                <div class="action-icon">👤</div>
                <div class="action-label">Account</div>
            </a>

            <a href="{{ route('seller.receipts') }}" class="action-card receipt-action">
                <div class="action-icon">📄</div>
                <div class="action-label">Receipts</div>
            </a>


            <a href="{{ route('seller.photos') }}" class="action-card">
                <div class="action-icon">📷</div>
                <div class="action-label">Gallery</div>
            </a>

            <a href="{{ route('seller.account') }}#transactions" class="action-card">
                <div class="action-icon">📊</div>
                <div class="action-label">History</div>
            </a>
        </div>

        <!-- Recent Activity -->
        <div class="activity-card fade-in">
            <div class="activity-header">
                <h3 class="activity-title">⚡ Recent Activity</h3>
                @if($totalTransactions > 0)
                <a href="{{ route('seller.account') }}" class="view-all">View All →</a>
                @endif
            </div>
            
            @if($totalTransactions > 0)
                @php
                    // Get recent transactions for display
                    $recentTransactions = collect();
                    try {
                        $recentTransactions = DB::table('point_transactions')
                            ->join('consumers', 'point_transactions.consumer_id', '=', 'consumers.id')
                            ->leftJoin('qr_codes', 'point_transactions.qr_code_id', '=', 'qr_codes.id')
                            ->leftJoin('items', 'qr_codes.item_id', '=', 'items.id')
                            ->where('point_transactions.seller_id', $seller->id)
                            ->select([
                                'point_transactions.id',
                                'point_transactions.points',
                                'point_transactions.type',
                                'point_transactions.created_at',
                                'consumers.full_name as consumer_name',
                                'items.name as item_name'
                            ])
                            ->orderBy('point_transactions.created_at', 'desc')
                            ->limit(5)
                            ->get();
                    } catch (\Exception $e) {
                        $recentTransactions = collect();
                    }
                @endphp
                
                @if($recentTransactions->count() > 0)
                <div class="activity-list">
                    @foreach($recentTransactions as $transaction)
                    <div class="activity-item slide-in">
                        <div class="activity-avatar">
                            @if($transaction->type === 'earn')
                                ✅
                            @else
                                💳
                            @endif
                        </div>
                        <div class="activity-details">
                            <div class="activity-name">{{ $transaction->consumer_name ?? 'Customer' }}</div>
                            <div class="activity-desc">
                                @if($transaction->type === 'earn')
                                    Earned points • {{ $transaction->item_name ?? 'Item' }}
                                @else
                                    Redeemed points • {{ $transaction->item_name ?? 'Item' }}
                                @endif
                            </div>
                        </div>
                        <div class="activity-points">
                            @if($transaction->type === 'earn')
                                +{{ $transaction->points }} pts
                            @else
                                -{{ $transaction->points }} pts
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="empty-state">
                    <div class="empty-text">No recent transactions to display</div>
                </div>
                @endif
            @else
                <div class="empty-state">
                    <div class="empty-icon">🚀</div>
                    <h4 class="empty-title">Ready to Get Started?</h4>
                    <p class="empty-text">Create your first receipt to start tracking your green impact and helping customers earn points!</p>
                    <a href="{{ route('seller.receipts.create') }}" class="btn-primary">Create First Receipt</a>
                </div>
            @endif
        </div>

        @if($totalTransactions == 0)
        <!-- Getting Started Guide -->
        <div class="getting-started-card fade-in">
            <h3 class="getting-started-title">
                <span>🌟</span>
                Getting Started Guide
            </h3>
            <div class="getting-started-steps">
                <p><strong>1.</strong> Create receipts for eco-friendly customer purchases</p>
                <p><strong>2.</strong> Share QR codes with customers to claim their green points</p>
                <p><strong>3.</strong> Use the QR scanner to award points for bring-your-own items</p>
                <p><strong>4.</strong> Track customer engagement and monitor your environmental impact</p>
                <p><strong>5.</strong> Climb the seller ranks and unlock exclusive benefits!</p>
            </div>
        </div>
        @endif
    </main>
</div>

<!-- Logout Form (hidden) -->
<form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<!-- Toast Container -->
<div id="toast" class="toast" style="display: none;">
    <span id="toast-message">Success!</span>
</div>

<script>
// Global variables
let isRefreshing = false;

// Show logout confirmation
function showLogoutConfirm() {
    if (confirm('Are you sure you want to logout?')) {
        document.getElementById('logoutForm').submit();
    }
}

// Show toast notification
function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    const messageEl = document.getElementById('toast-message');
    
    messageEl.textContent = message;
    toast.className = `toast ${type}`;
    toast.style.display = 'block';
    
    // Show toast
    setTimeout(() => toast.classList.add('show'), 100);
    
    // Hide toast
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.style.display = 'none', 300);
    }, 4000);
}

// Animate numbers on page load
function animateValue(element, start, end, duration) {
    if (!element) return;
    
    let startTimestamp = null;
    const step = (timestamp) => {
        if (!startTimestamp) startTimestamp = timestamp;
        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
        const current = Math.floor(progress * (end - start) + start);
        element.textContent = current.toLocaleString();
        if (progress < 1) {
            window.requestAnimationFrame(step);
        }
    };
    window.requestAnimationFrame(step);
}

// Refresh dashboard data
async function refreshDashboardData() {
    if (isRefreshing) return;
    
    isRefreshing = true;
    
    try {
        const response = await fetch('{{ route("dashboard.data") }}');
        if (!response.ok) throw new Error('Network response was not ok');
        
        const data = await response.json();
        
        // Update total points with animation
        const totalPointsEl = document.getElementById('totalPoints');
        if (totalPointsEl && data.total_rank_points !== undefined) {
            const currentValue = parseInt(totalPointsEl.textContent.replace(/,/g, ''));
            const newValue = data.total_rank_points;
            
            if (currentValue !== newValue) {
                animateValue(totalPointsEl, currentValue, newValue, 1000);
            }
        }
        
        // Update other dashboard stats if needed
        console.log('Dashboard data refreshed successfully');
        
    } catch (error) {
        console.error('Error refreshing dashboard data:', error);
    } finally {
        isRefreshing = false;
    }
}

// Initialize dashboard
document.addEventListener('DOMContentLoaded', function() {
    console.log('Dashboard initialized');
    
    // Animate total points on load
    const totalPointsEl = document.getElementById('totalPoints');
    if (totalPointsEl) {
        const currentValue = parseInt(totalPointsEl.textContent.replace(/,/g, ''));
        totalPointsEl.textContent = '0';
        animateValue(totalPointsEl, 0, currentValue, 2000);
    }

    // Add staggered fade-in animations
    const fadeElements = document.querySelectorAll('.fade-in');
    fadeElements.forEach((el, index) => {
        el.style.opacity = '0';
        setTimeout(() => {
            el.style.opacity = '1';
        }, index * 150);
    });

    // Add slide-in animations for activity items
    const slideElements = document.querySelectorAll('.slide-in');
    slideElements.forEach((el, index) => {
        el.style.opacity = '0';
        el.style.transform = 'translateX(-20px)';
        setTimeout(() => {
            el.style.opacity = '1';
            el.style.transform = 'translateX(0)';
        }, 500 + (index * 100));
    });

    @if($totalTransactions > 0)
    // Auto-refresh dashboard data every 2 minutes
    setInterval(refreshDashboardData, 120000);
    @endif

    // Show welcome message for new sellers
    @if($totalTransactions == 0)
    setTimeout(() => {
        showToast('Welcome to Green Cup! Create your first receipt to get started.', 'success');
    }, 1000);
    @endif
});

// Handle visibility change (refresh when user returns to tab)
document.addEventListener('visibilitychange', function() {
    if (!document.hidden && {{ $totalTransactions > 0 ? 'true' : 'false' }}) {
        setTimeout(refreshDashboardData, 1000);
    }
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Alt + R: Refresh data
    if (e.altKey && e.key === 'r') {
        e.preventDefault();
        refreshDashboardData();
        showToast('Dashboard refreshed!');
    }
    
    // Alt + N: New receipt
    if (e.altKey && e.key === 'n') {
        e.preventDefault();
        window.location.href = '{{ route("seller.receipts.create") }}';
    }
    
    // Alt + S: Scanner
    if (e.altKey && e.key === 's') {
        e.preventDefault();
        window.location.href = '{{ route("seller.scanner") }}';
    }
});

// Handle online/offline status
window.addEventListener('online', function() {
    showToast('Connection restored!', 'success');
    refreshDashboardData();
});

window.addEventListener('offline', function() {
    showToast('Connection lost. Working offline.', 'error');
});

// Performance monitoring
window.addEventListener('load', function() {
    const loadTime = performance.timing.loadEventEnd - performance.timing.navigationStart;
    console.log(`Dashboard loaded in ${loadTime}ms`);
});
</script>
@endsection