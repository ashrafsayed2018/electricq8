<?php

namespace Database\Factories;

use App\Enums\ServiceStatus;
use App\Models\Cluster;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ServiceFactory extends Factory
{
    private function arSlug(string $text): string
    {
        $text = preg_replace('/[^\p{Arabic}\p{N}\s-]/u', '', $text);
        return trim(preg_replace('/[\s-]+/u', '-', $text), '-');
    }

    private static array $pool = [
        ['en' => 'Split Electrical Repair',               'ar' => 'إصلاح كهرباء السبليت',           'type' => 'split'],
        ['en' => 'Central Electrical Repair',             'ar' => 'إصلاح الكهرباء المركزي',         'type' => 'central'],
        ['en' => 'Window Electrical Repair',              'ar' => 'إصلاح كهرباء الشباك',             'type' => 'window'],
        ['en' => 'Cassette Electrical Maintenance',       'ar' => 'صيانة كهرباء الكاسيت',            'type' => 'cassette'],
        ['en' => 'Portable Electrical Service',           'ar' => 'خدمة الكهرباء المتنقل',           'type' => 'portable'],
        ['en' => 'Ducted Electrical Installation',        'ar' => 'تمديدات كهربائية مجاري الهواء',     'type' => 'duct'],
        ['en' => 'AC Deep Cleaning',              'ar' => 'تنظيف الكهرباء العميق',           'type' => 'general'],
        ['en' => 'Electrical Top-Up',                 'ar' => 'تعبئة غاز الكهرباء',             'type' => 'general'],
        ['en' => 'AC Compressor Replacement',     'ar' => 'استبدال كمبروسر الكهرباء',       'type' => 'general'],
        ['en' => 'Thermostat Installation',       'ar' => 'تركيب ترموستات الكهرباء',        'type' => 'general'],
        ['en' => 'Emergency Electrical Repair',           'ar' => 'إصلاح طارئ للكهرباء',           'type' => 'general'],
        ['en' => 'AC Annual Maintenance Contract','ar' => 'عقد صيانة سنوي للكهرباء',       'type' => 'general'],
    ];

    private static int $index = 0;

    public function definition(): array
    {
        $data = static::$pool[static::$index % count(static::$pool)];
        static::$index++;

        $enSlug = Str::slug($data['en']);
        $arSlug = $this->arSlug($data['ar']);

        $priceFrom = $this->faker->numberBetween(10, 30) * 5;
        $priceTo   = $priceFrom + $this->faker->numberBetween(2, 10) * 5;

        return [
            'cluster_id'       => Cluster::inRandomOrder()->value('id') ?? Cluster::factory(),
            'title'            => $data,
            'slug'             => ['en' => $enSlug, 'ar' => $arSlug],
            'h1'               => ['en' => $data['en'] . ' in Kuwait', 'ar' => $data['ar'] . ' في الكويت'],
            'intro'            => [
                'en' => $this->faker->sentence(14),
                'ar' => $this->faker->sentence(14),
            ],
            'content'          => [
                'en' => '<p>' . implode('</p><p>', $this->faker->paragraphs(4)) . '</p>',
                'ar' => '<p>' . implode('</p><p>', $this->faker->paragraphs(4)) . '</p>',
            ],
            'meta_title'       => [
                'en' => $data['en'] . ' Kuwait | ElectricQ8',
                'ar' => $data['ar'] . ' الكويت | إلكتريك كويت',
            ],
            'meta_description' => [
                'en' => $this->faker->sentence(20),
                'ar' => $this->faker->sentence(20),
            ],
            'canonical_url'    => ['en' => '/en/services/' . $enSlug, 'ar' => '/ar/خدمات/' . $arSlug],
            'service_type'     => $data['type'],
            'price_from'       => $priceFrom,
            'price_to'         => $priceTo,
            'faq_schema'       => null,
            'status'           => $this->faker->randomElement([
                ServiceStatus::Active, ServiceStatus::Active, ServiceStatus::Inactive,
            ]),
            'sort_order'       => $this->faker->numberBetween(1, 50),
        ];
    }
}
