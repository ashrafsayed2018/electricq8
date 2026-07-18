@extends('layouts.app')

@php
    $isAr     = app()->getLocale() === 'ar';
    $locale   = $isAr ? 'ar' : 'en';
    $phone    = \App\Models\SiteSetting::get('phone_number');
    $e164     = '+965' . preg_replace('/\D/', '', $phone);
    $email    = \App\Models\SiteSetting::get('email');
    $siteName = \App\Models\SiteSetting::get('site_name_' . $locale);
    $insta    = \App\Models\SiteSetting::get('instagram_url');
    $snap     = \App\Models\SiteSetting::get('snapchat_url');
    $tiktok   = \App\Models\SiteSetting::get('tiktok_url');
@endphp

@section('meta_title')
    {{ $isAr ? 'من نحن — إلكتريك كويت لخدمات الكهرباء بالكويت' : 'About Us — ElectricQ8 Electrical Services Kuwait' }}
@endsection
@section('meta_description')
    {{ $isAr ? 'تعرف على إلكتريك كويت — أكثر من 10 سنوات في تقديم خدمات كهرباء المنازل بالكويت.' : 'Learn about ElectricQ8 — over 10 years providing electrical services across Kuwait.' }}
@endsection

@section('schema_markup')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": ["LocalBusiness", "electricalBusiness"],
  "name": "{{ $siteName }}",
  "url": "{{ url('/') }}",
  "telephone": "{{ $e164 }}",
  "email": "{{ $email }}",
  "foundingDate": "2014",
  "address": { "@@type": "PostalAddress", "addressCountry": "KW", "addressRegion": "Kuwait" },
  "areaServed": { "@@type": "Country", "name": "Kuwait" },
  "openingHoursSpecification": { "@@type": "OpeningHoursSpecification", "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"], "opens": "00:00", "closes": "23:59" },
  "sameAs": ["{{ $insta }}", "{{ $snap }}", "{{ $tiktok }}"]
}
</script>
@endsection

@section('content')
<div dir="{{ $isAr ? 'rtl' : 'ltr' }}">

{{-- Hero --}}
<section class="eq8-page-hero">
    <div class="eq8-page-hero__inner">
        <h1 class="eq8-page-hero__title">
            {{ $isAr ? 'من نحن — إلكتريك كويت لخدمات الكهرباء' : 'About Us — ElectricQ8 Electrical Services' }}
        </h1>
        <p class="eq8-page-hero__sub">
            {{ $isAr ? 'أكثر من عقد من تقديم خدمات الكهرباء الاحترافية في جميع أنحاء الكويت' : 'Over a decade of professional electrical services across all of Kuwait' }}
        </p>
    </div>
</section>

{{-- Story --}}
<section class="eq8-pg-section">
    <div class="eq8-pg-inner">
        <div class="eq8-pg-2col">
            <div>
                <h2 class="eq8-pg-h2">{{ $isAr ? 'قصتنا' : 'Our Story' }}</h2>
                <div class="eq8-pg-prose">
                    @if($isAr)
                        <p>بدأت إلكتريك كويت بهدف واحد واضح: تقديم خدمات كهرباء سريعة واحترافية يستحقها سكان الكويت. في دولة يصل فيها صيف الخليج إلى 50 درجة، لا يتحمل العميل الانتظار أياماً لإصلاح كهرباءه — ولا يقبل بفني يصل بدون أدوات أو بأسعار مبهمة.</p>
                        <p>لاحظنا هذه الفجوة الكبيرة في السوق الكويتي، فأسسنا فريقاً من الفنيين المعتمدين الذين يعملون على مدار الساعة، يصلون إلى العميل في ساعة واحدة، يشخصون العطل بدقة، ويقدمون سعراً واضحاً قبل بدء العمل.</p>
                        <p>اليوم، بعد أكثر من 10 سنوات وأكثر من 5000 عميل راضٍ، أصبحت إلكتريك كويت الاسم الأول الذي يتذكره الكويتيون عند أي مشكلة في الكهرباء.</p>
                    @else
                        <p>ElectricQ8 was founded with a single clear goal: to deliver fast, professional electrical services that Kuwait residents deserve.</p>
                        <p>We identified this gap in the Kuwaiti market and built a team of certified technicians operating around the clock, reaching customers within one hour, diagnosing faults accurately, and providing a clear price before starting any work.</p>
                        <p>Today, after more than 10 years and over 5,000 satisfied customers, ElectricQ8 has become the first name Kuwaitis reach for whenever they have an electrical problem.</p>
                    @endif
                </div>
            </div>
            <div class="eq8-vision-card">
                <h3 class="eq8-vision-card__title">{{ $isAr ? 'رؤيتنا ومهمتنا' : 'Vision & Mission' }}</h3>
                <div class="eq8-vision-list">
                    @php
                    $visions = [
                        ['🎯', $isAr ? 'رؤيتنا' : 'Our Vision', $isAr ? 'أن نكون الخيار الأول لخدمات الكهرباء في الكويت، معروفين بالسرعة والأمانة والجودة.' : "To be Kuwait's first choice for electrical services — known for speed, integrity, and quality."],
                        ['💡', $isAr ? 'مهمتنا' : 'Our Mission', $isAr ? 'تقديم خدمات كهرباء موثوقة بأسعار شفافة وفنيين معتمدين، لكل بيت ومكتب وشركة في الكويت.' : 'To deliver reliable electrical services at transparent prices with certified technicians for every home and business in Kuwait.'],
                        ['🤝', $isAr ? 'قيمنا' : 'Our Values', $isAr ? 'الصدق في السعر، السرعة في الوصول، الدقة في التشخيص، والالتزام بالضمان.' : 'Honest pricing, fast arrival, accurate diagnosis, and commitment to our warranty.'],
                    ];
                    @endphp
                    @foreach($visions as [$icon, $label, $body])
                    <div class="eq8-vision-item">
                        <span class="eq8-vision-item__icon">{{ $icon }}</span>
                        <div>
                            <p class="eq8-vision-item__label">{{ $label }}</p>
                            <p class="eq8-vision-item__body">{{ $body }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Stats --}}
