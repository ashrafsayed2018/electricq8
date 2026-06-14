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
        : 'Contact an AC Technician in Kuwait 24/7 | ElectricQ8' }}
@endsection

@section('meta_description')
    {{ $isAr
        ? 'تواصل مع إلكتريك كويت لحجز خدمة كهرباء في الكويت — تركيب، إصلاح، تنظيف، تصليح شورت. خدمة طوارئ 24 ساعة في جميع مناطق الكويت.'
        : 'Contact ElectricQ8 to book an electrical service in Kuwait — installation, repair, cleaning, short circuit repair. 24-hour emergency service across all Kuwait areas.' }}
@endsection

@section('schema_markup')
{{-- LocalBusiness + OpeningHours Schema --}}
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": ["LocalBusiness", "electricalBusiness"],
  "name": "{{ $siteName }}",
  "url": "{{ url('/') }}",
  "telephone": "{{ $e164 }}",
  @if($email)"email": "{{ $email }}",@endif
  "description": "{{ $isAr ? 'متخصصون في خدمات كهرباء المنازل في الكويت منذ أكثر من 10 سنوات' : 'Specialists in electrical services across Kuwait for over 10 years' }}",
  "address": {
    "@@type": "PostalAddress",
    "addressCountry": "KW",
    "addressRegion": "{{ $isAr ? 'الكويت' : 'Kuwait' }}"
  },
  "areaServed": { "@@type": "Country", "name": "Kuwait" },
  "openingHoursSpecification": {
    "@@type": "OpeningHoursSpecification",
    "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
    "opens": "00:00",
    "closes": "23:59"
  }
}
</script>
{{-- Breadcrumb Schema --}}
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

{{-- ── Breadcrumb ── --}}
<nav class="bg-gray-50 border-b border-gray-200 py-3" dir="{{ $isAr ? 'rtl' : 'ltr' }}"
     aria-label="{{ $isAr ? 'مسار التنقل' : 'Breadcrumb' }}">
    <div class="container mx-auto px-4">
        <ol class="flex items-center gap-2 text-sm text-gray-500 flex-wrap">
            <li><a href="{{ route($isAr ? 'home' : 'en.home') }}" class="hover:text-yellow-700 transition">{{ $isAr ? 'الرئيسية' : 'Home' }}</a></li>
            <li aria-hidden="true" class="text-gray-300">/</li>
            <li class="text-gray-800 font-semibold" aria-current="page">{{ $isAr ? 'تواصل معنا' : 'Contact' }}</li>
        </ol>
    </div>
</nav>

