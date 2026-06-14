<?php

namespace Tests\Unit;

use App\Models\Media;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MediaModelTest extends TestCase
{
    use RefreshDatabase;

    // ─── Helpers ────────────────────────────────────────────

    private function makeMedia(array $overrides = []): Media
    {
        return Media::create(array_merge([
            'name'      => ['ar' => 'صورة تجريبية', 'en' => 'Test Image'],
            'alt'       => ['ar' => 'وصف الصورة',   'en' => 'Image description'],
            'file_name' => 'test-image.webp',
            'path'      => 'media/2026/05/test-image.webp',
            'mime_type' => 'image/webp',
            'size'      => 102400,
            'sort_order'=> 0,
        ], $overrides));
    }

    // ══════════════════════════════════════════════════════
    // CREATION
    // ══════════════════════════════════════════════════════

    // Happy: can create a media record with all fields
    public function test_media_can_be_created_with_all_fields(): void
    {
        $media = $this->makeMedia();

        $this->assertDatabaseHas('media', ['id' => $media->id]);
        $this->assertSame('Test Image',    $media->getTranslation('name', 'en'));
        $this->assertSame('صورة تجريبية', $media->getTranslation('name', 'ar'));
    }

    // Happy: both locales stored correctly on name
    public function test_media_name_stores_both_locales(): void
    {
        $media = $this->makeMedia([
            'name' => ['ar' => 'شعار الشركة', 'en' => 'Company Logo'],
        ]);

        $this->assertSame('شعار الشركة', $media->getTranslation('name', 'ar'));
        $this->assertSame('Company Logo', $media->getTranslation('name', 'en'));
    }

    // Happy: both locales stored correctly on alt
    public function test_media_alt_stores_both_locales(): void
    {
        $media = $this->makeMedia([
            'alt' => ['ar' => 'صورة للوحة كهربائية', 'en' => 'Central AC image'],
        ]);

        $this->assertSame('صورة للوحة كهربائية', $media->getTranslation('alt', 'ar'));
        $this->assertSame('Central AC image',   $media->getTranslation('alt', 'en'));
    }

    // Happy: file_name, path, mime_type, size stored correctly
    public function test_media_file_fields_store_correctly(): void
    {
        $media = $this->makeMedia([
            'file_name' => 'ac-unit.webp',
            'path'      => 'media/2026/05/ac-unit.webp',
            'mime_type' => 'image/webp',
            'size'      => 204800,
        ]);

        $this->assertSame('ac-unit.webp',              $media->file_name);
        $this->assertSame('media/2026/05/ac-unit.webp', $media->path);
        $this->assertSame('image/webp',                $media->mime_type);
        $this->assertSame(204800,                      $media->size);
    }

    // ══════════════════════════════════════════════════════
    // url ACCESSOR
    // ══════════════════════════════════════════════════════

    // Happy: url accessor returns the full public storage URL
    public function test_media_url_accessor_returns_public_url(): void
    {
        $media = $this->makeMedia(['path' => 'media/2026/05/test.webp']);

        $this->assertSame(
            Storage::url('media/2026/05/test.webp'),
            $media->url
        );
    }

    // ══════════════════════════════════════════════════════
    // sort_order
    // ══════════════════════════════════════════════════════

    // Happy: sort_order defaults to 0
    public function test_media_sort_order_defaults_to_zero(): void
    {
        $media = Media::create([
            'name'      => ['ar' => 'أ', 'en' => 'A'],
            'alt'       => ['ar' => 'أ', 'en' => 'A'],
            'file_name' => 'a.webp',
            'path'      => 'media/a.webp',
            'mime_type' => 'image/webp',
            'size'      => 1024,
        ]);

        $this->assertSame(0, $media->fresh()->sort_order);
    }

    // Happy: sort_order can be set explicitly
    public function test_media_sort_order_can_be_set(): void
    {
        $media = $this->makeMedia(['sort_order' => 5]);

        $this->assertSame(5, $media->fresh()->sort_order);
    }

    // ══════════════════════════════════════════════════════
    // UPDATE & DELETE
    // ══════════════════════════════════════════════════════

    // Happy: media name can be updated
    public function test_media_can_be_updated(): void
    {
        $media = $this->makeMedia();

        $media->update(['name' => ['ar' => 'اسم جديد', 'en' => 'New Name']]);

        $this->assertSame('New Name', $media->fresh()->getTranslation('name', 'en'));
        $this->assertSame('اسم جديد', $media->fresh()->getTranslation('name', 'ar'));
    }

    // Happy: media record can be deleted
    public function test_media_can_be_deleted(): void
    {
        $media = $this->makeMedia();
        $id    = $media->id;

        $media->delete();

        $this->assertDatabaseMissing('media', ['id' => $id]);
    }

    // ══════════════════════════════════════════════════════
    // ORDERED SCOPE
    // ══════════════════════════════════════════════════════

    // Happy: latest() returns newest first by default
    public function test_media_ordered_by_latest(): void
    {
        $first = $this->makeMedia(['file_name' => 'first.webp', 'path' => 'media/first.webp']);
        $first->created_at = now()->subMinute();
        $first->save();

        $second = $this->makeMedia(['file_name' => 'second.webp', 'path' => 'media/second.webp']);

        $results = Media::latest()->get();

        $this->assertSame($second->id, $results->first()->id);
        $this->assertSame($first->id,  $results->last()->id);
    }

    // ══════════════════════════════════════════════════════
    // TRANSLATABLE
    // ══════════════════════════════════════════════════════

    // Happy: translatable fields are declared correctly on the model
    public function test_media_has_correct_translatable_fields(): void
    {
        $media = new Media();

        $this->assertContains('name', $media->getTranslatableAttributes());
        $this->assertContains('alt',  $media->getTranslatableAttributes());
    }
}
