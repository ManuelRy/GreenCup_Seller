<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register Business - GreenCup</title>
  <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" 
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <style>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
  background: linear-gradient(-45deg, #0f766e, #0d9488, #14b8a6, #5eead4);
  background-size: 400% 400%;
  animation: gradientShift 20s ease infinite;
  min-height: 100vh;
  padding: 2rem 1rem;
}

@keyframes gradientShift {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}

.container {
  max-width: 700px;
  margin: 0 auto;
}

.register-card {
  background: white;
  border-radius: 20px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
  overflow: hidden;
  margin-bottom: 2rem;
  border: 1px solid rgba(255, 255, 255, 0.2);
}

.card-header-custom {
  background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);
  padding: 2.5rem 2rem;
  text-align: center;
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

.mb-3 {
  margin-bottom: 1.5rem;
}

.mb-4 {
  margin-bottom: 2rem;
}

.alert {
  border-radius: 12px;
  padding: 1rem 1.25rem;
  margin-bottom: 1.5rem;
  border: none;
}

.alert-success {
  background: #d1fae5;
  color: #065f46;
  border-left: 4px solid #10b981;
}

.alert-danger {
  background: #fee2e2;
  color: #991b1b;
  border-left: 4px solid #ef4444;
}

.progress-bar-container {
  margin-bottom: 2rem;
}

.progress {
  height: 8px;
  border-radius: 10px;
  background: #e5e7eb;
}

.progress-bar {
  background: linear-gradient(90deg, #14b8a6, #0d9488);
  border-radius: 10px;
  transition: width 0.3s ease;
}

.form-label {
  font-weight: 600;
  color: #374151;
  margin-bottom: 0.5rem;
  font-size: 0.95rem;
  display: block;
}

.form-label .text-muted {
  color: #9ca3af;
  font-weight: 400;
  font-size: 0.875rem;
}

.input-wrapper {
  position: relative;
  display: block;
  width: 100%;
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

.form-control,
.form-select {
  border: 2px solid #e5e7eb;
  border-radius: 12px;
  padding: 0.875rem 1rem 0.875rem 3rem;
  font-size: 1rem;
  transition: all 0.3s ease;
  background: white;
  width: 100%;
}

.form-control:focus,
.form-select:focus {
  border-color: #0d9488;
  box-shadow: 0 0 0 4px rgba(13, 148, 136, 0.1);
  background: white;
  outline: none;
}

.form-control:focus + .input-icon,
.form-select:focus + .input-icon {
  color: #0d9488;
}

.form-control.is-invalid,
.form-select.is-invalid {
  border-color: #ef4444;
  background: #fef2f2;
}

.form-control::placeholder {
  color: #d1d5db;
}

textarea.form-control {
  padding: 0.875rem 1rem;
  min-height: 120px;
  resize: vertical;
}

.invalid-feedback {
  display: block;
  color: #ef4444;
  font-size: 0.875rem;
  margin-top: 0.5rem;
}

.invalid-feedback i {
  margin-right: 0.25rem;
}

textarea.form-control {
  min-height: 100px;
  resize: vertical;
}

.custom-hours-input {
  margin-top: 0.75rem;
  display: none;
}

.btn-secondary-custom {
  background: white;
  border: 2px solid #e5e7eb;
  border-radius: 12px;
  padding: 0.875rem 1.5rem;
  font-size: 1rem;
  font-weight: 600;
  color: #374151;
  transition: all 0.3s ease;
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  cursor: pointer;
  text-decoration: none;
}

.btn-secondary-custom:hover {
  transform: translateY(-2px);
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  background: #f9fafb;
  border-color: #d1d5db;
  color: #374151;
  text-decoration: none;
}

.btn-primary-custom {
  background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
  border: none;
  border-radius: 12px;
  padding: 1rem 1.5rem;
  font-size: 1.125rem;
  font-weight: 700;
  color: white;
  width: 100%;
  transition: all 0.3s ease;
  box-shadow: 0 4px 12px rgba(13, 148, 136, 0.25);
  cursor: pointer;
}

.btn-primary-custom:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(13, 148, 136, 0.35);
  background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);
}

