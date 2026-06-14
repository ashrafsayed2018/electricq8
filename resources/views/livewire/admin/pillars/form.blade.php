<div>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-white">{{ $pillar ? __('admin.pillars.edit') : __('admin.pillars.add_new') }}</h1>
        <a href="{{ route('admin.pillars.index') }}" class="text-sm text-gray-400 hover:text-white transition">{{ __('admin.common.back') }}</a>
    </div>

    <form wire:submit="save" class="space-y-6 max-w-4xl">

        {{-- Titles & Slugs --}}
        <div class="bg-[#1a1d27] rounded-xl border border-white/10 p-6">
            <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-widest mb-4">{{ __('admin.pillars.basic_settings') }}</h2>
            <div class="grid grid-cols-2 gap-4">

                <div x-data="{ slug: '{{ $slug_ar }}' }">
                    <label class="block text-xs text-gray-500 mb-1">{{ __('admin.common.title_ar') }} {{ __('admin.common.required_mark') }}</label>
                    <input wire:model.blur="title_ar" type="text" dir="rtl"
                        x-on:input="slug = $el.value.replace(/[^؀-ۿ\d\s-]/g,'').trim().replace(/[\s-]+/g,'-')"
                        class="w-full bg-[#0f1117] border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-purple-500 transition">
                    <p x-show="slug" class="text-xs text-gray-500 mt-1 font-mono" dir="rtl">🔗 <span x-text="slug"></span></p>
                    @error('title_ar') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div x-data="{ slug: '{{ $slug_en }}' }">
                    <label class="block text-xs text-gray-500 mb-1">{{ __('admin.common.title_en') }} {{ __('admin.common.required_mark') }}</label>
                    <input wire:model.blur="title_en" type="text" dir="ltr"
                        x-on:input="slug = $el.value.toLowerCase().replace(/[^a-z0-9\s-]/g,'').trim().replace(/[\s-]+/g,'-')"
                        class="w-full bg-[#0f1117] border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-purple-500 transition">
                    <p x-show="slug" class="text-xs text-gray-500 mt-1 font-mono" dir="ltr">🔗 <span x-text="slug"></span></p>
                    @error('title_en') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs text-gray-500 mb-1">{{ __('admin.common.h1_ar') }}</label>
                    <input wire:model="h1_ar" type="text" dir="rtl"
                        class="w-full bg-[#0f1117] border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-purple-500 transition">
                </div>

                <div>
                    <label class="block text-xs text-gray-500 mb-1">{{ __('admin.common.h1_en') }}</label>
                    <input wire:model="h1_en" type="text" dir="ltr"
                        class="w-full bg-[#0f1117] border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-purple-500 transition">
                </div>

            </div>
        </div>

        {{-- Intro --}}
        <x-admin.bilingual-editor
            label="{{ __('admin.common.intro') }}"
            modelAr="intro_ar"
            modelEn="intro_en"
            :valueAr="$intro_ar"
            :valueEn="$intro_en"
            :rows="4"
        />

        {{-- Content --}}
        <x-admin.bilingual-editor
            label="{{ __('admin.common.content') }}"
            modelAr="content_ar"
            modelEn="content_en"
            :valueAr="$content_ar"
            :valueEn="$content_en"
            :rows="8"
        />

        {{-- Image --}}
        @livewire('admin.image-picker', ['field' => 'image_url', 'imageUrl' => $image_url, 'label' => __('admin.common.main_image')])

        {{-- Publish Settings --}}
        <div class="bg-[#1a1d27] rounded-xl border border-white/10 p-6">
            <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-widest mb-4">{{ __('admin.common.publish') }}</h2>
            <div class="grid grid-cols-2 gap-4">

                <div>
                    <label class="block text-xs text-gray-500 mb-1">{{ __('admin.common.status') }}</label>
                    <select wire:model="status"
                        class="w-full bg-[#0f1117] border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-purple-500 transition">
                        <option value="active">{{ __('admin.common.active') }}</option>
                        <option value="draft">{{ __('admin.common.draft') }}</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs text-gray-500 mb-1">{{ __('admin.common.sort_order') }}</label>
                    <input wire:model="sort_order" type="number" min="0"
                        class="w-full bg-[#0f1117] border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-purple-500 transition">
                </div>

            </div>
        </div>

        {{-- Submit --}}
        <div class="flex gap-3">
            <button type="submit"
                class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2.5 rounded-lg text-sm font-semibold transition">
                {{ $pillar ? __('admin.common.save_changes') : __('admin.pillars.save') }}
            </button>
            <a href="{{ route('admin.pillars.index') }}"
               class="bg-white/5 hover:bg-white/10 text-gray-300 px-6 py-2.5 rounded-lg text-sm font-semibold transition">
                {{ __('admin.common.cancel') }}
            </a>
        </div>

    </form>
</div>
