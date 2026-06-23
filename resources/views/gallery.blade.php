@extends('layouts.app')

@php
    $isAr   = app()->getLocale() === 'ar';
    $locale = $isAr ? 'ar' : 'en';
@endphp

@section('meta_title')
    {{ $isAr
        ? 'معرض الصور — إلكتريك كويت لخدمات الكهرباء'
        : 'Gallery — ElectricQ8 Electrical Services Kuwait' }}
@endsection

@section('meta_description')
    {{ $isAr
        ? 'شاهد صور أعمالنا في مجال الكهرباء والتمديدات والإضاءة في الكويت.'
        : 'Browse our project photos covering electrical wiring, maintenance and lighting across Kuwait.' }}
@endsection

@section('content')
<div dir="{{ $isAr ? 'rtl' : 'ltr' }}" style="font-family:'Cairo',sans-serif;">

    {{-- ── Hero banner ──────────────────────────────────────────── --}}
    <div class="gallery-hero">
        <h1 class="gallery-hero__title">
            {{ $isAr ? 'معرض الصور' : 'Our Gallery' }}
        </h1>
        <p class="gallery-hero__sub">
            {{ $isAr
                ? 'نماذج من أعمالنا في التمديدات الكهربائية والإضاءة والصيانة في جميع أنحاء الكويت'
                : 'A selection of our electrical wiring, lighting and maintenance projects across Kuwait' }}
        </p>
    </div>

    {{-- ── Grid ────────────────────────────────────────────────── --}}
    <div class="container mx-auto px-4 py-14">

        @if($images->isEmpty())
            <div class="gallery-empty">
                <svg width="56" height="56" fill="none" stroke="#d1d5db" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 3h18M3 21h18M9 3v18"/>
                </svg>
                <p>{{ $isAr ? 'لا توجد صور بعد.' : 'No images yet.' }}</p>
            </div>
        @else
            <div class="gallery-grid">
                @foreach($images as $image)
                <div class="gallery-card" data-gallery-reveal>
                    <div class="gallery-card__img-wrap">
                        <img
                            src="{{ $image->url }}"
                            alt="{{ $image->getTranslation('alt', $locale) ?: $image->getTranslation('name', $locale) }}"
                            class="gallery-card__img"
                            loading="lazy"
                            decoding="async"
                        >
                    </div>
                    @if($image->getTranslation('name', $locale))
                    <div class="gallery-card__caption">
                        {{ $image->getTranslation('name', $locale) }}
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        @endif

    </div>
</div>

<style>
/* ── Hero ───────────────────────────────────────────────────────── */
.gallery-hero {
    background: linear-gradient(135deg, #1e3a8a 0%, #1a3ae0 100%);
    padding: 64px 24px 56px;
    text-align: center;
    color: #fff;
}
.gallery-hero__title {
    font-size: clamp(2rem, 5vw, 3rem);
    font-weight: 900;
    margin: 0 0 12px;
    font-family: 'Cairo', sans-serif;
}
.gallery-hero__sub {
    font-size: 1.05rem;
    color: #bfdbfe;
    margin: 0;
    font-family: 'Cairo', sans-serif;
    max-width: 600px;
    margin-inline: auto;
    line-height: 1.7;
}

/* ── Grid ────────────────────────────────────────────────────────── */
.gallery-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
    align-items: start;
}
@media (max-width: 900px) {
    .gallery-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 540px) {
    .gallery-grid { grid-template-columns: 1fr; }
}

/* ── Card ────────────────────────────────────────────────────────── */
.gallery-card {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.45s ease, transform 0.45s ease, box-shadow 0.25s ease;
}
.gallery-card.revealed {
    opacity: 1;
    transform: translateY(0);
}
.gallery-card:hover {
    box-shadow: 0 8px 32px rgba(26,58,224,0.15);
    transform: translateY(-4px);
}
.gallery-card.revealed:hover {
    transform: translateY(-4px);
}

/* ── Image wrapper (fixed aspect ratio 4:3) ──────────────────────── */
.gallery-card__img-wrap {
    position: relative;
    width: 100%;
    aspect-ratio: 4 / 3;
    overflow: hidden;
    background: #f1f5f9;
}
.gallery-card__img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}
.gallery-card:hover .gallery-card__img {
    transform: scale(1.05);
}

/* ── Caption ─────────────────────────────────────────────────────── */
.gallery-card__caption {
    padding: 12px 16px 14px;
    font-size: 0.875rem;
    font-weight: 600;
    color: #374151;
    font-family: 'Cairo', sans-serif;
    text-align: center;
}

/* ── Empty state ─────────────────────────────────────────────────── */
.gallery-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 16px;
    padding: 80px 24px;
    color: #9ca3af;
    font-family: 'Cairo', sans-serif;
    font-size: 1rem;
}
</style>

<script>
(function () {
    var cards = document.querySelectorAll('[data-gallery-reveal]');
    if (!cards.length) return;
    if (!window.IntersectionObserver) {
        cards.forEach(function (c) { c.classList.add('revealed'); });
        return;
    }
    var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (e) {
            if (e.isIntersecting) {
                e.target.classList.add('revealed');
                io.unobserve(e.target);
            }
        });
    }, { threshold: 0.06 });
    cards.forEach(function (c, i) {
        c.style.transitionDelay = (i % 3 * 80) + 'ms';
        io.observe(c);
    });
})();
</script>
@endsection