<div class="contact-page" dir="{{ $isAr ? 'rtl' : 'ltr' }}">

    {{-- ── H1 (SEO) above the card — visually hidden on small, shown on large ── --}}
    <div class="container mx-auto px-4 max-w-5xl">
        <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-6 text-center">
            {{ $isAr
                ? 'تواصل مع فني كهربائي بالكويت — خدمة 24 ساعة'
                : 'Contact an AC Technician in Kuwait — 24-Hour Service' }}
        </h1>
    </div>

    {{-- ── Two-column card ── --}}
    <div class="contact-grid">

        {{-- Info panel --}}
        <div class="contact-info-panel">

            <div class="contact-brand">
                <span class="contact-brand-icon">❄️</span>
                <span class="contact-brand-name">ElectricQ8</span>
            </div>

            <p class="contact-info-sub">
                {{ $isAr
                    ? 'اترك لنا رسالة وسنتواصل معك خلال دقائق. خدمة سريعة واحترافية على مدار الساعة.'
                    : "Leave us a message and we'll get back to you within minutes. Fast, professional service around the clock." }}
            </p>

            {{-- NAP — Name / Area / Phone --}}
            <ul class="contact-info-list">
                <li>
                    <span class="contact-info-icon" style="background:#fefce8;color:#ca8a04">📞</span>
                    <div>
                        <span class="contact-info-label">{{ $isAr ? 'اتصل بنا' : 'Call Us' }}</span>
                        <a href="tel:{{ $phone }}" class="contact-info-value" dir="ltr">{{ $phone }}</a>
                    </div>
                </li>
                <li>
                    <span class="contact-info-icon" style="background:#dcfce7;color:#16a34a">💬</span>
                    <div>
                        <span class="contact-info-label">WhatsApp</span>
                        <a href="{{ \App\Helpers\WhatsAppHelper::url() }}" target="_blank" rel="noopener"
                           class="contact-info-value">
                            {{ $isAr ? 'راسلنا مباشرة' : 'Message us directly' }}
                        </a>
                    </div>
                </li>
                @if($email)
                <li>
                    <span class="contact-info-icon" style="background:#ede9fe;color:#7c3aed">✉️</span>
                    <div>
                        <span class="contact-info-label">{{ $isAr ? 'البريد الإلكتروني' : 'Email' }}</span>
                        <a href="mailto:{{ $email }}" class="contact-info-value" dir="ltr">{{ $email }}</a>
                    </div>
                </li>
                @endif
                <li>
                    <span class="contact-info-icon" style="background:#fef9c3;color:#ca8a04">🕐</span>
                    <div>
                        <span class="contact-info-label">{{ $isAr ? 'ساعات العمل' : 'Working Hours' }}</span>
                        <span class="contact-info-value">
                            {{ $isAr
                                ? 'السبت – الجمعة: 24 ساعة'
                                : 'Sat – Fri: 24 Hours' }}
                        </span>
                    </div>
                </li>
                <li>
                    <span class="contact-info-icon" style="background:#fce7f3;color:#be185d">📍</span>
                    <div>
                        <span class="contact-info-label">{{ $isAr ? 'مناطق الخدمة' : 'Service Areas' }}</span>
                        <span class="contact-info-value">
                            {{ $isAr
                                ? 'الكويت — خدمة متنقلة لجميع المحافظات'
                                : 'Kuwait — Mobile service across all governorates' }}
                        </span>
                    </div>
                </li>
            </ul>

            {{-- Trust badges --}}
            <div class="contact-badges">
                <span class="contact-badge">✅ {{ $isAr ? 'فنيون معتمدون' : 'Certified Techs' }}</span>
                <span class="contact-badge">🛡️ {{ $isAr ? 'ضمان 3 أشهر' : '3-Month Warranty' }}</span>
                <span class="contact-badge">⚡ {{ $isAr ? 'استجابة خلال ساعة' : '1-Hour Response' }}</span>
            </div>

        </div>

        {{-- Form panel --}}
        <div class="contact-form-panel">
            <livewire:contact-form />
        </div>

    </div>

    {{-- ── SEO text block — below the form card ── --}}
    <div class="contact-seo-block" dir="{{ $isAr ? 'rtl' : 'ltr' }}">

        <h2>{{ $isAr ? 'خدمات الكهرباء التي نقدمها في الكويت' : 'Electrical Services We Provide Across Kuwait' }}</h2>

        @if($isAr)
        <p>إلكتريك كويت متخصصة في تقديم جميع خدمات الكهرباء للمنازل والمكاتب والمنشآت التجارية في جميع محافظات الكويت. سواء كنت تحتاج إلى <strong>تمديدات كهربائية جديد</strong>، أو <strong>صيانة وإصلاح عطل</strong>، أو <strong>تنظيف دوري</strong>، أو <strong>تصليح شورت فريون</strong>، أو <strong>خدمة طوارئ عاجلة</strong> في منتصف الليل — فنيونا المعتمدون يصلون إليك خلال ساعة واحدة في أي منطقة من مناطق الكويت.</p>
        <p>نقدم ضمانًا رسميًا مدته 3 أشهر على جميع الأعمال، وأسعارًا شفافة تُعرض عليك قبل بدء أي عمل. لا رسوم مخفية، لا مفاجآت.</p>
        @else
        <p>ElectricQ8 specialises in all electrical services for homes, offices and commercial facilities across all Kuwait governorates. Whether you need a <strong>new electrical installation</strong>, <strong>fault repair and maintenance</strong>, <strong>routine cleaning</strong>, <strong>refrigerant short circuit repair</strong>, or an <strong>urgent emergency callout</strong> in the middle of the night — our certified technicians reach you within one hour in any area of Kuwait.</p>
        <p>We provide an official 3-month warranty on all work and transparent pricing presented to you before starting. No hidden fees, no surprises.</p>
        @endif

        <div class="contact-seo-services">
            @php
            $seoServices = $isAr ? [
                ['🔧', 'تمديدات كهربائية',          '/services'],
                ['🛠️','صيانة وإصلاح كهرباء',   '/services'],
                ['🧹', 'تصليح كهرباء',          '/services'],
                ['💨', 'تصليح شورت كهرباء',        '/services'],
                ['🚨', 'طوارئ كهرباء 24 ساعة',  '/services'],
            ] : [
                ['🔧', 'Electrical Installation',          '/en/services'],
                ['🛠️','Electrical Repair & Maintenance',  '/en/services'],
                ['🧹', 'AC Cleaning',              '/en/services'],
                ['💨', 'Electrical Refill',            '/en/services'],
                ['🚨', '24-Hour Electrical Emergency',     '/en/services'],
            ];
            @endphp
            @foreach($seoServices as [$icon, $label, $href])
            <a href="{{ $href }}" class="contact-seo-chip">{{ $icon }} {{ $label }}</a>
            @endforeach
        </div>

        <div class="contact-seo-areas">
            <h3>{{ $isAr ? 'مناطق خدمة الكهرباء' : 'Electrical Service Areas' }}</h3>
            @php
            $govs = $isAr
                ? ['محافظة العاصمة','محافظة حولي','محافظة الفروانية','محافظة الجهراء','محافظة الأحمدي','محافظة مبارك الكبير']
                : ['Capital Governorate','Hawalli Governorate','Farwaniya Governorate','Jahra Governorate','Ahmadi Governorate','Mubarak Al-Kabeer Governorate'];
            $areasRoute = route($isAr ? 'areas.index' : 'en.areas.index');
            @endphp
            <div class="contact-seo-govs">
                @foreach($govs as $gov)
                <a href="{{ $areasRoute }}" class="contact-seo-chip contact-seo-chip--area">📍 {{ $gov }}</a>
                @endforeach
            </div>
        </div>

    </div>
