@php
    $isAr  = app()->getLocale() === 'ar';
    $phone = \App\Models\SiteSetting::get('phone_number');
    $waUrl = \App\Helpers\WhatsAppHelper::url();
@endphp

<div class="eq8-sticky-bar" id="eq8StickyBar"
     dir="{{ $isAr ? 'rtl' : 'ltr' }}"
     aria-hidden="true"
     role="region"
     aria-label="{{ $isAr ? 'تواصل سريع' : 'Quick contact' }}">

    <span class="eq8-sticky-bar__site">ElectricQ8 |</span>

    <a href="{{ $waUrl }}" target="_blank" rel="noopener"
       class="eq8-sticky-btn eq8-sticky-btn--wa"
       onclick="window.analyticsTrack&&analyticsTrack('whatsapp_click',{placement:'sticky_bar'})">
        <svg fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.116 1.528 5.845L0 24l6.335-1.505A11.946 11.946 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.882a9.872 9.872 0 01-5.031-1.378l-.361-.214-3.741.981.999-3.648-.235-.374A9.869 9.869 0 012.118 12C2.118 6.963 6.963 2.118 12 2.118s9.882 4.845 9.882 9.882-4.845 9.882-9.882 9.882z"/>
        </svg>
        {{ $isAr ? 'احجز الآن' : 'WhatsApp' }}
    </a>

    <a href="tel:{{ $phone }}"
       class="eq8-sticky-btn eq8-sticky-btn--call"
       onclick="window.analyticsTrack&&analyticsTrack('phone_click',{placement:'sticky_bar'})">
        <svg fill="none" stroke="currentColor" stroke-width="2.2"
             stroke-linecap="round" stroke-linejoin="round"
             viewBox="0 0 24 24" aria-hidden="true">
            <path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
        </svg>
        {{ $isAr ? 'اتصل بنا' : 'Call Now' }}
    </a>
</div>

<style>
.eq8-sticky-bar {
    position: fixed;
    bottom: 0; left: 0; right: 0;
    z-index: 800;
    background: #1a1008;
    border-top: 1px solid rgba(255,255,255,.1);
    padding: 10px 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transform: translateY(100%);
    transition: transform .35s cubic-bezier(.4,0,.2,1);
    box-shadow: 0 -4px 24px rgba(0,0,0,.35);
}
.eq8-sticky-bar--visible {
    transform: translateY(0);
}
.eq8-sticky-bar__site {
    font-family: 'Cairo', system-ui, sans-serif;
    font-size: .78rem;
    font-weight: 700;
    color: rgba(255,255,255,.45);
    white-space: nowrap;
    display: none;
}
@media (min-width: 500px) { .eq8-sticky-bar__site { display: block; } }

.eq8-sticky-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-family: 'Cairo', system-ui, sans-serif;
    font-weight: 800;
    font-size: .88rem;
    padding: 10px 22px;
    border-radius: 999px;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: opacity .18s ease, transform .18s ease;
    white-space: nowrap;
}
.eq8-sticky-btn:hover { opacity: .88; transform: scale(1.03); }
.eq8-sticky-btn svg   { width: 18px; height: 18px; flex-shrink: 0; }

.eq8-sticky-btn--wa   { background: #25D366; color: #fff; }
.eq8-sticky-btn--call {
    background: transparent;
    color: #fff;
    border: 2px solid rgba(255,255,255,.45);
}
.eq8-sticky-btn--call:hover { border-color: #fff; }
</style>

<script>
(function () {
    var bar   = document.getElementById('eq8StickyBar');
    if (!bar) return;

    // On the home page, wait until the hero scrolls out of view.
    // On every other page, show after the user scrolls down 300 px.
    var hero  = document.querySelector('.eq8-page-hero, .eq8-hero');
    var shown = false;

    function show() {
        if (shown) return;
        shown = true;
        bar.classList.add('eq8-sticky-bar--visible');
        bar.removeAttribute('aria-hidden');
    }
    function hide() {
        if (!shown) return;
        shown = false;
        bar.classList.remove('eq8-sticky-bar--visible');
        bar.setAttribute('aria-hidden', 'true');
    }

    function check() {
        if (hero) {
            hero.getBoundingClientRect().bottom < 0 ? show() : hide();
        } else {
            window.scrollY > 300 ? show() : hide();
        }
    }

    window.addEventListener('scroll', check, { passive: true });
    check(); // run once on load in case page is already scrolled
})();
</script>
