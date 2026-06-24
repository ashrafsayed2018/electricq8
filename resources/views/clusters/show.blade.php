@extends('layouts.app')

@php
    $isAr   = app()->getLocale() === 'ar';
    $locale = $isAr ? 'ar' : 'en';
    $prefix = $isAr ? '' : 'en.';

    $title   = $cluster->getTranslation('title',  $locale);
    $h1      = $title;
    $content = $cluster->getTranslation('content',$locale);

    $metaTitle = $cluster->getTranslation('meta_title', $locale)       ?: $title;
    $metaDesc  = $cluster->getTranslation('meta_description', $locale) ?: '';
@endphp

@section('meta_title'){{ $metaTitle }}@endsection
@section('meta_description'){{ $metaDesc }}@endsection

@section('content')
<div dir="{{ $isAr ? 'rtl' : 'ltr' }}">

    {{-- Breadcrumb --}}
    <nav class="bg-gray-50 border-b border-gray-200 py-3">
        <div class="container mx-auto px-4">
            <ol class="flex items-center gap-2 text-sm text-gray-500 flex-wrap">
                <li><a href="{{ route($prefix . 'home') }}" class="hover:text-yellow-700 transition">{{ $isAr ? 'الرئيسية' : 'Home' }}</a></li>
                <li class="text-gray-300">/</li>
                <li><a href="{{ route($prefix . 'services.index') }}" class="hover:text-yellow-700 transition">{{ $isAr ? 'الخدمات' : 'Services' }}</a></li>
                <li class="text-gray-300">/</li>
                <li class="text-gray-800 font-semibold" aria-current="page">{{ $title }}</li>
            </ol>
        </div>
    </nav>

    {{-- Hero --}}
    <section class="bg-yellow-700 text-white py-16">
        <div class="container mx-auto px-4 text-center max-w-3xl">
            @if($cluster->image_url)
                <img src="{{ $cluster->image_url }}" alt="{{ $title }}"
                     class="w-24 h-24 rounded-2xl object-cover mx-auto mb-6 shadow-lg">
            @endif
            <h1 class="text-3xl md:text-4xl font-extrabold mb-4">{{ $h1 }}</h1>
        </div>
    </section>

    {{-- Rich content --}}
    @if($content)
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4 max-w-4xl">
            <div class="richtext" dir="{{ $isAr ? 'rtl' : 'ltr' }}">{!! \App\Helpers\RichText::clean($content) !!}</div>
    </section>
    @endif

    {{-- Services in this cluster --}}
    @if($cluster->services->count())
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl font-extrabold text-gray-900 mb-8 text-center">
                {{ $isAr ? 'الخدمات المتاحة' : 'Available Services' }}
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-5xl mx-auto">
                @foreach($cluster->services as $service)
                <a href="{{ route($prefix . 'services.show', $service->getTranslation('slug', $locale)) }}"
                   class="block bg-white rounded-2xl shadow hover:shadow-lg transition p-6 border border-gray-100 hover:border-yellow-300">
                    <div class="text-3xl mb-3">{{ $service->icon() }}</div>
                    <h3 class="text-lg font-bold mb-2 text-gray-900">{{ $service->getTranslation('title', $locale) }}</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">{{ html_entity_decode(strip_tags($service->getTranslation('intro', $locale)), ENT_QUOTES | ENT_HTML5, 'UTF-8') }}</p>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- CTA --}}
    <section class="py-14 bg-yellow-700 text-white text-center">
        <div class="container mx-auto px-4 max-w-xl">
            <h2 class="text-2xl font-extrabold mb-4">
                {{ $isAr ? 'تواصل معنا الآن' : 'Contact Us Now' }}
            </h2>
            <div class="flex gap-4 justify-center flex-wrap">
                <a href="{{ \App\Helpers\WhatsAppHelper::url() }}" target="_blank"
                   class="bg-green-500 hover:bg-green-600 text-white font-bold px-8 py-4 rounded-xl transition">
                    {{ $isAr ? 'واتساب' : 'WhatsApp' }}
                </a>
                <a href="tel:{{ \App\Models\SiteSetting::get('phone_number') }}"
                   class="bg-white text-yellow-700 font-bold px-8 py-4 rounded-xl transition hover:bg-gray-100">
                    {{ $isAr ? 'اتصل الآن' : 'Call Now' }}
                </a>
            </div>
        </div>
    </section>

</div>
@endsection
