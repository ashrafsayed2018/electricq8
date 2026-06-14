<div>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-white">{{ __('admin.users.title') }}</h1>
        <a href="{{ route('admin.users.create') }}"
           class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
            {{ __('admin.users.add') }}
        </a>
    </div>

    <div class="mb-4">
        <input wire:model.live.debounce.300ms="search"
               type="text"
               placeholder="{{ __('admin.users.search') }}"
               class="w-full md:w-80 bg-[#1a1d27] border border-white/10 text-white text-sm rounded-lg px-4 py-2.5 focus:outline-none focus:border-purple-500 placeholder-gray-500" />
    </div>

    <div class="bg-[#1a1d27] rounded-xl border border-white/10 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="border-b border-white/10 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-4 py-3 text-right">{{ __('admin.users.name') }}</th>
                    <th class="px-4 py-3 text-right">{{ __('admin.users.email') }}</th>
                    <th class="px-4 py-3 text-right">{{ __('admin.users.role') }}</th>
                    <th class="px-4 py-3 text-right">{{ __('admin.users.created_at') }}</th>
                    <th class="px-4 py-3 text-right">{{ __('admin.common.actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($users as $user)
                    <tr class="hover:bg-white/5 transition">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-purple-600 flex items-center justify-center text-xs font-bold shrink-0">
                                    {{ mb_substr($user->name, 0, 1) }}
                                </div>
                                <span class="text-white font-medium">{{ $user->name }}</span>
                                @if($user->id === auth()->id())
                                    <span class="text-xs text-purple-400">{{ __('admin.users.you') }}</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3 text-gray-300">{{ $user->email }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded-md text-xs font-semibold bg-purple-500/20 text-purple-400">
                                {{ $user->roles->first()?->name ?? '—' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-500 text-xs">{{ $user->created_at->format('Y-m-d') }}</td>
                        <td class="px-4 py-3 flex gap-3">
                            <a href="{{ route('admin.users.edit', $user) }}"
                               class="text-purple-400 hover:text-purple-300 text-xs transition">{{ __('admin.common.edit') }}</a>
                            @if($user->id !== auth()->id())
                                <button wire:click="delete({{ $user->id }})"
                                    wire:confirm="{{ __('admin.users.confirm_delete') }}"
                                    class="text-red-400 hover:text-red-300 text-xs transition">{{ __('admin.common.delete') }}</button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-500">{{ __('admin.users.empty') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    @endif
</div>
