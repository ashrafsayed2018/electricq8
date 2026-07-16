@extends('layouts.app')

@php
    $isAr      = app()->getLocale() === 'ar';
    $locale    = app()->getLocale();
    $prefix    = $isAr ? '' : 'en.';
    $siteName  = \App\Models\SiteSetting::get('site_name_' . $locale) ?: 'ElectricQ8';
    $siteUrl   = config('app.url');
    $pageUrl   = url()->current();
    $phone     = \App\Models\SiteSetting::get('phone_number');

    $pageTitle = $page->getTranslation('meta_title', $locale) ?: $page->getTranslation('title', $locale);
    $pageDesc  = $page->getTranslation('meta_description', $locale) ?: $page->getTranslation('intro', $locale);
    $h1        = $page->getTranslation('h1', $locale) ?: $page->getTranslation('title', $locale);

    $sName     = $service->getTranslation('title', $locale);
    $lName     = $location->getTranslation('name', $locale);
    $sSlug     = $service->getTranslation('slug', $locale);
    $lSlug     = $location->getTranslation('slug', $locale);

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
    "address": { "@@type": "PostalAddress", "addressLocality": {{ json_encode($lName) }}, "addressCountry": "KW" }
  },
  "areaServed": { "@@type": "City", "name": {{ json_encode($lName) }} }
  @if($service->price_from),
  "offers": { "@@type": "Offer", "priceCurrency": "KWD", "price": "{{ $service->price_from }}" }
  @endif
}
</script>
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "FAQPage",
  "mainEntity": [
    @foreach($faqs as $i => $faq)
    { "@@type": "Question", "name": {{ json_encode($faq['q']) }}, "acceptedAnswer": { "@@type": "Answer", "text": {{ json_encode($faq['a']) }} } }{{ $loop->last ? '' : ',' }}
    @endforeach
  ]
}
</script>
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "BreadcrumbList",
  "itemListElement": [
    { "@@type": "ListItem", "position": 1, "name": {{ json_encode($isAr ? 'الرئيسية' : 'Home') }}, "item": {{ json_encode($siteUrl . ($isAr ? '' : '/en')) }} },
    { "@@type": "ListItem", "position": 2, "name": {{ json_encode($isAr ? 'الخدمات' : 'Services') }}, "item": {{ json_encode(route($prefix . 'services.index')) }} },
    { "@@type": "ListItem", "position": 3, "name": {{ json_encode($sName) }}, "item": {{ json_encode(route($prefix . 'services.show', $sSlug)) }} },
    { "@@type": "ListItem", "position": 4, "name": {{ json_encode($h1) }}, "item": {{ json_encode($pageUrl) }} }
  ]
}
</script>
@endpush

