<?php

namespace Tests\Feature;

use App\Enums\ServiceStatus;
use App\Livewire\Admin\Services\Form;
use App\Livewire\Admin\Services\Index;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminServicesLivewireTest extends TestCase
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

    private function makeService(array $overrides = []): Service
    {
        return Service::create(array_merge([
            'title'      => ['ar' => 'تنظيف كهرباء', 'en' => 'AC Cleaning'],
            'slug'       => ['ar' => 'تنظيف-كهرباء', 'en' => 'ac-cleaning'],
            'h1'         => ['ar' => 'تنظيف كهرباء', 'en' => 'AC Cleaning'],
            'intro'      => ['ar' => 'وصف مختصر',  'en' => 'Short desc'],
            'content'    => ['ar' => 'محتوى',       'en' => 'Content'],
            'status'     => ServiceStatus::Active,
            'sort_order' => 1,
        ], $overrides));
    }

    // ═══════════════════════════════════════════════════════════
    // INDEX — listing & delete
    // ═══════════════════════════════════════════════════════════

    public function test_index_renders_existing_services(): void
    {
        $this->makeService(['title' => ['ar' => 'إصلاح كهرباء', 'en' => 'Electrical Repair']]);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->assertSee('Electrical Repair');
    }

    public function test_admin_can_delete_service(): void
    {
        $service = $this->makeService();

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->call('delete', $service);

        $this->assertDatabaseMissing('services', ['id' => $service->id]);
    }

    public function test_deleting_one_service_leaves_others_intact(): void
    {
        $first  = $this->makeService(['title' => ['ar' => 'أ', 'en' => 'First'],  'slug' => ['ar' => 'أ', 'en' => 'first']]);
        $second = $this->makeService(['title' => ['ar' => 'ب', 'en' => 'Second'], 'slug' => ['ar' => 'ب', 'en' => 'second']]);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->call('delete', $first);

        $this->assertDatabaseMissing('services', ['id' => $first->id]);
        $this->assertDatabaseHas('services',    ['id' => $second->id]);
    }

    // ═══════════════════════════════════════════════════════════
    // FORM — create
    // ═══════════════════════════════════════════════════════════

    public function test_valid_form_creates_service_and_redirects(): void
    {
        Livewire::actingAs($this->admin)
            ->test(Form::class)
            ->set('title_ar', 'تركيب كهرباء')
            ->set('title_en', 'Electrical Installation')
            ->set('slug_ar',  'تركيب-كهرباء')
            ->set('slug_en',  'ac-installation')
            ->set('status',   'active')
            ->call('save')
            ->assertRedirect(route('admin.services.index'));

        $this->assertDatabaseHas('services', ['id' => Service::latest()->first()->id]);
        $this->assertSame('Electrical Installation', Service::latest()->first()->getTranslation('title', 'en'));
    }

    public function test_creating_service_stores_both_translations(): void
    {
        Livewire::actingAs($this->admin)
            ->test(Form::class)
            ->set('title_ar', 'صيانة كهرباء')
            ->set('title_en', 'Electrical Maintenance')
            ->set('slug_ar',  'صيانة-كهرباء')
            ->set('slug_en',  'ac-maintenance')
            ->call('save');

        $service = Service::latest()->first();
        $this->assertSame('صيانة كهرباء',    $service->getTranslation('title', 'ar'));
        $this->assertSame('Electrical Maintenance', $service->getTranslation('title', 'en'));
    }

    // ═══════════════════════════════════════════════════════════
    // FORM — edit
    // ═══════════════════════════════════════════════════════════

    public function test_edit_form_prefills_existing_service(): void
    {
        $service = $this->makeService([
            'title'      => ['ar' => 'إصلاح', 'en' => 'Repair'],
            'slug'       => ['ar' => 'إصلاح', 'en' => 'repair'],
            'status'     => ServiceStatus::Active,
            'sort_order' => 5,
        ]);

        Livewire::actingAs($this->admin)
            ->test(Form::class, ['service' => $service])
            ->assertSet('title_ar',  'إصلاح')
            ->assertSet('title_en',  'Repair')
            ->assertSet('slug_en',   'repair')
            ->assertSet('status',    'active')
            ->assertSet('sort_order', 5);
    }

    public function test_valid_form_updates_existing_service(): void
    {
        $service = $this->makeService();

        Livewire::actingAs($this->admin)
            ->test(Form::class, ['service' => $service])
            ->set('title_en', 'Updated Service')
            ->set('status',   'inactive')
            ->call('save');

        $this->assertSame('Updated Service', $service->fresh()->getTranslation('title', 'en'));
        $this->assertSame('inactive',        $service->fresh()->status->value);
    }

    // ═══════════════════════════════════════════════════════════
    // FORM — slug auto-generation
    // ═══════════════════════════════════════════════════════════

    public function test_updating_title_en_auto_fills_slug_en(): void
    {
        Livewire::actingAs($this->admin)
            ->test(Form::class)
            ->set('title_en', 'AC Cleaning Service')
            ->assertSet('slug_en', 'ac-cleaning-service');
    }

    public function test_updating_title_ar_auto_fills_slug_ar(): void
    {
        Livewire::actingAs($this->admin)
            ->test(Form::class)
            ->set('title_ar', 'تنظيف كهرباء')
            ->assertSet('slug_ar', 'تنظيف-كهرباء');
    }

    // ═══════════════════════════════════════════════════════════
    // FORM — validation (unhappy)
    // ═══════════════════════════════════════════════════════════

    public function test_form_fails_without_title_ar(): void
    {
        Livewire::actingAs($this->admin)
            ->test(Form::class)
            ->set('title_ar', '')
            ->set('title_en', 'Electrical Repair')
            ->set('slug_ar',  'إصلاح')
            ->set('slug_en',  'ac-repair')
            ->call('save')
            ->assertHasErrors(['title_ar' => 'required']);
    }

    public function test_form_fails_without_title_en(): void
    {
        Livewire::actingAs($this->admin)
            ->test(Form::class)
            ->set('title_ar', 'إصلاح كهرباء')
            ->set('title_en', '')
            ->set('slug_ar',  'إصلاح')
            ->set('slug_en',  'ac-repair')
            ->call('save')
            ->assertHasErrors(['title_en' => 'required']);
    }

    public function test_form_fails_without_slug_ar(): void
    {
        Livewire::actingAs($this->admin)
            ->test(Form::class)
            ->set('title_ar', 'إصلاح كهرباء')
            ->set('title_en', 'Electrical Repair')
            ->set('slug_ar',  '')
            ->set('slug_en',  'ac-repair')
            ->call('save')
            ->assertHasErrors(['slug_ar' => 'required']);
    }

    public function test_form_fails_without_slug_en(): void
    {
        Livewire::actingAs($this->admin)
            ->test(Form::class)
            ->set('title_ar', 'إصلاح كهرباء')
            ->set('title_en', 'Electrical Repair')
            ->set('slug_ar',  'إصلاح')
            ->set('slug_en',  '')
            ->call('save')
            ->assertHasErrors(['slug_en' => 'required']);
    }

    public function test_no_service_created_when_validation_fails(): void
    {
        $countBefore = Service::count();

        Livewire::actingAs($this->admin)
            ->test(Form::class)
            ->set('title_ar', '')
            ->call('save');

        $this->assertSame($countBefore, Service::count());
    }
}
