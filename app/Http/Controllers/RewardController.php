<?php

namespace App\Http\Controllers;

use App\Models\Reward;
use App\Repository\FileRepository;
use App\Repository\RewardRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class RewardController extends Controller
{
    private RewardRepository $rRepo;
    private FileRepository $fRepo;

    public function __construct(RewardRepository $rRepo, FileRepository $fRepo)
    {
        $this->rRepo = $rRepo;
        $this->fRepo = $fRepo;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rewards = $this->rRepo->list(Auth::id());
        return view('rewards.index', compact('rewards'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('rewards.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'points_required' => 'required|integer|min:1',
            'quantity' => 'required|integer|min:1',
            'valid_from' => 'required|date|after_or_equal:today',
            'valid_until' => 'required|date|after_or_equal:valid_from',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB limit
        ]);

        try {
            $imagePath = null;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $response = $this->fRepo->upload("rewards", $file);
                if ($response->successful()) {
                    $data = $response->json();
                    $imagePath = $this->fRepo->get($data['path']);
                }
            }

            $this->rRepo->create([
                ...$request->all(),
                'image_path' => $imagePath,
                'seller_id' => Auth::id(),
            ]);

            return redirect()->route('reward.index')
                ->with('success', 'Reward created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create reward. Please try again.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $reward = $this->rRepo->get($id, Auth::id());
        return view('rewards.edit', compact('reward'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reward $reward)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'points_required' => 'required|integer|min:1',
            'quantity' => 'required|integer|min:' . $reward->quantity_redeemed,
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after_or_equal:valid_from',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'is_active' => 'boolean',
        ]);

        try {
            $imagePath = null;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $response = $this->fRepo->upload("items", $file);
                if ($response->successful()) {
                    $data = $response->json();
                    $imagePath = $this->fRepo->get($data['path']);
                }
            }
            $this->rRepo->update($reward->id, Auth::id(), [
                ...$request->all(),
                'image_path' => $imagePath,
            ]);

            return redirect()->route('reward.index')
                ->with('success', 'Reward updated successfully!');
        } catch (\Exception $e) {
            Log::error('Reward update failed: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update reward. Please try again.');
        }
    }

    /**
     * Display pending reward redemptions for the seller
     */
    public function redemptions()
    {
        // For now, we'll create mock data for the design
        // This will be replaced with actual database queries later
        $redemptions = collect([
            (object)[
                'id' => 1,
                'consumer_name' => 'John Doe',
                'consumer_email' => 'john@example.com',
                'reward_name' => 'Free Coffee',
                'points_required' => 100,
                'status' => 'pending',
                'requested_at' => now()->subHours(2),
                'consumer_phone' => '+1234567890'
            ],
            (object)[
                'id' => 2,
                'consumer_name' => 'Jane Smith',
                'consumer_email' => 'jane@example.com',
                'reward_name' => '10% Discount',
                'points_required' => 50,
                'status' => 'pending',
                'requested_at' => now()->subHours(5),
                'consumer_phone' => '+0987654321'
            ],
            (object)[
                'id' => 3,
                'consumer_name' => 'Bob Johnson',
                'consumer_email' => 'bob@example.com',
                'reward_name' => 'Free Pastry',
                'points_required' => 75,
                'status' => 'approved',
                'requested_at' => now()->subDays(1),
                'approved_at' => now()->subHours(12),
                'consumer_phone' => '+1122334455'
            ]
        ]);

        return view('rewards.redemptions', compact('redemptions'));
    }

    /**
     * Approve a reward redemption
     */
    public function approveRedemption($id)
    {
        // Mock implementation for now
        return redirect()->route('reward.redemptions')
            ->with('success', 'Redemption approved successfully!');
    }

    /**
     * Reject a reward redemption
     */
    public function rejectRedemption($id)
    {
        // Mock implementation for now
        return redirect()->route('reward.redemptions')
            ->with('success', 'Redemption rejected successfully!');
    }
}
