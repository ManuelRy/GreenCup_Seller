@extends('master')

@section('content')
@php
    // Helper function to limit string length
    function limitString($string, $limit)
    {
        return strlen($string) > $limit ? substr($string, 0, $limit) . '...' : $string;
    }
@endphp

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

    /* Container with Clean Background */
    .dashboard-container {
        min-height: 100vh;
        background: #f9fafb;
        padding-bottom: 60px;
    }

    /* Modern Header */
    .dashboard-header {
        background: white;
        padding: 1.5rem;
        position: sticky;
        top: 0;
        z-index: 100;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        border-bottom: 1px solid #e5e7eb;
    }

    .header-content {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .header-back-btn {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: #f3f4f6;
        border: none;
        color: #1f2937;
        font-size: 20px;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }

    .header-back-btn:hover {
        background: #e5e7eb;
        color: #111827;
        text-decoration: none;
        transform: translateX(-2px);
    }

    .header-title-section {
        color: #111827;
    }

    .app-title {
        font-size: 28px;
        font-weight: 700;
        margin: 0 0 4px 0;
        color: #111827;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .app-subtitle {
        font-size: 14px;
        color: #6b7280;
        margin: 0;
    }

    .back-button {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.25);
    }

    .back-button:hover {
        background: linear-gradient(135deg, #059669, #047857);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.35);
        color: white;
        text-decoration: none;
    }

    /* Alert Messages */
    .alert {
        padding: 16px 20px;
        border-radius: 12px;
        margin-bottom: 24px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .alert-success {
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        color: #047857;
        border: 1px solid rgba(4, 120, 87, 0.2);
    }

    .alert-error {
        background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
        color: #dc2626;
        border: 1px solid rgba(220, 38, 38, 0.2);
    }

    /* Utility Classes */
    .text-center {
        text-align: center;
    }

    .fade-in {
        animation: fadeIn 0.6s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="dashboard-container">
    <!-- Header -->
    <header class="dashboard-header">
        <div class="header-content">
            <div class="header-left">
                <a href="{{ route('dashboard') }}" class="header-back-btn">
                    ←
                </a>
                <div class="header-title-section">
                    <h1 class="app-title">📸 Store Gallery Manager</h1>
                    <p class="app-subtitle">Share your store photos with customers and showcase your green impact</p>
                </div>
            </div>
            <a href="{{ route('dashboard') }}" class="back-button">
                ← Back to Dashboard
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Alerts - SINGLE INSTANCE ONLY -->
        @if (session('success'))
            <div class="alert alert-success fade-in">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error fade-in">
                ❌ {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error fade-in">
                @foreach ($errors->all() as $error)
                    ❌ {{ $error }}<br>
                @endforeach
            </div>
        @endif

        <div class="text-center">
            <h2>📸 Store Gallery Manager</h2>
            <p>Upload and manage your store photos here. This feature is being updated for better performance.</p>
            <p>Please check back soon for the full gallery functionality.</p>
        </div>
    </main>
</div>

@endsection
