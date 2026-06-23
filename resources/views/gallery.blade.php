@extends('layouts.app')

@php
    $isAr   = app()->getLocale() === 'ar';
    $locale = $isAr ? 'ar' : 'en';
    $prefix = $isAr ? '' : 'en.';
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
<div dir="{{ $isAr ? 'rtl' : 'ltr' }}" class="gal-page">

    {{-- ── Breadcrumb ──────────────────────────────────────────── --}}
    <div class="gal-breadcrumb">
        <div class="gal-container">
            <a href="{{ route($prefix . 'home') }}" class="gal-bc__link">{{ $isAr ? 'الرئيسية' : 'Home' }}</a>
            <span class="gal-bc__sep" aria-hidden="true">›</span>
            <span class="gal-bc__current">{{ $isAr ? 'معرض الصور' : 'Gallery' }}</span>
        </div>
    </div>

    {{-- ── Header ──────────────────────────────────────────────── --}}
    <div class="gal-header">
        <div class="gal-container">
            <div class="gal-header__badge">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><circle cx="12" cy="13" r="3"/></svg>
                {{ $isAr ? 'معرض الصور' : 'Photo Gallery' }}
            </div>
            <h1 class="gal-header__title">{{ $isAr ? 'معرض صور الكهرباء في الكويت' : 'Electrical Projects Gallery in Kuwait' }}</h1>
            <p class="gal-header__sub">
                {{ $isAr
                    ? 'نعرض لك أبرز الأعمال والتمديدات الكهربائية التي نفذناها في الكويت — مع صور واضحة وأوصاف دقيقة لكل عمل'
                    : 'Browse our best electrical wiring and installation projects across Kuwait — with clear photos and detailed descriptions' }}
            </p>
            <div class="gal-header__count">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                {{ $total }} {{ $isAr ? 'صورة' : 'Images' }}
            </div>
        </div>
    </div>

    {{-- ── Livewire: search + grid + pagination ────────────────── --}}
    <livewire:gallery-search />

</div>

{{-- ── Lightbox Modal ───────────────────────────────────────────── --}}
<div id="galModal" class="gal-modal" role="dialog" aria-modal="true" aria-label="{{ $isAr ? 'عرض الصورة' : 'Image viewer' }}" style="display:none">
    <div class="gal-modal__backdrop"></div>
    <div class="gal-modal__box">
        <div class="gal-modal__header">
            <span class="gal-modal__title" id="galModalTitle"></span>
            <button type="button" class="gal-modal__close" aria-label="{{ $isAr ? 'إغلاق' : 'Close' }}">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="gal-modal__img-wrap">
            <img id="galModalImg" src="" alt="" class="gal-modal__img">
        </div>
    </div>
</div>

