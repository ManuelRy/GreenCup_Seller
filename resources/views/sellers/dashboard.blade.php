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
    <!-- Header Section -->
    <div class="header">
        <h1 class="app-title">🌱 GreenCup Dashboard</h1>
        
        <div class="profile-section">
            <div class="profile-pic"></div>
            <div class="greeting">
                <h2>Welcome back, {{ $seller->business_name }}!</h2>
                <p>{{ $seller->email }}</p>
                <button type="button" onclick="showLogoutModal()" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3); padding: 6px 12px; border-radius: 15px; font-size: 12px; cursor: pointer; transition: all 0.3s ease; margin-top: 10px;" onmouseover="this.style.background='rgba(255,255,255,0.3)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'">
                    🚪 Logout
                </button>
            </div>
        </div>
    </div>

    <!-- Points Card -->
    <div class="points-card">
        <div class="points-amount" id="totalPoints">{{ number_format($totalRankPoints) }}</div>
        <div class="points-label">
            🏆 {{ $currentRank->name }} Rank Points
        </div>
    </div>

    <!-- Rank Progress Section -->
    <div class="rank-progress-section" style="margin: 0 30px 30px; background: white; border-radius: 25px; padding: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
        <h3 style="color: #2E8B57; margin-bottom: 20px; font-size: 18px; font-weight: 600;">Rank Progress</h3>
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <span style="background: linear-gradient(45deg, #fd7e14, #ffc107); color: white; padding: 8px 16px; border-radius: 8px; font-weight: bold; font-size: 14px;">
                    {{ $currentRank->name }} Seller
                </span>
                <span style="color: #2E8B57; font-weight: 600;">{{ number_format($totalRankPoints) }} points</span>
            </div>
            @if($nextRank)
            <div style="color: #6c757d; font-size: 14px;">
                {{ number_format($pointsToNext) }} points to {{ $nextRank->name }}
            </div>
            @else
            <div style="color: #28a745; font-size: 14px; font-weight: 600;">
                🎉 Maximum rank achieved!
            </div>
            @endif
        </div>
        
        @if($nextRank)
        <div style="width: 100%; height: 12px; background: #e9ecef; border-radius: 6px; overflow: hidden; margin-bottom: 10px;">
            <div style="height: 100%; background: linear-gradient(45deg, #fd7e14, #ffc107); border-radius: 6px; width: {{ min(100, (($totalRankPoints - $currentRank->min_points) / ($nextRank->min_points - $currentRank->min_points)) * 100) }}%; transition: width 0.3s ease;"></div>
        </div>
        
        <div style="display: flex; justify-content: space-between; font-size: 12px; color: #6c757d;">
            <span>{{ $currentRank->name }} ({{ number_format($currentRank->min_points) }})</span>
            <span>{{ $nextRank->name }} ({{ number_format($nextRank->min_points) }})</span>
        </div>
        @endif
    </div>

    <!-- Stats Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 15px; margin: 0 30px 30px; padding: 0;">
        <!-- Points Given -->
        <div style="background: white; border-radius: 16px; padding: 20px; box-shadow: 0 8px 25px rgba(0,0,0,0.12); text-align: center; border-top: 4px solid #28a745;">
            <div style="font-size: 14px; color: #28a745; margin-bottom: 8px; font-weight: 600;">Points Given</div>
            <div style="font-size: 24px; font-weight: bold; color: #2c3e50;">{{ number_format($pointsGiven) }}</div>
        </div>

        <!-- Customers -->
        <div style="background: white; border-radius: 16px; padding: 20px; box-shadow: 0 8px 25px rgba(0,0,0,0.12); text-align: center; border-top: 4px solid #6f42c1;">
            <div style="font-size: 14px; color: #6f42c1; margin-bottom: 8px; font-weight: 600;">Customers</div>
            <div style="font-size: 24px; font-weight: bold; color: #2c3e50;">{{ number_format($totalCustomers) }}</div>
        </div>

        <!-- Transactions -->
        <div style="background: white; border-radius: 16px; padding: 20px; box-shadow: 0 8px 25px rgba(0,0,0,0.12); text-align: center; border-top: 4px solid #17a2b8;">
            <div style="font-size: 14px; color: #17a2b8; margin-bottom: 8px; font-weight: 600;">Transactions</div>
            <div style="font-size: 24px; font-weight: bold; color: #2c3e50;">{{ number_format($totalTransactions) }}</div>
        </div>
    </div>

    <!-- Analytics Section -->
    <div class="analytics-section">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
            <h3 style="color: white; font-size: 18px; font-weight: 600; margin: 0;">Activity Overview</h3>
        </div>

        @if($totalTransactions > 0)
        <div class="spending-chart">
            <div class="chart-circle">
                <div class="chart-content">
                    <span class="chart-icon">📊</span>
                    <div class="chart-title">Total Activity</div>
                    <div class="chart-amount">{{ number_format($totalActivity) }} pts</div>
                </div>
            </div>
        </div>

        <div class="flow-cards">
            <div class="flow-card">
                <div class="flow-header">
                    <div class="flow-title">
                        <span>📈</span>
                        <span>Points Given</span>
                    </div>
                </div>
                <div class="flow-amount">{{ number_format($pointsGiven) }} pts</div>
                <div class="flow-change points-in-change">{{ round($givingPercentage) }}% of activity</div>
            </div>

            <div class="flow-card">
                <div class="flow-header">
                    <div class="flow-title">
                        <span>🎁</span>
                        <span>Redemptions</span>
                    </div>
                </div>
                <div class="flow-amount">{{ number_format($pointsFromRedemptions) }} pts</div>
                <div class="flow-change points-out-change">{{ round($redemptionPercentage) }}% of activity</div>
            </div>
        </div>
        @else
        <!-- Empty state for no transactions -->
        <div style="text-align: center; padding: 60px 20px; color: rgba(255,255,255,0.8);">
            <div style="font-size: 48px; margin-bottom: 20px;">📱</div>
            <h3 style="color: white; margin-bottom: 10px;">No Activity Yet</h3>
            <p style="font-size: 16px; margin-bottom: 30px;">Start scanning customer QR codes to track your green impact!</p>
            <button onclick="alert('QR Scanner feature coming soon!')" style="background: white; color: #2E8B57; border: none; padding: 12px 30px; border-radius: 25px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all 0.3s ease;">
                Open Scanner
            </button>
        </div>
        @endif

        <div class="cash-flow-section">
            <div class="cash-flow-header">
                <div class="cash-flow-title">
                    <span>⭐</span>
                    <span>Rank Status</span>
                </div>
            </div>
            <div class="net-flow-label">Current Rank</div>
            <div class="net-flow-amount" style="color: #28a745;">{{ $currentRank->name }}</div>
            
            @if($nextRank)
            <div class="flow-bars">
                <div class="flow-bar-section">
                    <div class="flow-bar-label">Current Points</div>
                    <div class="flow-bar points-in-bar"></div>
                    <div class="flow-bar-amount">{{ number_format($totalRankPoints) }}</div>
                </div>
                <div class="flow-bar-section">
                    <div class="flow-bar-label">Next Rank</div>
                    <div class="flow-bar points-out-bar"></div>
                    <div class="flow-bar-amount">{{ number_format($nextRank->min_points) }}</div>
                </div>
            </div>
            @else
            <div style="text-align: center; padding: 20px; color: #28a745;">
                <p style="font-size: 18px; margin: 0;">🏆 Congratulations! You've reached the highest rank!</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Top Items Section -->
    <div style="margin: 0 30px 30px; background: white; border-radius: 16px; padding: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); border: 1px solid #e9ecef;">
        <h3 style="color: #2c3e50; font-size: 18px; margin-bottom: 20px;">Top Scanned Items</h3>
        
        @if($topItems->count() > 0)
            @foreach($topItems as $item)
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 0; border-bottom: 1px solid #e9ecef;">
                <div style="display: flex; align-items: center; gap: 15px;">
                    <div style="width: 40px; height: 40px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 18px; color: white; background: linear-gradient(45deg, #28a745, #20c997);">
                        @switch($item->name)
                            @case('Reusable Cup') ♻️ @break
                            @case('Coffee Cup') ☕ @break
                            @case('Water Bottle') 🥤 @break
                            @case('Food Container') 🍽️ @break
                            @case('Shopping Bag') 🛍️ @break
                            @case('Takeout Container') 📦 @break
                            @case('Straw') 🥤 @break
                            @case('Utensils Set') 🍴 @break
                            @default 📦
                        @endswitch
                    </div>
                    <div>
                        <h4 style="color: #2c3e50; font-size: 16px; margin-bottom: 2px;">{{ $item->name }}</h4>
                        <p style="color: #6c757d; font-size: 14px;">{{ number_format($item->scan_count) }} scans</p>
                    </div>
                </div>
                <div style="text-align: right;">
                    <div style="color: #28a745; font-weight: bold; font-size: 16px;">+{{ number_format($item->total_points) }} pts</div>
                    <div style="color: #6c757d; font-size: 14px;">{{ number_format($item->total_units) }} units</div>
                </div>
            </div>
            @endforeach
        @else
            <!-- Empty state for no items -->
            <div style="text-align: center; padding: 40px 20px; color: #6c757d;">
                <div style="font-size: 48px; margin-bottom: 15px; opacity: 0.3;">📦</div>
                <p style="font-size: 16px;">No items scanned yet. Start scanning customer items to see your top products!</p>
            </div>
        @endif
    </div>

    <!-- Services Grid -->
    <div class="services-grid">
        <a href="{{ route('seller.profile') ?? '#' }}" class="service-item">
            <div class="service-icon">👤</div>
            <div class="service-name">Account</div>
        </a>

        <a href="#" class="service-item" onclick="alert('Point Scanner feature coming soon!')">
            <div class="service-icon">📱</div>
            <div class="service-name">Point<br>Scanner</div>
        </a>

        <a href="#" class="service-item" onclick="alert('Upload Product feature coming soon!')">
            <div class="service-icon">📤</div>
            <div class="service-name">Upload<br>Product</div>
        </a>
    </div>
    
    @if($totalTransactions == 0)
    <!-- Getting Started Guide for new sellers -->
    <div style="margin: 0 30px 30px; background: linear-gradient(135deg, #e8f5e9, #c8e6c9); border-radius: 16px; padding: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.08);">
        <h3 style="color: #2E8B57; font-size: 18px; margin-bottom: 15px;">🚀 Getting Started</h3>
        <ol style="color: #558b2f; font-size: 15px; line-height: 1.8; margin: 0; padding-left: 20px;">
            <li>Share your seller QR code with customers</li>
            <li>Scan customer items when they use reusable products</li>
            <li>Award points automatically to encourage green behavior</li>
            <li>Track your impact and climb the ranks!</li>
        </ol>
    </div>
    @endif
