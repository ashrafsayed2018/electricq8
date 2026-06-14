<?php

namespace Tests\Feature;

use App\Livewire\Admin\Clusters\Form;
use App\Livewire\Admin\Clusters\Index;
use App\Models\Cluster;
use App\Models\Pillar;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminClustersLivewireTest extends TestCase
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

    private function makePillar(array $overrides = []): Pillar
    {
        return Pillar::create(array_merge([
            'title'      => ['ar' => 'خدمات الكهرباء', 'en' => 'Electrical Services'],
            'slug'       => ['ar' => 'خدمات-كهرباء',   'en' => 'ac-services'],
            'h1'         => ['ar' => 'خدمات الكهرباء', 'en' => 'Electrical Services'],
            'status'     => 'active',
            'sort_order' => 1,
        ], $overrides));
    }

    private function makeCluster(array $overrides = []): Cluster
    {
        $pillar = $this->makePillar();
        return Cluster::create(array_merge([
            'pillar_id'     => $pillar->id,
            'title'         => ['ar' => 'إصلاح الكهرباء', 'en' => 'Electrical Repair'],
            'slug'          => ['ar' => 'إصلاح-كهرباء',   'en' => 'ac-repair'],
            'h1'            => ['ar' => 'إصلاح الكهرباء', 'en' => 'Electrical Repair'],
            'search_intent' => 'commercial',
            'status'        => 'active',
            'sort_order'    => 1,
        ], $overrides));
    }

    // ═══════════════════════════════════════════════════════════
    // INDEX — listing & delete
    // ═══════════════════════════════════════════════════════════

    public function test_index_renders_existing_clusters(): void
    {
        $this->makeCluster(['title' => ['ar' => 'تنظيف', 'en' => 'AC Cleaning']]);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->assertSee('AC Cleaning');
    }

    public function test_admin_can_delete_cluster(): void
    {
        $cluster = $this->makeCluster();

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->call('delete', $cluster);

        $this->assertDatabaseMissing('clusters', ['id' => $cluster->id]);
    }

    public function test_deleting_one_cluster_leaves_others_intact(): void
    {
        $pillar = $this->makePillar(['slug' => ['ar' => 'p1', 'en' => 'p1']]);
        $first  = Cluster::create(['pillar_id' => $pillar->id, 'title' => ['ar' => 'أ', 'en' => 'First'],  'slug' => ['ar' => 'أ', 'en' => 'first'],  'h1' => ['ar' => 'أ', 'en' => 'First'],  'status' => 'active', 'sort_order' => 1]);
        $second = Cluster::create(['pillar_id' => $pillar->id, 'title' => ['ar' => 'ب', 'en' => 'Second'], 'slug' => ['ar' => 'ب', 'en' => 'second'], 'h1' => ['ar' => 'ب', 'en' => 'Second'], 'status' => 'active', 'sort_order' => 2]);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->call('delete', $first);

        $this->assertDatabaseMissing('clusters', ['id' => $first->id]);
        $this->assertDatabaseHas('clusters',    ['id' => $second->id]);
    }

    // ═══════════════════════════════════════════════════════════
    // FORM — create
    // ═══════════════════════════════════════════════════════════

    public function test_valid_form_creates_cluster_and_redirects(): void
    {
        $pillar = $this->makePillar();

        Livewire::actingAs($this->admin)
            ->test(Form::class)
            ->set('pillar_id', $pillar->id)
            ->set('title_ar',  'تنظيف كهرباء')
            ->set('title_en',  'AC Cleaning')
            ->set('slug_ar',   'تنظيف-كهرباء')
            ->set('slug_en',   'ac-cleaning')
            ->set('status',    'active')
            ->call('save')
            ->assertRedirect(route('admin.clusters.index'));

        $this->assertDatabaseHas('clusters', ['pillar_id' => $pillar->id]);
        $this->assertSame('AC Cleaning', Cluster::latest()->first()->getTranslation('title', 'en'));
    }

    public function test_creating_cluster_stores_both_translations(): void
    {
        $pillar = $this->makePillar();

        Livewire::actingAs($this->admin)
            ->test(Form::class)
            ->set('pillar_id', $pillar->id)
            ->set('title_ar',  'صيانة كهرباء')
            ->set('title_en',  'Electrical Maintenance')
            ->set('slug_ar',   'صيانة-كهرباء')
            ->set('slug_en',   'ac-maintenance')
            ->set('status',    'active')
            ->call('save');

        $cluster = Cluster::latest()->first();
        $this->assertSame('صيانة كهرباء',    $cluster->getTranslation('title', 'ar'));
        $this->assertSame('Electrical Maintenance', $cluster->getTranslation('title', 'en'));
    }

    // ═══════════════════════════════════════════════════════════
    // FORM — edit
    // ═══════════════════════════════════════════════════════════

    public function test_edit_form_prefills_existing_cluster(): void
    {
        $pillar  = $this->makePillar();
        $cluster = Cluster::create([
            'pillar_id'     => $pillar->id,
            'title'         => ['ar' => 'إصلاح', 'en' => 'Repair'],
            'slug'          => ['ar' => 'إصلاح', 'en' => 'repair'],
            'h1'            => ['ar' => 'إصلاح', 'en' => 'Repair'],
            'search_intent' => 'informational',
            'status'        => 'draft',
            'sort_order'    => 7,
        ]);

        Livewire::actingAs($this->admin)
            ->test(Form::class, ['cluster' => $cluster])
            ->assertSet('title_ar',      'إصلاح')
            ->assertSet('title_en',      'Repair')
            ->assertSet('slug_en',       'repair')
            ->assertSet('status',        'draft')
            ->assertSet('search_intent', 'informational')
            ->assertSet('sort_order',    7);
    }

    public function test_valid_form_updates_existing_cluster(): void
    {
        $cluster = $this->makeCluster();

        Livewire::actingAs($this->admin)
            ->test(Form::class, ['cluster' => $cluster])
            ->set('title_en', 'Updated Cluster')
            ->set('status',   'archived')
            ->call('save');

        $this->assertSame('Updated Cluster', $cluster->fresh()->getTranslation('title', 'en'));
        $this->assertSame('archived',        $cluster->fresh()->status);
    }

    // ═══════════════════════════════════════════════════════════
    // FORM — slug auto-generation
    // ═══════════════════════════════════════════════════════════

    public function test_updating_title_en_auto_fills_slug_en(): void
    {
        Livewire::actingAs($this->admin)
            ->test(Form::class)
            ->set('title_en', 'Split Electrical Repair')
            ->assertSet('slug_en', 'split-ac-repair');
    }

    public function test_updating_title_ar_auto_fills_slug_ar(): void
    {
        Livewire::actingAs($this->admin)
            ->test(Form::class)
            ->set('title_ar', 'إصلاح كهرباء')
            ->assertSet('slug_ar', 'إصلاح-كهرباء');
    }

    // ═══════════════════════════════════════════════════════════
    // FORM — validation (unhappy)
    // ═══════════════════════════════════════════════════════════

    public function test_form_fails_without_pillar_id(): void
    {
        Livewire::actingAs($this->admin)
            ->test(Form::class)
            ->set('pillar_id', 0)
            ->set('title_ar',  'تنظيف')
            ->set('title_en',  'Cleaning')
            ->set('slug_ar',   'تنظيف')
            ->set('slug_en',   'cleaning')
            ->set('status',    'active')
            ->call('save')
            ->assertHasErrors(['pillar_id']);
    }

    public function test_form_fails_with_nonexistent_pillar_id(): void
    {
        Livewire::actingAs($this->admin)
            ->test(Form::class)
            ->set('pillar_id', 99999)
            ->set('title_ar',  'تنظيف')
            ->set('title_en',  'Cleaning')
            ->set('slug_ar',   'تنظيف')
            ->set('slug_en',   'cleaning')
            ->set('status',    'active')
            ->call('save')
            ->assertHasErrors(['pillar_id']);
    }

    public function test_form_fails_without_title_ar(): void
    {
        $pillar = $this->makePillar();

        Livewire::actingAs($this->admin)
            ->test(Form::class)
            ->set('pillar_id', $pillar->id)
            ->set('title_ar',  '')
            ->set('title_en',  'Cleaning')
            ->set('slug_ar',   'تنظيف')
            ->set('slug_en',   'cleaning')
            ->set('status',    'active')
            ->call('save')
            ->assertHasErrors(['title_ar' => 'required']);
    }

    public function test_form_fails_without_title_en(): void
    {
        $pillar = $this->makePillar();

        Livewire::actingAs($this->admin)
            ->test(Form::class)
            ->set('pillar_id', $pillar->id)
            ->set('title_ar',  'تنظيف')
            ->set('title_en',  '')
            ->set('slug_ar',   'تنظيف')
            ->set('slug_en',   'cleaning')
            ->set('status',    'active')
            ->call('save')
            ->assertHasErrors(['title_en' => 'required']);
    }

    public function test_form_fails_with_invalid_status(): void
    {
        $pillar = $this->makePillar();

        Livewire::actingAs($this->admin)
            ->test(Form::class)
            ->set('pillar_id', $pillar->id)
            ->set('title_ar',  'تنظيف')
            ->set('title_en',  'Cleaning')
            ->set('slug_ar',   'تنظيف')
            ->set('slug_en',   'cleaning')
            ->set('status',    'unknown')
            ->call('save')
            ->assertHasErrors(['status']);
    }

    public function test_no_cluster_created_when_validation_fails(): void
    {
        $countBefore = Cluster::count();

        Livewire::actingAs($this->admin)
            ->test(Form::class)
            ->set('title_ar', '')
            ->call('save');

        $this->assertSame($countBefore, Cluster::count());
    }
}
