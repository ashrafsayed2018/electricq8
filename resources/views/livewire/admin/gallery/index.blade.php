<div>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-white">{{ __('admin.gallery.title') }}</h1>
    </div>

    {{-- Upload Form --}}
    <div class="bg-[#1a1d27] rounded-xl border border-white/10 p-6 mb-6">
        <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-widest mb-4">{{ __('admin.gallery.upload') }}</h2>

        {{-- Error summary banner --}}
        @if($errors->any())
            <div class="mb-4 bg-red-500/10 border border-red-500/30 rounded-lg p-4 space-y-1" dir="rtl">
                <p class="text-sm font-semibold text-red-400 mb-2">{{ __('admin.gallery.fix_errors') }}</p>
                @foreach($errors->all() as $error)
                    <p class="text-xs text-red-400 flex items-start gap-1.5">
                        <span class="mt-0.5 shrink-0">•</span>{{ $error }}
                    </p>
                @endforeach
            </div>
        @endif

        <form wire:submit="saveImage" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                {{-- Arabic name --}}
                <div>
                    <label class="block text-xs text-gray-500 mb-1">
                        {{ __('admin.gallery.name_ar') }} <span class="text-red-400">{{ __('admin.common.required_mark') }}</span>
                    </label>
                    <input wire:model="name_ar" type="text" dir="rtl"
                        class="w-full bg-[#0f1117] rounded-lg px-3 py-2 text-sm text-white focus:outline-none transition
                               {{ $errors->has('name_ar') ? 'border border-red-500 focus:border-red-500' : 'border border-white/10 focus:border-purple-500' }}">
                    @error('name_ar')
                        <p class="text-red-400 text-xs mt-1 flex items-center gap-1" dir="rtl">
                            <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- English name --}}
                <div>
                    <label class="block text-xs text-gray-500 mb-1">
                        {{ __('admin.gallery.name_en') }} <span class="text-red-400">{{ __('admin.common.required_mark') }}</span>
                    </label>
                    <input wire:model="name_en" type="text" dir="ltr"
                        class="w-full bg-[#0f1117] rounded-lg px-3 py-2 text-sm text-white focus:outline-none transition
                               {{ $errors->has('name_en') ? 'border border-red-500 focus:border-red-500' : 'border border-white/10 focus:border-purple-500' }}">
                    @error('name_en')
                        <p class="text-red-400 text-xs mt-1 flex items-center gap-1" dir="rtl">
                            <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Arabic alt --}}
                <div>
                    <label class="block text-xs text-gray-500 mb-1">{{ __('admin.gallery.alt_ar') }}</label>
                    <input wire:model="alt_ar" type="text" dir="rtl"
                        class="w-full bg-[#0f1117] border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-purple-500 transition">
                </div>

                {{-- English alt --}}
                <div>
                    <label class="block text-xs text-gray-500 mb-1">{{ __('admin.gallery.alt_en') }}</label>
                    <input wire:model="alt_en" type="text" dir="ltr"
                        class="w-full bg-[#0f1117] border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-purple-500 transition">
                </div>
            </div>

            {{-- File picker --}}
            <div>
                <label class="block text-xs text-gray-500 mb-2">
                    {{ __('admin.gallery.image_field') }} <span class="text-red-400">{{ __('admin.common.required_mark') }}</span>
                    <span class="text-gray-600 mr-1">{{ __('admin.gallery.image_hint') }}</span>
                </label>

                <div class="relative">
                    <input wire:model="image" type="file" accept="image/webp"
                        class="block w-full text-sm text-gray-400 cursor-pointer
                               file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0
                               file:text-sm file:font-semibold file:bg-purple-600 file:text-white
                               hover:file:bg-purple-700 file:transition
                               {{ $errors->has('image') ? 'ring-1 ring-red-500 rounded-lg' : '' }}">
                </div>

                @error('image')
                    <p class="text-red-400 text-xs mt-1.5 flex items-center gap-1" dir="rtl">
                        <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                @enderror

                {{-- Upload progress / preview --}}
                <div wire:loading wire:target="image" class="mt-2 text-xs text-purple-400 flex items-center gap-1.5">
                    <svg class="w-3 h-3 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                    </svg>
                    {{ __('admin.gallery.uploading') }}
                </div>

                @if($image && !$errors->has('image'))
                    <div class="mt-3">
                        <img src="{{ $image->temporaryUrl() }}" class="h-24 rounded-lg object-cover border border-white/10">
                    </div>
                @endif
            </div>

            <button type="submit" wire:loading.attr="disabled" wire:target="saveImage"
                class="bg-purple-600 hover:bg-purple-700 disabled:opacity-50 text-white px-6 py-2 rounded-lg font-semibold text-sm transition flex items-center gap-2">
                <span wire:loading.remove wire:target="saveImage">{{ __('admin.gallery.upload_btn') }}</span>
                <span wire:loading wire:target="saveImage" class="flex items-center gap-2">
                    <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                    </svg>
                    {{ __('admin.common.saving') }}
                </span>
            </button>
        </form>
    </div>

    {{-- Search --}}
    <div class="mb-4">
        <input wire:model.live="search" type="text" placeholder="{{ __('admin.gallery.search') }}"
            class="w-full max-w-sm bg-[#1a1d27] border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-purple-500 transition">
    </div>

    {{-- Grid --}}
    @if($items->isEmpty())
        <div class="text-center py-16 text-gray-500 text-sm">{{ __('admin.gallery.empty') }}</div>
    @else
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-6">
            @foreach($items as $media)
                <div class="group relative bg-[#1a1d27] rounded-xl border border-white/10 overflow-hidden">
                    <img src="{{ $media->url }}"
                        alt="{{ $media->getTranslation('alt', app()->getLocale()) }}"
                        class="w-full aspect-square object-cover">

                    <div class="p-2">
                        <p class="text-xs text-white truncate">{{ $media->getTranslation('name', 'en') }}</p>
                        <p class="text-xs text-gray-500 truncate" dir="rtl">{{ $media->getTranslation('name', 'ar') }}</p>
                    </div>

                    <div class="absolute top-2 left-2 right-2 flex justify-between opacity-0 group-hover:opacity-100 transition">
                        <button type="button"
                            wire:click="selectMedia({{ $media->id }})"
                            class="bg-purple-600 hover:bg-purple-700 text-white text-xs px-2 py-1 rounded-md">
                            {{ __('admin.gallery.select') }}
                        </button>
                        <button type="button"
                            wire:click="delete({{ $media->id }})"
                            wire:confirm="{{ __('admin.gallery.confirm_delete') }}"
                            class="bg-red-600 hover:bg-red-700 text-white text-xs px-2 py-1 rounded-md">
                            {{ __('admin.common.delete') }}
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        {{ $items->links() }}
    @endif
</div>