</div>

<!-- Logout Confirmation Modal -->
<!-- Style 1: Friendly Modal (Current) -->
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

<!-- Style 2: Minimalist Modal (Alternative - uncomment to use) -->
<!--
<div id="logoutModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; opacity: 0; transition: opacity 0.3s ease;">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; border-radius: 16px; padding: 24px; box-shadow: 0 10px 40px rgba(0,0,0,0.2); max-width: 320px; width: 90%;">
        <h4 style="color: #2c3e50; margin-bottom: 16px; font-size: 18px; font-weight: 600;">Confirm Logout</h4>
        <p style="color: #6c757d; margin-bottom: 20px; font-size: 14px;">Are you sure you want to logout?</p>
        
        <form id="logoutForm" action="{{ route('logout') }}" method="POST">
            @csrf
            <div style="display: flex; gap: 12px;">
                <button type="button" onclick="hideLogoutModal()" style="flex: 1; background: white; color: #6c757d; border: 1px solid #dee2e6; padding: 10px 20px; border-radius: 8px; font-size: 14px; font-weight: 500; cursor: pointer; transition: all 0.2s ease; font-family: inherit;">
                    Cancel
                </button>
                <button type="submit" style="flex: 1; background: #dc3545; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-size: 14px; font-weight: 500; cursor: pointer; transition: all 0.2s ease; font-family: inherit;">
                    Logout
                </button>
            </div>
        </form>
    </div>
