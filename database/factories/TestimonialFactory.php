<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

class TestimonialFactory extends Factory
{
    private static array $reviews = [
        [
            'en' => ['name' => 'Ahmed Al-Rashidi',  'body' => 'Excellent service! The technician arrived on time and fixed my AC within an hour. Very professional team.'],
            'ar' => ['name' => 'أحمد الراشدي',      'body' => 'خدمة ممتازة! وصل الفني في الوقت المحدد وأصلح الكهرباء خلال ساعة. فريق محترف جداً.'],
        ],
        [
            'en' => ['name' => 'Sara Al-Mutairi',   'body' => 'I called them for emergency electrical repair at midnight and they responded immediately. Very satisfied with the service.'],
            'ar' => ['name' => 'سارة المطيري',      'body' => 'اتصلت بهم لإصلاح طارئ للكهرباء في منتصف الليل وردوا فوراً. راضية جداً عن الخدمة.'],
        ],
        [
            'en' => ['name' => 'Mohammed Al-Azmi',  'body' => 'Best electrical maintenance service in Kuwait. My unit is running much more efficiently now. Highly recommended!'],
            'ar' => ['name' => 'محمد العازمي',      'body' => 'أفضل خدمة تصليح كهرباء في الكويت. الكهرباء يعمل بكفاءة أكبر الآن. أنصح بشدة!'],
        ],
        [
            'en' => ['name' => 'Fatima Al-Sabah',   'body' => 'They installed three split ACs in my apartment. The work was clean, fast, and reasonably priced.'],
            'ar' => ['name' => 'فاطمة الصباح',      'body' => 'ركّبوا ثلاثة كهرباءات سبليت في شقتي. العمل كان نظيفاً وسريعاً وبسعر معقول.'],
        ],
        [
            'en' => ['name' => 'Khalid Al-Hajri',   'body' => 'Quick response and honest pricing. The technician explained everything clearly before starting the work.'],
            'ar' => ['name' => 'خالد الهاجري',      'body' => 'استجابة سريعة وأسعار صادقة. شرح الفني كل شيء بوضوح قبل البدء بالعمل.'],
        ],
        [
            'en' => ['name' => 'Noor Al-Enezi',     'body' => 'They diagnosed the problem with my central AC and had it running perfectly within two hours. Great work!'],
            'ar' => ['name' => 'نور العنزي',        'body' => 'شخّصوا مشكلة الكهرباء المركزي وأعادوه للعمل بشكل مثالي خلال ساعتين. عمل رائع!'],
        ],
        [
            'en' => ['name' => 'Tariq Al-Kandari',  'body' => 'Professional team, clean work area, and fair prices. Will definitely use their service again.'],
            'ar' => ['name' => 'طارق الكندري',      'body' => 'فريق محترف ومنطقة عمل نظيفة وأسعار عادلة. سأستخدم خدمتهم مرة أخرى بالتأكيد.'],
        ],
        [
            'en' => ['name' => 'Maryam Al-Shammari','body' => 'Excellent short circuit repair service. My AC cools perfectly now. The technician was polite and efficient.'],
            'ar' => ['name' => 'مريم الشمري',       'body' => 'خدمة تصليح شورت ممتازة. كهرباءي يبرد بشكل مثالي الآن. الفني كان مؤدباً وفعالاً.'],
        ],
        [
            'en' => ['name' => 'Jaber Al-Otaibi',   'body' => 'Used their annual maintenance contract. Really worth the investment. Regular checkups prevent costly repairs.'],
            'ar' => ['name' => 'جابر العتيبي',      'body' => 'استخدمت عقد الصيانة السنوي. يستحق الاستثمار فعلاً. الفحوصات المنتظمة تمنع الأعطال المكلفة.'],
        ],
        [
            'en' => ['name' => 'Dalal Al-Qattan',   'body' => 'Fast and reliable service. They replaced the compressor in my old AC and it works like new again.'],
            'ar' => ['name' => 'دلال القطان',       'body' => 'خدمة سريعة وموثوقة. استبدلوا الكمبروسر في كهرباءي القديم ويعمل كالجديد مجدداً.'],
        ],
    ];

    public function definition(): array
    {
        $review   = $this->faker->randomElement(static::$reviews);
        $rating   = $this->faker->randomElement([4, 5, 5, 5]);

        return [
            'client_name' => ['en' => $review['en']['name'], 'ar' => $review['ar']['name']],
            'body'        => ['en' => $review['en']['body'], 'ar' => $review['ar']['body']],
            'location_id' => Location::inRandomOrder()->value('id'),
            'rating'      => $rating,
            'is_active'   => $this->faker->boolean(85),
        ];
    }
}
