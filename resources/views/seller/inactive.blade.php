@extends('layouts.app')

@section('title', 'Account Pending Approval')

@section('content')
<div class="d-flex align-items-center justify-content-center" style="min-height: 80vh; background: #f8fafc;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card border-0 shadow-lg">
                    <div class="card-body text-center p-5">
                        <!-- Status Icon -->
                        <div class="mb-4">
                            <div class="bg-warning rounded-circle d-inline-flex align-items-center justify-content-center"
                                 style="width: 80px; height: 80px;">
                                <i class="bi bi-hourglass-split text-white" style="font-size: 2rem;"></i>
                            </div>
                        </div>

                        <!-- Main Message -->
                        <h2 class="text-success mb-3">Account Under Review</h2>
                        <p class="text-muted mb-4">Your seller application is being processed by our admin team.</p>

                        <!-- Info Alert -->
                        <div class="alert alert-success border-0" style="background: #e8f5e8;">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-info-circle text-success me-2 mt-1"></i>
                                <div class="text-start">
                                    <strong>What's next?</strong>
                                    <ul class="mb-0 mt-2 ps-3">
                                        <li>Review typically takes 1-2 business days</li>
                                        <li>You'll receive an email notification once approved</li>
                                        <li>Access to seller dashboard will be activated</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Progress Steps -->
                        <div class="my-4">
                            <div class="d-flex justify-content-center align-items-center">
                                <div class="text-center">
                                    <div class="bg-success rounded-circle d-inline-flex align-items-center justify-content-center mb-2"
                                         style="width: 30px; height: 30px;">
                                        <i class="bi bi-check text-white"></i>
                                    </div>
                                    <div><small class="text-success">Submitted</small></div>
                                </div>

                                <div class="border-top border-2 border-warning mx-3" style="width: 50px;"></div>

                                <div class="text-center">
                                    <div class="bg-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-2"
                                         style="width: 30px; height: 30px;">
                                        <i class="bi bi-search text-white"></i>
                                    </div>
                                    <div><small class="text-warning">Reviewing</small></div>
                                </div>

                                <div class="border-top border-2 border-muted mx-3" style="width: 50px;"></div>

                                <div class="text-center">
                                    <div class="bg-light border rounded-circle d-inline-flex align-items-center justify-content-center mb-2"
                                         style="width: 30px; height: 30px;">
                                        <i class="bi bi-shield-check text-muted"></i>
                                    </div>
                                    <div><small class="text-muted">Approved</small></div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-grid gap-2 mt-4">
                            <a href="mailto:support@greencups.com" class="btn btn-warning btn-lg">
                                <i class="bi bi-envelope me-2"></i>
                                Contact Support
                            </a>
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-house me-2"></i>
                                Back to Home
                            </a>
                        </div>

                        <!-- Additional Info -->
                        <div class="row mt-4 text-center">
                            <div class="col-6">
                                <div class="border-end">
                                    <i class="bi bi-clock text-muted d-block mb-1"></i>
                                    <small class="text-muted">1-2 Days</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <i class="bi bi-shield-check text-muted d-block mb-1"></i>
                                <small class="text-muted">Secure Process</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 1rem;
}

.alert {
    border-radius: 0.75rem;
}

.btn {
    border-radius: 0.5rem;
}

@media (max-width: 576px) {
    .card-body {
        padding: 2rem 1.5rem !important;
    }
}
</style>
@endsection
