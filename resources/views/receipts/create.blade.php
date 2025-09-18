@extends('master')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="create-receipt-container">
    <!-- Header -->
    <div class="create-header">
        <div class="header-content">
            <a href="{{ route('seller.receipts.index') }}" class="back-button">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
            </a>
            <div class="header-title">
                <h1>Create Receipt</h1>
                <p>Generate a receipt for customer purchase</p>
            </div>
            <div class="store-info">
                <div class="store-name">{{ $seller->business_name }}</div>
                <div class="store-location">📍 {{ Str::limit($seller->address, 30) }}</div>
            </div>
        </div>
    </div>

    <!-- Receipt Builder -->
    <div class="receipt-builder">
        <!-- Items Selection -->
        <div class="builder-section">
            <div class="items-section">
                <div class="section-header">
                    <h2>📦 Select Items</h2>
                    <p>Choose items the customer purchased</p>
                </div>

                <div class="items-grid">
                    @foreach($items as $item)
                        <div class="item-card" id="item-card-{{ $item->id }}">
                            <div class="item-icon">{{ getItemIcon($item->name) }}</div>
                            <div class="item-name">{{ $item->name }}</div>
                            <div class="item-points">{{ $item->points_per_unit }} pts each</div>
                            
                            <!-- Quantity Controls (initially hidden) -->
                            <div class="item-quantity-controls" id="qty-controls-{{ $item->id }}" style="display: none;">
                                <button type="button" class="qty-btn" onclick="changeQuantity({{ $item->id }}, -1)">-</button>
                                <span class="qty-display" id="qty-{{ $item->id }}">0</span>
                                <button type="button" class="qty-btn" onclick="changeQuantity({{ $item->id }}, 1)">+</button>
                            </div>
                            
                            <!-- Add Button (initially visible) -->
                            <button type="button" class="add-item-btn" id="add-btn-{{ $item->id }}" 
                                    onclick="addFirstItem({{ $item->id }}, '{{ addslashes($item->name) }}', {{ $item->points_per_unit }})">
                                <span class="btn-icon">+</span>
                                Add
                            </button>
                        </div>
                    @endforeach
                </div>

                @if($items->isEmpty())
                    <div class="no-items">
                        <div class="no-items-icon">📦</div>
                        <p>No items available. Please contact admin to add items to the system.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Receipt Preview -->
        <div class="receipt-preview">
            <div class="preview-header">
                <h3>📄 Receipt Preview</h3>
                <div class="preview-actions">
                    <button type="button" onclick="clearAll()" class="clear-btn" id="clear-btn" disabled>
                        🗑️ Clear All
                    </button>
                </div>
            </div>

            <div class="receipt-paper">
                <div class="receipt-header-section">
                    <div class="receipt-store">{{ $seller->business_name }}</div>
                    <div class="receipt-address">{{ $seller->address }}</div>
                    <div class="receipt-date">{{ now()->format('M d, Y g:i A') }}</div>
                </div>

                <div class="receipt-divider"></div>

                <div class="receipt-items" id="receipt-items">
                    <div class="no-items-text">No items selected</div>
                </div>

                <div class="receipt-divider"></div>

                <div class="receipt-totals">
                    <div class="total-row">
                        <span>Total Items:</span>
                        <span id="total-items">0</span>
                    </div>
                    <div class="total-row">
                        <span>Total Quantity:</span>
                        <span id="total-quantity">0</span>
                    </div>
                    <div class="total-row grand-total">
                        <span>Total Points:</span>
                        <span id="total-points">0 pts</span>
                    </div>
                </div>

                <!-- Expiration Settings -->
                <div class="expiration-section">
                    <label for="expires_hours">Receipt expires in:</label>
                    <select id="expires_hours" name="expires_hours">
                        <option value="1">1 hour</option>
                        <option value="6">6 hours</option>
                        <option value="12">12 hours</option>
                        <option value="24" selected>24 hours (1 day)</option>
                        <option value="48">48 hours (2 days)</option>
                        <option value="72">72 hours (3 days)</option>
                        <option value="168">1 week</option>
                    </select>
                </div>

                <!-- Generate Button -->
                <div class="generate-section">
                    <button type="button" onclick="generateReceipt()" class="generate-btn" id="generate-btn" disabled>
                        <span class="btn-text">
                            <span class="btn-icon">🎯</span>
                            Generate Receipt
                        </span>
                        <span class="btn-loading" style="display: none;">
                            <div class="loading-spinner"></div>
                            Generating...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div id="success-modal" class="modal" style="display: none;">
    <div class="modal-backdrop" onclick="closeModal()"></div>
    <div class="modal-content">
        <div class="modal-header">
            <h2>✅ Receipt Generated!</h2>
            <button type="button" onclick="closeModal()" class="close-modal">×</button>
        </div>
        
        <div class="modal-body">
            <div class="success-info">
                <div class="receipt-code-display">
                    <label>Receipt Code:</label>
                    <div class="code-value" id="generated-code">Loading...</div>
                </div>
                
                <div class="receipt-summary">
                    <div class="summary-item">
                        <span>Total Points:</span>
                        <span id="generated-points">0 pts</span>
                    </div>
                    <div class="summary-item">
                        <span>Total Items:</span>
                        <span id="generated-quantity">0</span>
                    </div>
                    <div class="summary-item">
                        <span>Expires:</span>
                        <span id="generated-expires">-</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal-actions">
            <button type="button" onclick="showQRCode()" class="btn-qr">
                <span class="btn-icon">📱</span>
                Show QR Code
            </button>
            <button type="button" onclick="createAnother()" class="btn-another">
                <span class="btn-icon">➕</span>
                Create Another
            </button>
            <button type="button" onclick="goToReceipts()" class="btn-done">
                <span class="btn-icon">📋</span>
                View All Receipts
            </button>
        </div>
    </div>
