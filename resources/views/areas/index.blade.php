@extends('layouts.app')

@php
    $isAr   = app()->getLocale() === 'ar';
    $locale = $isAr ? 'ar' : 'en';
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
<div dir="{{ $isAr ? 'rtl' : 'ltr' }}">

    {{-- Hero --}}
    <section class="bg-yellow-700 text-white py-14 text-center">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl md:text-4xl font-extrabold mb-3">
                {{ $isAr
                    ? 'فني كهربائي في جميع مناطق الكويت'
                    : 'Electrician in All Kuwait Areas' }}
            </h1>
            <p class="text-lg opacity-90 mb-6 max-w-xl mx-auto">
                {{ $isAr
                    ? 'نغطي جميع محافظات الكويت الست — استجابة خلال ساعة في أي منطقة'
                    : 'Covering all 6 Kuwait governorates — response within one hour' }}
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

    {{-- Areas grid --}}
    @include('partials.areas-grid', ['locations' => $locations])

    {{-- Coverage guarantee strip --}}
    <section class="py-10 bg-white" dir="{{ $isAr ? 'rtl' : 'ltr' }}">
        <div class="container mx-auto px-4 max-w-3xl text-center">
            <p class="text-gray-700 leading-relaxed">
                {{ $isAr
                    ? 'تخدم إلكتريك كويت جميع المناطق السكنية والتجارية في الكويت، من مدينة الكويت والسالمية شمالاً حتى الأحمدي والخيران جنوبًا. سواء كنت في شقة أو فيلا أو مبنى تجاري، فنيونا يصلون إليك خلال ساعة واحدة، مزودين بالأدوات والقطع اللازمة لإنهاء الخدمة في نفس الزيارة.'
                    : 'ElectricQ8 serves all residential and commercial areas in Kuwait, from Kuwait City and Salmiya in the north to Ahmadi and Khiran in the south. Whether you are in an apartment, villa or commercial building, our technicians reach you within one hour, equipped with all tools and parts to complete the service in a single visit.' }}
            </p>
        </div>
    </section>

</div>
@endsection
