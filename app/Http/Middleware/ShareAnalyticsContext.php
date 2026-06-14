<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class ShareAnalyticsContext
{
    public function handle(Request $request, Closure $next): Response
    {
        $analyticsContext = [
            'pageType'   => $this->resolvePageType($request),
            'routeName'  => $request->route()?->getName(),
            'locale'     => $request->getLocale(),
            'url'        => $request->fullUrl(),
            'path'       => '/' . ltrim($request->path(), '/'),
            'deviceType' => $this->resolveDeviceType((string) $request->userAgent()),
        ];

        $request->attributes->set('analyticsContext', $analyticsContext);
        View::share('analyticsContext', $analyticsContext);

        return $next($request);
    }

    private function resolvePageType(Request $request): string
    {
        $routeName = $request->route()?->getName();

        $routeNameMap = [
            'home'                       => 'home',
            'en.home'                    => 'home',
            'about'                      => 'about',
            'contact'                    => 'contact',
            'privacy'                    => 'privacy',
            'pillars.show'               => 'pillar_show',
            'en.pillars.show'            => 'pillar_show',
            'clusters.show'              => 'cluster_show',
            'en.clusters.show'           => 'cluster_show',
            'services.show'              => 'service_show',
            'en.services.show'           => 'service_show',
            'service_location.show'      => 'service_location_show',
            'en.service_location.show'   => 'service_location_show',
            'locations.index'            => 'locations_index',
            'en.locations.index'         => 'locations_index',
            'locations.show'             => 'location_show',
            'en.locations.show'          => 'location_show',
            'admin.dashboard'            => 'admin_dashboard',
            'admin.contacts.index'       => 'admin_contacts',
            'admin.clusters.index'       => 'admin_clusters',
            'admin.services.index'       => 'admin_services',
            'admin.services.create'      => 'admin_services',
            'admin.services.edit'        => 'admin_services',
            'admin.areas.index'          => 'admin_areas',
            'admin.testimonials.index'   => 'admin_testimonials',
            'admin.posts.index'          => 'admin_posts',
            'admin.posts.create'         => 'admin_posts',
            'admin.posts.edit'           => 'admin_posts',
            'admin.gallery.index'        => 'admin_gallery',
            'admin.gallery.create'       => 'admin_gallery',
            'admin.gallery.edit'         => 'admin_gallery',
            'admin.settings'             => 'admin_settings',
        ];

        if (is_string($routeName) && isset($routeNameMap[$routeName])) {
            return $routeNameMap[$routeName];
        }

        $path     = trim((string) $request->path(), '/');
        $segments = $path === '' ? [] : explode('/', $path);

        $allowedLocales = (array) Config::get('analytics.allowed_locales', ['en', 'ar']);
        if (isset($segments[0]) && in_array($segments[0], $allowedLocales, true)) {
            array_shift($segments);
        }

        $normalizedPath = implode('/', $segments);

        return match (true) {
            $normalizedPath === ''                                      => 'home',
            $normalizedPath === 'about'                                 => 'about',
            $normalizedPath === 'contact'                               => 'contact',
            $normalizedPath === 'privacy'                               => 'privacy',
            $normalizedPath === 'locations'                             => 'locations_index',
            str_starts_with($normalizedPath, 'locations/')              => 'location_show',
            str_starts_with($normalizedPath, 'admin/contacts')          => 'admin_contacts',
            str_starts_with($normalizedPath, 'admin/clusters')          => 'admin_clusters',
            str_starts_with($normalizedPath, 'admin/services')          => 'admin_services',
            str_starts_with($normalizedPath, 'admin/areas')             => 'admin_areas',
            str_starts_with($normalizedPath, 'admin/testimonials')      => 'admin_testimonials',
            str_starts_with($normalizedPath, 'admin/posts')             => 'admin_posts',
            str_starts_with($normalizedPath, 'admin/gallery')           => 'admin_gallery',
            str_starts_with($normalizedPath, 'admin/settings')          => 'admin_settings',
            str_starts_with($normalizedPath, 'admin')                   => 'admin_dashboard',
            default                                                     => 'page',
        };
    }

    private function resolveDeviceType(string $userAgent): string
    {
        if ($userAgent === '') {
            return 'desktop';
        }

        $ua = strtolower($userAgent);

        if (str_contains($ua, 'ipad') || str_contains($ua, 'tablet')) {
            return 'tablet';
        }

        if (preg_match('/mobile|iphone|ipod|android|blackberry|opera mini|iemobile/u', $ua) === 1) {
            return 'mobile';
        }

        return 'desktop';
    }
}
