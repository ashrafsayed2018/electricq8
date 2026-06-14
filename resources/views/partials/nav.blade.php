@php
$isAr    = app()->getLocale() === 'ar';
$prefix  = $isAr ? '' : 'en.';
$current = request()->route()?->getName() ?? '';

// Strip the "en." prefix for comparison so active detection works for both locales
$currentBase = str_replace('en.', '', $current);

$links = [
    ['route' => $prefix . 'home',           'base' => 'home',          'label' => __('site.nav.home')],
    ['route' => $prefix . 'services.index', 'base' => 'services.index','label' => __('site.nav.services')],
    ['route' => $prefix . 'areas.index',    'base' => 'areas.index',   'label' => __('site.nav.areas')],
    ['route' => $prefix . 'about',          'base' => 'about',         'label' => __('site.nav.about')],
    ['route' => $prefix . 'contact',        'base' => 'contact',       'label' => __('site.nav.contact')],
    ['route' => $prefix . 'posts.index',    'base' => 'posts.index',   'label' => __('site.nav.blog')],
];
@endphp

{{-- ── Navbar ──────────────────────────────────────────────────────── --}}
<nav
    class="site-nav"
    dir="{{ $isAr ? 'rtl' : 'ltr' }}"
    x-data="{ open: false }"
    @keydown.escape.window="open = false; $nextTick(() => $el.querySelector('.site-nav__hamburger')?.focus())"
>

    <div class="site-nav__inner">

        {{-- Logo --}}
        <a href="{{ route($prefix . 'home') }}" class="site-nav__logo" aria-label="ElectricQ8 — {{ $isAr ? 'الرئيسية' : 'Home' }}">
            <span class="site-nav__logo-icon">⚡</span>
            ElectricQ8
        </a>

        {{-- Desktop links (hidden on mobile) --}}
        <ul class="site-nav__links" role="list">
            @foreach($links as $link)
            @php
                $href    = route($link['route']);
                $isActive = $currentBase === $link['base'];
            @endphp
            <li>
                <a
                    href="{{ $href }}"
                    class="site-nav__link {{ $isActive ? 'nav-link--active' : '' }}"
                    @if($isActive) aria-current="page" @endif
                >
                    {{ $link['label'] }}
                </a>
            </li>
            @endforeach
        </ul>

        {{-- Right cluster: language toggle + hamburger --}}
        <div class="site-nav__actions">

            {{-- Language toggle --}}
            <livewire:language-switcher />

            {{-- Hamburger — mobile only --}}
            <button
                class="site-nav__hamburger"
                aria-label="{{ $isAr ? 'فتح القائمة' : 'Open menu' }}"
                :aria-expanded="open"
                @click="open = true"
            >
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.2"
                     stroke-linecap="round" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

    </div>

    {{-- ── Mobile drawer overlay ───────────────────────────────────── --}}
    {{-- Fixed overlay — does NOT push page content down --}}
    <div
        class="nav-drawer"
        data-dir="{{ $isAr ? 'rtl' : 'ltr' }}"
        :class="open ? 'nav-drawer--open' : ''"
        @click.self="document.activeElement?.blur(); open = false; $nextTick(() => $el.closest('nav').querySelector('.site-nav__hamburger')?.focus())"
        aria-hidden="true"
        x-bind:aria-hidden="!open"
    >
        {{-- Panel --}}
        <div class="nav-drawer__panel" role="dialog" aria-modal="true"
             :aria-label="'{{ $isAr ? 'القائمة الرئيسية' : 'Main menu' }}'">

            {{-- Drawer header --}}
            <div class="nav-drawer__header">
                <span class="site-nav__logo" style="font-size:1.1rem">⚡ ElectricQ8</span>
                <button
                    class="nav-drawer__close"
                    aria-label="{{ $isAr ? 'إغلاق القائمة' : 'Close menu' }}"
                    @click="$el.blur(); open = false; $nextTick(() => $el.closest('nav').querySelector('.site-nav__hamburger')?.focus())"
                >
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5"
                         stroke-linecap="round" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Drawer links --}}
            <ul class="nav-drawer__links" role="list">
                @foreach($links as $link)
                @php
                    $href     = route($link['route']);
                    $isActive = $currentBase === $link['base'];
                @endphp
                <li>
                    <a
                        href="{{ $href }}"
                        class="nav-drawer__link {{ $isActive ? 'nav-link--active' : '' }}"
                        @if($isActive) aria-current="page" @endif
                        @click="open = false"
                    >
                        {{ $link['label'] }}
                        @if($isActive)
                        <span class="nav-drawer__dot" aria-hidden="true"></span>
                        @endif
                    </a>
                </li>
                @endforeach
            </ul>

            {{-- Drawer footer: language toggle --}}
            <div class="nav-drawer__footer">
                <livewire:language-switcher />
            </div>

        </div>
    </div>

