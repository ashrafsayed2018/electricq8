<div class="space-y-5">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-white">{{ __('admin.tags.title') }}</h1>
            <p class="text-gray-500 text-xs mt-0.5">{{ __('admin.tags.subtitle') }}</p>
        </div>
        <button wire:click="openCreate"
            class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 4v16m8-8H4"/>
            </svg>
            {{ __('admin.tags.add_new') }}
        </button>
    </div>

    {{-- Inline create/edit form --}}
    @if($showForm)
    <div class="bg-[#1a1d27] rounded-xl border border-purple-500/40 p-6">
        <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-widest mb-4">
            {{ $editingId ? __('admin.tags.edit') : __('admin.tags.add_new') }}
        </h2>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs text-gray-500 mb-1">{{ __('admin.common.name_ar') }} *</label>
                <input wire:model="name_ar" type="text" dir="rtl"
                    class="w-full bg-[#0f1117] border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-purple-500 transition"
                    placeholder="مثال: كهرباء">
                @error('name_ar') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1">{{ __('admin.common.name_en') }} *</label>
                <input wire:model="name_en" type="text" dir="ltr"
                    class="w-full bg-[#0f1117] border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-purple-500 transition"
                    placeholder="e.g. electrical">
                @error('name_en') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- TinyMCE content editors (full width, below name row) --}}
        <input type="hidden" wire:model="content_ar" id="tag_hidden_content_ar">
        <input type="hidden" wire:model="content_en" id="tag_hidden_content_en">

        <div wire:ignore class="grid grid-cols-2 gap-4 mt-4">
            <div>
                <label class="block text-xs text-gray-500 mb-1">{{ __('admin.tags.content_ar') }}</label>
                <textarea id="tag_tinymce_content_ar" dir="rtl">{{ $content_ar }}</textarea>
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1">{{ __('admin.tags.content_en') }}</label>
                <textarea id="tag_tinymce_content_en" dir="ltr">{{ $content_en }}</textarea>
            </div>
        </div>

        <div class="flex gap-3 mt-4">
            <button
                @click="['ar','en'].forEach(function(l){var e=tinymce&&tinymce.get('tag_tinymce_content_'+l);if(e){var h=document.getElementById('tag_hidden_content_'+l);if(h){h.value=e.getContent();h.dispatchEvent(new Event('input',{bubbles:true}));}}});$nextTick(()=>$wire.save())"
                class="bg-purple-600 hover:bg-purple-700 text-white px-5 py-2 rounded-lg text-sm font-semibold transition">
                {{ $editingId ? __('admin.tags.save_changes') : __('admin.tags.save') }}
            </button>
            <button wire:click="cancelForm"
                class="bg-white/5 hover:bg-white/10 text-gray-400 hover:text-white px-5 py-2 rounded-lg text-sm transition">
                {{ __('admin.common.cancel') }}
            </button>
        </div>
    </div>
    @endif

    {{-- Search --}}
    <div class="relative max-w-sm">
        <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500 pointer-events-none"
             fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        <input wire:model.live.debounce.300ms="search" type="text"
               placeholder="{{ __('admin.tags.search') }}"
               class="w-full bg-[#1a1d27] border border-white/10 rounded-lg pr-9 pl-4 py-2 text-sm text-white placeholder-gray-600 focus:outline-none focus:border-purple-500 transition">
        @if($search)
        <button wire:click="$set('search','')"
                class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-white transition">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        @endif
    </div>

    {{-- Table --}}
    <div class="bg-[#1a1d27] rounded-xl border border-white/10 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="border-b border-white/10 text-gray-500 text-xs uppercase tracking-wide">
                <tr>
                    <th class="px-4 py-3 text-right">#</th>
                    <th class="px-4 py-3 text-right">{{ __('admin.common.name_ar') }}</th>
                    <th class="px-4 py-3 text-right">{{ __('admin.common.name_en') }}</th>
                    <th class="px-4 py-3 text-right">{{ __('admin.tags.posts_count') }}</th>
                    <th class="px-4 py-3 text-right">{{ __('admin.common.actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($tags as $tag)
                <tr class="hover:bg-white/3 transition">
                    <td class="px-4 py-3 text-gray-600 font-mono text-xs">{{ $tag->id }}</td>
                    <td class="px-4 py-3">
                        <span class="text-white font-medium" dir="rtl">{{ $tag->getTranslation('name', 'ar') }}</span>
                    </td>
                    <td class="px-4 py-3">
                        <span class="text-gray-300" dir="ltr">{{ $tag->getTranslation('name', 'en') }}</span>
                    </td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-purple-500/15 text-purple-400">
                            {{ $tag->posts_count }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">
                            <button wire:click="openEdit({{ $tag->id }})"
                                class="inline-flex items-center gap-1.5 bg-purple-600/15 hover:bg-purple-600 text-purple-400 hover:text-white px-3 py-1.5 rounded-lg text-xs font-medium transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                {{ __('admin.common.edit') }}
                            </button>
                            <button wire:click="delete({{ $tag->id }})"
                                wire:confirm="{{ __('admin.tags.confirm_delete') }}"
                                class="inline-flex items-center gap-1.5 bg-red-500/10 hover:bg-red-600 text-red-400 hover:text-white px-3 py-1.5 rounded-lg text-xs font-medium transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                {{ __('admin.common.delete') }}
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-16 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="w-12 h-12 rounded-full bg-white/5 flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                            </div>
                            <p class="text-gray-500 text-sm">
                                {{ $search ? __('admin.tags.no_results') : __('admin.tags.empty') }}
                            </p>
                            @if(!$search)
                            <button wire:click="openCreate" class="text-purple-400 hover:text-purple-300 text-xs transition">
                                {{ __('admin.tags.add_first') }}
                            </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($tags->hasPages())
        <div class="px-4 py-3 border-t border-white/10">
            {{ $tags->links() }}
        </div>
        @endif
    </div>

</div>

<script>
(function () {
    function initTagEditors() {
        if (typeof tinymce === 'undefined') { setTimeout(initTagEditors, 100); return; }

        ['ar', 'en'].forEach(function (lang) {
            var id       = 'tag_tinymce_content_' + lang;
            var hiddenId = 'tag_hidden_content_' + lang;
            var existing = tinymce.get(id);
            if (existing) existing.remove();

            if (!document.getElementById(id)) return;

            tinymce.init({
                selector: '#' + id,
                directionality: lang === 'ar' ? 'rtl' : 'ltr',
                height: 300,
                skin: 'oxide-dark',
                content_css: 'dark',
                plugins: ['advlist','autolink','lists','link','charmap','searchreplace','visualblocks','code','fullscreen','wordcount'],
                toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | bullist numlist | link | code fullscreen',
                toolbar_mode: 'sliding',
                promotion: false,
                content_style: 'body { font-family: Tahoma, Arial, sans-serif; font-size: 15px; }',
                setup: function (editor) {
                    editor.on('init', function () {
                        var hidden = document.getElementById(hiddenId);
                        if (hidden && hidden.value) editor.setContent(hidden.value);
                    });
                    editor.on('change input', function () {
                        var hidden = document.getElementById(hiddenId);
                        if (hidden) {
                            hidden.value = editor.getContent();
                            hidden.dispatchEvent(new Event('input', { bubbles: true }));
                        }
                    });
                },
            });
        });
    }

    document.addEventListener('DOMContentLoaded', initTagEditors);
    document.addEventListener('livewire:update', function () { setTimeout(initTagEditors, 50); });
})();
</script>
