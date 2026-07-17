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

        $relatedPosts = Post::published()
            ->where('id', '!=', $post->id)
            ->when($post->cluster_id, fn ($q) => $q->orderByRaw('cluster_id = ? desc', [$post->cluster_id]))
            ->limit(8)
            ->get();

        return view('posts.show', ['post' => $post, 'relatedPosts' => $relatedPosts]);
    }
}