</nav>

<style>
/* ── Reset / tokens ────────────────────────────────────────────── */
:root {
    --nav-h:        64px;
    --nav-bg:       #ffffff;
    --nav-shadow:   0 1px 0 #e5e7eb, 0 2px 8px rgba(0,0,0,0.04);
    --nav-blue:     #ca8a04;
    --nav-active-bg:#fefce8;
    --nav-active-c: #ca8a04;
    --nav-text:     #374151;
    --nav-hover-c:  #ca8a04;
    --drawer-w:     280px;
    --drawer-bg:    #ffffff;
    --drawer-overlay: rgba(15,23,42,0.45);
    --radius:       10px;
    --font:         'Cairo', system-ui, sans-serif;
}

/* ── Navbar shell ──────────────────────────────────────────────── */
.site-nav {
    position: sticky;
    top: 0;
    z-index: 900;
    background: var(--nav-bg);
    box-shadow: var(--nav-shadow);
    height: var(--nav-h);
    font-family: var(--font);
}

.site-nav__inner {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
}

/* ── Logo ──────────────────────────────────────────────────────── */
.site-nav__logo {
    font-size: 1.25rem;
    font-weight: 800;
    color: var(--nav-blue);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    letter-spacing: -0.3px;
    flex-shrink: 0;
}
.site-nav__logo-icon {
    font-style: normal;
    font-size: 1.1em;
    color: #38bdf8;
}

/* ── Desktop link list ─────────────────────────────────────────── */
.site-nav__links {
    display: flex;
    align-items: center;
    gap: 2px;
    list-style: none;
    margin: 0;
    padding: 0;
    flex: 1;
    justify-content: center;
}
@media (max-width: 767px) {
    .site-nav__links { display: none; }
}

.site-nav__link {
    display: inline-flex;
    align-items: center;
    padding: 7px 14px;
    border-radius: var(--radius);
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--nav-text);
    text-decoration: none;
    transition: background 0.18s ease, color 0.18s ease;
    position: relative;
    white-space: nowrap;
}
.site-nav__link:hover {
    background: #f1f5f9;
    color: var(--nav-hover-c);
}

/* Active desktop link */
.site-nav__link.nav-link--active,
.site-nav__link[aria-current="page"] {
    background: var(--nav-active-bg);
    color: var(--nav-active-c);
    font-weight: 700;
}
.site-nav__link.nav-link--active::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 14px;
    right: 14px;
    height: 2px;
    border-radius: 2px;
    background: var(--nav-blue);
}

/* ── Right actions cluster ─────────────────────────────────────── */
.site-nav__actions {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-shrink: 0;
}

/* ── Hamburger button ──────────────────────────────────────────── */
.site-nav__hamburger {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border: none;
    background: #f1f5f9;
    border-radius: 10px;
    color: #374151;
    cursor: pointer;
    transition: background 0.18s ease, color 0.18s ease;
}
.site-nav__hamburger:hover {
    background: #e0e7ff;
    color: var(--nav-blue);
}
@media (min-width: 768px) {
    .site-nav__hamburger { display: none; }
}

