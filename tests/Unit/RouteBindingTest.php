<?php

namespace Tests\Unit;

use App\Enums\ServiceStatus;
use App\Models\Location;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

class RouteBindingTest extends TestCase
{
    use RefreshDatabase;

    // Happy: Service resolves by Arabic slug when locale is AR
    public function test_service_resolves_by_arabic_slug(): void
    {
        $service = Service::create([
            'title'   => ['ar' => 'تنظيف الكهرباء', 'en' => 'AC Cleaning'],
            'slug'    => ['ar' => 'تنظيف-كهرباء', 'en' => 'ac-cleaning'],
            'h1'      => ['ar' => 'تنظيف الكهرباء', 'en' => 'AC Cleaning'],
            'status'  => ServiceStatus::Active,
        ]);

        app()->setLocale('ar');
        $found = (new Service)->resolveRouteBinding('تنظيف-كهرباء');

        $this->assertNotNull($found);
        $this->assertEquals($service->id, $found->id);
    }

    // Happy: Service resolves by English slug when locale is EN
    public function test_service_resolves_by_english_slug(): void
    {
        $service = Service::create([
            'title'   => ['ar' => 'تنظيف الكهرباء', 'en' => 'AC Cleaning'],
            'slug'    => ['ar' => 'تنظيف-كهرباء', 'en' => 'ac-cleaning'],
            'h1'      => ['ar' => 'تنظيف الكهرباء', 'en' => 'AC Cleaning'],
            'status'  => ServiceStatus::Active,
        ]);

        app()->setLocale('en');
        $found = (new Service)->resolveRouteBinding('ac-cleaning');

        $this->assertEquals($service->id, $found->id);
    }

    // Unhappy: Service throws 404 for non-existent slug
    public function test_service_throws_404_for_unknown_slug(): void
    {
        app()->setLocale('en');

        $this->expectException(NotFoundHttpException::class);
        (new Service)->resolveRouteBinding('does-not-exist');
    }

    // Happy: Location resolves by Arabic slug
    public function test_area_resolves_by_arabic_slug(): void
    {
        $location = Location::create([
            'name'        => ['ar' => 'حولي', 'en' => 'Hawalli'],
            'slug'        => ['ar' => 'حولي', 'en' => 'hawalli'],
            'governorate' => 'hawalli',
        ]);

        app()->setLocale('ar');
        $found = (new Location)->resolveRouteBinding('حولي');

        $this->assertEquals($location->id, $found->id);
    }

    // Happy: Location resolves by English slug
    public function test_area_resolves_by_english_slug(): void
    {
        $location = Location::create([
            'name'        => ['ar' => 'حولي', 'en' => 'Hawalli'],
            'slug'        => ['ar' => 'حولي', 'en' => 'hawalli'],
            'governorate' => 'hawalli',
        ]);

        app()->setLocale('en');
        $found = (new Location)->resolveRouteBinding('hawalli');

        $this->assertEquals($location->id, $found->id);
    }

    // Unhappy: Location throws 404 for non-existent slug
    public function test_area_throws_404_for_unknown_slug(): void
    {
        app()->setLocale('en');

        $this->expectException(NotFoundHttpException::class);
        (new Location)->resolveRouteBinding('does-not-exist');
    }
}
