@if($testimonials->count())
@php $isAr = app()->getLocale() === 'ar'; @endphp
<section class="eq8-reviews" dir="{{ $isAr ? 'rtl' : 'ltr' }}">
    <div class="eq8-section-inner">
        <div class="eq8-section-head">
            <h2 class="eq8-section-title">{{ $isAr ? 'آراء عملائنا' : 'Customer Reviews' }}</h2>
            <p class="eq8-section-sub">{{ $isAr ? 'تقييمات حقيقية من عملائنا في الكويت' : 'Genuine reviews from our customers across Kuwait' }}</p>
        </div>
        <div class="eq8-reviews__grid">
            @foreach($testimonials as $testimonial)
            <div class="eq8-review-card">
                <div class="eq8-review-card__stars">
                    @for($i = 0; $i < 5; $i++)
                        <span class="{{ $i < $testimonial->rating ? 'eq8-star--on' : 'eq8-star--off' }}">★</span>
                    @endfor
                </div>
                <p class="eq8-review-card__body">"{{ $testimonial->body }}"</p>
                <div class="eq8-review-card__meta">
                    <span class="eq8-review-card__avatar">{{ mb_substr($testimonial->client_name, 0, 1) }}</span>
                    <div>
                        <p class="eq8-review-card__name">{{ $testimonial->client_name }}</p>
                        @if($testimonial->area)
                        <p class="eq8-review-card__area">{{ $testimonial->area->name }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<style>
.eq8-reviews {
    padding: 64px 0;
    background: var(--bg);
}
.eq8-reviews__grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}
@media (max-width: 900px) { .eq8-reviews__grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 540px) { .eq8-reviews__grid { grid-template-columns: 1fr; } }

.eq8-review-card {
    background: var(--cardBg);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 24px;
    display: flex;
    flex-direction: column;
    gap: 14px;
    font-family: 'Cairo', system-ui, sans-serif;
    transition: border-color .2s ease, box-shadow .2s ease;
}
.eq8-review-card:hover {
    border-color: var(--accent);
    box-shadow: 0 6px 24px rgba(107,58,23,.1);
}
.eq8-review-card__stars { display: flex; gap: 2px; }
.eq8-star--on  { color: #D97B2E; font-size: 1rem; }
.eq8-star--off { color: var(--border); font-size: 1rem; }
.eq8-review-card__body {
    font-size: .88rem;
    color: var(--body);
    line-height: 1.7;
    margin: 0;
    font-style: italic;
    flex: 1;
}
.eq8-review-card__meta {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-top: auto;
}
.eq8-review-card__avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: var(--accentTint);
    color: var(--primary);
    font-weight: 700;
    font-size: .95rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.eq8-review-card__name {
    font-size: .88rem;
    font-weight: 700;
    color: var(--text);
    margin: 0;
}
.eq8-review-card__area {
    font-size: .75rem;
    color: var(--muted);
    margin: 2px 0 0;
}
</style>
@endif
