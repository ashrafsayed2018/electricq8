@extends('layouts.app')

@php
    $isAr   = app()->getLocale() === 'ar';
    $locale = $isAr ? 'ar' : 'en';
    $prefix = $isAr ? '' : 'en.';
@endphp

@section('meta_title')
    {{ $isAr ? 'خريطة الموقع | إلكتريك كويت' : 'Sitemap | ElectricQ8' }}
@endsection

@section('meta_description')
    {{ $isAr
        ? 'خريطة موقع إلكتريك كويت — جميع الخدمات والمناطق والمقالات وصفحات الموقع.'
        : 'ElectricQ8 sitemap — all services, areas, articles and pages on the site.' }}
@endsection

@section('content')
<div dir="{{ $isAr ? 'rtl' : 'ltr' }}" style="background:var(--bg)">

    {{-- Breadcrumb --}}
    <nav class="eq8-bc">
        <div class="eq8-bc__inner">
            <ol class="eq8-bc__list">
                <li><a href="{{ route($prefix . 'home') }}" class="eq8-bc__link">{{ $isAr ? 'الرئيسية' : 'Home' }}</a></li>
                <li class="eq8-bc__sep">/</li>
                <li class="eq8-bc__current" aria-current="page">{{ $isAr ? 'خريطة الموقع' : 'Sitemap' }}</li>
            </ol>
        </div>
    </nav>

    {{-- Page header --}}
    <div class="eq8-page-hero" style="padding:48px 0">
        <div class="eq8-page-hero__inner">
            <h1 class="eq8-page-hero__title">{{ $isAr ? 'خريطة الموقع' : 'Sitemap' }}</h1>
            <p style="color:#F3D9BB;font-size:.9rem;margin:0;font-family:'Cairo',sans-serif;opacity:.9">
                {{ $isAr ? 'كل صفحات الموقع في مكان واحد' : 'Every page on the site, in one place' }}
            </p>
        </div>
    </div>

    <div class="eq8-sitemap-wrap">
        <div class="eq8-sitemap-inner">

            {{-- Main pages --}}
            <section class="eq8-sm-block">
                <h2 class="eq8-sm-title">{{ $isAr ? 'الصفحات الرئيسية' : 'Main Pages' }}</h2>
                <ul class="eq8-sm-list">
                    <li><a href="{{ route($prefix . 'home') }}" class="eq8-sm-link">{{ $isAr ? 'الرئيسية' : 'Home' }}</a></li>
                    <li><a href="{{ route($prefix . 'services.index') }}" class="eq8-sm-link">{{ $isAr ? 'الخدمات' : 'Services' }}</a></li>
                    <li><a href="{{ route($prefix . 'areas.index') }}" class="eq8-sm-link">{{ $isAr ? 'مناطق الخدمة' : 'Service Areas' }}</a></li>
                    <li><a href="{{ route($prefix . 'posts.index') }}" class="eq8-sm-link">{{ $isAr ? 'المدونة' : 'Blog' }}</a></li>
                    <li><a href="{{ route($prefix . 'about') }}" class="eq8-sm-link">{{ $isAr ? 'من نحن' : 'About Us' }}</a></li>
                    <li><a href="{{ route($prefix . 'contact') }}" class="eq8-sm-link">{{ $isAr ? 'تواصل معنا' : 'Contact' }}</a></li>
                    <li><a href="{{ route($prefix . 'gallery') }}" class="eq8-sm-link">{{ $isAr ? 'معرض الصور' : 'Gallery' }}</a></li>
                    <li><a href="{{ route('privacy') }}" class="eq8-sm-link">{{ $isAr ? 'سياسة الخصوصية والشروط' : 'Privacy & Terms' }}</a></li>
                </ul>
            </section>

            {{-- Pillars & Clusters --}}
            @if($pillars->isNotEmpty())
            <section class="eq8-sm-block">
                <h2 class="eq8-sm-title">{{ $isAr ? 'محاور المحتوى' : 'Content Pillars' }}</h2>
                <div class="eq8-sm-pillars">
                    @foreach($pillars as $pillar)
                    <div class="eq8-sm-pillar">
                        <a href="{{ route($prefix . 'pillars.show', $pillar->getTranslation('slug', $locale)) }}"
                           class="eq8-sm-pillar__title">{{ $pillar->getTranslation('title', $locale) }}</a>
                        @if($pillar->clusters->isNotEmpty())
                        <ul class="eq8-sm-list eq8-sm-list--nested">
                            @foreach($pillar->clusters as $cluster)
                            <li><a href="{{ route($prefix . 'clusters.show', $cluster->getTranslation('slug', $locale)) }}"
                                   class="eq8-sm-link">{{ $cluster->getTranslation('title', $locale) }}</a></li>
                            @endforeach
                        </ul>
                        @endif
                    </div>
                    @endforeach
                </div>
            </section>
            @endif

            {{-- Services --}}
            @if($services->isNotEmpty())
            <section class="eq8-sm-block">
                <h2 class="eq8-sm-title">{{ $isAr ? 'جميع الخدمات' : 'All Services' }}</h2>
                <ul class="eq8-sm-list eq8-sm-list--grid">
                    @foreach($services as $service)
                    <li><a href="{{ route($prefix . 'services.show', $service->getTranslation('slug', $locale)) }}"
                           class="eq8-sm-link">{{ $service->title }}</a></li>
                    @endforeach
                </ul>
            </section>
            @endif

            {{-- Areas --}}
            @if($locations->isNotEmpty())
            <section class="eq8-sm-block">
                <h2 class="eq8-sm-title">{{ $isAr ? 'جميع المناطق' : 'All Areas' }}</h2>
                <ul class="eq8-sm-list eq8-sm-list--grid">
                    @foreach($locations as $location)
                    <li><a href="{{ route($prefix . 'areas.show', $location->getTranslation('slug', $locale)) }}"
                           class="eq8-sm-link">{{ $location->getTranslation('name', $locale) }}</a></li>
                    @endforeach
                </ul>
            </section>
            @endif

            {{-- Articles --}}
            @if($posts->isNotEmpty())
            <section class="eq8-sm-block">
                <h2 class="eq8-sm-title">{{ $isAr ? 'جميع المقالات' : 'All Articles' }}</h2>
                <ul class="eq8-sm-list eq8-sm-list--grid">
                    @foreach($posts as $post)
                    <li><a href="{{ route($prefix . 'posts.show', $post->getTranslation('slug', $locale)) }}"
                           class="eq8-sm-link">{{ $post->getTranslation('title', $locale) }}</a></li>
                    @endforeach
                </ul>
            </section>
            @endif

        </div>
    </div>

