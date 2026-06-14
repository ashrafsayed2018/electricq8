@php $isAr = app()->getLocale() === 'ar'; @endphp

{{-- ══════════════════════════════════════════════════════════
     SECTION 0 — Deep Service Content (SEO)
     ════════════════════════════════════════════════════════ --}}
<section class="py-16 bg-white" dir="{{ $isAr ? 'rtl' : 'ltr' }}" data-reveal>
    <div class="container mx-auto px-4">

        <div class="text-center mb-12">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-3">{{ __('site.services_deep.heading') }}</h2>
            <p class="text-gray-500 max-w-2xl mx-auto">{{ __('site.services_deep.subheading') }}</p>
        </div>

        <div class="space-y-10 max-w-4xl mx-auto">

            {{-- تمديدات كهربائية --}}
            <div class="bg-yellow-50 rounded-2xl p-8 border border-yellow-100">
                <div class="flex items-center gap-3 mb-4">
                    <span class="text-3xl" aria-hidden="true">🔧</span>
                    <h2 class="text-xl font-extrabold text-yellow-800">{{ __('site.services_deep.install.title') }}</h2>
                </div>
                <p class="text-gray-700 leading-relaxed mb-5">{{ __('site.services_deep.install.body') }}</p>
                <h3 class="font-bold text-gray-800 mb-3">{{ __('site.services_deep.install.when') }}</h3>
                <ul class="space-y-2">
                    @foreach(__('site.services_deep.install.when_points') as $point)
                    <li class="flex items-start gap-2 text-gray-600 text-sm">
                        <span class="mt-1 w-5 h-5 rounded-full bg-yellow-600 text-white flex items-center justify-center shrink-0 text-xs">✓</span>
                        {{ $point }}
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- صيانة وإصلاح --}}
            <div class="bg-orange-50 rounded-2xl p-8 border border-orange-100">
                <div class="flex items-center gap-3 mb-4">
                    <span class="text-3xl" aria-hidden="true">🛠️</span>
                    <h2 class="text-xl font-extrabold text-orange-800">{{ __('site.services_deep.repair.title') }}</h2>
                </div>
                <p class="text-gray-700 leading-relaxed mb-5">{{ __('site.services_deep.repair.body') }}</p>
                <h3 class="font-bold text-gray-800 mb-3">{{ __('site.services_deep.repair.signs') }}</h3>
                <ul class="space-y-2">
                    @foreach(__('site.services_deep.repair.signs_points') as $point)
                    <li class="flex items-start gap-2 text-gray-600 text-sm">
                        <span class="mt-1 w-5 h-5 rounded-full bg-orange-500 text-white flex items-center justify-center shrink-0 text-xs">!</span>
                        {{ $point }}
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- تصليح كهرباء --}}
            <div class="bg-green-50 rounded-2xl p-8 border border-green-100">
                <div class="flex items-center gap-3 mb-4">
                    <span class="text-3xl" aria-hidden="true">🧹</span>
                    <h2 class="text-xl font-extrabold text-green-800">{{ __('site.services_deep.clean.title') }}</h2>
                </div>
                <p class="text-gray-700 leading-relaxed mb-5">{{ __('site.services_deep.clean.body') }}</p>
                <h3 class="font-bold text-gray-800 mb-3">{{ __('site.services_deep.clean.why') }}</h3>
                <ul class="space-y-2">
                    @foreach(__('site.services_deep.clean.why_points') as $point)
                    <li class="flex items-start gap-2 text-gray-600 text-sm">
                        <span class="mt-1 w-5 h-5 rounded-full bg-green-600 text-white flex items-center justify-center shrink-0 text-xs">✓</span>
                        {{ $point }}
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- تصليح شورت --}}
            <div class="bg-purple-50 rounded-2xl p-8 border border-purple-100">
                <div class="flex items-center gap-3 mb-4">
                    <span class="text-3xl" aria-hidden="true">💨</span>
                    <h2 class="text-xl font-extrabold text-purple-800">{{ __('site.services_deep.gas.title') }}</h2>
                </div>
                <p class="text-gray-700 leading-relaxed mb-5">{{ __('site.services_deep.gas.body') }}</p>
                <h3 class="font-bold text-gray-800 mb-3">{{ __('site.services_deep.gas.when') }}</h3>
                <ul class="space-y-2">
                    @foreach(__('site.services_deep.gas.when_points') as $point)
                    <li class="flex items-start gap-2 text-gray-600 text-sm">
                        <span class="mt-1 w-5 h-5 rounded-full bg-purple-600 text-white flex items-center justify-center shrink-0 text-xs">✓</span>
                        {{ $point }}
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- طوارئ 24 ساعة --}}
            <div class="bg-red-700 rounded-2xl p-8 text-white">
                <div class="flex items-center gap-3 mb-4">
                    <span class="text-3xl" aria-hidden="true">🚨</span>
                    <h2 class="text-xl font-extrabold">{{ __('site.services_deep.emergency.title') }}</h2>
                </div>
                <p class="leading-relaxed opacity-90 mb-4">{{ __('site.services_deep.emergency.body') }}</p>
                <p class="font-bold text-yellow-300 text-sm">⚡ {{ __('site.services_deep.emergency.response') }}</p>
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ \App\Helpers\WhatsAppHelper::url() }}" target="_blank"
                       class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-400 text-white font-bold px-6 py-3 rounded-xl transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.116 1.528 5.845L0 24l6.335-1.505A11.946 11.946 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.882a9.872 9.872 0 01-5.031-1.378l-.361-.214-3.741.981.999-3.648-.235-.374A9.869 9.869 0 012.118 12C2.118 6.963 6.963 2.118 12 2.118s9.882 4.845 9.882 9.882-4.845 9.882-9.882 9.882z"/>
                        </svg>
                        {{ $isAr ? 'واتساب الآن' : 'WhatsApp Now' }}
                    </a>
                    <a href="tel:{{ \App\Models\SiteSetting::get('phone_number') }}"
                       class="inline-flex items-center gap-2 bg-white text-red-700 font-bold px-6 py-3 rounded-xl transition hover:bg-red-50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        {{ $isAr ? 'اتصل الآن' : 'Call Now' }}
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════
     SECTION 2 — Why Us + Stats
     ════════════════════════════════════════════════════════ --}}
