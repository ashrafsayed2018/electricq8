<div>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-white">{{ __('admin.services.title') }}</h1>
        <a href="{{ route('admin.services.create') }}"
           class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
            {{ __('admin.services.add') }}
        </a>
    </div>

    <div class="bg-[#1a1d27] rounded-xl border border-white/10 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="border-b border-white/10 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-4 py-3 text-right">{{ __('admin.common.hash') }}</th>
                    <th class="px-4 py-3 text-right">{{ __('admin.common.image') }}</th>
                    <th class="px-4 py-3 text-right">{{ __('admin.common.title_ar') }}</th>
                    <th class="px-4 py-3 text-right">{{ __('admin.common.title_en') }}</th>
                    <th class="px-4 py-3 text-right">{{ __('admin.common.status') }}</th>
                    <th class="px-4 py-3 text-right">{{ __('admin.common.actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach($services as $service)
                    @php
                        $svcPublicUrl = route('services.show', $service->getTranslation('slug', 'ar'));
                    @endphp
                    <tr class="hover:bg-white/5 transition">
                        <td class="px-4 py-3 text-gray-500">{{ $service->sort_order }}</td>
                        <td class="px-4 py-3">
                            @if($service->image_url)
                                <a href="{{ $svcPublicUrl }}" target="_blank" title="{{ __('admin.visit_site') }}">
                                    <img src="{{ $service->image_url }}" alt="{{ $service->getTranslation('title', 'ar') }}"
                                         class="w-12 h-12 rounded-lg object-cover border border-white/10 hover:border-purple-500 transition">
                                </a>
                            @else
                                <a href="{{ $svcPublicUrl }}" target="_blank"
                                   class="w-12 h-12 rounded-lg bg-white/5 border border-white/10 hover:border-purple-500 flex items-center justify-center transition"
                                   title="{{ __('admin.visit_site') }}">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 6h16M4 6a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V8a2 2 0 00-2-2M4 6a2 2 0 012-2h12a2 2 0 012 2"/>
                                    </svg>
                                </a>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-white font-medium">
                            <a href="{{ route('services.show', $service->getTranslation('slug', 'ar')) }}"
                               target="_blank" class="hover:text-purple-400 transition">
                                {{ $service->getTranslation('title', 'ar') }}
                            </a>
                        </td>
                        <td class="px-4 py-3 text-gray-300">
                            <a href="{{ route('en.services.show', $service->getTranslation('slug', 'en')) }}"
                               target="_blank" class="hover:text-purple-400 transition">
                                {{ $service->getTranslation('title', 'en') }}
                            </a>
                        </td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded-md text-xs font-semibold
                                {{ $service->status->value === 'active' ? 'bg-green-500/20 text-green-400' : 'bg-gray-500/20 text-gray-400' }}">
                                {{ $service->status->value === 'active' ? __('admin.common.active') : __('admin.common.inactive') }}
                            </span>
                        </td>
                        <td class="px-4 py-3 flex gap-3">
                            <a href="{{ route('admin.services.edit', $service) }}"
                               class="text-purple-400 hover:text-purple-300 text-xs transition">{{ __('admin.common.edit') }}</a>
                            <button wire:click="delete({{ $service->id }})"
                                wire:confirm="{{ __('admin.services.confirm_delete') }}"
                                class="text-red-400 hover:text-red-300 text-xs transition">{{ __('admin.common.delete') }}</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
