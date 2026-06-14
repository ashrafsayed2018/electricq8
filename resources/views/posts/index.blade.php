@extends('layouts.app')

@php $isAr = app()->getLocale() === 'ar'; @endphp

@section('meta_title')
    {{ $isAr
        ? 'مدونة الكهرباء في الكويت — نصائح وإرشادات كهربائية | إلكتريك كويت'
        : 'Electrical Blog in Kuwait — Tips & Guides | ElectricQ8' }}
@endsection

@section('meta_description')
    {{ $isAr
        ? 'مقالات متخصصة في الكهرباء المنزلية بالكويت — نصائح عملية وإرشادات متخصصة من فنيي إلكتريك كويت.'
        : 'Expert electrical articles for Kuwait — practical tips and expert guidance from ElectricQ8 technicians.' }}
@endsection

@section('content')
<div class="bg-gray-50 min-h-screen" dir="{{ $isAr ? 'rtl' : 'ltr' }}">

    {{-- Hero --}}
    <section class="bg-yellow-700 text-white py-12 text-center">
        <div class="container mx-auto px-4 max-w-2xl">
            <h1 class="text-3xl md:text-4xl font-extrabold mb-3">
                {{ $isAr ? 'مدونة الكهرباء في الكويت' : 'Electrical Blog in Kuwait' }}
            </h1>
            <p class="text-lg opacity-90">
                {{ $isAr
                    ? 'نصائح عملية وإرشادات متخصصة من فنيي إلكتريك كويت'
                    : 'Practical tips and expert guidance from ElectricQ8 technicians' }}
            </p>
        </div>
    </section>

    <div class="container mx-auto px-4 py-12">

        @if($posts->isEmpty())
            <p class="text-center text-gray-400 py-20">{{ $isAr ? 'لا توجد مقالات بعد.' : 'No posts yet.' }}</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($posts as $post)
                @php
                    $postLocale  = app()->getLocale();
                    $postTitle   = $post->getTranslation('title', $postLocale);
                    $postExcerpt = Str::limit(strip_tags($post->getTranslation('excerpt', $postLocale)), 140);
                    $postSlug    = $post->getTranslation('slug', $postLocale);
                    $postRoute   = $isAr ? route('posts.show', $postSlug) : route('en.posts.show', $postSlug);
                    $wordCount   = str_word_count(strip_tags($post->getTranslation('content', $postLocale) ?? ''));
                    $readMinutes = max(1, (int) ceil($wordCount / 200));
                @endphp
                <a href="{{ $postRoute }}"
                   class="bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all overflow-hidden flex flex-col group">

                    {{-- Thumbnail --}}
                    @if($post->featured_image)
                        <div class="overflow-hidden">
                            <img src="{{ asset('storage/' . $post->featured_image) }}"
                                 alt="{{ $postTitle }}"
                                 loading="lazy"
                                 class="w-full h-44 object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>
                    @else
                        <div class="w-full h-44 bg-yellow-50 flex items-center justify-center">
                            <svg class="w-12 h-12 text-yellow-200" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"/>
                            </svg>
                        </div>
                    @endif

                    <div class="p-5 flex flex-col flex-1">

                        {{-- Meta row: date + reading time --}}
                        <div class="flex items-center gap-3 text-xs text-gray-400 mb-3">
                            @if($post->published_at)
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span dir="ltr">{{ $post->published_at->format('d M Y') }}</span>
                                </span>
                            @endif
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ $isAr ? $readMinutes . ' د قراءة' : $readMinutes . ' min read' }}
                            </span>
                        </div>

                        {{-- Title --}}
                        <h2 class="font-bold text-gray-900 text-base mb-2 leading-snug">
                            {{ $postTitle }}
                        </h2>

                        {{-- Excerpt --}}
                        @if($postExcerpt)
                            <p class="text-gray-500 text-sm leading-relaxed flex-1">
                                {{ $postExcerpt }}
                            </p>
                        @endif

                        {{-- CTA --}}
                        <span class="mt-4 text-yellow-600 text-sm font-semibold group-hover:underline">
                            {{ $isAr ? 'اقرأ المزيد ←' : 'Read more →' }}
                        </span>
                    </div>
                </a>
                @endforeach
            </div>

            <div class="mt-10">
                {{ $posts->links() }}
            </div>
        @endif

    </div>
</div>
@endsection
