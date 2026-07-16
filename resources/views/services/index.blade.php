@extends('layouts.app')

@php $isAr = app()->getLocale() === 'ar'; @endphp

@section('meta_title')
    {{ $isAr
        ? 'خدمات الكهرباء بالكويت | تمديدات وصيانة وتصليح شورت | إلكتريك كويت'
        : 'Electrical Services in Kuwait | Wiring, Maintenance & Short Circuit | ElectricQ8' }}
@endsection

@section('meta_description')
    {{ $isAr
        ? 'جميع خدمات الكهرباء في الكويت — تمديدات، صيانة، تصليح شورت، تركيب إضاءة، طوارئ 24 ساعة. فنيون معتمدون يصلونك خلال ساعة في جميع مناطق الكويت.'
        : 'All electrical services in Kuwait — wiring, maintenance, short circuit repair, lighting installation, 24-hour emergency. Certified technicians reaching you within one hour across all Kuwait areas.' }}
@endsection

@section('content')
<div dir="{{ $isAr ? 'rtl' : 'ltr' }}">

    {{-- Hero --}}
    <section class="eq8-page-hero">
        <div class="eq8-page-hero__inner">
            <h1 class="eq8-page-hero__title">
                {{ $isAr ? 'خدمات الكهرباء بالكويت' : 'Electrical Services in Kuwait' }}
            </h1>
            <p class="eq8-page-hero__sub">
                {{ $isAr
                    ? 'تمديدات · صيانة · تصليح شورت · تركيب إضاءة · طوارئ 24 ساعة'
                    : 'Wiring · Maintenance · Short Circuit · Lighting · 24/7 Emergency' }}
            </p>
            @include('partials.hero-btns')
        </div>
    </section>

    {{-- Services grid --}}
    <section style="padding:56px 0;background:var(--altBg)">
        <div class="container mx-auto px-4">
            <div class="eq8-section-head">
                <h2 class="eq8-section-title">{{ $isAr ? 'اختر الخدمة التي تحتاجها' : 'Choose the Service You Need' }}</h2>
                <p class="eq8-section-sub">{{ $isAr ? 'كل خدمة بصفحة مستقلة مع تفاصيل كاملة وFAQ' : 'Each service has a dedicated page with full details and FAQ' }}</p>
            </div>
            @include('partials.services-grid', ['services' => $services])
        </div>
    </section>

    {{-- Trust strip --}}
    <section style="padding:40px 0;background:var(--bg)">
        <div class="container mx-auto px-4" style="max-width:780px;text-align:center">
            <p style="color:var(--body);line-height:1.8;font-family:'Cairo',sans-serif;font-size:.9rem">
                {{ $isAr
                    ? 'إلكتريك كويت تغطي جميع خدمات الكهرباء للمنازل والمكاتب والمنشآت التجارية في الكويت. فنيونا المعتمدون يصلون إليك خلال ساعة واحدة، يشخصون العطل بدقة ويقدمون سعرًا واضحًا قبل بدء العمل — مع ضمان رسمي 3 أشهر على كل خدمة.'
                    : 'ElectricQ8 covers all electrical services for homes, offices and commercial facilities across Kuwait. Our certified technicians reach you within one hour, diagnose faults accurately and provide a clear price before starting work — with an official 3-month warranty on every service.' }}
            </p>
        </div>
    </section>

</div>

<style>
.eq8-page-hero { background:linear-gradient(135deg,#43230E 0%,#6B3A17 60%,#8B4D20 100%); color:#fff; padding:56px 20px; text-align:center; }
.eq8-page-hero__inner { max-width:700px; margin:0 auto; }
.eq8-page-hero__title { font-size:clamp(1.6rem,4vw,2.4rem); font-weight:800; margin:0 0 12px; font-family:'Cairo',system-ui,sans-serif; }
.eq8-page-hero__sub { font-size:1rem; color:#F3D9BB; margin:0 0 28px; font-family:'Cairo',system-ui,sans-serif; }
</style>
@endsection
