<div dir="{{ $isAr ? 'rtl' : 'ltr' }}">

    <div class="eq8-area-search">
        <span class="eq8-area-search__icon">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="8"/><path stroke-linecap="round" d="M21 21l-4.35-4.35"/></svg>
        </span>
        <input
            type="search"
            wire:model.live.debounce.300ms="search"
            placeholder="{{ $isAr ? 'ابحث عن منطقتك...' : 'Search for your area...' }}"
            class="eq8-area-search__input"
            autocomplete="off"
            aria-label="{{ $isAr ? 'بحث عن منطقة' : 'Search areas' }}"
        >
        @if($search !== '')
        <button type="button" wire:click="$set('search', '')" class="eq8-area-search__clear" aria-label="{{ $isAr ? 'مسح' : 'Clear' }}">✕</button>
        @endif
    </div>

    @if($search !== '')
    <p class="eq8-area-search__meta">
        {{ $isAr ? 'النتائج:' : 'Results:' }} <strong>{{ $total }}</strong>
        {{ $isAr ? 'منطقة' : 'areas' }}
    </p>
    @endif

    <div class="eq8-areas__grid" wire:loading.class="eq8-areas__grid--loading">
        @forelse($govOrder as $govKey)
            @php
                $govAreas = $byGov[$govKey] ?? collect();
                if ($govAreas->isEmpty()) continue;
                $govName = $govMeta[$govKey][$lang] ?? $govKey;
            @endphp
            <div class="eq8-gov-card revealed">
                <div class="eq8-gov-card__head">
                    <span class="eq8-gov-card__pin" aria-hidden="true">📍</span>
                    <h3 class="eq8-gov-card__name">{{ $govName }}</h3>
                    <span class="eq8-gov-card__count">{{ $govAreas->count() }} {{ $isAr ? 'منطقة' : 'areas' }}</span>
                </div>
                <div class="eq8-gov-card__pills">
                    @foreach($govAreas as $loc)
                    @php
                        $areaName = $loc->getTranslation('name', $lang);
                        $areaSlug = $loc->getTranslation('slug', $lang);
                    @endphp
                    <a href="{{ route($isAr ? 'areas.show' : 'en.areas.show', $areaSlug) }}"
                       class="eq8-pill eq8-pill--link">{{ $areaName }}</a>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="eq8-area-search__empty">
                <span aria-hidden="true">🔍</span>
                <p>{{ $isAr ? 'لا توجد مناطق مطابقة لبحثك' : 'No areas match your search' }}</p>
            </div>
        @endforelse
    </div>

</div>

<style>
.eq8-area-search {
    position: relative;
    max-width: 460px;
    margin: 0 auto 36px;
    display: flex;
    align-items: center;
}
.eq8-area-search__icon {
    position: absolute;
    inset-inline-start: 16px;
    display: flex;
    color: var(--muted);
    pointer-events: none;
}
.eq8-area-search__input {
    width: 100%;
    padding: 13px 44px;
    border-radius: 999px;
    border: 1px solid var(--border);
    background: var(--cardBg);
    color: var(--text);
    font-size: .92rem;
    font-weight: 600;
    font-family: 'Cairo', system-ui, sans-serif;
    transition: border-color .18s ease, box-shadow .18s ease;
}
.eq8-area-search__input::placeholder { color: var(--muted); font-weight: 500; }
.eq8-area-search__input:focus {
    outline: none;
    border-color: var(--accent);
    box-shadow: 0 0 0 3px var(--accentTint);
}
.eq8-area-search__clear {
    position: absolute;
    inset-inline-end: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 22px;
    height: 22px;
    border-radius: 50%;
    background: var(--altBg);
    color: var(--muted);
    border: none;
    font-size: .7rem;
    cursor: pointer;
}
.eq8-area-search__clear:hover { background: var(--border); color: var(--text); }
.eq8-area-search__meta {
    text-align: center;
    color: var(--muted);
    font-size: .85rem;
    font-weight: 600;
    font-family: 'Cairo', system-ui, sans-serif;
    margin: -20px 0 24px;
}
.eq8-area-search__meta strong { color: var(--primaryText); }
.eq8-areas__grid--loading { opacity: .5; transition: opacity .15s ease; }
.eq8-area-search__empty {
    grid-column: 1 / -1;
    text-align: center;
    padding: 48px 20px;
    color: var(--muted);
    font-family: 'Cairo', system-ui, sans-serif;
}
.eq8-area-search__empty span { font-size: 2rem; display: block; margin-bottom: 10px; }
.eq8-area-search__empty p { margin: 0; font-weight: 600; }
</style>
