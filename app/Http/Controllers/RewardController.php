<?php

namespace App\Http\Controllers;

use App\Models\Reward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class RewardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $seller = Auth::guard('seller')->user();

        if (!$seller) {
            return redirect()->route('login')->with('error', 'Please log in to manage rewards.');
        }

        $rewards = Reward::where('seller_id', $seller->id)
                        ->orderBy('created_at', 'desc')
                        ->paginate(12);

        return view('rewards.index', compact('rewards', 'seller'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $seller = Auth::guard('seller')->user();

        if (!$seller) {
            return redirect()->route('login')->with('error', 'Please log in to create rewards.');
        }

        return view('rewards.create', compact('seller'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $seller = Auth::guard('seller')->user();

        if (!$seller) {
            return redirect()->route('login')->with('error', 'Please log in to create rewards.');
        }

        $validated = $request->validate([
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
                $image = $request->file('image');
                $imagePath = $image->store('rewards', 'public');
            }

            Reward::create([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'points_required' => $validated['points_required'],
                'quantity' => $validated['quantity'],
                'valid_from' => $validated['valid_from'],
                'valid_until' => $validated['valid_until'],
                'image_path' => $imagePath,
                'seller_id' => $seller->id,
            ]);

            return redirect()->route('reward.index')
                ->with('success', 'Reward created successfully!');

        } catch (\Exception $e) {
            Log::error('Reward creation failed: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create reward. Please try again.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reward $reward)
    {
        $seller = Auth::guard('seller')->user();

        if (!$seller || $reward->seller_id !== $seller->id) {
            return redirect()->route('reward.index')
                ->with('error', 'You can only edit your own rewards.');
        }

        return view('rewards.edit', compact('reward', 'seller'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reward $reward)
    {
        $seller = Auth::guard('seller')->user();

        if (!$seller || $reward->seller_id !== $seller->id) {
            return redirect()->route('reward.index')
                ->with('error', 'You can only update your own rewards.');
        }

        $validated = $request->validate([
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
            $imagePath = $reward->image_path;
            
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($reward->image_path) {
                    Storage::disk('public')->delete($reward->image_path);
                }
                
                $image = $request->file('image');
                $imagePath = $image->store('rewards', 'public');
            }

            $reward->update([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'points_required' => $validated['points_required'],
                'quantity' => $validated['quantity'],
                'valid_from' => $validated['valid_from'],
                'valid_until' => $validated['valid_until'],
                'image_path' => $imagePath,
                'is_active' => $request->has('is_active'),
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
}
