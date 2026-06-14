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
    {{ $isAr
        ? 'من نحن — إلكتريك كويت لخدمات الكهرباء بالكويت'
        : 'About Us — ElectricQ8 Electrical Services Kuwait' }}
@endsection

@section('meta_description')
    {{ $isAr
        ? 'تعرف على إلكتريك كويت — أكثر من 10 سنوات في تقديم خدمات كهرباء المنازل بالكويت. فنيون معتمدون، ضمان على الخدمة، وتغطية جميع المناطق.'
        : 'Learn about ElectricQ8 — over 10 years providing electrical services across Kuwait. Certified technicians, service warranty, and full coverage of all governorates.' }}
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
  "description": {{ $isAr ? '"شركة متخصصة في خدمات كهرباء المنازل في الكويت منذ أكثر من 10 سنوات"' : '"Specialist electrical services company serving Kuwait for over 10 years"' }},
  "address": {
    "@@type": "PostalAddress",
    "addressCountry": "KW",
    "addressRegion": "Kuwait"
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
  "sameAs": [
    "{{ $insta }}",
    "{{ $snap }}",
    "{{ $tiktok }}"
  ]
}
</script>
@endsection

@section('content')
<div dir="{{ $isAr ? 'rtl' : 'ltr' }}">

{{-- ══════════════════════════════════════════════
     HERO
════════════════════════════════════════════════ --}}
<section class="bg-yellow-700 text-white py-16 text-center">
    <div class="container mx-auto px-4 max-w-3xl">
        <h1 class="text-3xl md:text-4xl font-extrabold mb-4">
            {{ $isAr ? 'من نحن — إلكتريك كويت لخدمات الكهرباء' : 'About Us — ElectricQ8 Electrical Services' }}
        </h1>
        <p class="text-lg opacity-90">
            {{ $isAr
                ? 'أكثر من عقد من تقديم خدمات الكهرباء الاحترافية في جميع أنحاء الكويت'
                : 'Over a decade of professional electrical services across all of Kuwait' }}
        </p>
    </div>
</section>

