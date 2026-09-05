@extends('layouts.app')

@php
    $isAr     = app()->getLocale() === 'ar';
    $locale   = app()->getLocale();
    $tagName  = $tag->getTranslation('name', $locale);
@endphp

@section('robots', 'noindex, nofollow')

@section('meta_title')
    {{ $isAr
        ? "مقالات موسومة بـ {$tagName} | إلكتريك كويت"
        : "Articles tagged \"{$tagName}\" | ElectricQ8" }}
@endsection

@section('meta_description')
    {{ $tag->getTranslation('content', $locale) ?: ($isAr
        ? "جميع المقالات المتعلقة بـ {$tagName} في مدونة إلكتريك كويت."
        : "All articles related to \"{$tagName}\" on the ElectricQ8 blog.") }}
@endsection

@section('content')
<div dir="{{ $isAr ? 'rtl' : 'ltr' }}">

    {{-- Hero --}}
    <section class="eq8-page-hero">
        <div class="eq8-page-hero__inner">
            <h1 class="eq8-page-hero__title">
                {{ $isAr ? "مقالات موسومة بـ: {$tagName}" : "Articles tagged: {$tagName}" }}
            </h1>
            <p class="eq8-page-hero__sub">
                {{ $isAr
                    ? 'تصفح جميع المقالات المرتبطة بهذا الوسم'
                    : 'Browse all articles related to this tag' }}
            </p>
        </div>
    </section>

    <div style="background:var(--bg);min-height:60vh;padding:48px 0">
        <div class="container mx-auto px-4">

            @if($posts->isEmpty())
                <p style="text-align:center;color:var(--muted);padding:80px 0;font-family:'Cairo',sans-serif">
                    {{ $isAr ? 'لا توجد مقالات بهذا الوسم بعد.' : 'No articles with this tag yet.' }}
                </p>
            @else
                <div class="eq8-blog-grid">
                    @foreach($posts as $post)
                    @php
                        $postTitle   = $post->getTranslation('title', $locale);
                        $postExcerpt = Str::limit(strip_tags($post->getTranslation('excerpt', $locale)), 140);
                        $postSlug    = $post->getTranslation('slug', $locale);
                        $postRoute   = $isAr ? route('posts.show', $postSlug) : route('en.posts.show', $postSlug);
                        $readMinutes = $post->readMinutes($locale);
                    @endphp
                    <a href="{{ $postRoute }}" class="eq8-post-card">

                        {{-- Thumbnail --}}
                        @if($post->featured_image)
                            <div class="eq8-post-card__img-wrap">
                                <img src="{{ $post->featured_image }}"
                                     alt="{{ $postTitle }}" loading="lazy" class="eq8-post-card__img">
                            </div>
                        @else
                            <div class="eq8-post-card__placeholder">
                                <svg class="eq8-post-card__placeholder-icon" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"/>
                                </svg>
                            </div>
                        @endif

                        <div class="eq8-post-card__body">
                            <div class="eq8-post-card__meta">
                                @if($post->published_at)
                                    <span class="eq8-post-meta-item">
                                        <svg class="eq8-post-meta-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        <span dir="ltr">{{ $post->published_at->format('d M Y') }}</span>
                                    </span>
                                @endif
                                <span class="eq8-post-meta-item">
                                    <svg class="eq8-post-meta-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $isAr ? $readMinutes . ' د قراءة' : $readMinutes . ' min read' }}
                                </span>
                            </div>
                            <h2 class="eq8-post-card__title">{{ $postTitle }}</h2>
                            @if($postExcerpt)
                                <p class="eq8-post-card__excerpt">{{ $postExcerpt }}</p>
                            @endif
                            <span class="eq8-post-card__cta">{{ $isAr ? 'اقرأ المزيد ←' : 'Read more →' }}</span>
                        </div>
                    </a>
                    @endforeach
                </div>

                <div class="mt-10">{{ $posts->links() }}</div>
            @endif

        </div>
    </div>
</div>

<style>
.eq8-page-hero { background:linear-gradient(135deg,#43230E 0%,#6B3A17 60%,#8B4D20 100%); color:#fff; padding:56px 20px; text-align:center; }
.eq8-page-hero__inner { max-width:700px; margin:0 auto; }
.eq8-page-hero__title { font-size:clamp(1.6rem,4vw,2.4rem); font-weight:800; margin:0 0 12px; font-family:'Cairo',system-ui,sans-serif; }
.eq8-page-hero__sub { font-size:1rem; color:#F3D9BB; margin:0; font-family:'Cairo',system-ui,sans-serif; }

.eq8-blog-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:24px; }
@media(max-width:900px){ .eq8-blog-grid { grid-template-columns:repeat(2,1fr); } }
@media(max-width:560px){ .eq8-blog-grid { grid-template-columns:1fr; } }

.eq8-post-card { display:flex; flex-direction:column; background:var(--cardBg); border:1px solid var(--border); border-radius:16px; overflow:hidden; text-decoration:none; transition:box-shadow .25s,transform .25s,border-color .25s; }
.eq8-post-card:hover { box-shadow:0 8px 32px rgba(107,58,23,.12); transform:translateY(-4px); border-color:var(--accent); }

.eq8-post-card__img-wrap { overflow:hidden; }
.eq8-post-card__img { width:100%; height:176px; object-fit:cover; transition:transform .35s; }
.eq8-post-card:hover .eq8-post-card__img { transform:scale(1.05); }

.eq8-post-card__placeholder { width:100%; height:176px; background:var(--altBg); display:flex; align-items:center; justify-content:center; }
.eq8-post-card__placeholder-icon { width:48px; height:48px; color:var(--border); }

.eq8-post-card__body { padding:18px; display:flex; flex-direction:column; flex:1; }
.eq8-post-card__meta { display:flex; align-items:center; gap:12px; margin-bottom:10px; }
.eq8-post-meta-item { display:flex; align-items:center; gap:4px; font-size:.74rem; color:var(--muted); font-family:'Cairo',sans-serif; }
.eq8-post-meta-icon { width:13px; height:13px; }
.eq8-post-card__title { font-size:.9rem; font-weight:700; color:var(--text); margin:0 0 8px; line-height:1.45; font-family:'Cairo',sans-serif; }
.eq8-post-card__excerpt { font-size:.8rem; color:var(--body); line-height:1.65; flex:1; margin:0 0 12px; font-family:'Cairo',sans-serif; }
.eq8-post-card__cta { font-size:.82rem; font-weight:600; color:var(--accent); margin-top:auto; font-family:'Cairo',sans-serif; }
</style>
@endsection
