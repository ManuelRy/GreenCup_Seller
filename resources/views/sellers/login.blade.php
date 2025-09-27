@extends('layouts.guest')

@section('title', 'Login - Green Cup App')

@push('styles')
<style>
    /* Glass morphism and animations */
    .glass {
      background: rgba(255, 255, 255, 0.2);
      backdrop-filter: blur(25px);
      -webkit-backdrop-filter: blur(25px);
      border: 1px solid rgba(255, 255, 255, 0.3);
      box-shadow:
        0 25px 80px rgba(0, 0, 0, 0.15),
        0 10px 40px rgba(0, 0, 0, 0.1),
        inset 0 1px 0 rgba(255, 255, 255, 0.4);
    }

    @keyframes gradientShift {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }    .btn-premium {
      background: linear-gradient(135deg, #10B981 0%, #059669 50%, #047857 100%);
      background-size: 200% 200%;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      min-height: 52px;
      display: flex;
      align-items: center;
      justify-content: center;
      touch-action: manipulation;
      border-radius: 14px;
      border: none;
      color: white;
      font-weight: 600;
      font-size: 16px;
      letter-spacing: 0.5px;
      position: relative;
      overflow: hidden;
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
    }

    .btn-premium::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
      transition: left 0.6s ease;
    }

    .btn-premium:hover::before {
      left: 100%;
    }

    .btn-premium:hover {
      transform: translateY(-3px) scale(1.02);
      box-shadow: 0 15px 40px rgba(16, 185, 129, 0.4);
      background-position: 100% 0;
    }

    .btn-premium:active {
      transform: translateY(-1px) scale(0.98);
      box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
    }

    .input-premium {
      background: rgba(255, 255, 255, 0.15);
      border: 2px solid rgba(255, 255, 255, 0.3);
      color: white;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      font-size: 16px;
      min-height: 50px;
      border-radius: 12px;
      padding: 12px 18px;
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
    }

    .input-premium::placeholder {
      color: rgba(255, 255, 255, 0.7);
    }

    .input-premium:focus {
      background: rgba(255, 255, 255, 0.2);
      border-color: rgba(255, 255, 255, 0.6);
      box-shadow:
        inset 0 2px 4px rgba(0,0,0,0.1),
        0 0 0 3px rgba(255, 255, 255, 0.2);
      transform: translateY(-1px);
    }

    .input-premium:focus {
      border-color: #10B981;
      box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.2);
      outline: none;
    }

    .input-premium::placeholder {
      color: rgba(255, 255, 255, 0.7);
    }

    .error-input {
      border-color: #EF4444 !important;
      box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.2) !important;
    }

    /* Container - Mobile First */
    .login-container {
      width: 100%;
      max-width: none;
      margin: 0;
      padding: clamp(16px, 4vw, 32px);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-card {
      width: 100%;
      max-width: 500px;
      margin: 0 auto;
      padding: clamp(24px, 6vw, 40px);
      border-radius: clamp(16px, 4vw, 24px);
    }

    /* Typography - Responsive */
    .main-title {
      font-size: clamp(28px, 8vw, 40px);
      font-weight: 700;
      color: white;
      margin-bottom: clamp(8px, 2vw, 12px);
      text-align: center;
      line-height: 1.2;
    }

    .subtitle {
      font-size: clamp(16px, 4vw, 18px);
      color: #d1fae5;
      text-align: center;
      margin-bottom: clamp(32px, 8vw, 40px);
    }

    .logo-container {
      width: 80px;
      height: 80px;
      margin: 0 auto 24px auto;
      border-radius: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, rgba(255,255,255,0.3) 0%, rgba(255,255,255,0.1) 100%);
      backdrop-filter: blur(15px);
      -webkit-backdrop-filter: blur(15px);
      border: 1px solid rgba(255, 255, 255, 0.4);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
      animation: logoFloat 3s ease-in-out infinite;
    }

    @keyframes logoFloat {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(-5px); }
    }

    .logo-icon {
      font-size: 32px;
      color: white;
      text-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    .main-title {
      font-size: 32px;
      font-weight: 800;
      color: white;
      text-align: center;
      margin-bottom: 8px;
      text-shadow: 0 4px 8px rgba(0,0,0,0.2);
      background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: -0.5px;
    }

    .subtitle {
      font-size: 16px;
      color: rgba(255, 255, 255, 0.9);
      text-align: center;
      margin-bottom: 36px;
      font-weight: 500;
      letter-spacing: 0.3px;
    }

    /* Form Elements - Mobile Optimized */
    .form-container {
      width: 100%;
    }

    .form-group {
      margin-bottom: clamp(20px, 5vw, 28px);
    }

    .form-label {
      display: block;
      color: white;
      font-weight: 600;
      margin-bottom: clamp(6px, 1.5vw, 8px);
      font-size: clamp(16px, 4vw, 18px);
    }

    .form-label i {
      margin-right: clamp(6px, 1.5vw, 8px);
      color: #10B981;
      font-size: clamp(14px, 3.5vw, 16px);
    }

    .form-input {
      width: 100%;
      padding: clamp(14px, 3.5vw, 16px) clamp(16px, 4vw, 20px);
      border-radius: clamp(10px, 2.5vw, 12px);
      font-size: 16px; /* Fixed to prevent iOS zoom */
      font-weight: 500;
    }

    .submit-button {
      width: 100%;
      padding: clamp(16px, 4vw, 20px) clamp(20px, 5vw, 24px);
      border-radius: clamp(10px, 2.5vw, 12px);
      font-size: clamp(16px, 4vw, 18px);
      font-weight: 600;
      border: none;
      cursor: pointer;
      margin-top: clamp(12px, 3vw, 16px);
    }

    .submit-button i {
      margin-right: clamp(8px, 2vw, 12px);
      font-size: clamp(14px, 3.5vw, 16px);
    }

    /* Alert Messages - Responsive */
    .alert {
      padding: clamp(12px, 3vw, 16px) clamp(16px, 4vw, 20px);
      border-radius: clamp(8px, 2vw, 12px);
      margin-bottom: clamp(20px, 5vw, 24px);
      font-size: clamp(13px, 3.25vw, 14px);
      line-height: 1.5;
    }

    .alert i {
      margin-right: clamp(8px, 2vw, 12px);
      font-size: clamp(14px, 3.5vw, 16px);
      flex-shrink: 0;
    }

    .alert-content {
      display: flex;
      align-items: flex-start;
      gap: clamp(6px, 1.5vw, 8px);
    }

    /* Checkbox - Touch Friendly */
    .checkbox-container {
      display: flex;
      align-items: flex-start;
      gap: clamp(8px, 2vw, 12px);
      margin-bottom: clamp(20px, 5vw, 28px);
    }

    .checkbox-input {
      width: 18px;
      height: 18px;
      margin-top: 2px;
      flex-shrink: 0;
      cursor: pointer;
    }

    .checkbox-label {
      color: white;
      font-size: clamp(14px, 3.5vw, 16px);
      line-height: 1.4;
      cursor: pointer;
    }

    /* Links - Mobile Optimized */
    .link-section {
      text-align: center;
      margin-top: clamp(32px, 8vw, 40px);
    }

    .link-text {
      color: #d1fae5;
      font-size: clamp(14px, 3.5vw, 16px);
      margin-bottom: clamp(16px, 4vw, 20px);
    }

    .primary-link {
      display: inline-flex;
      align-items: center;
      color: white;
      font-weight: 600;
      font-size: clamp(16px, 4vw, 20px);
      text-decoration: none;
      transition: all 0.3s ease;
      gap: clamp(8px, 2vw, 12px);
      min-height: 44px;
      padding: clamp(8px, 2vw, 12px);
      border-radius: 8px;
      justify-content: center;
    }

    .primary-link:hover {
      color: #10B981;
      text-decoration: none;
      background: rgba(255, 255, 255, 0.1);
    }

    .primary-link:active {
      background: rgba(255, 255, 255, 0.2);
    }

    /* Error States */
    .error-message {
      color: #fca5a5;
      font-size: clamp(12px, 3vw, 13px);
      margin-top: clamp(6px, 1.5vw, 8px);
      display: flex;
      align-items: center;
      gap: clamp(4px, 1vw, 6px);
    }

    .error-message i {
      font-size: clamp(11px, 2.75vw, 12px);
      flex-shrink: 0;
    }

    /* Loading States */
    .loading {
      opacity: 0.7;
      cursor: not-allowed;
    }

    .spinner {
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }

    /* Touch Feedback */
    .touch-feedback {
      position: relative;
      overflow: hidden;
    }

    .touch-feedback::after {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 0;
      height: 0;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.3);
      transform: translate(-50%, -50%);
      transition: width 0.3s ease, height 0.3s ease;
    }

    .touch-feedback:active::after {
      width: 100%;
      height: 100%;
    }

    /* Responsive Breakpoints */
    @media (min-width: 480px) {
      .login-container {
        padding: 32px 24px;
      }

      .login-card {
        padding: 48px 40px;
        border-radius: 24px;
      }
    }

    @media (min-width: 768px) {
      .login-container {
        padding: 32px;
      }

      .login-card {
        max-width: 500px;
        padding: 60px 48px;
      }
    }

    /* Landscape Mobile Optimization */
    @media (max-height: 600px) and (orientation: landscape) {
      .login-container {
        padding: 16px;
        min-height: auto;
      }

      .login-card {
        padding: 24px;
        margin: 16px auto;
      }

      .logo-container {
        width: 60px;
        height: 60px;
        margin-bottom: 16px;
      }

      .main-title {
        font-size: 24px;
        margin-bottom: 8px;
      }

      .subtitle {
        font-size: 14px;
        margin-bottom: 24px;
      }

      .form-group {
        margin-bottom: 16px;
      }

      .link-section {
        margin-top: 24px;
      }
    }

    /* Very Small Devices */
    @media (max-width: 320px) {
      .login-container {
        padding: 12px;
      }

      .login-card {
        padding: 20px 16px;
      }

      .form-input {
        padding: 12px 14px;
      }

      .submit-button {
        padding: 14px 16px;
      }
    }

    /* High DPI Displays */
    @media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
      .glass {
        backdrop-filter: blur(25px);
      }

      .logo-container {
        transform: translateZ(0);
        backface-visibility: hidden;
      }
    }

    /* Reduced Motion Support */
    @media (prefers-reduced-motion: reduce) {
      * {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
      }

      body {
        animation: none;
        background: #10B981;
      }
    }

    /* Dark Mode Support */
    @media (prefers-color-scheme: dark) {
      .input-premium::placeholder {
        color: rgba(255, 255, 255, 0.6);
      }
    }

    /* Focus Visible for Accessibility */
    .btn-premium:focus-visible,
    .input-premium:focus-visible,
    .primary-link:focus-visible {
      outline: 2px solid #10B981;
      outline-offset: 2px;
    }

    /* Enhanced form styling */
    .login-card {
      width: 100%;
      max-width: 420px;
      padding: 48px 36px;
      border-radius: 24px;
      background: rgba(255, 255, 255, 0.25);
      backdrop-filter: blur(30px);
      -webkit-backdrop-filter: blur(30px);
      border: 1px solid rgba(255, 255, 255, 0.4);
      box-shadow:
        0 30px 100px rgba(0, 0, 0, 0.2),
        0 15px 50px rgba(0, 0, 0, 0.15),
        inset 0 1px 0 rgba(255, 255, 255, 0.5);
      animation: slideInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
      overflow: hidden;
    }

    .login-card::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.1) 50%, transparent 70%);
      transform: rotate(45deg);
      animation: shimmer 3s infinite;
    }

    @keyframes slideInUp {
      from {
        opacity: 0;
        transform: translateY(40px) scale(0.9);
      }
      to {
        opacity: 1;
        transform: translateY(0) scale(1);
      }
    }

    @keyframes shimmer {
      0% { transform: rotate(45deg) translateX(-200%); }
      100% { transform: rotate(45deg) translateX(200%); }
    }

    .text-center {
      text-align: center;
      position: relative;
      z-index: 2;
    }

    .form-container {
      position: relative;
      z-index: 2;
    }

    .form-group {
      margin-bottom: 24px;
      animation: fadeInUp 0.6s ease-out backwards;
    }

    .form-group:nth-child(1) { animation-delay: 0.1s; }
    .form-group:nth-child(2) { animation-delay: 0.2s; }
    .form-group:nth-child(3) { animation-delay: 0.3s; }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .form-label {
      display: block;
      color: rgba(255, 255, 255, 0.95);
      font-size: 14px;
      font-weight: 600;
      margin-bottom: 8px;
      letter-spacing: 0.3px;
    }

    .form-label i {
      margin-right: 8px;
      color: rgba(255, 255, 255, 0.8);
    }

    .checkbox-container {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 28px;
      animation: fadeInUp 0.6s ease-out backwards;
      animation-delay: 0.4s;
    }

    .checkbox-input {
      width: 18px;
      height: 18px;
      border-radius: 4px;
      border: 2px solid rgba(255, 255, 255, 0.4);
      background: rgba(255, 255, 255, 0.1);
    }

    .checkbox-label {
      color: rgba(255, 255, 255, 0.9);
      font-size: 14px;
      font-weight: 500;
      cursor: pointer;
    }

    .submit-button {
      width: 100%;
      margin-bottom: 24px;
      animation: fadeInUp 0.6s ease-out backwards;
      animation-delay: 0.5s;
    }

    .link-section {
      text-align: center;
      animation: fadeInUp 0.6s ease-out backwards;
      animation-delay: 0.6s;
      position: relative;
      z-index: 2;
    }

    .link-text {
      color: rgba(255, 255, 255, 0.8);
      font-size: 14px;
      margin-bottom: 12px;
    }

    .primary-link {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      color: white;
      text-decoration: none;
      font-weight: 600;
      padding: 12px 24px;
      border-radius: 10px;
      background: rgba(255, 255, 255, 0.15);
      border: 1px solid rgba(255, 255, 255, 0.3);
      transition: all 0.3s ease;
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
    }

    .primary-link:hover {
      background: rgba(255, 255, 255, 0.25);
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(0,0,0,0.15);
      color: white;
      text-decoration: none;
    }

    .error-input {
      border-color: rgba(239, 68, 68, 0.6) !important;
      background: rgba(239, 68, 68, 0.1) !important;
    }

    .error-message {
      color: #fca5a5;
      font-size: 13px;
      margin-top: 6px;
      display: flex;
      align-items: center;
      gap: 6px;
      animation: shake 0.5s ease-out;
    }

    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      25% { transform: translateX(-5px); }
      75% { transform: translateX(5px); }
    }
