@php $isAr = app()->getLocale() === 'ar'; @endphp

{{-- ══ Deep Service Content ══════════════════════════════════════ --}}
<section class="eq8-deep" dir="{{ $isAr ? 'rtl' : 'ltr' }}" data-reveal>
    <div class="eq8-section-inner">
        <div class="eq8-section-head">
            <h2 class="eq8-section-title">{{ __('site.services_deep.heading') }}</h2>
            <p class="eq8-section-sub">{{ __('site.services_deep.subheading') }}</p>
        </div>
        <div class="eq8-deep__list">

            <div class="eq8-deep-card">
                <div class="eq8-deep-card__head">
                    <span class="eq8-deep-card__icon">🔧</span>
                    <h2 class="eq8-deep-card__title">{{ __('site.services_deep.install.title') }}</h2>
                </div>
                <p class="eq8-deep-card__body">{{ __('site.services_deep.install.body') }}</p>
                <h3 class="eq8-deep-card__sub">{{ __('site.services_deep.install.when') }}</h3>
                <ul class="eq8-deep-card__list">
                    @foreach(__('site.services_deep.install.when_points') as $point)
                    <li><span class="eq8-check">✓</span>{{ $point }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="eq8-deep-card">
                <div class="eq8-deep-card__head">
                    <span class="eq8-deep-card__icon">🛠️</span>
                    <h2 class="eq8-deep-card__title">{{ __('site.services_deep.repair.title') }}</h2>
                </div>
                <p class="eq8-deep-card__body">{{ __('site.services_deep.repair.body') }}</p>
                <h3 class="eq8-deep-card__sub">{{ __('site.services_deep.repair.signs') }}</h3>
                <ul class="eq8-deep-card__list">
                    @foreach(__('site.services_deep.repair.signs_points') as $point)
                    <li><span class="eq8-check eq8-check--warn">!</span>{{ $point }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="eq8-deep-card">
                <div class="eq8-deep-card__head">
                    <span class="eq8-deep-card__icon">🧹</span>
                    <h2 class="eq8-deep-card__title">{{ __('site.services_deep.clean.title') }}</h2>
                </div>
                <p class="eq8-deep-card__body">{{ __('site.services_deep.clean.body') }}</p>
                <h3 class="eq8-deep-card__sub">{{ __('site.services_deep.clean.why') }}</h3>
                <ul class="eq8-deep-card__list">
                    @foreach(__('site.services_deep.clean.why_points') as $point)
                    <li><span class="eq8-check">✓</span>{{ $point }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="eq8-deep-card">
                <div class="eq8-deep-card__head">
                    <span class="eq8-deep-card__icon">💨</span>
                    <h2 class="eq8-deep-card__title">{{ __('site.services_deep.gas.title') }}</h2>
                </div>
                <p class="eq8-deep-card__body">{{ __('site.services_deep.gas.body') }}</p>
                <h3 class="eq8-deep-card__sub">{{ __('site.services_deep.gas.when') }}</h3>
                <ul class="eq8-deep-card__list">
                    @foreach(__('site.services_deep.gas.when_points') as $point)
                    <li><span class="eq8-check">✓</span>{{ $point }}</li>
                    @endforeach
                </ul>
            </div>

            {{-- Emergency card — always dark --}}
            <div class="eq8-deep-card eq8-deep-card--emergency">
                <div class="eq8-deep-card__head">
                    <span class="eq8-deep-card__icon">🚨</span>
                    <h2 class="eq8-deep-card__title" style="color:#F3D9BB">{{ __('site.services_deep.emergency.title') }}</h2>
                </div>
                <p class="eq8-deep-card__body" style="color:#C4AD95">{{ __('site.services_deep.emergency.body') }}</p>
                <p style="font-weight:700;color:#D97B2E;font-size:.88rem;margin:0 0 20px">⚡ {{ __('site.services_deep.emergency.response') }}</p>
                <div style="display:flex;flex-wrap:wrap;gap:12px">
                    <a href="{{ \App\Helpers\WhatsAppHelper::url() }}" target="_blank" class="eq8-btn eq8-btn--wa">
                        <svg class="eq8-btn__icon" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.116 1.528 5.845L0 24l6.335-1.505A11.946 11.946 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.882a9.872 9.872 0 01-5.031-1.378l-.361-.214-3.741.981.999-3.648-.235-.374A9.869 9.869 0 012.118 12C2.118 6.963 6.963 2.118 12 2.118s9.882 4.845 9.882 9.882-4.845 9.882-9.882 9.882z"/></svg>
                        {{ $isAr ? 'واتساب الآن' : 'WhatsApp Now' }}
                    </a>
                    <a href="tel:{{ \App\Models\SiteSetting::get('phone_number') }}" class="eq8-btn eq8-btn--call">
                        <svg class="eq8-btn__icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        {{ $isAr ? 'اتصل الآن' : 'Call Now' }}
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ══ Why Us + Stats ═════════════════════════════════════════════ --}}
<section class="eq8-why" dir="{{ $isAr ? 'rtl' : 'ltr' }}" data-reveal>
    <div class="eq8-section-inner">
        <div class="eq8-section-head">
            <h2 class="eq8-section-title">{{ $isAr ? 'لماذا تختار إلكتريك كويت؟' : 'Why Choose ElectricQ8?' }}</h2>
            <p class="eq8-section-sub">{{ $isAr ? 'نلتزم بالجودة والأمانة في كل خدمة نقدمها' : 'We are committed to quality and integrity in every service we deliver' }}</p>
        </div>

        <div class="eq8-why__grid">
            @php
            $whyCards = [
                ['icon' => '🏅', 'title_ar' => 'فنيون معتمدون',               'title_en' => 'Certified Technicians',       'body_ar' => 'جميع فنيينا حاصلون على شهادات معتمدة وخبرة تزيد عن 5 سنوات في مجال الكهرباء',                                      'body_en' => 'All our technicians hold certified qualifications and have over 5 years of electrical experience'],
                ['icon' => '🛡️', 'title_ar' => 'ضمان على الخدمة',              'title_en' => 'Service Warranty',            'body_ar' => 'نضمن جميع أعمالنا بضمان رسمي لمدة 3 أشهر. إذا عادت المشكلة نعالجها مجاناً',                                         'body_en' => 'We back all work with a 3-month official warranty. If the problem recurs, we fix it free'],
                ['icon' => '⚡', 'title_ar' => 'استجابة سريعة',               'title_en' => 'Fast Response',               'body_ar' => 'نصل إليك خلال ساعتين من تأكيد الطلب في أغلب مناطق الكويت، بما فيها أوقات الطوارئ',                                   'body_en' => 'We reach you within 2 hours of booking confirmation across most areas of Kuwait'],
                ['icon' => '🕐', 'title_ar' => 'خدمة طوارئ على مدار الساعة', 'title_en' => 'Around-the-Clock Emergency',  'body_ar' => 'فني متاح فورًا طوال اليوم وكل أيام الأسبوع بما فيها الجمعة والعطل الرسمية',                                           'body_en' => 'A technician is instantly available all day, every day including Fridays and public holidays'],
            ];
            @endphp
            @foreach($whyCards as $card)
            <div class="eq8-why-card">
                <div class="eq8-why-card__icon">{{ $card['icon'] }}</div>
                <h3 class="eq8-why-card__title">{{ $isAr ? $card['title_ar'] : $card['title_en'] }}</h3>
                <p class="eq8-why-card__body">{{ $isAr ? $card['body_ar'] : $card['body_en'] }}</p>
            </div>
            @endforeach
        </div>

        {{-- Stats --}}
        <div class="eq8-stats">
            <div class="eq8-stats__item">
                <span class="eq8-stats__num">+5000</span>
                <span class="eq8-stats__label">{{ $isAr ? 'عميل راضٍ' : 'Happy Customers' }}</span>
            </div>
            <div class="eq8-stats__item">
                <span class="eq8-stats__num">+10</span>
                <span class="eq8-stats__label">{{ $isAr ? 'سنوات خبرة' : 'Years Experience' }}</span>
            </div>
            <div class="eq8-stats__item">
                <span class="eq8-stats__num">+15000</span>
                <span class="eq8-stats__label">{{ $isAr ? 'مشروع منجز' : 'Projects Done' }}</span>
            </div>
            <div class="eq8-stats__item">
                <span class="eq8-stats__num">98%</span>
                <span class="eq8-stats__label">{{ $isAr ? 'نسبة رضا العملاء' : 'Customer Satisfaction' }}</span>
            </div>
        </div>
    </div>
</section>

{{-- ══ How It Works ═══════════════════════════════════════════════ --}}
<section class="eq8-how" dir="{{ $isAr ? 'rtl' : 'ltr' }}" data-reveal>
    <div class="eq8-section-inner">
        <div class="eq8-section-head">
            <h2 class="eq8-section-title">{{ $isAr ? 'كيف نعمل؟' : 'How It Works' }}</h2>
            <p class="eq8-section-sub">{{ $isAr ? 'أربع خطوات بسيطة تفصلك عن كهرباء يعمل بكفاءة تامة' : 'Four simple steps to a perfectly working electrical system' }}</p>
        </div>
        <div class="eq8-how__steps">
            @php
            $steps = [
                ['icon_path' => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z', 'title_ar' => 'اتصل بنا',     'title_en' => 'Contact Us',        'body_ar' => 'تواصل معنا عبر الهاتف أو واتساب وأخبرنا بمشكلة الكهرباء لديك',                                           'body_en' => 'Reach out by phone or WhatsApp and describe your electrical problem'],
                ['icon_path' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',           'title_ar' => 'حدد موعدك',     'title_en' => 'Book Your Slot',    'body_ar' => 'نحدد معك وقتاً مناسباً للزيارة ونرسل لك تأكيداً فورياً',                                                   'body_en' => 'We agree on a convenient visit time and send you instant confirmation'],
                ['icon_path' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',                               'title_ar' => 'زيارة الفني',   'title_en' => 'Technician Visit',  'body_ar' => 'يصلك الفني المعتمد في الوقت المحدد تماماً مع جميع الأدوات والقطع اللازمة',                                  'body_en' => 'Our certified technician arrives on time with all the tools and parts needed'],
                ['icon_path' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',                                                     'title_ar' => 'إصلاح وضمان', 'title_en' => 'Fix & Warranty',    'body_ar' => 'يُنجز العمل بكفاءة عالية ويحصل على بطاقة ضمان على الخدمة المقدمة',                                        'body_en' => 'The job is completed to a high standard and you receive a warranty card'],
            ];
            @endphp
            @foreach($steps as $i => $step)
            <div class="eq8-step">
                <div class="eq8-step__circle">
                    <span class="eq8-step__num">{{ $i + 1 }}</span>
                    <svg class="eq8-step__svg" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $step['icon_path'] }}"/>
                    </svg>
                </div>
                <h3 class="eq8-step__title">{{ $isAr ? $step['title_ar'] : $step['title_en'] }}</h3>
                <p class="eq8-step__body">{{ $isAr ? $step['body_ar'] : $step['body_en'] }}</p>
            </div>
            @endforeach
        </div>
        <div class="eq8-section-cta">
            <a href="{{ \App\Helpers\WhatsAppHelper::url() }}" target="_blank" class="eq8-btn eq8-btn--wa">
                <svg class="eq8-btn__icon" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.116 1.528 5.845L0 24l6.335-1.505A11.946 11.946 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.882a9.872 9.872 0 01-5.031-1.378l-.361-.214-3.741.981.999-3.648-.235-.374A9.869 9.869 0 012.118 12C2.118 6.963 6.963 2.118 12 2.118s9.882 4.845 9.882 9.882-4.845 9.882-9.882 9.882z"/></svg>
                {{ $isAr ? 'ابدأ الآن عبر واتساب' : 'Get Started on WhatsApp' }}
            </a>
        </div>
    </div>
</section>

{{-- ══ FAQ ════════════════════════════════════════════════════════ --}}
<section class="eq8-faq" dir="{{ $isAr ? 'rtl' : 'ltr' }}" data-reveal>
    <div class="eq8-section-inner">
        <div class="eq8-section-head">
            <h2 class="eq8-section-title">{{ $isAr ? 'الأسئلة الشائعة' : 'Frequently Asked Questions' }}</h2>
            <p class="eq8-section-sub">{{ $isAr ? 'إجابات على أكثر الأسئلة التي يطرحها عملاؤنا' : 'Answers to the questions our customers ask most' }}</p>
        </div>

        <div class="eq8-faq__list" x-data="{ open: null }">
            @php
            $faqs = $isAr ? [
                ['q' => 'ما هي مناطق الخدمة التي تغطونها؟',   'a' => 'نغطي جميع محافظات الكويت الست: العاصمة، الفروانية، الجهراء، الأحمدي، مبارك الكبير، والكويت الوسطى. نصل إلى جميع الأحياء السكنية والتجارية خلال ساعتين من تأكيد الحجز.'],
                ['q' => 'كم يستغرق إصلاح الكهرباء؟',           'a' => 'تستغرق معظم عمليات الإصلاح من 30 دقيقة إلى ساعتين حسب نوع المشكلة. في حال احتجنا إلى قطع غيار خاصة، نبلغك مسبقاً ونحدد موعد الإكمال.'],
                ['q' => 'هل تعملون في أيام العطل والجمعة؟',    'a' => 'نعم، نعمل على مدار الساعة 24/7 طوال أيام الأسبوع بما فيها الجمعة والإجازات الرسمية. نؤمن بأن أعطال الكهرباء لا تنتظر.'],
                ['q' => 'ما الماركات التي تدعمونها؟',           'a' => 'نصلح جميع ماركات الكهرباء الشائعة في الكويت مثل: سامسونج، LG، كاريير، دايكن، ميديا، جري، توشيبا، باناسونيك، شارب، ميتسوبيشي، هيتاشي، وغيرها.'],
                ['q' => 'هل يوجد ضمان على الخدمة؟',             'a' => 'نعم، نقدم ضماناً لمدة 3 أشهر على جميع أعمال الإصلاح والصيانة. إذا عادت نفس المشكلة خلال فترة الضمان، نعالجها مجاناً.'],
                ['q' => 'كيف يمكنني الحجز؟',                   'a' => 'يمكنك الحجز عبر واتساب مباشرة، أو الاتصال برقم هاتفنا، أو ملء نموذج التواصل في الموقع. نرد عليك فوراً.'],
            ] : [
                ['q' => 'Which areas do you cover?',             'a' => 'We cover all six governorates of Kuwait: Capital, Farwaniya, Jahra, Ahmadi, Mubarak Al-Kabeer, and Central Kuwait. We reach all residential and commercial areas within 2 hours of booking confirmation.'],
                ['q' => 'How long does an electrical repair take?','a' => 'Most repairs take between 30 minutes and 2 hours depending on the issue. If special spare parts are needed, we will inform you in advance and schedule a follow-up.'],
                ['q' => 'Do you work on weekends and public holidays?','a' => 'Yes, we operate 24/7 every day of the week including Fridays and official public holidays. Electrical breakdowns cannot wait.'],
                ['q' => 'Which brands do you support?',           'a' => 'We repair all popular electrical brands in Kuwait including Samsung, LG, Carrier, Daikin, Midea, Gree, Toshiba, Panasonic, Sharp, Mitsubishi, Hitachi, and many more.'],
                ['q' => 'Is there a warranty on the service?',    'a' => 'Yes, we provide a 3-month warranty on all repair and maintenance work. If the same problem returns within the warranty period, we fix it free of charge.'],
                ['q' => 'How do I book?',                         'a' => 'You can book directly via WhatsApp, by calling our phone number, or by filling in the contact form on the website. We respond immediately.'],
            ];
            @endphp
            @foreach($faqs as $i => $faq)
            <div class="eq8-faq__item">
                <button type="button" class="eq8-faq__q {{ $isAr ? 'eq8-faq__q--ar' : '' }}"
                        @click="open === {{ $i }} ? open = null : open = {{ $i }}"
                        :aria-expanded="open === {{ $i }}">
                    <span>{{ $faq['q'] }}</span>
                    <svg class="eq8-faq__chevron" :class="{ 'eq8-faq__chevron--open': open === {{ $i }} }"
                         fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open === {{ $i }}"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="eq8-faq__a" style="display:none">
                    <p>{{ $faq['a'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══ Property Types ═════════════════════════════════════════════ --}}
<section class="eq8-props" dir="{{ $isAr ? 'rtl' : 'ltr' }}" data-reveal>
    <div class="eq8-section-inner">
        <div class="eq8-section-head">
            <h2 class="eq8-section-title">{{ $isAr ? 'نخدم جميع أنواع المباني' : 'All Property Types We Cover' }}</h2>
            <p class="eq8-section-sub">{{ $isAr ? 'فني كهربائي معتمد لكل أنواع المنازل والمنشآت في الكويت' : 'Certified electrician for all types of homes and properties in Kuwait' }}</p>
        </div>
        @php
        $propertyTypes = $isAr ? [
            ['icon' => '🏠', 'title' => 'المنازل والبيوت',       'desc' => 'تمديدات وصيانة وتصليح شورت للمنازل السكنية'],
            ['icon' => '🏢', 'title' => 'الشركات والمكاتب',      'desc' => 'حلول كهربائية متكاملة للمنشآت التجارية والإدارية'],
            ['icon' => '🏭', 'title' => 'المصانع والمستودعات',   'desc' => 'تمديدات ثلاثية الأطوار وصيانة للمنشآت الصناعية'],
            ['icon' => '🏗️', 'title' => 'المباني قيد الإنشاء',  'desc' => 'تمديدات كهربائية كاملة من الصفر للمشاريع الجديدة'],
            ['icon' => '🛖', 'title' => 'الفلل والقصور',         'desc' => 'خدمة كهربائية شاملة للفلل الخاصة والمجمعات السكنية'],
            ['icon' => '🏪', 'title' => 'المحلات التجارية',      'desc' => 'تركيب إضاءة وتمديدات للمحلات والمطاعم والمراكز التجارية'],
        ] : [
            ['icon' => '🏠', 'title' => 'Houses & Homes',         'desc' => 'Wiring, maintenance and short circuit repair for residential homes'],
            ['icon' => '🏢', 'title' => 'Companies & Offices',    'desc' => 'Complete electrical solutions for commercial and administrative buildings'],
            ['icon' => '🏭', 'title' => 'Factories & Warehouses', 'desc' => 'Three-phase wiring and maintenance for industrial facilities'],
            ['icon' => '🏗️', 'title' => 'Buildings Under Construction','desc' => 'Full electrical installations from scratch for new projects'],
            ['icon' => '🛖', 'title' => 'Villas & Palaces',       'desc' => 'Comprehensive electrical service for private villas and residential compounds'],
            ['icon' => '🏪', 'title' => 'Shops & Restaurants',    'desc' => 'Lighting installation and wiring for shops, restaurants and malls'],
        ];
        @endphp
        <div class="eq8-props__grid">
            @foreach($propertyTypes as $type)
            <div class="eq8-prop-card">
                <span class="eq8-prop-card__icon">{{ $type['icon'] }}</span>
                <div>
                    <h3 class="eq8-prop-card__title">{{ $type['title'] }}</h3>
                    <p class="eq8-prop-card__desc">{{ $type['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
        <div class="eq8-section-cta">
            <a href="{{ \App\Helpers\WhatsAppHelper::url() }}" target="_blank" class="eq8-btn eq8-btn--wa">
                <svg class="eq8-btn__icon" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.116 1.528 5.845L0 24l6.335-1.505A11.946 11.946 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.882a9.872 9.872 0 01-5.031-1.378l-.361-.214-3.741.981.999-3.648-.235-.374A9.869 9.869 0 012.118 12C2.118 6.963 6.963 2.118 12 2.118s9.882 4.845 9.882 9.882-4.845 9.882-9.882 9.882z"/></svg>
                {{ $isAr ? 'تواصل معنا عبر واتساب' : 'Contact Us on WhatsApp' }}
            </a>
        </div>
    </div>
</section>

<style>
/* ── Shared buttons ──────────────────────────────────────────── */
.eq8-btn {
    display: inline-flex; align-items: center; gap: 8px;
    font-weight: 700; font-size: .95rem; padding: 12px 24px;
    border-radius: 12px; text-decoration: none;
    font-family: 'Cairo', system-ui, sans-serif;
    transition: transform .2s ease, box-shadow .2s ease, background .18s ease;
}
.eq8-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,.2); }
.eq8-btn__icon { width: 20px; height: 20px; flex-shrink: 0; }
.eq8-btn--wa   { background: #25D366; color: #fff; }
.eq8-btn--wa:hover { background: #1fba5a; }
.eq8-btn--call { background: rgba(255,255,255,.12); color: #fff; border: 1.5px solid rgba(255,255,255,.35); }
.eq8-btn--call:hover { background: rgba(255,255,255,.22); }

.eq8-section-cta { text-align: center; margin-top: 40px; }

/* ── Deep content ────────────────────────────────────────────── */
.eq8-deep {
    padding: 64px 0;
    background: var(--bg);
}
.eq8-deep__list { display: flex; flex-direction: column; gap: 20px; max-width: 800px; margin: 0 auto; }

.eq8-deep-card {
    background: var(--cardBg);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 28px;
    transition: border-color .2s ease;
}
.eq8-deep-card:hover { border-color: var(--accent); }
.eq8-deep-card--emergency {
    background: #43230E !important;
    border-color: #6B3A17 !important;
}

.eq8-deep-card__head { display: flex; align-items: center; gap: 12px; margin-bottom: 14px; }
.eq8-deep-card__icon { font-size: 1.8rem; line-height: 1; flex-shrink: 0; }
.eq8-deep-card__title { font-size: 1.1rem; font-weight: 700; color: var(--text); margin: 0; font-family: 'Cairo', system-ui, sans-serif; }
.eq8-deep-card__body  { font-size: .88rem; color: var(--body); line-height: 1.7; margin: 0 0 14px; font-family: 'Cairo', system-ui, sans-serif; }
.eq8-deep-card__sub   { font-size: .9rem; font-weight: 700; color: var(--text); margin: 0 0 10px; font-family: 'Cairo', system-ui, sans-serif; }
.eq8-deep-card__list  { list-style: none; margin: 0; padding: 0; display: flex; flex-direction: column; gap: 8px; }
.eq8-deep-card__list li { display: flex; align-items: flex-start; gap: 10px; font-size: .85rem; color: var(--body); font-family: 'Cairo', system-ui, sans-serif; }
.eq8-check {
    width: 20px; height: 20px; border-radius: 50%;
    background: var(--primary); color: #fff;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: .7rem; font-weight: 700; flex-shrink: 0; margin-top: 2px;
}
.eq8-check--warn { background: var(--accent); }

/* ── Why Us ──────────────────────────────────────────────────── */
.eq8-why { padding: 64px 0; background: var(--altBg); }
.eq8-why__grid {
    display: grid; grid-template-columns: repeat(4, 1fr); gap: 18px; margin-bottom: 40px;
}
@media (max-width: 900px)  { .eq8-why__grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 480px)  { .eq8-why__grid { grid-template-columns: 1fr; } }

.eq8-why-card {
    background: var(--cardBg);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 24px 20px;
    text-align: center;
    transition: border-color .2s, box-shadow .2s, transform .2s;
    font-family: 'Cairo', system-ui, sans-serif;
}
.eq8-why-card:hover { border-color: var(--accent); box-shadow: 0 6px 24px rgba(107,58,23,.1); transform: translateY(-3px); }
.eq8-why-card__icon  { font-size: 2rem; margin-bottom: 12px; display: block; }
.eq8-why-card__title { font-size: .95rem; font-weight: 700; color: var(--text); margin: 0 0 8px; }
.eq8-why-card__body  { font-size: .82rem; color: var(--body); line-height: 1.65; margin: 0; }

/* ── Stats band ──────────────────────────────────────────────── */
.eq8-stats {
    background: linear-gradient(135deg, #43230E 0%, #6B3A17 100%);
    border-radius: 16px;
    padding: 40px 24px;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 24px;
    text-align: center;
}
@media (max-width: 640px) { .eq8-stats { grid-template-columns: repeat(2, 1fr); } }
.eq8-stats__num   { display: block; font-size: 2.5rem; font-weight: 800; color: #fff; margin-bottom: 4px; font-family: 'Cairo', system-ui, sans-serif; }
.eq8-stats__label { font-size: .82rem; font-weight: 600; color: #F3D9BB; font-family: 'Cairo', system-ui, sans-serif; }

/* ── How It Works ────────────────────────────────────────────── */
.eq8-how { padding: 64px 0; background: var(--bg); }
.eq8-how__steps {
    display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; position: relative;
}
@media (max-width: 900px)  { .eq8-how__steps { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 480px)  { .eq8-how__steps { grid-template-columns: 1fr; } }

.eq8-step { display: flex; flex-direction: column; align-items: center; text-align: center; font-family: 'Cairo', system-ui, sans-serif; }
.eq8-step__circle {
    width: 72px; height: 72px; border-radius: 50%;
    background: linear-gradient(135deg, #6B3A17, #D97B2E);
    color: #fff;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 18px; position: relative; flex-shrink: 0;
    box-shadow: 0 4px 18px rgba(107,58,23,.3);
}
.eq8-step__num {
    position: absolute; top: -6px; right: -6px;
    width: 22px; height: 22px; border-radius: 50%;
    background: #fff; border: 2px solid #6B3A17;
    color: #6B3A17; font-size: .72rem; font-weight: 800;
    display: flex; align-items: center; justify-content: center;
}
[dir="ltr"] .eq8-step__num { right: auto; left: -6px; }
.eq8-step__svg   { width: 30px; height: 30px; }
.eq8-step__title { font-size: .95rem; font-weight: 700; color: var(--text); margin: 0 0 8px; }
.eq8-step__body  { font-size: .82rem; color: var(--body); line-height: 1.65; margin: 0; }

/* ── FAQ ─────────────────────────────────────────────────────── */
.eq8-faq { padding: 64px 0; background: var(--altBg); }
.eq8-faq__list { max-width: 720px; margin: 0 auto; display: flex; flex-direction: column; gap: 10px; }
.eq8-faq__item {
    background: var(--cardBg);
    border: 1px solid var(--border);
    border-radius: 12px;
    overflow: hidden;
    transition: border-color .2s;
}
.eq8-faq__item:has(.eq8-faq__a:not([style*="display: none"])) { border-color: var(--accent); }
.eq8-faq__q {
    width: 100%;
    display: flex; align-items: center; justify-content: space-between;
    padding: 18px 20px;
    background: none; border: none; cursor: pointer;
    font-size: .92rem; font-weight: 700; color: var(--text);
    text-align: right; font-family: 'Cairo', system-ui, sans-serif;
    transition: background .18s;
}
.eq8-faq__q--ar { text-align: right; }
.eq8-faq__q:not(.eq8-faq__q--ar) { text-align: left; }
.eq8-faq__q:hover { background: var(--altBg); }
.eq8-faq__chevron {
    width: 18px; height: 18px; color: var(--accent); flex-shrink: 0;
    transition: transform .25s ease;
    margin-inline-start: 12px;
}
.eq8-faq__chevron--open { transform: rotate(180deg); }
.eq8-faq__a {
    padding: 0 20px 18px; border-top: 1px solid var(--border); font-family: 'Cairo', system-ui, sans-serif;
}
.eq8-faq__a p { margin: 14px 0 0; font-size: .86rem; color: var(--body); line-height: 1.75; }

/* ── Property Types ──────────────────────────────────────────── */
.eq8-props { padding: 64px 0; background: var(--bg); }
.eq8-props__grid {
    display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; max-width: 960px; margin: 0 auto 40px;
}
@media (max-width: 720px)  { .eq8-props__grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 480px)  { .eq8-props__grid { grid-template-columns: 1fr; } }

.eq8-prop-card {
    display: flex; align-items: flex-start; gap: 14px;
    background: var(--cardBg); border: 1px solid var(--border); border-radius: 14px; padding: 22px 18px;
    font-family: 'Cairo', system-ui, sans-serif;
    transition: border-color .2s, box-shadow .2s;
}
.eq8-prop-card:hover { border-color: var(--accent); box-shadow: 0 4px 16px rgba(107,58,23,.1); }
.eq8-prop-card__icon  { font-size: 1.8rem; flex-shrink: 0; margin-top: 2px; }
.eq8-prop-card__title { font-size: .92rem; font-weight: 700; color: var(--text); margin: 0 0 5px; }
.eq8-prop-card__desc  { font-size: .8rem; color: var(--body); line-height: 1.6; margin: 0; }

/* ── Scroll reveal ───────────────────────────────────────────── */
[data-reveal] {
    opacity: 0; transform: translateY(24px);
    transition: opacity .55s ease, transform .55s ease;
}
[data-reveal].is-visible { opacity: 1; transform: none; }
</style>

<script>
(function () {
    var els = document.querySelectorAll('[data-reveal]');
    if (!els.length) return;
    var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (e) {
            if (e.isIntersecting) { e.target.classList.add('is-visible'); io.unobserve(e.target); }
        });
    }, { threshold: 0.1 });
    els.forEach(function (el) { io.observe(el); });
})();
</script>
