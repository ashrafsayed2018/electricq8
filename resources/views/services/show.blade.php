@extends('layouts.app')

@php
    $isAr     = app()->getLocale() === 'ar';
    $locale   = $isAr ? 'ar' : 'en';
    $h1       = $service->getTranslation('h1', $locale) ?: $service->getTranslation('title', $locale);
    $title    = $service->getTranslation('title', $locale);
    $intro    = $service->getTranslation('intro', $locale);
    $content  = $service->getTranslation('content', $locale);
    $phone    = \App\Models\SiteSetting::get('phone_number');
    $e164     = '+965' . preg_replace('/\D/', '', $phone);
    $siteName = \App\Models\SiteSetting::get('site_name_' . $locale);

    $metaTitle = $service->getTranslation('meta_title', $locale)
        ?: ($isAr
            ? "{$title} بالكويت | إلكتريك كويت | خدمة 24 ساعة"
            : "{$title} Kuwait | ElectricQ8 | 24-Hour Service");

    $metaDesc = $service->getTranslation('meta_description', $locale)
        ?: ($isAr
            ? "إلكتريك كويت تقدم خدمة {$title} في جميع مناطق الكويت. فنيون معتمدون، خدمة طوارئ 24 ساعة، وضمان على العمل. اتصل الآن!"
            : "ElectricQ8 provides {$title} service across all Kuwait areas. Certified technicians, 24-hour emergency service and workmanship warranty. Call now!");

    $faqRaw = $service->getTranslation('faq_schema', $locale);
    $faqs   = $faqRaw ? json_decode($faqRaw, true) : null;

    if (!$faqs) {
        $type = $service->service_type ?? '';
        $faqs = match(true) {
            $isAr && str_contains($type, 'install') || $isAr && str_contains($title, 'تركيب') => [
                ['q' => 'كم يستغرق تركيب الكهرباء؟', 'a' => 'يستغرق تركيب الوحدة الواحدة من 1 إلى 3 ساعات حسب نوع الكهرباء والموضع. نتولى كل شيء من تمديد المواسير حتى الاختبار النهائي.'],
                ['q' => 'هل تركبون جميع ماركات الكهرباء؟', 'a' => 'نعم، نركب جميع الماركات: سامسونج، LG، كاريير، دايكن، ميديا، جري، توشيبا، باناسونيك، يورك وغيرها.'],
                ['q' => 'هل يوجد ضمان على التركيب؟', 'a' => 'نعم، نقدم ضمان 3 أشهر على جميع أعمال التركيب. إذا ظهرت أي مشكلة في العمل نعالجها مجانًا.'],
                ['q' => 'كيف أحدد حجم الكهرباء المناسب لغرفتي؟', 'a' => 'يعتمد الحجم على مساحة الغرفة والارتفاع وعدد النوافذ. فنيونا يزورون الموقع ويحددون السعة المناسبة مجانًا قبل التركيب.'],
            ],
            !$isAr && (str_contains($type, 'install') || str_contains($title, 'Install')) => [
                ['q' => 'How long does electrical installation take?', 'a' => 'Installing a single unit takes 1–3 hours depending on the type and position. We handle everything from pipe routing to the final test.'],
                ['q' => 'Do you install all AC brands?', 'a' => 'Yes, we install all brands: Samsung, LG, Carrier, Daikin, Midea, Gree, Toshiba, Panasonic, York and more.'],
                ['q' => 'Is there a warranty on installation?', 'a' => 'Yes, we provide a 3-month warranty on all installation work. If any issue arises from our work we resolve it free of charge.'],
                ['q' => 'How do I choose the right AC size for my room?', 'a' => 'The size depends on room area, ceiling height and the number of windows. Our technicians visit the site and determine the right capacity free of charge before installation.'],
            ],
            $isAr => [
                ['q' => "كم وقت تستغرق خدمة {$title}؟", 'a' => "تتراوح مدة خدمة {$title} عادةً بين 30 دقيقة وساعتين حسب حالة الجهاز. فنيونا يصلون إليك خلال ساعة من تأكيد الطلب."],
                ['q' => 'هل تعملون في الطوارئ وأوقات الليل؟', 'a' => 'نعم، نعمل 24 ساعة يوميًا بما فيها الجمعة والعطل الرسمية. فريق الطوارئ لدينا جاهز في أي وقت.'],
                ['q' => 'هل يوجد ضمان على الخدمة؟', 'a' => 'نعم، جميع خدماتنا مغطاة بضمان رسمي 3 أشهر. إذا عادت المشكلة نصلحها مجانًا.'],
                ['q' => 'ما المناطق التي تخدمونها؟', 'a' => 'نغطي جميع محافظات الكويت الست: العاصمة وحولي والفروانية والجهراء والأحمدي ومبارك الكبير.'],
            ],
            default => [
                ['q' => "How long does {$title} service take?", 'a' => "{$title} service typically takes between 30 minutes and 2 hours depending on the unit's condition. Our technicians reach you within one hour of booking."],
                ['q' => 'Do you work on emergency and night-time calls?', 'a' => 'Yes, we operate 24 hours a day including Fridays and public holidays. Our emergency team is ready at any time.'],
                ['q' => 'Is there a warranty on the service?', 'a' => 'Yes, all our services are covered by an official 3-month warranty. If the problem returns we fix it free of charge.'],
                ['q' => 'Which areas do you cover?', 'a' => 'We cover all six Kuwait governorates: Capital, Hawalli, Farwaniya, Jahra, Ahmadi and Mubarak Al-Kabeer.'],
            ],
        };
    }

    $brands = [
        ['ar' => 'سامسونج', 'en' => 'Samsung'],['ar' => 'إل جي','en' => 'LG'],['ar' => 'كاريير','en' => 'Carrier'],
        ['ar' => 'دايكن','en' => 'Daikin'],['ar' => 'ميديا','en' => 'Midea'],['ar' => 'جري','en' => 'Gree'],
        ['ar' => 'توشيبا','en' => 'Toshiba'],['ar' => 'باناسونيك','en'=> 'Panasonic'],['ar' => 'يورك','en' => 'York'],
        ['ar' => 'هيتاشي','en' => 'Hitachi'],['ar' => 'شارب','en' => 'Sharp'],['ar' => 'ميتسوبيشي','en'=> 'Mitsubishi'],
    ];

    $acTypes = $isAr
        ? ['سبليت', 'مركزي', 'شباك', 'مخفي (كاسيت)', 'محمول']
        : ['Split', 'Central', 'Window', 'Concealed / Cassette', 'Portable'];
