<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="@yield('robots', 'index, follow')">
    <meta name="theme-color" content="#6B3A17">

    <title>@yield('meta_title', __('site.default_meta_title'))</title>
    <meta name="description" content="@yield('meta_description', __('site.default_meta_desc'))">
    <link rel="canonical" href="{{ url()->current() }}">

    <link rel="alternate" hreflang="ar" href="{{ url('/') }}">
    <link rel="alternate" hreflang="en" href="{{ url('/en') }}">
    <link rel="alternate" hreflang="x-default" href="{{ url('/') }}">

    {{-- Favicon (DB setting overrides static file) --}}
    @php $faviconUrl = \App\Models\SiteSetting::get('favicon_url') ?: asset('favicon.ico'); @endphp
    <link rel="icon" type="image/x-icon" href="{{ $faviconUrl }}">
    <link rel="apple-touch-icon" href="{{ \App\Models\SiteSetting::get('logo_url') ?: asset('apple-touch-icon.png') }}">
    <link rel="sitemap" type="application/xml" href="/sitemap.xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Open Graph --}}
    @php $ogImage = \App\Models\SiteSetting::get('hero_image_url') ?: asset('images/og-default.jpg'); @endphp
    <meta property="og:title"       content="@yield('meta_title', __('site.default_meta_title'))">
    <meta property="og:description" content="@yield('meta_description', __('site.default_meta_desc'))">
    <meta property="og:image"       content="@yield('og_image', $ogImage)">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:url"         content="{{ url()->current() }}">
    <meta property="og:type"        content="website">
    <meta property="og:locale"      content="{{ app()->getLocale() === 'ar' ? 'ar_KW' : 'en_US' }}">

    {{-- Twitter Card --}}
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="@yield('meta_title', __('site.default_meta_title'))">
    <meta name="twitter:description" content="@yield('meta_description', __('site.default_meta_desc'))">
    <meta name="twitter:image"       content="@yield('og_image', $ogImage)">

    @yield('schema_markup')

    {{-- Apply saved theme before first paint to avoid flash --}}
    <script>
        (function(){
            var s = localStorage.getItem('eq8-theme');
            if (s) { document.documentElement.setAttribute('data-theme', s); return; }
            if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                document.documentElement.setAttribute('data-theme', 'dark');
            }
        })();
    </script>
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="eq8-body antialiased">
<style>
:root {
    --bg:        #FAF6F1;
    --headerBg:  #FFFFFF;
    --border:    #E7DCCC;
    --cardBg:    #FFFFFF;
    --altBg:     #F2E9DE;
    --text:      #2B211A;
    --muted:     #7A6A5C;
    --body:      #5A4C40;
    --primary:   #6B3A17;
    --primaryDk: #43230E;
    --accent:    #D97B2E;
    --accentTint:#F3D9BB;
    --wa:        #25D366;
    --footerBg:  #241A12;
}
@media (prefers-color-scheme: dark) {
    :root {
        --bg:       #1C140D;
        --headerBg: #241A11;
        --border:   #4A3826;
        --cardBg:   #2C2013;
        --altBg:    #221808;
        --text:     #F3E9DC;
        --muted:    #C4AD95;
        --body:     #D8C7B4;
    }
}
:root[data-theme="light"] {
    --bg:        #FAF6F1;
    --headerBg:  #FFFFFF;
    --border:    #E7DCCC;
    --cardBg:    #FFFFFF;
    --altBg:     #F2E9DE;
    --text:      #2B211A;
    --muted:     #7A6A5C;
    --body:      #5A4C40;
}
:root[data-theme="dark"] {
    --bg:       #1C140D;
    --headerBg: #241A11;
    --border:   #4A3826;
    --cardBg:   #2C2013;
    --altBg:    #221808;
    --text:     #F3E9DC;
    --muted:    #C4AD95;
    --body:     #D8C7B4;
}
.eq8-body {
    background: var(--bg);
    color: var(--text);
    font-family: 'Cairo', 'Inter', system-ui, sans-serif;
    transition: background 0.3s ease, color 0.3s ease;
}
</style>

    @include('partials.nav')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    {{-- Floating WhatsApp Button --}}
    <a href="https://wa.me/{{ \App\Models\SiteSetting::get('whatsapp_number') }}?text={{ urlencode(app()->getLocale() === 'ar' ? 'مرحباً، أريد الاستفسار عن خدمات الكهرباء' : 'Hello, I would like to inquire about electrical services') }}"
       target="_blank"
       aria-label="WhatsApp"
       class="fixed bottom-6 {{ app()->getLocale() === 'ar' ? 'left-6' : 'right-6' }} z-50 text-white rounded-full p-4 shadow-xl transition hover:scale-110" style="background:#25D366" onmouseover="this.style.background='#20ba58'" onmouseout="this.style.background='#25D366'">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
            <path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.116 1.528 5.845L0 24l6.335-1.505A11.946 11.946 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.882a9.872 9.872 0 01-5.031-1.378l-.361-.214-3.741.981.999-3.648-.235-.374A9.869 9.869 0 012.118 12C2.118 6.963 6.963 2.118 12 2.118s9.882 4.845 9.882 9.882-4.845 9.882-9.882 9.882z"/>
        </svg>
    </a>

    @livewireScripts

    {{-- Analytics tracker --}}
    @unless(str_starts_with(request()->path(), 'admin'))
    <script>
    (function () {
        var COOKIE = '{{ config('analytics.visitor_cookie_name', '_vid') }}';
        var SESSION_KEY = '{{ config('analytics.session_storage_key', '_sid') }}';
        var COLLECT = '{{ route('analytics.collect') }}';
        var CSRF = document.querySelector('meta[name="csrf-token"]')?.content || '';

        function uuid() {
            return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
                var r = Math.random() * 16 | 0, v = c === 'x' ? r : (r & 0x3 | 0x8);
                return v.toString(16);
            });
        }

        function getCookie(name) {
            var m = document.cookie.match('(^|;)\\s*' + name + '\\s*=\\s*([^;]+)');
            return m ? m.pop() : null;
        }

        function setCookie(name, value, days) {
            var d = new Date();
            d.setTime(d.getTime() + days * 864e5);
            document.cookie = name + '=' + value + ';expires=' + d.toUTCString() + ';path=/;SameSite=Lax';
        }

        var visitorId = getCookie(COOKIE);
        if (!visitorId) {
            visitorId = uuid();
            setCookie(COOKIE, visitorId, 365);
        }

        var sessionId = sessionStorage.getItem(SESSION_KEY);
        if (!sessionId) {
            sessionId = uuid();
            sessionStorage.setItem(SESSION_KEY, sessionId);
        }

        function utmParams() {
            var p = new URLSearchParams(location.search);
            var u = {};
            ['source','medium','campaign','term','content'].forEach(function (k) {
                var v = p.get('utm_' + k);
                if (v) u[k] = v;
            });
            return Object.keys(u).length ? u : null;
        }

        function deviceType() {
            var ua = navigator.userAgent.toLowerCase();
            if (/ipad|tablet/.test(ua)) return 'tablet';
            if (/mobile|iphone|ipod|android|blackberry|opera mini|iemobile/.test(ua)) return 'mobile';
            return 'desktop';
        }

        function send(eventName, extra) {
            var payload = Object.assign({
                event_name:  eventName,
                page_type:   (window.analyticsContext && window.analyticsContext.pageType) || 'page',
                route_name:  (window.analyticsContext && window.analyticsContext.routeName) || null,
                locale:      document.documentElement.lang || 'ar',
                device_type: deviceType(),
                visitor_id:  visitorId,
                session_id:  sessionId,
                url:         location.href,
                path:        location.pathname,
                referrer:    document.referrer || null,
                utm:         utmParams(),
            }, extra || {});

            fetch(COLLECT, {
                method:  'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
                body:    JSON.stringify(payload),
                keepalive: true,
            }).catch(function () {});
        }

        // Page view
        send('page_view');

        // WhatsApp click
        document.querySelectorAll('a[href*="wa.me"]').forEach(function (el) {
            el.addEventListener('click', function () { send('whatsapp_click', { placement: 'floating_button' }); });
        });

        // Phone click
        document.querySelectorAll('a[href^="tel:"]').forEach(function (el) {
            el.addEventListener('click', function () { send('phone_click'); });
        });

        // Contact form submit — fired from Livewire event
        document.addEventListener('livewire:contact-sent', function () {
            send('contact_form_submit', { message_length: 0 });
        });

        // Scroll depth
        var fired = {};
        window.addEventListener('scroll', function () {
            var pct = Math.round((window.scrollY + window.innerHeight) / document.body.scrollHeight * 100);
            [25, 50, 75, 100].forEach(function (d) {
                if (pct >= d && !fired[d]) {
                    fired[d] = true;
                    send('scroll_depth', { scroll_percentage: d });
                }
            });
        }, { passive: true });

        // Expose send() globally for use in Blade/Alpine
        window.analyticsTrack = send;
    })();
    </script>
    @endunless
</body>
</html>
