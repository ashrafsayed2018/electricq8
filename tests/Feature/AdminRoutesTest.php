<?php

namespace Tests\Feature;

use App\Enums\PostStatus;
use App\Enums\ServiceStatus;
use App\Models\Cluster;
use App\Models\Location;
use App\Models\Pillar;
use App\Models\Post;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminRoutesTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $guest;

    protected function setUp(): void
    {
        parent::setUp();

        // Spatie requires roles table — seed the admin role
        $role = Role::create(['name' => 'admin', 'guard_name' => 'web']);

        $this->admin = User::factory()->create();
        $this->admin->assignRole($role);

        $this->guest = User::factory()->create();
    }

    // ── Helpers ───────────────────────────────────────────────────────────

    private function makeLocation(): Location
    {
        return Location::create([
            'name'        => ['ar' => 'حولي',  'en' => 'Hawalli'],
            'slug'        => ['ar' => 'حولي',  'en' => 'hawalli'],
            'governorate' => 'hawalli',
            'is_active'   => true,
            'sort_order'  => 1,
        ]);
    }

    private function makeService(): Service
    {
        return Service::create([
            'title'       => ['ar' => 'تنظيف الكهرباء', 'en' => 'AC Cleaning'],
            'slug'        => ['ar' => 'تنظيف-كهرباء',   'en' => 'ac-cleaning'],
            'h1'          => ['ar' => 'تنظيف الكهرباء', 'en' => 'AC Cleaning'],
            'intro'       => ['ar' => 'وصف مختصر',     'en' => 'Short desc'],
            'content'     => ['ar' => 'محتوى',          'en' => 'Content'],
            'service_type'=> 'general',
            'status'      => ServiceStatus::Active,
            'sort_order'  => 1,
        ]);
    }

    private function makePillar(): Pillar
    {
        return Pillar::create([
            'title'      => ['ar' => 'خدمات الكهرباء', 'en' => 'Electrical Services'],
            'slug'       => ['ar' => 'خدمات-كهرباء',   'en' => 'ac-services'],
            'h1'         => ['ar' => 'خدمات الكهرباء', 'en' => 'Electrical Services'],
            'status'     => 'active',
            'sort_order' => 1,
        ]);
    }

    private function makeCluster(): Cluster
    {
        $pillar = $this->makePillar();
        return Cluster::create([
            'pillar_id'     => $pillar->id,
            'title'         => ['ar' => 'إصلاح الكهرباء', 'en' => 'Electrical Repair'],
            'slug'          => ['ar' => 'إصلاح-كهرباء',   'en' => 'ac-repair'],
            'h1'            => ['ar' => 'إصلاح الكهرباء', 'en' => 'Electrical Repair'],
            'search_intent' => 'commercial',
            'status'        => 'active',
            'sort_order'    => 1,
        ]);
    }

    private function makePost(): Post
    {
        return Post::create([
            'title'      => ['ar' => 'مقال تجريبي', 'en' => 'Test Post'],
            'slug'       => ['ar' => 'مقال-تجريبي', 'en' => 'test-post'],
            'h1'         => ['ar' => 'مقال تجريبي', 'en' => 'Test Post'],
            'status'     => PostStatus::Draft,
            'sort_order' => 1,
        ]);
    }

    // ══════════════════════════════════════════════════════════════════════
    // AUTH GUARD — unauthenticated users redirected to login
    // ══════════════════════════════════════════════════════════════════════

    public function test_unauthenticated_user_redirected_from_dashboard(): void
    {
        $this->get('/admin')->assertRedirect('/login');
    }

    public function test_unauthenticated_user_redirected_from_services(): void
    {
        $this->get('/admin/services')->assertRedirect('/login');
    }

    public function test_unauthenticated_user_redirected_from_areas(): void
    {
        $this->get('/admin/areas')->assertRedirect('/login');
    }

    public function test_unauthenticated_user_redirected_from_posts(): void
    {
        $this->get('/admin/posts')->assertRedirect('/login');
    }

    // ══════════════════════════════════════════════════════════════════════
    // ROLE GUARD — authenticated but non-admin gets 403
    // ══════════════════════════════════════════════════════════════════════

    public function test_non_admin_user_forbidden_from_dashboard(): void
    {
        $this->actingAs($this->guest)->get('/admin')->assertForbidden();
    }

    public function test_non_admin_user_forbidden_from_services(): void
    {
        $this->actingAs($this->guest)->get('/admin/services')->assertForbidden();
    }

    public function test_non_admin_user_forbidden_from_areas(): void
    {
        $this->actingAs($this->guest)->get('/admin/areas')->assertForbidden();
    }

    public function test_non_admin_user_forbidden_from_settings(): void
    {
        $this->actingAs($this->guest)->get('/admin/settings')->assertForbidden();
    }

    // ══════════════════════════════════════════════════════════════════════
    // DASHBOARD
    // ══════════════════════════════════════════════════════════════════════

    public function test_admin_dashboard_returns_200(): void
    {
        $this->actingAs($this->admin)->get('/admin')->assertOk();
    }

    // ══════════════════════════════════════════════════════════════════════
    // AREAS (LOCATIONS)
    // ══════════════════════════════════════════════════════════════════════

    public function test_admin_areas_index_returns_200(): void
    {
        $this->actingAs($this->admin)->get('/admin/areas')->assertOk();
    }

    public function test_admin_areas_create_returns_200(): void
    {
        $this->actingAs($this->admin)->get('/admin/areas/create')->assertOk();
    }

    public function test_admin_areas_edit_returns_200_with_id(): void
    {
        $location = $this->makeLocation();
        $this->actingAs($this->admin)
            ->get("/admin/areas/{$location->id}/edit")
            ->assertOk();
    }

    public function test_admin_areas_edit_returns_404_for_nonexistent_id(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/areas/99999/edit')
            ->assertNotFound();
    }

    public function test_admin_areas_edit_shows_existing_location_name(): void
    {
        $location = $this->makeLocation();
        $this->actingAs($this->admin)
            ->get("/admin/areas/{$location->id}/edit")
            ->assertOk()
            ->assertSee('hawalli', false); // en slug visible in wire:snapshot
    }

    // ══════════════════════════════════════════════════════════════════════
    // SERVICES
    // ══════════════════════════════════════════════════════════════════════

    public function test_admin_services_index_returns_200(): void
    {
        $this->actingAs($this->admin)->get('/admin/services')->assertOk();
    }

    public function test_admin_services_create_returns_200(): void
    {
        $this->actingAs($this->admin)->get('/admin/services/create')->assertOk();
    }

    public function test_admin_services_edit_returns_200_with_id(): void
    {
        $service = $this->makeService();
        $this->actingAs($this->admin)
            ->get("/admin/services/{$service->id}/edit")
            ->assertOk();
    }

    public function test_admin_services_edit_returns_404_for_nonexistent_id(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/services/99999/edit')
            ->assertNotFound();
    }

    public function test_admin_services_edit_shows_existing_service_title(): void
    {
        $service = $this->makeService();
        $this->actingAs($this->admin)
            ->get("/admin/services/{$service->id}/edit")
            ->assertOk()
            ->assertSee('ac-cleaning', false); // en slug visible in wire:snapshot
    }

    // ══════════════════════════════════════════════════════════════════════
    // CLUSTERS
    // ══════════════════════════════════════════════════════════════════════

    public function test_admin_clusters_index_returns_200(): void
    {
        $this->actingAs($this->admin)->get('/admin/clusters')->assertOk();
    }

    public function test_admin_clusters_create_returns_200(): void
    {
        $this->actingAs($this->admin)->get('/admin/clusters/create')->assertOk();
    }

    public function test_admin_clusters_edit_returns_200_with_id(): void
    {
        $cluster = $this->makeCluster();
        $this->actingAs($this->admin)
            ->get("/admin/clusters/{$cluster->id}/edit")
            ->assertOk();
    }

    public function test_admin_clusters_edit_returns_404_for_nonexistent_id(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/clusters/99999/edit')
            ->assertNotFound();
    }

    public function test_admin_clusters_edit_shows_existing_cluster_title(): void
    {
        $cluster = $this->makeCluster();
        $this->actingAs($this->admin)
            ->get("/admin/clusters/{$cluster->id}/edit")
            ->assertOk()
            ->assertSee('ac-repair', false); // en slug visible in wire:snapshot
    }

    // ══════════════════════════════════════════════════════════════════════
    // POSTS
    // ══════════════════════════════════════════════════════════════════════

    public function test_admin_posts_index_returns_200(): void
    {
        $this->actingAs($this->admin)->get('/admin/posts')->assertOk();
    }

    public function test_admin_posts_create_returns_200(): void
    {
        $this->actingAs($this->admin)->get('/admin/posts/create')->assertOk();
    }

    public function test_admin_posts_edit_returns_200_with_id(): void
    {
        $post = $this->makePost();
        $this->actingAs($this->admin)
            ->get("/admin/posts/{$post->id}/edit")
            ->assertOk();
    }

    public function test_admin_posts_edit_returns_404_for_nonexistent_id(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/posts/99999/edit')
            ->assertNotFound();
    }

    public function test_admin_posts_edit_shows_existing_post_title(): void
    {
        $post = $this->makePost();
        $this->actingAs($this->admin)
            ->get("/admin/posts/{$post->id}/edit")
            ->assertOk()
            ->assertSee('test-post', false); // en slug visible in wire:snapshot
    }

    // ══════════════════════════════════════════════════════════════════════
    // CONTACTS
    // ══════════════════════════════════════════════════════════════════════

    public function test_admin_contacts_index_returns_200(): void
    {
        $this->actingAs($this->admin)->get('/admin/contacts')->assertOk();
    }

    public function test_admin_contacts_index_with_ar_locale_returns_200(): void
    {
        $this->actingAs($this->admin)->get('/admin/contacts/ar')->assertOk();
    }

    public function test_admin_contacts_index_with_en_locale_returns_200(): void
    {
        $this->actingAs($this->admin)->get('/admin/contacts/en')->assertOk();
    }

    // ══════════════════════════════════════════════════════════════════════
    // SETTINGS & ANALYTICS
    // ══════════════════════════════════════════════════════════════════════

    public function test_admin_settings_returns_200(): void
    {
        $this->actingAs($this->admin)->get('/admin/settings')->assertOk();
    }

    public function test_admin_analytics_returns_200(): void
    {
        $this->actingAs($this->admin)->get('/admin/analytics')->assertOk();
    }

    // ══════════════════════════════════════════════════════════════════════
    // TESTIMONIALS
    // ══════════════════════════════════════════════════════════════════════

    public function test_admin_testimonials_index_returns_200(): void
    {
        $this->actingAs($this->admin)->get('/admin/testimonials')->assertOk();
    }
}