{{-- ══════════════════════════════════════════════
     STORY
════════════════════════════════════════════════ --}}
<section class="py-16 bg-white">
    <div class="container mx-auto px-4 max-w-4xl">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

            <div>
                <h2 class="text-2xl font-extrabold text-gray-900 mb-5">
                    {{ $isAr ? 'قصتنا' : 'Our Story' }}
                </h2>
                <div class="space-y-4 text-gray-600 leading-relaxed">
                    @if($isAr)
                        <p>بدأت إلكتريك كويت بهدف واحد واضح: تقديم خدمات كهرباء سريعة واحترافية يستحقها سكان الكويت. في دولة يصل فيها صيف الخليج إلى 50 درجة، لا يتحمل العميل الانتظار أياماً لإصلاح كهرباءه — ولا يقبل بفني يصل بدون أدوات أو بأسعار مبهمة.</p>
                        <p>لاحظنا هذه الفجوة الكبيرة في السوق الكويتي، فأسسنا فريقاً من الفنيين المعتمدين الذين يعملون على مدار الساعة، يصلون إلى العميل في ساعة واحدة، يشخصون العطل بدقة، ويقدمون سعراً واضحاً قبل بدء العمل.</p>
                        <p>اليوم، بعد أكثر من 10 سنوات وأكثر من 5000 عميل راضٍ، أصبحت إلكتريك كويت الاسم الأول الذي يتذكره الكويتيون عند أي مشكلة في الكهرباء.</p>
                    @else
                        <p>ElectricQ8 was founded with a single clear goal: to deliver fast, professional electrical services that Kuwait residents deserve. In a country where summer temperatures reach 50°C, a customer cannot afford to wait days for a repair — nor to accept a technician who arrives unprepared or with unclear pricing.</p>
                        <p>We identified this gap in the Kuwaiti market and built a team of certified technicians operating around the clock, reaching customers within one hour, diagnosing faults accurately, and providing a clear price before starting any work.</p>
                        <p>Today, after more than 10 years and over 5,000 satisfied customers, ElectricQ8 has become the first name Kuwaitis reach for whenever they have an AC problem.</p>
                    @endif
                </div>
            </div>

            <div class="bg-yellow-50 rounded-2xl p-8 border border-yellow-100">
                <h3 class="font-bold text-yellow-800 text-lg mb-6">
                    {{ $isAr ? 'رؤيتنا ومهمتنا' : 'Vision & Mission' }}
                </h3>
                <div class="space-y-5">
                    <div class="flex gap-3">
                        <span class="text-2xl shrink-0 mt-0.5" aria-hidden="true">🎯</span>
                        <div>
                            <p class="font-bold text-gray-900 mb-1">{{ $isAr ? 'رؤيتنا' : 'Our Vision' }}</p>
                            <p class="text-gray-600 text-sm leading-relaxed">
                                {{ $isAr
                                    ? 'أن نكون الخيار الأول لخدمات الكهرباء في الكويت، معروفين بالسرعة والأمانة والجودة التي لا تُنافَس.'
                                    : 'To be Kuwait\'s first choice for electrical services — known for speed, integrity, and unrivalled quality.' }}
                            </p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <span class="text-2xl shrink-0 mt-0.5" aria-hidden="true">💡</span>
                        <div>
                            <p class="font-bold text-gray-900 mb-1">{{ $isAr ? 'مهمتنا' : 'Our Mission' }}</p>
                            <p class="text-gray-600 text-sm leading-relaxed">
                                {{ $isAr
                                    ? 'تقديم خدمات كهرباء موثوقة بأسعار شفافة وفنيين معتمدين، لكل بيت ومكتب وشركة في الكويت.'
                                    : 'To deliver reliable electrical services at transparent prices with certified technicians, for every home, office and business in Kuwait.' }}
                            </p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <span class="text-2xl shrink-0 mt-0.5" aria-hidden="true">🤝</span>
                        <div>
                            <p class="font-bold text-gray-900 mb-1">{{ $isAr ? 'قيمنا' : 'Our Values' }}</p>
                            <p class="text-gray-600 text-sm leading-relaxed">
                                {{ $isAr
                                    ? 'الصدق في السعر، السرعة في الوصول، الدقة في التشخيص، والالتزام بالضمان.'
                                    : 'Honest pricing, fast arrival, accurate diagnosis, and commitment to our warranty.' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════
     NUMBERS — E-E-A-T PROOF
════════════════════════════════════════════════ --}}
<section class="py-14 bg-yellow-700 text-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-10">
            <h2 class="text-2xl font-extrabold mb-2">
                {{ $isAr ? 'خبرتنا بالأرقام' : 'Our Experience in Numbers' }}
            </h2>
            <p class="opacity-80 text-sm">
                {{ $isAr ? 'أرقام حقيقية تعكس سنوات العمل في سوق الكهرباء الكويتي' : 'Real numbers reflecting years of work in the Kuwait AC market' }}
            </p>
        </div>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 text-center">
            <div>
                <span class="block text-4xl md:text-5xl font-extrabold mb-1">+10</span>
                <span class="text-yellow-200 text-sm font-medium">{{ $isAr ? 'سنوات خبرة' : 'Years Experience' }}</span>
            </div>
            <div>
                <span class="block text-4xl md:text-5xl font-extrabold mb-1">+5000</span>
                <span class="text-yellow-200 text-sm font-medium">{{ $isAr ? 'عميل راضٍ' : 'Satisfied Customers' }}</span>
            </div>
            <div>
                <span class="block text-4xl md:text-5xl font-extrabold mb-1">+15000</span>
                <span class="text-yellow-200 text-sm font-medium">{{ $isAr ? 'كهرباء تمت صيانته' : 'AC Units Serviced' }}</span>
            </div>
            <div>
                <span class="block text-4xl md:text-5xl font-extrabold mb-1">6</span>
                <span class="text-yellow-200 text-sm font-medium">{{ $isAr ? 'محافظات كويتية مغطاة' : 'Kuwait Governorates Covered' }}</span>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════
     SERVICES WE PROVIDE
