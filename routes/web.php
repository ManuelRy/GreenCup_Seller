<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SellerAuthController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ReceiptController;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes - Clean Version
|--------------------------------------------------------------------------
*/

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/unauthorize', function () {
    return view('sellers.inactive');
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

    // Seller-specific routes
    Route::prefix('seller')->name('seller.')->group(function () {

        Route::resource('items', ItemController::class)->names('item');
        /*
        |--------------------------------------------------------------------------
        | Account & Profile Routes
        |--------------------------------------------------------------------------
        */
        Route::get('/account', [SellerController::class, 'account'])->name('account');
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
        Route::get('/photos', [SellerController::class, 'photos'])->name('photos');
        Route::post('/photos', [SellerController::class, 'storePhoto'])->name('photos.store');
        Route::get('/photos/{id}', [SellerController::class, 'showPhoto'])->name('photos.show');
        Route::put('/photos/{id}', [SellerController::class, 'updatePhoto'])->name('photos.update');
        Route::delete('/photos/{id}', [SellerController::class, 'destroyPhoto'])->name('photos.destroy');
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

        /*
        |--------------------------------------------------------------------------
        | Receipt Management Routes
        |--------------------------------------------------------------------------
        */
        Route::get('/receipts', [SellerController::class, 'receipts'])->name('receipts');
        Route::get('/receipts/create', [SellerController::class, 'createReceipt'])->name('receipts.create');
        Route::post('/receipts', [SellerController::class, 'storeReceipt'])->name('receipts.store');
        Route::get('/receipts/{id}', [SellerController::class, 'showReceipt'])->name('receipts.show');
        Route::delete('/receipts/{id}', [SellerController::class, 'cancelReceipt'])->name('receipts.cancel');
        Route::get('/receipts/{id}/qr', [SellerController::class, 'printReceipt'])->name('receipts.qr');
        Route::get('/receipts/export', [SellerController::class, 'exportReceipts'])->name('receipts.export');
        Route::get('/api/receipt-stats', [SellerController::class, 'getReceiptStats'])->name('api.receipt-stats');
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
| Development/Testing Routes (Local Environment Only)
|--------------------------------------------------------------------------
*/
// if (app()->environment('local')) {
//     Route::prefix('test')->name('test.')->group(function () {
//         // Quick login as first seller for testing
//         Route::get('/login', function () {
//             $seller = \App\Models\Seller::first();
//             if ($seller) {
//                 Auth::guard('seller')->login($seller);
//                 return redirect()->route('dashboard')->with('success', 'Test login successful!');
//             }
//             return redirect()->route('login')->with('error', 'No seller found for testing. Please register first.');
//         })->name('login');

//         // Quick access to main features
//         Route::get('/dashboard', function () {
//             $seller = \App\Models\Seller::first();
//             if ($seller) {
//                 Auth::guard('seller')->login($seller);
//                 return redirect()->route('dashboard');
//             }
//             return redirect()->route('login');
//         })->name('dashboard');

//         Route::get('/receipts', function () {
//             $seller = \App\Models\Seller::first();
//             if ($seller) {
//                 Auth::guard('seller')->login($seller);
//                 return redirect()->route('seller.receipts');
//             }
//             return redirect()->route('login');
//         })->name('receipts');

//         Route::get('/scanner', function () {
//             $seller = \App\Models\Seller::first();
//             if ($seller) {
//                 Auth::guard('seller')->login($seller);
//                 return redirect()->route('seller.scanner');
//             }
//             return redirect()->route('login');
//         })->name('scanner');

//         // Database info route
//         Route::get('/db-info', function () {
//             $tables = [
//                 'sellers' => \App\Models\Seller::count(),
//                 'consumers' => DB::table('consumers')->count(),
//                 'items' => DB::table('items')->count(),
//                 'pending_transactions' => DB::table('pending_transactions')->count(),
//                 'point_transactions' => DB::table('point_transactions')->count(),
//                 'ranks' => DB::table('ranks')->count(),
//             ];

//             return response()->json([
//                 'message' => 'Database Status',
//                 'tables' => $tables,
//                 'environment' => app()->environment(),
//                 'timestamp' => now(),
//             ]);
//         })->name('db-info');
//     });
// }

/*
|--------------------------------------------------------------------------
| Fallback Route
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    return redirect()->route('login')->with('error', 'Page not found. Please log in to access the application.');
});