.btn-primary-custom:disabled {
  opacity: 0.6;
  cursor: not-allowed;
  transform: none;
}

.password-strength {
  height: 6px;
  background: #e5e7eb;
  border-radius: 3px;
  margin-top: 0.5rem;
  overflow: hidden;
}

.password-strength-bar {
  height: 100%;
  width: 0%;
  transition: all 0.3s;
  border-radius: 3px;
}

.password-help {
  font-size: 0.875rem;
  margin-top: 0.375rem;
  color: #6b7280;
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

.form-check-label a {
  color: #0d9488;
  text-decoration: none;
  font-weight: 600;
}

.form-check-label a:hover {
  text-decoration: underline;
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

.login-link {
  text-align: center;
  margin-top: 0;
}

.login-link p {
  color: #6b7280;
  margin-bottom: 0.75rem;
  font-size: 0.95rem;
}

.login-link a {
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

.login-link a:hover {
  background: rgba(13, 148, 136, 0.1);
  transform: translateX(3px);
}

.spinner-border-sm {
  width: 1rem;
  height: 1rem;
  border-width: 0.15em;
}

@media (max-width: 576px) {
  body {
    padding: 1rem 0.5rem;
  }

  .register-card {
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
</head>

<body>
  <div class="container">
    <div class="register-card">
      <div class="card-header-custom">
        <div class="logo-circle">
          <i class="fas fa-store"></i>
        </div>
        <h2>Business Registration</h2>
        <p>Join GreenCup as a seller</p>
      </div>

      <div class="card-body-custom">
        @if(session('success'))
          <div class="alert alert-success">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
          </div>
        @endif

        @if(session('error'))
          <div class="alert alert-danger">
            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
          </div>
        @endif

        @if($errors->any())
          <div class="alert alert-danger">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-2">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <div class="progress-bar-container">
          <div class="progress">
            <div class="progress-bar" id="progressBar" role="progressbar" style="width: 0%"></div>
          </div>
        </div>

        <form action="{{ route('sellers.store') }}" method="POST" id="registrationForm" novalidate>
          @csrf

          <div class="mb-3">
            <label for="business_name" class="form-label">
              Business Name
            </label>
            <div class="input-wrapper">
              <i class="fas fa-store input-icon"></i>
              <input type="text" id="business_name" name="business_name" value="{{ old('business_name') }}"
                class="form-control @error('business_name') is-invalid @enderror"
                placeholder="Enter your business name" required />
            </div>
            @error('business_name')
              <div class="invalid-feedback">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ $message }}</span>
              </div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">
              Email Address
            </label>
            <div class="input-wrapper">
              <i class="fas fa-envelope input-icon"></i>
              <input type="email" id="email" name="email" value="{{ old('email') }}"
                class="form-control @error('email') is-invalid @enderror"
                placeholder="your.email@example.com" required />
            </div>
            @error('email')
              <div class="invalid-feedback">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ $message }}</span>
              </div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="phone" class="form-label">
              Phone Number <span class="text-muted">(optional)</span>
            </label>
            <div class="input-wrapper">
              <i class="fas fa-phone input-icon"></i>
              <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                class="form-control @error('phone') is-invalid @enderror"
                placeholder="+855 12 345 678" />
            </div>
            @error('phone')
              <div class="invalid-feedback">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ $message }}</span>
              </div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="description" class="form-label">
              Business Description <span class="text-muted">(optional)</span>
            </label>
            <textarea id="description" name="description"
              class="form-control @error('description') is-invalid @enderror"
              placeholder="Describe your business, products, or services"
              maxlength="1000">{{ old('description') }}</textarea>
            @error('description')
              <div class="invalid-feedback">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ $message }}</span>
              </div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="working_hours" class="form-label">
              Working Hours <span class="text-muted">(optional)</span>
            </label>
            <div class="input-wrapper">
              <i class="fas fa-clock input-icon"></i>
              <select id="working_hours" name="working_hours" class="form-select @error('working_hours') is-invalid @enderror">
                <option value="">-- Select Working Hours --</option>
                <optgroup label="Standard Business Hours">
                  <option value="Mon-Fri 9AM-5PM" {{ old('working_hours') == 'Mon-Fri 9AM-5PM' ? 'selected' : '' }}>Mon-Fri 9AM-5PM</option>
                  <option value="Mon-Fri 8AM-6PM" {{ old('working_hours') == 'Mon-Fri 8AM-6PM' ? 'selected' : '' }}>Mon-Fri 8AM-6PM</option>
                </optgroup>
                <optgroup label="Including Saturday">
                  <option value="Mon-Sat 9AM-5PM" {{ old('working_hours') == 'Mon-Sat 9AM-5PM' ? 'selected' : '' }}>Mon-Sat 9AM-5PM</option>
                  <option value="Mon-Sat 8AM-6PM" {{ old('working_hours') == 'Mon-Sat 8AM-6PM' ? 'selected' : '' }}>Mon-Sat 8AM-6PM</option>
                </optgroup>
                <optgroup label="7 Days a Week">
                  <option value="Mon-Sun 9AM-5PM" {{ old('working_hours') == 'Mon-Sun 9AM-5PM' ? 'selected' : '' }}>Mon-Sun 9AM-5PM</option>
                  <option value="24/7" {{ old('working_hours') == '24/7' ? 'selected' : '' }}>24/7 (Always Open)</option>
                </optgroup>
                <optgroup label="Custom">
                  <option value="custom" {{ old('working_hours') == 'custom' ? 'selected' : '' }}>Custom Hours</option>
                </optgroup>
              </select>
            </div>

            <div id="customHoursInput" class="custom-hours-input">
              <input type="text" id="custom_working_hours" name="custom_working_hours"
                value="{{ old('custom_working_hours') }}" class="form-control"
                placeholder="e.g., Mon-Wed 9AM-1PM, Thu-Fri 2PM-6PM" />
            </div>

            @error('working_hours')
              <div class="invalid-feedback">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ $message }}</span>
              </div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="address" class="form-label">
              Business Address
            </label>
            <textarea id="address" name="address"
              class="form-control @error('address') is-invalid @enderror"
              placeholder="Enter your complete business address" required>{{ old('address') }}</textarea>
            @error('address')
              <div class="invalid-feedback">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ $message }}</span>
              </div>
            @enderror
          </div>

          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label for="latitude" class="form-label">
                Latitude
              </label>
              <div class="input-wrapper">
                <i class="fas fa-map input-icon"></i>
                <input type="number" step="any" id="latitude" name="latitude" value="{{ old('latitude') }}"
                  class="form-control @error('latitude') is-invalid @enderror"
                  placeholder="e.g., 11.5564" required min="-90" max="90" />
              </div>
              @error('latitude')
                <div class="invalid-feedback">
                  <i class="fas fa-exclamation-circle"></i>
                  <span>{{ $message }}</span>
                </div>
              @enderror
            </div>

            <div class="col-md-6">
              <label for="longitude" class="form-label">
                Longitude
              </label>
              <div class="input-wrapper">
                <i class="fas fa-map input-icon"></i>
                <input type="number" step="any" id="longitude" name="longitude" value="{{ old('longitude') }}"
                  class="form-control @error('longitude') is-invalid @enderror"
                  placeholder="e.g., 104.9282" required min="-180" max="180" />
              </div>
              @error('longitude')
                <div class="invalid-feedback">
                  <i class="fas fa-exclamation-circle"></i>
                  <span>{{ $message }}</span>
                </div>
              @enderror
            </div>
          </div>

          <div class="text-center mb-4">
            <button type="button" onclick="getCurrentLocation()" id="locationButton" class="btn-secondary-custom">
              <i class="fas fa-location-arrow" id="locationIcon"></i>
              <span id="locationText">Get My Location</span>
            </button>
          </div>

          <!-- Map for Location Selection -->
          <div class="mb-4">
            <label class="form-label">
              Select Location on Map
            </label>
            <p class="text-muted small mb-2">Click on the map to set your business location, or use the button above to get your current location</p>
            <div id="registrationMap" style="height: 400px; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1);"></div>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">
              Password
            </label>
            <div class="input-wrapper">
              <i class="fas fa-lock input-icon"></i>
              <input type="password" id="password" name="password"
                class="form-control @error('password') is-invalid @enderror"
                placeholder="Create a strong password (min 8 characters)" required minlength="8" autocomplete="new-password" />
            </div>
            <div class="password-strength">
              <div class="password-strength-bar" id="passwordStrength"></div>
            </div>
            <p class="password-help" id="passwordHelp">
              Password strength: <span id="strengthText">Enter password</span>
            </p>
            @error('password')
              <div class="invalid-feedback">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ $message }}</span>
              </div>
            @enderror
          </div>

          <div class="mb-4">
            <label for="password_confirmation" class="form-label">
              Confirm Password
            </label>
            <div class="input-wrapper">
              <i class="fas fa-lock input-icon"></i>
              <input type="password" id="password_confirmation" name="password_confirmation"
                class="form-control @error('password_confirmation') is-invalid @enderror"
                placeholder="Confirm your password" required autocomplete="new-password" />
            </div>
            @error('password_confirmation')
              <div class="invalid-feedback">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ $message }}</span>
              </div>
            @enderror
          </div>

          <div class="mb-4">
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
              <label class="form-check-label" for="terms">
                I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
              </label>
            </div>
          </div>

          <button type="submit" id="submitButton" class="btn btn-primary-custom">
            <span id="submitIcon"><i class="fas fa-store me-2"></i></span>
            <span id="submitText">Register Business</span>
          </button>
        </form>

        <div class="divider">
          <span>or</span>
        </div>

        <div class="login-link">
          <p>Already have a business account?</p>
          <a href="{{ route('login') }}">
            <i class="fas fa-sign-in-alt"></i>
            <span>Sign In Instead</span>
          </a>
        </div>
      </div>
    </div>
  </div>

  <script>
