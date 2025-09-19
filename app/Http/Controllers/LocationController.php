<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class LocationController extends Controller
{
    /**
     * Display the shop location page
     */
    public function show()
    {
        $seller = Auth::guard('seller')->user();

        if (!$seller) {
            return redirect()->route('seller.login');
        }

        return view('location.show', compact('seller'));
    }

    /**
     * Show the location edit form
     */
    public function edit()
    {
        $seller = Auth::guard('seller')->user();

        if (!$seller) {
            return redirect()->route('seller.login');
        }

        return view('location.edit', compact('seller'));
    }

    /**
     * Update the seller's location
     */
    public function update(Request $request)
    {
        $seller = Auth::guard('seller')->user();

        if (!$seller) {
            return redirect()->route('seller.login');
        }

        $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'address' => 'required|string|max:500',
        ]);

        $seller->update([
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'address' => $request->address,
        ]);

        return redirect()->route('location.show')
            ->with('success', 'Location updated successfully!');
    }

    /**
     * Get address from coordinates using reverse geocoding
     */
    public function reverseGeocode(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        try {
            // Using Nominatim (OpenStreetMap) for reverse geocoding - it's free
            $response = Http::get('https://nominatim.openstreetmap.org/reverse', [
                'format' => 'json',
                'lat' => $request->latitude,
                'lon' => $request->longitude,
                'addressdetails' => 1,
                'zoom' => 18,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $address = $data['display_name'] ?? 'Address not found';

                return response()->json([
                    'success' => true,
                    'address' => $address,
                    'details' => $data
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Unable to get address for this location'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error getting address: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Search for addresses (forward geocoding)
     */
    public function searchAddress(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:3',
        ]);

        try {
            // Using Nominatim for forward geocoding
            $response = Http::get('https://nominatim.openstreetmap.org/search', [
                'format' => 'json',
                'q' => $request->query,
                'limit' => 5,
                'addressdetails' => 1,
            ]);

            if ($response->successful()) {
                $results = $response->json();

                $formatted = collect($results)->map(function ($item) {
                    return [
                        'display_name' => $item['display_name'],
                        'latitude' => (float) $item['lat'],
                        'longitude' => (float) $item['lon'],
                        'importance' => $item['importance'] ?? 0,
                    ];
                })->sortByDesc('importance')->values();

                return response()->json([
                    'success' => true,
                    'results' => $formatted
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'No results found'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error searching address: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get current location using IP geolocation (fallback)
     */
    public function getApproximateLocation(Request $request)
    {
        try {
            // Using a free IP geolocation service as fallback
            $response = Http::get('http://ip-api.com/json/');

            if ($response->successful()) {
                $data = $response->json();

                if ($data['status'] === 'success') {
                    return response()->json([
                        'success' => true,
                        'latitude' => $data['lat'],
                        'longitude' => $data['lon'],
                        'city' => $data['city'] ?? '',
                        'country' => $data['country'] ?? '',
                    ]);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'Unable to determine approximate location'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error getting location: ' . $e->getMessage()
            ]);
        }
    }
}
