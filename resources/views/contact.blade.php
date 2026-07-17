@extends('layouts.app')

@php
    $isAr     = app()->getLocale() === 'ar';
    $locale   = $isAr ? 'ar' : 'en';
    $phone    = \App\Models\SiteSetting::get('phone_number');
    $e164     = '+965' . preg_replace('/\D/', '', $phone);
    $email    = \App\Models\SiteSetting::get('email');
    $siteName = \App\Models\SiteSetting::get('site_name_' . $locale);
@endphp

@section('meta_title')
    {{ $isAr
        ? 'تواصل مع فني كهربائي بالكويت 24 ساعة | إلكتريك كويت'
        : 'Contact an Electrician in Kuwait 24/7 | ElectricQ8' }}
@endsection

@section('meta_description')
    {{ $isAr
        ? 'تواصل مع إلكتريك كويت لحجز خدمة كهرباء في الكويت — تركيب، إصلاح، تصليح شورت. خدمة طوارئ 24 ساعة في جميع مناطق الكويت.'
        : 'Contact ElectricQ8 to book an electrical service in Kuwait — installation, repair, short circuit repair. 24-hour emergency service across all Kuwait areas.' }}
@endsection

@section('schema_markup')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": ["LocalBusiness", "electricalBusiness"],
  "name": "{{ $siteName }}",
  "url": "{{ url('/') }}",
  "telephone": "{{ $e164 }}",
  @if($email)"email": "{{ $email }}",@endif
  "address": { "@@type": "PostalAddress", "addressCountry": "KW" },
  "areaServed": { "@@type": "Country", "name": "Kuwait" },
  "openingHoursSpecification": {
    "@@type": "OpeningHoursSpecification",
    "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
    "opens": "00:00", "closes": "23:59"
  }
}
</script>
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "BreadcrumbList",
  "itemListElement": [
    {"@@type":"ListItem","position":1,"name":"{{ $isAr ? 'الرئيسية' : 'Home' }}","item":"{{ url($isAr ? '/' : '/en') }}"},
    {"@@type":"ListItem","position":2,"name":"{{ $isAr ? 'تواصل معنا' : 'Contact' }}","item":"{{ url()->current() }}"}
  ]
}
</script>
@endsection

@section('content')

{{-- Breadcrumb --}}
<nav class="eq8-bc" dir="{{ $isAr ? 'rtl' : 'ltr' }}" aria-label="{{ $isAr ? 'مسار التنقل' : 'Breadcrumb' }}">
    <div class="eq8-bc__inner">
        <ol class="eq8-bc__list">
            <li><a href="{{ route($isAr ? 'home' : 'en.home') }}" class="eq8-bc__link">{{ $isAr ? 'الرئيسية' : 'Home' }}</a></li>
            <li aria-hidden="true" class="eq8-bc__sep">/</li>
            <li class="eq8-bc__current" aria-current="page">{{ $isAr ? 'تواصل معنا' : 'Contact' }}</li>
        </ol>
    </div>
</nav>

