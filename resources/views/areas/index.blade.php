@extends('layouts.app')

@php
    $isAr   = app()->getLocale() === 'ar';
    $locale = $isAr ? 'ar' : 'en';
    $prefix = $isAr ? '' : 'en.';
@endphp

@section('meta_title')
    {{ $isAr
        ? 'فني كهربائي في جميع مناطق الكويت | إلكتريك كويت'
        : 'Electrician in All Kuwait Areas | ElectricQ8' }}
@endsection

@section('meta_description')
    {{ $isAr
        ? 'نغطي جميع محافظات الكويت الست — العاصمة، حولي، الفروانية، الجهراء، الأحمدي، مبارك الكبير. فني كهربائي يصلك خلال ساعة مع خدمة طوارئ 24 ساعة.'
        : 'We cover all six Kuwait governorates — Capital, Hawalli, Farwaniya, Jahra, Ahmadi, Mubarak Al-Kabeer. Electrician reaches you within one hour with 24-hour emergency service.' }}
@endsection

@section('content')
<div dir="{{ $isAr ? 'rtl' : 'ltr' }}" style="background:var(--bg)">

    {{-- Breadcrumb --}}
    <nav class="eq8-bc">
        <div class="eq8-bc__inner">
            <ol class="eq8-bc__list">
                <li><a href="{{ route($prefix . 'home') }}" class="eq8-bc__link">{{ $isAr ? 'الرئيسية' : 'Home' }}</a></li>
                <li class="eq8-bc__sep">/</li>
                <li class="eq8-bc__current" aria-current="page">{{ $isAr ? 'مناطق الخدمة' : 'Service Areas' }}</li>
            </ol>
        </div>
    </nav>

    {{-- Hero --}}
    <section class="eq8-page-hero">
        <div class="eq8-page-hero__inner">
            <span class="eq8-areas-badge">
                <span class="eq8-areas-badge__dot"></span>
                {{ $isAr ? 'تغطية كاملة لجميع محافظات الكويت' : 'Full coverage across all Kuwait governorates' }}
            </span>
            <h1 class="eq8-page-hero__title">
                {{ $isAr ? 'فني كهربائي في جميع مناطق الكويت' : 'Electrician in All Kuwait Areas' }}
            </h1>
            <p class="eq8-page-hero__sub">
                {{ $isAr
                    ? 'نغطي جميع محافظات الكويت الست — استجابة خلال ساعة في أي منطقة'
                    : 'Covering all 6 Kuwait governorates — response within one hour anywhere' }}
            </p>
            @include('partials.hero-btns')
            {{-- Trust badges --}}
            <div class="eq8-page-hero__badges">
                <span class="eq8-page-hero__trust">⚡ {{ $isAr ? 'فني معتمد' : 'Certified Tech' }}</span>
                <span class="eq8-page-hero__trust">🕐 {{ $isAr ? 'طوارئ 24/7' : '24/7 Emergency' }}</span>
                <span class="eq8-page-hero__trust">🛡️ {{ $isAr ? 'ضمان 3 أشهر' : '3-Month Warranty' }}</span>
                <span class="eq8-page-hero__trust">📍 {{ $isAr ? 'جميع المناطق' : 'All Areas' }}</span>
            </div>
        </div>
    </section>

    {{-- Areas grid --}}
    @include('partials.areas-grid', ['locations' => $locations])

    {{-- Coverage strip --}}
    <section class="eq8-coverage-strip">
        <div class="eq8-coverage-strip__inner">
            <p class="eq8-coverage-strip__text">
                {{ $isAr
                    ? 'تخدم إلكتريك كويت جميع المناطق السكنية والتجارية في الكويت، من مدينة الكويت والسالمية شمالاً حتى الأحمدي والخيران جنوبًا. سواء كنت في شقة أو فيلا أو مبنى تجاري، فنيونا يصلون إليك خلال ساعة واحدة، مزودين بالأدوات والقطع اللازمة لإنهاء الخدمة في نفس الزيارة.'
                    : 'ElectricQ8 serves all residential and commercial areas in Kuwait, from Kuwait City and Salmiya in the north to Ahmadi and Khiran in the south. Whether you are in an apartment, villa or commercial building, our technicians reach you within one hour, equipped with all tools and parts to complete the service in a single visit.' }}
            </p>
        </div>
    </section>

</div>

<style>
/* Breadcrumb */
.eq8-bc { background:var(--altBg); border-bottom:1px solid var(--border); padding:10px 0; font-family:'Cairo',system-ui,sans-serif; font-size:13px; }
.eq8-bc__inner { max-width:1200px; margin:0 auto; padding:0 24px; }
.eq8-bc__list { display:flex; align-items:center; gap:8px; list-style:none; margin:0; padding:0; flex-wrap:wrap; color:var(--muted); }
.eq8-bc__link { color:var(--primary); text-decoration:none; font-weight:600; }
.eq8-bc__link:hover { text-decoration:underline; }
.eq8-bc__sep { color:var(--border); }
.eq8-bc__current { color:var(--text); font-weight:600; }

/* Hero */
.eq8-page-hero {
    background: linear-gradient(135deg,#43230E 0%,#6B3A17 60%,#8B4D20 100%);
    color: #fff;
    padding: 64px 24px 72px;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.eq8-page-hero::before {
    content:'';
    position:absolute; inset:0;
    background: radial-gradient(ellipse at 60% 40%, rgba(217,123,46,.2) 0%, transparent 65%);
    pointer-events:none;
}
.eq8-page-hero__inner {
    position: relative;
    max-width: 800px;
    margin: 0 auto;
}
.eq8-areas-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(217,123,46,.25);
    border: 1px solid rgba(217,123,46,.4);
    color: #F3D9BB;
    font-size: .82rem;
    font-weight: 700;
    padding: 6px 16px;
    border-radius: 999px;
    margin-bottom: 20px;
    font-family: 'Cairo',system-ui,sans-serif;
}
.eq8-areas-badge__dot {
    width:8px; height:8px; border-radius:50%;
    background:#25D366;
    animation: areaDot 1.5s ease-in-out infinite;
}
@keyframes areaDot { 0%,100%{opacity:1} 50%{opacity:.3} }

.eq8-page-hero__title {
    font-size: clamp(1.7rem,4.5vw,2.6rem);
    font-weight: 800;
    margin: 0 0 14px;
    line-height: 1.2;
    font-family: 'Cairo',system-ui,sans-serif;
}
.eq8-page-hero__sub {
    font-size: 1rem;
    color: #F3D9BB;
    margin: 0 0 28px;
    font-family: 'Cairo',system-ui,sans-serif;
    opacity: .9;
}
.eq8-page-hero__badges {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 10px;
    margin-top: 24px;
}
.eq8-page-hero__trust {
    background: rgba(255,255,255,.12);
    border: 1px solid rgba(255,255,255,.2);
    color: #F3D9BB;
    font-size: .8rem;
    font-weight: 600;
    padding: 6px 16px;
    border-radius: 999px;
    font-family: 'Cairo',system-ui,sans-serif;
}

/* Coverage text strip */
.eq8-coverage-strip {
    padding: 48px 24px;
    background: var(--bg);
    border-top: 1px solid var(--border);
}
.eq8-coverage-strip__inner {
    max-width: 760px;
    margin: 0 auto;
    text-align: center;
}
.eq8-coverage-strip__text {
    color: var(--body);
    line-height: 1.85;
    font-family: 'Cairo',system-ui,sans-serif;
    font-size: .9rem;
    margin: 0;
}
</style>
@endsection
