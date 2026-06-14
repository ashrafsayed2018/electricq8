<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        // Delete existing service-location pages first to avoid FK constraint
        \App\Models\ServiceLocationPage::query()->delete();
        Service::query()->delete();

        $services = [
            [
                'ar'      => 'كهربائي منازل بالكويت',
                'en'      => 'Home Electrician in Kuwait',
                'slug_ar' => 'كهربائي-منازل-بالكويت',
                'slug_en' => 'home-electrician-kuwait',
                'h1_ar'   => 'كهربائي منازل محترف بالكويت',
                'h1_en'   => 'Professional Home Electrician in Kuwait',
                'type'    => 'repair',
                'sort'    => 1,
            ],
            [
                'ar'      => 'تصليح شورت الكهرباء',
                'en'      => 'Short Circuit Repair',
                'slug_ar' => 'تصليح-شورت-الكهرباء',
                'slug_en' => 'short-circuit-repair',
                'h1_ar'   => 'تصليح شورت كهرباء سريع بالكويت',
                'h1_en'   => 'Fast Short Circuit Repair in Kuwait',
                'type'    => 'repair',
                'sort'    => 2,
            ],
            [
                'ar'      => 'تمديدات كهربائية',
                'en'      => 'Electrical Wiring',
                'slug_ar' => 'تمديدات-كهربائية',
                'slug_en' => 'electrical-wiring-kuwait',
                'h1_ar'   => 'تمديدات كهربائية احترافية بالكويت',
                'h1_en'   => 'Professional Electrical Wiring in Kuwait',
                'type'    => 'install',
                'sort'    => 3,
            ],
            [
                'ar'      => 'تركيب لوحة كهربائية',
                'en'      => 'Electrical Panel Installation',
                'slug_ar' => 'تركيب-لوحة-كهربائية',
                'slug_en' => 'electrical-panel-installation',
                'h1_ar'   => 'تركيب لوحة كهربائية معتمدة بالكويت',
                'h1_en'   => 'Certified Electrical Panel Installation in Kuwait',
                'type'    => 'install',
                'sort'    => 4,
            ],
            [
                'ar'      => 'تركيب سبوت لايت وإضاءة',
                'en'      => 'Spotlight & Lighting Installation',
                'slug_ar' => 'تركيب-سبوت-لايت-واضاءة',
                'slug_en' => 'spotlight-lighting-installation',
                'h1_ar'   => 'تركيب سبوت لايت وإضاءة بالكويت',
                'h1_en'   => 'Spotlight & Lighting Installation in Kuwait',
                'type'    => 'install',
                'sort'    => 5,
            ],
            [
                'ar'      => 'كهربائي 24 ساعة طوارئ',
                'en'      => '24/7 Emergency Electrician',
                'slug_ar' => 'كهربائي-24-ساعة',
                'slug_en' => 'emergency-electrician-24-7',
                'h1_ar'   => 'كهربائي طوارئ 24 ساعة في الكويت',
                'h1_en'   => '24/7 Emergency Electrician in Kuwait',
                'type'    => 'repair',
                'sort'    => 6,
            ],
        ];

        foreach ($services as $data) {
            Service::create([
                'title'        => ['ar' => $data['ar'],      'en' => $data['en']],
                'slug'         => ['ar' => $data['slug_ar'], 'en' => $data['slug_en']],
                'h1'           => ['ar' => $data['h1_ar'],   'en' => $data['h1_en']],
                'intro'        => ['ar' => '', 'en' => ''],
                'content'      => ['ar' => '', 'en' => ''],
                'meta_title'   => ['ar' => $data['ar'] . ' | إلكتريك كويت', 'en' => $data['en'] . ' | ElectricQ8'],
                'meta_description' => [
                    'ar' => 'خدمة ' . $data['ar'] . ' — فنيون معتمدون، استجابة خلال ساعة، ضمان 3 أشهر. اتصل الآن.',
                    'en' => 'Professional ' . $data['en'] . ' — certified technicians, 1-hour response, 3-month warranty. Call now.',
                ],
                'service_type' => $data['type'],
                'status'       => 'active',
                'sort_order'   => $data['sort'],
            ]);
        }

        $this->command->info('✓ Seeded ' . count($services) . ' services.');
    }
}
