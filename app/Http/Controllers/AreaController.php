<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Service;

class AreaController extends Controller
{
    public function index()
    {
        return view('areas.index', [
            'locations' => Location::where('is_active', true)->orderBy('sort_order')->get(),
        ]);
    }

    public function show(Location $location)
    {
        $relatedLocations = Location::where('is_active', true)
            ->where('governorate', $location->governorate)
            ->where('id', '!=', $location->id)
            ->orderBy('sort_order')
            ->limit(6)
            ->get();

        return view('areas.show', [
            'location'         => $location,
            'services'         => Service::active()->get(),
            'testimonials'     => $location->testimonials()->active()->limit(4)->get(),
            'relatedLocations' => $relatedLocations,
        ]);
    }
}
