<div>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-white">{{ __('admin.roles.title') }}</h1>
        <a href="{{ route('admin.roles.create') }}"
           class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
            {{ __('admin.roles.add') }}
        </a>
    </div>

    <div class="bg-[#1a1d27] rounded-xl border border-white/10 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="border-b border-white/10 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-4 py-3 text-right">{{ __('admin.roles.name') }}</th>
                    <th class="px-4 py-3 text-right">{{ __('admin.roles.permissions') }}</th>
                    <th class="px-4 py-3 text-right">{{ __('admin.roles.users') }}</th>
                    <th class="px-4 py-3 text-right">{{ __('admin.common.actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($roles as $role)
                    <tr class="hover:bg-white/5 transition">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <span class="text-white font-medium">{{ $role->name }}</span>
                                @if($role->name === 'admin')
                                    <span class="text-xs bg-purple-500/20 text-purple-400 px-2 py-0.5 rounded-full">{{ __('admin.roles.protected') }}</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex flex-wrap gap-1">
                                @forelse($role->permissions as $perm)
                                    <span class="text-xs bg-yellow-500/15 text-yellow-400 px-2 py-0.5 rounded-full">{{ $perm->name }}</span>
                                @empty
                                    <span class="text-gray-600 text-xs">{{ __('admin.roles.no_permissions') }}</span>
                                @endforelse
                            </div>
                        </td>
                        <td class="px-4 py-3 text-gray-400">{{ $role->users_count }}</td>
                        <td class="px-4 py-3 flex gap-3">
                            <a href="{{ route('admin.roles.edit', $role) }}"
                               class="text-purple-400 hover:text-purple-300 text-xs transition">{{ __('admin.common.edit') }}</a>
                            @if($role->name !== 'admin')
                                <button wire:click="delete({{ $role->id }})"
                                    wire:confirm="{{ __('admin.roles.confirm_delete') }}"
                                    class="text-red-400 hover:text-red-300 text-xs transition">{{ __('admin.common.delete') }}</button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-gray-500">{{ __('admin.roles.empty') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
