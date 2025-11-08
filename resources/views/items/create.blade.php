@extends('layouts.app')

@section('title', 'Add New Item - Green Cup App')
@section('page-title', 'Add New Item')
@section('page-subtitle', 'Create a new recyclable item')

@push('styles')
<style>
/* Form Container */
.form-container {
    max-width: 900px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Form Card */
.form-card {
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border-radius: 16px;
    padding: 32px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    border: 1px solid rgba(0, 176, 155, 0.1);
    animation: fadeInUp 0.4s ease;
}

.form-header {
    border-bottom: 2px solid #f3f4f6;
    padding-bottom: 20px;
    margin-bottom: 28px;
}

.form-title {
    font-size: 24px;
    font-weight: 700;
    color: #1f2937;
    margin: 0 0 8px 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.form-title i {
    color: #00b09b;
}

.form-subtitle {
    font-size: 14px;
    color: #6b7280;
    margin: 0;
}

/* Form Group */
.form-group {
    margin-bottom: 24px;
}

.form-label {
    display: block;
    font-size: 14px;
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
    padding: 12px 16px;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.3s ease;
    background: white;
}

.form-input:focus {
    outline: none;
    border-color: #00b09b;
    box-shadow: 0 0 0 3px rgba(0, 176, 155, 0.1);
}

.form-input.error {
    border-color: #dc2626;
}

.form-input.error:focus {
    border-color: #dc2626;
    box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
}

.form-help {
    font-size: 13px;
    color: #6b7280;
    margin-top: 6px;
}

.form-error {
    font-size: 13px;
    color: #dc2626;
    margin-top: 6px;
    font-weight: 500;
}

/* Input Icons */
.input-wrapper {
    position: relative;
}

.input-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
    font-size: 16px;
}

.input-wrapper .form-input {
    padding-left: 44px;
}

/* Points Input */
.points-wrapper {
    position: relative;
}

.points-suffix {
    position: absolute;
    right: 14px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 14px;
    color: #00b09b;
    font-weight: 600;
}

.points-wrapper .form-input {
    padding-right: 70px;
}

/* Image Upload */
.image-upload-area {
    border: 2px dashed #d1d5db;
    border-radius: 12px;
    padding: 32px 20px;
    text-align: center;
    background: #f9fafb;
    cursor: pointer;
    transition: all 0.3s ease;
}

.image-upload-area:hover {
    border-color: #00b09b;
    background: rgba(0, 176, 155, 0.05);
}

.image-upload-area.dragover {
    border-color: #00b09b;
    background: rgba(0, 176, 155, 0.1);
    transform: scale(1.01);
}

.upload-icon {
    font-size: 48px;
    color: #9ca3af;
    margin-bottom: 12px;
}

.upload-text {
    font-size: 15px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 4px;
}

.upload-subtext {
    font-size: 13px;
    color: #6b7280;
}

.file-input {
    display: none;
}

.image-upload-area.has-file {
    border-color: #00b09b;
    background: rgba(0, 176, 155, 0.05);
}

.image-upload-area.has-file .upload-icon {
    color: #00b09b;
}

.image-upload-area.has-file .upload-text {
    color: #00b09b;
}

/* Image Preview */
.image-preview-container {
    margin-top: 16px;
    display: none;
}

.image-preview {
    position: relative;
    max-width: 250px;
    margin: 0 auto;
    border-radius: 12px;
    overflow: hidden;
    border: 2px solid #e5e7eb;
}

.image-preview img {
    width: 100%;
    height: auto;
    display: block;
}

.remove-image-btn {
    position: absolute;
    top: 8px;
    right: 8px;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: rgba(220, 38, 38, 0.9);
    color: white;
    border: none;
    cursor: pointer;
    font-size: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.remove-image-btn:hover {
    background: #dc2626;
    transform: scale(1.1);
}

/* Form Actions */
.form-actions {
    display: flex;
    gap: 12px;
    justify-content: flex-end;
    margin-top: 32px;
    padding-top: 24px;
    border-top: 2px solid #f3f4f6;
}

.btn {
    padding: 12px 24px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-primary {
    background: linear-gradient(135deg, #00b09b, #00d9a6);
    color: white;
    box-shadow: 0 4px 12px rgba(0, 176, 155, 0.25);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 176, 155, 0.35);
    color: white;
    text-decoration: none;
}

.btn-secondary {
    background: #f3f4f6;
    color: #374151;
    border: 1px solid #e5e7eb;
}

.btn-secondary:hover {
    background: #e5e7eb;
    color: #1f2937;
    text-decoration: none;
}

.btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none !important;
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive */
@media (max-width: 768px) {
    .form-container {
        padding: 0 16px;
    }

    .form-card {
        padding: 24px 20px;
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
    .form-card {
        padding: 20px 16px;
    }

    .form-title {
        font-size: 20px;
    }
}
</style>
@endpush

@section('content')
<div class="form-container">
    <div class="form-card">
        <div class="form-header">
            <h2 class="form-title">
                <i class="fas fa-plus-circle"></i>
                Add New Item
            </h2>
            <p class="form-subtitle">Fill in the details below to create a new recyclable item in your inventory</p>
        </div>

        <form method="POST" action="{{ route('item.store') }}" id="itemForm" enctype="multipart/form-data">
            @csrf

            <!-- Item Name -->
            <div class="form-group">
                <label for="name" class="form-label required">Item Name</label>
                <div class="input-wrapper">
                    <i class="fas fa-box input-icon"></i>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-input @error('name') error @enderror"
                        value="{{ old('name') }}"
                        placeholder="e.g., Reusable Cup, Coffee Grounds"
                        maxlength="255"
                        required
                        autofocus
                    >
                </div>
                @error('name')
                    <div class="form-error">{{ $message }}</div>
                @enderror
                <div class="form-help">Enter a clear, descriptive name that customers will recognize</div>
            </div>

            <!-- Image Upload -->
            <div class="form-group">
                <label class="form-label">Item Image (Optional)</label>
                <input
                    type="file"
                    id="image"
                    name="image"
                    class="file-input @error('image') error @enderror"
                    accept="image/*"
                >
                <div class="image-upload-area" id="uploadArea" onclick="document.getElementById('image').click()">
                    <div class="upload-icon"><i class="fas fa-camera"></i></div>
                    <div class="upload-text">Take photo or upload image</div>
                    <div class="upload-subtext">JPEG, PNG, JPG, GIF (Max: 5MB)</div>
                </div>
                @error('image')
                    <div class="form-error">{{ $message }}</div>
                @enderror
                <div class="form-help">Upload an image to help customers identify this item</div>

                <!-- Image Preview -->
                <div class="image-preview-container" id="imagePreview">
                    <div class="image-preview">
                        <img id="previewImg" src="" alt="Preview">
                        <button type="button" class="remove-image-btn" onclick="removeImage()">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <a href="{{ route('item.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <i class="fas fa-check"></i>
                    Create Item
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('image');
    const uploadArea = document.getElementById('uploadArea');
    const imagePreview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    const form = document.getElementById('itemForm');
    const submitBtn = document.getElementById('submitBtn');

    // File input change
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            handleFile(file);
        }
    });

    // Drag and drop
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('dragover');
    });

    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
    });

    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            const file = files[0];
            if (file.type.startsWith('image/')) {
                imageInput.files = files;
                handleFile(file);
            } else {
                alert('Please select an image file.');
            }
        }
    });

    function handleFile(file) {
        // Validate size (5MB)
        if (file.size > 5120 * 1024) {
            alert('File size must be less than 5MB.');
            imageInput.value = '';
            return;
        }

        // Validate type
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
            uploadArea.classList.add('has-file');
            uploadArea.querySelector('.upload-text').textContent = file.name;
            uploadArea.querySelector('.upload-subtext').textContent = formatFileSize(file.size);
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

    window.removeImage = function() {
        imageInput.value = '';
        imagePreview.style.display = 'none';
        uploadArea.classList.remove('has-file');
        uploadArea.querySelector('.upload-text').textContent = 'Click to upload or drag and drop';
        uploadArea.querySelector('.upload-subtext').textContent = 'JPEG, PNG, JPG, GIF (Max: 5MB)';
    };

    // Form submission
    form.addEventListener('submit', function() {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating...';
    });
});
</script>
@endsection
