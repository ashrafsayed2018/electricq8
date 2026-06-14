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
    <section class="bg-yellow-700 text-white py-14 text-center">
        <div class="container mx-auto px-4 max-w-2xl">
            <h1 class="text-3xl md:text-4xl font-extrabold mb-3">
                {{ $isAr ? 'خدمات الكهرباء بالكويت' : 'Electrical Services in Kuwait' }}
            </h1>
            <p class="text-lg opacity-90 mb-6">
                {{ $isAr
                    ? 'تمديدات · صيانة · تصليح شورت · تركيب إضاءة · طوارئ 24 ساعة'
                    : 'Wiring · Maintenance · Short Circuit · Lighting · 24/7 Emergency' }}
            </p>
            <div class="flex gap-4 justify-center flex-wrap">
                <a href="{{ \App\Helpers\WhatsAppHelper::url() }}" target="_blank"
                   class="bg-green-500 hover:bg-green-600 text-white font-bold px-8 py-4 rounded-xl transition">
                    {{ $isAr ? 'واتساب الآن' : 'WhatsApp Now' }}
                </a>
                <a href="tel:{{ \App\Models\SiteSetting::get('phone_number') }}"
                   class="bg-white text-yellow-700 font-bold px-8 py-4 rounded-xl transition hover:bg-gray-100">
                    {{ $isAr ? 'اتصل الآن' : 'Call Now' }}
                </a>
            </div>
        </div>
    </section>

    {{-- Services grid --}}
    <section class="py-14 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-10">
                <h2 class="text-2xl font-extrabold text-gray-900 mb-2">
                    {{ $isAr ? 'اختر الخدمة التي تحتاجها' : 'Choose the Service You Need' }}
                </h2>
                <p class="text-gray-500">
                    {{ $isAr ? 'كل خدمة بصفحة مستقلة مع تفاصيل كاملة وFAQ' : 'Each service has a dedicated page with full details and FAQ' }}
                </p>
            </div>
            @include('partials.services-grid', ['services' => $services])
        </div>
    </section>

    {{-- Brief trust strip --}}
    <section class="py-10 bg-white">
        <div class="container mx-auto px-4 max-w-3xl text-center">
            <p class="text-gray-600 leading-relaxed">
                {{ $isAr
                    ? 'إلكتريك كويت تغطي جميع خدمات الكهرباء للمنازل والمكاتب والمنشآت التجارية في الكويت. فنيونا المعتمدون يصلون إليك خلال ساعة واحدة، يشخصون العطل بدقة ويقدمون سعرًا واضحًا قبل بدء العمل — مع ضمان رسمي 3 أشهر على كل خدمة.'
                    : 'ElectricQ8 covers all electrical services for homes, offices and commercial facilities across Kuwait. Our certified technicians reach you within one hour, diagnose faults accurately and provide a clear price before starting work — with an official 3-month warranty on every service.' }}
            </p>
        </div>
    </section>

</div>
@endsection
