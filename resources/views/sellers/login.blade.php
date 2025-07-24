<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <title>Seller Login - GreenCup</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    /* Mobile-First Responsive Design */
    * {
      box-sizing: border-box;
      -webkit-tap-highlight-color: transparent;
    }

    html {
      font-size: 16px;
      -webkit-text-size-adjust: 100%;
      -webkit-font-smoothing: antialiased;
    }

    body {
      background: linear-gradient(-45deg, #10B981, #059669, #047857, #064E3B, #10B981);
      background-size: 400% 400%;
      animation: gradientShift 15s ease infinite;
      min-height: 100vh;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
      margin: 0;
      padding: 0;
      overflow-x: hidden;
      /* Safe area support for notched devices */
      padding-top: env(safe-area-inset-top);
      padding-bottom: env(safe-area-inset-bottom);
    }
    
    @keyframes gradientShift {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }
    
    .glass {
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.3);
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }
    
    .btn-premium {
      background: linear-gradient(135deg, #10B981, #059669);
      transition: all 0.3s ease;
      min-height: 44px; /* iOS touch target */
      display: flex;
      align-items: center;
      justify-content: center;
      touch-action: manipulation;
    }
    
    .btn-premium:hover {
      transform: translateY(-2px);
      box-shadow: 0 12px 40px rgba(16, 185, 129, 0.4);
    }

    .btn-premium:active {
      transform: translateY(0);
      box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3);
    }
    
    .input-premium {
      background: rgba(255, 255, 255, 0.1);
      border: 2px solid rgba(16, 185, 129, 0.3);
      color: white;
      transition: all 0.3s ease;
      font-size: 16px; /* Prevent iOS zoom */
      min-height: 44px;
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
      width: clamp(60px, 15vw, 96px);
      height: clamp(60px, 15vw, 96px);
      margin: 0 auto clamp(20px, 5vw, 24px);
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
    }

    .logo-icon {
      font-size: clamp(24px, 6vw, 40px);
      color: white;
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
  </style>
</head>

<body>
  <div class="login-container">
    <div class="login-card glass">
      <!-- Logo and Header -->
      <div class="text-center">
        <div class="logo-container glass">
          <i class="logo-icon fas fa-store"></i>
        </div>
        <h1 class="main-title">Seller Portal</h1>
        <p class="subtitle">Sign in to your business account</p>
      </div>

      <!-- Success Messages -->
      @if(session('registration_success'))
      <div class="alert glass" style="border-left: 4px solid #10B981;">
        <div class="alert-content">
          <i class="fas fa-check-circle" style="color: #10B981;"></i>
          <span style="color: white;">{{ session('registration_success') }}</span>
        </div>
      </div>
      @endif

      @if(session('success') && !session('registration_success'))
      <div class="alert glass" style="border-left: 4px solid #10B981;">
        <div class="alert-content">
          <i class="fas fa-check-circle" style="color: #10B981;"></i>
          <span style="color: white;">{{ session('success') }}</span>
        </div>
      </div>
      @endif

      <!-- Error Messages -->
      @if(session('error'))
      <div class="alert glass" style="border-left: 4px solid #EF4444;">
        <div class="alert-content">
          <i class="fas fa-exclamation-triangle" style="color: #EF4444;"></i>
          <div>
            <p style="color: white; font-weight: 600; margin-bottom: 4px;">System Error:</p>
            <p style="color: #fca5a5; font-size: clamp(12px, 3vw, 13px);">{{ session('error') }}</p>
          </div>
        </div>
      </div>
      @endif

      @if($errors->any())
      <div class="alert glass" style="border-left: 4px solid #EF4444;">
        <div class="alert-content">
          <i class="fas fa-exclamation-triangle" style="color: #EF4444;"></i>
          <div>
            <p style="color: white; font-weight: 600; margin-bottom: 4px;">Login failed:</p>
            <ul style="color: #fca5a5; font-size: clamp(12px, 3vw, 13px); margin: 0; padding-left: 16px;">
              @foreach($errors->all() as $error)
                <li style="margin-bottom: 2px;">{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
      @endif

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
  </div>

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
        }, 10000);
      });

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

      // Auto-hide success messages after 5 seconds
      setTimeout(() => {
        const successMessages = document.querySelectorAll('[style*="border-left: 4px solid #10B981"]');
        successMessages.forEach(msg => {
          msg.style.opacity = '0';
          msg.style.transition = 'opacity 0.5s ease';
          setTimeout(() => {
            if (msg.parentNode) {
              msg.remove();
            }
          }, 500);
        });
      }, 5000);

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

      // Handle orientation changes
      window.addEventListener('orientationchange', function() {
        setTimeout(() => {
          // Recalculate viewport
          const vh = window.innerHeight * 0.01;
          document.documentElement.style.setProperty('--vh', `${vh}px`);
        }, 100);
      });

      // Optimize for safe areas on notched devices
      if (CSS.supports('padding-top: env(safe-area-inset-top)')) {
        document.body.style.paddingTop = 'env(safe-area-inset-top)';
        document.body.style.paddingBottom = 'env(safe-area-inset-bottom)';
      }

      // Improve performance on mobile
      if (window.DeviceMotionEvent) {
        document.body.style.overscrollBehavior = 'contain';
      }

      console.log('Mobile-optimized login page initialized');
    });

    // Handle network connectivity for mobile users
    window.addEventListener('online', function() {
      showToast('Connection restored', 'success');
    });

    window.addEventListener('offline', function() {
      showToast('No internet connection', 'warning');
    });

    // Toast notification system
    function showToast(message, type = 'info') {
      const toast = document.createElement('div');
      const bgColor = type === 'success' ? '#10B981' : type === 'warning' ? '#F59E0B' : '#6B7280';
      
      toast.style.cssText = `
        position: fixed;
        top: calc(20px + env(safe-area-inset-top, 0px));
        left: 50%;
        transform: translateX(-50%);
        background: ${bgColor};
        color: white;
        padding: 12px 20px;
        border-radius: 25px;
        font-size: 14px;
        font-weight: 600;
        z-index: 10000;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        opacity: 0;
        transition: opacity 0.3s ease;
        max-width: 90%;
        text-align: center;
      `;
      toast.textContent = message;
      document.body.appendChild(toast);
      
      setTimeout(() => toast.style.opacity = '1', 100);
      
      setTimeout(() => {
        toast.style.opacity = '0';
        setTimeout(() => {
          if (document.body.contains(toast)) {
            document.body.removeChild(toast);
          }
        }, 300);
      }, 3000);
    }
  </script>
</body>
</html>