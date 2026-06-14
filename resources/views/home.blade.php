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
    <section class="bg-yellow-700 text-white py-20 text-center">
        <div class="container mx-auto px-4">
            <div class="inline-block bg-red-500 text-white text-sm font-bold px-4 py-2 rounded-full mb-4">
                {{ __('site.emergency.badge') }}
            </div>
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4">{{ __('site.hero.title') }}</h1>
            <p class="text-xl opacity-90 mb-8">{{ __('site.hero.subtitle') }}</p>
            <div class="flex gap-4 justify-center flex-wrap">
                <a href="{{ \App\Helpers\WhatsAppHelper::url() }}" target="_blank"
                   class="bg-green-500 hover:bg-green-600 text-white font-bold px-8 py-4 rounded-xl transition">
                    {{ __('site.hero.cta_whatsapp') }}
                </a>
                <a href="tel:{{ \App\Models\SiteSetting::get('phone_number') }}"
                   class="bg-white text-yellow-700 font-bold px-8 py-4 rounded-xl transition hover:bg-gray-100">
                    {{ __('site.hero.cta_call') }}
                </a>
            </div>
            {{-- Trust badges --}}
            <div class="flex flex-wrap justify-center gap-3 mt-8 text-sm font-semibold">
                <span class="bg-white/20 rounded-full px-4 py-2">⚡ فني كهربائي معتمد</span>
                <span class="bg-white/20 rounded-full px-4 py-2">🔧 ضمان 3 أشهر</span>
                <span class="bg-white/20 rounded-full px-4 py-2">📍 جميع مناطق الكويت</span>
                <span class="bg-white/20 rounded-full px-4 py-2">🕐 خدمة 24/7</span>
            </div>
        </div>
    </section>

    @include('partials.services-grid', ['services' => $services])
    @include('partials.areas-grid', ['locations' => $locations])
    @include('partials.testimonials', ['testimonials' => $testimonials])

    @include('partials.home-sections')
@endsection
