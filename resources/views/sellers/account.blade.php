@extends('master')

@section('content')
    <div class="background-animation">
        <div class="floating-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>

    <!-- Logout Modal (in case master template doesn't include it) -->
    @if(!View::hasSection('logout-modal'))
    <div id="logoutModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 9999; opacity: 0; transition: opacity 0.3s ease;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; border-radius: 20px; padding: 30px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); max-width: 400px; width: 90%; text-align: center;">
            <div style="font-size: 48px; margin-bottom: 20px;">👋</div>
            <h3 style="color: #2c3e50; margin-bottom: 10px; font-size: 22px;">Leaving Already?</h3>
            <p style="color: #6c757d; margin-bottom: 25px; font-size: 16px;">Are you sure you want to logout from GreenCup?</p>
            
            <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: inline-block;">
                @csrf
                <div style="display: flex; gap: 15px; justify-content: center;">
                    <button type="button" onclick="hideLogoutModal()" style="background: #e9ecef; color: #6c757d; border: none; padding: 12px 30px; border-radius: 25px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; font-family: inherit;" onmouseover="this.style.background='#dee2e6'" onmouseout="this.style.background='#e9ecef'">
                        Stay Here
                    </button>
                    <button type="submit" style="background: linear-gradient(45deg, #dc3545, #e83e8c); color: white; border: none; padding: 12px 30px; border-radius: 25px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(220,53,69,0.3); font-family: inherit;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(220,53,69,0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(220,53,69,0.3)'">
                        Yes, Logout
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Logout modal functions (if not already defined)
        if (typeof showLogoutModal === 'undefined') {
            function showLogoutModal() {
                const modal = document.getElementById('logoutModal');
                modal.style.display = 'block';
                document.body.style.overflow = 'hidden';
                setTimeout(() => {
                    modal.style.opacity = '1';
                }, 10);
            }

            function hideLogoutModal() {
                const modal = document.getElementById('logoutModal');
                modal.style.opacity = '0';
                document.body.style.overflow = '';
                setTimeout(() => {
                    modal.style.display = 'none';
                }, 300);
            }

            // Close modal when clicking outside
            document.getElementById('logoutModal')?.addEventListener('click', function(e) {
                if (e.target === this) {
                    hideLogoutModal();
                }
            });
        }
    </script>
    @endif
        <div class="particles">
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
        </div>
    </div>

    <div class="container">
        <!-- Header with back button -->
        <div class="account-header">
            <div class="header-nav">
                <a href="{{ route('dashboard') }}" class="back-btn">
                    <span>←</span>
                </a>
                <h2>Business Account</h2>
                <div class="settings-btn" onclick="showSettings()">⚙️</div>
            </div>
        </div>

        <!-- Business Profile Section -->
        <div class="business-profile-section">
            <div class="profile-avatar">
                <span>{{ substr($seller->business_name, 0, 2) }}</span>
            </div>
            <h3 class="business-name">{{ $seller->business_name }}</h3>
            <p class="business-email">{{ $seller->email }}</p>
            
            <!-- Rank Badge -->
            <div class="rank-badge-container">
                <div class="rank-badge {{ strtolower($currentRank->name) }}">
                    <span class="rank-icon">
                        @switch($currentRank->name)
                            @case('Platinum') 💎 @break
                            @case('Gold') 🏆 @break
                            @case('Silver') 🥈 @break
                            @case('Bronze') 🥉 @break
                            @default ⭐
                        @endswitch
                    </span>
                    <span class="rank-name">{{ $currentRank->name }} Seller</span>
                </div>
            </div>
        </div>

        <!-- Points Summary Section -->
        <div class="points-summary-section">
            <div class="points-circle">
                <div class="circle-content">
                    <div class="circle-label">Rank Points</div>
                    <div class="total-points">{{ number_format($totalRankPoints) }}</div>
                    <div class="points-subtitle">Total Earned</div>
                </div>
            </div>
            
            <div class="points-breakdown">
                <div class="breakdown-item">
                    <span class="breakdown-label">Points Given</span>
                    <span class="breakdown-value">{{ number_format($pointsGiven) }} pts</span>
                </div>
                <div class="breakdown-item">
                    <span class="breakdown-label">Total Customers</span>
                    <span class="breakdown-value">{{ number_format($totalCustomers) }}</span>
                </div>
            </div>

            <!-- Rank Progress Bar -->
            @if($nextRank)
            <div class="rank-progress">
                <div class="progress-info">
                    <span>{{ number_format($pointsToNext) }} points to {{ $nextRank->name }}</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: {{ min(100, (($totalRankPoints - $currentRank->min_points) / ($nextRank->min_points - $currentRank->min_points)) * 100) }}%"></div>
                </div>
            </div>
            @endif
        </div>

        <!-- Transaction History -->
        <div class="accounts-section">
            <div class="section-header">
                <h3>Transaction History</h3>
                <select class="filter-select" onchange="filterTransactions(this.value)">
                    <option value="all">All Transactions</option>
                    <option value="earn">Points Given</option>
                    <option value="spend">Redemptions</option>
                </select>
            </div>

            @forelse($transactions as $transaction)
                <div class="account-card transaction-type-{{ $transaction->type }}" onclick="showTransactionDetail({{ json_encode($transaction) }})">
                    <div class="account-info">
                        <div class="account-icon">
                            @if($transaction->type === 'earn')
                                <span style="color: #28a745;">📤</span>
                            @else
                                <span style="color: #17a2b8;">📥</span>
                            @endif
                        </div>
                        <div class="account-details">
                            <div class="account-title">
                                {{ $transaction->consumer_name ?? 'Customer #' . $transaction->consumer_id }}
                            </div>
                            <div class="account-subtitle">
                                {{ $transaction->item_name ?? 'Unknown Item' }}
                                • {{ $transaction->units_scanned ?? 1 }} units
                            </div>
                            <div class="account-date">
                                {{ \Carbon\Carbon::parse($transaction->scanned_at ?? $transaction->created_at)->format('M d, Y • h:i A') }}
                            </div>
                        </div>
                        <div class="account-amount">
                            <div class="amount {{ $transaction->type }}">
                                @if($transaction->type === 'earn')
                                    -{{ number_format($transaction->points) }}
                                @else
                                    +{{ number_format($transaction->points) }}
                                @endif
                            </div>
                            <div class="amount-label">POINTS</div>
                        </div>
                    </div>
                    <div class="account-actions">
                        <div class="view-indicator">👁️</div>
                    </div>
                </div>
            @empty
                <div class="no-transactions-card">
                    <div class="empty-state">
                        <div class="empty-icon">📊</div>
                        <div class="empty-title">No transactions yet</div>
                        <div class="empty-subtitle">Start scanning customer QR codes to see your transaction history!</div>
                        <div style="margin-top: 15px;">
                            <a href="{{ route('dashboard') }}" style="color: #2E8B57; text-decoration: none; font-weight: 600;">
                                Go to Dashboard →
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse

            @if($transactions->count() > 0)
                <div class="pagination-info">
                    <small>Showing {{ $transactions->count() }} recent transactions</small>
                    @if($transactions->hasMorePages())
                        <a href="{{ $transactions->nextPageUrl() }}" class="load-more">Load more →</a>
                    @endif
                </div>
            @endif
        </div>

        <!-- Business Info Section -->
        <div class="business-info-section">
            <h3>Business Information</h3>
            
            <div class="info-card">
                <div class="info-row">
                    <span class="info-label">📍 Address</span>
                    <span class="info-value">{{ $seller->address }}</span>
                </div>
                @if($seller->phone)
                <div class="info-row">
                    <span class="info-label">📞 Phone</span>
                    <span class="info-value">{{ $seller->phone }}</span>
                </div>
                @endif
                @if($seller->working_hours)
                <div class="info-row">
                    <span class="info-label">🕐 Hours</span>
                    <span class="info-value">{{ $seller->working_hours }}</span>
                </div>
                @endif
                <div class="info-row">
                    <span class="info-label">📅 Member Since</span>
                    <span class="info-value">{{ $seller->created_at->format('F Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction Detail Modal -->
    <div id="transactionModal" class="transaction-modal" style="display: none;">
        <div class="modal-overlay" onclick="closeTransactionDetail()"></div>
        <div class="modal-content">
            <div class="modal-header">
                <h3>📧 Transaction Receipt</h3>
                <button onclick="closeTransactionDetail()" class="modal-close">×</button>
            </div>
            
            <div class="modal-body">
                <!-- Receipt Header -->
                <div class="receipt-header">
                    <div class="receipt-logo">🌱</div>
                    <div class="receipt-title">Green Cup Business</div>
                    <div class="receipt-subtitle">Transaction Record</div>
                </div>

                <!-- Transaction Status -->
                <div class="transaction-status success">
                    <div class="status-icon">✅</div>
                    <div class="status-text">Transaction Completed</div>
                </div>

                <!-- Points Section -->
                <div class="points-section">
                    <div class="points-display">
                        <div class="transaction-type-label" id="modalTransactionType">Points Given</div>
                        <div class="points-amount" id="modalPointsAmount">-0</div>
                        <div class="points-label">Points</div>
                    </div>
                </div>

                <!-- Consumer Information -->
                <div class="detail-section">
                    <div class="detail-header">👤 Customer Information</div>
                    
                    <div class="detail-row">
                        <span class="detail-label">Name</span>
                        <span class="detail-value" id="modalCustomerName">-</span>
                    </div>
                    
                    <div class="detail-row">
                        <span class="detail-label">Email</span>
                        <span class="detail-value" id="modalCustomerEmail">-</span>
                    </div>
                    
                    <div class="detail-row">
                        <span class="detail-label">Customer ID</span>
                        <span class="detail-value" id="modalCustomerId">-</span>
                    </div>
                </div>

                <!-- Transaction Details -->
                <div class="detail-section">
                    <div class="detail-header">📋 Transaction Details</div>
                    
                    <div class="detail-row">
                        <span class="detail-label">📦 Item</span>
                        <span class="detail-value" id="modalItemName">-</span>
                    </div>
                    
                    <div class="detail-row">
                        <span class="detail-label">🔢 Units Scanned</span>
                        <span class="detail-value" id="modalUnitsScanned">-</span>
                    </div>
                    
                    <div class="detail-row">
                        <span class="detail-label">📅 Date & Time</span>
                        <span class="detail-value" id="modalDateTime">-</span>
                    </div>
                    
                    <div class="detail-row">
                        <span class="detail-label">🆔 Transaction ID</span>
                        <span class="detail-value" id="modalTransactionId">-</span>
                    </div>
                    
                    <div class="detail-row">
                        <span class="detail-label">💳 Type</span>
                        <span class="detail-value" id="modalType">-</span>
                    </div>
                </div>

                <!-- Rank Points Impact -->
                <div class="detail-section rank-impact-section">
                    <div class="detail-header">🏆 Rank Points Impact</div>
                    <div class="rank-impact">
                        <div class="impact-icon" id="modalImpactIcon">➕</div>
                        <div class="impact-text">
                            <span id="modalImpactText">Added</span> <strong id="modalImpactPoints">0</strong> points to your rank
                        </div>
                    </div>
                    <div class="current-total">
                        Current Total: <strong>{{ number_format($totalRankPoints) }}</strong> points
                    </div>
                </div>

                <!-- Environmental Impact -->
                <div class="detail-section eco-section">
                    <div class="detail-header">🌍 Environmental Impact</div>
                    <div class="eco-message">
                        <div class="eco-icon">♻️</div>
                        <div class="eco-text">
                            Thank you for promoting sustainable practices! 
                            Every transaction helps build a greener future.
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="modal-actions">
                    <button onclick="downloadReceipt()" class="btn-download">
                        <span>📥</span> Download Receipt
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Settings Modal -->
    <div id="settingsModal" class="settings-modal" style="display: none;">
        <div class="modal-overlay" onclick="closeSettings()"></div>
        <div class="settings-content">
            <div class="settings-header">
                <h3>⚙️ Account Settings</h3>
                <button onclick="closeSettings()" class="modal-close">×</button>
            </div>
            
            <div class="settings-body">
                <button class="settings-option" onclick="editProfile()">
                    <span class="option-icon">✏️</span>
                    <span>Edit Business Profile</span>
                    <span class="option-arrow">›</span>
                </button>
                
                <button class="settings-option" onclick="changePassword()">
                    <span class="option-icon">🔐</span>
                    <span>Change Password</span>
                    <span class="option-arrow">›</span>
                </button>
                
                <button class="settings-option" onclick="manageQRCodes()">
                    <span class="option-icon">📱</span>
                    <span>Manage QR Codes</span>
                    <span class="option-arrow">›</span>
                </button>
                
                <button class="settings-option" onclick="viewAnalytics()">
                    <span class="option-icon">📊</span>
                    <span>View Analytics</span>
                    <span class="option-arrow">›</span>
                </button>
                
                <div class="settings-divider"></div>
                
                <button class="settings-option danger" onclick="showLogoutModal()">
                    <span class="option-icon">🚪</span>
                    <span>Logout</span>
                    <span class="option-arrow">›</span>
                </button>
            </div>
        </div>
    </div>

    <style>
        /* Base styles */
        * {
            box-sizing: border-box;
        }
        
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            max-width: 100vw;
        }

        .background-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            max-width: 100vw;
            overflow: hidden;
            z-index: -1;
        }

        .floating-shapes, .particles {
            width: 100%;
            height: 100%;
            max-width: 100vw;
            overflow: hidden;
        }

        .container {
            background: rgba(255, 255, 255, 0.95);
            min-height: 50vh;
            position: relative;
            backdrop-filter: blur(10px);
            border-radius: 0;
            overflow: hidden;
            max-width: 100%;
            width: 100%;
        }

        @media (min-width: 768px) {
            .container {
                max-width: 700px;
                margin: 20px auto;
                border-radius: 25px;
                box-shadow: 0 20px 50px rgba(0,0,0,0.3);
                /* min-height: calc(100vh - 40px); */
            }
        }

        /* Header styles - FIXED for visibility */
        .account-header {
            background: linear-gradient(135deg, #2E8B57, #3CB371);
            padding: 15px 20px 10px;
            color: white;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 5px 0;
        }

        .back-btn {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            border-radius: 50%;
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            font-size: 20px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1);
        }

        .header-nav h2 {
            margin: 0;
            font-size: 20px;
            font-weight: 600;
        }

        .settings-btn {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .settings-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: rotate(90deg);
        }

        /* Business Profile Section */
        .business-profile-section {
            background: linear-gradient(135deg, #2E8B57, #3CB371);
            padding: 20px 20px 30px;
            color: white;
            text-align: center;
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
            margin: 0 auto 15px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: bold;
            text-transform: uppercase;
            border: 3px solid rgba(255, 255, 255, 0.3);
        }

        .business-name {
            font-size: 24px;
            font-weight: 700;
            margin: 0 0 5px;
        }

        .business-email {
            font-size: 14px;
            opacity: 0.9;
            margin: 0 0 20px;
        }

        .rank-badge-container {
            display: flex;
            justify-content: center;
        }

        .rank-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .rank-badge.platinum {
            background: linear-gradient(135deg, #e5e4e2, #bbb);
        }

        .rank-badge.gold {
            background: linear-gradient(135deg, #FFD700, #FFA500);
        }

        .rank-badge.silver {
            background: linear-gradient(135deg, #C0C0C0, #808080);
        }

        .rank-badge.bronze {
            background: linear-gradient(135deg, #CD7F32, #8B4513);
        }

        /* Points Summary Section */
        .points-summary-section {
            background: #f8f9fa;
            padding: 30px 20px;
            text-align: center;
        }

        .points-circle {
            margin: 0 auto 25px;
            width: 160px;
            height: 160px;
            border-radius: 50%;
            background: linear-gradient(135deg, #2E8B57, #3CB371);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 30px rgba(46, 139, 87, 0.3);
        }

        .circle-content {
            text-align: center;
            color: white;
        }

        .circle-label {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 8px;
        }

        .total-points {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .points-subtitle {
            font-size: 12px;
            opacity: 0.8;
        }

        .points-breakdown {
            display: flex;
            justify-content: space-around;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .breakdown-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: white;
            padding: 15px 20px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            min-width: 100px;
        }

        .breakdown-label {
            font-size: 12px;
            color: #666;
            margin-bottom: 4px;
        }

        .breakdown-value {
            font-size: 18px;
            font-weight: 600;
            color: #2E8B57;
        }

        .rank-progress {
            margin-top: 20px;
            background: white;
            padding: 15px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .progress-info {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }

        .progress-bar {
            width: 100%;
            height: 10px;
            background: #e9ecef;
            border-radius: 5px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(45deg, #2E8B57, #3CB371);
            border-radius: 5px;
            transition: width 0.3s ease;
        }

        /* Transaction History Section */
        .accounts-section {
            background: #f8f9fa;
            padding: 20px;
            min-height: 400px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .section-header h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
            color: #333;
        }

        .filter-select {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            background: white;
            cursor: pointer;
        }

        .account-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .account-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(0,0,0,0.15);
        }

        .account-info {
            display: flex;
            align-items: center;
            flex: 1;
        }

        .account-icon {
            font-size: 24px;
            margin-right: 15px;
        }

        .account-details {
            flex: 1;
            min-width: 0;
            margin-right: 15px;
        }

        .account-title {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            margin-bottom: 4px;
        }

        .account-subtitle {
            font-size: 14px;
            color: #666;
            margin-bottom: 4px;
        }

        .account-date {
            font-size: 12px;
            color: #999;
        }

        .account-amount {
            text-align: right;
            margin-right: 15px;
        }

        .amount {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .amount.earn {
            color: #dc3545;
        }

        .amount.spend {
            color: #17a2b8;
        }

        .amount-label {
            font-size: 12px;
            color: #666;
            font-weight: 500;
        }

        .pagination-info {
            text-align: center;
            padding: 20px;
            color: #666;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .load-more {
            color: #2E8B57;
            text-decoration: none;
            font-weight: 600;
        }

        /* Business Info Section */
        .business-info-section {
            background: #fff;
            padding: 20px;
        }

        .business-info-section h3 {
            margin: 0 0 20px;
            font-size: 18px;
            font-weight: 600;
            color: #333;
        }

        .info-card {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 12px 0;
            border-bottom: 1px solid #e9ecef;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-size: 14px;
            color: #666;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-value {
            font-size: 14px;
            color: #333;
            font-weight: 600;
            text-align: right;
            max-width: 60%;
        }

        /* Modal Styles */
        .transaction-modal, .settings-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 10000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(4px);
        }

        .modal-content, .settings-content {
            background: white;
            border-radius: 16px;
            width: 100%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            position: relative;
            animation: modalSlideUp 0.3s ease;
        }

        .settings-content {
            max-width: 400px;
        }

        @keyframes modalSlideUp {
            from {
                opacity: 0;
                transform: translateY(50px) scale(0.9);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .modal-header, .settings-header {
            background: linear-gradient(135deg, #2E8B57, #3CB371);
            color: white;
            padding: 20px;
            border-radius: 16px 16px 0 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-header h3, .settings-header h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
        }

        .modal-close {
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            padding: 4px;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-close:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .modal-body {
            padding: 0;
        }

        .receipt-header {
            text-align: center;
            padding: 25px 20px 20px;
            background: #f8f9fa;
        }

        .receipt-logo {
            font-size: 40px;
            margin-bottom: 8px;
        }

        .receipt-title {
            font-size: 20px;
            font-weight: 700;
            color: #2E8B57;
            margin-bottom: 4px;
        }

        .receipt-subtitle {
            font-size: 14px;
            color: #666;
        }

        .transaction-status {
            padding: 20px;
            text-align: center;
            background: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
        }

        .transaction-status.success {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
        }

        .status-icon {
            font-size: 24px;
            margin-bottom: 8px;
        }

        .status-text {
            font-size: 16px;
            font-weight: 600;
            color: #155724;
        }

        .points-section {
            padding: 25px 20px;
            text-align: center;
            border-bottom: 1px solid #e9ecef;
        }

        .points-display {
            background: linear-gradient(135deg, #E8F5E8, #F0F8FF);
            border-radius: 12px;
            padding: 20px;
            border: 2px solid #2E8B57;
        }

        .transaction-type-label {
            font-size: 14px;
            color: #666;
            margin-bottom: 8px;
        }

        .points-amount {
            font-size: 36px;
            font-weight: 700;
            color: #2E8B57;
            margin-bottom: 4px;
        }

        .points-label {
            font-size: 14px;
            color: #666;
            font-weight: 600;
        }

        .detail-section {
            padding: 20px;
            border-bottom: 1px solid #e9ecef;
        }

        .detail-header {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #2E8B57;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-size: 14px;
            color: #666;
            font-weight: 500;
        }

        .detail-value {
            font-size: 14px;
            color: #333;
            font-weight: 600;
            text-align: right;
            max-width: 60%;
        }

        .rank-impact-section {
            background: #f8f9fa;
        }

        .rank-impact {
            display: flex;
            align-items: center;
            gap: 12px;
            background: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .impact-icon {
            font-size: 24px;
            color: #2E8B57;
        }

        .current-total {
            text-align: center;
            font-size: 14px;
            color: #666;
        }

        .eco-section {
            background: linear-gradient(135deg, #E8F5E8, #F0F8FF);
            border-bottom: none;
        }

        .eco-message {
            display: flex;
            align-items: center;
            gap: 12px;
            background: white;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #28a745;
        }

        .eco-icon {
            font-size: 24px;
        }

        .eco-text {
            font-size: 14px;
            color: #155724;
            line-height: 1.4;
        }

        .modal-actions {
            padding: 20px;
            display: flex;
            justify-content: center;
        }

        .btn-download {
            padding: 12px 16px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: all 0.3s ease;
            background: linear-gradient(135deg, #2E8B57, #3CB371);
            color: white;
            min-width: 160px;
        }

        .btn-download:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(46, 139, 87, 0.3);
        }

        /* Settings Modal Styles */
        .settings-body {
            padding: 0;
        }

        .settings-option {
            width: 100%;
            background: white;
            border: none;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            cursor: pointer;
            transition: all 0.2s ease;
            border-bottom: 1px solid #f0f0f0;
            font-size: 16px;
            text-align: left;
        }

        .settings-option:hover {
            background: #f8f9fa;
        }

        .settings-option.danger {
            color: #dc3545;
        }

        .option-icon {
            font-size: 20px;
        }

        .option-arrow {
            margin-left: auto;
            color: #999;
        }

        .settings-divider {
            height: 8px;
            background: #f0f0f0;
        }

        /* Empty state */
        .no-transactions-card {
            background: white;
            border-radius: 12px;
            padding: 40px 20px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .empty-state {
            color: #666;
        }

        .empty-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }

        .empty-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .empty-subtitle {
            font-size: 14px;
            opacity: 0.8;
        }

        /* Mobile Responsive */
        @media (max-width: 480px) {
            .container {
                border-radius: 0;
                margin: 0;
            }

            .business-name {
                font-size: 20px;
            }

            .points-circle {
                width: 130px;
                height: 130px;
            }

            .total-points {
                font-size: 26px;
            }

            .breakdown-item {
                padding: 10px 15px;
                min-width: 90px;
            }

            .breakdown-value {
                font-size: 16px;
            }

            .account-card {
                padding: 15px;
            }

            .modal-content {
                margin: 10px;
                max-height: 95vh;
            }
        }
    </style>

    <script>
        // Transaction detail modal
        function showTransactionDetail(transaction) {
            // Set transaction type label
            const typeLabel = transaction.type === 'earn' ? 'Points Given' : 'Points from Redemption';
            document.getElementById('modalTransactionType').textContent = typeLabel;
            
            // Set points amount with correct sign
            const pointsAmount = transaction.type === 'earn' ? '-' + transaction.points : '+' + transaction.points;
            document.getElementById('modalPointsAmount').textContent = pointsAmount;
            
            // Set customer information
            document.getElementById('modalCustomerName').textContent = 
                transaction.consumer_name || 'Customer #' + transaction.consumer_id;
            document.getElementById('modalCustomerEmail').textContent = 
                transaction.consumer_email || 'Not available';
            document.getElementById('modalCustomerId').textContent = 
                '#' + (transaction.consumer_id || '000').toString().padStart(6, '0');
            
            // Set other details
            document.getElementById('modalItemName').textContent = 
                transaction.item_name || 'Unknown Item';
            document.getElementById('modalUnitsScanned').textContent = 
                transaction.units_scanned || '1';
            document.getElementById('modalDateTime').textContent = 
                new Date(transaction.scanned_at || transaction.created_at).toLocaleString();
            document.getElementById('modalTransactionId').textContent = 
                '#' + (transaction.id || '000').toString().padStart(6, '0');
            document.getElementById('modalType').textContent = 
                transaction.type === 'earn' ? 'Points Distribution' : 'Points Redemption';
            
            // Set rank impact
            document.getElementById('modalImpactIcon').textContent = '➕';
            document.getElementById('modalImpactText').textContent = 'Added';
            document.getElementById('modalImpactPoints').textContent = transaction.points;

            // Show modal
            document.getElementById('transactionModal').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeTransactionDetail() {
            document.getElementById('transactionModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Settings modal
        function showSettings() {
            document.getElementById('settingsModal').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeSettings() {
            document.getElementById('settingsModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Settings options
        function editProfile() {
            window.location.href = '{{ route("seller.profile") }}';
        }

        function changePassword() {
            alert('Change Password feature coming soon!');
            closeSettings();
        }

        function manageQRCodes() {
            alert('QR Code Management feature coming soon!');
            closeSettings();
        }

        function viewAnalytics() {
            window.location.href = '{{ route("dashboard") }}';
        }

        function confirmLogout() {
            closeSettings();
            // Use the logout modal from the main dashboard if it exists
            if (typeof window.showLogoutModal === 'function') {
                window.showLogoutModal();
            } else {
                // Fallback to creating a simple form submission
                if (confirm('Are you sure you want to logout?')) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route("logout") }}';
                    
                    const token = document.createElement('input');
                    token.type = 'hidden';
                    token.name = '_token';
                    token.value = '{{ csrf_token() }}';
                    
                    form.appendChild(token);
                    document.body.appendChild(form);
                    form.submit();
                }
            }
        }

        // Download receipt
        function downloadReceipt() {
            alert('Download feature coming soon! The receipt will be saved as a PDF.');
        }

        // Filter transactions
        function filterTransactions(type) {
            const cards = document.querySelectorAll('.account-card');
            cards.forEach(card => {
                if (type === 'all') {
                    card.style.display = 'flex';
                } else {
                    const isMatch = card.classList.contains('transaction-type-' + type);
                    card.style.display = isMatch ? 'flex' : 'none';
                }
            });
        }

        // Close modals on escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeTransactionDetail();
                closeSettings();
            }
        });

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            // Add smooth scroll
            document.documentElement.style.scrollBehavior = 'smooth';
            
            // Touch feedback for mobile
            const cards = document.querySelectorAll('.account-card, .settings-option');
            cards.forEach(card => {
                card.addEventListener('touchstart', function() {
                    this.style.transform = 'scale(0.98)';
                }, { passive: true });
                
                card.addEventListener('touchend', function() {
                    this.style.transform = '';
                }, { passive: true });
            });
        });
    </script>
@endsection