@endphp

@section('meta_title'){{ $metaTitle }}@endsection
@section('meta_description'){{ $metaDesc }}@endsection

@section('schema_markup')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "Service",
  "name": "{{ $title }}",
  "description": "{{ $metaDesc }}",
  "provider": {
    "@@type": "LocalBusiness",
    "name": "{{ $siteName }}",
    "telephone": "{{ $e164 }}",
    "address": { "@@type": "PostalAddress", "addressCountry": "KW" }
  },
  "areaServed": { "@@type": "Country", "name": "Kuwait" }{{ $service->price_from ? ',
  "offers": { "@@type": "Offer", "priceCurrency": "KWD", "price": "' . $service->price_from . '" }' : '' }}
}
</script>
@if($faqs)
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "FAQPage",
  "mainEntity": [
    @foreach($faqs as $i => $faq)
    { "@@type": "Question", "name": "{{ addslashes($faq['q']) }}", "acceptedAnswer": { "@@type": "Answer", "text": "{{ addslashes($faq['a']) }}" } }{{ !$loop->last ? ',' : '' }}
    @endforeach
  ]
}
</script>
@endif
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "BreadcrumbList",
  "itemListElement": [
    {"@@type":"ListItem","position":1,"name":"{{ $isAr ? 'الرئيسية' : 'Home' }}","item":"{{ url($isAr ? '/' : '/en') }}"},
    {"@@type":"ListItem","position":2,"name":"{{ $isAr ? 'الخدمات' : 'Services' }}","item":"{{ route($isAr ? 'services.index' : 'en.services.index') }}"},
    {"@@type":"ListItem","position":3,"name":"{{ $title }}","item":"{{ url()->current() }}"}
  ]
}
</script>
@endsection

