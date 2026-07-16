@php
    $footerLocale = app()->getLocale();
    $footerIsAr   = $footerLocale === 'ar';
    $footerPrefix = $footerIsAr ? '' : 'en.';
    $footerPhone  = \App\Models\SiteSetting::get('phone_number');
    $footerEmail  = \App\Models\SiteSetting::get('email');
@endphp
<footer class="eq8-footer" dir="{{ $footerIsAr ? 'rtl' : 'ltr' }}">
    <div class="eq8-footer__inner">

        <div class="eq8-footer__cols">

            {{-- Brand --}}
            <div class="eq8-footer__brand">
                <p class="eq8-footer__logo">⚡ ElectricQ8</p>
                <p class="eq8-footer__tagline">
                    {{ $footerIsAr
                        ? 'متخصصون في خدمات الكهرباء في الكويت — تمديدات وصيانة وتصليح شورت وتركيب إضاءة.'
                        : 'Specialists in electrical services in Kuwait — wiring, maintenance, short circuit repair and lighting.' }}
                </p>
                @if($footerPhone)
                <a href="tel:{{ $footerPhone }}" class="eq8-footer__contact-link">
                    <svg class="eq8-footer__icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    <span dir="ltr">{{ $footerPhone }}</span>
                </a>
                @endif
                @if($footerEmail)
                <a href="mailto:{{ $footerEmail }}" class="eq8-footer__contact-link">
                    <svg class="eq8-footer__icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span dir="ltr">{{ $footerEmail }}</span>
                </a>
                @endif
                <div class="eq8-footer__socials">
                    @if(\App\Models\SiteSetting::get('instagram_url'))
                    <a href="{{ \App\Models\SiteSetting::get('instagram_url') }}" target="_blank" rel="noopener"
                       class="eq8-footer__social" aria-label="Instagram">IG</a>
                    @endif
                    @if(\App\Models\SiteSetting::get('snapchat_url'))
                    <a href="{{ \App\Models\SiteSetting::get('snapchat_url') }}" target="_blank" rel="noopener"
                       class="eq8-footer__social" aria-label="Snapchat">SC</a>
                    @endif
                    @if(\App\Models\SiteSetting::get('tiktok_url'))
                    <a href="{{ \App\Models\SiteSetting::get('tiktok_url') }}" target="_blank" rel="noopener"
                       class="eq8-footer__social" aria-label="TikTok">TK</a>
                    @endif
                </div>
            </div>

            {{-- Services --}}
            <div>
                <p class="eq8-footer__col-title">{{ $footerIsAr ? 'الخدمات' : 'Services' }}</p>
                <ul class="eq8-footer__list">
                    @php
                    $footerServices = $footerIsAr ? [
                        'كهربائي منازل بالكويت','تصليح شورت الكهرباء','تمديدات كهربائية',
                        'تركيب لوحة كهربائية','تركيب سبوت لايت وإضاءة','كهربائي طوارئ 24 ساعة',
                    ] : [
                        'Home Electrician in Kuwait','Short Circuit Repair','Electrical Wiring',
                        'Electrical Panel Installation','Spotlight & Lighting Installation','24/7 Emergency Electrician',
                    ];
                    @endphp
                    @foreach($footerServices as $svc)
                    <li><a href="{{ route($footerPrefix . 'services.index') }}" class="eq8-footer__link">{{ $svc }}</a></li>
                    @endforeach
                </ul>
            </div>

            {{-- Areas --}}
            <div>
                <p class="eq8-footer__col-title">{{ $footerIsAr ? 'مناطق الخدمة' : 'Service Areas' }}</p>
                <ul class="eq8-footer__list">
                    @php
                    $footerAreas = $footerIsAr
                        ? ['العاصمة','حولي','الفروانية','الجهراء','الأحمدي','مبارك الكبير']
                        : ['Capital','Hawalli','Farwaniya','Jahra','Ahmadi','Mubarak Al-Kabeer'];
                    @endphp
                    @foreach($footerAreas as $area)
                    <li><a href="{{ route($footerPrefix . 'areas.index') }}" class="eq8-footer__link">{{ $area }}</a></li>
                    @endforeach
                </ul>
            </div>

            {{-- Quick Links --}}
            <div>
                <p class="eq8-footer__col-title">{{ $footerIsAr ? 'روابط سريعة' : 'Quick Links' }}</p>
                <ul class="eq8-footer__list">
                    <li><a href="{{ route($footerPrefix . 'home') }}"       class="eq8-footer__link">{{ $footerIsAr ? 'الرئيسية' : 'Home' }}</a></li>
                    <li><a href="{{ route($footerPrefix . 'about') }}"       class="eq8-footer__link">{{ $footerIsAr ? 'من نحن' : 'About Us' }}</a></li>
                    <li><a href="{{ route($footerPrefix . 'posts.index') }}" class="eq8-footer__link">{{ $footerIsAr ? 'المدونة' : 'Blog' }}</a></li>
                    <li><a href="{{ route($footerPrefix . 'contact') }}"     class="eq8-footer__link">{{ $footerIsAr ? 'تواصل معنا' : 'Contact' }}</a></li>
                </ul>
            </div>

            {{-- Info --}}
            <div>
                <p class="eq8-footer__col-title">{{ $footerIsAr ? 'معلومات' : 'Information' }}</p>
                <ul class="eq8-footer__list" style="margin-bottom:20px">
                    <li><a href="{{ route('privacy') }}" class="eq8-footer__link">{{ $footerIsAr ? 'سياسة الخصوصية' : 'Privacy Policy' }}</a></li>
                    <li><a href="{{ route('privacy') }}" class="eq8-footer__link">{{ $footerIsAr ? 'الشروط والأحكام' : 'Terms of Service' }}</a></li>
                    <li><a href="/sitemap.xml" class="eq8-footer__link">Sitemap</a></li>
                </ul>
                <div class="eq8-footer__hours">
                    <p class="eq8-footer__hours-title">{{ $footerIsAr ? 'ساعات العمل' : 'Working Hours' }}</p>
                    <p class="eq8-footer__hours-days">{{ $footerIsAr ? 'السبت – الجمعة' : 'Sat – Fri' }}</p>
                    <p class="eq8-footer__hours-time">{{ $footerIsAr ? '24 ساعة / 7 أيام' : '24 Hours / 7 Days' }}</p>
                    <p class="eq8-footer__hours-badge">⚡ {{ $footerIsAr ? 'خدمة طوارئ متاحة دائمًا' : 'Emergency always available' }}</p>
                </div>
            </div>

        </div>

        <div class="eq8-footer__bottom">
            <span>&copy; 2025 ElectricQ8. {{ $footerIsAr ? 'جميع الحقوق محفوظة.' : 'All rights reserved.' }}</span>
            <span class="eq8-footer__status">
                <span class="eq8-footer__pulse"></span>
                {{ $footerIsAr ? 'فني متاح الآن' : 'Technician available now' }}
            </span>
        </div>

    </div>
