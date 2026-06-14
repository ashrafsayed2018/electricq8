<?php

namespace Tests\Feature;

use App\Livewire\Admin\Settings\Index;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminSettingsLivewireTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $writer;

    protected function setUp(): void
    {
        parent::setUp();
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        Role::firstOrCreate(['name' => 'admin',  'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'writer', 'guard_name' => 'web']);

        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');

        $this->writer = User::factory()->create();
        $this->writer->assignRole('writer');
    }

    // ═══════════════════════════════════════════════════════════
    // ACCESS CONTROL
    // ═══════════════════════════════════════════════════════════

    public function test_guest_redirected_from_settings(): void
    {
        $this->get(route('admin.settings'))
            ->assertRedirect(route('login'));
    }

    public function test_writer_forbidden_from_settings(): void
    {
        $this->actingAs($this->writer)
            ->get(route('admin.settings'))
            ->assertForbidden();
    }

    public function test_admin_can_access_settings(): void
    {
        $this->actingAs($this->admin)
            ->get(route('admin.settings'))
            ->assertOk();
    }

    // ═══════════════════════════════════════════════════════════
    // LOADING — mount pulls all settings
    // ═══════════════════════════════════════════════════════════

    public function test_mount_loads_existing_settings(): void
    {
        SiteSetting::create(['key' => 'whatsapp_number', 'value' => '96512345678', 'group' => 'contact']);
        SiteSetting::create(['key' => 'company_name',    'value' => 'ElectricQ8',      'group' => 'general']);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->assertSet('settings.whatsapp_number', '96512345678')
            ->assertSet('settings.company_name',    'ElectricQ8');
    }

    public function test_mount_with_no_settings_loads_empty_array(): void
    {
        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->assertSet('settings', []);
    }

    // ═══════════════════════════════════════════════════════════
    // SAVE — updates DB values
    // ═══════════════════════════════════════════════════════════

    public function test_save_persists_changed_setting_to_database(): void
    {
        SiteSetting::create(['key' => 'whatsapp_number', 'value' => '96512345678', 'group' => 'contact']);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->set('settings.whatsapp_number', '96598765432')
            ->call('save');

        $this->assertDatabaseHas('site_settings', [
            'key'   => 'whatsapp_number',
            'value' => '96598765432',
        ]);
    }

    public function test_save_persists_multiple_settings(): void
    {
        SiteSetting::create(['key' => 'whatsapp_number', 'value' => 'old-number', 'group' => 'contact']);
        SiteSetting::create(['key' => 'company_name',    'value' => 'OldName',    'group' => 'general']);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->set('settings.whatsapp_number', '96500000000')
            ->set('settings.company_name',    'NewName')
            ->call('save');

        $this->assertDatabaseHas('site_settings', ['key' => 'whatsapp_number', 'value' => '96500000000']);
        $this->assertDatabaseHas('site_settings', ['key' => 'company_name',    'value' => 'NewName']);
    }

    public function test_save_shows_success_flash_in_rendered_output(): void
    {
        SiteSetting::create(['key' => 'whatsapp_number', 'value' => '965', 'group' => 'contact']);

        // Flash is set via session()->flash() in the component then rendered in the view
        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->set('settings.whatsapp_number', '96512345678')
            ->call('save')
            ->assertSee('تم حفظ الإعدادات بنجاح');
    }

    public function test_save_creates_new_setting_if_not_yet_in_db(): void
    {
        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->set('settings.new_key', 'new_value')
            ->call('save');

        $this->assertDatabaseHas('site_settings', ['key' => 'new_key', 'value' => 'new_value']);
    }

    // ═══════════════════════════════════════════════════════════
    // UNHAPPY — saving empty string clears the value
    // ═══════════════════════════════════════════════════════════

    public function test_save_stores_empty_string_value(): void
    {
        SiteSetting::create(['key' => 'company_name', 'value' => 'ElectricQ8', 'group' => 'general']);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->set('settings.company_name', '')
            ->call('save');

        $this->assertDatabaseHas('site_settings', ['key' => 'company_name', 'value' => '']);
    }
}