/* ── Drawer overlay ────────────────────────────────────────────── */
.nav-drawer {
    position: fixed;
    inset: 0;                       /* covers full viewport */
    z-index: 950;
    background: var(--drawer-overlay);
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.28s ease, visibility 0.28s ease;
    /* does NOT affect document flow — page content never moves */
}
.nav-drawer--open {
    opacity: 1;
    visibility: visible;
}

/* ── Drawer panel ──────────────────────────────────────────────── */
.nav-drawer__panel {
    position: absolute;
    top: 0;
    bottom: 0;
    width: var(--drawer-w);
    background: var(--drawer-bg);
    box-shadow: 0 0 40px rgba(0,0,0,0.15);
    display: flex;
    flex-direction: column;
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    overflow-y: auto;
    font-family: var(--font);
}

/* RTL: panel slides from the right (inline-end = right in RTL) */
[data-dir="rtl"] .nav-drawer__panel {
    right: 0;
    left: auto;
    transform: translateX(100%);   /* hidden off-screen to the right */
}
[data-dir="rtl"].nav-drawer--open .nav-drawer__panel {
    transform: translateX(0);      /* slides in from right */
}

/* LTR: panel slides from the left */
[data-dir="ltr"] .nav-drawer__panel {
    left: 0;
    right: auto;
    transform: translateX(-100%);  /* hidden off-screen to the left */
}
[data-dir="ltr"].nav-drawer--open .nav-drawer__panel {
    transform: translateX(0);      /* slides in from left */
}

/* ── Drawer header ─────────────────────────────────────────────── */
.nav-drawer__header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 20px;
    border-bottom: 1px solid #e5e7eb;
    flex-shrink: 0;
}
.nav-drawer__close {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border: none;
    background: #f1f5f9;
    border-radius: 8px;
    color: #6b7280;
    cursor: pointer;
    transition: background 0.18s, color 0.18s;
}
.nav-drawer__close:hover {
    background: #fee2e2;
    color: #ef4444;
}

/* ── Drawer link list ──────────────────────────────────────────── */
.nav-drawer__links {
    list-style: none;
    margin: 0;
    padding: 12px 12px 0;
    flex: 1;
}
.nav-drawer__link {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 14px;
    border-radius: var(--radius);
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--nav-text);
    text-decoration: none;
    transition: background 0.18s ease, color 0.18s ease;
    margin-bottom: 2px;
}
.nav-drawer__link:hover {
    background: #f1f5f9;
    color: var(--nav-hover-c);
}
.nav-drawer__link.nav-link--active,
.nav-drawer__link[aria-current="page"] {
    background: var(--nav-active-bg);
    color: var(--nav-active-c);
    font-weight: 700;
}
.nav-drawer__dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: var(--nav-blue);
    flex-shrink: 0;
}

/* ── Drawer footer ─────────────────────────────────────────────── */
.nav-drawer__footer {
    padding: 16px 20px 24px;
    border-top: 1px solid #e5e7eb;
    flex-shrink: 0;
}

/* ── Language toggle (global) ──────────────────────────────────── */
.lang-toggle {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    border-radius: 999px;
    font-size: 0.8rem;
    font-weight: 700;
    font-family: var(--font);
    background: #fefce8;
    color: var(--nav-blue);
    border: 1.5px solid #fde047;
    cursor: pointer;
    transition: background 0.18s ease, color 0.18s ease, border-color 0.18s ease;
    white-space: nowrap;
    letter-spacing: 0.02em;
}
.lang-toggle:hover {
    background: var(--nav-blue);
    color: #fff;
    border-color: var(--nav-blue);
}
.lang-toggle__globe {
    font-style: normal;
    font-size: 1em;
}
</style>
