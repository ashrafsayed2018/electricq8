<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [

            [
                'title' => ['ar' => 'كهربائي منازل الكويت', 'en' => 'Home Electrician Kuwait'],
                'slug' => ['ar' => 'كهربائي-منازل-الكويت', 'en' => 'home-electrician-kuwait'],
                'sort_order' => 1,
                'status' => 'active',
            ],

            [
                'title' => ['ar' => 'كهربائي 24 ساعة الكويت', 'en' => 'Emergency Electrician Kuwait'],
                'slug' => ['ar' => 'كهربائي-24-ساعة-الكويت', 'en' => 'emergency-electrician-kuwait'],
                'sort_order' => 2,
                'status' => 'active',
            ],

            [
                'title' => ['ar' => 'تصليح الأعطال الكهربائية', 'en' => 'Electrical Fault Repair'],
                'slug' => ['ar' => 'تصليح-الأعطال-الكهربائية', 'en' => 'electrical-fault-repair'],
                'sort_order' => 3,
                'status' => 'active',
            ],

            [
                'title' => ['ar' => 'كشف الماس الكهربائي', 'en' => 'Short Circuit Detection'],
                'slug' => ['ar' => 'كشف-الماس-الكهربائي', 'en' => 'short-circuit-detection'],
                'sort_order' => 4,
                'status' => 'active',
            ],

            [
                'title' => ['ar' => 'تمديدات وتأسيس الكهرباء', 'en' => 'Electrical Wiring & Installation'],
                'slug' => ['ar' => 'تمديدات-وتأسيس-الكهرباء', 'en' => 'electrical-wiring-installation'],
                'sort_order' => 5,
                'status' => 'active',
            ],

            [
                'title' => ['ar' => 'تركيب وصيانة اللوحات الكهربائية', 'en' => 'Electrical Panel Installation'],
                'slug' => ['ar' => 'تركيب-وصيانة-اللوحات-الكهربائية', 'en' => 'electrical-panel-installation'],
                'sort_order' => 6,
                'status' => 'active',
            ],

            [
                'title' => ['ar' => 'تبديل القواطع الكهربائية', 'en' => 'Circuit Breaker Replacement'],
                'slug' => ['ar' => 'تبديل-القواطع-الكهربائية', 'en' => 'circuit-breaker-replacement'],
                'sort_order' => 7,
                'status' => 'active',
            ],

            [
                'title' => ['ar' => 'تركيب سبوت لايت وإضاءة', 'en' => 'Spotlight & Lighting Installation'],
                'slug' => ['ar' => 'تركيب-سبوت-لايت-وإضاءة', 'en' => 'spotlight-lighting-installation'],
                'sort_order' => 8,
                'status' => 'active',
            ],

            [
                'title' => ['ar' => 'تركيب الثريات', 'en' => 'Chandelier Installation'],
                'slug' => ['ar' => 'تركيب-الثريات', 'en' => 'chandelier-installation'],
                'sort_order' => 9,
                'status' => 'active',
            ],

            [
                'title' => ['ar' => 'تركيب أفياش ومفاتيح كهربائية', 'en' => 'Switches & Sockets Installation'],
                'slug' => ['ar' => 'تركيب-أفياش-ومفاتيح-كهربائية', 'en' => 'switches-sockets-installation'],
                'sort_order' => 10,
                'status' => 'active',
            ],

            [
                'title' => ['ar' => 'كهربائي فلل الكويت', 'en' => 'Villa Electrician Kuwait'],
                'slug' => ['ar' => 'كهربائي-فلل-الكويت', 'en' => 'villa-electrician-kuwait'],
                'sort_order' => 11,
                'status' => 'active',
            ],

            [
                'title' => ['ar' => 'كهربائي شركات ومكاتب', 'en' => 'Commercial Electrician Kuwait'],
                'slug' => ['ar' => 'كهربائي-شركات-ومكاتب', 'en' => 'commercial-electrician-kuwait'],
                'sort_order' => 12,
                'status' => 'active',
            ],

        ];

        foreach ($services as $service) {
            Service::updateOrCreate(
                ['slug->en' => $service['slug']['en']],
                $service
            );
        }

        $this->command->info('ServiceSeeder: 12 services seeded successfully.');
    }
}
