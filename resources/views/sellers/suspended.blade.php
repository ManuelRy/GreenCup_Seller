@extends('layouts.guest')

@section('title', 'Account Suspended')

@push('styles')
<style>
.review-card {
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(20px);
  border-radius: 20px;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
  overflow: hidden;
  max-width: 600px;
  width: 100%;
  margin: 0 auto;
}

.card-body-custom {
  padding: 3rem 2.5rem;
}

.status-icon {
  width: 100px;
  height: 100px;
  background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 2rem;
  border: 4px solid rgba(239, 68, 68, 0.2);
}

.status-icon i {
  font-size: 3rem;
  color: white;
}

.main-title {
  color: #dc2626;
  font-weight: 700;
  font-size: 2rem;
  margin-bottom: 1rem;
  text-align: center;
}

.main-description {
  color: #6b7280;
  font-size: 1.1rem;
  text-align: center;
  margin-bottom: 2rem;
}

.info-box {
  background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(220, 38, 38, 0.05));
  border-left: 4px solid #dc2626;
  border-radius: 12px;
  padding: 1.5rem;
  margin-bottom: 2rem;
}

.info-box strong {
  color: #dc2626;
  font-size: 1.1rem;
  display: block;
  margin-bottom: 1rem;
}

.info-box p {
  color: #374151;
  margin: 0;
  line-height: 1.6;
}

.info-box ul {
  list-style: none;
  padding: 0;
  margin: 1rem 0 0 0;
}

.info-box ul li {
  color: #374151;
  padding: 0.5rem 0;
  padding-left: 1.75rem;
  position: relative;
}

.info-box ul li::before {
  content: '\f06a';
  font-family: 'Font Awesome 6 Free';
  font-weight: 900;
  position: absolute;
  left: 0;
  color: #dc2626;
}

.warning-box {
  background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(217, 119, 6, 0.05));
  border-left: 4px solid #f59e0b;
  border-radius: 12px;
  padding: 1.5rem;
  margin-bottom: 2rem;
}

.warning-box strong {
  color: #d97706;
  font-size: 1rem;
  display: block;
  margin-bottom: 0.5rem;
}

.warning-box p {
  color: #374151;
  margin: 0;
  font-size: 0.95rem;
}

.btn-primary-custom {
  background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
  border: none;
  border-radius: 10px;
  padding: 0.875rem 1.5rem;
  font-size: 1.05rem;
  font-weight: 600;
  color: white;
  width: 100%;
  transition: all 0.3s ease;
  box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);
  text-decoration: none;
  display: inline-block;
  text-align: center;
}

.btn-primary-custom:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(220, 38, 38, 0.4);
  background: linear-gradient(135deg, #b91c1c 0%, #991b1b 100%);
  color: white;
}

.btn-secondary-custom {
  background: transparent;
  border: 2px solid #d1d5db;
  border-radius: 10px;
  padding: 0.875rem 1.5rem;
  font-size: 1.05rem;
  font-weight: 600;
  color: #6b7280;
  width: 100%;
  transition: all 0.3s ease;
  text-decoration: none;
  display: inline-block;
  text-align: center;
  margin-top: 1rem;
}

.btn-secondary-custom:hover {
  border-color: #dc2626;
  color: #dc2626;
  background: rgba(220, 38, 38, 0.05);
}

.info-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1.5rem;
  margin-top: 2rem;
  padding-top: 2rem;
  border-top: 1px solid #e5e7eb;
}

.info-item {
  text-align: center;
}

.info-item-icon {
  width: 50px;
  height: 50px;
  background: linear-gradient(135deg, rgba(220, 38, 38, 0.1), rgba(185, 28, 28, 0.05));
  border-radius: 12px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 0.75rem;
}

.info-item-icon i {
  font-size: 1.5rem;
  color: #dc2626;
}

.info-item-label {
  font-size: 0.875rem;
  font-weight: 600;
  color: #374151;
}

@media (max-width: 576px) {
  .card-body-custom {
    padding: 2.5rem 2rem;
  }

  .main-title {
    font-size: 1.75rem;
  }

  .main-description {
    font-size: 1rem;
  }

  .status-icon {
    width: 80px;
    height: 80px;
  }

  .status-icon i {
    font-size: 2.5rem;
  }

  .info-grid {
    gap: 1rem;
  }
}
</style>
@endpush

@section('content')
<div class="review-card">
  <div class="card-body-custom">
    <div class="status-icon">
      <i class="fas fa-ban"></i>
    </div>

    <h1 class="main-title">Account Suspended</h1>
    <p class="main-description">Your seller account has been temporarily suspended</p>

    <div class="info-box">
      <strong><i class="fas fa-exclamation-triangle me-2"></i>Why was my account suspended?</strong>
      <p>Your account has been suspended due to a violation of our terms of service or platform policies.</p>
      <ul>
        <li>Possible policy violations</li>
        <li>Suspicious activity detected</li>
        <li>Customer complaints or reports</li>
        <li>Failure to meet quality standards</li>
      </ul>
    </div>

    <div class="warning-box">
      <strong><i class="fas fa-lightbulb me-2"></i>What can I do?</strong>
      <p>Please contact our support team to understand the reason for suspension and learn about the appeal process. Our team will review your case and guide you on next steps.</p>
    </div>

    <a href="mailto:support@greencups.com" class="btn-primary-custom">
      <i class="fas fa-envelope me-2"></i>Contact Support Team
    </a>

    <a href="{{ route('login') }}" class="btn-secondary-custom">
      <i class="fas fa-arrow-left me-2"></i>Back to Login
    </a>

    <div class="info-grid">
      <div class="info-item">
        <div class="info-item-icon">
          <i class="fas fa-headset"></i>
        </div>
        <div class="info-item-label">Support Available</div>
      </div>
      <div class="info-item">
        <div class="info-item-icon">
          <i class="fas fa-balance-scale"></i>
        </div>
        <div class="info-item-label">Appeal Process</div>
      </div>
    </div>
  </div>
</div>
@endsection
