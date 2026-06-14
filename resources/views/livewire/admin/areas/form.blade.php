<div>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-white">{{ $location ? __('admin.areas.edit') : __('admin.areas.add_new') }}</h1>
        <a href="{{ route('admin.areas.index') }}" class="text-sm text-gray-400 hover:text-white transition">{{ __('admin.common.back') }}</a>
    </div>

    <form wire:submit="save" class="space-y-6 max-w-4xl">

        {{-- Name & Slug --}}
        <div class="bg-[#1a1d27] rounded-xl border border-white/10 p-6">
            <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-widest mb-4">{{ __('admin.areas.name_slug') }}</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs text-gray-500 mb-1">{{ __('admin.common.name_ar') }} {{ __('admin.common.required_mark') }}</label>
                    <input wire:model.live="name_ar" type="text"
                        class="w-full bg-[#0f1117] border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-purple-500 transition">
                    @if($slug_ar)
                        <p class="text-xs text-gray-500 mt-1 font-mono" dir="rtl">🔗 {{ $slug_ar }}</p>
                    @endif
                    @error('name_ar') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">{{ __('admin.common.name_en') }} {{ __('admin.common.required_mark') }}</label>
                    <input wire:model.live="name_en" type="text"
                        class="w-full bg-[#0f1117] border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-purple-500 transition">
                    @if($slug_en)
                        <p class="text-xs text-gray-500 mt-1 font-mono" dir="ltr">🔗 {{ $slug_en }}</p>
                    @endif
                    @error('name_en') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- Governorate --}}
        <div class="bg-[#1a1d27] rounded-xl border border-white/10 p-6">
            <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-widest mb-4">{{ __('admin.areas.details') }}</h2>
            <div>
                <label class="block text-xs text-gray-500 mb-1">{{ __('admin.areas.governorate') }} {{ __('admin.common.required_mark') }}</label>
                <select wire:model="governorate"
                    class="w-full bg-[#0f1117] border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-purple-500 transition">
                    <option value="capital">{{ __('admin.areas.governorates.capital') }}</option>
                    <option value="hawalli">{{ __('admin.areas.governorates.hawalli') }}</option>
                    <option value="farwaniya">{{ __('admin.areas.governorates.farwaniya') }}</option>
                    <option value="ahmadi">{{ __('admin.areas.governorates.ahmadi') }}</option>
                    <option value="jahra">{{ __('admin.areas.governorates.jahra') }}</option>
                    <option value="mubarak_al_kabeer">{{ __('admin.areas.governorates.mubarak') }}</option>
                </select>
                @error('governorate') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Description --}}
        <x-admin.bilingual-editor
            label="{{ __('admin.common.description') }}"
            modelAr="description_ar"
            modelEn="description_en"
            :valueAr="$description_ar"
            :valueEn="$description_en"
            :rows="5"
        />

        {{-- Publish --}}
        <div class="bg-[#1a1d27] rounded-xl border border-white/10 p-6">
            <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-widest mb-4">{{ __('admin.common.publish') }}</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs text-gray-500 mb-1">{{ __('admin.common.sort_order') }}</label>
                    <input wire:model="sort_order" type="number"
                        class="w-full bg-[#0f1117] border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-purple-500 transition">
                </div>
                <div class="flex items-end">
                    <label class="flex items-center gap-3 cursor-pointer select-none">
                        <div class="relative">
                            <input wire:model="is_active" type="checkbox" class="sr-only peer">
                            <div class="w-10 h-6 bg-white/10 rounded-full peer-checked:bg-purple-600 transition"></div>
                            <div class="absolute top-1 right-1 w-4 h-4 bg-white rounded-full transition peer-checked:translate-x-[-16px]"></div>
                        </div>
                        <span class="text-sm text-gray-300">{{ __('admin.areas.area_enabled') }}</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit"
                class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg font-semibold text-sm transition">
                {{ $location ? __('admin.common.save_changes') : __('admin.areas.save') }}
            </button>
            <a href="{{ route('admin.areas.index') }}"
               class="bg-white/5 hover:bg-white/10 text-gray-400 hover:text-white px-6 py-2 rounded-lg text-sm transition">
                {{ __('admin.common.cancel') }}
            </a>
        </div>

    </form>
</div>