<section class="py-16 bg-gray-50" dir="{{ $isAr ? 'rtl' : 'ltr' }}" data-reveal>
    <div class="container mx-auto px-4">

        <div class="text-center mb-12">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-2">{{ $isAr ? 'لماذا تختار إلكتريك كويت؟' : 'Why Choose ElectricQ8?' }}</h2>
            <p class="text-gray-500">{{ $isAr ? 'نلتزم بالجودة والأمانة في كل خدمة نقدمها' : 'We are committed to quality and integrity in every service we deliver' }}</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-14">

            <div class="bg-white rounded-2xl p-6 text-center border border-gray-200 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all">
                <div class="w-14 h-14 rounded-full bg-yellow-100 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7 text-yellow-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900 text-lg mb-2">{{ $isAr ? 'فنيون معتمدون' : 'Certified Technicians' }}</h3>
                <p class="text-gray-500 text-sm leading-relaxed">{{ $isAr ? 'جميع فنيينا حاصلون على شهادات معتمدة وخبرة تزيد عن 5 سنوات في مجال الكهرباء' : 'All our technicians hold certified qualifications and have over 5 years of experience in AC servicing' }}</p>
            </div>

            <div class="bg-white rounded-2xl p-6 text-center border border-gray-200 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all">
                <div class="w-14 h-14 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7 text-green-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900 text-lg mb-2">{{ $isAr ? 'ضمان على الخدمة' : 'Service Warranty' }}</h3>
                <p class="text-gray-500 text-sm leading-relaxed">{{ $isAr ? 'نضمن جميع أعمالنا بضمان رسمي لمدة 3 أشهر. إذا عادت المشكلة نعالجها مجاناً' : 'We back all our work with a 3-month official warranty. If the problem recurs, we fix it free of charge' }}</p>
            </div>

            <div class="bg-white rounded-2xl p-6 text-center border border-gray-200 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all">
                <div class="w-14 h-14 rounded-full bg-yellow-100 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7 text-yellow-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900 text-lg mb-2">{{ $isAr ? 'استجابة سريعة' : 'Fast Response' }}</h3>
                <p class="text-gray-500 text-sm leading-relaxed">{{ $isAr ? 'نصل إليك خلال ساعتين من تأكيد الطلب في أغلب مناطق الكويت، بما فيها أوقات الطوارئ' : 'We reach you within 2 hours of booking confirmation across most areas of Kuwait, including emergency calls' }}</p>
            </div>

            <div class="bg-white rounded-2xl p-6 text-center border border-gray-200 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all">
                <div class="w-14 h-14 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900 text-lg mb-2">{{ $isAr ? 'خدمة طوارئ على مدار الساعة' : 'Around-the-Clock Emergency' }}</h3>
                <p class="text-gray-500 text-sm leading-relaxed">{{ $isAr ? 'فني متاح فورًا طوال اليوم وكل أيام الأسبوع بما فيها الجمعة والعطل الرسمية. استجابة سريعة لا تنتظر' : 'A technician is instantly available all day, every day including Fridays and public holidays. Fast response when you need it most' }}</p>
            </div>

        </div>

        {{-- Stats strip --}}
        <div class="bg-yellow-700 rounded-2xl py-10 px-6">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 text-center text-white">
                <div>
                    <span class="block text-4xl md:text-5xl font-extrabold mb-1">+5000</span>
                    <span class="text-yellow-200 text-sm font-medium">{{ $isAr ? 'عميل راضٍ' : 'Happy Customers' }}</span>
                </div>
                <div>
                    <span class="block text-4xl md:text-5xl font-extrabold mb-1">+10</span>
                    <span class="text-yellow-200 text-sm font-medium">{{ $isAr ? 'سنوات خبرة' : 'Years Experience' }}</span>
                </div>
                <div>
                    <span class="block text-4xl md:text-5xl font-extrabold mb-1">+15000</span>
                    <span class="text-yellow-200 text-sm font-medium">{{ $isAr ? 'كهرباء تم صيانته' : 'AC Units Serviced' }}</span>
                </div>
                <div>
                    <span class="block text-4xl md:text-5xl font-extrabold mb-1">98%</span>
                    <span class="text-yellow-200 text-sm font-medium">{{ $isAr ? 'نسبة رضا العملاء' : 'Customer Satisfaction' }}</span>
                </div>
            </div>
        </div>

    </div>
