@extends('layouts.app')

@php
    $isAr   = app()->getLocale() === 'ar';
    $locale = $isAr ? 'ar' : 'en';
    $prefix = $isAr ? '' : 'en.';

    $title   = $pillar->getTranslation('title',   $locale);
    $h1      = $title;
    $content = $pillar->getTranslation('content', $locale);

    $metaTitle = $pillar->getTranslation('meta_title',       $locale) ?: $title;
    $metaDesc  = $pillar->getTranslation('meta_description', $locale) ?: '';
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
            <h1 class="eq8-page-hero__title">{{ $h1 }}</h1>
        </div>
    </section>

    {{-- Pillar image --}}
    @if($pillar->image_url)
    <section style="padding:48px 0 {{ $content ? '0' : '48px' }};background:var(--bg)">
        <div class="container mx-auto px-4" style="max-width:960px">
            <img src="{{ $pillar->image_url }}" alt="{{ $title }}" class="eq8-pillar-image">
        </div>
    </section>
    @endif

    {{-- Rich content --}}
    @if($content)
    <section style="padding:48px 0;background:var(--bg)">
        <div class="container mx-auto px-4" style="max-width:960px">
            <div class="richtext" dir="{{ $isAr ? 'rtl' : 'ltr' }}">{!! \App\Helpers\RichText::clean($content) !!}</div>
        </div>
    </section>
    @endif

    {{-- Clusters in pillar --}}
    @if($pillar->clusters->count())
    <section style="padding:48px 0;background:var(--altBg)">
        <div class="container mx-auto px-4">
            <div class="eq8-section-head">
                <h2 class="eq8-section-title">{{ $isAr ? 'التصنيفات' : 'Categories' }}</h2>
            </div>
            <div class="eq8-pillar-grid">
                @foreach($pillar->clusters as $cluster)
                @php
                    $clusterSlug = $cluster->getTranslation('slug', $locale);
                    $clusterName = $cluster->getTranslation('title', $locale);
                @endphp
                <a href="{{ route($prefix . 'clusters.show', $clusterSlug) }}" class="eq8-cluster-card">
                    @if($cluster->image_url)
                        <img src="{{ $cluster->image_url }}" alt="{{ $clusterName }}" class="eq8-cluster-card__img">
                    @endif
                    <h3 class="eq8-cluster-card__title">{{ $clusterName }}</h3>
                    <p class="eq8-cluster-card__count">
                        {{ $cluster->services->count() }} {{ $isAr ? 'خدمة' : 'services' }}
                    </p>
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
.eq8-bc__link { color:var(--primaryText); text-decoration:none; font-weight:600; }
.eq8-bc__link:hover { text-decoration:underline; }
.eq8-bc__sep { color:var(--border); }
.eq8-bc__current { color:var(--text); font-weight:600; }

.eq8-page-hero { background:linear-gradient(135deg,#43230E 0%,#6B3A17 60%,#8B4D20 100%); color:#fff; padding:56px 20px; text-align:center; }
.eq8-page-hero__inner { max-width:760px; margin:0 auto; }
.eq8-page-hero__title { font-size:clamp(1.6rem,4vw,2.4rem); font-weight:800; margin:0; font-family:'Cairo',system-ui,sans-serif; }

.eq8-pillar-image { width:100%; height:auto; max-height:520px; object-fit:contain; border-radius:18px; border:1px solid var(--border); display:block; margin:0 auto; }

.eq8-pillar-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:16px; max-width:1000px; margin:0 auto; }
@media(max-width:760px){ .eq8-pillar-grid { grid-template-columns:repeat(2,1fr); } }
@media(max-width:480px){ .eq8-pillar-grid { grid-template-columns:1fr; } }

.eq8-cluster-card { display:block; background:var(--cardBg); border:1px solid var(--border); border-radius:16px; padding:20px; text-decoration:none; transition:border-color .2s,box-shadow .2s; }
.eq8-cluster-card:hover { border-color:var(--accent); box-shadow:0 4px 20px rgba(107,58,23,.1); }
.eq8-cluster-card__img { width:48px; height:48px; border-radius:10px; object-fit:cover; margin-bottom:14px; }
.eq8-cluster-card__title { font-size:.9rem; font-weight:700; color:var(--text); margin:0 0 6px; font-family:'Cairo',sans-serif; }
.eq8-cluster-card__count { font-size:.78rem; font-weight:600; color:var(--accent); margin:0; font-family:'Cairo',sans-serif; }

.eq8-cta-band { background:linear-gradient(135deg,#43230E 0%,#6B3A17 100%); padding:56px 20px; }
</style>
@endsection