<section class="eq8-stats-section">
    <div class="eq8-pg-inner">
        <div class="eq8-section-head" style="margin-bottom:40px">
            <h2 class="eq8-section-title" style="color:#fff">{{ $isAr ? 'خبرتنا بالأرقام' : 'Our Experience in Numbers' }}</h2>
            <p class="eq8-section-sub" style="color:#F3D9BB">{{ $isAr ? 'أرقام حقيقية تعكس سنوات العمل' : 'Real numbers reflecting years of work' }}</p>
        </div>
        <div class="eq8-stats">
            <div class="eq8-stats__item">
                <span class="eq8-stats__icon" aria-hidden="true">🏆</span>
                <span class="eq8-stats__num">+10</span>
                <span class="eq8-stats__label">{{ $isAr ? 'سنوات خبرة' : 'Years Experience' }}</span>
            </div>
            <div class="eq8-stats__item">
                <span class="eq8-stats__icon" aria-hidden="true">😊</span>
                <span class="eq8-stats__num">+5000</span>
                <span class="eq8-stats__label">{{ $isAr ? 'عميل راضٍ' : 'Satisfied Customers' }}</span>
            </div>
            <div class="eq8-stats__item">
                <span class="eq8-stats__icon" aria-hidden="true">✅</span>
                <span class="eq8-stats__num">+15000</span>
                <span class="eq8-stats__label">{{ $isAr ? 'مشروع منجز' : 'Projects Done' }}</span>
            </div>
            <div class="eq8-stats__item">
                <span class="eq8-stats__icon" aria-hidden="true">📍</span>
                <span class="eq8-stats__num">6</span>
                <span class="eq8-stats__label">{{ $isAr ? 'محافظات مغطاة' : 'Governorates Covered' }}</span>
            </div>
        </div>
    </div>
</section>

{{-- Services --}}
<section class="eq8-pg-section" style="background:var(--altBg)">
    <div class="eq8-pg-inner">
        <div class="eq8-section-head">
            <h2 class="eq8-section-title">{{ $isAr ? 'الخدمات التي نقدمها' : 'Services We Provide' }}</h2>
            <p class="eq8-section-sub">{{ $isAr ? 'حلول متكاملة لكل احتياجات الكهرباء في الكويت' : 'Complete solutions for all electrical needs in Kuwait' }}</p>
        </div>
        <div class="eq8-pg-grid-3">
            @php
            $svcs = $isAr ? [
                ['🔧','تمديدات كهربائية','تمديد الأسلاك والكابلات الكهربائية للمنازل والفلل والمكاتب بمعايير السلامة الكاملة.'],
                ['🛠️','صيانة وإصلاح','تشخيص وإصلاح جميع أعطال الكهرباء: انقطاع التيار، ضعف الجهد، أعطال القواطع، والأسلاك المحترقة.'],
                ['⚡','تصليح شورت الكهرباء','كشف وإصلاح الأعطال الكهربائية والقصر في الدوائر بأدوات تشخيص متطورة وبأمان تام.'],
                ['💡','تركيب إضاءة وسبوت لايت','تركيب جميع أنواع الإضاءة: سبوت لايت، إضاءة LED، لمبات سقف، وإضاءة خارجية.'],
                ['🚨','خدمة طوارئ 24 ساعة','فني كهربائي متاح فورًا في أي وقت، يصلك خلال ساعة في جميع مناطق الكويت.'],
                ['🏢','تركيب لوحات كهربائية','تركيب وتوسعة وصيانة لوحات التوزيع الكهربائية للمنازل والمباني التجارية والصناعية.'],
            ] : [
                ['🔧','Electrical Wiring','Wiring and cabling for homes, villas and offices to full safety standards.'],
                ['🛠️','Repair & Maintenance','Diagnosis and repair of all electrical faults: power cuts, low voltage, tripped breakers and burnt wiring.'],
                ['⚡','Short Circuit Repair','Detection and repair of electrical faults and short circuits using advanced diagnostic tools, safely.'],
                ['💡','Lighting & Spotlight','Installation of all lighting types: spotlights, LED strips, ceiling lights, and outdoor lighting.'],
                ['🚨','24-Hour Emergency','An electrician available instantly at any hour, reaching you within one hour across all Kuwait areas.'],
                ['🏢','Electrical Panel Installation','Installation, expansion and maintenance of electrical distribution panels for homes and commercial buildings.'],
            ];
            @endphp
            @foreach($svcs as [$icon, $title, $body])
            <div class="eq8-mini-card">
                <span class="eq8-mini-card__icon-wrap"><span class="eq8-mini-card__icon">{{ $icon }}</span></span>
                <h3 class="eq8-mini-card__title">{{ $title }}</h3>
                <p class="eq8-mini-card__body">{{ $body }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Property types --}}