</div>

<style>
/* ── page shell ─────────────────────────────────────────────── */
.contact-page {
    background: #f1f5f9;
    padding: 32px 16px 64px;
    font-family: 'Cairo', sans-serif;
}

/* ── two-column grid ────────────────────────────────────────── */
.contact-grid {
    display: grid;
    grid-template-columns: 1fr 1.15fr;
    gap: 0;
    max-width: 1000px;
    margin: 0 auto 48px;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 8px 40px rgba(0,0,0,0.10);
}
@media (max-width: 768px) {
    .contact-grid { grid-template-columns: 1fr; }
}

/* ── info panel ─────────────────────────────────────────────── */
.contact-info-panel {
    background: linear-gradient(145deg, #a16207 0%, #ca8a04 50%, #d97706 100%);
    color: #fff;
    padding: 48px 36px;
    display: flex;
    flex-direction: column;
    gap: 0;
}
.contact-brand {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 28px;
}
.contact-brand-icon { font-size: 28px; }
.contact-brand-name { font-size: 22px; font-weight: 800; letter-spacing: -0.3px; }
.contact-info-sub {
    font-size: 0.9rem;
    opacity: 0.85;
    line-height: 1.7;
    margin: 0 0 32px;
}

/* info list */
.contact-info-list {
    list-style: none;
    padding: 0;
    margin: 0 0 32px;
    display: flex;
    flex-direction: column;
    gap: 18px;
}
.contact-info-list li {
    display: flex;
    align-items: flex-start;
    gap: 14px;
}
.contact-info-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
}
.contact-info-label {
    display: block;
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    opacity: 0.6;
    margin-bottom: 2px;
}
.contact-info-value {
    display: block;
    font-size: 0.9rem;
    font-weight: 600;
    color: #fff;
    text-decoration: none;
}
.contact-info-value:hover { text-decoration: underline; }

/* trust badges */
.contact-badges {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: auto;
    padding-top: 20px;
    border-top: 1px solid rgba(255,255,255,0.15);
}
.contact-badge {
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 999px;
    padding: 5px 14px;
    font-size: 11px;
    font-weight: 600;
    white-space: nowrap;
}

/* ── form panel ─────────────────────────────────────────────── */
.contact-form-panel {
    background: #ffffff;
    padding: 48px 40px;
}
@media (max-width: 480px) {
    .contact-info-panel { padding: 32px 20px; }
    .contact-form-panel { padding: 32px 20px; }
}

/* ── SEO block below form ──────────────────────────────────── */
.contact-seo-block {
    max-width: 1000px;
    margin: 0 auto;
    background: #fff;
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 2px 16px rgba(0,0,0,0.06);
}
.contact-seo-block h2 {
    font-size: 1.2rem;
    font-weight: 800;
    color: #111827;
    margin: 0 0 16px;
    font-family: 'Cairo', sans-serif;
}
.contact-seo-block h3 {
    font-size: 0.95rem;
    font-weight: 700;
    color: #374151;
    margin: 24px 0 10px;
    font-family: 'Cairo', sans-serif;
}
.contact-seo-block p {
    color: #4b5563;
    font-size: 0.9rem;
    line-height: 1.8;
    margin: 0 0 12px;
    font-family: 'Cairo', sans-serif;
}

.contact-seo-services,
.contact-seo-govs {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 12px;
}

.contact-seo-chip {
    display: inline-flex;
    align-items: center;
    padding: 6px 16px;
    border-radius: 999px;
    border: 1.5px solid #bfdbfe;
    background: #eff6ff;
    color: #ca8a04;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: background 0.18s, color 0.18s;
    font-family: 'Cairo', sans-serif;
}
.contact-seo-chip:hover {
    background: #ca8a04;
    color: #fff;
    border-color: #ca8a04;
}
.contact-seo-chip--area {
    background: #f0fdf4;
    border-color: #bbf7d0;
    color: #166534;
}
.contact-seo-chip--area:hover {
    background: #166534;
    color: #fff;
    border-color: #166534;
}
</style>
@endsection
