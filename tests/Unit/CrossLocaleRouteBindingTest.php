<?php

namespace Tests\Unit;

use App\Enums\PostStatus;
use App\Enums\ServiceStatus;
use App\Models\Location;
use App\Models\Post;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

/**
 * Tests that slug resolution works regardless of the current session locale.
 * The bug: visiting /services/ac-repair while locale=ar returned 404 because
 * the model only searched slug->ar. Now it tries all locales.
 */
class CrossLocaleRouteBindingTest extends TestCase
{
    use RefreshDatabase;

    // ══════════════════════════════════════════════════════
    // SERVICE — cross-locale slug resolution
    // ══════════════════════════════════════════════════════

    // Unhappy: English slug fails when only current locale (ar) is searched — RED proves old bug
    // After fix: English slug resolves even when locale is Arabic
    public function test_service_english_slug_resolves_when_locale_is_arabic(): void
    {
        $service = Service::create([
            'title'  => ['ar' => 'إصلاح كهرباء', 'en' => 'Electrical Repair'],
            'slug'   => ['ar' => 'إصلاح-كهرباء', 'en' => 'ac-repair'],
            'h1'     => ['ar' => 'إصلاح كهرباء', 'en' => 'Electrical Repair'],
            'status' => ServiceStatus::Active,
        ]);

        app()->setLocale('ar');

        $found = (new Service)->resolveRouteBinding('ac-repair');

        $this->assertNotNull($found);
        $this->assertEquals($service->id, $found->id);
    }

    // Unhappy: Arabic slug fails when only current locale (en) is searched — RED proves old bug
    // After fix: Arabic slug resolves even when locale is English
    public function test_service_arabic_slug_resolves_when_locale_is_english(): void
    {
        $service = Service::create([
            'title'  => ['ar' => 'إصلاح كهرباء', 'en' => 'Electrical Repair'],
            'slug'   => ['ar' => 'إصلاح-كهرباء', 'en' => 'ac-repair'],
            'h1'     => ['ar' => 'إصلاح كهرباء', 'en' => 'Electrical Repair'],
            'status' => ServiceStatus::Active,
        ]);

        app()->setLocale('en');

        $found = (new Service)->resolveRouteBinding('إصلاح-كهرباء');

        $this->assertNotNull($found);
        $this->assertEquals($service->id, $found->id);
    }

    // Unhappy: completely unknown service slug throws 404 (not ModelNotFoundException)
    public function test_service_unknown_slug_throws_404(): void
    {
        $this->expectException(NotFoundHttpException::class);

        (new Service)->resolveRouteBinding('totally-unknown-slug');
    }

    // Happy: service resolves by numeric id regardless of locale
    public function test_service_resolves_by_numeric_id(): void
    {
        $service = Service::create([
            'title'  => ['ar' => 'إصلاح كهرباء', 'en' => 'Electrical Repair'],
            'slug'   => ['ar' => 'إصلاح-كهرباء', 'en' => 'ac-repair'],
            'h1'     => ['ar' => 'إصلاح كهرباء', 'en' => 'Electrical Repair'],
            'status' => ServiceStatus::Active,
        ]);

        $found = (new Service)->resolveRouteBinding((string) $service->id, 'id');

        $this->assertEquals($service->id, $found->id);
    }

    // ══════════════════════════════════════════════════════
    // LOCATION — cross-locale slug resolution
    // ══════════════════════════════════════════════════════

    // Unhappy: English slug fails when locale is Arabic — RED proves old bug
    // After fix: resolves correctly
    public function test_location_english_slug_resolves_when_locale_is_arabic(): void
    {
        $location = Location::create([
            'name'        => ['ar' => 'حولي',  'en' => 'Hawalli'],
            'slug'        => ['ar' => 'حولي',  'en' => 'hawalli'],
            'governorate' => 'hawalli',
        ]);

        app()->setLocale('ar');

        $found = (new Location)->resolveRouteBinding('hawalli');

        $this->assertNotNull($found);
        $this->assertEquals($location->id, $found->id);
    }

    // Unhappy: Arabic slug fails when locale is English — RED proves old bug
    // After fix: resolves correctly
    public function test_location_arabic_slug_resolves_when_locale_is_english(): void
    {
        $location = Location::create([
            'name'        => ['ar' => 'حولي',  'en' => 'Hawalli'],
            'slug'        => ['ar' => 'حولي',  'en' => 'hawalli'],
            'governorate' => 'hawalli',
        ]);

        app()->setLocale('en');

        $found = (new Location)->resolveRouteBinding('حولي');

        $this->assertNotNull($found);
        $this->assertEquals($location->id, $found->id);
    }