@section('content')
<div dir="{{ $isAr ? 'rtl' : 'ltr' }}">

    {{-- Breadcrumb --}}
    <nav class="eq8-bc" aria-label="breadcrumb">
        <div class="eq8-bc__inner">
            <ol class="eq8-bc__list">
                <li><a href="{{ route($prefix . 'home') }}" class="eq8-bc__link">{{ $isAr ? 'الرئيسية' : 'Home' }}</a></li>
                <li class="eq8-bc__sep">/</li>
                <li><a href="{{ route($prefix . 'services.index') }}" class="eq8-bc__link">{{ $isAr ? 'الخدمات' : 'Services' }}</a></li>
                <li class="eq8-bc__sep">/</li>
                <li><a href="{{ route($prefix . 'services.show', $sSlug) }}" class="eq8-bc__link">{{ $sName }}</a></li>
                <li class="eq8-bc__sep">/</li>
                <li class="eq8-bc__current">{{ $lName }}</li>
            </ol>
        </div>
    </nav>

    {{-- Hero --}}
    <section class="eq8-page-hero">
        <div class="eq8-page-hero__inner">
            <div class="eq8-avail-badge">
                <span class="eq8-avail-dot"></span>
                {{ $isAr ? 'فني متاح الآن في ' . $lName : 'Technician available now in ' . $lName }}
            </div>
            <h1 class="eq8-page-hero__title">{{ $h1 }}</h1>
            <div class="eq8-page-hero__intro">{!! $page->getTranslation('intro', $locale) !!}</div>
            @include('partials.hero-btns', ['waUrl' => \App\Helpers\WhatsAppHelper::url($isAr ? "مرحباً، أريد الاستفسار عن {$sName} في {$lName}" : "Hello, I need {$sName} in {$lName}")])
        </div>
    </section>

    {{-- Trust strip --}}
    <section style="background:var(--cardBg);border-bottom:1px solid var(--border);padding:18px 0">
        <div class="container mx-auto px-4">
            @php
            $trust = $isAr
                ? [['⚡','استجابة خلال ساعة'],['✅','فنيون معتمدون'],['🛡️','ضمان 3 أشهر'],['💰','سعر واضح مسبقاً'],['🕐','خدمة 24/7']]
                : [['⚡','1-Hour Response'],['✅','Certified Technicians'],['🛡️','3-Month Warranty'],['💰','Upfront Pricing'],['🕐','24/7 Service']];
            @endphp
            <div style="display:flex;align-items:center;justify-content:center;flex-wrap:wrap;gap:24px">
                @foreach($trust as [$icon, $label])
                <div style="display:flex;align-items:center;gap:6px;font-size:.83rem;color:var(--body);font-family:'Cairo',sans-serif;font-weight:600">
                    <span style="font-size:1rem">{{ $icon }}</span> {{ $label }}
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Local problem / solution --}}
    @if($page->getTranslation('local_problem', $locale) || $page->getTranslation('local_solution', $locale))
    <section style="padding:48px 0;background:var(--altBg)">
        <div class="container mx-auto px-4" style="max-width:900px">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                @if($page->getTranslation('local_problem', $locale))
                <div class="eq8-ps-card eq8-ps-card--problem">
                    <div class="eq8-ps-card__head">
                        <span class="eq8-ps-card__icon eq8-ps-card__icon--problem">⚠️</span>
                        <h2 class="eq8-ps-card__title">{{ $isAr ? "المشكلة في {$lName}" : "The Problem in {$lName}" }}</h2>
                    </div>
                    <p class="eq8-ps-card__body">{{ $page->getTranslation('local_problem', $locale) }}</p>
                </div>
                @endif
                @if($page->getTranslation('local_solution', $locale))
                <div class="eq8-ps-card eq8-ps-card--solution">
                    <div class="eq8-ps-card__head">
                        <span class="eq8-ps-card__icon eq8-ps-card__icon--solution">✅</span>
                        <h2 class="eq8-ps-card__title">{{ $isAr ? 'الحل من إلكتريك كويت' : 'ElectricQ8 Solution' }}</h2>
                    </div>
                    <p class="eq8-ps-card__body">{{ $page->getTranslation('local_solution', $locale) }}</p>
                </div>
                @endif
            </div>
        </div>
    </section>
    @endif

    {{-- Unique content --}}
    @if($page->getTranslation('unique_local_content', $locale))
    <section style="padding:48px 0;background:var(--bg)">
        <div class="container mx-auto px-4" style="max-width:760px">
            <div class="richtext" dir="{{ $isAr ? 'rtl' : 'ltr' }}">{!! \App\Helpers\RichText::clean($page->getTranslation('unique_local_content', $locale)) !!}</div>
        </div>
    </section>
    @endif

    {{-- FAQ --}}
    <section style="padding:48px 0;background:var(--altBg)">
        <div class="container mx-auto px-4" style="max-width:720px">
            <h2 style="font-size:1.3rem;font-weight:800;color:var(--text);margin:0 0 28px;text-align:center;font-family:'Cairo',sans-serif">
                {{ $isAr ? 'أسئلة شائعة' : 'Frequently Asked Questions' }}
            </h2>
            <div class="eq8-faq" x-data="{ open: null }">
                @foreach($faqs as $i => $faq)
                <div class="eq8-faq__item">
                    <button @click="open = open === {{ $i }} ? null : {{ $i }}"
                            class="eq8-faq__btn">
                        <span class="eq8-faq__q">{{ $faq['q'] }}</span>
                        <svg class="eq8-faq__chevron" :class="open === {{ $i }} ? 'rotate-180' : ''"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open === {{ $i }}" x-collapse
                         class="eq8-faq__answer">
                        {{ $faq['a'] }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Nearby locations --}}
    @if($nearbyLocations->isNotEmpty())
    <section style="padding:48px 0;background:var(--bg)">
        <div class="container mx-auto px-4" style="max-width:900px;text-align:center">
            <h2 style="font-size:1.2rem;font-weight:800;color:var(--text);margin:0 0 20px;font-family:'Cairo',sans-serif">
                {{ $isAr ? "خدمة {$sName} في مناطق قريبة من {$lName}" : "{$sName} in Areas Near {$lName}" }}
            </h2>
            <div class="eq8-pill-row eq8-pill-row--center">
                @foreach($nearbyLocations as $nl)
                @php $nlSlug = $nl->getTranslation('slug', $locale); $nlName = $nl->getTranslation('name', $locale); @endphp
                <a href="{{ route($prefix . 'service-locations.show', [$sSlug, $nlSlug]) }}" class="eq8-pill eq8-pill--link">
                    {{ $isAr ? "{$sName} في {$nlName}" : "{$sName} in {$nlName}" }}
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Other services in location --}}
    @if($otherServices->isNotEmpty())
    <section style="padding:48px 0;background:var(--altBg)">
        <div class="container mx-auto px-4" style="max-width:900px;text-align:center">
            <h2 style="font-size:1.2rem;font-weight:800;color:var(--text);margin:0 0 20px;font-family:'Cairo',sans-serif">
                {{ $isAr ? "خدمات الكهرباء الأخرى في {$lName}" : "Other Electrical Services in {$lName}" }}
            </h2>
            <div class="eq8-pill-row eq8-pill-row--center">
                @foreach($otherServices as $os)
                @php $osSlug = $os->getTranslation('slug', $locale); $osName = $os->getTranslation('title', $locale); @endphp
                <a href="{{ route($prefix . 'service-locations.show', [$osSlug, $lSlug]) }}" class="eq8-pill eq8-pill--muted eq8-pill--link">
                    {{ $osName }}
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Final CTA --}}
    <section class="eq8-cta-band">
        <div class="container mx-auto px-4" style="text-align:center;max-width:680px">
            <h2 style="font-size:clamp(1.3rem,3vw,1.8rem);font-weight:800;color:#fff;margin:0 0 10px;font-family:'Cairo',sans-serif">
                {{ $page->getTranslation('cta_text', $locale) ?: ($isAr ? "احجز فنيًا في {$lName} الآن" : "Book a Technician in {$lName} Now") }}
            </h2>
            <p style="color:#F3D9BB;margin:0 0 28px;font-size:.88rem;font-family:'Cairo',sans-serif">
                {{ $isAr ? 'نصل إليك خلال ساعة — فنيون معتمدون — ضمان 3 أشهر' : 'We reach you in 1 hour — certified technicians — 3-month warranty' }}
            </p>
            @include('partials.hero-btns', [
                'waUrl'     => \App\Helpers\WhatsAppHelper::url($isAr ? "مرحباً، أريد {$sName} في {$lName}" : "Hello, I need {$sName} in {$lName}"),
                'waLabel'   => $isAr ? 'واتساب الآن' : 'WhatsApp Now',
                'callLabel' => $isAr ? 'اتصل الآن' : 'Call Now',
            ])
        </div>
    </section>

