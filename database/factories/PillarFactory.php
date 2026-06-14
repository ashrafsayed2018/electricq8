<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PillarFactory extends Factory
{
    private function arSlug(string $text): string
    {
        $text = preg_replace('/[^\p{Arabic}\p{N}\s-]/u', '', $text);
        return trim(preg_replace('/[\s-]+/u', '-', $text), '-');
    }

    public function definition(): array
    {
        $titles = [
            ['en' => 'Electrical Services in Kuwait',        'ar' => 'خدمات الكهرباء في الكويت'],
            ['en' => 'Refrigeration Services',        'ar' => 'خدمات التبريد'],
            ['en' => 'Electrical Maintenance',        'ar' => 'الصيانة الكهربائية'],
            ['en' => 'Plumbing & Sanitation',         'ar' => 'السباكة والصرف الصحي'],
            ['en' => 'Home Appliance Repair',         'ar' => 'إصلاح الأجهزة المنزلية'],
        ];

        $data = $this->faker->randomElement($titles);
        $enSlug = Str::slug($data['en']);
        $arSlug = $this->arSlug($data['ar']);

        return [
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
                'en' => $data['en'] . ' | ElectricQ8',
                'ar' => $data['ar'] . ' | إلكتريك كويت',
            ],
            'meta_description' => [
                'en' => $this->faker->sentence(18),
                'ar' => $this->faker->sentence(18),
            ],
            'canonical_url'    => ['en' => '/en/' . $enSlug, 'ar' => '/ar/' . $arSlug],
            'status'           => $this->faker->randomElement(['active', 'active', 'draft']),
            'sort_order'       => $this->faker->numberBetween(1, 20),
        ];
    }
}
