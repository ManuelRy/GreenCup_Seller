@extends('layouts.app')

@section('title', 'Edit Location - Green Cup')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<style>
.custom-marker {
    background: none !important;
    border: none !important;
}
.leaflet-popup-content-wrapper {
    border-radius: 0.5rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}
@media (max-width: 768px) {
    .sticky-top {
        position: static !important;
    }
    #map {
        height: 350px !important;
    }
}
.spinner-border-sm {
    width: 1rem;
    height: 1rem;
}
.glass-effect {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
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
                        Edit Location
                    </h1>
                    <p class="text-muted mb-0">Set your business location for customers to find you easily</p>
                </div>
                <a href="{{ route('location.show') }}" 
                   class="btn btn-outline-secondary d-inline-flex align-items-center mt-3 mt-md-0">
                    <i class="bi bi-arrow-left me-2"></i>
                    Back to Location
                </a>
            </div>
        </div>
    </div>
    <!-- Alert Messages -->
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <strong>Error!</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <strong>Please fix the following errors:</strong>
        <ul class="mb-0 mt-2 ps-3">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Status Message (for JavaScript) -->
    <div id="statusMessage" class="d-none"></div>

    <!-- Main Content -->
    <div class="row g-4">
        <!-- Form Panel -->
        <div class="col-lg-4">
            <div class="card shadow-lg glass-effect sticky-top" style="top: 2rem;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-primary bg-opacity-10 rounded-3 p-3 me-3">
                            <i class="bi bi-geo-alt text-primary fs-4"></i>
                        </div>
                        <div>
                            <h2 class="h5 mb-1 text-dark">Location Settings</h2>
                            <small class="text-muted">Configure your business location</small>
                        </div>
                    </div>

                    <!-- Location Tools -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-dark mb-3">
                            <i class="bi bi-tools me-2"></i>Location Tools
                        </h6>
                        <div class="d-grid gap-2">
                            <button type="button" id="getCurrentLocation" class="btn btn-outline-primary">
                                <i class="bi bi-geo-alt-fill me-2"></i>
                                Use Current Location
                            </button>
                            <button type="button" id="getApproximateLocation" class="btn btn-outline-info">
                                <i class="bi bi-globe me-2"></i>
                                Get Approximate Location
                            </button>
                        </div>
                    </div>

                    <!-- Address Search -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-dark">
                            <i class="bi bi-search me-2"></i>Search Address
                        </label>
                        <div class="position-relative">
                            <input type="text" id="addressSearch" 
                                   class="form-control form-control-lg" 
                                   placeholder="Search for an address or place...">
                            <div id="searchResults" class="position-absolute w-100 bg-white border rounded shadow-lg mt-1 d-none" 
                                 style="z-index: 1000; max-height: 200px; overflow-y: auto;"></div>
                        </div>
                        <small class="text-muted">Type an address to search and select from results</small>
                    </div>

                    <!-- Location Form -->
                    <form action="{{ route('location.update') }}" method="POST" id="locationForm" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <!-- Business Address -->
                        <div class="mb-4">
                            <label for="address" class="form-label fw-bold text-dark">
                                <i class="bi bi-building me-2"></i>Business Address *
                            </label>
                            <textarea id="address" name="address" 
                                    class="form-control @error('address') is-invalid @enderror" 
                                    rows="3" required
                                    placeholder="Enter your complete business address">{{ old('address', $seller->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                <div class="form-text">This address will be visible to customers</div>
                            @enderror
                        </div>

                        <!-- Coordinates -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">
                                <i class="bi bi-crosshair me-2"></i>Coordinates *
                            </label>
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="form-floating">
                                        <input type="number" id="latitude" name="latitude" 
                                               class="form-control @error('latitude') is-invalid @enderror" 
                                               step="any" required placeholder="Latitude"
                                               value="{{ old('latitude', $seller->latitude) }}">
                                        <label for="latitude">Latitude</label>
                                        @error('latitude')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-floating">
                                        <input type="number" id="longitude" name="longitude" 
                                               class="form-control @error('longitude') is-invalid @enderror" 
                                               step="any" required placeholder="Longitude"
                                               value="{{ old('longitude', $seller->longitude) }}">
                                        <label for="longitude">Longitude</label>
                                        @error('longitude')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <small class="text-muted">Click on the map or use the tools above to set coordinates</small>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-check-lg me-2"></i>
                                Save Location
                            </button>
                            <a href="{{ route('location.show') }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Map Panel -->
        <div class="col-lg-8">
            <div class="card shadow-lg glass-effect">
                <!-- Map Header -->
                <div class="card-header bg-light">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded-3 p-3 me-3">
                            <i class="bi bi-map text-primary fs-4"></i>
                        </div>
                        <div>
                            <h3 class="h5 mb-1 text-dark">Interactive Map</h3>
                            <small class="text-muted">Click anywhere on the map to set your business location</small>
                        </div>
                    </div>
                </div>

                <!-- Map Container -->
                <div class="card-body p-0">
                    <div id="map" class="w-100" style="height: 500px;">
                        <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                            <div class="text-center">
                                <div class="spinner-border text-primary mb-3" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="text-muted">Loading interactive map...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>

<script>
// Global variables
let map;
let marker;
let currentLatitude = {{ $seller->latitude ?: 'null' }};
let currentLongitude = {{ $seller->longitude ?: 'null' }};

// Initialize the map
function initializeMap() {
    const defaultLat = currentLatitude || 0;
    const defaultLng = currentLongitude || 0;
    const defaultZoom = (currentLatitude && currentLongitude) ? 15 : 2;

    // Create map instance
    map = L.map('map').setView([defaultLat, defaultLng], defaultZoom);

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19
    }).addTo(map);

    // Add existing marker if coordinates exist
    if (currentLatitude && currentLongitude) {
        addMarker(defaultLat, defaultLng);
    }

    // Handle map clicks
    map.on('click', function(e) {
        const lat = e.latlng.lat;
        const lng = e.latlng.lng;
        setLocation(lat, lng);
        reverseGeocode(lat, lng);
    });

    // Handle tile errors gracefully
    map.on('tileerror', function(e) {
        console.error('Map tile error:', e);
        showStatus('Some map tiles failed to load, but the map should still work.', 'warning');
    });
}

// Add or update marker on map
function addMarker(lat, lng) {
    if (marker) {
        map.removeLayer(marker);
    }

    // Create custom marker
    const customIcon = L.divIcon({
        className: 'custom-marker',
        html: `<div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow" 
               style="width: 40px; height: 40px;">
               <i class="bi bi-shop fs-6"></i>
               </div>`,
        iconSize: [40, 40],
        iconAnchor: [20, 40]
    });

    marker = L.marker([lat, lng], {
        icon: customIcon,
        draggable: true
    }).addTo(map);

    // Handle marker drag
    marker.on('dragend', function(e) {
        const position = e.target.getLatLng();
        setLocation(position.lat, position.lng);
        reverseGeocode(position.lat, position.lng);
    });

    // Add popup to marker
    marker.bindPopup(`
        <div class="text-center p-2">
            <h6 class="text-primary mb-1">Your Business Location</h6>
            <small class="text-muted">Drag to adjust position</small>
        </div>
    `).openPopup();
}

// Set location in form and update map
function setLocation(lat, lng) {
    currentLatitude = lat;
    currentLongitude = lng;

    document.getElementById('latitude').value = lat.toFixed(6);
    document.getElementById('longitude').value = lng.toFixed(6);

    addMarker(lat, lng);
    map.setView([lat, lng], 15);

    showStatus('Location updated successfully! Remember to save your changes.', 'success');
}

// Show status message with auto-hide
function showStatus(message, type = 'info') {
    const statusEl = document.getElementById('statusMessage');
    const alertClass = type === 'success' ? 'alert-success' : 
                      type === 'warning' ? 'alert-warning' : 
                      type === 'error' ? 'alert-danger' : 'alert-info';
    
    const icon = type === 'success' ? 'bi-check-circle-fill' : 
                 type === 'warning' ? 'bi-exclamation-triangle-fill' : 
                 type === 'error' ? 'bi-x-circle-fill' : 'bi-info-circle-fill';

    statusEl.innerHTML = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            <i class="bi ${icon} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    statusEl.classList.remove('d-none');

    // Auto-hide after 5 seconds
    setTimeout(() => {
        statusEl.classList.add('d-none');
    }, 5000);
}

// Get current location using browser geolocation
function getCurrentLocation() {
    const btn = document.getElementById('getCurrentLocation');
    const originalText = btn.innerHTML;
    
    btn.innerHTML = '<i class="spinner-border spinner-border-sm me-2"></i>Getting location...';
    btn.disabled = true;

    if (!navigator.geolocation) {
        showStatus('Geolocation is not supported by this browser.', 'error');
        resetButton(btn, originalText);
        return;
    }

    navigator.geolocation.getCurrentPosition(
        function(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;

            setLocation(lat, lng);
            reverseGeocode(lat, lng);
            showStatus('Current location detected successfully!', 'success');
            resetButton(btn, originalText);
        },
        function(error) {
            let message = 'Unable to get your current location. ';
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    message += 'Please allow location access in your browser settings.';
                    break;
                case error.POSITION_UNAVAILABLE:
                    message += 'Location information is unavailable.';
                    break;
                case error.TIMEOUT:
                    message += 'Location request timed out. Please try again.';
                    break;
                default:
                    message += 'An unknown error occurred.';
                    break;
            }
            showStatus(message, 'error');
            resetButton(btn, originalText);
        },
        {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 60000
        }
    );
}

// Get approximate location using IP
function getApproximateLocation() {
    const btn = document.getElementById('getApproximateLocation');
    const originalText = btn.innerHTML;
    
    btn.innerHTML = '<i class="spinner-border spinner-border-sm me-2"></i>Getting location...';
    btn.disabled = true;

    fetch('{{ route("location.approximate-location") }}')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                setLocation(data.latitude, data.longitude);
                reverseGeocode(data.latitude, data.longitude);
                showStatus(`Approximate location set based on your IP (${data.city}, ${data.country})`, 'success');
            } else {
                showStatus(data.message || 'Unable to get approximate location', 'error');
            }
            resetButton(btn, originalText);
        })
        .catch(error => {
            console.error('Error:', error);
            showStatus('Error getting approximate location', 'error');
            resetButton(btn, originalText);
        });
}

