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

.create-container {
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
    max-width: 800px;
    margin: 0 auto;
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.form-header {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    padding: 30px;
    text-align: center;
}

.form-title {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 8px;
}

.form-subtitle {
    font-size: 16px;
    opacity: 0.9;
}

.form-content {
    padding: 40px;
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
    padding: 12px 16px;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 16px;
    transition: all 0.3s ease;
    background: white;
}

.form-input:focus,
.form-textarea:focus,
.form-select:focus {
    outline: none;
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
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

/* File Upload */
.file-upload-container {
    border: 2px dashed #d1d5db;
    border-radius: 8px;
    padding: 30px;
    text-align: center;
    transition: all 0.3s ease;
    cursor: pointer;
}

.file-upload-container:hover {
    border-color: #10b981;
    background: #f0fdf4;
}

.file-upload-icon {
    font-size: 48px;
    color: #9ca3af;
    margin-bottom: 15px;
}

.file-upload-text {
    color: #374151;
    font-weight: 600;
    margin-bottom: 5px;
}

.file-upload-hint {
    color: #6b7280;
    font-size: 14px;
}

.file-input {
    display: none;
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
}

.btn-primary {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #059669, #047857);
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
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

    .form-content {
        padding: 30px 20px;
    }

    .form-actions {
        flex-direction: column;
    }
}
</style>

<div class="create-container">
    <!-- Header -->
    {{-- <div class="header">
        <div class="header-content">
            <h1 class="header-title">🎁 Create New Reward</h1>
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
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="points_required" class="form-label">Points Required *</label>
                        <input type="number" id="points_required" name="points_required" class="form-input"
                               value="{{ old('points_required') }}" required min="1"
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
                              maxlength="1000" placeholder="Describe your reward, terms and conditions, etc.">{{ old('description') }}</textarea>
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
                               value="{{ old('quantity') }}" required min="1"
                               placeholder="50">
                        @error('quantity')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                        <div class="helper-text">How many of this reward are available</div>
                    </div>

                    <div class="form-group">
                        <label for="valid_from" class="form-label">Valid From *</label>
                        <input type="date" id="valid_from" name="valid_from" class="form-input"
                               value="{{ old('valid_from', date('Y-m-d')) }}" required>
                        @error('valid_from')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="valid_until" class="form-label">Valid Until *</label>
                        <input type="date" id="valid_until" name="valid_until" class="form-input"
                               value="{{ old('valid_until') }}" required>
                        @error('valid_until')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Image Upload -->
                <div class="form-group full-width">
                    <label for="image" class="form-label">Reward Image</label>
                    <div class="file-upload-container" onclick="document.getElementById('image').click()">
                        <div class="file-upload-icon">📷</div>
                        <div class="file-upload-text">Click to upload an image</div>
                        <div class="file-upload-hint">JPG, PNG, GIF up to 5MB</div>
                    </div>
                    <input type="file" id="image" name="image" class="file-input"
                           accept="image/jpeg,image/png,image/jpg,image/gif">
                    @error('image')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('reward.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        ✨ Create Reward
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// File upload preview
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const container = document.querySelector('.file-upload-container');

    if (file) {
        const fileName = file.name;
        container.innerHTML = `
            <div class="file-upload-icon">✅</div>
            <div class="file-upload-text">Image selected: ${fileName}</div>
            <div class="file-upload-hint">Click to change image</div>
        `;
    }
});

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
