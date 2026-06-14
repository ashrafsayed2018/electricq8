<div>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-white">{{ __('admin.contacts.title') }}</h1>
        <div class="flex gap-3">
            <select wire:model.live="status"
                class="bg-[#1a1d27] border border-white/10 text-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-purple-500">
                <option value="">{{ __('admin.contacts.all') }}</option>
                <option value="new">{{ __('admin.contacts.new') }}</option>
                <option value="read">{{ __('admin.contacts.read') }}</option>
                <option value="replied">{{ __('admin.contacts.replied') }}</option>
            </select>
            <div class="flex rounded-lg overflow-hidden border border-white/10 text-sm">
                <a href="{{ route('admin.contacts.index') }}"
                   class="px-4 py-2 {{ $locale === '' ? 'bg-purple-600 text-white' : 'bg-[#1a1d27] text-gray-400 hover:text-white' }}">
                    {{ __('admin.contacts.all') }}
                </a>
                <a href="{{ route('admin.contacts.index', 'ar') }}"
                   class="px-4 py-2 {{ $locale === 'ar' ? 'bg-purple-600 text-white' : 'bg-[#1a1d27] text-gray-400 hover:text-white' }}">
                    {{ __('admin.contacts.arabic') }}
                </a>
                <a href="{{ route('admin.contacts.index', 'en') }}"
                   class="px-4 py-2 {{ $locale === 'en' ? 'bg-purple-600 text-white' : 'bg-[#1a1d27] text-gray-400 hover:text-white' }}">
                    English
                </a>
            </div>
        </div>
    </div>

    <div class="bg-[#1a1d27] rounded-xl border border-white/10 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="border-b border-white/10 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-4 py-3 text-right">{{ __('admin.contacts.name') }}</th>
                    <th class="px-4 py-3 text-right">{{ __('admin.contacts.phone') }}</th>
                    <th class="px-4 py-3 text-right">{{ __('admin.contacts.service') }}</th>
                    <th class="px-4 py-3 text-right">{{ __('admin.contacts.location') }}</th>
                    <th class="px-4 py-3 text-right">{{ __('admin.contacts.status') }}</th>
                    <th class="px-4 py-3 text-right">{{ __('admin.contacts.language') }}</th>
                    <th class="px-4 py-3 text-right">{{ __('admin.contacts.action') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach($this->contacts as $contact)
                    <tr class="hover:bg-white/5 transition">
                        <td class="px-4 py-3 font-medium text-white">{{ $contact->name }}</td>
                        <td class="px-4 py-3 text-gray-300">{{ $contact->phone }}</td>
                        <td class="px-4 py-3 text-gray-400">{{ $contact->service?->getTranslation('title', 'ar') ?? '—' }}</td>
                        <td class="px-4 py-3 text-gray-400">{{ $contact->location?->getTranslation('name', 'ar') ?? '—' }}</td>
                        <td class="px-4 py-3">
                            @php
                                $statusColors = [
                                    'new'     => 'bg-red-500/20 text-red-400',
                                    'read'    => 'bg-gray-500/20 text-gray-400',
                                    'replied' => 'bg-green-500/20 text-green-400',
                                ];
                                $statusLabels = [
                                    'new'     => __('admin.contacts.new'),
                                    'read'    => __('admin.contacts.read'),
                                    'replied' => __('admin.contacts.replied'),
                                ];
                            @endphp
                            <span class="px-2 py-1 rounded-md text-xs font-semibold {{ $statusColors[$contact->status->value] ?? 'bg-gray-500/20 text-gray-400' }}">
                                {{ $statusLabels[$contact->status->value] ?? $contact->status->value }}
                            </span>
                        </td>
                        <td class="px-4 py-3 uppercase text-xs text-gray-500">{{ $contact->locale }}</td>
                        <td class="px-4 py-3">
                            @if($contact->status->value === 'new')
                                <button wire:click="markRead({{ $contact->id }})"
                                    class="text-xs text-purple-400 hover:text-purple-300 transition">
                                    {{ __('admin.contacts.mark_read') }}
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-4 py-3 border-t border-white/10">{{ $this->contacts->links() }}</div>
    </div>
</div>
