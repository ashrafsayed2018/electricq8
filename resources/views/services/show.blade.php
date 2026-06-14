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

    // FAQ — try DB field first, then fallback per service_type
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

    // Brands
    $brands = [
        ['ar' => 'سامسونج', 'en' => 'Samsung'],
        ['ar' => 'إل جي',   'en' => 'LG'],
        ['ar' => 'كاريير',  'en' => 'Carrier'],
        ['ar' => 'دايكن',   'en' => 'Daikin'],
        ['ar' => 'ميديا',   'en' => 'Midea'],
        ['ar' => 'جري',     'en' => 'Gree'],
        ['ar' => 'توشيبا',  'en' => 'Toshiba'],
        ['ar' => 'باناسونيك','en'=> 'Panasonic'],
        ['ar' => 'يورك',    'en' => 'York'],
        ['ar' => 'هيتاشي',  'en' => 'Hitachi'],
        ['ar' => 'شارب',    'en' => 'Sharp'],
        ['ar' => 'ميتسوبيشي','en'=> 'Mitsubishi'],
    ];

    // AC types
    $acTypes = $isAr
        ? ['سبليت', 'مركزي', 'شباك', 'مخفي (كاسيت)', 'محمول']
        : ['Split', 'Central', 'Window', 'Concealed / Cassette', 'Portable'];
@endphp

@section('meta_title'){{ $metaTitle }}@endsection
@section('meta_description'){{ $metaDesc }}@endsection

@section('schema_markup')
{{-- Service Schema --}}
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
    "address": {
      "@@type": "PostalAddress",
      "addressCountry": "KW"
    }
  },
  "areaServed": { "@@type": "Country", "name": "Kuwait" }{{ $service->price_from ? ',
  "offers": {
    "@@type": "Offer",
    "priceCurrency": "KWD",
    "price": "' . $service->price_from . '"
  }' : '' }}
}
</script>
{{-- FAQ Schema --}}
@if($faqs)
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "FAQPage",
  "mainEntity": [
    @foreach($faqs as $i => $faq)
    {
      "@@type": "Question",
      "name": "{{ addslashes($faq['q']) }}",
      "acceptedAnswer": {
        "@@type": "Answer",
        "text": "{{ addslashes($faq['a']) }}"
      }
    }{{ !$loop->last ? ',' : '' }}
    @endforeach
  ]
}
</script>
@endif
{{-- Breadcrumb Schema --}}
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

{{-- ── Breadcrumb ── --}}
<nav class="bg-gray-50 border-b border-gray-200 py-3" aria-label="{{ $isAr ? 'مسار التنقل' : 'Breadcrumb' }}">
    <div class="container mx-auto px-4">
        <ol class="flex items-center gap-2 text-sm text-gray-500 flex-wrap">
            <li><a href="{{ route($isAr ? 'home' : 'en.home') }}" class="hover:text-yellow-700 transition">{{ $isAr ? 'الرئيسية' : 'Home' }}</a></li>
            <li aria-hidden="true" class="text-gray-300">/</li>
            <li><a href="{{ route($isAr ? 'services.index' : 'en.services.index') }}" class="hover:text-yellow-700 transition">{{ $isAr ? 'الخدمات' : 'Services' }}</a></li>
            <li aria-hidden="true" class="text-gray-300">/</li>
            <li class="text-gray-800 font-semibold" aria-current="page">{{ $title }}</li>
        </ol>
    </div>
</nav>

{{-- ── Hero ── --}}
<section class="bg-yellow-700 text-white py-16">
    <div class="container mx-auto px-4 text-center max-w-3xl">
        <div class="inline-block bg-red-500 text-white text-sm font-bold px-4 py-2 rounded-full mb-4">
            {{ $isAr ? 'خدمة طوارئ 24 ساعة' : '24/7 Emergency Service' }}
        </div>
        <h1 class="text-3xl md:text-4xl font-extrabold mb-3">{{ $h1 }}</h1>
        <div class="text-lg opacity-90 mb-6">{!! \App\Helpers\RichText::clean($intro) !!}</div>
        <div class="flex gap-4 justify-center flex-wrap">
            <a href="{{ \App\Helpers\WhatsAppHelper::url($isAr ? 'أريد الاستفسار عن: ' . $title : 'I need: ' . $title) }}"
               target="_blank"
               class="bg-green-500 hover:bg-green-600 text-white font-bold px-8 py-4 rounded-xl transition">
                {{ $isAr ? 'واتساب الآن' : 'WhatsApp Now' }}
            </a>
            <a href="tel:{{ $phone }}"
               class="bg-white text-yellow-700 font-bold px-8 py-4 rounded-xl transition hover:bg-gray-100">
                {{ $isAr ? 'اتصل الآن' : 'Call Now' }}
            </a>
        </div>
    </div>
</section>

