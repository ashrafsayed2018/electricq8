@extends('layouts.app')

@php
    $isAr      = app()->getLocale() === 'ar';
    $locale    = app()->getLocale();
    $prefix    = $isAr ? '' : 'en.';
    $siteName  = \App\Models\SiteSetting::get('site_name_' . $locale) ?: 'ElectricQ8';
    $siteUrl   = config('app.url');
    $pageUrl   = url()->current();
    $phone     = \App\Models\SiteSetting::get('phone_number');

    $pageTitle = $page->getTranslation('meta_title', $locale)
              ?: $page->getTranslation('title', $locale);
    $pageDesc  = $page->getTranslation('meta_description', $locale)
              ?: $page->getTranslation('intro', $locale);
    $h1        = $page->getTranslation('h1', $locale)
              ?: $page->getTranslation('title', $locale);

    $sName     = $service->getTranslation('title', $locale);
    $lName     = $location->getTranslation('name', $locale);
    $sSlug     = $service->getTranslation('slug', $locale);
    $lSlug     = $location->getTranslation('slug', $locale);

    // Build FAQ
    $faqs = $isAr ? [
        ['q' => "كم تستغرق خدمة {$sName} في {$lName}؟",
         'a' => "تستغرق عادةً بين ساعة وثلاث ساعات حسب حجم الجهاز وطبيعة المشكلة. فنيونا في {$lName} يقدمون تقديرًا دقيقًا قبل بدء العمل."],
        ['q' => "ما هو سعر {$sName} في {$lName}؟",
         'a' => "الأسعار تبدأ من " . ($service->price_from ? number_format($service->price_from) . ' د.ك' : 'سعر تنافسي') . ". نقدم عرض سعر مجاني قبل بدء العمل بدون أي التزام."],
        ['q' => "هل تصلون إلى {$lName} في نفس اليوم؟",
         'a' => "نعم، نغطي {$lName} على مدار الساعة 7 أيام في الأسبوع. وقت الاستجابة المتوسط ساعة واحدة."],
        ['q' => "هل توجد ضمان على خدمة {$sName}؟",
         'a' => "نعم، جميع خدماتنا مضمونة لمدة 3 أشهر. إذا عادت المشكلة خلال فترة الضمان نصلحها مجانًا."],
    ] : [
        ['q' => "How long does {$sName} take in {$lName}?",
         'a' => "It typically takes 1–3 hours depending on the unit size and problem. Our {$lName} technicians provide an accurate estimate before starting."],
        ['q' => "What is the cost of {$sName} in {$lName}?",
         'a' => "Prices start from " . ($service->price_from ? 'KWD ' . number_format($service->price_from) : 'competitive rates') . ". We provide a free quote before any work begins."],
        ['q' => "Do you offer same-day service in {$lName}?",
         'a' => "Yes, we cover {$lName} 24/7. Average response time is one hour."],
        ['q' => "Is there a warranty on {$sName}?",
         'a' => "Yes, all our services carry a 3-month warranty. If the issue returns within the warranty period we fix it free of charge."],
    ];
@endphp

@section('meta_title') {{ $pageTitle }} @endsection
@section('meta_description') {{ $pageDesc }} @endsection

@if($page->noindex)
@section('robots', 'noindex, follow')
@endif

@push('head')
{{-- Service Schema --}}
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "Service",
  "name": {{ json_encode($h1) }},
  "description": {{ json_encode($pageDesc) }},
  "provider": {
    "@@type": "LocalBusiness",
    "name": {{ json_encode($siteName) }},
    "telephone": {{ json_encode($phone) }},
    "address": {
      "@@type": "PostalAddress",
      "addressLocality": {{ json_encode($lName) }},
      "addressCountry": "KW"
    }
  },
  "areaServed": {
    "@@type": "City",
    "name": {{ json_encode($lName) }}
  }@if($service->price_from),
  "offers": {
    "@@type": "Offer",
    "priceCurrency": "KWD",
    "price": "{{ $service->price_from }}"
  }@endif
}
</script>

{{-- FAQPage Schema --}}
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "FAQPage",
  "mainEntity": [
    @foreach($faqs as $i => $faq)
    {
      "@@type": "Question",
      "name": {{ json_encode($faq['q']) }},
      "acceptedAnswer": { "@@type": "Answer", "text": {{ json_encode($faq['a']) }} }
    }{{ $loop->last ? '' : ',' }}
    @endforeach
  ]
}
</script>

{{-- BreadcrumbList Schema --}}
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "BreadcrumbList",
  "itemListElement": [
    { "@@type": "ListItem", "position": 1, "name": {{ json_encode($isAr ? 'الرئيسية' : 'Home') }},     "item": {{ json_encode($siteUrl . ($isAr ? '' : '/en')) }} },
    { "@@type": "ListItem", "position": 2, "name": {{ json_encode($isAr ? 'الخدمات' : 'Services') }}, "item": {{ json_encode(route($prefix . 'services.index')) }} },
    { "@@type": "ListItem", "position": 3, "name": {{ json_encode($sName) }},                          "item": {{ json_encode(route($prefix . 'services.show', $sSlug)) }} },
    { "@@type": "ListItem", "position": 4, "name": {{ json_encode($h1) }},                             "item": {{ json_encode($pageUrl) }} }
  ]
}
</script>
@endpush

