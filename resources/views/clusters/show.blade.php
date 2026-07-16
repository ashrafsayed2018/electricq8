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
            <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap">
                <a href="{{ \App\Helpers\WhatsAppHelper::url() }}" target="_blank" class="eq8-btn eq8-btn--wa">
                    <svg class="eq8-btn__icon" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.116 1.528 5.845L0 24l6.335-1.505A11.946 11.946 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.882a9.872 9.872 0 01-5.031-1.378l-.361-.214-3.741.981.999-3.648-.235-.374A9.869 9.869 0 012.118 12C2.118 6.963 6.963 2.118 12 2.118s9.882 4.845 9.882 9.882-4.845 9.882-9.882 9.882z"/></svg>
                    {{ $isAr ? 'واتساب' : 'WhatsApp' }}
                </a>
                <a href="tel:{{ \App\Models\SiteSetting::get('phone_number') }}" class="eq8-btn eq8-btn--call">
                    <svg class="eq8-btn__icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    {{ $isAr ? 'اتصل الآن' : 'Call Now' }}
                </a>
            </div>
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