{{-- ── Main content ── --}}
@if($content)
<section class="py-14 bg-white">
    <div class="container mx-auto px-4 max-w-3xl">
        <div class="richtext" dir="{{ $isAr ? 'rtl' : 'ltr' }}">
            {!! \App\Helpers\RichText::clean($content) !!}
        </div>
    </div>
</section>
@endif

{{-- ── AC types covered ── --}}
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4 max-w-4xl">
        <h2 class="text-xl font-extrabold text-gray-900 mb-6 text-center">
            {{ $isAr ? 'أنواع الكهرباء التي نخدمها' : 'AC Types We Service' }}
        </h2>
        <div class="flex flex-wrap justify-center gap-3">
            @foreach($acTypes as $t)
            <span class="inline-flex items-center px-5 py-2 rounded-full border border-yellow-200 bg-white text-yellow-700 font-semibold text-sm">{{ $t }}</span>
            @endforeach
        </div>
    </div>
</section>

{{-- ── Why choose us ── --}}
<section class="py-12 bg-white">
    <div class="container mx-auto px-4 max-w-4xl">
        <h2 class="text-xl font-extrabold text-gray-900 mb-8 text-center">
            {{ $isAr ? "لماذا تختار إلكتريك كويت لـ{$title}؟" : "Why Choose ElectricQ8 for {$title}?" }}
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @php
            $whyUs = $isAr ? [
                ['⚡','وصول خلال ساعة واحدة', 'فنيونا يصلون إليك بسرعة في أي منطقة من مناطق الكويت.'],
                ['🔧','فنيون معتمدون',         'خبرة أكثر من 5 سنوات وشهادات معتمدة في صيانة وتركيب الكهرباء.'],
                ['🛡️','ضمان رسمي 3 أشهر',    'إذا عادت المشكلة نصلحها مجانًا خلال فترة الضمان.'],
                ['💰','أسعار شفافة',           'تقدير واضح قبل بدء العمل — لا رسوم مخفية.'],
                ['🏷️','جميع الماركات',        'نصلح ونركب جميع ماركات الكهرباء المتوفرة في السوق الكويتي.'],
                ['📞','دعم 24 ساعة',           'متاحون دائمًا للطوارئ وأيام العطل والجمعة.'],
            ] : [
                ['⚡','One-Hour Arrival',         'Our technicians reach you fast in any area across Kuwait.'],
                ['🔧','Certified Technicians',    'Over 5 years of experience and certified qualifications in AC servicing.'],
                ['🛡️','Official 3-Month Warranty','If the problem returns within the warranty period we fix it free.'],
                ['💰','Transparent Pricing',      'Clear estimate before starting — no hidden fees.'],
                ['🏷️','All Brands',              'We service and install all AC brands available in the Kuwait market.'],
                ['📞','24-Hour Support',          'Always available for emergencies, weekends and public holidays.'],
            ];
            @endphp
            @foreach($whyUs as [$icon, $ttl, $body])
            <div class="flex gap-3 bg-gray-50 rounded-xl border border-gray-100 p-5">
                <span class="text-2xl shrink-0 mt-0.5" aria-hidden="true">{{ $icon }}</span>
                <div>
                    <p class="font-bold text-gray-900 mb-1 text-sm">{{ $ttl }}</p>
                    <p class="text-gray-500 text-xs leading-relaxed">{{ $body }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── Brands ── --}}
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4 max-w-3xl">
        <h2 class="text-xl font-extrabold text-gray-900 mb-6 text-center">
            {{ $isAr ? 'الماركات التي نخدمها' : 'Brands We Service' }}
        </h2>
        <div class="flex flex-wrap justify-center gap-3">
            @foreach($brands as $b)
            <span class="inline-flex items-center px-4 py-2 rounded-full border border-gray-200 bg-white text-gray-700 font-semibold text-sm hover:border-yellow-300 hover:text-yellow-700 transition cursor-default">
                {{ $b[$locale] ?? $b['en'] }}
            </span>
            @endforeach
        </div>
    </div>
</section>