</div>

<style>
.eq8-sitemap-wrap { padding: 56px 0 64px; }
.eq8-sitemap-inner { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
.eq8-sm-block { margin-bottom: 44px; }
.eq8-sm-block:last-child { margin-bottom: 0; }
.eq8-sm-title {
    font-size: 1.3rem;
    font-weight: 800;
    color: var(--primaryText);
    margin: 0 0 16px;
    padding-bottom: 12px;
    border-bottom: 2px solid var(--border);
    font-family: 'Cairo', system-ui, sans-serif;
}
.eq8-sm-list {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    gap: 4px;
}
.eq8-sm-list--grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 6px 16px;
}
@media (max-width: 900px) { .eq8-sm-list--grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 540px) { .eq8-sm-list--grid { grid-template-columns: 1fr; } }
.eq8-sm-list--nested { margin-top: 8px; margin-inline-start: 18px; }
.eq8-sm-link {
    display: inline-block;
    padding: 6px 0;
    color: var(--body);
    text-decoration: none;
    font-size: .92rem;
    font-weight: 600;
    font-family: 'Cairo', system-ui, sans-serif;
    border-bottom: 1px solid transparent;
    transition: color .15s ease, border-color .15s ease;
}
.eq8-sm-link:hover { color: var(--accent); border-color: var(--accent); }
.eq8-sm-pillars { display: flex; flex-direction: column; gap: 20px; }
.eq8-sm-pillar__title {
    display: inline-block;
    font-size: 1.02rem;
    font-weight: 800;
    color: var(--text);
    text-decoration: none;
    font-family: 'Cairo', system-ui, sans-serif;
}
.eq8-sm-pillar__title:hover { color: var(--accent); }
</style>
@endsection
