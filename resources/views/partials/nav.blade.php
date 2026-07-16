@php
$isAr    = app()->getLocale() === 'ar';
$prefix  = $isAr ? '' : 'en.';
$current = request()->route()?->getName() ?? '';
$currentBase = str_replace('en.', '', $current);

$links = [
    ['route' => $prefix . 'home',           'base' => 'home',          'label' => __('site.nav.home')],
    ['route' => $prefix . 'services.index', 'base' => 'services.index','label' => __('site.nav.services')],
    ['route' => $prefix . 'areas.index',    'base' => 'areas.index',   'label' => __('site.nav.areas')],
    ['route' => $prefix . 'about',          'base' => 'about',         'label' => __('site.nav.about')],
    ['route' => $prefix . 'contact',        'base' => 'contact',       'label' => __('site.nav.contact')],
    ['route' => $prefix . 'posts.index',    'base' => 'posts.index',   'label' => __('site.nav.blog')],
    ['route' => $prefix . 'gallery',        'base' => 'gallery',       'label' => __('site.nav.gallery')],
];
@endphp

<nav class="eq8-nav" dir="{{ $isAr ? 'rtl' : 'ltr' }}"
     x-data="{
         open: false,
         dark: false,
         init() {
             const saved = localStorage.getItem('eq8-theme');
             const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
             this.dark = saved ? saved === 'dark' : prefersDark;
             this.applyTheme();
         },
         toggle() { this.dark = !this.dark; this.applyTheme(); },
         applyTheme() {
             const t = this.dark ? 'dark' : 'light';
             document.documentElement.setAttribute('data-theme', t);
             localStorage.setItem('eq8-theme', t);
         }
     }"
     @keydown.escape.window="open = false; $nextTick(() => $el.querySelector('.eq8-nav__burger')?.focus())">

    <div class="eq8-nav__inner">

        <a href="{{ route($prefix . 'home') }}" class="eq8-nav__logo" aria-label="ElectricQ8">
            <span class="eq8-nav__bolt" aria-hidden="true">⚡</span>
            ElectricQ8
        </a>

        <ul class="eq8-nav__links" role="list">
            @foreach($links as $link)
            @php $isActive = $currentBase === $link['base']; @endphp
            <li>
                <a href="{{ route($link['route']) }}"
                   class="eq8-nav__link{{ $isActive ? ' eq8-nav__link--active' : '' }}"
                   @if($isActive) aria-current="page" @endif>
                    {{ $link['label'] }}
                </a>
            </li>
            @endforeach
        </ul>

        <div class="eq8-nav__actions">
            <button class="eq8-theme-toggle" @click="toggle()"
                    :aria-label="dark ? '{{ $isAr ? 'تفعيل الوضع النهاري' : 'Switch to light mode' }}' : '{{ $isAr ? 'تفعيل الوضع الليلي' : 'Switch to dark mode' }}'">
                {{-- Sun icon (shown in dark mode) --}}
                <svg x-show="dark" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="12" cy="12" r="5"/>
                    <line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/>
                    <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
                    <line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/>
                    <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
                </svg>
                {{-- Moon icon (shown in light mode) --}}
                <svg x-show="!dark" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
                </svg>
            </button>
            <livewire:language-switcher />
            <button class="eq8-nav__burger"
                    aria-label="{{ $isAr ? 'فتح القائمة' : 'Open menu' }}"
                    :aria-expanded="open" @click="open = true">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.2"
                     stroke-linecap="round" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

    </div>

    {{-- Mobile drawer --}}
    <div class="eq8-drawer" data-dir="{{ $isAr ? 'rtl' : 'ltr' }}"
         :class="open ? 'eq8-drawer--open' : ''"
         @click.self="open = false; $nextTick(() => $el.closest('nav').querySelector('.eq8-nav__burger')?.focus())"
         x-bind:aria-hidden="!open">

        <div class="eq8-drawer__panel" role="dialog" aria-modal="true"
             :aria-label="'{{ $isAr ? 'القائمة الرئيسية' : 'Main menu' }}'">

            <div class="eq8-drawer__head">
                <span class="eq8-nav__logo" style="font-size:1.05rem">⚡ ElectricQ8</span>
                <button class="eq8-drawer__close"
                        aria-label="{{ $isAr ? 'إغلاق القائمة' : 'Close menu' }}"
                        @click="open = false; $nextTick(() => $el.closest('nav').querySelector('.eq8-nav__burger')?.focus())">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5"
                         stroke-linecap="round" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <ul class="eq8-drawer__links" role="list">
                @foreach($links as $link)
                @php $isActive = $currentBase === $link['base']; @endphp
                <li>
                    <a href="{{ route($link['route']) }}"
                       class="eq8-drawer__link{{ $isActive ? ' eq8-nav__link--active' : '' }}"
                       @if($isActive) aria-current="page" @endif
                       @click="open = false">
                        {{ $link['label'] }}
                        @if($isActive)<span class="eq8-drawer__dot" aria-hidden="true"></span>@endif
                    </a>
                </li>
                @endforeach
            </ul>

            <div class="eq8-drawer__foot">
                <livewire:language-switcher />
                <button class="eq8-theme-toggle eq8-theme-toggle--drawer" @click="toggle()"
                        :aria-label="dark ? '{{ $isAr ? 'تفعيل الوضع النهاري' : 'Switch to light mode' }}' : '{{ $isAr ? 'تفعيل الوضع الليلي' : 'Switch to dark mode' }}'">
                    <svg x-show="dark" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="5"/>
                        <line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/>
                        <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
                        <line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/>
                        <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
                    </svg>
                    <svg x-show="!dark" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" viewBox="0 0 24 24">
                        <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
                    </svg>
                    <span x-text="dark ? '{{ $isAr ? 'وضع النهار' : 'Light mode' }}' : '{{ $isAr ? 'وضع الليل' : 'Dark mode' }}'"></span>
                </button>
            </div>
        </div>
    </div>

