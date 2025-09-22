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

    .redemptions-container {
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
      font-weight: 600;
      text-transform: uppercase;
    }

    /* Redemptions List */
    .redemptions-section {
      background: white;
      border-radius: 16px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }

    .section-header {
      background: linear-gradient(135deg, #374151, #1f2937);
      color: white;
      padding: 20px 30px;
      font-size: 20px;
      font-weight: 700;
    }

    .redemptions-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
      gap: 20px;
      padding: 30px;
    }

    .redemption-card {
      background: #f9fafb;
      border: 2px solid #e5e7eb;
      border-radius: 12px;
      padding: 20px;
      transition: all 0.3s ease;
    }

    .redemption-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .redemption-card.pending {
      border-color: #f59e0b;
      background: #fefce8;
    }

    .redemption-card.approved {
      border-color: #10b981;
      background: #f0fdf4;
    }

    .redemption-card.rejected {
      border-color: #ef4444;
      background: #fef2f2;
    }

    .redemption-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 15px;
    }

    .redemption-id {
      font-size: 14px;
      font-weight: 600;
      color: #6b7280;
    }

    .status-badge {
      padding: 4px 12px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 600;
      text-transform: uppercase;
    }

    .status-pending {
      background: #fbbf24;
      color: #92400e;
    }

    .status-approved {
      background: #10b981;
      color: white;
    }

    .status-rejected {
      background: #ef4444;
      color: white;
    }

    .consumer-info {
      margin-bottom: 15px;
    }

    .consumer-name {
      font-size: 18px;
      font-weight: 700;
      color: #1f2937;
      margin-bottom: 4px;
    }

    .consumer-contact {
      font-size: 14px;
      color: #6b7280;
      margin-bottom: 2px;
    }

    .reward-info {
      background: white;
      padding: 15px;
      border-radius: 8px;
      margin-bottom: 15px;
    }

    .reward-name {
      font-size: 16px;
      font-weight: 700;
      color: #1f2937;
      margin-bottom: 8px;
    }

    .reward-points {
      color: #059669;
      font-weight: 600;
      font-size: 14px;
    }

    .redemption-time {
      font-size: 12px;
      color: #6b7280;
      margin-bottom: 15px;
    }

    .redemption-actions {
      display: flex;
      gap: 10px;
    }

    .approve-btn {
      flex: 1;
      background: linear-gradient(135deg, #10b981, #059669);
      color: white;
      border: none;
      padding: 10px 16px;
      border-radius: 8px;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .approve-btn:hover {
      background: linear-gradient(135deg, #059669, #047857);
      transform: translateY(-1px);
    }

    .reject-btn {
      flex: 1;
      background: linear-gradient(135deg, #ef4444, #dc2626);
      color: white;
      border: none;
      padding: 10px 16px;
      border-radius: 8px;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .reject-btn:hover {
      background: linear-gradient(135deg, #dc2626, #b91c1c);
      transform: translateY(-1px);
    }

    .approved-info {
      background: #d1fae5;
      color: #065f46;
      padding: 10px;
      border-radius: 8px;
      font-size: 14px;
      font-weight: 600;
      text-align: center;
    }

    .empty-state {
      text-align: center;
      padding: 60px 30px;
      color: #6b7280;
    }

    .empty-icon {
      font-size: 64px;
      margin-bottom: 20px;
      opacity: 0.5;
    }

    .empty-title {
      font-size: 24px;
      font-weight: 700;
      margin-bottom: 10px;
    }

    .empty-description {
      font-size: 16px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .redemptions-container {
        padding: 10px;
      }

      .header {
        margin: -10px -10px 20px -10px;
        padding: 15px;
      }

      .header-content {
        flex-direction: column;
        gap: 15px;
        text-align: center;
      }

      .page-header {
        padding: 20px;
      }

      .page-title {
        font-size: 24px;
      }

      .page-subtitle {
        font-size: 16px;
      }

      .stats-grid {
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
      }

      .redemptions-grid {
        grid-template-columns: 1fr;
        padding: 20px;
      }

      .section-header {
        padding: 15px 20px;
        font-size: 18px;
      }
    }
  </style>

  <div class="redemptions-container">
    <!-- Header -->
    <div class="header">
      <div class="header-content">
        <h1 class="header-title">🎁 Reward Redemptions</h1>
        <a href="{{ route('reward.index') }}" class="back-btn">← Back to Rewards</a>
      </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
      <div class="alert alert-success">
        ✅ {{ session('success') }}
      </div>
    @endif

    @if(session('error'))
      <div class="alert alert-error">
        ❌ {{ session('error') }}
      </div>
    @endif

    <!-- Page Header -->
    <div class="page-header">
      <h1 class="page-title">Manage Reward Redemptions</h1>
      <p class="page-subtitle">Review and approve customer reward redemption requests</p>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-number">{{ $redemptions->where('status', 'pending')->count() }}</div>
        <div class="stat-label">Pending Requests</div>
      </div>
      <div class="stat-card">
        <div class="stat-number">{{ $redemptions->where('status', 'approved')->count() }}</div>
        <div class="stat-label">Approved Today</div>
      </div>
      <div class="stat-card">
        <div class="stat-number">{{ $redemptions->count() }}</div>
        <div class="stat-label">Total Requests</div>
      </div>
    </div>

    <!-- Redemptions List -->
    <div class="redemptions-section">
      <div class="section-header">
        📋 Redemption Requests
      </div>

      @if($redemptions->count() > 0)
        <div class="redemptions-grid">
          @foreach($redemptions as $redemption)
            <div class="redemption-card {{ $redemption->status }}">
              <!-- Redemption Header -->
              <div class="redemption-header">
                <span class="redemption-id">#{{ str_pad($redemption->id, 4, '0', STR_PAD_LEFT) }}</span>
                <span class="status-badge status-{{ $redemption->status }}">
                  {{ ucfirst($redemption->status) }}
                </span>
              </div>

              <!-- Consumer Information -->
              <div class="consumer-info">
                <div class="consumer-name">{{ $redemption->consumer_name }}</div>
                <div class="consumer-contact">📧 {{ $redemption->consumer_email }}</div>
                <div class="consumer-contact">📱 {{ $redemption->consumer_phone }}</div>
              </div>

              <!-- Reward Information -->
              <div class="reward-info">
                <div class="reward-name">{{ $redemption->reward_name }}</div>
                <div class="reward-points">💎 {{ $redemption->points_required }} points required</div>
              </div>

              <!-- Request Time -->
              <div class="redemption-time">
                🕒 Requested {{ $redemption->requested_at->diffForHumans() }}
              </div>

              <!-- Actions -->
              @if($redemption->status === 'pending')
                <div class="redemption-actions">
                  <form method="POST" action="{{ route('reward.redemptions.approve', $redemption->id) }}" style="flex: 1;">
                    @csrf
                    <button type="submit" class="approve-btn" onclick="return confirm('Are you sure you want to approve this redemption?')">
                      ✅ Approve
                    </button>
                  </form>
                  <form method="POST" action="{{ route('reward.redemptions.reject', $redemption->id) }}" style="flex: 1;">
                    @csrf
                    <button type="submit" class="reject-btn" onclick="return confirm('Are you sure you want to reject this redemption?')">
                      ❌ Reject
                    </button>
                  </form>
                </div>
              @elseif($redemption->status === 'approved')
                <div class="approved-info">
                  ✅ Approved {{ isset($redemption->approved_at) ? $redemption->approved_at->diffForHumans() : 'recently' }}
                </div>
              @else
                <div class="approved-info" style="background: #fee2e2; color: #991b1b;">
                  ❌ Rejected
                </div>
              @endif
            </div>
          @endforeach
        </div>
      @else
        <div class="empty-state">
          <div class="empty-icon">🎁</div>
          <h3 class="empty-title">No Redemption Requests Yet</h3>
          <p class="empty-description">When customers request to redeem rewards, they will appear here for your approval.</p>
        </div>
      @endif
    </div>
  </div>
@endsection
