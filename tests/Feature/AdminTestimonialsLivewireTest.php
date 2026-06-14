<?php

namespace Tests\Feature;

use App\Livewire\Admin\Testimonials\Index;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminTestimonialsLivewireTest extends TestCase
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

    private function makeTestimonial(array $overrides = []): Testimonial
    {
        return Testimonial::create(array_merge([
            'client_name' => ['ar' => 'أحمد محمد', 'en' => 'Ahmed Mohamed'],
            'body'        => ['ar' => 'خدمة ممتازة', 'en' => 'Excellent service'],
            'rating'      => 5,
            'is_active'   => true,
        ], $overrides));
    }

    // ═══════════════════════════════════════════════════════════
    // ACCESS CONTROL
    // ═══════════════════════════════════════════════════════════

    public function test_guest_redirected_from_testimonials(): void
    {
        $this->get(route('admin.testimonials.index'))
            ->assertRedirect(route('login'));
    }

    public function test_non_admin_forbidden_from_testimonials(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('admin.testimonials.index'))
            ->assertForbidden();
    }

    public function test_admin_can_access_testimonials(): void
    {
        $this->actingAs($this->admin)
            ->get(route('admin.testimonials.index'))
            ->assertOk();
    }

    // ═══════════════════════════════════════════════════════════
    // INDEX — listing
    // ═══════════════════════════════════════════════════════════

    public function test_index_renders_existing_testimonials(): void
    {
        // The view renders client_name in Arabic (getTranslation('client_name', 'ar'))
        $this->makeTestimonial(['client_name' => ['ar' => 'فاطمة', 'en' => 'Fatima']]);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->assertSee('فاطمة');
    }

    public function test_index_shows_multiple_testimonials(): void
    {
        $this->makeTestimonial(['client_name' => ['ar' => 'أحمد', 'en' => 'Ahmed']]);
        $this->makeTestimonial(['client_name' => ['ar' => 'سارة', 'en' => 'Sara']]);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->assertSee('أحمد')
            ->assertSee('سارة');
    }

    // ═══════════════════════════════════════════════════════════
    // TOGGLE — active/inactive
    // ═══════════════════════════════════════════════════════════

    public function test_toggle_deactivates_active_testimonial(): void
    {
        $testimonial = $this->makeTestimonial(['is_active' => true]);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->call('toggle', $testimonial);

        $this->assertSame(0, (int) $testimonial->fresh()->is_active);
    }

    public function test_toggle_activates_inactive_testimonial(): void
    {
        $testimonial = $this->makeTestimonial(['is_active' => false]);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->call('toggle', $testimonial);

        $this->assertSame(1, (int) $testimonial->fresh()->is_active);
    }

    public function test_toggling_twice_returns_to_original_state(): void
    {
        $testimonial = $this->makeTestimonial(['is_active' => true]);

        $component = Livewire::actingAs($this->admin)->test(Index::class);
        $component->call('toggle', $testimonial);
        $component->call('toggle', $testimonial->fresh());

        $this->assertSame(1, (int) $testimonial->fresh()->is_active);
    }

    public function test_toggling_one_does_not_affect_others(): void
    {
        $first  = $this->makeTestimonial(['is_active' => true]);
        $second = $this->makeTestimonial(['is_active' => true]);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->call('toggle', $first);

        $this->assertSame(0, (int) $first->fresh()->is_active);
        $this->assertSame(1, (int) $second->fresh()->is_active);
    }

    // ═══════════════════════════════════════════════════════════
    // DELETE
    // ═══════════════════════════════════════════════════════════

    public function test_admin_can_delete_testimonial(): void
    {
        $testimonial = $this->makeTestimonial();

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->call('delete', $testimonial);

        $this->assertDatabaseMissing('testimonials', ['id' => $testimonial->id]);
    }

    public function test_deleting_one_testimonial_leaves_others_intact(): void
    {
        $first  = $this->makeTestimonial(['client_name' => ['ar' => 'أ', 'en' => 'Alice']]);
        $second = $this->makeTestimonial(['client_name' => ['ar' => 'ب', 'en' => 'Bob']]);

        Livewire::actingAs($this->admin)
            ->test(Index::class)
            ->call('delete', $first);

        $this->assertDatabaseMissing('testimonials', ['id' => $first->id]);
        $this->assertDatabaseHas('testimonials',    ['id' => $second->id]);
    }

    // ═══════════════════════════════════════════════════════════
    // UNHAPPY — toggle/delete on non-existent
    // ═══════════════════════════════════════════════════════════

    public function test_deleted_testimonial_is_removed_from_listing(): void
    {
        $testimonial = $this->makeTestimonial(['client_name' => ['ar' => 'خالد', 'en' => 'Khaled']]);

        $component = Livewire::actingAs($this->admin)->test(Index::class);
        $component->assertSee('خالد');

        $component->call('delete', $testimonial);
        $component->assertDontSee('خالد');
    }
}
