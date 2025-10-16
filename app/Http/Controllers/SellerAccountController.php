<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Seller;
use App\Models\PointTransaction;
use App\Models\RedeemHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SellerAccountController extends Controller
{
    /**
     * Display the seller's account page
     */
    public function index(Request $request)
    {
        // Get authenticated seller
        $seller = Auth::guard('seller')->user();
        
        if (!$seller) {
            return redirect()->route('login')->with('error', 'Please log in to access your account.');
        }

        // Refresh seller to get latest data
        $seller->refresh();

        // Get seller's rank information
        $currentRank = $seller->getCurrentRank();
        $nextRank = $seller->getNextRank();
        $totalRankPoints = $seller->total_points;
        $pointsToNext = $nextRank ? $nextRank->min_points - $totalRankPoints : 0;

        // Get points statistics - specify table name
        $pointsGiven = PointTransaction::where('point_transactions.seller_id', $seller->id)
                                     ->where('point_transactions.type', 'earn')
                                     ->sum('point_transactions.points') ?? 0;

        // Points from redemptions - only count approved redemptions
        // Join redeem_histories with rewards to calculate total points from approved redemptions
        $pointsFromRedemptions = RedeemHistory::join('rewards', 'redeem_histories.reward_id', '=', 'rewards.id')
                                               ->where('rewards.seller_id', $seller->id)
                                               ->where('redeem_histories.status', 'approved')
                                               ->sum(DB::raw('rewards.points_required * COALESCE(redeem_histories.quantity, 1)')) ?? 0;

        $totalCustomers = PointTransaction::where('point_transactions.seller_id', $seller->id)
                                        ->distinct('point_transactions.consumer_id')
                                        ->count('point_transactions.consumer_id') ?? 0;

        // Get transaction history with pagination and better joins
        $query = PointTransaction::where('point_transactions.seller_id', $seller->id)
            ->leftJoin('consumers', 'point_transactions.consumer_id', '=', 'consumers.id')
            ->leftJoin('qr_codes', 'point_transactions.qr_code_id', '=', 'qr_codes.id')
            ->leftJoin('items', 'qr_codes.item_id', '=', 'items.id')
            ->select([
                'point_transactions.*',
                'consumers.full_name as consumer_name',
                'consumers.email as consumer_email',
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

        // Paginate results
        $transactions = $query->paginate(20);

        // Debug: Log some transaction info to help identify the issue
        if ($transactions->count() > 0) {
            $firstTransaction = $transactions->first();
            Log::info('Transaction Debug Info:', [
                'transaction_id' => $firstTransaction->id,
                'receipt_code' => $firstTransaction->receipt_code,
                'item_name' => $firstTransaction->item_name,
                'units_scanned' => $firstTransaction->units_scanned,
                'points_per_unit' => $firstTransaction->points_per_unit,
                'description' => $firstTransaction->description,
                'transaction_type' => $firstTransaction->receipt_code ? 'RECEIPT_BASED' : 'LEGACY/DIRECT',
                'all_attributes' => $firstTransaction->getAttributes() // This will show all fields
            ]);
        }

        // Add additional item lookup for transactions without proper item data
        $transactions->getCollection()->transform(function ($transaction) {
            // For receipt-based transactions, try to extract item info from description
            if (!$transaction->item_name && $transaction->receipt_code && $transaction->description) {
                if (preg_match('/Purchased:\s*([^f]+?)\s+from/i', $transaction->description, $matches)) {
                    $transaction->extracted_items = trim($matches[1]);
                }
            }
            
            // For legacy transactions (no receipt_code, but has descriptive description)
            if (!$transaction->item_name && !$transaction->receipt_code && $transaction->description) {
                if (preg_match('/Purchased:\s*([^f]+?)\s+from/i', $transaction->description, $matches)) {
                    $transaction->extracted_items = trim($matches[1]);
                    $transaction->is_legacy = true;
                }
            }
            
            // Ensure units_scanned has a default value
            if (!$transaction->units_scanned) {
                $transaction->units_scanned = 1;
            }
            
            // Calculate points_per_unit if missing
            if (!$transaction->points_per_unit && $transaction->points && $transaction->units_scanned) {
                $transaction->points_per_unit = round($transaction->points / $transaction->units_scanned, 2);
            }
            
            return $transaction;
        });

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
                'items.points_per_unit'
            ])
            ->first();

        if (!$transaction) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        // Additional processing for legacy transactions
        if (!$transaction->item_name && $transaction->description) {
            if (preg_match('/Purchased:\s*([^f]+?)\s+from/i', $transaction->description, $matches)) {
                $transaction->extracted_items = trim($matches[1]);
            }
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
                'point_transactions.description',
                'point_transactions.scanned_at',
                'point_transactions.created_at',
                'point_transactions.receipt_code'
            ])
            ->orderBy('point_transactions.scanned_at', 'desc');

        // Apply date range filter if provided
        if ($request->has('start_date')) {
            $query->whereDate('point_transactions.scanned_at', '>=', $request->start_date);
        }
        if ($request->has('end_date')) {
            $query->whereDate('point_transactions.scanned_at', '<=', $request->end_date);
        }

        // Apply type filter if provided
        if ($request->has('filter') && in_array($request->filter, ['earn', 'spend'])) {
            $query->where('point_transactions.type', $request->filter);
        }

        $transactions = $query->get();

        // Post-process transactions to fill missing item data
        $transactions = $transactions->map(function ($transaction) {
            if (!$transaction->item_name && $transaction->qr_code_id) {
                $itemInfo = DB::table('qr_codes')
                    ->leftJoin('items', 'qr_codes.item_id', '=', 'items.id')
                    ->where('qr_codes.id', $transaction->qr_code_id)
                    ->select('items.name as item_name')
                    ->first();
                
                if ($itemInfo && $itemInfo->item_name) {
                    $transaction->item_name = $itemInfo->item_name;
                }
            }
            
            return $transaction;
        });

        // Generate CSV
        $filename = 'greencup_transactions_' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($transactions) {
            $file = fopen('php://output', 'w');
            
            // Header row
            fputcsv($file, [
                'Transaction ID',
                'Date & Time',
                'Type',
                'Customer',
                'Item',
                'Quantity',
                'Points',
                'Impact',
                'Description',
                'Receipt Code'
            ]);

            // Data rows
            foreach ($transactions as $transaction) {
                $itemName = $transaction->item_name;
                if (!$itemName) {
                    // Try to extract from description for receipt-based transactions
                    if ($transaction->description && preg_match('/Purchased:\s*([^f]+?)\s+from/i', $transaction->description, $matches)) {
                        $itemName = trim($matches[1]);
                    } elseif ($transaction->receipt_code) {
                        $itemName = 'Receipt #' . $transaction->receipt_code;
                    } else {
                        $itemName = 'Direct Transaction';
                    }
                }

                fputcsv($file, [
                    $transaction->id,
                    $transaction->scanned_at ?? $transaction->created_at,
                    $transaction->type === 'earn' ? 'Points Given' : 'Redemption',
                    $transaction->consumer_name ?? 'Customer #' . $transaction->consumer_id,
                    $itemName,
                    $transaction->units_scanned ?? 1,
                    $transaction->points,
                    $transaction->type === 'earn' ? '-' . $transaction->points : '+' . $transaction->points,
                    $transaction->description ?? '',
                    $transaction->receipt_code ?? 'N/A'
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

        // For now, redirect to account page
        // Later you can create a dedicated profile editing view
        return redirect()->route('seller.account');
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

        // For now, just redirect with a message
        // Later you can implement the actual update logic
        return redirect()->route('seller.account')
            ->with('info', 'Profile editing feature coming soon!');
    }
}