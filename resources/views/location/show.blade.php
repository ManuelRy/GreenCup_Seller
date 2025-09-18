@extends('master')

@section('content')
<style>
/* Reset and Base Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
    background: linear-gradient(135deg, #00b09b 0%, #00cdac 50%, #00dfa8 100%);
    min-height: 100vh;
    color: #333333;
}

.location-container {
    min-height: 100vh;
    padding: 20px;
}

/* Header */
.header {
    background: #374151;
    padding: 20px;
    margin: -20px -20px 30px -20px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.header-content {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header-title {
    color: white;
    font-size: 24px;
    font-weight: 700;
}

.header-actions {
    display: flex;
    gap: 10px;
}

.back-btn, .edit-btn {
    background: linear-gradient(135deg, #6b7280, #4b5563);
    color: white;
    text-decoration: none;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.edit-btn {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
}

.back-btn:hover, .edit-btn:hover {
    transform: translateY(-1px);
    color: white;
    text-decoration: none;
}

.back-btn:hover {
    background: linear-gradient(135deg, #4b5563, #374151);
}

.edit-btn:hover {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
}

/* Alert Messages */
.alert {
    padding: 15px 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    font-weight: 600;
}

.alert-success {
    background: #d1fae5;
    color: #065f46;
    border: 1px solid #10b981;
}

/* Main Content */
.main-content {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
}

/* Shop Info Card */
.shop-info-card {
    background: white;
    border-radius: 16px;
    padding: 30px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    height: fit-content;
}

.shop-header {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 25px;
}

.shop-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    color: white;
}

.shop-details h2 {
    font-size: 24px;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 5px;
}

.shop-status {
    color: #059669;
    font-size: 14px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 5px;
}

.info-section {
    margin-bottom: 25px;
}

.info-label {
    font-size: 12px;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
}

.info-value {
    font-size: 16px;
    color: #374151;
    line-height: 1.4;
}

.address-value {
    display: flex;
    align-items: flex-start;
    gap: 10px;
}

.coordinates {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
    margin-top: 15px;
}

.coordinate-item {
    background: #f8fafc;
    padding: 12px;
    border-radius: 8px;
    text-align: center;
}

.coordinate-label {
    font-size: 10px;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    margin-bottom: 4px;
}

.coordinate-value {
    font-size: 14px;
    font-weight: 700;
    color: #1e293b;
    font-family: monospace;
}

/* Map Container */
.map-container {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.map-header {
    background: #f8fafc;
    padding: 20px;
    border-bottom: 1px solid #e2e8f0;
}

.map-title {
    font-size: 18px;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 5px;
}

.map-subtitle {
    font-size: 14px;
    color: #6b7280;
}

#map {
    height: 500px;
    width: 100%;
}

/* Loading State */
.map-loading {
    height: 500px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8fafc;
    color: #6b7280;
    font-size: 16px;
}

.loading-spinner {
    width: 40px;
    height: 40px;
    border: 4px solid #e2e8f0;
    border-top: 4px solid #3b82f6;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin-right: 15px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Quick Actions */
.quick-actions {
    display: flex;
    gap: 10px;
    margin-top: 20px;
}

.quick-btn {
    flex: 1;
    padding: 12px 16px;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.quick-btn-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
}

.quick-btn-secondary {
    background: #f1f5f9;
    color: #475569;
    border: 1px solid #e2e8f0;
}

.quick-btn:hover {
    transform: translateY(-1px);
    text-decoration: none;
}

.quick-btn-primary:hover {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: white;
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
}

.quick-btn-secondary:hover {
    background: #e2e8f0;
    color: #334155;
}

/* Responsive Design */
@media (max-width: 768px) {
    .main-content {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .header-content {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }
    
    .header-actions {
        flex-direction: column;
        width: 100%;
    }
    
    .coordinates {
        grid-template-columns: 1fr;
    }
    
    #map {
        height: 400px;
    }
}

/* Error State */
.map-error {
    height: 500px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: #fef2f2;
    color: #dc2626;
    text-align: center;
    padding: 20px;
}

.error-icon {
    font-size: 48px;
    margin-bottom: 15px;
}

.error-title {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 10px;
}

.error-message {
    font-size: 14px;
    color: #7f1d1d;
}
</style>

<div class="location-container">
    <!-- Header -->
    <div class="header">
        <div class="header-content">
            <h1 class="header-title">📍 Shop Location</h1>
            <div class="header-actions">
                <a href="{{ route('dashboard') }}" class="back-btn">← Back to Dashboard</a>
                <a href="{{ route('location.edit') }}" class="edit-btn">✏️ Edit Location</a>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success">
            ✅ {{ session('success') }}
        </div>
    @endif

    <!-- Main Content -->
    <div class="main-content">
        <!-- Shop Information -->
        <div class="shop-info-card">
            <div class="shop-header">
                <div class="shop-icon">🏪</div>
                <div class="shop-details">
                    <h2>{{ $seller->business_name }}</h2>
                    <div class="shop-status">
                        <span>●</span>
                        {{ $seller->is_active ? 'Active' : 'Inactive' }}
                    </div>
                </div>
            </div>

            <div class="info-section">
                <div class="info-label">Business Address</div>
                <div class="info-value address-value">
                    <span>📍</span>
                    <span>{{ $seller->address ?: 'No address set' }}</span>
                </div>
            </div>

            @if($seller->description)
            <div class="info-section">
                <div class="info-label">Description</div>
                <div class="info-value">{{ $seller->description }}</div>
            </div>
            @endif

            @if($seller->working_hours)
            <div class="info-section">
                <div class="info-label">Working Hours</div>
                <div class="info-value">{{ $seller->working_hours }}</div>
            </div>
            @endif

            @if($seller->phone)
            <div class="info-section">
                <div class="info-label">Phone</div>
                <div class="info-value">{{ $seller->phone }}</div>
            </div>
            @endif

            @if($seller->latitude && $seller->longitude)
            <div class="info-section">
                <div class="info-label">Coordinates</div>
                <div class="coordinates">
                    <div class="coordinate-item">
                        <div class="coordinate-label">Latitude</div>
                        <div class="coordinate-value">{{ number_format($seller->latitude, 6) }}</div>
                    </div>
                    <div class="coordinate-item">
                        <div class="coordinate-label">Longitude</div>
                        <div class="coordinate-value">{{ number_format($seller->longitude, 6) }}</div>
                    </div>
                </div>
            </div>

            <div class="quick-actions">
                <a href="{{ route('location.edit') }}" class="quick-btn quick-btn-primary">
                    ✏️ Edit Location
                </a>
                <a href="{{ route('seller.account') }}" class="quick-btn quick-btn-secondary">
                    👤 Account Settings
                </a>
            </div>
            @else
            <div class="info-section">
                <div class="info-label">Location Status</div>
                <div class="info-value" style="color: #dc2626;">
                    ⚠️ Location not set
                </div>
            </div>

            <div class="quick-actions">
                <a href="{{ route('location.edit') }}" class="quick-btn quick-btn-primary">
                    📍 Set Location
                </a>
            </div>
            @endif
        </div>

        <!-- Map -->
        <div class="map-container">
            <div class="map-header">
                <h3 class="map-title">Shop Location on Map</h3>
                <p class="map-subtitle">Interactive map showing your business location</p>
            </div>
            
            @if($seller->latitude && $seller->longitude)
                <div id="map"></div>
            @else
                <div class="map-error">
                    <div class="error-icon">🗺️</div>
                    <div class="error-title">No location set</div>
                    <div class="error-message">Please set your shop location to view it on the map</div>
                </div>
            @endif
        </div>
    </div>
</div>

@if($seller->latitude && $seller->longitude)
<!-- Leaflet CSS and JS (Free OpenStreetMap solution) -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>

<script>
// Initialize the map with Leaflet (completely free)
const map = L.map('map').setView([{{ $seller->latitude }}, {{ $seller->longitude }}], 15);

// Add OpenStreetMap tiles (free)
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    maxZoom: 19
}).addTo(map);

// Add a marker for the shop location
const marker = L.marker([{{ $seller->latitude }}, {{ $seller->longitude }}])
    .addTo(map)
    .bindPopup(`
        <div style="text-align: center; padding: 10px;">
            <h3 style="margin: 0 0 5px 0; color: #1f2937;">{{ $seller->business_name }}</h3>
            <p style="margin: 0; color: #6b7280; font-size: 14px;">{{ $seller->address }}</p>
        </div>
    `)
    .openPopup();

// Handle map errors
map.on('tileerror', function(e) {
    console.error('Map tile error:', e);
});

console.log('Map loaded successfully with Leaflet');
</script>
@endif
@endsection