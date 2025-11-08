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
    min-height: 100vh;
    color: #333333;
    position: relative;
    overflow-x: hidden;
}


.edit-container {
    min-height: 100vh;
    padding: 20px;
    position: relative;
    z-index: 1;
}

/* Header */
.header {
    background: #374151;
    padding: 20px;
    margin: -20px -20px 30px -20px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.header-content {
    max-width: 800px;
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

/* Form Container */
.form-container {
    max-width: 900px;
    margin: 0 auto;
    background: white;
    border-radius: 24px;
    box-shadow: 0 20px 80px rgba(0, 0, 0, 0.15), 0 0 0 1px rgba(255,255,255,0.1);
    overflow: hidden;
    animation: slideIn 0.6s ease-out;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(30px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.form-header {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    padding: 40px 30px;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.form-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 10%, transparent 10%);
    background-size: 30px 30px;
    animation: headerPattern 30s linear infinite;
}

@keyframes headerPattern {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.form-title {
    font-size: 32px;
    font-weight: 700;
    margin-bottom: 10px;
    position: relative;
    z-index: 1;
}

.form-subtitle {
    font-size: 16px;
    opacity: 0.95;
    position: relative;
    z-index: 1;
}

.form-content {
    padding: 50px 40px;
}

/* Form Groups */
.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 25px;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.form-label {
    display: block;
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
    font-size: 14px;
}

.form-input,
.form-textarea,
.form-select {
    width: 100%;
    padding: 14px 18px;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    font-size: 16px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    background: white;
}

.form-input:focus,
.form-textarea:focus,
.form-select:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1), 0 4px 12px rgba(59, 130, 246, 0.15);
    transform: translateY(-2px);
}

.form-textarea {
    resize: vertical;
    min-height: 100px;
}

.form-error {
    color: #dc2626;
    font-size: 12px;
    margin-top: 4px;
}

/* Checkbox */
.checkbox-group {
    display: flex;
    align-items: center;
    gap: 10px;
}

.checkbox-input {
    width: 18px;
    height: 18px;
    accent-color: #3b82f6;
}

/* Current Image Display */
.current-image {
    margin-bottom: 15px;
}

.current-image img {
    max-width: 200px;
    height: 150px;
    object-fit: cover;
    border-radius: 8px;
    border: 2px solid #e5e7eb;
}

.no-image {
    width: 200px;
    height: 150px;
    background: #f3f4f6;
    border: 2px dashed #d1d5db;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #9ca3af;
    font-size: 48px;
}

/* File Upload */
.file-upload-container {
    border: 3px dashed #d1d5db;
    border-radius: 16px;
    padding: 40px;
    text-align: center;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
    position: relative;
    background: #fafafa;
}

.file-upload-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    border-radius: 16px;
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.05), rgba(37, 99, 235, 0.05));
    opacity: 0;
    transition: opacity 0.4s;
}

.file-upload-container:hover {
    border-color: #3b82f6;
    background: #eff6ff;
    transform: translateY(-4px);
    box-shadow: 0 12px 30px rgba(59, 130, 246, 0.15);
}

.file-upload-container:hover::before {
    opacity: 1;
}

.file-upload-icon {
    font-size: 56px;
    color: #9ca3af;
    margin-bottom: 15px;
    transition: transform 0.3s;
    position: relative;
    z-index: 1;
}

.file-upload-container:hover .file-upload-icon {
    transform: scale(1.1) rotate(5deg);
    color: #3b82f6;
}

.file-upload-text {
    color: #374151;
    font-weight: 600;
    margin-bottom: 5px;
    position: relative;
    z-index: 1;
}

.file-upload-hint {
    color: #6b7280;
    font-size: 14px;
    position: relative;
    z-index: 1;
}

.file-input {
    display: none;
}

/* Stats Info */
.stats-info {
    background: linear-gradient(135deg, #eff6ff, #dbeafe);
    border: 2px solid #bae6fd;
    border-radius: 16px;
    padding: 20px;
    margin-bottom: 30px;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.1);
    animation: pulse 2s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { box-shadow: 0 4px 12px rgba(59, 130, 246, 0.1); }
    50% { box-shadow: 0 6px 20px rgba(59, 130, 246, 0.15); }
}

