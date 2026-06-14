<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        return view('posts.index', [
            'posts' => Post::published()->paginate(12),
        ]);
    }

    public function show(Post $post)
    {
        $locale      = app()->getLocale();
        $correctSlug = $post->getTranslation('slug', $locale);
        $requestedSlug = last(request()->segments());

        if ($requestedSlug !== $correctSlug) {
            $route = $locale === 'ar' ? 'posts.show' : 'en.posts.show';
            return redirect()->route($route, $correctSlug, 302);
        }

        return view('posts.show', ['post' => $post]);
    }
}
