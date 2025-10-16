<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard - Green Cup App')</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('logo/seller-logo.png') }}" type="image/png">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Stylesheets -->
    <link href="{{ asset('dashboard.css') }}" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Page Specific Styles -->
    @stack('styles')

    <!-- Enhanced Background Animations -->
    <style>
        /* Enhanced Dashboard Animations */
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            margin: 0;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        .dashboard-container {
            position: relative;
            overflow: hidden;
        }

        /* Floating Orbs Layer */
        .dashboard-container::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image:
                radial-gradient(circle at 25% 25%, rgba(255, 255, 255, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(255, 255, 255, 0.06) 0%, transparent 50%),
                radial-gradient(circle at 50% 10%, rgba(255, 255, 255, 0.05) 0%, transparent 40%);
            pointer-events: none;
            z-index: 0;
            animation: floatingOrbs 25s ease-in-out infinite;
        }

        /* Animated Wave Layer */
        .dashboard-container::after {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image:
                radial-gradient(ellipse 800px 600px at 50% 100%, rgba(255, 255, 255, 0.04) 0%, transparent 70%),
                radial-gradient(ellipse 600px 400px at 20% 20%, rgba(255, 255, 255, 0.03) 0%, transparent 60%),
                radial-gradient(ellipse 400px 300px at 80% 80%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
            pointer-events: none;
            z-index: 1;
            animation: waveFloat 35s ease-in-out infinite;
        }

        @keyframes floatingOrbs {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
                opacity: 1;
            }
            25% {
                transform: translateY(-10px) rotate(1deg);
                opacity: 0.8;
            }
            50% {
                transform: translateY(-5px) rotate(0deg);
                opacity: 0.9;
            }
            75% {
                transform: translateY(5px) rotate(-1deg);
                opacity: 0.7;
            }
        }

        @keyframes waveFloat {
            0%, 100% {
                transform: translateX(0px) translateY(0px) scale(1);
                opacity: 0.6;
            }
            25% {
                transform: translateX(-10px) translateY(-5px) scale(1.02);
                opacity: 0.7;
            }
            50% {
                transform: translateX(5px) translateY(-10px) scale(0.98);
                opacity: 0.5;
            }
            75% {
                transform: translateX(-5px) translateY(5px) scale(1.01);
                opacity: 0.8;
            }
        }

        /* Enhanced Floating Elements */
        .floating-elements {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 2;
        }

        .floating-element {
            position: absolute;
            width: 8px;
            height: 8px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            animation: enhancedFloat 15s infinite linear;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.2);
        }

        .floating-element:nth-child(1) {
            left: 10%;
            animation-delay: 0s;
            animation-duration: 20s;
            background: rgba(255, 255, 255, 0.4);
        }

        .floating-element:nth-child(2) {
            left: 20%;
            animation-delay: 2s;
            animation-duration: 18s;
            width: 6px;
            height: 6px;
        }

        .floating-element:nth-child(3) {
            left: 30%;
            animation-delay: 4s;
            animation-duration: 22s;
            width: 10px;
            height: 10px;
        }

        .floating-element:nth-child(4) {
            left: 40%;
            animation-delay: 6s;
            animation-duration: 16s;
            width: 5px;
            height: 5px;
        }

        .floating-element:nth-child(5) {
            left: 50%;
            animation-delay: 8s;
            animation-duration: 24s;
            width: 7px;
            height: 7px;
        }

        .floating-element:nth-child(6) {
            left: 60%;
            animation-delay: 10s;
            animation-duration: 19s;
            width: 9px;
            height: 9px;
        }

        .floating-element:nth-child(7) {
            left: 70%;
            animation-delay: 12s;
            animation-duration: 21s;
            width: 4px;
            height: 4px;
        }

        .floating-element:nth-child(8) {
            left: 80%;
            animation-delay: 14s;
            animation-duration: 17s;
            width: 11px;
            height: 11px;
        }

        @keyframes enhancedFloat {
            0% {
                transform: translateY(100vh) rotate(0deg) scale(0);
                opacity: 0;
            }
            10% {
                opacity: 0.3;
                transform: translateY(90vh) rotate(18deg) scale(0.5);
            }
            20% {
                opacity: 0.6;
                transform: translateY(80vh) rotate(36deg) scale(0.8);
            }
            50% {
                opacity: 1;
                transform: translateY(40vh) rotate(180deg) scale(1);
            }
            80% {
                opacity: 0.8;
                transform: translateY(15vh) rotate(288deg) scale(1.2);
            }
            90% {
                opacity: 0.4;
                transform: translateY(5vh) rotate(324deg) scale(0.8);
            }
            100% {
                transform: translateY(-10vh) rotate(360deg) scale(0);
                opacity: 0;
            }
        }

        /* Sparkle Effect */
        .sparkle-effect {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
            background-image:
                radial-gradient(2px 2px at 20px 30px, rgba(255, 255, 255, 0.3), transparent),
                radial-gradient(2px 2px at 40px 70px, rgba(255, 255, 255, 0.2), transparent),
                radial-gradient(1px 1px at 90px 40px, rgba(255, 255, 255, 0.4), transparent),
                radial-gradient(1px 1px at 130px 80px, rgba(255, 255, 255, 0.2), transparent),
                radial-gradient(2px 2px at 160px 30px, rgba(255, 255, 255, 0.3), transparent);
            background-repeat: repeat;
            background-size: 200px 100px;
            animation: sparkleMove 40s linear infinite;
        }

        @keyframes sparkleMove {
            0% { transform: translateY(0px); }
            100% { transform: translateY(-200px); }
        }
    </style>
</head>

<body>
    <!-- Dashboard Container -->
    <div class="dashboard-container">
        <!-- Enhanced Background Effects -->
        <div class="floating-elements">
            <div class="floating-element"></div>
            <div class="floating-element"></div>
            <div class="floating-element"></div>
            <div class="floating-element"></div>
            <div class="floating-element"></div>
            <div class="floating-element"></div>
            <div class="floating-element"></div>
            <div class="floating-element"></div>
        </div>
        <div class="sparkle-effect"></div>

        <!-- Navigation Component -->
        @include('components.navbar')

        <!-- Dashboard Content -->
        @yield('content')

        <!-- Footer -->
        @include('components.footer')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('dashboard.js') }}"></script>

    <!-- Page Specific Scripts -->
    @stack('scripts')
</body>

</html>
