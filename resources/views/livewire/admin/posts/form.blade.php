<div>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-white">{{ $post ? __('admin.posts.edit') : __('admin.posts.add_new') }}</h1>
        <a href="{{ route('admin.posts.index') }}" class="text-sm text-gray-400 hover:text-white transition">{{ __('admin.common.back') }}</a>
    </div>

    <form wire:submit="save" class="space-y-6 max-w-4xl">

        {{-- Titles & Slugs --}}
        <div class="bg-[#1a1d27] rounded-xl border border-white/10 p-6">
            <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-widest mb-4">{{ __('admin.posts.title_slug') }}</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs text-gray-500 mb-1">{{ __('admin.common.title_ar') }} {{ __('admin.common.required_mark') }}</label>
                    <input wire:model.blur="title_ar" type="text"
                        class="w-full bg-[#0f1117] border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-purple-500 transition">
                    @if($slug_ar)
                        <p class="text-xs text-gray-500 mt-1 font-mono" dir="rtl">🔗 {{ $slug_ar }}</p>
                    @endif
                    @error('title_ar') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">{{ __('admin.common.title_en') }} {{ __('admin.common.required_mark') }}</label>
                    <input wire:model.blur="title_en" type="text"
                        class="w-full bg-[#0f1117] border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-purple-500 transition">
                    @if($slug_en)
                        <p class="text-xs text-gray-500 mt-1 font-mono" dir="ltr">🔗 {{ $slug_en }}</p>
                    @endif
                    @error('title_en') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">{{ __('admin.common.h1_ar') }}</label>
                    <input wire:model="h1_ar" type="text"
                        class="w-full bg-[#0f1117] border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-purple-500 transition">
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">{{ __('admin.common.h1_en') }}</label>
                    <input wire:model="h1_en" type="text"
                        class="w-full bg-[#0f1117] border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-purple-500 transition">
                </div>
            </div>
        </div>

        {{-- Excerpt --}}
        <x-admin.bilingual-editor
            label="{{ __('admin.posts.excerpt') }}"
            modelAr="excerpt_ar"
            modelEn="excerpt_en"
            :valueAr="$excerpt_ar"
            :valueEn="$excerpt_en"
            :rows="3"
        />

        {{-- Content --}}
        <x-admin.bilingual-editor
            label="{{ __('admin.common.content') }}"
            modelAr="content_ar"
            modelEn="content_en"
            :valueAr="$content_ar"
            :valueEn="$content_en"
            :rows="10"
        />

        {{-- SEO --}}
        <div class="bg-[#1a1d27] rounded-xl border border-white/10 p-6">
            <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-widest mb-4">{{ __('admin.posts.seo') }}</h2>
            <div
                x-data="{ tab: 'ar' }"
                class="space-y-4"
            >
                <div class="flex justify-end">
                    <div class="flex bg-[#0f1117] rounded-lg p-0.5 gap-0.5 border border-white/10">
                        <button type="button" @click="tab = 'ar'"
                            :class="tab === 'ar' ? 'bg-purple-600 text-white' : 'text-gray-400 hover:text-white'"
                            class="px-4 py-1.5 rounded-md text-xs font-semibold transition">{{ __('admin.common.arabic') }}</button>
                        <button type="button" @click="tab = 'en'"
                            :class="tab === 'en' ? 'bg-purple-600 text-white' : 'text-gray-400 hover:text-white'"
                            class="px-4 py-1.5 rounded-md text-xs font-semibold transition">{{ __('admin.common.english') }}</button>
                    </div>
                </div>
                <div x-show="tab === 'ar'" x-cloak class="space-y-4">
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">{{ __('admin.posts.meta_title_ar') }}</label>
                        <input wire:model="meta_title_ar" type="text" dir="rtl"
                            class="w-full bg-[#0f1117] border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-purple-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">{{ __('admin.posts.meta_desc_ar') }}</label>
                        <textarea wire:model="meta_desc_ar" rows="2" dir="rtl"
                            class="w-full bg-[#0f1117] border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-purple-500 transition resize-none"></textarea>
                    </div>
                </div>
                <div x-show="tab === 'en'" x-cloak class="space-y-4">
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">{{ __('admin.posts.meta_title_en') }}</label>
                        <input wire:model="meta_title_en" type="text" dir="ltr"
                            class="w-full bg-[#0f1117] border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-purple-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">{{ __('admin.posts.meta_desc_en') }}</label>
                        <textarea wire:model="meta_desc_en" rows="2" dir="ltr"
                            class="w-full bg-[#0f1117] border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-purple-500 transition resize-none"></textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Category & Tags --}}
        <div class="bg-[#1a1d27] rounded-xl border border-white/10 p-6 space-y-5">

            {{-- Category — custom searchable dropdown --}}
            <div>
                <label class="block text-xs text-gray-500 mb-2 text-right">{{ __('admin.posts.category') }}</label>
                <div x-data="{
                        open: false,
                        search: '',
                        selectedId: @entangle('category_id'),
                        get filtered() {
                            if (!this.search) return this.$refs.list.querySelectorAll('[data-option]');
                            return Array.from(this.$refs.list.querySelectorAll('[data-option]'))
                                       .filter(el => el.dataset.label.includes(this.search));
                        },
                        label() {
                            const el = this.$refs.list ? this.$refs.list.querySelector('[data-value=\"'+this.selectedId+'\"]') : null;
                            return el ? el.dataset.label : '{{ __('admin.posts.no_category') }}';
                        }
                     }"
                     @click.outside="open = false"
                     class="relative">

                    {{-- Trigger --}}
                    <button type="button" @click="open = !open"
                        class="w-full flex items-center justify-between bg-[#0f1117] border border-white/10 rounded-lg px-4 py-2.5 text-sm text-white focus:outline-none focus:border-purple-500 transition"
                        :class="open ? 'border-purple-500' : ''">
                        <span x-text="label()" class="truncate text-right flex-1"></span>
                        <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 text-gray-500 shrink-0 transition-transform ml-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    {{-- Dropdown --}}
                    <div x-show="open" x-transition.opacity
                         class="absolute z-50 mt-1 w-full bg-[#0f1117] border border-white/10 rounded-lg shadow-xl overflow-hidden">
                        <div class="p-2 border-b border-white/10">
                            <input x-model="search" type="text"
                                placeholder="{{ __('admin.posts.search_category') }}"
                                class="w-full bg-[#1a1d27] border border-white/10 rounded-md px-3 py-1.5 text-sm text-white placeholder-gray-600 focus:outline-none focus:border-purple-500 transition text-right"
                                @click.stop>
                        </div>
                        <div class="max-h-52 overflow-y-auto" x-ref="list">
                            <div data-option data-value="" data-label="{{ __('admin.posts.no_category') }}"
                                 @click="selectedId = ''; open = false"
                                 class="flex items-center gap-3 px-4 py-2.5 cursor-pointer hover:bg-white/5 transition"
                                 x-show="!'{{ addslashes(__('admin.posts.no_category')) }}'.includes(search) ? search === '' : true">
                                <input type="radio" :checked="!selectedId" class="w-4 h-4 text-purple-600 bg-[#0f1117] border-white/20" readonly>
                                <span class="text-sm text-gray-400 flex-1 text-right">{{ __('admin.posts.no_category') }}</span>
                            </div>
                            @foreach($allCategories as $cat)
                            @php $catName = $cat->getTranslation('name', app()->getLocale()) ?: $cat->getTranslation('name', 'ar'); @endphp
                            <div data-option data-value="{{ $cat->id }}" data-label="{{ $catName }}"
                                 @click="selectedId = {{ $cat->id }}; open = false"
                                 x-show="search === '' || '{{ $catName }}'.includes(search)"
                                 class="flex items-center gap-3 px-4 py-2.5 cursor-pointer hover:bg-white/5 transition">
                                <input type="radio" :checked="selectedId == {{ $cat->id }}" class="w-4 h-4 text-purple-600 bg-[#0f1117] border-white/20" readonly>
                                <span class="text-sm text-gray-300 flex-1 text-right">{{ $catName }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tags — custom searchable dropdown with checkboxes --}}
            <div>
                <label class="block text-xs text-gray-500 mb-2 text-right">{{ __('admin.posts.tags') }}</label>
                @if($allTags->isNotEmpty())
                <div x-data="{
                        open: false,
                        search: '',
                        get label() {
                            const count = document.querySelectorAll('input[name=tag_cb]:checked').length;
                            return count ? count + ' {{ __('admin.posts.tags_selected') }}' : '{{ __('admin.posts.select_tags') }}';
                        }
                     }"
                     @click.outside="open = false"
                     class="relative">

                    {{-- Trigger --}}
                    <button type="button" @click="open = !open"
                        class="w-full flex items-center justify-between bg-[#0f1117] border border-white/10 rounded-lg px-4 py-2.5 text-sm text-white focus:outline-none focus:border-purple-500 transition"
                        :class="open ? 'border-purple-500' : ''">
                        <span x-text="label" class="truncate text-right flex-1"></span>
                        <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 text-gray-500 shrink-0 transition-transform ml-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    {{-- Dropdown --}}
                    <div x-show="open" x-transition.opacity
                         class="absolute z-40 mt-1 w-full bg-[#0f1117] border border-white/10 rounded-lg shadow-xl overflow-hidden">
                        <div class="p-2 border-b border-white/10">
                            <input x-model="search" type="text"
                                placeholder="{{ __('admin.posts.search_tags') }}"
                                class="w-full bg-[#1a1d27] border border-white/10 rounded-md px-3 py-1.5 text-sm text-white placeholder-gray-600 focus:outline-none focus:border-purple-500 transition text-right"
                                @click.stop>
                        </div>
                        <div class="max-h-52 overflow-y-auto">
                            @foreach($allTags as $tag)
                            @php $tagName = $tag->getTranslation('name', app()->getLocale()) ?: $tag->getTranslation('name', 'ar'); @endphp
                            <label x-show="search === '' || '{{ $tagName }}'.includes(search)"
                                   class="flex items-center gap-3 px-4 py-2.5 cursor-pointer hover:bg-white/5 transition">
                                <input type="checkbox"
                                    name="tag_cb"
                                    wire:model="selected_tags"
                                    value="{{ $tag->id }}"
                                    class="w-4 h-4 rounded border-white/20 bg-[#1a1d27] text-purple-600 focus:ring-purple-500 focus:ring-offset-0 cursor-pointer">
                                <span class="text-sm text-gray-300 flex-1 text-right">{{ $tagName }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                @else
                <p class="text-xs text-gray-600">{{ __('admin.posts.no_tags') }}</p>
                @endif
            </div>

        </div>

        {{-- Featured image --}}
        @livewire('admin.image-picker', ['field' => 'featured_image', 'imageUrl' => $featured_image, 'label' => __('admin.posts.featured_image')])

        {{-- Publish settings --}}
        <div class="bg-[#1a1d27] rounded-xl border border-white/10 p-6">
            <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-widest mb-4">{{ __('admin.common.publish') }}</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs text-gray-500 mb-1">{{ __('admin.posts.publish_date') }}</label>
                    <input wire:model="published_at" type="date"
                        class="w-full bg-[#0f1117] border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-purple-500 transition">
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">{{ __('admin.common.status') }} {{ __('admin.common.required_mark') }}</label>
                    <select wire:model="status"
                        class="w-full bg-[#0f1117] border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-purple-500 transition">
                        <option value="draft">{{ __('admin.posts.draft') }}</option>
                        <option value="published">{{ __('admin.posts.published') }}</option>
                    </select>
                    @error('status') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-1">{{ __('admin.posts.sort_order') }}</label>
                    <input wire:model="sort_order" type="number"
                        class="w-full bg-[#0f1117] border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-purple-500 transition">
                </div>
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit"
                class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg font-semibold text-sm transition">
                {{ $post ? __('admin.posts.save_changes') : __('admin.posts.save') }}
            </button>
            <a href="{{ route('admin.posts.index') }}"
               class="bg-white/5 hover:bg-white/10 text-gray-400 hover:text-white px-6 py-2 rounded-lg text-sm transition">
                {{ __('admin.common.cancel') }}
            </a>
        </div>
    </form>
</div>
