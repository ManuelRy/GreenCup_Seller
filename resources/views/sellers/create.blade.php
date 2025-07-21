<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register Business - GreenCup</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(-45deg, #10B981, #059669, #047857, #064E3B, #10B981);
      background-size: 400% 400%;
      animation: gradientShift 15s ease infinite;
      min-height: 100vh;
      font-family: 'Inter', sans-serif;
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
    }
    
    .btn-premium:hover {
      transform: translateY(-2px);
      box-shadow: 0 12px 40px rgba(16, 185, 129, 0.4);
    }
    
    .btn-premium:disabled {
      opacity: 0.7;
      cursor: not-allowed;
      transform: none;
    }
    
    .input-premium {
      background: rgba(255, 255, 255, 0.1);
      border: 2px solid rgba(16, 185, 129, 0.3);
      color: white;
      transition: all 0.3s ease;
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

    .success-input {
      border-color: #10B981 !important;
      box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.2) !important;
    }

    .password-strength {
      height: 4px;
      border-radius: 2px;
      margin-top: 8px;
      background: rgba(255, 255, 255, 0.2);
      overflow: hidden;
    }

    .strength-bar {
      height: 100%;
      transition: all 0.3s ease;
      border-radius: 2px;
    }

    .field-group {
      position: relative;
    }

    .validation-icon {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 16px;
    }

    .tooltip {
      position: relative;
      cursor: help;
    }

    .tooltip::after {
      content: attr(data-tooltip);
      position: absolute;
      bottom: 100%;
      left: 50%;
      transform: translateX(-50%);
      background: rgba(0, 0, 0, 0.8);
      color: white;
      padding: 8px 12px;
      border-radius: 6px;
      font-size: 12px;
      white-space: nowrap;
      opacity: 0;
      pointer-events: none;
      transition: opacity 0.3s ease;
      z-index: 1000;
    }

    .tooltip:hover::after {
      opacity: 1;
    }

    /* Custom dropdown styling */
    .select-premium {
      background-image: url('data:image/svg+xml;charset=US-ASCII,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 4 5"><path fill="%23ffffff" d="M2 0L0 2h4zm0 5L0 3h4z"/></svg>');
      background-repeat: no-repeat;
      background-position: right 1rem center;
      background-size: 0.75rem;
      color-scheme: dark;
      appearance: none;
    }

    .select-premium option {
      background: #047857;
      color: white;
      padding: 10px;
    }

    .select-premium optgroup {
      background: #064E3B;
      color: #D1FAE5;
      font-weight: bold;
    }
  </style>
