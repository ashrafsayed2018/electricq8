<div>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-white">{{ __('admin.testimonials.title') }}</h1>
    </div>

    <div class="bg-[#1a1d27] rounded-xl border border-white/10 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="border-b border-white/10 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-4 py-3 text-right">{{ __('admin.testimonials.client') }}</th>
                    <th class="px-4 py-3 text-right">{{ __('admin.testimonials.rating') }}</th>
                    <th class="px-4 py-3 text-right">{{ __('admin.testimonials.location') }}</th>
                    <th class="px-4 py-3 text-right">{{ __('admin.testimonials.active') }}</th>
                    <th class="px-4 py-3 text-right">{{ __('admin.common.actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach($testimonials as $testimonial)
                    <tr class="hover:bg-white/5 transition">
                        <td class="px-4 py-3 font-medium text-white">{{ $testimonial->getTranslation('client_name', 'ar') }}</td>
                        <td class="px-4 py-3 text-yellow-400">
                            @for($i = 1; $i <= 5; $i++)
                                {{ $i <= $testimonial->rating ? '★' : '☆' }}
                            @endfor
                        </td>
                        <td class="px-4 py-3 text-gray-400">{{ $testimonial->location?->getTranslation('name', 'ar') ?? '—' }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded-md text-xs font-semibold
                                {{ $testimonial->is_active ? 'bg-green-500/20 text-green-400' : 'bg-gray-500/20 text-gray-400' }}">
                                {{ $testimonial->is_active ? __('admin.common.yes') : __('admin.common.no') }}
                            </span>
                        </td>
                        <td class="px-4 py-3 flex gap-3">
                            <button wire:click="toggle({{ $testimonial->id }})"
                                class="text-purple-400 hover:text-purple-300 text-xs transition">{{ __('admin.testimonials.toggle') }}</button>
                            <button wire:click="delete({{ $testimonial->id }})"
                                wire:confirm="{{ __('admin.testimonials.confirm_delete') }}"
                                class="text-red-400 hover:text-red-300 text-xs transition">{{ __('admin.common.delete') }}</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
