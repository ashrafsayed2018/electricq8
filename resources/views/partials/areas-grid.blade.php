@php
$isAr = app()->getLocale() === 'ar';

$governorates = [
    [
        'key'     => 'capital',
        'ar'      => 'محافظة العاصمة',
        'en'      => 'Capital Governorate',
        'aria_ar' => 'صيانة كهرباءات محافظة العاصمة الكويت',
        'aria_en' => 'Electrical Repair Capital Governorate Kuwait',
        'areas'   => [
            'ar' => ['مدينة الكويت','دسمان','الشرق','الصوابر','خيطان','قرطبة','غرناطة','شمال غرب الصليبيخات','المرقاب','القبلة','الصالحية','الوطية','السرة','بنيد القار','كيفان','الدوحة','الدسمة','الدعية','اليرموك','الصليبيخات','الروضة','النزهة','الفيحاء','الشامية','الشويخ','النهضة','ضاحية عبدالله السالم','العديلية','الخالدية','القادسية','الري','القيروان','مدينة جابر الأحمد'],
            'en' => ['Kuwait City','Dasman','Sharq','Sawaber','Khaitan','Qurtuba','Granada','North West Sulaibikhat','Mirqab','Qibla','Salhiya','Watiya','Surra','Bneid Al-Qar','Kaifan','Doha','Dasma','Daiya','Yarmouk','Sulaibikhat','Rawda','Nuzha','Faiha','Shamiya','Shuwaikh','Nahda','Abdullah Al-Salem','Adailiya','Khalidiya','Qadsiya','Rai','Qairawan','Jaber Al-Ahmad City'],
        ],
    ],
    [
        'key'     => 'hawalli',
        'ar'      => 'محافظة حولي',
        'en'      => 'Hawalli Governorate',
        'aria_ar' => 'صيانة كهرباءات محافظة حولي الكويت',
        'aria_en' => 'Electrical Repair Hawalli Governorate Kuwait',
        'areas'   => [
            'ar' => ['حولي','مشرف','سلوى','ضاحية مبارك العبدالله الجابر','الشعب','بيان','جنوب السرة','السالمية','البدع','حطين','السلام','الجابرية','الرميثية','النقرة','الزهراء','ميدان حولي','الصديق','الشهداء'],
            'en' => ['Hawalli','Mishrif','Salwa','Mubarak Al-Abdullah Al-Jaber','Shaab','Bayan','South Surra','Salmiya','Bidaa','Hittin','Salam','Jabriya','Rumaithiya','Nuqra','Zahraa','Hawalli Maidan','Siddiq','Shuhada'],
        ],
    ],
    [
        'key'     => 'farwaniya',
        'ar'      => 'محافظة الفروانية',
        'en'      => 'Farwaniya Governorate',
        'aria_ar' => 'صيانة كهرباءات محافظة الفروانية الكويت',
        'aria_en' => 'Electrical Repair Farwaniya Governorate Kuwait',
        'areas'   => [
            'ar' => ['أبرق خيطان','خيطان الجديدة','العباسية','الرابية','ضاحية عبدالله المبارك','الأندلس','العمرية','الفردوس','الرحاب','أشبيلية','العارضية','الفروانية','الرقعي','غرب عبدالله المبارك','خيطان','العارضية مخازن','الشدادية','ضاحية صباح الناصر','الصبيح','جليب الشيوخ','العارضية الصناعية','الحساوي','الري الصناعية'],
            'en' => ['Abraq Khaitan','New Khaitan','Abbasiya','Rabiya','Abdullah Al-Mubarak','Andalus','Omariya','Firdous','Rehab','Ishbiliya','Ardiya','Farwaniya','Rigai','West Abdullah Al-Mubarak','Khaitan Farwaniya','Ardiya Stores','Shadadiya','Sabah Al-Naser','Subaiha','Jleeb Al-Shuyoukh','Ardiya Industrial','Hassawi','Rai Industrial'],
        ],
    ],
    [
        'key'     => 'jahra',
        'ar'      => 'محافظة الجهراء',
        'en'      => 'Jahra Governorate',
        'aria_ar' => 'صيانة كهرباءات محافظة الجهراء الكويت',
        'aria_en' => 'Electrical Repair Jahra Governorate Kuwait',
        'areas'   => [
            'ar' => ['الصليبية','تيماء','الجهراء القديمة','كبد','أمغرة','النسيم','الجهراء الجديدة','الروضتين','الصليبية الصناعية','النعيم','العيون','مدينة سعد العبدالله','الصبية','القصر','القصرية','السالمي','جنوب الجهراء','الصليبية الزراعية','الواحة','العبدلي','المطلاع','الجهراء الصناعية'],
            'en' => ['Sulaibiya','Tayma','Old Jahra','Kabd','Amghara','Naseem','New Jahra','Raudhatain','Sulaibiya Industrial','Naeem','Uyoun','Saad Al-Abdullah City','Subbiya','Qasr','Qasriya','Salmi','South Jahra','Sulaibiya Agricultural','Waha','Abdali','Mutlaa','Jahra Industrial'],
        ],
    ],
    [
        'key'     => 'mubarak_al_kabeer',
        'ar'      => 'محافظة مبارك الكبير',
        'en'      => 'Mubarak Al-Kabeer Governorate',
        'aria_ar' => 'صيانة كهرباءات محافظة مبارك الكبير الكويت',
        'aria_en' => 'Electrical Repair Mubarak Al-Kabeer Governorate Kuwait',
        'areas'   => [
            'ar' => ['العدان','أبو فطيرة','القصور','صبحان','القرين','الفنيطيس','ضاحية صباح السالم','المسيلة','ضاحية مبارك الكبير','أبو الحصاني'],
            'en' => ['Adan','Abu Ftaira','Qusour','Sabhan','Qurain','Funaitees','Sabah Al-Salem','Masayel','Mubarak Al-Kabeer','Abu Al-Hasaniya'],
        ],
    ],
    [
        'key'     => 'ahmadi',
        'ar'      => 'محافظة الأحمدي',
        'en'      => 'Ahmadi Governorate',
        'aria_ar' => 'صيانة كهرباءات محافظة الأحمدي الكويت',
        'aria_en' => 'Electrical Repair Ahmadi Governorate Kuwait',
        'areas'   => [
            'ar' => ['الفنطاس','الرقة','المهبولة','ضاحية جابر العلي','ميناء عبدالله','العقيلة','هدية','الأحمدي','الوفرة الزراعية','ضاحية فهد الأحمد','شرق الأحمدي','الفحيحيل','المنقف','الخيران','الصناعية','مدينة صباح الأحمد','مدينة الخيران','الظهر','أبو حليفة','الوفرة','بنيدر','الشعيبة','وارة','ميناء الأحمدي','الزور','الجليعة','ضاحية علي صباح السالم - أم الهيمان','النويصيب','مدينة صباح الأحمد البحرية'],
            'en' => ['Fintas','Ruqa','Mahboula','Jaber Al-Ali','Abdullah Port','Aqaila','Hadiya','Ahmadi','Wafra Agricultural','Fahad Al-Ahmad','East Ahmadi','Fahaheel','Mangaf','Khairan','Industrial Ahmadi','Sabah Al-Ahmad City','Khairan City','Dhaher','Abu Halifa','Wafra','Bnaider','Shuaiba','Wara','Ahmadi Port','Zour','Julaiaa','Ali Sabah Al-Salem - Um Al-Hayman','Nuwaiseeb','Sabah Al-Ahmad Marine City'],
        ],
    ],
];