// Reset button to original state
function resetButton(btn, originalText) {
    btn.innerHTML = originalText;
    btn.disabled = false;
}

// Reverse geocoding to get address from coordinates
function reverseGeocode(lat, lng) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        console.error('CSRF token not found');
        return;
    }

    fetch('{{ route("location.reverse-geocode") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken.content
        },
        body: JSON.stringify({
            latitude: lat,
            longitude: lng
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('address').value = data.address;
            showStatus('Address updated automatically based on coordinates!', 'info');
        }
    })
    .catch(error => {
        console.error('Reverse geocoding error:', error);
    });
}

// Search for addresses
function searchAddress(query) {
    if (query.length < 3) {
        hideSearchResults();
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        console.error('CSRF token not found');
        return;
    }

    fetch('{{ route("location.search-address") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken.content
        },
        body: JSON.stringify({ query: query })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.results.length > 0) {
            showSearchResults(data.results);
        } else {
            hideSearchResults();
        }
    })
    .catch(error => {
        console.error('Address search error:', error);
        hideSearchResults();
    });
}

// Show search results dropdown
function showSearchResults(results) {
    const resultsEl = document.getElementById('searchResults');
    resultsEl.innerHTML = '';

    results.forEach(result => {
        const div = document.createElement('div');
        div.className = 'p-3 border-bottom cursor-pointer hover:bg-light';
        div.innerHTML = `
            <div class="d-flex align-items-start">
                <i class="bi bi-geo-alt text-muted me-2 mt-1"></i>
                <div>
                    <div class="fw-medium text-dark">${result.display_name.split(',')[0]}</div>
                    <small class="text-muted">${result.display_name}</small>
                </div>
            </div>
        `;
        div.style.cursor = 'pointer';
        div.addEventListener('mouseenter', () => div.classList.add('bg-light'));
        div.addEventListener('mouseleave', () => div.classList.remove('bg-light'));
        div.addEventListener('click', () => {
            setLocation(result.latitude, result.longitude);
            document.getElementById('address').value = result.display_name;
            document.getElementById('addressSearch').value = result.display_name.split(',')[0];
            hideSearchResults();
            showStatus('Location set from search result!', 'success');
        });
        resultsEl.appendChild(div);
    });

    resultsEl.classList.remove('d-none');
}

