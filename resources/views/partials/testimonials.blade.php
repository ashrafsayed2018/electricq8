@if($testimonials->count())
<section class="py-12">
    <div class="container mx-auto px-4">
        <h2 class="text-2xl font-bold mb-8 text-center">
            {{ app()->getLocale() === 'ar' ? 'آراء عملائنا' : 'Customer Reviews' }}
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($testimonials as $testimonial)
                <div class="bg-white rounded-2xl shadow p-6 border border-gray-100">
                    <div class="flex mb-3">
                        @for($i = 0; $i < $testimonial->rating; $i++)
                            <span class="text-yellow-400">★</span>
                        @endfor
                    </div>
                    <p class="text-gray-600 mb-4 italic">"{{ $testimonial->body }}"</p>
                    <p class="font-bold text-sm">{{ $testimonial->client_name }}</p>
                    @if($testimonial->area)
                        <p class="text-gray-400 text-xs">{{ $testimonial->area->name }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