{{-- ── Service areas ── --}}
<section class="py-12 bg-white">
    <div class="container mx-auto px-4 max-w-3xl">
        <h2 class="text-xl font-extrabold text-gray-900 mb-3 text-center">
            {{ $isAr ? "مناطق خدمة {$title} في الكويت" : "{$title} Service Areas in Kuwait" }}
        </h2>
        <p class="text-gray-500 text-center text-sm mb-6">
            {{ $isAr ? 'نغطي جميع المحافظات الست — استجابة خلال ساعة واحدة' : 'Covering all six governorates — one-hour response' }}
        </p>
        <div class="flex flex-wrap justify-center gap-3">
            @foreach($locations as $loc)
            @php $locName = $loc->getTranslation('name', $locale); $locSlug = $loc->getTranslation('slug', $locale); @endphp
            <a href="{{ route($isAr ? 'areas.show' : 'en.areas.show', $locSlug) }}"
               class="inline-flex items-center px-4 py-2 rounded-full border border-yellow-200 bg-yellow-50 text-yellow-700 font-semibold text-sm hover:bg-yellow-700 hover:text-white hover:border-yellow-700 transition">
                {{ $locName }}
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ── FAQ ── --}}
@if($faqs)
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4 max-w-2xl">
        <h2 class="text-xl font-extrabold text-gray-900 mb-8 text-center">
            {{ $isAr ? "الأسئلة الشائعة — {$title}" : "FAQ — {$title}" }}
        </h2>
        <div class="space-y-3" x-data="{ open: null }">
            @foreach($faqs as $i => $faq)
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <button type="button"
                    class="w-full flex items-center justify-between px-6 py-5 {{ $isAr ? 'text-right' : 'text-left' }} font-bold text-gray-900 hover:bg-gray-50 transition focus:outline-none"
                    @click="open === {{ $i }} ? open = null : open = {{ $i }}"
                    :aria-expanded="open === {{ $i }}">
                    <span class="text-sm">{{ $faq['q'] }}</span>
                    <svg class="w-5 h-5 text-yellow-700 shrink-0 transition-transform duration-300 {{ $isAr ? 'mr-3' : 'ml-3' }}"
                         :class="{ 'rotate-180': open === {{ $i }} }"
                         fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open === {{ $i }}"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="px-6 pb-5 text-gray-600 text-sm leading-relaxed border-t border-gray-100"
                     style="display:none">
                    <p class="pt-4">{{ $faq['a'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ── This service in every area — Local SEO internal links ── --}}
@if($locations->count())
<section class="py-12 bg-yellow-50">
    <div class="container mx-auto px-4 max-w-4xl">
        <h2 class="text-xl font-extrabold text-gray-900 mb-2 text-center">
            {{ $isAr ? "خدمة {$title} في جميع مناطق الكويت" : "{$title} Across All Kuwait Areas" }}
        </h2>
        <p class="text-center text-gray-500 text-sm mb-6">
            {{ $isAr ? 'اختر منطقتك للحصول على صفحة مخصصة بأسعار وتفاصيل محلية' : 'Select your area for a dedicated page with local pricing and details' }}
        </p>
        <div class="flex flex-wrap justify-center gap-2">
            @foreach($locations as $loc)
            @php
                $locSlug = $loc->getTranslation('slug', $locale);
                $locName = $loc->getTranslation('name', $locale);
                $svcSlug = $service->getTranslation('slug', $locale);
                $prefix  = $isAr ? '' : 'en.';
            @endphp
            <a href="{{ route($prefix . 'service-locations.show', [$svcSlug, $locSlug]) }}"
               class="px-4 py-2 bg-white hover:bg-yellow-700 hover:text-white text-yellow-700 text-sm font-medium rounded-full border border-yellow-200 hover:border-yellow-700 transition">
                {{ $isAr ? "{$title} في {$locName}" : "{$title} in {$locName}" }}
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ── Other services — internal linking ── --}}
@if($otherServices->count())
<section class="py-12 bg-white">
    <div class="container mx-auto px-4 max-w-4xl">
        <h2 class="text-xl font-extrabold text-gray-900 mb-6 text-center">
            {{ $isAr ? 'خدمات أخرى' : 'Other Services' }}
        </h2>
        @include('partials.services-grid', ['services' => $otherServices])
    </div>
</section>
@endif

{{-- ── Final CTA ── --}}
<section class="py-14 bg-yellow-700 text-white text-center">
    <div class="container mx-auto px-4 max-w-2xl">
        <h2 class="text-2xl font-extrabold mb-3">
            {{ $isAr ? "احجز خدمة {$title} الآن" : "Book {$title} Service Now" }}
        </h2>
        <p class="opacity-90 mb-8">
            {{ $isAr
                ? 'فنيونا جاهزون ويصلونك خلال ساعة — تواصل الآن'
                : 'Our technicians are ready and will reach you within one hour — contact us now' }}
        </p>
        <div class="flex gap-4 justify-center flex-wrap">
            <a href="{{ \App\Helpers\WhatsAppHelper::url($isAr ? 'أريد الاستفسار عن: ' . $title : 'I need: ' . $title) }}"
               target="_blank"
               class="bg-green-500 hover:bg-green-600 text-white font-bold px-8 py-4 rounded-xl transition inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.116 1.528 5.845L0 24l6.335-1.505A11.946 11.946 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.882a9.872 9.882 0 01-5.031-1.378l-.361-.214-3.741.981.999-3.648-.235-.374A9.869 9.869 0 012.118 12C2.118 6.963 6.963 2.118 12 2.118s9.882 4.845 9.882 9.882-4.845 9.882-9.882 9.882z"/>
                </svg>
                {{ $isAr ? 'واتساب الآن' : 'WhatsApp Now' }}
            </a>
            <a href="tel:{{ $phone }}"
               class="bg-white text-yellow-700 font-bold px-8 py-4 rounded-xl transition hover:bg-gray-100">
                {{ $isAr ? 'اتصل الآن' : 'Call Now' }}
            </a>
        </div>
    </div>
</section>

</div>
@endsection