</section>


{{-- ══════════════════════════════════════════════════════════
     SECTION 3 — How It Works
     ════════════════════════════════════════════════════════ --}}
<section class="py-16 bg-white" dir="{{ $isAr ? 'rtl' : 'ltr' }}" data-reveal>
    <div class="container mx-auto px-4">

        <div class="text-center mb-14">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-2">{{ $isAr ? 'كيف نعمل؟' : 'How It Works' }}</h2>
            <p class="text-gray-500">{{ $isAr ? 'أربع خطوات بسيطة تفصلك عن كهرباء يعمل بكفاءة تامة' : 'Four simple steps to a perfectly working air conditioner' }}</p>
        </div>

        <div class="relative">

            <div class="hidden lg:block absolute top-10 right-[12.5%] left-[12.5%] h-px border-t-2 border-dashed border-yellow-200 z-0"></div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 relative z-10">

                <div class="flex flex-col items-center text-center">
                    <div class="w-20 h-20 rounded-full bg-yellow-700 text-white flex items-center justify-center mb-5 shadow-lg relative">
                        <span class="absolute -top-2 -right-2 w-6 h-6 rounded-full bg-white border-2 border-yellow-700 text-yellow-700 text-xs font-extrabold flex items-center justify-center">1</span>
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 text-lg mb-2">{{ $isAr ? 'اتصل بنا' : 'Contact Us' }}</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">{{ $isAr ? 'تواصل معنا عبر الهاتف أو واتساب وأخبرنا بمشكلة الكهرباء لديك' : 'Reach out by phone or WhatsApp and tell us about your AC problem' }}</p>
                </div>

                <div class="flex flex-col items-center text-center">
                    <div class="w-20 h-20 rounded-full bg-yellow-700 text-white flex items-center justify-center mb-5 shadow-lg relative">
                        <span class="absolute -top-2 -right-2 w-6 h-6 rounded-full bg-white border-2 border-yellow-700 text-yellow-700 text-xs font-extrabold flex items-center justify-center">2</span>
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 text-lg mb-2">{{ $isAr ? 'حدد موعدك' : 'Book Your Slot' }}</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">{{ $isAr ? 'نحدد معك وقتاً مناسباً للزيارة ونرسل لك تأكيداً فورياً برقم الفني' : 'We agree on a convenient visit time and send you instant confirmation with the technician details' }}</p>
                </div>

                <div class="flex flex-col items-center text-center">
                    <div class="w-20 h-20 rounded-full bg-yellow-700 text-white flex items-center justify-center mb-5 shadow-lg relative">
                        <span class="absolute -top-2 -right-2 w-6 h-6 rounded-full bg-white border-2 border-yellow-700 text-yellow-700 text-xs font-extrabold flex items-center justify-center">3</span>
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 text-lg mb-2">{{ $isAr ? 'زيارة الفني' : 'Technician Visit' }}</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">{{ $isAr ? 'يصلك الفني المعتمد في الوقت المحدد تماماً مع جميع الأدوات والقطع اللازمة' : 'Our certified technician arrives exactly on time with all the tools and parts needed' }}</p>
                </div>

                <div class="flex flex-col items-center text-center">
                    <div class="w-20 h-20 rounded-full bg-yellow-700 text-white flex items-center justify-center mb-5 shadow-lg relative">
                        <span class="absolute -top-2 -right-2 w-6 h-6 rounded-full bg-white border-2 border-yellow-700 text-yellow-700 text-xs font-extrabold flex items-center justify-center">4</span>
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 text-lg mb-2">{{ $isAr ? 'إصلاح وضمان' : 'Fix & Warranty' }}</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">{{ $isAr ? 'يُنجز العمل بكفاءة عالية ويحصل بطاقة ضمان على الخدمة المقدمة' : 'The job is completed to a high standard and you receive a warranty card for the service' }}</p>
                </div>

            </div>
        </div>

        <div class="text-center mt-12">
            <a href="{{ \App\Helpers\WhatsAppHelper::url() }}" target="_blank"
               class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white font-bold px-8 py-4 rounded-xl transition">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.116 1.528 5.845L0 24l6.335-1.505A11.946 11.946 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.882a9.872 9.872 0 01-5.031-1.378l-.361-.214-3.741.981.999-3.648-.235-.374A9.869 9.869 0 012.118 12C2.118 6.963 6.963 2.118 12 2.118s9.882 4.845 9.882 9.882-4.845 9.882-9.882 9.882z"/>
                </svg>
                {{ $isAr ? 'ابدأ الآن عبر واتساب' : 'Get Started on WhatsApp' }}
            </a>
        </div>

    </div>
