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
            
            // Try to decode JSON QR data first
            $decodedData = json_decode($qrData, true);
            
            if ($decodedData && isset($decodedData['consumer_id'])) {
                // Structured QR code with consumer info
                $consumerId = $decodedData['consumer_id'];
            } else {
                // Simple QR code - look up in qr_codes table
                $qrCodeRecord = DB::table('qr_codes')
                    ->where('code', $qrData)
                    ->where('type', 'consumer_profile')
                    ->where('active', true)
                    ->where(function($query) {
                        $query->whereNull('expires_at')
                              ->orWhere('expires_at', '>', now());
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
                
                // Create transaction record using your exact table structure
                DB::table('point_transactions')->insert([
                    'consumer_id' => $consumerId,
                    'seller_id' => $seller->id,
                    'qr_code_id' => $qrCodeId,
                    'units_scanned' => $quantity, // Using existing field for quantity
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
            
            // NOTE: The trigger in your point_transactions table will automatically update seller's total_points
            // But if you want to ensure it's updated correctly with total units:
            // DB::table('sellers')
            //     ->where('id', $seller->id)
            //     ->increment('total_points', $totalUnitsScanned);
            
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
                'seller_points_gained' => $totalPointsAwarded, // Based on your trigger logic
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
     * Award points for redemption (future implementation)
     * When a consumer redeems points at a seller, the seller gains additional points
     */
    public function processRedemption(Request $request)
    {
        $request->validate([
            'consumer_id' => 'required|integer|exists:consumers,id',
            'redemption_points' => 'required|integer|min:1',
            'description' => 'required|string|max:255'
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
            $redemptionPoints = $request->input('redemption_points');
            $description = $request->input('description');
            
            // Check consumer has enough points
            $consumerTotalPoints = DB::table('point_transactions')
                ->where('consumer_id', $consumerId)
                ->sum(DB::raw('CASE WHEN type = "earn" THEN points ELSE -points END'));
                
            if ($consumerTotalPoints < $redemptionPoints) {
                throw new \Exception('Consumer does not have enough points');
            }
            
            // Create redemption transaction (consumer spends points)
            DB::table('point_transactions')->insert([
                'consumer_id' => $consumerId,
                'seller_id' => $seller->id,
                'qr_code_id' => 1, // Default for redemptions
                'units_scanned' => 1,
                'points' => $redemptionPoints,
                'type' => 'spend',
                'description' => $description,
                'scanned_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            // Award seller bonus points for redemption (e.g., 10% of redemption value)
            $sellerBonusPoints = ceil($redemptionPoints * 0.1);
            DB::table('sellers')
                ->where('id', $seller->id)
                ->increment('total_points', $sellerBonusPoints);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Redemption processed successfully!',
                'consumer_points_spent' => $redemptionPoints,
                'seller_bonus_points' => $sellerBonusPoints,
                'consumer_remaining_points' => $consumerTotalPoints - $redemptionPoints
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}