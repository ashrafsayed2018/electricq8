<div>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-white">{{ __('admin.areas.title') }}</h1>
        <a href="{{ route('admin.areas.create') }}"
           class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
            {{ __('admin.areas.add') }}
        </a>
    </div>

    <div class="bg-[#1a1d27] rounded-xl border border-white/10 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="border-b border-white/10 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-4 py-3 text-right">{{ __('admin.common.hash') }}</th>
                    <th class="px-4 py-3 text-right">{{ __('admin.common.name_ar') }}</th>
                    <th class="px-4 py-3 text-right">{{ __('admin.common.name_en') }}</th>
                    <th class="px-4 py-3 text-right">{{ __('admin.areas.governorate') }}</th>
                    <th class="px-4 py-3 text-right">{{ __('admin.areas.area_enabled') }}</th>
                    <th class="px-4 py-3 text-right">{{ __('admin.common.actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach($locations as $location)
                    <tr class="hover:bg-white/5 transition">
                        <td class="px-4 py-3 text-gray-500">{{ $location->sort_order }}</td>
                        <td class="px-4 py-3 text-white font-medium">{{ $location->getTranslation('name', 'ar') }}</td>
                        <td class="px-4 py-3 text-gray-300">{{ $location->getTranslation('name', 'en') }}</td>
                        <td class="px-4 py-3 text-gray-400 capitalize">{{ str_replace('_', ' ', $location->governorate) }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded-md text-xs font-semibold
                                {{ $location->is_active ? 'bg-green-500/20 text-green-400' : 'bg-gray-500/20 text-gray-400' }}">
                                {{ $location->is_active ? __('admin.common.yes') : __('admin.common.no') }}
                            </span>
                        </td>
                        <td class="px-4 py-3 flex gap-3">
                            <a href="{{ route('admin.areas.edit', $location) }}"
                               class="text-purple-400 hover:text-purple-300 text-xs transition">{{ __('admin.common.edit') }}</a>
                            <button wire:click="delete({{ $location->id }})"
                                wire:confirm="{{ __('admin.areas.confirm_delete') }}"
                                class="text-red-400 hover:text-red-300 text-xs transition">{{ __('admin.common.delete') }}</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