document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('registrationForm');
  const progressBar = document.getElementById('progressBar');
  const requiredFields = ['business_name', 'email', 'address', 'latitude', 'longitude', 'password', 'password_confirmation'];

  function updateProgress() {
    let filledFields = 0;
    requiredFields.forEach(fieldName => {
      const field = document.getElementById(fieldName);
      if (field && field.value.trim()) {
        filledFields++;
      }
    });
    const percentage = Math.round((filledFields / requiredFields.length) * 100);
    progressBar.style.width = percentage + '%';
  }

  function checkPasswordStrength(password) {
    const strengthBar = document.getElementById('passwordStrength');
    const strengthText = document.getElementById('strengthText');

    if (!password) {
      strengthBar.style.width = '0%';
      strengthText.textContent = 'Enter password';
      strengthText.style.color = '#6b7280';
      return;
    }

    let strength = 0;
    let requirements = [];

    // Check minimum length (required)
    if (password.length >= 8) {
      strength++;
    } else {
      requirements.push('8+ characters');
    }

    // Check uppercase (required)
    if (/[A-Z]/.test(password)) {
      strength++;
    } else {
      requirements.push('uppercase letter');
    }

    // Check special character (required)
    if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
      strength++;
    } else {
      requirements.push('special character');
    }

    // Bonus points for additional complexity
    if (/[a-z]/.test(password)) strength++;
    if (/\d/.test(password)) strength++;

    const colors = ['#ef4444', '#f59e0b', '#eab308', '#22c55e', '#10b981'];
    const labels = ['Very Weak', 'Weak', 'Fair', 'Good', 'Strong'];
    const widths = ['20%', '40%', '60%', '80%', '100%'];

    strengthBar.style.width = widths[strength - 1] || '20%';
    strengthBar.style.backgroundColor = colors[strength - 1] || colors[0];

    if (requirements.length > 0) {
      strengthText.textContent = 'Missing: ' + requirements.join(', ');
      strengthText.style.color = '#ef4444';
    } else {
      strengthText.textContent = labels[strength - 1] || labels[0];
      strengthText.style.color = colors[strength - 1] || colors[0];
    }
  }

  document.getElementById('working_hours').addEventListener('change', function() {
    const customInput = document.getElementById('customHoursInput');
    const customField = document.getElementById('custom_working_hours');

    if (this.value === 'custom') {
      customInput.style.display = 'block';
      customField.required = true;
    } else {
      customInput.style.display = 'none';
      customField.required = false;
      customField.value = '';
    }
    updateProgress();
  });

  if (document.getElementById('working_hours').value === 'custom') {
    document.getElementById('customHoursInput').style.display = 'block';
    document.getElementById('custom_working_hours').required = true;
  }

  document.querySelectorAll('input, textarea, select').forEach(field => {
    field.addEventListener('input', function() {
      this.classList.remove('is-invalid');
      const errorElement = this.parentElement.querySelector('.invalid-feedback');
      if (errorElement) {
        errorElement.style.display = 'none';
      }

      if (this.name === 'password') {
        checkPasswordStrength(this.value);
      }

      updateProgress();
    });
  });

  form.addEventListener('submit', function(e) {
    const button = document.getElementById('submitButton');
    const icon = document.getElementById('submitIcon');
    const text = document.getElementById('submitText');

    const termsCheckbox = document.getElementById('terms');
    if (!termsCheckbox.checked) {
      e.preventDefault();
      alert('Please agree to the Terms of Service and Privacy Policy to continue.');
      return;
    }

    const workingHoursSelect = document.getElementById('working_hours');
    const customHours = document.getElementById('custom_working_hours');

    if (workingHoursSelect.value === 'custom') {
      if (!customHours.value.trim()) {
        e.preventDefault();
        alert('Please enter your custom working hours.');
        customHours.focus();
        return;
      }
      workingHoursSelect.value = customHours.value;
    }

    button.disabled = true;
    icon.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>';
    text.textContent = 'Creating Account...';

    setTimeout(() => {
      button.disabled = false;
      icon.innerHTML = '<i class="fas fa-store me-2"></i>';
      text.textContent = 'Register Business';
    }, 15000);
  });

  updateProgress();
});

