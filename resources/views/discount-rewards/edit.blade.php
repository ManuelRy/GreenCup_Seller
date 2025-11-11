@extends('master')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="mb-4">
        <div class="d-flex align-items-center gap-3 mb-2">
            <a href="{{ route('reward.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back
            </a>
            <div>
                <h1 class="h2 fw-bold mb-0">Edit Discount Reward</h1>
                <p class="text-muted mb-0">Update discount settings</p>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('discount-reward.update', $discountReward->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Discount Name -->
                        <div class="mb-4">
                            <label for="name" class="form-label fw-semibold">
                                <i class="fas fa-tag me-2 text-primary"></i>Discount Name
                            </label>
                            <input type="text"
                                   class="form-control form-control-lg @error('name') is-invalid @enderror"
                                   id="name"
                                   name="name"
                                   value="{{ old('name', $discountReward->name) }}"
                                   placeholder="e.g., 10% Off, 20% Discount"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Give this discount a clear, descriptive name</div>
                        </div>

                        <!-- Discount Percentage -->
                        <div class="mb-4">
                            <label for="discount_percentage" class="form-label fw-semibold">
                                <i class="fas fa-percent me-2 text-warning"></i>Discount Percentage
                            </label>
                            <div class="input-group input-group-lg">
                                <input type="number"
                                       class="form-control @error('discount_percentage') is-invalid @enderror"
                                       id="discount_percentage"
                                       name="discount_percentage"
                                       value="{{ old('discount_percentage', $discountReward->discount_percentage) }}"
                                       min="0.01"
                                       max="100"
                                       step="0.01"
                                       placeholder="10"
                                       required>
                                <span class="input-group-text">%</span>
                                @error('discount_percentage')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text">Enter the discount percentage (e.g., 10 for 10% off)</div>
                        </div>

                        <!-- Points Cost -->
                        <div class="mb-4">
                            <label for="points_cost" class="form-label fw-semibold">
                                <i class="fas fa-coins me-2 text-success"></i>Points Cost
                            </label>
                            <div class="input-group input-group-lg">
                                <input type="number"
                                       class="form-control @error('points_cost') is-invalid @enderror"
                                       id="points_cost"
                                       name="points_cost"
                                       value="{{ old('points_cost', $discountReward->points_cost) }}"
                                       min="1"
                                       placeholder="50"
                                       required>
                                <span class="input-group-text">pts</span>
                                @error('points_cost')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text">How many points will be deducted when customer uses this discount</div>
                        </div>

                        <!-- Active Status -->
                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input"
                                       type="checkbox"
                                       id="is_active"
                                       name="is_active"
                                       value="1"
                                       {{ old('is_active', $discountReward->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="is_active">
                                    <i class="fas fa-power-off me-2 text-success"></i>Active (Available for use)
                                </label>
                            </div>
                        </div>

                        <!-- Info Box -->
                        <div class="alert alert-info border-0 mb-4">
                            <h6 class="alert-heading fw-bold">
                                <i class="fas fa-info-circle me-2"></i>How Discount Rewards Work
                            </h6>
                            <ul class="mb-0 ps-3">
                                <li>When you create a receipt, you can attach this discount to it</li>
                                <li>When customer scans the receipt, their points will be deducted immediately</li>
                                <li>The discount is applied at the time of purchase, not redeemed separately</li>
                                <li>Customer pays fewer points for the transaction if discount is applied</li>
                            </ul>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-lg px-4">
                                <i class="fas fa-save me-2"></i>Update Discount Reward
                            </button>
                            <a href="{{ route('reward.index') }}" class="btn btn-outline-secondary btn-lg px-4">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                            <button type="button"
                                    class="btn btn-outline-danger btn-lg px-4 ms-auto"
                                    onclick="deleteDiscount({{ $discountReward->id }})">
                                <i class="fas fa-trash me-2"></i>Delete
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 16px;
}

.form-control:focus, .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
}
</style>

<script>
async function deleteDiscount(id) {
    if (!confirm('Are you sure you want to delete this discount reward? This action cannot be undone.')) {
        return;
    }

    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (!csrfToken) {
            alert('CSRF token not found. Please refresh the page.');
            return;
        }

        const response = await fetch(`/discount-rewards/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken.content,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const data = await response.json();

        if (data.success) {
            window.location.href = '{{ route("reward.index") }}';
        } else {
            alert(data.message || 'Failed to delete discount reward');
        }
    } catch (error) {
        console.error('Delete error:', error);
        alert('Failed to delete discount reward. Please try again.');
    }
}
</script>
@endsection
