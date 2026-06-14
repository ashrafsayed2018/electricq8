<?php

namespace Tests\Feature;

use App\Enums\ContactStatus;
use App\Enums\ServiceStatus;
use App\Models\Contact;
use App\Models\Location;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModelTest extends TestCase
{
    use RefreshDatabase;

    // ─── Service ────────────────────────────────────────────

    // Happy: can create a service with translatable fields
    public function test_service_can_be_created_with_translatable_fields(): void
    {
        $service = Service::create([
            'title'   => ['ar' => 'تركيب الكهرباء', 'en' => 'Electrical Installation'],
            'slug'    => ['ar' => 'تركيب-كهرباء', 'en' => 'ac-installation'],
            'h1'      => ['ar' => 'تركيب الكهرباء', 'en' => 'Electrical Installation'],
            'status'  => ServiceStatus::Active,
            'sort_order' => 1,
        ]);

        $this->assertDatabaseHas('services', ['id' => $service->id]);
        $this->assertSame('Electrical Installation', $service->getTranslation('title', 'en'));
        $this->assertSame('تركيب الكهرباء', $service->getTranslation('title', 'ar'));
    }

    // Happy: scopeActive only returns active services ordered by sort_order
    public function test_service_scope_active_returns_only_active_ordered(): void
    {
        Service::create([
            'title'  => ['ar' => 'أ', 'en' => 'A'],
            'slug'   => ['ar' => 'ا', 'en' => 'a'],
            'h1'     => ['ar' => 'أ', 'en' => 'A'],
            'status' => ServiceStatus::Inactive,
            'sort_order' => 1,
        ]);
        Service::create([
            'title'  => ['ar' => 'ب', 'en' => 'B'],
            'slug'   => ['ar' => 'ب', 'en' => 'b'],
            'h1'     => ['ar' => 'ب', 'en' => 'B'],
            'status' => ServiceStatus::Active,
            'sort_order' => 2,
        ]);

        $active = Service::active()->get();

        $this->assertCount(1, $active);
        $this->assertSame('B', $active->first()->getTranslation('title', 'en'));
    }

    // Happy: status casts to ServiceStatus enum
    public function test_service_status_casts_to_enum(): void
    {
        $service = Service::create([
            'title'  => ['ar' => 'أ', 'en' => 'A'],
            'slug'   => ['ar' => 'ا', 'en' => 'a'],
            'h1'     => ['ar' => 'أ', 'en' => 'A'],
            'status' => ServiceStatus::Active,
        ]);

        $this->assertInstanceOf(ServiceStatus::class, $service->fresh()->status);
        $this->assertEquals(ServiceStatus::Active, $service->fresh()->status);
    }

    // Unhappy: service without required title field cannot be created
    public function test_service_creation_fails_without_required_name(): void
    {
        $this->expectException(\Exception::class);

        Service::create([
            'slug'   => ['ar' => 'ا', 'en' => 'a'],
            'status' => ServiceStatus::Active,
        ]);
    }

    // ─── Location ───────────────────────────────────────────────

    // Happy: can create a location
    public function test_area_can_be_created(): void
    {
        $location = Location::create([
            'name'        => ['ar' => 'حولي', 'en' => 'Hawalli'],
            'slug'        => ['ar' => 'حولي', 'en' => 'hawalli'],
            'governorate' => 'hawalli',
            'is_active'   => true,
            'sort_order'  => 1,
        ]);

        $this->assertDatabaseHas('locations', ['id' => $location->id]);
        $this->assertSame('Hawalli', $location->getTranslation('name', 'en'));
    }

    // Happy: location has_many testimonials
    public function test_area_has_many_testimonials(): void
    {
        $location = Location::create([
            'name'        => ['ar' => 'حولي', 'en' => 'Hawalli'],
            'slug'        => ['ar' => 'حولي', 'en' => 'hawalli'],
            'governorate' => 'hawalli',
        ]);
        Testimonial::create([
            'client_name' => ['ar' => 'أحمد', 'en' => 'Ahmed'],
            'body'        => ['ar' => 'ممتاز', 'en' => 'Excellent'],
            'location_id' => $location->id,
            'rating'      => 5,
        ]);

        $this->assertCount(1, $location->testimonials);
    }

    // Unhappy: inactive location is excluded from is_active=true query
    public function test_inactive_area_excluded_from_active_query(): void
    {
        Location::create(['name' => ['ar' => 'أ', 'en' => 'A'], 'slug' => ['ar' => 'ا', 'en' => 'a'], 'governorate' => 'capital', 'is_active' => false]);
        Location::create(['name' => ['ar' => 'ب', 'en' => 'B'], 'slug' => ['ar' => 'ب', 'en' => 'b'], 'governorate' => 'hawalli', 'is_active' => true]);

        $activeLocations = Location::where('is_active', true)->get();

        $this->assertCount(1, $activeLocations);
        $this->assertSame('B', $activeLocations->first()->getTranslation('name', 'en'));
    }

    // ─── Testimonial ────────────────────────────────────────

    // Happy: can create testimonial with rating and translations
    public function test_testimonial_can_be_created(): void
    {
        $testimonial = Testimonial::create([
            'client_name' => ['ar' => 'محمد', 'en' => 'Mohammed'],
            'body'        => ['ar' => 'خدمة ممتازة', 'en' => 'Excellent service'],
            'rating'      => 5,
            'is_active'   => true,
        ]);

        $this->assertDatabaseHas('testimonials', ['id' => $testimonial->id, 'rating' => 5]);
        $this->assertSame('Excellent service', $testimonial->getTranslation('body', 'en'));
    }

    // Happy: scopeActive returns only active testimonials
    public function test_testimonial_scope_active_returns_only_active(): void
    {
        Testimonial::create([
            'client_name' => ['ar' => 'أ', 'en' => 'A'], 'body' => ['ar' => 'ب', 'en' => 'B'],
            'rating' => 5, 'is_active' => false,
        ]);
        Testimonial::create([
            'client_name' => ['ar' => 'ج', 'en' => 'C'], 'body' => ['ar' => 'د', 'en' => 'D'],
            'rating' => 4, 'is_active' => true,
        ]);

        $this->assertCount(1, Testimonial::active()->get());
    }

    // Unhappy: testimonial rating defaults to 5
    public function test_testimonial_rating_defaults_to_5(): void
    {
        $testimonial = Testimonial::create([
            'client_name' => ['ar' => 'أ', 'en' => 'A'],
            'body'        => ['ar' => 'ب', 'en' => 'B'],
        ]);

        $this->assertEquals(5, $testimonial->fresh()->rating);
    }

    // ─── Contact ────────────────────────────────────────────

    // Happy: can create a contact record
    public function test_contact_can_be_created(): void
    {
        $contact = Contact::create([
            'name'   => 'علي أحمد',
            'phone'  => '+96512345678',
            'locale' => 'ar',
            'status' => ContactStatus::New,
        ]);

        $this->assertDatabaseHas('contacts', ['name' => 'علي أحمد', 'status' => 'new']);
        $this->assertInstanceOf(ContactStatus::class, $contact->fresh()->status);
    }

    // Happy: status casts to ContactStatus enum
    public function test_contact_status_casts_to_enum(): void
    {
        $contact = Contact::create([
            'name' => 'Test', 'phone' => '12345678', 'status' => ContactStatus::Read,
        ]);

        $this->assertEquals(ContactStatus::Read, $contact->fresh()->status);
    }

    // Happy: contact nullOnDelete when related service is deleted
    public function test_contact_service_id_nulled_on_service_delete(): void
    {
        $service = Service::create([
            'title'  => ['ar' => 'أ', 'en' => 'A'],
            'slug'   => ['ar' => 'ا', 'en' => 'a'],
            'h1'     => ['ar' => 'أ', 'en' => 'A'],
            'status' => ServiceStatus::Active,
        ]);
        $contact = Contact::create([
            'name' => 'Test', 'phone' => '12345678', 'service_id' => $service->id,
        ]);

        $service->delete();

        $this->assertNull($contact->fresh()->service_id);
    }

    // Unhappy: contact status defaults to 'new'
    public function test_contact_status_defaults_to_new(): void
    {
        $contact = Contact::create(['name' => 'Test', 'phone' => '12345678']);

        $this->assertEquals(ContactStatus::New, $contact->fresh()->status);
    }
}
