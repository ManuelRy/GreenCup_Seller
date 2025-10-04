@extends('layouts.app')

@section('title', 'Business Location - Green Cup')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<style>
.glass-effect {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}
.coordinate-value {
    font-family: 'Courier New', monospace;
}
#map {
    height: 500px;
}
.custom-business-marker {
    background: none !important;
    border: none !important;
}
.leaflet-popup-content-wrapper {
    border-radius: 1rem;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}
@media (max-width: 768px) {
    #map {
        height: 350px !important;
    }
}
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="card shadow-lg glass-effect mb-4">
        <div class="card-body p-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                <div>
                    <h1 class="h3 fw-bold text-dark mb-2">
                        <i class="bi bi-geo-alt text-primary me-2"></i>
                        Business Location
                    </h1>
                    <p class="text-muted mb-0">Manage your business location and help customers find you</p>
                </div>
                <div class="d-flex gap-2 mt-3 mt-md-0">
                    <a href="{{ route('location.edit') }}"
                       class="btn btn-primary d-inline-flex align-items-center">
                        <i class="bi bi-pencil-square me-2"></i>
                        Edit Location
                    </a>
                    <a href="{{ route('seller.account') }}"
                       class="btn btn-outline-secondary d-inline-flex align-items-center">
                        <i class="bi bi-person-gear me-2"></i>
                        Account
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row g-4">
        <!-- Business Information Card -->
        <div class="col-lg-4">
            <div class="card h-100 shadow-lg glass-effect">
                <div class="card-body p-4">
                    <!-- Business Header -->
                    <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                        <div class="me-3" style="width: 80px; height: 80px; border-radius: 16px; overflow: hidden; background: linear-gradient(135deg, #00b09b, #00d9a6); display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 24px rgba(0, 176, 155, 0.3);">
                            @if($seller->photo_url)
                                <img src="{{ asset($seller->photo_url) }}" alt="{{ $seller->business_name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <i class="bi bi-shop text-white fs-2"></i>
                            @endif
                        </div>
                        <div class="flex-grow-1">
                            <h2 class="card-title h4 mb-1">{{ $seller->business_name }}</h2>
                            <span class="badge {{ $seller->is_active ? 'bg-success' : 'bg-secondary' }}">
                                <i class="bi bi-circle-fill me-1"></i>
                                {{ $seller->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>

                    @if($seller->latitude && $seller->longitude)
                        <!-- Business Address -->
                        <div class="mb-4">
                            <h6 class="text-muted text-uppercase small fw-bold mb-2">
                                <i class="bi bi-geo-alt me-1"></i>Business Address
                            </h6>
                            <div class="bg-light p-3 rounded border-start border-primary border-4">
                                <span class="text-dark">{{ $seller->address ?: 'No address provided' }}</span>
                            </div>
                        </div>

                        <!-- Coordinates -->
                        <div class="mb-4">
                            <h6 class="text-muted text-uppercase small fw-bold mb-2">
                                <i class="bi bi-crosshair me-1"></i>Coordinates
                            </h6>
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="bg-light p-3 rounded text-center">
                                        <small class="text-muted d-block text-uppercase fw-bold">Latitude</small>
                                        <span class="coordinate-value fw-bold text-dark">
                                            {{ number_format($seller->latitude, 6) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-light p-3 rounded text-center">
                                        <small class="text-muted d-block text-uppercase fw-bold">Longitude</small>
                                        <span class="coordinate-value fw-bold text-dark">
                                            {{ number_format($seller->longitude, 6) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        @if($seller->description)
                        <div class="mb-4">
                            <h6 class="text-muted text-uppercase small fw-bold mb-2">
                                <i class="bi bi-info-circle me-1"></i>Description
                            </h6>
                            <p class="text-dark mb-0">{{ $seller->description }}</p>
                        </div>
                        @endif

                        @if($seller->working_hours)
                        <div class="mb-4">
                            <h6 class="text-muted text-uppercase small fw-bold mb-2">
                                <i class="bi bi-clock me-1"></i>Working Hours
                            </h6>
                            <p class="text-dark mb-0">{{ $seller->working_hours }}</p>
                        </div>
                        @endif

                        @if($seller->phone)
                        <div class="mb-4">
                            <h6 class="text-muted text-uppercase small fw-bold mb-2">
                                <i class="bi bi-telephone me-1"></i>Phone
                            </h6>
                            <p class="text-dark mb-0">
                                <a href="tel:{{ $seller->phone }}" class="text-decoration-none">
                                    {{ $seller->phone }}
                                </a>
                            </p>
                        </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="d-grid gap-2">
                            <a href="{{ route('location.edit') }}" class="btn btn-primary">
                                <i class="bi bi-pencil-square me-2"></i>Update Location
                            </a>
                        </div>
                    @else
                        <!-- No Location Set -->
                        <div class="text-center py-4">
                            <i class="bi bi-geo-alt display-1 text-muted mb-3"></i>
                            <h5 class="text-dark mb-3">Location Not Set</h5>
                            <p class="text-muted mb-4">Set your business location to help customers find you easily</p>

                            <div class="alert alert-warning mb-4" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <strong>Action Required:</strong> Please set your location to appear in customer searches.
                            </div>

                            <a href="{{ route('location.edit') }}" class="btn btn-primary btn-lg">
                                <i class="bi bi-geo-alt me-2"></i>Set Location Now
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- Map Card -->
        <div class="col-lg-8">
            <div class="card shadow-lg glass-effect">
                <!-- Map Header -->
                <div class="card-header bg-light">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-map text-primary fs-4 me-3"></i>
                        <div>
                            <h3 class="card-title h5 mb-1">Shop Location on Map</h3>
                            <small class="text-muted">Interactive map showing your business location</small>
                        </div>
                    </div>
                </div>

                <!-- Map Content -->
                <div class="card-body p-0">
                    @if($seller->latitude && $seller->longitude)
                        <div id="map"></div>
                    @else
                        <div class="d-flex flex-column align-items-center justify-content-center bg-light text-center"
                             style="height: 500px;">
                            <i class="bi bi-map display-1 text-muted mb-3"></i>
                            <h4 class="text-muted">No location set</h4>
                            <p class="text-muted">Please set your shop location to view it on the map</p>
                            <a href="{{ route('location.edit') }}" class="btn btn-primary mt-2">
                                <i class="bi bi-geo-alt me-2"></i>Set Location Now
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@if($seller->latitude && $seller->longitude)
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Leaflet map
    const map = L.map('map').setView([{{ $seller->latitude }}, {{ $seller->longitude }}], 15);

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19
    }).addTo(map);

    // Custom business marker icon
    const businessIcon = L.divIcon({
        className: 'custom-business-marker',
        html: `<div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow-lg"
               style="width: 50px; height: 50px; border: 3px solid white;">
               <i class="bi bi-shop fs-4"></i>
               </div>`,
        iconSize: [50, 50],
        iconAnchor: [25, 50]
    });

    // Add marker with enhanced popup
    const marker = L.marker([{{ $seller->latitude }}, {{ $seller->longitude }}], {icon: businessIcon})
        .addTo(map)
        .bindPopup(`
            <div class="text-center p-3" style="min-width: 200px;">
                <h5 class="text-primary mb-2">{{ $seller->business_name }}</h5>
                @if($seller->address)
                <p class="text-muted mb-2 small">{{ $seller->address }}</p>
                @endif
                @if($seller->phone)
                <div class="mt-3">
                    <a href="tel:{{ $seller->phone }}" class="btn btn-sm btn-outline-primary me-2">
                        <i class="bi bi-telephone me-1"></i>Call
                    </a>
                    <a href="https://maps.google.com?q={{ $seller->latitude }},{{ $seller->longitude }}"
                       target="_blank" class="btn btn-sm btn-outline-success">
                        <i class="bi bi-navigation me-1"></i>Directions
                    </a>
                </div>
                @endif
            </div>
        `, {
            maxWidth: 300,
            className: 'custom-popup'
        })
        .openPopup();

    // Handle map errors gracefully
    map.on('tileerror', function(e) {
        console.warn('Map tile loading error:', e);
    });

    // Add zoom control styling
    map.zoomControl.setPosition('topright');
});
</script>

<style>
/* Custom marker styles */
.custom-business-marker {
    background: none !important;
    border: none !important;
}

/* Enhanced popup styling */
.leaflet-popup-content-wrapper {
    border-radius: 1rem;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    border: none;
}

.leaflet-popup-tip {
    background: white;
    border: none;
    box-shadow: none;
}

/* Responsive map adjustments */
@media (max-width: 768px) {
    #map {
        height: 350px !important;
    }
}

/* Coordinate display */
.font-monospace {
    font-family: 'Courier New', monospace;
}
</style>
@endif
@endsection
