<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AreasSeeder extends Seeder
{
    public function run(): void
    {
        $areas = [
            // Capital Governorate
            ['en' => 'Kuwait City',                       'ar' => 'مدينة الكويت',                          'gov' => 'capital'],
            ['en' => 'Dasman',                            'ar' => 'دسمان',                                 'gov' => 'capital'],
            ['en' => 'Sharq',                             'ar' => 'الشرق',                                 'gov' => 'capital'],
            ['en' => 'Sawaber',                           'ar' => 'الصوابر',                               'gov' => 'capital'],
            ['en' => 'Khaitan',                           'ar' => 'خيطان',                                 'gov' => 'capital'],
            ['en' => 'Qurtuba',                           'ar' => 'قرطبة',                                 'gov' => 'capital'],
            ['en' => 'Granada',                           'ar' => 'غرناطة',                                'gov' => 'capital'],
            ['en' => 'North West Sulaibikhat',            'ar' => 'شمال غرب الصليبيخات',                  'gov' => 'capital'],
            ['en' => 'Mirqab',                            'ar' => 'المرقاب',                               'gov' => 'capital'],
            ['en' => 'Qibla',                             'ar' => 'القبلة',                                'gov' => 'capital'],
            ['en' => 'Salhiya',                           'ar' => 'الصالحية',                              'gov' => 'capital'],
            ['en' => 'Watiya',                            'ar' => 'الوطية',                                'gov' => 'capital'],
            ['en' => 'Surra',                             'ar' => 'السرة',                                 'gov' => 'capital'],
            ['en' => 'Bneid Al-Qar',                     'ar' => 'بنيد القار',                            'gov' => 'capital'],
            ['en' => 'Kaifan',                            'ar' => 'كيفان',                                 'gov' => 'capital'],
            ['en' => 'Doha',                              'ar' => 'الدوحة',                                'gov' => 'capital'],
            ['en' => 'Dasma',                             'ar' => 'الدسمة',                                'gov' => 'capital'],
            ['en' => 'Daiya',                             'ar' => 'الدعية',                                'gov' => 'capital'],
            ['en' => 'Yarmouk',                           'ar' => 'اليرموك',                               'gov' => 'capital'],
            ['en' => 'Sulaibikhat',                       'ar' => 'الصليبيخات',                            'gov' => 'capital'],
            ['en' => 'Rawda',                             'ar' => 'الروضة',                                'gov' => 'capital'],
            ['en' => 'Nuzha',                             'ar' => 'النزهة',                                'gov' => 'capital'],
            ['en' => 'Faiha',                             'ar' => 'الفيحاء',                               'gov' => 'capital'],
            ['en' => 'Shamiya',                           'ar' => 'الشامية',                               'gov' => 'capital'],
            ['en' => 'Shuwaikh',                          'ar' => 'الشويخ',                                'gov' => 'capital'],
            ['en' => 'Nahda',                             'ar' => 'النهضة',                                'gov' => 'capital'],
            ['en' => 'Abdullah Al-Salem',                 'ar' => 'ضاحية عبدالله السالم',                 'gov' => 'capital'],
            ['en' => 'Adailiya',                          'ar' => 'العديلية',                              'gov' => 'capital'],
            ['en' => 'Khalidiya',                         'ar' => 'الخالدية',                              'gov' => 'capital'],
            ['en' => 'Qadsiya',                           'ar' => 'القادسية',                              'gov' => 'capital'],
            ['en' => 'Rai',                               'ar' => 'الري',                                  'gov' => 'capital'],
            ['en' => 'Qairawan',                          'ar' => 'القيروان',                              'gov' => 'capital'],
            ['en' => 'Jaber Al-Ahmad City',               'ar' => 'مدينة جابر الأحمد',                    'gov' => 'capital'],

            // Hawalli Governorate
            ['en' => 'Hawalli',                           'ar' => 'حولي',                                  'gov' => 'hawalli'],
            ['en' => 'Mishrif',                           'ar' => 'مشرف',                                  'gov' => 'hawalli'],
            ['en' => 'Salwa',                             'ar' => 'سلوى',                                  'gov' => 'hawalli'],
            ['en' => 'Mubarak Al-Abdullah Al-Jaber',      'ar' => 'ضاحية مبارك العبدالله الجابر',          'gov' => 'hawalli'],
            ['en' => 'Shaab',                             'ar' => 'الشعب',                                 'gov' => 'hawalli'],
            ['en' => 'Bayan',                             'ar' => 'بيان',                                  'gov' => 'hawalli'],
            ['en' => 'South Surra',                       'ar' => 'جنوب السرة',                            'gov' => 'hawalli'],
            ['en' => 'Salmiya',                           'ar' => 'السالمية',                              'gov' => 'hawalli'],
            ['en' => 'Bidaa',                             'ar' => 'البدع',                                  'gov' => 'hawalli'],
            ['en' => 'Hittin',                            'ar' => 'حطين',                                  'gov' => 'hawalli'],
            ['en' => 'Salam',                             'ar' => 'السلام',                                'gov' => 'hawalli'],
            ['en' => 'Jabriya',                           'ar' => 'الجابرية',                              'gov' => 'hawalli'],
            ['en' => 'Rumaithiya',                        'ar' => 'الرميثية',                              'gov' => 'hawalli'],
            ['en' => 'Nuqra',                             'ar' => 'النقرة',                                'gov' => 'hawalli'],
            ['en' => 'Zahraa',                            'ar' => 'الزهراء',                               'gov' => 'hawalli'],
            ['en' => 'Hawalli Maidan',                    'ar' => 'ميدان حولي',                            'gov' => 'hawalli'],
            ['en' => 'Siddiq',                            'ar' => 'الصديق',                                'gov' => 'hawalli'],
            ['en' => 'Shuhada',                           'ar' => 'الشهداء',                               'gov' => 'hawalli'],

            // Farwaniya Governorate
            ['en' => 'Abraq Khaitan',                     'ar' => 'أبرق خيطان',                           'gov' => 'farwaniya'],
            ['en' => 'New Khaitan',                       'ar' => 'خيطان الجديدة',                         'gov' => 'farwaniya'],
            ['en' => 'Abbasiya',                          'ar' => 'العباسية',                              'gov' => 'farwaniya'],
            ['en' => 'Rabiya',                            'ar' => 'الرابية',                               'gov' => 'farwaniya'],
            ['en' => 'Abdullah Al-Mubarak',               'ar' => 'ضاحية عبدالله المبارك',                 'gov' => 'farwaniya'],
            ['en' => 'Andalus',                           'ar' => 'الأندلس',                               'gov' => 'farwaniya'],
            ['en' => 'Omariya',                           'ar' => 'العمرية',                               'gov' => 'farwaniya'],
            ['en' => 'Firdous',                           'ar' => 'الفردوس',                               'gov' => 'farwaniya'],
            ['en' => 'Rehab',                             'ar' => 'الرحاب',                                'gov' => 'farwaniya'],
            ['en' => 'Ishbiliya',                         'ar' => 'أشبيلية',                               'gov' => 'farwaniya'],
            ['en' => 'Ardiya',                            'ar' => 'العارضية',                              'gov' => 'farwaniya'],
            ['en' => 'Farwaniya',                         'ar' => 'الفروانية',                             'gov' => 'farwaniya'],
            ['en' => 'Rigai',                             'ar' => 'الرقعي',                                'gov' => 'farwaniya'],
            ['en' => 'West Abdullah Al-Mubarak',          'ar' => 'غرب عبدالله المبارك',                  'gov' => 'farwaniya'],
            ['en' => 'Khaitan Farwaniya',                 'ar' => 'خيطان',                                 'gov' => 'farwaniya'],
            ['en' => 'Ardiya Stores',                     'ar' => 'العارضية مخازن',                        'gov' => 'farwaniya'],
            ['en' => 'Shadadiya',                         'ar' => 'الشدادية',                              'gov' => 'farwaniya'],
            ['en' => 'Sabah Al-Naser',                    'ar' => 'ضاحية صباح الناصر',                     'gov' => 'farwaniya'],
            ['en' => 'Subaiha',                           'ar' => 'الصبيح',                                'gov' => 'farwaniya'],
            ['en' => 'Jleeb Al-Shuyoukh',                 'ar' => 'جليب الشيوخ',                           'gov' => 'farwaniya'],
            ['en' => 'Ardiya Industrial',                 'ar' => 'العارضية الصناعية',                     'gov' => 'farwaniya'],
            ['en' => 'Hassawi',                           'ar' => 'الحساوي',                               'gov' => 'farwaniya'],
            ['en' => 'Rai Industrial',                    'ar' => 'الري الصناعية',                         'gov' => 'farwaniya'],

            // Jahra Governorate
            ['en' => 'Sulaibiya',                         'ar' => 'الصليبية',                              'gov' => 'jahra'],
            ['en' => 'Tayma',                             'ar' => 'تيماء',                                 'gov' => 'jahra'],
            ['en' => 'Old Jahra',                         'ar' => 'الجهراء القديمة',                       'gov' => 'jahra'],
            ['en' => 'Kabd',                              'ar' => 'كبد',                                   'gov' => 'jahra'],
            ['en' => 'Amghara',                           'ar' => 'أمغرة',                                 'gov' => 'jahra'],
            ['en' => 'Naseem',                            'ar' => 'النسيم',                                'gov' => 'jahra'],
            ['en' => 'New Jahra',                         'ar' => 'الجهراء الجديدة',                       'gov' => 'jahra'],
            ['en' => 'Raudhatain',                        'ar' => 'الروضتين',                              'gov' => 'jahra'],
            ['en' => 'Sulaibiya Industrial',              'ar' => 'الصليبية الصناعية',                     'gov' => 'jahra'],
            ['en' => 'Naeem',                             'ar' => 'النعيم',                                'gov' => 'jahra'],
            ['en' => 'Uyoun',                             'ar' => 'العيون',                                'gov' => 'jahra'],
            ['en' => 'Saad Al-Abdullah City',             'ar' => 'مدينة سعد العبدالله',                  'gov' => 'jahra'],
            ['en' => 'Subbiya',                           'ar' => 'الصبية',                                'gov' => 'jahra'],
            ['en' => 'Qasr',                              'ar' => 'القصر',                                 'gov' => 'jahra'],
            ['en' => 'Qasriya',                           'ar' => 'القصرية',                               'gov' => 'jahra'],
            ['en' => 'Salmi',                             'ar' => 'السالمي',                               'gov' => 'jahra'],
            ['en' => 'South Jahra',                       'ar' => 'جنوب الجهراء',                          'gov' => 'jahra'],
            ['en' => 'Sulaibiya Agricultural',            'ar' => 'الصليبية الزراعية',                     'gov' => 'jahra'],
            ['en' => 'Waha',                              'ar' => 'الواحة',                                'gov' => 'jahra'],
            ['en' => 'Abdali',                            'ar' => 'العبدلي',                               'gov' => 'jahra'],
            ['en' => 'Mutlaa',                            'ar' => 'المطلاع',                               'gov' => 'jahra'],
            ['en' => 'Jahra Industrial',                  'ar' => 'الجهراء الصناعية',                      'gov' => 'jahra'],

            // Ahmadi Governorate
            ['en' => 'Fintas',                            'ar' => 'الفنطاس',                               'gov' => 'ahmadi'],
            ['en' => 'Ruqa',                              'ar' => 'الرقة',                                 'gov' => 'ahmadi'],
            ['en' => 'Mahboula',                          'ar' => 'المهبولة',                              'gov' => 'ahmadi'],
            ['en' => 'Jaber Al-Ali',                      'ar' => 'ضاحية جابر العلي',                      'gov' => 'ahmadi'],
            ['en' => 'Abdullah Port',                     'ar' => 'ميناء عبدالله',                         'gov' => 'ahmadi'],
            ['en' => 'Aqaila',                            'ar' => 'العقيلة',                               'gov' => 'ahmadi'],
            ['en' => 'Hadiya',                            'ar' => 'هدية',                                  'gov' => 'ahmadi'],
            ['en' => 'Ahmadi',                            'ar' => 'الأحمدي',                               'gov' => 'ahmadi'],
            ['en' => 'Wafra Agricultural',                'ar' => 'الوفرة الزراعية',                       'gov' => 'ahmadi'],
            ['en' => 'Fahad Al-Ahmad',                    'ar' => 'ضاحية فهد الأحمد',                      'gov' => 'ahmadi'],
            ['en' => 'East Ahmadi',                       'ar' => 'شرق الأحمدي',                           'gov' => 'ahmadi'],
            ['en' => 'Fahaheel',                          'ar' => 'الفحيحيل',                              'gov' => 'ahmadi'],
            ['en' => 'Mangaf',                            'ar' => 'المنقف',                                'gov' => 'ahmadi'],
            ['en' => 'Khairan',                           'ar' => 'الخيران',                               'gov' => 'ahmadi'],
            ['en' => 'Industrial Ahmadi',                 'ar' => 'الصناعية',                              'gov' => 'ahmadi'],
            ['en' => 'Sabah Al-Ahmad City',               'ar' => 'مدينة صباح الأحمد',                    'gov' => 'ahmadi'],
            ['en' => 'Khairan City',                      'ar' => 'مدينة الخيران',                         'gov' => 'ahmadi'],
            ['en' => 'Dhaher',                            'ar' => 'الظهر',                                 'gov' => 'ahmadi'],
            ['en' => 'Abu Halifa',                        'ar' => 'أبو حليفة',                             'gov' => 'ahmadi'],
            ['en' => 'Wafra',                             'ar' => 'الوفرة',                                'gov' => 'ahmadi'],
            ['en' => 'Bnaider',                           'ar' => 'بنيدر',                                 'gov' => 'ahmadi'],
            ['en' => 'Shuaiba',                           'ar' => 'الشعيبة',                               'gov' => 'ahmadi'],
            ['en' => 'Wara',                              'ar' => 'وارة',                                  'gov' => 'ahmadi'],
            ['en' => 'Ahmadi Port',                       'ar' => 'ميناء الأحمدي',                         'gov' => 'ahmadi'],
            ['en' => 'Zour',                              'ar' => 'الزور',                                 'gov' => 'ahmadi'],
            ['en' => 'Julaiaa',                           'ar' => 'الجليعة',                               'gov' => 'ahmadi'],
            ['en' => 'Ali Sabah Al-Salem - Um Al-Hayman', 'ar' => 'ضاحية علي صباح السالم - أم الهيمان',   'gov' => 'ahmadi'],
            ['en' => 'Nuwaiseeb',                         'ar' => 'النويصيب',                              'gov' => 'ahmadi'],
            ['en' => 'Sabah Al-Ahmad Marine City',        'ar' => 'مدينة صباح الأحمد البحرية',             'gov' => 'ahmadi'],

            // Mubarak Al-Kabeer Governorate
            ['en' => 'Adan',                              'ar' => 'العدان',                                'gov' => 'mubarak_al_kabeer'],
            ['en' => 'Abu Ftaira',                        'ar' => 'أبو فطيرة',                             'gov' => 'mubarak_al_kabeer'],
            ['en' => 'Qusour',                            'ar' => 'القصور',                                'gov' => 'mubarak_al_kabeer'],
            ['en' => 'Sabhan',                            'ar' => 'صبحان',                                 'gov' => 'mubarak_al_kabeer'],
            ['en' => 'Qurain',                            'ar' => 'القرين',                                'gov' => 'mubarak_al_kabeer'],
            ['en' => 'Funaitees',                         'ar' => 'الفنيطيس',                              'gov' => 'mubarak_al_kabeer'],
            ['en' => 'Sabah Al-Salem',                    'ar' => 'ضاحية صباح السالم',                     'gov' => 'mubarak_al_kabeer'],
            ['en' => 'Masayel',                           'ar' => 'المسيلة',                               'gov' => 'mubarak_al_kabeer'],
            ['en' => 'Mubarak Al-Kabeer',                 'ar' => 'ضاحية مبارك الكبير',                    'gov' => 'mubarak_al_kabeer'],
            ['en' => 'Abu Al-Hasaniya',                   'ar' => 'أبو الحصاني',                           'gov' => 'mubarak_al_kabeer'],
        ];

        foreach ($areas as $i => $area) {
            $slug = Str::slug($area['en']);

            Location::updateOrCreate(
                ['slug->en' => $slug],
                [
                    'name'        => ['en' => $area['en'], 'ar' => $area['ar']],
                    'slug'        => ['en' => $slug,       'ar' => Str::slug($area['ar'], '-', null)],
                    'governorate' => $area['gov'],
                    'description' => [
                        'en' => 'Electrical services in ' . $area['en'] . '.',
                        'ar' => 'خدمات الكهرباء في ' . $area['ar'] . '.',
                    ],
                    'is_active'   => true,
                    'sort_order'  => $i + 1,
                ]
            );
        }
    }
}