function getCurrentLocation() {
  const button = document.getElementById('locationButton');
  const icon = document.getElementById('locationIcon');
  const text = document.getElementById('locationText');

  button.disabled = true;
  icon.className = 'spinner-border spinner-border-sm';
  text.textContent = 'Getting Location...';

  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      async function(position) {
        const lat = position.coords.latitude;
        const lng = position.coords.longitude;

        document.getElementById('latitude').value = lat.toFixed(7);
        document.getElementById('longitude').value = lng.toFixed(7);

        document.getElementById('latitude').dispatchEvent(new Event('input'));
        document.getElementById('longitude').dispatchEvent(new Event('input'));

        // Update map marker
        updateMapFromInputs();

        text.textContent = 'Getting Address...';

        try {
          await reverseGeocode(lat, lng);
          icon.className = 'fas fa-check';
          text.textContent = 'Location Captured!';
        } catch (error) {
          icon.className = 'fas fa-check';
          text.textContent = 'Location Captured!';
        }

        setTimeout(() => {
          button.disabled = false;
          icon.className = 'fas fa-location-arrow';
          text.textContent = 'Get My Location';
        }, 3000);
      },
      function(error) {
        icon.className = 'fas fa-exclamation-triangle';
        text.textContent = 'Location Failed';

        setTimeout(() => {
          button.disabled = false;
          icon.className = 'fas fa-location-arrow';
          text.textContent = 'Get My Location';
        }, 3000);

        alert('Unable to get your location. Please enter coordinates manually.');
      },
      {
        enableHighAccuracy: true,
        timeout: 15000,
        maximumAge: 0
      }
    );
  } else {
    icon.className = 'fas fa-exclamation-triangle';
    text.textContent = 'Not Supported';

    setTimeout(() => {
      button.disabled = false;
      icon.className = 'fas fa-location-arrow';
      text.textContent = 'Get My Location';
    }, 3000);

    alert('Geolocation is not supported by this browser.');
  }
}