</section>


{{-- ══════════════════════════════════════════════════════════
     SECTION 4 — FAQ Accordion
     ════════════════════════════════════════════════════════ --}}
<section class="py-16 bg-gray-50" dir="{{ $isAr ? 'rtl' : 'ltr' }}" data-reveal>
    <div class="container mx-auto px-4">

        <div class="text-center mb-12">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-2">{{ $isAr ? 'الأسئلة الشائعة' : 'Frequently Asked Questions' }}</h2>
            <p class="text-gray-500">{{ $isAr ? 'إجابات على أكثر الأسئلة التي يطرحها عملاؤنا' : 'Answers to the questions our customers ask most' }}</p>
        </div>

        <div class="max-w-2xl mx-auto space-y-3" x-data="{ open: null }">

            @php
            $faqs = $isAr ? [
                [
                    'q' => 'ما هي مناطق الخدمة التي تغطونها؟',
                    'a' => 'نغطي جميع محافظات الكويت الست: العاصمة، الفروانية، الجهراء، الأحمدي، مبارك الكبير، والكويت الوسطى. نصل إلى جميع الأحياء السكنية والتجارية خلال ساعتين من تأكيد الحجز.',
                ],
                [
                    'q' => 'كم يستغرق إصلاح الكهرباء؟',
                    'a' => 'تستغرق معظم عمليات الإصلاح من 30 دقيقة إلى ساعتين حسب نوع المشكلة. في حال احتجنا إلى قطع غيار خاصة، نبلغك مسبقاً ونحدد موعد الإكمال.',
                ],
                [
                    'q' => 'هل تعملون في أيام العطل والجمعة؟',
                    'a' => 'نعم، نعمل على مدار الساعة 24/7 طوال أيام الأسبوع بما فيها الجمعة والإجازات الرسمية. نؤمن بأن أعطال الكهرباء لا تنتظر.',
                ],
                [
                    'q' => 'ما الماركات التي تدعمونها؟',
                    'a' => 'نصلح جميع ماركات الكهرباء الشائعة في الكويت مثل: سامسونج، LG، كاريير، دايكن، ميديا، جري، توشيبا، باناسونيك، شارب، ميتسوبيشي، هيتاشي، وغيرها.',
                ],
                [
                    'q' => 'هل يوجد ضمان على الخدمة؟',
                    'a' => 'نعم، نقدم ضماناً لمدة 3 أشهر على جميع أعمال الإصلاح والصيانة. إذا عادت نفس المشكلة خلال فترة الضمان، نعالجها مجاناً بدون أي رسوم إضافية.',
                ],
                [
                    'q' => 'كيف يمكنني الحجز؟',
                    'a' => 'يمكنك الحجز بعدة طرق: عبر واتساب مباشرة، أو الاتصال برقم هاتفنا، أو ملء نموذج التواصل في الموقع. نرد عليك فوراً ونحدد الموعد الأنسب لك.',
                ],
            ] : [
                [
                    'q' => 'Which areas do you cover?',
                    'a' => 'We cover all six governorates of Kuwait: Capital, Farwaniya, Jahra, Ahmadi, Mubarak Al-Kabeer, and Central Kuwait. We reach all residential and commercial areas within 2 hours of booking confirmation.',
                ],
                [
                    'q' => 'How long does an electrical repair take?',
                    'a' => 'Most repairs take between 30 minutes and 2 hours depending on the issue. If special spare parts are needed, we will inform you in advance and schedule a follow-up appointment.',
                ],
                [
                    'q' => 'Do you work on weekends and public holidays?',
                    'a' => 'Yes, we operate 24/7 every day of the week including Fridays and official public holidays. We believe AC breakdowns cannot wait.',
                ],
                [
                    'q' => 'Which AC brands do you support?',
                    'a' => 'We repair all popular AC brands in Kuwait including Samsung, LG, Carrier, Daikin, Midea, Gree, Toshiba, Panasonic, Sharp, Mitsubishi, Hitachi, and many more.',
                ],
                [
                    'q' => 'Is there a warranty on the service?',
                    'a' => 'Yes, we provide a 3-month warranty on all repair and maintenance work. If the same problem returns within the warranty period, we fix it free of charge with no additional fees.',
                ],
                [
                    'q' => 'How do I book?',
                    'a' => 'You can book in several ways: directly via WhatsApp, by calling our phone number, or by filling in the contact form on the website. We respond immediately and schedule the most convenient time for you.',
                ],
            ];
            @endphp

            @foreach($faqs as $i => $faq)
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">

                <button
                    type="button"
                    class="w-full flex items-center justify-between px-6 py-5 {{ $isAr ? 'text-right' : 'text-left' }} font-bold text-gray-900 hover:bg-gray-50 transition focus:outline-none"
                    @click="open === {{ $i }} ? open = null : open = {{ $i }}"
                    :class="{ 'border-{{ $isAr ? 'r' : 'l' }}-4 border-yellow-700': open === {{ $i }} }"
                    :aria-expanded="open === {{ $i }}"
                >
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
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-2"
                     class="px-6 pb-5 text-gray-600 text-sm leading-relaxed border-t border-gray-100"
                     style="display:none">
                    <p class="pt-4">{{ $faq['a'] }}</p>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</section>


