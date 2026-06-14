<div>
    {{-- Search --}}
    <div class="mb-4">
        <input wire:model.live="search" type="text" placeholder="بحث عن صورة..."
            class="w-full max-w-sm bg-[#1a1d27] border border-white/10 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-purple-500 transition">
    </div>

    @if($items->isEmpty())
        <div class="text-center py-12 text-gray-500 text-sm">
            لا توجد صور في المعرض بعد —
            <a href="{{ route('admin.gallery.index') }}" target="_blank" class="text-purple-400 hover:underline">ارفع صورة</a>
        </div>
    @else
        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-3 mb-4">
            @foreach($items as $media)
                <button type="button" wire:click="select({{ $media->id }})"
                    class="group relative rounded-xl overflow-hidden border border-white/10 hover:border-purple-500 transition aspect-square">
                    <img src="{{ $media->url }}"
                        alt="{{ $media->getTranslation('alt', app()->getLocale()) }}"
                        class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-purple-600/0 group-hover:bg-purple-600/30 transition flex items-center justify-center">
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
