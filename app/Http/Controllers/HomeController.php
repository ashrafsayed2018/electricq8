<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Service;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'services'     => Service::active()->get(),
            'locations'    => Location::where('is_active', true)->orderBy('sort_order')->get(),
            'testimonials' => Testimonial::active()->limit(6)->get(),
        ]);
    }
}
