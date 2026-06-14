<div>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-white">
            {{ $user ? __('admin.users.edit') : __('admin.users.add_new') }}
        </h1>
        <a href="{{ route('admin.users.index') }}"
           class="text-gray-400 hover:text-white text-sm transition">
            {{ __('admin.common.back_to_list') }}
        </a>
    </div>

    <form wire:submit="save" class="max-w-xl space-y-5">

        <div>
            <label class="block text-sm text-gray-400 mb-1.5">{{ __('admin.users.name') }} <span class="text-red-400">{{ __('admin.common.required_mark') }}</span></label>
            <input wire:model="name" type="text"
                   class="w-full bg-[#1a1d27] border border-white/10 text-white rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-purple-500 placeholder-gray-600"
                   placeholder="{{ __('admin.users.name') }}" />
            @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm text-gray-400 mb-1.5">{{ __('admin.users.email') }} <span class="text-red-400">{{ __('admin.common.required_mark') }}</span></label>
            <input wire:model="email" type="email"
                   class="w-full bg-[#1a1d27] border border-white/10 text-white rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-purple-500 placeholder-gray-600"
                   placeholder="example@email.com" />
            @error('email') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div x-data="{ show: false }">
            <label class="block text-sm text-gray-400 mb-1.5">
                {{ __('admin.users.password') }}
                @if($user) <span class="text-gray-600 text-xs">{{ __('admin.users.password_hint') }}</span> @else <span class="text-red-400">{{ __('admin.common.required_mark') }}</span> @endif
            </label>
            <div class="relative">
                <input wire:model="password" :type="show ? 'text' : 'password'"
                       class="w-full bg-[#1a1d27] border border-white/10 text-white rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-purple-500 placeholder-gray-600 pl-10"
                       placeholder="{{ __('admin.users.password_min') }}" />
                <button type="button" @click="show = !show"
                        class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-300 transition">
                    <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <svg x-show="show" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" x-cloak>
                        <path d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                    </svg>
                </button>
            </div>
            @error('password') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm text-gray-400 mb-1.5">{{ __('admin.users.role') }} <span class="text-red-400">{{ __('admin.common.required_mark') }}</span></label>
            <select wire:model="role"
                    class="w-full bg-[#1a1d27] border border-white/10 text-white rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:border-purple-500">
                @foreach($roles as $r)
                    <option value="{{ $r }}">{{ $r }}</option>
                @endforeach
            </select>
            @error('role') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="pt-2">
            <button type="submit"
                    class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2.5 rounded-lg text-sm font-semibold transition">
                {{ $user ? __('admin.common.save_changes') : __('admin.users.create') }}
            </button>
        </div>

    </form>
</div>
