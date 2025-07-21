<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Seller;
use App\Models\PointTransaction;

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

        // Paginate results
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
     * Download transaction receipt as PDF (placeholder for future implementation)
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

        $callback = function() use ($transactions) {
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