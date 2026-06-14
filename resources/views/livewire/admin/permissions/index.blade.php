<div>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-white">{{ __('admin.permissions.title') }}</h1>
        <a href="{{ route('admin.permissions.create') }}"
           class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
            {{ __('admin.permissions.add') }}
        </a>
    </div>

    <div class="bg-[#1a1d27] rounded-xl border border-white/10 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="border-b border-white/10 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-4 py-3 text-right">{{ __('admin.permissions.name') }}</th>
                    <th class="px-4 py-3 text-right">{{ __('admin.permissions.used_in_roles') }}</th>
                    <th class="px-4 py-3 text-right">{{ __('admin.common.actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($permissions as $permission)
                    <tr class="hover:bg-white/5 transition">
                        <td class="px-4 py-3">
                            <span class="text-white font-medium font-mono text-xs bg-white/5 px-2 py-1 rounded">{{ $permission->name }}</span>
                        </td>
                        <td class="px-4 py-3 text-gray-400">
                            @if($permission->roles_count > 0)
                                <span class="text-yellow-400">{{ $permission->roles_count }} {{ $permission->roles_count === 1 ? __('admin.permissions.role_singular') : __('admin.permissions.role_plural') }}</span>
                            @else
                                <span class="text-gray-600">{{ __('admin.permissions.unused') }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 flex gap-3">
                            <a href="{{ route('admin.permissions.edit', $permission) }}"
                               class="text-purple-400 hover:text-purple-300 text-xs transition">{{ __('admin.common.edit') }}</a>
                            <button wire:click="delete({{ $permission->id }})"
                                wire:confirm="{{ __('admin.permissions.confirm_delete') }}"
                                class="text-red-400 hover:text-red-300 text-xs transition">{{ __('admin.common.delete') }}</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-4 py-8 text-center text-gray-500">{{ __('admin.permissions.empty') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
