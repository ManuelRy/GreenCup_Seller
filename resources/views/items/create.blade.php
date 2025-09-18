@extends('master')

@section('content')
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

/* Container with Gradient Background */
.dashboard-container {
    min-height: 100vh;
    background: linear-gradient(135deg, #00b09b 0%, #00cdac 50%, #00dfa8 100%);
    padding-bottom: 40px;
}

/* Header */
.dashboard-header {
    background: #374151;
    padding: 20px;
    position: sticky;
    top: 0;
    z-index: 100;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
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
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.1);
    border: none;
    color: white;
    font-size: 18px;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
}

.header-back-btn:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateX(-2px);
    color: white;
    text-decoration: none;
}

.header-title-section {
    color: white;
}

.app-title {
    font-size: 24px;
    font-weight: 700;
    margin: 0;
    color: white;
}

.app-subtitle {
    font-size: 14px;
    color: rgba(255, 255, 255, 0.8);
    margin: 0;
}

.back-button {
    background: rgba(255, 255, 255, 0.1);
    color: white;
    padding: 10px 20px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s ease;
}

.back-button:hover {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    text-decoration: none;
}

/* Main Content */
.main-content {
    max-width: 800px;
    margin: 0 auto;
    padding: 24px 20px;
}

/* Alerts */
.alert {
    padding: 16px;
    border-radius: 12px;
    margin-bottom: 20px;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 8px;
}

.alert-error {
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid #fca5a5;
}

/* Form Card */
.form-card {
    background: white;
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.12);
    margin-bottom: 24px;
}

.form-header {
    text-align: center;
    margin-bottom: 32px;
}

.form-title {
    font-size: 32px;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 8px;
}

.form-subtitle {
    font-size: 16px;
    color: #666;
}

/* Form Groups */
.form-group {
    margin-bottom: 24px;
}

.form-label {
    display: block;
    font-size: 16px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
}

.form-label.required::after {
    content: " *";
    color: #dc2626;
}

.form-input {
    width: 100%;
    padding: 14px 16px;
    border: 2px solid #e5e5e5;
    border-radius: 12px;
    font-size: 16px;
    transition: all 0.2s ease;
    background: white;
}

.form-input:focus {
    outline: none;
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
}

.form-input.error {
    border-color: #dc2626;
}

.form-input.error:focus {
    border-color: #dc2626;
    box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
}

.form-textarea {
    min-height: 100px;
    resize: vertical;
}

.form-help {
    font-size: 14px;
    color: #666;
    margin-top: 6px;
}

.form-error {
    font-size: 14px;
    color: #dc2626;
    margin-top: 6px;
    font-weight: 500;
}

/* Image Preview */
.image-preview-container {
    margin-top: 12px;
}

.image-preview {
    max-width: 200px;
    max-height: 200px;
    border-radius: 12px;
    border: 2px solid #e5e5e5;
    padding: 8px;
    background: #f8f8f8;
}

.image-preview img {
    width: 100%;
    height: auto;
    border-radius: 8px;
}

.image-placeholder {
    width: 200px;
    height: 150px;
    background: #f8f8f8;
    border: 2px dashed #ccc;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #666;
    font-size: 48px;
}

/* Buttons */
.form-actions {
    display: flex;
    gap: 16px;
    justify-content: center;
    margin-top: 32px;
    flex-wrap: wrap;
}

.btn {
    padding: 14px 28px;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 600;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    min-width: 140px;
    justify-content: center;
}

.btn-primary {
    background: #10b981;
    color: white;
}

.btn-primary:hover {
    background: #059669;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    color: white;
    text-decoration: none;
}

.btn-secondary {
    background: #f3f4f6;
    color: #374151;
    border: 1px solid #d1d5db;
}

.btn-secondary:hover {
    background: #e5e7eb;
    color: #374151;
    text-decoration: none;
}

.btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none !important;
}

/* Input Icons */
.input-group {
    position: relative;
}

.input-icon {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 18px;
    color: #666;
    pointer-events: none;
}

.input-group .form-input {
    padding-left: 48px;
}

/* Points Input Special Styling */
.points-input-container {
    position: relative;
}

.points-suffix {
    position: absolute;
    right: 16px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 16px;
    color: #10b981;
    font-weight: 600;
    pointer-events: none;
}

