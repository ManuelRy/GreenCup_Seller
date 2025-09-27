{{--
    This file is deprecated. Please use the new layout files:
    - layouts/app.blade.php for authenticated pages
    - layouts/dashboard.blade.php for the dashboard
    - layouts/guest.blade.php for guest pages (login, register)
--}}
@extends('layouts.app')

{{-- Fallback content --}}
@section('content')
    @yield('content')
@endsection
