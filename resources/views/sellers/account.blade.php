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
      background: #374151;
      padding: 20px;
      position: sticky;
      top: 0;
      z-index: 100;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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
      color: white;
      text-decoration: none;
    }

    .header-title-section {
      color: white;
    }

    .app-title {
      font-size: 24px;
      font-weight: 700;
      margin: 0 0 4px 0;
      color: white;
    }

    .app-subtitle {
      font-size: 14px;
      color: rgba(255, 255, 255, 0.8);
      margin: 0;
    }

    .back-button {
      background: linear-gradient(135deg, #00b09b, #00cdac);
      color: white;
      border: none;
      padding: 12px 20px;
      border-radius: 10px;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 8px;
      box-shadow: 0 4px 12px rgba(0, 176, 155, 0.3);
    }

    .back-button:hover {
      background: linear-gradient(135deg, #009688, #00b09b);
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(0, 176, 155, 0.4);
      color: white;
      text-decoration: none;
    }

    /* Main Content */
    .main-content {
      max-width: 1200px;
      margin: 0 auto;
      padding: 24px 16px;
    }

    /* Business Profile Section */
    .business-profile-card {
      background: white;
      border-radius: 20px;
      padding: 32px;
      margin-bottom: 24px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      border: 2px solid #f0f0f0;
      text-align: center;
    }

    /* Profile Picture Input Styles */
    .profile-picture-input-wrapper {
      position: relative;
      display: inline-block;
      margin-bottom: 20px;
    }

    .profile-avatar {
      width: 100px;
      height: 100px;
      margin: 0 auto 20px;
      background: linear-gradient(135deg, #00b09b, #00cdac);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 36px;
      font-weight: bold;
      text-transform: uppercase;
      color: white;
      border: 4px solid rgba(0, 176, 155, 0.2);
      box-shadow: 0 8px 25px rgba(0, 176, 155, 0.3);
      position: relative;
      overflow: hidden;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .profile-avatar:hover {
      transform: translateY(-2px);
      box-shadow: 0 12px 35px rgba(0, 176, 155, 0.4);
      border-color: rgba(0, 176, 155, 0.4);
    }

    .profile-avatar img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 50%;
    }

    .profile-overlay {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(0, 0, 0, 0.6);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      opacity: 0;
      transition: opacity 0.3s ease;
      cursor: pointer;
    }

    .profile-avatar:hover .profile-overlay {
      opacity: 1;
    }

    .overlay-content {
      color: white;
      text-align: center;
    }

    .overlay-icon {
      font-size: 20px;
      margin-bottom: 4px;
    }

    .overlay-text {
      font-size: 10px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .profile-file-input {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      opacity: 0;
      cursor: pointer;
    }

    .upload-instructions {
      font-size: 12px;
      color: #666;
      margin-bottom: 16px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }

    .change-picture-btn {
      background: linear-gradient(135deg, #6c757d, #5a6268);
      color: white;
      border: none;
      padding: 8px 16px;
      border-radius: 8px;
      font-size: 12px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-bottom: 16px;
      box-shadow: 0 2px 8px rgba(108, 117, 125, 0.3);
    }

    .change-picture-btn:hover {
      background: linear-gradient(135deg, #5a6268, #545b62);
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(108, 117, 125, 0.4);
    }

    .business-name {
      font-size: 28px;
      font-weight: 700;
      margin: 0 0 8px;
      color: #333;
    }

    .business-email {
      font-size: 16px;
      color: #666;
      margin: 0 0 24px;
    }

    .rank-badge-container {
      display: flex;
      justify-content: center;
      margin-bottom: 20px;
    }

    .rank-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: linear-gradient(135deg, #f8f9fa, #e9ecef);
      padding: 12px 24px;
      border-radius: 25px;
      font-size: 16px;
      font-weight: 600;
      color: #333;
      border: 2px solid #e9ecef;
    }

    .rank-badge.platinum {
      background: linear-gradient(135deg, #e5e4e2, #bbb);
      color: #333;
    }

    .rank-badge.gold {
      background: linear-gradient(135deg, #FFD700, #FFA500);
      color: white;
    }

    .rank-badge.silver {
      background: linear-gradient(135deg, #C0C0C0, #808080);
      color: white;
    }

    .rank-badge.bronze {
      background: linear-gradient(135deg, #CD7F32, #8B4513);
      color: white;
    }

    /* Stats Grid */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
      margin-bottom: 32px;
    }

    .stat-card {
      background: white;
      border-radius: 16px;
      padding: 24px;
      text-align: center;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      border: 2px solid #f0f0f0;
      transition: all 0.3s ease;
    }

    .stat-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
      border-color: #00b09b;
    }

    .stat-icon {
      font-size: 32px;
      margin-bottom: 12px;
      display: block;
    }

    .stat-value {
      font-size: 28px;
      font-weight: 700;
      color: #00b09b;
      margin-bottom: 4px;
    }

    .stat-label {
      font-size: 14px;
      color: #666;
      font-weight: 500;
    }

    /* Rank Progress */
    .rank-progress-card {
      background: white;
      border-radius: 20px;
      padding: 24px;
      margin-bottom: 32px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      border: 2px solid #f0f0f0;
    }

    .rank-progress-title {
      font-size: 18px;
      font-weight: 600;
      color: #333;
      margin-bottom: 16px;
      text-align: center;
    }

    .rank-progress-info {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 12px;
    }

    .current-rank,
    .next-rank {
      font-size: 14px;
      font-weight: 600;
    }

    .current-rank {
      color: #00b09b;
    }

    .next-rank {
      color: #666;
    }

    .progress-bar-container {
      width: 100%;
      height: 12px;
      background: #f0f0f0;
      border-radius: 6px;
      overflow: hidden;
      margin-bottom: 8px;
    }

    .progress-bar-fill {
      height: 100%;
      background: linear-gradient(45deg, #00b09b, #00cdac);
      border-radius: 6px;
      transition: width 0.3s ease;
    }

    .points-needed {
      text-align: center;
      font-size: 12px;
      color: #666;
    }

    /* Transaction History */
    .transaction-history-card {
      background: white;
      border-radius: 20px;
      padding: 24px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      border: 2px solid #f0f0f0;
    }

    .section-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 24px;
      padding-bottom: 16px;
      border-bottom: 2px solid #f0f0f0;
    }

    .section-title {
      font-size: 20px;
      font-weight: 700;
      color: #333;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .filter-select {
      padding: 10px 16px;
      border: 2px solid #f0f0f0;
      border-radius: 12px;
      font-size: 14px;
      background: white;
      cursor: pointer;
      font-weight: 500;
      transition: all 0.2s ease;
    }

    .filter-select:focus {
      outline: none;
      border-color: #00b09b;
    }

    /* Transaction Cards */
    .transaction-card {
      background: #f8f9fa;
      border: 2px solid #f0f0f0;
      border-radius: 16px;
      padding: 20px;
      margin-bottom: 16px;
      cursor: pointer;
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
    }

    .transaction-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 4px;
      height: 100%;
      background: linear-gradient(135deg, #00b09b, #00cdac);
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .transaction-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
      border-color: #00b09b;
      background: white;
    }

    .transaction-card:hover::before {
      opacity: 1;
    }

    .transaction-card.earn {
      border-left: 4px solid #28a745;
    }

    .transaction-card.spend {
      border-left: 4px solid #17a2b8;
    }

    .transaction-card.receipt-based {
      border-left: 4px solid #6f42c1;
    }

    .transaction-card.qr-based {
      border-left: 4px solid #fd7e14;
    }

    .transaction-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 12px;
    }

    .transaction-type {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 16px;
      font-weight: 600;
    }

    .transaction-type.earn {
      color: #28a745;
    }

    .transaction-type.spend {
      color: #17a2b8;
    }

    .transaction-points {
      font-size: 20px;
      font-weight: 700;
    }

    .transaction-points.earn {
      color: #dc3545;
    }

    .transaction-points.spend {
      color: #17a2b8;
    }

    .transaction-details {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 12px;
      margin-bottom: 12px;
    }

    .detail-item {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 14px;
      color: #666;
    }

    .detail-icon {
      font-size: 16px;
      opacity: 0.7;
    }

    .transaction-meta {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding-top: 12px;
      border-top: 1px solid #e9ecef;
      font-size: 12px;
      color: #999;
    }

    .transaction-id {
      font-family: monospace;
      background: #e9ecef;
      padding: 2px 6px;
      border-radius: 4px;
    }

    /* Empty State */
    .empty-state {
      text-align: center;
      padding: 60px 24px;
    }

    .empty-icon {
      font-size: 64px;
      margin-bottom: 20px;
      opacity: 0.5;
    }

    .empty-title {
      font-size: 20px;
      font-weight: 600;
      color: #333;
      margin-bottom: 12px;
    }

    .empty-text {
      font-size: 16px;
      color: #666;
      margin-bottom: 32px;
      line-height: 1.5;
    }

    .empty-action {
      display: inline-block;
      background: linear-gradient(135deg, #00b09b, #00cdac);
      color: white;
      padding: 12px 24px;
      border-radius: 12px;
      text-decoration: none;
      font-weight: 600;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(0, 176, 155, 0.3);
    }

    .empty-action:hover {
      background: linear-gradient(135deg, #009688, #00b09b);
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(0, 176, 155, 0.4);
      color: white;
      text-decoration: none;
    }

    /* Pagination */
    .pagination-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 24px;
      padding-top: 16px;
      border-top: 1px solid #e9ecef;
    }

    .pagination-info {
      font-size: 14px;
      color: #666;
    }

    .load-more {
      background: linear-gradient(135deg, #00b09b, #00cdac);
      color: white;
      padding: 10px 20px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
      transition: all 0.3s ease;
      box-shadow: 0 2px 8px rgba(0, 176, 155, 0.3);
    }

    .load-more:hover {
      background: linear-gradient(135deg, #009688, #00b09b);
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(0, 176, 155, 0.4);
      color: white;
      text-decoration: none;
    }

    /* Export Button */
    .export-btn {
      background: linear-gradient(135deg, #6c757d, #5a6268);
      color: white;
      padding: 10px 16px;
      border: none;
      border-radius: 8px;
      font-size: 12px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 6px;
      text-decoration: none;
      box-shadow: 0 2px 8px rgba(108, 117, 125, 0.3);
    }

    .export-btn:hover {
      background: linear-gradient(135deg, #5a6268, #545b62);
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(108, 117, 125, 0.4);
      color: white;
      text-decoration: none;
    }

    /* Alert Messages */
    .alert {
      padding: 16px 20px;
      border-radius: 12px;
      margin-bottom: 24px;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .alert-success {
      background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
      color: #047857;
      border: 1px solid rgba(4, 120, 87, 0.2);
    }

    .alert-error {
      background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
      color: #dc2626;
      border: 1px solid rgba(220, 38, 38, 0.2);
    }

    /* Modal Styles */
    .transaction-modal {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(0, 0, 0, 0.8);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 9999;
      padding: 20px;
      opacity: 0;
      visibility: hidden;
      transition: all 0.3s ease;
    }

    .transaction-modal.active {
      opacity: 1;
      visibility: visible;
    }

    .modal-content {
      background: white;
      border-radius: 20px;
      max-width: 600px;
      width: 100%;
      max-height: 90vh;
      overflow-y: auto;
      box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
      transform: scale(0.9);
      transition: transform 0.3s ease;
    }

    .transaction-modal.active .modal-content {
      transform: scale(1);
    }

    .modal-header {
      background: linear-gradient(135deg, #00b09b, #00cdac);
      color: white;
      padding: 24px 32px;
      border-radius: 20px 20px 0 0;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .modal-title {
      font-size: 20px;
      font-weight: 600;
      margin: 0;
    }

    .modal-close {
      background: none;
      border: none;
      color: white;
      font-size: 24px;
      cursor: pointer;
      padding: 4px;
      border-radius: 50%;
      width: 36px;
      height: 36px;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.2s ease;
    }

    .modal-close:hover {
      background: rgba(255, 255, 255, 0.2);
    }

    .modal-body {
      padding: 32px;
    }

    .modal-section {
      margin-bottom: 24px;
      padding-bottom: 16px;
      border-bottom: 1px solid #f0f0f0;
    }

    .modal-section:last-child {
      border-bottom: none;
      margin-bottom: 0;
    }

    .modal-section-title {
      font-size: 16px;
      font-weight: 600;
      color: #333;
      margin-bottom: 12px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .modal-detail-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px;
    }

    .modal-detail-item {
      display: flex;
      flex-direction: column;
      gap: 4px;
    }

    .modal-detail-label {
      font-size: 12px;
      color: #666;
      font-weight: 600;
      text-transform: uppercase;
    }

    .modal-detail-value {
      font-size: 14px;
      color: #333;
      font-weight: 500;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
      .main-content {
        padding: 16px 12px;
      }

      .stats-grid {
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 16px;
      }

      .transaction-details {
        grid-template-columns: 1fr;
        gap: 8px;
      }

      .modal-detail-grid {
        grid-template-columns: 1fr;
        gap: 12px;
      }
    }

    @media (max-width: 480px) {
      .header-content {
        flex-direction: column;
        gap: 16px;
        text-align: center;
      }

      .header-left {
        justify-content: center;
      }

      .app-title {
        font-size: 20px;
      }

      .business-profile-card {
        padding: 24px 16px;
      }

      .business-name {
        font-size: 24px;
      }

      .stats-grid {
        grid-template-columns: 1fr;
      }

      .modal-content {
        margin: 10px;
        max-height: 95vh;
      }

      .modal-header {
        padding: 20px 24px;
      }

      .modal-body {
        padding: 24px;
      }
    }

    .fade-in {
      animation: fadeIn 0.6s ease-out;
    }

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
  </style>

  <div class="dashboard-container">
    <!-- Header -->
    <header class="dashboard-header">
      <div class="header-content">
        <div class="header-left">
          <a href="{{ route('dashboard') }}" class="header-back-btn">
            ←
          </a>
          <div class="header-title-section">
            <h1 class="app-title">💼 Business Account</h1>
            <p class="app-subtitle">Manage your account details and view transaction history</p>
          </div>
        </div>
        <a href="{{ route('dashboard') }}" class="back-button">
          ← Back to Dashboard
        </a>
      </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
      <!-- Alerts -->
      @if (session('success'))
        <div class="alert alert-success fade-in">
          ✅ {{ session('success') }}
        </div>
      @endif

      @if (session('error'))
        <div class="alert alert-error fade-in">
          ❌ {{ session('error') }}
        </div>
      @endif

      <!-- Business Profile Card -->
      <div class="business-profile-card fade-in">
        <div class="profile-picture-input-wrapper">
          <div class="profile-avatar" {{-- onclick="document.getElementById('profilePictureInput').click();" --}}>
            <img src="{{ $seller->photo_url }}" alt="Profile" style="display: none;">
            {{-- <span id="profileInitials">{{ substr($seller->business_name, 0, 2) }}</span> --}}
            {{-- <div class="profile-overlay">
              <div class="overlay-content">
                <div class="overlay-icon">📷</div>
                <div class="overlay-text">Change Photo</div>
              </div>
            </div> --}}
            {{-- <input type="file" id="profilePictureInput" class="profile-file-input" accept="image/*"> --}}
          </div>
        </div>

        <div class="upload-instructions">
          <span>📤</span>
          <span>Click on the avatar to upload a profile picture (JPG, PNG, max 5MB)</span>
        </div>

        <form action="{{ route('seller.photo.update') }}" method="POST" enctype="multipart/form-data">
          @csrf

          <input type="file" name="image" accept="image/*">
          <button type="submit" class="btn btn-secondary">Save</button>
        </form>
        <h2 class="business-name">{{ $seller->business_name }}</h2>
        <p class="business-email">{{ $seller->email }}</p>

        <div class="rank-badge-container">
          <div class="rank-badge {{ strtolower($currentRank->name) }}">
            <span class="rank-icon">
              @switch($currentRank->name)
                @case('Platinum')
                  💎
                @break

                @case('Gold')
                  🏆
                @break

                @case('Silver')
                  🥈
                @break

                @case('Bronze')
                  🥉
                @break

                @default
                  ⭐
              @endswitch
            </span>
            <span class="rank-name">{{ $currentRank->name }} Seller</span>
          </div>
        </div>
      </div>

      <!-- Stats Grid -->
      <div class="stats-grid fade-in">
        <div class="stat-card">
          <span class="stat-icon">🏆</span>
          <div class="stat-value">{{ number_format($totalRankPoints) }}</div>
          <div class="stat-label">Total Rank Points</div>
        </div>
        <div class="stat-card">
          <span class="stat-icon">📤</span>
          <div class="stat-value">{{ number_format($pointsGiven) }}</div>
          <div class="stat-label">Points Given</div>
        </div>
        <div class="stat-card">
          <span class="stat-icon">📥</span>
          <div class="stat-value">{{ number_format($pointsFromRedemptions) }}</div>
          <div class="stat-label">From Redemptions</div>
        </div>
        <div class="stat-card">
          <span class="stat-icon">👥</span>
          <div class="stat-value">{{ number_format($totalCustomers) }}</div>
          <div class="stat-label">Total Customers</div>
        </div>
      </div>

      <!-- Rank Progress -->
      @if ($nextRank)
        <div class="rank-progress-card fade-in">
          <h3 class="rank-progress-title">🎯 Progress to {{ $nextRank->name }}</h3>
          <div class="rank-progress-info">
            <span class="current-rank">{{ $currentRank->name }}</span>
            <span class="next-rank">{{ $nextRank->name }}</span>
          </div>
          <div class="progress-bar-container">
            <div class="progress-bar-fill"
              style="width: {{ min(100, (($totalRankPoints - $currentRank->min_points) / ($nextRank->min_points - $currentRank->min_points)) * 100) }}%"></div>
          </div>
          <div class="points-needed">{{ number_format($pointsToNext) }} points needed to reach {{ $nextRank->name }}</div>
        </div>
      @endif

      <!-- Transaction History -->
      <div class="transaction-history-card fade-in">
        <div class="section-header">
          <h3 class="section-title">
            📊 Transaction History
          </h3>
          <div style="display: flex; gap: 12px; align-items: center;">
            <button class="export-btn" onclick="exportTransactions()">
              📊 Export CSV
            </button>
            <select class="filter-select" onchange="filterTransactions(this.value)">
              <option value="all" {{ $filter == 'all' ? 'selected' : '' }}>All Transactions</option>
              <option value="earn" {{ $filter == 'earn' ? 'selected' : '' }}>Points Given</option>
              <option value="spend" {{ $filter == 'spend' ? 'selected' : '' }}>Redemptions</option>
            </select>
          </div>
        </div>

        @forelse($transactions as $transaction)
          <div class="transaction-card {{ $transaction->type }}" onclick="showTransactionModal({{ json_encode($transaction) }})">
            <div class="transaction-header">
              <div class="transaction-type {{ $transaction->type }}">
                @if ($transaction->type === 'earn')
                  @if ($transaction->receipt_code)
                    🧾 Receipt Transaction
                  @else
                    📤 Points Given
                  @endif
                @else
                  📥 Points Redeemed
                @endif
              </div>
              <div class="transaction-points {{ $transaction->type }}">
                @if ($transaction->type === 'earn')
                  -{{ number_format($transaction->points) }}
                @else
                  +{{ number_format($transaction->points) }}
                @endif
              </div>
            </div>

            <div class="transaction-details">
              <div class="detail-item">
                <span class="detail-icon">👤</span>
                <span>{{ $transaction->consumer_name ?? 'Customer #' . $transaction->consumer_id }}</span>
              </div>
              <div class="detail-item">
                <span class="detail-icon">📦</span>
                <span>
                  @if ($transaction->item_name)
                    {{ $transaction->item_name }}
                  @elseif(isset($transaction->extracted_items))
                    {{ $transaction->extracted_items }}
                  @elseif($transaction->description && str_contains($transaction->description, 'Purchased:'))
                    @php
                      // Extract items from description like "Purchased: Coffee, Food Container from..."
                      $desc = $transaction->description;
                      if (preg_match('/Purchased:\s*([^f]+?)\s+from/i', $desc, $matches)) {
                          $items = trim($matches[1]);
                          echo strlen($items) > 30 ? substr($items, 0, 30) . '...' : $items;
                      } else {
                          echo 'Receipt Items';
                      }
                    @endphp
                  @elseif($transaction->receipt_code)
                    Receipt #{{ $transaction->receipt_code }}
                  @elseif($transaction->qr_code_id)
                    Item #{{ $transaction->qr_code_id }}
                  @else
                    Direct Transaction
                  @endif
                </span>
              </div>
              <div class="detail-item">
                <span class="detail-icon">🔢</span>
                <span>{{ $transaction->units_scanned ?? 1 }} units scanned</span>
              </div>
              <div class="detail-item">
                <span class="detail-icon">⚡</span>
                <span>
                  @if ($transaction->points_per_unit)
                    {{ $transaction->points_per_unit }} pts/unit
                  @else
                    {{ number_format($transaction->points / ($transaction->units_scanned ?? 1), 1) }} pts/unit
                  @endif
                </span>
              </div>
            </div>

            <div class="transaction-meta">
              <span class="transaction-id">ID: {{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}</span>
              <span>{{ \Carbon\Carbon::parse($transaction->scanned_at ?? $transaction->created_at)->format('M d, Y • h:i A') }}</span>
            </div>
          </div>
        @empty
          <div class="empty-state">
            <div class="empty-icon">📊</div>
            <h3 class="empty-title">No transactions yet</h3>
            <p class="empty-text">Start scanning customer QR codes to see your transaction history and earn rank points!</p>
            <a href="{{ route('seller.scanner') }}" class="empty-action">
              📱 Open QR Scanner
            </a>
          </div>
        @endforelse

        @if ($transactions->count() > 0)
          <div class="pagination-container">
            <div class="pagination-info">
              Showing {{ $transactions->count() }} of {{ $transactions->total() }} transactions
            </div>
            @if ($transactions->hasMorePages())
              <a href="{{ $transactions->nextPageUrl() }}" class="load-more">
                Load More →
              </a>
            @endif
          </div>
        @endif
      </div>
    </main>
  </div>

  <!-- Transaction Detail Modal -->
  <div id="transactionModal" class="transaction-modal" onclick="closeTransactionModal(event)">
    <div class="modal-content" onclick="event.stopPropagation()">
      <div class="modal-header">
        <h3 class="modal-title">📧 Transaction Details</h3>
        <button class="modal-close" onclick="closeTransactionModal()">×</button>
      </div>

      <div class="modal-body">
        <!-- Transaction Summary -->
        <div class="modal-section">
          <h4 class="modal-section-title">💳 Transaction Summary</h4>
          <div class="modal-detail-grid">
            <div class="modal-detail-item">
              <span class="modal-detail-label">Transaction ID</span>
              <span class="modal-detail-value" id="modalTransactionId">-</span>
            </div>
            <div class="modal-detail-item">
              <span class="modal-detail-label">Type</span>
              <span class="modal-detail-value" id="modalTransactionType">-</span>
            </div>
            <div class="modal-detail-item">
              <span class="modal-detail-label">Points</span>
              <span class="modal-detail-value" id="modalPoints">-</span>
            </div>
            <div class="modal-detail-item">
              <span class="modal-detail-label">Date & Time</span>
              <span class="modal-detail-value" id="modalDateTime">-</span>
            </div>
          </div>
        </div>

        <!-- Customer Information -->
        <div class="modal-section">
          <h4 class="modal-section-title">👤 Customer Information</h4>
          <div class="modal-detail-grid">
            <div class="modal-detail-item">
              <span class="modal-detail-label">Customer Name</span>
              <span class="modal-detail-value" id="modalCustomerName">-</span>
            </div>
            <div class="modal-detail-item">
              <span class="modal-detail-label">Customer ID</span>
              <span class="modal-detail-value" id="modalCustomerId">-</span>
            </div>
          </div>
        </div>

        <!-- Item Details -->
        <div class="modal-section">
          <h4 class="modal-section-title">📦 Item Details</h4>
          <div class="modal-detail-grid">
            <div class="modal-detail-item">
              <span class="modal-detail-label">Item Name</span>
              <span class="modal-detail-value" id="modalItemName">-</span>
            </div>
            <div class="modal-detail-item">
              <span class="modal-detail-label">Quantity Scanned</span>
              <span class="modal-detail-value" id="modalUnitsScanned">-</span>
            </div>
            <div class="modal-detail-item">
              <span class="modal-detail-label">Points Per Unit</span>
              <span class="modal-detail-value" id="modalPointsPerUnit">-</span>
            </div>
            <div class="modal-detail-item">
              <span class="modal-detail-label">Total Points</span>
              <span class="modal-detail-value" id="modalTotalPoints">-</span>
            </div>
            <div class="modal-detail-item">
              <span class="modal-detail-label">QR Code ID</span>
              <span class="modal-detail-value" id="modalQRCodeId">-</span>
            </div>
            <div class="modal-detail-item">
              <span class="modal-detail-label">Receipt Code</span>
              <span class="modal-detail-value" id="modalReceiptCode">-</span>
            </div>
            <div class="modal-detail-item">
              <span class="modal-detail-label">Transaction Source</span>
              <span class="modal-detail-value" id="modalTransactionSource">-</span>
            </div>
            <div class="modal-detail-item">
              <span class="modal-detail-label">Transaction Description</span>
              <span class="modal-detail-value" id="modalDescription">-</span>
            </div>
          </div>
        </div>

        <!-- Impact Information -->
        <div class="modal-section">
          <h4 class="modal-section-title">🏆 Business Impact</h4>
          <div class="modal-detail-grid">
            <div class="modal-detail-item">
              <span class="modal-detail-label">Rank Points Impact</span>
              <span class="modal-detail-value" id="modalRankImpact">-</span>
            </div>
            <div class="modal-detail-item">
              <span class="modal-detail-label">Current Total Points</span>
              <span class="modal-detail-value">{{ number_format($totalRankPoints) }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Show transaction modal
    function showTransactionModal(transaction) {
      // Debug: Log the transaction data to see what we're getting
      console.log('Transaction data:', transaction);
      console.log('QR Code ID:', transaction.qr_code_id);
      console.log('Receipt Code:', transaction.receipt_code);
      console.log('Description:', transaction.description);

      // Populate modal fields
      document.getElementById('modalTransactionId').textContent = '#' + String(transaction.id).padStart(6, '0');

      // Determine transaction type display
      let transactionType = 'Points Given';
      if (transaction.type === 'earn') {
        if (transaction.receipt_code) {
          transactionType = 'Receipt Transaction';
        } else {
          transactionType = 'Points Given';
        }
      } else {
        transactionType = 'Points Redeemed';
      }
      document.getElementById('modalTransactionType').textContent = transactionType;
      document.getElementById('modalPoints').textContent = (transaction.type === 'earn' ? '-' : '+') + transaction.points + ' points';
      document.getElementById('modalDateTime').textContent = new Date(transaction.scanned_at || transaction.created_at).toLocaleString();

      document.getElementById('modalCustomerName').textContent = transaction.consumer_name || 'Customer #' + transaction.consumer_id;
      document.getElementById('modalCustomerId').textContent = '#' + String(transaction.consumer_id).padStart(6, '0');

      // Handle item information with better fallbacks
      let itemName = 'Direct Transaction';
      if (transaction.item_name) {
        itemName = transaction.item_name;
      } else if (transaction.extracted_items) {
        // Use pre-extracted items from controller
        itemName = transaction.extracted_items;
      } else if (transaction.description && transaction.description.includes('Purchased:')) {
        // Extract items from description like "Purchased: Coffee, Food Container from..."
        const match = transaction.description.match(/Purchased:\s*([^f]+?)\s+from/i);
        if (match && match[1]) {
          itemName = match[1].trim();
        } else {
          itemName = 'Receipt Items';
        }
      } else if (transaction.receipt_code) {
        itemName = 'Receipt #' + transaction.receipt_code;
      } else if (transaction.qr_code_id) {
        itemName = 'Item #' + transaction.qr_code_id;
      }
      document.getElementById('modalItemName').textContent = itemName;

      // Show quantity with clear labeling
      const quantity = transaction.units_scanned || 1;
      document.getElementById('modalUnitsScanned').textContent = quantity + ' unit' + (quantity > 1 ? 's' : '');

      // Calculate and show points per unit
      let pointsPerUnit = 0;
      if (transaction.points_per_unit) {
        pointsPerUnit = transaction.points_per_unit;
      } else if (transaction.points && quantity) {
        pointsPerUnit = Math.round((transaction.points / quantity) * 10) / 10; // Round to 1 decimal
      }
      document.getElementById('modalPointsPerUnit').textContent = pointsPerUnit + ' points/unit';

      document.getElementById('modalTotalPoints').textContent = transaction.points + ' points';
      document.getElementById('modalQRCodeId').textContent = transaction.qr_code_id ? '#' + transaction.qr_code_id : 'N/A';

      // Handle receipt code with better fallback
      let receiptCode = 'N/A';
      let transactionSource = 'Unknown';

      if (transaction.receipt_code) {
        receiptCode = transaction.receipt_code;
        transactionSource = 'Receipt System';
      } else if (transaction.qr_code_id) {
        transactionSource = 'QR Code Scan';
      } else if (transaction.description && transaction.description.includes('from ')) {
        // Generate a pseudo receipt code from description for old transactions
        const match = transaction.description.match(/from\s+(.+?)$/i);
        if (match) {
          const location = match[1].trim();
          receiptCode = 'LEGACY_' + String(transaction.id).padStart(6, '0');
          transactionSource = 'Legacy Transaction (' + location + ')';
        } else {
          transactionSource = 'Legacy Direct Entry';
        }
      } else {
        transactionSource = 'Direct Entry';
      }

      document.getElementById('modalReceiptCode').textContent = receiptCode;
      document.getElementById('modalTransactionSource').textContent = transactionSource;

      document.getElementById('modalDescription').textContent = transaction.description || 'No description available';

      document.getElementById('modalRankImpact').textContent = '+' + transaction.points + ' points';

      // Show modal
      document.getElementById('transactionModal').classList.add('active');
      document.body.style.overflow = 'hidden';
    }

    // Close transaction modal
    function closeTransactionModal(event) {
      if (!event || event.target === document.getElementById('transactionModal')) {
        document.getElementById('transactionModal').classList.remove('active');
        document.body.style.overflow = 'auto';
      }
    }

    // Filter transactions
    function filterTransactions(type) {
      const url = new URL(window.location);
      url.searchParams.set('filter', type);
      window.location.href = url.toString();
    }

    // Export transactions
    function exportTransactions() {
      const url = new URL('{{ route('seller.account.export') }}', window.location.origin);

      // Add current filter if any
      const currentFilter = new URLSearchParams(window.location.search).get('filter');
      if (currentFilter && currentFilter !== 'all') {
        url.searchParams.set('filter', currentFilter);
      }

      window.location.href = url.toString();
    }

    // Initialize animations
    document.addEventListener('DOMContentLoaded', function() {
      // Add fade-in animation to elements
      const fadeElements = document.querySelectorAll('.fade-in');
      fadeElements.forEach((el, index) => {
        el.style.opacity = '0';
        setTimeout(() => {
          el.style.opacity = '1';
        }, index * 100);
      });

      // Keyboard shortcuts
      document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
          closeTransactionModal();
        }
      });

      console.log('Account page initialized');
    });
  </script>

@endsection
