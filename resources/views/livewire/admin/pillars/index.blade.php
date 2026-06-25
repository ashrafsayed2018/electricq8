@php $locale = app()->getLocale(); @endphp
<div>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-white">{{ __('admin.pillars.title') }}</h1>
        <a href="{{ route('admin.pillars.create') }}"
           class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
            {{ __('admin.pillars.add') }}
        </a>
    </div>

    <div class="bg-[#1a1d27] rounded-xl border border-white/10 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="border-b border-white/10 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-4 py-3 text-start text-gray-600 w-10">#</th>
                    <th class="px-4 py-3 text-start">{{ __('admin.common.image') }}</th>
                    <th class="px-4 py-3 text-start">{{ $locale === 'ar' ? __('admin.common.title_ar') : __('admin.common.title_en') }}</th>
                    <th class="px-4 py-3 text-start">{{ __('admin.pillars.clusters_count') }}</th>
                    <th class="px-4 py-3 text-start">{{ __('admin.common.status') }}</th>
                    <th class="px-4 py-3 text-start">{{ __('admin.common.actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($pillars as $pillar)
                @php
                    $title     = $pillar->getTranslation('title', $locale);
                    $slugAr    = $pillar->getTranslation('slug', 'ar');
                    $publicUrl = $slugAr ? route('pillars.show', $slugAr) : null;
                @endphp
                    <tr class="hover:bg-white/5 transition">

                        <td class="px-4 py-3 text-gray-600 text-xs font-mono">{{ $loop->iteration }}</td>

                        {{-- Image thumbnail → links to public page --}}
                        <td class="px-4 py-3">
                            @if($pillar->image_url && $publicUrl)
                                <a href="{{ $publicUrl }}" target="_blank" title="{{ __('admin.visit_site') }}">
                                    <img src="{{ $pillar->image_url }}" alt="{{ $title }}"
                                         class="w-12 h-12 rounded-lg object-cover border border-white/10 hover:border-purple-500 transition">
                                </a>
                            @elseif($publicUrl)
                                <a href="{{ $publicUrl }}" target="_blank"
                                   class="w-12 h-12 rounded-lg bg-white/5 border border-white/10 hover:border-purple-500 flex items-center justify-center transition"
                                   title="{{ __('admin.visit_site') }}">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                </a>
                            @else
                                <div class="w-12 h-12 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                        </td>

                        {{-- Title in current admin locale — links to public page --}}
                        <td class="px-4 py-3">
                            @if($publicUrl)
                                <a href="{{ $publicUrl }}" target="_blank"
                                   class="text-white font-medium hover:text-purple-400 transition inline-flex items-center gap-1">
                                    {{ $title }}
                                    <svg class="w-3 h-3 opacity-40 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                </a>
                            @else
                                <span class="text-white font-medium">{{ $title }}</span>
                            @endif
                        </td>

                        {{-- Clusters count badge --}}
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded-md text-xs font-mono bg-purple-500/10 text-purple-400">
                                {{ $pillar->clusters_count }}
                            </span>
                        </td>

                        {{-- Status badge --}}
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded-md text-xs font-semibold
                                {{ $pillar->status === 'active' ? 'bg-green-500/20 text-green-400' : 'bg-gray-500/20 text-gray-400' }}">
                                {{ $pillar->status === 'active' ? __('admin.common.active') : __('admin.common.draft') }}
                            </span>
                        </td>

                        {{-- Actions --}}
                        <td class="px-4 py-3 flex gap-3">
                            <a href="{{ route('admin.pillars.edit', $pillar) }}"
                               class="text-purple-400 hover:text-purple-300 text-xs transition">{{ __('admin.common.edit') }}</a>
                            <button wire:click="delete({{ $pillar->id }})"
                                wire:confirm="{{ __('admin.pillars.confirm_delete') }}"
                                class="text-red-400 hover:text-red-300 text-xs transition">{{ __('admin.common.delete') }}</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-600">{{ __('admin.pillars.empty') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
