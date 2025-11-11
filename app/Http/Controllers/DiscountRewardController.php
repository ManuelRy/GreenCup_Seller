<?php

namespace App\Http\Controllers;

use App\Models\DiscountReward;
use App\Repository\DiscountRewardRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DiscountRewardController extends Controller
{
    private DiscountRewardRepository $dRRepo;

    public function __construct(DiscountRewardRepository $dRRepo)
    {
        $this->dRRepo = $dRRepo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Redirect to the main rewards page where discount rewards are displayed
        return redirect()->route('reward.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('discount-rewards.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'discount_percentage' => 'required|numeric|min:0.01|max:100',
            'points_cost' => 'required|integer|min:1',
        ]);

        try {
            $this->dRRepo->create([
                ...$request->all(),
                'seller_id' => Auth::id(),
            ]);

            return redirect()->route('discount-reward.index')
                ->with('success', 'Discount reward created successfully!');
        } catch (\Exception $e) {
            Log::error('Discount reward creation error: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create discount reward. Please try again.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $discountReward = $this->dRRepo->get($id, Auth::id());

        if (!$discountReward) {
            return redirect()->route('discount-reward.index')
                ->with('error', 'Discount reward not found.');
        }

        return view('discount-rewards.edit', compact('discountReward'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'discount_percentage' => 'required|numeric|min:0.01|max:100',
            'points_cost' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ]);

        try {
            $discountReward = $this->dRRepo->update($id, Auth::id(), $request->all());

            if (!$discountReward) {
                return redirect()->route('discount-reward.index')
                    ->with('error', 'Discount reward not found.');
            }

            return redirect()->route('discount-reward.index')
                ->with('success', 'Discount reward updated successfully!');
        } catch (\Exception $e) {
            Log::error('Discount reward update error: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update discount reward. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $deleted = $this->dRRepo->delete($id, Auth::id());

            if (!$deleted) {
                return response()->json([
                    'success' => false,
                    'message' => 'Discount reward not found.'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Discount reward deleted successfully!'
            ]);
        } catch (\Exception $e) {
            Log::error('Discount reward deletion error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete discount reward.'
            ], 500);
        }
    }

    /**
     * Toggle active status
     */
    public function toggleActive($id)
    {
        try {
            $discountReward = $this->dRRepo->toggleActive($id, Auth::id());

            if (!$discountReward) {
                return response()->json([
                    'success' => false,
                    'message' => 'Discount reward not found.'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully!',
                'is_active' => $discountReward->is_active
            ]);
        } catch (\Exception $e) {
            Log::error('Discount reward toggle error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status.'
            ], 500);
        }
    }
}
