@extends('layouts.app')

@php
    $isAr     = app()->getLocale() === 'ar';
    $locale   = $isAr ? 'ar' : 'en';
    $name     = $location->getTranslation('name', $locale);
    $desc     = $location->getTranslation('description', $locale);
    $gov      = $location->governorate;
    $phone    = \App\Models\SiteSetting::get('phone_number');
    $e164     = '+965' . preg_replace('/\D/', '', $phone);
    $siteName = \App\Models\SiteSetting::get('site_name_' . $locale);

    $govData = [
        'capital'           => ['ar' => 'محافظة العاصمة',        'en' => 'Capital Governorate'],
        'hawalli'           => ['ar' => 'محافظة حولي',            'en' => 'Hawalli Governorate'],
        'farwaniya'         => ['ar' => 'محافظة الفروانية',       'en' => 'Farwaniya Governorate'],
        'jahra'             => ['ar' => 'محافظة الجهراء',         'en' => 'Jahra Governorate'],
        'mubarak_al_kabeer' => ['ar' => 'محافظة مبارك الكبير',   'en' => 'Mubarak Al-Kabeer Governorate'],
        'ahmadi'            => ['ar' => 'محافظة الأحمدي',        'en' => 'Ahmadi Governorate'],
    ];
    $govName = $govData[$gov][$locale] ?? ($isAr ? 'الكويت' : 'Kuwait');

    $metaTitle = $location->meta_title
        ?? ($isAr
            ? "فني كهربائي في {$name} | صيانة وتركيب وتصليح شورت 24 ساعة"
            : "Electrician in {$name} Kuwait | Repair, Installation 24/7");
    $metaDesc = $location->meta_description
        ?? ($isAr
            ? "فني كهربائي في {$name} — تركيب وصيانة وتصليح شورت لجميع الماركات. خدمة طوارئ 24 ساعة مع ضمان على العمل. اتصل الآن!"
            : "Electrician in {$name} Kuwait — installation, repair, short circuit repair for all brands. 24-hour emergency service. Call now!");
@endphp

@section('meta_title'){{ $metaTitle }}@endsection
@section('meta_description'){{ $metaDesc }}@endsection

