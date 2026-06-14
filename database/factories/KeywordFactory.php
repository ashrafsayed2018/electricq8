<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class KeywordFactory extends Factory
{
    private static array $keywords = [
        ['en' => 'ac repair kuwait',              'ar' => 'إصلاح كهرباء الكويت',            'intent' => 'transactional', 'type' => 'service',   'vol' => 1900, 'diff' => 32],
        ['en' => 'ac cleaning kuwait',            'ar' => 'تصليح كهرباء الكويت',            'intent' => 'transactional', 'type' => 'service',   'vol' => 1300, 'diff' => 28],
        ['en' => 'ac installation kuwait',        'ar' => 'تمديدات كهربائية الكويت',            'intent' => 'transactional', 'type' => 'service',   'vol' => 1100, 'diff' => 35],
        ['en' => 'ac short circuit repair kuwait',          'ar' => 'تصليح شورت كهرباء الكويت',          'intent' => 'transactional', 'type' => 'service',   'vol' => 880,  'diff' => 25],
        ['en' => 'emergency ac repair kuwait',    'ar' => 'إصلاح كهرباء طارئ الكويت',       'intent' => 'transactional', 'type' => 'service',   'vol' => 720,  'diff' => 22],
        ['en' => 'central ac maintenance kuwait', 'ar' => 'صيانة كهرباء مركزي الكويت',      'intent' => 'commercial',    'type' => 'service',   'vol' => 590,  'diff' => 40],
        ['en' => 'split ac service kuwait',       'ar' => 'خدمة كهرباء سبليت الكويت',        'intent' => 'commercial',    'type' => 'service',   'vol' => 650,  'diff' => 30],
        ['en' => 'best ac brand kuwait',          'ar' => 'أفضل ماركة كهرباء الكويت',        'intent' => 'informational', 'type' => 'blog',      'vol' => 420,  'diff' => 18],
        ['en' => 'how much does ac repair cost',  'ar' => 'كم تكلفة إصلاح الكهرباء',         'intent' => 'informational', 'type' => 'blog',      'vol' => 380,  'diff' => 15],
        ['en' => 'ac services salmiya',           'ar' => 'خدمات كهرباء السالمية',           'intent' => 'transactional', 'type' => 'location',  'vol' => 310,  'diff' => 20],
        ['en' => 'ac repair farwaniya',           'ar' => 'إصلاح كهرباء الفروانية',          'intent' => 'transactional', 'type' => 'location',  'vol' => 290,  'diff' => 19],
        ['en' => 'ac services hawalli',           'ar' => 'خدمات كهرباء حولي',              'intent' => 'transactional', 'type' => 'location',  'vol' => 270,  'diff' => 21],
        ['en' => 'ac maintenance cluster kuwait', 'ar' => 'مجموعة صيانة كهرباء الكويت',     'intent' => 'commercial',    'type' => 'cluster',   'vol' => 200,  'diff' => 38],
        ['en' => 'kuwait ac services pillar',     'ar' => 'ركيزة خدمات الكهرباء الكويت',    'intent' => 'navigational',  'type' => 'pillar',    'vol' => 150,  'diff' => 45],
        ['en' => 'ac compressor replacement',     'ar' => 'استبدال كمبروسر كهرباء',          'intent' => 'transactional', 'type' => 'service',   'vol' => 490,  'diff' => 33],
        ['en' => 'window ac repair kuwait',       'ar' => 'إصلاح كهرباء شباك الكويت',        'intent' => 'transactional', 'type' => 'service',   'vol' => 340,  'diff' => 27],
    ];

    private static int $index = 0;

    public function definition(): array
    {
        $kw = static::$keywords[static::$index % count(static::$keywords)];
        static::$index++;

        return [
            'keyword'       => ['en' => $kw['en'], 'ar' => $kw['ar']],
            'intent'        => $kw['intent'],
            'type'          => $kw['type'],
            'search_volume' => $kw['vol'],
            'difficulty'    => $kw['diff'],
            'status'        => $this->faker->randomElement(['active', 'active', 'active', 'paused']),
        ];
    }
}