<div class="eq8-contact-page" dir="{{ $isAr ? 'rtl' : 'ltr' }}">

    <div class="eq8-contact-page__inner">
        <h1 class="eq8-contact-page__h1">
            {{ $isAr
                ? 'تواصل مع فني كهربائي بالكويت — خدمة 24 ساعة'
                : 'Contact an Electrician in Kuwait — 24-Hour Service' }}
        </h1>
    </div>

    {{-- Two-column card --}}
    <div class="eq8-contact-grid">

        {{-- Info panel --}}
        <div class="eq8-contact-info">
            <div class="eq8-contact-info__brand">
                <span>⚡</span>
                <span class="eq8-contact-info__name">ElectricQ8</span>
            </div>
            <p class="eq8-contact-info__sub">
                {{ $isAr
                    ? 'اترك لنا رسالة وسنتواصل معك خلال دقائق. خدمة سريعة واحترافية على مدار الساعة.'
                    : "Leave us a message and we'll get back to you within minutes. Fast, professional service around the clock." }}
            </p>
            <ul class="eq8-contact-info__list">
                <li>
                    <span class="eq8-info-icon">📞</span>
                    <div>
                        <span class="eq8-info-label">{{ $isAr ? 'اتصل بنا' : 'Call Us' }}</span>
                        <a href="tel:{{ $phone }}" class="eq8-info-value" dir="ltr">{{ $phone }}</a>
                    </div>
                </li>
                <li>
                    <span class="eq8-info-icon">💬</span>
                    <div>
                        <span class="eq8-info-label">WhatsApp</span>
                        <a href="{{ \App\Helpers\WhatsAppHelper::url() }}" target="_blank" rel="noopener" class="eq8-info-value">
                            {{ $isAr ? 'راسلنا مباشرة' : 'Message us directly' }}
                        </a>
                    </div>
                </li>
                @if($email)
                <li>
                    <span class="eq8-info-icon">✉️</span>
                    <div>
                        <span class="eq8-info-label">{{ $isAr ? 'البريد الإلكتروني' : 'Email' }}</span>
                        <a href="mailto:{{ $email }}" class="eq8-info-value" dir="ltr">{{ $email }}</a>
                    </div>
                </li>
                @endif
                <li>
                    <span class="eq8-info-icon">🕐</span>
                    <div>
                        <span class="eq8-info-label">{{ $isAr ? 'ساعات العمل' : 'Working Hours' }}</span>
                        <span class="eq8-info-value">{{ $isAr ? 'السبت – الجمعة: 24 ساعة' : 'Sat – Fri: 24 Hours' }}</span>
                    </div>
                </li>
                <li>
                    <span class="eq8-info-icon">📍</span>
                    <div>
                        <span class="eq8-info-label">{{ $isAr ? 'مناطق الخدمة' : 'Service Areas' }}</span>
                        <span class="eq8-info-value">{{ $isAr ? 'الكويت — جميع المحافظات' : 'Kuwait — All Governorates' }}</span>
                    </div>
                </li>
            </ul>
            <div class="eq8-contact-info__badges">
                <span class="eq8-contact-badge">✅ {{ $isAr ? 'فنيون معتمدون' : 'Certified Techs' }}</span>
                <span class="eq8-contact-badge">🛡️ {{ $isAr ? 'ضمان 3 أشهر' : '3-Month Warranty' }}</span>
                <span class="eq8-contact-badge">⚡ {{ $isAr ? 'استجابة خلال ساعة' : '1-Hour Response' }}</span>
            </div>
        </div>

        {{-- Form panel --}}
        <div class="eq8-contact-form-panel">
            <livewire:contact-form />
        </div>

    </div>

    {{-- SEO block --}}
    <div class="eq8-contact-seo" dir="{{ $isAr ? 'rtl' : 'ltr' }}">
        <h2 class="eq8-contact-seo__h2">{{ $isAr ? 'خدمات الكهرباء التي نقدمها في الكويت' : 'Electrical Services We Provide Across Kuwait' }}</h2>

        @if($isAr)
        <p class="eq8-contact-seo__p">إلكتريك كويت متخصصة في تقديم جميع خدمات الكهرباء للمنازل والمكاتب والمنشآت التجارية في جميع محافظات الكويت. سواء كنت تحتاج إلى <strong>تمديدات كهربائية</strong>، أو <strong>صيانة وإصلاح عطل</strong>، أو <strong>تصليح شورت</strong>، أو <strong>خدمة طوارئ عاجلة</strong> في منتصف الليل — فنيونا المعتمدون يصلون إليك خلال ساعة واحدة.</p>
        <p class="eq8-contact-seo__p">نقدم ضمانًا رسميًا مدته 3 أشهر على جميع الأعمال، وأسعارًا شفافة تُعرض عليك قبل بدء أي عمل.</p>
        @else
        <p class="eq8-contact-seo__p">ElectricQ8 specialises in all electrical services for homes, offices and commercial facilities across all Kuwait governorates. Whether you need a <strong>new electrical installation</strong>, <strong>fault repair</strong>, <strong>short circuit repair</strong>, or an <strong>urgent emergency callout</strong> — our certified technicians reach you within one hour.</p>
        <p class="eq8-contact-seo__p">We provide an official 3-month warranty on all work and transparent pricing before starting. No hidden fees, no surprises.</p>
        @endif

        <div class="eq8-contact-seo__chips">
            @php
            $seoServices = $isAr ? [
                ['🔧', 'تمديدات كهربائية', '/services'],
                ['🛠️','صيانة وإصلاح كهرباء', '/services'],
                ['⚡', 'تصليح شورت كهرباء', '/services'],
                ['💡', 'تركيب إضاءة وسبوت لايت', '/services'],
                ['🚨', 'طوارئ كهرباء 24 ساعة', '/services'],
            ] : [
                ['🔧', 'Electrical Installation', '/en/services'],
                ['🛠️','Electrical Repair & Maintenance', '/en/services'],
                ['⚡', 'Short Circuit Repair', '/en/services'],
                ['💡', 'Lighting & Spotlight', '/en/services'],
                ['🚨', '24-Hour Electrical Emergency', '/en/services'],
            ];
            @endphp
            @foreach($seoServices as [$icon, $label, $href])
            <a href="{{ $href }}" class="eq8-seo-chip">{{ $icon }} {{ $label }}</a>
            @endforeach
        </div>

        <div class="eq8-contact-seo__areas">
            <h3 class="eq8-contact-seo__h3">{{ $isAr ? 'مناطق خدمة الكهرباء' : 'Electrical Service Areas' }}</h3>
            @php
            $govs = $isAr
                ? ['محافظة العاصمة','محافظة حولي','محافظة الفروانية','محافظة الجهراء','محافظة الأحمدي','محافظة مبارك الكبير']
                : ['Capital Governorate','Hawalli Governorate','Farwaniya Governorate','Jahra Governorate','Ahmadi Governorate','Mubarak Al-Kabeer Governorate'];
            $areasRoute = route($isAr ? 'areas.index' : 'en.areas.index');
            @endphp
            <div class="eq8-contact-seo__chips">
                @foreach($govs as $gov)
                <a href="{{ $areasRoute }}" class="eq8-seo-chip eq8-seo-chip--area">📍 {{ $gov }}</a>
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
.eq8-bc { background:var(--altBg); border-bottom:1px solid var(--border); padding:10px 0; font-size:13px; font-family:'Cairo',sans-serif; }
.eq8-bc__inner { max-width:1000px; margin:0 auto; padding:0 16px; }
.eq8-bc__list { display:flex; align-items:center; gap:8px; list-style:none; margin:0; padding:0; flex-wrap:wrap; color:var(--muted); }
.eq8-bc__link { color:var(--primaryText); text-decoration:none; font-weight:600; }
.eq8-bc__link:hover { text-decoration:underline; }
.eq8-bc__sep { color:var(--border); }
.eq8-bc__current { color:var(--text); font-weight:600; }