</div>
-->

<style>
/* Additional dashboard-specific styles */
.rank-progress-section h3 {
    display: flex;
    align-items: center;
    gap: 8px;
}

.services-grid {
    padding-bottom: 40px;
    grid-template-columns: repeat(3, 1fr) !important;
}

.service-item {
    transition: all 0.3s ease;
    border: none;
    background: white;
    font-family: inherit;
}

.service-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.18);
}

/* Header logout button */
.header .greeting button {
    font-family: inherit;
}

/* Modal animations */
@keyframes modalSlideIn {
    from {
        transform: translate(-50%, -50%) scale(0.8);
        opacity: 0;
    }
    to {
        transform: translate(-50%, -50%) scale(1);
        opacity: 1;
    }
}

#logoutModal > div {
    animation: modalSlideIn 0.3s ease-out;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .services-grid {
        grid-template-columns: repeat(3, 1fr) !important;
        gap: 15px;
        padding: 30px 30px 40px;
    }
    
    .service-icon {
        width: 50px;
        height: 50px;
        font-size: 24px;
    }
    
    .service-name {
        font-size: 14px;
    }
}

@media (max-width: 480px) {
    .services-grid {
        grid-template-columns: 1fr !important;
        gap: 20px;
    }
    
    .service-icon {
        width: 60px;
        height: 60px;
        font-size: 28px;
    }
    
    .service-name {
        font-size: 16px;
    }
}
</style>

