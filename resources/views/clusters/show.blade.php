@extends('layouts.app')

@php
    $isAr   = app()->getLocale() === 'ar';
    $locale = $isAr ? 'ar' : 'en';
    $prefix = $isAr ? '' : 'en.';

    $title   = $cluster->getTranslation('title',  $locale);
    $h1      = $title;
    $content = $cluster->getTranslation('content',$locale);

    $metaTitle = $cluster->getTranslation('meta_title', $locale)       ?: $title;
    $metaDesc  = $cluster->getTranslation('meta_description', $locale) ?: '';
@endphp

@section('meta_title'){{ $metaTitle }}@endsection
@section('meta_description'){{ $metaDesc }}@endsection

@section('content')
<div dir="{{ $isAr ? 'rtl' : 'ltr' }}">

    {{-- Breadcrumb --}}
    <nav class="eq8-bc">
        <div class="eq8-bc__inner">
            <ol class="eq8-bc__list">
                <li><a href="{{ route($prefix . 'home') }}" class="eq8-bc__link">{{ $isAr ? 'الرئيسية' : 'Home' }}</a></li>
                <li class="eq8-bc__sep">/</li>
                <li><a href="{{ route($prefix . 'services.index') }}" class="eq8-bc__link">{{ $isAr ? 'الخدمات' : 'Services' }}</a></li>
                <li class="eq8-bc__sep">/</li>
                <li class="eq8-bc__current" aria-current="page">{{ $title }}</li>
            </ol>
        </div>
    </nav>

    {{-- Hero --}}
    <section class="eq8-page-hero">
        <div class="eq8-page-hero__inner">
            @if($cluster->image_url)
                <img src="{{ $cluster->image_url }}" alt="{{ $title }}" style="width:96px;height:96px;border-radius:16px;object-fit:cover;margin:0 auto 20px;display:block;box-shadow:0 4px 20px rgba(0,0,0,.3)">
            @endif
            <h1 class="eq8-page-hero__title">{{ $h1 }}</h1>
        </div>
    </section>

    {{-- Rich content --}}
    @if($content)
    <section style="padding:48px 0;background:var(--bg)">
        <div class="container mx-auto px-4" style="max-width:960px">
            <div class="richtext" dir="{{ $isAr ? 'rtl' : 'ltr' }}">{!! \App\Helpers\RichText::clean($content) !!}</div>
        </div>
    </section>
    @endif

    {{-- Services in cluster --}}
    @if($cluster->services->count())
    <section style="padding:48px 0;background:var(--altBg)">
        <div class="container mx-auto px-4">
            <div class="eq8-section-head">
                <h2 class="eq8-section-title">{{ $isAr ? 'الخدمات المتاحة' : 'Available Services' }}</h2>
            </div>
            <div class="eq8-cluster-grid">
                @foreach($cluster->services as $service)
                <a href="{{ route($prefix . 'services.show', $service->getTranslation('slug', $locale)) }}"
                   class="eq8-svc-card">
                    <div class="eq8-svc-card__icon">{{ $service->icon() }}</div>
                    <h3 class="eq8-svc-card__title">{{ $service->getTranslation('title', $locale) }}</h3>
                    <p class="eq8-svc-card__body">{{ html_entity_decode(strip_tags($service->getTranslation('intro', $locale)), ENT_QUOTES | ENT_HTML5, 'UTF-8') }}</p>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- CTA --}}
    <section class="eq8-cta-band">
        <div class="container mx-auto px-4" style="text-align:center;max-width:600px">
            <h2 style="font-size:1.5rem;font-weight:800;color:#fff;margin:0 0 24px;font-family:'Cairo',sans-serif">
                {{ $isAr ? 'تواصل معنا الآن' : 'Contact Us Now' }}
            </h2>
            @include('partials.hero-btns', [
                'waLabel'   => $isAr ? 'واتساب' : 'WhatsApp',
                'callLabel' => $isAr ? 'اتصل الآن' : 'Call Now',
            ])
        </div>
    </section>

</div>

<style>
.eq8-bc { background:var(--altBg); border-bottom:1px solid var(--border); padding:10px 0; font-family:'Cairo',sans-serif; font-size:13px; }
.eq8-bc__inner { max-width:1100px; margin:0 auto; padding:0 16px; }
.eq8-bc__list { display:flex; align-items:center; gap:8px; list-style:none; margin:0; padding:0; flex-wrap:wrap; color:var(--muted); }
.eq8-bc__link { color:var(--primary); text-decoration:none; font-weight:600; }
.eq8-bc__link:hover { text-decoration:underline; }
.eq8-bc__sep { color:var(--border); }
.eq8-bc__current { color:var(--text); font-weight:600; }

.eq8-page-hero { background:linear-gradient(135deg,#43230E 0%,#6B3A17 60%,#8B4D20 100%); color:#fff; padding:56px 20px; text-align:center; }
.eq8-page-hero__inner { max-width:760px; margin:0 auto; }
.eq8-page-hero__title { font-size:clamp(1.6rem,4vw,2.4rem); font-weight:800; margin:0; font-family:'Cairo',system-ui,sans-serif; }

.eq8-cluster-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:16px; max-width:1000px; margin:0 auto; }
@media(max-width:760px){ .eq8-cluster-grid { grid-template-columns:repeat(2,1fr); } }
@media(max-width:480px){ .eq8-cluster-grid { grid-template-columns:1fr; } }

.eq8-svc-card { display:block; background:var(--cardBg); border:1px solid var(--border); border-radius:16px; padding:20px; text-decoration:none; transition:border-color .2s,box-shadow .2s; }
.eq8-svc-card:hover { border-color:var(--accent); box-shadow:0 4px 20px rgba(107,58,23,.1); }
.eq8-svc-card__icon { font-size:1.8rem; margin-bottom:10px; }
.eq8-svc-card__title { font-size:.9rem; font-weight:700; color:var(--text); margin:0 0 6px; font-family:'Cairo',sans-serif; }
.eq8-svc-card__body { font-size:.78rem; color:var(--body); line-height:1.65; margin:0; font-family:'Cairo',sans-serif; }

.eq8-cta-band { background:linear-gradient(135deg,#43230E 0%,#6B3A17 100%); padding:56px 20px; }
</style>
@endsection
