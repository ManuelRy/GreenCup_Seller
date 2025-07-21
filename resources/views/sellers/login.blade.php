<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Seller Login - GreenCup</title>
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
  </style>
</head>

<body class="py-8 px-4">
  <div class="w-full max-w-lg mx-auto">
    <div class="glass rounded-3xl p-10 shadow-2xl">
      <!-- Logo and Header -->
      <div class="text-center mb-10">
        <div class="inline-flex items-center justify-center w-24 h-24 glass rounded-full mb-6">
          <i class="fas fa-store text-4xl text-white"></i>
        </div>
        <h1 class="text-4xl font-bold text-white mb-3">Seller Portal</h1>
        <p class="text-green-100 text-lg">Sign in to your business account</p>
      </div>

      <!-- Success Messages -->
      @if(session('registration_success'))
      <div class="mb-6 px-4 py-3 glass rounded-lg border-l-4 border-green-400">
        <div class="flex items-center">
          <i class="fas fa-check-circle text-green-400 mr-3"></i>
          <span class="text-white">{{ session('registration_success') }}</span>
        </div>
      </div>
      @endif

      @if(session('success') && !session('registration_success'))
      <div class="mb-6 px-4 py-3 glass rounded-lg border-l-4 border-green-400">
        <div class="flex items-center">
          <i class="fas fa-check-circle text-green-400 mr-3"></i>
          <span class="text-white">{{ session('success') }}</span>
        </div>
      </div>
      @endif

      <!-- Error Messages - Enhanced -->
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

      @if($errors->any())
      <div class="mb-6 px-4 py-3 glass rounded-lg border-l-4 border-red-400">
        <div class="flex items-start">
          <i class="fas fa-exclamation-triangle text-red-400 mr-3 mt-0.5"></i>
          <div>
            <p class="text-white font-medium mb-2">Login failed:</p>
            <ul class="text-red-100 text-sm space-y-1 list-disc list-inside">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
      @endif

      <form action="{{ route('login.store') }}" method="POST" class="space-y-7" id="loginForm">
        @csrf
        <!-- Email Address -->
        <div>
          <label for="email" class="block text-white font-medium mb-2 text-lg">
            <i class="fas fa-envelope mr-2 text-green-400"></i>Business Email
          </label>
          <input type="email" id="email" name="email" value="{{ old('email', session('registration_email')) }}"
            class="w-full input-premium glass rounded-xl px-5 py-4 text-white placeholder-green-200 focus:outline-none text-lg @error('email') error-input @enderror"
            placeholder="Enter your business email" required />
          @error('email')
            <p class="mt-2 text-red-300 text-sm flex items-center">
              <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
            </p>
          @enderror
        </div>

        <!-- Password -->
        <div>
          <label for="password" class="block text-white font-medium mb-2 text-lg">
            <i class="fas fa-lock mr-2 text-green-400"></i>Password
          </label>
          <input type="password" id="password" name="password"
            class="w-full input-premium glass rounded-xl px-5 py-4 text-white placeholder-green-200 focus:outline-none text-lg @error('password') error-input @enderror"
            placeholder="Enter your password" required />
          @error('password')
            <p class="mt-2 text-red-300 text-sm flex items-center">
              <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
            </p>
          @enderror
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
          <input type="checkbox" id="remember_me" name="remember_me" class="mr-3" />
          <label for="remember_me" class="text-white text-lg cursor-pointer">Remember this device</label>
        </div>

        <!-- Submit Button -->
        <button type="submit" id="loginButton"
          class="w-full btn-premium text-white font-semibold py-5 rounded-xl transition-all duration-300 flex items-center justify-center text-lg">
          <i class="fas fa-sign-in-alt mr-3" id="loginIcon"></i>
          <span id="loginText">Sign In to Dashboard</span>
        </button>
      </form>

      <!-- Register Link -->
      <div class="mt-10 text-center">
        <p class="text-green-100 mb-5 text-lg">Don't have a business account?</p>
        <a href="{{ route('sellers.create') }}"
          class="inline-flex items-center text-white font-semibold text-xl hover:text-green-200 transition-colors">
          <i class="fas fa-store mr-3"></i>
          Register Your Business
        </a>
      </div>
    </div>
  </div>

  <script>
    // Enhanced form submission with error handling
    document.getElementById('loginForm').addEventListener('submit', function(e) {
      const button = document.getElementById('loginButton');
      const icon = document.getElementById('loginIcon');
      const text = document.getElementById('loginText');
      
      // Show loading state
      button.disabled = true;
      icon.className = 'fas fa-spinner fa-spin mr-3';
      text.textContent = 'Signing In...';
      
      // Re-enable after 10 seconds as fallback
      setTimeout(() => {
        button.disabled = false;
        icon.className = 'fas fa-sign-in-alt mr-3';
        text.textContent = 'Sign In to Dashboard';
      }, 10000);
    });

    // Clear errors when user starts typing
    document.querySelectorAll('input').forEach(input => {
      input.addEventListener('input', function() {
        this.classList.remove('error-input');
        const errorMsg = this.parentElement.querySelector('.text-red-300');
        if (errorMsg) {
          errorMsg.style.display = 'none';
        }
      });
    });

    // Auto-hide success messages after 5 seconds
    setTimeout(() => {
      const successMessages = document.querySelectorAll('.border-green-400');
      successMessages.forEach(msg => {
        msg.style.opacity = '0';
        msg.style.transition = 'opacity 0.5s ease';
        setTimeout(() => msg.remove(), 500);
      });
    }, 5000);
  </script>
</body>
</html>