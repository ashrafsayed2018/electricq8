<div>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-white">
            {{ $permission ? __('admin.permissions.edit') : __('admin.permissions.add_new') }}
        </h1>
        <a href="{{ route('admin.permissions.index') }}"
           class="text-gray-400 hover:text-white text-sm transition">{{ __('admin.common.back_to_list') }}</a>
    </div>

    <form wire:submit="save" class="max-w-xl space-y-5">

        <div>
            <label class="block text-sm text-gray-400 mb-1.5">{{ __('admin.permissions.name_label') }} <span class="text-red-400">{{ __('admin.common.required_mark') }}</span></label>
            <input wire:model="name" type="text"
                   class="w-full bg-[#1a1d27] border border-white/10 text-white rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-purple-500 placeholder-gray-600 font-mono"
                   placeholder="{{ __('admin.permissions.name_example') }}" />
            <p class="text-gray-600 text-xs mt-1">{{ __('admin.permissions.name_hint') }}</p>
            @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <button type="submit"
                    class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2.5 rounded-lg text-sm font-semibold transition">
                {{ $permission ? __('admin.common.save_changes') : __('admin.permissions.create') }}
            </button>
        </div>

    </form>
</div>
