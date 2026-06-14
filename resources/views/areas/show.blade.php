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

    // Governorate-specific context for unique content
    $govData = [
        'capital'         => ['ar' => 'محافظة العاصمة',        'en' => 'Capital Governorate'],
        'hawalli'         => ['ar' => 'محافظة حولي',            'en' => 'Hawalli Governorate'],
        'farwaniya'       => ['ar' => 'محافظة الفروانية',       'en' => 'Farwaniya Governorate'],
        'jahra'           => ['ar' => 'محافظة الجهراء',         'en' => 'Jahra Governorate'],
        'mubarak_al_kabeer' => ['ar' => 'محافظة مبارك الكبير', 'en' => 'Mubarak Al-Kabeer Governorate'],
        'ahmadi'          => ['ar' => 'محافظة الأحمدي',        'en' => 'Ahmadi Governorate'],
    ];
    $govName = $govData[$gov][$locale] ?? ($isAr ? 'الكويت' : 'Kuwait');

    $metaTitle = $location->meta_title
        ?? ($isAr
            ? "فني كهربائي في {$name} | صيانة وتركيب وتصليح شورت 24 ساعة"
            : "AC Technician in {$name} Kuwait | Repair, Installation & Gas Refill 24/7");
    $metaDesc = $location->meta_description
        ?? ($isAr
            ? "فني كهربائي في {$name} — تركيب وصيانة وتنظيف وتصليح شورت لجميع الماركات. خدمة طوارئ 24 ساعة مع ضمان على العمل. اتصل الآن!"
            : "electrician in {$name} Kuwait — installation, repair, cleaning & short circuit repair for all brands. 24-hour emergency service with workmanship warranty. Call now!");
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
  "description": "{{ $metaDesc }}",
  "address": {
    "@@type": "PostalAddress",
    "addressCountry": "KW",
    "addressLocality": "{{ $name }}"
  },
  "areaServed": {
    "@@type": "City",
    "name": "{{ $name }}"
  },
  "openingHoursSpecification": {
    "@@type": "OpeningHoursSpecification",
    "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
    "opens": "00:00",
    "closes": "23:59"
  },
  "availableLanguage": ["Arabic","English"]
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
                <li><a href="{{ route($isAr ? 'areas.index' : 'en.areas.index') }}" class="hover:text-yellow-700 transition">{{ $isAr ? 'مناطق الخدمة' : 'Service Areas' }}</a></li>
                <li aria-hidden="true" class="text-gray-300">/</li>
                <li class="text-gray-800 font-semibold" aria-current="page">{{ $name }}</li>
            </ol>
        </div>
    </nav>

    {{-- ── Hero ── --}}
    <section class="bg-yellow-700 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <div class="inline-block bg-red-500 text-white text-sm font-bold px-4 py-2 rounded-full mb-4">
                {{ $isAr ? 'خدمة طوارئ 24 ساعة' : '24/7 Emergency Service' }}
            </div>
            <h1 class="text-3xl md:text-4xl font-extrabold mb-3">
                {{ $isAr ? "فني كهربائي في {$name}" : "AC Technician in {$name}" }}
            </h1>
            <p class="text-lg opacity-90 mb-6">
                {{ $isAr
                    ? "تركيب وصيانة وتنظيف وتصليح شورت الكهرباء في {$name} — {$govName}"
                    : "electrical installation, repair, cleaning & short circuit repair in {$name} — {$govName}" }}
            </p>
            <div class="flex gap-4 justify-center flex-wrap">
                <a href="{{ \App\Helpers\WhatsAppHelper::url() }}" target="_blank"
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

    {{-- ── Intro paragraph (unique per area) ── --}}
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4 max-w-3xl">
            @if($desc)
                <p class="text-gray-700 text-lg leading-relaxed">{{ $desc }}</p>
            @else
                <p class="text-gray-700 text-lg leading-relaxed">
                    @if($isAr)
                        تقدم إلكتريك كويت خدمات كهرباء متكاملة في <strong>{{ $name }}</strong>، من تركيب وصيانة وتنظيف دوري وتصليح شورت، وصولًا إلى خدمة الطوارئ على مدار الساعة. فنيونا المعتمدون يصلون إليك في {{ $name }} خلال ساعة واحدة، مزودين بجميع الأدوات والقطع اللازمة لإنهاء العمل في أول زيارة. نخدم جميع أحياء {{ $govName }} بما فيها {{ $name }} بأسعار شفافة وضمان رسمي على جميع الأعمال.
                    @else
                        ElectricQ8 provides comprehensive electrical services in <strong>{{ $name }}</strong>, covering installation, maintenance, routine cleaning, short circuit repair, and 24-hour emergency callouts. Our certified technicians reach you in {{ $name }} within one hour, equipped with all tools and parts needed to complete the job on the first visit. We serve all districts of {{ $govName }} including {{ $name }} with transparent pricing and an official warranty on all work.
                    @endif
                </p>
            @endif
        </div>
    </section>

    {{-- ── Services for this area ── --}}
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-10">
                <h2 class="text-2xl font-extrabold text-gray-900 mb-2">
                    {{ $isAr ? "خدمات الكهرباء في {$name}" : "Electrical Services in {$name}" }}
                </h2>
                <p class="text-gray-500">
                    {{ $isAr ? 'جميع خدمات الكهرباء في موقعك' : 'All electrical services at your location' }}
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-5xl mx-auto">
                @foreach($services as $service)
                <a href="{{ route($isAr ? 'services.show' : 'en.services.show', $service->getTranslation('slug', $locale)) }}"
                   class="block bg-white rounded-2xl shadow hover:shadow-lg transition p-6 border border-gray-100 hover:border-yellow-300">
                    <div class="text-3xl mb-3">{{ $service->icon() }}</div>
                    <h3 class="text-lg font-bold mb-2 text-gray-900">{{ $service->getTranslation('title', $locale) }}</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">{{ html_entity_decode(strip_tags($service->getTranslation('intro', $locale)), ENT_QUOTES | ENT_HTML5, 'UTF-8') }}</p>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── Why choose us in this area ── --}}
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4 max-w-4xl">
            <h2 class="text-2xl font-extrabold text-gray-900 mb-8 text-center">
                {{ $isAr ? "لماذا تختار إلكتريك كويت في {$name}؟" : "Why Choose ElectricQ8 in {$name}?" }}
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                @php
                $advantages = $isAr ? [
                    ['icon' => '⚡', 'title' => 'وصول سريع',       'body' => "فنيونا في {$name} يصلون إليك خلال ساعة واحدة في أي وقت من اليوم أو الليل."],
                    ['icon' => '🔧', 'title' => 'فنيون معتمدون',   'body' => 'جميع فنيينا حاصلون على شهادات معتمدة وخبرة أكثر من 5 سنوات في صيانة الكهرباء.'],
                    ['icon' => '🛡️', 'title' => 'ضمان 3 أشهر',    'body' => 'كل خدمة مغطاة بضمان رسمي 3 أشهر. إذا عادت المشكلة نصلحها مجانًا.'],
                    ['icon' => '💰', 'title' => 'أسعار شفافة',     'body' => 'نقدم تقديراً واضحاً للسعر قبل بدء العمل، بدون رسوم مخفية أو مفاجآت.'],
                    ['icon' => '🏷️', 'title' => 'جميع الماركات', 'body' => 'نصلح كاريير ودايكن وسامسونج وLG وميديا وجري وجميع الماركات الأخرى.'],
                    ['icon' => '📞', 'title' => 'دعم مستمر',       'body' => 'فريق دعم متاح على مدار الساعة للرد على استفساراتك وتتبع طلبات الخدمة.'],
                ] : [
                    ['icon' => '⚡', 'title' => 'Fast Arrival',       'body' => "Our technicians in {$name} reach you within one hour at any time of day or night."],
                    ['icon' => '🔧', 'title' => 'Certified Technicians', 'body' => 'All our technicians hold certified qualifications and have over 5 years of AC servicing experience.'],
                    ['icon' => '🛡️', 'title' => '3-Month Warranty',  'body' => 'Every service is covered by an official 3-month warranty. If the problem recurs we fix it free.'],
                    ['icon' => '💰', 'title' => 'Transparent Pricing', 'body' => 'We provide a clear price estimate before starting work — no hidden fees, no surprises.'],
                    ['icon' => '🏷️', 'title' => 'All Brands',        'body' => 'We repair Carrier, Daikin, Samsung, LG, Midea, Gree and all other AC brands.'],
                    ['icon' => '📞', 'title' => 'Continuous Support', 'body' => 'Support team available around the clock to answer your queries and track service requests.'],
                ];
                @endphp
                @foreach($advantages as $adv)
                <div class="flex gap-4 p-5 rounded-xl border border-gray-100 bg-gray-50">
                    <span class="text-2xl shrink-0 mt-0.5" aria-hidden="true">{{ $adv['icon'] }}</span>
                    <div>
                        <h3 class="font-bold text-gray-900 mb-1">{{ $adv['title'] }}</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">{{ $adv['body'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── Testimonials (if any for this area) ── --}}
    @if($testimonials->count())
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4 max-w-4xl">
            <h2 class="text-2xl font-extrabold text-gray-900 mb-8 text-center">
                {{ $isAr ? "آراء عملاء {$name}" : "What {$name} Customers Say" }}
            </h2>
            @include('partials.testimonials', ['testimonials' => $testimonials])
        </div>
    </section>
    @endif

    {{-- ── Area FAQ ── --}}
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4 max-w-2xl">
            <h2 class="text-2xl font-extrabold text-gray-900 mb-8 text-center">
                {{ $isAr ? "أسئلة شائعة — فني كهربائي في {$name}" : "FAQ — AC Technician in {$name}" }}
            </h2>
            @php
            $faqs = $isAr ? [
                [
                    'q' => "هل تخدمون منطقة {$name}؟",
                    'a' => "نعم، نقدم جميع خدمات الكهرباء في {$name} بما فيها التركيب والصيانة والتنظيف وشحن الغاز. فنيونا يصلون إليك خلال ساعة واحدة.",
                ],
                [
                    'q' => "كم وقت الانتظار لخدمة طوارئ في {$name}؟",
                    'a' => "وقت الاستجابة المضمون في {$name} هو ساعة واحدة. نعمل 24 ساعة يومياً بما فيها الجمعة والعطل الرسمية.",
                ],
                [
                    'q' => 'هل يوجد ضمان على خدمات الكهرباء؟',
                    'a' => 'نعم، جميع خدماتنا مغطاة بضمان رسمي 3 أشهر. إذا عادت المشكلة خلال فترة الضمان نصلحها مجانًا.',
                ],
                [
                    'q' => 'ما الماركات التي تدعمونها؟',
                    'a' => 'نصلح جميع ماركات الكهرباء: سامسونج، LG، كاريير، دايكن، ميديا، جري، توشيبا، باناسونيك، شارب، هيتاشي، ميتسوبيشي، وغيرها.',
                ],
            ] : [
                [
                    'q' => "Do you service the {$name} area?",
                    'a' => "Yes, we provide all electrical services in {$name} including installation, maintenance, cleaning and short circuit repair. Our technicians reach you within one hour.",
                ],
                [
                    'q' => "How long is the wait for emergency service in {$name}?",
                    'a' => "Our guaranteed response time in {$name} is one hour. We operate 24 hours a day including Fridays and public holidays.",
                ],
                [
                    'q' => 'Is there a warranty on electrical services?',
                    'a' => 'Yes, all our services are covered by an official 3-month warranty. If the problem returns within the warranty period we fix it free of charge.',
                ],
                [
                    'q' => 'Which AC brands do you support?',
                    'a' => 'We repair all AC brands: Samsung, LG, Carrier, Daikin, Midea, Gree, Toshiba, Panasonic, Sharp, Hitachi, Mitsubishi and more.',
                ],
            ];
            @endphp

            <div class="space-y-3" x-data="{ open: null }">
                @foreach($faqs as $i => $faq)
                <div class="bg-gray-50 rounded-xl border border-gray-200 overflow-hidden">
                    <button type="button"
                        class="w-full flex items-center justify-between px-6 py-5 {{ $isAr ? 'text-right' : 'text-left' }} font-bold text-gray-900 hover:bg-gray-100 transition focus:outline-none"
                        @click="open === {{ $i }} ? open = null : open = {{ $i }}"
                        :aria-expanded="open === {{ $i }}">
                        <span>{{ $faq['q'] }}</span>
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

    {{-- ── Related areas (same governorate) — internal linking ── --}}
    @if($relatedLocations->count())
    <section class="py-10 bg-gray-50">
        <div class="container mx-auto px-4 max-w-3xl">
            <h2 class="text-lg font-bold text-gray-700 mb-4">
                {{ $isAr ? "مناطق أخرى في {$govName}" : "Other areas in {$govName}" }}
            </h2>
            <div class="flex flex-wrap gap-3">
                @foreach($relatedLocations as $rel)
                @php $relName = $rel->getTranslation('name', $locale); $relSlug = $rel->getTranslation('slug', $locale); @endphp
                <a href="{{ route($isAr ? 'areas.show' : 'en.areas.show', $relSlug) }}"
                   class="inline-flex items-center px-4 py-2 rounded-full border border-yellow-200 bg-white text-yellow-700 font-semibold text-sm hover:bg-yellow-700 hover:text-white hover:border-yellow-700 transition">
                    {{ $isAr ? "فني كهربائي {$relName}" : "AC Technician {$relName}" }}
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ── All services in this area — Local SEO internal links ── --}}
    @if($services->count())
    <section class="py-12 bg-yellow-50">
        <div class="container mx-auto px-4 max-w-4xl">
            <h2 class="text-xl font-extrabold text-gray-900 mb-2 text-center">
                {{ $isAr ? "جميع خدمات الكهرباء في {$name}" : "All Electrical Services in {$name}" }}
            </h2>
            <p class="text-center text-gray-500 text-sm mb-6">
                {{ $isAr ? 'اختر الخدمة التي تحتاجها للحصول على صفحة مخصصة بتفاصيل محلية' : 'Select the service you need for a dedicated page with local details' }}
            </p>
            <div class="flex flex-wrap justify-center gap-2">
                @foreach($services as $svc)
                @php
                    $svcSlug = $svc->getTranslation('slug', $locale);
                    $svcName = $svc->getTranslation('title', $locale);
                    $locSlug = $location->getTranslation('slug', $locale);
                    $prefix  = $isAr ? '' : 'en.';
                @endphp
                <a href="{{ route($prefix . 'service-locations.show', [$svcSlug, $locSlug]) }}"
                   class="px-4 py-2 bg-white hover:bg-yellow-700 hover:text-white text-yellow-700 text-sm font-medium rounded-full border border-yellow-200 hover:border-yellow-700 transition">
                    {{ $isAr ? "{$svcName} في {$name}" : "{$svcName} in {$name}" }}
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ── Final CTA ── --}}
    <section class="py-14 bg-yellow-700 text-white text-center">
        <div class="container mx-auto px-4 max-w-2xl">
            <h2 class="text-2xl font-extrabold mb-3">
                {{ $isAr ? "احجز فني كهربائي في {$name} الآن" : "Book an AC Technician in {$name} Now" }}
            </h2>
            <p class="opacity-90 mb-8">
                {{ $isAr
                    ? 'تواصل معنا عبر واتساب أو اتصل بنا مباشرة — فنيونا جاهزون'
                    : 'Contact us via WhatsApp or call us directly — our technicians are ready' }}
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
            </div>
        </div>
    </section>

</div>
@endsection