════════════════════════════════════════════════ --}}
<section class="py-16 bg-white">
    <div class="container mx-auto px-4 max-w-4xl">

        <h2 class="text-2xl font-extrabold text-gray-900 mb-2 text-center">
            {{ $isAr ? 'الخدمات التي نقدمها' : 'Services We Provide' }}
        </h2>
        <p class="text-gray-500 text-center mb-10">
            {{ $isAr ? 'حلول متكاملة لكل احتياجات الكهرباء في الكويت' : 'Complete solutions for all AC needs in Kuwait' }}
        </p>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @php
            $services = $isAr ? [
                ['icon' => '🔧', 'title' => 'تمديدات كهربائية',         'body' => 'تركيب جميع أنواع الكهرباءات السبليت والمركزي والشباك والمخفي للمنازل والمكاتب.'],
                ['icon' => '🛠️', 'title' => 'إصلاح وصيانة',      'body' => 'تشخيص وإصلاح جميع أعطال الكهرباء: ضعف تبريد، تسريب ماء، أصوات غريبة، توقف عن العمل.'],
                ['icon' => '🧹', 'title' => 'تصليح كهرباء',        'body' => 'تنظيف شامل للفلاتر والملفات والمصرف مع تعقيم بالمواد الآمنة للحفاظ على جودة الهواء.'],
                ['icon' => '💨', 'title' => 'تصليح شورت فريون',      'body' => 'فحص مستوى الغاز، اكتشاف التسريبات، وشحن R22 أو R410a أو R32 بالكمية المناسبة.'],
                ['icon' => '🚨', 'title' => 'خدمة طوارئ 24 ساعة', 'body' => 'فني متاح فورًا في أي وقت من الليل أو النهار، يصلك خلال ساعة واحدة في جميع مناطق الكويت.'],
                ['icon' => '🏢', 'title' => 'صيانة تجارية',       'body' => 'عقود صيانة دورية للمجمعات التجارية والمكاتب والمستودعات بأسعار مخصصة وجداول منتظمة.'],
            ] : [
                ['icon' => '🔧', 'title' => 'Electrical Installation',      'body' => 'Installation of all AC types: split, central, window and concealed units for homes and offices.'],
                ['icon' => '🛠️', 'title' => 'Repair & Maintenance', 'body' => 'Diagnosis and repair of all AC faults: weak electrical, water leaks, strange noises, unit not starting.'],
                ['icon' => '🧹', 'title' => 'AC Cleaning',           'body' => 'Full filter, coil and drain cleaning with safe sanitisation to maintain healthy indoor air quality.'],
                ['icon' => '💨', 'title' => 'Gas Refill',            'body' => 'Gas level check, leak detection, and charging R22, R410a or R32 to the correct specification.'],
                ['icon' => '🚨', 'title' => '24-Hour Emergency',     'body' => 'A technician available instantly at any hour, reaching you within one hour across all Kuwait areas.'],
                ['icon' => '🏢', 'title' => 'Commercial Maintenance','body' => 'Regular maintenance contracts for commercial complexes, offices and warehouses at tailored rates.'],
            ];
            @endphp
            @foreach($services as $svc)
            <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 hover:border-yellow-200 hover:shadow-md transition">
                <span class="text-3xl mb-3 block" aria-hidden="true">{{ $svc['icon'] }}</span>
                <h3 class="font-bold text-gray-900 mb-2">{{ $svc['title'] }}</h3>
                <p class="text-gray-500 text-sm leading-relaxed">{{ $svc['body'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════
     AC TYPES WE SERVICE
════════════════════════════════════════════════ --}}
<section class="py-14 bg-gray-50">
    <div class="container mx-auto px-4 max-w-4xl">

        <h2 class="text-2xl font-extrabold text-gray-900 mb-10 text-center">
            {{ $isAr ? 'أنواع الأجهزة التي نخدمها' : 'AC Types We Service' }}
        </h2>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 text-center">
            @php
            $types = $isAr
                ? [['🌬️','سبليت'],['❄️','مركزي'],['🪟','شباك'],['🏠','مخفي في السقف'],['🏭','وحدات تجارية']]
                : [['🌬️','Split'],['❄️','Central'],['🪟','Window'],['🏠','Concealed / Cassette'],['🏭','Commercial Units']];
            @endphp
            @foreach($types as [$icon, $label])
            <div class="bg-white rounded-xl border border-gray-200 p-5 hover:border-yellow-300 hover:shadow-sm transition">
                <span class="text-3xl block mb-2" aria-hidden="true">{{ $icon }}</span>
                <span class="text-sm font-semibold text-gray-700">{{ $label }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════
     BRANDS
════════════════════════════════════════════════ --}}
<section class="py-14 bg-white">
    <div class="container mx-auto px-4 max-w-4xl">

        <h2 class="text-2xl font-extrabold text-gray-900 mb-3 text-center">
            {{ $isAr ? 'الماركات التي نخدمها' : 'Brands We Service' }}
        </h2>
        <p class="text-gray-500 text-center mb-8">
            {{ $isAr ? 'نصلح جميع الماركات العالمية المتوفرة في الكويت' : 'We repair all international brands available in Kuwait' }}
        </p>

        <div class="flex flex-wrap justify-center gap-3">
            @php
            $brands = [
                ['ar' => 'سامسونج',    'en' => 'Samsung'],
                ['ar' => 'إل جي',      'en' => 'LG'],
                ['ar' => 'كاريير',     'en' => 'Carrier'],
                ['ar' => 'دايكن',      'en' => 'Daikin'],
                ['ar' => 'ميديا',      'en' => 'Midea'],
                ['ar' => 'جري',        'en' => 'Gree'],
                ['ar' => 'توشيبا',     'en' => 'Toshiba'],
                ['ar' => 'باناسونيك',  'en' => 'Panasonic'],
                ['ar' => 'شارب',       'en' => 'Sharp'],
                ['ar' => 'يورك',       'en' => 'York'],
                ['ar' => 'هيتاشي',     'en' => 'Hitachi'],
                ['ar' => 'ميتسوبيشي', 'en' => 'Mitsubishi'],
                ['ar' => 'جنرال',      'en' => 'General'],
                ['ar' => 'تي سي إل',   'en' => 'TCL'],
                ['ar' => 'هايير',      'en' => 'Haier'],
            ];
            @endphp
            @foreach($brands as $brand)
            <span class="inline-flex items-center px-5 py-2.5 rounded-full border-2 border-yellow-200 bg-white text-yellow-700 font-semibold text-sm hover:bg-yellow-700 hover:text-white hover:border-yellow-700 transition cursor-default select-none">
                {{ $brand[$locale] ?? $brand['en'] }}
            </span>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════
     WHY CHOOSE US
