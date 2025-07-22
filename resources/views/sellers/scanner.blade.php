@extends('master')

@section('content')
    <div class="scanner-fullscreen">
        <!-- Video Background -->
        <video id="qr-video" autoplay muted playsinline></video>
        
        <!-- Header -->
        <div class="scanner-header">
            <h1 class="app-title">ABA Scan</h1>
            <a href="{{ route('dashboard') }}" class="close-btn">×</a>
        </div>

        <!-- Scan Frame -->
        <div class="scan-overlay">
            <div class="scan-frame">
                <div class="frame-corner corner-tl"></div>
                <div class="frame-corner corner-tr"></div>
                <div class="frame-corner corner-bl"></div>
                <div class="frame-corner corner-br"></div>
            </div>
        </div>

        <!-- Bottom Controls -->
        <div class="bottom-controls">
            <button id="flash-btn" class="control-button">
                <div class="control-icon">⚡</div>
                <div class="control-label">Flash</div>
            </button>
            
            <button id="gallery-btn" class="control-button">
                <div class="control-icon">📷</div>
                <div class="control-label">Upload QR</div>
            </button>
        </div>

        <!-- Status Message -->
        <div class="scan-status" id="scan-status">
            <p>Position customer QR code within the frame</p>
        </div>

        <!-- Success Modal - Consumer Details -->
        <div id="consumer-modal" class="success-modal" style="display: none;">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Customer Found!</h2>
                    <button onclick="closeConsumerModal()" class="modal-close">×</button>
                </div>
                
                <div class="consumer-info" id="consumer-info">
                    <!-- Consumer details will be populated here -->
                </div>

                <!-- Award Points Section -->
                <div class="award-section">
                    <h3>Add Items</h3>
                    
                    <!-- Selected Items List -->
                    <div class="selected-items-container" id="selected-items-container">
                        <!-- Selected items will appear here -->
                    </div>
                    
                    <!-- Add Item Button -->
                    <button onclick="showItemSelector()" class="add-item-btn">
                        <span>+</span> Add Item
                    </button>
                    
                    <!-- Points Summary -->
                    <div class="points-summary-box">
                        <div class="summary-row">
                            <span>Total Items:</span>
                            <span id="total-items">0</span>
                        </div>
                        <div class="summary-row">
                            <span>Total Quantity:</span>
                            <span id="total-quantity">0</span>
                        </div>
                        <div class="summary-row total">
                            <span>Total Points:</span>
                            <span id="total-points-preview">0 pts</span>
                        </div>
                    </div>
                    
                    <div class="action-buttons">
                        <button onclick="closeConsumerModal()" class="btn-cancel">Cancel</button>
                        <button onclick="confirmAwardPoints()" class="btn-confirm" id="confirm-btn" disabled>
                            <span class="btn-icon">✓</span>
                            Award Points
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Item Selector Modal -->
        <div id="item-selector-modal" class="item-selector-modal" style="display: none;">
            <div class="item-selector-content">
                <div class="item-selector-header">
                    <h3>Select Item</h3>
                    <button onclick="closeItemSelector()" class="modal-close">×</button>
                </div>
                
                <div class="items-grid" id="items-grid">
                    <!-- Items will be populated here -->
                </div>
            </div>
        </div>

        <!-- Transaction Success Modal -->
        <div id="success-modal" class="transaction-success-modal" style="display: none;">
            <div class="success-content">
                <div class="success-animation">
                    <div class="success-icon">🎉</div>
                    <div class="success-title">Points Awarded!</div>
                </div>
                
                <div class="points-summary">
                    <div class="points-awarded" id="points-awarded">
                        <!-- Points details will be shown here -->
                    </div>
                </div>

                <div class="success-actions">
                    <button onclick="goToDashboard()" class="btn-dashboard">
                        <span class="btn-icon">🏠</span>
                        Dashboard
                    </button>
                    <button onclick="scanAnother()" class="btn-scan-more">
                        <span class="btn-icon">📱</span>
                        Scan Another
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .scanner-fullscreen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: #000;
            z-index: 9999;
            overflow: hidden;
        }

        #qr-video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 1;
        }

        .scanner-header {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            z-index: 10;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 50px 20px 20px;
            background: linear-gradient(180deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.4) 70%, transparent 100%);
        }

        .app-title {
            color: white;
            font-size: 24px;
            font-weight: 600;
            margin: 0;
            text-shadow: 0 2px 8px rgba(0,0,0,0.5);
            letter-spacing: 2px;
        }

        .close-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            text-decoration: none;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            line-height: 1;
        }

        .close-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            color: white;
            text-decoration: none;
        }

        .scan-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 5;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .scan-frame {
            position: relative;
            width: 280px;
            height: 280px;
        }

        .frame-corner {
            position: absolute;
            width: 60px;
            height: 60px;
            border: 4px solid white;
        }

        .corner-tl {
            top: 0;
            left: 0;
            border-right: none;
            border-bottom: none;
            border-top-left-radius: 16px;
        }

        .corner-tr {
            top: 0;
            right: 0;
            border-left: none;
            border-bottom: none;
            border-top-right-radius: 16px;
        }

        .corner-bl {
            bottom: 0;
            left: 0;
            border-right: none;
            border-top: none;
            border-bottom-left-radius: 16px;
        }

        .corner-br {
            bottom: 0;
            right: 0;
            border-left: none;
            border-top: none;
            border-bottom-right-radius: 16px;
        }

        .bottom-controls {
            position: absolute;
            bottom: 30px;
            left: 0;
            right: 0;
            z-index: 10;
            display: flex;
            justify-content: center;
            gap: 20px;
            padding: 0 20px;
        }

        .control-button {
            flex: 1;
            max-width: 160px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 50px;
            padding: 16px 24px;
            color: white;
            cursor: pointer;
            backdrop-filter: blur(20px);
            transition: all 0.3s ease;
        }

        .control-button:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
        }

        .control-button:active {
            transform: scale(0.98);
        }

        .control-icon {
            font-size: 20px;
        }

        .control-label {
            font-size: 16px;
            font-weight: 500;
        }

        .scan-status {
            position: absolute;
            bottom: 120px;
            left: 20px;
            right: 20px;
            z-index: 10;
            text-align: center;
        }

        .scan-status p {
            color: white;
            font-size: 16px;
            font-weight: 400;
            margin: 0;
            text-shadow: 0 2px 8px rgba(0,0,0,0.5);
        }

        /* Consumer Modal Styles */
        .success-modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1000;
            background: rgba(0, 0, 0, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            backdrop-filter: blur(5px);
        }

        .modal-content {
            width: 100%;
            max-width: 500px;
            max-height: 90vh;
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            animation: modalSlideUp 0.4s ease;
        }

        .modal-header {
            background: linear-gradient(135deg, #2E8B57, #3CB371);
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h2 {
            margin: 0;
            font-size: 24px;
        }

        .modal-close {
            background: none;
            border: none;
            color: white;
            font-size: 28px;
            cursor: pointer;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: background 0.3s ease;
        }

        .modal-close:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .consumer-info {
            padding: 20px;
            background: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
        }

        .consumer-details {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .consumer-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6f42c1, #8b5cf6);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
            font-weight: bold;
        }

        .consumer-meta h3 {
            margin: 0 0 5px 0;
            font-size: 20px;
            color: #2c3e50;
        }

        .consumer-meta p {
            margin: 0;
            color: #6c757d;
            font-size: 14px;
        }

        .consumer-stats {
            display: flex;
            gap: 20px;
            margin-top: 15px;
        }

        .stat-item {
            flex: 1;
            text-align: center;
            padding: 10px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .stat-value {
            font-size: 24px;
            font-weight: bold;
            color: #2E8B57;
        }

        .stat-label {
            font-size: 12px;
            color: #6c757d;
            margin-top: 4px;
        }

        .award-section {
            padding: 20px;
            overflow-y: auto;
            max-height: calc(90vh - 300px);
        }

        .award-section h3 {
            margin: 0 0 20px 0;
            color: #2c3e50;
            font-size: 18px;
        }

        /* Selected Items Container */
        .selected-items-container {
            max-height: 250px;
            overflow-y: auto;
            margin-bottom: 15px;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            padding: 10px;
            background: #f8f9fa;
        }

        .selected-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px;
            background: white;
            border-radius: 8px;
            margin-bottom: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            animation: slideIn 0.3s ease;
        }

        .selected-item:last-child {
            margin-bottom: 0;
        }

        .item-info {
            display: flex;
            align-items: center;
            gap: 12px;
            flex: 1;
        }

        .item-icon {
            font-size: 24px;
        }

        .item-details {
            flex: 1;
        }

        .item-name {
            font-weight: 600;
            color: #2c3e50;
            font-size: 14px;
        }

        .item-unit-points {
            font-size: 12px;
            color: #6c757d;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .qty-btn {
            width: 28px;
            height: 28px;
            border: 1px solid #dee2e6;
            background: white;
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .qty-btn:hover {
            background: #f8f9fa;
            border-color: #2E8B57;
        }

        .qty-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .quantity-display {
            min-width: 20px;
            text-align: center;
            font-weight: 600;
            color: #2c3e50;
        }

        .item-points {
            font-weight: 600;
            color: #2E8B57;
            min-width: 60px;
            text-align: right;
        }

        .remove-item {
            width: 28px;
            height: 28px;
            border: none;
            background: #dc3545;
            color: white;
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 10px;
            transition: all 0.2s ease;
        }

        .remove-item:hover {
            background: #c82333;
            transform: scale(1.1);
        }

        /* Add Item Button */
        .add-item-btn {
            width: 100%;
            padding: 14px;
            border: 2px dashed #2E8B57;
            background: #e8f5e9;
            border-radius: 12px;
            color: #2E8B57;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 20px;
        }

        .add-item-btn:hover {
            background: #c8e6c9;
            border-color: #1e7e34;
        }

        .add-item-btn span {
            font-size: 20px;
        }

        /* Points Summary */
        .points-summary-box {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 14px;
            color: #6c757d;
        }

        .summary-row:last-child {
            margin-bottom: 0;
        }

        .summary-row.total {
            font-size: 18px;
            font-weight: 600;
            color: #2E8B57;
            padding-top: 8px;
            border-top: 1px solid #e9ecef;
        }

        /* Item Selector Modal */
        .item-selector-modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1001;
            background: rgba(0, 0, 0, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .item-selector-content {
            width: 100%;
            max-width: 600px;
            max-height: 80vh;
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }

        .item-selector-header {
            background: #f8f9fa;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e9ecef;
        }

        .item-selector-header h3 {
            margin: 0;
            color: #2c3e50;
        }

        .items-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
            padding: 20px;
            overflow-y: auto;
            max-height: calc(80vh - 80px);
        }

        .item-card {
            background: #f8f9fa;
            border: 2px solid transparent;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .item-card:hover {
            background: #e8f5e9;
            border-color: #2E8B57;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(46, 139, 87, 0.2);
        }

        .item-card .item-icon {
            font-size: 36px;
            margin-bottom: 10px;
        }

        .item-card .item-name {
            font-size: 14px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .item-card .item-points {
            font-size: 16px;
            color: #2E8B57;
            font-weight: bold;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .btn-cancel, .btn-confirm {
            flex: 1;
            padding: 14px 20px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-cancel {
            background: #e9ecef;
            color: #6c757d;
        }

        .btn-cancel:hover {
            background: #dee2e6;
        }

        .btn-confirm {
            background: linear-gradient(135deg, #2E8B57, #3CB371);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-confirm:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(46, 139, 87, 0.3);
        }

        .btn-confirm:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* Transaction Success Modal */
        .transaction-success-modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1002;
            background: linear-gradient(135deg, #2E8B57, #3CB371);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .success-content {
            text-align: center;
            color: white;
            max-width: 400px;
            width: 100%;
        }

        .success-animation {
            margin-bottom: 30px;
        }

        .success-icon {
            font-size: 80px;
            margin-bottom: 20px;
            animation: bounce 0.8s ease;
        }

        .success-title {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .points-summary {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 25px;
            margin: 30px 0;
            color: #333;
        }

        .points-awarded {
            font-size: 48px;
            font-weight: bold;
            color: #2E8B57;
            margin-bottom: 10px;
        }

        .success-actions {
            display: flex;
            gap: 15px;
        }

        .btn-dashboard, .btn-scan-more {
            flex: 1;
            padding: 16px 20px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn-dashboard {
            background: white;
            color: #2E8B57;
        }

        .btn-scan-more {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid white;
        }

        .btn-icon {
            font-size: 18px;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 40px;
            color: #6c757d;
        }

        .empty-state-icon {
            font-size: 48px;
            margin-bottom: 10px;
            opacity: 0.3;
        }

        /* Animations */
        @keyframes modalSlideUp {
            from {
                transform: translateY(100px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes slideIn {
            from {
                transform: translateX(-20px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes bounce {
            0%, 20%, 60%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-30px);
            }
            80% {
                transform: translateY(-15px);
            }
        }

        /* Mobile Responsive */
        @media (max-width: 480px) {
            .scan-frame {
                width: 240px;
                height: 240px;
            }

            .frame-corner {
                width: 50px;
                height: 50px;
            }

            .items-grid {
                grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            }

            .modal-content {
                max-height: 100vh;
                border-radius: 0;
            }

            .success-actions {
                flex-direction: column;
            }

            .selected-items-container {
                max-height: 200px;
            }
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/qr-scanner@1.4.2/qr-scanner.umd.min.js"></script>
    <script>
        let scanner = null;
        let isScanning = false;
        let currentConsumer = null;
        let selectedItems = [];
        let availableItems = [];

        const video = document.getElementById('qr-video');
        const flashBtn = document.getElementById('flash-btn');
        const galleryBtn = document.getElementById('gallery-btn');
        const statusEl = document.getElementById('scan-status');
        const consumerModal = document.getElementById('consumer-modal');
        const itemSelectorModal = document.getElementById('item-selector-modal');
        const successModal = document.getElementById('success-modal');

        // Initialize scanner on page load
        window.addEventListener('load', initializeScanner);
        flashBtn.addEventListener('click', toggleFlash);
        galleryBtn.addEventListener('click', selectFromGallery);

        async function initializeScanner() {
            try {
                updateStatus('Starting camera...');
                
                scanner = new QrScanner(video, result => handleScanResult(result), {
                    returnDetailedScanResult: true,
                    highlightScanRegion: false,
                    highlightCodeOutline: false,
                    preferredCamera: 'environment',
                    maxScansPerSecond: 5
                });

                await scanner.start();
                isScanning = true;
                updateStatus('Position customer QR code within the frame');
                
            } catch (error) {
                console.error('Scanner initialization failed:', error);
                updateStatus('Camera access denied. Please allow camera access.');
            }
        }

        function updateStatus(message) {
            statusEl.innerHTML = `<p>${message}</p>`;
        }

        function handleScanResult(result) {
            console.log('QR Code detected:', result.data);
            
            // Haptic feedback
            if (navigator.vibrate) {
                navigator.vibrate(100);
            }
            
            // Stop scanning temporarily
            if (scanner) {
                scanner.stop();
                isScanning = false;
            }
            
            // Process consumer QR code
            processConsumerQR(result.data);
        }

        async function processConsumerQR(data) {
            try {
                updateStatus('Processing customer QR code...');
                
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                // Call API to get consumer details
                const response = await fetch('/seller/qr/process-consumer', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        qr_data: data
                    })
                });
                
                const result = await response.json();
                
                if (result.success) {
                    currentConsumer = result.consumer;
                    availableItems = result.items;
                    showConsumerModal(result);
                } else {
                    updateStatus('Error: ' + result.message);
                    setTimeout(() => {
                        updateStatus('Position customer QR code within the frame');
                        restartScanner();
                    }, 3000);
                }
                
            } catch (error) {
                console.error('Error processing QR code:', error);
                updateStatus('Network error. Please try again.');
                setTimeout(() => {
                    updateStatus('Position customer QR code within the frame');
                    restartScanner();
                }, 3000);
            }
        }

        function showConsumerModal(data) {
            const consumer = data.consumer;
            
            // Update consumer info
            document.getElementById('consumer-info').innerHTML = `
                <div class="consumer-details">
                    <div class="consumer-avatar">
                        ${consumer.full_name.charAt(0).toUpperCase()}
                    </div>
                    <div class="consumer-meta">
                        <h3>${consumer.full_name}</h3>
                        <p>${consumer.email}</p>
                    </div>
                </div>
                <div class="consumer-stats">
                    <div class="stat-item">
                        <div class="stat-value">${consumer.total_points.toLocaleString()}</div>
                        <div class="stat-label">Total Points</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">${consumer.transactions_count}</div>
                        <div class="stat-label">Transactions</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">${consumer.member_since}</div>
                        <div class="stat-label">Member Since</div>
                    </div>
                </div>
            `;
            
            // Reset selected items
            selectedItems = [];
            updateSelectedItemsDisplay();
            updateTotals();
            
            // Show modal
            consumerModal.style.display = 'flex';
        }

        function showItemSelector() {
            const itemsGrid = document.getElementById('items-grid');
            
            itemsGrid.innerHTML = availableItems.map(item => `
                <div class="item-card" onclick="addItemToSelection(${item.id}, '${item.name}', ${item.points_per_unit})">
                    <div class="item-icon">${getItemIcon(item.name)}</div>
                    <div class="item-name">${item.name}</div>
                    <div class="item-points">+${item.points_per_unit} pt</div>
                </div>
            `).join('');
            
            itemSelectorModal.style.display = 'flex';
        }

        function closeItemSelector() {
            itemSelectorModal.style.display = 'none';
        }

        function addItemToSelection(itemId, itemName, pointsPerUnit) {
            // Check if item already exists
            const existingItem = selectedItems.find(item => item.id === itemId);
            
            if (existingItem) {
                // Increase quantity if less than 3
                if (existingItem.quantity < 3) {
                    existingItem.quantity++;
                } else {
                    alert('Maximum quantity (3) reached for this item');
                }
            } else {
                // Add new item
                selectedItems.push({
                    id: itemId,
                    name: itemName,
                    pointsPerUnit: pointsPerUnit,
                    quantity: 1
                });
            }
            
            updateSelectedItemsDisplay();
            updateTotals();
            closeItemSelector();
        }

        function updateSelectedItemsDisplay() {
            const container = document.getElementById('selected-items-container');
            
            if (selectedItems.length === 0) {
                container.innerHTML = `
                    <div class="empty-state">
                        <div class="empty-state-icon">📦</div>
                        <p>No items selected yet</p>
                    </div>
                `;
                return;
            }
            
            container.innerHTML = selectedItems.map((item, index) => `
                <div class="selected-item">
                    <div class="item-info">
                        <div class="item-icon">${getItemIcon(item.name)}</div>
                        <div class="item-details">
                            <div class="item-name">${item.name}</div>
                            <div class="item-unit-points">${item.pointsPerUnit} pt each</div>
                        </div>
                    </div>
                    <div class="quantity-controls">
                        <button class="qty-btn" onclick="decreaseQuantity(${index})" ${item.quantity <= 1 ? 'disabled' : ''}>
                            -
                        </button>
                        <span class="quantity-display">${item.quantity}</span>
                        <button class="qty-btn" onclick="increaseQuantity(${index})" ${item.quantity >= 3 ? 'disabled' : ''}>
                            +
                        </button>
                    </div>
                    <div class="item-points">
                        ${item.quantity * item.pointsPerUnit} pts
                    </div>
                    <button class="remove-item" onclick="removeItem(${index})">
                        ×
                    </button>
                </div>
            `).join('');
        }

        function increaseQuantity(index) {
            if (selectedItems[index].quantity < 3) {
                selectedItems[index].quantity++;
                updateSelectedItemsDisplay();
                updateTotals();
            }
        }

        function decreaseQuantity(index) {
            if (selectedItems[index].quantity > 1) {
                selectedItems[index].quantity--;
                updateSelectedItemsDisplay();
                updateTotals();
            }
        }

        function removeItem(index) {
            selectedItems.splice(index, 1);
            updateSelectedItemsDisplay();
            updateTotals();
        }

        function updateTotals() {
            const totalItems = selectedItems.length;
            const totalQuantity = selectedItems.reduce((sum, item) => sum + item.quantity, 0);
            const totalPoints = selectedItems.reduce((sum, item) => sum + (item.quantity * item.pointsPerUnit), 0);
            
            document.getElementById('total-items').textContent = totalItems;
            document.getElementById('total-quantity').textContent = totalQuantity;
            document.getElementById('total-points-preview').textContent = totalPoints + ' pts';
            
            // Enable/disable confirm button
            document.getElementById('confirm-btn').disabled = totalItems === 0;
        }

        function getItemIcon(itemName) {
            const icons = {
                'Reusable Cup': '♻️',
                'Coffee Cup': '☕',
                'Water Bottle': '🥤',
                'Food Container': '🍽️',
                'Shopping Bag': '🛍️',
                'Takeout Container': '📦',
                'Straw': '🥤',
                'Utensils Set': '🍴'
            };
            return icons[itemName] || '📦';
        }

        async function confirmAwardPoints() {
            if (selectedItems.length === 0) {
                alert('Please select at least one item');
                return;
            }
            
            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                const response = await fetch('/seller/qr/award-points', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        consumer_id: currentConsumer.id,
                        items: selectedItems.map(item => ({
                            item_id: item.id,
                            quantity: item.quantity
                        }))
                    })
                });
                
                const result = await response.json();
                
                if (result.success) {
                    closeConsumerModal();
                    showSuccessModal(result);
                } else {
                    alert('Error: ' + result.message);
                }
                
            } catch (error) {
                console.error('Error awarding points:', error);
                alert('Network error. Please try again.');
            }
        }

        function showSuccessModal(data) {
            document.getElementById('points-awarded').innerHTML = `
                +${data.total_points_awarded} points
                <div style="font-size: 16px; color: #6c757d; margin-top: 10px;">
                    ${data.total_quantity} items scanned
                </div>
                <div style="font-size: 14px; color: #6c757d; margin-top: 5px;">
                    Customer now has ${data.consumer_total_points.toLocaleString()} points
                </div>
                <div style="font-size: 14px; color: #28a745; margin-top: 10px; font-weight: 600;">
                    Your rank points: +${data.total_points_awarded}
                </div>
            `;
            
            successModal.style.display = 'flex';
        }

        function closeConsumerModal() {
            consumerModal.style.display = 'none';
            restartScanner();
        }

        async function restartScanner() {
            if (!isScanning) {
                try {
                    await scanner.start();
                    isScanning = true;
                    updateStatus('Position customer QR code within the frame');
                } catch (error) {
                    updateStatus('Error restarting camera');
                }
            }
        }

        async function toggleFlash() {
            if (scanner && scanner.hasFlash()) {
                try {
                    await scanner.toggleFlash();
                    const isOn = scanner.isFlashOn();
                    flashBtn.style.background = isOn ? 'rgba(255, 255, 255, 0.3)' : 'rgba(255, 255, 255, 0.15)';
                } catch (error) {
                    console.log('Flash toggle failed:', error);
                }
            }
        }

        function selectFromGallery() {
            const input = document.createElement('input');
            input.type = 'file';
            input.accept = 'image/*';
            input.onchange = handleImageUpload;
            input.click();
        }

        async function handleImageUpload(event) {
            const file = event.target.files[0];
            if (file) {
                try {
                    updateStatus('Scanning image...');
                    const result = await QrScanner.scanImage(file);
                    handleScanResult({ data: result });
                } catch (error) {
                    updateStatus('No QR code found in image');
                    setTimeout(() => {
                        updateStatus('Position customer QR code within the frame');
                    }, 2000);
                }
            }
        }

        function goToDashboard() {
            window.location.href = '{{ route("dashboard") }}';
        }

        function scanAnother() {
            successModal.style.display = 'none';
            selectedItems = [];
            restartScanner();
        }

        // Handle page visibility changes
        document.addEventListener('visibilitychange', function() {
            if (document.hidden && scanner && isScanning) {
                scanner.stop();
                isScanning = false;
            } else if (!document.hidden && scanner && !isScanning && 
                       consumerModal.style.display === 'none' && 
                       successModal.style.display === 'none' &&
                       itemSelectorModal.style.display === 'none') {
                restartScanner();
            }
        });

        // Cleanup on page unload
        window.addEventListener('beforeunload', function() {
            if (scanner) {
                scanner.stop();
            }
        });
    </script>
@endsection