@php
$isAr = app()->getLocale() === 'ar';
@endphp

<section class="eq8-areas" dir="{{ $isAr ? 'rtl' : 'ltr' }}"
         aria-label="{{ $isAr ? 'مناطق الخدمة في الكويت' : 'Service Areas in Kuwait' }}">
    <div class="eq8-section-inner">

        <div class="eq8-section-head">
            <h2 class="eq8-section-title">{{ $isAr ? 'مناطق الخدمة في الكويت' : 'Service Areas in Kuwait' }}</h2>
            <h3 class="eq8-section-sub">{{ $isAr
                ? 'نغطي جميع محافظات ومناطق الكويت — خدمة سريعة في موقعك'
                : 'We cover all governorates and areas of Kuwait — fast service at your location' }}</h3>
        </div>

        @livewire('area-search')

        <div class="eq8-areas__banner" data-gov-reveal style="transition-delay: 490ms">
            <div class="eq8-areas__banner-content">
                <span class="eq8-areas__banner-icon" aria-hidden="true">📍</span>
                <div class="eq8-areas__banner-copy">
                    <p class="eq8-areas__banner-text">{{ $isAr
                        ? 'لا تجد منطقتك؟'
                        : "Can't find your area?" }}</p>
                    <p class="eq8-areas__banner-sub">{{ $isAr
                        ? 'تواصل معنا وسنصلك أينما كنت في الكويت'
                        : "Contact us and we'll reach you anywhere in Kuwait" }}</p>
                </div>
            </div>
            <a href="{{ \App\Helpers\WhatsAppHelper::url() }}" target="_blank" rel="noopener" class="eq8-areas__banner-btn">
                <span class="eq8-areas__banner-btn-icon">
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.116 1.528 5.845L0 24l6.335-1.505A11.946 11.946 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.882a9.872 9.872 0 01-5.031-1.378l-.361-.214-3.741.981.999-3.648-.235-.374A9.869 9.869 0 012.118 12C2.118 6.963 6.963 2.118 12 2.118s9.882 4.845 9.882 9.882-4.845 9.882-9.882 9.882z"/>
                    </svg>
                </span>
                {{ $isAr ? 'تواصل عبر واتساب' : 'Contact via WhatsApp' }}
            </a>
        </div>

    </div>
</section>

<style>
.eq8-areas {
    padding: 64px 0;
    background: var(--altBg);
    transition: background .3s ease;
}
.eq8-section-head {
    text-align: center;
    margin-bottom: 48px;
}
.eq8-section-title {
    font-size: 1.85rem;
    font-weight: 800;
    color: var(--text);
    margin: 0 0 10px;
    font-family: 'Cairo', system-ui, sans-serif;
}
.eq8-section-sub {
    font-size: 1rem;
    font-weight: 600;
    color: var(--muted);
    margin: 0;
    font-family: 'Cairo', system-ui, sans-serif;
}
.eq8-areas__grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    align-items: start;
    padding-right: 20px;
    padding-left: 20px;
}
@media (max-width: 900px) { .eq8-areas__grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 540px) { .eq8-areas__grid { grid-template-columns: 1fr; } }

.eq8-gov-card {
    background: var(--cardBg);
    border: 1px solid var(--border);
    border-radius: 14px;
    overflow: hidden;
    opacity: 0;
    transform: translateY(18px);
    transition: opacity .45s ease, transform .45s ease, border-color .2s ease, box-shadow .2s ease;
    font-family: 'Cairo', system-ui, sans-serif;
}
.eq8-gov-card.revealed { opacity: 1; transform: translateY(0); }
.eq8-gov-card:hover {
    border-color: var(--accent);
    box-shadow: 0 8px 28px rgba(107,58,23,.12);
}
.eq8-gov-card.revealed:hover { transform: translateY(-3px); }