</head>
<body class="py-8 px-4">
  <!-- Mobile Back Button -->
  <div class="md:hidden fixed top-4 left-4 z-50">
    <button onclick="history.back()" class="flex items-center justify-center w-12 h-12 glass rounded-full text-white hover:bg-white hover:bg-opacity-20 transition-all">
      <i class="fas fa-arrow-left text-lg"></i>
    </button>
  </div>

  <div class="w-full max-w-lg mx-auto">
    <div class="glass rounded-3xl p-10 shadow-2xl">
      <!-- Logo and Header -->
      <div class="text-center mb-10">
        <div class="inline-flex items-center justify-center w-24 h-24 glass rounded-full mb-6">
          <i class="fas fa-store text-4xl text-white"></i>
        </div>
        <h1 class="text-4xl font-bold text-white mb-3">Business Registration</h1>
        <p class="text-green-100 text-lg">Join GreenCup as a seller</p>
      </div>

      <!-- Success Message -->
      @if(session('success'))
        <div class="mb-6 px-4 py-3 glass rounded-lg border-l-4 border-green-400" id="successAlert">
          <div class="flex items-center">
            <i class="fas fa-check-circle text-green-400 mr-3"></i>
            <span class="text-white">{{ session('success') }}</span>
          </div>
        </div>
      @endif

      <!-- System Error Messages -->
      @if(session('error'))
      <div class="mb-6 px-4 py-3 glass rounded-lg border-l-4 border-red-400">
        <div class="flex items-start">
          <i class="fas fa-exclamation-triangle text-red-400 mr-3 mt-0.5"></i>
          <div>
            <p class="text-white font-medium mb-2">System Error:</p>
            <p class="text-red-100 text-sm">{{ session('error') }}</p>
          </div>
        </div>
      </div>
      @endif

      <!-- Validation Error Messages -->
      @if($errors->any())
        <div class="mb-6 px-4 py-3 glass rounded-lg border-l-4 border-red-400" id="errorAlert">
          <div class="flex items-start">
            <i class="fas fa-exclamation-triangle text-red-400 mr-3 mt-0.5"></i>
            <div>
              <p class="text-white font-medium mb-2">Please fix the following errors:</p>
              <ul class="text-red-100 text-sm space-y-1 list-disc list-inside">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
      @endif

      <!-- Registration Progress Bar -->
      <div class="mb-8">
        <div class="flex justify-between text-white text-xs mb-2">
          <span>Registration Progress</span>
          <span id="progressText">0% Complete</span>
        </div>
        <div class="w-full bg-gray-300 rounded-full h-2">
          <div class="bg-gradient-to-r from-green-400 to-green-600 h-2 rounded-full transition-all duration-300" 
               style="width: 0%" id="progressBar"></div>
        </div>
      </div>

      <form action="{{ route('sellers.store') }}" method="POST" class="space-y-6" id="registrationForm" novalidate>
        @csrf
        
        <!-- Business Name -->
        <div class="field-group">
          <label for="business_name" class="block text-white font-medium mb-2">
            <i class="fas fa-store mr-2 text-green-400"></i>Business Name *
            <span class="tooltip text-green-300" data-tooltip="The official name of your business">ⓘ</span>
          </label>
          <div class="relative">
            <input type="text" id="business_name" name="business_name" value="{{ old('business_name') }}"
              class="w-full input-premium glass rounded-xl px-5 py-4 pr-12 text-white placeholder-green-200 focus:outline-none @error('business_name') error-input @enderror"
              placeholder="Enter your business name" required minlength="2" maxlength="255" />
            <div class="validation-icon" id="business_name_icon"></div>
          </div>
          @error('business_name')
            <p class="mt-2 text-red-300 text-sm flex items-center" id="business_name_error">
              <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
            </p>
          @enderror
        </div>

        <!-- Business Email -->
        <div class="field-group">
          <label for="email" class="block text-white font-medium mb-2">
            <i class="fas fa-envelope mr-2 text-green-400"></i>Business Email *
            <span class="tooltip text-green-300" data-tooltip="Email address for your business account">ⓘ</span>
          </label>
          <div class="relative">
            <input type="email" id="email" name="email" value="{{ old('email') }}"
              class="w-full input-premium glass rounded-xl px-5 py-4 pr-12 text-white placeholder-green-200 focus:outline-none @error('email') error-input @enderror"
              placeholder="Enter your business email" required />
            <div class="validation-icon" id="email_icon"></div>
          </div>
          @error('email')
            <p class="mt-2 text-red-300 text-sm flex items-center" id="email_error">
              <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
            </p>
          @enderror
        </div>

        <!-- Phone Number -->
        <div class="field-group">
          <label for="phone" class="block text-white font-medium mb-2">
            <i class="fas fa-phone mr-2 text-green-400"></i>Phone Number
            <span class="text-green-200 font-normal">(optional)</span>
          </label>
          <div class="relative">
            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
              class="w-full input-premium glass rounded-xl px-5 py-4 pr-12 text-white placeholder-green-200 focus:outline-none @error('phone') error-input @enderror"
              placeholder="Enter business phone number" />
            <div class="validation-icon" id="phone_icon"></div>
          </div>
          @error('phone')
            <p class="mt-2 text-red-300 text-sm flex items-center" id="phone_error">
              <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
            </p>
          @enderror
        </div>

        <!-- Business Description -->
        <div class="field-group">
          <label for="description" class="block text-white font-medium mb-2">
            <i class="fas fa-file-text mr-2 text-green-400"></i>Business Description
            <span class="text-green-200 font-normal">(optional)</span>
          </label>
          <textarea id="description" name="description" rows="3" maxlength="1000"
            class="w-full input-premium glass rounded-xl px-5 py-4 text-white placeholder-green-200 focus:outline-none resize-vertical @error('description') error-input @enderror"
            placeholder="Describe your business, products, or services">{{ old('description') }}</textarea>
          <div class="text-right text-green-200 text-xs mt-1">
            <span id="description_count">0</span>/1000 characters
          </div>
          @error('description')
            <p class="mt-2 text-red-300 text-sm flex items-center" id="description_error">
              <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
            </p>
          @enderror
        </div>

        <!-- Working Hours -->
        <div class="field-group">
          <label for="working_hours" class="block text-white font-medium mb-2">
            <i class="fas fa-clock mr-2 text-green-400"></i>Working Hours
            <span class="text-green-200 font-normal">(optional)</span>
          </label>
          <select id="working_hours" name="working_hours"
            class="w-full input-premium glass rounded-xl px-5 py-4 text-white focus:outline-none select-premium @error('working_hours') error-input @enderror">
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
            
            <!-- Retail/Restaurant Hours -->
            <optgroup label="🛍️ Retail & Restaurant">
              <option value="Mon-Thu 10AM-9PM, Fri-Sat 10AM-10PM, Sun 12PM-8PM" {{ old('working_hours') == 'Mon-Thu 10AM-9PM, Fri-Sat 10AM-10PM, Sun 12PM-8PM' ? 'selected' : '' }}>
                Mall Hours (Longer Weekends)
              </option>
              <option value="Mon-Sun 10AM-10PM" {{ old('working_hours') == 'Mon-Sun 10AM-10PM' ? 'selected' : '' }}>
                Retail Hours (10AM-10PM Daily)
              </option>
              <option value="Mon-Sun 11AM-11PM" {{ old('working_hours') == 'Mon-Sun 11AM-11PM' ? 'selected' : '' }}>
                Restaurant Hours (11AM-11PM)
              </option>
              <option value="Mon-Thu 5PM-11PM, Fri-Sat 5PM-12AM, Sun 5PM-10PM" {{ old('working_hours') == 'Mon-Thu 5PM-11PM, Fri-Sat 5PM-12AM, Sun 5PM-10PM' ? 'selected' : '' }}>
                Dinner Service (Evenings Only)
              </option>
            </optgroup>
            
            <!-- Part-time/Flexible -->
            <optgroup label="⏰ Flexible & Part-time">
              <option value="Mon-Wed-Fri 9AM-3PM" {{ old('working_hours') == 'Mon-Wed-Fri 9AM-3PM' ? 'selected' : '' }}>
                Part-time (Mon/Wed/Fri Mornings)
              </option>
              <option value="Tue-Thu 2PM-8PM" {{ old('working_hours') == 'Tue-Thu 2PM-8PM' ? 'selected' : '' }}>
                Part-time (Tue/Thu Afternoons)
              </option>
              <option value="Weekends Only (Sat-Sun 9AM-6PM)" {{ old('working_hours') == 'Weekends Only (Sat-Sun 9AM-6PM)' ? 'selected' : '' }}>
                Weekends Only
              </option>
              <option value="By Appointment Only" {{ old('working_hours') == 'By Appointment Only' ? 'selected' : '' }}>
                By Appointment Only
              </option>
              <option value="Seasonal Hours (Call for Schedule)" {{ old('working_hours') == 'Seasonal Hours (Call for Schedule)' ? 'selected' : '' }}>
                Seasonal Hours
              </option>
            </optgroup>
            
            <!-- Services/Professional -->
            <optgroup label="💼 Professional Services">
              <option value="Mon-Fri 8AM-4PM" {{ old('working_hours') == 'Mon-Fri 8AM-4PM' ? 'selected' : '' }}>
                Early Professional (8AM-4PM)
              </option>
              <option value="Mon-Fri 10AM-7PM" {{ old('working_hours') == 'Mon-Fri 10AM-7PM' ? 'selected' : '' }}>
                Late Professional (10AM-7PM)
              </option>
              <option value="Mon-Fri 9AM-5PM, Sat 9AM-2PM" {{ old('working_hours') == 'Mon-Fri 9AM-5PM, Sat 9AM-2PM' ? 'selected' : '' }}>
                Weekdays + Saturday Morning
              </option>
              <option value="Emergency Service Available 24/7" {{ old('working_hours') == 'Emergency Service Available 24/7' ? 'selected' : '' }}>
                Emergency Service 24/7
              </option>
            </optgroup>
            
            <!-- Custom Option -->
            <optgroup label="✏️ Custom">
              <option value="custom" {{ old('working_hours') == 'custom' ? 'selected' : '' }}>
                Custom Hours (Specify Below)
              </option>
            </optgroup>
          </select>
          
          <!-- Custom Hours Input (shown when "custom" is selected) -->
          <div id="customHoursInput" style="display: none;" class="mt-3">
            <label for="custom_working_hours" class="block text-white font-medium mb-2 text-sm">
              <i class="fas fa-edit mr-2 text-green-400"></i>Enter your custom working hours:
            </label>
            <input type="text" id="custom_working_hours" name="custom_working_hours" 
                   value="{{ old('custom_working_hours') }}"
                   class="w-full input-premium glass rounded-xl px-5 py-3 text-white placeholder-green-200 focus:outline-none"
                   placeholder="e.g., Mon-Wed 9AM-1PM, Thu-Fri 2PM-6PM" />
          </div>
          
          @error('working_hours')
            <p class="mt-2 text-red-300 text-sm flex items-center" id="working_hours_error">
              <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
            </p>
          @enderror
        </div>

        <!-- Business Address -->
        <div class="field-group">
          <label for="address" class="block text-white font-medium mb-2">
            <i class="fas fa-map-marker-alt mr-2 text-green-400"></i>Business Address *
          </label>
          <textarea id="address" name="address" rows="2" required minlength="10" maxlength="500"
            class="w-full input-premium glass rounded-xl px-5 py-4 text-white placeholder-green-200 focus:outline-none resize-vertical @error('address') error-input @enderror"
            placeholder="Enter your complete business address">{{ old('address') }}</textarea>
          @error('address')
            <p class="mt-2 text-red-300 text-sm flex items-center" id="address_error">
              <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
            </p>
          @enderror
        </div>

        <!-- Location Coordinates -->
        <div class="grid grid-cols-2 gap-4">
          <div class="field-group">
            <label for="latitude" class="block text-white font-medium mb-2">
              <i class="fas fa-map mr-2 text-green-400"></i>Latitude *
            </label>
            <div class="relative">
              <input type="number" step="any" id="latitude" name="latitude" value="{{ old('latitude') }}" required
                class="w-full input-premium glass rounded-xl px-5 py-4 pr-12 text-white placeholder-green-200 focus:outline-none @error('latitude') error-input @enderror"
                placeholder="e.g., 11.5564" min="-90" max="90" />
              <div class="validation-icon" id="latitude_icon"></div>
            </div>
            @error('latitude')
              <p class="mt-2 text-red-300 text-sm flex items-center" id="latitude_error">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
              </p>
            @enderror
          </div>
          
          <div class="field-group">
            <label for="longitude" class="block text-white font-medium mb-2">
              <i class="fas fa-map mr-2 text-green-400"></i>Longitude *
            </label>
            <div class="relative">
              <input type="number" step="any" id="longitude" name="longitude" value="{{ old('longitude') }}" required
                class="w-full input-premium glass rounded-xl px-5 py-4 pr-12 text-white placeholder-green-200 focus:outline-none @error('longitude') error-input @enderror"
                placeholder="e.g., 104.9282" min="-180" max="180" />
              <div class="validation-icon" id="longitude_icon"></div>
            </div>
            @error('longitude')
              <p class="mt-2 text-red-300 text-sm flex items-center" id="longitude_error">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
              </p>
            @enderror
          </div>
        </div>

        <!-- Get Location Button -->
        <div class="text-center">
          <button type="button" onclick="getCurrentLocation()" id="locationButton"
            class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors flex items-center mx-auto">
            <i class="fas fa-location-arrow mr-2" id="locationIcon"></i>
            <span id="locationText">Get My Current Location</span>
          </button>
        </div>

        <!-- Password -->
        <div class="field-group">
          <label for="password" class="block text-white font-medium mb-2">
            <i class="fas fa-lock mr-2 text-green-400"></i>Password *
            <span class="tooltip text-green-300" data-tooltip="Must be at least 8 characters with uppercase, lowercase, and number">ⓘ</span>
          </label>
          <div class="relative">
            <input type="password" id="password" name="password"
              class="w-full input-premium glass rounded-xl px-5 py-4 pr-12 text-white placeholder-green-200 focus:outline-none @error('password') error-input @enderror"
              placeholder="Create a strong password (min 8 characters)" required minlength="8" />
            <button type="button" onclick="togglePassword('password')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-green-300 hover:text-white transition-colors">
              <i id="passwordToggle" class="fas fa-eye"></i>
            </button>
          </div>
          <div class="password-strength">
            <div class="strength-bar" id="passwordStrength"></div>
          </div>
          <p class="text-green-200 text-xs mt-1" id="passwordHelp">
            Password strength: <span id="strengthText">Enter password</span>
          </p>
          @error('password')
            <p class="mt-2 text-red-300 text-sm flex items-center" id="password_error">
              <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
            </p>
          @enderror
        </div>

        <!-- Confirm Password -->
        <div class="field-group">
          <label for="password_confirmation" class="block text-white font-medium mb-2">
            <i class="fas fa-lock mr-2 text-green-400"></i>Confirm Password *
          </label>
          <div class="relative">
            <input type="password" id="password_confirmation" name="password_confirmation"
              class="w-full input-premium glass rounded-xl px-5 py-4 pr-12 text-white placeholder-green-200 focus:outline-none @error('password_confirmation') error-input @enderror"
              placeholder="Confirm your password" required />
            <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-green-300 hover:text-white transition-colors">
              <i id="confirmPasswordToggle" class="fas fa-eye"></i>
            </button>
          </div>
          <div class="validation-icon" id="password_confirmation_icon" style="right: 45px;"></div>
          @error('password_confirmation')
            <p class="mt-2 text-red-300 text-sm flex items-center" id="password_confirmation_error">
              <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
            </p>
          @enderror
        </div>

        <!-- Terms Agreement -->
        <div class="flex items-start space-x-3">
          <input type="checkbox" id="terms" name="terms" required class="mt-1" />
          <label for="terms" class="text-white text-sm leading-relaxed cursor-pointer">
            I agree to the <a href="#" class="text-green-300 hover:text-green-200 underline">Terms of Service</a> 
            and <a href="#" class="text-green-300 hover:text-green-200 underline">Privacy Policy</a>
          </label>
        </div>

        <!-- Submit Button -->
        <button type="submit" id="submitButton"
          class="w-full btn-premium text-white font-semibold py-5 rounded-xl transition-all duration-300 flex items-center justify-center text-lg">
          <i class="fas fa-store mr-3" id="submitIcon"></i>
          <span id="submitText">Register Business</span>
        </button>
      </form>

      <!-- Login Link -->
      <div class="mt-10 text-center">
        <p class="text-green-100 mb-5 text-lg">Already have a business account?</p>
        <a href="{{ route('login') }}" class="inline-flex items-center text-white font-semibold text-xl hover:text-green-200 transition-colors">
          <i class="fas fa-sign-in-alt mr-3"></i>
          Sign In Instead
        </a>
      </div>

      <!-- Desktop Back Button -->
      <div class="hidden md:block mt-8 text-center">
        <button onclick="history.back()" class="inline-flex items-center text-green-200 hover:text-white transition-colors text-lg">
          <i class="fas fa-arrow-left mr-3"></i>
          Go Back
        </button>
      </div>
    </div>
  </div>

  <script>
    // Form validation and progress tracking
    const form = document.getElementById('registrationForm');
    const progressBar = document.getElementById('progressBar');
    const progressText = document.getElementById('progressText');
    
    // Required fields for progress calculation
    const requiredFields = ['business_name', 'email', 'address', 'latitude', 'longitude', 'password', 'password_confirmation'];
    
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
          icon.innerHTML = '<i class="fas fa-check text-green-400"></i>';
          if (error) error.style.display = 'none';
        } else {
          icon.innerHTML = '<i class="fas fa-times text-red-400"></i>';
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
        customField.focus();
      } else {
        customInput.style.display = 'none';
        customField.required = false;
        customField.value = '';
      }
      
      // Update validation and progress
      updateProgress();
    });

    // Initialize custom hours visibility on page load
    document.addEventListener('DOMContentLoaded', function() {
      const workingHoursSelect = document.getElementById('working_hours');
      const customInput = document.getElementById('customHoursInput');
      
      if (workingHoursSelect.value === 'custom') {
        customInput.style.display = 'block';
        document.getElementById('custom_working_hours').required = true;
      }
    });

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

    // Get current location
    function getCurrentLocation() {
      const button = document.getElementById('locationButton');
      const icon = document.getElementById('locationIcon');
      const text = document.getElementById('locationText');
      
      // Show loading state
      button.disabled = true;
      icon.className = 'fas fa-spinner fa-spin mr-2';
      text.textContent = 'Getting Location...';
      
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
          function(position) {
            document.getElementById('latitude').value = position.coords.latitude.toFixed(7);
            document.getElementById('longitude').value = position.coords.longitude.toFixed(7);
            
            // Validate the new values
            validateField('latitude', document.getElementById('latitude').value);
            validateField('longitude', document.getElementById('longitude').value);
            updateProgress();
            
            // Show success state
            icon.className = 'fas fa-check mr-2';
            text.textContent = 'Location Captured!';
            
            // Reset button after 3 seconds
            setTimeout(() => {
              button.disabled = false;
              icon.className = 'fas fa-location-arrow mr-2';
              text.textContent = 'Get My Current Location';
            }, 3000);
            
            showLocationSuccess();
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
            icon.className = 'fas fa-exclamation-triangle mr-2';
            text.textContent = 'Location Failed';
            
            setTimeout(() => {
              button.disabled = false;
              icon.className = 'fas fa-location-arrow mr-2';
              text.textContent = 'Get My Current Location';
            }, 3000);
            
            alert(errorMessage + ' Please enter coordinates manually.');
          }
        );
      } else {
        icon.className = 'fas fa-exclamation-triangle mr-2';
        text.textContent = 'Not Supported';
        
        setTimeout(() => {
          button.disabled = false;
          icon.className = 'fas fa-location-arrow mr-2';
          text.textContent = 'Get My Current Location';
        }, 3000);
        
        alert('Geolocation is not supported by this browser. Please enter coordinates manually.');
      }
    }

    function showLocationSuccess() {
      const successDiv = document.createElement('div');
      successDiv.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: linear-gradient(135deg, #10B981, #059669);
        color: white;
        padding: 15px 20px;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        z-index: 1000;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: opacity 0.3s ease;
      `;
      successDiv.innerHTML = '✅ Location captured successfully!';
      document.body.appendChild(successDiv);
      
      setTimeout(() => {
        successDiv.style.opacity = '0';
        setTimeout(() => {
          if (document.body.contains(successDiv)) {
            document.body.removeChild(successDiv);
          }
        }, 300);
      }, 3000);
    }

    // Form submission with loading state
    form.addEventListener('submit', function(e) {
      const button = document.getElementById('submitButton');
      const icon = document.getElementById('submitIcon');
      const text = document.getElementById('submitText');
      
      // Check terms agreement
      const termsCheckbox = document.getElementById('terms');
      if (!termsCheckbox.checked) {
        e.preventDefault();
        alert('Please agree to the Terms of Service and Privacy Policy to continue.');
        return;
      }

      // Handle custom working hours
      const workingHoursSelect = document.getElementById('working_hours');
      const customHours = document.getElementById('custom_working_hours');
      
      if (workingHoursSelect.value === 'custom') {
        if (!customHours.value.trim()) {
          e.preventDefault();
          alert('Please enter your custom working hours.');
          customHours.focus();
          return;
        }
        // Set the select value to the custom input value for submission
        workingHoursSelect.value = customHours.value;
      }
      
      // Show loading state
      button.disabled = true;
      icon.className = 'fas fa-spinner fa-spin mr-3';
      text.textContent = 'Creating Account...';
      
      // Re-enable after 15 seconds as fallback
      setTimeout(() => {
        button.disabled = false;
        icon.className = 'fas fa-store mr-3';
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
        setTimeout(() => msg.remove(), 500);
      });
    }, 5000);
  </script>
</body>
</html>