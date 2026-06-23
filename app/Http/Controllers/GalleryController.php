<?php

namespace App\Http\Controllers;

use App\Models\Media;

class GalleryController extends Controller
{
    public function index()
    {
        $search = request('q');

        $images = Media::when($search, function ($query) use ($search) {
                $query->where('name->ar', 'like', "%{$search}%")
                      ->orWhere('name->en', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $total = Media::count();

        return view('gallery', compact('images', 'total', 'search'));
    }
}