.eq8-contact-page { background:var(--bg); padding:32px 16px 64px; font-family:'Cairo',sans-serif; }
.eq8-contact-page__inner { max-width:1000px; margin:0 auto 24px; }
.eq8-contact-page__h1 { font-size:clamp(1.4rem,3vw,1.9rem); font-weight:800; color:var(--text); text-align:center; margin:0 0 24px; }

.eq8-contact-grid { display:grid; grid-template-columns:1fr 1.15fr; max-width:1000px; margin:0 auto 48px; border-radius:24px; overflow:hidden; box-shadow:0 8px 40px rgba(0,0,0,.10); }
@media(max-width:768px){ .eq8-contact-grid { grid-template-columns:1fr; } }

.eq8-contact-info { background:linear-gradient(145deg,#43230E 0%,#6B3A17 60%,#8B4D20 100%); color:#fff; padding:48px 36px; display:flex; flex-direction:column; gap:0; }
.eq8-contact-info__brand { display:flex; align-items:center; gap:10px; margin-bottom:28px; font-size:22px; font-weight:800; }
.eq8-contact-info__name { font-size:22px; font-weight:800; }
.eq8-contact-info__sub { font-size:.9rem; color:rgba(255,255,255,.82); line-height:1.7; margin:0 0 32px; }
.eq8-contact-info__list { list-style:none; padding:0; margin:0 0 32px; display:flex; flex-direction:column; gap:18px; }
.eq8-contact-info__list li { display:flex; align-items:flex-start; gap:14px; }
.eq8-info-icon { font-size:18px; flex-shrink:0; margin-top:2px; }
.eq8-info-label { display:block; font-size:10px; text-transform:uppercase; letter-spacing:.08em; color:rgba(255,255,255,.58); margin-bottom:2px; }
.eq8-info-value { display:block; font-size:.9rem; font-weight:600; color:#fff; text-decoration:none; }
.eq8-info-value:hover { text-decoration:underline; }
.eq8-contact-info__badges { display:flex; flex-wrap:wrap; gap:8px; margin-top:auto; padding-top:20px; border-top:1px solid rgba(255,255,255,.15); }
.eq8-contact-badge { background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.2); border-radius:999px; padding:5px 14px; font-size:11px; font-weight:600; white-space:nowrap; }

.eq8-contact-form-panel { background:var(--cardBg); padding:48px 40px; }
@media(max-width:480px){ .eq8-contact-info { padding:32px 20px; } .eq8-contact-form-panel { padding:32px 20px; } }

.eq8-contact-seo { max-width:1000px; margin:0 auto; background:var(--cardBg); border:1px solid var(--border); border-radius:20px; padding:40px; }
.eq8-contact-seo__h2 { font-size:1.1rem; font-weight:800; color:var(--text); margin:0 0 16px; font-family:'Cairo',sans-serif; }
.eq8-contact-seo__h3 { font-size:.9rem; font-weight:700; color:var(--text); margin:24px 0 10px; font-family:'Cairo',sans-serif; }
.eq8-contact-seo__p { color:var(--body); font-size:.88rem; line-height:1.8; margin:0 0 12px; font-family:'Cairo',sans-serif; }
.eq8-contact-seo__areas { margin-top:16px; }
.eq8-contact-seo__chips { display:flex; flex-wrap:wrap; gap:8px; margin-top:12px; }
.eq8-seo-chip { display:inline-flex; align-items:center; padding:6px 16px; border-radius:999px; border:1.5px solid var(--accentTint); background:var(--altBg); color:var(--primaryText); font-size:13px; font-weight:600; text-decoration:none; transition:background .18s,color .18s,border-color .18s; font-family:'Cairo',sans-serif; }
.eq8-seo-chip:hover { background:var(--primary); color:#fff; border-color:var(--primary); }
.eq8-seo-chip--area { background:var(--altBg); border-color:var(--border); color:var(--text); }
.eq8-seo-chip--area:hover { background:var(--primaryDk); color:#fff; border-color:var(--primaryDk); }
</style>
@endsection