.stats-title {
    font-weight: 700;
    color: #0c4a6e;
    margin-bottom: 15px;
    font-size: 16px;
}

.stats-row {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
    text-align: center;
}

.stat-item {
    background: white;
    padding: 15px;
    border-radius: 10px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.stat-item:hover {
    transform: translateY(-4px);
    box-shadow: 0 6px 16px rgba(59, 130, 246, 0.15);
}

.stat-value {
    font-size: 24px;
    font-weight: 700;
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.stat-label {
    font-size: 12px;
    color: #64748b;
    margin-top: 2px;
}

/* Form Actions */
.form-actions {
    display: flex;
    gap: 15px;
    justify-content: flex-end;
    margin-top: 40px;
    padding-top: 30px;
    border-top: 1px solid #e5e7eb;
}

.btn {
    padding: 16px 32px;
    border: none;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    text-decoration: none;
    display: inline-block;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.btn::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}

.btn:hover::before {
    width: 300px;
    height: 300px;
}

.btn-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
}

.btn-primary:hover {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
}

.btn-primary:active {
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

/* Helper Text */
.helper-text {
    font-size: 12px;
    color: #6b7280;
    margin-top: 4px;
}

.warning-text {
    color: #dc2626;
    font-size: 12px;
    margin-top: 4px;
    font-weight: 600;
}

/* Responsive */
@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }

    .form-row {
        grid-template-columns: 1fr;
        gap: 0;
    }

    .stats-row {
        grid-template-columns: 1fr;
        gap: 10px;
    }

    .form-content {
        padding: 30px 20px;
    }

    .form-actions {
        flex-direction: column;
    }
}
</style>