════════════════════════════════════════════════ --}}
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 max-w-4xl">

        <h2 class="text-2xl font-extrabold text-gray-900 mb-10 text-center">
            {{ $isAr ? 'لماذا يختارنا عملاؤنا؟' : 'Why Do Our Customers Choose Us?' }}
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            @php
            $reasons = $isAr ? [
                ['icon' => '⚡', 'title' => 'وصول خلال ساعة واحدة',   'body' => 'لا انتظار. فنيونا يصلون إليك في غضون ساعة من تأكيد الطلب في معظم مناطق الكويت.'],
                ['icon' => '🔍', 'title' => 'تشخيص دقيق بأدوات متطورة','body' => 'نستخدم أجهزة قياس الضغط والحرارة وأدوات التشخيص الرقمية لتحديد العطل بدقة من أول زيارة.'],
                ['icon' => '💰', 'title' => 'أسعار شفافة 100%',        'body' => 'نقدم تقديراً واضحاً للسعر قبل بدء أي عمل. لا رسوم مخفية ولا مفاجآت في الفاتورة النهائية.'],
                ['icon' => '🛡️', 'title' => 'ضمان رسمي 3 أشهر',      'body' => 'كل خدمة مغطاة بضمان رسمي مدته 3 أشهر. إذا عادت المشكلة نصلحها مجانًا بدون أي رسوم إضافية.'],
                ['icon' => '🔧', 'title' => 'فنيون معتمدون ومدربون',  'body' => 'جميع فنيينا حاصلون على شهادات معتمدة وخبرة لا تقل عن 5 سنوات في صيانة وتركيب الكهرباء.'],
                ['icon' => '📞', 'title' => 'دعم متواصل 24/7',        'body' => 'خط دعم مفتوح على مدار الساعة للرد على استفساراتك وتتبع حالة طلب الخدمة في الوقت الفعلي.'],
            ] : [
                ['icon' => '⚡', 'title' => 'One-Hour Arrival',            'body' => 'No waiting. Our technicians reach you within one hour of booking confirmation in most Kuwait areas.'],
                ['icon' => '🔍', 'title' => 'Accurate Diagnosis',          'body' => 'We use pressure gauges, thermal tools and digital diagnostic equipment to identify faults precisely on the first visit.'],
                ['icon' => '💰', 'title' => '100% Transparent Pricing',    'body' => 'We give a clear price estimate before starting any work. No hidden fees, no surprises on the final bill.'],
                ['icon' => '🛡️', 'title' => 'Official 3-Month Warranty',  'body' => 'Every service is backed by a 3-month official warranty. If the problem returns we fix it free of charge.'],
                ['icon' => '🔧', 'title' => 'Certified Technicians',       'body' => 'All our technicians hold certified qualifications and have a minimum of 5 years of AC servicing experience.'],
                ['icon' => '📞', 'title' => '24/7 Continuous Support',     'body' => 'An open support line around the clock to answer your queries and track service requests in real time.'],
            ];
            @endphp
            @foreach($reasons as $r)
            <div class="flex gap-4 bg-white rounded-xl border border-gray-100 p-6 hover:border-yellow-200 hover:shadow-sm transition">
                <span class="text-2xl shrink-0 mt-0.5" aria-hidden="true">{{ $r['icon'] }}</span>
                <div>
                    <h3 class="font-bold text-gray-900 mb-1">{{ $r['title'] }}</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">{{ $r['body'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════
     SERVICE AREAS