@section('content')
<div dir="{{ $isAr ? 'rtl' : 'ltr' }}">

    {{-- ── Breadcrumb ── --}}
    <nav class="bg-gray-50 border-b border-gray-200 py-3" aria-label="breadcrumb">
        <div class="container mx-auto px-4">
            <ol class="flex items-center flex-wrap gap-1 text-xs text-gray-500">
                <li><a href="{{ route($prefix . 'home') }}" class="hover:text-yellow-600 transition">{{ $isAr ? 'الرئيسية' : 'Home' }}</a></li>
                <li class="text-gray-300 mx-1">/</li>
                <li><a href="{{ route($prefix . 'services.index') }}" class="hover:text-yellow-600 transition">{{ $isAr ? 'الخدمات' : 'Services' }}</a></li>
                <li class="text-gray-300 mx-1">/</li>
                <li><a href="{{ route($prefix . 'services.show', $sSlug) }}" class="hover:text-yellow-600 transition">{{ $sName }}</a></li>
                <li class="text-gray-300 mx-1">/</li>
                <li class="text-gray-700 font-medium">{{ $lName }}</li>
            </ol>
        </div>
    </nav>

    {{-- ── Hero ── --}}
    <section class="bg-gradient-to-br from-yellow-700 to-yellow-900 text-white py-14">
        <div class="container mx-auto px-4 max-w-3xl text-center">
            <div class="inline-flex items-center gap-2 bg-yellow-600/40 text-yellow-200 text-xs font-semibold px-3 py-1 rounded-full mb-4">
                <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                {{ $isAr ? 'فني متاح الآن في ' . $lName : 'Technician available now in ' . $lName }}
            </div>
            <h1 class="text-3xl md:text-4xl font-extrabold mb-4 leading-tight">{{ $h1 }}</h1>
            <p class="text-lg opacity-90 mb-8 leading-relaxed">
                {!! $page->getTranslation('intro', $locale) !!}
            </p>
            <div class="flex gap-3 justify-center flex-wrap">
                <a href="{{ \App\Helpers\WhatsAppHelper::url($isAr ? "مرحباً، أريد الاستفسار عن {$sName} في {$lName}" : "Hello, I need {$sName} in {$lName}") }}"
                   target="_blank"
                   class="bg-green-500 hover:bg-green-600 text-white font-bold px-8 py-4 rounded-xl transition shadow-lg">
                    {{ $isAr ? 'واتساب الآن' : 'WhatsApp Now' }}
                </a>
                @if($phone)
                <a href="tel:{{ $phone }}"
                   class="bg-white text-yellow-700 font-bold px-8 py-4 rounded-xl transition hover:bg-gray-100 shadow-lg">
                    {{ $isAr ? 'اتصل الآن' : 'Call Now' }}
                </a>
                @endif
            </div>
        </div>
    </section>

    {{-- ── Trust strip ── --}}
    <section class="bg-white border-b border-gray-100 py-5">
        <div class="container mx-auto px-4">
            @php
            $trust = $isAr ? [
                ['⚡', 'استجابة خلال ساعة'],
                ['✅', 'فنيون معتمدون'],
                ['🛡️', 'ضمان 3 أشهر'],
                ['💰', 'سعر واضح مسبقاً'],
                ['🕐', 'خدمة 24/7'],
            ] : [
                ['⚡', '1-Hour Response'],
                ['✅', 'Certified Technicians'],
                ['🛡️', '3-Month Warranty'],
                ['💰', 'Upfront Pricing'],
                ['🕐', '24/7 Service'],
            ];
            @endphp
            <div class="flex items-center justify-center flex-wrap gap-6">
                @foreach($trust as [$icon, $label])
                <div class="flex items-center gap-2 text-sm text-gray-600 font-medium">
                    <span class="text-base">{{ $icon }}</span>
                    {{ $label }}
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── Local Problem / Solution ── --}}
    @if($page->getTranslation('local_problem', $locale) || $page->getTranslation('local_solution', $locale))
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4 max-w-4xl">
            <div class="grid md:grid-cols-2 gap-6">

                @if($page->getTranslation('local_problem', $locale))
                <div class="bg-red-50 border border-red-100 rounded-2xl p-6">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="w-9 h-9 rounded-xl bg-red-100 flex items-center justify-center text-lg">⚠️</span>
                        <h2 class="font-bold text-gray-900 text-base">
                            {{ $isAr ? "المشكلة في {$lName}" : "The Problem in {$lName}" }}
                        </h2>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        {{ $page->getTranslation('local_problem', $locale) }}
                    </p>
                </div>
                @endif

                @if($page->getTranslation('local_solution', $locale))
                <div class="bg-green-50 border border-green-100 rounded-2xl p-6">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="w-9 h-9 rounded-xl bg-green-100 flex items-center justify-center text-lg">✅</span>
                        <h2 class="font-bold text-gray-900 text-base">
                            {{ $isAr ? "الحل من إلكتريك كويت" : "ElectricQ8 Solution" }}
                        </h2>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        {{ $page->getTranslation('local_solution', $locale) }}
                    </p>
                </div>
                @endif

            </div>
        </div>
    </section>
    @endif

    {{-- ── Unique local content (from DB) ── --}}
    @if($page->getTranslation('unique_local_content', $locale))
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4 max-w-3xl">
            <div class="richtext" dir="{{ $isAr ? 'rtl' : 'ltr' }}">{!! \App\Helpers\RichText::clean($page->getTranslation('unique_local_content', $locale)) !!}</div>
    </section>
    @endif

    {{-- ── FAQ ── --}}
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4 max-w-3xl">
            <h2 class="text-2xl font-extrabold text-gray-900 mb-8 text-center">
                {{ $isAr ? 'أسئلة شائعة' : 'Frequently Asked Questions' }}
            </h2>
            <div x-data="{ open: null }" class="space-y-3">
                @foreach($faqs as $i => $faq)
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <button @click="open = open === {{ $i }} ? null : {{ $i }}"
                            class="w-full flex items-center justify-between px-5 py-4 text-start font-semibold text-gray-900 text-sm gap-3">
                        <span>{{ $faq['q'] }}</span>
                        <svg :class="open === {{ $i }} ? 'rotate-180' : ''"
                             class="w-5 h-5 text-gray-400 shrink-0 transition-transform"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open === {{ $i }}" x-collapse
                         class="px-5 pb-4 text-sm text-gray-600 leading-relaxed border-t border-gray-100">
                        {{ $faq['a'] }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── Nearby locations (same service, different areas) ── --}}
    @if($nearbyLocations->isNotEmpty())
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4 max-w-4xl">
            <h2 class="text-xl font-extrabold text-gray-900 mb-6 text-center">
                {{ $isAr
                    ? "خدمة {$sName} في مناطق قريبة من {$lName}"
                    : "{$sName} in Areas Near {$lName}" }}
            </h2>
            <div class="flex flex-wrap justify-center gap-3">
                @foreach($nearbyLocations as $nl)
                @php
                    $nlSlug = $nl->getTranslation('slug', $locale);
                    $nlName = $nl->getTranslation('name', $locale);
                @endphp
                <a href="{{ route($prefix . 'service-locations.show', [$sSlug, $nlSlug]) }}"
                   class="px-4 py-2 bg-yellow-50 hover:bg-yellow-100 text-yellow-700 text-sm font-medium rounded-full border border-yellow-200 transition">
                    {{ $isAr ? "{$sName} في {$nlName}" : "{$sName} in {$nlName}" }}
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ── Other services in this location ── --}}
    @if($otherServices->isNotEmpty())
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4 max-w-4xl">
            <h2 class="text-xl font-extrabold text-gray-900 mb-6 text-center">
                {{ $isAr
                    ? "خدمات الكهرباء الأخرى في {$lName}"
                    : "Other Electrical Services in {$lName}" }}
            </h2>
            <div class="flex flex-wrap justify-center gap-3">
                @foreach($otherServices as $os)
                @php
                    $osSlug = $os->getTranslation('slug', $locale);
                    $osName = $os->getTranslation('title', $locale);
                @endphp
                <a href="{{ route($prefix . 'service-locations.show', [$osSlug, $lSlug]) }}"
                   class="px-4 py-2 bg-white hover:bg-gray-100 text-gray-700 text-sm font-medium rounded-full border border-gray-200 transition">
                    {{ $osName }}
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ── Final CTA ── --}}
    <section class="py-14 bg-yellow-700 text-white text-center">
        <div class="container mx-auto px-4 max-w-xl">
            <h2 class="text-2xl font-extrabold mb-3">
                {{ $page->getTranslation('cta_text', $locale) ?: ($isAr ? "احجز فنيًا في {$lName} الآن" : "Book a Technician in {$lName} Now") }}
            </h2>
            <p class="opacity-90 mb-8 text-sm">
                {{ $isAr
                    ? 'نصل إليك خلال ساعة — فنيون معتمدون — ضمان 3 أشهر'
                    : 'We reach you in 1 hour — certified technicians — 3-month warranty' }}
            </p>
            <div class="flex gap-3 justify-center flex-wrap">
                <a href="{{ \App\Helpers\WhatsAppHelper::url($isAr ? "مرحباً، أريد {$sName} في {$lName}" : "Hello, I need {$sName} in {$lName}") }}"
                   target="_blank"
                   class="bg-green-500 hover:bg-green-600 text-white font-bold px-8 py-4 rounded-xl transition">
                    {{ $isAr ? 'واتساب الآن' : 'WhatsApp Now' }}
                </a>
                @if($phone)
                <a href="tel:{{ $phone }}"
                   class="bg-white text-yellow-700 font-bold px-8 py-4 rounded-xl transition hover:bg-gray-100">
                    {{ $isAr ? 'اتصل الآن' : 'Call Now' }}
                </a>
                @endif
            </div>
        </div>
    </section>

</div>
@endsection
