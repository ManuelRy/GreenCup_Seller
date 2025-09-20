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
            'points_per_unit' => 'required|integer|min:1|max:1000',
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
            ...$request->all(),
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
        return view('items.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255'
            ],
            'points_per_unit' => 'required|integer|min:1|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);
        $imageUrl = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $response = $this->fRepo->upload("items", $file);
            if ($response->successful()) {
                $data = $response->json();
                $imageUrl = $this->fRepo->get($data['path']);
            }
        }

        $this->iRepo->update($id, Auth::id(), [
            ...$request->all(),
            'image_url' => $imageUrl
        ]);

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
