<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use App\Models\SellerPhoto;
use App\Models\PointTransaction;
use App\Models\Rank;
use App\Repository\FileRepository;
use App\Repository\SellerRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Exception;


class SellerController extends Controller
{
    private SellerRepository $sRepo;
    private FileRepository $fRepo;

    public function __construct(SellerRepository $sRepo, FileRepository $fRepo)
    {
        $this->sRepo = $sRepo;
        $this->fRepo = $fRepo;
    }

    /**
     * ========================================
     * DASHBOARD METHODS
     * ========================================
     */

    /**
     * Display the seller dashboard
     */
    public function dashboard()
    {
        try {
            $seller = Auth::guard('seller')->user();

            if (!$seller) {
                Log::warning('Dashboard access attempt without authentication');
                return redirect()->route('login')->with('error', 'Please log in to access the dashboard.');
            }

            // Check if seller account is active
            if (!$seller->is_active) {
                Log::warning('Inactive seller attempted dashboard access: ' . $seller->id);
                Auth::guard('seller')->logout();
                return redirect()->route('login')->with('error', 'Your account has been deactivated. Please contact support.');
            }

            // Get seller's current rank points
            $totalRankPoints = $seller->total_points;

            // Get current rank and next rank
            $currentRank = $seller->getCurrentRank();
            $nextRank = $seller->getNextRank();
            $pointsToNext = $nextRank ? $nextRank->min_points - $totalRankPoints : 0;

            // Get points given to customers (all 'earn' transactions by this seller)
            $pointsGiven = PointTransaction::where('seller_id', $seller->id)
                ->where('type', 'earn')
                ->sum('points') ?? 0;

            // Get points earned from redemptions (all 'spend' transactions by this seller)
            $pointsFromRedemptions = PointTransaction::where('seller_id', $seller->id)
                ->where('type', 'spend')
                ->sum('points') ?? 0;

            // Total customers served
            $totalCustomers = PointTransaction::where('seller_id', $seller->id)
                ->distinct('consumer_id')
                ->count('consumer_id') ?? 0;

            // Total transactions
            $totalTransactions = PointTransaction::where('seller_id', $seller->id)->count() ?? 0;

            // Calculate breakdown percentages
            $totalActivity = $pointsGiven + $pointsFromRedemptions;
            $givingPercentage = $totalActivity > 0 ? ($pointsGiven / $totalActivity) * 100 : 0;
            $redemptionPercentage = $totalActivity > 0 ? ($pointsFromRedemptions / $totalActivity) * 100 : 0;

            // Top items scanned
            $topItems = collect();
            try {
                $topItems = DB::table('point_transactions')
                    ->join('qr_codes', 'point_transactions.qr_code_id', '=', 'qr_codes.id')
                    ->join('items', 'qr_codes.item_id', '=', 'items.id')
                    ->where('point_transactions.seller_id', $seller->id)
                    ->select(
                        'items.name',
                        DB::raw('SUM(point_transactions.units_scanned) as total_units'),
                        DB::raw('SUM(point_transactions.points) as total_points'),
                        DB::raw('COUNT(point_transactions.id) as scan_count')
                    )
                    ->groupBy('items.id', 'items.name')
                    ->orderBy('total_points', 'desc')
                    ->limit(5)
                    ->get();
            } catch (\Exception $e) {
                $topItems = collect();
            }

            return view('sellers.dashboard', compact(
                'seller',
                'totalRankPoints',
                'currentRank',
                'nextRank',
                'pointsToNext',
                'pointsGiven',
                'pointsFromRedemptions',
                'totalCustomers',
                'totalTransactions',
                'totalActivity',
                'givingPercentage',
                'redemptionPercentage',
                'topItems'
            ));
        } catch (Exception $e) {
            Log::error('Dashboard error for seller ' . (Auth::guard('seller')->id() ?? 'unknown') . ': ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Unable to load dashboard. Please try logging in again.');
        }
    }