</style>
@endpush

@section('content')
<div class="login-card glass">
  <!-- Logo and Header -->
  <div class="text-center">
    <div class="logo-container glass">
      <i class="logo-icon fas fa-store"></i>
    </div>
    <h1 class="main-title">Seller Portal</h1>
    <p class="subtitle">Sign in to your business account</p>
  </div>

  <form action="{{ route('login.store') }}" method="POST" class="form-container" id="loginForm">
    @csrf

    <!-- Email Address -->
    <div class="form-group">
      <label for="email" class="form-label">
        <i class="fas fa-envelope"></i>Business Email
      </label>
      <input type="email" id="email" name="email" value="{{ old('email', session('registration_email')) }}"
        class="form-input input-premium glass @error('email') error-input @enderror"
        placeholder="Enter your business email" required autocomplete="email" />
      @error('email')
        <p class="error-message">
          <i class="fas fa-exclamation-circle"></i>{{ $message }}
        </p>
      @enderror
    </div>

    <!-- Password -->
    <div class="form-group">
      <label for="password" class="form-label">
        <i class="fas fa-lock"></i>Password
      </label>
      <input type="password" id="password" name="password"
        class="form-input input-premium glass @error('password') error-input @enderror"
        placeholder="Enter your password" required autocomplete="current-password" />
      @error('password')
        <p class="error-message">
          <i class="fas fa-exclamation-circle"></i>{{ $message }}
        </p>
      @enderror
    </div>

    <!-- Remember Me -->
    <div class="checkbox-container">
      <input type="checkbox" id="remember_me" name="remember_me" class="checkbox-input" />
      <label for="remember_me" class="checkbox-label">Remember this device</label>
    </div>

    <!-- Submit Button -->
    <button type="submit" id="loginButton" class="submit-button btn-premium touch-feedback">
      <i class="fas fa-sign-in-alt" id="loginIcon"></i>
      <span id="loginText">Sign In to Dashboard</span>
    </button>
  </form>

  <!-- Register Link -->
  <div class="link-section">
    <p class="link-text">Don't have a business account?</p>
    <a href="{{ route('sellers.create') }}" class="primary-link touch-feedback">
      <i class="fas fa-store"></i>
      <span>Register Your Business</span>
    </a>
  </div>
