@extends('layouts.guest')

@section('title', 'Login - Green Cup App')

@push('styles')
<style>
.login-card {
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(20px);
  border-radius: 20px;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
  overflow: hidden;
  max-width: 480px;
  width: 100%;
  margin: 0 auto;
}

.card-header-custom {
  background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);
  padding: 2.5rem 2rem;
  text-align: center;
  border: none;
}

.logo-circle {
  width: 80px;
  height: 80px;
  background: rgba(255, 255, 255, 0.2);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 1.5rem;
  border: 3px solid rgba(255, 255, 255, 0.3);
}

.logo-circle i {
  font-size: 2.5rem;
  color: white;
}

.card-header-custom h2 {
  color: white;
  font-weight: 700;
  font-size: 1.75rem;
  margin-bottom: 0.5rem;
}

.card-header-custom p {
  color: rgba(255, 255, 255, 0.9);
  font-size: 1rem;
  margin-bottom: 0;
}

.card-body-custom {
  padding: 2.5rem 2rem;
}

.form-label {
  font-weight: 600;
  color: #374151;
  margin-bottom: 0.5rem;
  font-size: 0.95rem;
}

.input-wrapper {
  position: relative;
  margin-bottom: 1.25rem;
}

.input-icon {
  position: absolute;
  left: 1rem;
  top: 50%;
  transform: translateY(-50%);
  color: #9ca3af;
  font-size: 1.1rem;
  pointer-events: none;
  transition: color 0.3s ease;
}

.form-control {
  border: 2px solid #e5e7eb;
  border-radius: 12px;
  padding: 0.875rem 1rem 0.875rem 3rem;
  font-size: 1rem;
  transition: all 0.3s ease;
  background: white;
}

.form-control:focus {
  border-color: #0d9488;
  box-shadow: 0 0 0 4px rgba(13, 148, 136, 0.1);
  background: white;
}

.form-control:focus + .input-icon {
  color: #0d9488;
}

.form-control.is-invalid {
  border-color: #ef4444;
  background: #fef2f2;
}

.form-control::placeholder {
  color: #d1d5db;
}

.invalid-feedback {
  display: flex;
  align-items: center;
  gap: 0.25rem;
  font-size: 0.875rem;
  margin-top: 0.5rem;
}

.form-check {
  padding-left: 1.75rem;
}

.form-check-input {
  width: 1.25rem;
  height: 1.25rem;
  margin-top: 0.125rem;
  cursor: pointer;
}

.form-check-input:checked {
  background-color: #0d9488;
  border-color: #0d9488;
}

.form-check-label {
  color: #6b7280;
  font-size: 0.95rem;
  cursor: pointer;
}

.btn-primary-custom {
  background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
  border: none;
  border-radius: 10px;
  padding: 0.875rem 1.5rem;
  font-size: 1.05rem;
  font-weight: 600;
  color: white;
  width: 100%;
  transition: all 0.3s ease;
  box-shadow: 0 4px 15px rgba(13, 148, 136, 0.3);
}

.btn-primary-custom:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(13, 148, 136, 0.4);
  background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);
}

.btn-primary-custom:active {
  transform: translateY(0);
}

.btn-primary-custom:disabled {
  opacity: 0.6;
  cursor: not-allowed;
  transform: none;
}

.divider {
  display: flex;
  align-items: center;
  text-align: center;
  margin: 1.25rem 0 1rem 0;
}

.divider::before,
.divider::after {
  content: '';
  flex: 1;
  border-bottom: 1px solid #e5e7eb;
}

.divider span {
  padding: 0 1rem;
  color: #9ca3af;
  font-size: 0.875rem;
  font-weight: 500;
}

.register-link {
  text-align: center;
  margin-top: 0;
}

.register-link p {
  color: #6b7280;
  margin-bottom: 0.75rem;
  font-size: 0.95rem;
}

.register-link a {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  color: #0d9488;
  text-decoration: none;
  font-weight: 600;
  font-size: 1rem;
  padding: 0.5rem 1rem;
  border-radius: 8px;
  transition: all 0.3s ease;
}

.register-link a:hover {
  background: rgba(13, 148, 136, 0.1);
  transform: translateX(3px);
}

.spinner-border-sm {
  width: 1rem;
  height: 1rem;
  border-width: 0.15em;
}

