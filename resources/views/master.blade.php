<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Green Cup App</title>
    <link href="{{ asset('dashboard.css') }}" rel="stylesheet">
      @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
</head>

<body>
    @yield('content')

    {{-- Your JavaScript --}}
    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
    <script src="{{ asset('dashboard.js') }}"></script>
</body>

</html>