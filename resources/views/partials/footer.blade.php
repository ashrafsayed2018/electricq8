@php
    $footerLocale = app()->getLocale();
    $footerIsAr   = $footerLocale === 'ar';
    $footerPrefix = $footerIsAr ? '' : 'en.';
    $footerPhone  = \App\Models\SiteSetting::get('phone_number');
    $footerEmail  = \App\Models\SiteSetting::get('email');
@endphp
<footer class="bg-gray-900 text-gray-300 py-14 mt-16" dir="{{ $footerIsAr ? 'rtl' : 'ltr' }}">
    <div class="container mx-auto px-4">

        <div class="grid grid-cols-2 lg:grid-cols-5 gap-8 mb-10 text-sm">

            {{-- ── Col 1: Brand ── --}}
            <div class="col-span-2 lg:col-span-1">
                <p class="font-bold text-white text-lg mb-3">
                    {{ \App\Models\SiteSetting::get('site_name_' . $footerLocale) }}
                </p>
                <p class="text-gray-400 leading-relaxed text-xs mb-4">
                    {{ $footerIsAr
                        ? 'متخصصون في خدمات الكهرباء في الكويت — تمديدات وصيانة وتصليح شورت وتركيب إضاءة.'
                        : 'Specialists in electrical services in Kuwait — wiring, maintenance, short circuit repair and lighting.' }}
                </p>
                {{-- Contact --}}
                @if($footerPhone)
                <a href="tel:{{ $footerPhone }}"
                   class="flex items-center gap-2 text-xs text-gray-400 hover:text-white transition mb-1.5">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    <span dir="ltr">{{ $footerPhone }}</span>
                </a>
                @endif
                @if($footerEmail)
                <a href="mailto:{{ $footerEmail }}"
                   class="flex items-center gap-2 text-xs text-gray-400 hover:text-white transition mb-3">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span dir="ltr">{{ $footerEmail }}</span>
                </a>
                @endif
                {{-- Social --}}
                <div class="flex items-center gap-3 mt-1">
                    @if(\App\Models\SiteSetting::get('instagram_url'))
                    <a href="{{ \App\Models\SiteSetting::get('instagram_url') }}" target="_blank" rel="noopener"
                       class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:text-pink-400 hover:bg-gray-700 transition text-xs font-bold"
                       aria-label="Instagram">IG</a>
                    @endif
                    @if(\App\Models\SiteSetting::get('snapchat_url'))
                    <a href="{{ \App\Models\SiteSetting::get('snapchat_url') }}" target="_blank" rel="noopener"
                       class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:text-yellow-300 hover:bg-gray-700 transition text-xs font-bold"
                       aria-label="Snapchat">SC</a>
                    @endif
                    @if(\App\Models\SiteSetting::get('tiktok_url'))
                    <a href="{{ \App\Models\SiteSetting::get('tiktok_url') }}" target="_blank" rel="noopener"
                       class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center text-gray-400 hover:text-white hover:bg-gray-700 transition text-xs font-bold"
                       aria-label="TikTok">TK</a>
                    @endif
                </div>
            </div>

            {{-- ── Col 2: Services ── --}}
            <div>
                <p class="font-bold text-white mb-3 text-sm">{{ $footerIsAr ? 'الخدمات' : 'Services' }}</p>
                <ul class="space-y-2 text-gray-400 text-xs">
                    @php
                    $footerServices = $footerIsAr ? [
                        'كهربائي منازل بالكويت',
                        'تصليح شورت الكهرباء',
                        'تمديدات كهربائية',
                        'تركيب لوحة كهربائية',
                        'تركيب سبوت لايت وإضاءة',
                        'كهربائي طوارئ 24 ساعة',
                    ] : [
                        'Home Electrician in Kuwait',
                        'Short Circuit Repair',
                        'Electrical Wiring',
                        'Electrical Panel Installation',
                        'Spotlight & Lighting Installation',
                        '24/7 Emergency Electrician',
                    ];
                    @endphp
                    @foreach($footerServices as $svc)
                    <li>
                        <a href="{{ route($footerPrefix . 'services.index') }}"
                           class="hover:text-white transition">{{ $svc }}</a>
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- ── Col 3: Areas ── --}}
            <div>
                <p class="font-bold text-white mb-3 text-sm">{{ $footerIsAr ? 'مناطق الخدمة' : 'Service Areas' }}</p>
                <ul class="space-y-2 text-gray-400 text-xs">
                    @php
                    $footerAreas = $footerIsAr ? [
                        'العاصمة','حولي','الفروانية','الجهراء','الأحمدي','مبارك الكبير',
                    ] : [
                        'Capital','Hawalli','Farwaniya','Jahra','Ahmadi','Mubarak Al-Kabeer',
                    ];
                    @endphp
                    @foreach($footerAreas as $area)
                    <li>
                        <a href="{{ route($footerPrefix . 'areas.index') }}"
                           class="hover:text-white transition">{{ $area }}</a>
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- ── Col 4: Quick Links ── --}}
            <div>
                <p class="font-bold text-white mb-3 text-sm">{{ $footerIsAr ? 'روابط سريعة' : 'Quick Links' }}</p>
                <ul class="space-y-2 text-gray-400 text-xs">
                    <li><a href="{{ route($footerPrefix . 'home') }}"          class="hover:text-white transition">{{ $footerIsAr ? 'الرئيسية' : 'Home' }}</a></li>
                    <li><a href="{{ route($footerPrefix . 'about') }}"          class="hover:text-white transition">{{ $footerIsAr ? 'من نحن' : 'About Us' }}</a></li>
                    <li><a href="{{ route($footerPrefix . 'posts.index') }}"    class="hover:text-white transition">{{ $footerIsAr ? 'المدونة' : 'Blog' }}</a></li>
                    <li><a href="{{ route($footerPrefix . 'contact') }}"        class="hover:text-white transition">{{ $footerIsAr ? 'تواصل معنا' : 'Contact' }}</a></li>
                </ul>
            </div>

            {{-- ── Col 5: Legal + Hours ── --}}
            <div>
                <p class="font-bold text-white mb-3 text-sm">{{ $footerIsAr ? 'معلومات' : 'Information' }}</p>
                <ul class="space-y-2 text-gray-400 text-xs mb-5">
                    <li><a href="{{ route('privacy') }}" class="hover:text-white transition">{{ $footerIsAr ? 'سياسة الخصوصية' : 'Privacy Policy' }}</a></li>
                    <li><a href="{{ route('privacy') }}" class="hover:text-white transition">{{ $footerIsAr ? 'الشروط والأحكام' : 'Terms of Service' }}</a></li>
                    <li><a href="/sitemap.xml"           class="hover:text-white transition">Sitemap</a></li>
                </ul>
                {{-- Hours block --}}
                <div class="bg-gray-800 rounded-xl p-3 text-xs">
                    <p class="text-white font-bold mb-1">{{ $footerIsAr ? 'ساعات العمل' : 'Working Hours' }}</p>
                    <p class="text-green-400 font-semibold">{{ $footerIsAr ? 'السبت – الجمعة' : 'Sat – Fri' }}</p>
                    <p class="text-gray-300">{{ $footerIsAr ? '24 ساعة / 7 أيام' : '24 Hours / 7 Days' }}</p>
                    <p class="text-yellow-400 text-xs mt-1">{{ $footerIsAr ? '⚡ خدمة طوارئ متاحة دائمًا' : '⚡ Emergency always available' }}</p>
                </div>
            </div>

        </div>

        {{-- Bottom bar --}}
        <div class="border-t border-gray-700 pt-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-gray-500">
            <span>&copy; 2025 ElectricQ8. {{ $footerIsAr ? 'جميع الحقوق محفوظة.' : 'All rights reserved.' }} {{ $footerIsAr ? 'فني متاح الآن' : 'Technician available now' }}</span>
            <span class="flex items-center gap-1">
                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse inline-block"></span>
                {{ $footerIsAr ? 'فني متاح الآن' : 'Technician available now' }}
            </span>
        </div>

    </div>
</footer>
