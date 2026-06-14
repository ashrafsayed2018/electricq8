@if($inline)
{{-- ── Inline mode: just the button (used when parent already shows the preview) ── --}}
<div x-data @image-picker-closed.window="document.body.style.overflow = ''">

    <button type="button" wire:click="openModal"
        class="w-full flex items-center justify-center gap-2 bg-white/5 hover:bg-purple-600/20 border border-white/10 hover:border-purple-500/50 text-gray-400 hover:text-purple-300 text-sm font-medium px-4 py-2 rounded-lg transition">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        {{ __('admin.image_picker.choose') }}
    </button>

    @if($open)
    @include('livewire.admin.image-picker-modal')
    @endif
</div>

@else
{{-- ── Full card mode: wrapper + thumbnail + button (used in services/posts forms) ── --}}
<div
    class="bg-[#1a1d27] rounded-xl border border-white/10 p-6"
    x-data
    @image-picker-closed.window="document.body.style.overflow = ''"
>
    @if($label)
    <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-widest mb-4">{{ $label }}</h2>
    @endif

    <div class="flex items-start gap-4">

        {{-- Thumbnail --}}
        <div class="shrink-0 w-32 h-32 rounded-lg border border-white/10 bg-[#0f1117] flex items-center justify-center overflow-hidden">
            @if($imageUrl)
                <img src="{{ $imageUrl }}" class="w-full h-full object-cover">
            @else
                <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            @endif
        </div>

        <div class="flex flex-col gap-2">
            <button type="button" wire:click="openModal"
                class="bg-purple-600 hover:bg-purple-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                {{ __('admin.image_picker.choose') }}
            </button>
            @if($imageUrl)
                <button type="button" wire:click="clear"
                    class="text-xs text-red-400 hover:text-red-300 transition text-start">
                    × {{ __('admin.image_picker.remove') }}
                </button>
                <p class="text-xs text-gray-600 font-mono break-all max-w-xs">{{ $imageUrl }}</p>
            @endif
        </div>
    </div>

    @if($open)
    @include('livewire.admin.image-picker-modal')
    @endif
</div>
@endif
