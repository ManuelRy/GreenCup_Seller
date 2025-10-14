<?php

namespace App\Repository;

use Illuminate\Support\Facades\Http;

class FileRepository
{
  /**
   * Get the file server host URL
   * For uploads, always use HTTP
   */
  public function host(): string
  {
    return env('FILE_SERVER_URL', 'http://188.166.186.208');
  }

  /**
   * Get the base API URL for server-side operations
   */
  public function base(): string
  {
    return $this->host() . '/api/files';
  }

  /**
   * Get the public URL for displaying images
   * Uses image proxy to avoid mixed content issues when app uses HTTPS but file server is HTTP-only
   */
  public function get($path): string
  {
    // Check if we should use proxy (when app is HTTPS and file server is HTTP)
    $useProxy = env('USE_IMAGE_PROXY', true);

    if ($useProxy) {
      // Use Laravel route to proxy images through our HTTPS domain
      return url('/proxy/images/' . $path);
    }

    // Fallback to direct URL (for local development or when file server has HTTPS)
    $publicUrl = env('FILE_SERVER_PUBLIC_URL', '//188.166.186.208');
    return $publicUrl . '/api/files/get/' . $path;
  }

  /**
   * Upload a file to the server
   */
  public function upload($folder, $file)
  {
    return Http::attach(
      'file',
      fopen($file->getRealPath(), 'r'),
      $file->getClientOriginalName()
    )->post($this->base() . '/upload', [
      'folder' => $folder
    ]);
  }
}
