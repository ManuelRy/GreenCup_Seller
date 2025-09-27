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
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Stylesheets -->
    <link href="{{ asset('dashboard.css') }}" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Page Specific Styles -->
    @stack('styles')
</head>

<body>
    <!-- Dashboard Container -->
    <div class="dashboard-container">
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
