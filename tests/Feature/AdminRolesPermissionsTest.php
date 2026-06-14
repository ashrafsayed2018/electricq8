<?php

namespace Tests\Feature;

use App\Livewire\Admin\Permissions\Form as PermissionForm;
use App\Livewire\Admin\Permissions\Index as PermissionIndex;
use App\Livewire\Admin\Roles\Form as RoleForm;
use App\Livewire\Admin\Roles\Index as RoleIndex;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminRolesPermissionsTest extends TestCase
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
    // ROLES — Route access control (unhappy)
    // ═══════════════════════════════════════════════════════════

    public function test_guest_cannot_access_roles_index(): void
    {
        $this->get(route('admin.roles.index'))
            ->assertRedirect(route('login'));
    }

    public function test_guest_cannot_access_roles_create(): void
    {
        $this->get(route('admin.roles.create'))
            ->assertRedirect(route('login'));
    }

    public function test_writer_cannot_access_roles_index(): void
    {
        $this->actingAs($this->writer)
            ->get(route('admin.roles.index'))
            ->assertForbidden();
    }

    public function test_writer_cannot_access_roles_create(): void
    {
        $this->actingAs($this->writer)
            ->get(route('admin.roles.create'))
            ->assertForbidden();
    }

    public function test_writer_cannot_access_roles_edit(): void
    {
        $role = Role::where('name', 'writer')->first();
        $this->actingAs($this->writer)
            ->get(route('admin.roles.edit', $role))
            ->assertForbidden();
    }

    // ═══════════════════════════════════════════════════════════
    // PERMISSIONS — Route access control (unhappy)
    // ═══════════════════════════════════════════════════════════

    public function test_guest_cannot_access_permissions_index(): void
    {
        $this->get(route('admin.permissions.index'))
            ->assertRedirect(route('login'));
    }

    public function test_guest_cannot_access_permissions_create(): void
    {
        $this->get(route('admin.permissions.create'))
            ->assertRedirect(route('login'));
    }

    public function test_writer_cannot_access_permissions_index(): void
    {
        $this->actingAs($this->writer)
            ->get(route('admin.permissions.index'))
            ->assertForbidden();
    }

    public function test_writer_cannot_access_permissions_create(): void
    {
        $this->actingAs($this->writer)
            ->get(route('admin.permissions.create'))
            ->assertForbidden();
    }

    // ═══════════════════════════════════════════════════════════
    // ROLES — Livewire component authorization (unhappy)
    // ═══════════════════════════════════════════════════════════

    public function test_writer_cannot_call_role_delete(): void
    {
        $role = Role::where('name', 'writer')->first();

        Livewire::actingAs($this->writer)
            ->test(RoleIndex::class)
            ->call('delete', $role->id)
            ->assertForbidden();
    }

    public function test_writer_cannot_save_new_role(): void
    {
        Livewire::actingAs($this->writer)
            ->test(RoleForm::class)
            ->set('name', 'hacker')
            ->call('save')
            ->assertForbidden();
    }

    // ═══════════════════════════════════════════════════════════
    // PERMISSIONS — Livewire component authorization (unhappy)
    // ═══════════════════════════════════════════════════════════

    public function test_writer_cannot_call_permission_delete(): void
    {
        $perm = Permission::firstOrCreate(['name' => 'posts.create', 'guard_name' => 'web']);

        Livewire::actingAs($this->writer)
            ->test(PermissionIndex::class)
            ->call('delete', $perm->id)
            ->assertForbidden();
    }

    public function test_writer_cannot_save_new_permission(): void
    {
        Livewire::actingAs($this->writer)
            ->test(PermissionForm::class)
            ->set('name', 'posts.destroy')
            ->call('save')
            ->assertForbidden();
    }

    // ═══════════════════════════════════════════════════════════
    // ROLES — Validation (unhappy)
    // ═══════════════════════════════════════════════════════════

    public function test_role_name_is_required(): void
    {
        Livewire::actingAs($this->admin)
            ->test(RoleForm::class)
            ->set('name', '')
            ->call('save')
            ->assertHasErrors(['name' => 'required']);
    }

    public function test_role_name_must_be_unique(): void
    {
        Livewire::actingAs($this->admin)
            ->test(RoleForm::class)
            ->set('name', 'admin')
            ->call('save')
            ->assertHasErrors(['name' => 'unique']);
    }

    public function test_role_name_max_100_characters(): void
    {
        Livewire::actingAs($this->admin)
            ->test(RoleForm::class)
            ->set('name', str_repeat('a', 101))
            ->call('save')
            ->assertHasErrors(['name' => 'max']);
    }

    public function test_role_permission_must_exist(): void
    {
        Livewire::actingAs($this->admin)
            ->test(RoleForm::class)
            ->set('name', 'testrole')
            ->set('selectedPermissions', ['nonexistent.permission'])
            ->call('save')
            ->assertHasErrors(['selectedPermissions.*']);
    }

    // ═══════════════════════════════════════════════════════════
    // PERMISSIONS — Validation (unhappy)
    // ═══════════════════════════════════════════════════════════

    public function test_permission_name_is_required(): void
    {
        Livewire::actingAs($this->admin)
            ->test(PermissionForm::class)
            ->set('name', '')
            ->call('save')
            ->assertHasErrors(['name' => 'required']);
    }

    public function test_permission_name_must_be_unique(): void
    {
        Permission::firstOrCreate(['name' => 'posts.create', 'guard_name' => 'web']);

        Livewire::actingAs($this->admin)
            ->test(PermissionForm::class)
            ->set('name', 'posts.create')
            ->call('save')
            ->assertHasErrors(['name' => 'unique']);
    }

    public function test_permission_name_max_100_characters(): void
    {
        Livewire::actingAs($this->admin)
            ->test(PermissionForm::class)
            ->set('name', str_repeat('a', 101))
            ->call('save')
            ->assertHasErrors(['name' => 'max']);
    }

    // ═══════════════════════════════════════════════════════════
    // ROLES — Business rules (unhappy)
    // ═══════════════════════════════════════════════════════════

    public function test_admin_role_cannot_be_deleted(): void
    {
        $adminRole = Role::where('name', 'admin')->first();

        Livewire::actingAs($this->admin)
            ->test(RoleIndex::class)
            ->call('delete', $adminRole->id);

        $this->assertDatabaseHas('roles', ['name' => 'admin']);
    }

    public function test_deleting_nonexistent_role_returns_404(): void
    {
        Livewire::actingAs($this->admin)
            ->test(RoleIndex::class)
            ->call('delete', 99999)
            ->assertNotFound();
    }

    public function test_edit_nonexistent_role_returns_404(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/roles/99999/edit')
            ->assertNotFound();
    }

    public function test_edit_nonexistent_permission_returns_404(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/permissions/99999/edit')
            ->assertNotFound();
    }

    // ═══════════════════════════════════════════════════════════
    // ROLES — Happy paths (admin can do everything)
    // ═══════════════════════════════════════════════════════════

    public function test_admin_can_create_role_with_permissions(): void
    {
        $perm = Permission::firstOrCreate(['name' => 'posts.create', 'guard_name' => 'web']);

        Livewire::actingAs($this->admin)
            ->test(RoleForm::class)
            ->set('name', 'editor')
            ->set('selectedPermissions', ['posts.create'])
            ->call('save')
            ->assertRedirect(route('admin.roles.index'));

        $role = Role::where('name', 'editor')->first();
        $this->assertNotNull($role);
        $this->assertTrue($role->hasPermissionTo('posts.create'));
    }

    public function test_admin_can_delete_non_admin_role(): void
    {
        $role = Role::where('name', 'writer')->first();

        Livewire::actingAs($this->admin)
            ->test(RoleIndex::class)
            ->call('delete', $role->id);

        $this->assertDatabaseMissing('roles', ['name' => 'writer']);
    }

    public function test_admin_can_create_permission(): void
    {
        Livewire::actingAs($this->admin)
            ->test(PermissionForm::class)
            ->set('name', 'posts.delete')
            ->call('save')
            ->assertRedirect(route('admin.permissions.index'));

        $this->assertDatabaseHas('permissions', ['name' => 'posts.delete']);
    }

    public function test_admin_can_edit_permission_name(): void
    {
        $perm = Permission::firstOrCreate(['name' => 'posts.old', 'guard_name' => 'web']);

        Livewire::actingAs($this->admin)
            ->test(PermissionForm::class, ['permission' => $perm])
            ->set('name', 'posts.new')
            ->call('save')
            ->assertRedirect(route('admin.permissions.index'));

        $this->assertDatabaseHas('permissions',    ['name' => 'posts.new']);
        $this->assertDatabaseMissing('permissions', ['name' => 'posts.old']);
    }

    // ═══════════════════════════════════════════════════════════
    // PERMISSION ENFORCEMENT — writer role restricted to their permissions
    // ═══════════════════════════════════════════════════════════

    public function test_writer_with_posts_create_permission_can_access_posts_create(): void
    {
        $perm = Permission::firstOrCreate(['name' => 'posts.create', 'guard_name' => 'web']);
        $this->writer->givePermissionTo($perm);
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $this->actingAs($this->writer)
            ->get(route('admin.posts.create'))
            ->assertOk();
    }

    public function test_writer_without_posts_create_permission_cannot_access_posts_create(): void
    {
        $this->actingAs($this->writer)
            ->get(route('admin.posts.create'))
            ->assertForbidden();
    }

    public function test_writer_cannot_access_users_section(): void
    {
        $this->actingAs($this->writer)
            ->get(route('admin.users.index'))
            ->assertForbidden();
    }

    public function test_writer_cannot_access_settings(): void
    {
        $this->actingAs($this->writer)
            ->get(route('admin.settings'))
            ->assertForbidden();
    }
}