</footer>

<style>
.eq8-footer {
    background: #241A12;
    color: #C4AD95;
    padding: 56px 0 0;
    margin-top: 0;
    font-family: 'Cairo', system-ui, sans-serif;
}
.eq8-footer__inner {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}
.eq8-footer__cols {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1fr 1fr;
    gap: 40px;
    margin-bottom: 40px;
}
@media (max-width: 1024px) {
    .eq8-footer__cols { grid-template-columns: 1fr 1fr 1fr; }
    .eq8-footer__brand { grid-column: 1 / -1; }
}
@media (max-width: 640px) {
    .eq8-footer__cols { grid-template-columns: 1fr 1fr; }
}
.eq8-footer__logo {
    font-size: 1.2rem;
    font-weight: 800;
    color: #F3D9BB;
    margin: 0 0 10px;
}
.eq8-footer__tagline {
    font-size: .8rem;
    color: #9A8070;
    line-height: 1.7;
    margin: 0 0 16px;
}
.eq8-footer__contact-link {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: .8rem;
    color: #9A8070;
    text-decoration: none;
    margin-bottom: 8px;
    transition: color .18s;
}
.eq8-footer__contact-link:hover { color: #F3D9BB; }
.eq8-footer__icon { width: 14px; height: 14px; flex-shrink: 0; }
.eq8-footer__socials { display: flex; gap: 10px; margin-top: 14px; }
.eq8-footer__social {
    width: 32px; height: 32px;
    border-radius: 50%;
    background: #3A2518;
    color: #9A8070;
    display: flex; align-items: center; justify-content: center;
    font-size: .7rem; font-weight: 700;
    text-decoration: none;
    transition: background .18s, color .18s;
}
.eq8-footer__social:hover { background: var(--accent, #D97B2E); color: #fff; }

.eq8-footer__col-title {
    font-size: .85rem;
    font-weight: 700;
    color: #F3D9BB;
    margin: 0 0 14px;
}
.eq8-footer__list {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.eq8-footer__link {
    font-size: .8rem;
    color: #9A8070;
    text-decoration: none;
    transition: color .18s;
}
.eq8-footer__link:hover { color: #F3D9BB; }

.eq8-footer__hours {
    background: #3A2518;
    border-radius: 12px;
    padding: 14px;
}
.eq8-footer__hours-title { font-size: .8rem; font-weight: 700; color: #F3D9BB; margin: 0 0 6px; }
.eq8-footer__hours-days  { font-size: .78rem; font-weight: 600; color: #4ADE80; margin: 0 0 2px; }
.eq8-footer__hours-time  { font-size: .78rem; color: #C4AD95; margin: 0 0 6px; }
.eq8-footer__hours-badge { font-size: .75rem; color: var(--accent, #D97B2E); margin: 0; }

.eq8-footer__bottom {
    border-top: 1px solid #3A2518;
    padding: 20px 0 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    font-size: .75rem;
    color: #6B5545;
    flex-wrap: wrap;
}
.eq8-footer__status { display: flex; align-items: center; gap: 6px; }
.eq8-footer__pulse {
    width: 8px; height: 8px;
    border-radius: 50%;
    background: #4ADE80;
    animation: footerPulse 2s ease-in-out infinite;
    flex-shrink: 0;
}
@keyframes footerPulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: .6; transform: scale(.85); }
}
</style>
