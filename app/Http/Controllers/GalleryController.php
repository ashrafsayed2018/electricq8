<?php

namespace App\Http\Controllers;

use App\Models\Media;

class GalleryController extends Controller
{
    public function index()
    {
        $images = Media::latest()->get();
        return view('gallery', compact('images'));
    }
}
