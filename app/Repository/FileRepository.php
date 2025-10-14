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
   * Uses protocol-relative URL to avoid mixed content issues
   */
  public function get($path): string
  {
    // Use protocol-relative URL for client-side (browser) requests
    // This automatically uses HTTP or HTTPS based on the page protocol
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
