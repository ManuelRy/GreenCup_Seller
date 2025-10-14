@extends('master')

@section('content')
  <div class="container-fluid min-vh-100 py-3">
    <div class="row justify-content-center">
      <div class="col-12 col-xl-10">

        <!-- Page Header -->
        <div class="row mb-4">
          <div class="col-12">
            <div class="card border-0 shadow-sm bg-gradient-primary text-white rounded-4">
              <div class="card-body py-4">
                <div class="d-flex align-items-center justify-content-between">
                  <div>
                    <div class="mb-3">
                      <i class="fas fa-list-alt fa-3x opacity-90"></i>
                    </div>
                    <h2 class="fw-bold mb-2">My Reports</h2>
                    <p class="fw-light opacity-90 mb-0">Track the status of your submitted reports</p>
                  </div>
                  <div class="text-end">
                    <a href="{{ route('report.create') }}" class="btn btn-light btn-lg">
                      <i class="fas fa-plus me-2"></i>New Report
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Reports List -->
        <div class="row">
          <div class="col-12">
            @if($reports && $reports->count() > 0)
              <div class="row g-4">
                @foreach($reports as $report)
                  <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-3 report-card">
                      <div class="card-body p-4">
                        <div class="row align-items-center">
                          <div class="col-md-8">
                            <div class="d-flex align-items-start">
                              <!-- Report Icon Based on Tag -->
                              <div class="me-3">
                                @if($report->tag == 'App Bug')
                                  <div class="icon-wrapper bg-danger">
                                    <i class="fas fa-bug text-white"></i>
                                  </div>
                                @elseif($report->tag == 'Store Issue')
                                  <div class="icon-wrapper bg-warning">
                                    <i class="fas fa-store text-white"></i>
                                  </div>
                                @elseif($report->tag == 'Payment')
                                  <div class="icon-wrapper bg-info">
                                    <i class="fas fa-credit-card text-white"></i>
                                  </div>
                                @elseif($report->tag == 'Account')
                                  <div class="icon-wrapper bg-primary">
                                    <i class="fas fa-user-circle text-white"></i>
                                  </div>
                                @elseif($report->tag == 'QR Scan')
                                  <div class="icon-wrapper bg-success">
                                    <i class="fas fa-qrcode text-white"></i>
                                  </div>
                                @else
                                  <div class="icon-wrapper bg-secondary">
                                    <i class="fas fa-question-circle text-white"></i>
                                  </div>
                                @endif
                              </div>

                              <!-- Report Details -->
                              <div class="flex-grow-1">
                                <div class="d-flex align-items-center mb-2">
                                  <h5 class="mb-0 fw-bold text-dark me-3">{{ $report->title }}</h5>

                                  <!-- Priority Badge -->
                                  @if($report->priority == 'Critical')
                                    <span class="badge bg-danger">
                                      <i class="fas fa-exclamation-triangle me-1"></i>Critical
                                    </span>
                                  @elseif($report->priority == 'High')
                                    <span class="badge bg-warning">
                                      <i class="fas fa-exclamation-circle me-1"></i>High
                                    </span>
                                  @elseif($report->priority == 'Medium')
                                    <span class="badge bg-primary">
                                      <i class="fas fa-circle me-1"></i>Medium
                                    </span>
                                  @else
                                    <span class="badge bg-success">
                                      <i class="fas fa-circle me-1"></i>Low
                                    </span>
                                  @endif
                                </div>

                                <!-- Tag and Date -->
                                <div class="mb-2">
                                  <span class="badge bg-light text-dark me-2">
                                    <i class="fas fa-tag me-1"></i>{{ $report->tag }}
                                  </span>
                                  <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ $report->created_at->format('M d, Y \a\t g:i A') }}
                                  </small>
                                </div>

                                <!-- Description Preview -->
                                <p class="text-muted mb-0 description-preview">
                                  {{ Str::limit($report->description, 120) }}
                                </p>
                              </div>
                            </div>
                          </div>

                          <!-- Status and Actions -->
                          <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <!-- Status Badge -->
                            @if($report->status == 'Resolve')
                              <div class="status-badge bg-success">
                                <i class="fas fa-check-circle me-2"></i>
                                <span>Resolved</span>
                              </div>
                            @elseif($report->status == 'Warning')
                              <div class="status-badge bg-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <span>Under Review</span>
                              </div>
                            @elseif($report->status == 'Investigate')
                              <div class="status-badge bg-info">
                                <i class="fas fa-search me-2"></i>
                                <span>Investigating</span>
                              </div>
                            @elseif($report->status == 'Suspend')
                              <div class="status-badge bg-danger">
                                <i class="fas fa-pause-circle me-2"></i>
                                <span>Suspended</span>
                              </div>
                            @else
                              <div class="status-badge bg-secondary">
                                <i class="fas fa-clock me-2"></i>
                                <span>Pending</span>
                              </div>
                            @endif

                            <!-- Report ID -->
                            <div class="mt-2">
                              <small class="text-muted">
                                Report #{{ str_pad($report->id, 6, '0', STR_PAD_LEFT) }}
                              </small>
                            </div>
                          </div>
                        </div>

                        <!-- Evidences -->
                        @if($report->evidences && $report->evidences->count() > 0)
                          <div class="row mt-3">
                            <div class="col-12">
                              <hr class="my-3">
                              <div class="d-flex align-items-center">
                                <small class="text-muted me-3">
                                  <i class="fas fa-paperclip me-1"></i>Attachments:
                                </small>
                                <div class="d-flex gap-2 flex-wrap">
                                  @foreach($report->evidences as $evidence)
                                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="openImageModal('{{ $evidence->file_url }}', 'Evidence {{ $loop->iteration }}')">
                                      <i class="fas fa-image me-1"></i>View Image {{ $loop->iteration }}
                                    </button>
                                  @endforeach
                                </div>
                              </div>
                            </div>
                          </div>
                        @endif
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>

              <!-- Pagination -->
              @if($reports->hasPages())
                <div class="row mt-5">
                  <div class="col-12">
                    <div class="d-flex justify-content-center">
                      {{ $reports->links() }}
                    </div>
                  </div>
                </div>
              @endif

            @else
              <!-- Empty State -->
              <div class="row">
                <div class="col-12">
                  <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body text-center py-5">
                      <div class="mb-4">
                        <i class="fas fa-inbox fa-4x text-muted opacity-50"></i>
                      </div>
                      <h4 class="fw-bold text-dark mb-3">No Reports Yet</h4>
                      <p class="text-muted mb-4">
                        You haven't submitted any reports yet. If you encounter any issues or have feedback,
                        please don't hesitate to submit a report.
                      </p>
                      <a href="{{ route('report.create') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus me-2"></i>Submit Your First Report
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            @endif
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- Image Modal (Custom Implementation) -->
  <div class="custom-image-modal" id="imageModal" style="display: none;">
    <div class="custom-modal-backdrop" onclick="closeImageModal()"></div>
    <div class="custom-modal-dialog">
      <div class="custom-modal-content">
        <div class="custom-modal-header">
          <h5 class="custom-modal-title" id="imageModalLabel">Evidence Image</h5>
          <button type="button" class="custom-btn-close" onclick="closeImageModal()" aria-label="Close">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <div class="custom-modal-body">
          <img id="modalImage" src="" alt="Evidence">
        </div>
        <div class="custom-modal-footer">
          <a id="downloadImageBtn" href="" download class="custom-btn custom-btn-primary">
            <i class="fas fa-download me-2"></i>Download
          </a>
          <button type="button" class="custom-btn custom-btn-secondary" onclick="closeImageModal()">
            <i class="fas fa-times me-2"></i>Close
          </button>
        </div>
      </div>
    </div>
  </div>

  <style>
    /* Custom CSS consistent with dashboard theme */
    :root {
      --bs-primary: #1dd1a1;
      --bs-primary-rgb: 29, 209, 161;
      --bs-success: #22c55e;
      --bs-danger: #ef4444;
      --bs-warning: #f59e0b;
      --bs-info: #06b6d4;
    }

    .bg-gradient-primary {
      background: linear-gradient(135deg, #1dd1a1, #10ac84) !important;
    }

    .btn-primary {
      background: linear-gradient(135deg, #1dd1a1, #10ac84);
      border: none;
      transition: all 0.3s ease;
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(29, 209, 161, 0.3);
      background: linear-gradient(135deg, #10ac84, #0e8e71);
    }

    .btn-light {
      background: rgba(255, 255, 255, 0.95);
      border: none;
      color: #333;
      transition: all 0.3s ease;
    }

    .btn-light:hover {
      background: white;
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    /* Report Cards */
    .report-card {
      transition: all 0.3s ease;
      border-left: 4px solid #1dd1a1 !important;
    }

    .report-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1) !important;
    }

    /* Icon Wrappers */
    .icon-wrapper {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.25rem;
    }

    /* Status Badges */
    .status-badge {
      padding: 8px 16px;
      border-radius: 25px;
      font-weight: 600;
      font-size: 0.875rem;
      display: inline-flex;
      align-items: center;
      color: white;
    }

    /* Priority and Tag Badges */
    .badge {
      font-size: 0.75rem;
      padding: 4px 8px;
    }

    /* Description Preview */
    .description-preview {
      line-height: 1.5;
      font-size: 0.95rem;
    }

    /* Card animations */
    .card {
      animation: slideUp 0.6s ease-out;
    }

    @keyframes slideUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Mobile optimizations */
    @media (max-width: 768px) {
      .container-fluid {
        padding-left: 0.75rem;
        padding-right: 0.75rem;
      }

      .card-body {
        padding: 1.5rem;
      }

      .status-badge {
        font-size: 0.8rem;
        padding: 6px 12px;
      }

      .icon-wrapper {
        width: 40px;
        height: 40px;
        font-size: 1rem;
      }
    }

    /* Enhanced visual feedback */
    .btn:focus {
      outline: 2px solid #1dd1a1;
      outline-offset: 2px;
    }

    /* Pagination styling */
    .pagination .page-link {
      color: #1dd1a1;
      border-color: #e9ecef;
    }

    .pagination .page-link:hover {
      color: #10ac84;
      background-color: rgba(29, 209, 161, 0.1);
      border-color: #1dd1a1;
    }

    .pagination .page-item.active .page-link {
      background-color: #1dd1a1;
      border-color: #1dd1a1;
    }

    /* Custom Image Modal - Isolated Styles */
    .custom-image-modal {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 10000;
      display: flex;
      align-items: center;
      justify-content: center;
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.3s ease, visibility 0.3s ease;
    }

    .custom-image-modal.show {
      opacity: 1;
      visibility: visible;
    }

    .custom-modal-backdrop {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.75);
      backdrop-filter: blur(5px);
    }

    .custom-modal-dialog {
      position: relative;
      z-index: 10001;
      max-width: 90%;
      max-height: 90vh;
      width: 800px;
      animation: modalSlideIn 0.3s ease-out;
    }

    @keyframes modalSlideIn {
      from {
        transform: translateY(-50px) scale(0.9);
        opacity: 0;
      }
      to {
        transform: translateY(0) scale(1);
        opacity: 1;
      }
    }

    .custom-modal-content {
      background: #fff;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
    }

    .custom-modal-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 1.5rem;
      border-bottom: 2px solid #e8ecf4;
      background: linear-gradient(135deg, #1dd1a1, #10ac84);
    }

    .custom-modal-title {
      margin: 0;
      font-size: 1.25rem;
      font-weight: 600;
      color: white;
    }

    .custom-btn-close {
      background: rgba(255, 255, 255, 0.2);
      border: none;
      width: 36px;
      height: 36px;
      border-radius: 8px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 1.25rem;
      transition: all 0.2s ease;
    }

    .custom-btn-close:hover {
      background: rgba(255, 255, 255, 0.3);
      transform: rotate(90deg);
    }

    .custom-modal-body {
      padding: 2rem;
      background: #f8f9fa;
      text-align: center;
      position: relative;
      min-height: 200px;
      max-height: 60vh;
      overflow: auto;
    }

    .custom-modal-body img {
      max-width: 100%;
      max-height: 60vh;
      width: auto;
      height: auto;
      border-radius: 8px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
      opacity: 0;
      transition: opacity 0.3s ease, transform 0.3s ease;
    }

    .custom-modal-body img.loaded {
      opacity: 1;
    }

    .custom-modal-body img:hover {
      transform: scale(1.02);
    }

    .custom-modal-footer {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 1rem 1.5rem;
      border-top: 2px solid #e8ecf4;
      background: #fff;
    }

    .custom-btn {
      padding: 0.6rem 1.25rem;
      border-radius: 8px;
      border: none;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.2s ease;
      display: inline-flex;
      align-items: center;
      text-decoration: none;
      font-size: 0.95rem;
    }

    .custom-btn-primary {
      background: linear-gradient(135deg, #1dd1a1, #10ac84);
      color: white;
    }

    .custom-btn-primary:hover {
      background: linear-gradient(135deg, #10ac84, #0e8e71);
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(29, 209, 161, 0.3);
    }

    .custom-btn-secondary {
      background: #64748b;
      color: white;
    }

    .custom-btn-secondary:hover {
      background: #475569;
      transform: translateY(-2px);
    }

    .image-loading {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      font-size: 2.5rem;
      color: #1dd1a1;
    }

    /* Mobile responsive */
    @media (max-width: 768px) {
      .custom-modal-dialog {
        max-width: 95%;
        width: 95%;
      }

      .custom-modal-header {
        padding: 1rem;
      }

      .custom-modal-body {
        padding: 1rem;
        max-height: 50vh;
      }

      .custom-modal-footer {
        padding: 0.75rem 1rem;
        flex-direction: column;
        gap: 0.5rem;
      }

      .custom-btn {
        width: 100%;
        justify-content: center;
      }
    }
  </style>

  <script>
    // Function to open image in modal
    function openImageModal(imageUrl, imageTitle) {
      const modal = document.getElementById('imageModal');
      const modalImage = document.getElementById('modalImage');
      const modalTitle = document.getElementById('imageModalLabel');
      const modalBody = modal.querySelector('.custom-modal-body');
      const downloadBtn = document.getElementById('downloadImageBtn');

      // Reset image
      modalImage.classList.remove('loaded');
      modalImage.src = '';

      // Set download button
      downloadBtn.href = imageUrl;
      downloadBtn.download = imageTitle || 'evidence-image.jpg';

      // Add loading spinner
      const loadingSpinner = document.createElement('div');
      loadingSpinner.className = 'image-loading';
      loadingSpinner.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
      modalBody.appendChild(loadingSpinner);

      // Set title
      modalTitle.textContent = imageTitle || 'Evidence Image';

      // Show the modal (custom implementation)
      modal.style.display = 'flex';
      setTimeout(() => {
        modal.classList.add('show');
      }, 10);

      // Prevent body scroll
      document.body.style.overflow = 'hidden';

      // Load image
      const img = new Image();
      img.onload = function() {
        modalImage.src = imageUrl;
        modalImage.classList.add('loaded');
        // Remove loading spinner
        if (loadingSpinner && loadingSpinner.parentNode) {
          loadingSpinner.remove();
        }
      };
      img.onerror = function() {
        // Remove loading spinner
        if (loadingSpinner && loadingSpinner.parentNode) {
          loadingSpinner.remove();
        }
        modalImage.src = imageUrl; // Still try to load it
        modalImage.classList.add('loaded');
        alert('Failed to load image. Please try again.');
      };
      img.src = imageUrl;
    }

    // Function to close image modal
    function closeImageModal() {
      const modal = document.getElementById('imageModal');
      modal.classList.remove('show');

      // Restore body scroll
      document.body.style.overflow = '';

      setTimeout(() => {
        modal.style.display = 'none';
      }, 300);
    }

    // Close modal on ESC key
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        const modal = document.getElementById('imageModal');
        if (modal.classList.contains('show')) {
          closeImageModal();
        }
      }
    });

    document.addEventListener('DOMContentLoaded', function() {
      // Animate cards on scroll
      const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
      };

      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
          }
        });
      }, observerOptions);

      // Observe all report cards
      document.querySelectorAll('.report-card').forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = `all 0.6s ease ${index * 0.1}s`;
        observer.observe(card);
      });

      // Auto-dismiss alerts
      setTimeout(() => {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
          if (alert.querySelector('.btn-close')) {
            alert.querySelector('.btn-close').click();
          }
        });
      }, 5000);
    });
  </script>
@endsection