</div>

<style>
.eq8-bc { background:var(--altBg); border-bottom:1px solid var(--border); padding:10px 0; font-family:'Cairo',sans-serif; font-size:13px; }
.eq8-bc__inner { max-width:1100px; margin:0 auto; padding:0 16px; }
.eq8-bc__list { display:flex; align-items:center; gap:6px; list-style:none; margin:0; padding:0; flex-wrap:wrap; color:var(--muted); font-size:12px; }
.eq8-bc__link { color:var(--primary); text-decoration:none; font-weight:600; }
.eq8-bc__link:hover { text-decoration:underline; }
.eq8-bc__sep { color:var(--border); }
.eq8-bc__current { color:var(--text); font-weight:600; }

.eq8-page-hero { background:linear-gradient(135deg,#43230E 0%,#6B3A17 60%,#8B4D20 100%); color:#fff; padding:56px 20px; text-align:center; }
.eq8-page-hero__inner { max-width:760px; margin:0 auto; }
.eq8-page-hero__title { font-size:clamp(1.5rem,4vw,2.2rem); font-weight:800; margin:0 0 14px; font-family:'Cairo',system-ui,sans-serif; }
.eq8-page-hero__intro { font-size:1rem; color:#F3D9BB; margin:0 0 24px; opacity:.9; font-family:'Cairo',sans-serif; }

.eq8-avail-badge { display:inline-flex; align-items:center; gap:6px; background:rgba(37,211,102,.15); border:1px solid rgba(37,211,102,.3); color:#a3f5c4; border-radius:999px; padding:5px 14px; font-size:.8rem; font-weight:600; margin-bottom:16px; font-family:'Cairo',sans-serif; }
.eq8-avail-dot { width:8px; height:8px; background:#25D366; border-radius:50%; animation:pulse 1.5s ease-in-out infinite; }
@keyframes pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.6;transform:scale(1.3)} }

.eq8-faq { display:flex; flex-direction:column; gap:10px; }
.eq8-faq__item { background:var(--cardBg); border:1px solid var(--border); border-radius:12px; overflow:hidden; }
.eq8-faq__btn { width:100%; display:flex; align-items:center; justify-content:space-between; padding:14px 18px; font-family:'Cairo',sans-serif; font-weight:600; font-size:.84rem; color:var(--text); background:transparent; border:none; cursor:pointer; gap:10px; text-align:start; }
.eq8-faq__btn:hover { background:var(--altBg); }
.eq8-faq__q { flex:1; }
.eq8-faq__chevron { width:18px; height:18px; color:var(--muted); flex-shrink:0; transition:transform .25s; }
.eq8-faq__answer { padding:0 18px 14px; font-size:.82rem; color:var(--body); line-height:1.7; border-top:1px solid var(--border); font-family:'Cairo',sans-serif; }
.rotate-180 { transform:rotate(180deg); }

.eq8-pill-row { display:flex; flex-wrap:wrap; gap:10px; }
.eq8-pill-row--center { justify-content:center; }
.eq8-pill { display:inline-flex; align-items:center; padding:7px 16px; border-radius:999px; border:1.5px solid var(--accentTint); background:var(--cardBg); color:var(--primary); font-size:.8rem; font-weight:600; font-family:'Cairo',sans-serif; }
.eq8-pill--muted { border-color:var(--border); color:var(--text); }
.eq8-pill--link { text-decoration:none; transition:background .18s,color .18s; }
.eq8-pill--link:hover { background:var(--primary); color:#fff; border-color:var(--primary); }

@media (prefers-color-scheme: dark) {
    .eq8-pill--link { color:#D97B2E; border-color:rgba(217,123,46,.35); background:rgba(217,123,46,.1); }
    .eq8-pill--link:hover { background:#D97B2E; color:#fff; border-color:#D97B2E; }
    .eq8-pill--muted { color:var(--text); border-color:var(--border); background:var(--cardBg); }
}
:root[data-theme="dark"] .eq8-pill--link { color:#D97B2E; border-color:rgba(217,123,46,.35); background:rgba(217,123,46,.1); }
:root[data-theme="dark"] .eq8-pill--link:hover { background:#D97B2E; color:#fff; border-color:#D97B2E; }
:root[data-theme="dark"] .eq8-pill--muted { color:var(--text); border-color:var(--border); background:var(--cardBg); }
:root[data-theme="light"] .eq8-pill--link { color:var(--primary); border-color:var(--accentTint); background:var(--cardBg); }
:root[data-theme="light"] .eq8-pill--link:hover { background:var(--primary); color:#fff; border-color:var(--primary); }

.eq8-cta-band { background:linear-gradient(135deg,#43230E 0%,#6B3A17 100%); padding:56px 20px; }

/* Problem / Solution cards */
.eq8-ps-card { border-radius:16px; padding:24px; }
.eq8-ps-card__head { display:flex; align-items:center; gap:10px; margin-bottom:12px; }
.eq8-ps-card__icon { width:36px; height:36px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:1.1rem; flex-shrink:0; }
.eq8-ps-card__title { font-size:.9rem; font-weight:700; color:var(--text); margin:0; font-family:'Cairo',sans-serif; }
.eq8-ps-card__body { font-size:.82rem; line-height:1.75; margin:0; font-family:'Cairo',sans-serif; color:var(--text); }

/* Light mode */
.eq8-ps-card--problem { background:#fef2f2; border:1px solid #fecaca; }
.eq8-ps-card--problem .eq8-ps-card__icon--problem { background:#fee2e2; }
.eq8-ps-card--problem .eq8-ps-card__title { color:#991b1b; }
.eq8-ps-card--problem .eq8-ps-card__body  { color:#7f1d1d; }

.eq8-ps-card--solution { background:#f0fdf4; border:1px solid #bbf7d0; }
.eq8-ps-card--solution .eq8-ps-card__icon--solution { background:#dcfce7; }
.eq8-ps-card--solution .eq8-ps-card__title { color:#166534; }
.eq8-ps-card--solution .eq8-ps-card__body  { color:#14532d; }

/* Dark mode */
@media (prefers-color-scheme: dark) {
    .eq8-ps-card--problem { background:rgba(220,38,38,.12); border-color:rgba(220,38,38,.3); }
    .eq8-ps-card--problem .eq8-ps-card__icon--problem { background:rgba(220,38,38,.2); }
    .eq8-ps-card--problem .eq8-ps-card__title { color:#fca5a5; }
    .eq8-ps-card--problem .eq8-ps-card__body  { color:#fcd5d5; }
    .eq8-ps-card--solution { background:rgba(34,197,94,.1); border-color:rgba(34,197,94,.25); }
    .eq8-ps-card--solution .eq8-ps-card__icon--solution { background:rgba(34,197,94,.18); }
    .eq8-ps-card--solution .eq8-ps-card__title { color:#86efac; }
    .eq8-ps-card--solution .eq8-ps-card__body  { color:#bbf7d0; }
}
:root[data-theme="dark"] .eq8-ps-card--problem { background:rgba(220,38,38,.12); border-color:rgba(220,38,38,.3); }
:root[data-theme="dark"] .eq8-ps-card--problem .eq8-ps-card__icon--problem { background:rgba(220,38,38,.2); }
:root[data-theme="dark"] .eq8-ps-card--problem .eq8-ps-card__title { color:#fca5a5; }
:root[data-theme="dark"] .eq8-ps-card--problem .eq8-ps-card__body  { color:#fcd5d5; }
:root[data-theme="dark"] .eq8-ps-card--solution { background:rgba(34,197,94,.1); border-color:rgba(34,197,94,.25); }
:root[data-theme="dark"] .eq8-ps-card--solution .eq8-ps-card__icon--solution { background:rgba(34,197,94,.18); }
:root[data-theme="dark"] .eq8-ps-card--solution .eq8-ps-card__title { color:#86efac; }
:root[data-theme="dark"] .eq8-ps-card--solution .eq8-ps-card__body  { color:#bbf7d0; }
:root[data-theme="light"] .eq8-ps-card--problem { background:#fef2f2; border-color:#fecaca; }
:root[data-theme="light"] .eq8-ps-card--problem .eq8-ps-card__title { color:#991b1b; }
:root[data-theme="light"] .eq8-ps-card--problem .eq8-ps-card__body  { color:#7f1d1d; }
:root[data-theme="light"] .eq8-ps-card--solution { background:#f0fdf4; border-color:#bbf7d0; }
:root[data-theme="light"] .eq8-ps-card--solution .eq8-ps-card__title { color:#166534; }
:root[data-theme="light"] .eq8-ps-card--solution .eq8-ps-card__body  { color:#14532d; }
</style>
@endsection
