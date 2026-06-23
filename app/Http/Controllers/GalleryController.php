<?php

namespace App\Http\Controllers;

use App\Models\Media;

class GalleryController extends Controller
{
    public function index()
    {
        $total = Media::count();
        return view('gallery', compact('total'));
    }
}
