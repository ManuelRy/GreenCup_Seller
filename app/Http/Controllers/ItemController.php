<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Item::query();

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Sort by name by default
        $items = $query->orderBy('name')->paginate(15);

        return view('items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('items.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:items,name',
            'points_per_unit' => 'required|integer|min:1|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('items', 'public');
            $validated['image_url'] = '/storage/' . $imagePath;
        }

        // Remove 'image' from validated data since we use 'image_url' in database
        unset($validated['image']);

        Item::create($validated);

        return redirect()->route('item.index')
            ->with('success', 'Item created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        return view('items.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        return view('items.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('items', 'name')->ignore($item->id)
            ],
            'points_per_unit' => 'required|integer|min:1|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($item->image_url && file_exists(public_path($item->image_url))) {
                unlink(public_path($item->image_url));
            }

            $imagePath = $request->file('image')->store('items', 'public');
            $validated['image_url'] = '/storage/' . $imagePath;
        }

        // Remove 'image' from validated data since we use 'image_url' in database
        unset($validated['image']);

        $item->update($validated);

        return redirect()->route('item.index')
            ->with('success', 'Item updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        // Delete associated image file if exists
        if ($item->image_url && file_exists(public_path($item->image_url))) {
            unlink(public_path($item->image_url));
        }

        $item->delete();

        return redirect()->route('item.index')
            ->with('success', 'Item deleted successfully!');
    }
}
