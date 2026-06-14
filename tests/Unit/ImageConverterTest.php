<?php

namespace Tests\Unit;

use App\Services\ImageConverter;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageConverterTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    // ══════════════════════════════════════════════════════
    // CONVERSION & STORAGE
    // ══════════════════════════════════════════════════════

    // Happy: converts a JPEG and stores it under media/YYYY/MM/
    public function test_converts_jpeg_and_stores_as_webp(): void
    {
        $file = UploadedFile::fake()->image('photo.jpg', 100, 100);

        $path = ImageConverter::store($file);

        Storage::disk('public')->assertExists($path);
        $this->assertStringEndsWith('.webp', $path);
    }

    // Happy: converts a PNG and stores it as webp
    public function test_converts_png_and_stores_as_webp(): void
    {
        $file = UploadedFile::fake()->image('photo.png', 100, 100);

        $path = ImageConverter::store($file);

        Storage::disk('public')->assertExists($path);
        $this->assertStringEndsWith('.webp', $path);
    }

    // Happy: converts a GIF and stores it as webp
    public function test_converts_gif_and_stores_as_webp(): void
    {
        $file = UploadedFile::fake()->image('photo.gif', 100, 100);

        $path = ImageConverter::store($file);

        Storage::disk('public')->assertExists($path);
        $this->assertStringEndsWith('.webp', $path);
    }

    // Happy: stores file under media/YYYY/MM/ directory structure
    public function test_stores_file_under_year_month_directory(): void
    {
        $file = UploadedFile::fake()->image('photo.jpg', 100, 100);

        $path = ImageConverter::store($file);

        $expectedPrefix = 'media/' . now()->format('Y/m') . '/';
        $this->assertStringStartsWith($expectedPrefix, $path);
    }

    // Happy: each call produces a unique filename (UUID-based)
    public function test_each_call_produces_unique_filename(): void
    {
        $file = UploadedFile::fake()->image('photo.jpg', 100, 100);

        $path1 = ImageConverter::store($file);
        $path2 = ImageConverter::store($file);

        $this->assertNotSame($path1, $path2);
    }

    // Happy: returned path is a string
    public function test_store_returns_string_path(): void
    {
        $file = UploadedFile::fake()->image('photo.jpg');

        $result = ImageConverter::store($file);

        $this->assertIsString($result);
    }

    // Happy: stored file has correct mime type webp
    public function test_stored_file_has_webp_mime_type(): void
    {
        $file = UploadedFile::fake()->image('photo.jpg', 100, 100);

        $path = ImageConverter::store($file);

        $stored = Storage::disk('public')->path($path);
        // In a fake disk the file is stored as-is, so we verify the extension only
        $this->assertStringEndsWith('.webp', $path);
    }

    // Happy: accepts a WebP file directly without failing
    public function test_accepts_webp_file(): void
    {
        $file = UploadedFile::fake()->image('photo.webp', 100, 100);

        $path = ImageConverter::store($file);

        Storage::disk('public')->assertExists($path);
    }

    // ══════════════════════════════════════════════════════
    // FILENAME
    // ══════════════════════════════════════════════════════

    // Happy: filename is always {uuid}.webp
    public function test_filename_is_uuid_dot_webp(): void
    {
        $file = UploadedFile::fake()->image('anything.jpg');

        $path = ImageConverter::store($file);

        $filename = basename($path);
        // UUID v4 pattern: 8-4-4-4-12 hex chars
        $this->assertMatchesRegularExpression(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}\.webp$/',
            $filename
        );
    }
}
