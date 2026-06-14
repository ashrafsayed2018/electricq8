<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        return view('services.index', [
            'services' => Service::active()->get(),
        ]);
    }

    public function show(Service $service)
    {
        $locale        = app()->getLocale();
        $correctSlug   = $service->getTranslation('slug', $locale);
        $requestedSlug = last(request()->segments());

        if ($requestedSlug !== $correctSlug) {
            $route = $locale === 'ar' ? 'services.show' : 'en.services.show';
            return redirect()->route($route, $correctSlug, 302);
        }

        return view('services.show', [
            'service'       => $service,
            'otherServices' => Service::active()->where('id', '!=', $service->id)->get(),
            'locations'     => Location::where('is_active', true)->orderBy('sort_order')->get(),
        ]);
    }
}
