<div>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-white">{{ $service ? __('admin.services.edit') : __('admin.services.add_new') }}</h1>
        <a href="{{ route('admin.services.index') }}" class="text-sm text-gray-400 hover:text-white transition">{{ __('admin.common.back') }}</a>
    </div>

    <form wire:submit="save" class="space-y-6 max-w-4xl">

        {{-- Title & Slug --}}
        <div class="bg-[#1a1d27] rounded-xl border border-white/10 p-6">
            <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-widest mb-4">{{ __('admin.services.title_slug') }}</h2>
            <div class="grid grid-cols-2 gap-4">
                <div x-data="{ slug: '{{ $slug_ar }}' }">
                    <label class="block text-xs text-gray-500 mb-1">{{ __('admin.common.title_ar') }} {{ __('admin.common.required_mark') }}</label>
                    <input wire:model.blur="title_ar" type="text"
                        x-on:input="slug = $el.value.replace(/[^؀-ۿ\d\s-]/g,'').trim().replace(/[\s-]+/g,'-')"
                        class="w-full bg-[#0f1117] border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-purple-500 transition">
                    <p x-show="slug" class="text-xs text-gray-500 mt-1 font-mono" dir="rtl">🔗 <span x-text="slug"></span></p>
                    @error('title_ar') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div x-data="{ slug: '{{ $slug_en }}' }">
                    <label class="block text-xs text-gray-500 mb-1">{{ __('admin.common.title_en') }} {{ __('admin.common.required_mark') }}</label>
                    <input wire:model.blur="title_en" type="text"
                        x-on:input="slug = $el.value.toLowerCase().replace(/[^a-z0-9\s-]/g,'').trim().replace(/[\s-]+/g,'-')"
                        class="w-full bg-[#0f1117] border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-purple-500 transition">
                    <p x-show="slug" class="text-xs text-gray-500 mt-1 font-mono" dir="ltr">🔗 <span x-text="slug"></span></p>
                    @error('title_en') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- Content --}}
        <x-admin.bilingual-editor
            label="{{ __('admin.common.content') }}"
            modelAr="content_ar"
            modelEn="content_en"
            :valueAr="$content_ar"
            :valueEn="$content_en"
            :rows="8"
        />
        @error('content_ar') <p class="text-red-400 text-xs -mt-4">{{ $message }}</p> @enderror
        @error('content_en') <p class="text-red-400 text-xs -mt-4">{{ $message }}</p> @enderror

        {{-- Meta Description --}}
        <div class="bg-[#1a1d27] rounded-xl border border-white/10 p-6">
            <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-widest mb-4">{{ __('admin.common.meta_description') }}</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs text-gray-500 mb-1">{{ __('admin.common.meta_description_ar') }} {{ __('admin.common.required_mark') }}</label>
                    <textarea wire:model="meta_description_ar" rows="3" dir="rtl"
                        class="w-full bg-[#0f1117] border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-purple-500 transition resize-none"></textarea>
                    @error('meta_description_ar') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">{{ __('admin.common.meta_description_en') }} {{ __('admin.common.required_mark') }}</label>
                    <textarea wire:model="meta_description_en" rows="3" dir="ltr"
                        class="w-full bg-[#0f1117] border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-purple-500 transition resize-none"></textarea>
                    @error('meta_description_en') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- Image --}}
        @livewire('admin.image-picker', ['field' => 'image_url', 'imageUrl' => $image_url, 'label' => __('admin.common.main_image')])
        @error('image_url') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror

        {{-- Publish --}}
        <div class="bg-[#1a1d27] rounded-xl border border-white/10 p-6">
            <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-widest mb-4">{{ __('admin.common.publish') }}</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs text-gray-500 mb-1">{{ __('admin.common.status') }}</label>
                    <select wire:model="status"
                        class="w-full bg-[#0f1117] border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-purple-500 transition">
                        <option value="active">{{ __('admin.common.active') }}</option>
                        <option value="inactive">{{ __('admin.common.inactive') }}</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">{{ __('admin.common.sort_order') }}</label>
                    <input wire:model="sort_order" type="number"
                        class="w-full bg-[#0f1117] border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-purple-500 transition">
                </div>
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit"
                class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg font-semibold text-sm transition">
                {{ $service ? __('admin.common.save_changes') : __('admin.services.save') }}
            </button>
            <a href="{{ route('admin.services.index') }}"
               class="bg-white/5 hover:bg-white/10 text-gray-400 hover:text-white px-6 py-2 rounded-lg text-sm transition">
                {{ __('admin.common.cancel') }}
            </a>
        </div>

    </form>
</div>
