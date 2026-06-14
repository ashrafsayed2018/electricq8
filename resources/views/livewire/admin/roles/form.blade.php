<div>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-white">
            {{ $role ? __('admin.roles.edit') : __('admin.roles.add_new') }}
        </h1>
        <a href="{{ route('admin.roles.index') }}"
           class="text-gray-400 hover:text-white text-sm transition">{{ __('admin.common.back_to_list') }}</a>
    </div>

    <form wire:submit="save" class="max-w-xl space-y-6">

        <div>
            <label class="block text-sm text-gray-400 mb-1.5">{{ __('admin.roles.name_label') }} <span class="text-red-400">{{ __('admin.common.required_mark') }}</span></label>
            <input wire:model="name" type="text"
                   class="w-full bg-[#1a1d27] border border-white/10 text-white rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-purple-500 placeholder-gray-600"
                   placeholder="{{ __('admin.roles.name_example') }}" />
            @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm text-gray-400 mb-3">{{ __('admin.roles.permissions') }}</label>
            <div class="bg-[#1a1d27] border border-white/10 rounded-lg p-4 space-y-2 max-h-64 overflow-y-auto">
                @forelse($permissions as $perm)
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox"
                               wire:model="selectedPermissions"
                               value="{{ $perm->name }}"
                               class="w-4 h-4 rounded border-white/20 bg-white/5 text-purple-500 focus:ring-purple-500 focus:ring-offset-0 cursor-pointer" />
                        <span class="text-sm text-gray-300 group-hover:text-white transition">{{ $perm->name }}</span>
                    </label>
                @empty
                    <p class="text-gray-500 text-sm">{!! __('admin.roles.no_perms_hint', ['url' => route('admin.permissions.create')]) !!}</p>
                @endforelse
            </div>
            @error('selectedPermissions') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <button type="submit"
                    class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2.5 rounded-lg text-sm font-semibold transition">
                {{ $role ? __('admin.common.save_changes') : __('admin.roles.create') }}
            </button>
        </div>

    </form>
</div>