$lang = $isAr ? 'ar' : 'en';

$dbLookup = [];
foreach ($locations as $loc) {
    $arName = $loc->getTranslation('name', 'ar');
    $slug   = $loc->getTranslation('slug', $lang);
    $dbLookup[$loc->governorate][$arName] = $slug;
}
@endphp

<section class="eq8-areas" dir="{{ $isAr ? 'rtl' : 'ltr' }}"
         aria-label="{{ $isAr ? 'مناطق الخدمة في الكويت' : 'Service Areas in Kuwait' }}">
    <div class="eq8-section-inner">

        <div class="eq8-section-head">
            <h2 class="eq8-section-title">{{ $isAr ? 'مناطق الخدمة في الكويت' : 'Service Areas in Kuwait' }}</h2>
            <p class="eq8-section-sub">{{ $isAr
                ? 'نغطي جميع محافظات ومناطق الكويت — خدمة سريعة في موقعك'
                : 'We cover all governorates and areas of Kuwait — fast service at your location' }}</p>
        </div>

        <div class="eq8-areas__grid">
            @foreach($governorates as $idx => $gov)
            @php
                $govName = $gov[$lang] ?? $gov['ar'];
                $slugMap = $dbLookup[$gov['key']] ?? [];
                $delay   = $idx * 70;
            @endphp
            <div class="eq8-gov-card" data-gov-reveal style="transition-delay: {{ $delay }}ms"
                 aria-label="{{ $gov[$isAr ? 'aria_ar' : 'aria_en'] }}">
                <div class="eq8-gov-card__head">
                    <span class="eq8-gov-card__pin" aria-hidden="true">📍</span>
                    <h3 class="eq8-gov-card__name">{{ $govName }}</h3>
                </div>
                <div class="eq8-gov-card__divider"></div>
                <div class="eq8-gov-card__pills">
                    @foreach($gov['areas']['ar'] as $arIdx => $arName)
                    @php
                        $displayName = $isAr ? $arName : ($gov['areas']['en'][$arIdx] ?? $arName);
                        $slug        = $slugMap[$arName] ?? null;
                    @endphp
                    @if($slug)
                        <a href="{{ route($isAr ? 'areas.show' : 'en.areas.show', $slug) }}" class="eq8-pill eq8-pill--link">{{ $displayName }}</a>
                    @else
                        <span class="eq8-pill">{{ $displayName }}</span>
                    @endif
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        <div class="eq8-areas__banner" data-gov-reveal style="transition-delay: 490ms">
            <p class="eq8-areas__banner-text">{{ $isAr
                ? 'لا تجد منطقتك؟ تواصل معنا وسنصلك أينما كنت في الكويت'
                : "Can't find your area? Contact us and we'll reach you anywhere in Kuwait" }}</p>
            <a href="{{ \App\Helpers\WhatsAppHelper::url() }}" target="_blank" rel="noopener" class="eq8-areas__banner-btn">
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.116 1.528 5.845L0 24l6.335-1.505A11.946 11.946 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.882a9.872 9.872 0 01-5.031-1.378l-.361-.214-3.741.981.999-3.648-.235-.374A9.869 9.869 0 012.118 12C2.118 6.963 6.963 2.118 12 2.118s9.882 4.845 9.882 9.882-4.845 9.882-9.882 9.882z"/>
                </svg>
                {{ $isAr ? 'تواصل عبر واتساب 📲' : 'Contact via WhatsApp 📲' }}
            </a>
        </div>

    </div>
