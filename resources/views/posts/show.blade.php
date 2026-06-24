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

@section('meta_title')
    {{ $post->getTranslation('meta_title', $locale) ?: $postTitle }}
@endsection

@section('meta_description')
    {{ $post->getTranslation('meta_description', $locale) ?: $postExcerpt }}
@endsection

{{-- ── Article Schema ── --}}
@push('head')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "Article",
  "headline": {{ json_encode($postTitle) }},
  "description": {{ json_encode($postExcerpt) }},
  @if($imageUrl)
  "image": {{ json_encode($imageUrl) }},
  @endif
  @if($post->published_at)
  "datePublished": "{{ $post->published_at->toIso8601String() }}",
  "dateModified": "{{ ($post->updated_at ?? $post->published_at)->toIso8601String() }}",
  @endif
  "author": {
    "@@type": "Organization",
    "name": {{ json_encode($siteName) }},
    "url": {{ json_encode($siteUrl) }}
  },
  "publisher": {
    "@@type": "Organization",
    "name": {{ json_encode($siteName) }},
    "url": {{ json_encode($siteUrl) }}
  },
  "mainEntityOfPage": {
    "@@type": "WebPage",
    "@@id": {{ json_encode($postUrl) }}
  },
  "inLanguage": "{{ $isAr ? 'ar' : 'en' }}"
}
</script>
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@@type": "ListItem",
      "position": 1,
      "name": {{ json_encode($isAr ? 'الرئيسية' : 'Home') }},
      "item": {{ json_encode($siteUrl . ($isAr ? '' : '/en')) }}
    },
    {
      "@@type": "ListItem",
      "position": 2,
      "name": {{ json_encode($isAr ? 'المدونة' : 'Blog') }},
      "item": {{ json_encode($blogRoute) }}
    },
    {
      "@@type": "ListItem",
      "position": 3,
      "name": {{ json_encode($postTitle) }},
      "item": {{ json_encode($postUrl) }}
    }
  ]
}
</script>
@endpush

@section('content')
<div dir="{{ $isAr ? 'rtl' : 'ltr' }}">

    {{-- Breadcrumb --}}
    <nav class="bg-gray-50 border-b border-gray-200 py-3" aria-label="breadcrumb">
        <div class="container mx-auto px-4 max-w-3xl">
            <ol class="flex items-center flex-wrap gap-1 text-xs text-gray-500">
                <li>
                    <a href="{{ $isAr ? route('home') : route('en.home') }}"
                       class="hover:text-yellow-600 transition">{{ $isAr ? 'الرئيسية' : 'Home' }}</a>
                </li>
                <li class="text-gray-300 mx-1">/</li>
                <li>
                    <a href="{{ $blogRoute }}" class="hover:text-yellow-600 transition">{{ $isAr ? 'المدونة' : 'Blog' }}</a>
                </li>
                <li class="text-gray-300 mx-1">/</li>
                <li class="text-gray-700 truncate max-w-xs">{{ $postTitle }}</li>
            </ol>
        </div>
    </nav>

    <article class="py-10 bg-white min-h-screen">
        <div class="container mx-auto px-4 max-w-3xl">

            {{-- Featured image --}}
            @if($post->featured_image)
                <img src="{{ asset('storage/' . $post->featured_image) }}"
                     alt="{{ $postTitle }}"
                     class="w-full rounded-2xl mb-8 object-cover max-h-96">
            @endif

            {{-- H1 --}}
            <h1 class="text-3xl font-extrabold text-gray-900 mb-4 leading-tight">
                {{ $postTitle }}
            </h1>

            {{-- Meta: date + reading time --}}
            <div class="flex items-center flex-wrap gap-4 text-sm text-gray-400 mb-8 pb-6 border-b border-gray-100">
                @if($post->published_at)
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span dir="ltr">{{ $post->published_at->format('d M Y') }}</span>
                    </span>
                @endif
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ $isAr ? $readMinutes . ' دقائق قراءة' : $readMinutes . ' min read' }}
                </span>
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    {{ $siteName }}
                </span>
            </div>

            {{-- Article body --}}
            <div class="richtext" dir="{{ $isAr ? 'rtl' : 'ltr' }}">
                {!! \App\Helpers\RichText::clean($post->getTranslation('content', $locale)) !!}
            </div>

            {{-- Back link --}}
            <div class="mt-10 pt-6 border-t border-gray-100">
                <a href="{{ $blogRoute }}"
                   class="inline-flex items-center gap-2 text-yellow-600 text-sm font-medium hover:underline">
                    @if($isAr)
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        العودة إلى المدونة
                    @else
                        <svg class="w-4 h-4 rotate-180" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        Back to Blog
                    @endif
                </a>
            </div>

        </div>
    </article>

    {{-- ── Related Services strip ── --}}
    <section class="py-10 bg-yellow-700 text-white">
        <div class="container mx-auto px-4 text-center max-w-2xl">
            <h2 class="text-xl font-extrabold mb-2">
                {{ $isAr ? 'احتاج فني كهربائي الآن؟' : 'Need an AC Technician Now?' }}
            </h2>
            <p class="opacity-90 mb-6 text-sm">
                {{ $isAr
                    ? 'فنيو إلكتريك كويت معتمدون ومتاحون 24 ساعة في جميع مناطق الكويت.'
                    : 'ElectricQ8 certified technicians available 24 hours across all Kuwait areas.' }}
            </p>
            <div class="flex flex-wrap justify-center gap-3">
                <a href="{{ \App\Helpers\WhatsAppHelper::url() }}" target="_blank" rel="noopener"
                   class="bg-green-500 hover:bg-green-600 text-white font-bold px-6 py-3 rounded-xl transition text-sm">
                    {{ $isAr ? 'واتساب الآن' : 'WhatsApp Now' }}
                </a>
                <a href="tel:{{ \App\Models\SiteSetting::get('phone_number') }}"
                   class="bg-white text-yellow-700 font-bold px-6 py-3 rounded-xl transition hover:bg-gray-100 text-sm">
                    {{ $isAr ? 'اتصل الآن' : 'Call Now' }}
                </a>
                <a href="{{ $isAr ? route('services.index') : route('en.services.index') }}"
                   class="border border-white text-white font-bold px-6 py-3 rounded-xl transition hover:bg-yellow-600 text-sm">
                    {{ $isAr ? 'عرض الخدمات' : 'View Services' }}
                </a>
            </div>
        </div>
    </section>

</div>
@endsection
