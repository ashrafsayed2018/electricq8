<?php

namespace Tests\Feature;

use App\Livewire\Admin\Gallery\Index;
use App\Models\Media;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminGalleryLivewireTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        Role::firstOrCreate(['name' => 'admin']);
        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');
        Storage::fake('public');
    }

    // ─── Helpers ─────────────────────────────────────────

    private function makeMedia(array $overrides = []): Media
    {
        return Media::create(array_merge([
            'name'      => ['ar' => 'صورة تجريبية', 'en' => 'Test Image'],
            'alt'       => ['ar' => 'وصف الصورة',   'en' => 'Image alt'],
            'file_name' => 'test.webp',
            'path'      => 'media/2026/05/test.webp',
            'mime_type' => 'image/webp',
            'size'      => 102400,
            'sort_order'=> 0,
        ], $overrides));
    }

    // ══════════════════════════════════════════════════════
    // ACCESS CONTROL
    // ══════════════════════════════════════════════════════

    // Unhappy: guest cannot access gallery page
    public function test_guest_cannot_access_gallery(): void
    {
        $this->get(route('admin.gallery.index'))
            ->assertRedirect(route('login'));
    }

    // Unhappy: non-admin user is forbidden from gallery
    public function test_non_admin_cannot_access_gallery(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.gallery.index'))
            ->assertForbidden();
    }

    // Happy: admin can access gallery page
    public function test_admin_can_access_gallery(): void
    {
        $this->actingAs($this->admin)
            ->get(route('admin.gallery.index'))
            ->assertOk();
    }

    // ══════════════════════════════════════════════════════
    // INDEX — LISTING
    // ══════════════════════════════════════════════════════

    // Happy: gallery renders existing media items
    public function test_index_renders_existing_media(): void
    {
        $this->makeMedia(['name' => ['ar' => 'شعار', 'en' => 'Logo']]);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->assertSee('Logo');
    }

    // Happy: gallery shows empty state when no media exists
    public function test_index_shows_empty_state_when_no_media(): void
    {
        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->assertSee('لا توجد صور بعد');
    }

    // Happy: multiple media items all appear in the grid
    public function test_index_shows_all_media_items(): void
    {
        $this->makeMedia(['name' => ['ar' => 'أ', 'en' => 'Alpha'], 'path' => 'media/alpha.webp', 'file_name' => 'alpha.webp']);
        $this->makeMedia(['name' => ['ar' => 'ب', 'en' => 'Beta'],  'path' => 'media/beta.webp',  'file_name' => 'beta.webp']);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->assertSee('Alpha')
            ->assertSee('Beta');
    }

    // ══════════════════════════════════════════════════════
    // SEARCH
    // ══════════════════════════════════════════════════════

    // Happy: search filters media by English name
    public function test_search_filters_by_english_name(): void
    {
        $this->makeMedia(['name' => ['ar' => 'أ', 'en' => 'Company Logo'], 'path' => 'media/logo.webp',   'file_name' => 'logo.webp']);
        $this->makeMedia(['name' => ['ar' => 'ب', 'en' => 'Hero Banner'],  'path' => 'media/banner.webp', 'file_name' => 'banner.webp']);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->set('search', 'Logo')
            ->assertSee('Company Logo')
            ->assertDontSee('Hero Banner');
    }

    // Happy: search filters media by Arabic name
    public function test_search_filters_by_arabic_name(): void
    {
        $this->makeMedia(['name' => ['ar' => 'شعار الشركة', 'en' => 'Company Logo'], 'path' => 'media/logo.webp',   'file_name' => 'logo.webp']);
        $this->makeMedia(['name' => ['ar' => 'صورة بانر',   'en' => 'Hero Banner'],  'path' => 'media/banner.webp', 'file_name' => 'banner.webp']);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->set('search', 'شعار')
            ->assertSee('Company Logo')
            ->assertDontSee('Hero Banner');
    }

    // Happy: clearing search shows all media
    public function test_clearing_search_shows_all_media(): void
    {
        $this->makeMedia(['name' => ['ar' => 'أ', 'en' => 'Logo'],  'path' => 'media/logo.webp',   'file_name' => 'logo.webp']);
        $this->makeMedia(['name' => ['ar' => 'ب', 'en' => 'Banner'],'path' => 'media/banner.webp', 'file_name' => 'banner.webp']);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->set('search', 'Logo')
            ->set('search', '')
            ->assertSee('Logo')
            ->assertSee('Banner');
    }

    // ══════════════════════════════════════════════════════
    // DELETE
    // ══════════════════════════════════════════════════════

    // Happy: admin can delete a media record
    public function test_admin_can_delete_media(): void
    {
        $media = $this->makeMedia();

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->call('delete', $media->id);

        $this->assertDatabaseMissing('media', ['id' => $media->id]);
    }

    // Happy: deleting media removes the file from storage
    public function test_deleting_media_removes_file_from_storage(): void
    {
        Storage::disk('public')->put('media/2026/05/deleteme.webp', 'fake-content');

        $media = $this->makeMedia([
            'path'      => 'media/2026/05/deleteme.webp',
            'file_name' => 'deleteme.webp',
        ]);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->call('delete', $media->id);

        Storage::disk('public')->assertMissing('media/2026/05/deleteme.webp');
    }

    // Happy: deleting one media item does not affect others
    public function test_deleting_one_media_leaves_others_intact(): void
    {
        $first  = $this->makeMedia(['path' => 'media/first.webp',  'file_name' => 'first.webp']);
        $second = $this->makeMedia(['path' => 'media/second.webp', 'file_name' => 'second.webp']);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->call('delete', $first->id);

        $this->assertDatabaseMissing('media', ['id' => $first->id]);
        $this->assertDatabaseHas('media', ['id' => $second->id]);
    }

    // ══════════════════════════════════════════════════════
    // UPLOAD
    // ══════════════════════════════════════════════════════

    // Happy: valid image upload creates a media record
    public function test_valid_upload_creates_media_record(): void
    {
        $file = UploadedFile::fake()->image('photo.jpg', 800, 600);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->set('name_ar',  'صورة جديدة')
            ->set('name_en',  'New Photo')
            ->set('alt_ar',   'وصف الصورة')
            ->set('alt_en',   'Photo description')
            ->set('image',    $file)
            ->call('saveImage');

        $this->assertDatabaseCount('media', 1);

        $media = Media::first();
        $this->assertSame('New Photo',    $media->getTranslation('name', 'en'));
        $this->assertSame('صورة جديدة',  $media->getTranslation('name', 'ar'));
    }

    // Happy: uploaded image is saved to storage under media/YYYY/MM/
    public function test_upload_saves_file_to_storage(): void
    {
        $file = UploadedFile::fake()->image('photo.jpg', 800, 600);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->set('name_ar', 'صورة')
            ->set('name_en', 'Photo')
            ->set('alt_ar',  'وصف')
            ->set('alt_en',  'Alt')
            ->set('image',   $file)
            ->call('saveImage');

        $media = Media::first();
        Storage::disk('public')->assertExists($media->path);
    }

    // Happy: uploaded file is stored as webp
    public function test_upload_converts_file_to_webp(): void
    {
        $file = UploadedFile::fake()->image('photo.jpg');

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->set('name_ar', 'صورة')
            ->set('name_en', 'Photo')
            ->set('alt_ar',  'وصف')
            ->set('alt_en',  'Alt')
            ->set('image',   $file)
            ->call('saveImage');

        $media = Media::first();
        $this->assertStringEndsWith('.webp', $media->file_name);
        $this->assertSame('image/webp', $media->mime_type);
    }

    // Happy: form fields reset after successful upload
    public function test_form_resets_after_successful_upload(): void
    {
        $file = UploadedFile::fake()->image('photo.jpg');

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->set('name_ar', 'صورة')
            ->set('name_en', 'Photo')
            ->set('alt_ar',  'وصف')
            ->set('alt_en',  'Alt')
            ->set('image',   $file)
            ->call('saveImage')
            ->assertSet('name_ar', '')
            ->assertSet('name_en', '')
            ->assertSet('alt_ar',  '')
            ->assertSet('alt_en',  '')
            ->assertSet('image',   null);
    }

    // ══════════════════════════════════════════════════════
    // UPLOAD VALIDATION
    // ══════════════════════════════════════════════════════

    // Unhappy: upload fails without an image file
    public function test_upload_fails_without_image(): void
    {
        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->set('name_ar', 'صورة')
            ->set('name_en', 'Photo')
            ->set('alt_ar',  'وصف')
            ->set('alt_en',  'Alt')
            ->call('saveImage')
            ->assertHasErrors(['image' => 'required']);
    }

    // Unhappy: upload fails without Arabic name
    public function test_upload_fails_without_arabic_name(): void
    {
        $file = UploadedFile::fake()->image('photo.jpg');

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->set('name_ar', '')
            ->set('name_en', 'Photo')
            ->set('alt_ar',  'وصف')
            ->set('alt_en',  'Alt')
            ->set('image',   $file)
            ->call('saveImage')
            ->assertHasErrors(['name_ar' => 'required']);
    }

    // Unhappy: upload fails without English name
    public function test_upload_fails_without_english_name(): void
    {
        $file = UploadedFile::fake()->image('photo.jpg');

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->set('name_ar', 'صورة')
            ->set('name_en', '')
            ->set('alt_ar',  'وصف')
            ->set('alt_en',  'Alt')
            ->set('image',   $file)
            ->call('saveImage')
            ->assertHasErrors(['name_en' => 'required']);
    }

    // Unhappy: upload rejects files with disallowed extensions (e.g. svg)
    public function test_upload_rejects_non_image_files(): void
    {
        // SVG passes Livewire's preview-mime check (it's an image type) but
        // our mimes rule only allows jpg,jpeg,png,gif,webp — so it fails validation
        $file = UploadedFile::fake()->create('icon.svg', 10, 'image/svg+xml');

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->set('name_ar', 'ملف')
            ->set('name_en', 'File')
            ->set('alt_ar',  'وصف')
            ->set('alt_en',  'Alt')
            ->set('image',   $file)
            ->call('saveImage')
            ->assertHasErrors(['image']);
    }

    // Unhappy: upload rejects files over 5MB
    public function test_upload_rejects_files_over_5mb(): void
    {
        $file = UploadedFile::fake()->image('huge.jpg')->size(6000);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->set('name_ar', 'صورة')
            ->set('name_en', 'Photo')
            ->set('alt_ar',  'وصف')
            ->set('alt_en',  'Alt')
            ->set('image',   $file)
            ->call('saveImage')
            ->assertHasErrors(['image']);
    }

    // Unhappy: no media record created when validation fails
    public function test_no_media_created_when_validation_fails(): void
    {
        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->set('name_ar', '')
            ->call('saveImage');

        $this->assertDatabaseCount('media', 0);
    }

    // ══════════════════════════════════════════════════════
    // IMAGE PICKER (modal selection)
    // ══════════════════════════════════════════════════════

    // Happy: selectMedia dispatches browser event with media url and id
    public function test_select_media_dispatches_event_with_url_and_id(): void
    {
        $media = $this->makeMedia(['path' => 'media/2026/05/test.webp']);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->call('selectMedia', $media->id)
            ->assertDispatched('media-selected', id: $media->id, url: Storage::url('media/2026/05/test.webp'));
    }
}
