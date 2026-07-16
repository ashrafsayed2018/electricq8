<!DOCTYPE html>
<html lang="{{ app()->getLocale() === 'en' ? 'en' : 'ar' }}" dir="{{ app()->getLocale() === 'en' ? 'ltr' : 'rtl' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ElectricQ8 — {{ __('admin.panel_title') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* ── Admin design tokens ──────────────────────────────────── */
        :root {
            /* Light mode admin */
            --ad-bg:      #F5EFE8;
            --ad-surface: #FFFFFF;
            --ad-input:   #FAF6F1;
            --ad-modal:   #F0E8DE;
            --ad-border:  rgba(107,58,23,.18);
            --ad-text:    #2B211A;
            --ad-text2:   #5C4033;
            --ad-text3:   #7A6A5C;
            --ad-text4:   #9E8878;
            --ad-muted:   #B8A898;
            --ad-accent:  #D97B2E;
            --ad-accentdk:#6B3A17;
            --ad-accentlt:rgba(217,123,46,.15);
            --ad-focus:   #D97B2E;
            --ad-active:  rgba(217,123,46,.15);
            --ad-divide:  rgba(107,58,23,.10);
            --ad-tooltip: #43230E;
        }
        @media (prefers-color-scheme: dark) {
            :root {
                --ad-bg:      #0f1117;
                --ad-surface: #1a1d27;
                --ad-input:   #0f1117;
                --ad-modal:   #12141f;
                --ad-border:  rgba(255,255,255,.10);
                --ad-text:    #F3E9DC;
                --ad-text2:   #D8C7B4;
                --ad-text3:   #B0998A;
                --ad-text4:   #8A7060;
                --ad-muted:   #6A5848;
                --ad-accent:  #D97B2E;
                --ad-accentdk:#6B3A17;
                --ad-accentlt:rgba(217,123,46,.15);
                --ad-focus:   #D97B2E;
                --ad-active:  rgba(255,255,255,.10);
                --ad-divide:  rgba(255,255,255,.05);
                --ad-tooltip: #43230E;
            }
        }
        :root[data-theme="dark"] {
            --ad-bg:      #0f1117;
            --ad-surface: #1a1d27;
            --ad-input:   #0f1117;
            --ad-modal:   #12141f;
            --ad-border:  rgba(255,255,255,.10);
            --ad-text:    #F3E9DC;
            --ad-text2:   #D8C7B4;
            --ad-text3:   #B0998A;
            --ad-text4:   #8A7060;
            --ad-muted:   #6A5848;
            --ad-active:  rgba(255,255,255,.10);
            --ad-divide:  rgba(255,255,255,.05);
            --ad-tooltip: #43230E;
        }
        :root[data-theme="light"] {
            --ad-bg:      #F5EFE8;
            --ad-surface: #FFFFFF;
            --ad-input:   #FAF6F1;
            --ad-modal:   #F0E8DE;
            --ad-border:  rgba(107,58,23,.18);
            --ad-text:    #2B211A;
            --ad-text2:   #5C4033;
            --ad-text3:   #7A6A5C;
            --ad-text4:   #9E8878;
            --ad-muted:   #B8A898;
            --ad-active:  rgba(217,123,46,.15);
            --ad-divide:  rgba(107,58,23,.10);
            --ad-tooltip: #43230E;
        }

        [x-cloak] { display: none !important; }

        /* ── Global admin base ───────────────────────────────────── */
        body { background: var(--ad-bg) !important; color: var(--ad-text) !important; }

        /* ── Hardcoded hex overrides → tokens ────────────────────── */
        .bg-\[\#0f1117\]  { background-color: var(--ad-bg)      !important; }
        .bg-\[\#1a1d27\]  { background-color: var(--ad-surface)  !important; }
        .bg-\[\#12141f\]  { background-color: var(--ad-modal)    !important; }
        .text-white       { color: var(--ad-text)   !important; }
        .text-gray-300    { color: var(--ad-text2)  !important; }
        .text-gray-400    { color: var(--ad-text3)  !important; }
        .text-gray-500    { color: var(--ad-text4)  !important; }
        .text-gray-600    { color: var(--ad-muted)  !important; }
        .text-gray-700    { color: var(--ad-muted)  !important; }
        .border-white\/10 { border-color: var(--ad-border) !important; }
        .border-white\/8  { border-color: var(--ad-border) !important; }
        .divide-white\/5 > * + * { border-color: var(--ad-divide) !important; }
        .hover\:bg-white\/5:hover   { background-color: var(--ad-active) !important; }
        .bg-white\/5                { background-color: var(--ad-active) !important; }
        .bg-white\/10               { background-color: var(--ad-accentlt) !important; }

        /* Purple → brown accent */
        .bg-purple-600              { background-color: var(--ad-accentdk) !important; }
        .hover\:bg-purple-600:hover { background-color: var(--ad-accentdk) !important; }
        .bg-purple-600\/10          { background-color: var(--ad-accentlt) !important; }
        .bg-purple-500\/20          { background-color: var(--ad-accentlt) !important; }
        .bg-purple-500\/15          { background-color: var(--ad-accentlt) !important; }
        .bg-purple-500\/10          { background-color: var(--ad-accentlt) !important; }
        .text-purple-400            { color: var(--ad-accent)   !important; }
        .text-purple-300            { color: var(--ad-accent)   !important; }
        .hover\:text-purple-300:hover { color: var(--ad-accent) !important; }
        .focus\:border-purple-500:focus { border-color: var(--ad-focus) !important; }
        .hover\:border-purple-500:hover { border-color: var(--ad-focus) !important; }
        .border-purple-500\/40      { border-color: rgba(217,123,46,.4) !important; }
        .shadow-purple-900\/30      { --tw-shadow-color: rgba(107,58,23,.3) !important; }
        .hover\:border-yellow-500\/40:hover { border-color: rgba(217,123,46,.4) !important; }
        .hover\:border-purple-500\/40:hover { border-color: rgba(217,123,46,.4) !important; }

        /* Gray badge → neutral brown */
        .bg-gray-500\/20            { background-color: var(--ad-accentlt) !important; }
        .bg-gray-600                { background-color: var(--ad-text4)    !important; }

        /* Additional purple → brown overrides */
        .hover\:bg-purple-700:hover { background-color: var(--ad-accentdk) !important; }
        .hover\:bg-purple-500:hover { background-color: var(--ad-accent)   !important; }
        .hover\:bg-purple-600:hover { background-color: var(--ad-accentdk) !important; }
        .hover\:bg-purple-600\/20:hover { background-color: var(--ad-accentlt) !important; }
        .hover\:border-purple-500\/50:hover { border-color: rgba(217,123,46,.5) !important; }
        .hover\:text-purple-300:hover { color: var(--ad-accent) !important; }
        .file\:bg-purple-600::file-selector-button { background-color: var(--ad-accentdk) !important; }
        input[type="checkbox"]:checked ~ div.peer-checked\:bg-purple-600,
        input:checked + * .peer-checked\:bg-purple-600,
        .peer:checked ~ .peer-checked\:bg-purple-600 {
            background-color: var(--ad-accentdk) !important;
        }

        /* Inputs */
        input, textarea, select {
            background-color: var(--ad-input) !important;
            color: var(--ad-text) !important;
            border-color: var(--ad-border) !important;
        }
        input::placeholder, textarea::placeholder { color: var(--ad-muted) !important; }
        .placeholder-gray-600::placeholder { color: var(--ad-muted) !important; }
        input:focus, textarea:focus, select:focus {
            border-color: var(--ad-focus) !important;
            box-shadow: 0 0 0 2px rgba(217,123,46,.2) !important;
        }
        select option { background: var(--ad-surface); color: var(--ad-text); }

        /* ── Sidebar ─────────────────────────────────────────────── */
        aside, .fixed.inset-y-0.start-0 {
            background-color: var(--ad-surface) !important;
            border-color: var(--ad-border) !important;
        }
        header {
            background-color: var(--ad-surface) !important;
            border-color: var(--ad-border) !important;
        }
        /* Language switcher bg */
        .flex.bg-\[\#0f1117\].rounded-lg {
            background-color: var(--ad-bg) !important;
        }

        /* ── Tooltip ─────────────────────────────────────────────── */
        .nav-item { position: relative; }
        .nav-item .tooltip {
            position: absolute;
            top: 50%;
            right: calc(100% + 10px);
            transform: translateY(-50%);
            background: var(--ad-tooltip);
            color: #fff;
            font-size: 12px;
            padding: 5px 12px;
            border-radius: 6px;
            white-space: nowrap;
            pointer-events: none;
            box-shadow: 0 2px 12px rgba(0,0,0,.4);
            opacity: 0;
            transition: opacity 0.15s;
            z-index: 9999;
        }
        .nav-item .tooltip::after {
            content: '';
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            border: 5px solid transparent;
            border-left-color: var(--ad-tooltip);
        }
        [dir="ltr"] .nav-item .tooltip {
            right: auto;
            left: calc(100% + 10px);
        }
        [dir="ltr"] .nav-item .tooltip::after {
            left: auto;
            right: 100%;
            border-left-color: transparent;
            border-right-color: var(--ad-tooltip);
        }
        body[data-sidebar-collapsed="true"] .nav-item:hover .tooltip { opacity: 1; }
        body[data-sidebar-collapsed="true"] aside,
        body[data-sidebar-collapsed="true"] aside nav { overflow: visible !important; }

        /* ── Table ───────────────────────────────────────────────── */
        table { color: var(--ad-text); }
        thead { color: var(--ad-text4); }
        tbody tr:hover { background-color: var(--ad-active) !important; }

        /* ── Pagination links ─────────────────────────────────────── */
        nav[aria-label="Pagination Navigation"] span,
        nav[aria-label="Pagination Navigation"] a {
            background-color: var(--ad-surface) !important;
            border-color: var(--ad-border) !important;
            color: var(--ad-text3) !important;
        }
        nav[aria-label="Pagination Navigation"] span[aria-current],
        nav[aria-label="Pagination Navigation"] .bg-white {
            background-color: var(--ad-accentdk) !important;
            color: #fff !important;
        }

        /* ── Theme toggle button in admin topbar ─────────────────── */
        .ad-theme-toggle {
            display: flex; align-items: center; justify-content: center;
            width: 32px; height: 32px; border-radius: 8px;
            background: var(--ad-active); border: 1px solid var(--ad-border);
            color: var(--ad-text3); cursor: pointer; transition: background .18s, color .18s;
            flex-shrink: 0;
        }
        .ad-theme-toggle:hover { background: var(--ad-accentlt); color: var(--ad-accent); }
    </style>
    <script>
    (function(){
        var s=localStorage.getItem('eq8-theme');
        if(s){document.documentElement.setAttribute('data-theme',s);return;}
        if(window.matchMedia('(prefers-color-scheme:dark)').matches){document.documentElement.setAttribute('data-theme','dark');}
    })();
    </script>
</head>
<body class="antialiased">

<div x-data="{
    sidebarOpen: false,
    collapsed: (function() {
        var c = document.cookie.match(/sidebarCollapsed=([^;]+)/);
        return c ? c[1] === 'true' : false;
    })(),
    toggle() {
        this.collapsed = !this.collapsed;
        document.cookie = 'sidebarCollapsed=' + this.collapsed + ';path=/;max-age=31536000';
        document.body.setAttribute('data-sidebar-collapsed', this.collapsed);
    },
    init() {
        document.body.setAttribute('data-sidebar-collapsed', this.collapsed);
    }
}" class="flex min-h-screen bg-[#0f1117]">

    {{-- Mobile backdrop --}}
    <div
        x-show="sidebarOpen"
        x-transition.opacity
        @click="sidebarOpen = false"
        class="fixed inset-0 z-20 bg-black/60 lg:hidden"
        x-cloak
    ></div>

    {{-- Sidebar — sticky flex child, no fixed positioning needed --}}
    @php $sidebarCollapsed = request()->cookie('sidebarCollapsed') === 'true'; @endphp
    <aside
        :style="collapsed ? 'width:56px' : 'width:256px'"
        class="hidden lg:flex shrink-0 sticky top-0 h-screen bg-[#1a1d27] flex-col
               transition-all duration-200 ease-in-out overflow-hidden
               {{ $sidebarCollapsed ? 'w-14' : 'w-64' }}"
    >
        {{-- Brand --}}
        <div class="border-b border-white/10 flex items-center overflow-hidden transition-all duration-200"
             :class="collapsed ? 'justify-center px-0 py-3' : 'justify-between px-3 py-3 gap-2'">

            {{-- Logo + text (hidden when collapsed) --}}
            <div x-show="!collapsed" class="flex items-center gap-3 min-w-0">
                <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold shrink-0" style="background:var(--ad-accentdk);color:#fff">Q</div>
                <span class="font-bold text-sm leading-tight whitespace-nowrap">
                    ElectricQ8<br><span class="text-gray-400 font-normal text-xs">{{ __('admin.panel_title') }}</span>
                </span>
            </div>

            {{-- Logo only (shown when collapsed) --}}
            <div x-show="collapsed" class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold shrink-0" style="background:var(--ad-accentdk);color:#fff">Q</div>

            {{-- Close button mobile --}}
            <button @click="sidebarOpen = false" class="lg:hidden text-gray-400 hover:text-white shrink-0" x-show="sidebarOpen">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            {{-- Collapse toggle desktop — always visible --}}
            <button @click="toggle()" x-show="!collapsed"
                    class="hidden lg:flex text-gray-500 hover:text-white transition shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M11 19l-7-7 7-7M18 19l-7-7 7-7"/>
                </svg>
            </button>
        </div>

        {{-- Expand button (shown below logo when collapsed) --}}
        <button @click="toggle()" x-show="collapsed"
                class="hidden lg:flex justify-center py-2 text-gray-500 hover:text-white transition border-b border-white/10">
            <svg class="w-4 h-4 rotate-180" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M11 19l-7-7 7-7M18 19l-7-7 7-7"/>
            </svg>
        </button>

        {{-- Nav --}}
        <nav :class="collapsed ? 'px-1' : 'px-2'" class="flex-1 py-1.5 text-sm flex flex-col justify-between overflow-y-auto overflow-x-hidden">

            @php
            $link = fn(string $label, string $route, string $active, string $icon) => [
                'label'  => $label,
                'route'  => $route,
                'active' => $active,
                'icon'   => $icon,
            ];
            $links = [
                $link(__('admin.nav.dashboard'), 'admin.dashboard',       'admin.dashboard',    'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'),
                $link(__('admin.nav.contacts'),   'admin.contacts.index',  'admin.contacts.*',   'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'),
            ];
            $content = [
                $link(__('admin.nav.pillars'),      'admin.pillars.index',     'admin.pillars.*',      'M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z'),
                $link(__('admin.nav.clusters'),     'admin.clusters.index',    'admin.clusters.*',     'M4 6h16M4 10h16M4 14h16M4 18h16'),
                $link(__('admin.nav.services'),     'admin.services.index',    'admin.services.*',     'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'),
                $link(__('admin.nav.areas'),             'admin.areas.index',            'admin.areas.*',             'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z'),
                $link(__('admin.nav.service_locations'), 'admin.service-locations.index', 'admin.service-locations.*', 'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7'),
                $link(__('admin.nav.gallery'),           'admin.gallery.index',          'admin.gallery.*',           'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'),
                $link(__('admin.nav.testimonials'), 'admin.testimonials.index','admin.testimonials.*', 'M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z'),
                $link(__('admin.nav.posts'),        'admin.posts.index',       'admin.posts.*',        'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'),
                $link(__('admin.nav.tags'),         'admin.tags.index',        'admin.tags.*',         'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z'),
            ];
            $system = [
                $link(__('admin.nav.analytics'),    'admin.analytics',         'admin.analytics*',       'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'),
                $link(__('admin.nav.users'),        'admin.users.index',        'admin.users.*',           'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'),
                $link(__('admin.nav.roles'),        'admin.roles.index',        'admin.roles.*',           'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'),
                $link(__('admin.nav.permissions'),  'admin.permissions.index',  'admin.permissions.*',     'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'),
                $link(__('admin.nav.settings'),     'admin.settings',           'admin.settings',          'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065zM15 12a3 3 0 11-6 0 3 3 0 016 0z'),
            ];
            @endphp

            @foreach($links as $item)
                <div class="nav-item">
                    <a href="{{ route($item['route']) }}" @click="sidebarOpen = false"
                       :class="collapsed ? 'justify-center px-0' : 'px-3'"
                       class="flex items-center gap-2.5 py-1.5 rounded-md transition w-full
                              {{ request()->routeIs($item['active']) ? 'bg-white/10 text-white' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="{{ $item['icon'] }}"/>
                        </svg>
                        <span x-show="!collapsed" class="whitespace-nowrap">{{ $item['label'] }}</span>
                    </a>
                    <span class="tooltip">{{ $item['label'] }}</span>
                </div>
            @endforeach

            {{-- Content group --}}
            <div>
                <p x-show="!collapsed" x-transition.opacity
                   class="px-3 pt-2 pb-0.5 text-xs text-gray-600 uppercase tracking-widest whitespace-nowrap">{{ __('admin.nav_content') }}</p>
                <div x-show="collapsed" class="border-t border-white/10 my-1 mx-2"></div>

                @foreach($content as $item)
                    <div class="nav-item">
                        <a href="{{ route($item['route']) }}" @click="sidebarOpen = false"
                           :class="collapsed ? 'justify-center px-0' : 'px-3'"
                           class="flex items-center gap-2.5 py-1.5 rounded-md transition w-full
                                  {{ request()->routeIs($item['active']) ? 'bg-white/10 text-white' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="{{ $item['icon'] }}"/>
                            </svg>
                            <span x-show="!collapsed" class="whitespace-nowrap">{{ $item['label'] }}</span>
                        </a>
                        <span class="tooltip">{{ $item['label'] }}</span>
                    </div>
                @endforeach
            </div>

            {{-- System group --}}
            <div>
                <p x-show="!collapsed" x-transition.opacity
                   class="px-3 pt-2 pb-0.5 text-xs text-gray-600 uppercase tracking-widest whitespace-nowrap">{{ __('admin.nav_system') }}</p>
                <div x-show="collapsed" class="border-t border-white/10 my-1 mx-2"></div>

                @foreach($system as $item)
                    <div class="nav-item">
                        <a href="{{ route($item['route']) }}" @click="sidebarOpen = false"
                           :class="collapsed ? 'justify-center px-0' : 'px-3'"
                           class="flex items-center gap-2.5 py-1.5 rounded-md transition w-full
                                  {{ request()->routeIs($item['active']) ? 'bg-white/10 text-white' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="{{ $item['icon'] }}"/>
                            </svg>
                            <span x-show="!collapsed" class="whitespace-nowrap">{{ $item['label'] }}</span>
                        </a>
                        <span class="tooltip">{{ $item['label'] }}</span>
                    </div>
                @endforeach

                {{-- Logout --}}
                <div class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            :class="collapsed ? 'justify-center px-0' : 'px-3'"
                            class="w-full flex items-center gap-2.5 py-1 rounded-md transition text-gray-400 hover:text-red-400 hover:bg-white/5">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            <span x-show="!collapsed" class="whitespace-nowrap">{{ __('admin.logout') }}</span>
                        </button>
                    </form>
                    <span class="tooltip">{{ __('admin.logout') }}</span>
                </div>
            </div>

        </nav>
    </aside>

    {{-- Mobile sidebar drawer (fixed overlay, only on small screens) --}}
    <div
        x-show="sidebarOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-x-full"
        x-transition:enter-end="opacity-100 translate-x-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-x-0"
        x-transition:leave-end="opacity-0 -translate-x-full"
        class="fixed inset-y-0 start-0 z-40 w-64 bg-[#1a1d27] flex flex-col lg:hidden"
        x-cloak
    >
        {{-- Mobile header --}}
        <div class="border-b border-white/10 flex items-center justify-between px-3 py-3">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold shrink-0" style="background:var(--ad-accentdk);color:#fff">Q</div>
                <span class="font-bold text-sm">ElectricQ8<br><span class="text-gray-400 font-normal text-xs">{{ __('admin.panel_title') }}</span></span>
            </div>
            <button @click="sidebarOpen = false" class="text-gray-400 hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        {{-- Reuse same nav links for mobile --}}
        <nav class="flex-1 px-2 py-2 text-sm overflow-y-auto">
            @foreach($links as $item)
                <a href="{{ route($item['route']) }}" @click="sidebarOpen = false"
                   class="flex items-center gap-2.5 px-3 py-1.5 rounded-md transition mb-0.5
                          {{ request()->routeIs($item['active']) ? 'bg-white/10 text-white' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="{{ $item['icon'] }}"/></svg>
                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach
            <p class="px-3 pt-3 pb-0.5 text-xs text-gray-600 uppercase tracking-widest">{{ __('admin.nav_content') }}</p>
            @foreach($content as $item)
                <a href="{{ route($item['route']) }}" @click="sidebarOpen = false"
                   class="flex items-center gap-2.5 px-3 py-1.5 rounded-md transition mb-0.5
                          {{ request()->routeIs($item['active']) ? 'bg-white/10 text-white' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="{{ $item['icon'] }}"/></svg>
                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach
            <p class="px-3 pt-3 pb-0.5 text-xs text-gray-600 uppercase tracking-widest">{{ __('admin.nav_system') }}</p>
            @foreach($system as $item)
                <a href="{{ route($item['route']) }}" @click="sidebarOpen = false"
                   class="flex items-center gap-2.5 px-3 py-1.5 rounded-md transition mb-0.5
                          {{ request()->routeIs($item['active']) ? 'bg-white/10 text-white' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="{{ $item['icon'] }}"/></svg>
                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach
            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2.5 px-3 py-1.5 rounded-md transition text-gray-400 hover:text-red-400 hover:bg-white/5">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    {{ __('admin.logout') }}
                </button>
            </form>
        </nav>
    </div>

    {{-- Main content — flex-1 naturally fills remaining space, no margin hacks --}}
    <div class="flex-1 flex flex-col min-h-screen min-w-0 bg-[#0f1117]">

        {{-- Top bar --}}
        <header class="bg-[#1a1d27] border-b border-white/10 px-4 py-3 flex items-center justify-between gap-3 sticky top-0 z-20">
            <div class="flex items-center gap-3">
                {{-- Hamburger (mobile only) --}}
                <button @click="sidebarOpen = true"
                    class="lg:hidden text-gray-400 hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <p class="text-sm text-gray-400">
                    {{ __('admin.welcome') }} <span class="text-white font-medium">{{ auth()->user()->name }}</span>
                </p>
                {{-- Language switcher --}}
                @php $currentLocale = app()->getLocale(); @endphp
                <div class="flex rounded-lg border border-white/10 p-0.5 gap-0.5 mr-1" style="background:var(--ad-bg)">
                    <a href="{{ route('locale.switch', 'ar') }}"
                       class="px-3 py-1 rounded-md text-xs font-semibold transition"
                       style="{{ $currentLocale === 'ar' ? 'background:var(--ad-accentdk);color:#fff' : 'color:var(--ad-text3)' }}">
                        ع
                    </a>
                    <a href="{{ route('locale.switch', 'en') }}"
                       class="px-3 py-1 rounded-md text-xs font-semibold transition"
                       style="{{ $currentLocale === 'en' ? 'background:var(--ad-accentdk);color:#fff' : 'color:var(--ad-text3)' }}">
                        EN
                    </a>
                </div>
            </div>
            <div class="flex items-center gap-2">
            <button type="button" class="ad-theme-toggle" id="adThemeToggle" aria-label="Toggle theme">
                <svg id="adThemeSun" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:none">
                    <circle cx="12" cy="12" r="5"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/>
                </svg>
                <svg id="adThemeMoon" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
                </svg>
            </button>
            <a href="{{ config('app.url') }}" target="_blank"
               class="flex items-center gap-2 text-xs text-gray-400 hover:text-white transition shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
                <span class="hidden sm:inline">{{ __('admin.visit_site') }}</span>
            </a>
            </div>
        </header>

        <main class="flex-1 p-4 md:p-6">
            {{ $slot }}
        </main>

    </div>

</div>

    @livewireScripts
    <script src="https://cdn.tiny.cloud/1/{{ config('services.tinymce.key') }}/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        window.initTinyMCE = function (selector, dir, wireModel) {
            var id = selector.replace('#', '');
            var existing = tinymce.get(id);
            if (existing) { existing.remove(); }

            tinymce.init({
                selector: selector,
                directionality: dir,
                height: 600,
                skin: 'oxide-dark',
                content_css: 'dark',
                plugins: [
                    'accordion', 'advlist', 'anchor', 'autolink', 'autosave',
                    'charmap', 'code', 'codesample', 'directionality', 'emoticons',
                    'fullscreen', 'help', 'image', 'importcss', 'insertdatetime',
                    'link', 'lists', 'media', 'nonbreaking', 'pagebreak', 'preview',
                    'quickbars', 'searchreplace', 'table', 'visualblocks', 'visualchars', 'wordcount',
                ],
                menubar: 'file edit view insert format tools table help',
                toolbar: 'undo redo | accordion accordionremove | blocks fontfamily fontsize | bold italic underline strikethrough | align numlist bullist | link image | table media | lineheight outdent indent | forecolor backcolor removeformat | charmap emoticons | code fullscreen preview | pagebreak anchor codesample | ltr rtl',
                toolbar_mode: 'sliding',
                autosave_ask_before_unload: true,
                autosave_interval: '30s',
                autosave_restore_when_empty: false,
                autosave_retention: '2m',
                image_advtab: true,
                image_caption: true,
                importcss_append: true,
                quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
                noneditable_class: 'mceNonEditable',
                contextmenu: 'link image table',
                content_style: 'body { font-family: Tahoma, Arial, sans-serif; font-size: 15px; }',
                promotion: false,
                setup: function (editor) {
                    editor.on('change', function () {
                        editor.save();
                    });
                },
            });
        };

        document.addEventListener('livewire:navigating', function () {
            tinymce.remove();
        });

        document.addEventListener('livewire:initialized', function () {
            Livewire.on('scroll-to-error', function () {
                setTimeout(function () {
                    var first = document.querySelector('.text-red-400');
                    if (first) {
                        first.closest('div')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }, 50);
            });
        });

    </script>
    <script>
    (function(){
        var btn  = document.getElementById('adThemeToggle');
        var sun  = document.getElementById('adThemeSun');
        var moon = document.getElementById('adThemeMoon');
        function applyTheme(dark) {
            document.documentElement.setAttribute('data-theme', dark ? 'dark' : 'light');
            localStorage.setItem('eq8-theme', dark ? 'dark' : 'light');
            if (sun)  sun.style.display  = dark ? '' : 'none';
            if (moon) moon.style.display = dark ? 'none' : '';
        }
        var saved = localStorage.getItem('eq8-theme');
        var isDark = saved ? saved === 'dark' : window.matchMedia('(prefers-color-scheme:dark)').matches;
        applyTheme(isDark);
        if (btn) btn.addEventListener('click', function(){
            isDark = !isDark;
            applyTheme(isDark);
        });
    })();
    </script>
</body>
</html>
