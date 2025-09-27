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
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

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
            background: #ffffff;
            color: #333333;
            line-height: 1.6;
            min-height: 100vh;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        /* App Container */
        .app-container {
            min-height: 100vh;
            background: linear-gradient(-45deg, #00b09b, #00c9a1, #00d9a6, #00e8ab, #00b09b);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
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
        }

        /* Main Content Area */
        .main-content {
            flex: 1;
            padding: 32px 24px;
            padding-top: 0;
            position: relative;
            z-index: 1;
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
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255,255,255,0.2);
            animation: slideInDown 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .alert::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.6s ease;
        }

        .alert:hover::before {
            left: 100%;
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
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
        @include('components.footer')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('dashboard.js') }}"></script>

    <!-- Page Specific Scripts -->
    @stack('scripts')
</body>

</html>
