<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SellerQRController extends Controller
{
    /**
     * Show the QR scanner interface
     */
    public function index()
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
        
        // 🔍 DEBUG: Log what we received
        \Log::info('=== QR CODE DEBUG START ===', [
            'original_qr_data' => $qrData,
            'seller_id' => $seller->id,
            'qr_length' => strlen($qrData),
            'contains_http' => str_contains($qrData, 'http'),
            'contains_award_points' => str_contains($qrData, 'award-points'),
            'matches_gc_pattern' => preg_match('/GC_\d+_[A-F0-9]+/i', $qrData)
        ]);

        // 🔍 DEBUG: Show sample QR codes in database
        $sampleQRs = DB::table('qr_codes')
            ->where('type', 'consumer_profile')
            ->where('active', true)
            ->take(5)
            ->get(['id', 'consumer_id', 'code']);
            
        \Log::info('Sample QR codes in database:', [
            'total_consumer_qrs' => DB::table('qr_codes')->where('type', 'consumer_profile')->where('active', true)->count(),
            'samples' => $sampleQRs->toArray()
        ]);
        
        // Store the original QR data for searching
        $originalQrData = $qrData;
        $extractedToken = null;
        
        // Handle URL-based QR codes (extract the token from URL)
        if (str_contains($qrData, 'award-points/')) {
            // Extract token from URL like: http://127.0.0.1:8000/award-points/GC_2_6F649B7D
            $parts = explode('award-points/', $qrData);
            if (count($parts) > 1) {
                $extractedToken = trim($parts[1]);
            }
        } else if (preg_match('/GC_\d+_[A-F0-9]+/i', $qrData, $matches)) {
            // Direct token like: GC_1_22F8F1F4
            $extractedToken = $matches[0];
        }
        
        \Log::info('QR Token Extraction Result:', [
            'original' => $originalQrData,
            'extracted_token' => $extractedToken
        ]);
        
        // Try to decode JSON QR data first
        $decodedData = json_decode($qrData, true);
        
        if ($decodedData && isset($decodedData['consumer_id'])) {
            // Structured QR code with consumer info
            $consumerId = $decodedData['consumer_id'];
            \Log::info('Found consumer ID from JSON QR data:', ['consumer_id' => $consumerId]);
        } else {
            // Simple QR code - look up in qr_codes table
            // Build comprehensive search query
            $qrCodeQuery = DB::table('qr_codes')
                ->where('type', 'consumer_profile')
                ->where('active', true)
                ->where(function($query) {
                    $query->whereNull('expires_at')
                          ->orWhere('expires_at', '>', now());
                });
            
            // Search by multiple strategies
            $qrCodeRecord = $qrCodeQuery->where(function($query) use ($originalQrData, $extractedToken) {
                // Strategy 1: Exact match with original data
                $query->where('code', $originalQrData);
                
                // Strategy 2: If we extracted a token, search for it
                if ($extractedToken) {
                    $query->orWhere('code', $extractedToken)
                          ->orWhere('code', 'LIKE', '%' . $extractedToken . '%');
                }
                
                // Strategy 3: If original data looks like a token, try building URL
                if (preg_match('/^GC_\d+_[A-F0-9]+$/i', $originalQrData)) {
                    $possibleUrl = 'http://127.0.0.1:8000/award-points/' . $originalQrData;
                    $query->orWhere('code', $possibleUrl);
                }
                
                // Strategy 4: Try alternative URL formats
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
            
            \Log::info('QR Code Search Result:', [
                'found' => $qrCodeRecord ? 'YES' : 'NO',
                'qr_record_id' => $qrCodeRecord ? $qrCodeRecord->id : null,
                'qr_code_value' => $qrCodeRecord ? $qrCodeRecord->code : null,
                'consumer_id' => $qrCodeRecord ? $qrCodeRecord->consumer_id : null
            ]);
            
            if (!$qrCodeRecord) {
                // 🔍 DEBUG: Log all available QR codes for comparison
                $allQRs = DB::table('qr_codes')
                    ->where('type', 'consumer_profile')
                    ->where('active', true)
                    ->get(['id', 'consumer_id', 'code']);
                    
                \Log::error('QR Code NOT FOUND - Available QR codes:', [
                    'searched_for' => $originalQrData,
                    'extracted_token' => $extractedToken,
                    'all_qr_codes' => $allQRs->toArray()
                ]);
                
                throw new \Exception('Invalid consumer QR code. Searched for: ' . $originalQrData . ($extractedToken ? ' (token: ' . $extractedToken . ')' : '') . '. Total QR codes in DB: ' . count($allQRs));
            }
            
            $consumerId = $qrCodeRecord->consumer_id;
        }
        
        // Get consumer details
        $consumer = DB::table('consumers')
            ->where('id', $consumerId)
            ->first();
            
        if (!$consumer) {
            \Log::error('Consumer not found:', ['consumer_id' => $consumerId]);
            throw new \Exception('Consumer not found for ID: ' . $consumerId);
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
        
        \Log::info('QR Processing SUCCESS:', [
            'consumer_id' => $consumer->id,
            'consumer_name' => $consumer->full_name,
            'total_points' => $totalPoints,
            'transactions_count' => $transactionsCount
        ]);
        
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
        
        \Log::error('QR Processing FAILED:', [
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
            
            // Get consumer's new total points
            $consumerTotalPoints = DB::table('point_transactions')
                ->where('consumer_id', $consumerId)
                ->sum(DB::raw('CASE WHEN type = "earn" THEN points ELSE -points END'));
            
            // Get seller's updated total points
            $seller = DB::table('sellers')->where('id', $seller->id)->first();
            
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
}