{{-- ══════════════════════════════════════════════════════════
     SECTION 5 — Brands We Service
     ════════════════════════════════════════════════════════ --}}
<section class="py-16 bg-white" dir="{{ $isAr ? 'rtl' : 'ltr' }}" data-reveal>
    <div class="container mx-auto px-4">

        <div class="text-center mb-10">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-2">{{ $isAr ? 'الماركات التي نخدمها' : 'Brands We Service' }}</h2>
            <p class="text-gray-500">{{ $isAr ? 'نصلح جميع أنواع وماركات الكهرباء' : 'We repair all types and brands of air conditioners' }}</p>
        </div>

        <div class="flex flex-wrap justify-center gap-3 max-w-3xl mx-auto mb-10">
            @php
            $brands = [
                ['ar' => 'سامسونج',   'en' => 'Samsung'],
                ['ar' => 'إل جي',     'en' => 'LG'],
                ['ar' => 'كاريير',    'en' => 'Carrier'],
                ['ar' => 'دايكن',     'en' => 'Daikin'],
                ['ar' => 'ميديا',     'en' => 'Midea'],
                ['ar' => 'جري',       'en' => 'Gree'],
                ['ar' => 'توشيبا',    'en' => 'Toshiba'],
                ['ar' => 'باناسونيك', 'en' => 'Panasonic'],
                ['ar' => 'شارب',      'en' => 'Sharp'],
                ['ar' => 'يورك',      'en' => 'York'],
                ['ar' => 'هيتاشي',    'en' => 'Hitachi'],
                ['ar' => 'ميتسوبيشي','en' => 'Mitsubishi'],
                ['ar' => 'تي سي إل',  'en' => 'TCL'],
                ['ar' => 'هايير',     'en' => 'Haier'],
            ];
            $locale = app()->getLocale();
            @endphp
            @foreach($brands as $brand)
            <span class="inline-flex items-center px-5 py-2.5 rounded-full border-2 border-yellow-200 bg-white text-yellow-700 font-semibold text-sm hover:bg-yellow-700 hover:text-white hover:border-yellow-700 transition cursor-default select-none">
                {{ $brand[$locale] ?? $brand['en'] }}
            </span>
            @endforeach
        </div>

        <div class="text-center">
            <p class="text-gray-500 mb-4">{{ $isAr ? 'لا تجد ماركتك؟ تواصل معنا وسنساعدك' : "Don't see your brand? Contact us and we'll help you" }}</p>
            <a href="{{ \App\Helpers\WhatsAppHelper::url() }}" target="_blank"
               class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white font-bold px-7 py-3.5 rounded-xl transition">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.116 1.528 5.845L0 24l6.335-1.505A11.946 11.946 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.882a9.872 9.872 0 01-5.031-1.378l-.361-.214-3.741.981.999-3.648-.235-.374A9.869 9.869 0 012.118 12C2.118 6.963 6.963 2.118 12 2.118s9.882 4.845 9.882 9.882-4.845 9.882-9.882 9.882z"/>
                </svg>
                {{ $isAr ? 'تواصل معنا عبر واتساب' : 'Contact Us on WhatsApp' }}
            </a>
        </div>

    </div>
</section>


{{-- Scroll-reveal: uses IntersectionObserver, no extra library --}}
<style>
[data-reveal] {
    opacity: 0;
    transform: translateY(28px);
    transition: opacity 0.55s ease, transform 0.55s ease;
}
[data-reveal].is-visible {
    opacity: 1;
    transform: none;
}
</style>
<script>
(function () {
    var els = document.querySelectorAll('[data-reveal]');
    if (!els.length) return;
    var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (e) {
            if (e.isIntersecting) {
                e.target.classList.add('is-visible');
                io.unobserve(e.target);
            }
        });
    }, { threshold: 0.1 });
    els.forEach(function (el) { io.observe(el); });
})();
</script>
