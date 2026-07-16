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
            <div class="eq8-page-hero__btns">
                <a href="{{ \App\Helpers\WhatsAppHelper::url() }}" target="_blank" class="eq8-btn eq8-btn--wa">
                    <svg class="eq8-btn__icon" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.116 1.528 5.845L0 24l6.335-1.505A11.946 11.946 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.882a9.872 9.872 0 01-5.031-1.378l-.361-.214-3.741.981.999-3.648-.235-.374A9.869 9.869 0 012.118 12C2.118 6.963 6.963 2.118 12 2.118s9.882 4.845 9.882 9.882-4.845 9.882-9.882 9.882z"/></svg>
                    {{ $isAr ? 'واتساب الآن' : 'WhatsApp Now' }}
                </a>
                <a href="tel:{{ \App\Models\SiteSetting::get('phone_number') }}" class="eq8-btn eq8-btn--call">
                    <svg class="eq8-btn__icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    {{ $isAr ? 'اتصل الآن' : 'Call Now' }}
                </a>
            </div>
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
.eq8-page-hero__btns { display:flex; gap:12px; justify-content:center; flex-wrap:wrap; }
</style>
@endsection
