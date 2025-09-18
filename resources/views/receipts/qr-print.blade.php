<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Receipt QR Code - {{ $receipt->receipt_code }}</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      line-height: 1.6;
      color: #111827;
      background: #ffffff;
      padding: 2rem;
    }

    .qr-container {
      max-width: 600px;
      margin: 0 auto;
      background: white;
      border: 2px solid #e5e7eb;
      border-radius: 20px;
      padding: 2rem;
      text-align: center;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .header-section {
      margin-bottom: 2rem;
      padding-bottom: 1.5rem;
      border-bottom: 2px solid #e5e7eb;
    }

    .store-name {
      font-size: 2rem;
      font-weight: 800;
      color: #10b981;
      margin-bottom: 0.5rem;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .store-address {
      font-size: 1rem;
      color: #6b7280;
      margin-bottom: 1rem;
    }

    .receipt-title {
      font-size: 1.5rem;
      font-weight: 700;
      color: #111827;
      margin-bottom: 0.5rem;
    }

    .receipt-code {
      font-family: 'SF Mono', Monaco, 'Cascadia Code', monospace;
      font-size: 1.25rem;
      font-weight: 700;
      color: #10b981;
      background: #f0fdf4;
      padding: 0.75rem 1.5rem;
      border-radius: 8px;
      border: 2px solid #10b981;
      display: inline-block;
      margin-bottom: 1rem;
    }

    .qr-section {
      margin: 2rem 0;
      padding: 2rem;
      background: #f8fafc;
      border-radius: 16px;
      border: 1px solid #e5e7eb;
    }

    .qr-code-container {
      width: 300px;
      height: 300px;
      margin: 0 auto 1.5rem;
      background: white;
      border: 4px solid #10b981;
      border-radius: 16px;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
    }

    .qr-display {
      width: 100%;
      height: 100%;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 1rem;
      text-align: center;
    }

    .qr-icon {
      font-size: 3rem;
      margin-bottom: 1rem;
      color: #10b981;
    }

    .qr-text {
      font-size: 1.125rem;
      font-weight: 600;
      color: #111827;
      margin-bottom: 0.5rem;
    }

    .qr-code-text {
      font-family: 'SF Mono', Monaco, 'Cascadia Code', monospace;
      font-size: 0.875rem;
      color: #6b7280;
      word-break: break-all;
      line-height: 1.4;
      background: #f9fafb;
      padding: 0.5rem;
      border-radius: 6px;
      border: 1px solid #e5e7eb;
    }

    .scan-instructions {
      font-size: 1.125rem;
      color: #111827;
      margin-bottom: 1rem;
      font-weight: 600;
    }

    .scan-details {
      font-size: 0.9rem;
      color: #6b7280;
      line-height: 1.5;
    }

    .manual-entry-section {
      margin-top: 2rem;
      padding: 1.5rem;
      background: #fff7ed;
      border-radius: 12px;
      border: 1px solid #fed7aa;
    }

    .manual-title {
      font-size: 1rem;
      font-weight: 700;
      color: #9a3412;
      margin-bottom: 1rem;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
    }

    .manual-instructions {
      font-size: 0.875rem;
      color: #7c2d12;
      line-height: 1.5;
      text-align: left;
    }

    .manual-instructions ol {
      margin: 1rem 0;
      padding-left: 1.5rem;
    }

    .manual-instructions li {
      margin-bottom: 0.5rem;
    }

    .copy-code-section {
      margin-top: 1rem;
      padding: 1rem;
      background: white;
      border-radius: 8px;
      border: 1px solid #fed7aa;
    }

    .copy-input {
      width: 100%;
      padding: 0.75rem;
      font-family: 'SF Mono', Monaco, 'Cascadia Code', monospace;
      font-size: 0.875rem;
      border: 2px solid #e5e7eb;
      border-radius: 6px;
      text-align: center;
      background: #f9fafb;
      color: #111827;
    }

    .copy-btn {
      margin-top: 0.5rem;
      width: 100%;
      padding: 0.5rem;
      background: #10b981;
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 0.875rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .copy-btn:hover {
      background: #059669;
    }

    .copy-btn.copied {
      background: #059669;
    }

    .receipt-summary {
      margin-top: 2rem;
      padding: 1.5rem;
      background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
      border-radius: 12px;
      border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .summary-title {
      font-size: 1.25rem;
      font-weight: 700;
      color: #111827;
      margin-bottom: 1rem;
    }

    .summary-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1rem;
      margin-bottom: 1.5rem;
    }

    .summary-item {
      text-align: left;
    }

    .summary-label {
      font-size: 0.875rem;
      color: #6b7280;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      margin-bottom: 0.25rem;
    }

    .summary-value {
      font-size: 1.125rem;
      font-weight: 700;
      color: #111827;
    }

    .points-value {
      color: #10b981;
      font-size: 1.5rem;
    }

    .items-section {
      margin-top: 1.5rem;
      padding-top: 1.5rem;
      border-top: 1px solid rgba(16, 185, 129, 0.2);
    }

    .items-title {
      font-size: 1rem;
      font-weight: 700;
      color: #111827;
      margin-bottom: 1rem;
      text-align: center;
    }

    .items-list {
      display: grid;
      gap: 0.5rem;
    }

    .item-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0.5rem 1rem;
      background: white;
      border-radius: 8px;
      font-size: 0.875rem;
    }

    .item-name {
      font-weight: 600;
      color: #111827;
    }

    .item-points {
      font-weight: 700;
      color: #10b981;
    }

    .footer-section {
      margin-top: 2rem;
      padding-top: 1.5rem;
      border-top: 2px solid #e5e7eb;
      font-size: 0.875rem;
      color: #6b7280;
    }

    .expiry-info {
      background: #fef3c7;
      color: #92400e;
      padding: 1rem;
      border-radius: 8px;
      margin-bottom: 1rem;
      border: 1px solid #fbbf24;
    }

    .expiry-text {
      font-weight: 600;
      font-size: 0.9rem;
    }

    .print-actions {
      margin-top: 2rem;
      display: flex;
      gap: 1rem;
      justify-content: center;
    }

    .btn {
      padding: 0.75rem 1.5rem;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
    }

    .btn-print {
      background: #10b981;
      color: white;
    }

    .btn-print:hover {
      background: #059669;
      transform: translateY(-1px);
    }

    .btn-back {
      background: #f3f4f6;
      color: #6b7280;
    }

    .btn-back:hover {
      background: #e5e7eb;
      color: #111827;
      text-decoration: none;
    }

    /* Print styles */
    @media print {
      body {
        padding: 0;
        background: white;
      }

      .qr-container {
        box-shadow: none;
        border: 1px solid #000;
        border-radius: 0;
        margin: 0;
        max-width: none;
      }

      .print-actions,
      .manual-entry-section {
        display: none;
      }

      .qr-code-container {
        border-color: #000;
      }

      .receipt-code {
        border-color: #000;
      }
    }

    /* Mobile responsive */
    @media (max-width: 768px) {
      body {
        padding: 1rem;
      }

      .qr-container {
        padding: 1.5rem;
      }

      .store-name {
        font-size: 1.5rem;
      }

      .qr-code-container {
        width: 250px;
        height: 250px;
      }

      .summary-grid {
        grid-template-columns: 1fr;
        gap: 0.75rem;
      }

      .print-actions {
        flex-direction: column;
      }
    }
  </style>
</head>

<body>
  <div class="qr-container">
    <!-- Header -->
    <div class="header-section">
      <div class="store-name">{{ $seller->business_name }}</div>
      <div class="store-address">{{ $seller->address }}</div>
      <div class="receipt-title">📄 Receipt QR Code</div>
      <div class="receipt-code">{{ $receipt->receipt_code }}</div>
    </div>

    <!-- QR Code Section -->
    <div class="qr-section">
      <div class="qr-code-container">
        <!-- Real QR code canvas here -->
        <canvas id="qr-canvas" width="280" height="280"></canvas>
      </div>
      <div class="scan-instructions">📱 Scan with GreenCup App</div>
      <div class="scan-details">
        Customers can scan this QR code with the GreenCup mobile app<br>
        to claim {{ $receipt->total_points }} points for their purchase.
      </div>
    </div>

    <!-- Manual Entry Instructions -->
    <div class="manual-entry-section">
      <div class="manual-title">
        <span>📝</span>
        Manual Entry Instructions
      </div>
      <div class="manual-instructions">
        <p><strong>If QR scanning doesn't work, customers can manually enter the receipt code:</strong></p>
        <ol>
          <li>Open the GreenCup mobile app</li>
          <li>Go to "Claim Points" or "Enter Receipt Code"</li>
          <li>Type the receipt code below</li>
          <li>Tap "Claim Points" to receive {{ $receipt->total_points }} points</li>
        </ol>

        <div class="copy-code-section">
          <input type="text" class="copy-input" value="{{ $receipt->receipt_code }}" id="receipt-code-input" readonly>
          <button class="copy-btn" onclick="copyReceiptCode()">📋 Copy Receipt Code</button>
        </div>
      </div>
    </div>

    <!-- Receipt Summary -->
    <div class="receipt-summary">
      <div class="summary-title">📋 Receipt Summary</div>

      <div class="summary-grid">
        <div class="summary-item">
          <div class="summary-label">Total Items</div>
          <div class="summary-value">{{ count($receipt->items) }}</div>
        </div>
        <div class="summary-item">
          <div class="summary-label">Total Quantity</div>
          <div class="summary-value">{{ $receipt->total_quantity }}</div>
        </div>
        <div class="summary-item">
          <div class="summary-label">Total Points</div>
          <div class="summary-value points-value">{{ $receipt->total_points }} pts</div>
        </div>
        <div class="summary-item">
          <div class="summary-label">Created</div>
          <div class="summary-value">{{ $receipt->created_at }}</div>
        </div>
      </div>

      @if ($receipt->expires_at)
        <div class="expiry-info">
          <div class="expiry-text">
            ⏰ This receipt expires on {{ $receipt->expires_at }}
          </div>
        </div>
      @endif

      <!-- Items List -->
      @if (count($receipt->items) > 0)
        <div class="items-section">
          <div class="items-title">Items in this receipt:</div>
          <div class="items-list">
            @foreach ($receipt->items as $item)
              <div class="item-row">
                <span class="item-name">{{ $item['quantity'] }}x {{ $item['name'] }}</span>
                <span class="item-points">{{ $item['total_points'] }} pts</span>
              </div>
            @endforeach
          </div>
        </div>
      @endif
    </div>

    <!-- Footer -->
    <div class="footer-section">
      <p>🌱 Thank you for supporting eco-friendly practices!</p>
      <p>Generated on {{ now()->format('M d, Y g:i A') }}</p>
    </div>

    <!-- Print Actions -->
    <div class="print-actions">
      <button onclick="window.print()" class="btn btn-print">
        <span>🖨️</span>
        Print Receipt
      </button>
      <a href="{{ route('seller.receipts.show', $receipt->id) }}" class="btn btn-back">
        <span>← </span>
        Back to Receipt
      </a>
    </div>
  </div>

  <!-- QRious JS for QR code generation -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
  <script>
    // Generate QR code
    const qrValue = "{{ $receipt->receipt_code }}";
    const qrCanvas = document.getElementById('qr-canvas');
    if (qrCanvas && window.QRious) {
      new QRious({
        element: qrCanvas,
        value: qrValue,
        size: 280,
        background: 'white',
        foreground: '#10b981'
      });
    }

    // Copy receipt code to clipboard
    function copyReceiptCode() {
      const input = document.getElementById('receipt-code-input');
      const button = document.querySelector('.copy-btn');
      input.select();
      input.setSelectionRange(0, 99999);
      try {
        document.execCommand('copy');
        const originalText = button.textContent;
        button.textContent = '✅ Copied!';
        button.classList.add('copied');
        setTimeout(() => {
          button.textContent = originalText;
          button.classList.remove('copied');
        }, 2000);
      } catch (err) {
        alert('Failed to copy. Please select and copy manually.');
      }
    }

    // Handle keyboard shortcuts
    document.addEventListener('keydown', function(e) {
      if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
        e.preventDefault();
        window.print();
      }
      if (e.key === 'Escape') {
        window.history.back();
      }
      if ((e.ctrlKey || e.metaKey) && e.key === 'c' && e.target.id !== 'receipt-code-input') {
        copyReceiptCode();
      }
    });

    // Auto-print if requested
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('print') === 'true') {
      setTimeout(() => {
        window.print();
      }, 1000);
    }
  </script>
</body>

</html>
