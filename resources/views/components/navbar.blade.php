<!-- Navigation Bar -->
<nav class="navbar">
    <div class="navbar-container">
        <!-- Left Section -->
        <div class="navbar-left">
            @if(request()->routeIs('dashboard'))
                <!-- Dashboard - Show brand -->
                <div class="navbar-brand">
                    <h1 class="app-title">Green Cup</h1>
                    <p class="app-subtitle">Seller Dashboard</p>
                </div>
            @else
                <!-- Other pages - Show back button and page title -->
                <div class="navbar-navigation">
                    <a href="{{ route('dashboard') }}" class="back-btn">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div class="navbar-title">
                        <h2 class="page-title">@yield('page-title', 'Green Cup')</h2>
                        @hasSection('page-subtitle')
                            <p class="page-subtitle">@yield('page-subtitle')</p>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- Right Section -->
        <div class="navbar-right">
            @auth('seller')
                <!-- User Menu -->
                <div class="user-menu" onclick="toggleUserDropdown()">
                    <div class="user-info">
                        <div class="user-avatar">
                            @if(auth('seller')->user()->photo_url)
                                <img src="{{ asset(auth('seller')->user()->photo_url) }}"
                                     alt="Profile" class="user-photo">
                            @else
                                <i class="fas fa-user"></i>
                            @endif
                        </div>
                        <div class="user-details">
                            <span class="user-name">{{ auth('seller')->user()->business_name ?? 'Business' }}</span>
                            <span class="user-email">{{ auth('seller')->user()->email }}</span>
                        </div>
                    </div>
                    <i class="fas fa-chevron-down dropdown-icon"></i>
                </div>

                <!-- Dropdown Menu -->
                <div class="user-dropdown" id="userDropdown">
                    <div class="dropdown-header">
                        <div class="user-info-full">
                            <div class="user-avatar-large">
                                @if(auth('seller')->user()->photo_url)
                                    <img src="{{ asset(auth('seller')->user()->photo_url) }}"
                                         alt="Profile" class="user-photo">
                                @else
                                    <i class="fas fa-user"></i>
                                @endif
                            </div>
                            <div>
                                <h4>{{ auth('seller')->user()->business_name ?? 'Business' }}</h4>
                                <p>{{ auth('seller')->user()->email }}</p>
                                <span class="user-status {{ auth('seller')->user()->is_active ? 'active' : 'inactive' }}">
                                    {{ auth('seller')->user()->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="dropdown-divider"></div>

                    <!-- Navigation Links -->
                    <div class="dropdown-section">
                        <h5 class="dropdown-section-title">Navigation</h5>
                        <a href="{{ route('dashboard') }}" class="dropdown-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('item.index') }}" class="dropdown-item {{ request()->routeIs('item.*') ? 'active' : '' }}">
                            <i class="fas fa-box"></i>
                            <span>Items</span>
                        </a>
                        <a href="{{ route('reward.index') }}" class="dropdown-item {{ request()->routeIs('reward.*') ? 'active' : '' }}">
                            <i class="fas fa-gift"></i>
                            <span>Rewards</span>
                        </a>
                        <a href="{{ route('reward.redemptions') }}" class="dropdown-item {{ request()->routeIs('reward.redemptions') ? 'active' : '' }}">
                            <i class="fas fa-exchange-alt"></i>
                            <span>Redemptions</span>
                        </a>
                        <a href="{{ route('seller.receipts.index') }}" class="dropdown-item {{ request()->routeIs('seller.receipts.*') ? 'active' : '' }}">
                            <i class="fas fa-receipt"></i>
                            <span>Receipts</span>
                        </a>
                        <a href="{{ route('report.index') }}" class="dropdown-item {{ request()->routeIs('report.*') ? 'active' : '' }}">
                            <i class="fas fa-flag"></i>
                            <span>Reports</span>
                        </a>
                    </div>

                    <div class="dropdown-divider"></div>

                    <!-- Account Section -->
                    <div class="dropdown-section">
                        <h5 class="dropdown-section-title">Account</h5>
                        <a href="{{ route('seller.account') }}" class="dropdown-item {{ request()->routeIs('seller.account') ? 'active' : '' }}">
                            <i class="fas fa-user-circle"></i>
                            <span>Account Settings</span>
                        </a>
                        <a href="{{ route('seller.photos') }}" class="dropdown-item {{ request()->routeIs('seller.photos.*') ? 'active' : '' }}">
                            <i class="fas fa-images"></i>
                            <span>Photo Gallery</span>
                        </a>
                        <a href="{{ route('location.show') }}" class="dropdown-item {{ request()->routeIs('location.*') ? 'active' : '' }}">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Location</span>
                        </a>
                        <a href="{{ route('seller.scanner') }}" class="dropdown-item {{ request()->routeIs('seller.scanner') ? 'active' : '' }}">
                            <i class="fas fa-qrcode"></i>
                            <span>QR Scanner</span>
                        </a>
                    </div>

                    <div class="dropdown-divider"></div>

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}" class="dropdown-logout">
                        @csrf
                        <button type="submit" class="dropdown-item logout-item">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            @endauth
        </div>
    </div>
</nav>

<!-- Navbar Styles -->
<style>
    /* Navbar Container */
    .navbar {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
        padding: 18px 24px;
        position: sticky;
        top: 0;
        z-index: 1000;
        box-shadow: 0 8px 32px rgba(0,0,0,0.2), 0 2px 16px rgba(0,0,0,0.1);
        border-bottom: 1px solid rgba(255,255,255,0.15);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        transition: all 0.3s ease;
    }

    .navbar-container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
    }

    /* Left Section */
    .navbar-left {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .navbar-brand .app-title {
        color: #ffffff;
        font-size: 26px;
        font-weight: 800;
        margin: 0;
        line-height: 1.1;
        background: linear-gradient(135deg, #ffffff 0%, #e2e8f0 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .navbar-brand .app-subtitle {
        color: rgba(255,255,255,0.9);
        font-size: 13px;
        margin: 0;
        line-height: 1;
        font-weight: 500;
        letter-spacing: 0.5px;
    }

    .navbar-navigation {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .back-btn {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0.05) 100%);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        font-size: 18px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        position: relative;
        overflow: hidden;
    }

    .back-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s ease;
    }

    .back-btn:hover::before {
        left: 100%;
    }

    .back-btn:hover {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.25) 0%, rgba(255, 255, 255, 0.15) 100%);
        transform: translateX(-3px) scale(1.05);
        color: white;
        text-decoration: none;
        border-color: rgba(255, 255, 255, 0.3);
        box-shadow: 0 4px 16px rgba(0,0,0,0.2);
    }

    .navbar-title .page-title {
        color: white;
        font-size: 20px;
        font-weight: 600;
        margin: 0;
        line-height: 1.2;
    }

    .navbar-title .page-subtitle {
        color: rgba(255,255,255,0.8);
        font-size: 14px;
        margin: 0;
        line-height: 1;
    }

    /* Right Section */
    .navbar-right {
        position: relative;
    }

    .user-menu {
        display: flex;
        align-items: center;
        gap: 14px;
        cursor: pointer;
        padding: 10px 16px;
        border-radius: 16px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
        border: 1px solid rgba(255,255,255,0.15);
        user-select: none;
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        position: relative;
        overflow: hidden;
    }

    .user-menu::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .user-menu:hover::before {
        opacity: 1;
    }

    .user-menu:hover {
        background: linear-gradient(135deg, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0.08) 100%);
        border-color: rgba(255,255,255,0.25);
        transform: translateY(-1px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .user-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 15px;
        font-weight: 600;
        overflow: hidden;
        border: 2px solid rgba(255,255,255,0.4);
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15), 0 0 0 0 rgba(16, 185, 129, 0.4);
        position: relative;
    }

    .user-menu:hover .user-avatar {
        transform: scale(1.1);
        border-color: rgba(255,255,255,0.6);
        box-shadow: 0 4px 12px rgba(0,0,0,0.25), 0 0 20px rgba(16, 185, 129, 0.3);
    }

    .user-photo {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }

    .user-details {
        display: flex;
        flex-direction: column;
        text-align: left;
    }

    .user-name {
        color: white;
        font-weight: 600;
        font-size: 14px;
        line-height: 1.2;
        max-width: 150px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .user-email {
        color: rgba(255,255,255,0.7);
        font-size: 12px;
        line-height: 1.2;
        max-width: 150px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .dropdown-icon {
        color: rgba(255,255,255,0.7);
        font-size: 12px;
        transition: transform 0.2s ease;
    }

    .user-menu.open .dropdown-icon {
        transform: rotate(180deg);
    }

    /* Dropdown Menu */
    .user-dropdown {
        position: absolute;
        top: calc(100% + 16px);
        right: 0;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(25px);
        -webkit-backdrop-filter: blur(25px);
        border-radius: 20px;
        box-shadow:
            0 25px 80px rgba(0,0,0,0.25),
            0 10px 40px rgba(0,0,0,0.15),
            inset 0 1px 0 rgba(255,255,255,0.9);
        min-width: 300px;
        max-width: 340px;
        max-height: 600px;
        z-index: 10000;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-20px) scale(0.9);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(255,255,255,0.3);
        overflow: hidden;
        overflow-y: auto;
    }

    .user-dropdown.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0) scale(1);
    }

    .dropdown-header {
        padding: 24px;
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 50%, #cbd5e1 100%);
        border-bottom: 1px solid rgba(148, 163, 184, 0.2);
        position: relative;
    }

    .dropdown-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.5) 0%, transparent 100%);
        pointer-events: none;
    }

    .user-info-full {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .user-avatar-large {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        font-size: 20px;
        font-weight: 600;
        overflow: hidden;
        border: 3px solid rgba(255,255,255,0.8);
        flex-shrink: 0;
        box-shadow: 0 4px 16px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }

    .user-info-full:hover .user-avatar-large {
        transform: scale(1.05);
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }

    .user-info-full h4 {
        margin: 0;
        color: #1e293b;
        font-size: 16px;
        font-weight: 600;
        line-height: 1.2;
    }

    .user-info-full p {
        margin: 2px 0;
        color: #64748b;
        font-size: 13px;
        line-height: 1.2;
    }

    .user-status {
        display: inline-block;
        padding: 2px 8px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 4px;
    }

    .user-status.active {
        background: #dcfce7;
        color: #166534;
    }

    .user-status.inactive {
        background: #fee2e2;
        color: #991b1b;
    }

    .dropdown-divider {
        height: 1px;
        background: #e2e8f0;
        margin: 0;
    }

    .dropdown-section {
        padding: 16px 0;
    }

    .dropdown-section-title {
        color: #64748b;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin: 0 0 8px 20px;
        padding: 0;
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 24px;
        color: #374151;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        background: none;
        width: 100%;
        text-align: left;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        position: relative;
        overflow: hidden;
    }

    .dropdown-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.1), transparent);
        transition: left 0.5s ease;
    }

    .dropdown-item:hover::before {
        left: 100%;
    }

    .dropdown-item:hover {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.08) 0%, rgba(147, 197, 253, 0.05) 100%);
        color: #1e40af;
        text-decoration: none;
        transform: translateX(4px);
        padding-left: 28px;
    }

    .dropdown-item.active {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1d4ed8;
        font-weight: 600;
        border-left: 4px solid #3b82f6;
        padding-left: 20px;
    }

    .dropdown-item i {
        width: 16px;
        text-align: center;
        font-size: 14px;
    }

    .dropdown-logout {
        margin: 0;
    }

    .logout-item {
        color: #dc2626;
        border-top: 1px solid #e2e8f0;
    }

    .logout-item:hover {
        background: #fef2f2;
        color: #b91c1c;
    }

    /* Alert Styles */
    .alert {
        padding: 16px 20px;
        border-radius: 12px;
        margin-bottom: 20px;
        font-weight: 500;
        display: flex;
        align-items: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #10b981;
    }

    .alert-error {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #ef4444;
    }

    .alert ul {
        margin: 8px 0 0 0;
        padding-left: 20px;
    }

    .alert li {
        margin: 4px 0;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .navbar {
            padding: 12px 16px;
        }

        .user-details {
            display: none;
        }

        .user-dropdown {
            min-width: 260px;
            right: -10px;
        }

        .navbar-brand .app-title {
            font-size: 20px;
        }

        .navbar-title .page-title {
            font-size: 18px;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
        }

        .user-avatar .user-photo {
            width: 36px;
            height: 36px;
        }

        .user-avatar i {
            font-size: 16px;
        }
    }

    @media (max-width: 480px) {
        .navbar {
            padding: 10px 12px;
        }

        .user-dropdown {
            min-width: 240px;
            right: -20px;
        }

        .navbar-brand .app-title {
            font-size: 18px;
        }

        .navbar-title .page-title {
            font-size: 16px;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
        }

        .user-avatar .user-photo {
            width: 32px;
            height: 32px;
        }

        .user-avatar i {
            font-size: 14px;
        }

        .dropdown-header h4 {
            font-size: 16px;
        }

        .dropdown-header p {
            font-size: 13px;
        }

        .dropdown-item span {
            font-size: 14px;
        }
    }
</style>

<!-- Navbar JavaScript -->
<script>
    // Toggle user dropdown
    function toggleUserDropdown() {
        const dropdown = document.getElementById('userDropdown');
        const userMenu = document.querySelector('.user-menu');

        dropdown.classList.toggle('show');
        userMenu.classList.toggle('open');
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const userMenu = document.querySelector('.user-menu');
        const dropdown = document.getElementById('userDropdown');

        if (userMenu && dropdown) {
            if (!userMenu.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.remove('show');
                userMenu.classList.remove('open');
            }
        }
    });

    // Close dropdown on escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const dropdown = document.getElementById('userDropdown');
            const userMenu = document.querySelector('.user-menu');

            if (dropdown && userMenu) {
                dropdown.classList.remove('show');
                userMenu.classList.remove('open');
            }
        }
    });

    // Auto-dismiss alerts
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-20px)';
                setTimeout(() => {
                    alert.remove();
                }, 300);
            }, 5000);
        });
    });
</script>