@media (max-width: 576px) {
  .login-card {
    border-radius: 15px;
  }

  .card-header-custom {
    padding: 2rem 1.5rem;
  }

  .card-body-custom {
    padding: 2rem 1.5rem;
  }

  .logo-circle {
    width: 70px;
    height: 70px;
  }

  .logo-circle i {
    font-size: 2rem;
  }

  .card-header-custom h2 {
    font-size: 1.5rem;
  }
}
</style>
@endpush

@section('content')
<div class="login-card">
  <div class="card-header-custom">
    <div class="logo-circle">
      <i class="fas fa-store"></i>
    </div>
    <h2>Seller Portal</h2>
    <p>Sign in to your business account</p>
  </div>

  <div class="card-body-custom">
    <form action="{{ route('login.store') }}" method="POST" id="loginForm" autocomplete="off">
      @csrf
      <input type="hidden" id="formSubmitted" value="no">

      <div class="mb-3">
        <label for="email" class="form-label">Business Email</label>
        <div class="input-wrapper">
          <input
            type="email"
            id="email"
            name="email"
            value="{{ old('email', session('registration_email')) }}"
            class="form-control @error('email') is-invalid @enderror"
            placeholder="Enter your business email"
            required
            autocomplete="email"
          />
          <i class="fas fa-envelope input-icon"></i>
        </div>
        @error('email')
          <div class="invalid-feedback">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ $message }}</span>
          </div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <div class="input-wrapper">
          <input
            type="password"
            id="password"
            name="password"
            class="form-control @error('password') is-invalid @enderror"
            placeholder="Enter your password"
            required
            autocomplete="current-password"
          />
          <i class="fas fa-lock input-icon"></i>
        </div>
        @error('password')
          <div class="invalid-feedback">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ $message }}</span>
          </div>
        @enderror
      </div>

      <div class="mb-4">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="remember_me" name="remember_me">
          <label class="form-check-label" for="remember_me">
            Remember me
          </label>
        </div>
      </div>

      <button type="submit" id="loginButton" class="btn btn-primary-custom">
        <span id="loginIcon"><i class="fas fa-sign-in-alt me-2"></i></span>
        <span id="loginText">Sign In</span>
      </button>
    </form>

    <div class="divider">
      <span>or</span>
    </div>

    <div class="register-link">
      <p>Don't have a business account?</p>
      <a href="{{ route('sellers.create') }}">
        <i class="fas fa-store"></i>
        <span>Register Your Business</span>
      </a>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('loginForm');
  const inputs = document.querySelectorAll('input');

  // Clear errors when user starts typing
  inputs.forEach(input => {
    input.addEventListener('input', function() {
      this.classList.remove('is-invalid');
      const feedback = this.parentElement.querySelector('.invalid-feedback');
      if (feedback) {
        feedback.style.display = 'none';
      }
    });
  });

  // Get form submitted flag
  const formSubmitted = document.getElementById('formSubmitted');

  // Reset button state on page load (fixes back button issue)
  function resetLoginButton() {
    const button = document.getElementById('loginButton');
    const icon = document.getElementById('loginIcon');
    const text = document.getElementById('loginText');

    if (button) button.disabled = false;
    if (icon) icon.innerHTML = '<i class="fas fa-sign-in-alt me-2"></i>';
    if (text) text.textContent = 'Sign In';
    if (formSubmitted) formSubmitted.value = 'no';
  }

  // Reset on ALL page loads (including back button navigation)
  window.addEventListener('pageshow', function(event) {
    // Check if user came back after login (back button pressed)
    if (event.persisted && formSubmitted && formSubmitted.value === 'yes') {
      // User pressed back button after successful login - submit logout form
      const logoutForm = document.createElement('form');
      logoutForm.method = 'POST';
      logoutForm.action = '{{ route("logout") }}';

      const csrfToken = document.createElement('input');
      csrfToken.type = 'hidden';
      csrfToken.name = '_token';
      csrfToken.value = '{{ csrf_token() }}';

      logoutForm.appendChild(csrfToken);
      document.body.appendChild(logoutForm);
      logoutForm.submit();
      return;
    }

    // Otherwise just reset button state
    resetLoginButton();
  });

  // Form submission
  form.addEventListener('submit', function(e) {
    // Mark form as submitted
    if (formSubmitted) {
      formSubmitted.value = 'yes';
    }

    const button = document.getElementById('loginButton');
    const icon = document.getElementById('loginIcon');
    const text = document.getElementById('loginText');

    button.disabled = true;
    icon.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>';
    text.textContent = 'Signing In...';
  });
});
</script>
@endpush
