@php $isAr = app()->getLocale() === 'ar'; @endphp
<section class="eq8-svc-section" dir="{{ $isAr ? 'rtl' : 'ltr' }}">
    <div class="eq8-section-inner">
        <div class="eq8-section-head">
            <h2 class="eq8-section-title">{{ $isAr ? 'خدماتنا' : 'Our Services' }}</h2>
            <p class="eq8-section-sub">{{ $isAr ? 'حلول كهربائية متكاملة لجميع احتياجاتك' : 'Complete electrical solutions for all your needs' }}</p>
        </div>
        <div class="eq8-svc-grid">
            @foreach($services as $service)
            @php
                $locale   = app()->getLocale();
                $svcRoute = $isAr ? 'services.show' : 'en.services.show';
                $isLast   = $loop->last && $loop->count % 3 === 1;
            @endphp
            <a href="{{ route($svcRoute, $service->getTranslation('slug', $locale)) }}"
               class="eq8-svc-card{{ $isLast ? ' eq8-svc-card--center' : '' }}">
                <div class="eq8-svc-card__icon">{{ $service->icon() }}</div>
                <h3 class="eq8-svc-card__title">{{ $service->title }}</h3>
                <p class="eq8-svc-card__desc">{{ html_entity_decode(strip_tags($service->intro), ENT_QUOTES | ENT_HTML5, 'UTF-8') }}</p>
                <span class="eq8-svc-card__arrow" aria-hidden="true">{{ $isAr ? '←' : '→' }}</span>
            </a>
            @endforeach
        </div>
    </div>
</section>

<style>
.eq8-svc-section {
    padding: 64px 0;
    background: var(--bg);
}
.eq8-section-inner {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
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
    color: var(--muted);
    margin: 0;
    font-family: 'Cairo', system-ui, sans-serif;
}
.eq8-svc-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}
@media (max-width: 900px) { .eq8-svc-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 540px) { .eq8-svc-grid { grid-template-columns: 1fr; } }

.eq8-svc-card {
    display: flex;
    flex-direction: column;
    background: var(--cardBg);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 28px 24px 22px;
    text-decoration: none;
    transition: border-color .2s ease, box-shadow .2s ease, transform .2s ease;
    position: relative;
    overflow: hidden;
}
.eq8-svc-card::before {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: 16px;
    background: linear-gradient(135deg, rgba(107,58,23,.04) 0%, transparent 60%);
    pointer-events: none;
}
.eq8-svc-card:hover {
    border-color: var(--accent);
    box-shadow: 0 8px 32px rgba(107,58,23,.12);
    transform: translateY(-3px);
}
.eq8-svc-card--center { grid-column: 2; }
@media (max-width: 900px) { .eq8-svc-card--center { grid-column: unset; } }

.eq8-svc-card__icon {
    font-size: 2.2rem;
    margin-bottom: 14px;
    line-height: 1;
}
.eq8-svc-card__title {
    font-size: 1rem;
    font-weight: 700;
    color: var(--text);
    margin: 0 0 8px;
    font-family: 'Cairo', system-ui, sans-serif;
}
.eq8-svc-card__desc {
    font-size: .85rem;
    color: var(--body);
    line-height: 1.65;
    margin: 0;
    flex: 1;
    font-family: 'Cairo', system-ui, sans-serif;
}
.eq8-svc-card__arrow {
    display: inline-block;
    margin-top: 16px;
    font-size: 1.1rem;
    color: var(--accent);
    transition: transform .2s ease;
}
.eq8-svc-card:hover .eq8-svc-card__arrow { transform: translateX(-4px); }
[dir="ltr"] .eq8-svc-card:hover .eq8-svc-card__arrow { transform: translateX(4px); }
</style>