════════════════════════════════════════════════ --}}
<section class="py-14 bg-white">
    <div class="container mx-auto px-4 max-w-4xl">

        <h2 class="text-2xl font-extrabold text-gray-900 mb-3 text-center">
            {{ $isAr ? 'مناطق الخدمة' : 'Service Areas' }}
        </h2>
        <p class="text-gray-500 text-center mb-8">
            {{ $isAr ? 'نغطي جميع المحافظات الست في الكويت' : 'We cover all six governorates across Kuwait' }}
        </p>

        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
            @php
            $govs = $isAr ? [
                ['🏙️', 'محافظة العاصمة'],
                ['🏘️', 'محافظة حولي'],
                ['🌆', 'محافظة الفروانية'],
                ['🌄', 'محافظة الجهراء'],
                ['🏭', 'محافظة الأحمدي'],
                ['🏡', 'محافظة مبارك الكبير'],
            ] : [
                ['🏙️', 'Capital Governorate'],
                ['🏘️', 'Hawalli Governorate'],
                ['🌆', 'Farwaniya Governorate'],
                ['🌄', 'Jahra Governorate'],
                ['🏭', 'Ahmadi Governorate'],
                ['🏡', 'Mubarak Al-Kabeer Governorate'],
            ];
            @endphp
            @foreach($govs as [$icon, $label])
            <div class="flex items-center gap-3 bg-yellow-50 border border-yellow-100 rounded-xl px-5 py-4">
                <span class="text-xl" aria-hidden="true">{{ $icon }}</span>
                <span class="font-semibold text-yellow-800 text-sm">{{ $label }}</span>
            </div>
            @endforeach
        </div>

        <p class="text-center text-gray-500 text-sm mt-6">
            {{ $isAr
                ? 'داخل كل محافظة نصل إلى جميع الأحياء والمناطق السكنية والتجارية.'
                : 'Within each governorate we reach all districts, residential and commercial areas.' }}
        </p>
    </div>
</section>

