@extends('master')

@section('content')
<style>
/* Modern Professional Design with Purple Gradient Theme */
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    --danger-gradient: linear-gradient(135deg, #eb3349 0%, #f45c43 100%);
}

body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
    min-height: 100vh;
    color: #1e293b;
    position: relative;
    overflow-x: hidden;
}

body::before {
    content: '';
    position: fixed;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
    background-size: 50px 50px;
    animation: floatPattern 60s linear infinite;
    pointer-events: none;
    z-index: 0;
}

@keyframes floatPattern {
    from { transform: translate(0, 0) rotate(0deg); }
    to { transform: translate(50px, 50px) rotate(360deg); }
}

.create-container {
    min-height: 100vh;
    padding: 2rem 1rem;
    position: relative;
    z-index: 1;
}

/* Alert Messages */
.alert {
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(20px);
    border-radius: 16px;
    padding: 1rem 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    border: none;
    animation: slideDown 0.4s ease-out;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.alert-error {
    border-left: 4px solid #ef4444;
}

.alert-error strong {
    color: #dc2626;
}

/* Form Container */
.form-container {
    max-width: 900px;
    margin: 0 auto;
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(20px);
    border-radius: 24px;
    box-shadow: 0 20px 80px rgba(0, 0, 0, 0.15);
    overflow: hidden;
    animation: slideIn 0.6s ease-out;
    border: 1px solid rgba(255, 255, 255, 0.5);
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
    background: var(--primary-gradient);
    color: white;
    padding: 2.5rem 2rem;
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
    background: radial-gradient(circle, rgba(255,255,255,0.15) 10%, transparent 10%);
    background-size: 30px 30px;
    animation: headerPattern 30s linear infinite;
}

@keyframes headerPattern {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.form-header-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
    display: inline-block;
    animation: bounce 2s infinite;
}

@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

.form-title {
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 0.5rem;
    position: relative;
    z-index: 1;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.form-subtitle {
    font-size: 1rem;
    opacity: 0.95;
    position: relative;
    z-index: 1;
}

.form-content {
    padding: 2.5rem 2rem;
}

/* Form Groups */
.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.form-label {
    display: block;
    font-weight: 700;
    color: #374151;
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.form-input,
.form-textarea,
.form-select {
    width: 100%;
    padding: 0.875rem 1.125rem;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    font-size: 1rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    background: white;
    font-weight: 500;
}

.form-input:focus,
.form-textarea:focus,
.form-select:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1), 0 4px 12px rgba(102, 126, 234, 0.15);
    transform: translateY(-2px);
}

.form-textarea {
    resize: vertical;
    min-height: 100px;
}

.form-error {
    color: #dc2626;
    font-size: 0.75rem;
    margin-top: 0.25rem;
    font-weight: 600;
}

.helper-text {
    font-size: 0.75rem;
    color: #6b7280;
    margin-top: 0.25rem;
}

/* File Upload */
.file-upload-container {
    border: 3px dashed #cbd5e1;
    border-radius: 16px;
    padding: 2.5rem;
    text-align: center;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
    position: relative;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.03) 0%, rgba(118, 75, 162, 0.03) 100%);
}

.file-upload-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    border-radius: 16px;
    background: var(--primary-gradient);
    opacity: 0;
    transition: opacity 0.4s;
}

.file-upload-container:hover {
    border-color: #667eea;
    background: rgba(102, 126, 234, 0.05);
    transform: translateY(-4px);
    box-shadow: 0 12px 30px rgba(102, 126, 234, 0.15);
}

.file-upload-container:hover::before {
    opacity: 0.05;
}

.file-upload-icon {
    font-size: 3.5rem;
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 1rem;
    transition: transform 0.3s;
    position: relative;
    z-index: 1;
}

.file-upload-container:hover .file-upload-icon {
    transform: scale(1.1) rotate(5deg);
}

.file-upload-text {
    color: #374151;
    font-weight: 700;
    font-size: 1rem;
    margin-bottom: 0.5rem;
    position: relative;
    z-index: 1;
}

.file-upload-hint {
    color: #6b7280;
    font-size: 0.875rem;
    position: relative;
    z-index: 1;
}

.file-input {
    display: none;
}

/* Form Actions */
.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 2px solid #f1f5f9;
}

.btn {
    padding: 1rem 2rem;
    border: none;
    border-radius: 12px;
    font-size: 1rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    position: relative;
    overflow: hidden;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
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
    background: var(--primary-gradient);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 16px 40px rgba(102, 126, 234, 0.3);
    color: white;
}

.btn-primary:active {
    transform: translateY(-1px);
}

.btn-secondary {
    background: #f3f4f6;
    color: #374151;
}

.btn-secondary:hover {
    background: #e5e7eb;
    color: #374151;
    text-decoration: none;
    transform: translateY(-2px);
}