@section('content')
<div dir="{{ $isAr ? 'rtl' : 'ltr' }}">

{{-- Breadcrumb --}}
<nav class="eq8-bc" aria-label="{{ $isAr ? 'مسار التنقل' : 'Breadcrumb' }}">
    <div class="eq8-bc__inner">
        <ol class="eq8-bc__list">
            <li><a href="{{ route($isAr ? 'home' : 'en.home') }}" class="eq8-bc__link">{{ $isAr ? 'الرئيسية' : 'Home' }}</a></li>
            <li aria-hidden="true" class="eq8-bc__sep">/</li>
            <li><a href="{{ route($isAr ? 'services.index' : 'en.services.index') }}" class="eq8-bc__link">{{ $isAr ? 'الخدمات' : 'Services' }}</a></li>
            <li aria-hidden="true" class="eq8-bc__sep">/</li>
            <li class="eq8-bc__current" aria-current="page">{{ $title }}</li>
        </ol>
    </div>
</nav>

{{-- Hero --}}
<section class="eq8-page-hero">
    <div class="eq8-page-hero__inner">
        <div class="eq8-emergency-badge">
            {{ $isAr ? 'خدمة طوارئ 24 ساعة' : '24/7 Emergency Service' }}
        </div>
        <h1 class="eq8-page-hero__title">{{ $h1 }}</h1>
        <div class="eq8-page-hero__intro">{!! \App\Helpers\RichText::clean($intro) !!}</div>
        @include('partials.hero-btns', ['waUrl' => \App\Helpers\WhatsAppHelper::url($isAr ? 'أريد الاستفسار عن: ' . $title : 'I need: ' . $title)])
    </div>
</section>

{{-- Main content --}}
@if($content)
<section class="eq8-sv-section">
    <div class="eq8-sv-inner eq8-sv-inner--narrow">
        <div class="richtext" dir="{{ $isAr ? 'rtl' : 'ltr' }}">{!! \App\Helpers\RichText::clean($content) !!}</div>
    </div>
</section>
@endif

{{-- AC types --}}
<section class="eq8-sv-section eq8-sv-section--alt">
    <div class="eq8-sv-inner eq8-sv-inner--mid">
        <h2 class="eq8-sv-h2 eq8-sv-h2--center">{{ $isAr ? 'أنواع الكهرباء التي نخدمها' : 'AC Types We Service' }}</h2>
        <div class="eq8-pill-row">
            @foreach($acTypes as $t)
            <span class="eq8-pill">{{ $t }}</span>
            @endforeach
        </div>
    </div>
</section>

