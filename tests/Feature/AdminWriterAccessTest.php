<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

/**
 * Covers every admin route with three actors:
 *   - guest      → redirected to login
 *   - writer     → shared routes OK; admin-only routes 403
 *   - admin      → full access everywhere
 *
 * Writer permission matrix:
 *   - no permission           → 403 on all post routes
 *   - posts.create only       → 200 on /posts/create, 403 on list
 *   - posts.index only        → 200 on /posts list, 403 on create
 *   - multiple permissions    → each unlocked independently
 *   - all post permissions    → still 403 on non-post admin routes
 */
class AdminWriterAccessTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $writer;
    private User $noRole;

    private array $adminOnlyRoutes = [
        'admin.contacts.index',
        'admin.clusters.index',
        'admin.clusters.create',
        'admin.services.index',
        'admin.services.create',
        'admin.areas.index',
        'admin.areas.create',
        'admin.testimonials.index',
        'admin.gallery.index',
        'admin.users.index',
        'admin.users.create',
        'admin.roles.index',
        'admin.roles.create',
        'admin.permissions.index',
        'admin.permissions.create',
        'admin.settings',
    ];

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

        $this->noRole = User::factory()->create();
    }

    // ════════════════════════════════════════════════════════════
    // GUEST — redirected to login on every admin route
    // ════════════════════════════════════════════════════════════

    public function test_guest_redirected_from_dashboard(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
    }

    public function test_guest_redirected_from_analytics(): void
    {
        $this->get(route('admin.analytics'))->assertRedirect(route('login'));
    }

    public function test_guest_redirected_from_contacts(): void
    {
        $this->get(route('admin.contacts.index'))->assertRedirect(route('login'));
    }

    public function test_guest_redirected_from_clusters_index(): void
    {
        $this->get(route('admin.clusters.index'))->assertRedirect(route('login'));
    }

    public function test_guest_redirected_from_clusters_create(): void
    {
        $this->get(route('admin.clusters.create'))->assertRedirect(route('login'));
    }

    public function test_guest_redirected_from_services_index(): void
    {
        $this->get(route('admin.services.index'))->assertRedirect(route('login'));
    }

    public function test_guest_redirected_from_services_create(): void
    {
        $this->get(route('admin.services.create'))->assertRedirect(route('login'));
    }

    public function test_guest_redirected_from_areas_index(): void
    {
        $this->get(route('admin.areas.index'))->assertRedirect(route('login'));
    }

    public function test_guest_redirected_from_areas_create(): void
    {
        $this->get(route('admin.areas.create'))->assertRedirect(route('login'));
    }

    public function test_guest_redirected_from_testimonials(): void
    {
        $this->get(route('admin.testimonials.index'))->assertRedirect(route('login'));
    }

    public function test_guest_redirected_from_gallery(): void
    {
        $this->get(route('admin.gallery.index'))->assertRedirect(route('login'));
    }

    public function test_guest_redirected_from_users_index(): void
    {
        $this->get(route('admin.users.index'))->assertRedirect(route('login'));
    }

    public function test_guest_redirected_from_users_create(): void
    {
        $this->get(route('admin.users.create'))->assertRedirect(route('login'));
    }

    public function test_guest_redirected_from_roles_index(): void
    {
        $this->get(route('admin.roles.index'))->assertRedirect(route('login'));
    }

    public function test_guest_redirected_from_roles_create(): void
    {
        $this->get(route('admin.roles.create'))->assertRedirect(route('login'));
    }

    public function test_guest_redirected_from_permissions_index(): void
    {
        $this->get(route('admin.permissions.index'))->assertRedirect(route('login'));
    }

    public function test_guest_redirected_from_permissions_create(): void
    {
        $this->get(route('admin.permissions.create'))->assertRedirect(route('login'));
    }

    public function test_guest_redirected_from_settings(): void
    {
        $this->get(route('admin.settings'))->assertRedirect(route('login'));
    }

    public function test_guest_redirected_from_posts_index(): void
    {
        $this->get(route('admin.posts.index'))->assertRedirect(route('login'));
    }

    public function test_guest_redirected_from_posts_create(): void
    {
        $this->get(route('admin.posts.create'))->assertRedirect(route('login'));
    }

    // ════════════════════════════════════════════════════════════
    // USER WITH NO ROLE — forbidden from all admin routes
    // ════════════════════════════════════════════════════════════

    public function test_user_without_role_forbidden_from_dashboard(): void
    {
        $this->actingAs($this->noRole)->get(route('admin.dashboard'))->assertForbidden();
    }

    public function test_user_without_role_forbidden_from_all_admin_only_routes(): void
    {
        foreach ($this->adminOnlyRoutes as $routeName) {
            $this->actingAs($this->noRole)
                ->get(route($routeName))
                ->assertForbidden("route: $routeName");
        }
    }

    public function test_user_without_role_forbidden_from_posts_create(): void
    {
        $this->actingAs($this->noRole)->get(route('admin.posts.create'))->assertForbidden();
    }

    // ════════════════════════════════════════════════════════════
    // WRITER — shared routes accessible
    // ════════════════════════════════════════════════════════════

    public function test_writer_can_access_dashboard(): void
    {
        $this->actingAs($this->writer)->get(route('admin.dashboard'))->assertOk();
    }

    public function test_writer_can_access_analytics(): void
    {
        $this->actingAs($this->writer)->get(route('admin.analytics'))->assertOk();
    }

    // ════════════════════════════════════════════════════════════
    // WRITER — blocked from all admin-only routes
    // ════════════════════════════════════════════════════════════

    public function test_writer_forbidden_from_contacts(): void
    {
        $this->actingAs($this->writer)->get(route('admin.contacts.index'))->assertForbidden();
    }

    public function test_writer_forbidden_from_clusters_index(): void
    {
        $this->actingAs($this->writer)->get(route('admin.clusters.index'))->assertForbidden();
    }

    public function test_writer_forbidden_from_clusters_create(): void
    {
        $this->actingAs($this->writer)->get(route('admin.clusters.create'))->assertForbidden();
    }

    public function test_writer_forbidden_from_services_index(): void
    {
        $this->actingAs($this->writer)->get(route('admin.services.index'))->assertForbidden();
    }

    public function test_writer_forbidden_from_services_create(): void
    {
        $this->actingAs($this->writer)->get(route('admin.services.create'))->assertForbidden();
    }

    public function test_writer_forbidden_from_areas_index(): void
    {
        $this->actingAs($this->writer)->get(route('admin.areas.index'))->assertForbidden();
    }

    public function test_writer_forbidden_from_areas_create(): void
    {
        $this->actingAs($this->writer)->get(route('admin.areas.create'))->assertForbidden();
    }

    public function test_writer_forbidden_from_testimonials(): void
    {
        $this->actingAs($this->writer)->get(route('admin.testimonials.index'))->assertForbidden();
    }

    public function test_writer_forbidden_from_gallery(): void
    {
        $this->actingAs($this->writer)->get(route('admin.gallery.index'))->assertForbidden();
    }

    public function test_writer_forbidden_from_users_index(): void
    {
        $this->actingAs($this->writer)->get(route('admin.users.index'))->assertForbidden();
    }

    public function test_writer_forbidden_from_users_create(): void
    {
        $this->actingAs($this->writer)->get(route('admin.users.create'))->assertForbidden();
    }

    public function test_writer_forbidden_from_roles_index(): void
    {
        $this->actingAs($this->writer)->get(route('admin.roles.index'))->assertForbidden();
    }

    public function test_writer_forbidden_from_roles_create(): void
    {
        $this->actingAs($this->writer)->get(route('admin.roles.create'))->assertForbidden();
    }

    public function test_writer_forbidden_from_permissions_index(): void
    {
        $this->actingAs($this->writer)->get(route('admin.permissions.index'))->assertForbidden();
    }

    public function test_writer_forbidden_from_permissions_create(): void
    {
        $this->actingAs($this->writer)->get(route('admin.permissions.create'))->assertForbidden();
    }

    public function test_writer_forbidden_from_settings(): void
    {
        $this->actingAs($this->writer)->get(route('admin.settings'))->assertForbidden();
    }

    // ════════════════════════════════════════════════════════════
    // WRITER — posts routes require specific permissions
    // ════════════════════════════════════════════════════════════

    public function test_writer_without_permissions_forbidden_from_posts_index(): void
    {
        $this->actingAs($this->writer)->get(route('admin.posts.index'))->assertForbidden();
    }

    public function test_writer_without_permissions_forbidden_from_posts_create(): void
    {
        $this->actingAs($this->writer)->get(route('admin.posts.create'))->assertForbidden();
    }

    public function test_writer_with_posts_create_can_access_posts_create(): void
    {
        $this->giveWriterPermission('posts.create');

        $this->actingAs($this->writer)->get(route('admin.posts.create'))->assertOk();
    }

    public function test_writer_with_posts_create_still_forbidden_from_posts_index(): void
    {
        $this->giveWriterPermission('posts.create');

        $this->actingAs($this->writer)->get(route('admin.posts.index'))->assertForbidden();
    }

    public function test_writer_with_posts_index_can_access_posts_list(): void
    {
        $this->giveWriterPermission('posts.index');

        $this->actingAs($this->writer)->get(route('admin.posts.index'))->assertOk();
    }

    public function test_writer_with_posts_index_still_forbidden_from_posts_create(): void
    {
        $this->giveWriterPermission('posts.index');

        $this->actingAs($this->writer)->get(route('admin.posts.create'))->assertForbidden();
    }

    public function test_writer_with_both_post_permissions_can_access_both_routes(): void
    {
        $this->giveWriterPermission('posts.index');
        $this->giveWriterPermission('posts.create');

        $this->actingAs($this->writer)->get(route('admin.posts.index'))->assertOk();
        $this->actingAs($this->writer)->get(route('admin.posts.create'))->assertOk();
    }

    public function test_writer_with_all_post_permissions_still_forbidden_from_admin_only_routes(): void
    {
        foreach (['posts.index', 'posts.create', 'posts.edit', 'posts.delete'] as $perm) {
            $this->giveWriterPermission($perm);
        }

        $this->actingAs($this->writer)->get(route('admin.users.index'))->assertForbidden();
        $this->actingAs($this->writer)->get(route('admin.roles.index'))->assertForbidden();
        $this->actingAs($this->writer)->get(route('admin.settings'))->assertForbidden();
    }

    // ════════════════════════════════════════════════════════════
    // ADMIN — full access to every route
    // ════════════════════════════════════════════════════════════

    public function test_admin_can_access_dashboard(): void
    {
        $this->actingAs($this->admin)->get(route('admin.dashboard'))->assertOk();
    }

    public function test_admin_can_access_analytics(): void
    {
        $this->actingAs($this->admin)->get(route('admin.analytics'))->assertOk();
    }

    public function test_admin_can_access_contacts(): void
    {
        $this->actingAs($this->admin)->get(route('admin.contacts.index'))->assertOk();
    }

    public function test_admin_can_access_clusters_index(): void
    {
        $this->actingAs($this->admin)->get(route('admin.clusters.index'))->assertOk();
    }

    public function test_admin_can_access_clusters_create(): void
    {
        $this->actingAs($this->admin)->get(route('admin.clusters.create'))->assertOk();
    }

    public function test_admin_can_access_services_index(): void
    {
        $this->actingAs($this->admin)->get(route('admin.services.index'))->assertOk();
    }

    public function test_admin_can_access_services_create(): void
    {
        $this->actingAs($this->admin)->get(route('admin.services.create'))->assertOk();
    }

    public function test_admin_can_access_areas_index(): void
    {
        $this->actingAs($this->admin)->get(route('admin.areas.index'))->assertOk();
    }

    public function test_admin_can_access_areas_create(): void
    {
        $this->actingAs($this->admin)->get(route('admin.areas.create'))->assertOk();
    }

    public function test_admin_can_access_testimonials(): void
    {
        $this->actingAs($this->admin)->get(route('admin.testimonials.index'))->assertOk();
    }

    public function test_admin_can_access_gallery(): void
    {
        $this->actingAs($this->admin)->get(route('admin.gallery.index'))->assertOk();
    }

    public function test_admin_can_access_users_index(): void
    {
        $this->actingAs($this->admin)->get(route('admin.users.index'))->assertOk();
    }

    public function test_admin_can_access_users_create(): void
    {
        $this->actingAs($this->admin)->get(route('admin.users.create'))->assertOk();
    }

    public function test_admin_can_access_roles_index(): void
    {
        $this->actingAs($this->admin)->get(route('admin.roles.index'))->assertOk();
    }

    public function test_admin_can_access_roles_create(): void
    {
        $this->actingAs($this->admin)->get(route('admin.roles.create'))->assertOk();
    }

    public function test_admin_can_access_permissions_index(): void
    {
        $this->actingAs($this->admin)->get(route('admin.permissions.index'))->assertOk();
    }

    public function test_admin_can_access_permissions_create(): void
    {
        $this->actingAs($this->admin)->get(route('admin.permissions.create'))->assertOk();
    }

    public function test_admin_can_access_settings(): void
    {
        $this->actingAs($this->admin)->get(route('admin.settings'))->assertOk();
    }

    public function test_admin_can_access_posts_index_without_explicit_permission(): void
    {
        $this->actingAs($this->admin)->get(route('admin.posts.index'))->assertOk();
    }

    public function test_admin_can_access_posts_create_without_explicit_permission(): void
    {
        $this->actingAs($this->admin)->get(route('admin.posts.create'))->assertOk();
    }

    // ════════════════════════════════════════════════════════════
    // ROLE CHANGES — take effect immediately
    // ════════════════════════════════════════════════════════════

    public function test_admin_who_loses_role_is_immediately_forbidden(): void
    {
        $this->actingAs($this->admin)->get(route('admin.users.index'))->assertOk();

        $this->admin->removeRole('admin');
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $this->actingAs($this->admin)->get(route('admin.users.index'))->assertForbidden();
    }

    public function test_writer_who_gains_admin_role_can_access_admin_only_routes(): void
    {
        $this->actingAs($this->writer)->get(route('admin.users.index'))->assertForbidden();

        $this->writer->assignRole('admin');
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $this->actingAs($this->writer)->get(route('admin.users.index'))->assertOk();
    }

    public function test_writer_permission_revocation_removes_access(): void
    {
        $this->giveWriterPermission('posts.create');
        $this->actingAs($this->writer)->get(route('admin.posts.create'))->assertOk();

        $this->writer->revokePermissionTo('posts.create');
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $this->actingAs($this->writer)->get(route('admin.posts.create'))->assertForbidden();
    }

    // ════════════════════════════════════════════════════════════
    // Helper
    // ════════════════════════════════════════════════════════════

    private function giveWriterPermission(string $name): void
    {
        $perm = Permission::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
        $this->writer->givePermissionTo($perm);
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
