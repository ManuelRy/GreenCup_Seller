@extends('layouts.guest')

@section('title', 'Application Rejected')

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
  content: '\f071';
  font-family: 'Font Awesome 6 Free';
  font-weight: 900;
  position: absolute;
  left: 0;
  color: #dc2626;
}

.success-box {
  background: linear-gradient(135deg, rgba(13, 148, 136, 0.1), rgba(16, 185, 129, 0.05));
  border-left: 4px solid #0d9488;
  border-radius: 12px;
  padding: 1.5rem;
  margin-bottom: 2rem;
}

.success-box strong {
  color: #0d9488;
  font-size: 1rem;
  display: block;
  margin-bottom: 0.5rem;
}

.success-box p {
  color: #374151;
  margin: 0;
  font-size: 0.95rem;
}

.btn-primary-custom {
  background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);
  border: none;
  border-radius: 10px;
  padding: 0.875rem 1.5rem;
  font-size: 1.05rem;
  font-weight: 600;
  color: white;
  width: 100%;
  transition: all 0.3s ease;
  box-shadow: 0 4px 15px rgba(13, 148, 136, 0.3);
  text-decoration: none;
  display: inline-block;
  text-align: center;
}

.btn-primary-custom:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(13, 148, 136, 0.4);
  background: linear-gradient(135deg, #0f766e 0%, #115e59 100%);
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
      <i class="fas fa-times-circle"></i>
    </div>

    <h1 class="main-title">Application Rejected</h1>
    <p class="main-description">Unfortunately, your seller application was not approved at this time</p>

    <div id="status-check-message" style="display: none; background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(13, 148, 136, 0.05)); border-left: 4px solid #10b981; border-radius: 12px; padding: 1rem; margin-bottom: 1rem; text-align: center;">
      <i class="fas fa-check-circle" style="color: #10b981; margin-right: 0.5rem;"></i>
      <strong style="color: #10b981;">Great news! Your account has been approved. Redirecting...</strong>
    </div>

    <div class="info-box">
      <strong><i class="fas fa-info-circle me-2"></i>Common rejection reasons:</strong>
      <ul>
        <li>Incomplete or inaccurate business information</li>
        <li>Business doesn't meet eligibility requirements</li>
        <li>Unable to verify business credentials</li>
        <li>Business type not supported on the platform</li>
      </ul>
    </div>

    <div class="success-box">
      <strong><i class="fas fa-redo me-2"></i>You can reapply!</strong>
      <p>If you believe this was a mistake or if you've resolved the issues, you're welcome to submit a new application. Please contact our support team to learn more about the specific reasons and how to improve your application.</p>
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
          <i class="fas fa-headset"></i>
        </div>
        <div class="info-item-label">Support Available</div>
      </div>
      <div class="info-item">
        <div class="info-item-icon">
          <i class="fas fa-sync-alt"></i>
        </div>
        <div class="info-item-label">Reapply Anytime</div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get seller email from Laravel session (passed on redirect)
    @if(session('seller_email'))
        const sellerEmail = '{{ session('seller_email') }}';
        // Store in localStorage for subsequent page refreshes
        localStorage.setItem('rejected_seller_email', sellerEmail);
    @else
        // Try to get from localStorage (for page refreshes)
        const sellerEmail = localStorage.getItem('rejected_seller_email');
    @endif

    if (!sellerEmail) {
        console.warn('No seller email found');
        return;
    }

    // Check status on page load
    checkSellerStatus();

    function checkSellerStatus() {
        fetch('{{ route("seller.check-status") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                email: sellerEmail
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.is_approved) {
                // Show success message
                document.getElementById('status-check-message').style.display = 'block';

                // Clear email from storage
                localStorage.removeItem('rejected_seller_email');

                // Redirect to login page after 2 seconds
                setTimeout(function() {
                    window.location.href = '{{ route("login") }}';
                }, 2000);
            }
        })
        .catch(error => {
            console.error('Error checking status:', error);
        });
    }
});
</script>
@endpush