<style>
/* ── Base ──────────────────────────────────────────────────────── */
.gal-page { background:#fffbeb; min-height:100vh; font-family:'Cairo',sans-serif; }
.gal-container { max-width:1200px; margin:0 auto; padding-inline:20px; }

/* ── Breadcrumb ────────────────────────────────────────────────── */
.gal-breadcrumb { background:#fff; border-bottom:1px solid #e5e7eb; padding:10px 0; font-size:13px; color:#6b7280; }
.gal-bc__link { color:#ca8a04; text-decoration:none; font-weight:600; }
.gal-bc__link:hover { text-decoration:underline; }
.gal-bc__sep { margin-inline:8px; color:#d1d5db; }
.gal-bc__current { color:#374151; font-weight:600; }

/* ── Header ────────────────────────────────────────────────────── */
.gal-header { background:linear-gradient(135deg,#78350f 0%,#ca8a04 100%); padding:48px 0 40px; text-align:center; color:#fff; }
.gal-header__badge { display:inline-flex; align-items:center; gap:6px; background:rgba(255,255,255,.15); border:1px solid rgba(255,255,255,.25); border-radius:999px; padding:5px 16px; font-size:13px; font-weight:600; margin-bottom:16px; }
.gal-header__title { font-size:clamp(1.6rem,4vw,2.4rem); font-weight:900; margin:0 0 12px; }
.gal-header__sub { font-size:1rem; color:#fef3c7; max-width:640px; margin:0 auto 20px; line-height:1.75; }
.gal-header__count { display:inline-flex; align-items:center; gap:6px; background:rgba(255,255,255,.15); border-radius:999px; padding:5px 16px; font-size:13px; font-weight:700; }

/* ── Toolbar ────────────────────────────────────────────────────── */
.gal-toolbar { background:#fff; border-bottom:1px solid #e5e7eb; padding:14px 0; position:sticky; top:64px; z-index:10; box-shadow:0 2px 8px rgba(0,0,0,.04); }
.gal-toolbar__inner { display:flex; align-items:center; gap:16px; flex-wrap:wrap; }
.gal-search { display:flex; align-items:center; background:#f9fafb; border:1.5px solid #e5e7eb; border-radius:10px; overflow:hidden; flex:1; min-width:200px; max-width:420px; transition:border-color .2s; }
.gal-search:focus-within { border-color:#ca8a04; }
.gal-search__btn { background:none; border:none; padding:0 12px; color:#9ca3af; display:flex; align-items:center; }
.gal-search__input { flex:1; border:none; background:transparent; padding:9px 4px; font-size:14px; font-family:'Cairo',sans-serif; color:#111827; outline:none; }
.gal-search__input::placeholder { color:#9ca3af; }
.gal-search__clear { background:none; border:none; padding:0 10px; color:#9ca3af; cursor:pointer; font-size:13px; font-weight:700; transition:color .15s; }
.gal-search__clear:hover { color:#ef4444; }
.gal-filter-info { font-size:13px; color:#6b7280; display:flex; align-items:center; gap:8px; margin-inline-start:auto; }

/* ── Loading ────────────────────────────────────────────────────── */
.gal-loading { display:flex; align-items:center; justify-content:center; gap:10px; padding:20px; color:#ca8a04; font-family:'Cairo',sans-serif; font-size:14px; font-weight:600; }
.gal-spin { animation:spin .8s linear infinite; }
@keyframes spin { to { transform:rotate(360deg); } }
.gal-grid-loading { opacity:.5; pointer-events:none; transition:opacity .2s; }

/* ── Body ───────────────────────────────────────────────────────── */
.gal-body { padding-top:32px; padding-bottom:48px; }

/* ── Grid ───────────────────────────────────────────────────────── */
.gal-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:20px; align-items:start; }
@media (max-width:900px)  { .gal-grid { grid-template-columns:repeat(2,1fr); } }
@media (max-width:560px)  { .gal-grid { grid-template-columns:1fr; } }

/* ── Card ───────────────────────────────────────────────────────── */
.gal-card { background:#fff; border-radius:16px; box-shadow:0 1px 4px rgba(0,0,0,.07),0 4px 16px rgba(0,0,0,.05); overflow:hidden; transition:box-shadow .25s ease,transform .25s ease; display:flex; flex-direction:column; }
.gal-card:hover { box-shadow:0 8px 32px rgba(202,138,4,.18); transform:translateY(-4px); }

/* ── Card image ─────────────────────────────────────────────────── */
.gal-card__img-wrap { position:relative; width:100%; aspect-ratio:16/10; overflow:hidden; background:#fef9c3; }
.gal-card__img { width:100%; height:100%; object-fit:cover; transition:transform .4s ease; }
.gal-card:hover .gal-card__img { transform:scale(1.06); }
.gal-card__overlay { position:absolute; inset:0; background:rgba(0,0,0,.35); display:flex; align-items:center; justify-content:center; opacity:0; transition:opacity .3s ease; }
.gal-card:hover .gal-card__overlay { opacity:1; }
.gal-card__view-btn { display:inline-flex; align-items:center; gap:6px; background:#fff; color:#ca8a04; border:none; border-radius:8px; padding:8px 18px; font-size:13px; font-weight:700; cursor:pointer; font-family:'Cairo',sans-serif; transition:background .2s; }
.gal-card__view-btn:hover { background:#fefce8; }

/* ── Card body ──────────────────────────────────────────────────── */
.gal-card__body { padding:14px 16px 10px; flex:1; }
.gal-card__title { font-size:14px; font-weight:700; color:#111827; margin:0 0 6px; line-height:1.5; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
.gal-card__desc { font-size:12px; color:#6b7280; margin:0 0 10px; line-height:1.6; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
.gal-card__meta { display:flex; align-items:center; gap:6px; flex-wrap:wrap; }
.gal-card__dims,.gal-card__size { font-size:11px; font-weight:600; padding:2px 8px; border-radius:6px; background:#fefce8; color:#a16207; border:1px solid #fde047; }

/* ── Card actions ───────────────────────────────────────────────── */
.gal-card__actions { display:flex; gap:8px; padding:10px 16px 14px; border-top:1px solid #f3f4f6; }
.gal-btn { display:inline-flex; align-items:center; gap:5px; border-radius:8px; padding:6px 14px; font-size:12px; font-weight:700; font-family:'Cairo',sans-serif; cursor:pointer; text-decoration:none; transition:background .2s,color .2s,transform .15s; border:none; white-space:nowrap; }
.gal-btn:active { transform:scale(0.96); }
.gal-btn--copy { background:#fefce8; color:#a16207; border:1.5px solid #fde047; }
.gal-btn--copy:hover { background:#ca8a04; color:#fff; border-color:#ca8a04; }
.gal-btn--copy.copied { background:#fef9c3; color:#a16207; }
.gal-btn--view { background:#ca8a04; color:#fff; border:1.5px solid #ca8a04; flex:1; justify-content:center; }
.gal-btn--view:hover { background:#a16207; border-color:#a16207; }

/* ── Pagination ─────────────────────────────────────────────────── */
.gal-pagination { display:flex; align-items:center; justify-content:center; gap:6px; margin-top:40px; flex-wrap:wrap; }
.gal-page-btn { display:inline-flex; align-items:center; justify-content:center; min-width:36px; height:36px; padding:0 12px; border-radius:8px; font-size:13px; font-weight:600; font-family:'Cairo',sans-serif; text-decoration:none; background:#fff; color:#374151; border:1.5px solid #e5e7eb; cursor:pointer; transition:background .18s,color .18s,border-color .18s; }
.gal-page-btn:hover { background:#fefce8; border-color:#fde047; color:#ca8a04; }
.gal-page-btn--active { background:#ca8a04; color:#fff; border-color:#ca8a04; pointer-events:none; }
.gal-page-btn--disabled { color:#d1d5db; pointer-events:none; cursor:default; border:none; background:transparent; }

/* ── Empty ──────────────────────────────────────────────────────── */
.gal-empty { display:flex; flex-direction:column; align-items:center; gap:16px; padding:80px 24px; color:#9ca3af; font-size:1rem; }

/* ── Modal ──────────────────────────────────────────────────────── */
.gal-modal { position:fixed; inset:0; z-index:9999; display:flex; align-items:center; justify-content:center; padding:16px; font-family:'Cairo',sans-serif; }
.gal-modal__backdrop { position:absolute; inset:0; background:rgba(0,0,0,.88); cursor:pointer; }
.gal-modal__box { position:relative; background:#1a3a2a; border-radius:16px; overflow:hidden; max-width:min(520px,92vw); display:flex; flex-direction:column; box-shadow:0 24px 80px rgba(0,0,0,.7); animation:galModalIn .25s ease; }
@keyframes galModalIn { from{opacity:0;transform:scale(.93)} to{opacity:1;transform:scale(1)} }
.gal-modal__header { display:flex; align-items:center; justify-content:space-between; padding:12px 14px; background:rgba(0,0,0,.6); flex-shrink:0; gap:10px; }
.gal-modal__title { font-size:14px; font-weight:700; color:#f9fafb; min-width:0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; direction:rtl; text-align:right; flex:1; }
.gal-modal__close { display:flex; align-items:center; justify-content:center; width:34px; height:34px; border:none; background:rgba(255,255,255,.15); border-radius:8px; color:#f9fafb; cursor:pointer; flex-shrink:0; transition:background .18s; }
.gal-modal__close:hover { background:rgba(239,68,68,.8); }
.gal-modal__img-wrap { display:flex; align-items:center; justify-content:center; }
.gal-modal__img { width:100%; height:auto; display:block; max-height:80vh; object-fit:contain; }
</style>

<script>
/* ── Reveal cards ─────────────────────────────────────────────── */
function galReveal() {
    document.querySelectorAll('[data-reveal]').forEach(function(c) {
        c.classList.add('revealed');
    });
}
galReveal();

/* Re-run after every Livewire network round-trip */
document.addEventListener('livewire:request', function() {
    /* nothing — wait for response */
});
document.addEventListener('livewire:commit', galReveal);
/* Fallback for older Livewire 3 builds */
window.addEventListener('livewire:update', galReveal);

/* ── Copy URL ─────────────────────────────────────────────────── */
document.addEventListener('click', function(e) {
    var btn = e.target.closest('[data-copy-url]');
    if (!btn) return;
    var url       = btn.dataset.copyUrl;
    var label     = btn.querySelector('.gal-btn-label');
    var iconCopy  = btn.querySelector('.gal-copy-icon');
    var iconCheck = btn.querySelector('.gal-check-icon');
    var origLabel = label.textContent.trim();

    function showCopied() {
        btn.classList.add('copied');
        iconCopy.style.display  = 'none';
        iconCheck.style.display = '';
        label.textContent = btn.dataset.copiedLabel;
        setTimeout(function(){
            btn.classList.remove('copied');
            iconCopy.style.display  = '';
            iconCheck.style.display = 'none';
            label.textContent = origLabel;
        }, 2000);
    }

    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(url).then(showCopied).catch(function(){ fallbackCopy(url); showCopied(); });
    } else { fallbackCopy(url); showCopied(); }
});

function fallbackCopy(text) {
    var ta = document.createElement('textarea');
    ta.value = text;
    ta.style.cssText = 'position:fixed;top:0;left:0;opacity:0;pointer-events:none';
    document.body.appendChild(ta); ta.focus(); ta.select();
    try { document.execCommand('copy'); } catch(e) {}
    document.body.removeChild(ta);
}

/* ── Lightbox Modal ────────────────────────────────────────────── */
(function(){
    var modal      = document.getElementById('galModal');
    var modalImg   = document.getElementById('galModalImg');
    var modalTitle = document.getElementById('galModalTitle');

    function openModal(src, alt, title) {
        modalImg.src = src; modalImg.alt = alt || '';
        modalTitle.textContent = title || '';
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        modal.querySelector('.gal-modal__close').focus();
    }
    function closeModal() {
        modal.style.display = 'none';
        document.body.style.overflow = '';
        modalImg.src = '';
    }

    document.addEventListener('click', function(e){
        var trigger = e.target.closest('[data-modal-open]');
        if (trigger) { e.preventDefault(); openModal(trigger.dataset.modalSrc, trigger.dataset.modalAlt, trigger.dataset.modalTitle); return; }
        if (e.target === modal.querySelector('.gal-modal__backdrop')) closeModal();
        if (e.target.closest('.gal-modal__close')) closeModal();
    });
    document.addEventListener('keydown', function(e){ if(e.key==='Escape' && modal.style.display!=='none') closeModal(); });
})();
</script>
@endsection
