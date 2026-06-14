<?php

namespace Tests\Feature;

use App\Enums\ContactStatus;
use App\Livewire\Admin\Contacts\Index;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminContactsLivewireTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        Role::firstOrCreate(['name' => 'admin']);
        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');
    }

    private function makeContact(array $overrides = []): Contact
    {
        return Contact::create(array_merge([
            'name'   => 'Test User',
            'phone'  => '96512345678',
            'locale' => 'ar',
            'status' => ContactStatus::New,
        ], $overrides));
    }

    // Happy: component renders with contacts listed
    public function test_contacts_index_renders_with_contacts(): void
    {
        $this->makeContact(['name' => 'علي أحمد']);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->assertSee('علي أحمد');
    }

    // Happy: markRead changes status to Read
    public function test_mark_read_updates_contact_status(): void
    {
        $contact = $this->makeContact(['status' => ContactStatus::New]);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->call('markRead', $contact);

        $this->assertEquals(ContactStatus::Read, $contact->fresh()->status);
    }

    // Happy: filter by status=new shows only new contacts
    public function test_filter_by_status_new_shows_only_new_contacts(): void
    {
        $this->makeContact(['name' => 'NewUser', 'status' => ContactStatus::New]);
        $this->makeContact(['name' => 'ReadUser', 'status' => ContactStatus::Read]);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->set('status', 'new')
            ->assertSee('NewUser')
            ->assertDontSee('ReadUser');
    }

    // Happy: filter by locale=en shows only English submissions
    public function test_filter_by_locale_en_shows_only_english_contacts(): void
    {
        $this->makeContact(['name' => 'Arabic User', 'locale' => 'ar']);
        $this->makeContact(['name' => 'English User', 'locale' => 'en']);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->set('locale', 'en')
            ->assertSee('English User')
            ->assertDontSee('Arabic User');
    }

    // Happy: clearing filters shows all contacts
    public function test_clearing_filters_shows_all_contacts(): void
    {
        $this->makeContact(['name' => 'User One', 'locale' => 'ar']);
        $this->makeContact(['name' => 'User Two', 'locale' => 'en']);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->set('locale', '')
            ->set('status', '')
            ->assertSee('User One')
            ->assertSee('User Two');
    }

    // Unhappy: markRead on already-read contact stays read
    public function test_mark_read_on_already_read_contact_stays_read(): void
    {
        $contact = $this->makeContact(['status' => ContactStatus::Read]);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->call('markRead', $contact);

        $this->assertEquals(ContactStatus::Read, $contact->fresh()->status);
    }

    // Unhappy: filter by nonexistent locale shows no contacts
    public function test_filter_by_nonexistent_locale_shows_no_contacts(): void
    {
        $this->makeContact(['name' => 'Arabic User', 'locale' => 'ar']);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->set('locale', 'fr')
            ->assertDontSee('Arabic User');
    }
}