{{-- Why choose us --}}
<section class="eq8-sv-section">
    <div class="eq8-sv-inner eq8-sv-inner--mid">
        <h2 class="eq8-sv-h2 eq8-sv-h2--center">
            {{ $isAr ? "لماذا تختار إلكتريك كويت لـ{$title}؟" : "Why Choose ElectricQ8 for {$title}?" }}
        </h2>
        <div class="eq8-sv-grid-3">
            @php
            $whyUs = $isAr ? [
                ['⚡','وصول خلال ساعة واحدة', 'فنيونا يصلون إليك بسرعة في أي منطقة من مناطق الكويت.'],
                ['🔧','فنيون معتمدون', 'خبرة أكثر من 5 سنوات وشهادات معتمدة في صيانة وتركيب الكهرباء.'],
                ['🛡️','ضمان رسمي 3 أشهر', 'إذا عادت المشكلة نصلحها مجانًا خلال فترة الضمان.'],
                ['💰','أسعار شفافة', 'تقدير واضح قبل بدء العمل — لا رسوم مخفية.'],
                ['🏷️','جميع الماركات', 'نصلح ونركب جميع ماركات الكهرباء المتوفرة في السوق الكويتي.'],
                ['📞','دعم 24 ساعة', 'متاحون دائمًا للطوارئ وأيام العطل والجمعة.'],
            ] : [
                ['⚡','One-Hour Arrival', 'Our technicians reach you fast in any area across Kuwait.'],
                ['🔧','Certified Technicians', 'Over 5 years of experience and certified qualifications.'],
                ['🛡️','Official 3-Month Warranty', 'If the problem returns we fix it free within the warranty period.'],
                ['💰','Transparent Pricing', 'Clear estimate before starting — no hidden fees.'],
                ['🏷️','All Brands', 'We service and install all AC brands in the Kuwait market.'],
                ['📞','24-Hour Support', 'Always available for emergencies, weekends and public holidays.'],
            ];
            @endphp
            @foreach($whyUs as [$icon, $ttl, $body])
            <div class="eq8-why-card">
                <span class="eq8-why-card__icon">{{ $icon }}</span>
                <div>
                    <p class="eq8-why-card__title">{{ $ttl }}</p>
                    <p class="eq8-why-card__body">{{ $body }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Brands --}}
<section class="eq8-sv-section eq8-sv-section--alt">
    <div class="eq8-sv-inner eq8-sv-inner--narrow">
        <h2 class="eq8-sv-h2 eq8-sv-h2--center">{{ $isAr ? 'الماركات التي نخدمها' : 'Brands We Service' }}</h2>
        <div class="eq8-pill-row">
            @foreach($brands as $b)
            <span class="eq8-pill eq8-pill--muted">{{ $b[$locale] ?? $b['en'] }}</span>
            @endforeach
        </div>
    </div>
</section>

{{-- Service areas --}}
<section class="eq8-sv-section">
    <div class="eq8-sv-inner eq8-sv-inner--narrow" style="text-align:center">
        <h2 class="eq8-sv-h2 eq8-sv-h2--center">
            {{ $isAr ? "مناطق خدمة {$title} في الكويت" : "{$title} Service Areas in Kuwait" }}
        </h2>
        <p class="eq8-sv-sub">{{ $isAr ? 'نغطي جميع المحافظات الست — استجابة خلال ساعة واحدة' : 'Covering all six governorates — one-hour response' }}</p>
        <div class="eq8-pill-row eq8-pill-row--center">
            @foreach($locations as $loc)
            @php $locName = $loc->getTranslation('name', $locale); $locSlug = $loc->getTranslation('slug', $locale); @endphp
            <a href="{{ route($isAr ? 'areas.show' : 'en.areas.show', $locSlug) }}" class="eq8-pill eq8-pill--link">{{ $locName }}</a>
            @endforeach
        </div>
    </div>
</section>

