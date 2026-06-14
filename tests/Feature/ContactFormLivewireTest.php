<?php

namespace Tests\Feature;

use App\Enums\ContactStatus;
use App\Enums\ServiceStatus;
use App\Livewire\ContactForm;
use App\Models\Contact;
use App\Models\Location;
use App\Models\Service;
use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ContactFormLivewireTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        SiteSetting::create(['key' => 'whatsapp_number', 'value' => '96512345678', 'group' => 'contact']);
    }

    // Happy: form renders correctly
    public function test_contact_form_renders(): void
    {
        Livewire::test(ContactForm::class)
            ->assertStatus(200);
    }

    // Happy: valid submission creates contact and shows success
    public function test_valid_submission_creates_contact_and_shows_success(): void
    {
        Livewire::test(ContactForm::class)
            ->set('name', 'علي أحمد')
            ->set('phone', '96512345678')
            ->call('send')
            ->assertSet('submitted', true);

        $this->assertDatabaseHas('contacts', [
            'name'  => 'علي أحمد',
            'phone' => '96512345678',
        ]);
    }

    // Happy: submission with optional fields stores them correctly
    public function test_submission_with_optional_fields_stores_them(): void
    {
        $service = Service::create([
            'title'  => ['ar' => 'أ', 'en' => 'A'],
            'slug'   => ['ar' => 'ا', 'en' => 'a'],
            'h1'     => ['ar' => 'أ', 'en' => 'A'],
            'status' => ServiceStatus::Active,
        ]);
        $location = Location::create([
            'name'        => ['ar' => 'حولي', 'en' => 'Hawalli'],
            'slug'        => ['ar' => 'حولي', 'en' => 'hawalli'],
            'governorate' => 'hawalli',
        ]);

        Livewire::test(ContactForm::class)
            ->set('name', 'John Doe')
            ->set('phone', '96512345678')
            ->set('email', 'john@example.com')
            ->set('service_id', (string) $service->id)
            ->set('location_id', (string) $location->id)
            ->set('message', 'I need help with my AC.')
            ->call('send')
            ->assertSet('submitted', true);

        $this->assertDatabaseHas('contacts', [
            'email'       => 'john@example.com',
            'service_id'  => $service->id,
            'location_id' => $location->id,
        ]);
    }

    // Happy: contact status defaults to 'new'
    public function test_new_contact_has_status_new(): void
    {
        Livewire::test(ContactForm::class)
            ->set('name', 'Test User')
            ->set('phone', '96512345678')
            ->call('send');

        $contact = Contact::first();
        $this->assertEquals(ContactStatus::New, $contact->status);
    }

    // Happy: after send, fields are reset
    public function test_fields_are_reset_after_successful_submission(): void
    {
        Livewire::test(ContactForm::class)
            ->set('name', 'Test')
            ->set('phone', '96512345678')
            ->call('send')
            ->assertSet('name', '')
            ->assertSet('phone', '');
    }

    // Unhappy: name is required
    public function test_name_is_required(): void
    {
        Livewire::test(ContactForm::class)
            ->set('name', '')
            ->set('phone', '96512345678')
            ->call('send')
            ->assertHasErrors(['name' => 'required']);
    }

    // Unhappy: name must be at least 2 characters
    public function test_name_must_be_at_least_2_characters(): void
    {
        Livewire::test(ContactForm::class)
            ->set('name', 'A')
            ->set('phone', '96512345678')
            ->call('send')
            ->assertHasErrors(['name']);
    }

    // Unhappy: phone is required
    public function test_phone_is_required(): void
    {
        Livewire::test(ContactForm::class)
            ->set('name', 'Valid Name')
            ->set('phone', '')
            ->call('send')
            ->assertHasErrors(['phone' => 'required']);
    }

    // Unhappy: phone must match regex (letters not allowed)
    public function test_phone_must_match_regex(): void
    {
        Livewire::test(ContactForm::class)
            ->set('name', 'Valid Name')
            ->set('phone', 'not-a-phone')
            ->call('send')
            ->assertHasErrors(['phone']);
    }

    // Unhappy: invalid email format fails validation
    public function test_invalid_email_fails_validation(): void
    {
        Livewire::test(ContactForm::class)
            ->set('name', 'Valid Name')
            ->set('phone', '96512345678')
            ->set('email', 'not-an-email')
            ->call('send')
            ->assertHasErrors(['email']);
    }

    // Unhappy: non-existent service_id fails validation
    public function test_nonexistent_service_id_fails_validation(): void
    {
        Livewire::test(ContactForm::class)
            ->set('name', 'Valid Name')
            ->set('phone', '96512345678')
            ->set('service_id', '9999')
            ->call('send')
            ->assertHasErrors(['service_id']);
    }

    // Unhappy: message exceeding 500 chars fails validation
    public function test_message_exceeding_500_chars_fails_validation(): void
    {
        Livewire::test(ContactForm::class)
            ->set('name', 'Valid Name')
            ->set('phone', '96512345678')
            ->set('message', str_repeat('a', 501))
            ->call('send')
            ->assertHasErrors(['message']);
    }

    // Unhappy: no contact created on validation failure
    public function test_no_contact_created_on_validation_failure(): void
    {
        Livewire::test(ContactForm::class)
            ->set('name', '')
            ->set('phone', '')
            ->call('send');

        $this->assertDatabaseCount('contacts', 0);
    }
}
