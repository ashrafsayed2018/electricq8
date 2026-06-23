@php
    $isAr   = app()->getLocale() === 'ar';
    $locale = $isAr ? 'ar' : 'en';
    $prefix = $isAr ? '' : 'en.';
@endphp

<div dir="{{ $isAr ? 'rtl' : 'ltr' }}">

    {{-- ── Toolbar ──────────────────────────────────────────────── --}}
    <div class="gal-toolbar">
        <div class="gal-container gal-toolbar__inner">
            <div class="gal-search">
                <span class="gal-search__btn">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" d="M21 21l-4.35-4.35"/></svg>
                </span>
                <input
                    type="search"
                    wire:model.live.debounce.400ms="search"
                    placeholder="{{ $isAr ? 'ابحث عن صورة...' : 'Search images...' }}"
                    class="gal-search__input"
                    autocomplete="off"
                >
                @if($search)
                <button type="button" wire:click="$set('search','')" class="gal-search__clear" aria-label="{{ $isAr ? 'مسح' : 'Clear' }}">✕</button>
                @endif
            </div>
            <div class="gal-filter-info">
                @if($search)
                    <span>{{ $isAr ? 'نتائج:' : 'Results for:' }} <strong>{{ $search }}</strong> ({{ $images->total() }})</span>
                @else
                    @if($images->total())
                    <span class="gal-showing">
                        {{ $isAr ? 'عرض' : 'Showing' }}
                        <strong>{{ $images->firstItem() }}–{{ $images->lastItem() }}</strong>
                        {{ $isAr ? 'من' : 'of' }}
                        <strong>{{ $total }}</strong>
                    </span>
                    @endif
                @endif
            </div>
        </div>
    </div>

    {{-- ── Loading indicator ───────────────────────────────────── --}}
    <div wire:loading.flex class="gal-loading">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2.5" class="gal-spin"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg>
        <span>{{ $isAr ? 'جاري البحث...' : 'Searching...' }}</span>
    </div>

    {{-- ── Grid ────────────────────────────────────────────────── --}}
    <div class="gal-container gal-body" wire:loading.class="gal-grid-loading">

        @if($images->isEmpty())
        <div class="gal-empty">
            <svg width="56" height="56" fill="none" stroke="#d1d5db" stroke-width="1.3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><circle cx="12" cy="13" r="3"/></svg>
            <p>{{ $isAr ? 'لا توجد صور مطابقة.' : 'No images found.' }}</p>
        </div>
        @else
        <div class="gal-grid">
            @foreach($images as $idx => $image)
            @php
                $name    = $image->getTranslation('name', $locale) ?: $image->getTranslation('name', 'ar');
                $alt     = $image->getTranslation('alt',  $locale) ?: $name;
                $url     = $image->url;
                $fullUrl = request()->getSchemeAndHttpHost() . $url;
            @endphp
            <div class="gal-card">

                {{-- Image --}}
                <div class="gal-card__img-wrap" data-modal-open data-modal-src="{{ $url }}" data-modal-alt="{{ $alt }}" data-modal-title="{{ $name }}" style="cursor:pointer">
                    <img src="{{ $url }}" alt="{{ $alt }}" class="gal-card__img" loading="lazy" decoding="async">
                    <div class="gal-card__overlay">
                        <button type="button" class="gal-card__view-btn" data-modal-open data-modal-src="{{ $url }}" data-modal-alt="{{ $alt }}" data-modal-title="{{ $name }}">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            {{ $isAr ? 'عرض' : 'View' }}
                        </button>
                    </div>
                </div>

                {{-- Body --}}
                <div class="gal-card__body">
                    <h3 class="gal-card__title">{{ $name }}</h3>
                    @php $desc = $image->getTranslation('alt', $locale) @endphp
                    @if($desc && $desc !== $name)
                    <p class="gal-card__desc">{{ $desc }}</p>
                    @endif
                    <div class="gal-card__meta">
                        <span class="gal-card__dims">WebP</span>
                        <span class="gal-card__size">{{ number_format($image->size / 1024, 0) }} KB</span>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="gal-card__actions">
                    @auth
                    <button
                        type="button"
                        class="gal-btn gal-btn--copy"
                        data-copy-url="{{ $fullUrl }}"
                        data-copied-label="{{ $isAr ? 'تم النسخ' : 'Copied!' }}"
                        title="{{ $isAr ? 'نسخ الرابط' : 'Copy URL' }}"
                    >
                        <svg class="gal-copy-icon" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg>
                        <svg class="gal-check-icon" style="display:none" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        <span class="gal-btn-label">{{ $isAr ? 'نسخ' : 'Copy' }}</span>
                    </button>
                    @endauth
                    <button type="button" class="gal-btn gal-btn--view" data-modal-open data-modal-src="{{ $url }}" data-modal-alt="{{ $alt }}" data-modal-title="{{ $name }}">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        {{ $isAr ? 'عرض' : 'View' }}
                    </button>
                </div>

            </div>
            @endforeach
        </div>

        {{-- ── Pagination ──────────────────────────────────────── --}}
        @if($images->hasPages())
        <div class="gal-pagination">
            @if($images->onFirstPage())
                <span class="gal-page-btn gal-page-btn--disabled">{{ $isAr ? '‹ السابق' : '‹ Prev' }}</span>
            @else
                <button type="button" wire:click="previousPage" class="gal-page-btn">{{ $isAr ? '‹ السابق' : '‹ Prev' }}</button>
            @endif

            @foreach($images->getUrlRange(1, $images->lastPage()) as $page => $pageUrl)
                @if($page == $images->currentPage())
                    <span class="gal-page-btn gal-page-btn--active" aria-current="page">{{ $page }}</span>
                @else
                    <button type="button" wire:click="gotoPage({{ $page }})" class="gal-page-btn">{{ $page }}</button>
                @endif
            @endforeach

            @if($images->hasMorePages())
                <button type="button" wire:click="nextPage" class="gal-page-btn">{{ $isAr ? 'التالي ›' : 'Next ›' }}</button>
            @else
                <span class="gal-page-btn gal-page-btn--disabled">{{ $isAr ? 'التالي ›' : 'Next ›' }}</span>
            @endif
        </div>
        @endif

        @endif
    </div>
</div>

<style>
.gal-loading {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 20px;
    color: #16a34a;
    font-family: 'Cairo', sans-serif;
    font-size: 14px;
    font-weight: 600;
}
.gal-spin {
    animation: spin 0.8s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

.gal-grid-loading { opacity: 0.5; pointer-events: none; transition: opacity 0.2s; }

.gal-search__clear {
    background: none;
    border: none;
    padding: 0 10px;
    color: #9ca3af;
    cursor: pointer;
    font-size: 13px;
    font-weight: 700;
    line-height: 1;
    transition: color 0.15s;
}
.gal-search__clear:hover { color: #ef4444; }
</style>
