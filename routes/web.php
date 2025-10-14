<?php

use App\Http\Controllers\GalleryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SellerAuthController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ImageProxyController;
/*
|--------------------------------------------------------------------------
| Web Routes - Clean Version
|--------------------------------------------------------------------------
*/

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Image proxy route (public, no auth needed)
// Proxies images from HTTP file server through HTTPS to avoid mixed content errors
Route::get('/proxy/images/{path}', [ImageProxyController::class, 'proxy'])
    ->where('path', '.*')
    ->name('image.proxy');

// Inactive seller status routes (accessible without auth)
Route::get('/pending', function () {
    return view('sellers.pending');
})->name('sellers.pending');

Route::get('/suspended', function () {
    return view('sellers.suspended');
})->name('sellers.suspended');

Route::get('/rejected', function () {
    return view('sellers.rejected');
})->name('sellers.rejected');

// Legacy route for backward compatibility
Route::get('/unauthorize', function () {
    return view('sellers.pending');
})->name('sellers.inactive');

/*
|--------------------------------------------------------------------------
| Guest Routes (Authentication)
|--------------------------------------------------------------------------
*/
Route::middleware(['guest:seller'])->group(function () {
    // Authentication routes
    Route::get('/login', [SellerAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [SellerAuthController::class, 'login'])->name('login.store');

    // Registration routes
    Route::get('/register', [SellerAuthController::class, 'create'])->name('sellers.create');
    Route::post('/register', [SellerAuthController::class, 'store'])->name('sellers.store');
});

/*
|--------------------------------------------------------------------------
| Logout Route (Available for authenticated users)
|--------------------------------------------------------------------------
*/
Route::post('/logout', [SellerAuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth:seller');

/*
|--------------------------------------------------------------------------
| Authenticated Seller Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:seller', 'seller.active'])->group(function () {

    // Dashboard Routes
    Route::get('/dashboard', [SellerController::class, 'dashboard'])->name('dashboard');
    Route::get('/api/dashboard-data', [SellerController::class, 'getDashboardData'])->name('dashboard.data');

    // Items Management Routes (outside seller prefix for cleaner URLs)
    Route::resource('items', ItemController::class)->names('item')->except(['show']);

    Route::resource('reports', ReportController::class)->names('report')->only(['index', 'create', 'store']);

    Route::resource('rewards', RewardController::class)->names('reward')->only(['index', 'create', 'store', 'edit', 'update']);

    // Reward Redemption Management Routes
    Route::get('/redemptions', [RewardController::class, 'redemptions'])->name('reward.redemptions');
    Route::post('/redemptions/{id}/approve', [RewardController::class, 'approveRedemption'])->name('reward.redemptions.approve');
    Route::post('/redemptions/{id}/reject', [RewardController::class, 'rejectRedemption'])->name('reward.redemptions.reject');

    // Location Management Routes
    Route::prefix('location')->name('location.')->group(function () {
        Route::get('/', [LocationController::class, 'show'])->name('show');
        Route::get('/edit', [LocationController::class, 'edit'])->name('edit');
        Route::put('/update', [LocationController::class, 'update'])->name('update');
        Route::post('/reverse-geocode', [LocationController::class, 'reverseGeocode'])->name('reverse-geocode');
        Route::post('/search-address', [LocationController::class, 'searchAddress'])->name('search-address');
        Route::get('/approximate-location', [LocationController::class, 'getApproximateLocation'])->name('approximate-location');
    });

    // Seller-specific routes
    Route::prefix('seller')->name('seller.')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Account & Profile Routes
        |--------------------------------------------------------------------------
        */
        Route::get('/account', [SellerController::class, 'account'])->name('account');
        Route::get('/activity', [SellerController::class, 'activity'])->name('activity');
        Route::get('/account/transaction/{id}', [SellerController::class, 'getTransactionDetail'])->name('account.transaction');
        Route::get('/account/download-receipt/{id}', [SellerController::class, 'downloadReceipt'])->name('account.download-receipt');
        Route::get('/account/export', [SellerController::class, 'exportTransactions'])->name('account.export');

        Route::post('/profile/photo', [SellerController::class, 'updateProfilePhoto'])->name('photo.update');
        Route::get('/profile', [SellerController::class, 'profile'])->name('profile');
        Route::put('/profile', [SellerController::class, 'updateProfile'])->name('profile.update');

        /*
        |--------------------------------------------------------------------------
        | Photo Gallery Routes
        |--------------------------------------------------------------------------
        */

        Route::get('/photos', [GalleryController::class, 'index'])->name('photos');
        Route::post('/photos', [GalleryController::class, 'store'])->name('photos.store');
        Route::get('/photos/{id}', [GalleryController::class, 'show'])->name('photos.show');
        Route::put('/photos/{id}', [GalleryController::class, 'update'])->name('photos.update');
        Route::delete('/photos/{id}', [GalleryController::class, 'destroy'])->name('photos.destroy');

        Route::post('/photos/reorder', [SellerController::class, 'reorderPhotos'])->name('photos.reorder');
        Route::get('/api/photo-stats', [SellerController::class, 'getPhotoStats'])->name('api.photo-stats');

        /*
        |--------------------------------------------------------------------------
        | Location Routes
        |--------------------------------------------------------------------------
        */
        Route::put('/location', [SellerController::class, 'updateLocation'])->name('location.update');

        /*
        |--------------------------------------------------------------------------
        | QR Scanner Routes
        |--------------------------------------------------------------------------
        */
        Route::get('/scanner', [SellerController::class, 'scanner'])->name('scanner');
        Route::post('/qr/process-consumer', [SellerController::class, 'processConsumer'])->name('qr.process-consumer');
        Route::post('/qr/award-points', [SellerController::class, 'awardPoints'])->name('qr.award-points');
        Route::get('/qr/recent-transactions', [SellerController::class, 'recentTransactions'])->name('qr.recent-transactions');
        Route::post('/qr/process-redemption', [SellerController::class, 'processRedemption'])->name('qr.process-redemption');

        // Receipt route
        Route::get('/receipts/export', [ReceiptController::class, 'export'])->name('receipts.export');
        Route::get('/receipts/{id}/qr', [ReceiptController::class, 'print'])->name('receipts.qr');

        // Test endpoint for debugging
        Route::post('/test-json', function(\Illuminate\Http\Request $request) {
            \Log::info('Test JSON endpoint hit', [
                'data' => $request->all(),
                'headers' => $request->headers->all()
            ]);
            return response()->json([
                'success' => true,
                'message' => 'JSON POST working correctly',
                'received_data' => $request->all(),
                'timestamp' => now()->toDateTimeString()
            ]);
        })->name('test-json');

        // Debug route to check image URLs
        Route::get('/debug-images', function() {
            $items = \App\Models\Item::whereNotNull('image_url')->take(5)->get(['id', 'name', 'image_url']);
            $fRepo = new \App\Repository\FileRepository();

            return response()->json([
                'environment' => [
                    'APP_ENV' => env('APP_ENV'),
                    'APP_URL' => env('APP_URL'),
                    'FILE_SERVER_URL' => env('FILE_SERVER_URL'),
                    'FILE_SERVER_PUBLIC_URL' => env('FILE_SERVER_PUBLIC_URL'),
                    'USE_IMAGE_PROXY' => env('USE_IMAGE_PROXY'),
                ],
                'items' => $items,
                'test_url' => $items->first() ? $fRepo->get($items->first()->image_url) : 'No items with images',
            ]);
        })->name('debug-images');

        Route::resource('receipts', ReceiptController::class)->names('receipts');
    });
});

/*
|--------------------------------------------------------------------------
| Consumer API Routes (for receipt scanning)
|--------------------------------------------------------------------------
*/
Route::prefix('api')->name('api.')->group(function () {
    // Receipt API routes for consumer app integration
    // These will be implemented when you build the consumer mobile app
    Route::post('/receipt/check', function () {
        return response()->json(['message' => 'Consumer API not implemented yet']);
    })->name('receipt.check');

    Route::post('/receipt/claim', function () {
        return response()->json(['message' => 'Consumer API not implemented yet']);
    })->name('receipt.claim');

    Route::get('/receipt/history', function () {
        return response()->json(['message' => 'Consumer API not implemented yet']);
    })->name('receipt.history');
});


/*
|--------------------------------------------------------------------------
| Fallback Route
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    return redirect()->route('login')->with('error', 'Page not found. Please log in to access the application.');
});