async function reverseGeocode(lat, lng) {
  try {
    const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`, {
      headers: { 'User-Agent': 'GreenCup Business Registration' }
    });

    if (response.ok) {
      const data = await response.json();
      if (data && data.display_name) {
        document.getElementById('address').value = data.display_name;
        document.getElementById('address').dispatchEvent(new Event('input'));
      }
    }
  } catch (error) {
    console.warn('Address lookup failed:', error);
  }
}

// Initialize Leaflet Map
let map, marker;

document.addEventListener('DOMContentLoaded', function() {
  // Default location (Phnom Penh, Cambodia)
  const defaultLat = 11.5564;
  const defaultLng = 104.9282;

  // Initialize map
  map = L.map('registrationMap').setView([defaultLat, defaultLng], 13);

  // Add OpenStreetMap tiles
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors',
    maxZoom: 19
  }).addTo(map);

  // Custom marker icon
  const customIcon = L.divIcon({
    className: 'custom-marker',
    html: '<div style="background: linear-gradient(135deg, #0d9488, #0f766e); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(13, 148, 136, 0.4); border: 3px solid white;"><i class="fas fa-store" style="color: white; font-size: 16px;"></i></div>',
    iconSize: [40, 40],
    iconAnchor: [20, 40]
  });

  // Add initial marker if lat/lng already exist
  const latInput = document.getElementById('latitude');
  const lngInput = document.getElementById('longitude');

  if (latInput.value && lngInput.value) {
    const lat = parseFloat(latInput.value);
    const lng = parseFloat(lngInput.value);
    marker = L.marker([lat, lng], {icon: customIcon}).addTo(map);
    map.setView([lat, lng], 15);
  }

  // Handle map clicks
  map.on('click', async function(e) {
    const lat = e.latlng.lat;
    const lng = e.latlng.lng;

    // Update inputs
    latInput.value = lat.toFixed(7);
    lngInput.value = lng.toFixed(7);

    // Trigger input events for validation
    latInput.dispatchEvent(new Event('input'));
    lngInput.dispatchEvent(new Event('input'));

    // Remove old marker if exists
    if (marker) {
      map.removeLayer(marker);
    }

    // Add new marker
    marker = L.marker([lat, lng], {icon: customIcon}).addTo(map)
      .bindPopup('Getting address...<br><small>' + lat.toFixed(6) + ', ' + lng.toFixed(6) + '</small>')
      .openPopup();

    // Get address from coordinates
    try {
      await reverseGeocode(lat, lng);
      marker.setPopupContent('Your Business Location<br><small>' + lat.toFixed(6) + ', ' + lng.toFixed(6) + '</small>');
    } catch (error) {
      marker.setPopupContent('Your Business Location<br><small>' + lat.toFixed(6) + ', ' + lng.toFixed(6) + '</small>');
    }
  });

  // Update map when coordinates are manually entered
  latInput.addEventListener('change', updateMapFromInputs);
  lngInput.addEventListener('change', updateMapFromInputs);
});

function updateMapFromInputs() {
  const latInput = document.getElementById('latitude');
  const lngInput = document.getElementById('longitude');

  if (latInput.value && lngInput.value) {
    const lat = parseFloat(latInput.value);
    const lng = parseFloat(lngInput.value);

    if (!isNaN(lat) && !isNaN(lng) && lat >= -90 && lat <= 90 && lng >= -180 && lng <= 180) {
      if (marker) {
        map.removeLayer(marker);
      }

      const customIcon = L.divIcon({
        className: 'custom-marker',
        html: '<div style="background: linear-gradient(135deg, #0d9488, #0f766e); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(13, 148, 136, 0.4); border: 3px solid white;"><i class="fas fa-store" style="color: white; font-size: 16px;"></i></div>',
        iconSize: [40, 40],
        iconAnchor: [20, 40]
      });

      marker = L.marker([lat, lng], {icon: customIcon}).addTo(map)
        .bindPopup('Your Business Location<br><small>' + lat.toFixed(6) + ', ' + lng.toFixed(6) + '</small>');
      map.setView([lat, lng], 15);
    }
  }
}
  </script>

  <!-- Leaflet JS -->
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
</body>
</html>
