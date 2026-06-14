<div>
    <h1 class="text-xl font-bold mb-6 text-white">{{ __('admin.dashboard.title') }}</h1>

    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">

        {{-- Contacts --}}
        <a href="{{ route('admin.contacts.index') }}"
           class="bg-[#1a1d27] rounded-xl border border-white/10 p-5 flex items-center gap-4 hover:border-yellow-500/40 hover:bg-white/5 transition group">
            <div class="w-11 h-11 rounded-lg bg-yellow-500/15 flex items-center justify-center shrink-0 group-hover:bg-yellow-500/25 transition">
                <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <p class="text-2xl font-extrabold text-white leading-none">{{ $totalContacts }}</p>
                <p class="text-gray-500 text-xs mt-1">{{ __('admin.dashboard.total_messages') }}</p>
            </div>
        </a>

        {{-- New contacts --}}
        <a href="{{ route('admin.contacts.index') }}"
           class="bg-[#1a1d27] rounded-xl border border-white/10 p-5 flex items-center gap-4 hover:border-red-500/40 hover:bg-white/5 transition group">
            <div class="w-11 h-11 rounded-lg bg-red-500/15 flex items-center justify-center shrink-0 group-hover:bg-red-500/25 transition">
                <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
            </div>
            <div class="min-w-0">
                <p class="text-2xl font-extrabold text-white leading-none">{{ $newContacts }}</p>
                <p class="text-gray-500 text-xs mt-1">{{ __('admin.dashboard.new_messages') }}</p>
            </div>
        </a>

        {{-- Services --}}
        <a href="{{ route('admin.services.index') }}"
           class="bg-[#1a1d27] rounded-xl border border-white/10 p-5 flex items-center gap-4 hover:border-green-500/40 hover:bg-white/5 transition group">
            <div class="w-11 h-11 rounded-lg bg-green-500/15 flex items-center justify-center shrink-0 group-hover:bg-green-500/25 transition">
                <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
            <div class="min-w-0">
                <p class="text-2xl font-extrabold text-white leading-none">{{ $totalServices }}</p>
                <p class="text-gray-500 text-xs mt-1">{{ __('admin.dashboard.services') }}</p>
            </div>
        </a>

        {{-- Locations --}}
        <a href="{{ route('admin.areas.index') }}"
           class="bg-[#1a1d27] rounded-xl border border-white/10 p-5 flex items-center gap-4 hover:border-purple-500/40 hover:bg-white/5 transition group">
            <div class="w-11 h-11 rounded-lg bg-purple-500/15 flex items-center justify-center shrink-0 group-hover:bg-purple-500/25 transition">
                <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <p class="text-2xl font-extrabold text-white leading-none">{{ $totalLocations }}</p>
                <p class="text-gray-500 text-xs mt-1">{{ __('admin.dashboard.areas') }}</p>
            </div>
        </a>

        {{-- Posts --}}
        <a href="{{ route('admin.posts.index') }}"
           class="bg-[#1a1d27] rounded-xl border border-white/10 p-5 flex items-center gap-4 hover:border-yellow-500/40 hover:bg-white/5 transition group">
            <div class="w-11 h-11 rounded-lg bg-yellow-500/15 flex items-center justify-center shrink-0 group-hover:bg-yellow-500/25 transition">
                <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <p class="text-2xl font-extrabold text-white leading-none">{{ $totalPosts }}</p>
                <p class="text-gray-500 text-xs mt-1">{{ __('admin.dashboard.posts') }} <span class="text-yellow-500/70">({{ $publishedPosts }} {{ __('admin.common.published') }})</span></p>
            </div>
        </a>

        {{-- Clusters --}}
        <a href="{{ route('admin.clusters.index') }}"
           class="bg-[#1a1d27] rounded-xl border border-white/10 p-5 flex items-center gap-4 hover:border-cyan-500/40 hover:bg-white/5 transition group">
            <div class="w-11 h-11 rounded-lg bg-cyan-500/15 flex items-center justify-center shrink-0 group-hover:bg-cyan-500/25 transition">
                <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
            </div>
            <div class="min-w-0">
                <p class="text-2xl font-extrabold text-white leading-none">{{ $totalClusters }}</p>
                <p class="text-gray-500 text-xs mt-1">{{ __('admin.dashboard.clusters') }}</p>
            </div>
        </a>

        {{-- Testimonials --}}
        <a href="{{ route('admin.testimonials.index') }}"
           class="bg-[#1a1d27] rounded-xl border border-white/10 p-5 flex items-center gap-4 hover:border-orange-500/40 hover:bg-white/5 transition group">
            <div class="w-11 h-11 rounded-lg bg-orange-500/15 flex items-center justify-center shrink-0 group-hover:bg-orange-500/25 transition">
                <svg class="w-5 h-5 text-orange-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <p class="text-2xl font-extrabold text-white leading-none">{{ $totalTestimonials }}</p>
                <p class="text-gray-500 text-xs mt-1">{{ __('admin.dashboard.testimonials') }}</p>
            </div>
        </a>

        {{-- Users --}}
        <a href="{{ route('admin.users.index') }}"
           class="bg-[#1a1d27] rounded-xl border border-white/10 p-5 flex items-center gap-4 hover:border-pink-500/40 hover:bg-white/5 transition group">
            <div class="w-11 h-11 rounded-lg bg-pink-500/15 flex items-center justify-center shrink-0 group-hover:bg-pink-500/25 transition">
                <svg class="w-5 h-5 text-pink-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <p class="text-2xl font-extrabold text-white leading-none">{{ $totalUsers }}</p>
                <p class="text-gray-500 text-xs mt-1">{{ __('admin.dashboard.users') }}</p>
            </div>
        </a>

    </div>
</div>
