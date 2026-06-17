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

// Build a lookup: governorate → [ arabic-name => route-slug ]
// so we can make pills clickable when a DB record exists.
$dbLookup = [];
foreach ($locations as $loc) {
    $arName = $loc->getTranslation('name', 'ar');
    $slug   = $loc->getTranslation('slug', $lang);
    $dbLookup[$loc->governorate][$arName] = $slug;
}
@endphp

{{-- ─────────────────────────────────────────────────────────────
     مناطق الخدمة — Service Areas section
───────────────────────────────────────────────────────────────── --}}
<style>
/* ── section wrapper ───────────────────────────────────────── */
.areas-section {
    padding: 64px 0;
    background: #f8fafc;
    direction: rtl;
}
.areas-section.ltr {
    direction: ltr;
}

/* ── heading ────────────────────────────────────────────────── */
.areas-heading {
    text-align: center;
    margin-bottom: 48px;
}
.areas-heading h2 {
    font-size: 2rem;
    font-weight: 800;
    color: #111827;
    margin: 0 0 10px;
    font-family: 'Cairo', sans-serif;
}
.areas-heading p {
    font-size: 1rem;
    color: #6b7280;
    margin: 0;
    font-family: 'Cairo', sans-serif;
}

/* ── grid ───────────────────────────────────────────────────── */
.areas-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
    grid-auto-rows: auto;       /* NEVER fixed row height */
    align-items: start;         /* cards don't stretch to match tallest */
}
@media (max-width: 768px) {
    .areas-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 480px) {
    .areas-grid { grid-template-columns: 1fr; }
}

/* ── card ───────────────────────────────────────────────────── */
.gov-card {
    background: #ffffff;
    border-radius: 16px;
    border-right: 4px solid #1a3ae0;  /* RTL: right = visual start */
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    height: auto;
    min-height: unset;
    overflow: visible;              /* NEVER hidden */
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.45s ease, transform 0.45s ease,
                box-shadow 0.25s ease;
    font-family: 'Cairo', sans-serif;
}
.gov-card.ltr {
    border-right: none;
    border-left: 4px solid #1a3ae0;
}
.gov-card.revealed {
    opacity: 1;
    transform: translateY(0);
}
.gov-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 28px rgba(26,58,224,0.15);
}
.gov-card.revealed:hover {
    transform: translateY(-4px);
}

/* ── card header ────────────────────────────────────────────── */
.gov-card-header {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 18px 20px 14px;
}
.gov-card-header h3 {
    font-size: 18px;
    font-weight: 700;
    color: #1a3ae0;
    margin: 0;
}
.gov-divider {
    height: 1px;
    background: #e5e7eb;
    margin: 0 20px 4px;
}

/* ── pills container ────────────────────────────────────────── */
.areas-pills {
    display: flex;
    flex-wrap: wrap;            /* REQUIRED — pills wrap to new lines */
    gap: 8px;
    padding: 12px 20px 20px;
}

/* ── individual pill ────────────────────────────────────────── */
.area-pill {
    display: inline-flex;
    align-items: center;
    background: #eff3ff;
    color: #1a3ae0;
    border: 1px solid #c7d2fe;
    border-radius: 999px;
    padding: 4px 14px;
    font-size: 13px;
    font-weight: 600;
    white-space: nowrap;
    flex-shrink: 0;
    text-decoration: none;
    transition: background 0.2s ease, color 0.2s ease, border-color 0.2s ease;
    font-family: 'Cairo', sans-serif;
}
.area-pill:hover {
    background: #1a3ae0;
    color: #ffffff;
    border-color: #1a3ae0;
}

/* ── bottom banner ──────────────────────────────────────────── */
.areas-banner {
    background: #1a3ae0;
    border-radius: 16px;
    margin-top: 40px;
    padding: 36px 24px;
    text-align: center;
    color: #ffffff;
    font-family: 'Cairo', sans-serif;
}
.areas-banner p {
    font-size: 1.1rem;
    font-weight: 700;
    margin: 0 0 20px;
}
.areas-banner-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #ffffff;
    color: #1a3ae0;
    border: none;
    border-radius: 12px;
    padding: 12px 28px;
    font-size: 15px;
    font-weight: 700;
    text-decoration: none;
    transition: background 0.2s ease, color 0.2s ease;
    font-family: 'Cairo', sans-serif;
}
.areas-banner-btn:hover {
    background: #25d366;
    color: #ffffff;
}
</style>

