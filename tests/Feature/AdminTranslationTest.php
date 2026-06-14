<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class AdminTranslationTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');
    }

    // ═══════════════════════════════════════════════════════════
    // TRANSLATION FILE COMPLETENESS
    // ═══════════════════════════════════════════════════════════

    public function test_ar_and_en_translation_files_have_identical_top_level_keys(): void
    {
        $ar = require base_path('lang/ar/admin.php');
        $en = require base_path('lang/en/admin.php');

        $this->assertSame(
            array_keys($ar),
            array_keys($en),
            'Top-level keys differ between ar/admin.php and en/admin.php'
        );
    }

    public function test_ar_and_en_nav_section_have_identical_keys(): void
    {
        $ar = require base_path('lang/ar/admin.php');
        $en = require base_path('lang/en/admin.php');

        $this->assertSame(array_keys($ar['nav']), array_keys($en['nav']));
    }

    public function test_ar_and_en_common_section_have_identical_keys(): void
    {
        $ar = require base_path('lang/ar/admin.php');
        $en = require base_path('lang/en/admin.php');

        $this->assertSame(array_keys($ar['common']), array_keys($en['common']));
    }

    public function test_ar_and_en_posts_section_have_identical_keys(): void
    {
        $ar = require base_path('lang/ar/admin.php');
        $en = require base_path('lang/en/admin.php');

        $this->assertSame(array_keys($ar['posts']), array_keys($en['posts']));
    }

    public function test_ar_and_en_settings_section_have_identical_keys(): void
    {
        $ar = require base_path('lang/ar/admin.php');
        $en = require base_path('lang/en/admin.php');

        $this->assertSame(array_keys($ar['settings']), array_keys($en['settings']));
    }

    public function test_ar_areas_section_has_governorates_sub_array(): void
    {
        $ar = require base_path('lang/ar/admin.php');
        $this->assertArrayHasKey('governorates', $ar['areas']);
        $this->assertArrayHasKey('capital', $ar['areas']['governorates']);
    }

    // ═══════════════════════════════════════════════════════════
    // ARABIC LOCALE — admin dashboard renders Arabic strings
    // ═══════════════════════════════════════════════════════════

    public function test_dashboard_renders_arabic_title_in_ar_locale(): void
    {
        $this->actingAs($this->admin)
            ->withSession(['locale' => 'ar'])
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('لوحة التحكم');
    }

    public function test_dashboard_renders_english_title_in_en_locale(): void
    {
        $this->actingAs($this->admin)
            ->withSession(['locale' => 'en'])
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Dashboard');
    }

    // ═══════════════════════════════════════════════════════════
    // ARABIC LOCALE — posts index renders Arabic strings
    // ═══════════════════════════════════════════════════════════

    public function test_posts_index_renders_arabic_strings_in_ar_locale(): void
    {
        $this->actingAs($this->admin)
            ->withSession(['locale' => 'ar'])
            ->get(route('admin.posts.index'))
            ->assertOk()
            ->assertSee('المقالات')
            ->assertSee('إدارة جميع المقالات والمحتوى');
    }

    public function test_posts_index_renders_english_strings_in_en_locale(): void
    {
        $this->actingAs($this->admin)
            ->withSession(['locale' => 'en'])
            ->get(route('admin.posts.index'))
            ->assertOk()
            ->assertSee('Posts')
            ->assertSee('Manage all posts and content');
    }

    // ═══════════════════════════════════════════════════════════
    // ARABIC LOCALE — areas index
    // ═══════════════════════════════════════════════════════════

    public function test_areas_index_renders_arabic_strings_in_ar_locale(): void
    {
        $this->actingAs($this->admin)
            ->withSession(['locale' => 'ar'])
            ->get(route('admin.areas.index'))
            ->assertOk()
            ->assertSee('المناطق');
    }

    public function test_areas_index_renders_english_strings_in_en_locale(): void
    {
        $this->actingAs($this->admin)
            ->withSession(['locale' => 'en'])
            ->get(route('admin.areas.index'))
            ->assertOk()
            ->assertSee('Areas');
    }

    // ═══════════════════════════════════════════════════════════
    // ARABIC LOCALE — users index
    // ═══════════════════════════════════════════════════════════

    public function test_users_index_renders_arabic_strings_in_ar_locale(): void
    {
        $this->actingAs($this->admin)
            ->withSession(['locale' => 'ar'])
            ->get(route('admin.users.index'))
            ->assertOk()
            ->assertSee('المستخدمون');
    }

    public function test_users_index_renders_english_strings_in_en_locale(): void
    {
        $this->actingAs($this->admin)
            ->withSession(['locale' => 'en'])
            ->get(route('admin.users.index'))
            ->assertOk()
            ->assertSee('Users');
    }

    // ═══════════════════════════════════════════════════════════
    // SPECIFIC TRANSLATION KEY VALUES
    // ═══════════════════════════════════════════════════════════

    public function test_ar_translation_logout_key_is_correct(): void
    {
        App::setLocale('ar');
        $this->assertSame('تسجيل الخروج', __('admin.logout'));
    }

    public function test_en_translation_logout_key_is_correct(): void
    {
        App::setLocale('en');
        $this->assertSame('Log Out', __('admin.logout'));
    }

    public function test_ar_translation_panel_title_is_correct(): void
    {
        App::setLocale('ar');
        $this->assertSame('لوحة التحكم', __('admin.panel_title'));
    }

    public function test_en_translation_panel_title_is_correct(): void
    {
        App::setLocale('en');
        $this->assertSame('Control Panel', __('admin.panel_title'));
    }

    public function test_ar_translation_settings_saved_flash_is_correct(): void
    {
        App::setLocale('ar');
        $this->assertSame('تم حفظ الإعدادات بنجاح.', __('admin.settings.saved'));
    }

    public function test_en_translation_settings_saved_flash_is_correct(): void
    {
        App::setLocale('en');
        $this->assertSame('Settings saved successfully.', __('admin.settings.saved'));
    }

    public function test_ar_translation_posts_confirm_delete_is_correct(): void
    {
        App::setLocale('ar');
        $this->assertSame('هل أنت متأكد من حذف هذا المقال؟', __('admin.posts.confirm_delete'));
    }

    public function test_en_translation_posts_confirm_delete_is_correct(): void
    {
        App::setLocale('en');
        $this->assertSame('Are you sure you want to delete this post?', __('admin.posts.confirm_delete'));
    }

    public function test_ar_nav_keys_resolve_to_arabic_strings(): void
    {
        App::setLocale('ar');
        $this->assertSame('الرسائل', __('admin.nav.contacts'));
        $this->assertSame('التصنيفات', __('admin.nav.clusters'));
        $this->assertSame('المقالات', __('admin.nav.posts'));
    }

    public function test_en_nav_keys_resolve_to_english_strings(): void
    {
        App::setLocale('en');
        $this->assertSame('Messages', __('admin.nav.contacts'));
        $this->assertSame('Clusters', __('admin.nav.clusters'));
        $this->assertSame('Posts', __('admin.nav.posts'));
    }

    // ═══════════════════════════════════════════════════════════
    // ROLES / PERMISSIONS / SETTINGS PAGES
    // ═══════════════════════════════════════════════════════════

    public function test_roles_index_renders_arabic_in_ar_locale(): void
    {
        $this->actingAs($this->admin)
            ->withSession(['locale' => 'ar'])
            ->get(route('admin.roles.index'))
            ->assertOk()
            ->assertSee('الأدوار');
    }

    public function test_roles_index_renders_english_in_en_locale(): void
    {
        $this->actingAs($this->admin)
            ->withSession(['locale' => 'en'])
            ->get(route('admin.roles.index'))
            ->assertOk()
            ->assertSee('Roles');
    }

    public function test_settings_page_renders_arabic_in_ar_locale(): void
    {
        $this->actingAs($this->admin)
            ->withSession(['locale' => 'ar'])
            ->get(route('admin.settings'))
            ->assertOk()
            ->assertSee('الإعدادات');
    }

    public function test_settings_page_renders_english_in_en_locale(): void
    {
        $this->actingAs($this->admin)
            ->withSession(['locale' => 'en'])
            ->get(route('admin.settings'))
            ->assertOk()
            ->assertSee('Settings');
    }
}
