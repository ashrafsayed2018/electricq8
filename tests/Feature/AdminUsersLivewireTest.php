<?php

namespace Tests\Feature;

use App\Livewire\Admin\Users\Form;
use App\Livewire\Admin\Users\Index;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminUsersLivewireTest extends TestCase
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

    private function makeUser(array $overrides = []): User
    {
        $user = User::factory()->create(array_merge([
            'name'  => 'Test User',
            'email' => 'testuser@example.com',
        ], $overrides));
        $user->assignRole('admin');
        return $user;
    }

    // ─── Routes: access control ──────────────────────────────

    // Unhappy: guest redirected from users index
    public function test_guest_cannot_access_admin_users_index(): void
    {
        $this->get(route('admin.users.index'))
            ->assertRedirect(route('login'));
    }

    // Unhappy: guest redirected from users create
    public function test_guest_cannot_access_admin_users_create(): void
    {
        $this->get(route('admin.users.create'))
            ->assertRedirect(route('login'));
    }

    // Unhappy: non-admin forbidden from users index
    public function test_non_admin_forbidden_from_users_index(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('admin.users.index'))
            ->assertForbidden();
    }

    // Unhappy: non-admin forbidden from users create
    public function test_non_admin_forbidden_from_users_create(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('admin.users.create'))
            ->assertForbidden();
    }

    // Happy: admin can access users index
    public function test_admin_can_access_users_index(): void
    {
        $this->actingAs($this->admin)
            ->get(route('admin.users.index'))
            ->assertOk();
    }

    // Happy: admin can access users create
    public function test_admin_can_access_users_create(): void
    {
        $this->actingAs($this->admin)
            ->get(route('admin.users.create'))
            ->assertOk();
    }

    // Happy: admin can access users edit
    public function test_admin_can_access_users_edit(): void
    {
        $user = $this->makeUser(['email' => 'edit@example.com']);
        $this->actingAs($this->admin)
            ->get(route('admin.users.edit', $user))
            ->assertOk();
    }

    // Unhappy: edit returns 404 for nonexistent user
    public function test_edit_returns_404_for_nonexistent_user(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/users/99999/edit')
            ->assertNotFound();
    }

    // ─── Index: rendering ────────────────────────────────────

    // Happy: index lists existing users
    public function test_index_renders_existing_users(): void
    {
        $this->makeUser(['name' => 'Jane Doe', 'email' => 'jane@example.com']);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->assertSee('Jane Doe')
            ->assertSee('jane@example.com');
    }

    // Happy: index shows empty state when no other users exist
    public function test_index_shows_empty_state_when_no_users(): void
    {
        // Only the admin exists — delete them temporarily to test empty state
        User::where('id', '!=', $this->admin->id)->delete();

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->assertSee($this->admin->name); // admin still shows
    }

    // Happy: index shows the logged-in admin's own entry
    public function test_index_shows_current_admin(): void
    {
        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->assertSee($this->admin->email);
    }

    // ─── Index: search ───────────────────────────────────────

    // Happy: search by name filters results
    public function test_search_by_name_filters_users(): void
    {
        $this->makeUser(['name' => 'Alice Smith', 'email' => 'alice@example.com']);
        $this->makeUser(['name' => 'Bob Jones',   'email' => 'bob@example.com']);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->set('search', 'Alice')
            ->assertSee('Alice Smith')
            ->assertDontSee('Bob Jones');
    }

    // Happy: search by email filters results
    public function test_search_by_email_filters_users(): void
    {
        $this->makeUser(['name' => 'Alice Smith', 'email' => 'alice@example.com']);
        $this->makeUser(['name' => 'Bob Jones',   'email' => 'bob@example.com']);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->set('search', 'bob@example.com')
            ->assertSee('Bob Jones')
            ->assertDontSee('Alice Smith');
    }

    // Happy: clearing search shows all users
    public function test_clearing_search_shows_all_users(): void
    {
        $this->makeUser(['name' => 'Alice Smith', 'email' => 'alice@example.com']);
        $this->makeUser(['name' => 'Bob Jones',   'email' => 'bob@example.com']);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->set('search', 'Alice')
            ->set('search', '')
            ->assertSee('Alice Smith')
            ->assertSee('Bob Jones');
    }

    // ─── Index: delete ───────────────────────────────────────

    // Happy: admin can delete another user
    public function test_admin_can_delete_another_user(): void
    {
        $user = $this->makeUser(['email' => 'deleteme@example.com']);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->call('delete', $user);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    // Unhappy: admin cannot delete themselves
    public function test_admin_cannot_delete_themselves(): void
    {
        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->call('delete', $this->admin);

        $this->assertDatabaseHas('users', ['id' => $this->admin->id]);
    }

    // Happy: deleting one user does not affect others
    public function test_deleting_one_user_leaves_others_intact(): void
    {
        $first  = $this->makeUser(['email' => 'first@example.com']);
        $second = $this->makeUser(['email' => 'second@example.com']);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->call('delete', $first);

        $this->assertDatabaseMissing('users', ['id' => $first->id]);
        $this->assertDatabaseHas('users',    ['id' => $second->id]);
    }

    // ─── Form: rendering ─────────────────────────────────────

    // Happy: create form renders correctly
    public function test_create_form_renders(): void
    {
        Livewire::actingAs($this->admin)
            ->test(Form::class)
            ->assertSee('إنشاء المستخدم');
    }

    // Happy: edit form pre-fills fields from existing user
    public function test_edit_form_prefills_existing_user_fields(): void
    {
        $user = $this->makeUser(['name' => 'Prefilled User', 'email' => 'prefilled@example.com']);

        Livewire::actingAs($this->admin)
            ->test(Form::class, ['user' => $user])
            ->assertSet('name',  'Prefilled User')
            ->assertSet('email', 'prefilled@example.com')
            ->assertSet('role',  'admin');
    }

    // Happy: edit form shows "حفظ التعديلات" button
    public function test_edit_form_shows_save_button(): void
    {
        $user = $this->makeUser(['email' => 'edit2@example.com']);

        Livewire::actingAs($this->admin)
            ->test(Form::class, ['user' => $user])
            ->assertSee('حفظ التعديلات');
    }

    // ─── Form: create ────────────────────────────────────────

    // Happy: valid submission creates user and redirects
    public function test_valid_form_creates_user_and_redirects(): void
    {
        Livewire::actingAs($this->admin)
            ->test(Form::class)
            ->set('name',     'New Admin')
            ->set('email',    'newadmin@example.com')
            ->set('password', 'secret1234')
            ->set('role',     'admin')
            ->call('save')
            ->assertRedirect(route('admin.users.index'));

        $this->assertDatabaseHas('users', ['email' => 'newadmin@example.com']);
    }

    // Happy: created user is assigned the admin role
    public function test_created_user_has_admin_role(): void
    {
        Livewire::actingAs($this->admin)
            ->test(Form::class)
            ->set('name',     'Role Test')
            ->set('email',    'roletest@example.com')
            ->set('password', 'secret1234')
            ->set('role',     'admin')
            ->call('save');

        $user = User::where('email', 'roletest@example.com')->first();
        $this->assertTrue($user->hasRole('admin'));
    }

    // ─── Form: update ────────────────────────────────────────

    // Happy: valid submission updates existing user
    public function test_valid_form_updates_existing_user(): void
    {
        $user = $this->makeUser(['name' => 'Old Name', 'email' => 'old@example.com']);

        Livewire::actingAs($this->admin)
            ->test(Form::class, ['user' => $user])
            ->set('name',  'New Name')
            ->set('email', 'new@example.com')
            ->call('save');

        $this->assertDatabaseHas('users', ['id' => $user->id, 'name' => 'New Name', 'email' => 'new@example.com']);
    }

    // Happy: password is not changed when left blank on edit
    public function test_password_unchanged_when_blank_on_edit(): void
    {
        $user = $this->makeUser(['email' => 'nopasschange@example.com']);
        $originalHash = $user->password;

        Livewire::actingAs($this->admin)
            ->test(Form::class, ['user' => $user])
            ->set('name',     'Same User')
            ->set('password', '')
            ->call('save');

        $this->assertSame($originalHash, $user->fresh()->password);
    }

    // Happy: password is updated when provided on edit
    public function test_password_updated_when_provided_on_edit(): void
    {
        $user = $this->makeUser(['email' => 'passchange@example.com']);
        $originalHash = $user->password;

        Livewire::actingAs($this->admin)
            ->test(Form::class, ['user' => $user])
            ->set('password', 'newpassword123')
            ->call('save');

        $this->assertNotSame($originalHash, $user->fresh()->password);
    }

    // ─── Form: validation ────────────────────────────────────

    // Unhappy: missing name fails validation
    public function test_form_fails_validation_without_name(): void
    {
        Livewire::actingAs($this->admin)
            ->test(Form::class)
            ->set('name',     '')
            ->set('email',    'valid@example.com')
            ->set('password', 'secret1234')
            ->call('save')
            ->assertHasErrors(['name' => 'required']);
    }

    // Unhappy: missing email fails validation
    public function test_form_fails_validation_without_email(): void
    {
        Livewire::actingAs($this->admin)
            ->test(Form::class)
            ->set('name',     'Some Name')
            ->set('email',    '')
            ->set('password', 'secret1234')
            ->call('save')
            ->assertHasErrors(['email' => 'required']);
    }

    // Unhappy: invalid email format fails validation
    public function test_form_fails_validation_with_invalid_email(): void
    {
        Livewire::actingAs($this->admin)
            ->test(Form::class)
            ->set('name',     'Some Name')
            ->set('email',    'not-an-email')
            ->set('password', 'secret1234')
            ->call('save')
            ->assertHasErrors(['email' => 'email']);
    }

    // Unhappy: duplicate email fails validation on create
    public function test_form_fails_validation_with_duplicate_email(): void
    {
        $this->makeUser(['email' => 'duplicate@example.com']);

        Livewire::actingAs($this->admin)
            ->test(Form::class)
            ->set('name',     'Another User')
            ->set('email',    'duplicate@example.com')
            ->set('password', 'secret1234')
            ->call('save')
            ->assertHasErrors(['email' => 'unique']);
    }

    // Happy: duplicate email is allowed on edit for same user
    public function test_form_allows_same_email_on_edit(): void
    {
        $user = $this->makeUser(['email' => 'sameemail@example.com']);

        Livewire::actingAs($this->admin)
            ->test(Form::class, ['user' => $user])
            ->set('name',  'Updated Name')
            ->set('email', 'sameemail@example.com')
            ->call('save')
            ->assertHasNoErrors();
    }

    // Unhappy: missing password fails validation on create
    public function test_form_fails_validation_without_password_on_create(): void
    {
        Livewire::actingAs($this->admin)
            ->test(Form::class)
            ->set('name',     'Some Name')
            ->set('email',    'valid@example.com')
            ->set('password', '')
            ->call('save')
            ->assertHasErrors(['password' => 'required']);
    }

    // Unhappy: short password fails validation
    public function test_form_fails_validation_with_short_password(): void
    {
        Livewire::actingAs($this->admin)
            ->test(Form::class)
            ->set('name',     'Some Name')
            ->set('email',    'valid@example.com')
            ->set('password', 'short')
            ->call('save')
            ->assertHasErrors(['password' => 'min']);
    }

    // Unhappy: no user created when validation fails
    public function test_no_user_created_when_validation_fails(): void
    {
        $countBefore = User::count();

        Livewire::actingAs($this->admin)
            ->test(Form::class)
            ->set('name', '')
            ->call('save');

        $this->assertSame($countBefore, User::count());
    }
}
