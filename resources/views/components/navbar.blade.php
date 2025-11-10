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

        <!-- Center Section - Main Navigation (Desktop Only) -->
        <div class="navbar-center">
            @auth('seller')
                <div class="main-nav">
                    <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('item.index') }}" class="nav-item {{ request()->routeIs('item.*') ? 'active' : '' }}">
                        <i class="fas fa-box"></i>
                        <span>Items</span>
                    </a>
                    <a href="{{ route('reward.index') }}" class="nav-item {{ request()->routeIs('reward.*') ? 'active' : '' }}">
                        <i class="fas fa-gift"></i>
                        <span>Rewards</span>
                    </a>
                    <a href="{{ route('reward.redemptions') }}" class="nav-item {{ request()->routeIs('reward.redemptions') ? 'active' : '' }}">
                        <i class="fas fa-exchange-alt"></i>
                        <span>Redemptions</span>
                    </a>
                    <a href="{{ route('seller.receipts.index') }}" class="nav-item {{ request()->routeIs('seller.receipts.*') ? 'active' : '' }}">
                        <i class="fas fa-receipt"></i>
                        <span>Receipts</span>
                    </a>
                    <a href="{{ route('seller.consumers.index') }}" class="nav-item {{ request()->routeIs('seller.consumers.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span>Consumers</span>
                    </a>
                    <a href="{{ route('report.index') }}" class="nav-item {{ request()->routeIs('report.*') ? 'active' : '' }}">
                        <i class="fas fa-flag"></i>
                        <span>Reports</span>
                    </a>
                </div>
            @endauth
        </div>

        <!-- Right Section -->
        <div class="navbar-right">
            @auth('seller')
                <!-- Mobile Menu Toggle -->
                <button class="mobile-menu-toggle" id="mobileMenuToggle">
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                </button>

                <!-- Account Menu (Desktop) -->
                <div class="account-menu" id="accountMenu">
                    <div class="account-info" onclick="toggleAccountDropdown()">
                        <div class="user-avatar">
                            @if(auth('seller')->user()->photo_url)
                                <img src="{{ auth('seller')->user()->photo_url }}"
                                     alt="Profile" class="user-photo">
                            @else
                                <i class="fas fa-store"></i>
                            @endif
                        </div>
                        <div class="user-details">
                            <span class="user-name">{{ auth('seller')->user()->business_name ?? 'Business' }}</span>
                            <span class="user-email">{{ auth('seller')->user()->email }}</span>
                        </div>
                        <i class="fas fa-chevron-down dropdown-icon"></i>
                    </div>

                    <!-- Account Dropdown -->
                    <div class="account-dropdown" id="accountDropdown">
                        <div class="dropdown-header">
                            <div class="user-info-full">
                                <div class="user-avatar-large">
                                    @if(auth('seller')->user()->photo_url)
                                        <img src="{{ auth('seller')->user()->photo_url }}"
                                             alt="Profile" class="user-photo">
                                    @else
                                        <i class="fas fa-store"></i>
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

                        <!-- Account Section -->
                        <div class="dropdown-section">
                            <a href="{{ route('seller.account') }}" class="dropdown-item {{ request()->routeIs('seller.account') ? 'active' : '' }}">
                                <i class="fas fa-user-circle"></i>
                                <span>Account Settings</span>
                            </a>
                            <a href="{{ route('seller.activity') }}" class="dropdown-item {{ request()->routeIs('seller.activity') ? 'active' : '' }}">
                                <i class="fas fa-history"></i>
                                <span>Activity History</span>
                            </a>
                            <a href="{{ route('seller.photos') }}" class="dropdown-item {{ request()->routeIs('seller.photos.*') ? 'active' : '' }}">
                                <i class="fas fa-images"></i>
                                <span>Photo Gallery</span>
                            </a>
                            <a href="{{ route('location.show') }}" class="dropdown-item {{ request()->routeIs('location.*') ? 'active' : '' }}">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Location</span>
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
                </div>
            @endauth
        </div>
    </div>

    <!-- Mobile Menu Overlay -->
    @auth('seller')
        <div class="mobile-menu-overlay" id="mobileMenuOverlay">
            <div class="mobile-menu-content">
                <!-- Mobile Menu Header -->
                <div class="mobile-menu-header">
                    <div class="user-info-mobile">
                        <div class="user-avatar-mobile">
                            @if(auth('seller')->user()->photo_url)
                                <img src="{{ auth('seller')->user()->photo_url }}"
                                     alt="Profile" class="user-photo">
                            @else
                                <i class="fas fa-store"></i>
                            @endif
                        </div>
                        <div>
                            <h3>{{ auth('seller')->user()->business_name ?? 'Business' }}</h3>
                            <p>{{ auth('seller')->user()->email }}</p>
                            <span class="user-status {{ auth('seller')->user()->is_active ? 'active' : 'inactive' }}">
                                {{ auth('seller')->user()->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                    <button class="mobile-menu-close" id="mobileMenuClose">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <!-- Mobile Navigation -->
                <div class="mobile-nav-section">
                    <h4 class="mobile-section-title">Navigation</h4>
                    <a href="{{ route('dashboard') }}" class="mobile-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                    <a href="{{ route('item.index') }}" class="mobile-nav-item {{ request()->routeIs('item.*') ? 'active' : '' }}">
                        <i class="fas fa-box"></i>
                        <span>Items</span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                    <a href="{{ route('reward.index') }}" class="mobile-nav-item {{ request()->routeIs('reward.*') ? 'active' : '' }}">
                        <i class="fas fa-gift"></i>
                        <span>Rewards</span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                    <a href="{{ route('reward.redemptions') }}" class="mobile-nav-item {{ request()->routeIs('reward.redemptions') ? 'active' : '' }}">
                        <i class="fas fa-exchange-alt"></i>
                        <span>Redemptions</span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                    <a href="{{ route('seller.receipts.index') }}" class="mobile-nav-item {{ request()->routeIs('seller.receipts.*') ? 'active' : '' }}">
                        <i class="fas fa-receipt"></i>
                        <span>Receipts</span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                    <a href="{{ route('seller.consumers.index') }}" class="mobile-nav-item {{ request()->routeIs('seller.consumers.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span>Consumers</span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                    <a href="{{ route('report.index') }}" class="mobile-nav-item {{ request()->routeIs('report.*') ? 'active' : '' }}">
                        <i class="fas fa-flag"></i>
                        <span>Reports</span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </div>

                <!-- Mobile Account Section -->
                <div class="mobile-nav-section">
                    <h4 class="mobile-section-title">Account</h4>
                    <a href="{{ route('seller.account') }}" class="mobile-nav-item {{ request()->routeIs('seller.account') ? 'active' : '' }}">
                        <i class="fas fa-user-circle"></i>
                        <span>Account Settings</span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                    <a href="{{ route('seller.activity') }}" class="mobile-nav-item {{ request()->routeIs('seller.activity') ? 'active' : '' }}">
                        <i class="fas fa-history"></i>
                        <span>Activity History</span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                    <a href="{{ route('seller.photos') }}" class="mobile-nav-item {{ request()->routeIs('seller.photos.*') ? 'active' : '' }}">
                        <i class="fas fa-images"></i>
                        <span>Photo Gallery</span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                    <a href="{{ route('location.show') }}" class="mobile-nav-item {{ request()->routeIs('location.*') ? 'active' : '' }}">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Location</span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </div>

                <!-- Mobile Logout -->
                <div class="mobile-logout-section">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="mobile-logout-btn">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endauth
</nav>

<!-- Navbar Styles -->
<style>
    /* Navbar Container */
    .navbar {
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.95) 0%, rgba(30, 41, 59, 0.95) 50%, rgba(51, 65, 85, 0.95) 100%);
        padding: 20px 0;
        position: sticky;
        top: 0;
        z-index: 1000;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3), 0 2px 16px rgba(0, 0, 0, 0.2);
        border-bottom: 1px solid rgba(255,255,255,0.15);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        transition: all 0.3s ease;
    }

    .navbar-container {
        max-width: 1600px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 32px;
        position: relative;
        gap: 32px;
        overflow: visible;
    }

    /* Left Section */
    .navbar-left {
        display: flex;
        align-items: center;
        gap: 20px;
        min-width: 250px;
        flex-shrink: 0;
        overflow: hidden;
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
        gap: 20px;
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

    /* Center Section - Main Navigation */
    .navbar-center {
        flex: 1;
        display: flex;
        justify-content: center;
        max-width: 800px;
        margin: 0 20px;
        min-width: 0; /* Allow shrinking */
    }

    .main-nav {
        display: flex;
        gap: 8px;
        background: rgba(255,255,255,0.08);
        border-radius: 18px;
        padding: 10px;
        backdrop-filter: blur(15px);
        border: 1px solid rgba(255,255,255,0.12);
        flex-wrap: nowrap;
        overflow: hidden;
    }

    .nav-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 14px 16px;
        border-radius: 14px;
        color: rgba(255,255,255,0.8);
        text-decoration: none;
        transition: all 0.3s ease;
        font-weight: 500;
        font-size: 13px;
        position: relative;
        overflow: hidden;
        white-space: nowrap;
        min-width: 0;
        flex-shrink: 1;
    }

    .nav-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
        transition: left 0.5s ease;
    }

    .nav-item:hover::before {
        left: 100%;
    }

    .nav-item:hover {
        color: white;
        background: rgba(255,255,255,0.15);
        transform: translateY(-2px);
        text-decoration: none;
    }

    .nav-item.active {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        font-weight: 600;
    }

    .nav-item i {
        font-size: 14px;
        width: 16px;
        text-align: center;
    }

    /* Right Section */
    .navbar-right {
        display: flex;
        align-items: center;
        gap: 20px;
        min-width: 250px;
        justify-content: flex-end;
        position: relative;
        flex-shrink: 1;
        overflow: visible;
    }

    .mobile-menu-toggle {
        display: none;
        flex-direction: column;
        gap: 4px;
        background: none;
        border: none;
        cursor: pointer;
        padding: 8px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .hamburger-line {
        width: 24px;
        height: 3px;
        background: white;
        border-radius: 2px;
        transition: all 0.3s ease;
    }

    .mobile-menu-toggle:hover {
        background: rgba(255,255,255,0.1);
    }

    .mobile-menu-toggle.active .hamburger-line:nth-child(1) {
        transform: rotate(45deg) translate(7px, 7px);
    }

    .mobile-menu-toggle.active .hamburger-line:nth-child(2) {
        opacity: 0;
    }

    .mobile-menu-toggle.active .hamburger-line:nth-child(3) {
        transform: rotate(-45deg) translate(7px, -7px);
    }

    /* Account Menu */
    .account-menu {
        position: relative;
    }

    .account-info {
        display: flex;
        align-items: center;
        gap: 16px;
        cursor: pointer;
        padding: 12px 20px;
        border-radius: 16px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
        border: 1px solid rgba(255,255,255,0.15);
        user-select: none;
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        position: relative;
        overflow: hidden;
        min-width: 180px;
        max-width: 280px;
    }

    .account-info::before {
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

    .account-info:hover::before {
        opacity: 1;
    }

    .account-info:hover {
        background: linear-gradient(135deg, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0.08) 100%);
        border-color: rgba(255,255,255,0.25);
        transform: translateY(-1px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
    }

    .user-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 15px;
        font-weight: 600;
        overflow: hidden;
        border: 2px solid rgba(255,255,255,0.4);
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2), 0 0 0 0 rgba(99, 102, 241, 0.4);
        position: relative;
    }

    .account-info:hover .user-avatar {
        transform: scale(1.1);
        border-color: rgba(255,255,255,0.6);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3), 0 0 20px rgba(99, 102, 241, 0.4);
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
        flex: 1;
        min-width: 0;
    }

    .user-name {
        color: white;
        font-weight: 600;
        font-size: 14px;
        line-height: 1.2;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .user-email {
        color: rgba(255,255,255,0.7);
        font-size: 12px;
        line-height: 1.2;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .dropdown-icon {
        color: rgba(255,255,255,0.7);
        font-size: 12px;
        transition: transform 0.2s ease;
    }

    .account-info.open .dropdown-icon {
        transform: rotate(180deg);
    }

    /* Account Dropdown */
    .account-dropdown {
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

    .account-dropdown.show {
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
        border-radius: 50%;
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 20px;
        font-weight: 600;
        overflow: hidden;
        border: 3px solid rgba(255,255,255,0.8);
        flex-shrink: 0;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
    }

    .user-info-full:hover .user-avatar-large {
        transform: scale(1.05);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
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

    /* Mobile Menu */
    .mobile-menu-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
        backdrop-filter: blur(8px);
        z-index: 10001;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }

    .mobile-menu-overlay.show {
        opacity: 1;
        visibility: visible;
    }

    .mobile-menu-content {
        position: absolute;
        top: 0;
        right: 0;
        width: 320px;
        max-width: 90vw;
        height: 100vh;
        height: 100dvh; /* Use dynamic viewport height for mobile browsers */
        background: white;
        box-shadow: -10px 0 30px rgba(0,0,0,0.2);
        transform: translateX(100%);
        transition: transform 0.3s ease;
        overflow-y: auto;
        -webkit-overflow-scrolling: touch; /* Smooth scrolling on iOS */
        padding-bottom: 40px; /* Extra padding at bottom to ensure logout is accessible */
    }

    .mobile-menu-overlay.show .mobile-menu-content {
        transform: translateX(0);
    }

    .mobile-menu-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        padding: 24px 20px;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        color: white;
    }

    .user-info-mobile {
        display: flex;
        gap: 12px;
        flex: 1;
    }

    .user-avatar-mobile {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 18px;
        font-weight: 600;
        overflow: hidden;
        border: 2px solid rgba(255,255,255,0.3);
        flex-shrink: 0;
    }

    .user-info-mobile h3 {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
        line-height: 1.2;
    }

    .user-info-mobile p {
        margin: 4px 0;
        color: rgba(255,255,255,0.8);
        font-size: 12px;
    }

    .mobile-menu-close {
        background: none;
        border: none;
        color: white;
        font-size: 20px;
        cursor: pointer;
        padding: 8px;
        border-radius: 8px;
        transition: background 0.2s ease;
    }

    .mobile-menu-close:hover {
        background: rgba(255,255,255,0.1);
    }

    .mobile-nav-section {
        padding: 20px 0;
        border-bottom: 1px solid #e2e8f0;
    }

    .mobile-section-title {
        color: #64748b;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin: 0 0 12px 20px;
    }

    .mobile-nav-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px 20px;
        color: #374151;
        text-decoration: none;
        transition: all 0.2s ease;
        font-weight: 500;
    }

    .mobile-nav-item:hover {
        background: #f8fafc;
        color: #1e40af;
        text-decoration: none;
    }

    .mobile-nav-item.active {
        background: #eff6ff;
        color: #1d4ed8;
        border-left: 4px solid #3b82f6;
        padding-left: 16px;
    }

    .mobile-nav-item i:first-child {
        width: 18px;
        text-align: center;
        font-size: 14px;
    }

    .mobile-nav-item i:last-child {
        margin-left: auto;
        color: #94a3b8;
        font-size: 12px;
    }

    .mobile-logout-section {
        padding: 20px;
        padding-bottom: 30px; /* Extra bottom padding for safe area on mobile */
        border-top: 1px solid #e2e8f0;
        margin-bottom: 20px; /* Ensure space at the very bottom */
    }

    .mobile-logout-btn {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px;
        width: 100%;
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: 12px;
        color: #dc2626;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .mobile-logout-btn:hover {
        background: #fee2e2;
        border-color: #fca5a5;
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

    /* Responsive Design */
    @media (max-width: 1400px) {
        .navbar-center {
            margin: 0 12px;
            max-width: 700px;
        }

        .nav-item {
            padding: 12px 14px;
            font-size: 12px;
            gap: 6px;
        }

        .main-nav {
            gap: 6px;
            padding: 8px;
        }

        .account-info {
            padding: 10px 16px;
            min-width: 160px;
            max-width: 240px;
            gap: 12px;
        }

        .user-name {
            font-size: 13px;
        }

        .user-email {
            font-size: 11px;
        }
    }

    @media (max-width: 1200px) {
        .navbar-center {
            margin: 0 8px;
            max-width: 600px;
        }

        .nav-item {
            padding: 10px 12px;
            font-size: 11px;
            gap: 5px;
        }

        .nav-item span {
            font-size: 11px;
        }

        .main-nav {
            gap: 4px;
            padding: 6px;
        }

        .account-info {
            min-width: 140px;
            max-width: 200px;
            padding: 8px 12px;
            gap: 10px;
        }

        .user-name {
            font-size: 12px;
        }

        .user-email {
            font-size: 10px;
        }

        .dropdown-icon {
            font-size: 10px;
        }
    }

    @media (max-width: 1100px) {
        .navbar-container {
            gap: 12px;
            padding: 0 20px;
        }

        .navbar-center {
            margin: 0 4px;
            max-width: 500px;
        }

        .navbar-left {
            min-width: 200px;
        }

        .navbar-right {
            min-width: 180px;
            gap: 12px;
        }

        .nav-item {
            padding: 8px 8px;
            font-size: 10px;
            gap: 4px;
        }

        .nav-item span {
            font-size: 10px;
        }

        .main-nav {
            gap: 3px;
            padding: 5px;
        }

        .account-info {
            min-width: auto;
            max-width: 160px;
            padding: 8px 10px;
            gap: 8px;
        }

        .user-name {
            font-size: 11px;
        }

        .user-email {
            font-size: 9px;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            font-size: 13px;
        }
    }

    @media (max-width: 1024px) {
        .nav-item span {
            display: none;
        }

        .nav-item {
            padding: 10px;
            min-width: 36px;
            justify-content: center;
        }

        .nav-item i {
            font-size: 16px;
        }

        .account-info {
            min-width: auto;
            max-width: 160px;
            padding: 8px 10px;
            gap: 8px;
        }

        .user-name {
            font-size: 11px;
        }

        .user-email {
            font-size: 9px;
        }

        .user-avatar {
            width: 30px;
            height: 30px;
            font-size: 12px;
        }

        .dropdown-icon {
            font-size: 9px;
        }
    }

    @media (max-width: 991px) {
        .navbar {
            padding: 16px 0;
        }

        .navbar-container {
            gap: 16px;
            padding: 0 20px;
        }

        .navbar-center {
            display: none;
        }

        .mobile-menu-toggle {
            display: flex;
        }

        .account-menu {
            display: none;
        }

        .navbar-left {
            min-width: auto;
            flex: 1;
        }

        .navbar-right {
            min-width: auto;
            flex-shrink: 0;
        }
    }

    @media (max-width: 768px) {
        .navbar {
            padding: 14px 0;
        }

        .navbar-container {
            padding: 0 16px;
            gap: 12px;
        }

        .navbar-left {
            min-width: auto;
            flex: 1;
            gap: 12px;
        }

        .navbar-right {
            min-width: auto;
            flex-shrink: 0;
        }

        .navbar-brand .app-title {
            font-size: 20px;
        }

        .navbar-brand .app-subtitle {
            font-size: 11px;
        }

        .navbar-navigation {
            gap: 12px;
        }

        .navbar-title .page-title {
            font-size: 18px;
        }

        .user-details {
            display: none;
        }

        .account-dropdown {
            min-width: 260px;
            right: -10px;
        }

        .back-btn {
            width: 36px;
            height: 36px;
            font-size: 16px;
        }
    }

    @media (max-width: 576px) {
        .navbar {
            padding: 10px 0;
        }

        .navbar-container {
            padding: 0 12px;
            gap: 8px;
            flex-wrap: nowrap;
        }

        .navbar-left {
            gap: 8px;
            min-width: 0;
            flex: 1;
            overflow: hidden;
        }

        .navbar-right {
            flex-shrink: 0;
        }

        .navbar-brand .app-title {
            font-size: 16px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .navbar-brand .app-subtitle {
            font-size: 10px;
            display: none; /* Hide subtitle on very small screens */
        }

        .navbar-title .page-title {
            font-size: 16px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 180px;
        }

        .navbar-title .page-subtitle {
            display: none;
        }

        .back-btn {
            width: 32px;
            height: 32px;
            font-size: 14px;
            flex-shrink: 0;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            font-size: 13px;
        }

        .mobile-menu-toggle {
            padding: 4px;
        }

        .hamburger-line {
            width: 20px;
            height: 2px;
        }
    }

    @media (max-width: 480px) {
        .navbar {
            padding: 10px 0;
        }

        .navbar-container {
            padding: 0 10px;
            gap: 6px;
        }

        .navbar-left {
            gap: 6px;
        }

        .navbar-brand .app-title {
            font-size: 15px;
        }

        .navbar-brand .app-subtitle {
            font-size: 9px;
            display: none;
        }

        .navbar-title .page-title {
            font-size: 15px;
            max-width: 150px;
        }

        .back-btn {
            width: 30px;
            height: 30px;
            font-size: 13px;
        }

        .user-avatar {
            width: 30px;
            height: 30px;
            font-size: 12px;
        }
    }

    @media (max-width: 360px) {
        .navbar-container {
            padding: 0 8px;
            gap: 4px;
        }

        .navbar-left {
            gap: 4px;
        }

        .navbar-brand .app-title {
            font-size: 14px;
            max-width: 140px;
        }

        .navbar-title .page-title {
            font-size: 14px;
            max-width: 120px;
        }

        .back-btn {
            width: 28px;
            height: 28px;
            font-size: 12px;
        }

        .user-avatar {
            width: 28px;
            height: 28px;
            font-size: 11px;
        }

        .hamburger-line {
            width: 18px;
        }
    }

        .navbar-navigation {
            gap: 8px;
        }

        .navbar-title .page-title {
            font-size: 16px;
        }

        .mobile-menu-content {
            width: 100vw;
        }

        .account-dropdown {
            min-width: 240px;
            right: -20px;
        }

        .back-btn {
            width: 32px;
            height: 32px;
            font-size: 14px;
        }
    }

    @media (max-width: 360px) {
        .navbar-container {
            padding: 0 8px;
            gap: 6px;
        }

        .navbar-brand .app-title {
            font-size: 16px;
        }

        .navbar-title .page-title {
            font-size: 14px;
        }

        .mobile-menu-toggle {
            padding: 6px;
        }

        .hamburger-line {
            width: 20px;
            height: 2px;
        }
    }
</style>

<!-- Navbar JavaScript -->
<script>
    // Toggle account dropdown
    function toggleAccountDropdown() {
        const dropdown = document.getElementById('accountDropdown');
        const accountInfo = document.querySelector('.account-info');

        if (dropdown && accountInfo) {
            dropdown.classList.toggle('show');
            accountInfo.classList.toggle('open');
        }
    }

    // Mobile menu functions
    function toggleMobileMenu() {
        const overlay = document.getElementById('mobileMenuOverlay');
        const toggle = document.getElementById('mobileMenuToggle');

        if (overlay && toggle) {
            const isOpen = overlay.classList.contains('show');
            if (isOpen) {
                closeMobileMenu();
            } else {
                openMobileMenu();
            }
        }
    }

    function openMobileMenu() {
        const overlay = document.getElementById('mobileMenuOverlay');
        const toggle = document.getElementById('mobileMenuToggle');

        if (overlay && toggle) {
            overlay.classList.add('show');
            toggle.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeMobileMenu() {
        const overlay = document.getElementById('mobileMenuOverlay');
        const toggle = document.getElementById('mobileMenuToggle');

        if (overlay && toggle) {
            overlay.classList.remove('show');
            toggle.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    function closeAccountDropdown() {
        const dropdown = document.getElementById('accountDropdown');
        const accountInfo = document.querySelector('.account-info');

        if (dropdown && accountInfo) {
            dropdown.classList.remove('show');
            accountInfo.classList.remove('open');
        }
    }

    // Event listeners
    document.addEventListener('DOMContentLoaded', function() {
        // Mobile menu toggle
        const mobileToggle = document.getElementById('mobileMenuToggle');
        if (mobileToggle) {
            mobileToggle.addEventListener('click', toggleMobileMenu);
        }

        // Mobile menu close
        const mobileClose = document.getElementById('mobileMenuClose');
        if (mobileClose) {
            mobileClose.addEventListener('click', closeMobileMenu);
        }

        // Close mobile menu when clicking overlay
        const mobileOverlay = document.getElementById('mobileMenuOverlay');
        if (mobileOverlay) {
            mobileOverlay.addEventListener('click', function(e) {
                if (e.target === mobileOverlay) {
                    closeMobileMenu();
                }
            });
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            const accountMenu = document.querySelector('.account-menu');
            const accountDropdown = document.getElementById('accountDropdown');
            const mobileMenuContent = document.querySelector('.mobile-menu-content');
            const mobileMenuToggle = document.getElementById('mobileMenuToggle');

            // Close account dropdown
            if (accountMenu && accountDropdown) {
                if (!accountMenu.contains(event.target) && !accountDropdown.contains(event.target)) {
                    closeAccountDropdown();
                }
            }

            // Close mobile menu
            if (mobileMenuContent && mobileMenuToggle) {
                if (!mobileMenuContent.contains(event.target) && !mobileMenuToggle.contains(event.target)) {
                    closeMobileMenu();
                }
            }
        });

        // Close dropdowns on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeAccountDropdown();
                closeMobileMenu();
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 991) {
                closeMobileMenu();
            }
        });

        // Auto-dismiss alerts
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
