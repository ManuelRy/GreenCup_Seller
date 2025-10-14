<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ImageProxyController extends Controller
{
    /**
     * Proxy images from HTTP file server through HTTPS
     * This avoids mixed content errors when the main app uses HTTPS
     * but the file server only supports HTTP
     */
    public function proxy(Request $request, $path)
    {
        // Build the full file server URL
        $fileServerUrl = env('FILE_SERVER_URL', 'http://188.166.186.208');
        $imageUrl = $fileServerUrl . '/api/files/get/' . $path;

        try {
            // Cache the image for 1 hour to reduce load on file server
            $cacheKey = 'image_proxy_' . md5($imageUrl);

            $imageData = Cache::remember($cacheKey, 3600, function () use ($imageUrl) {
                $response = Http::timeout(10)->get($imageUrl);

                if ($response->successful()) {
                    return [
                        'body' => $response->body(),
                        'contentType' => $response->header('Content-Type') ?: 'image/jpeg',
                    ];
                }

                return null;
            });

            if (!$imageData) {
                abort(404, 'Image not found');
            }

            return response($imageData['body'])
                ->header('Content-Type', $imageData['contentType'])
                ->header('Cache-Control', 'public, max-age=3600');

        } catch (\Exception $e) {
            \Log::error('Image proxy error: ' . $e->getMessage(), [
                'url' => $imageUrl,
                'path' => $path
            ]);
            abort(404, 'Image not found');
        }
    }
}
