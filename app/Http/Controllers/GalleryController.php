<?php

namespace App\Http\Controllers;

use App\Repository\FileRepository;
use App\Repository\SellerGalleryRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GalleryController extends Controller
{
    private SellerGalleryRepository $sGRepo;
    private FileRepository $fRepo;


    public function __construct(SellerGalleryRepository $sGRepo, FileRepository $fRepo)
    {
        $this->sGRepo = $sGRepo;
        $this->fRepo = $fRepo;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $seller = Auth::user();
            $photos = $this->sGRepo->list($seller->id);
            return view('sellers.photo', compact('seller', 'photos'));
        } catch (Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Unable to load photo gallery.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'photo' => 'required|image|max:5120',
                'caption' => 'nullable|string|max:255',
                'category' => 'nullable|in:store,products,ambiance',
                'is_featured' => 'nullable|boolean'
            ], [
                'photo.required' => 'Please select a photo to upload.',
                'photo.image' => 'The file must be an image.',
                'photo.max' => 'The photo may not be greater than 5MB.',
                'caption.max' => 'Caption must not exceed 255 characters.',
                'category.in' => 'Please select a valid category.'
            ]);

            $isFeatured = $request->filled('is_featured') && $request->is_featured;
            $photoUrl = null;
            $file = $request->file('photo');
            $response = $this->fRepo->upload("galleries", $file);

            if ($response->successful()) {
                $data = $response->json();
                $photoUrl = $data['path'] ?? null;
            }

            $photo = $this->sGRepo->create([
                'seller_id' => Auth::id(),
                'photo_url' => $photoUrl,
                'caption' => $request->caption,
                'category' => $request->category,
                'is_featured' => $isFeatured,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Photo uploaded successfully!',
                'photo' => $photo
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while uploading the photo.'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $photo = $this->sGRepo->get($id, Auth::id());
            return response()->json([
                'success' => true,
                'photo' => $photo
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred.'], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'caption' => 'nullable|string|max:255',
                'category' => 'nullable|in:store,products,ambiance',
                'is_featured' => 'nullable|boolean'
            ]);

            $this->sGRepo->update($id, Auth::id(), $request->all());
            return redirect()->route('seller.photos');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating the photo.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->sGRepo->delete($id, Auth::id());
            return redirect()->route('seller.photos')->with('success', 'Photo deleted successfully! 🗑️');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while deleting the photo.');
        }
    }
}