<section class="eq8-pg-section">
    <div class="eq8-pg-inner">
        <div class="eq8-section-head">
            <h2 class="eq8-section-title">{{ $isAr ? 'نخدم جميع أنواع المباني' : 'All Property Types We Cover' }}</h2>
        </div>
        <div class="eq8-pg-grid-3">
            @php
            $ptypes = $isAr
                ? [['🏠','المنازل والبيوت'],['🏢','الشركات والمكاتب'],['🏭','المصانع والمستودعات'],['🏗️','المباني قيد الإنشاء'],['🛖','الفلل والقصور'],['🏪','المحلات التجارية']]
                : [['🏠','Houses & Homes'],['🏢','Companies & Offices'],['🏭','Factories & Warehouses'],['🏗️','Buildings Under Construction'],['🛖','Villas & Palaces'],['🏪','Shops & Restaurants']];
            @endphp
            @foreach($ptypes as [$icon, $label])
            <div class="eq8-ptype-card">
                <span class="eq8-ptype-card__icon">{{ $icon }}</span>
                <span class="eq8-ptype-card__label">{{ $label }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Why choose us --}}
<section class="eq8-pg-section" style="background:var(--altBg)">
    <div class="eq8-pg-inner">
        <div class="eq8-section-head">
            <h2 class="eq8-section-title">{{ $isAr ? 'لماذا يختارنا عملاؤنا؟' : 'Why Do Our Customers Choose Us?' }}</h2>
        </div>
        <div class="eq8-pg-grid-2">
            @php
            $reasons = $isAr ? [
                ['⚡','وصول خلال ساعة واحدة','لا انتظار. فنيونا يصلون إليك في غضون ساعة من تأكيد الطلب في معظم مناطق الكويت.'],
                ['🔍','تشخيص دقيق بأدوات متطورة','نستخدم أجهزة قياس الضغط والحرارة وأدوات التشخيص الرقمية لتحديد العطل بدقة من أول زيارة.'],
                ['💰','أسعار شفافة 100%','نقدم تقديراً واضحاً للسعر قبل بدء أي عمل. لا رسوم مخفية ولا مفاجآت في الفاتورة النهائية.'],
                ['🛡️','ضمان رسمي 3 أشهر','كل خدمة مغطاة بضمان رسمي مدته 3 أشهر. إذا عادت المشكلة نصلحها مجانًا بدون أي رسوم إضافية.'],
                ['🔧','فنيون معتمدون ومدربون','جميع فنيينا حاصلون على شهادات معتمدة وخبرة لا تقل عن 5 سنوات في صيانة وتركيب الكهرباء.'],
                ['📞','دعم متواصل 24/7','خط دعم مفتوح على مدار الساعة للرد على استفساراتك وتتبع حالة طلب الخدمة في الوقت الفعلي.'],
            ] : [
                ['⚡','One-Hour Arrival','No waiting. Our technicians reach you within one hour of booking confirmation in most Kuwait areas.'],
                ['🔍','Accurate Diagnosis','We use digital diagnostic equipment to identify faults precisely on the first visit.'],
                ['💰','100% Transparent Pricing','We give a clear price estimate before starting any work. No hidden fees, no surprises on the final bill.'],
                ['🛡️','Official 3-Month Warranty','Every service is backed by a 3-month official warranty. If the problem returns we fix it free of charge.'],
                ['🔧','Certified Technicians','All our technicians hold certified qualifications and have a minimum of 5 years of electrical experience.'],
                ['📞','24/7 Continuous Support','An open support line around the clock to answer your queries and track service requests in real time.'],
            ];
            @endphp
            @foreach($reasons as $i => [$icon, $title, $body])
            <div class="eq8-reason-card">
                <span class="eq8-reason-card__num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                <span class="eq8-reason-card__icon-wrap"><span class="eq8-reason-card__icon">{{ $icon }}</span></span>
                <div>
                    <h3 class="eq8-reason-card__title">{{ $title }}</h3>
                    <p class="eq8-reason-card__body">{{ $body }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Service areas --}}
