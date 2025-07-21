<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Seller;
use App\Models\Rank;
use App\Models\PointTransaction;

class SellerDashboardController extends Controller
{
    public function dashboard()
    {
        // Try to get authenticated seller, otherwise get first seller for testing
        $seller = Auth::guard('seller')->user() ?? Seller::first();
        
        if (!$seller) {
            return redirect()->back()->with('error', 'No seller found. Please create a seller first.');
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

        // Top items scanned - handle case where tables might not have data
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
            // If tables don't exist or have no data, use empty collection
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
    }

    // API method for AJAX updates (optional)
    public function getDashboardData(Request $request)
    {
        $seller = Auth::guard('seller')->user() ?? Seller::first();
        
        if (!$seller) {
            return response()->json(['error' => 'No seller found'], 404);
        }

        // Refresh the seller model to get latest data
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
}