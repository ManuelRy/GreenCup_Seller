<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use App\Repository\ItemRepository;
use App\Repository\PendingTransactionRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReceiptController extends Controller
{
    private ItemRepository $iRepo;
    private PendingTransactionRepository $pTRepo;

    public function __construct(ItemRepository $iRepo, PendingTransactionRepository $pTRepo)
    {
        $this->iRepo = $iRepo;
        $this->pTRepo = $pTRepo;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        $search = $request->get('search', '');
        $dateFrom = $request->get('date_from', '');
        $dateTo = $request->get('date_to', '');
        $seller_id = Auth::id();
        // TODO: Implement listing features here

        $query = $this->pTRepo->listQuery($seller_id);
        if ($status !== 'all')
            $query->where('status', $status);
        if ($search)
            $query->where('receipt_code', 'LIKE', '%' . $search . '%');
        if ($dateFrom)
            $query->whereDate('created_at', '>=', $dateFrom);
        if ($dateTo)
            $query->whereDate('created_at', '<=', $dateTo);

        $receipts = $query->paginate(20);
        $stats = $this->pTRepo->stats($seller_id);
        // dd($receipts    );
        return view('receipts.index', compact('receipts', 'stats', 'status', 'search', 'dateFrom', 'dateTo'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $seller = Auth::user();
        $items = $this->iRepo->list(Auth::id());
        return view('receipts.create', compact('items', 'seller'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Log incoming request
            Log::info('Receipt store request received', [
                'seller_id' => Auth::id(),
                'request_data' => $request->all(),
                'headers' => [
                    'content-type' => $request->header('Content-Type'),
                    'accept' => $request->header('Accept')
                ]
            ]);

            $request->validate([
                'items' => 'required|array|min:1',
                'items.*.item_id' => 'required|integer|exists:items,id',
                'items.*.quantity' => 'required|integer|min:1',
                'expires_hours' => 'nullable|integer|min:1|max:168' // Max 1 week
            ]);

            $seller_id  = Auth::id();
            $expiresAt = $request->expires_hours ?? 24;
            $items = [];
            $points = 0;
            $qantity = 0;

            foreach ($request->items as $item) {
                $i = $this->iRepo->get($item['item_id'], $seller_id);
                if (!$i) {
                    Log::warning('Item not found or not owned by seller', [
                        'item_id' => $item['item_id'],
                        'seller_id' => $seller_id
                    ]);
                    continue;
                }
                $qty = (int) $item['quantity'];
                $pt = $i->points_per_unit * $qty;

                $items[] = [
                    ...$i->toArray(),
                    'quantity' => $qty,
                    'total_points' => $pt
                ];
                $points += $pt;
                $qantity += $qty;
            }

            if (empty($items)) {
                throw new Exception('No valid items found for receipt');
            }

            $receipt = $this->pTRepo->create([
                'seller_id' => $seller_id,
                'items' => $items,
                'total_points' => $points,
                'total_quantity' => $qantity,
                'expires_at' => Carbon::now()->addHours($expiresAt),
            ]);

            Log::info('Receipt created successfully', ['receipt_id' => $receipt->id]);

            return response()->json([
                'success' => true,
                'message' => 'Receipt created successfully!',
                'receipt' => $receipt->toArray()
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Receipt validation error', [
                'errors' => $e->errors(),
                'seller_id' => Auth::id()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Throwable $e) {
            Log::error('Receipt creation error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'seller_id' => Auth::id()
            ]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $receipt = $this->pTRepo->get($id, Auth::id());
            if (!$receipt)
                return redirect()->route('seller.receipts.index')->with('error', 'Receipt not found.');
            return view('receipts.show', compact('receipt'));
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return redirect()->route('seller.receipts.index')->with('error', 'Something when wrong.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $seller_id = Auth::id();
            $receipt = $this->pTRepo->get($id, $seller_id);
            if (!$receipt) {
                throw new Exception('Receipt not found');
            }

            if ($receipt->status !== 'pending') {
                throw new Exception('Can only cancel pending receipts');
            }

            $this->pTRepo->update($id, $seller_id, [
                'status' => 'expired'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Receipt cancelled successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function print($id)
    {
        try {
            $seller = Auth::user();
            $receipt = $this->pTRepo->get($id, $seller->id);
            if (!$receipt)
                return redirect()->route('seller.receipts.index')->with('error', 'Receipt not found.');

            return view('receipts.qr-print', compact('receipt', 'seller'));
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('seller.receipts.index')->with('error', 'Unable to generate QR code.');
        }
    }

    public function export(Request $request)
    {
        try {
            $query =  $this->pTRepo->listQuery(Auth::id());

            // Apply filters if provided
            if ($request->has('status') && $request->status !== 'all') {
                $query->where('status', $request->status);
            }

            if ($request->has('date_from')) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }

            if ($request->has('date_to')) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }

            $receipts = $query->get();

            // Generate CSV
            $filename = 'receipts_' . date('Y-m-d') . '.csv';

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            $callback = function () use ($receipts) {
                $file = fopen('php://output', 'w');

                // Header row
                fputcsv($file, [
                    'Receipt Code',
                    'Status',
                    'Items Count',
                    'Total Quantity',
                    'Total Points',
                    'Created At',
                    'Expires At',
                    'Claimed At',
                    'Customer Email'
                ]);

                // Data rows
                foreach ($receipts as $receipt) {
                    $items = $receipt->items;
                    $customerEmail = '';

                    if ($receipt->claimed_by_consumer_id) {
                        $consumer = DB::table('consumers')->where('id', $receipt->claimed_by_consumer_id)->first();
                        $customerEmail = $consumer->email ?? '';
                    }

                    fputcsv($file, [
                        $receipt->receipt_code,
                        ucfirst($receipt->status),
                        count($items),
                        $receipt->total_quantity,
                        $receipt->total_points,
                        $receipt->created_at ? $receipt->created_at->timezone('Asia/Phnom_Penh')->format('M d, Y g:i A') : '',
                        $receipt->expires_at ? $receipt->expires_at->timezone('Asia/Phnom_Penh')->format('M d, Y g:i A') : '',
                        $receipt->claimed_at ? $receipt->claimed_at->timezone('Asia/Phnom_Penh')->format('M d, Y g:i A') : '',
                        $customerEmail
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } catch (Exception $e) {
            Log::error('Receipt export error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to export receipts.');
        }
    }
    // public function stats()
    // {
    //     try {
    //         $seller = Auth::guard('seller')->user();

    //         if (!$seller) {
    //             return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
    //         }

    //         $stats = [
    //             'today' => [
    //                 'created' => DB::table('pending_transactions')
    //                     ->where('seller_id', $seller->id)
    //                     ->whereDate('created_at', today())
    //                     ->count(),
    //                 'claimed' => DB::table('pending_transactions')
    //                     ->where('seller_id', $seller->id)
    //                     ->where('status', 'claimed')
    //                     ->whereDate('claimed_at', today())
    //                     ->count(),
    //                 'points_issued' => DB::table('pending_transactions')
    //                     ->where('seller_id', $seller->id)
    //                     ->whereDate('created_at', today())
    //                     ->sum('total_points'),
    //                 'points_claimed' => DB::table('pending_transactions')
    //                     ->where('seller_id', $seller->id)
    //                     ->where('status', 'claimed')
    //                     ->whereDate('claimed_at', today())
    //                     ->sum('total_points')
    //             ],
    //             'week' => [
    //                 'created' => DB::table('pending_transactions')
    //                     ->where('seller_id', $seller->id)
    //                     ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
    //                     ->count(),
    //                 'claimed' => DB::table('pending_transactions')
    //                     ->where('seller_id', $seller->id)
    //                     ->where('status', 'claimed')
    //                     ->whereBetween('claimed_at', [now()->startOfWeek(), now()->endOfWeek()])
    //                     ->count()
    //             ],
    //             'all_time' => [
    //                 'total' => DB::table('pending_transactions')->where('seller_id', $seller->id)->count(),
    //                 'pending' => DB::table('pending_transactions')->where('seller_id', $seller->id)->where('status', 'pending')->count(),
    //                 'claimed' => DB::table('pending_transactions')->where('seller_id', $seller->id)->where('status', 'claimed')->count(),
    //                 'expired' => DB::table('pending_transactions')->where('seller_id', $seller->id)->where('status', 'expired')->count(),
    //             ]
    //         ];

    //         return response()->json([
    //             'success' => true,
    //             'stats' => $stats
    //         ]);
    //     } catch (Exception $e) {
    //         Log::error('Receipt stats error: ' . $e->getMessage());
    //         return response()->json(['success' => false, 'message' => 'Error fetching stats'], 500);
    //     }
    // }
}
