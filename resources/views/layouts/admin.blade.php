<!DOCTYPE html>
<html lang="{{ app()->getLocale() === 'en' ? 'en' : 'ar' }}" dir="{{ app()->getLocale() === 'en' ? 'ltr' : 'rtl' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ElectricQ8 — {{ __('admin.panel_title') }}</title>
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }

        /* Tooltip — appears outside the collapsed sidebar */
        .nav-item { position: relative; }
        .nav-item .tooltip {
            position: absolute;
            top: 50%;
            /* RTL: sidebar is on the right, tooltip goes to the left */
            right: calc(100% + 10px);
            transform: translateY(-50%);
            background: #2d3148;
            color: #fff;
            font-size: 12px;
            padding: 5px 12px;
            border-radius: 6px;
            white-space: nowrap;
            pointer-events: none;
            box-shadow: 0 2px 12px rgba(0,0,0,.6);
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
            border-left-color: #2d3148;
        }
        /* LTR: sidebar is on the left, tooltip goes to the right */
        [dir="ltr"] .nav-item .tooltip {
            right: auto;
            left: calc(100% + 10px);
        }
        [dir="ltr"] .nav-item .tooltip::after {
            left: auto;
            right: 100%;
            border-left-color: transparent;
            border-right-color: #2d3148;
        }
        body[data-sidebar-collapsed="true"] .nav-item:hover .tooltip {
            opacity: 1;
        }
        /* Allow tooltips to overflow the sidebar bounds */
        body[data-sidebar-collapsed="true"] aside,
        body[data-sidebar-collapsed="true"] aside nav {
            overflow: visible !important;
        }
    </style>
</head>
<body class="bg-[#0f1117] text-white antialiased">

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
                <div class="w-9 h-9 rounded-full bg-purple-600 flex items-center justify-center text-sm font-bold shrink-0">Q</div>
                <span class="font-bold text-sm leading-tight whitespace-nowrap">
                    ElectricQ8<br><span class="text-gray-400 font-normal text-xs">{{ __('admin.panel_title') }}</span>
                </span>
            </div>

            {{-- Logo only (shown when collapsed) --}}
            <div x-show="collapsed" class="w-9 h-9 rounded-full bg-purple-600 flex items-center justify-center text-sm font-bold shrink-0">Q</div>

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
        <nav :class="collapsed ? 'px-1' : 'px-2'" class="flex-1 py-1.5 text-sm flex flex-col justify-between overflow-hidden">

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
                <div class="w-9 h-9 rounded-full bg-purple-600 flex items-center justify-center text-sm font-bold shrink-0">Q</div>
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
                <div class="flex bg-[#0f1117] rounded-lg border border-white/10 p-0.5 gap-0.5 mr-1">
                    <a href="{{ route('locale.switch', 'ar') }}"
                       class="px-3 py-1 rounded-md text-xs font-semibold transition
                              {{ $currentLocale === 'ar' ? 'bg-purple-600 text-white' : 'text-gray-400 hover:text-white' }}">
                        ع
                    </a>
                    <a href="{{ route('locale.switch', 'en') }}"
                       class="px-3 py-1 rounded-md text-xs font-semibold transition
                              {{ $currentLocale === 'en' ? 'bg-purple-600 text-white' : 'text-gray-400 hover:text-white' }}">
                        EN
                    </a>
                </div>
            </div>
            <a href="{{ config('app.url') }}" target="_blank"
               class="flex items-center gap-2 text-xs text-gray-400 hover:text-white transition shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
                <span class="hidden sm:inline">{{ __('admin.visit_site') }}</span>
            </a>
        </header>

        <main class="flex-1 p-4 md:p-6 bg-[#0f1117]">
            {{ $slot }}
        </main>

    </div>

</div>

    @livewireScripts
    <script src="https://cdn.tiny.cloud/1/{{ env('TINYMCE_API_KEY') }}/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
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

    </script>
</body>
</html>
