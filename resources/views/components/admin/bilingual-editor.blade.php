@props([
    'label'    => 'المحتوى',
    'modelAr',
    'modelEn',
    'valueAr'  => '',
    'valueEn'  => '',
    'rows'     => 8,
    'required' => false,
])

@php
    $idAr = 'tinymce_' . $modelAr;
    $idEn = 'tinymce_' . $modelEn;
@endphp

<div x-data="{ tab: 'ar' }" class="bg-[#1a1d27] rounded-xl border border-white/10 p-6">

    {{-- Hidden inputs that Livewire reads — updated by JS before submit --}}
    <input type="hidden" wire:model="{{ $modelAr }}" id="hidden_{{ $idAr }}">
    <input type="hidden" wire:model="{{ $modelEn }}" id="hidden_{{ $idEn }}">

    {{-- Header + tab switcher --}}
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-widest">{{ $label }}</h2>
        <div class="flex bg-[#0f1117] rounded-lg p-0.5 gap-0.5 border border-white/10">
            <button type="button" @click="tab = 'ar'"
                :class="tab === 'ar' ? 'bg-purple-600 text-white' : 'text-gray-400 hover:text-white'"
                class="px-4 py-1.5 rounded-md text-xs font-semibold transition">العربية</button>
            <button type="button" @click="tab = 'en'"
                :class="tab === 'en' ? 'bg-purple-600 text-white' : 'text-gray-400 hover:text-white'"
                class="px-4 py-1.5 rounded-md text-xs font-semibold transition">English</button>
        </div>
    </div>

    {{-- TinyMCE textareas — wire:ignore prevents Livewire from touching them --}}
    <div wire:ignore>

        <div :style="tab === 'ar' ? '' : 'display:none'">
            <label class="block text-xs text-gray-500 mb-1">{{ $label }} (عربي){{ $required ? ' *' : '' }}</label>
            <textarea
                id="{{ $idAr }}"
                rows="{{ $rows }}"
                dir="rtl"
                class="w-full bg-[#0f1117] border border-white/10 rounded-lg px-3 py-2 text-sm text-white"
            >{{ $valueAr }}</textarea>
        </div>

        <div :style="tab === 'en' ? '' : 'display:none'">
            <label class="block text-xs text-gray-500 mb-1">{{ $label }} (English){{ $required ? ' *' : '' }}</label>
            <textarea
                id="{{ $idEn }}"
                rows="{{ $rows }}"
                dir="ltr"
                class="w-full bg-[#0f1117] border border-white/10 rounded-lg px-3 py-2 text-sm text-white"
            >{{ $valueEn }}</textarea>
        </div>

    </div>

</div>

<script>
    (function () {
        function tryInit() {
            if (typeof tinymce === 'undefined') { setTimeout(tryInit, 100); return; }

            function init(selector, dir, hiddenId) {
                var id = selector.replace('#', '');
                var existing = tinymce.get(id);
                if (existing) existing.remove();

                tinymce.init({
                    selector: selector,
                    directionality: dir,
                    height: 400,
                    skin: 'oxide-dark',
                    content_css: 'dark',
                    plugins: ['advlist','autolink','lists','link','image','charmap','preview','searchreplace','visualblocks','code','fullscreen','insertdatetime','media','table','wordcount'],
                    toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | bullist numlist | link image | code fullscreen',
                    toolbar_mode: 'sliding',
                    promotion: false,
                    content_style: 'body { font-family: Tahoma, Arial, sans-serif; font-size: 15px; }',
                    setup: function (editor) {
                        editor.on('init', function () {
                            // sync hidden input on init so Livewire has initial value
                            var hidden = document.getElementById(hiddenId);
                            if (hidden && hidden.value) {
                                editor.setContent(hidden.value);
                            }
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
            }

            init('#{{ $idAr }}', 'rtl', 'hidden_{{ $idAr }}');
            init('#{{ $idEn }}', 'ltr', 'hidden_{{ $idEn }}');
        }
        tryInit();
    })();
</script>
