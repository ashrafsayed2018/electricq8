@php $isAr = app()->getLocale() === 'ar'; @endphp
<section class="py-12">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 justify-items-center">
            @foreach($services as $service)
                @php
                    $isLast  = $loop->last && $loop->count % 3 === 1;
                    $locale  = app()->getLocale();
                    $svcRoute = $isAr ? 'services.show' : 'en.services.show';
                @endphp
                <a href="{{ route($svcRoute, $service->getTranslation('slug', $locale)) }}"
                   class="block w-full bg-white rounded-2xl shadow hover:shadow-lg transition p-6 border border-gray-100 {{ $isLast ? 'lg:col-start-2' : '' }}">
                    <div class="text-4xl mb-3">{{ $service->icon() }}</div>
                    <h3 class="text-lg font-bold mb-2">{{ $service->title }}</h3>
                    <p class="text-gray-500 text-sm">{{ html_entity_decode(strip_tags($service->intro), ENT_QUOTES | ENT_HTML5, 'UTF-8') }}</p>
                </a>
            @endforeach
        </div>
    </div>
</section>

