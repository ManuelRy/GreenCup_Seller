<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
  <title>Register Business - GreenCup</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    /* Mobile-First Responsive Design */
    * {
      margin: 0;
      padding: 0;
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
      overflow-x: hidden;
      /* Safe area support */
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
    
    /* Container - Mobile First */
    .registration-container {
      width: 100%;
      padding: clamp(12px, 3vw, 32px);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .registration-card {
      width: 100%;
      max-width: 600px;
      margin: 0 auto;
      padding: clamp(20px, 5vw, 40px);
      border-radius: clamp(16px, 4vw, 24px);
      flex: 1;
    }

    /* Mobile Back Button */
    .mobile-back-btn {
      position: fixed;
      top: clamp(16px, 4vw, 20px);
      left: clamp(16px, 4vw, 20px);
      z-index: 50;
      width: clamp(40px, 10vw, 48px);
      height: clamp(40px, 10vw, 48px);
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
      color: white;
      text-decoration: none;
      transition: all 0.2s ease;
      font-size: clamp(16px, 4vw, 18px);
      touch-action: manipulation;
    }

    .mobile-back-btn:hover {
      background: rgba(255, 255, 255, 0.2);
      color: white;
      text-decoration: none;
    }

    /* Typography - Responsive */
    .main-title {
      font-size: clamp(24px, 6vw, 36px);
      font-weight: 700;
      color: white;
      margin-bottom: clamp(6px, 1.5vw, 8px);
      text-align: center;
      line-height: 1.2;
    }

    .subtitle {
      font-size: clamp(14px, 3.5vw, 16px);
      color: #d1fae5;
      text-align: center;
      margin-bottom: clamp(24px, 6vw, 32px);
    }

    .logo-container {
      width: clamp(60px, 12vw, 80px);
      height: clamp(60px, 12vw, 80px);
      margin: 0 auto clamp(16px, 4vw, 20px);
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
    }

    .logo-icon {
      font-size: clamp(24px, 6vw, 32px);
      color: white;
    }

    /* Progress Bar - Mobile Optimized */
    .progress-container {
      margin-bottom: clamp(20px, 5vw, 32px);
    }

    .progress-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: clamp(6px, 1.5vw, 8px);
    }

    .progress-label {
      color: white;
      font-size: clamp(11px, 2.75vw, 12px);
      font-weight: 600;
    }

    .progress-bar-bg {
      width: 100%;
      height: clamp(6px, 1.5vw, 8px);
      background: rgba(255, 255, 255, 0.2);
      border-radius: clamp(3px, 0.75vw, 4px);
      overflow: hidden;
    }

    .progress-bar-fill {
      height: 100%;
      background: linear-gradient(135deg, #10B981, #059669);
      border-radius: inherit;
      transition: width 0.3s ease;
      width: 0%;
    }

    /* Form Elements - Mobile First */
    .form-container {
      width: 100%;
    }

    .form-group {
      margin-bottom: clamp(16px, 4vw, 24px);
      position: relative;
    }

    .form-label {
      display: block;
      color: white;
      font-weight: 600;
      margin-bottom: clamp(6px, 1.5vw, 8px);
      font-size: clamp(14px, 3.5vw, 16px);
      line-height: 1.3;
    }

    .form-label i {
      margin-right: clamp(6px, 1.5vw, 8px);
      color: #10B981;
      font-size: clamp(12px, 3vw, 14px);
    }

    .form-input, .form-textarea, .form-select {
      width: 100%;
      background: rgba(255, 255, 255, 0.1);
      border: 2px solid rgba(16, 185, 129, 0.3);
      color: white;
      border-radius: clamp(8px, 2vw, 12px);
      padding: clamp(12px, 3vw, 16px) clamp(14px, 3.5vw, 20px);
      font-size: 16px; /* Fixed to prevent iOS zoom */
      font-weight: 500;
      transition: all 0.3s ease;
      min-height: 44px; /* iOS touch target */
    }

    .form-input:focus, .form-textarea:focus, .form-select:focus {
      border-color: #10B981;
      box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.2);
      outline: none;
    }

    .form-input::placeholder, .form-textarea::placeholder {
      color: rgba(255, 255, 255, 0.7);
    }

    .form-textarea {
      resize: vertical;
      min-height: clamp(80px, 20vw, 120px);
      font-family: inherit;
    }

    /* Grid Layout - Responsive */
    .form-grid {
      display: grid;
      grid-template-columns: 1fr;
      gap: clamp(12px, 3vw, 16px);
    }

    @media (min-width: 480px) {
      .form-grid.two-columns {
        grid-template-columns: 1fr 1fr;
      }
    }

    /* Validation Icons */
    .validation-icon {
      position: absolute;
      right: clamp(12px, 3vw, 16px);
      top: 50%;
      transform: translateY(-50%);
      font-size: clamp(14px, 3.5vw, 16px);
      z-index: 10;
    }

    /* Error States */
    .error-input {
      border-color: #EF4444 !important;
      box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.2) !important;
    }

    .error-message {
      color: #fca5a5;
      font-size: clamp(11px, 2.75vw, 12px);
      margin-top: clamp(4px, 1vw, 6px);
      display: flex;
      align-items: center;
      gap: clamp(4px, 1vw, 6px);
    }

    .error-message i {
      font-size: clamp(10px, 2.5vw, 11px);
    }

    /* Buttons - Touch Optimized */
    .btn-primary {
      background: linear-gradient(135deg, #10B981, #059669);
      color: white;
      border: none;
      border-radius: clamp(8px, 2vw, 12px);
      padding: clamp(12px, 3vw, 16px) clamp(16px, 4vw, 20px);
      font-size: clamp(14px, 3.5vw, 16px);
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      min-height: 44px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: clamp(6px, 1.5vw, 8px);
      touch-action: manipulation;
    }

    .btn-primary:hover {
      transform: translateY(-1px);
      box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
    }

    .btn-primary:active {
      transform: translateY(0);
    }

    .btn-primary:disabled {
      opacity: 0.7;
      cursor: not-allowed;
      transform: none;
    }

    .btn-secondary {
      background: linear-gradient(135deg, #6B7280, #4B5563);
      color: white;
      border: none;
      border-radius: clamp(6px, 1.5vw, 8px);
      padding: clamp(8px, 2vw, 10px) clamp(12px, 3vw, 16px);
      font-size: clamp(12px, 3vw, 14px);
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      min-height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: clamp(4px, 1vw, 6px);
      touch-action: manipulation;
    }

    .submit-button {
      width: 100%;
      padding: clamp(16px, 4vw, 20px);
      font-size: clamp(16px, 4vw, 18px);
      margin-top: clamp(16px, 4vw, 20px);
    }

    /* Custom Select Styling */
    .form-select {
      background-image: url('data:image/svg+xml;charset=US-ASCII,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 4 5"><path fill="%23ffffff" d="M2 0L0 2h4zm0 5L0 3h4z"/></svg>');
      background-repeat: no-repeat;
      background-position: right clamp(12px, 3vw, 16px) center;
      background-size: clamp(10px, 2.5vw, 12px);
      appearance: none;
      padding-right: clamp(32px, 8vw, 40px);
    }

    .form-select option {
      background: #047857;
      color: white;
      padding: 8px;
    }

    .form-select optgroup {
      background: #064E3B;
      color: #D1FAE5;
      font-weight: bold;
    }

    /* Password Strength */
    .password-strength {
      height: clamp(3px, 0.75vw, 4px);
      border-radius: clamp(1.5px, 0.375vw, 2px);
      margin-top: clamp(6px, 1.5vw, 8px);
      background: rgba(255, 255, 255, 0.2);
      overflow: hidden;
    }

    .strength-bar {
      height: 100%;
      transition: all 0.3s ease;
      border-radius: inherit;
    }

    .password-help {
      color: #d1fae5;
      font-size: clamp(10px, 2.5vw, 11px);
      margin-top: clamp(2px, 0.5vw, 4px);
    }

    /* Character Counter */
    .character-counter {
      text-align: right;
      color: #d1fae5;
      font-size: clamp(10px, 2.5vw, 11px);
      margin-top: clamp(2px, 0.5vw, 4px);
    }

    /* Custom Hours Input */
    .custom-hours-container {
      margin-top: clamp(8px, 2vw, 12px);
      display: none;
    }

    /* Location Button */
    .location-button {
      margin: clamp(12px, 3vw, 16px) auto;
      background: #059669;
    }

    .location-button:hover {
      background: #047857;
    }

    /* Checkbox Styling */
    .checkbox-container {
      display: flex;
      align-items: flex-start;
      gap: clamp(8px, 2vw, 12px);
      margin: clamp(16px, 4vw, 20px) 0;
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
      font-size: clamp(12px, 3vw, 14px);
      line-height: 1.4;
      cursor: pointer;
    }

    .checkbox-label a {
      color: #10B981;
      text-decoration: underline;
    }

    .checkbox-label a:hover {
      color: #059669;
    }

    /* Alert Messages */
    .alert {
      padding: clamp(12px, 3vw, 16px) clamp(16px, 4vw, 20px);
      border-radius: clamp(8px, 2vw, 12px);
      margin-bottom: clamp(16px, 4vw, 20px);
      font-size: clamp(12px, 3vw, 14px);
      line-height: 1.5;
    }

    .alert-content {
      display: flex;
      align-items: flex-start;
      gap: clamp(6px, 1.5vw, 8px);
    }

    .alert i {
      font-size: clamp(14px, 3.5vw, 16px);
      flex-shrink: 0;
      margin-top: 2px;
    }

    .alert.success {
      border-left: 4px solid #10B981;
    }

    .alert.error {
      border-left: 4px solid #EF4444;
    }

    /* Links Section */
    .links-section {
      text-align: center;
      margin-top: clamp(24px, 6vw, 40px);
    }

    .link-text {
      color: #d1fae5;
      font-size: clamp(14px, 3.5vw, 16px);
      margin-bottom: clamp(12px, 3vw, 16px);
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
    }

    .primary-link:hover {
      color: #10B981;
      text-decoration: none;
      background: rgba(255, 255, 255, 0.1);
    }

    /* Desktop Back Button */
    .desktop-back-btn {
      display: none;
    }

    /* Loading States */
    .spinner {
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }

    /* Tooltip */
    .tooltip {
      position: relative;
      cursor: help;
      display: inline-block;
      margin-left: clamp(4px, 1vw, 6px);
    }

    .tooltip::after {
      content: attr(data-tooltip);
      position: absolute;
      bottom: 100%;
      left: 50%;
      transform: translateX(-50%);
      background: rgba(0, 0, 0, 0.8);
      color: white;
      padding: clamp(6px, 1.5vw, 8px) clamp(8px, 2vw, 12px);
      border-radius: clamp(4px, 1vw, 6px);
      font-size: clamp(10px, 2.5vw, 12px);
      white-space: nowrap;
      opacity: 0;
      pointer-events: none;
      transition: opacity 0.3s ease;
      z-index: 1000;
    }

    .tooltip:hover::after {
      opacity: 1;
    }

    /* Responsive Breakpoints */
    @media (min-width: 480px) {
      .registration-container {
        padding: 20px;
      }
      
      .registration-card {
        padding: 36px 32px;
      }
      
      .mobile-back-btn {
        display: none;
      }
    }

    @media (min-width: 768px) {
      .registration-container {
        padding: 32px;
      }
      
      .registration-card {
        max-width: 600px;
        padding: 48px 40px;
      }
      
      .desktop-back-btn {
        display: block;
        text-align: center;
        margin-top: 32px;
      }

      .desktop-back-btn button {
        background: none;
        border: none;
        color: #10B981;
        font-size: 16px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px;
        border-radius: 8px;
        transition: all 0.3s ease;
      }

      .desktop-back-btn button:hover {
        color: white;
        background: rgba(255, 255, 255, 0.1);
      }
    }

    /* Landscape Mobile Optimization */
    @media (max-height: 600px) and (orientation: landscape) {
      .registration-container {
        padding: 8px 16px;
      }
      
      .registration-card {
        padding: 16px 20px;
        margin: 8px auto;
      }
      
      .logo-container {
        width: 50px;
        height: 50px;
        margin-bottom: 12px;
      }
      
      .main-title {
        font-size: 20px;
        margin-bottom: 4px;
      }
      
      .subtitle {
        font-size: 12px;
        margin-bottom: 16px;
      }
      
      .form-group {
        margin-bottom: 12px;
      }
      
      .progress-container {
        margin-bottom: 16px;
      }
      
      .links-section {
        margin-top: 20px;
      }
    }

    /* Very Small Devices */
    @media (max-width: 320px) {
      .registration-container {
        padding: 8px;
      }
      
      .registration-card {
        padding: 16px 12px;
      }
      
      .form-input, .form-textarea, .form-select {
        padding: 10px 12px;
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
    }

    /* Touch Improvements */
    @media (hover: none) and (pointer: coarse) {
      .btn-primary:hover,
      .btn-secondary:hover {
        transform: none;
      }
      
      .btn-primary:active,
      .btn-secondary:active {
        transform: scale(0.98);
        opacity: 0.9;
      }
    }

    /* Reduced Motion */
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

    /* Focus Management */
    .btn-primary:focus-visible,
    .form-input:focus-visible,
    .form-textarea:focus-visible,
    .form-select:focus-visible {
      outline: 2px solid #10B981;
      outline-offset: 2px;
    }
  </style>
</head>

<body>
  <!-- Mobile Back Button -->
  <a href="javascript:history.back()" class="mobile-back-btn glass">
    <i class="fas fa-arrow-left"></i>
  </a>

  <div class="registration-container">
    <div class="registration-card glass">
      <!-- Logo and Header -->
      <div class="text-center">
        <div class="logo-container glass">
          <i class="logo-icon fas fa-store"></i>
        </div>
        <h1 class="main-title">Business Registration</h1>
        <p class="subtitle">Join GreenCup as a seller</p>
      </div>

      <!-- Success Message -->
      @if(session('success'))
        <div class="alert glass success" id="successAlert">
          <div class="alert-content">
            <i class="fas fa-check-circle" style="color: #10B981;"></i>
            <span style="color: white;">{{ session('success') }}</span>
          </div>
        </div>
      @endif

      <!-- System Error Messages -->
      @if(session('error'))
      <div class="alert glass error">
        <div class="alert-content">
          <i class="fas fa-exclamation-triangle" style="color: #EF4444;"></i>
          <div>
            <p style="color: white; font-weight: 600; margin-bottom: 4px;">System Error:</p>
            <p style="color: #fca5a5; font-size: clamp(11px, 2.75vw, 12px);">{{ session('error') }}</p>
          </div>
        </div>
      </div>
      @endif

      <!-- Validation Error Messages -->
      @if($errors->any())
        <div class="alert glass error" id="errorAlert">
          <div class="alert-content">
            <i class="fas fa-exclamation-triangle" style="color: #EF4444;"></i>
            <div>
              <p style="color: white; font-weight: 600; margin-bottom: 4px;">Please fix the following errors:</p>
              <ul style="color: #fca5a5; font-size: clamp(11px, 2.75vw, 12px); margin: 0; padding-left: 16px;">
                @foreach($errors->all() as $error)
                  <li style="margin-bottom: 2px;">{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
      @endif

      <!-- Registration Progress Bar -->
      <div class="progress-container">
        <div class="progress-header">
          <span class="progress-label">Registration Progress</span>
          <span class="progress-label" id="progressText">0% Complete</span>
        </div>
        <div class="progress-bar-bg">
          <div class="progress-bar-fill" id="progressBar"></div>
        </div>
      </div>

      <form action="{{ route('sellers.store') }}" method="POST" class="form-container" id="registrationForm" novalidate>
        @csrf
        
        <!-- Business Name -->
        <div class="form-group">
          <label for="business_name" class="form-label">
            <i class="fas fa-store"></i>Business Name *
            <span class="tooltip" data-tooltip="The official name of your business">ⓘ</span>
          </label>
          <div style="position: relative;">
            <input type="text" id="business_name" name="business_name" value="{{ old('business_name') }}"
              class="form-input @error('business_name') error-input @enderror"
              placeholder="Enter your business name" required minlength="2" maxlength="255" />
            <div class="validation-icon" id="business_name_icon"></div>
          </div>
          @error('business_name')
            <p class="error-message" id="business_name_error">
              <i class="fas fa-exclamation-circle"></i>{{ $message }}
            </p>
          @enderror
        </div>

        <!-- Business Email -->
        <div class="form-group">
          <label for="email" class="form-label">
            <i class="fas fa-envelope"></i>Business Email *
            <span class="tooltip" data-tooltip="Email address for your business account">ⓘ</span>
          </label>
          <div style="position: relative;">
            <input type="email" id="email" name="email" value="{{ old('email') }}"
              class="form-input @error('email') error-input @enderror"
              placeholder="Enter your business email" required autocomplete="email" />
            <div class="validation-icon" id="email_icon"></div>
          </div>
          @error('email')
            <p class="error-message" id="email_error">
              <i class="fas fa-exclamation-circle"></i>{{ $message }}
            </p>
          @enderror
        </div>

        <!-- Phone Number -->
        <div class="form-group">
          <label for="phone" class="form-label">
            <i class="fas fa-phone"></i>Phone Number
            <span style="color: #d1fae5; font-weight: 400;">(optional)</span>
          </label>
          <div style="position: relative;">
            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
              class="form-input @error('phone') error-input @enderror"
              placeholder="Enter business phone number" autocomplete="tel" />
            <div class="validation-icon" id="phone_icon"></div>
          </div>
          @error('phone')
            <p class="error-message" id="phone_error">
              <i class="fas fa-exclamation-circle"></i>{{ $message }}
            </p>
          @enderror
        </div>

        <!-- Business Description -->
        <div class="form-group">
          <label for="description" class="form-label">
            <i class="fas fa-file-text"></i>Business Description
            <span style="color: #d1fae5; font-weight: 400;">(optional)</span>
          </label>
          <textarea id="description" name="description" rows="3" maxlength="1000"
            class="form-textarea @error('description') error-input @enderror"
            placeholder="Describe your business, products, or services">{{ old('description') }}</textarea>
          <div class="character-counter">
            <span id="description_count">0</span>/1000 characters
          </div>
          @error('description')
            <p class="error-message" id="description_error">
              <i class="fas fa-exclamation-circle"></i>{{ $message }}
            </p>
          @enderror
        </div>

        <!-- Working Hours -->
        <div class="form-group">
          <label for="working_hours" class="form-label">
            <i class="fas fa-clock"></i>Working Hours
            <span style="color: #d1fae5; font-weight: 400;">(optional)</span>
          </label>
          <select id="working_hours" name="working_hours"
            class="form-select @error('working_hours') error-input @enderror">
            <option value="">-- Select Working Hours --</option>
            
            <!-- Standard Business Hours -->
            <optgroup label="📅 Standard Business Hours">
              <option value="Mon-Fri 9AM-5PM" {{ old('working_hours') == 'Mon-Fri 9AM-5PM' ? 'selected' : '' }}>
                Mon-Fri 9AM-5PM (Standard Office)
              </option>
              <option value="Mon-Fri 8AM-5PM" {{ old('working_hours') == 'Mon-Fri 8AM-5PM' ? 'selected' : '' }}>
                Mon-Fri 8AM-5PM (Early Start)
              </option>
              <option value="Mon-Fri 9AM-6PM" {{ old('working_hours') == 'Mon-Fri 9AM-6PM' ? 'selected' : '' }}>
                Mon-Fri 9AM-6PM (Extended Hours)
              </option>
              <option value="Mon-Fri 8AM-6PM" {{ old('working_hours') == 'Mon-Fri 8AM-6PM' ? 'selected' : '' }}>
                Mon-Fri 8AM-6PM (Long Days)
              </option>
            </optgroup>
            
            <!-- Include Saturday -->
            <optgroup label="📅 Including Saturday">
              <option value="Mon-Sat 9AM-5PM" {{ old('working_hours') == 'Mon-Sat 9AM-5PM' ? 'selected' : '' }}>
                Mon-Sat 9AM-5PM
              </option>
              <option value="Mon-Sat 8AM-6PM" {{ old('working_hours') == 'Mon-Sat 8AM-6PM' ? 'selected' : '' }}>
                Mon-Sat 8AM-6PM
              </option>
              <option value="Mon-Sat 10AM-6PM" {{ old('working_hours') == 'Mon-Sat 10AM-6PM' ? 'selected' : '' }}>
                Mon-Sat 10AM-6PM
              </option>
              <option value="Tue-Sat 9AM-5PM" {{ old('working_hours') == 'Tue-Sat 9AM-5PM' ? 'selected' : '' }}>
                Tue-Sat 9AM-5PM (Closed Mondays)
              </option>
            </optgroup>
            
            <!-- 7 Days a Week -->
            <optgroup label="📅 7 Days a Week">
              <option value="Mon-Sun 9AM-5PM" {{ old('working_hours') == 'Mon-Sun 9AM-5PM' ? 'selected' : '' }}>
                Mon-Sun 9AM-5PM (Every Day)
              </option>
              <option value="Mon-Sun 8AM-8PM" {{ old('working_hours') == 'Mon-Sun 8AM-8PM' ? 'selected' : '' }}>
                Mon-Sun 8AM-8PM (Extended Daily)
              </option>
              <option value="24/7" {{ old('working_hours') == '24/7' ? 'selected' : '' }}>
                24/7 (Always Open)
              </option>
            </optgroup>
            
            <!-- Custom Option -->
            <optgroup label="✏️ Custom">
              <option value="custom" {{ old('working_hours') == 'custom' ? 'selected' : '' }}>
                Custom Hours (Specify Below)
              </option>
            </optgroup>
          </select>
          
          <!-- Custom Hours Input -->
          <div id="customHoursInput" class="custom-hours-container">
            <label for="custom_working_hours" class="form-label" style="margin-bottom: 6px; font-size: clamp(12px, 3vw, 14px);">
              <i class="fas fa-edit"></i>Enter your custom working hours:
            </label>
            <input type="text" id="custom_working_hours" name="custom_working_hours" 
                   value="{{ old('custom_working_hours') }}"
                   class="form-input"
                   placeholder="e.g., Mon-Wed 9AM-1PM, Thu-Fri 2PM-6PM" />
          </div>
          
          @error('working_hours')
            <p class="error-message" id="working_hours_error">
              <i class="fas fa-exclamation-circle"></i>{{ $message }}
            </p>
          @enderror
        </div>

        <!-- Business Address -->
        <div class="form-group">
          <label for="address" class="form-label">
            <i class="fas fa-map-marker-alt"></i>Business Address *
            <button type="button" id="undoAddressBtn" style="display: none; background: none; border: none; color: #F59E0B; font-size: 10px; margin-left: 8px; cursor: pointer; text-decoration: underline;" onclick="undoAddressFill()">
              ↺ Undo auto-fill
            </button>
          </label>
          <textarea id="address" name="address" rows="2" required minlength="10" maxlength="500"
            class="form-textarea @error('address') error-input @enderror"
            placeholder="Enter your complete business address">{{ old('address') }}</textarea>
          @error('address')
            <p class="error-message" id="address_error">
              <i class="fas fa-exclamation-circle"></i>{{ $message }}
            </p>
          @enderror
        </div>

        <!-- Location Coordinates -->
        <div class="form-grid two-columns">
          <div class="form-group">
            <label for="latitude" class="form-label">
              <i class="fas fa-map"></i>Latitude *
            </label>
            <div style="position: relative;">
              <input type="number" step="any" id="latitude" name="latitude" value="{{ old('latitude') }}" required
                class="form-input @error('latitude') error-input @enderror"
                placeholder="e.g., 11.5564" min="-90" max="90" />
              <div class="validation-icon" id="latitude_icon"></div>
            </div>
            @error('latitude')
              <p class="error-message" id="latitude_error">
                <i class="fas fa-exclamation-circle"></i>{{ $message }}
              </p>
            @enderror
          </div>
          
          <div class="form-group">
            <label for="longitude" class="form-label">
              <i class="fas fa-map"></i>Longitude *
            </label>
            <div style="position: relative;">
              <input type="number" step="any" id="longitude" name="longitude" value="{{ old('longitude') }}" required
                class="form-input @error('longitude') error-input @enderror"
                placeholder="e.g., 104.9282" min="-180" max="180" />
              <div class="validation-icon" id="longitude_icon"></div>
            </div>
            @error('longitude')
              <p class="error-message" id="longitude_error">
                <i class="fas fa-exclamation-circle"></i>{{ $message }}
              </p>
            @enderror
          </div>
        </div>

        <!-- Get Location Button -->
        <div style="text-align: center;">
          <button type="button" onclick="getCurrentLocation()" id="locationButton"
            class="btn-secondary location-button">
            <i class="fas fa-location-arrow" id="locationIcon"></i>
            <span id="locationText">Get My Location & Address</span>
          </button>
          <p style="color: #d1fae5; font-size: clamp(10px, 2.5vw, 11px); margin-top: 6px; text-align: center;">
            📍 Automatically fills coordinates and business address
          </p>
        </div>

        <!-- Password -->
        <div class="form-group">
          <label for="password" class="form-label">
            <i class="fas fa-lock"></i>Password *
            <span class="tooltip" data-tooltip="Must be at least 8 characters with uppercase, lowercase, and number">ⓘ</span>
          </label>
          <div style="position: relative;">
            <input type="password" id="password" name="password"
              class="form-input @error('password') error-input @enderror"
              placeholder="Create a strong password (min 8 characters)" required minlength="8" autocomplete="new-password" />
            <button type="button" onclick="togglePassword('password')" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #10B981; cursor: pointer; font-size: 14px;">
              <i id="passwordToggle" class="fas fa-eye"></i>
            </button>
          </div>
          <div class="password-strength">
            <div class="strength-bar" id="passwordStrength"></div>
          </div>
          <p class="password-help" id="passwordHelp">
            Password strength: <span id="strengthText">Enter password</span>
          </p>
          @error('password')
            <p class="error-message" id="password_error">
              <i class="fas fa-exclamation-circle"></i>{{ $message }}
            </p>
          @enderror
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
          <label for="password_confirmation" class="form-label">
            <i class="fas fa-lock"></i>Confirm Password *
          </label>
          <div style="position: relative;">
            <input type="password" id="password_confirmation" name="password_confirmation"
              class="form-input @error('password_confirmation') error-input @enderror"
              placeholder="Confirm your password" required autocomplete="new-password" />
            <button type="button" onclick="togglePassword('password_confirmation')" style="position: absolute; right: 40px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #10B981; cursor: pointer; font-size: 14px;">
              <i id="confirmPasswordToggle" class="fas fa-eye"></i>
            </button>
            <div class="validation-icon" id="password_confirmation_icon" style="right: 12px;"></div>
          </div>
          @error('password_confirmation')
            <p class="error-message" id="password_confirmation_error">
              <i class="fas fa-exclamation-circle"></i>{{ $message }}
            </p>
          @enderror
        </div>

        <!-- Terms Agreement -->
        <div class="checkbox-container">
          <input type="checkbox" id="terms" name="terms" required class="checkbox-input" />
          <label for="terms" class="checkbox-label">
            I agree to the <a href="#">Terms of Service</a> 
            and <a href="#">Privacy Policy</a>
          </label>
        </div>

        <!-- Submit Button -->
        <button type="submit" id="submitButton" class="btn-primary submit-button">
          <i class="fas fa-store" id="submitIcon"></i>
          <span id="submitText">Register Business</span>
        </button>
      </form>

      <!-- Login Link -->
      <div class="links-section">
        <p class="link-text">Already have a business account?</p>
        <a href="{{ route('login') }}" class="primary-link">
          <i class="fas fa-sign-in-alt"></i>
          <span>Sign In Instead</span>
        </a>
      </div>

      <!-- Desktop Back Button -->
      <div class="desktop-back-btn">
        <button onclick="history.back()">
          <i class="fas fa-arrow-left"></i>
          <span>Go Back</span>
        </button>
      </div>
    </div>
  </div>

  <script>
    // Mobile-optimized form validation and progress tracking
    document.addEventListener('DOMContentLoaded', function() {
      const form = document.getElementById('registrationForm');
      const progressBar = document.getElementById('progressBar');
      const progressText = document.getElementById('progressText');
      
      // Required fields for progress calculation
      const requiredFields = ['business_name', 'email', 'address', 'latitude', 'longitude', 'password', 'password_confirmation'];
      
      // Prevent iOS zoom on input focus
      if (/iPad|iPhone|iPod/.test(navigator.userAgent)) {
        const inputs = document.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
          input.addEventListener('focus', function() {
            if (this.style.fontSize !== '16px') {
              this.style.fontSize = '16px';
            }
          });
        });
      }

      // Real-time validation and progress
      function updateProgress() {
        let filledFields = 0;
        let totalFields = requiredFields.length;
        
        requiredFields.forEach(fieldName => {
          const field = document.getElementById(fieldName);
          if (field && field.value.trim()) {
            filledFields++;
          }
        });
        
        const percentage = Math.round((filledFields / totalFields) * 100);
        progressBar.style.width = percentage + '%';
        progressText.textContent = percentage + '% Complete';
      }

      // Field validation
      function validateField(fieldName, value) {
        const icon = document.getElementById(fieldName + '_icon');
        const error = document.getElementById(fieldName + '_error');
        
        if (!icon) return;
        
        let isValid = false;
        
        switch(fieldName) {
          case 'business_name':
            isValid = value.length >= 2 && value.length <= 255;
            break;
          case 'email':
            isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
            break;
          case 'phone':
            isValid = !value || value.length >= 10;
            break;
          case 'address':
            isValid = value.length >= 10 && value.length <= 500;
            break;
          case 'latitude':
            isValid = !isNaN(value) && value >= -90 && value <= 90;
            break;
          case 'longitude':
            isValid = !isNaN(value) && value >= -180 && value <= 180;
            break;
          case 'password':
            isValid = value.length >= 8 && /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/.test(value);
            break;
          case 'password_confirmation':
            const password = document.getElementById('password').value;
            isValid = value === password && value.length >= 8;
            break;
        }
        
        if (value) {
          if (isValid) {
            icon.innerHTML = '<i class="fas fa-check" style="color: #10B981;"></i>';
            if (error) error.style.display = 'none';
          } else {
            icon.innerHTML = '<i class="fas fa-times" style="color: #EF4444;"></i>';
          }
        } else {
          icon.innerHTML = '';
        }
        
        return isValid;
      }

      // Password strength checker
      function checkPasswordStrength(password) {
        const strengthBar = document.getElementById('passwordStrength');
        const strengthText = document.getElementById('strengthText');
        
        if (!password) {
          strengthBar.style.width = '0%';
          strengthBar.style.backgroundColor = '';
          strengthText.textContent = 'Enter password';
          return;
        }
        
        let strength = 0;
        const checks = {
          length: password.length >= 8,
          lowercase: /[a-z]/.test(password),
          uppercase: /[A-Z]/.test(password),
          number: /\d/.test(password),
          special: /[!@#$%^&*(),.?":{}|<>]/.test(password)
        };
        
        strength = Object.values(checks).filter(Boolean).length;
        
        const colors = ['#EF4444', '#F59E0B', '#EAB308', '#22C55E', '#10B981'];
        const labels = ['Very Weak', 'Weak', 'Fair', 'Good', 'Strong'];
        const widths = ['20%', '40%', '60%', '80%', '100%'];
        
        strengthBar.style.width = widths[strength - 1] || '20%';
        strengthBar.style.backgroundColor = colors[strength - 1] || colors[0];
        strengthText.textContent = labels[strength - 1] || labels[0];
      }

      // Character counter for description
      const descriptionField = document.getElementById('description');
      const descriptionCounter = document.getElementById('description_count');
      
      if (descriptionField && descriptionCounter) {
        descriptionField.addEventListener('input', function() {
          descriptionCounter.textContent = this.value.length;
        });
        // Initialize counter
        descriptionCounter.textContent = descriptionField.value.length;
      }

      // Handle custom working hours option
      document.getElementById('working_hours').addEventListener('change', function() {
        const customInput = document.getElementById('customHoursInput');
        const customField = document.getElementById('custom_working_hours');
        
        if (this.value === 'custom') {
          customInput.style.display = 'block';
          customField.required = true;
          setTimeout(() => customField.focus(), 100);
        } else {
          customInput.style.display = 'none';
          customField.required = false;
          customField.value = '';
        }
        
        updateProgress();
      });

      // Initialize custom hours visibility on page load
      const workingHoursSelect = document.getElementById('working_hours');
      const customInput = document.getElementById('customHoursInput');
      
      if (workingHoursSelect.value === 'custom') {
        customInput.style.display = 'block';
        document.getElementById('custom_working_hours').required = true;
      }

      // Add event listeners to all form fields
      document.querySelectorAll('input, textarea, select').forEach(field => {
        field.addEventListener('input', function() {
          validateField(this.name, this.value);
          updateProgress();
          
          // Clear error styling when user starts typing
          this.classList.remove('error-input');
          const errorElement = document.getElementById(this.name + '_error');
          if (errorElement) {
            errorElement.style.display = 'none';
          }
          
          // Hide undo button if user manually edits address after auto-fill
          if (this.name === 'address') {
            const undoBtn = document.getElementById('undoAddressBtn');
            const originalValue = this.getAttribute('data-original');
            if (undoBtn && originalValue && this.value !== originalValue) {
              // Only hide if the current value is different from both original and auto-filled
              setTimeout(() => {
                if (undoBtn.style.display !== 'none') {
                  undoBtn.style.display = 'none';
                  this.removeAttribute('data-original');
                }
              }, 1000); // Give user a moment to undo if they want
            }
          }
          
          // Special handling for password strength
          if (this.name === 'password') {
            checkPasswordStrength(this.value);
          }
          
          // Check password confirmation match
          if (this.name === 'password_confirmation' || this.name === 'password') {
            const password = document.getElementById('password').value;
            const confirmation = document.getElementById('password_confirmation').value;
            validateField('password_confirmation', confirmation);
          }
        });
        
        field.addEventListener('blur', function() {
          validateField(this.name, this.value);
        });
      });

      // Form submission with mobile optimizations
      form.addEventListener('submit', function(e) {
        const button = document.getElementById('submitButton');
        const icon = document.getElementById('submitIcon');
        const text = document.getElementById('submitText');
        
        // Check terms agreement
        const termsCheckbox = document.getElementById('terms');
        if (!termsCheckbox.checked) {
          e.preventDefault();
          showToast('Please agree to the Terms of Service and Privacy Policy to continue.', 'warning');
          return;
        }

        // Handle custom working hours
        const workingHoursSelect = document.getElementById('working_hours');
        const customHours = document.getElementById('custom_working_hours');
        
        if (workingHoursSelect.value === 'custom') {
          if (!customHours.value.trim()) {
            e.preventDefault();
            showToast('Please enter your custom working hours.', 'warning');
            customHours.focus();
            return;
          }
          // Set the select value to the custom input value for submission
          workingHoursSelect.value = customHours.value;
        }
        
        // Show loading state
        button.disabled = true;
        icon.className = 'fas fa-spinner spinner';
        text.textContent = 'Creating Account...';
        
        // Re-enable after 15 seconds as fallback
        setTimeout(() => {
          button.disabled = false;
          icon.className = 'fas fa-store';
          text.textContent = 'Register Business';
        }, 15000);
      });

      // Initialize progress on page load
      updateProgress();
      
      // Auto-hide success messages after 5 seconds
      setTimeout(() => {
        const successMessages = document.querySelectorAll('#successAlert');
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

      // Mobile performance optimizations
      if (window.DeviceMotionEvent) {
        document.body.style.overscrollBehavior = 'contain';
      }

      console.log('Mobile-optimized registration page initialized');
    });

    // Password toggle functionality
    function togglePassword(inputId) {
      const input = document.getElementById(inputId);
      const toggle = document.getElementById(inputId === 'password' ? 'passwordToggle' : 'confirmPasswordToggle');
      
      if (input.type === 'password') {
        input.type = 'text';
        toggle.className = 'fas fa-eye-slash';
      } else {
        input.type = 'password';
        toggle.className = 'fas fa-eye';
      }
    }

    // Get current location with mobile optimizations and auto-fill address
    function getCurrentLocation() {
      const button = document.getElementById('locationButton');
      const icon = document.getElementById('locationIcon');
      const text = document.getElementById('locationText');
      
      // Show loading state
      button.disabled = true;
      icon.className = 'fas fa-spinner spinner';
      text.textContent = 'Getting Location...';
      
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
          async function(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            
            // Fill coordinates
            document.getElementById('latitude').value = lat.toFixed(7);
            document.getElementById('longitude').value = lng.toFixed(7);
            
            // Validate the coordinate fields
            const latField = document.getElementById('latitude');
            const lngField = document.getElementById('longitude');
            latField.dispatchEvent(new Event('input'));
            lngField.dispatchEvent(new Event('input'));
            
            // Update button to show address fetching
            text.textContent = 'Getting Address...';
            
            // Get address using reverse geocoding
            try {
              await reverseGeocode(lat, lng);
              
              // Show complete success state
              icon.className = 'fas fa-check';
              text.textContent = 'Location & Address Captured!';
              showToast('Location and address captured successfully!', 'success');
              
            } catch (addressError) {
              console.warn('Address lookup failed:', addressError);
              
              // Show partial success - coordinates only
              icon.className = 'fas fa-check';
              text.textContent = 'Location Captured!';
              showToast('Location captured! Please enter address manually.', 'warning');
            }
            
            // Reset button after 4 seconds
            setTimeout(() => {
              button.disabled = false;
              icon.className = 'fas fa-location-arrow';
              text.textContent = 'Get My Location & Address';
            }, 4000);
          },
          function(error) {
            let errorMessage = 'Unable to get your location. ';
            switch(error.code) {
              case error.PERMISSION_DENIED:
                errorMessage += 'Location access was denied.';
                break;
              case error.POSITION_UNAVAILABLE:
                errorMessage += 'Location information is unavailable.';
                break;
              case error.TIMEOUT:
                errorMessage += 'Location request timed out.';
                break;
            }
            
            // Show error state
            icon.className = 'fas fa-exclamation-triangle';
            text.textContent = 'Location Failed';
            
            setTimeout(() => {
              button.disabled = false;
              icon.className = 'fas fa-location-arrow';
              text.textContent = 'Get My Location & Address';
            }, 3000);
            
            showToast(errorMessage + ' Please enter coordinates manually.', 'warning');
          },
          {
            enableHighAccuracy: true,
            timeout: 15000,
            maximumAge: 60000
          }
        );
      } else {
        icon.className = 'fas fa-exclamation-triangle';
        text.textContent = 'Not Supported';
        
        setTimeout(() => {
          button.disabled = false;
          icon.className = 'fas fa-location-arrow';
          text.textContent = 'Get My Location & Address';
        }, 3000);
        
        showToast('Geolocation is not supported by this browser. Please enter coordinates manually.', 'warning');
      }
    }

    // Reverse geocoding function to get address from coordinates
    async function reverseGeocode(lat, lng) {
      return new Promise((resolve, reject) => {
        // Method 1: Try using browser's built-in reverse geocoding (if available)
        if (window.google && window.google.maps && window.google.maps.Geocoder) {
          // Use Google Maps Geocoder if available
          const geocoder = new window.google.maps.Geocoder();
          geocoder.geocode(
            { location: { lat: lat, lng: lng } },
            function(results, status) {
              if (status === 'OK' && results[0]) {
                const address = results[0].formatted_address;
                fillAddressField(address);
                resolve(address);
              } else {
                reject('Google Geocoder failed');
              }
            }
          );
        } else {
          // Method 2: Use free Nominatim service (OpenStreetMap)
          const controller = new AbortController();
          const timeoutId = setTimeout(() => controller.abort(), 8000); // 8 second timeout

          fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1&accept-language=en`, {
            signal: controller.signal,
            headers: {
              'User-Agent': 'GreenCup Business Registration'
            }
          })
            .then(response => {
              clearTimeout(timeoutId);
              if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
              }
              return response.json();
            })
            .then(data => {
              if (data && (data.display_name || data.address)) {
                const address = formatNominatimAddress(data);
                fillAddressField(address);
                resolve(address);
              } else {
                throw new Error('No address data received');
              }
            })
            .catch(error => {
              clearTimeout(timeoutId);
              console.warn('Nominatim geocoding failed:', error);
              
              // Method 3: Fallback to generating address from coordinates
              generateFallbackAddress(lat, lng)
                .then(address => {
                  fillAddressField(address);
                  resolve(address);
                })
                .catch(() => {
                  reject('All address lookup methods failed');
                });
            });
        }
      });
    }

    // Generate a basic address when all geocoding fails
    function generateFallbackAddress(lat, lng) {
      return new Promise((resolve) => {
        // Create a basic address format
        const latDir = lat >= 0 ? 'N' : 'S';
        const lngDir = lng >= 0 ? 'E' : 'W';
        const basicAddress = `${Math.abs(lat).toFixed(4)}°${latDir}, ${Math.abs(lng).toFixed(4)}°${lngDir}`;
        
        // Try to determine rough location based on coordinates
        let region = 'Unknown Location';
        
        // Very basic region detection (this is simplified)
        if (lat >= 1 && lat <= 7 && lng >= 100 && lng <= 120) {
          region = 'Southeast Asia';
        } else if (lat >= -6 && lat <= 6 && lng >= 95 && lng <= 141) {
          region = 'Indonesia/Malaysia Region';
        } else if (lat >= 25 && lat <= 50 && lng >= -125 && lng <= -66) {
          region = 'United States';
        } else if (lat >= 36 && lat <= 71 && lng >= -10 && lng <= 40) {
          region = 'Europe';
        }
        
        const fallbackAddress = `Near ${basicAddress} (${region})`;
        resolve(fallbackAddress);
      });
    }

    // Format Nominatim response into readable address
    function formatNominatimAddress(data) {
      const address = data.address || {};
      const parts = [];
      
      // Build address from specific to general
      if (address.house_number && address.road) {
        parts.push(`${address.house_number} ${address.road}`);
      } else if (address.road) {
        parts.push(address.road);
      }
      
      if (address.neighbourhood) {
        parts.push(address.neighbourhood);
      } else if (address.suburb) {
        parts.push(address.suburb);
      }
      
      if (address.city) {
        parts.push(address.city);
      } else if (address.town) {
        parts.push(address.town);
      } else if (address.village) {
        parts.push(address.village);
      }
      
      if (address.state) {
        parts.push(address.state);
      }
      
      if (address.postcode) {
        parts.push(address.postcode);
      }
      
      if (address.country) {
        parts.push(address.country);
      }
      
      // If we couldn't build a proper address, use the display name
      return parts.length > 0 ? parts.join(', ') : data.display_name;
    }

    // Fill the address field and trigger validation
    function fillAddressField(address) {
      const addressField = document.getElementById('address');
      const undoBtn = document.getElementById('undoAddressBtn');
      
      if (addressField && address) {
        // Store original value in case user wants to undo
        addressField.setAttribute('data-original', addressField.value);
        addressField.value = address;
        
        // Show undo button if there was original content or if auto-filled
        if (undoBtn) {
          undoBtn.style.display = 'inline-block';
        }
        
        // Trigger validation for the address field
        addressField.dispatchEvent(new Event('input'));
        addressField.dispatchEvent(new Event('blur'));
        
        // Add a visual indicator that field was auto-filled
        addressField.style.backgroundColor = 'rgba(16, 185, 129, 0.1)';
        addressField.style.border = '2px solid #10B981';
        addressField.style.transition = 'all 0.5s ease';
        
        // Add a small "auto-filled" indicator
        let indicator = document.getElementById('address-auto-indicator');
        if (!indicator) {
          indicator = document.createElement('div');
          indicator.id = 'address-auto-indicator';
          indicator.style.cssText = `
            position: absolute;
            top: -8px;
            right: 8px;
            background: #10B981;
            color: white;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 10px;
            font-weight: 600;
            z-index: 10;
            opacity: 0;
            transition: opacity 0.3s ease;
          `;
          indicator.textContent = '✓ Auto-filled';
          addressField.parentElement.style.position = 'relative';
          addressField.parentElement.appendChild(indicator);
        }
        
        // Show indicator
        setTimeout(() => {
          indicator.style.opacity = '1';
        }, 100);
        
        // Gradually remove visual indicators
        setTimeout(() => {
          addressField.style.backgroundColor = '';
          addressField.style.border = '';
          indicator.style.opacity = '0';
          
          setTimeout(() => {
            if (indicator && indicator.parentNode) {
              indicator.parentNode.removeChild(indicator);
            }
          }, 300);
        }, 3000);
        
        // Focus briefly to show user the field was filled
        addressField.focus();
        setTimeout(() => addressField.blur(), 500);
      }
    }

    // Undo address auto-fill
    function undoAddressFill() {
      const addressField = document.getElementById('address');
      const undoBtn = document.getElementById('undoAddressBtn');
      
      if (addressField) {
        const originalValue = addressField.getAttribute('data-original') || '';
        addressField.value = originalValue;
        
        // Hide undo button
        if (undoBtn) {
          undoBtn.style.display = 'none';
        }
        
        // Remove the original data attribute
        addressField.removeAttribute('data-original');
        
        // Trigger validation
        addressField.dispatchEvent(new Event('input'));
        addressField.dispatchEvent(new Event('blur'));
        
        // Show feedback
        showToast('Address auto-fill undone', 'info');
        
        // Focus the field for user to edit
        addressField.focus();
      }
    }

    // Toast notification system optimized for mobile
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
        line-height: 1.3;
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
      }, 4000);
    }

    // Handle network connectivity for mobile users
    window.addEventListener('online', function() {
      showToast('Connection restored', 'success');
    });

    window.addEventListener('offline', function() {
      showToast('No internet connection', 'warning');
    });
  </script>
</body>
</html>