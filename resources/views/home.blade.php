@extends('layouts.app')

@section('meta_title'){{ __('site.default_meta_title') }}@endsection

@section('meta_description'){{ __('site.default_meta_desc') }}@endsection

@section('schema_markup')
@php
    $phone      = \App\Models\SiteSetting::get('phone_number');
    $e164       = '+965' . preg_replace('/\D/', '', $phone);
    $siteName   = \App\Models\SiteSetting::get('site_name_' . app()->getLocale());
    $priceRange = '$$';
@endphp
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": ["LocalBusiness", "Electrician"],
  "name": "{{ $siteName }}",
  "url": "{{ url('/') }}",
  "logo": "{{ asset('images/logo.png') }}",
  "image": "{{ asset('images/og-default.jpg') }}",
  "description": "{{ __('site.default_meta_desc') }}",
  "telephone": "{{ $e164 }}",
  "priceRange": "{{ $priceRange }}",
  "address": {
    "@@type": "PostalAddress",
    "addressCountry": "KW",
    "addressRegion": "Kuwait City"
  },
  "geo": {
    "@@type": "GeoCoordinates",
    "latitude": 29.3759,
    "longitude": 47.9774
  },
  "areaServed": {
    "@@type": "Country",
    "name": "Kuwait"
  },
  "openingHoursSpecification": {
    "@@type": "OpeningHoursSpecification",
    "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
    "opens": "00:00",
    "closes": "23:59"
  },
  "availableLanguage": ["Arabic", "English"]
}
</script>
@endsection

@section('content')
    {{-- Hero --}}
    @php $isAr = app()->getLocale() === 'ar'; @endphp
    <section class="eq8-hero" dir="{{ $isAr ? 'rtl' : 'ltr' }}">
        <div class="eq8-hero__inner">
            <span class="eq8-hero__badge">
                <span class="eq8-hero__badge-dot"></span>
                {{ __('site.emergency.badge') }}
            </span>
            <h1 class="eq8-hero__title">{{ __('site.hero.title') }}</h1>
            <p class="eq8-hero__sub">{{ __('site.hero.subtitle') }}</p>
            <div class="eq8-hero__ctas">
                <a href="{{ \App\Helpers\WhatsAppHelper::url() }}" target="_blank" class="eq8-btn eq8-btn--wa">
                    <svg class="eq8-btn__icon" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.116 1.528 5.845L0 24l6.335-1.505A11.946 11.946 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.882a9.872 9.872 0 01-5.031-1.378l-.361-.214-3.741.981.999-3.648-.235-.374A9.869 9.869 0 012.118 12C2.118 6.963 6.963 2.118 12 2.118s9.882 4.845 9.882 9.882-4.845 9.882-9.882 9.882z"/>
                    </svg>
                    {{ __('site.hero.cta_whatsapp') }}
                </a>
                <a href="tel:{{ \App\Models\SiteSetting::get('phone_number') }}" class="eq8-btn eq8-btn--call">
                    <svg class="eq8-btn__icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    {{ __('site.hero.cta_call') }}
                </a>
            </div>
            <div class="eq8-hero__badges">
                <span class="eq8-hero__trust">⚡ {{ $isAr ? 'فني كهربائي معتمد' : 'Certified Electrician' }}</span>
                <span class="eq8-hero__trust">🔧 {{ $isAr ? 'ضمان 3 أشهر' : '3-Month Warranty' }}</span>
                <span class="eq8-hero__trust">📍 {{ $isAr ? 'جميع مناطق الكويت' : 'All Kuwait Areas' }}</span>
                <span class="eq8-hero__trust">🕐 {{ $isAr ? 'خدمة 24/7' : '24/7 Service' }}</span>
            </div>
        </div>
    </section>

    <style>
    .eq8-hero {
        background: linear-gradient(135deg, #43230E 0%, #6B3A17 60%, #8B4D20 100%);
        color: #fff;
        padding: 80px 0 72px;
        text-align: center;
        font-family: 'Cairo', system-ui, sans-serif;
        position: relative;
        overflow: hidden;
    }
    .eq8-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse at 60% 40%, rgba(217,123,46,.25) 0%, transparent 65%);
        pointer-events: none;
    }
    .eq8-hero__inner {
        position: relative;
        max-width: 860px;
        margin: 0 auto;
        padding: 0 20px;
    }
    .eq8-hero__badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(217,123,46,.25);
        border: 1px solid rgba(217,123,46,.4);
        color: #F3D9BB;
        font-size: .82rem;
        font-weight: 700;
        padding: 6px 16px;
        border-radius: 999px;
        margin-bottom: 24px;
    }
    .eq8-hero__badge-dot {
        width: 8px; height: 8px;
        border-radius: 50%;
        background: #D97B2E;
        animation: heroFlash 1.5s ease-in-out infinite;
    }
    @keyframes heroFlash {
        0%, 100% { opacity: 1; }
        50% { opacity: .3; }
    }
    .eq8-hero__title {
        font-size: clamp(2rem, 5vw, 3rem);
        font-weight: 800;
        line-height: 1.25;
        margin: 0 0 16px;
        color: #fff;
    }
    .eq8-hero__sub {
        font-size: 1.1rem;
        color: #F3D9BB;
        margin: 0 0 36px;
        opacity: .9;
    }
    .eq8-hero__ctas {
        display: flex;
        gap: 14px;
        justify-content: center;
        flex-wrap: wrap;
        margin-bottom: 32px;
    }
    .eq8-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-weight: 700;
        font-size: .95rem;
        padding: 14px 28px;
        border-radius: 12px;
        text-decoration: none;
        transition: transform .2s ease, box-shadow .2s ease, background .18s ease;
        font-family: 'Cairo', system-ui, sans-serif;
    }
    .eq8-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,.25); }
    .eq8-btn__icon { width: 20px; height: 20px; flex-shrink: 0; }
    .eq8-btn--wa  { background: #25D366; color: #fff; }
    .eq8-btn--wa:hover  { background: #20ba58; }
    .eq8-btn--call { background: rgba(255,255,255,.12); color: #fff; border: 1.5px solid rgba(255,255,255,.3); backdrop-filter: blur(4px); }
    .eq8-btn--call:hover { background: rgba(255,255,255,.22); }
    .eq8-hero__badges {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 10px;
    }
    .eq8-hero__trust {
        background: rgba(255,255,255,.12);
        border: 1px solid rgba(255,255,255,.2);
        color: #F3D9BB;
        font-size: .82rem;
        font-weight: 600;
        padding: 6px 16px;
        border-radius: 999px;
    }
    </style>

    @include('partials.services-grid', ['services' => $services])
    @include('partials.areas-grid', ['locations' => $locations])
    @include('partials.testimonials', ['testimonials' => $testimonials])

    @include('partials.home-sections')
@endsection
