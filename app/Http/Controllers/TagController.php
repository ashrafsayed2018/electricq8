<?php

namespace App\Http\Controllers;

use App\Models\Tag;

class TagController extends Controller
{
    public function show(Tag $tag)
    {
        $locale        = app()->getLocale();
        $correctSlug   = $tag->getTranslation('slug', $locale);
        $requestedSlug = last(request()->segments());

        if ($requestedSlug !== $correctSlug) {
            $route = $locale === 'ar' ? 'tags.show' : 'en.tags.show';
            return redirect()->route($route, $correctSlug, 301);
        }

        $posts = $tag->posts()
            ->published()
            ->paginate(12);

        return view('tags.show', ['tag' => $tag, 'posts' => $posts]);
    }
}