{{-- FAQ --}}
@if($faqs)
<section class="eq8-sv-section eq8-sv-section--alt">
    <div class="eq8-sv-inner eq8-sv-inner--narrow">
        <h2 class="eq8-sv-h2 eq8-sv-h2--center">{{ $isAr ? "الأسئلة الشائعة — {$title}" : "FAQ — {$title}" }}</h2>
        <div class="eq8-faq" x-data="{ open: null }">
            @foreach($faqs as $i => $faq)
            <div class="eq8-faq__item">
                <button type="button" class="eq8-faq__btn {{ $isAr ? 'text-right' : 'text-left' }}"
                    @click="open === {{ $i }} ? open = null : open = {{ $i }}"
                    :aria-expanded="open === {{ $i }}">
                    <span class="eq8-faq__q">{{ $faq['q'] }}</span>
                    <svg class="eq8-faq__chevron" :class="{ 'rotate-180': open === {{ $i }} }"
                         fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open === {{ $i }}"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="eq8-faq__answer" style="display:none">
                    <p>{{ $faq['a'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- This service in every area --}}
@if($locations->count())
<section class="eq8-sv-section" style="background:var(--altBg)">
    <div class="eq8-sv-inner eq8-sv-inner--mid" style="text-align:center">
        <h2 class="eq8-sv-h2 eq8-sv-h2--center">
            {{ $isAr ? "خدمة {$title} في جميع مناطق الكويت" : "{$title} Across All Kuwait Areas" }}
        </h2>
        <p class="eq8-sv-sub">{{ $isAr ? 'اختر منطقتك للحصول على صفحة مخصصة بتفاصيل محلية' : 'Select your area for a dedicated page with local details' }}</p>
        <div class="eq8-pill-row eq8-pill-row--center">
            @foreach($locations as $loc)
            @php
                $locSlug = $loc->getTranslation('slug', $locale);
                $locName = $loc->getTranslation('name', $locale);
                $svcSlug = $service->getTranslation('slug', $locale);
                $prefix  = $isAr ? '' : 'en.';
            @endphp
            <a href="{{ route($prefix . 'service-locations.show', [$svcSlug, $locSlug]) }}" class="eq8-pill eq8-pill--link">
                {{ $isAr ? "{$title} في {$locName}" : "{$title} in {$locName}" }}
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Other services --}}
@if($otherServices->count())
<section class="eq8-sv-section">
    <div class="eq8-sv-inner">
        <h2 class="eq8-sv-h2 eq8-sv-h2--center">{{ $isAr ? 'خدمات أخرى' : 'Other Services' }}</h2>
        @include('partials.services-grid', ['services' => $otherServices])
    </div>
</section>
@endif

{{-- Final CTA --}}
<section class="eq8-cta-band">
    <div class="eq8-sv-inner" style="text-align:center;max-width:700px">
        <h2 style="font-size:clamp(1.3rem,3vw,1.8rem);font-weight:800;color:#fff;margin:0 0 10px;font-family:'Cairo',sans-serif">
            {{ $isAr ? "احجز خدمة {$title} الآن" : "Book {$title} Service Now" }}
        </h2>
        <p style="color:#F3D9BB;margin:0 0 28px;font-family:'Cairo',sans-serif">
            {{ $isAr ? 'فنيونا جاهزون ويصلونك خلال ساعة — تواصل الآن' : 'Our technicians are ready and will reach you within one hour — contact us now' }}
        </p>
        @include('partials.hero-btns', ['waUrl' => \App\Helpers\WhatsAppHelper::url($isAr ? 'أريد الاستفسار عن: ' . $title : 'I need: ' . $title)])
    </div>
</section>

</div>

<style>
.eq8-bc { background:var(--altBg); border-bottom:1px solid var(--border); padding:10px 0; font-family:'Cairo',sans-serif; font-size:13px; }
.eq8-bc__inner { max-width:1000px; margin:0 auto; padding:0 16px; }
.eq8-bc__list { display:flex; align-items:center; gap:8px; list-style:none; margin:0; padding:0; flex-wrap:wrap; color:var(--muted); }
.eq8-bc__link { color:var(--primaryText); text-decoration:none; font-weight:600; }
.eq8-bc__link:hover { text-decoration:underline; }
.eq8-bc__sep { color:var(--border); }
.eq8-bc__current { color:var(--text); font-weight:600; }

