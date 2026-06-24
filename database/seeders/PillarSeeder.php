<?php

namespace Database\Seeders;

use App\Models\Pillar;
use Illuminate\Database\Seeder;

class PillarSeeder extends Seeder
{
    public function run(): void
    {
        $pillars = [

            // Pillar 1 — فني كهربائي منازل الكويت
            [
                'title' => ['ar' => 'فني كهربائي منازل الكويت', 'en' => 'Home Electrician Kuwait'],
                'slug'  => ['ar' => 'فني-كهربائي-منازل-الكويت', 'en' => 'home-electrician-kuwait'],
                'meta_title' => [
                    'ar' => 'فني كهربائي منازل الكويت | خدمة 24 ساعة لجميع المناطق',
                    'en' => 'Home Electrician Kuwait | 24 Hour Service All Areas',
                ],
                'meta_description' => [
                    'ar' => 'فني كهربائي منازل في الكويت لإصلاح الأعطال وتمديد الأسلاك وتركيب الإضاءة. خدمة سريعة 24 ساعة لجميع مناطق الكويت. اتصل الآن.',
                    'en' => 'Home electrician in Kuwait for fault repair, wiring and lighting installation. Fast 24-hour service across all Kuwait areas. Call now.',
                ],
                'canonical_url' => [
                    'ar' => 'https://electricq8.com/ar/فني-كهربائي-منازل-الكويت',
                    'en' => 'https://electricq8.com/en/home-electrician-kuwait',
                ],
                'content' => [
                    'ar' => '<h2>خدمات فني كهربائي المنازل</h2><ul><li>إصلاح الأعطال الكهربائية المفاجئة</li><li>تمديد وتأسيس الكهرباء للمنازل الجديدة</li><li>تركيب الإضاءة والسبوت لايت والثريات</li><li>صيانة القواطع والمفاتيح والأفياش</li><li>توصيل المكيفات والأجهزة الكهربائية</li><li>خدمة طوارئ كهربائية 24 ساعة</li></ul><h2>لماذا تختارنا</h2><p>فريقنا من الفنيين المتخصصين يصل إليك في أسرع وقت ممكن، يستخدم أدوات حديثة، ويلتزم بمعايير السلامة الكهربائية الكاملة. نغطي جميع مناطق الكويت.</p>',
                    'en' => '<h2>Our Home Electrical Services</h2><ul><li>Emergency fault repair</li><li>New home wiring and installation</li><li>Lighting, spotlights and chandelier installation</li><li>Circuit breaker, switch and socket maintenance</li><li>AC and appliance wiring</li><li>24-hour emergency electrical service</li></ul><h2>Why Choose Us</h2><p>Our specialist technicians reach you fast, use professional tools, and follow full electrical safety standards. We cover all Kuwait governorates.</p>',
                ],
                'status' => 'active', 'sort_order' => 1, 'image_url' => null,
            ],

            // Pillar 2 — تأسيس وتمديد كهرباء في الكويت
            [
                'title' => ['ar' => 'تأسيس وتمديد كهرباء في الكويت', 'en' => 'Electrical Installation & Wiring Kuwait'],
                'slug'  => ['ar' => 'تأسيس-وتمديد-كهرباء-الكويت', 'en' => 'electrical-installation-wiring-kuwait'],
                'meta_title' => [
                    'ar' => 'تأسيس وتمديد كهرباء في الكويت | منازل وفلل وشركات',
                    'en' => 'Electrical Installation & Wiring Kuwait | Homes, Villas & Offices',
                ],
                'meta_description' => [
                    'ar' => 'خدمة تأسيس وتمديد كهرباء احترافية في الكويت للمنازل الجديدة والفلل والشقق والمكاتب. تنفيذ بمعايير سلامة عالية وأسعار مناسبة.',
                    'en' => 'Professional electrical installation and wiring in Kuwait for new homes, villas, apartments and offices. High safety standards and competitive prices.',
                ],
                'canonical_url' => [
                    'ar' => 'https://electricq8.com/ar/تأسيس-وتمديد-كهرباء-الكويت',
                    'en' => 'https://electricq8.com/en/electrical-installation-wiring-kuwait',
                ],
                'content' => [
                    'ar' => '<h2>ما تشمله خدمة التأسيس</h2><ul><li>تمديد الأسلاك والكابلات الكهربائية الداخلية</li><li>تركيب لوحات التوزيع الكهربائية</li><li>تأسيس نقاط الإضاءة والمفاتيح والأفياش</li><li>توصيل خطوط المكيفات والأجهزة الثقيلة</li><li>تأسيس كهرباء القسايم والمجمعات السكنية</li><li>تمديد كهرباء ثلاث فاز للشركات والمستودعات</li></ul>',
                    'en' => '<h2>What Our Installation Includes</h2><ul><li>Internal cable and wire laying</li><li>Distribution board installation</li><li>Lighting points, switches and socket installation</li><li>AC and heavy appliance wiring</li><li>Residential compound electrical setup</li><li>Three-phase wiring for businesses and warehouses</li></ul>',
                ],
                'status' => 'active', 'sort_order' => 2, 'image_url' => null,
            ],

            // Pillar 3 — صيانة وإصلاح أعطال كهربائية
            [
                'title' => ['ar' => 'صيانة وإصلاح أعطال كهربائية في الكويت', 'en' => 'Electrical Fault Repair & Maintenance Kuwait'],
                'slug'  => ['ar' => 'صيانة-وإصلاح-أعطال-كهربائية-الكويت', 'en' => 'electrical-fault-repair-maintenance-kuwait'],
                'meta_title' => [
                    'ar' => 'صيانة وإصلاح أعطال كهربائية في الكويت | كشف ماس وانقطاع تيار',
                    'en' => 'Electrical Fault Repair Kuwait | Short Circuit & Power Outage Fix',
                ],
                'meta_description' => [
                    'ar' => 'إصلاح الأعطال الكهربائية في الكويت بسرعة واحترافية. كشف ماس كهربائي، انقطاع تيار، إصلاح قواطع ومفاتيح. فني يصل إليك فوراً.',
                    'en' => 'Fast professional electrical fault repair in Kuwait. Short circuit detection, power outage fix, breaker and switch repair. Technician reaches you immediately.',
                ],
                'canonical_url' => [
                    'ar' => 'https://electricq8.com/ar/صيانة-وإصلاح-أعطال-كهربائية-الكويت',
                    'en' => 'https://electricq8.com/en/electrical-fault-repair-maintenance-kuwait',
                ],
                'content' => [
                    'ar' => '<h2>الأعطال التي نعالجها</h2><ul><li>الماس الكهربائي وحرق الأسلاك</li><li>انقطاع التيار الكهربائي الجزئي أو الكلي</li><li>تعطل القواطع الكهربائية</li><li>ضعف الجهد الكهربائي</li><li>احتراق المفاتيح والأفياش</li><li>تلف التوصيلات والوصلات الكهربائية</li></ul>',
                    'en' => '<h2>Faults We Fix</h2><ul><li>Short circuits and burnt wiring</li><li>Partial or total power outages</li><li>Tripped or faulty circuit breakers</li><li>Low voltage issues</li><li>Burnt switches and sockets</li><li>Damaged connections and joints</li></ul>',
                ],
                'status' => 'active', 'sort_order' => 3, 'image_url' => null,
            ],

            // Pillar 4 — تركيب إضاءة وسبوت لايت
            [
                'title' => ['ar' => 'تركيب إضاءة وسبوت لايت في الكويت', 'en' => 'Lighting & Spotlight Installation Kuwait'],
                'slug'  => ['ar' => 'تركيب-إضاءة-وسبوت-لايت-الكويت', 'en' => 'lighting-spotlight-installation-kuwait'],
                'meta_title' => [
                    'ar' => 'تركيب إضاءة وسبوت لايت في الكويت | LED وثريات وإضاءة خارجية',
                    'en' => 'Lighting & Spotlight Installation Kuwait | LED, Chandeliers & Outdoor',
                ],
                'meta_description' => [
                    'ar' => 'تركيب إضاءة وسبوت لايت احترافي في الكويت. LED موفر للطاقة، ثريات، إضاءة داخلية وخارجية للمنازل والفلل والمكاتب.',
                    'en' => 'Professional lighting and spotlight installation in Kuwait. Energy-saving LED, chandeliers, indoor and outdoor lighting for homes, villas and offices.',
                ],
                'canonical_url' => [
                    'ar' => 'https://electricq8.com/ar/تركيب-إضاءة-وسبوت-لايت-الكويت',
                    'en' => 'https://electricq8.com/en/lighting-spotlight-installation-kuwait',
                ],
                'content' => [
                    'ar' => '<h2>أنواع الإضاءة التي نركبها</h2><ul><li>سبوت لايت مودرن داخلي وخارجي</li><li>إضاءة LED موفرة للطاقة</li><li>ثريات وإضاءة ديكورية</li><li>إضاءة المجالس والغرف والممرات</li><li>إضاءة حدائق وأسطح ومداخل الفلل</li><li>إضاءة واجهات المحلات التجارية</li></ul>',
                    'en' => '<h2>Lighting Types We Install</h2><ul><li>Modern indoor and outdoor spotlights</li><li>Energy-saving LED lighting</li><li>Chandeliers and decorative lighting</li><li>Living room, bedroom and corridor lighting</li><li>Garden, rooftop and villa entrance lighting</li><li>Commercial shop front lighting</li></ul>',
                ],
                'status' => 'active', 'sort_order' => 4, 'image_url' => null,
            ],

            // Pillar 5 — لوحات كهربائية وقواطع
            [
                'title' => ['ar' => 'لوحات كهربائية وقواطع في الكويت', 'en' => 'Electrical Panels & Circuit Breakers Kuwait'],
                'slug'  => ['ar' => 'لوحات-كهربائية-وقواطع-الكويت', 'en' => 'electrical-panels-circuit-breakers-kuwait'],
                'meta_title' => [
                    'ar' => 'لوحات كهربائية وقواطع في الكويت | تركيب وتبديل وصيانة',
                    'en' => 'Electrical Panels & Circuit Breakers Kuwait | Install, Replace & Maintain',
                ],
                'meta_description' => [
                    'ar' => 'تركيب وتبديل وصيانة لوحات الكهرباء والقواطع في الكويت للمنازل والفلل والشركات. فني متخصص يصل إليك بسرعة.',
                    'en' => 'Electrical panel and circuit breaker installation, replacement and maintenance in Kuwait for homes, villas and businesses. Specialist technician reaches you fast.',
                ],
                'canonical_url' => [
                    'ar' => 'https://electricq8.com/ar/لوحات-كهربائية-وقواطع-الكويت',
                    'en' => 'https://electricq8.com/en/electrical-panels-circuit-breakers-kuwait',
                ],
                'content' => [
                    'ar' => '<h2>خدمات اللوحات الكهربائية</h2><ul><li>تركيب لوحات توزيع كهربائية جديدة</li><li>تبديل اللوحات القديمة أو التالفة</li><li>توسعة اللوحات لإضافة دوائر جديدة</li><li>تركيب واستبدال القواطع الكهربائية</li><li>تركيب قواطع التفاضل لحماية الأشخاص</li><li>فحص وصيانة اللوحات الكهربائية الدورية</li></ul>',
                    'en' => '<h2>Electrical Panel Services</h2><ul><li>New distribution panel installation</li><li>Old or damaged panel replacement</li><li>Panel expansion for additional circuits</li><li>Circuit breaker installation and replacement</li><li>RCD / RCCB installation for personal protection</li><li>Periodic panel inspection and maintenance</li></ul>',
                ],
                'status' => 'active', 'sort_order' => 5, 'image_url' => null,
            ],

            // Pillar 6 — كهربائي فلل وشركات
            [
                'title' => ['ar' => 'كهربائي فلل وشركات الكويت', 'en' => 'Electrician for Villas & Companies Kuwait'],
                'slug'  => ['ar' => 'كهربائي-فلل-وشركات-الكويت', 'en' => 'electrician-villas-companies-kuwait'],
                'meta_title' => [
                    'ar' => 'كهربائي فلل وشركات في الكويت | تأسيس وصيانة وإصلاح',
                    'en' => 'Electrician for Villas & Companies Kuwait | Install, Maintain & Repair',
                ],
                'meta_description' => [
                    'ar' => 'خدمات كهربائية متكاملة للفلل والشركات والمجمعات والمستودعات في الكويت. تأسيس، صيانة، إصلاح أعطال.',
                    'en' => 'Complete electrical services for villas, companies, complexes and warehouses in Kuwait. Installation, maintenance and fault repair.',
                ],
                'canonical_url' => [
                    'ar' => 'https://electricq8.com/ar/كهربائي-فلل-وشركات-الكويت',
                    'en' => 'https://electricq8.com/en/electrician-villas-companies-kuwait',
                ],
                'content' => [
                    'ar' => '<h2>خدماتنا للفلل</h2><ul><li>تأسيس كهرباء الفلل الجديدة من الصفر</li><li>تركيب إضاءة داخلية وخارجية وحدائق</li><li>توصيل المسابح والمضخات الكهربائية</li><li>صيانة وإصلاح جميع الأعطال الكهربائية</li></ul><h2>خدماتنا للشركات</h2><ul><li>تمديد كهرباء ثلاث فاز للمصانع والمستودعات</li><li>تركيب لوحات كهربائية صناعية</li><li>صيانة دورية لكهرباء المكاتب والمحلات</li><li>طوارئ كهربائية للشركات 24 ساعة</li></ul>',
                    'en' => '<h2>Our Villa Services</h2><ul><li>Complete new villa electrical installation</li><li>Indoor, outdoor and garden lighting</li><li>Pool and pump electrical connection</li><li>Fault repair and maintenance</li></ul><h2>Our Commercial Services</h2><ul><li>Three-phase wiring for factories and warehouses</li><li>Industrial electrical panel installation</li><li>Periodic office and shop maintenance</li><li>24-hour commercial emergency service</li></ul>',
                ],
                'status' => 'active', 'sort_order' => 6, 'image_url' => null,
            ],

            // Pillar 7 — كهربائي 24 ساعة طوارئ
            [
                'title' => ['ar' => 'كهربائي 24 ساعة طوارئ الكويت', 'en' => '24 Hour Emergency Electrician Kuwait'],
                'slug'  => ['ar' => 'كهربائي-24-ساعة-طوارئ-الكويت', 'en' => '24-hour-emergency-electrician-kuwait'],
                'meta_title' => [
                    'ar' => 'كهربائي 24 ساعة طوارئ الكويت | فني يصل إليك فوراً',
                    'en' => '24 Hour Emergency Electrician Kuwait | Technician Reaches You Immediately',
                ],
                'meta_description' => [
                    'ar' => 'كهربائي طوارئ في الكويت على مدار 24 ساعة 7 أيام. ماس كهربائي، انقطاع تيار، أي عطل مفاجئ — فني يصل إليك فوراً في جميع المناطق.',
                    'en' => 'Emergency electrician in Kuwait available 24 hours 7 days. Short circuit, power outage, any sudden fault — technician reaches you immediately across all areas.',
                ],
                'canonical_url' => [
                    'ar' => 'https://electricq8.com/ar/كهربائي-24-ساعة-طوارئ-الكويت',
                    'en' => 'https://electricq8.com/en/24-hour-emergency-electrician-kuwait',
                ],
                'content' => [
                    'ar' => '<h2>حالات الطوارئ التي نتعامل معها</h2><ul><li>الماس الكهربائي الحاد</li><li>انقطاع التيار الكهربائي المفاجئ</li><li>احتراق اللوحة الكهربائية أو القواطع</li><li>شرر أو رائحة احتراق من الأسلاك</li><li>صعق كهربائي أو خطر على السلامة</li></ul><h2>تغطية جميع مناطق الكويت</h2><p>لدينا فنيون موزعون على جميع مناطق الكويت — العاصمة، حولي، الفروانية، الجهراء، الأحمدي، ومبارك الكبير.</p>',
                    'en' => '<h2>Emergency Situations We Handle</h2><ul><li>Severe short circuits</li><li>Sudden power outages</li><li>Burnt electrical panel or breakers</li><li>Sparks or burning smell from wiring</li><li>Electric shock risk or safety hazard</li></ul><h2>Coverage Across All Kuwait Areas</h2><p>We have technicians across all Kuwait governorates — Capital, Hawalli, Farwaniya, Jahra, Ahmadi and Mubarak Al-Kabeer.</p>',
                ],
                'status' => 'active', 'sort_order' => 7, 'image_url' => null,
            ],

        ];

        foreach ($pillars as $data) {
            Pillar::firstOrCreate(
                ['slug->en' => $data['slug']['en']],
                $data
            );
        }
    }
}
