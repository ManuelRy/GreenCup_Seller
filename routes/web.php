<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\SellerDashboardController;
use App\Http\Controllers\SellerAccountController;
use App\Http\Controllers\SellerPhotoController;
use App\Http\Controllers\SellerQRController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Guest routes (not authenticated)
Route::middleware(['guest:seller'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('login');
    });
    
    Route::get('/login', [SellerController::class, 'showLogin'])->name('login');
    Route::post('/login', [SellerController::class, 'login'])->name('login.store');
    
    Route::get('/register', [SellerController::class, 'create'])->name('sellers.create');
    Route::post('/register', [SellerController::class, 'store'])->name('sellers.store');
});

// Logout route (available for authenticated users)
Route::post('/logout', [SellerController::class, 'logout'])->name('logout')->middleware('auth:seller');

// Authenticated seller routes
Route::middleware(['auth:seller'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [SellerDashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/api/dashboard-data', [SellerDashboardController::class, 'getDashboardData'])->name('dashboard.data');
    
    // Seller-specific routes
    Route::prefix('seller')->name('seller.')->group(function () {
        // Account routes
        Route::get('/account', [SellerAccountController::class, 'index'])->name('account');
        Route::get('/account/transaction/{id}', [SellerAccountController::class, 'getTransactionDetail'])->name('account.transaction');
        Route::get('/account/download-receipt/{id}', [SellerAccountController::class, 'downloadReceipt'])->name('account.download-receipt');
        Route::get('/account/export', [SellerAccountController::class, 'exportTransactions'])->name('account.export');
        
        // Profile routes
        Route::get('/profile', [SellerAccountController::class, 'profile'])->name('profile');
        Route::put('/profile', [SellerAccountController::class, 'updateProfile'])->name('profile.update');
        
        // Photo gallery routes
        Route::get('/photos', [SellerPhotoController::class, 'index'])->name('photos');
        Route::post('/photos', [SellerPhotoController::class, 'store'])->name('photos.store');
        Route::get('/photos/{id}', [SellerPhotoController::class, 'show'])->name('photos.show');
        Route::put('/photos/{id}', [SellerPhotoController::class, 'update'])->name('photos.update');
        Route::delete('/photos/{id}', [SellerPhotoController::class, 'destroy'])->name('photos.destroy');
        Route::post('/photos/reorder', [SellerPhotoController::class, 'reorder'])->name('photos.reorder');
        Route::get('/api/photo-stats', [SellerPhotoController::class, 'getPhotoStats'])->name('api.photo-stats');
        
        // Location route
        Route::put('/location', [SellerPhotoController::class, 'updateLocation'])->name('location.update');
        
        // QR Scanner routes
        Route::get('/scanner', [SellerQRController::class, 'index'])->name('scanner');
        Route::post('/qr/process-consumer', [SellerQRController::class, 'processConsumer'])->name('qr.process-consumer');
        Route::post('/qr/award-points', [SellerQRController::class, 'awardPoints'])->name('qr.award-points');
        Route::get('/qr/recent-transactions', [SellerQRController::class, 'recentTransactions'])->name('qr.recent-transactions');
        Route::post('/qr/process-redemption', [SellerQRController::class, 'processRedemption'])->name('qr.process-redemption');
    });
});

// Test routes (development only - remove in production)
if (app()->environment('local')) {
    Route::get('/test-dashboard', function () {
        $seller = \App\Models\Seller::first();
        if ($seller) {
            Auth::guard('seller')->login($seller);
            return redirect()->route('dashboard');
        }
        return redirect()->route('login')->with('error', 'No seller found for testing.');
    })->name('test.dashboard');
    
    Route::get('/test-account', function () {
        $seller = \App\Models\Seller::first();
        if ($seller) {
            Auth::guard('seller')->login($seller);
            return redirect()->route('seller.account');
        }
        return redirect()->route('login')->with('error', 'No seller found for testing.');
    })->name('test.account');
    
    Route::get('/test-photos', function () {
        $seller = \App\Models\Seller::first();
        if ($seller) {
            Auth::guard('seller')->login($seller);
            return redirect()->route('seller.photos');
        }
        return redirect()->route('login')->with('error', 'No seller found for testing.');
    })->name('test.photos');
}

// Fallback route - must be last
Route::fallback(function () {
    return redirect()->route('login')->with('error', 'Page not found. Please log in to access the application.');
});