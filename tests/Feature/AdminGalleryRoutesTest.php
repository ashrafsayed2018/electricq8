<?php

namespace Tests\Feature;

use App\Models\Media;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminGalleryRoutesTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $guest;

    protected function setUp(): void
    {
        parent::setUp();
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $role = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        $this->admin = User::factory()->create();
        $this->admin->assignRole($role);

        $this->guest = User::factory()->create();

        Storage::fake('public');
    }

    // ─── Helper ──────────────────────────────────────────

    private function makeMedia(array $overrides = []): Media
    {
        return Media::create(array_merge([
            'name'      => ['ar' => 'صورة تجريبية', 'en' => 'Test Image'],
            'alt'       => ['ar' => 'وصف',           'en' => 'Alt text'],
            'file_name' => 'test.webp',
            'path'      => 'media/2026/05/test.webp',
            'mime_type' => 'image/webp',
            'size'      => 102400,
        ], $overrides));
    }

    // ══════════════════════════════════════════════════════
    // AUTH GUARD — unauthenticated users redirected to login
    // ══════════════════════════════════════════════════════

    // Unhappy: unauthenticated user redirected from gallery index
    public function test_unauthenticated_user_redirected_from_gallery(): void
    {
        $this->get(route('admin.gallery.index'))
            ->assertRedirect('/login');
    }

    // ══════════════════════════════════════════════════════
    // ROLE GUARD — non-admin gets 403
    // ══════════════════════════════════════════════════════

    // Unhappy: non-admin user is forbidden from gallery
    public function test_non_admin_user_forbidden_from_gallery(): void
    {
        $this->actingAs($this->guest)
            ->get(route('admin.gallery.index'))
            ->assertForbidden();
    }

    // ══════════════════════════════════════════════════════
    // GALLERY INDEX
    // ══════════════════════════════════════════════════════

    // Happy: gallery index returns 200 for admin
    public function test_admin_gallery_index_returns_200(): void
    {
        $this->actingAs($this->admin)
            ->get(route('admin.gallery.index'))
            ->assertOk();
    }

    // Happy: gallery index shows existing media English name
    public function test_admin_gallery_index_shows_existing_media(): void
    {
        $this->makeMedia(['name' => ['ar' => 'شعار', 'en' => 'Company Logo']]);

        $this->actingAs($this->admin)
            ->get(route('admin.gallery.index'))
            ->assertOk()
            ->assertSee('Company Logo');
    }

    // ══════════════════════════════════════════════════════
    // SIDEBAR NAV LINK
    // ══════════════════════════════════════════════════════

    // Happy: admin sidebar contains gallery link
    public function test_admin_sidebar_contains_gallery_link(): void
    {
        $this->actingAs($this->admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee(route('admin.gallery.index'), false);
    }
}
