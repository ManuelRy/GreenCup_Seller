<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use App\Models\SellerPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class SellerPhotoController extends Controller
{
    /**
     * Display the photo gallery management page
     */
    public function index()
    {
        try {
            $seller = Auth::guard('seller')->user();
            
            if (!$seller) {
                return redirect()->route('login')->with('error', 'Please log in to access photos.');
            }

            // Get photos ordered by featured first, then by sort order, then by newest
            $photos = $seller->photos()
                            ->orderByDesc('is_featured')
                            ->orderBy('sort_order')
                            ->orderByDesc('created_at')
                            ->get();

            return view('sellers.photo', compact('seller', 'photos'));
            
        } catch (\Exception $e) {
            Log::error('Error loading photo gallery: ' . $e->getMessage());
            return redirect()->route('dashboard')->with('error', 'Unable to load photo gallery.');
        }
    }

/**
 * Store a newly uploaded photo.
 */
/**
 * Store a newly uploaded photo.
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

        $seller = Auth::guard('seller')->user();

        if (!$seller) {
            return redirect()->route('login')->with('error', 'Please log in to upload photos.');
        }

        $file = $request->file('photo');
        $path = $file->store('seller_photos', 'public');
        $photoUrl = '/storage/' . $path;

        // If marking as featured, unset other featured photos
        $isFeatured = $request->filled('is_featured') && $request->is_featured;
        if ($isFeatured) {
            $seller->photos()->update(['is_featured' => false]);
        }

        $photo = $seller->photos()->create([
            'photo_url' => $photoUrl,
            'caption' => $request->caption,
            'category' => $request->category,
            'is_featured' => $isFeatured,
            'sort_order' => $seller->photos()->count()
        ]);

        // Update seller's main photo if this is featured
        if ($photo->is_featured) {
            $seller->update([
                'photo_url' => $photo->photo_url,
                'photo_caption' => $photo->caption
            ]);
        }

        // ADD THIS AJAX RESPONSE CODE HERE ↓↓↓
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Photo uploaded successfully!',
                'photo' => [
                    'id' => $photo->id,
                    'photo_url' => $photo->photo_url,
                    'caption' => $photo->caption,
                    'category' => $photo->category,
                    'is_featured' => $photo->is_featured,
                    'sort_order' => $photo->sort_order,
                    'created_at' => $photo->created_at->format('M j, Y g:i A')
                ]
            ]);
        }
        // ↑↑↑ END OF AJAX RESPONSE CODE

        return redirect()->route('seller.photos')->with('success', 'Photo uploaded successfully! 📷');
        
    } catch (\Illuminate\Validation\ValidationException $e) {
        // Handle AJAX validation errors too
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        }
        return redirect()->back()->withErrors($e->validator)->withInput();
    } catch (\Exception $e) {
        Log::error('Error uploading photo: ' . $e->getMessage());
        
        // Handle AJAX general errors too
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while uploading the photo.'
            ], 500);
        }
        return redirect()->back()->with('error', 'An error occurred while uploading the photo. Please try again.');
    }
}

    /**
     * Update photo details
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'caption' => 'nullable|string|max:255',
                'category' => 'nullable|in:store,products,ambiance',
                'is_featured' => 'nullable|boolean'
            ], [
                'caption.max' => 'Caption must not exceed 255 characters.',
                'category.in' => 'Please select a valid category.'
            ]);

            $seller = Auth::guard('seller')->user();
            
            if (!$seller) {
                return redirect()->route('login')->with('error', 'Please log in to update photos.');
            }
            
            $photo = $seller->photos()->findOrFail($id);

            // If marking as featured, unset other featured photos
            if ($request->filled('is_featured') && $request->is_featured) {
                $seller->photos()->where('id', '!=', $id)->update(['is_featured' => false]);
            }

            $photo->update([
                'caption' => $request->caption,
                'category' => $request->category ?? $photo->category,
                'is_featured' => $request->filled('is_featured') ? true : false
            ]);

            // Update seller's main photo if this is now featured
            if ($photo->is_featured) {
                $seller->update([
                    'photo_url' => $photo->photo_url,
                    'photo_caption' => $photo->caption
                ]);
            } elseif (!$seller->photos()->where('is_featured', true)->exists()) {
                // If no featured photo exists, clear seller's main photo
                $seller->update([
                    'photo_url' => null,
                    'photo_caption' => null
                ]);
            }

            return redirect()->route('seller.photos')->with('success', 'Photo updated successfully! ✏️');
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('seller.photos')->with('error', 'Photo not found.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating photo: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating the photo. Please try again.');
        }
    }

    /**
     * Delete a photo
     */
    public function destroy($id)
    {
        try {
            $seller = Auth::guard('seller')->user();
            
            if (!$seller) {
                return redirect()->route('login')->with('error', 'Please log in to delete photos.');
            }
            
            $photo = $seller->photos()->findOrFail($id);

            // Delete file from storage
            $photoPath = str_replace('/storage/', '', $photo->photo_url);
            
            if (Storage::disk('public')->exists($photoPath)) {
                Storage::disk('public')->delete($photoPath);
            }

            // If this was the featured photo, clear it from seller and set next photo as featured if exists
            if ($photo->is_featured) {
                $seller->update([
                    'photo_url' => null,
                    'photo_caption' => null
                ]);

                // Set the next most recent photo as featured
                $nextPhoto = $seller->photos()
                                  ->where('id', '!=', $id)
                                  ->orderByDesc('created_at')
                                  ->first();
                
                if ($nextPhoto) {
                    $nextPhoto->update(['is_featured' => true]);
                    $seller->update([
                        'photo_url' => $nextPhoto->photo_url,
                        'photo_caption' => $nextPhoto->caption
                    ]);
                }
            }

            $photo->delete();

            return redirect()->route('seller.photos')->with('success', 'Photo deleted successfully! 🗑️');
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('seller.photos')->with('error', 'Photo not found.');
        } catch (\Exception $e) {
            Log::error('Error deleting photo: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while deleting the photo. Please try again.');
        }
    }

    /**
     * Get photo details for editing (AJAX)
     */
    public function show($id)
    {
        try {
            $seller = Auth::guard('seller')->user();
            
            if (!$seller) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
            }
            
            $photo = $seller->photos()->findOrFail($id);

            return response()->json([
                'success' => true,
                'photo' => [
                    'id' => $photo->id,
                    'photo_url' => $photo->photo_url,
                    'caption' => $photo->caption,
                    'category' => $photo->category,
                    'is_featured' => $photo->is_featured,
                    'sort_order' => $photo->sort_order,
                    'created_at' => $photo->created_at->format('M j, Y g:i A')
                ]
            ]);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Photo not found'], 404);
        } catch (\Exception $e) {
            Log::error('Error fetching photo details: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred while fetching photo details.']);
        }
    }

    /**
     * Reorder photos (AJAX)
     */
    public function reorder(Request $request)
    {
        try {
            $request->validate([
                'photo_ids' => 'required|array',
                'photo_ids.*' => 'exists:seller_photos,id'
            ]);

            $seller = Auth::guard('seller')->user();
            
            if (!$seller) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
            }

            foreach ($request->photo_ids as $index => $photoId) {
                $seller->photos()->where('id', $photoId)->update(['sort_order' => $index]);
            }

            return response()->json(['success' => true, 'message' => 'Photos reordered successfully!']);
            
        } catch (\Exception $e) {
            Log::error('Error reordering photos: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred while reordering photos.']);
        }
    }
}