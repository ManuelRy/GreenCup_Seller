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

.edit-container {
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

.back-btn {
    background: linear-gradient(135deg, #6b7280, #4b5563);
    color: white;
    text-decoration: none;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.back-btn:hover {
    background: linear-gradient(135deg, #4b5563, #374151);
    transform: translateY(-1px);
    color: white;
    text-decoration: none;
}

/* Alert Messages */
.alert {
    padding: 15px 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    font-weight: 600;
}

.alert-error {
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid #ef4444;
}

/* Main Content */
.main-content {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 400px 1fr;
    gap: 30px;
}

/* Form Panel */
.form-panel {
    background: white;
    border-radius: 16px;
    padding: 30px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    height: fit-content;
}

.form-title {
    font-size: 20px;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.form-group {
    margin-bottom: 20px;
}

.form-label {
    display: block;
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
    font-size: 14px;
}

.form-input,
.form-textarea {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 16px;
    transition: all 0.3s ease;
    background: white;
}

.form-input:focus,
.form-textarea:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.form-textarea {
    resize: vertical;
    min-height: 80px;
}

.form-error {
    color: #dc2626;
    font-size: 12px;
    margin-top: 4px;
}

.helper-text {
    font-size: 12px;
    color: #6b7280;
    margin-top: 4px;
}

/* Coordinate Inputs */
.coordinate-inputs {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
}

.coordinate-input {
    font-family: monospace;
    text-align: center;
}

/* Location Tools */
.location-tools {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 20px;
}

.tool-btn {
    padding: 12px 16px;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    background: #f9fafb;
    color: #374151;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.tool-btn:hover {
    background: #e5e7eb;
    border-color: #d1d5db;
}

.tool-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.tool-btn.loading {
    background: #3b82f6;
    color: white;
    border-color: #3b82f6;
}

/* Search Section */
.search-section {
    margin-bottom: 20px;
}

.search-input {
    margin-bottom: 10px;
}

.search-results {
    max-height: 200px;
    overflow-y: auto;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    background: white;
    display: none;
}

.search-result {
    padding: 12px;
    border-bottom: 1px solid #f3f4f6;
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.search-result:hover {
    background: #f8fafc;
}

.search-result:last-child {
    border-bottom: none;
}

.search-result-text {
    font-size: 14px;
    color: #374151;
    line-height: 1.4;
}

/* Form Actions */
.form-actions {
    display: flex;
    gap: 15px;
    margin-top: 30px;
}

.btn {
    padding: 14px 28px;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
    text-align: center;
    flex: 1;
}

.btn-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
}

.btn-secondary {
    background: #f3f4f6;
    color: #374151;
}

.btn-secondary:hover {
    background: #e5e7eb;
    color: #374151;
    text-decoration: none;
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
    height: 600px;
    width: 100%;
    cursor: crosshair;
}

/* Map Loading */
.map-loading {
    height: 600px;
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

/* Status Messages */
.status-message {
    padding: 10px 15px;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 15px;
}

.status-success {
    background: #d1fae5;
    color: #065f46;
    border: 1px solid #10b981;
}

.status-info {
    background: #dbeafe;
    color: #1e40af;
    border: 1px solid #3b82f6;
}

.status-warning {
    background: #fef3c7;
    color: #92400e;
    border: 1px solid #f59e0b;
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

    .coordinate-inputs {
        grid-template-columns: 1fr;
    }

    .form-actions {
        flex-direction: column;
    }

    #map {
        height: 400px;
    }
}
</style>

<div class="edit-container">
    <!-- Header -->
    <div class="header">
        <div class="header-content">
            <h1 class="header-title">📍 Edit Shop Location</h1>
            <a href="{{ route('location.show') }}" class="back-btn">← Back to Location</a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('error'))
        <div class="alert alert-error">
            ❌ {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            <strong>Please fix the following errors:</strong>
            <ul style="margin-top: 10px; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Main Content -->
    <div class="main-content">
        <!-- Form Panel -->
        <div class="form-panel">
            <h2 class="form-title">📍 Location Settings</h2>

            <!-- Status Message -->
            <div id="statusMessage" style="display: none;"></div>

            <!-- Location Tools -->
            <div class="location-tools">
                <button type="button" id="getCurrentLocation" class="tool-btn">
                    📱 Use Current Location
                </button>
                <button type="button" id="getApproximateLocation" class="tool-btn">
                    🌍 Get Approximate Location
                </button>
            </div>

            <!-- Address Search -->
            <div class="search-section">
                <div class="form-group">
                    <label class="form-label">🔍 Search Address</label>
                    <input type="text" id="addressSearch" class="form-input search-input"
                           placeholder="Search for an address or place...">
                    <div class="helper-text">Type an address to search and click on a result</div>
                </div>
                <div id="searchResults" class="search-results"></div>
            </div>

            <!-- Location Form -->
            <form action="{{ route('location.update') }}" method="POST" id="locationForm">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="address" class="form-label">Business Address *</label>
                    <textarea id="address" name="address" class="form-textarea" required
                              placeholder="Enter your business address">{{ old('address', $seller->address) }}</textarea>
                    @error('address')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                    <div class="helper-text">This address will be shown to customers</div>
                </div>

                <div class="form-group">
                    <label class="form-label">Coordinates *</label>
                    <div class="coordinate-inputs">
                        <div>
                            <input type="number" id="latitude" name="latitude" class="form-input coordinate-input"
                                   step="any" required placeholder="Latitude"
                                   value="{{ old('latitude', $seller->latitude) }}">
                            @error('latitude')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <input type="number" id="longitude" name="longitude" class="form-input coordinate-input"
                                   step="any" required placeholder="Longitude"
                                   value="{{ old('longitude', $seller->longitude) }}">
                            @error('longitude')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="helper-text">Click on the map or use the tools above to set coordinates</div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('location.show') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">💾 Save Location</button>
                </div>
            </form>
        </div>

        <!-- Map -->
        <div class="map-container">
            <div class="map-header">
                <h3 class="map-title">Interactive Map</h3>
                <p class="map-subtitle">Click on the map to set your shop location</p>
            </div>
            <div id="map">
                <div class="map-loading">
                    <div class="loading-spinner"></div>
                    Loading map...
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Leaflet CSS and JS (Free OpenStreetMap solution) -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>

<script>
// Global variables
let map;
let marker;
let currentLatitude = {{ $seller->latitude ?: 'null' }};
let currentLongitude = {{ $seller->longitude ?: 'null' }};

// Initialize the map with Leaflet
function initializeMap() {
    const defaultLat = currentLatitude || 0;
    const defaultLng = currentLongitude || 0;
    const defaultZoom = (currentLatitude && currentLongitude) ? 15 : 2;

    // Initialize map
    map = L.map('map').setView([defaultLat, defaultLng], defaultZoom);

    // Add OpenStreetMap tiles (free)
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

    // Handle tile errors
    map.on('tileerror', function(e) {
        console.error('Map tile error:', e);
        showStatus('Some map tiles failed to load, but the map should still work.', 'warning');
    });

    console.log('Map loaded successfully with Leaflet');
}

// Add or update marker
function addMarker(lat, lng) {
    if (marker) {
        map.removeLayer(marker);
    }

    marker = L.marker([lat, lng], {
        draggable: true
    }).addTo(map);

    // Handle marker drag
    marker.on('dragend', function(e) {
        const position = e.target.getLatLng();
        setLocation(position.lat, position.lng);
        reverseGeocode(position.lat, position.lng);
    });
}

// Set location in form and map
function setLocation(lat, lng) {
    currentLatitude = lat;
    currentLongitude = lng;

    document.getElementById('latitude').value = lat.toFixed(6);
    document.getElementById('longitude').value = lng.toFixed(6);

    addMarker(lat, lng);
    map.setView([lat, lng], 15);

    showStatus('Location updated! Remember to save your changes.', 'success');
}

// Show status message
function showStatus(message, type = 'info') {
    const statusEl = document.getElementById('statusMessage');
    statusEl.textContent = message;
    statusEl.className = `status-message status-${type}`;
    statusEl.style.display = 'block';

    // Auto-hide after 5 seconds
    setTimeout(() => {
        statusEl.style.display = 'none';
    }, 5000);
}

// Get current location using browser geolocation
function getCurrentLocation() {
    const btn = document.getElementById('getCurrentLocation');
    btn.textContent = '📱 Getting location...';
    btn.disabled = true;
    btn.classList.add('loading');

    if (!navigator.geolocation) {
        showStatus('Geolocation is not supported by this browser.', 'error');
        resetButton(btn, '📱 Use Current Location');
        return;
    }

    navigator.geolocation.getCurrentPosition(
        function(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;

            setLocation(lat, lng);
            reverseGeocode(lat, lng);
            showStatus('Current location detected successfully!', 'success');
            resetButton(btn, '📱 Use Current Location');
        },
        function(error) {
            let message = 'Unable to get your current location. ';
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    message += 'Please allow location access in your browser.';
                    break;
                case error.POSITION_UNAVAILABLE:
                    message += 'Location information is unavailable.';
                    break;
                case error.TIMEOUT:
                    message += 'Location request timed out.';
                    break;
                default:
                    message += 'An unknown error occurred.';
                    break;
            }
            showStatus(message, 'error');
            resetButton(btn, '📱 Use Current Location');
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
    btn.textContent = '🌍 Getting location...';
    btn.disabled = true;
    btn.classList.add('loading');

    fetch('{{ route("location.approximate-location") }}')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                setLocation(data.latitude, data.longitude);
                reverseGeocode(data.latitude, data.longitude);
                showStatus(`Approximate location set (${data.city}, ${data.country})`, 'success');
            } else {
                showStatus(data.message || 'Unable to get approximate location', 'error');
            }
            resetButton(btn, '🌍 Get Approximate Location');
        })
        .catch(error => {
            showStatus('Error getting approximate location', 'error');
            resetButton(btn, '🌍 Get Approximate Location');
        });
}

// Reset button state
function resetButton(btn, originalText) {
    btn.textContent = originalText;
    btn.disabled = false;
    btn.classList.remove('loading');
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
            showStatus('Address updated automatically!', 'info');
        }
    })
    .catch(error => {
        console.error('Reverse geocoding error:', error);
        showStatus('Could not get address for this location', 'warning');
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
        body: JSON.stringify({
            query: query
        })
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
        showStatus('Search service temporarily unavailable', 'warning');
    });
}

// Show search results
function showSearchResults(results) {
    const resultsEl = document.getElementById('searchResults');
    resultsEl.innerHTML = '';

    results.forEach(result => {
        const div = document.createElement('div');
        div.className = 'search-result';
        div.innerHTML = `<div class="search-result-text">${result.display_name}</div>`;
        div.addEventListener('click', () => {
            setLocation(result.latitude, result.longitude);
            document.getElementById('address').value = result.display_name;
            document.getElementById('addressSearch').value = result.display_name;
            hideSearchResults();
            showStatus('Location set from search result!', 'success');
        });
        resultsEl.appendChild(div);
    });

    resultsEl.style.display = 'block';
}

// Hide search results
function hideSearchResults() {
    document.getElementById('searchResults').style.display = 'none';
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Initialize map
    initializeMap();

    // Location tools
    document.getElementById('getCurrentLocation').addEventListener('click', getCurrentLocation);
    document.getElementById('getApproximateLocation').addEventListener('click', getApproximateLocation);

    // Address search
    let searchTimeout;
    document.getElementById('addressSearch').addEventListener('input', function(e) {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            searchAddress(e.target.value);
        }, 500);
    });

    // Hide search results when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.search-section')) {
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
});
</script>
@endsection
