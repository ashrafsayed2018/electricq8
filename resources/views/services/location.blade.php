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
                <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:16px;padding:24px">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px">
                        <span style="width:36px;height:36px;background:#fee2e2;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.1rem">⚠️</span>
                        <h2 style="font-size:.9rem;font-weight:700;color:var(--text);margin:0;font-family:'Cairo',sans-serif">{{ $isAr ? "المشكلة في {$lName}" : "The Problem in {$lName}" }}</h2>
                    </div>
                    <p style="font-size:.82rem;color:var(--body);line-height:1.7;margin:0;font-family:'Cairo',sans-serif">{{ $page->getTranslation('local_problem', $locale) }}</p>
                </div>
                @endif
                @if($page->getTranslation('local_solution', $locale))
                <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:16px;padding:24px">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px">
                        <span style="width:36px;height:36px;background:#dcfce7;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.1rem">✅</span>
                        <h2 style="font-size:.9rem;font-weight:700;color:var(--text);margin:0;font-family:'Cairo',sans-serif">{{ $isAr ? 'الحل من إلكتريك كويت' : 'ElectricQ8 Solution' }}</h2>
                    </div>
                    <p style="font-size:.82rem;color:var(--body);line-height:1.7;margin:0;font-family:'Cairo',sans-serif">{{ $page->getTranslation('local_solution', $locale) }}</p>
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
            <div class="eq8-page-hero__btns">
                <a href="{{ \App\Helpers\WhatsAppHelper::url($isAr ? "مرحباً، أريد {$sName} في {$lName}" : "Hello, I need {$sName} in {$lName}") }}"
                   target="_blank" class="eq8-btn eq8-btn--wa">
                    <svg class="eq8-btn__icon" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.116 1.528 5.845L0 24l6.335-1.505A11.946 11.946 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.882a9.872 9.872 0 01-5.031-1.378l-.361-.214-3.741.981.999-3.648-.235-.374A9.869 9.869 0 012.118 12C2.118 6.963 6.963 2.118 12 2.118s9.882 4.845 9.882 9.882-4.845 9.882-9.882 9.882z"/></svg>
                    {{ $isAr ? 'واتساب الآن' : 'WhatsApp Now' }}
                </a>
                @if($phone)
                <a href="tel:{{ $phone }}" class="eq8-btn eq8-btn--call">
                    <svg class="eq8-btn__icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    {{ $isAr ? 'اتصل الآن' : 'Call Now' }}
                </a>
                @endif
            </div>
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

.eq8-cta-band { background:linear-gradient(135deg,#43230E 0%,#6B3A17 100%); padding:56px 20px; }
</style>
@endsection
