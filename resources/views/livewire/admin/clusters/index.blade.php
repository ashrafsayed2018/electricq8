@php $locale = app()->getLocale(); @endphp
<div>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-white">{{ __('admin.clusters.title') }}</h1>
        <a href="{{ route('admin.clusters.create') }}"
           class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
            {{ __('admin.clusters.add') }}
        </a>
    </div>

    <div class="bg-[#1a1d27] rounded-xl border border-white/10 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="border-b border-white/10 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-4 py-3 text-start text-gray-600 w-10">#</th>
                    <th class="px-4 py-3 text-start">{{ __('admin.common.image') }}</th>
                    <th class="px-4 py-3 text-start">{{ $locale === 'ar' ? __('admin.common.title_ar') : __('admin.common.title_en') }}</th>
                    <th class="px-4 py-3 text-start">{{ __('admin.clusters.pillar') }}</th>
                    <th class="px-4 py-3 text-start">{{ __('admin.clusters.intent') }}</th>
                    <th class="px-4 py-3 text-start">{{ __('admin.common.status') }}</th>
                    <th class="px-4 py-3 text-start">{{ __('admin.common.actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($clusters as $cluster)
                @php
                    $title     = $cluster->getTranslation('title', $locale);
                    $slugAr    = $cluster->getTranslation('slug', 'ar');
                    $publicUrl = $slugAr ? route('clusters.show', $slugAr) : null;
                    $pillarTitle = $cluster->pillar?->getTranslation('title', $locale) ?? '—';
                @endphp
                    <tr class="hover:bg-white/5 transition">

                        <td class="px-4 py-3 text-gray-600 text-xs font-mono">{{ $loop->iteration }}</td>

                        {{-- Image thumbnail → links to public page --}}
                        <td class="px-4 py-3">
                            @if($cluster->image_url && $publicUrl)
                                <a href="{{ $publicUrl }}" target="_blank" title="{{ __('admin.visit_site') }}">
                                    <img src="{{ $cluster->image_url }}" alt="{{ $title }}"
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

                        {{-- Pillar in current admin locale --}}
                        <td class="px-4 py-3 text-gray-400">{{ $pillarTitle }}</td>

                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded-md text-xs font-mono bg-white/5 text-gray-400">
                                {{ $cluster->search_intent }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded-md text-xs font-semibold
                                {{ $cluster->status === 'active' ? 'bg-green-500/20 text-green-400' : 'bg-gray-500/20 text-gray-400' }}">
                                {{ $cluster->status === 'active' ? __('admin.common.active') : ($cluster->status === 'archived' ? __('admin.clusters.archived') : __('admin.common.draft')) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 flex gap-3">
                            <a href="{{ route('admin.clusters.edit', $cluster) }}"
                               class="text-purple-400 hover:text-purple-300 text-xs transition">{{ __('admin.common.edit') }}</a>
                            <button wire:click="delete({{ $cluster->id }})"
                                wire:confirm="{{ __('admin.clusters.confirm_delete') }}"
                                class="text-red-400 hover:text-red-300 text-xs transition">{{ __('admin.common.delete') }}</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-600">{{ __('admin.clusters.empty') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