</div>

<!-- Toast -->
<div id="toast" class="toast" style="display: none;">
    <span id="toast-message">Message</span>
</div>

<style>
/* Base Styles */
* {
    box-sizing: border-box;
}

body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    margin: 0;
    background: #f8fafc;
    color: #111827;
}

/* Header */
.create-header {
    background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
    color: white;
    padding: 1.5rem;
}

.header-content {
    display: flex;
    align-items: center;
    gap: 1rem;
    max-width: 1400px;
    margin: 0 auto;
}

.back-button {
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-decoration: none;
    background: rgba(255, 255, 255, 0.2);
    width: 44px;
    height: 44px;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.back-button:hover {
    background: rgba(255, 255, 255, 0.3);
    text-decoration: none;
    color: white;
}

.header-title {
    flex: 1;
    text-align: center;
}

.header-title h1 {
    font-size: 1.75rem;
    font-weight: 700;
    margin: 0;
}

.header-title p {
    font-size: 0.875rem;
    margin: 0.25rem 0 0;
    opacity: 0.9;
}

.store-info {
    text-align: right;
}

.store-name {
    font-size: 1rem;
    font-weight: 600;
}

.store-location {
    font-size: 0.75rem;
    opacity: 0.8;
}

/* Receipt Builder */
.receipt-builder {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 2rem;
    padding: 2rem;
    max-width: 1400px;
    margin: 0 auto;
    align-items: start;
}

.builder-section {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.items-section {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.section-header h2 {
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0 0 0.5rem;
}

.section-header p {
    font-size: 0.875rem;
    color: #6b7280;
    margin: 0 0 1.5rem;
}

.items-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 1rem;
}

.item-card {
    background: #f8fafc;
    border: 2px solid transparent;
    border-radius: 16px;
    padding: 1.5rem;
    text-align: center;
    transition: all 0.3s ease;
}

.item-card:hover {
    border-color: #10b981;
    background: #f0fdf4;
    transform: translateY(-2px);
}

.item-card.selected {
    border-color: #10b981;
    background: #f0fdf4;
}

.item-icon {
    font-size: 2.5rem;
    margin-bottom: 0.75rem;
}

.item-name {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.item-points {
    font-size: 0.875rem;
    color: #10b981;
    font-weight: 600;
    margin-bottom: 1rem;
}

.add-item-btn {
    background: #10b981;
    color: white;
    border: none;
    border-radius: 8px;
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.25rem;
    width: 100%;
}

.add-item-btn:hover {
    background: #059669;
    transform: translateY(-1px);
}

.item-quantity-controls {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    margin-top: 1rem;
}

.qty-btn {
    width: 32px;
    height: 32px;
    border: 1px solid #e5e7eb;
    background: white;
    border-radius: 6px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    transition: all 0.2s ease;
}

.qty-btn:hover {
    border-color: #10b981;
    background: #10b981;
    color: white;
}

.qty-display {
    min-width: 32px;
    text-align: center;
    font-weight: 600;
    font-size: 1.125rem;
    color: #10b981;
}

/* Receipt Preview */
.receipt-preview {
    position: sticky;
    top: 2rem;
}

.preview-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.preview-header h3 {
    font-size: 1.25rem;
    font-weight: 700;
    margin: 0;
}

.clear-btn {
    background: #fee2e2;
    color: #dc2626;
    border: none;
    border-radius: 8px;
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.clear-btn:hover:not(:disabled) {
    background: #dc2626;
    color: white;
}

.clear-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.receipt-paper {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    border: 1px solid #f3f4f6;
}

.receipt-header-section {
    text-align: center;
    margin-bottom: 1.5rem;
}

.receipt-store {
    font-size: 1.25rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.receipt-address {
    font-size: 0.875rem;
    color: #6b7280;
    margin-bottom: 0.5rem;
}

.receipt-date {
    font-size: 0.75rem;
    color: #9ca3af;
}

.receipt-divider {
    border-top: 1px dashed #e5e7eb;
    margin: 1.5rem 0;
}

.receipt-items {
    min-height: 60px;
}

.no-items-text {
    text-align: center;
    color: #9ca3af;
    font-style: italic;
    padding: 2rem 0;
}

.receipt-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
    border-bottom: 1px solid #f3f4f6;
}

.receipt-item:last-child {
    border-bottom: none;
}

.receipt-item-name {
    font-weight: 600;
}

.receipt-item-qty {
    font-size: 0.875rem;
    color: #6b7280;
    margin-top: 0.25rem;
}

.receipt-item-points {
    font-weight: 700;
    color: #10b981;
}

.receipt-totals {
    margin-top: 1rem;
}

.total-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
    font-size: 0.875rem;
    color: #6b7280;
}

.total-row.grand-total {
    border-top: 2px solid #e5e7eb;
    margin-top: 0.5rem;
    padding-top: 1rem;
    font-size: 1.125rem;
    font-weight: 700;
    color: #10b981;
}

.expiration-section {
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid #f3f4f6;
}

.expiration-section label {
    display: block;
    font-size: 0.875rem;
    font-weight: 600;
    color: #6b7280;
    margin-bottom: 0.5rem;
}

.expiration-section select {
    width: 100%;
    padding: 0.75rem;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    background: #f8fafc;
    font-size: 0.875rem;
    transition: all 0.3s ease;
}

.expiration-section select:focus {
    outline: none;
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
}

.generate-section {
    margin-top: 2rem;
}

.generate-btn {
    width: 100%;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    border: none;
    border-radius: 12px;
    padding: 1rem;
    font-size: 1rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
}

.generate-btn:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
}

.generate-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

.btn-text,
.btn-loading {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.loading-spinner {
    width: 20px;
    height: 20px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top-color: white;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* Modal */
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1000;
}

.modal-backdrop {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
}

.modal-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    border-radius: 20px;
    width: 90%;
    max-width: 500px;
    overflow: hidden;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    border-bottom: 1px solid #f3f4f6;
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
}

.modal-header h2 {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 700;
}

.close-modal {
    background: none;
    border: none;
    font-size: 1.5rem;
    color: #9ca3af;
    cursor: pointer;
    padding: 0.25rem;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.close-modal:hover {
    background: #f3f4f6;
    color: #6b7280;
}

.modal-body {
    padding: 1.5rem;
}

.receipt-code-display {
    text-align: center;
    margin-bottom: 1.5rem;
}

.receipt-code-display label {
    display: block;
    font-size: 0.875rem;
    font-weight: 600;
    color: #6b7280;
    margin-bottom: 0.5rem;
}

.code-value {
    font-family: 'SF Mono', Monaco, 'Cascadia Code', monospace;
    font-size: 1.5rem;
    font-weight: 700;
    color: #10b981;
    background: #f8fafc;
    padding: 1rem;
    border-radius: 8px;
    border: 2px solid #10b981;
}

.receipt-summary {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.summary-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem;
    background: #f8fafc;
    border-radius: 8px;
}

.modal-actions {
    display: flex;
    gap: 0.75rem;
    padding: 1.5rem;
    border-top: 1px solid #f3f4f6;
}

.btn-qr,
.btn-another,
.btn-done {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.75rem;
    border: none;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-qr {
    background: #ede9fe;
    color: #6366f1;
}

.btn-qr:hover {
    background: #6366f1;
    color: white;
}

.btn-another {
    background: #f3f4f6;
    color: #6b7280;
}

.btn-another:hover {
    background: #e5e7eb;
    color: #111827;
}

.btn-done {
    background: #10b981;
    color: white;
}

.btn-done:hover {
    background: #059669;
    transform: translateY(-1px);
}

/* Toast */
.toast {
    position: fixed;
    top: 2rem;
    right: 2rem;
    background: white;
    border-radius: 12px;
    padding: 1rem;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    z-index: 2000;
    transform: translateX(400px);
    transition: transform 0.3s ease;
    max-width: 350px;
    min-width: 280px;
    border-left: 4px solid #10b981;
}

.toast.show {
    transform: translateX(0);
}

.toast.error {
    border-left-color: #ef4444;
}

/* Responsive Design */
@media (max-width: 1200px) {
    .receipt-builder {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .receipt-preview {
        position: static;
        order: -1;
    }
}

@media (max-width: 768px) {
    .create-header {
        padding: 1rem;
    }
    
    .header-content {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .receipt-builder {
        padding: 1rem;
        gap: 1.5rem;
    }
    
    .items-section {
        padding: 1.5rem;
    }
    
    .items-grid {
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
    }
    
    .receipt-paper {
        padding: 1.5rem;
    }
    
    .modal-actions {
        flex-direction: column;
    }
}
</style>

<script>
// Global state
let selectedItems = {};
let isGenerating = false;
let generatedReceiptId = null;

// Item icons mapping
function getItemIcon(itemName) {
    const icons = {
        'Coffee': '☕',
        'Metal Straw': '🥤',
        'Straw': '🥤',
        'Eco Bag': '🍃',
        'Glass Container': '🍽️',
        'Smoothie': '🥤',
        'Organic Vegetables': '🥬',
        'Coffee Cup': '☕',
        'Reusable Cup': '♻️',
        'Bamboo Utensils': '🍴',
        'Shopping Bag': '🛍️',
        'Takeout Container': '📦',
        'Water Bottle': '🥤',
        'Utensils Set': '🍴',
        'Food Container': '🍽️'
    };
    return icons[itemName] || '📦';
}

// Add first item (when clicking Add button)
function addFirstItem(itemId, itemName, pointsPerUnit) {
    console.log('Adding first item:', itemId, itemName, pointsPerUnit);
    
    // Add to selected items
    selectedItems[itemId] = {
        id: itemId,
        name: itemName,
        pointsPerUnit: pointsPerUnit,
        quantity: 1
    };
    
    // Update UI
    updateItemCard(itemId);
    updateReceiptPreview();
    updateButtons();
}

// Change quantity (+ or - buttons)
function changeQuantity(itemId, change) {
    console.log('Changing quantity for item:', itemId, 'change:', change);
    
    if (!selectedItems[itemId]) return;
    
    const newQuantity = selectedItems[itemId].quantity + change;
    
    if (newQuantity <= 0) {
        // Remove item
        delete selectedItems[itemId];
        updateItemCard(itemId);
    } else if (newQuantity <= 10) {
        // Update quantity
        selectedItems[itemId].quantity = newQuantity;
        updateItemCard(itemId);
    } else {
        showToast('Maximum quantity (10) reached!', 'error');
        return;
    }
    
    updateReceiptPreview();
    updateButtons();
}

// Update individual item card UI
function updateItemCard(itemId) {
    const card = document.getElementById(`item-card-${itemId}`);
    const addBtn = document.getElementById(`add-btn-${itemId}`);
    const qtyControls = document.getElementById(`qty-controls-${itemId}`);
    const qtyDisplay = document.getElementById(`qty-${itemId}`);
    
    if (selectedItems[itemId]) {
        // Item is selected - show quantity controls
        card.classList.add('selected');
        addBtn.style.display = 'none';
        qtyControls.style.display = 'flex';
        qtyDisplay.textContent = selectedItems[itemId].quantity;
    } else {
        // Item is not selected - show add button
        card.classList.remove('selected');
        addBtn.style.display = 'flex';
        qtyControls.style.display = 'none';
        qtyDisplay.textContent = '0';
    }
}

// Update receipt preview
function updateReceiptPreview() {
    const itemsContainer = document.getElementById('receipt-items');
    const selectedItemsArray = Object.values(selectedItems);
    
    console.log('Updating receipt preview with items:', selectedItemsArray);
    
    if (selectedItemsArray.length === 0) {
        itemsContainer.innerHTML = '<div class="no-items-text">No items selected</div>';
    } else {
        const html = selectedItemsArray.map(item => `
            <div class="receipt-item">
                <div>
                    <div class="receipt-item-name">${item.name}</div>
                    <div class="receipt-item-qty">${item.quantity} × ${item.pointsPerUnit} pts</div>
                </div>
                <div class="receipt-item-points">${item.quantity * item.pointsPerUnit} pts</div>
            </div>
        `).join('');
        
        itemsContainer.innerHTML = html;
    }
    
    // Update totals
    const totalItems = selectedItemsArray.length;
    const totalQuantity = selectedItemsArray.reduce((sum, item) => sum + item.quantity, 0);
    const totalPoints = selectedItemsArray.reduce((sum, item) => sum + (item.quantity * item.pointsPerUnit), 0);
    
    document.getElementById('total-items').textContent = totalItems;
    document.getElementById('total-quantity').textContent = totalQuantity;
    document.getElementById('total-points').textContent = totalPoints + ' pts';
}

// Update button states
function updateButtons() {
    const hasItems = Object.keys(selectedItems).length > 0;
    
    document.getElementById('clear-btn').disabled = !hasItems;
    document.getElementById('generate-btn').disabled = !hasItems || isGenerating;
}

// Clear all items
function clearAll() {
    if (Object.keys(selectedItems).length === 0) return;
    
    if (confirm('Are you sure you want to clear all selected items?')) {
        // Reset all item cards
        Object.keys(selectedItems).forEach(itemId => {
            delete selectedItems[itemId];
            updateItemCard(parseInt(itemId));
        });
        
        updateReceiptPreview();
        updateButtons();
        showToast('All items cleared!', 'success');
    }
}

// Generate receipt
async function generateReceipt() {
    const selectedItemsArray = Object.values(selectedItems);
    if (selectedItemsArray.length === 0 || isGenerating) return;
    
    console.log('Generating receipt with items:', selectedItemsArray);
    
    isGenerating = true;
    
    // Update button state
    const generateBtn = document.getElementById('generate-btn');
    const btnText = generateBtn.querySelector('.btn-text');
    const btnLoading = generateBtn.querySelector('.btn-loading');
    
    generateBtn.disabled = true;
    btnText.style.display = 'none';
    btnLoading.style.display = 'flex';
    
    try {
        const expiresHours = document.getElementById('expires_hours').value;
        
        const requestData = {
            items: selectedItemsArray.map(item => ({
                item_id: item.id,
                quantity: item.quantity
            })),
            expires_hours: parseInt(expiresHours)
        };
        
        console.log('Sending request:', requestData);
        
        const response = await fetch('{{ route("seller.receipts.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify(requestData)
        });
        
        console.log('Response status:', response.status);
        
        const data = await response.json();
        console.log('Response data:', data);
        
        if (data.success) {
            generatedReceiptId = data.receipt.id;
            showSuccessModal(data.receipt);
            showToast('Receipt generated successfully!', 'success');
        } else {
            if (data.errors) {
                const errorMessages = Object.values(data.errors).flat().join('\n');
                showToast('Validation errors: ' + errorMessages, 'error');
            } else {
                showToast(data.message || 'Failed to generate receipt', 'error');
            }
        }
        
    } catch (error) {
        console.error('Generate receipt error:', error);
        showToast('Network error. Please try again.', 'error');
    } finally {
        isGenerating = false;
        
        // Reset button state
        generateBtn.disabled = Object.keys(selectedItems).length === 0;
        btnText.style.display = 'flex';
        btnLoading.style.display = 'none';
    }
}

// Show success modal
function showSuccessModal(receipt) {
    document.getElementById('generated-code').textContent = receipt.receipt_code;
    document.getElementById('generated-points').textContent = receipt.total_points + ' pts';
    document.getElementById('generated-quantity').textContent = receipt.total_quantity + ' items';
    document.getElementById('generated-expires').textContent = receipt.expires_at;
    
    document.getElementById('success-modal').style.display = 'block';
}

// Close modal
function closeModal() {
    document.getElementById('success-modal').style.display = 'none';
}

// Show QR code
function showQRCode() {
    if (generatedReceiptId) {
        const qrUrl = `{{ url('/seller/receipts') }}/${generatedReceiptId}/qr`;
        console.log('Opening QR URL:', qrUrl);
        window.open(qrUrl, '_blank');
    } else {
        showToast('No receipt ID available', 'error');
    }
}

// Create another receipt
function createAnother() {
    closeModal();
    
    // Clear current selection
    Object.keys(selectedItems).forEach(itemId => {
        delete selectedItems[itemId];
        updateItemCard(parseInt(itemId));
    });
    generatedReceiptId = null;
    
    // Reset displays
    updateReceiptPreview();
    updateButtons();
    
    // Scroll to top
    window.scrollTo({ top: 0, behavior: 'smooth' });
    showToast('Ready to create another receipt!', 'success');
}

// Go to receipts list
function goToReceipts() {
    window.location.href = '{{ route("seller.receipts.index") }}';
}

// Toast notification function
function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    const messageEl = document.getElementById('toast-message');
    
    messageEl.textContent = message;
    toast.className = `toast ${type === 'error' ? 'error' : ''}`;
    toast.style.display = 'block';
    
    setTimeout(() => toast.classList.add('show'), 100);
    
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.style.display = 'none', 300);
    }, 4000);
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    console.log('Create Receipt page loaded');
    updateButtons();
    
    // Handle escape key for modal
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });
    
    console.log('Initialization complete');
});

// PHP helper function for item icons
@php
function getItemIcon($itemName) {
    $icons = [
        'Coffee' => '☕',
        'Metal Straw' => '🥤',
        'Straw' => '🥤',
        'Eco Bag' => '🍃',
        'Glass Container' => '🍽️',
        'Smoothie' => '🥤',
        'Organic Vegetables' => '🥬',
        'Coffee Cup' => '☕',
        'Reusable Cup' => '♻️',
        'Bamboo Utensils' => '🍴',
        'Shopping Bag' => '🛍️',
        'Takeout Container' => '📦',
        'Water Bottle' => '🥤',
        'Utensils Set' => '🍴',
        'Food Container' => '🍽️'
    ];
    return $icons[$itemName] ?? '📦';
}
@endphp
</script>
@endsection