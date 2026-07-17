@extends('layouts.app')

@php
    $isAr      = app()->getLocale() === 'ar';
    $locale    = app()->getLocale();
    $postTitle = $post->getTranslation('title', $locale);
    $postExcerpt = strip_tags($post->getTranslation('excerpt', $locale) ?: $post->getTranslation('meta_description', $locale));
    $wordCount   = str_word_count(strip_tags($post->getTranslation('content', $locale) ?? ''));
    $readMinutes = max(1, (int) ceil($wordCount / 200));
    $blogRoute   = $isAr ? route('posts.index') : route('en.posts.index');
    $siteName    = \App\Models\SiteSetting::get('site_name_' . $locale) ?: 'ElectricQ8';
    $siteUrl     = config('app.url');
    $postUrl     = url()->current();
    $imageUrl    = $post->featured_image ? asset('storage/' . $post->featured_image) : null;
@endphp

@section('meta_title'){{ $post->getTranslation('meta_title', $locale) ?: $postTitle }}@endsection
@section('meta_description'){{ $post->getTranslation('meta_description', $locale) ?: $postExcerpt }}@endsection

@push('head')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "Article",
  "headline": {{ json_encode($postTitle) }},
  "description": {{ json_encode($postExcerpt) }},
  @if($imageUrl)"image": {{ json_encode($imageUrl) }},@endif
  @if($post->published_at)
  "datePublished": "{{ $post->published_at->toIso8601String() }}",
  "dateModified": "{{ ($post->updated_at ?? $post->published_at)->toIso8601String() }}",
  @endif
  "author": { "@@type": "Organization", "name": {{ json_encode($siteName) }}, "url": {{ json_encode($siteUrl) }} },
  "publisher": { "@@type": "Organization", "name": {{ json_encode($siteName) }}, "url": {{ json_encode($siteUrl) }} },
  "mainEntityOfPage": { "@@type": "WebPage", "@@id": {{ json_encode($postUrl) }} },
  "inLanguage": "{{ $isAr ? 'ar' : 'en' }}"
}
</script>
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "BreadcrumbList",
  "itemListElement": [
    { "@@type": "ListItem", "position": 1, "name": {{ json_encode($isAr ? 'الرئيسية' : 'Home') }}, "item": {{ json_encode($siteUrl . ($isAr ? '' : '/en')) }} },
    { "@@type": "ListItem", "position": 2, "name": {{ json_encode($isAr ? 'المدونة' : 'Blog') }}, "item": {{ json_encode($blogRoute) }} },
    { "@@type": "ListItem", "position": 3, "name": {{ json_encode($postTitle) }}, "item": {{ json_encode($postUrl) }} }
  ]
}
</script>
@endpush

