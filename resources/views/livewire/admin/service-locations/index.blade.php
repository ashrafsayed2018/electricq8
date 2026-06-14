<div>
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
        <div>
            <h1 class="text-xl font-bold text-white">صفحات الخدمة × المنطقة</h1>
            <p class="text-sm text-gray-500 mt-0.5">Local SEO — {{ $existing }} / {{ $total }} صفحة منشأة</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.service-locations.create') }}"
               class="flex items-center gap-2 bg-purple-600 hover:bg-purple-500 text-white text-sm font-semibold px-4 py-2 rounded-xl transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                إضافة صفحة
            </a>
            <button wire:click="generateAll" wire:confirm="سيتم إنشاء كل الصفحات الناقصة تلقائياً. هل تريد المتابعة؟"
                class="flex items-center gap-2 bg-green-600 hover:bg-green-500 text-white text-sm font-semibold px-4 py-2 rounded-xl transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                توليد الكل تلقائياً
            </button>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-500/20 text-green-400 border border-green-500/30 rounded-xl px-4 py-3 mb-5 text-sm">
        {{ session('success') }}
    </div>
    @endif

    {{-- Stats --}}
    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="bg-[#1a1d27] rounded-xl border border-white/8 p-4 text-center">
            <p class="text-2xl font-bold text-white">{{ $total }}</p>
            <p class="text-xs text-gray-500 mt-1">إجمالي الصفحات الممكنة</p>
        </div>
        <div class="bg-[#1a1d27] rounded-xl border border-white/8 p-4 text-center">
            <p class="text-2xl font-bold text-green-400">{{ $active }}</p>
            <p class="text-xs text-gray-500 mt-1">صفحات نشطة</p>
        </div>
        <div class="bg-[#1a1d27] rounded-xl border border-white/8 p-4 text-center">
            <p class="text-2xl font-bold text-yellow-400">{{ $total - $existing }}</p>
            <p class="text-xs text-gray-500 mt-1">صفحات ناقصة</p>
        </div>
    </div>

    {{-- Matrix grid --}}
    <div class="bg-[#1a1d27] rounded-2xl border border-white/8 overflow-x-auto">
        <table class="w-full text-xs min-w-max">
            <thead>
                <tr class="border-b border-white/8">
                    <th class="px-4 py-3 text-start text-gray-400 font-semibold w-40">المنطقة \ الخدمة</th>
                    @foreach($services as $service)
                    <th class="px-3 py-3 text-center text-gray-400 font-semibold max-w-28">
                        <div class="truncate">{{ $service->getTranslation('title', 'ar') }}</div>
                    </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($locations as $location)
                <tr class="border-b border-white/5 hover:bg-white/3 transition">
                    <td class="px-4 py-3 text-gray-300 font-medium">
                        {{ $location->getTranslation('name', 'ar') }}
                    </td>
                    @foreach($services as $service)
                    @php
                        $page = $pages->get($service->id . '_' . $location->id);
                        $sSlug = $service->getTranslation('slug', 'ar');
                        $lSlug = $location->getTranslation('slug', 'ar');
                    @endphp
                    <td class="px-3 py-3 text-center">
                        @if($page)
                            <div class="flex items-center justify-center gap-1.5">
                                {{-- Status dot --}}
                                <span class="w-2 h-2 rounded-full {{ $page->status === 'active' ? 'bg-green-500' : 'bg-gray-600' }}"></span>
                                {{-- View --}}
                                <a href="{{ route('service-locations.show', [$sSlug, $lSlug]) }}"
                                   target="_blank"
                                   title="عرض"
                                   class="text-gray-500 hover:text-yellow-400 transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                </a>
                                {{-- Edit --}}
                                <a href="{{ route('admin.service-locations.edit', $page->id) }}"
                                   title="تعديل"
                                   class="text-gray-500 hover:text-purple-400 transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                {{-- Toggle --}}
                                <button wire:click="toggleStatus({{ $page->id }})" title="{{ $page->status === 'active' ? 'إيقاف' : 'تفعيل' }}"
                                    class="text-gray-500 hover:text-yellow-400 transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636a9 9 0 010 12.728M15.536 8.464a5 5 0 010 7.072M6.343 17.657a9 9 0 010-12.728M9.172 15.535a5 5 0 010-7.07"/>
                                    </svg>
                                </button>
                            </div>
                        @else
                            <span class="text-gray-700">—</span>
                        @endif
                    </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Legend --}}
    <div class="flex items-center gap-5 mt-4 text-xs text-gray-500">
        <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-green-500"></span> نشطة</span>
        <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-gray-600"></span> موقوفة</span>
        <span class="flex items-center gap-1.5"><span class="text-gray-700">—</span> غير منشأة</span>
    </div>
</div>