    /**
     * API method for AJAX dashboard updates
     */
    public function getDashboardData(Request $request)
    {
        $seller = Auth::guard('seller')->user();

        if (!$seller) {
            return response()->json(['error' => 'No seller found'], 404);
        }

        $seller->refresh();

        return response()->json([
            'total_rank_points' => $seller->total_points,
            'points_given' => PointTransaction::where('seller_id', $seller->id)
                ->where('type', 'earn')
                ->sum('points') ?? 0,
            'points_from_redemptions' => PointTransaction::where('seller_id', $seller->id)
                ->where('type', 'spend')
                ->sum('points') ?? 0,
            'total_customers' => PointTransaction::where('seller_id', $seller->id)
                ->distinct('consumer_id')
                ->count('consumer_id') ?? 0,
            'total_transactions' => PointTransaction::where('seller_id', $seller->id)->count() ?? 0,
            'current_rank' => $seller->getCurrentRank()?->name ?? 'Standard',
            'next_rank' => $seller->getNextRank()?->name ?? 'Max Rank',
        ]);
    }

    /**
     * ========================================
     * ACCOUNT & PROFILE METHODS
     * ========================================
     */

    /**
     * Display the seller's account page
     */
    public function account(Request $request)
    {
        $seller = Auth::guard('seller')->user();

        // Get seller's rank information
        $currentRank = $seller->getCurrentRank();
        $nextRank = $seller->getNextRank();
        $totalRankPoints = $seller->total_points;
        $pointsToNext = $nextRank ? $nextRank->min_points - $totalRankPoints : 0;

        // Get points statistics
        $pointsGiven = PointTransaction::where('point_transactions.seller_id', $seller->id)
            ->where('point_transactions.type', 'earn')
            ->sum('point_transactions.points') ?? 0;

        $pointsFromRedemptions = PointTransaction::where('point_transactions.seller_id', $seller->id)
            ->where('point_transactions.type', 'spend')
            ->sum('point_transactions.points') ?? 0;

        $totalCustomers = PointTransaction::where('point_transactions.seller_id', $seller->id)
            ->distinct('point_transactions.consumer_id')
            ->count('point_transactions.consumer_id') ?? 0;

        // Get transaction history with pagination
        $query = PointTransaction::where('point_transactions.seller_id', $seller->id)
            ->leftJoin('consumers', 'point_transactions.consumer_id', '=', 'consumers.id')
            ->leftJoin('qr_codes', 'point_transactions.qr_code_id', '=', 'qr_codes.id')
            ->leftJoin('items', 'qr_codes.item_id', '=', 'items.id')
            ->select([
                'point_transactions.*',
                'consumers.full_name as consumer_name',
                'items.name as item_name',
                'items.points_per_unit'
            ])
            ->orderBy('point_transactions.scanned_at', 'desc')
            ->orderBy('point_transactions.created_at', 'desc');

        // Apply filter if requested
        $filter = $request->get('filter', 'all');
        if ($filter === 'earn' || $filter === 'spend') {
            $query->where('point_transactions.type', $filter);
        }

        $transactions = $query->paginate(20);

        return view('sellers.account', compact(
            'seller',
            'currentRank',
            'nextRank',
            'totalRankPoints',
            'pointsToNext',
            'pointsGiven',
            'pointsFromRedemptions',
            'totalCustomers',
            'transactions',
            'filter'
        ));
    }

    /**
     * Get transaction details via AJAX
     */
    public function getTransactionDetail($id)
    {
        $seller = Auth::guard('seller')->user();

        if (!$seller) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $transaction = PointTransaction::where('point_transactions.seller_id', $seller->id)
            ->where('point_transactions.id', $id)
            ->leftJoin('consumers', 'point_transactions.consumer_id', '=', 'consumers.id')
            ->leftJoin('qr_codes', 'point_transactions.qr_code_id', '=', 'qr_codes.id')
            ->leftJoin('items', 'qr_codes.item_id', '=', 'items.id')
            ->select([
                'point_transactions.*',
                'consumers.full_name as consumer_name',
                'consumers.email as consumer_email',
                'items.name as item_name',
                'items.points_per_unit',
                'qr_codes.code as qr_code'
            ])
            ->first();

        if (!$transaction) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        return response()->json($transaction);
    }