</nav>

<style>
/* ── Nav shell ───────────────────────────────────────────────── */
.eq8-nav {
    position: sticky;
    top: 0;
    z-index: 900;
    background: var(--headerBg);
    border-bottom: 1px solid var(--border);
    box-shadow: 0 1px 12px rgba(67,35,14,.06);
    height: 64px;
    font-family: 'Cairo', system-ui, sans-serif;
    transition: background .3s ease, border-color .3s ease;
}
.eq8-nav__inner {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
}

/* ── Logo ────────────────────────────────────────────────────── */
.eq8-nav__logo {
    font-size: 1.2rem;
    font-weight: 800;
    color: var(--primary);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    flex-shrink: 0;
    letter-spacing: -.3px;
}
.eq8-nav__bolt {
    color: var(--accent);
    font-style: normal;
}

/* ── Desktop links ───────────────────────────────────────────── */
.eq8-nav__links {
    display: flex;
    align-items: center;
    gap: 2px;
    list-style: none;
    margin: 0;
    padding: 0;
    flex: 1;
    justify-content: center;
}
@media (max-width: 767px) { .eq8-nav__links { display: none; } }

.eq8-nav__link {
    display: inline-flex;
    align-items: center;
    padding: 7px 13px;
    border-radius: 8px;
    font-size: .875rem;
    font-weight: 600;
    color: var(--muted);
    text-decoration: none;
    white-space: nowrap;
    transition: background .18s ease, color .18s ease;
}
.eq8-nav__link:hover {
    background: var(--altBg);
    color: var(--primary);
}
.eq8-nav__link--active {
    background: var(--accentTint);
    color: var(--primary);
    font-weight: 700;
}

/* ── Actions cluster ─────────────────────────────────────────── */
.eq8-nav__actions {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-shrink: 0;
}

/* ── Hamburger ───────────────────────────────────────────────── */
.eq8-nav__burger {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border: none;
    background: var(--altBg);
    border-radius: 10px;
    color: var(--muted);
    cursor: pointer;
    transition: background .18s ease, color .18s ease;
}
.eq8-nav__burger:hover { background: var(--accentTint); color: var(--primary); }
@media (min-width: 768px) { .eq8-nav__burger { display: none; } }

