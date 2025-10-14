<?php

namespace App\Traits;

use App\Repository\FileRepository;
use Illuminate\Support\Str;

trait NormalizesRemoteUrl
{
    /**
     * Normalize stored remote file references so they can be rendered safely over HTTPS.
     */
    protected function normalizeRemoteUrl(?string $value): ?string
    {
        if (empty($value)) {
            return null;
        }

        if (Str::startsWith($value, '//')) {
            $value = 'https:' . $value;
        }

        if (Str::startsWith($value, 'http://')) {
            $value = Str::replaceFirst('http://', 'https://', $value);
        }

        if (!Str::startsWith($value, 'http')) {
            /** @var FileRepository $fileRepo */
            $fileRepo = app(FileRepository::class);
            return $fileRepo->get(ltrim($value, '/'));
        }

        return $value;
    }
}
