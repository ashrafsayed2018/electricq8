<?php

namespace Database\Factories;

use App\Models\Pillar;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ClusterFactory extends Factory
{
    private function arSlug(string $text): string
    {
        $text = preg_replace('/[^\p{Arabic}\p{N}\s-]/u', '', $text);
        return trim(preg_replace('/[\s-]+/u', '-', $text), '-');
    }

    public function definition(): array
    {
        $topics = [
            ['en' => 'Electrical Repair',               'ar' => 'إصلاح الكهرباء'],
            ['en' => 'AC Cleaning',              'ar' => 'تنظيف الكهرباء'],
            ['en' => 'Electrical Installation',          'ar' => 'تركيب الكهرباء'],
            ['en' => 'Electrical Refill',            'ar' => 'تصليح شورت الكهرباء'],
            ['en' => 'Central Electrical Maintenance',   'ar' => 'صيانة الكهرباء المركزي'],
            ['en' => 'Split Electrical Service',         'ar' => 'خدمة كهرباء السبليت'],
            ['en' => 'Window Electrical Repair',         'ar' => 'إصلاح الكهرباء الشباك'],
            ['en' => 'Spare Parts Replacement',  'ar' => 'استبدال قطع الغيار'],
        ];

        $data = $this->faker->randomElement($topics);
        $enSlug = Str::slug($data['en']);
        $arSlug = $this->arSlug($data['ar']);

        return [
            'pillar_id'        => Pillar::inRandomOrder()->value('id') ?? Pillar::factory(),
            'title'            => $data,
            'slug'             => ['en' => $enSlug, 'ar' => $arSlug],
            'h1'               => ['en' => $data['en'], 'ar' => $data['ar']],
            'intro'            => [
                'en' => $this->faker->sentence(12),
                'ar' => $this->faker->sentence(12),
            ],
            'content'          => [
                'en' => '<p>' . implode('</p><p>', $this->faker->paragraphs(3)) . '</p>',
                'ar' => '<p>' . implode('</p><p>', $this->faker->paragraphs(3)) . '</p>',
            ],
            'meta_title'       => [
                'en' => $data['en'] . ' Services Kuwait | ElectricQ8',
                'ar' => $data['ar'] . ' في الكويت | إلكتريك كويت',
            ],
            'meta_description' => [
                'en' => $this->faker->sentence(18),
                'ar' => $this->faker->sentence(18),
            ],
            'canonical_url'    => ['en' => '/en/' . $enSlug, 'ar' => '/ar/' . $arSlug],
            'search_intent'    => $this->faker->randomElement(['commercial', 'commercial', 'transactional', 'informational']),
            'status'           => $this->faker->randomElement(['active', 'active', 'draft']),
            'sort_order'       => $this->faker->numberBetween(1, 30),
        ];
    }
}
