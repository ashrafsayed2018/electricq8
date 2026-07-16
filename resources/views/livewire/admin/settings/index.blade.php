<div x-data="{ tab: 'contact' }">

    {{-- ── Page header ── --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-white">{{ __('admin.settings.title') }}</h1>
            <p class="text-sm text-gray-500 mt-0.5">{{ __('admin.settings.subtitle') }}</p>
        </div>
        <button form="settings-form" type="submit"
            class="flex items-center gap-2 bg-purple-600 hover:bg-purple-500 text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition shadow-lg shadow-purple-900/30">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
            {{ __('admin.settings.save') }}
        </button>
    </div>

    {{-- ── Toast ── --}}
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="fixed top-6 end-6 z-50 flex items-center gap-3 bg-green-500 text-white px-5 py-3 rounded-xl shadow-2xl text-sm font-semibold">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
        </svg>
        {{ session('success') }}
        <button @click="show = false" class="opacity-70 hover:opacity-100 ms-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    @endif

    <div class="flex gap-6 items-start">

        {{-- ── Sidebar tabs ── --}}
        <nav class="w-52 shrink-0 flex flex-col gap-1 sticky top-6">

            <button type="button" @click="tab = 'contact'"
                :style="tab === 'contact' ? 'background:var(--ad-accentlt);color:var(--ad-accent);border-color:rgba(217,123,46,.4)' : 'border-color:transparent;color:var(--ad-text4)'"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl border text-sm font-medium transition w-full text-start">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                {{ __('admin.settings.contact_info') }}
            </button>

            <button type="button" @click="tab = 'social'"
                :style="tab === 'social' ? 'background:var(--ad-accentlt);color:var(--ad-accent);border-color:rgba(217,123,46,.4)' : 'border-color:transparent;color:var(--ad-text4)'"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl border text-sm font-medium transition w-full text-start">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                </svg>
                {{ __('admin.settings.social') }}
            </button>

            <button type="button" @click="tab = 'seo'"
                :style="tab === 'seo' ? 'background:var(--ad-accentlt);color:var(--ad-accent);border-color:rgba(217,123,46,.4)' : 'border-color:transparent;color:var(--ad-text4)'"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl border text-sm font-medium transition w-full text-start">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                {{ __('admin.settings.seo') }}
            </button>

            <button type="button" @click="tab = 'brand'"
                :style="tab === 'brand' ? 'background:var(--ad-accentlt);color:var(--ad-accent);border-color:rgba(217,123,46,.4)' : 'border-color:transparent;color:var(--ad-text4)'"
                class="flex items-center gap-3 px-4 py-2.5 rounded-xl border text-sm font-medium transition w-full text-start">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                {{ __('admin.settings.brand_images') }}
            </button>

        </nav>

        {{-- ── Main panel ── --}}
        <form id="settings-form" wire:submit="save" class="flex-1 min-w-0">

            {{-- ════ CONTACT ════ --}}
            <div x-show="tab === 'contact'" x-cloak>
                <div class="bg-[#1a1d27] rounded-2xl border border-white/8 overflow-hidden">

                    <div class="px-6 py-4 border-b border-white/8 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-purple-500/15 flex items-center justify-center">
                            <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-white">{{ __('admin.settings.contact_info') }}</p>
                            <p class="text-xs text-gray-500">{{ __('admin.settings.contact_subtitle') }}</p>
                        </div>
                    </div>

                    <div class="p-6 grid grid-cols-2 gap-5">

                        {{-- WhatsApp --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-400 mb-2">
                                {{ __('admin.settings.whatsapp') }}
                                <span class="text-gray-600 font-normal ms-1">{{ __('admin.settings.whatsapp_hint') }}</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-green-400" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.116 1.528 5.845L0 24l6.335-1.505A11.946 11.946 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.882a9.872 9.872 0 01-5.031-1.378l-.361-.214-3.741.981.999-3.648-.235-.374A9.869 9.869 0 012.118 12C2.118 6.963 6.963 2.118 12 2.118s9.882 4.845 9.882 9.882-4.845 9.882-9.882 9.882z"/>
                                    </svg>
                                </span>
                                <input wire:model="settings.whatsapp_number" type="text" dir="ltr"
                                    placeholder="96512345678"
                                    class="w-full bg-[#0f1117] border border-white/10 rounded-xl ps-10 pe-3 py-2.5 text-sm text-white placeholder-gray-600 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500/30 transition">
                            </div>
                        </div>

                        {{-- Phone --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-400 mb-2">{{ __('admin.settings.phone') }}</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </span>
                                <input wire:model="settings.phone_number" type="text" dir="ltr"
                                    placeholder="+965 1234 5678"
                                    class="w-full bg-[#0f1117] border border-white/10 rounded-xl ps-10 pe-3 py-2.5 text-sm text-white placeholder-gray-600 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500/30 transition">
                            </div>
                        </div>

                        {{-- Email --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-400 mb-2">{{ __('admin.settings.email') }}</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </span>
                                <input wire:model="settings.email" type="email" dir="ltr"
                                    placeholder="info@example.com"
                                    class="w-full bg-[#0f1117] border border-white/10 rounded-xl ps-10 pe-3 py-2.5 text-sm text-white placeholder-gray-600 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500/30 transition">
                            </div>
                        </div>

                        {{-- Google Maps --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-400 mb-2">{{ __('admin.settings.maps_link') }}</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </span>
                                <input wire:model="settings.google_maps_embed" type="text" dir="ltr"
                                    placeholder="https://maps.google.com/..."
                                    class="w-full bg-[#0f1117] border border-white/10 rounded-xl ps-10 pe-3 py-2.5 text-sm text-white placeholder-gray-600 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500/30 transition">
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- ════ SOCIAL ════ --}}
            <div x-show="tab === 'social'" x-cloak>
                <div class="bg-[#1a1d27] rounded-2xl border border-white/8 overflow-hidden">

                    <div class="px-6 py-4 border-b border-white/8 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-pink-500/15 flex items-center justify-center">
                            <svg class="w-4 h-4 text-pink-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-white">{{ __('admin.settings.social') }}</p>
                            <p class="text-xs text-gray-500">{{ __('admin.settings.social_subtitle') }}</p>
                        </div>
                    </div>

                    <div class="p-6 space-y-4">

                        {{-- Instagram --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-400 mb-2">Instagram</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-pink-400" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                    </svg>
                                </span>
                                <input wire:model="settings.instagram_url" type="text" dir="ltr"
                                    placeholder="https://instagram.com/yourhandle"
                                    class="w-full bg-[#0f1117] border border-white/10 rounded-xl ps-10 pe-3 py-2.5 text-sm text-white placeholder-gray-600 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500/30 transition">
                            </div>
                        </div>

                        {{-- Snapchat --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-400 mb-2">Snapchat</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-yellow-300" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12.206.793c.99 0 4.347.276 5.93 3.821.529 1.193.403 3.219.299 4.847l-.003.06c-.012.18-.022.345-.03.51.075.045.203.09.401.09.3-.016.659-.12 1.033-.301.165-.088.344-.104.464-.104.182 0 .359.029.509.09.45.149.734.479.734.838.015.449-.39.839-1.213 1.168-.089.029-.209.075-.344.119-.45.135-1.139.36-1.333.81-.09.224-.061.524.12.868l.015.015c.06.136 1.526 3.475 4.791 4.014.255.044.435.27.42.509 0 .075-.015.149-.045.225-.24.569-1.273.988-3.146 1.271-.059.091-.12.375-.164.57-.029.179-.074.36-.134.553-.076.271-.27.405-.555.405h-.03c-.135 0-.313-.031-.538-.074-.36-.075-.765-.135-1.273-.135-.3 0-.599.015-.913.074-.6.104-1.123.464-1.723.884-.853.599-1.826 1.288-3.294 1.288-.06 0-.119-.015-.18-.015h-.149c-1.468 0-2.427-.675-3.279-1.288-.599-.42-1.107-.779-1.707-.884-.314-.045-.629-.074-.928-.074-.54 0-.958.089-1.272.149-.211.043-.391.074-.54.074-.374 0-.523-.224-.583-.42-.061-.192-.09-.389-.135-.567-.046-.181-.105-.494-.166-.57-1.918-.222-2.95-.642-3.189-1.226-.031-.063-.052-.15-.055-.225-.015-.243.165-.465.42-.509 3.264-.54 4.73-3.879 4.791-4.02l.016-.029c.18-.345.224-.645.119-.869-.195-.434-.884-.658-1.332-.809-.121-.029-.24-.074-.346-.119-1.107-.435-1.257-.93-1.197-1.273.09-.479.674-.793 1.168-.793.146 0 .27.029.383.074.42.194.789.3 1.104.3.234 0 .384-.06.465-.105l-.031-.569c-.098-1.626-.225-3.651.307-4.837C7.392 1.077 10.739.807 11.727.807l.419-.015h.06z"/>
                                    </svg>
                                </span>
                                <input wire:model="settings.snapchat_url" type="text" dir="ltr"
                                    placeholder="https://snapchat.com/add/yourhandle"
                                    class="w-full bg-[#0f1117] border border-white/10 rounded-xl ps-10 pe-3 py-2.5 text-sm text-white placeholder-gray-600 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500/30 transition">
                            </div>
                        </div>

                        {{-- TikTok --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-400 mb-2">TikTok</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-300" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.33 6.33 0 00-.79-.05 6.34 6.34 0 00-6.34 6.34 6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.33-6.34V8.69a8.18 8.18 0 004.79 1.52V6.74a4.85 4.85 0 01-1.02-.05z"/>
                                    </svg>
                                </span>
                                <input wire:model="settings.tiktok_url" type="text" dir="ltr"
                                    placeholder="https://tiktok.com/@yourhandle"
                                    class="w-full bg-[#0f1117] border border-white/10 rounded-xl ps-10 pe-3 py-2.5 text-sm text-white placeholder-gray-600 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500/30 transition">
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- ════ SEO ════ --}}
            <div x-show="tab === 'seo'" x-cloak>
                <div class="bg-[#1a1d27] rounded-2xl border border-white/8 overflow-hidden">

                    <div class="px-6 py-4 border-b border-white/8 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-yellow-500/15 flex items-center justify-center">
                            <svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-white">{{ __('admin.settings.seo') }}</p>
                            <p class="text-xs text-gray-500">{{ __('admin.settings.seo_subtitle') }}</p>
                        </div>
                    </div>

                    <div class="p-6 space-y-6">

                        {{-- Site name row --}}
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">{{ __('admin.settings.site_name_label') }}</p>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs text-gray-500 mb-1.5 flex items-center gap-1.5">
                                        <span class="w-4 h-4 rounded bg-white/10 text-center text-gray-400 text-[10px] font-bold leading-4">ع</span>
                                        {{ __('admin.settings.site_name_ar') }}
                                    </label>
                                    <input wire:model="settings.site_name_ar" type="text"
                                        class="w-full bg-[#0f1117] border border-white/10 rounded-xl px-3 py-2.5 text-sm text-white placeholder-gray-600 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500/30 transition">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-500 mb-1.5 flex items-center gap-1.5">
                                        <span class="w-4 h-4 rounded bg-white/10 text-center text-gray-400 text-[10px] font-bold leading-4">A</span>
                                        {{ __('admin.settings.site_name_en') }}
                                    </label>
                                    <input wire:model="settings.site_name_en" type="text" dir="ltr"
                                        class="w-full bg-[#0f1117] border border-white/10 rounded-xl px-3 py-2.5 text-sm text-white placeholder-gray-600 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500/30 transition">
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-white/6"></div>

                        {{-- Meta description row --}}
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">{{ __('admin.settings.meta_desc_label') }}</p>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-xs text-gray-500 mb-1.5 flex items-center gap-1.5">
                                        <span class="w-4 h-4 rounded bg-white/10 text-center text-gray-400 text-[10px] font-bold leading-4">ع</span>
                                        {{ __('admin.settings.meta_desc_ar') }}
                                    </label>
                                    <textarea wire:model="settings.default_meta_ar" rows="2"
                                        class="w-full bg-[#0f1117] border border-white/10 rounded-xl px-3 py-2.5 text-sm text-white placeholder-gray-600 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500/30 transition resize-none"></textarea>
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-500 mb-1.5 flex items-center gap-1.5">
                                        <span class="w-4 h-4 rounded bg-white/10 text-center text-gray-400 text-[10px] font-bold leading-4">A</span>
                                        {{ __('admin.settings.meta_desc_en') }}
                                    </label>
                                    <textarea wire:model="settings.default_meta_en" rows="2" dir="ltr"
                                        class="w-full bg-[#0f1117] border border-white/10 rounded-xl px-3 py-2.5 text-sm text-white placeholder-gray-600 focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500/30 transition resize-none"></textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- ════ BRAND IMAGES ════ --}}
            <div x-show="tab === 'brand'" x-cloak>
                <div class="bg-[#1a1d27] rounded-2xl border border-white/8 overflow-hidden">

                    <div class="px-6 py-4 border-b border-white/8 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-orange-500/15 flex items-center justify-center">
                            <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-white">{{ __('admin.settings.brand_images') }}</p>
                            <p class="text-xs text-gray-500">{{ __('admin.settings.brand_subtitle') }}</p>
                        </div>
                    </div>

                    <div class="p-6 grid grid-cols-3 gap-5">

                        {{-- ── Logo ── --}}
                        <div class="bg-[#0f1117] rounded-xl border border-white/8 overflow-hidden flex flex-col">
                            {{-- Preview --}}
                            <div class="h-36 flex items-center justify-center relative overflow-hidden">
                                @if($logo_url)
                                    <img src="{{ $logo_url }}" class="max-h-28 max-w-full object-contain p-3" alt="Logo">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                                @else
                                    <div class="flex flex-col items-center gap-2 text-gray-700">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="text-xs">{{ __('admin.settings.no_image') }}</span>
                                    </div>
                                @endif
                            </div>
                            {{-- Info + actions --}}
                            <div class="p-4 border-t border-white/6 flex flex-col gap-3 flex-1">
                                <div>
                                    <p class="text-sm font-semibold text-white">{{ __('admin.settings.logo') }}</p>
                                    <p class="text-xs text-gray-600 mt-0.5">{{ __('admin.settings.logo_hint') }}</p>
                                </div>
                                <div class="flex flex-col gap-1.5 mt-auto">
                                    <livewire:admin.image-picker field="logo_url" :imageUrl="$logo_url" label="" :inline="true" :key="'logo-picker'" />
                                    @if($logo_url)
                                        <button type="button" wire:click="$set('logo_url', '')"
                                            class="text-xs text-red-400/70 hover:text-red-400 transition text-start">
                                            {{ __('admin.settings.remove_image') }}
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- ── Favicon ── --}}
                        <div class="bg-[#0f1117] rounded-xl border border-white/8 overflow-hidden flex flex-col">
                            <div class="h-36 flex items-center justify-center relative overflow-hidden">
                                @if($favicon_url)
                                    <img src="{{ $favicon_url }}" class="w-16 h-16 object-contain" alt="Favicon">
                                @else
                                    <div class="flex flex-col items-center gap-2 text-gray-700">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <span class="text-xs">{{ __('admin.settings.no_image') }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="p-4 border-t border-white/6 flex flex-col gap-3 flex-1">
                                <div>
                                    <p class="text-sm font-semibold text-white">{{ __('admin.settings.favicon') }}</p>
                                    <p class="text-xs text-gray-600 mt-0.5">{{ __('admin.settings.favicon_hint') }}</p>
                                </div>
                                <div class="flex flex-col gap-1.5 mt-auto">
                                    <livewire:admin.image-picker field="favicon_url" :imageUrl="$favicon_url" label="" :inline="true" :key="'favicon-picker'" />
                                    @if($favicon_url)
                                        <button type="button" wire:click="$set('favicon_url', '')"
                                            class="text-xs text-red-400/70 hover:text-red-400 transition text-start">
                                            {{ __('admin.settings.remove_image') }}
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- ── Hero / OG Image ── --}}
                        <div class="bg-[#0f1117] rounded-xl border border-white/8 overflow-hidden flex flex-col">
                            <div class="h-36 flex items-center justify-center relative overflow-hidden">
                                @if($hero_url)
                                    <img src="{{ $hero_url }}" class="w-full h-full object-cover" alt="Hero">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                                @else
                                    <div class="flex flex-col items-center gap-2 text-gray-700">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <span class="text-xs">{{ __('admin.settings.no_image') }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="p-4 border-t border-white/6 flex flex-col gap-3 flex-1">
                                <div>
                                    <p class="text-sm font-semibold text-white">{{ __('admin.settings.hero_image') }}</p>
                                    <p class="text-xs text-gray-600 mt-0.5">{{ __('admin.settings.hero_hint') }}</p>
                                </div>
                                <div class="flex flex-col gap-1.5 mt-auto">
                                    <livewire:admin.image-picker field="hero_image_url" :imageUrl="$hero_url" label="" :inline="true" :key="'hero-picker'" />
                                    @if($hero_url)
                                        <button type="button" wire:click="$set('hero_url', '')"
                                            class="text-xs text-red-400/70 hover:text-red-400 transition text-start">
                                            {{ __('admin.settings.remove_image') }}
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </form>

    </div>

</div>
