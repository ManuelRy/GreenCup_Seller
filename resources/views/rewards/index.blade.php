@extends('master')

@section('content')
  <style>
    /* Reset and Base Styles */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
      background: linear-gradient(135deg, #00b09b 0%, #00cdac 50%, #00dfa8 100%);
      min-height: 100vh;
      color: #333333;
    }

    .rewards-container {
      min-height: 100vh;
      padding: 20px;
    }

    /* Header */
    .header {
      background: #374151;
      padding: 20px;
      margin: -20px -20px 30px -20px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .header-content {
      max-width: 1200px;
      margin: 0 auto;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .header-title {
      color: white;
      font-size: 24px;
      font-weight: 700;
    }

    .back-btn {
      background: linear-gradient(135deg, #6b7280, #4b5563);
      color: white;
      text-decoration: none;
      padding: 10px 20px;
      border-radius: 8px;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .back-btn:hover {
      background: linear-gradient(135deg, #4b5563, #374151);
      transform: translateY(-1px);
      color: white;
      text-decoration: none;
    }

    /* Alert Messages */
    .alert {
      padding: 15px 20px;
      border-radius: 8px;
      margin-bottom: 20px;
      font-weight: 600;
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

    /* Page Header */
    .page-header {
      background: white;
      padding: 30px;
      border-radius: 16px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      margin-bottom: 30px;
      text-align: center;
    }

    .page-title {
      font-size: 32px;
      font-weight: 700;
      color: #1f2937;
      margin-bottom: 10px;
    }

    .page-subtitle {
      color: #6b7280;
      font-size: 18px;
      margin-bottom: 25px;
    }

    .create-btn {
      background: linear-gradient(135deg, #10b981, #059669);
      color: white;
      text-decoration: none;
      padding: 14px 28px;
      border-radius: 10px;
      font-size: 16px;
      font-weight: 600;
      transition: all 0.3s ease;
      display: inline-block;
    }

    .create-btn:hover {
      background: linear-gradient(135deg, #059669, #047857);
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
      color: white;
      text-decoration: none;
    }

    /* Stats Cards */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
      margin-bottom: 30px;
    }

    .stat-card {
      background: white;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .stat-number {
      font-size: 32px;
      font-weight: 700;
      color: #059669;
    }

    .stat-label {
      color: #6b7280;
      font-size: 14px;
      margin-top: 5px;
    }

    /* Rewards Grid */
    .rewards-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 25px;
      margin-bottom: 30px;
    }

    .reward-card {
      background: white;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
    }

    .reward-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    }

    .reward-image {
      width: 100%;
      height: 200px;
      background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 48px;
      color: #9ca3af;
    }

    .reward-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .reward-content {
      padding: 20px;
    }

    .reward-name {
      font-size: 18px;
      font-weight: 700;
      color: #1f2937;
      margin-bottom: 8px;
    }

    .reward-description {
      color: #6b7280;
      font-size: 14px;
      margin-bottom: 15px;
      line-height: 1.5;
    }

    .reward-details {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 15px;
      margin-bottom: 15px;
    }

    .detail-item {
      text-align: center;
    }

    .detail-label {
      font-size: 12px;
      color: #6b7280;
      text-transform: uppercase;
      font-weight: 600;
      margin-bottom: 4px;
    }

    .detail-value {
      font-size: 16px;
      font-weight: 700;
      color: #1f2937;
    }

    .points-value {
      color: #059669;
    }

    .quantity-value {
      color: #dc2626;
    }

    .reward-status {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 15px;
    }

    .status-badge {
      padding: 4px 12px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 600;
      text-transform: uppercase;
    }

    .status-active {
      background: #d1fae5;
      color: #065f46;
    }

    .status-inactive {
      background: #fee2e2;
      color: #991b1b;
    }

    .status-expired {
      background: #fef3c7;
      color: #92400e;
    }

    .reward-dates {
      font-size: 12px;
      color: #6b7280;
      margin-bottom: 15px;
    }

    .reward-actions {
      display: flex;
      gap: 10px;
    }

    .edit-btn {
      flex: 1;
      background: linear-gradient(135deg, #3b82f6, #2563eb);
      color: white;
      text-decoration: none;
      padding: 10px 16px;
      border-radius: 8px;
      font-size: 14px;
      font-weight: 600;
      text-align: center;
      transition: all 0.3s ease;
    }

    .edit-btn:hover {
      background: linear-gradient(135deg, #2563eb, #1d4ed8);
      transform: translateY(-1px);
      color: white;
      text-decoration: none;
    }

    /* Empty State */
    .empty-state {
      text-align: center;
      padding: 60px 20px;
      background: white;
      border-radius: 16px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .empty-icon {
      font-size: 64px;
      color: #d1d5db;
      margin-bottom: 20px;
    }

    .empty-title {
      font-size: 24px;
      font-weight: 700;
      color: #1f2937;
      margin-bottom: 10px;
    }

    .empty-subtitle {
      color: #6b7280;
      margin-bottom: 30px;
    }

    /* Pagination */
    .pagination-wrapper {
      display: flex;
      justify-content: center;
      margin-top: 30px;
    }

    .pagination {
      display: flex;
      gap: 8px;
    }

    .pagination .page-link {
      padding: 8px 12px;
      background: white;
      border: 1px solid #d1d5db;
      border-radius: 6px;
      color: #374151;
      text-decoration: none;
      transition: all 0.3s ease;
    }

    .pagination .page-link:hover {
      background: #f3f4f6;
      border-color: #9ca3af;
    }

    .pagination .page-item.active .page-link {
      background: #059669;
      border-color: #059669;
      color: white;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .header-content {
        flex-direction: column;
        gap: 15px;
        text-align: center;
      }

      .rewards-grid {
        grid-template-columns: 1fr;
      }

      .stats-grid {
        grid-template-columns: repeat(2, 1fr);
      }

      .reward-details {
        grid-template-columns: 1fr;
        gap: 10px;
      }
    }
  </style>

  <div class="rewards-container">
    <!-- Header -->
    <div class="header">
      <div class="header-content">
        <h1 class="header-title">🎁 Rewards Management</h1>
        <a href="{{ route('dashboard') }}" class="back-btn">← Back to Dashboard</a>
      </div>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
      <div class="alert alert-success">
        ✅ {{ session('success') }}
      </div>
    @endif

    @if (session('error'))
      <div class="alert alert-error">
        ❌ {{ session('error') }}
      </div>
    @endif

    <!-- Page Header -->
    <div class="page-header">
      <h2 class="page-title">Your Rewards</h2>
      <p class="page-subtitle">Create and manage rewards that customers can redeem with their points</p>
      <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
        <a href="{{ route('reward.create') }}" class="create-btn">
          ➕ Create New Reward
        </a>
        <a href="{{ route('reward.redemptions') }}" class="create-btn" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
          🎁 Manage Redemptions
        </a>
      </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-number">{{ $rewards->total() }}</div>
        <div class="stat-label">Total Rewards</div>
      </div>
      <div class="stat-card">
        <div class="stat-number">{{ $rewards->where('is_active', true)->count() }}</div>
        <div class="stat-label">Active Rewards</div>
      </div>
      <div class="stat-card">
        <div class="stat-number">{{ $rewards->sum('quantity_redeemed') }}</div>
        <div class="stat-label">Total Redeemed</div>
      </div>
      <div class="stat-card">
        <div class="stat-number">{{ $rewards->sum('quantity') - $rewards->sum('quantity_redeemed') }}</div>
        <div class="stat-label">Available Stock</div>
      </div>
    </div>

    <!-- Rewards Grid -->
    @if ($rewards->count() > 0)
      <div class="rewards-grid">
        @foreach ($rewards as $reward)
          <div class="reward-card">
            <div class="reward-image">
              @if ($reward->image_path)
                <img src="{{ $reward->image_path }}" alt="{{ $reward->name }}">
              @else
                🎁
              @endif
            </div>

            <div class="reward-content">
              <h3 class="reward-name">{{ $reward->name }}</h3>
              @if ($reward->description)
                <p class="reward-description">{{ Str::limit($reward->description, 100) }}</p>
              @endif

              <div class="reward-details">
                <div class="detail-item">
                  <div class="detail-label">Points Required</div>
                  <div class="detail-value points-value">{{ number_format($reward->points_required) }}</div>
                </div>
                <div class="detail-item">
                  <div class="detail-label">Available</div>
                  <div class="detail-value quantity-value">{{ $reward->available_quantity }}</div>
                </div>
              </div>

              <div class="reward-status">
                @if ($reward->isValid())
                  <span class="status-badge status-active">Active</span>
                @elseif($reward->valid_until < now()->toDateString())
                  <span class="status-badge status-expired">Expired</span>
                @else
                  <span class="status-badge status-inactive">Inactive</span>
                @endif
              </div>

              <div class="reward-dates">
                Valid: {{ $reward->valid_from->format('M d') }} - {{ $reward->valid_until->format('M d, Y') }}
              </div>

              <div class="reward-actions">
                <a href="{{ route('reward.edit', $reward) }}" class="edit-btn">
                  ✏️ Edit Reward
                </a>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      <!-- Pagination -->
      @if ($rewards->hasPages())
        <div class="pagination-wrapper">
          {{ $rewards->links() }}
        </div>
      @endif
    @else
      <!-- Empty State -->
      <div class="empty-state">
        <div class="empty-icon">🎁</div>
        <h3 class="empty-title">No Rewards Yet</h3>
        <p class="empty-subtitle">Start by creating your first reward that customers can redeem with their points.</p>
        <a href="{{ route('reward.create') }}" class="create-btn">
          ➕ Create Your First Reward
        </a>
      </div>
    @endif
  </div>
@endsection
