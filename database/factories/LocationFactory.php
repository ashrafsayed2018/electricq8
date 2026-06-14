<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class LocationFactory extends Factory
{
    private function arSlug(string $text): string
    {
        $text = preg_replace('/[^\p{Arabic}\p{N}\s-]/u', '', $text);
        return trim(preg_replace('/[\s-]+/u', '-', $text), '-');
    }

    // Real Kuwait neighbourhoods grouped by governorate
    private static array $areas = [
        ['en' => 'Salmiya',         'ar' => 'السالمية',       'gov' => 'hawalli'],
        ['en' => 'Rumaithiya',      'ar' => 'الرميثية',       'gov' => 'hawalli'],
        ['en' => 'Bayan',           'ar' => 'بيان',           'gov' => 'hawalli'],
        ['en' => 'Mishref',         'ar' => 'مشرف',           'gov' => 'hawalli'],
        ['en' => 'Jabriya',         'ar' => 'الجابرية',       'gov' => 'hawalli'],
        ['en' => 'Shuwaikh',        'ar' => 'الشويخ',         'gov' => 'capital'],
        ['en' => 'Sharq',           'ar' => 'شرق',            'gov' => 'capital'],
        ['en' => 'Qibla',           'ar' => 'القبلة',         'gov' => 'capital'],
        ['en' => 'Dasman',          'ar' => 'دسمان',          'gov' => 'capital'],
        ['en' => 'Abdullah Al-Salem','ar' => 'عبدالله السالم','gov' => 'capital'],
        ['en' => 'Jleeb Al-Shuyoukh','ar' => 'جليب الشيوخ',  'gov' => 'farwaniya'],
        ['en' => 'Khaitan',         'ar' => 'خيطان',          'gov' => 'farwaniya'],
        ['en' => 'Ardiya',          'ar' => 'العارضية',       'gov' => 'farwaniya'],
        ['en' => 'Fahaheel',        'ar' => 'الفحيحيل',       'gov' => 'ahmadi'],
        ['en' => 'Mangaf',          'ar' => 'المنقف',         'gov' => 'ahmadi'],
        ['en' => 'Fintas',          'ar' => 'الفنطاس',        'gov' => 'ahmadi'],
        ['en' => 'Jahra City',      'ar' => 'مدينة الجهراء',  'gov' => 'jahra'],
        ['en' => 'Sabah Al-Salem',  'ar' => 'صباح السالم',   'gov' => 'mubarak_al_kabeer'],
        ['en' => 'Mubarak Al-Kabeer','ar' => 'مبارك الكبير', 'gov' => 'mubarak_al_kabeer'],
        ['en' => 'Adan',            'ar' => 'العدان',         'gov' => 'mubarak_al_kabeer'],
    ];

    private static int $index = 0;

    public function definition(): array
    {
        $data = static::$areas[static::$index % count(static::$areas)];
        static::$index++;

        $enSlug = Str::slug($data['en']);
        $arSlug = $this->arSlug($data['ar']);

        return [
            'name'        => ['en' => $data['en'], 'ar' => $data['ar']],
            'slug'        => ['en' => $enSlug,    'ar' => $arSlug],
            'governorate' => $data['gov'],
            'description' => [
                'en' => $data['en'] . ' is one of Kuwait\'s well-known residential and commercial areas. ' . $this->faker->sentence(10),
                'ar' => $data['ar'] . ' من أبرز المناطق السكنية والتجارية في الكويت. ' . $this->faker->sentence(10),
            ],
            'is_active'   => true,
            'sort_order'  => static::$index,
        ];
    }
}