@section('content')
<div dir="{{ $isAr ? 'rtl' : 'ltr' }}">

    {{-- Breadcrumb --}}
    <nav class="eq8-bc" aria-label="breadcrumb">
        <div class="eq8-bc__inner" style="max-width:820px">
            <ol class="eq8-bc__list">
                <li><a href="{{ $isAr ? route('home') : route('en.home') }}" class="eq8-bc__link">{{ $isAr ? 'الرئيسية' : 'Home' }}</a></li>
                <li class="eq8-bc__sep">/</li>
                <li><a href="{{ $blogRoute }}" class="eq8-bc__link">{{ $isAr ? 'المدونة' : 'Blog' }}</a></li>
                <li class="eq8-bc__sep">/</li>
                <li class="eq8-bc__current" style="max-width:260px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ $postTitle }}</li>
            </ol>
        </div>
    </nav>

    {{-- Post hero --}}
    <header class="eq8-post-hero">
        @if($imageUrl)
        <div class="eq8-post-hero__bg" style="background-image:url('{{ $imageUrl }}')"></div>
        <div class="eq8-post-hero__scrim"></div>
        @endif
        <div class="eq8-post-hero__inner">
            <h1 class="eq8-post-h1">{{ $postTitle }}</h1>
            <div class="eq8-post-meta-bar">
                @if($post->published_at)
                    <span class="eq8-post-meta-bar__item">
                        <svg class="eq8-post-meta-bar__icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span dir="ltr">{{ $post->published_at->format('d M Y') }}</span>
                    </span>
                @endif
                <span class="eq8-post-meta-bar__item">
                    <svg class="eq8-post-meta-bar__icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ $isAr ? $readMinutes . ' دقائق قراءة' : $readMinutes . ' min read' }}
                </span>
                <span class="eq8-post-meta-bar__item">{{ $siteName }}</span>
            </div>
        </div>
    </header>

    <article style="padding:40px 0 8px;background:var(--bg)">
        <div class="container mx-auto px-4" style="max-width:760px">

            {{-- Article body --}}
            <div class="eq8-post-card-body">
                <div class="richtext" dir="{{ $isAr ? 'rtl' : 'ltr' }}">
                    {!! \App\Helpers\RichText::clean($post->getTranslation('content', $locale)) !!}
                </div>
            </div>

            {{-- Back link --}}
            <div class="eq8-post-back">
                <a href="{{ $blogRoute }}" class="eq8-post-back__link">
                    @if($isAr)
                        <svg class="eq8-post-back__icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        العودة إلى المدونة
                    @else
                        <svg class="eq8-post-back__icon eq8-post-back__icon--flip" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        Back to Blog
                    @endif
                </a>
            </div>

        </div>
    </article>

    {{-- Related posts --}}
    @if($relatedPosts->isNotEmpty())
    <section class="eq8-related">
        <div class="eq8-related__inner">
            <h2 class="eq8-related__title">{{ $isAr ? 'مقالات ذات صلة' : 'Related Articles' }}</h2>

            <div class="swiper eq8-related__swiper">
                <div class="swiper-wrapper">
                    @foreach($relatedPosts as $rp)
                    @php
                        $rpTitle   = $rp->getTranslation('title', $locale);
                        $rpExcerpt = Str::limit(strip_tags($rp->getTranslation('excerpt', $locale)), 100);
                        $rpSlug    = $rp->getTranslation('slug', $locale);
                        $rpRoute   = $isAr ? route('posts.show', $rpSlug) : route('en.posts.show', $rpSlug);
                    @endphp
                    <div class="swiper-slide">
                        <a href="{{ $rpRoute }}" class="eq8-post-card">
                            @if($rp->featured_image)
                                <div class="eq8-post-card__img-wrap">
                                    <img src="{{ asset('storage/' . $rp->featured_image) }}"
                                         alt="{{ $rpTitle }}" loading="lazy" class="eq8-post-card__img">
                                </div>
                            @else
                                <div class="eq8-post-card__placeholder">
                                    <svg class="eq8-post-card__placeholder-icon" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"/>
                                    </svg>
                                </div>
                            @endif
                            <div class="eq8-post-card__body">
                                <h3 class="eq8-post-card__title">{{ $rpTitle }}</h3>
                                @if($rpExcerpt)
                                    <p class="eq8-post-card__excerpt">{{ $rpExcerpt }}</p>
                                @endif
                                <span class="eq8-post-card__cta">{{ $isAr ? 'اقرأ المزيد ←' : 'Read more →' }}</span>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="eq8-related__nav">
                <button type="button" class="eq8-related__nav-btn eq8-related__nav-prev" aria-label="{{ $isAr ? 'السابق' : 'Previous' }}">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button type="button" class="eq8-related__nav-btn eq8-related__nav-next" aria-label="{{ $isAr ? 'التالي' : 'Next' }}">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>
    </section>
    @endif

    {{-- CTA strip --}}
    <section class="eq8-post-cta">
        <div class="container mx-auto px-4" style="text-align:center;max-width:600px">
            <h2 class="eq8-post-cta__title">{{ $isAr ? 'احتاج فني كهربائي الآن؟' : 'Need an Electrician Now?' }}</h2>
            <p class="eq8-post-cta__sub">
                {{ $isAr
                    ? 'فنيو إلكتريك كويت معتمدون ومتاحون 24 ساعة في جميع مناطق الكويت.'
                    : 'ElectricQ8 certified technicians available 24 hours across all Kuwait areas.' }}
            </p>
            <div class="eq8-post-cta__actions">
                <a href="{{ \App\Helpers\WhatsAppHelper::url() }}" target="_blank" rel="noopener" class="eq8-post-cta__btn eq8-post-cta__btn--wa">
                    <span class="eq8-post-cta__btn-icon">
                        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.116 1.528 5.845L0 24l6.335-1.505A11.946 11.946 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.882a9.872 9.872 0 01-5.031-1.378l-.361-.214-3.741.981.999-3.648-.235-.374A9.869 9.869 0 012.118 12C2.118 6.963 6.963 2.118 12 2.118s9.882 4.845 9.882 9.882-4.845 9.882-9.882 9.882z"/></svg>
                    </span>
                    {{ $isAr ? 'واتساب الآن' : 'WhatsApp Now' }}
                </a>
                <a href="tel:{{ \App\Models\SiteSetting::get('phone_number') }}" class="eq8-post-cta__btn eq8-post-cta__btn--call">
                    <span class="eq8-post-cta__btn-icon">
                        <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    </span>
                    {{ $isAr ? 'اتصل الآن' : 'Call Now' }}
                </a>
                <a href="{{ $isAr ? route('services.index') : route('en.services.index') }}" class="eq8-post-cta__btn eq8-post-cta__btn--outline">
                    {{ $isAr ? 'عرض الخدمات' : 'View Services' }}
                </a>
            </div>
        </div>
    </section>

