<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ConsumerController extends Controller
{
    /**
     * Display a listing of consumers who have interacted with this seller
     */
    public function index(Request $request)
    {
        try {
            $seller_id = Auth::id();
            $search = $request->get('search', '');
            $sortBy = $request->get('sort_by', 'earned');
            $sortOrder = $request->get('sort_order', 'desc');

            // Get consumers who have claimed receipts from this seller
            $query = DB::table('pending_transactions as pt')
                ->join('consumers as c', 'pt.claimed_by_consumer_id', '=', 'c.id')
                ->where('pt.seller_id', $seller_id)
                ->where('pt.status', 'claimed')
                ->select([
                    'c.id',
                    'c.full_name',
                    'c.email',
                    'c.phone_number',
                    DB::raw('COUNT(DISTINCT pt.id) as total_transactions'),
                    DB::raw('SUM(pt.total_points) as total_points_earned'),
                    DB::raw('SUM(pt.total_quantity) as total_items_purchased'),
                    DB::raw('MAX(pt.claimed_at) as last_transaction_at'),
                    DB::raw('MIN(pt.claimed_at) as first_transaction_at')
                ])
                ->groupBy('c.id', 'c.full_name', 'c.email', 'c.phone_number');

            // Apply search filter
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('c.full_name', 'LIKE', '%' . $search . '%')
                      ->orWhere('c.email', 'LIKE', '%' . $search . '%')
                      ->orWhere('c.phone_number', 'LIKE', '%' . $search . '%');
                });
            }

            // Apply sorting
            $validSortColumns = ['earned' => 'total_points_earned', 'transactions' => 'total_transactions', 'recent' => 'last_transaction_at', 'name' => 'c.full_name'];
            $sortColumn = $validSortColumns[$sortBy] ?? 'total_points_earned';
            $query->orderBy($sortColumn, $sortOrder);

            $consumers = $query->paginate(20);

            // Get statistics
            $stats = DB::table('pending_transactions')
                ->where('seller_id', $seller_id)
                ->where('status', 'claimed')
                ->selectRaw("
                    COUNT(DISTINCT claimed_by_consumer_id) as total_consumers,
                    SUM(total_points) as total_points_given,
                    COUNT(*) as total_receipts_claimed,
                    SUM(total_quantity) as total_items_sold
                ")
                ->first();

            return view('consumers.index', compact('consumers', 'stats', 'search', 'sortBy', 'sortOrder'));
        } catch (\Exception $e) {
            Log::error('Consumer list error: ' . $e->getMessage());
            return redirect()->route('seller.dashboard')->with('error', 'Unable to load consumers list.');
        }
    }
}