    /**
     * Export transactions to CSV
     */
    public function exportTransactions(Request $request)
    {
        $seller = Auth::guard('seller')->user();

        if (!$seller) {
            return redirect()->route('login');
        }

        $query = PointTransaction::where('point_transactions.seller_id', $seller->id)
            ->leftJoin('consumers', 'point_transactions.consumer_id', '=', 'consumers.id')
            ->leftJoin('qr_codes', 'point_transactions.qr_code_id', '=', 'qr_codes.id')
            ->leftJoin('items', 'qr_codes.item_id', '=', 'items.id')
            ->select([
                'point_transactions.id',
                'point_transactions.type',
                'consumers.full_name as consumer_name',
                'items.name as item_name',
                'point_transactions.units_scanned',
                'point_transactions.points',
                'point_transactions.scanned_at',
                'point_transactions.created_at'
            ])
            ->orderBy('point_transactions.scanned_at', 'desc');

        // Apply date range filter if provided
        if ($request->has('start_date')) {
            $query->whereDate('point_transactions.scanned_at', '>=', $request->start_date);
        }
        if ($request->has('end_date')) {
            $query->whereDate('point_transactions.scanned_at', '<=', $request->end_date);
        }

        $transactions = $query->get();

        // Generate CSV
        $filename = 'greencup_transactions_' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($transactions) {
            $file = fopen('php://output', 'w');

            // Header row
            fputcsv($file, [
                'Transaction ID',
                'Date & Time',
                'Type',
                'Customer',
                'Item',
                'Units',
                'Points',
                'Impact'
            ]);

            // Data rows
            foreach ($transactions as $transaction) {
                fputcsv($file, [
                    $transaction->id,
                    $transaction->scanned_at ?? $transaction->created_at,
                    $transaction->type === 'earn' ? 'Points Given' : 'Redemption',
                    $transaction->consumer_name,
                    $transaction->item_name ?? 'Unknown',
                    $transaction->units_scanned,
                    $transaction->points,
                    $transaction->type === 'earn' ? '-' . $transaction->points : '+' . $transaction->points
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Show the profile editing form
     */
    public function profile()
    {
        $seller = Auth::guard('seller')->user();

        if (!$seller) {
            return redirect()->route('login')->with('error', 'Please log in to access your profile.');
        }

        return redirect()->route('seller.account');
    }

    public function updateProfilePhoto(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB = 5120KB
        ], [
            'image.max' => 'The image size must not exceed 5MB.',
            'image.image' => 'The uploaded file must be a valid image.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif.',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $response = $this->fRepo->upload("profiles", $file);
            if ($response->successful()) {
                $data = $response->json();

                $this->sRepo->update(Auth::id(), [
                    'photo_url'  => $this->fRepo->get($data['path'] ?? null),
                ]);
            }
        }
        return redirect()->back()->with('success', 'Photo uploaded successfully! 📷');
    }
    /**
     * Update the seller's profile
     */
    public function updateProfile(Request $request)
    {
        $seller = Auth::guard('seller')->user();

        if (!$seller) {
            return redirect()->route('login')->with('error', 'Please log in to update your profile.');
        }

        // Validate the input
        $validated = $request->validate([
            'business_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:sellers,email,' . $seller->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        try {
            // Update the seller's profile
            $seller->update($validated);

            return redirect()->route('seller.account')
                ->with('success', 'Profile updated successfully!');
        } catch (Exception $e) {
            Log::error('Profile update error: ' . $e->getMessage());
            return redirect()->route('seller.account')
                ->with('error', 'Failed to update profile. Please try again.');
        }
    }

    /**
     * ========================================
     * PHOTO GALLERY METHODS
     * ========================================
     */

    /**
     * Display the photo gallery management page
     */
    public function photos()
    {
        try {
            $seller = Auth::guard('seller')->user();

            if (!$seller) {
                return redirect()->route('login')->with('error', 'Please log in to access photos.');
            }

            $photos = $seller->photos()
                ->orderByDesc('is_featured')
                ->orderBy('sort_order')
                ->orderByDesc('created_at')
                ->get();

            // FIXED: Group photos in controller instead of blade template
            $groupedPhotos = collect();
            $processedIds = collect();

            foreach ($photos as $photo) {
                if ($processedIds->contains($photo->id)) {
                    continue;
                }

                // Find all photos uploaded within 10 seconds of each other
                $sessionPhotos = $photos->filter(function ($p) use ($photo, $processedIds) {
                    return !$processedIds->contains($p->id) &&
                        abs($photo->created_at->diffInSeconds($p->created_at)) <= 10;
                });

                $groupedPhotos->push($sessionPhotos);
                $processedIds = $processedIds->merge($sessionPhotos->pluck('id'));
            }

            return view('sellers.photo', compact('seller', 'photos', 'groupedPhotos'));
        } catch (\Exception $e) {
            Log::error('Error loading photo gallery: ' . $e->getMessage());
            return redirect()->route('dashboard')->with('error', 'Unable to load photo gallery.');
        }
    }

    /**
     * Store a newly uploaded photo
     */
    public function storePhoto(Request $request)
    {
        try {
            $request->validate([
                'photo' => 'required|image|max:5120',
                'caption' => 'nullable|string|max:255',
                'category' => 'nullable|in:store,products,ambiance',
                'is_featured' => 'nullable|boolean'
            ], [
                'photo.required' => 'Please select a photo to upload.',
                'photo.image' => 'The file must be an image.',
                'photo.max' => 'The photo may not be greater than 5MB.',
                'caption.max' => 'Caption must not exceed 255 characters.',
                'category.in' => 'Please select a valid category.'
            ]);

            $seller = Auth::guard('seller')->user();

            if (!$seller) {
                return redirect()->route('login')->with('error', 'Please log in to upload photos.');
            }

            $file = $request->file('photo');
            $path = $file->store('seller_photos', 'public');
            $photoUrl = '/storage/' . $path;

            // If marking as featured, unset other featured photos
            $isFeatured = $request->filled('is_featured') && $request->is_featured;
            if ($isFeatured) {
                $seller->photos()->update(['is_featured' => false]);
            }

            $photo = $seller->photos()->create([
                'photo_url' => $photoUrl,
                'caption' => $request->caption,
                'category' => $request->category,
                'is_featured' => $isFeatured,
                'sort_order' => $seller->photos()->count()
            ]);

            // Update seller's main photo if this is featured
            if ($photo->is_featured) {
                $seller->update([
                    'photo_url' => $photo->photo_url,
                    'photo_caption' => $photo->caption
                ]);
            }

            // Handle AJAX response
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Photo uploaded successfully!',
                    'photo' => [
                        'id' => $photo->id,
                        'photo_url' => $photo->photo_url,
                        'caption' => $photo->caption,
                        'category' => $photo->category,
                        'is_featured' => $photo->is_featured,
                        'sort_order' => $photo->sort_order,
                        'created_at' => $photo->created_at->format('M j, Y g:i A')
                    ]
                ]);
            }

            return redirect()->route('seller.photos')->with('success', 'Photo uploaded successfully! 📷');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $e->errors()
                ], 422);
            }
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            Log::error('Error uploading photo: ' . $e->getMessage());

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while uploading the photo.'
                ], 500);
            }
            return redirect()->back()->with('error', 'An error occurred while uploading the photo. Please try again.');
        }
    }

    /**
     * Update photo details
     */
    public function updatePhoto(Request $request, $id)
    {
        try {
            $request->validate([
                'caption' => 'nullable|string|max:255',
                'category' => 'nullable|in:store,products,ambiance',
                'is_featured' => 'nullable|boolean'
            ]);

            $seller = Auth::guard('seller')->user();

            if (!$seller) {
                return redirect()->route('login')->with('error', 'Please log in to update photos.');
            }

            $photo = $seller->photos()->findOrFail($id);

            // If marking as featured, unset other featured photos
            if ($request->filled('is_featured') && $request->is_featured) {
                $seller->photos()->where('id', '!=', $id)->update(['is_featured' => false]);
            }

            $photo->update([
                'caption' => $request->caption,
                'category' => $request->category ?? $photo->category,
                'is_featured' => $request->filled('is_featured') ? true : false
            ]);

            // Update seller's main photo if this is now featured
            if ($photo->is_featured) {
                $seller->update([
                    'photo_url' => $photo->photo_url,
                    'photo_caption' => $photo->caption
                ]);
            } elseif (!$seller->photos()->where('is_featured', true)->exists()) {
                // If no featured photo exists, clear seller's main photo
                $seller->update([
                    'photo_url' => null,
                    'photo_caption' => null
                ]);
            }

            return redirect()->route('seller.photos')->with('success', 'Photo updated successfully! ✏️');
        } catch (\Exception $e) {
            Log::error('Error updating photo: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating the photo.');
        }
    }

    /**
     * Delete a photo
     */
    public function destroyPhoto($id)
    {
        try {
            $seller = Auth::guard('seller')->user();

            if (!$seller) {
                return redirect()->route('login')->with('error', 'Please log in to delete photos.');
            }

            $photo = $seller->photos()->findOrFail($id);

            // Delete file from storage
            $photoPath = str_replace('/storage/', '', $photo->photo_url);

            if (Storage::disk('public')->exists($photoPath)) {
                Storage::disk('public')->delete($photoPath);
            }

            // If this was the featured photo, handle updates
            if ($photo->is_featured) {
                $seller->update([
                    'photo_url' => null,
                    'photo_caption' => null
                ]);

                // Set the next most recent photo as featured
                $nextPhoto = $seller->photos()
                    ->where('id', '!=', $id)
                    ->orderByDesc('created_at')
                    ->first();

                if ($nextPhoto) {
                    $nextPhoto->update(['is_featured' => true]);
                    $seller->update([
                        'photo_url' => $nextPhoto->photo_url,
                        'photo_caption' => $nextPhoto->caption
                    ]);
                }
            }

            $photo->delete();

            return redirect()->route('seller.photos')->with('success', 'Photo deleted successfully! 🗑️');
        } catch (\Exception $e) {
            Log::error('Error deleting photo: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while deleting the photo.');
        }
    }

    /**
     * Get photo details for editing (AJAX)
     */
    public function showPhoto($id)
    {
        try {
            $seller = Auth::guard('seller')->user();

            if (!$seller) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
            }

            $photo = $seller->photos()->findOrFail($id);

            return response()->json([
                'success' => true,
                'photo' => [
                    'id' => $photo->id,
                    'photo_url' => $photo->photo_url,
                    'caption' => $photo->caption,
                    'category' => $photo->category,
                    'is_featured' => $photo->is_featured,
                    'sort_order' => $photo->sort_order,
                    'created_at' => $photo->created_at->format('M j, Y g:i A')
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching photo details: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred.'], 500);
        }
    }

    /**
     * Reorder photos (AJAX)
     */
    public function reorderPhotos(Request $request)
    {
        try {
            $request->validate([
                'photo_ids' => 'required|array',
                'photo_ids.*' => 'exists:seller_photos,id'
            ]);

            $seller = Auth::guard('seller')->user();

            if (!$seller) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
            }

            foreach ($request->photo_ids as $index => $photoId) {
                $seller->photos()->where('id', $photoId)->update(['sort_order' => $index]);
            }

            return response()->json(['success' => true, 'message' => 'Photos reordered successfully!']);
        } catch (\Exception $e) {
            Log::error('Error reordering photos: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred.'], 500);
        }
    }

    /**
     * ========================================
     * QR SCANNER METHODS
     * ========================================
     */

    /**
     * Show the QR scanner interface
     */
    public function scanner()
    {
        return view('sellers.scanner');
    }

    /**
     * Process consumer QR code and return consumer details
     */
    public function processConsumer(Request $request)
    {
        $request->validate([
            'qr_data' => 'required|string'
        ]);

        $seller = Auth::guard('seller')->user();

        if (!$seller) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication required'
            ], 401);
        }

        try {
            DB::beginTransaction();

            $qrData = $request->input('qr_data');

            // Store the original QR data for searching
            $originalQrData = $qrData;
            $extractedToken = null;

            // Handle URL-based QR codes (extract the token from URL)
            if (str_contains($qrData, 'award-points/')) {
                $parts = explode('award-points/', $qrData);
                if (count($parts) > 1) {
                    $extractedToken = trim($parts[1]);
                }
            } else if (preg_match('/GC_\d+_[A-F0-9]+/i', $qrData, $matches)) {
                $extractedToken = $matches[0];
            }

            // Try to decode JSON QR data first
            $decodedData = json_decode($qrData, true);

            if ($decodedData && isset($decodedData['consumer_id'])) {
                $consumerId = $decodedData['consumer_id'];
            } else {
                // Simple QR code - look up in qr_codes table
                $qrCodeQuery = DB::table('qr_codes')
                    ->where('type', 'consumer_profile')
                    ->where('active', true)
                    ->where(function ($query) {
                        $query->whereNull('expires_at')
                            ->orWhere('expires_at', '>', now());
                    });

                // Search by multiple strategies
                $qrCodeRecord = $qrCodeQuery->where(function ($query) use ($originalQrData, $extractedToken) {
                    $query->where('code', $originalQrData);

                    if ($extractedToken) {
                        $query->orWhere('code', $extractedToken)
                            ->orWhere('code', 'LIKE', '%' . $extractedToken . '%');
                    }

                    if (preg_match('/^GC_\d+_[A-F0-9]+$/i', $originalQrData)) {
                        $possibleUrl = 'http://127.0.0.1:8000/award-points/' . $originalQrData;
                        $query->orWhere('code', $possibleUrl);
                    }

                    if ($extractedToken) {
                        $altUrls = [
                            'http://localhost:8000/award-points/' . $extractedToken,
                            'https://127.0.0.1:8000/award-points/' . $extractedToken,
                            'https://localhost:8000/award-points/' . $extractedToken
                        ];
                        foreach ($altUrls as $url) {
                            $query->orWhere('code', $url);
                        }
                    }
                })
                    ->first();

                if (!$qrCodeRecord) {
                    throw new \Exception('Invalid consumer QR code');
                }

                $consumerId = $qrCodeRecord->consumer_id;
            }

            // Get consumer details
            $consumer = DB::table('consumers')
                ->where('id', $consumerId)
                ->first();

            if (!$consumer) {
                throw new \Exception('Consumer not found');
            }

            // Get consumer's total points
            $totalPoints = DB::table('point_transactions')
                ->where('consumer_id', $consumerId)
                ->sum(DB::raw('CASE WHEN type = "earn" THEN points ELSE -points END'));

            // Get consumer's transaction count with this seller
            $transactionsCount = DB::table('point_transactions')
                ->where('consumer_id', $consumerId)
                ->where('seller_id', $seller->id)
                ->count();

            // Get available items for awarding points
            $items = DB::table('items')
                ->orderBy('points_per_unit', 'asc')
                ->get();

            DB::commit();

            return response()->json([
                'success' => true,
                'consumer' => [
                    'id' => $consumer->id,
                    'full_name' => $consumer->full_name,
                    'email' => $consumer->email,
                    'phone_number' => $consumer->phone_number,
                    'gender' => $consumer->gender,
                    'total_points' => $totalPoints,
                    'transactions_count' => $transactionsCount,
                    'member_since' => date('M Y', strtotime($consumer->created_at))
                ],
                'items' => $items
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('QR Processing FAILED:', [
                'error' => $e->getMessage(),
                'qr_data' => $qrData ?? 'N/A',
                'seller_id' => $seller->id ?? 'N/A'
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Award points to consumer for multiple items with quantities
     */
    public function awardPoints(Request $request)
    {
        $request->validate([
            'consumer_id' => 'required|integer|exists:consumers,id',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|integer|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1|max:3'
        ]);

        $seller = Auth::guard('seller')->user();

        if (!$seller) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication required'
            ], 401);
        }

        try {
            DB::beginTransaction();

            $consumerId = $request->input('consumer_id');
            $itemsData = $request->input('items');

            // Get consumer
            $consumer = DB::table('consumers')
                ->where('id', $consumerId)
                ->first();

            if (!$consumer) {
                throw new \Exception('Consumer not found');
            }

            // Process each item
            $totalPointsAwarded = 0;
            $totalUnitsScanned = 0;
            $transactionDetails = [];

            foreach ($itemsData as $itemData) {
                $item = DB::table('items')->where('id', $itemData['item_id'])->first();
                if (!$item) continue;

                $quantity = $itemData['quantity'];
                $pointsForItem = $item->points_per_unit * $quantity;

                // Create QR code record for this transaction
                $qrCodeId = DB::table('qr_codes')->insertGetId([
                    'seller_id' => $seller->id,
                    'item_id' => $item->id,
                    'consumer_id' => null,
                    'type' => 'seller_item',
                    'code' => 'SELLER_SCAN_' . uniqid() . '_' . $item->id,
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                // Create transaction record
                DB::table('point_transactions')->insert([
                    'consumer_id' => $consumerId,
                    'seller_id' => $seller->id,
                    'qr_code_id' => $qrCodeId,
                    'units_scanned' => $quantity,
                    'points' => $pointsForItem,
                    'type' => 'earn',
                    'description' => "Scanned {$quantity}x {$item->name} at {$seller->business_name}",
                    'scanned_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                $totalPointsAwarded += $pointsForItem;
                $totalUnitsScanned += $quantity;
                $transactionDetails[] = "{$quantity}x {$item->name}";
            }

            // IMPORTANT: Manually update seller's total_points
            $seller->updateTotalPoints();

            // Update rank if needed
            $seller->updateRank();

            // Get consumer's new total points
            $consumerTotalPoints = DB::table('point_transactions')
                ->where('consumer_id', $consumerId)
                ->sum(DB::raw('CASE WHEN type = "earn" THEN points ELSE -points END'));

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Points awarded successfully!',
                'total_points_awarded' => $totalPointsAwarded,
                'total_quantity' => $totalUnitsScanned,
                'consumer_total_points' => $consumerTotalPoints,
                'seller_points_gained' => $totalPointsAwarded,
                'transaction_details' => implode(', ', $transactionDetails)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Get recent transactions for the seller
     */
    public function recentTransactions()
    {
        $seller = Auth::guard('seller')->user();

        if (!$seller) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication required'
            ], 401);
        }

        $transactions = DB::table('point_transactions as pt')
            ->join('consumers as c', 'pt.consumer_id', '=', 'c.id')
            ->leftJoin('qr_codes as qc', 'pt.qr_code_id', '=', 'qc.id')
            ->leftJoin('items as i', 'qc.item_id', '=', 'i.id')
            ->where('pt.seller_id', $seller->id)
            ->where('pt.type', 'earn')
            ->select(
                'pt.id',
                'pt.points',
                'pt.units_scanned',
                'pt.description',
                'pt.created_at',
                'c.full_name as consumer_name',
                'c.email as consumer_email',
                'i.name as item_name'
            )
            ->orderBy('pt.created_at', 'desc')
            ->limit(20)
            ->get();

        return response()->json([
            'success' => true,
            'transactions' => $transactions
        ]);
    }


    /**
     * Process redemption QR code
     */
    public function processRedemption(Request $request)
    {
        $request->validate([
            'qr_data' => 'required|string',
            'consumer_id' => 'required|integer|exists:consumers,id'
        ]);

        $seller = Auth::guard('seller')->user();

        if (!$seller) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication required'
            ], 401);
        }

        try {
            DB::beginTransaction();

            // TODO: Implement redemption logic
            // For now, return a placeholder response

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Redemption feature coming soon!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * ========================================
     * ADDITIONAL METHODS
     * ========================================
     */

    /**
     * Download transaction receipt as PDF
     */
    public function downloadReceipt($id)
    {
        $seller = Auth::guard('seller')->user();

        if (!$seller) {
            return redirect()->route('login');
        }

        // TODO: Implement PDF generation
        // For now, return a simple response
        return response()->json([
            'message' => 'PDF download feature coming soon!',
            'transaction_id' => $id
        ]);
    }

    /**
     * Get photo gallery statistics (AJAX)
     */
    public function getPhotoStats()
    {
        try {
            $seller = Auth::guard('seller')->user();

            if (!$seller) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
            }

            $stats = [
                'total_photos' => $seller->photos()->count(),
                'by_category' => [
                    'store' => $seller->photos()->where('category', 'store')->count(),
                    'products' => $seller->photos()->where('category', 'products')->count(),
                    'ambiance' => $seller->photos()->where('category', 'ambiance')->count(),
                    'uncategorized' => $seller->photos()->whereNull('category')->count(),
                ],
                'featured_count' => $seller->photos()->where('is_featured', true)->count(),
                'storage_used' => $seller->photos()->sum('file_size') ?? 0,
            ];

            return response()->json([
                'success' => true,
                'stats' => $stats
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching photo stats: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred.'], 500);
        }
    }

    /**
     * Update seller location
     */
    public function updateLocation(Request $request)
    {
        try {
            $request->validate([
                'latitude' => 'required|numeric|between:-90,90',
                'longitude' => 'required|numeric|between:-180,180',
                'address' => 'nullable|string|max:500'
            ]);

            $seller = Auth::guard('seller')->user();

            if (!$seller) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
            }

            $seller->update([
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'address' => $request->address ?? $seller->address
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Location updated successfully!'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error updating location: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred.'], 500);
        }
    }
}
