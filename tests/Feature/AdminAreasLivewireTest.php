<?php

namespace Tests\Feature;

use App\Livewire\Admin\Areas\Form;
use App\Livewire\Admin\Areas\Index;
use App\Models\Location;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminAreasLivewireTest extends TestCase
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

    private function makeLocation(array $overrides = []): Location
    {
        return Location::create(array_merge([
            'name'        => ['ar' => 'حولي',  'en' => 'Hawalli'],
            'slug'        => ['ar' => 'حولي',  'en' => 'hawalli'],
            'governorate' => 'hawalli',
            'is_active'   => true,
            'sort_order'  => 1,
        ], $overrides));
    }

    // ═══════════════════════════════════════════════════════════
    // INDEX — listing & delete
    // ═══════════════════════════════════════════════════════════

    public function test_index_renders_existing_areas(): void
    {
        $this->makeLocation(['name' => ['ar' => 'الكويت', 'en' => 'Kuwait City']]);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->assertSee('Kuwait City');
    }

    public function test_admin_can_delete_area(): void
    {
        $location = $this->makeLocation();

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->call('delete', $location);

        $this->assertDatabaseMissing('locations', ['id' => $location->id]);
    }

    public function test_deleting_one_area_leaves_others_intact(): void
    {
        $first  = $this->makeLocation(['name' => ['ar' => 'أ', 'en' => 'Alpha'], 'slug' => ['ar' => 'أ', 'en' => 'alpha']]);
        $second = $this->makeLocation(['name' => ['ar' => 'ب', 'en' => 'Beta'],  'slug' => ['ar' => 'ب', 'en' => 'beta']]);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->call('delete', $first);

        $this->assertDatabaseMissing('locations', ['id' => $first->id]);
        $this->assertDatabaseHas('locations',    ['id' => $second->id]);
    }

    // ═══════════════════════════════════════════════════════════
    // FORM — create
    // ═══════════════════════════════════════════════════════════

    public function test_valid_form_creates_area_and_redirects(): void
    {
        Livewire::actingAs($this->admin)
            ->test(Form::class)
            ->set('name_ar',    'مبارك الكبير')
            ->set('name_en',    'Mubarak Al-Kabeer')
            ->set('slug_ar',    'مبارك-الكبير')
            ->set('slug_en',    'mubarak-al-kabeer')
            ->set('governorate', 'ahmadi')
            ->call('save')
            ->assertRedirect(route('admin.areas.index'));

        $this->assertDatabaseHas('locations', ['governorate' => 'ahmadi']);
    }

    public function test_creating_area_stores_both_translations(): void
    {
        Livewire::actingAs($this->admin)
            ->test(Form::class)
            ->set('name_ar',    'الجهراء')
            ->set('name_en',    'Jahra')
            ->set('slug_ar',    'الجهراء')
            ->set('slug_en',    'jahra')
            ->set('governorate', 'jahra')
            ->call('save');

        $loc = Location::latest()->first();
        $this->assertSame('الجهراء', $loc->getTranslation('name', 'ar'));
        $this->assertSame('Jahra',   $loc->getTranslation('name', 'en'));
    }

    // ═══════════════════════════════════════════════════════════
    // FORM — edit
    // ═══════════════════════════════════════════════════════════

    public function test_edit_form_prefills_existing_location(): void
    {
        $location = $this->makeLocation([
            'name'        => ['ar' => 'السالمية', 'en' => 'Salmiya'],
            'slug'        => ['ar' => 'السالمية', 'en' => 'salmiya'],
            'governorate' => 'hawalli',
            'is_active'   => true,
            'sort_order'  => 3,
        ]);

        Livewire::actingAs($this->admin)
            ->test(Form::class, ['location' => $location])
            ->assertSet('name_ar',    'السالمية')
            ->assertSet('name_en',    'Salmiya')
            ->assertSet('slug_en',    'salmiya')
            ->assertSet('governorate', 'hawalli')
            ->assertSet('sort_order', 3);
    }

    public function test_valid_form_updates_existing_area(): void
    {
        $location = $this->makeLocation();

        Livewire::actingAs($this->admin)
            ->test(Form::class, ['location' => $location])
            ->set('name_en', 'Updated City')
            ->set('governorate', 'capital')
            ->call('save');

        $this->assertSame('Updated City', $location->fresh()->getTranslation('name', 'en'));
        $this->assertSame('capital',      $location->fresh()->governorate);
    }

    // ═══════════════════════════════════════════════════════════
    // FORM — slug auto-generation
    // ═══════════════════════════════════════════════════════════

    public function test_updating_name_en_auto_fills_slug_en(): void
    {
        Livewire::actingAs($this->admin)
            ->test(Form::class)
            ->set('name_en', 'Kuwait City')
            ->assertSet('slug_en', 'kuwait-city');
    }

    public function test_updating_name_ar_auto_fills_slug_ar(): void
    {
        Livewire::actingAs($this->admin)
            ->test(Form::class)
            ->set('name_ar', 'حولي')
            ->assertSet('slug_ar', 'حولي');
    }

    // ═══════════════════════════════════════════════════════════
    // FORM — validation (unhappy)
    // ═══════════════════════════════════════════════════════════

    public function test_form_fails_without_name_ar(): void
    {
        Livewire::actingAs($this->admin)
            ->test(Form::class)
            ->set('name_ar', '')
            ->set('name_en', 'Hawalli')
            ->set('slug_ar', 'hawalli')
            ->set('slug_en', 'hawalli')
            ->call('save')
            ->assertHasErrors(['name_ar' => 'required']);
    }

    public function test_form_fails_without_name_en(): void
    {
        Livewire::actingAs($this->admin)
            ->test(Form::class)
            ->set('name_ar', 'حولي')
            ->set('name_en', '')
            ->set('slug_ar', 'حولي')
            ->set('slug_en', 'hawalli')
            ->call('save')
            ->assertHasErrors(['name_en' => 'required']);
    }

    public function test_form_fails_without_slug_ar(): void
    {
        Livewire::actingAs($this->admin)
            ->test(Form::class)
            ->set('name_ar', 'حولي')
            ->set('name_en', 'Hawalli')
            ->set('slug_ar', '')
            ->set('slug_en', 'hawalli')
            ->call('save')
            ->assertHasErrors(['slug_ar' => 'required']);
    }

    public function test_form_fails_without_slug_en(): void
    {
        Livewire::actingAs($this->admin)
            ->test(Form::class)
            ->set('name_ar', 'حولي')
            ->set('name_en', 'Hawalli')
            ->set('slug_ar', 'حولي')
            ->set('slug_en', '')
            ->call('save')
            ->assertHasErrors(['slug_en' => 'required']);
    }

    public function test_form_fails_without_governorate(): void
    {
        Livewire::actingAs($this->admin)
            ->test(Form::class)
            ->set('name_ar',    'حولي')
            ->set('name_en',    'Hawalli')
            ->set('slug_ar',    'حولي')
            ->set('slug_en',    'hawalli')
            ->set('governorate', '')
            ->call('save')
            ->assertHasErrors(['governorate' => 'required']);
    }

    public function test_no_area_created_when_validation_fails(): void
    {
        $countBefore = Location::count();

        Livewire::actingAs($this->admin)
            ->test(Form::class)
            ->set('name_ar', '')
            ->call('save');

        $this->assertSame($countBefore, Location::count());
    }
}