@section('schema_markup')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": ["LocalBusiness", "electricalBusiness"],
  "name": "{{ $siteName }}",
  "url": "{{ url()->current() }}",
  "telephone": "{{ $e164 }}",
  "address": { "@@type": "PostalAddress", "addressCountry": "KW", "addressLocality": "{{ $name }}" },
  "areaServed": { "@@type": "City", "name": "{{ $name }}" },
  "openingHoursSpecification": { "@@type": "OpeningHoursSpecification", "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"], "opens": "00:00", "closes": "23:59" }
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
                <li class="eq8-bc__sep">/</li>
                <li><a href="{{ route($isAr ? 'areas.index' : 'en.areas.index') }}" class="eq8-bc__link">{{ $isAr ? 'مناطق الخدمة' : 'Service Areas' }}</a></li>
                <li class="eq8-bc__sep">/</li>
                <li class="eq8-bc__current" aria-current="page">{{ $name }}</li>
            </ol>
        </div>
    </nav>

    {{-- Hero --}}
    <section class="eq8-page-hero">
        <div class="eq8-page-hero__inner">
            <div class="eq8-emergency-badge">{{ $isAr ? 'خدمة طوارئ 24 ساعة' : '24/7 Emergency Service' }}</div>
            <h1 class="eq8-page-hero__title">
                {{ $isAr ? "فني كهربائي في {$name}" : "Electrician in {$name}" }}
            </h1>
            <p class="eq8-page-hero__sub">
                {{ $isAr
                    ? "تركيب وصيانة وتصليح شورت الكهرباء في {$name} — {$govName}"
                    : "Electrical installation, repair & short circuit repair in {$name} — {$govName}" }}
            </p>
            @include('partials.hero-btns')
        </div>
    </section>

    {{-- Intro --}}
    <section class="eq8-area-section">
        <div class="eq8-area-inner eq8-area-inner--narrow">
            @if($desc)
                <p class="eq8-area-intro">{{ $desc }}</p>
            @else
                <p class="eq8-area-intro">
                    @if($isAr)
                        تقدم إلكتريك كويت خدمات كهرباء متكاملة في <strong>{{ $name }}</strong>، من تركيب وصيانة وتصليح شورت، وصولًا إلى خدمة الطوارئ على مدار الساعة. فنيونا المعتمدون يصلون إليك في {{ $name }} خلال ساعة واحدة، مزودين بجميع الأدوات اللازمة لإنهاء العمل في أول زيارة.
                    @else
                        ElectricQ8 provides comprehensive electrical services in <strong>{{ $name }}</strong>, covering installation, maintenance, short circuit repair, and 24-hour emergency callouts. Our certified technicians reach you in {{ $name }} within one hour, equipped with all tools and parts needed to complete the job on the first visit.
                    @endif
                </p>
            @endif
        </div>
    </section>

    {{-- Services --}}
    <section class="eq8-area-section eq8-area-section--alt">
        <div class="eq8-area-inner">
            <div class="eq8-section-head">
                <h2 class="eq8-section-title">
                    {{ $isAr ? "خدمات الكهرباء في {$name}" : "Electrical Services in {$name}" }}
                </h2>
                <p class="eq8-section-sub">{{ $isAr ? 'جميع خدمات الكهرباء في موقعك' : 'All electrical services at your location' }}</p>
            </div>
            <div class="eq8-area-svc-grid">
                @foreach($services as $service)
                <a href="{{ route($isAr ? 'services.show' : 'en.services.show', $service->getTranslation('slug', $locale)) }}"
                   class="eq8-svc-card">
                    <div class="eq8-svc-card__icon">{{ $service->icon() }}</div>
                    <h3 class="eq8-svc-card__title">{{ $service->getTranslation('title', $locale) }}</h3>
                    <p class="eq8-svc-card__body">{{ html_entity_decode(strip_tags($service->getTranslation('intro', $locale)), ENT_QUOTES | ENT_HTML5, 'UTF-8') }}</p>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Why choose us --}}
    <section class="eq8-area-section">
        <div class="eq8-area-inner eq8-area-inner--mid">
            <h2 class="eq8-area-h2 eq8-area-h2--center">
                {{ $isAr ? "لماذا تختار إلكتريك كويت في {$name}؟" : "Why Choose ElectricQ8 in {$name}?" }}
            </h2>
            <div class="eq8-area-adv-grid">
                @php
                $advantages = $isAr ? [
                    ['⚡', 'وصول سريع', "فنيونا في {$name} يصلون إليك خلال ساعة واحدة في أي وقت."],
                    ['🔧', 'فنيون معتمدون', 'جميع فنيينا حاصلون على شهادات معتمدة وخبرة أكثر من 5 سنوات.'],
                    ['🛡️', 'ضمان 3 أشهر', 'كل خدمة مغطاة بضمان رسمي 3 أشهر. إذا عادت المشكلة نصلحها مجانًا.'],
                    ['💰', 'أسعار شفافة', 'نقدم تقديراً واضحاً للسعر قبل بدء العمل، بدون رسوم مخفية.'],
                    ['🏷️', 'جميع الماركات', 'نصلح جميع ماركات الكهرباء المتوفرة في السوق الكويتي.'],
                    ['📞', 'دعم مستمر', 'فريق دعم متاح على مدار الساعة للرد على استفساراتك.'],
                ] : [
                    ['⚡', 'Fast Arrival', "Our technicians in {$name} reach you within one hour any time."],
                    ['🔧', 'Certified Technicians', 'All our technicians hold certified qualifications and 5+ years of experience.'],
                    ['🛡️', '3-Month Warranty', 'Every service is covered by an official 3-month warranty.'],
                    ['💰', 'Transparent Pricing', 'We provide a clear price estimate before starting — no hidden fees.'],
                    ['🏷️', 'All Brands', 'We repair all AC brands available in the Kuwait market.'],
                    ['📞', 'Continuous Support', 'Support team available around the clock to answer your queries.'],
                ];
                @endphp
                @foreach($advantages as $adv)
                <div class="eq8-adv-card">
                    <span class="eq8-adv-card__icon">{{ $adv[0] }}</span>
                    <div>
                        <h3 class="eq8-adv-card__title">{{ $adv[1] }}</h3>
                        <p class="eq8-adv-card__body">{{ $adv[2] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Testimonials --}}
    @if($testimonials->count())
    <section class="eq8-area-section eq8-area-section--alt">
        <div class="eq8-area-inner eq8-area-inner--mid">
            <h2 class="eq8-area-h2 eq8-area-h2--center">
                {{ $isAr ? "آراء عملاء {$name}" : "What {$name} Customers Say" }}
            </h2>
            @include('partials.testimonials', ['testimonials' => $testimonials])
        </div>
    </section>
    @endif

    {{-- Area FAQ --}}
    <section class="eq8-area-section">
        <div class="eq8-area-inner eq8-area-inner--narrow">
            <h2 class="eq8-area-h2 eq8-area-h2--center">
                {{ $isAr ? "أسئلة شائعة — فني كهربائي في {$name}" : "FAQ — Electrician in {$name}" }}
            </h2>
            @php
            $faqs = $isAr ? [
                ['q' => "هل تخدمون منطقة {$name}؟", 'a' => "نعم، نقدم جميع خدمات الكهرباء في {$name} بما فيها التركيب والصيانة وتصليح الشورت. فنيونا يصلون إليك خلال ساعة واحدة."],
                ['q' => "كم وقت الانتظار لخدمة طوارئ في {$name}؟", 'a' => "وقت الاستجابة المضمون في {$name} هو ساعة واحدة. نعمل 24 ساعة يومياً بما فيها الجمعة والعطل الرسمية."],
                ['q' => 'هل يوجد ضمان على خدمات الكهرباء؟', 'a' => 'نعم، جميع خدماتنا مغطاة بضمان رسمي 3 أشهر. إذا عادت المشكلة خلال فترة الضمان نصلحها مجانًا.'],
                ['q' => 'ما الماركات التي تدعمونها؟', 'a' => 'نصلح جميع ماركات الكهرباء: سامسونج، LG، كاريير، دايكن، ميديا، جري، توشيبا، باناسونيك، شارب، هيتاشي، ميتسوبيشي، وغيرها.'],
            ] : [
                ['q' => "Do you service the {$name} area?", 'a' => "Yes, we provide all electrical services in {$name} including installation, maintenance and short circuit repair. Our technicians reach you within one hour."],
                ['q' => "How long is the wait for emergency service in {$name}?", 'a' => "Our guaranteed response time in {$name} is one hour. We operate 24 hours a day including Fridays and public holidays."],
                ['q' => 'Is there a warranty on electrical services?', 'a' => 'Yes, all our services are covered by an official 3-month warranty. If the problem returns within the warranty period we fix it free of charge.'],
                ['q' => 'Which brands do you support?', 'a' => 'We repair all brands: Samsung, LG, Carrier, Daikin, Midea, Gree, Toshiba, Panasonic, Sharp, Hitachi, Mitsubishi and more.'],
            ];
            @endphp
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

    {{-- Related areas --}}
    @if($relatedLocations->count())
    <section class="eq8-area-section eq8-area-section--alt">
        <div class="eq8-area-inner eq8-area-inner--mid">
            <h2 class="eq8-area-h2" style="font-size:1rem">
                {{ $isAr ? "مناطق أخرى في {$govName}" : "Other areas in {$govName}" }}
            </h2>
            <div class="eq8-pill-row">
                @foreach($relatedLocations as $rel)
                @php $relName = $rel->getTranslation('name', $locale); $relSlug = $rel->getTranslation('slug', $locale); @endphp
                <a href="{{ route($isAr ? 'areas.show' : 'en.areas.show', $relSlug) }}" class="eq8-pill eq8-pill--link">
                    {{ $isAr ? "فني كهربائي {$relName}" : "Electrician {$relName}" }}
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- All services in area --}}
    @if($services->count())
    <section class="eq8-area-section">
        <div class="eq8-area-inner eq8-area-inner--mid" style="text-align:center">
            <h2 class="eq8-area-h2 eq8-area-h2--center">
                {{ $isAr ? "جميع خدمات الكهرباء في {$name}" : "All Electrical Services in {$name}" }}
            </h2>
            <p style="color:var(--muted);font-size:.84rem;margin:0 0 20px;font-family:'Cairo',sans-serif">
                {{ $isAr ? 'اختر الخدمة التي تحتاجها للحصول على صفحة مخصصة' : 'Select the service you need for a dedicated page' }}
            </p>
            <div class="eq8-pill-row eq8-pill-row--center">
                @foreach($services as $svc)
                @php
                    $svcSlug = $svc->getTranslation('slug', $locale);
                    $svcName = $svc->getTranslation('title', $locale);
                    $locSlug = $location->getTranslation('slug', $locale);
                    $prefix  = $isAr ? '' : 'en.';
                @endphp
                <a href="{{ route($prefix . 'service-locations.show', [$svcSlug, $locSlug]) }}" class="eq8-pill eq8-pill--link">
                    {{ $isAr ? "{$svcName} في {$name}" : "{$svcName} in {$name}" }}
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Final CTA --}}
    <section class="eq8-cta-band">
        <div class="eq8-area-inner" style="text-align:center;max-width:700px">
            <h2 style="font-size:clamp(1.3rem,3vw,1.8rem);font-weight:800;color:#fff;margin:0 0 10px;font-family:'Cairo',sans-serif">
                {{ $isAr ? "احجز فني كهربائي في {$name} الآن" : "Book an Electrician in {$name} Now" }}
            </h2>
            <p style="color:#F3D9BB;margin:0 0 28px;font-family:'Cairo',sans-serif">
                {{ $isAr ? 'تواصل معنا عبر واتساب أو اتصل بنا مباشرة — فنيونا جاهزون' : 'Contact us via WhatsApp or call directly — our technicians are ready' }}
            </p>
            @include('partials.hero-btns')
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
.eq8-page-hero__title { font-size:clamp(1.6rem,4vw,2.3rem); font-weight:800; margin:0 0 12px; font-family:'Cairo',system-ui,sans-serif; }
.eq8-page-hero__sub { font-size:1rem; color:#F3D9BB; margin:0 0 28px; font-family:'Cairo',system-ui,sans-serif; }
.eq8-emergency-badge { display:inline-block; background:#dc2626; color:#fff; font-size:.78rem; font-weight:700; padding:5px 16px; border-radius:999px; margin-bottom:16px; font-family:'Cairo',sans-serif; }

.eq8-area-section { padding:48px 0; background:var(--bg); }
.eq8-area-section--alt { background:var(--altBg); }
.eq8-area-inner { max-width:1100px; margin:0 auto; padding:0 20px; }
.eq8-area-inner--mid { max-width:900px; margin:0 auto; padding:0 20px; }
.eq8-area-inner--narrow { max-width:720px; margin:0 auto; padding:0 20px; }
.eq8-area-intro { font-size:1rem; color:var(--body); line-height:1.8; margin:0; font-family:'Cairo',sans-serif; }
.eq8-area-h2 { font-size:1.3rem; font-weight:800; color:var(--text); margin:0 0 24px; font-family:'Cairo',sans-serif; }
.eq8-area-h2--center { text-align:center; }

.eq8-section-head { text-align:center; margin-bottom:32px; }
.eq8-section-title { font-size:1.5rem; font-weight:800; color:var(--text); margin:0 0 8px; font-family:'Cairo',sans-serif; }
.eq8-section-sub { font-size:.9rem; color:var(--muted); margin:0; font-family:'Cairo',sans-serif; }

.eq8-area-svc-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:16px; max-width:900px; margin:0 auto; }
@media(max-width:760px){ .eq8-area-svc-grid { grid-template-columns:repeat(2,1fr); } }
@media(max-width:480px){ .eq8-area-svc-grid { grid-template-columns:1fr; } }

.eq8-svc-card { display:block; background:var(--cardBg); border:1px solid var(--border); border-radius:16px; padding:20px; text-decoration:none; transition:border-color .2s,box-shadow .2s; }
.eq8-svc-card:hover { border-color:var(--accent); box-shadow:0 4px 20px rgba(107,58,23,.1); }
.eq8-svc-card__icon { font-size:1.8rem; margin-bottom:10px; }
.eq8-svc-card__title { font-size:.9rem; font-weight:700; color:var(--text); margin:0 0 6px; font-family:'Cairo',sans-serif; }
.eq8-svc-card__body { font-size:.78rem; color:var(--body); line-height:1.65; margin:0; font-family:'Cairo',sans-serif; }

.eq8-area-adv-grid { display:grid; grid-template-columns:repeat(2,1fr); gap:14px; }
@media(max-width:600px){ .eq8-area-adv-grid { grid-template-columns:1fr; } }

.eq8-adv-card { display:flex; gap:12px; align-items:flex-start; background:var(--cardBg); border:1px solid var(--border); border-radius:12px; padding:16px; }
.eq8-adv-card__icon { font-size:1.3rem; flex-shrink:0; margin-top:2px; }
.eq8-adv-card__title { font-size:.88rem; font-weight:700; color:var(--text); margin:0 0 4px; font-family:'Cairo',sans-serif; }
.eq8-adv-card__body { font-size:.78rem; color:var(--body); line-height:1.65; margin:0; font-family:'Cairo',sans-serif; }

.eq8-faq { display:flex; flex-direction:column; gap:10px; }
.eq8-faq__item { background:var(--cardBg); border:1px solid var(--border); border-radius:12px; overflow:hidden; }
.eq8-faq__btn { width:100%; display:flex; align-items:center; justify-content:space-between; padding:16px 20px; font-family:'Cairo',sans-serif; font-weight:700; font-size:.88rem; color:var(--text); background:transparent; border:none; cursor:pointer; gap:12px; }
.eq8-faq__btn:hover { background:var(--altBg); }
.eq8-faq__q { flex:1; }
.eq8-faq__chevron { width:18px; height:18px; color:var(--accent); flex-shrink:0; transition:transform .25s; }
.eq8-faq__answer { padding:0 20px 16px; font-size:.84rem; color:var(--body); line-height:1.7; border-top:1px solid var(--border); font-family:'Cairo',sans-serif; }
.eq8-faq__answer p { margin:12px 0 0; }
.rotate-180 { transform:rotate(180deg); }

.eq8-pill-row { display:flex; flex-wrap:wrap; gap:10px; }
.eq8-pill-row--center { justify-content:center; }
.eq8-pill { display:inline-flex; align-items:center; padding:7px 18px; border-radius:999px; border:1.5px solid var(--accentTint); background:var(--cardBg); color:var(--primary); font-size:.82rem; font-weight:600; font-family:'Cairo',sans-serif; }
.eq8-pill--link { text-decoration:none; transition:background .18s,color .18s; }
.eq8-pill--link:hover { background:var(--primary); color:#fff; border-color:var(--primary); }

@media (prefers-color-scheme: dark) {
    .eq8-pill--link { color:#D97B2E; border-color:rgba(217,123,46,.35); background:rgba(217,123,46,.1); }
    .eq8-pill--link:hover { background:#D97B2E; color:#fff; border-color:#D97B2E; }
}
:root[data-theme="dark"] .eq8-pill--link { color:#D97B2E; border-color:rgba(217,123,46,.35); background:rgba(217,123,46,.1); }
:root[data-theme="dark"] .eq8-pill--link:hover { background:#D97B2E; color:#fff; border-color:#D97B2E; }
:root[data-theme="light"] .eq8-pill--link { color:var(--primary); border-color:var(--accentTint); background:var(--cardBg); }
:root[data-theme="light"] .eq8-pill--link:hover { background:var(--primary); color:#fff; border-color:var(--primary); }

.eq8-cta-band { background:linear-gradient(135deg,#43230E 0%,#6B3A17 100%); padding:56px 20px; }
</style>
@endsection