{{-- ══════════════════════════════════════════════
     CONTACT INFO — Trust signals
════════════════════════════════════════════════ --}}
<section class="py-14 bg-gray-50">
    <div class="container mx-auto px-4 max-w-3xl">

        <h2 class="text-2xl font-extrabold text-gray-900 mb-10 text-center">
            {{ $isAr ? 'تواصل معنا' : 'Get in Touch' }}
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-10">
            {{-- Phone --}}
            <a href="tel:{{ $phone }}"
               class="flex items-center gap-4 bg-white rounded-xl border border-gray-200 p-5 hover:border-yellow-300 hover:shadow-sm transition group">
                <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center shrink-0 group-hover:bg-yellow-700 transition">
                    <svg class="w-5 h-5 text-yellow-700 group-hover:text-white transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">{{ $isAr ? 'الهاتف' : 'Phone' }}</p>
                    <p class="font-bold text-gray-900 dir-ltr">{{ $phone }}</p>
                </div>
            </a>

            {{-- WhatsApp --}}
            <a href="{{ \App\Helpers\WhatsAppHelper::url() }}" target="_blank"
               class="flex items-center gap-4 bg-white rounded-xl border border-gray-200 p-5 hover:border-green-300 hover:shadow-sm transition group">
                <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center shrink-0 group-hover:bg-green-500 transition">
                    <svg class="w-5 h-5 text-green-600 group-hover:text-white transition" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.116 1.528 5.845L0 24l6.335-1.505A11.946 11.946 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.882a9.872 9.872 0 01-5.031-1.378l-.361-.214-3.741.981.999-3.648-.235-.374A9.869 9.869 0 012.118 12C2.118 6.963 6.963 2.118 12 2.118s9.882 4.845 9.882 9.882-4.845 9.882-9.882 9.882z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">WhatsApp</p>
                    <p class="font-bold text-gray-900">{{ $isAr ? 'تواصل فورياً' : 'Contact Instantly' }}</p>
                </div>
            </a>

            {{-- Email --}}
            @if($email)
            <a href="mailto:{{ $email }}"
               class="flex items-center gap-4 bg-white rounded-xl border border-gray-200 p-5 hover:border-purple-300 hover:shadow-sm transition group">
                <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center shrink-0 group-hover:bg-purple-600 transition">
                    <svg class="w-5 h-5 text-purple-600 group-hover:text-white transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">{{ $isAr ? 'البريد الإلكتروني' : 'Email' }}</p>
                    <p class="font-bold text-gray-900 dir-ltr text-sm">{{ $email }}</p>
                </div>
            </a>
            @endif

            {{-- Hours --}}
            <div class="flex items-center gap-4 bg-white rounded-xl border border-gray-200 p-5">
                <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-0.5">{{ $isAr ? 'ساعات العمل' : 'Working Hours' }}</p>
                    <p class="font-bold text-gray-900">{{ $isAr ? '24 ساعة / 7 أيام' : '24 Hours / 7 Days' }}</p>
                </div>
            </div>
        </div>

        {{-- Social --}}
        @if($insta || $snap || $tiktok)
        <div class="text-center">
            <p class="text-gray-500 text-sm mb-4">{{ $isAr ? 'تابعنا على منصات التواصل' : 'Follow us on social media' }}</p>
            <div class="flex justify-center gap-4">
                @if($insta)
                <a href="{{ $insta }}" target="_blank" rel="noopener"
                   class="w-11 h-11 rounded-full bg-gradient-to-br from-pink-500 to-purple-600 flex items-center justify-center text-white hover:opacity-90 transition"
                   aria-label="Instagram">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                </a>
                @endif
                @if($snap)
                <a href="{{ $snap }}" target="_blank" rel="noopener"
                   class="w-11 h-11 rounded-full bg-yellow-400 flex items-center justify-center text-white hover:opacity-90 transition"
                   aria-label="Snapchat">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.166.007C9.05 0 6.37 1.373 4.694 3.564c-.94 1.24-1.37 2.66-1.37 4.13.01.64.06 1.28.14 1.92-.31.17-.65.26-1 .26-.37 0-.74-.1-1.05-.29a.42.42 0 00-.22-.06c-.22 0-.41.17-.41.4 0 .15.08.29.21.36.74.43 1.65.67 2.57.7.04.36.1.72.17 1.07C1.94 12.63 0 13.38 0 14.19c0 .28.17.54.43.65 1.08.46 2.45.5 3.05.5.13 0 .23 0 .29.01a6.53 6.53 0 004.37 2.2c.2.02.4.03.6.03.77 0 1.52-.17 2.2-.47.05-.02.12-.03.17-.03.06 0 .12.01.17.03.68.3 1.43.47 2.2.47.2 0 .4-.01.6-.03a6.53 6.53 0 004.37-2.2c.06-.01.16-.01.29-.01.6 0 1.97-.04 3.05-.5.26-.11.43-.37.43-.65 0-.81-1.94-1.56-3.76-2.19.07-.35.13-.71.17-1.07.92-.03 1.83-.27 2.57-.7a.41.41 0 00.21-.36c0-.22-.19-.4-.41-.4a.42.42 0 00-.22.06c-.31.19-.68.29-1.05.29-.35 0-.69-.09-1-.26.08-.64.13-1.28.14-1.92 0-1.47-.43-2.89-1.37-4.13C17.63 1.373 14.95 0 12.166.007z"/></svg>
                </a>
                @endif
                @if($tiktok)
                <a href="{{ $tiktok }}" target="_blank" rel="noopener"
                   class="w-11 h-11 rounded-full bg-black flex items-center justify-center text-white hover:opacity-80 transition"
                   aria-label="TikTok">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.33 6.33 0 00-.79-.05 6.34 6.34 0 00-6.34 6.34 6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.33-6.34V8.69a8.17 8.17 0 004.78 1.52V6.76a4.84 4.84 0 01-1.01-.07z"/></svg>
                </a>
                @endif
            </div>
        </div>
        @endif
    </div>
