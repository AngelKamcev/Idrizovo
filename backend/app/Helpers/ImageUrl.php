<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class ImageUrl
{
    public static function resolve(?string $path): string
    {
        $path = (string) $path;

        if ($path === '') {
            return '';
        }

        if (preg_match('#^https?://#i', $path)) {
            return $path;
        }

        if (self::localFileMissing($path)) {
            return '';
        }

        if (str_starts_with($path, '/storage/') || str_starts_with($path, 'storage/')) {
            return asset(ltrim($path, '/'));
        }

        if (preg_match('#^(images|documents)/#', $path)) {
            return asset($path);
        }

        return asset('storage/'.ltrim($path, '/'));
    }

    public static function resolveOrFallback(?string $path, ?string $fallback = null): string
    {
        $resolved = self::resolve($path);

        if ($resolved !== '') {
            return $resolved;
        }

        if ($fallback !== null && $fallback !== '') {
            if (preg_match('#^https?://#i', $fallback)) {
                return $fallback;
            }

            $fallbackResolved = self::resolve($fallback);

            if ($fallbackResolved !== '') {
                return $fallbackResolved;
            }
        }

        return '';
    }

    public static function localFileMissing(string $path): bool
    {
        if ($path === '' || preg_match('#^https?://#i', $path)) {
            return false;
        }

        $relative = ltrim($path, '/');

        if (str_starts_with($relative, 'storage/')) {
            $relative = substr($relative, strlen('storage/'));
        }

        if (preg_match('#^(images|documents)/#', $relative)) {
            return ! is_file(public_path($relative));
        }

        return ! Storage::disk('public')->exists($relative);
    }

    public static function galleryPlaceholder(int $id): string
    {
        return 'https://picsum.photos/id/'.(100 + ($id % 50)).'/500/400';
    }
}