    // Unhappy: completely unknown location slug throws 404
    public function test_location_unknown_slug_throws_404(): void
    {
        $this->expectException(NotFoundHttpException::class);

        (new Location)->resolveRouteBinding('totally-unknown-area');
    }

    // ══════════════════════════════════════════════════════
    // POST — cross-locale slug resolution
    // ══════════════════════════════════════════════════════

    // Unhappy: English slug fails when locale is Arabic — RED proves old bug
    // After fix: resolves correctly
    public function test_post_english_slug_resolves_when_locale_is_arabic(): void
    {
        $post = Post::create([
            'title'  => ['ar' => 'مقال تجريبي', 'en' => 'Test Article'],
            'slug'   => ['ar' => 'مقال-تجريبي', 'en' => 'test-article'],
            'h1'     => ['ar' => 'مقال تجريبي', 'en' => 'Test Article'],
            'status' => PostStatus::Published,
        ]);

        app()->setLocale('ar');

        $found = (new Post)->resolveRouteBinding('test-article');

        $this->assertNotNull($found);
        $this->assertEquals($post->id, $found->id);
    }

    // Unhappy: Arabic slug fails when locale is English — RED proves old bug
    // After fix: resolves correctly
    public function test_post_arabic_slug_resolves_when_locale_is_english(): void
    {
        $post = Post::create([
            'title'  => ['ar' => 'مقال تجريبي', 'en' => 'Test Article'],
            'slug'   => ['ar' => 'مقال-تجريبي', 'en' => 'test-article'],
            'h1'     => ['ar' => 'مقال تجريبي', 'en' => 'Test Article'],
            'status' => PostStatus::Published,
        ]);

        app()->setLocale('en');

        $found = (new Post)->resolveRouteBinding('مقال-تجريبي');

        $this->assertNotNull($found);
        $this->assertEquals($post->id, $found->id);
    }

    // Unhappy: completely unknown post slug throws 404
    public function test_post_unknown_slug_throws_404(): void
    {
        $this->expectException(NotFoundHttpException::class);

        (new Post)->resolveRouteBinding('totally-unknown-post');
    }

    // ══════════════════════════════════════════════════════
    // HTTP route level — cross-locale slug via real requests
    // ══════════════════════════════════════════════════════

    // Unhappy: /services/ac-repair returns 404 when locale=ar (old bug)
    // After fix: resolves and redirects to Arabic slug (301)
    public function test_service_english_slug_url_works_when_session_locale_is_arabic(): void
    {
        Service::create([
            'title'  => ['ar' => 'إصلاح كهرباء', 'en' => 'Electrical Repair'],
            'slug'   => ['ar' => 'إصلاح-كهرباء', 'en' => 'ac-repair'],
            'h1'     => ['ar' => 'إصلاح كهرباء', 'en' => 'Electrical Repair'],
            'status' => ServiceStatus::Active,
        ]);

        // Arabic session locale, English slug in URL → resolves, then redirects to Arabic slug
        $response = $this->withSession(['locale' => 'ar'])->get('/services/ac-repair');
        $response->assertStatus(301);
        $this->assertStringContainsString(urlencode('إصلاح-كهرباء'), $response->headers->get('Location'));
    }

    // Unhappy: /areas/hawalli returns 404 when locale=ar (old bug)
    // After fix: returns 200
    public function test_location_english_slug_url_works_when_session_locale_is_arabic(): void
    {
        Location::create([
            'name'        => ['ar' => 'حولي', 'en' => 'Hawalli'],
            'slug'        => ['ar' => 'حولي', 'en' => 'hawalli'],
            'governorate' => 'hawalli',
            'is_active'   => true,
        ]);

        $this->withSession(['locale' => 'ar'])
            ->get('/areas/hawalli')
            ->assertStatus(200);
    }

    // Unhappy: Arabic slug URL redirects to English slug when session locale is English
    public function test_service_arabic_slug_url_works_when_session_locale_is_english(): void
    {
        Service::create([
            'title'  => ['ar' => 'إصلاح كهرباء', 'en' => 'Electrical Repair'],
            'slug'   => ['ar' => 'إصلاح-كهرباء', 'en' => 'ac-repair'],
            'h1'     => ['ar' => 'إصلاح كهرباء', 'en' => 'Electrical Repair'],
            'status' => ServiceStatus::Active,
        ]);

        // English session locale, Arabic slug in URL → resolves, then redirects to English slug
        $response = $this->withSession(['locale' => 'en'])->get('/services/' . urlencode('إصلاح-كهرباء'));
        $response->assertStatus(301);
        $this->assertStringContainsString('ac-repair', $response->headers->get('Location'));
    }
}
