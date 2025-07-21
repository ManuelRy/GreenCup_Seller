<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\SellerDashboardController;
use App\Http\Controllers\SellerAccountController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes (handled by SellerController)
Route::get('/login', [SellerController::class, 'showLogin'])->name('login');
Route::post('/login', [SellerController::class, 'login'])->name('login.store');
Route::post('/logout', [SellerController::class, 'logout'])->name('logout');

// Seller Registration Routes
Route::get('/register', [SellerController::class, 'create'])->name('sellers.create');
Route::post('/register', [SellerController::class, 'store'])->name('sellers.store');

// Protected Routes (requires seller authentication)
Route::middleware(['auth:seller'])->group(function () {
    // Main dashboard route - using SellerDashboardController for the analytics dashboard
    Route::get('/dashboard', [SellerDashboardController::class, 'dashboard'])->name('dashboard');
    
    // Additional seller routes
    Route::prefix('seller')->name('seller.')->group(function () {
        // Account/Profile management
        Route::get('/account', [SellerAccountController::class, 'index'])->name('account');
        Route::get('/account/transaction/{id}', [SellerAccountController::class, 'getTransactionDetail'])->name('account.transaction');
        Route::get('/account/download-receipt/{id}', [SellerAccountController::class, 'downloadReceipt'])->name('account.download-receipt');
        Route::get('/account/export', [SellerAccountController::class, 'exportTransactions'])->name('account.export');
        
        // Profile management (using SellerAccountController)
        Route::get('/profile', [SellerAccountController::class, 'profile'])->name('profile');
        Route::put('/profile', [SellerAccountController::class, 'updateProfile'])->name('profile.update');
        
        // QR Scanner (future feature)
        // Route::get('/scanner', [SellerScannerController::class, 'index'])->name('scanner');
        
        // Transactions (future feature - detailed view)
        // Route::get('/transactions', [SellerTransactionController::class, 'index'])->name('transactions');
        
        // Rankings (future feature)
        // Route::get('/rankings', [SellerRankingController::class, 'index'])->name('rankings');
    });
    
    // API routes for AJAX dashboard updates
    Route::get('/api/dashboard-data', [SellerDashboardController::class, 'getDashboardData'])->name('dashboard.data');
});

// Public routes (no authentication required)
Route::get('/test-dashboard', [SellerDashboardController::class, 'dashboard'])->name('test.dashboard');
Route::get('/test-account', function() {
    // For testing, get first seller
    $seller = \App\Models\Seller::first();
    if ($seller) {
        Auth::guard('seller')->login($seller);
        return redirect()->route('seller.account');
    }
    return redirect()->route('login')->with('error', 'No seller found for testing.');
})->name('test.account');

// Fallback route for undefined routes
Route::fallback(function () {
    return redirect()->route('login')->with('error', 'Page not found. Please log in to access the application.');
});