<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Repository\FileRepository;
use App\Repository\ItemRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ItemController extends Controller
{
    private ItemRepository $iRepo;
    private FileRepository $fRepo;

    public function __construct(ItemRepository $iRepo, FileRepository $fRepo)
    {
        $this->iRepo = $iRepo;
        $this->fRepo = $fRepo;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $items = $this->iRepo->listQuery(Auth::id(), $request->search);
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);
        // Handle image upload
        $imageUrl = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $response = $this->fRepo->upload("items", $file);
            if ($response->successful()) {
                $data = $response->json();
                $imageUrl = $this->fRepo->get($data['path']);
            }
        }

        $this->iRepo->create([
            'name' => $request->name,
            'points_per_unit' => 1, // Always 1 point per item
            'seller_id' => Auth::id(),
            'image_url' => $imageUrl
        ]);

        return redirect()->route('item.index')
            ->with('success', 'Item created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        // return view('item.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $item = $this->iRepo->get($id, Auth::id());

        if (!$item) {
            return redirect()->route('item.index')
                ->with('error', 'Item not found or you do not have permission to edit it.');
        }

        return view('items.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        // Get existing item to preserve image if not uploading new one
        $item = $this->iRepo->get($id, Auth::id());

        if (!$item) {
            return redirect()->route('item.index')
                ->with('error', 'Item not found or you do not have permission to update it.');
        }

        // Prepare update data (name only, points always stay at 1)
        $updateData = [
            'name' => $request->name,
        ];

        // Only update image if a new one is uploaded
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $response = $this->fRepo->upload("items", $file);
            if ($response->successful()) {
                $data = $response->json();
                $updateData['image_url'] = $this->fRepo->get($data['path']);
            }
        }
        // If no new image uploaded, keep the existing image_url (don't set it to null)

        $this->iRepo->update($id, Auth::id(), $updateData);

        return redirect()->route('item.index')
            ->with('success', 'Item updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->iRepo->delete($id, Auth::id());
        return redirect()->route('item.index')
            ->with('success', 'Item deleted successfully!');
    }
}