<div class="edit-container">
    <!-- Header -->
    {{-- <div class="header">
        <div class="header-content">
            <h1 class="header-title">✏️ Edit Reward</h1>
            <a href="{{ route('reward.index') }}" class="back-btn">← Back to Rewards</a>
        </div>
    </div> --}}

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

    <!-- Form Container -->
    <div class="form-container">
        <div class="form-header">
            <h2 class="form-title">Edit: {{ $reward->name }}</h2>
            <p class="form-subtitle">Update your reward details and settings</p>
        </div>

        <div class="form-content">
            <!-- Reward Stats -->
            <div class="stats-info">
                <div class="stats-title">📊 Reward Statistics</div>
                <div class="stats-row">
                    <div class="stat-item">
                        <div class="stat-value">{{ $reward->quantity }}</div>
                        <div class="stat-label">Total Quantity</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ $reward->quantity_redeemed }}</div>
                        <div class="stat-label">Redeemed</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ $reward->available_quantity }}</div>
                        <div class="stat-label">Available</div>
                    </div>
                </div>
            </div>

            <form action="{{ route('reward.update', $reward) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Basic Information -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="name" class="form-label">Reward Name *</label>
                        <input type="text" id="name" name="name" class="form-input"
                               value="{{ old('name', $reward->name) }}" required maxlength="255"
                               placeholder="e.g., Free Coffee, 20% Discount">
                        @error('name')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="points_required" class="form-label">Points Required *</label>
                        <input type="number" id="points_required" name="points_required" class="form-input"
                               value="{{ old('points_required', $reward->points_required) }}" required min="1"
                               placeholder="100">
                        @error('points_required')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                        <div class="helper-text">How many points customers need to redeem this reward</div>
                    </div>
                </div>

                <!-- Description -->
                <div class="form-group full-width">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description" class="form-textarea"
                              maxlength="1000" placeholder="Describe your reward, terms and conditions, etc.">{{ old('description', $reward->description) }}</textarea>
                    @error('description')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                    <div class="helper-text">Optional description to help customers understand the reward</div>
                </div>

                <!-- Quantity and Dates -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="quantity" class="form-label">Total Quantity *</label>
                        <input type="number" id="quantity" name="quantity" class="form-input"
                               value="{{ old('quantity', $reward->quantity) }}" required
                               min="{{ $reward->quantity_redeemed }}"
                               placeholder="50">
                        @error('quantity')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                        @if($reward->quantity_redeemed > 0)
                            <div class="warning-text">
                                ⚠️ Cannot be less than {{ $reward->quantity_redeemed }} (already redeemed)
                            </div>
                        @else
                            <div class="helper-text">How many of this reward are available</div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="valid_from" class="form-label">Valid From (Date & Time) *</label>
                        <input type="datetime-local" id="valid_from" name="valid_from" class="form-input"
                               value="{{ old('valid_from', $reward->valid_from->format('Y-m-d\TH:i')) }}" required>
                        @error('valid_from')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                        <div class="helper-text">When the reward becomes available</div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="valid_until" class="form-label">Valid Until (Date & Time) *</label>
                        <input type="datetime-local" id="valid_until" name="valid_until" class="form-input"
                               value="{{ old('valid_until', $reward->valid_until->format('Y-m-d\TH:i')) }}" required>
                        @error('valid_until')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                        <div class="helper-text">When the reward expires</div>
                    </div>
                </div>

                <!-- Current Image -->
                <div class="form-group full-width">
                    <label class="form-label">Current Image</label>
                    <div class="current-image">
                        @if($reward->image_path)
                            <img src="{{  $reward->image_path}}" alt="{{ $reward->name }}">
                        @else
                            <div class="no-image">🎁</div>
                        @endif
                    </div>
                </div>

                <!-- Image Upload -->
                <div class="form-group full-width">
                    <label for="image" class="form-label">Update Image</label>
                    <div class="file-upload-container" id="uploadContainer" onclick="document.getElementById('image').click()">
                        <div class="file-upload-icon">📷</div>
                        <div class="file-upload-text">Take photo or upload new image</div>
                        <div class="file-upload-hint">JPG, PNG, GIF up to 5MB (optional)</div>
                    </div>
                    <input type="file" id="image" name="image" class="file-input"
                           accept="image/jpeg,image/png,image/jpg,image/gif">
                    @error('image')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                    <div class="helper-text">Leave empty to keep current image</div>

                    <!-- New Image Preview -->
                    <div id="imagePreview" style="display: none; margin-top: 1rem; text-align: center;">
                        <div style="position: relative; display: inline-block;">
                            <img id="previewImg" src="" alt="Preview" style="max-width: 300px; max-height: 300px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                            <button type="button" onclick="removeNewImage()" style="position: absolute; top: -10px; right: -10px; width: 32px; height: 32px; border-radius: 50%; background: #ef4444; color: white; border: 2px solid white; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.2);">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div id="fileName" style="margin-top: 0.5rem; font-size: 0.875rem; color: #6b7280;"></div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('reward.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        💾 Update Reward
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Fix for Android: Use wildcard to enable camera option
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('image');
    const isAndroid = /android/i.test(navigator.userAgent);
    
    if (isAndroid) {
        imageInput.setAttribute('accept', 'image/*');
    }
});

// File upload preview
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const container = document.getElementById('uploadContainer');
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    const fileName = document.getElementById('fileName');

    if (file) {
        // Validate file type
        if (!file.type.startsWith('image/')) {
            alert('Please select an image file (JPG, PNG, GIF)');
            this.value = '';
            return;
        }

        // Validate file size (5MB)
        if (file.size > 5 * 1024 * 1024) {
            alert('Image size must be less than 5MB');
            this.value = '';
            return;
        }

        // Show preview
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
            container.style.display = 'none';
        };
        reader.readAsDataURL(file);

        // Show file info
        const fileSize = (file.size / 1024 / 1024).toFixed(2);
        fileName.textContent = `New image: ${file.name} (${fileSize} MB)`;
    }
});

// Remove new image function
function removeNewImage() {
    const fileInput = document.getElementById('image');
    const container = document.getElementById('uploadContainer');
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');

    fileInput.value = '';
    previewImg.src = '';
    preview.style.display = 'none';
    container.style.display = 'flex';
}

// Date validation
document.getElementById('valid_from').addEventListener('change', function() {
    const validFrom = new Date(this.value);
    const validUntilInput = document.getElementById('valid_until');

    // Set minimum date for valid_until to be valid_from
    validUntilInput.min = this.value;

    // If valid_until is before valid_from, update it
    if (validUntilInput.value && new Date(validUntilInput.value) < validFrom) {
        validUntilInput.value = this.value;
    }
});
</script>
@endsection