<section
    class="areas-section{{ $isAr ? '' : ' ltr' }}"
    aria-label="{{ $isAr ? 'مناطق الخدمة في الكويت' : 'Service Areas in Kuwait' }}"
>
    <div class="container mx-auto px-4">

        {{-- Section heading --}}
        <div class="areas-heading">
            <h2>{{ $isAr ? 'مناطق الخدمة في الكويت' : 'Service Areas in Kuwait' }}</h2>
            <p>{{ $isAr
                ? 'نغطي جميع محافظات ومناطق الكويت — خدمة سريعة في موقعك'
                : 'We cover all governorates and areas of Kuwait — fast service at your location' }}</p>
        </div>

        {{-- 6 governorate cards --}}
        <div class="areas-grid">
            @foreach($governorates as $idx => $gov)
            @php
                $govName    = $gov[$lang] ?? $gov['ar'];
                $ariaText   = $gov[$isAr ? 'aria_ar' : 'aria_en'];
                $slugMap    = $dbLookup[$gov['key']] ?? [];  // arName => slug
                $delay      = $idx * 70;
            @endphp

            <div
                class="gov-card{{ $isAr ? '' : ' ltr' }}"
                data-gov-reveal
                style="transition-delay: {{ $delay }}ms"
                aria-label="{{ $ariaText }}"
                title="{{ $ariaText }}"
            >
                {{-- Header --}}
                <div class="gov-card-header">
                    <span aria-hidden="true" style="font-size:20px;line-height:1">📍</span>
                    <h3>{{ $govName }}</h3>
                </div>

                <div class="gov-divider"></div>

                {{-- Pills — always render the FULL static list.
                     If a DB record exists for that Arabic name, make it a link. --}}
                <div class="areas-pills">
                    @foreach($gov['areas']['ar'] as $arIdx => $arName)
                    @php
                        $displayName = $isAr ? $arName : ($gov['areas']['en'][$arIdx] ?? $arName);
                        $slug        = $slugMap[$arName] ?? null;
                    @endphp
                    @if($slug)
                        <a href="{{ route($isAr ? 'areas.show' : 'en.areas.show', $slug) }}" class="area-pill">{{ $displayName }}</a>
                    @else
                        <span class="area-pill">{{ $displayName }}</span>
                    @endif
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        {{-- Bottom banner --}}
        <div class="areas-banner" data-gov-reveal style="transition-delay: 490ms">
            <p>{{ $isAr
                ? 'لا تجد منطقتك؟ تواصل معنا وسنصلك أينما كنت في الكويت'
                : "Can't find your area? Contact us and we'll reach you anywhere in Kuwait" }}</p>
            <a
                href="{{ \App\Helpers\WhatsAppHelper::url() }}"
                target="_blank"
                rel="noopener"
                class="areas-banner-btn"
            >
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.116 1.528 5.845L0 24l6.335-1.505A11.946 11.946 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.882a9.872 9.882 0 01-5.031-1.378l-.361-.214-3.741.981.999-3.648-.235-.374A9.869 9.869 0 012.118 12C2.118 6.963 6.963 2.118 12 2.118s9.882 4.845 9.882 9.882-4.845 9.882-9.882 9.882z"/>
                </svg>
                {{ $isAr ? 'تواصل عبر واتساب 📲' : 'Contact via WhatsApp 📲' }}
            </a>
        </div>

    </div>
</section>

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
            if (e.isIntersecting) {
                e.target.classList.add('revealed');
                io.unobserve(e.target);
            }
        });
    }, { threshold: 0.06 });
    cards.forEach(function (c) { io.observe(c); });
})();
</script>
