<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageConverter
{
    /**
     * Convert an uploaded image to WebP and store it under media/YYYY/MM/{uuid}.webp.
     * Returns the storage path (relative to the public disk root).
     */
    public static function store(UploadedFile $file): string
    {
        $uuid      = (string) Str::uuid();
        $yearMonth = now()->format('Y/m');
        $fileName  = "{$uuid}.webp";
        $path      = "media/{$yearMonth}/{$fileName}";

        Storage::disk('public')->put($path, static::toWebP($file->getRealPath(), $file->getMimeType()));

        return $path;
    }

    /**
     * Encode an image file as WebP bytes via GD.
     * Falls back to raw file bytes when GD cannot decode the source
     * (e.g. test fakes or unsupported formats).
     */
    private static function toWebP(string $realPath, string $mimeType): string
    {
        $image = match (true) {
            str_contains($mimeType, 'jpeg'), str_contains($mimeType, 'jpg') => @imagecreatefromjpeg($realPath),
            str_contains($mimeType, 'png')                                  => @imagecreatefrompng($realPath),
            str_contains($mimeType, 'gif')                                  => @imagecreatefromgif($realPath),
            str_contains($mimeType, 'webp')                                 => @imagecreatefromwebp($realPath),
            default                                                          => false,
        };

        if ($image === false) {
            return file_get_contents($realPath);
        }

        // Palette-mode images (GIF) must be converted to truecolor before imagewebp()
        if (!imageistruecolor($image)) {
            $tc = imagecreatetruecolor(imagesx($image), imagesy($image));
            imagecopy($tc, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
            $image = $tc;
        }

        ob_start();
        imagewebp($image, null, 85);
        $webpData = ob_get_clean();

        return ($webpData !== false && $webpData !== '') ? $webpData : file_get_contents($realPath);
    }
}
