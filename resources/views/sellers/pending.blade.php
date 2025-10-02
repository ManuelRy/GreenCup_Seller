@extends('layouts.guest')

@section('title', 'Account Pending Approval')

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
  background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 2rem;
  border: 4px solid rgba(245, 158, 11, 0.2);
  animation: pulse 2s ease-in-out infinite;
}

@keyframes pulse {
  0%, 100% {
    box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.4);
  }
  50% {
    box-shadow: 0 0 0 20px rgba(245, 158, 11, 0);
  }
}

.status-icon i {
  font-size: 3rem;
  color: white;
}

.main-title {
  color: #0d9488;
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
  background: linear-gradient(135deg, rgba(13, 148, 136, 0.1), rgba(16, 185, 129, 0.05));
  border-left: 4px solid #0d9488;
  border-radius: 12px;
  padding: 1.5rem;
  margin-bottom: 2rem;
}

.info-box strong {
  color: #0d9488;
  font-size: 1.1rem;
  display: block;
  margin-bottom: 1rem;
}

.info-box ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.info-box ul li {
  color: #374151;
  padding: 0.5rem 0;
  padding-left: 1.75rem;
  position: relative;
}

.info-box ul li::before {
  content: '\f00c';
  font-family: 'Font Awesome 6 Free';
  font-weight: 900;
  position: absolute;
  left: 0;
  color: #0d9488;
}

.progress-steps {
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 2.5rem 0;
  padding: 0 1rem;
}

.step {
  display: flex;
  flex-direction: column;
  align-items: center;
  position: relative;
}

.step-icon {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 0.75rem;
  font-size: 1.25rem;
  transition: all 0.3s ease;
}

.step-icon.completed {
  background: linear-gradient(135deg, #10b981, #059669);
  color: white;
  box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
}

.step-icon.active {
  background: linear-gradient(135deg, #f59e0b, #d97706);
  color: white;
  box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
  animation: bounce 1s ease-in-out infinite;
}

@keyframes bounce {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-5px); }
}

.step-icon.pending {
  background: #f3f4f6;
  color: #9ca3af;
  border: 2px solid #e5e7eb;
}

.step-label {
  font-size: 0.875rem;
  font-weight: 600;
  text-align: center;
}

.step-label.completed {
  color: #10b981;
}

.step-label.active {
  color: #f59e0b;
}

.step-label.pending {
  color: #9ca3af;
}

.step-connector {
  width: 80px;
  height: 3px;
  margin: 0 1rem;
  border-radius: 2px;
  margin-bottom: 2rem;
}

.step-connector.completed {
  background: linear-gradient(90deg, #10b981, #059669);
}

.step-connector.active {
  background: linear-gradient(90deg, #f59e0b, #d97706);
}

.step-connector.pending {
  background: #e5e7eb;
}

.btn-primary-custom {
  background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
  border: none;
  border-radius: 10px;
  padding: 0.875rem 1.5rem;
  font-size: 1.05rem;
  font-weight: 600;
  color: white;
  width: 100%;
  transition: all 0.3s ease;
  box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
  text-decoration: none;
  display: inline-block;
  text-align: center;
}

.btn-primary-custom:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(245, 158, 11, 0.4);
  background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
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
  border-color: #0d9488;
  color: #0d9488;
  background: rgba(13, 148, 136, 0.05);
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
  background: linear-gradient(135deg, rgba(13, 148, 136, 0.1), rgba(16, 185, 129, 0.05));
  border-radius: 12px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 0.75rem;
}

.info-item-icon i {
  font-size: 1.5rem;
  color: #0d9488;
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

  .step-connector {
    width: 50px;
    margin: 0 0.5rem;
  }

  .step-icon {
    width: 40px;
    height: 40px;
    font-size: 1rem;
  }

  .info-grid {
    gap: 1rem;
  }
}

@media (max-width: 400px) {
  .progress-steps {
    padding: 0;
  }

  .step-connector {
    width: 30px;
    margin: 0 0.25rem;
  }

  .step-label {
    font-size: 0.75rem;
  }
}
</style>
@endpush

@section('content')
<div class="review-card">
  <div class="card-body-custom">
    <div class="status-icon">
      <i class="fas fa-hourglass-half"></i>
    </div>

    <h1 class="main-title">Account Under Review</h1>
    <p class="main-description">Your seller application is being processed by our admin team</p>

    <div class="info-box">
      <strong><i class="fas fa-info-circle me-2"></i>What's next?</strong>
      <ul>
        <li>Review typically takes 1-2 business days</li>
        <li>You'll receive an email notification once approved</li>
        <li>Access to seller dashboard will be activated</li>
      </ul>
    </div>

    <div class="progress-steps">
      <div class="step">
        <div class="step-icon completed">
          <i class="fas fa-check"></i>
        </div>
        <div class="step-label completed">Submitted</div>
      </div>

      <div class="step-connector completed"></div>

      <div class="step">
        <div class="step-icon active">
          <i class="fas fa-search"></i>
        </div>
        <div class="step-label active">Reviewing</div>
      </div>

      <div class="step-connector pending"></div>

      <div class="step">
        <div class="step-icon pending">
          <i class="fas fa-shield-alt"></i>
        </div>
        <div class="step-label pending">Approved</div>
      </div>
    </div>

    <a href="mailto:support@greencups.com" class="btn-primary-custom">
      <i class="fas fa-envelope me-2"></i>Contact Support
    </a>

    <a href="{{ route('login') }}" class="btn-secondary-custom">
      <i class="fas fa-arrow-left me-2"></i>Back to Login
    </a>

    <div class="info-grid">
      <div class="info-item">
        <div class="info-item-icon">
          <i class="fas fa-clock"></i>
        </div>
        <div class="info-item-label">1-2 Business Days</div>
      </div>
      <div class="info-item">
        <div class="info-item-icon">
          <i class="fas fa-shield-alt"></i>
        </div>
        <div class="info-item-label">Secure Process</div>
      </div>
    </div>
  </div>
</div>
@endsection