// Hide search results dropdown
function hideSearchResults() {
    document.getElementById('searchResults').classList.add('d-none');
}

// Initialize everything when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize map
    initializeMap();

    // Bind event listeners
    document.getElementById('getCurrentLocation').addEventListener('click', getCurrentLocation);
    document.getElementById('getApproximateLocation').addEventListener('click', getApproximateLocation);

    // Address search with debouncing
    let searchTimeout;
    document.getElementById('addressSearch').addEventListener('input', function(e) {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            searchAddress(e.target.value);
        }, 500);
    });

    // Hide search results when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('#addressSearch') && !e.target.closest('#searchResults')) {
            hideSearchResults();
        }
    });

    // Coordinate input changes
    document.getElementById('latitude').addEventListener('change', function() {
        const lat = parseFloat(this.value);
        const lng = parseFloat(document.getElementById('longitude').value);
        if (!isNaN(lat) && !isNaN(lng)) {
            addMarker(lat, lng);
            map.setView([lat, lng], 15);
            reverseGeocode(lat, lng);
        }
    });

    document.getElementById('longitude').addEventListener('change', function() {
        const lat = parseFloat(document.getElementById('latitude').value);
        const lng = parseFloat(this.value);
        if (!isNaN(lat) && !isNaN(lng)) {
            addMarker(lat, lng);
            map.setView([lat, lng], 15);
            reverseGeocode(lat, lng);
        }
    });

    // Form validation
    const form = document.getElementById('locationForm');
    form.addEventListener('submit', function(e) {
        if (!form.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
            showStatus('Please fill in all required fields correctly.', 'error');
        }
        form.classList.add('was-validated');
    });
});
</script>

<style>
/* Custom marker styles */
.custom-marker {
    background: none !important;
    border: none !important;
}

/* Search result hover effect */
.cursor-pointer {
    cursor: pointer;
}

/* Leaflet popup customization */
.leaflet-popup-content-wrapper {
    border-radius: 0.5rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Map container responsive behavior */
@media (max-width: 768px) {
    .sticky-top {
        position: static !important;
    }
    
    #map {
        height: 350px !important;
    }
}

/* Loading animation for buttons */
.spinner-border-sm {
    width: 1rem;
    height: 1rem;
}
</style>
@endsection
