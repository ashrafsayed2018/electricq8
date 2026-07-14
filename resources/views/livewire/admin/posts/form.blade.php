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
            </div>
        </div>

        {{-- Content + Excerpt (combined card) --}}
        <div class="bg-[#1a1d27] rounded-xl border border-white/10 p-6" x-data="{ tab: 'ar' }">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-widest">{{ __('admin.common.content') }}</h2>
                <div class="flex bg-[#0f1117] rounded-lg p-0.5 gap-0.5 border border-white/10">
                    <button type="button" @click="tab = 'ar'"
                        :class="tab === 'ar' ? 'bg-purple-600 text-white' : 'text-gray-400 hover:text-white'"
                        class="px-4 py-1.5 rounded-md text-xs font-semibold transition">العربية</button>
                    <button type="button" @click="tab = 'en'"
                        :class="tab === 'en' ? 'bg-purple-600 text-white' : 'text-gray-400 hover:text-white'"
                        class="px-4 py-1.5 rounded-md text-xs font-semibold transition">English</button>
                </div>
            </div>

            <input type="hidden" wire:model="content_ar" id="hidden_tinymce_content_ar">
            <input type="hidden" wire:model="content_en" id="hidden_tinymce_content_en">

            <div wire:ignore>
                {{-- Arabic --}}
                <div :style="tab === 'ar' ? '' : 'display:none'">
                    <textarea id="tinymce_content_ar" dir="rtl" rows="10"
                        class="w-full bg-[#0f1117] border border-white/10 rounded-lg px-3 py-2 text-sm text-white">{{ $content_ar }}</textarea>
                </div>

                {{-- English --}}
                <div :style="tab === 'en' ? '' : 'display:none'">
                    <textarea id="tinymce_content_en" dir="ltr" rows="10"
                        class="w-full bg-[#0f1117] border border-white/10 rounded-lg px-3 py-2 text-sm text-white">{{ $content_en }}</textarea>
                </div>
            </div>
        </div>

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
                <div x-show="tab === 'ar'" x-cloak>
                    <label class="block text-xs text-gray-500 mb-1">{{ __('admin.posts.meta_desc_ar') }}</label>
                    <textarea wire:model="meta_desc_ar" rows="2" dir="rtl"
                        class="w-full bg-[#0f1117] border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-purple-500 transition resize-none"></textarea>
                </div>
                <div x-show="tab === 'en'" x-cloak>
                    <label class="block text-xs text-gray-500 mb-1">{{ __('admin.posts.meta_desc_en') }}</label>
                    <textarea wire:model="meta_desc_en" rows="2" dir="ltr"
                        class="w-full bg-[#0f1117] border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-purple-500 transition resize-none"></textarea>
                </div>
            </div>
        </div>

        {{-- Cluster & Tags --}}
        <div class="bg-[#1a1d27] rounded-xl border border-white/10 p-6 space-y-6">

            {{-- Cluster --}}
            <div>
                <label class="block text-xs text-gray-500 mb-2">{{ __('admin.posts.cluster') }}</label>
                <select wire:model="cluster_id"
                    class="w-full bg-[#0f1117] border border-white/10 rounded-lg px-3 py-2.5 text-sm text-white focus:outline-none focus:border-purple-500 transition">
                    <option value="">— {{ __('admin.posts.no_cluster') }} —</option>
                    @foreach($allClusters as $cluster)
                    <option value="{{ $cluster->id }}">
                        {{ $cluster->getTranslation('title', app()->getLocale()) ?: $cluster->getTranslation('title', 'ar') }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Tags --}}
            <div>
                <label class="block text-xs text-gray-500 mb-2">{{ __('admin.posts.tags') }}</label>
                <div class="bg-[#0f1117] border border-white/10 rounded-lg overflow-hidden focus-within:border-purple-500 transition">

                    {{-- Search input --}}
                    <div class="flex items-center gap-2 px-3 py-2 border-b border-white/10">
                        <svg class="w-4 h-4 text-gray-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input wire:model.live.debounce.200ms="tag_search"
                            type="text"
                            placeholder="{{ __('admin.posts.search_tags') }}"
                            class="flex-1 bg-transparent text-sm text-white placeholder-gray-600 focus:outline-none">
                        @if($tag_search)
                        <button type="button" wire:click="$set('tag_search','')" class="text-gray-600 hover:text-white transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                        @endif
                    </div>

                    {{-- Scrollable checkbox list --}}
                    <div class="max-h-48 overflow-y-auto divide-y divide-white/5">
                        @forelse($allTags as $tag)
                        @php
                            $tagName = $tag->getTranslation('name', app()->getLocale()) ?: $tag->getTranslation('name', 'ar');
                            $isSelected = in_array((string)$tag->id, array_map('strval', $selected_tags));
                        @endphp
                        <label class="flex items-center gap-3 px-4 py-2.5 cursor-pointer hover:bg-white/5 transition {{ $isSelected ? 'bg-purple-600/10' : '' }}">
                            <input type="checkbox"
                                wire:model.live="selected_tags"
                                value="{{ $tag->id }}"
                                @checked($isSelected)
                                class="w-4 h-4 rounded border-white/20 bg-[#1a1d27] text-purple-600 focus:ring-purple-500 focus:ring-offset-0 cursor-pointer">
                            <span class="text-sm {{ $isSelected ? 'text-white font-medium' : 'text-gray-400' }} flex-1">{{ $tagName }}</span>
                            @if($isSelected)
                            <svg class="w-3.5 h-3.5 text-purple-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            @endif
                        </label>
                        @empty
                        <div class="px-4 py-6 text-center text-xs text-gray-600">{{ __('admin.posts.no_tags') }}</div>
                        @endforelse
                    </div>

                    {{-- Selected count footer --}}
                    @if(count($selected_tags) > 0)
                    <div class="px-4 py-2 border-t border-white/10 bg-purple-600/10">
                        <span class="text-xs text-purple-400">{{ count($selected_tags) }} {{ __('admin.posts.tags_selected') }}</span>
                    </div>
                    @endif

                </div>
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

<script>
(function () {
    var _editors = [
        { id: 'tinymce_content_ar', dir: 'rtl', hidden: 'hidden_tinymce_content_ar' },
        { id: 'tinymce_content_en', dir: 'ltr', hidden: 'hidden_tinymce_content_en' },
    ];

    function initEditor(cfg) {
        var existing = tinymce.get(cfg.id);
        if (existing) existing.remove();

        tinymce.init({
            selector: '#' + cfg.id,
            directionality: cfg.dir,
            height: 500,
            skin: 'oxide-dark',
            content_css: 'dark',
            plugins: ['advlist','autolink','lists','link','image','charmap','preview','searchreplace','visualblocks','code','fullscreen','insertdatetime','media','table','wordcount'],
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | bullist numlist | link image | code fullscreen',
            toolbar_mode: 'sliding',
            promotion: false,
            content_style: 'body { font-family: Tahoma, Arial, sans-serif; font-size: 15px; }',
            setup: function (editor) {
                editor.on('init', function () {
                    var hidden = document.getElementById(cfg.hidden);
                    if (hidden && hidden.value) editor.setContent(hidden.value);
                });
                editor.on('change input', function () {
                    var hidden = document.getElementById(cfg.hidden);
                    if (hidden) {
                        hidden.value = editor.getContent();
                        hidden.dispatchEvent(new Event('input', { bubbles: true }));
                    }
                });
            },
        });
    }

    function tryInit() {
        if (typeof tinymce === 'undefined') { setTimeout(tryInit, 100); return; }
        _editors.forEach(initEditor);
    }

    tryInit();
})();
</script>