/* ── Drawer overlay ──────────────────────────────────────────── */
.eq8-drawer {
    position: fixed;
    inset: 0;
    z-index: 950;
    background: rgba(43,33,26,.5);
    opacity: 0;
    visibility: hidden;
    transition: opacity .28s ease, visibility .28s ease;
}
.eq8-drawer--open { opacity: 1; visibility: visible; }

/* ── Drawer panel ────────────────────────────────────────────── */
.eq8-drawer__panel {
    position: absolute;
    top: 0; bottom: 0;
    width: 280px;
    background: var(--headerBg);
    box-shadow: 0 0 40px rgba(0,0,0,.2);
    display: flex;
    flex-direction: column;
    overflow-y: auto;
    font-family: 'Cairo', system-ui, sans-serif;
    transition: transform .3s cubic-bezier(.4,0,.2,1);
}
[data-dir="rtl"] .eq8-drawer__panel {
    right: 0; left: auto;
    transform: translateX(100%);
}
[data-dir="rtl"].eq8-drawer--open .eq8-drawer__panel { transform: translateX(0); }
[data-dir="ltr"] .eq8-drawer__panel {
    left: 0; right: auto;
    transform: translateX(-100%);
}
[data-dir="ltr"].eq8-drawer--open .eq8-drawer__panel { transform: translateX(0); }

/* ── Drawer sections ─────────────────────────────────────────── */
.eq8-drawer__head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 20px;
    border-bottom: 1px solid var(--border);
    flex-shrink: 0;
}
.eq8-drawer__close {
    width: 36px; height: 36px;
    border: none;
    background: var(--altBg);
    border-radius: 8px;
    color: var(--muted);
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: background .18s, color .18s;
}
.eq8-drawer__close:hover { background: #fee2e2; color: #ef4444; }

.eq8-drawer__links {
    list-style: none;
    margin: 0;
    padding: 12px 12px 0;
    flex: 1;
}
.eq8-drawer__link {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 14px;
    border-radius: 8px;
    font-size: .95rem;
    font-weight: 600;
    color: var(--muted);
    text-decoration: none;
    margin-bottom: 2px;
    transition: background .18s ease, color .18s ease;
}
.eq8-drawer__link:hover { background: var(--altBg); color: var(--primary); }
.eq8-drawer__link.eq8-nav__link--active { background: var(--accentTint); color: var(--primary); font-weight: 700; }
.eq8-drawer__dot {
    width: 7px; height: 7px;
    border-radius: 50%;
    background: var(--accent);
    flex-shrink: 0;
}
.eq8-drawer__foot {
    padding: 16px 20px 24px;
    border-top: 1px solid var(--border);
    flex-shrink: 0;
}

/* ── Theme toggle ────────────────────────────────────────────── */
.eq8-theme-toggle {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    border: 1px solid var(--border);
    background: var(--altBg);
    border-radius: 10px;
    color: var(--muted);
    cursor: pointer;
    transition: background .18s ease, color .18s ease, border-color .18s ease;
    flex-shrink: 0;
}
.eq8-theme-toggle:hover { background: var(--accentTint); color: var(--primary); border-color: var(--primary); }

.eq8-theme-toggle--drawer {
    width: 100%;
    height: auto;
    border-radius: 8px;
    padding: 10px 14px;
    gap: 10px;
    margin-top: 10px;
    font-size: .88rem;
    font-weight: 700;
    font-family: 'Cairo', system-ui, sans-serif;
    justify-content: flex-start;
}

/* ── Language toggle (global) ────────────────────────────────── */
.lang-toggle {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    border-radius: 999px;
    font-size: .8rem;
    font-weight: 700;
    font-family: 'Cairo', system-ui, sans-serif;
    background: var(--accentTint);
    color: var(--primary);
    border: 1.5px solid var(--border);
    cursor: pointer;
    transition: background .18s ease, color .18s ease, border-color .18s ease;
    white-space: nowrap;
}
.lang-toggle:hover { background: var(--primary); color: #fff; border-color: var(--primary); }
.lang-toggle__globe { font-style: normal; }
</style>