.eq8-gov-card__head {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 16px 18px;
    background: var(--altBg);
    border-bottom: 1px solid var(--border);
}
.eq8-gov-card__pin { font-size: 17px; line-height: 1; flex-shrink: 0; }
.eq8-gov-card__name {
    font-size: 1.05rem;
    font-weight: 800;
    color: var(--primary);
    margin: 0;
    flex: 1;
    line-height: 1.3;
}
.eq8-gov-card__count {
    font-size: .68rem;
    font-weight: 700;
    color: var(--accent);
    background: var(--cardBg);
    border: 1px solid var(--accentTint);
    border-radius: 999px;
    padding: 3px 10px;
    flex-shrink: 0;
    white-space: nowrap;
    font-family: 'Cairo', system-ui, sans-serif;
}
.eq8-gov-card__pills {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 8px;
    padding: 16px 18px 18px;
}
@media (max-width: 420px) { .eq8-gov-card__pills { grid-template-columns: 1fr; } }
.eq8-pill {
    display: inline-flex;
    align-items: center;
    background: var(--altBg);
    color: var(--body);
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 6px 12px;
    font-size: .78rem;
    font-weight: 600;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    font-family: 'Cairo', system-ui, sans-serif;
    transition: background .18s ease, color .18s ease, border-color .18s ease;
}
.eq8-pill--link {
    text-decoration: none;
    color: var(--primary);
    background: var(--cardBg);
    border-color: var(--border);
}
.eq8-pill--link:hover {
    background: var(--primary);
    color: #fff;
    border-color: var(--primary);
}

.eq8-areas__banner {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
    flex-wrap: wrap;
    background: linear-gradient(135deg, #43230E 0%, #6B3A17 55%, #8B4D20 100%);
    border-radius: 18px;
    margin-top: 32px;
    padding: 28px 32px;
    color: #fff;
    font-family: 'Cairo', system-ui, sans-serif;
    opacity: 0;
    transform: translateY(18px);
    transition: opacity .45s ease, transform .45s ease;
    overflow: hidden;
}
.eq8-areas__banner::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(ellipse at 15% 50%, rgba(217,123,46,.3) 0%, transparent 60%);
    pointer-events: none;
}
.eq8-areas__banner.revealed { opacity: 1; transform: translateY(0); }

.eq8-areas__banner-content {
    position: relative;
    display: flex;
    align-items: center;
    gap: 16px;
    text-align: start;
}
.eq8-areas__banner-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 48px;
    height: 48px;
    flex-shrink: 0;
    border-radius: 50%;
    background: rgba(255,255,255,.12);
    border: 1px solid rgba(255,255,255,.2);
    font-size: 22px;
}
.eq8-areas__banner-copy { display: flex; flex-direction: column; gap: 2px; }
.eq8-areas__banner-text {
    font-size: 1.05rem;
    font-weight: 800;
    margin: 0;
    color: #fff;
}
.eq8-areas__banner-sub {
    font-size: .85rem;
    font-weight: 600;
    margin: 0;
    color: #F3D9BB;
    opacity: .9;
}
.eq8-areas__banner-btn {
    position: relative;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: #25D366;
    color: #fff;
    border-radius: 999px;
    padding: 6px 22px 6px 6px;
    font-size: .92rem;
    font-weight: 700;
    text-decoration: none;
    white-space: nowrap;
    transition: background .2s ease, transform .2s ease, box-shadow .2s ease;
    font-family: 'Cairo', system-ui, sans-serif;
}
[dir="rtl"] .eq8-areas__banner-btn { padding: 6px 6px 6px 22px; }
.eq8-areas__banner-btn-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: rgba(0,0,0,.15);
    flex-shrink: 0;
}
.eq8-areas__banner-btn:hover {
    background: #20ba58;
    transform: translateY(-2px);
    box-shadow: 0 10px 24px rgba(0,0,0,.25);
}
@media (max-width: 640px) {
    .eq8-areas__banner { flex-direction: column; text-align: center; padding: 28px 24px; }
    .eq8-areas__banner-content { flex-direction: column; text-align: center; }
    .eq8-areas__banner-btn { width: 100%; justify-content: center; }
}
</style>

<script>
(function () {
    var cards = document.querySelectorAll('[data-gov-reveal]');
    if (!cards.length) return;
    if (!window.IntersectionObserver) {
        cards.forEach(function (c) { c.classList.add('revealed'); });
        return;
    }
    var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (e) {
            if (e.isIntersecting) { e.target.classList.add('revealed'); io.unobserve(e.target); }
        });
    }, { threshold: 0.06 });
    cards.forEach(function (c) { io.observe(c); });
})();
</script>