<section class="eq8-pg-section">
    <div class="eq8-pg-inner">
        <div class="eq8-section-head">
            <h2 class="eq8-section-title">{{ $isAr ? 'مناطق الخدمة' : 'Service Areas' }}</h2>
            <p class="eq8-section-sub">{{ $isAr ? 'نغطي جميع المحافظات الست في الكويت' : 'We cover all six governorates across Kuwait' }}</p>
        </div>
        <div class="eq8-pg-grid-3">
            @php
            $govs = $isAr ? [
                ['🏙️','محافظة العاصمة'],['🏘️','محافظة حولي'],['🌆','محافظة الفروانية'],
                ['🌄','محافظة الجهراء'],['🏭','محافظة الأحمدي'],['🏡','محافظة مبارك الكبير'],
            ] : [
                ['🏙️','Capital Governorate'],['🏘️','Hawalli Governorate'],['🌆','Farwaniya Governorate'],
                ['🌄','Jahra Governorate'],['🏭','Ahmadi Governorate'],['🏡','Mubarak Al-Kabeer Governorate'],
            ];
            @endphp
            @foreach($govs as [$icon, $label])
            <a href="{{ $isAr ? route('areas.index') : route('en.areas.index') }}" class="eq8-gov-pill">
                <span class="eq8-gov-pill__icon-wrap"><span>{{ $icon }}</span></span>
                <span class="eq8-gov-pill__label">{{ $label }}</span>
                <svg class="eq8-gov-pill__arrow" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M9 18l6-6-6-6"/></svg>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- Contact info --}}
