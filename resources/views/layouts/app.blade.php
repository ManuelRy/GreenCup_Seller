<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Green Cup App')</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('logo/seller-logo.png') }}" type="image/png">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Stylesheets -->
    <link href="{{ asset('dashboard.css') }}" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Page Specific Styles -->
    @stack('styles')

    <!-- Base Styles -->
    <style>
        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
        }

        html {
            font-size: 16px;
            -webkit-text-size-adjust: 100%;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            background: linear-gradient(-45deg, #00b09b, #00c9a1, #00d9a6, #00e8ab, #00b09b);
            background-size: 400% 400%;
            background-attachment: fixed;
            background-position: 50% 50%;
            color: #333333;
            line-height: 1.6;
            min-height: 100vh;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            will-change: auto;
        }

        /* App Container */
        .app-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative;
            transform: translateZ(0);
        }

        .app-container::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image:
                radial-gradient(circle at 25% 25%, rgba(255,255,255,0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(255,255,255,0.05) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
            will-change: auto;
            transform: translateZ(0);
        }

        /* Static Background Elements - Animation disabled for performance */
        .app-container::after {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image:
                radial-gradient(circle at 20% 80%, rgba(255,255,255,0.08) 0%, transparent 40%),
                radial-gradient(circle at 80% 20%, rgba(255,255,255,0.06) 0%, transparent 40%),
                radial-gradient(circle at 40% 40%, rgba(255,255,255,0.04) 0%, transparent 30%);
            pointer-events: none;
            z-index: 0;
            will-change: auto;
            transform: translateZ(0);
        }

        /* Particle Animation - DISABLED for scrolling performance */
        .particles {
            display: none;
        }

        /* Wave Animation - DISABLED for scrolling performance */
        .wave-animation {
            display: none;
        }

        /* Main Content Area */
        .main-content {
            flex: 1;
            padding: 32px 24px;
            padding-top: 0;
            position: relative;
            z-index: 1;
            transform: translateZ(0);
            will-change: auto;
        }

        .main-content > * {
            position: relative;
            z-index: 2;
        }

        /* Enhanced Alerts */
        .alert {
            padding: 18px 24px;
            border-radius: 16px;
            margin-bottom: 24px;
            font-weight: 600;
            display: flex;
            align-items: center;
            border: 1px solid rgba(255,255,255,0.2);
            position: relative;
            overflow: hidden;
            opacity: 1;
            transform: translateZ(0);
        }

        .alert::before {
            display: none;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.9);
            color: white;
            box-shadow: 0 8px 32px rgba(16, 185, 129, 0.3);
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.9);
            color: white;
            box-shadow: 0 8px 32px rgba(239, 68, 68, 0.3);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content {
                padding: 20px 16px;
                padding-top: 0;
            }

            .alert {
                padding: 16px 20px;
                margin-bottom: 20px;
            }
        }

        @media (max-width: 480px) {
            .main-content {
                padding: 16px 12px;
                padding-top: 0;
            }

            .alert {
                padding: 14px 18px;
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    <div class="app-container">
        <!-- Animated Background Elements -->
        <div class="particles">
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
        </div>
        <div class="wave-animation"></div>

        <!-- Navigation Component -->
        @include('components.navbar')

        <!-- Main Content Area -->
        <main class="main-content">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="alert alert-success mb-4">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error mb-4">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error mb-4">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <strong>Please fix the following errors:</strong>
                    <ul class="mt-2 mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Page Content -->
            @yield('content')
        </main>

        <!-- Footer (if needed) -->
        {{-- @include('components.footer') --}}
    </div>

    <!-- Scripts -->
    <script src="{{ asset('dashboard.js') }}"></script>

    <!-- Page Specific Scripts -->
    @stack('scripts')
</body>

</html>