.points-input {
    padding-right: 70px;
}

/* File Upload Styling */
.file-upload-container {
    position: relative;
}

.file-input {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.file-upload-label {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 32px 20px;
    border: 2px dashed #ccc;
    border-radius: 12px;
    background: #f8f9fa;
    cursor: pointer;
    transition: all 0.2s ease;
    text-align: center;
}

.file-upload-label:hover {
    border-color: #10b981;
    background: #f0fdf4;
}

.file-upload-label.dragover {
    border-color: #10b981;
    background: #ecfdf5;
    transform: scale(1.02);
}

.file-upload-icon {
    font-size: 48px;
    margin-bottom: 12px;
    color: #666;
}

.file-upload-text {
    font-size: 16px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 4px;
}

.file-upload-subtext {
    font-size: 14px;
    color: #6b7280;
}

.file-selected .file-upload-label {
    border-color: #10b981;
    background: #ecfdf5;
}

.file-selected .file-upload-icon {
    color: #10b981;
}

.file-selected .file-upload-text {
    color: #10b981;
}

/* Image Preview Updates */
.image-preview {
    position: relative;
    max-width: 200px;
    max-height: 200px;
    border-radius: 12px;
    border: 2px solid #e5e5e5;
    padding: 8px;
    background: #f8f8f8;
    overflow: hidden;
}

.image-preview img {
    width: 100%;
    height: auto;
    border-radius: 8px;
    display: block;
}

.remove-image-btn {
    position: absolute;
    top: 12px;
    right: 12px;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: rgba(220, 38, 38, 0.9);
    color: white;
    border: none;
    cursor: pointer;
    font-size: 14px;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.remove-image-btn:hover {
    background: #dc2626;
    transform: scale(1.1);
}

/* Mobile Responsiveness */
@media (max-width: 768px) {
    .main-content {
        padding: 16px;
    }

    .form-card {
        padding: 24px 20px;
    }

    .form-title {
        font-size: 28px;
    }

    .form-actions {
        flex-direction: column;
    }

    .btn {
        width: 100%;
    }
}

@media (max-width: 480px) {
    .header-content {
        flex-direction: column;
        gap: 16px;
        align-items: flex-start;
    }

    .form-card {
        padding: 20px 16px;
    }
}

/* Animations */
.fade-in {
    animation: fadeIn 0.3s ease-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Loading State */
.loading {
    opacity: 0.7;
    pointer-events: none;
}

.loading .btn {
    position: relative;
}

.loading .btn::after {
    content: '';
    position: absolute;
    width: 20px;
    height: 20px;
    border: 2px solid transparent;
    border-top: 2px solid currentColor;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}
</style>

<div class="dashboard-container">
    <!-- Header -->
    <header class="dashboard-header">
        <div class="header-content">
            <div class="header-left">
                <a href="{{ route('item.index') }}" class="header-back-btn">
                    ←
                </a>
                <div class="header-title-section">
                    <h1 class="app-title">➕ Add New Item</h1>
                    <p class="app-subtitle">Create a new item for receipt generation</p>
                </div>
            </div>
            <a href="{{ route('item.index') }}" class="back-button">
                ← Back to Items
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Validation Errors -->
        @if($errors->any())
            <div class="alert alert-error fade-in">
                ❌ Please fix the following errors:
                <ul style="margin: 8px 0 0 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Card -->
        <div class="form-card fade-in">
            <div class="form-header">
                <h2 class="form-title">📦 Create New Item</h2>
                <p class="form-subtitle">Fill in the details below to add a new item to your catalog</p>
            </div>

            <form method="POST" action="{{ route('item.store') }}" id="itemForm" enctype="multipart/form-data">
                @csrf

                <!-- Item Name -->
                <div class="form-group">
                    <label for="name" class="form-label required">Item Name</label>
                    <div class="input-group">
                        <span class="input-icon">📦</span>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-input @error('name') error @enderror"
                            value="{{ old('name') }}"
                            placeholder="Enter item name (e.g., Reusable Cup, Coffee Grounds)"
                            maxlength="255"
                            required
                        >
                    </div>
                    @error('name')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                    <div class="form-help">
                        Choose a clear, descriptive name for your item that customers will easily recognize.
                    </div>
                </div>

                <!-- Points Per Unit -->
                <div class="form-group">
                    <label for="points_per_unit" class="form-label required">Points Per Unit</label>
                    <div class="input-group points-input-container">
                        <span class="input-icon">⭐</span>
                        <input
                            type="number"
                            id="points_per_unit"
                            name="points_per_unit"
                            class="form-input points-input @error('points_per_unit') error @enderror"
                            value="{{ old('points_per_unit') }}"
                            placeholder="Enter points value"
                            min="1"
                            max="1000"
                            required
                        >
                        <span class="points-suffix">points</span>
                    </div>
                    @error('points_per_unit')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                    <div class="form-help">
                        Set the points value customers earn for each unit of this item (1-1000 points).
                    </div>
                </div>

                <!-- Image Upload -->
                <div class="form-group">
                    <label for="image" class="form-label">Item Image</label>
                    <div class="file-upload-container">
                        <input
                            type="file"
                            id="image"
                            name="image"
                            class="form-input file-input @error('image') error @enderror"
                            accept="image/jpeg,image/png,image/jpg,image/gif"
                        >
                        <div class="file-upload-label" onclick="document.getElementById('image').click()">
                            <span class="file-upload-icon">📁</span>
                            <span class="file-upload-text">Choose Image File</span>
                            <span class="file-upload-subtext">JPEG, PNG, JPG, GIF (Max: 5MB)</span>
                        </div>
                    </div>
                    @error('image')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                    <div class="form-help">
                        Optional: Upload an image that represents this item. Leave blank to use a default icon.
                    </div>

                    <!-- Image Preview -->
                    <div class="image-preview-container" id="imagePreview" style="display: none;">
                        <div class="image-preview">
                            <img id="previewImg" src="" alt="Item preview">
                            <button type="button" class="remove-image-btn" onclick="removeImage()">✕</button>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('item.index') }}" class="btn btn-secondary">
                        ❌ Cancel
                    </a>
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        ✅ Create Item
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    const fileUploadLabel = document.querySelector('.file-upload-label');
    const fileUploadContainer = document.querySelector('.file-upload-container');
    const form = document.getElementById('itemForm');
    const submitBtn = document.getElementById('submitBtn');

    // File input change handler
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            handleFileSelect(file);
        }
    });

    // Drag and drop functionality
    fileUploadLabel.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('dragover');
    });

    fileUploadLabel.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
    });

    fileUploadLabel.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');

        const files = e.dataTransfer.files;
        if (files.length > 0) {
            const file = files[0];
            if (file.type.startsWith('image/')) {
                imageInput.files = files;
                handleFileSelect(file);
            } else {
                alert('Please select an image file.');
            }
        }
    });

    function handleFileSelect(file) {
        // Validate file size (5MB = 5120KB)
        if (file.size > 5120 * 1024) {
            alert('File size must be less than 5MB.');
            imageInput.value = '';
            return;
        }

        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
        if (!allowedTypes.includes(file.type)) {
            alert('Please select a valid image file (JPEG, PNG, JPG, GIF).');
            imageInput.value = '';
            return;
        }

        // Show preview
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            imagePreview.style.display = 'block';
            fileUploadContainer.classList.add('file-selected');

            // Update upload label text
            document.querySelector('.file-upload-text').textContent = file.name;
            document.querySelector('.file-upload-subtext').textContent = formatFileSize(file.size);
        };
        reader.readAsDataURL(file);
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // Remove image function
    window.removeImage = function() {
        imageInput.value = '';
        imagePreview.style.display = 'none';
        fileUploadContainer.classList.remove('file-selected');

        // Reset upload label text
        document.querySelector('.file-upload-text').textContent = 'Choose Image File';
        document.querySelector('.file-upload-subtext').textContent = 'JPEG, PNG, JPG, GIF (Max: 5MB)';
    };

    // Form submission with loading state
    form.addEventListener('submit', function() {
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Creating...';
        form.classList.add('loading');
    });

    // Auto-focus first input
    document.getElementById('name').focus();

    // Points input validation
    const pointsInput = document.getElementById('points_per_unit');
    pointsInput.addEventListener('input', function() {
        const value = parseInt(this.value);
        if (value < 1) this.value = 1;
        if (value > 1000) this.value = 1000;
    });
});
</script>
@endsection