/* Responsive */
@media (max-width: 768px) {
    .create-container {
        padding: 1rem 0.5rem;
    }

    .form-row {
        grid-template-columns: 1fr;
        gap: 0;
    }

    .form-content {
        padding: 2rem 1.5rem;
    }

    .form-header {
        padding: 2rem 1.5rem;
    }

    .form-title {
        font-size: 1.5rem;
    }

    .form-actions {
        flex-direction: column-reverse;
    }

    .btn {
        width: 100%;
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .form-content {
        padding: 1.5rem 1rem;
    }

    .form-header {
        padding: 1.5rem 1rem;
    }

    .form-header-icon {
        font-size: 2.5rem;
    }

    .form-title {
        font-size: 1.25rem;
    }

    .file-upload-container {
        padding: 2rem 1rem;
    }
}
</style>

<div class="create-container">
    <!-- Alert Messages -->
    @if(session('error'))
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <strong>Error!</strong> {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            <i class="fas fa-exclamation-triangle"></i>
            <strong>Please fix the following errors:</strong>
            <ul style="margin-top: 0.75rem; padding-left: 1.5rem; margin-bottom: 0;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Container -->
    <div class="form-container">
        <div class="form-header">
            <div class="form-header-icon">
                <i class="fas fa-gift"></i>
            </div>
            <h2 class="form-title">Create New Reward</h2>
            <p class="form-subtitle">Set up a new reward that customers can redeem with their points</p>
        </div>

        <div class="form-content">
            <form action="{{ route('reward.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Basic Information -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="name" class="form-label">Reward Name *</label>
                        <input type="text" id="name" name="name" class="form-input"
                               value="{{ old('name') }}" required maxlength="255"
                               placeholder="e.g., Free Coffee, 20% Discount">
                        @error('name')
                            <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="points_required" class="form-label">Points Required *</label>
                        <input type="number" id="points_required" name="points_required" class="form-input"
                               value="{{ old('points_required') }}" required min="1"
                               placeholder="100">
                        @error('points_required')
                            <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                        <div class="helper-text">How many points customers need to redeem this reward</div>
                    </div>
                </div>

                <!-- Description -->
                <div class="form-group full-width">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description" class="form-textarea"
                              maxlength="1000" placeholder="Describe your reward, terms and conditions, etc.">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                    <div class="helper-text">Optional description to help customers understand the reward</div>
                </div>

                <!-- Quantity and Dates -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="quantity" class="form-label">Total Quantity *</label>
                        <input type="number" id="quantity" name="quantity" class="form-input"
                               value="{{ old('quantity') }}" required min="1"
                               placeholder="50">
                        @error('quantity')
                            <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                        <div class="helper-text">How many of this reward are available</div>
                    </div>

                    <div class="form-group">
                        <label for="valid_from" class="form-label">Valid From (Date & Time) *</label>
                        <input type="datetime-local" id="valid_from" name="valid_from" class="form-input"
                               value="{{ old('valid_from', date('Y-m-d\TH:i')) }}" required>
                        @error('valid_from')
                            <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                        <div class="helper-text">When the reward becomes available</div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="valid_until" class="form-label">Valid Until (Date & Time) *</label>
                        <input type="datetime-local" id="valid_until" name="valid_until" class="form-input"
                               value="{{ old('valid_until') }}" required>
                        @error('valid_until')
                            <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                        <div class="helper-text">When the reward expires</div>
                    </div>
                </div>

                <!-- Image Upload -->
                <div class="form-group full-width">
                    <label for="image" class="form-label">Reward Image</label>
                    <div class="file-upload-container" id="uploadContainer" onclick="document.getElementById('image').click()">
                        <div class="file-upload-icon">
                            <i class="fas fa-camera"></i>
                        </div>
                        <div class="file-upload-text">Take photo or upload image</div>
                        <div class="file-upload-hint">JPG, PNG, GIF up to 5MB</div>
                    </div>
                    <input type="file" id="image" name="image" class="file-input"
                           accept="image/jpeg,image/png,image/jpg,image/gif">
                    @error('image')
                        <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror

                    <!-- Image Preview -->
                    <div id="imagePreview" style="display: none; margin-top: 1rem; text-align: center;">
                        <div style="position: relative; display: inline-block;">
                            <img id="previewImg" src="" alt="Preview" style="max-width: 300px; max-height: 300px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                            <button type="button" onclick="removeImage()" style="position: absolute; top: -10px; right: -10px; width: 32px; height: 32px; border-radius: 50%; background: #ef4444; color: white; border: 2px solid white; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.2);">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div id="fileName" style="margin-top: 0.5rem; font-size: 0.875rem; color: #6b7280;"></div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('reward.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i>
                        <span>Cancel</span>
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check"></i>
                        <span>Create Reward</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Fix for Android: Remove specific MIME types to show camera option
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('image');
    const isAndroid = /android/i.test(navigator.userAgent);
    
    if (isAndroid) {
        // For Android, use wildcard to enable camera option
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
        fileName.textContent = `${file.name} (${fileSize} MB)`;
    }
});

// Remove image function
function removeImage() {
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