</div>
@endsection

@push('scripts')
<script>
// Enhanced mobile form handling
document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('loginForm');
  const inputs = document.querySelectorAll('input');

      // Prevent iOS zoom on input focus
      if (/iPad|iPhone|iPod/.test(navigator.userAgent)) {
        inputs.forEach(input => {
          input.addEventListener('focus', function() {
            if (this.style.fontSize !== '16px') {
              this.style.fontSize = '16px';
            }
          });
        });
      }

      // Enhanced form submission with mobile optimizations
      form.addEventListener('submit', function(e) {
        const button = document.getElementById('loginButton');
        const icon = document.getElementById('loginIcon');
        const text = document.getElementById('loginText');

        // Show loading state
        button.disabled = true;
        button.classList.add('loading');
        icon.className = 'fas fa-spinner spinner';
        text.textContent = 'Signing In...';

        // Re-enable after 10 seconds as fallback
        setTimeout(() => {
          button.disabled = false;
          button.classList.remove('loading');
          icon.className = 'fas fa-sign-in-alt';
          text.textContent = 'Sign In to Dashboard';

  // Clear errors when user starts typing
  inputs.forEach(input => {
    input.addEventListener('input', function() {
      this.classList.remove('error-input');
      const errorMsg = this.parentElement.querySelector('.error-message');
      if (errorMsg) {
        errorMsg.style.display = 'none';
      }
    });
  });

  // Touch feedback for mobile devices
  if ('ontouchstart' in window) {
    const touchElements = document.querySelectorAll('.touch-feedback');
    touchElements.forEach(element => {
      element.addEventListener('touchstart', function(e) {
        this.style.transform = 'scale(0.98)';
        this.style.opacity = '0.9';
      });

      element.addEventListener('touchend', function(e) {
        setTimeout(() => {
          this.style.transform = '';
          this.style.opacity = '';
        }, 150);
      });
    });
  }

  console.log('Mobile-optimized login page initialized');
});
</script>
@endpush
