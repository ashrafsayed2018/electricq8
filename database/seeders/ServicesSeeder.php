<?php

namespace Database\Seeders;

use App\Enums\ServiceStatus;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title'      => ['en' => 'Home Electrician in Kuwait',    'ar' => 'كهربائي منازل بالكويت'],
                'slug'       => ['en' => 'home-electrician-kuwait',       'ar' => 'كهربائي-منازل-بالكويت'],
                'h1'         => ['en' => 'Professional Home Electrician in Kuwait', 'ar' => 'كهربائي منازل محترف بالكويت'],
                'intro'      => ['en' => 'Professional home electrician in Kuwait for all residential electrical work 24/7. Fast response, expert diagnosis, guaranteed repairs.', 'ar' => 'فني كهربائي منازل متخصص بالكويت لجميع أعمال الكهرباء السكنية على مدار 24 ساعة.'],
                'content'    => ['en' => 'Fast response, expert diagnosis, guaranteed repairs.', 'ar' => 'نصلك في أسرع وقت لتشخيص الأعطال وإصلاحها باحترافية وضمان.'],
                'service_type' => 'repair',
                'status'     => ServiceStatus::Active,
                'sort_order' => 1,
            ],
            [
                'title'      => ['en' => 'Short Circuit Repair',          'ar' => 'تصليح شورت الكهرباء'],
                'slug'       => ['en' => 'short-circuit-repair',          'ar' => 'تصليح-شورت-الكهرباء'],
                'h1'         => ['en' => 'Fast Short Circuit Repair in Kuwait', 'ar' => 'تصليح شورت كهرباء سريع بالكويت'],
                'intro'      => ['en' => 'Short circuit detection and repair using advanced equipment with highest safety standards.', 'ar' => 'كشف وإصلاح الشورت الكهربائي بأحدث الأجهزة وأعلى معايير السلامة.'],
                'content'    => ['en' => 'Emergency service 24/7 across Kuwait.', 'ar' => 'خدمة طوارئ فورية على مدار 24 ساعة في جميع مناطق الكويت.'],
                'service_type' => 'repair',
                'status'     => ServiceStatus::Active,
                'sort_order' => 2,
            ],
            [
                'title'      => ['en' => 'Electrical Wiring',             'ar' => 'تمديدات كهربائية'],
                'slug'       => ['en' => 'electrical-wiring-kuwait',      'ar' => 'تمديدات-كهربائية'],
                'h1'         => ['en' => 'Professional Electrical Wiring in Kuwait', 'ar' => 'تمديدات كهربائية احترافية بالكويت'],
                'intro'      => ['en' => 'Electrical wiring and installation for homes, apartments and commercial buildings in Kuwait using certified materials with full warranty.', 'ar' => 'تمديد وتأسيس الكهرباء للمنازل والشقق والمجمعات التجارية بالكويت.'],
                'content'    => ['en' => 'Using certified materials with full warranty.', 'ar' => 'نستخدم أفضل الكابلات والمواد المعتمدة مع ضمان على جميع الأعمال.'],
                'service_type' => 'install',
                'status'     => ServiceStatus::Active,
                'sort_order' => 3,
            ],
            [
                'title'      => ['en' => 'Electrical Panel Installation', 'ar' => 'تركيب لوحة كهربائية'],
                'slug'       => ['en' => 'electrical-panel-installation', 'ar' => 'تركيب-لوحة-كهربائية'],
                'h1'         => ['en' => 'Certified Electrical Panel Installation in Kuwait', 'ar' => 'تركيب لوحة كهربائية معتمدة بالكويت'],
                'intro'      => ['en' => 'Installation, maintenance and replacement of main and sub electrical panels in Kuwait.', 'ar' => 'تركيب وصيانة وتبديل اللوحات الكهربائية الرئيسية والفرعية بالكويت.'],
                'content'    => ['en' => 'Certified technicians ensuring safe connections and compliance.', 'ar' => 'فنيون معتمدون يضمنون سلامة التوصيلات ومطابقة المواصفات الكويتية.'],
                'service_type' => 'install',
                'status'     => ServiceStatus::Active,
                'sort_order' => 4,
            ],
            [
                'title'      => ['en' => 'Spotlight & Lighting Installation', 'ar' => 'تركيب سبوت لايت وإضاءة'],
                'slug'       => ['en' => 'spotlight-lighting-installation',   'ar' => 'تركيب-سبوت-لايت-واضاءة'],
                'h1'         => ['en' => 'Spotlight & Lighting Installation in Kuwait', 'ar' => 'تركيب سبوت لايت وإضاءة بالكويت'],
                'intro'      => ['en' => 'Installation of all lighting types including spotlights, chandeliers, LED and outdoor lighting in Kuwait.', 'ar' => 'تركيب جميع أنواع الإضاءة من سبوت لايت وثريات وإضاءة LED وإضاءة خارجية بالكويت.'],
                'content'    => ['en' => 'Elegant designs at competitive prices.', 'ar' => 'تصاميم أنيقة وتنفيذ احترافي بأسعار مناسبة.'],
                'service_type' => 'install',
                'status'     => ServiceStatus::Active,
                'sort_order' => 5,
            ],
            [
                'title'      => ['en' => '24/7 Emergency Electrician',  'ar' => 'كهربائي 24 ساعة طوارئ'],
                'slug'       => ['en' => 'emergency-electrician-24-7',  'ar' => 'كهربائي-24-ساعة'],
                'h1'         => ['en' => '24/7 Emergency Electrician in Kuwait', 'ar' => 'كهربائي طوارئ 24 ساعة في الكويت'],
                'intro'      => ['en' => 'Emergency electrician available 24/7 for all Kuwait areas. Immediate response to any electrical fault regardless of size.', 'ar' => 'خدمة فني كهربائي طوارئ متاحة على مدار 24 ساعة 7 أيام في الأسبوع لجميع مناطق الكويت.'],
                'content'    => ['en' => 'Immediate response to any electrical fault regardless of size.', 'ar' => 'استجابة فورية لأي عطل كهربائي مهما كان حجمه.'],
                'service_type' => 'general',
                'status'     => ServiceStatus::Active,
                'sort_order' => 6,
            ],
        ];

        foreach ($services as $data) {
            Service::updateOrCreate(['slug->en' => $data['slug']['en']], $data);
        }
    }
}