</section>

{{-- ══════════════════════════════════════════════
     FINAL CTA
════════════════════════════════════════════════ --}}
<section class="py-14 bg-yellow-700 text-white text-center">
    <div class="container mx-auto px-4 max-w-2xl">
        <h2 class="text-2xl font-extrabold mb-3">
            {{ $isAr ? 'مستعد لخدمتك الآن' : 'Ready to Serve You Now' }}
        </h2>
        <p class="opacity-90 mb-8 text-lg">
            {{ $isAr
                ? 'تواصل مع فريق إلكتريك كويت — فنيونا جاهزون في جميع مناطق الكويت'
                : 'Contact the ElectricQ8 team — our technicians are ready across all Kuwait areas' }}
        </p>
        <div class="flex gap-4 justify-center flex-wrap">
            <a href="{{ \App\Helpers\WhatsAppHelper::url() }}" target="_blank"
               class="bg-green-500 hover:bg-green-600 text-white font-bold px-8 py-4 rounded-xl transition inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.116 1.528 5.845L0 24l6.335-1.505A11.946 11.946 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.882a9.872 9.872 0 01-5.031-1.378l-.361-.214-3.741.981.999-3.648-.235-.374A9.869 9.869 0 012.118 12C2.118 6.963 6.963 2.118 12 2.118s9.882 4.845 9.882 9.882-4.845 9.882-9.882 9.882z"/>
                </svg>
                {{ $isAr ? 'واتساب الآن' : 'WhatsApp Now' }}
            </a>
            <a href="tel:{{ $phone }}"
               class="bg-white text-yellow-700 font-bold px-8 py-4 rounded-xl transition hover:bg-gray-100">
                {{ $isAr ? 'اتصل الآن' : 'Call Now' }}
            </a>
            <a href="{{ route($isAr ? 'contact' : 'en.contact') }}"
               class="bg-yellow-600 hover:bg-yellow-500 text-white font-bold px-8 py-4 rounded-xl transition border border-yellow-500">
                {{ $isAr ? 'نموذج التواصل' : 'Contact Form' }}
            </a>
        </div>
    </div>
</section>

</div>
@endsection