<script>
// Logout modal functions
function showLogoutModal() {
    const modal = document.getElementById('logoutModal');
    modal.style.display = 'block';
    document.body.style.overflow = 'hidden'; // Prevent body scroll
    setTimeout(() => {
        modal.style.opacity = '1';
    }, 10);
}

function hideLogoutModal() {
    const modal = document.getElementById('logoutModal');
    modal.style.opacity = '0';
    document.body.style.overflow = ''; // Restore body scroll
    setTimeout(() => {
        modal.style.display = 'none';
    }, 300);
}

// Close modal when clicking outside
document.getElementById('logoutModal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideLogoutModal();
    }
});

// Close modal with ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && document.getElementById('logoutModal').style.display === 'block') {
        hideLogoutModal();
    }
});

// Add some interactive functionality
document.addEventListener('DOMContentLoaded', function() {
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

    // Animate stats on page load
    const totalPointsEl = document.getElementById('totalPoints');
    if (totalPointsEl) {
        const currentValue = parseInt(totalPointsEl.textContent.replace(/,/g, ''));
        animateValue(totalPointsEl, 0, currentValue, 2000);
    }

    // Add hover effects to stat cards
    const statCards = document.querySelectorAll('[style*="border-top: 4px solid"]');
    statCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px) scale(1.02)';
            this.style.transition = 'all 0.3s ease';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Optional: Auto-refresh dashboard data every 60 seconds
    @if($totalTransactions > 0)
    setInterval(function() {
        fetch('{{ route("dashboard.data") }}')
            .then(response => response.json())
            .then(data => {
                // Update points display
                if (data.total_rank_points !== undefined) {
                    document.getElementById('totalPoints').textContent = data.total_rank_points.toLocaleString();
                }
                // You can update other elements here as needed
            })
            .catch(error => console.error('Error refreshing data:', error));
    }, 60000); // Refresh every 60 seconds
    @endif
});
</script>
@endsection