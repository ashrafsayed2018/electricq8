<div
    x-data
    x-init="document.body.style.overflow = 'hidden'"
    x-on:keydown.escape.window="$wire.closeModal()"
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
>
    <div class="absolute inset-0 bg-black/70" wire:click="closeModal"></div>

    <div class="relative z-10 w-full max-w-5xl max-h-[90vh] bg-[#12141f] rounded-2xl border border-white/10 flex flex-col overflow-hidden">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-white/10 shrink-0">
            <h3 class="text-base font-bold text-white">{{ __('admin.image_picker.modal_title') }}</h3>
            <button type="button" wire:click="closeModal" class="text-gray-400 hover:text-white transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Search --}}
        <div class="px-4 pt-4 shrink-0">
            <input wire:model.live="search" type="text" placeholder="{{ __('admin.image_picker.search') }}"
                class="w-full max-w-sm bg-[#1a1d27] border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-purple-500 transition">
        </div>

        {{-- Grid --}}
        <div class="overflow-y-auto flex-1 p-4">
            @if($items->isEmpty())
                <div class="text-center py-12 text-gray-500 text-sm">
                    {{ __('admin.image_picker.empty') }} —
                    <a href="{{ route('admin.gallery.index') }}" target="_blank" class="text-purple-400 hover:underline">{{ __('admin.image_picker.upload') }}</a>
                </div>
            @else
                <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-3 mb-4">
                    @foreach($items as $media)
                        <button type="button" wire:click="pick({{ $media->id }})"
                            title="{{ $media->getTranslation('name', 'en') }}"
                            class="group relative rounded-xl overflow-hidden border border-white/10 hover:border-purple-500 transition aspect-square">
                            <img src="{{ $media->url }}"
                                alt="{{ $media->getTranslation('alt', app()->getLocale()) }}"
                                class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-purple-600/0 group-hover:bg-purple-600/40 transition flex items-center justify-center">
                                <svg class="w-6 h-6 text-white opacity-0 group-hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                        </button>
                    @endforeach
                </div>
                {{ $items->links() }}
            @endif
        </div>
    </div>
</div>
