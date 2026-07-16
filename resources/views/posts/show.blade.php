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
        <div class="eq8-bc__inner" style="max-width:800px">
            <ol class="eq8-bc__list">
                <li><a href="{{ $isAr ? route('home') : route('en.home') }}" class="eq8-bc__link">{{ $isAr ? 'الرئيسية' : 'Home' }}</a></li>
                <li class="eq8-bc__sep">/</li>
                <li><a href="{{ $blogRoute }}" class="eq8-bc__link">{{ $isAr ? 'المدونة' : 'Blog' }}</a></li>
                <li class="eq8-bc__sep">/</li>
                <li class="eq8-bc__current" style="max-width:260px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ $postTitle }}</li>
            </ol>
        </div>
    </nav>

    <article style="padding:40px 0;background:var(--bg);min-height:60vh">
        <div class="container mx-auto px-4" style="max-width:760px">

            {{-- Featured image --}}
            @if($post->featured_image)
                <img src="{{ asset('storage/' . $post->featured_image) }}"
                     alt="{{ $postTitle }}"
                     class="eq8-post-featured-img">
            @endif

            {{-- H1 --}}
            <h1 class="eq8-post-h1">{{ $postTitle }}</h1>

            {{-- Meta --}}
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

            {{-- Article body --}}
            <div class="richtext" dir="{{ $isAr ? 'rtl' : 'ltr' }}">
                {!! \App\Helpers\RichText::clean($post->getTranslation('content', $locale)) !!}
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

    {{-- CTA strip --}}
    <section class="eq8-post-cta">
        <div class="container mx-auto px-4" style="text-align:center;max-width:600px">
            <h2 class="eq8-post-cta__title">{{ $isAr ? 'احتاج فني كهربائي الآن؟' : 'Need an Electrician Now?' }}</h2>
            <p class="eq8-post-cta__sub">
                {{ $isAr
                    ? 'فنيو إلكتريك كويت معتمدون ومتاحون 24 ساعة في جميع مناطق الكويت.'
                    : 'ElectricQ8 certified technicians available 24 hours across all Kuwait areas.' }}
            </p>
            <div style="display:flex;flex-wrap:wrap;justify-content:center;gap:10px">
                <a href="{{ \App\Helpers\WhatsAppHelper::url() }}" target="_blank" rel="noopener" class="eq8-btn eq8-btn--wa">
                    <svg class="eq8-btn__icon" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.116 1.528 5.845L0 24l6.335-1.505A11.946 11.946 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.882a9.872 9.872 0 01-5.031-1.378l-.361-.214-3.741.981.999-3.648-.235-.374A9.869 9.869 0 012.118 12C2.118 6.963 6.963 2.118 12 2.118s9.882 4.845 9.882 9.882-4.845 9.882-9.882 9.882z"/></svg>
                    {{ $isAr ? 'واتساب الآن' : 'WhatsApp Now' }}
                </a>
                <a href="tel:{{ \App\Models\SiteSetting::get('phone_number') }}" class="eq8-btn eq8-btn--call">
                    <svg class="eq8-btn__icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    {{ $isAr ? 'اتصل الآن' : 'Call Now' }}
                </a>
                <a href="{{ $isAr ? route('services.index') : route('en.services.index') }}" class="eq8-btn eq8-btn--outline">
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
.eq8-bc__link { color:var(--primary); text-decoration:none; font-weight:600; }
.eq8-bc__link:hover { text-decoration:underline; }
.eq8-bc__sep { color:var(--border); }
.eq8-bc__current { color:var(--text); font-weight:600; }

.eq8-post-featured-img { width:100%; border-radius:16px; margin-bottom:32px; object-fit:cover; max-height:380px; }
.eq8-post-h1 { font-size:clamp(1.5rem,3.5vw,2rem); font-weight:800; color:var(--text); margin:0 0 16px; line-height:1.35; font-family:'Cairo',system-ui,sans-serif; }

.eq8-post-meta-bar { display:flex; align-items:center; flex-wrap:wrap; gap:16px; font-size:.82rem; color:var(--muted); margin-bottom:32px; padding-bottom:24px; border-bottom:1px solid var(--border); font-family:'Cairo',sans-serif; }
.eq8-post-meta-bar__item { display:flex; align-items:center; gap:5px; }
.eq8-post-meta-bar__icon { width:15px; height:15px; }

.eq8-post-back { margin-top:40px; padding-top:24px; border-top:1px solid var(--border); }
.eq8-post-back__link { display:inline-flex; align-items:center; gap:7px; color:var(--accent); font-size:.85rem; font-weight:600; text-decoration:none; font-family:'Cairo',sans-serif; }
.eq8-post-back__link:hover { text-decoration:underline; }
.eq8-post-back__icon { width:16px; height:16px; }
.eq8-post-back__icon--flip { transform:rotate(180deg); }

.eq8-post-cta { background:linear-gradient(135deg,#43230E 0%,#6B3A17 100%); padding:48px 20px; }
.eq8-post-cta__title { font-size:1.4rem; font-weight:800; color:#fff; margin:0 0 10px; font-family:'Cairo',sans-serif; }
.eq8-post-cta__sub { color:#F3D9BB; font-size:.88rem; margin:0 0 24px; line-height:1.7; font-family:'Cairo',sans-serif; }

.eq8-btn--outline { display:inline-flex; align-items:center; gap:7px; border:2px solid rgba(255,255,255,.6); color:#fff; background:transparent; font-weight:700; padding:12px 22px; border-radius:12px; font-size:.88rem; text-decoration:none; transition:background .2s,border-color .2s; font-family:'Cairo',sans-serif; }
.eq8-btn--outline:hover { background:rgba(255,255,255,.1); border-color:#fff; }
</style>
@endsection