</div>

<style>
.eq8-bc { background:var(--altBg); border-bottom:1px solid var(--border); padding:10px 0; font-family:'Cairo',sans-serif; font-size:13px; }
.eq8-bc__inner { max-width:1000px; margin:0 auto; padding:0 16px; }
.eq8-bc__list { display:flex; align-items:center; gap:8px; list-style:none; margin:0; padding:0; flex-wrap:wrap; color:var(--muted); }
.eq8-bc__link { color:var(--primaryText); text-decoration:none; font-weight:600; }
.eq8-bc__link:hover { text-decoration:underline; }
.eq8-bc__sep { color:var(--border); }
.eq8-bc__current { color:var(--text); font-weight:600; }

/* Post hero */
.eq8-post-hero {
    position: relative;
    background: linear-gradient(135deg,#43230E 0%,#6B3A17 60%,#8B4D20 100%);
    padding: 56px 20px 40px;
    overflow: hidden;
}
.eq8-post-hero__bg {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center;
    opacity: .28;
    filter: saturate(1.1);
}
.eq8-post-hero__scrim {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(67,35,14,.88) 0%, rgba(107,58,23,.88) 60%, rgba(139,77,32,.85) 100%);
}
.eq8-post-hero__inner { position: relative; max-width: 780px; margin: 0 auto; }
.eq8-post-h1 { font-size:clamp(1.6rem,3.8vw,2.3rem); font-weight:800; color:#fff; margin:0 0 18px; line-height:1.35; font-family:'Cairo',system-ui,sans-serif; }

.eq8-post-meta-bar { display:flex; align-items:center; flex-wrap:wrap; gap:16px; font-size:.85rem; color:#F3D9BB; font-family:'Cairo',sans-serif; }
.eq8-post-meta-bar__item { display:flex; align-items:center; gap:5px; }
.eq8-post-meta-bar__icon { width:15px; height:15px; }

/* Article content card */
.eq8-post-card-body {
    background: var(--cardBg);
    border: 1px solid var(--border);
    border-radius: 18px;
    padding: 32px 28px;
}
@media (max-width: 560px) { .eq8-post-card-body { padding: 24px 18px; border-radius: 14px; } }

.eq8-post-back { margin-top:32px; padding-top:24px; }
.eq8-post-back__link { display:inline-flex; align-items:center; gap:7px; color:var(--accent); font-size:.85rem; font-weight:600; text-decoration:none; font-family:'Cairo',sans-serif; }
.eq8-post-back__link:hover { text-decoration:underline; }
.eq8-post-back__icon { width:16px; height:16px; }
.eq8-post-back__icon--flip { transform:rotate(180deg); }

/* Related posts */
.eq8-related { padding: 48px 0 56px; background: var(--altBg); }
.eq8-related__inner { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
.eq8-related__title {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--text);
    margin: 0 0 24px;
    font-family: 'Cairo',system-ui,sans-serif;
}
.eq8-related__swiper { padding-bottom: 4px; }
.eq8-related__swiper .swiper-slide { height: auto; }
.eq8-related__nav { display: flex; gap: 10px; margin-top: 20px; justify-content: flex-end; }
[dir="rtl"] .eq8-related__nav { justify-content: flex-start; }
.eq8-related__nav-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: var(--cardBg);
    border: 1px solid var(--border);
    color: var(--primaryText);
    cursor: pointer;
    transition: background .18s ease, border-color .18s ease, color .18s ease;
}
.eq8-related__nav-btn:hover { background: var(--primary); border-color: var(--primary); color: #fff; }
.eq8-related__nav-btn.swiper-button-disabled { opacity: .35; cursor: default; }
[dir="rtl"] .eq8-related__nav-prev svg,
[dir="rtl"] .eq8-related__nav-next svg { transform: scaleX(-1); }

.eq8-post-card { display:flex; flex-direction:column; height: 100%; background:var(--cardBg); border:1px solid var(--border); border-radius:16px; overflow:hidden; text-decoration:none; transition:box-shadow .25s,transform .25s,border-color .25s; }
.eq8-post-card:hover { box-shadow:0 8px 32px rgba(107,58,23,.12); transform:translateY(-4px); border-color:var(--accent); }

.eq8-post-card__img-wrap { overflow:hidden; }
.eq8-post-card__img { width:100%; height:160px; object-fit:cover; transition:transform .35s; }
.eq8-post-card:hover .eq8-post-card__img { transform:scale(1.05); }

.eq8-post-card__placeholder { width:100%; height:160px; background:var(--altBg); display:flex; align-items:center; justify-content:center; }
.eq8-post-card__placeholder-icon { width:44px; height:44px; color:var(--border); }

.eq8-post-card__body { padding:16px; display:flex; flex-direction:column; flex:1; }
.eq8-post-card__title { font-size:.88rem; font-weight:700; color:var(--text); margin:0 0 8px; line-height:1.45; font-family:'Cairo',sans-serif; }
.eq8-post-card__excerpt { font-size:.78rem; color:var(--body); line-height:1.65; flex:1; margin:0 0 12px; font-family:'Cairo',sans-serif; }
.eq8-post-card__cta { font-size:.8rem; font-weight:600; color:var(--accent); margin-top:auto; font-family:'Cairo',sans-serif; }

.eq8-post-cta {
    position: relative;
    background: linear-gradient(135deg,#43230E 0%,#6B3A17 60%,#8B4D20 100%);
    padding: 52px 20px;
    overflow: hidden;
}
.eq8-post-cta::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(ellipse at 50% 0%, rgba(217,123,46,.22) 0%, transparent 60%);
    pointer-events: none;
}
.eq8-post-cta__title { position: relative; font-size:1.5rem; font-weight:800; color:#fff; margin:0 0 10px; font-family:'Cairo',sans-serif; }
.eq8-post-cta__sub { position: relative; color:#F3D9BB; font-size:.9rem; margin:0 0 28px; line-height:1.7; font-family:'Cairo',sans-serif; }

.eq8-post-cta__actions { position: relative; display:flex; flex-wrap:wrap; justify-content:center; gap:12px; }
.eq8-post-cta__btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 6px 24px 6px 6px;
    border-radius: 999px;
    font-size: .92rem;
    font-weight: 700;
    text-decoration: none;
    white-space: nowrap;
    font-family: 'Cairo',sans-serif;
    transition: transform .2s ease, box-shadow .2s ease, background .18s ease, border-color .18s ease;
}
[dir="rtl"] .eq8-post-cta__btn { padding: 6px 6px 6px 24px; }
.eq8-post-cta__btn-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    flex-shrink: 0;
}
.eq8-post-cta__btn:hover { transform: translateY(-2px); box-shadow: 0 10px 24px rgba(0,0,0,.28); }

.eq8-post-cta__btn--wa { background:#25D366; color:#fff; }
.eq8-post-cta__btn--wa:hover { background:#20ba58; }
.eq8-post-cta__btn--wa .eq8-post-cta__btn-icon { background: rgba(0,0,0,.15); }

.eq8-post-cta__btn--call { background:transparent; color:#fff; border:2px solid rgba(255,255,255,.55); }
.eq8-post-cta__btn--call:hover { background:rgba(255,255,255,.1); border-color:#fff; }
.eq8-post-cta__btn--call .eq8-post-cta__btn-icon { background: rgba(255,255,255,.18); border: 1.5px solid rgba(255,255,255,.35); }

.eq8-post-cta__btn--outline { background:transparent; color:#fff; border:2px solid rgba(255,255,255,.4); padding: 12px 22px; }
.eq8-post-cta__btn--outline:hover { background:rgba(255,255,255,.1); border-color:#fff; }

@media (max-width: 480px) {
    .eq8-post-cta__actions { flex-direction: column; align-items: stretch; }
    .eq8-post-cta__btn { justify-content: center; }
}
</style>

@if($relatedPosts->isNotEmpty())
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (!window.Swiper) return;
    new window.Swiper('.eq8-related__swiper', {
        modules: [window.SwiperModules.Navigation],
        slidesPerView: 1.15,
        spaceBetween: 16,
        rtl: {{ $isAr ? 'true' : 'false' }},
        navigation: {
            nextEl: '.eq8-related__nav-next',
            prevEl: '.eq8-related__nav-prev',
        },
        breakpoints: {
            560:  { slidesPerView: 2, spaceBetween: 20 },
            900:  { slidesPerView: 3, spaceBetween: 20 },
            1200: { slidesPerView: 4, spaceBetween: 24 },
        },
    });
});
</script>
@endif
@endsection