<section class="eq8-pg-section" style="background:var(--altBg)">
    <div class="eq8-pg-inner" style="max-width:840px">
        <div class="eq8-section-head">
            <h2 class="eq8-section-title">{{ $isAr ? 'تواصل معنا' : 'Get in Touch' }}</h2>
        </div>
        <div class="eq8-contact-panel">
        <div class="eq8-pg-grid-2">
            <a href="tel:{{ $phone }}" class="eq8-contact-card">
                <div class="eq8-contact-card__icon-wrap">
                    <svg class="eq8-contact-card__svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                </div>
                <div>
                    <p class="eq8-contact-card__label">{{ $isAr ? 'الهاتف' : 'Phone' }}</p>
                    <p class="eq8-contact-card__value" dir="ltr">{{ $phone }}</p>
                </div>
            </a>
            <a href="{{ \App\Helpers\WhatsAppHelper::url() }}" target="_blank" class="eq8-contact-card eq8-contact-card--wa">
                <div class="eq8-contact-card__icon-wrap eq8-contact-card__icon-wrap--wa">
                    <svg class="eq8-contact-card__svg" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.116 1.528 5.845L0 24l6.335-1.505A11.946 11.946 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.882a9.872 9.872 0 01-5.031-1.378l-.361-.214-3.741.981.999-3.648-.235-.374A9.869 9.869 0 012.118 12C2.118 6.963 6.963 2.118 12 2.118s9.882 4.845 9.882 9.882-4.845 9.882-9.882 9.882z"/></svg>
                </div>
                <div>
                    <p class="eq8-contact-card__label">WhatsApp</p>
                    <p class="eq8-contact-card__value">{{ $isAr ? 'تواصل فورياً' : 'Contact Instantly' }}</p>
                </div>
            </a>
            @if($email)
            <a href="mailto:{{ $email }}" class="eq8-contact-card">
                <div class="eq8-contact-card__icon-wrap">
                    <svg class="eq8-contact-card__svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <p class="eq8-contact-card__label">{{ $isAr ? 'البريد الإلكتروني' : 'Email' }}</p>
                    <p class="eq8-contact-card__value" dir="ltr" style="font-size:.85rem">{{ $email }}</p>
                </div>
            </a>
            @endif
            <div class="eq8-contact-card">
                <div class="eq8-contact-card__icon-wrap">
                    <svg class="eq8-contact-card__svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="eq8-contact-card__label">{{ $isAr ? 'ساعات العمل' : 'Working Hours' }}</p>
                    <p class="eq8-contact-card__value">{{ $isAr ? '24 ساعة / 7 أيام' : '24 Hours / 7 Days' }}</p>
                </div>
            </div>
        </div>
        @if($insta || $snap || $tiktok)
        <div class="eq8-contact-panel__social">
            <p class="eq8-contact-panel__social-label">{{ $isAr ? 'تابعنا على منصات التواصل' : 'Follow us on social media' }}</p>
            <div style="display:flex;justify-content:center;gap:16px">
                @if($insta)<a href="{{ $insta }}" target="_blank" rel="noopener" class="eq8-social-btn" aria-label="Instagram" style="background:linear-gradient(135deg,#f43f5e,#a855f7)"><svg class="eq8-social-btn__svg" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg></a>@endif
                @if($snap)<a href="{{ $snap }}" target="_blank" rel="noopener" class="eq8-social-btn" aria-label="Snapchat" style="background:#FFFC00;color:#000"><svg class="eq8-social-btn__svg" fill="currentColor" viewBox="0 0 24 24"><path d="M12.166.007C9.05 0 6.37 1.373 4.694 3.564c-.94 1.24-1.37 2.66-1.37 4.13.01.64.06 1.28.14 1.92-.31.17-.65.26-1 .26-.37 0-.74-.1-1.05-.29a.42.42 0 00-.22-.06c-.22 0-.41.17-.41.4 0 .15.08.29.21.36.74.43 1.65.67 2.57.7.04.36.1.72.17 1.07C1.94 12.63 0 13.38 0 14.19c0 .28.17.54.43.65 1.08.46 2.45.5 3.05.5.13 0 .23 0 .29.01a6.53 6.53 0 004.37 2.2c.2.02.4.03.6.03.77 0 1.52-.17 2.2-.47.05-.02.12-.03.17-.03.06 0 .12.01.17.03.68.3 1.43.47 2.2.47.2 0 .4-.01.6-.03a6.53 6.53 0 004.37-2.2c.06-.01.16-.01.29-.01.6 0 1.97-.04 3.05-.5.26-.11.43-.37.43-.65 0-.81-1.94-1.56-3.76-2.19.07-.35.13-.71.17-1.07.92-.03 1.83-.27 2.57-.7a.41.41 0 00.21-.36c0-.22-.19-.4-.41-.4a.42.42 0 00-.22.06c-.31.19-.68.29-1.05.29-.35 0-.69-.09-1-.26.08-.64.13-1.28.14-1.92 0-1.47-.43-2.89-1.37-4.13C17.63 1.373 14.95 0 12.166.007z"/></svg></a>@endif
                @if($tiktok)<a href="{{ $tiktok }}" target="_blank" rel="noopener" class="eq8-social-btn" aria-label="TikTok" style="background:#000"><svg class="eq8-social-btn__svg" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.33 6.33 0 00-.79-.05 6.34 6.34 0 00-6.34 6.34 6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.33-6.34V8.69a8.17 8.17 0 004.78 1.52V6.76a4.84 4.84 0 01-1.01-.07z"/></svg></a>@endif
            </div>
        </div>
        @endif
        </div>
    </div>
</section>

{{-- Final CTA --}}
<section class="eq8-cta-section">
    <div class="eq8-pg-inner eq8-cta-section__inner">
        <span class="eq8-cta-section__icon" aria-hidden="true">⚡</span>
        <h2 class="eq8-section-title" style="color:#fff;margin-bottom:12px">{{ $isAr ? 'مستعد لخدمتك الآن' : 'Ready to Serve You Now' }}</h2>
        <p class="eq8-cta-section__sub">{{ $isAr ? 'تواصل مع فريق إلكتريك كويت — فنيونا جاهزون في جميع مناطق الكويت' : 'Contact the ElectricQ8 team — our technicians are ready across all Kuwait areas' }}</p>
        <div class="eq8-cta-section__actions">
            <a href="{{ \App\Helpers\WhatsAppHelper::url() }}" target="_blank" rel="noopener" class="eq8-cta-section__btn eq8-cta-section__btn--wa">
                <span class="eq8-cta-section__btn-icon">
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.116 1.528 5.845L0 24l6.335-1.505A11.946 11.946 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.882a9.872 9.872 0 01-5.031-1.378l-.361-.214-3.741.981.999-3.648-.235-.374A9.869 9.869 0 012.118 12C2.118 6.963 6.963 2.118 12 2.118s9.882 4.845 9.882 9.882-4.845 9.882-9.882 9.882z"/></svg>
                </span>
                {{ $isAr ? 'واتساب الآن' : 'WhatsApp Now' }}
            </a>
            <a href="tel:{{ $phone }}" class="eq8-cta-section__btn eq8-cta-section__btn--call">
                <span class="eq8-cta-section__btn-icon">
                    <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                </span>
                {{ $isAr ? 'اتصل الآن' : 'Call Now' }}
            </a>
        </div>
    </div>
