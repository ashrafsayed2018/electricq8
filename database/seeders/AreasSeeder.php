<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class AreasSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            [
                'name'        => ['en' => 'Kuwait City',        'ar' => 'مدينة الكويت'],
                'slug'        => ['en' => 'kuwait-city',        'ar' => 'مدينة-الكويت'],
                'governorate' => 'capital',
                'description' => ['en' => 'electrical services in Kuwait City.', 'ar' => 'خدمات الكهرباء في مدينة الكويت.'],
                'is_active'   => true,
                'sort_order'  => 1,
            ],
            [
                'name'        => ['en' => 'Hawalli',            'ar' => 'حولي'],
                'slug'        => ['en' => 'hawalli',            'ar' => 'حولي'],
                'governorate' => 'hawalli',
                'description' => ['en' => 'electrical services in Hawalli.', 'ar' => 'خدمات الكهرباء في حولي.'],
                'is_active'   => true,
                'sort_order'  => 2,
            ],
            [
                'name'        => ['en' => 'Farwaniya',          'ar' => 'الفروانية'],
                'slug'        => ['en' => 'farwaniya',          'ar' => 'الفروانية'],
                'governorate' => 'farwaniya',
                'description' => ['en' => 'electrical services in Farwaniya.', 'ar' => 'خدمات الكهرباء في الفروانية.'],
                'is_active'   => true,
                'sort_order'  => 3,
            ],
            [
                'name'        => ['en' => 'Ahmadi',             'ar' => 'الأحمدي'],
                'slug'        => ['en' => 'ahmadi',             'ar' => 'الأحمدي'],
                'governorate' => 'ahmadi',
                'description' => ['en' => 'electrical services in Ahmadi.', 'ar' => 'خدمات الكهرباء في الأحمدي.'],
                'is_active'   => true,
                'sort_order'  => 4,
            ],
            [
                'name'        => ['en' => 'Jahra',              'ar' => 'الجهراء'],
                'slug'        => ['en' => 'jahra',              'ar' => 'الجهراء'],
                'governorate' => 'jahra',
                'description' => ['en' => 'electrical services in Jahra.', 'ar' => 'خدمات الكهرباء في الجهراء.'],
                'is_active'   => true,
                'sort_order'  => 5,
            ],
            [
                'name'        => ['en' => 'Mubarak Al-Kabeer',  'ar' => 'مبارك الكبير'],
                'slug'        => ['en' => 'mubarak-al-kabeer',  'ar' => 'مبارك-الكبير'],
                'governorate' => 'mubarak_al_kabeer',
                'description' => ['en' => 'electrical services in Mubarak Al-Kabeer.', 'ar' => 'خدمات الكهرباء في مبارك الكبير.'],
                'is_active'   => true,
                'sort_order'  => 6,
            ],
            [
                'name'        => ['en' => 'Salmiya',            'ar' => 'السالمية'],
                'slug'        => ['en' => 'salmiya',            'ar' => 'السالمية'],
                'governorate' => 'hawalli',
                'description' => ['en' => 'electrical services in Salmiya.', 'ar' => 'خدمات الكهرباء في السالمية.'],
                'is_active'   => true,
                'sort_order'  => 7,
            ],
            [
                'name'        => ['en' => 'Rumaithiya',         'ar' => 'الرميثية'],
                'slug'        => ['en' => 'rumaithiya',         'ar' => 'الرميثية'],
                'governorate' => 'hawalli',
                'description' => ['en' => 'electrical services in Rumaithiya.', 'ar' => 'خدمات الكهرباء في الرميثية.'],
                'is_active'   => true,
                'sort_order'  => 8,
            ],
            [
                'name'        => ['en' => 'Jabriya',            'ar' => 'الجابرية'],
                'slug'        => ['en' => 'jabriya',            'ar' => 'الجابرية'],
                'governorate' => 'hawalli',
                'description' => ['en' => 'electrical services in Jabriya.', 'ar' => 'خدمات الكهرباء في الجابرية.'],
                'is_active'   => true,
                'sort_order'  => 9,
            ],
            [
                'name'        => ['en' => 'Fahaheel',           'ar' => 'الفحيحيل'],
                'slug'        => ['en' => 'fahaheel',           'ar' => 'الفحيحيل'],
                'governorate' => 'ahmadi',
                'description' => ['en' => 'electrical services in Fahaheel.', 'ar' => 'خدمات الكهرباء في الفحيحيل.'],
                'is_active'   => true,
                'sort_order'  => 10,
            ],
            [
                'name'        => ['en' => 'Khaitan',            'ar' => 'خيطان'],
                'slug'        => ['en' => 'khaitan',            'ar' => 'خيطان'],
                'governorate' => 'farwaniya',
                'description' => ['en' => 'electrical services in Khaitan.', 'ar' => 'خدمات الكهرباء في خيطان.'],
                'is_active'   => true,
                'sort_order'  => 11,
            ],
            [
                'name'        => ['en' => 'Sabah Al-Salem',     'ar' => 'صباح السالم'],
                'slug'        => ['en' => 'sabah-al-salem',     'ar' => 'صباح-السالم'],
                'governorate' => 'mubarak_al_kabeer',
                'description' => ['en' => 'electrical services in Sabah Al-Salem.', 'ar' => 'خدمات الكهرباء في صباح السالم.'],
                'is_active'   => true,
                'sort_order'  => 12,
            ],
        ];

        foreach ($locations as $data) {
            Location::updateOrCreate(['slug->en' => $data['slug']['en']], $data);
        }
    }
}