</section>

<style>
.eq8-areas {
    padding: 64px 0;
    background: var(--altBg);
    transition: background .3s ease;
}
.eq8-areas__grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    align-items: start;
}
@media (max-width: 900px) { .eq8-areas__grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 540px) { .eq8-areas__grid { grid-template-columns: 1fr; } }

.eq8-gov-card {
    background: var(--cardBg);
    border: 1px solid var(--border);
    border-radius: 14px;
    overflow: visible;
    opacity: 0;
    transform: translateY(18px);
    transition: opacity .45s ease, transform .45s ease, border-color .2s ease, box-shadow .2s ease;
    font-family: 'Cairo', system-ui, sans-serif;
}
.eq8-gov-card.revealed { opacity: 1; transform: translateY(0); }
.eq8-gov-card:hover {
    border-color: var(--accent);
    box-shadow: 0 8px 28px rgba(107,58,23,.12);
    transform: translateY(-3px);
}
.eq8-gov-card.revealed:hover { transform: translateY(-3px); }

.eq8-gov-card__head {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 16px 18px 12px;
}
.eq8-gov-card__pin { font-size: 18px; line-height: 1; flex-shrink: 0; }
.eq8-gov-card__name {
    font-size: 1rem;
    font-weight: 700;
    color: var(--primary);
    margin: 0;
}
.eq8-gov-card__divider {
    height: 1px;
    background: var(--border);
    margin: 0 18px 2px;
}
.eq8-gov-card__pills {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    padding: 10px 18px 18px;
}
.eq8-pill {
    display: inline-flex;
    align-items: center;
    background: var(--altBg);
    color: var(--body);
    border: 1px solid var(--border);
    border-radius: 999px;
    padding: 3px 12px;
    font-size: .78rem;
    font-weight: 600;
    white-space: nowrap;
    font-family: 'Cairo', system-ui, sans-serif;
    transition: background .18s ease, color .18s ease, border-color .18s ease;
}
.eq8-pill--link {
    text-decoration: none;
    color: var(--primary);
    background: var(--accentTint);
    border-color: var(--accentTint);
}
.eq8-pill--link:hover {
    background: var(--primary);
    color: #fff;
    border-color: var(--primary);
}

.eq8-areas__banner {
    background: linear-gradient(135deg, #43230E 0%, #6B3A17 100%);
    border-radius: 14px;
    margin-top: 32px;
    padding: 36px 24px;
    text-align: center;
    color: #fff;
    font-family: 'Cairo', system-ui, sans-serif;
    opacity: 0;
    transform: translateY(18px);
    transition: opacity .45s ease, transform .45s ease;
}
.eq8-areas__banner.revealed { opacity: 1; transform: translateY(0); }
.eq8-areas__banner-text {
    font-size: 1.05rem;
    font-weight: 700;
    margin: 0 0 20px;
    color: #F3D9BB;
}
.eq8-areas__banner-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #25D366;
    color: #fff;
    border-radius: 12px;
    padding: 12px 28px;
    font-size: .95rem;
    font-weight: 700;
    text-decoration: none;
    transition: background .2s ease, transform .2s ease;
    font-family: 'Cairo', system-ui, sans-serif;
}
.eq8-areas__banner-btn:hover { background: #20ba58; transform: translateY(-2px); }
</style>

<script>
(function () {
    var cards = document.querySelectorAll('[data-gov-reveal]');
    if (!cards.length) return;
    if (!window.IntersectionObserver) {
        cards.forEach(function (c) { c.classList.add('revealed'); });
        return;
    }
    var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (e) {
            if (e.isIntersecting) { e.target.classList.add('revealed'); io.unobserve(e.target); }
        });
    }, { threshold: 0.06 });
    cards.forEach(function (c) { io.observe(c); });
})();
</script>
