<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Service;
use App\Models\ServiceLocationPage;

class ServiceLocationController extends Controller
{
    public function show(Service $service, Location $location)
    {
        $locale = app()->getLocale();

        // Resolve the page from DB, or generate on-the-fly from service+location data
        $page = ServiceLocationPage::where('service_id', $service->id)
            ->where('location_id', $location->id)
            ->where('status', 'active')
            ->first();

        // If noindex or not found with content, still render but flag for 404 if truly missing
        if (! $page) {
            // Auto-generate a virtual page so the URL still works without DB record
            $page = new ServiceLocationPage([
                'service_id'  => $service->id,
                'location_id' => $location->id,
                'status'      => 'active',
                'noindex'     => true,
            ]);

            foreach (['ar', 'en'] as $l) {
                $auto = ServiceLocationPage::autoFill($service, $location, $l);
                foreach ($auto as $field => $value) {
                    $page->setTranslation($field, $l, $value);
                }
            }
        }

        // Canonical-slug redirect: if the URL slug doesn't match current locale's slug
        $serviceSlug  = $service->getTranslation('slug', $locale);
        $locationSlug = $location->getTranslation('slug', $locale);
        $seg          = request()->segments();
        $urlServiceSlug  = $seg[count($seg) - 2] ?? null;
        $urlLocationSlug = $seg[count($seg) - 1] ?? null;

        if ($urlServiceSlug !== $serviceSlug || $urlLocationSlug !== $locationSlug) {
            $routeName = $locale === 'ar' ? 'service-locations.show' : 'en.service-locations.show';
            return redirect()->route($routeName, [$serviceSlug, $locationSlug], 302);
        }

        // Related: other services in same location, other locations for same service
        $otherServices = Service::active()
            ->where('id', '!=', $service->id)
            ->get();

        $otherLocations = Location::where('is_active', true)
            ->where('id', '!=', $location->id)
            ->orderBy('sort_order')
            ->limit(10)
            ->get();

        // Same-governorate locations for internal linking
        $nearbyLocations = Location::where('is_active', true)
            ->where('governorate', $location->governorate)
            ->where('id', '!=', $location->id)
            ->orderBy('sort_order')
            ->limit(6)
            ->get();

        return view('services.location', compact(
            'service', 'location', 'page',
            'otherServices', 'otherLocations', 'nearbyLocations'
        ));
    }
}