.eq8-page-hero { background:linear-gradient(135deg,#43230E 0%,#6B3A17 60%,#8B4D20 100%); color:#fff; padding:56px 20px; text-align:center; }
.eq8-page-hero__inner { max-width:760px; margin:0 auto; }
.eq8-page-hero__title { font-size:clamp(1.6rem,4vw,2.4rem); font-weight:800; margin:0 0 12px; font-family:'Cairo',system-ui,sans-serif; }
.eq8-page-hero__intro { font-size:1rem; color:#F3D9BB; margin:0 0 24px; opacity:.9; font-family:'Cairo',sans-serif; }
.eq8-emergency-badge { display:inline-block; background:#dc2626; color:#fff; font-size:.78rem; font-weight:700; padding:5px 16px; border-radius:999px; margin-bottom:16px; font-family:'Cairo',sans-serif; }

.eq8-sv-section { padding:48px 0; background:var(--bg); }
.eq8-sv-section--alt { background:var(--altBg); }
.eq8-sv-inner { max-width:1100px; margin:0 auto; padding:0 20px; }
.eq8-sv-inner--mid { max-width:900px; margin:0 auto; padding:0 20px; }
.eq8-sv-inner--narrow { max-width:720px; margin:0 auto; padding:0 20px; }
.eq8-sv-h2 { font-size:1.25rem; font-weight:800; color:var(--text); margin:0 0 24px; font-family:'Cairo',sans-serif; }
.eq8-sv-h2--center { text-align:center; }
.eq8-sv-sub { text-align:center; color:var(--muted); font-size:.88rem; margin:0 0 20px; font-family:'Cairo',sans-serif; }

.eq8-pill-row { display:flex; flex-wrap:wrap; justify-content:center; gap:10px; }
.eq8-pill { display:inline-flex; align-items:center; padding:7px 18px; border-radius:999px; border:1.5px solid var(--accentTint); background:var(--cardBg); color:var(--primaryText); font-size:.82rem; font-weight:600; font-family:'Cairo',sans-serif; }
.eq8-pill--muted { border-color:var(--border); color:var(--text); }
.eq8-pill--muted:hover { border-color:var(--accent); color:var(--primaryText); }
.eq8-pill--link { text-decoration:none; transition:background .18s,color .18s; }
.eq8-pill--link:hover { background:var(--primary); color:#fff; border-color:var(--primary); }
.eq8-pill-row--center { justify-content:center; }

.eq8-sv-grid-3 { display:grid; grid-template-columns:repeat(3,1fr); gap:14px; }
@media(max-width:760px){ .eq8-sv-grid-3 { grid-template-columns:repeat(2,1fr); } }
@media(max-width:480px){ .eq8-sv-grid-3 { grid-template-columns:1fr; } }

.eq8-why-card { display:flex; gap:12px; align-items:flex-start; background:var(--cardBg); border:1px solid var(--border); border-radius:12px; padding:16px; transition:border-color .2s; }
.eq8-why-card:hover { border-color:var(--accent); }
.eq8-why-card__icon { font-size:1.3rem; flex-shrink:0; margin-top:2px; }
.eq8-why-card__title { font-size:.85rem; font-weight:700; color:var(--text); margin:0 0 4px; font-family:'Cairo',sans-serif; }
.eq8-why-card__body { font-size:.78rem; color:var(--body); line-height:1.65; margin:0; font-family:'Cairo',sans-serif; }

.eq8-faq { display:flex; flex-direction:column; gap:10px; }
.eq8-faq__item { background:var(--cardBg); border:1px solid var(--border); border-radius:12px; overflow:hidden; }
.eq8-faq__btn { width:100%; display:flex; align-items:center; justify-content:space-between; padding:16px 20px; font-family:'Cairo',sans-serif; font-weight:700; font-size:.88rem; color:var(--text); background:transparent; border:none; cursor:pointer; gap:12px; }
.eq8-faq__btn:hover { background:var(--altBg); }
.eq8-faq__q { flex:1; }
.eq8-faq__chevron { width:18px; height:18px; color:var(--accent); flex-shrink:0; transition:transform .25s; }
.eq8-faq__answer { padding:0 20px 16px; font-size:.84rem; color:var(--body); line-height:1.7; border-top:1px solid var(--border); font-family:'Cairo',sans-serif; }
.eq8-faq__answer p { margin:12px 0 0; }
.rotate-180 { transform:rotate(180deg); }

.eq8-cta-band { background:linear-gradient(135deg,#43230E 0%,#6B3A17 100%); padding:56px 20px; }
</style>
@endsection