</section>

</div>

<style>
/* ── Page hero ───────────────────────────────────────────────── */
.eq8-page-hero { background:linear-gradient(135deg,#43230E 0%,#6B3A17 60%,#8B4D20 100%); color:#fff; padding:64px 20px; text-align:center; }
.eq8-page-hero__inner { max-width:800px; margin:0 auto; }
.eq8-page-hero__title { font-size:clamp(1.6rem,4vw,2.4rem); font-weight:800; margin:0 0 14px; font-family:'Cairo',system-ui,sans-serif; }
.eq8-page-hero__sub { font-size:1.05rem; color:#F3D9BB; margin:0; font-family:'Cairo',system-ui,sans-serif; }

/* ── Shared section ──────────────────────────────────────────── */
.eq8-pg-section { padding:64px 0; background:var(--bg); }
.eq8-pg-inner { max-width:1000px; margin:0 auto; padding:0 20px; }
.eq8-pg-prose p { color:var(--body); line-height:1.75; margin:0 0 14px; font-family:'Cairo',system-ui,sans-serif; font-size:.93rem; }
.eq8-pg-h2 { font-size:1.5rem; font-weight:800; color:var(--text); margin:0 0 20px; font-family:'Cairo',system-ui,sans-serif; }

/* ── Grids ───────────────────────────────────────────────────── */
.eq8-pg-2col { display:grid; grid-template-columns:1fr 1fr; gap:48px; align-items:start; }
@media(max-width:768px){ .eq8-pg-2col { grid-template-columns:1fr; } }
.eq8-pg-grid-3 { display:grid; grid-template-columns:repeat(3,1fr); gap:16px; }
@media(max-width:720px){ .eq8-pg-grid-3 { grid-template-columns:repeat(2,1fr); } }
@media(max-width:440px){ .eq8-pg-grid-3 { grid-template-columns:1fr; } }
.eq8-pg-grid-2 { display:grid; grid-template-columns:repeat(2,1fr); gap:16px; }
@media(max-width:540px){ .eq8-pg-grid-2 { grid-template-columns:1fr; } }

/* ── Vision card ─────────────────────────────────────────────── */
.eq8-vision-card { background:var(--altBg); border:1px solid var(--border); border-radius:16px; padding:28px; }
.eq8-vision-card__title { font-size:1rem; font-weight:700; color:var(--primaryText); margin:0 0 20px; font-family:'Cairo',system-ui,sans-serif; }
.eq8-vision-list { display:flex; flex-direction:column; gap:18px; }
.eq8-vision-item { display:flex; gap:12px; align-items:flex-start; }
.eq8-vision-item__icon { font-size:1.4rem; flex-shrink:0; margin-top:2px; }
.eq8-vision-item__label { font-size:.88rem; font-weight:700; color:var(--text); margin:0 0 4px; font-family:'Cairo',system-ui,sans-serif; }
.eq8-vision-item__body { font-size:.82rem; color:var(--body); line-height:1.65; margin:0; font-family:'Cairo',system-ui,sans-serif; }

/* ── Stats band ──────────────────────────────────────────────── */
.eq8-stats-section { position:relative; background:linear-gradient(135deg,#43230E 0%,#6B3A17 60%,#8B4D20 100%); padding:64px 20px; overflow:hidden; }
.eq8-stats-section::before { content:''; position:absolute; inset:0; background:radial-gradient(ellipse at 50% 0%, rgba(217,123,46,.2) 0%, transparent 60%); pointer-events:none; }
.eq8-stats-section .eq8-pg-inner { position:relative; }

.eq8-stats { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; }
@media (max-width:760px) { .eq8-stats { grid-template-columns:repeat(2,1fr); } }
.eq8-stats__item {
    display:flex;
    flex-direction:column;
    align-items:center;
    text-align:center;
    background:rgba(255,255,255,.06);
    border:1px solid rgba(255,255,255,.14);
    border-radius:16px;
    padding:26px 16px;
    transition:background .2s ease,transform .2s ease;
}
.eq8-stats__item:hover { background:rgba(255,255,255,.1); transform:translateY(-3px); }
.eq8-stats__icon { font-size:1.6rem; margin-bottom:10px; line-height:1; }
.eq8-stats__num   { display:block; font-size:2.2rem; font-weight:800; color:#fff; margin-bottom:4px; font-family:'Cairo',system-ui,sans-serif; }
.eq8-stats__label { font-size:.8rem; font-weight:600; color:#F3D9BB; font-family:'Cairo',system-ui,sans-serif; }

/* ── Mini card ───────────────────────────────────────────────── */
.eq8-mini-card { position:relative; background:var(--cardBg); border:1px solid var(--border); border-radius:14px; padding:24px 22px; overflow:hidden; transition:border-color .2s,box-shadow .2s,transform .2s; }
.eq8-mini-card::before { content:''; position:absolute; inset:0 0 auto 0; height:3px; background:linear-gradient(90deg,var(--accent),#6B3A17); transform:scaleX(0); transform-origin:0 0; transition:transform .25s ease; }
.eq8-mini-card:hover { border-color:var(--accent); box-shadow:0 8px 24px rgba(107,58,23,.12); transform:translateY(-3px); }
.eq8-mini-card:hover::before { transform:scaleX(1); }
.eq8-mini-card__icon-wrap { display:flex; align-items:center; justify-content:center; width:52px; height:52px; border-radius:14px; background:var(--accentTint); margin-bottom:16px; }
.eq8-mini-card__icon { font-size:1.6rem; line-height:1; }
.eq8-mini-card__title { font-size:.92rem; font-weight:700; color:var(--text); margin:0 0 8px; font-family:'Cairo',system-ui,sans-serif; }
.eq8-mini-card__body { font-size:.8rem; color:var(--body); line-height:1.7; margin:0; font-family:'Cairo',system-ui,sans-serif; }

/* ── Property type card ──────────────────────────────────────── */
.eq8-ptype-card { display:flex; flex-direction:column; align-items:center; gap:8px; background:var(--cardBg); border:1px solid var(--border); border-radius:12px; padding:20px 12px; text-align:center; transition:border-color .2s; }
.eq8-ptype-card:hover { border-color:var(--accent); }
.eq8-ptype-card__icon { font-size:1.8rem; }
.eq8-ptype-card__label { font-size:.82rem; font-weight:600; color:var(--text); font-family:'Cairo',system-ui,sans-serif; }

/* ── Reason card ─────────────────────────────────────────────── */
.eq8-reason-card { position:relative; display:flex; gap:14px; align-items:flex-start; background:var(--cardBg); border:1px solid var(--border); border-radius:14px; padding:22px 20px; overflow:hidden; transition:border-color .2s,box-shadow .2s,transform .2s; }
.eq8-reason-card::before { content:''; position:absolute; inset:0 0 auto 0; height:3px; background:linear-gradient(90deg,var(--accent),#6B3A17); transform:scaleX(0); transform-origin:0 0; transition:transform .25s ease; }
.eq8-reason-card:hover { border-color:var(--accent); box-shadow:0 8px 24px rgba(107,58,23,.1); transform:translateY(-3px); }
.eq8-reason-card:hover::before { transform:scaleX(1); }
.eq8-reason-card__num { position:absolute; top:14px; inset-inline-end:16px; font-size:1.4rem; font-weight:800; color:var(--border); font-family:'Cairo',system-ui,sans-serif; line-height:1; }
.eq8-reason-card__icon-wrap { display:flex; align-items:center; justify-content:center; width:44px; height:44px; border-radius:12px; background:var(--accentTint); flex-shrink:0; }
.eq8-reason-card__icon { font-size:1.3rem; line-height:1; }
.eq8-reason-card__title { font-size:.9rem; font-weight:700; color:var(--text); margin:0 0 5px; font-family:'Cairo',system-ui,sans-serif; }
.eq8-reason-card__body { font-size:.82rem; color:var(--body); line-height:1.65; margin:0; font-family:'Cairo',system-ui,sans-serif; }

/* ── Gov pill ────────────────────────────────────────────────── */
.eq8-gov-pill { display:flex; align-items:center; gap:12px; background:var(--altBg); border:1px solid var(--border); border-radius:12px; padding:14px 16px; text-decoration:none; transition:border-color .2s,background .2s,transform .2s; }
.eq8-gov-pill:hover { border-color:var(--accent); background:var(--cardBg); transform:translateY(-2px); }
.eq8-gov-pill__icon-wrap { display:flex; align-items:center; justify-content:center; width:38px; height:38px; border-radius:10px; background:var(--cardBg); flex-shrink:0; font-size:1.1rem; }
.eq8-gov-pill__label { flex:1; font-size:.85rem; font-weight:600; color:var(--primaryText); font-family:'Cairo',system-ui,sans-serif; }
.eq8-gov-pill__arrow { color:var(--muted); flex-shrink:0; transition:transform .2s ease,color .2s ease; }
.eq8-gov-pill:hover .eq8-gov-pill__arrow { color:var(--accent); transform:translateX(2px); }
[dir="rtl"] .eq8-gov-pill__arrow { transform:scaleX(-1); }
[dir="rtl"] .eq8-gov-pill:hover .eq8-gov-pill__arrow { transform:scaleX(-1) translateX(2px); }

/* ── Contact card ────────────────────────────────────────────── */
.eq8-contact-panel { background:var(--cardBg); border:1px solid var(--border); border-radius:20px; padding:28px; }
.eq8-contact-panel__social { text-align:center; margin-top:28px; padding-top:24px; border-top:1px solid var(--border); }
.eq8-contact-panel__social-label { font-size:.85rem; font-weight:600; color:var(--muted); margin:0 0 16px; font-family:'Cairo',system-ui,sans-serif; }
.eq8-contact-card { display:flex; align-items:center; gap:14px; background:var(--altBg); border:1px solid var(--border); border-radius:14px; padding:18px; text-decoration:none; transition:border-color .2s,box-shadow .2s,transform .2s; }
.eq8-contact-card:hover { border-color:var(--accent); box-shadow:0 4px 16px rgba(107,58,23,.1); transform:translateY(-2px); }
.eq8-contact-card__icon-wrap { width:44px;height:44px;border-radius:10px;background:var(--accentTint);display:flex;align-items:center;justify-content:center;flex-shrink:0; }
.eq8-contact-card__icon-wrap--wa { background:#dcfce7; }
.eq8-contact-card__svg { width:20px;height:20px;color:var(--primaryText); }
.eq8-contact-card--wa .eq8-contact-card__svg { color:#16a34a; }
.eq8-contact-card__label { font-size:.75rem; color:var(--muted); display:block; margin-bottom:2px; font-family:'Cairo',system-ui,sans-serif; }
.eq8-contact-card__value { font-size:.9rem; font-weight:700; color:var(--text); display:block; font-family:'Cairo',system-ui,sans-serif; }

/* ── Social btn ──────────────────────────────────────────────── */
.eq8-social-btn { width:44px;height:44px;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;text-decoration:none;transition:opacity .18s,transform .18s; }
.eq8-social-btn:hover { opacity:.85;transform:scale(1.08); }
.eq8-social-btn__svg { width:20px;height:20px; }

/* ── CTA section ─────────────────────────────────────────────── */
.eq8-cta-section {
    position: relative;
    background: linear-gradient(135deg,#43230E 0%,#6B3A17 60%,#8B4D20 100%);
    padding: 64px 20px;
    text-align: center;
    overflow: hidden;
}
.eq8-cta-section::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(ellipse at 50% 0%, rgba(217,123,46,.22) 0%, transparent 60%);
    pointer-events: none;
}
.eq8-cta-section__inner { position: relative; text-align: center; max-width: 640px; }
.eq8-cta-section__icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background: rgba(255,255,255,.12);
    border: 1px solid rgba(255,255,255,.2);
    font-size: 26px;
    margin-bottom: 18px;
}
.eq8-cta-section__sub { color:#F3D9BB; margin:0 0 32px; font-size:1.05rem; font-family:'Cairo',system-ui,sans-serif; line-height:1.6; }

.eq8-cta-section__actions { position: relative; display:flex; gap:14px; justify-content:center; flex-wrap:wrap; }
.eq8-cta-section__btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 6px 26px 6px 6px;
    border-radius: 999px;
    font-size: .95rem;
    font-weight: 700;
    text-decoration: none;
    white-space: nowrap;
    font-family: 'Cairo',system-ui,sans-serif;
    transition: transform .2s ease, box-shadow .2s ease, background .18s ease, border-color .18s ease;
}
[dir="rtl"] .eq8-cta-section__btn { padding: 6px 6px 6px 26px; }
.eq8-cta-section__btn-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    border-radius: 50%;
    flex-shrink: 0;
}
.eq8-cta-section__btn:hover { transform: translateY(-2px); box-shadow: 0 10px 24px rgba(0,0,0,.28); }

.eq8-cta-section__btn--wa { background:#25D366; color:#fff; }
.eq8-cta-section__btn--wa:hover { background:#20ba58; }
.eq8-cta-section__btn--wa .eq8-cta-section__btn-icon { background: rgba(0,0,0,.15); }

.eq8-cta-section__btn--call { background:transparent; color:#fff; border:2px solid rgba(255,255,255,.55); }
.eq8-cta-section__btn--call:hover { background:rgba(255,255,255,.1); border-color:#fff; }
.eq8-cta-section__btn--call .eq8-cta-section__btn-icon { background: rgba(255,255,255,.18); border: 1.5px solid rgba(255,255,255,.35); }

@media (max-width: 480px) {
    .eq8-cta-section__actions { flex-direction: column; align-items: stretch; }
    .eq8-cta-section__btn { justify-content: center; }
}
</style>
@endsection
