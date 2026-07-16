<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

/**
 * HOW TO USE:
 * For each location below, fill in:
 *   'description_ar' => '...' (Arabic, 300-500 words, unique to the area)
 *   'description_en' => '...' (English, 300-500 words, unique to the area)
 *
 * The description should mention:
 *  - The area name and governorate
 *  - What types of buildings/residents are there (villas, apartments, commercial)
 *  - Common electrical problems in that area
 *  - Why ElectricQ8 is the best choice for that specific area
 *  - Response time, warranty, 24/7 availability
 *
 * Run with: php artisan db:seed --class=LocationDescriptionSeeder
 */
class LocationDescriptionSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [

            // ═══════════════════════════════════════════
            // AHMADI GOVERNORATE — محافظة الأحمدي
            // ═══════════════════════════════════════════

            ['id' => 4,   'ar' => 'الأحمدي',               'en' => 'Ahmadi',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 10,  'ar' => 'الفحيحيل',              'en' => 'Fahaheel',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 27,  'ar' => 'المنقف',                'en' => 'Mangaf',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 28,  'ar' => 'الفنطاس',               'en' => 'Fintas',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 113, 'ar' => 'الرقة',                 'en' => 'Ruqa',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 114, 'ar' => 'المهبولة',              'en' => 'Mahboula',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 115, 'ar' => 'ضاحية جابر العلي',      'en' => 'Jaber Al-Ali',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 116, 'ar' => 'ميناء عبدالله',         'en' => 'Abdullah Port',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 117, 'ar' => 'العقيلة',               'en' => 'Aqaila',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 118, 'ar' => 'هدية',                  'en' => 'Hadiya',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 119, 'ar' => 'الوفرة الزراعية',       'en' => 'Wafra Agricultural',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 120, 'ar' => 'ضاحية فهد الأحمد',      'en' => 'Fahad Al-Ahmad',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 121, 'ar' => 'الخيران',               'en' => 'Khairan',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 122, 'ar' => 'أبو حليفة',             'en' => 'Abu Halifa',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 123, 'ar' => 'الوفرة',                'en' => 'Wafra',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 124, 'ar' => 'الشعيبة',               'en' => 'Shuaiba',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 125, 'ar' => 'ميناء الأحمدي',         'en' => 'Ahmadi Port',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 126, 'ar' => 'الظهر',                 'en' => 'Dhaher',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 127, 'ar' => 'مدينة صباح الأحمد',     'en' => 'Sabah Al-Ahmad City',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 128, 'ar' => 'ضاحية علي صباح السالم', 'en' => 'Ali Sabah Al-Salem',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 129, 'ar' => 'النويصيب',              'en' => 'Nuwaiseeb',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 130, 'ar' => 'الزور',                 'en' => 'Zour',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 131, 'ar' => 'الجليعة',               'en' => 'Julaiaa',
             'description_ar' => '',
             'description_en' => ''],

            // ═══════════════════════════════════════════
            // CAPITAL GOVERNORATE — محافظة العاصمة
            // ═══════════════════════════════════════════

            ['id' => 1,   'ar' => 'مدينة الكويت',          'en' => 'Kuwait City',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 18,  'ar' => 'الشويخ',                'en' => 'Shuwaikh',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 19,  'ar' => 'شرق',                   'en' => 'Sharq',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 20,  'ar' => 'القبلة',                'en' => 'Qibla',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 21,  'ar' => 'دسمان',                 'en' => 'Dasman',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 22,  'ar' => 'عبدالله السالم',        'en' => 'Abdullah Al-Salem',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 33,  'ar' => 'الصوابر',               'en' => 'Sawaber',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 34,  'ar' => 'المرقاب',               'en' => 'Mirqab',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 35,  'ar' => 'الصالحية',              'en' => 'Salhiya',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 36,  'ar' => 'الوطية',                'en' => 'Watiya',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 37,  'ar' => 'بنيد القار',            'en' => 'Bneid Al-Qar',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 38,  'ar' => 'كيفان',                 'en' => 'Kaifan',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 39,  'ar' => 'الدوحة',                'en' => 'Doha',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 40,  'ar' => 'الدسمة',                'en' => 'Dasma',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 41,  'ar' => 'الدعية',                'en' => 'Daiya',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 42,  'ar' => 'اليرموك',               'en' => 'Yarmouk',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 43,  'ar' => 'الصليبيخات',            'en' => 'Sulaibikhat',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 44,  'ar' => 'الروضة',                'en' => 'Rawda',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 45,  'ar' => 'النزهة',                'en' => 'Nuzha',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 46,  'ar' => 'الفيحاء',               'en' => 'Faiha',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 47,  'ar' => 'الشامية',               'en' => 'Shamiya',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 48,  'ar' => 'النهضة',                'en' => 'Nahda',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 49,  'ar' => 'العديلية',              'en' => 'Adailiya',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 50,  'ar' => 'الخالدية',              'en' => 'Khalidiya',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 51,  'ar' => 'القادسية',              'en' => 'Qadsiya',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 52,  'ar' => 'الري',                  'en' => 'Rai',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 53,  'ar' => 'القيروان',              'en' => 'Qairawan',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 54,  'ar' => 'السرة',                 'en' => 'Surra',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 55,  'ar' => 'غرناطة',                'en' => 'Granada',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 56,  'ar' => 'قرطبة',                 'en' => 'Qurtuba',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 57,  'ar' => 'شمال غرب الصليبيخات',   'en' => 'NW Sulaibikhat',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 58,  'ar' => 'مدينة جابر الأحمد',     'en' => 'Jaber Al-Ahmad City',
             'description_ar' => '',
             'description_en' => ''],

            // ═══════════════════════════════════════════
            // FARWANIYA GOVERNORATE — محافظة الفروانية
            // ═══════════════════════════════════════════

            ['id' => 3,   'ar' => 'الفروانية',             'en' => 'Farwaniya',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 11,  'ar' => 'خيطان',                 'en' => 'Khaitan',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 23,  'ar' => 'جليب الشيوخ',           'en' => 'Jleeb Al-Shuyoukh',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 25,  'ar' => 'العارضية',              'en' => 'Ardiya',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 71,  'ar' => 'أبرق خيطان',            'en' => 'Abraq Khaitan',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 72,  'ar' => 'خيطان الجديدة',         'en' => 'New Khaitan',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 73,  'ar' => 'العباسية',              'en' => 'Abbasiya',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 74,  'ar' => 'الرابية',               'en' => 'Rabiya',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 75,  'ar' => 'ضاحية عبدالله المبارك', 'en' => 'Abdullah Al-Mubarak',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 76,  'ar' => 'الأندلس',               'en' => 'Andalus',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 77,  'ar' => 'العمرية',               'en' => 'Omariya',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 78,  'ar' => 'الفردوس',               'en' => 'Firdous',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 79,  'ar' => 'الرحاب',                'en' => 'Rehab',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 80,  'ar' => 'أشبيلية',               'en' => 'Ishbiliya',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 81,  'ar' => 'الرقعي',                'en' => 'Rigai',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 82,  'ar' => 'غرب عبدالله المبارك',   'en' => 'West Abdullah Al-Mubarak',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 83,  'ar' => 'الشدادية',              'en' => 'Shadadiya',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 84,  'ar' => 'ضاحية صباح الناصر',     'en' => 'Sabah Al-Naser',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 85,  'ar' => 'الصبيح',                'en' => 'Subaiha',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 86,  'ar' => 'الحساوي',               'en' => 'Hassawi',
             'description_ar' => '',
             'description_en' => ''],

            // ═══════════════════════════════════════════
            // HAWALLI GOVERNORATE — محافظة حولي
            // ═══════════════════════════════════════════

            ['id' => 2,   'ar' => 'حولي',                  'en' => 'Hawalli',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 13,  'ar' => 'السالمية',              'en' => 'Salmiya',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 14,  'ar' => 'الرميثية',              'en' => 'Rumaithiya',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 15,  'ar' => 'بيان',                  'en' => 'Bayan',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 16,  'ar' => 'مشرف',                  'en' => 'Mishref',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 17,  'ar' => 'الجابرية',              'en' => 'Jabriya',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 59,  'ar' => 'سلوى',                  'en' => 'Salwa',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 60,  'ar' => 'الشعب',                 'en' => 'Shaab',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 61,  'ar' => 'جنوب السرة',            'en' => 'South Surra',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 62,  'ar' => 'البدع',                 'en' => 'Bidaa',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 63,  'ar' => 'حطين',                  'en' => 'Hittin',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 64,  'ar' => 'السلام',                'en' => 'Salam',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 65,  'ar' => 'النقرة',                'en' => 'Nuqra',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 66,  'ar' => 'الزهراء',               'en' => 'Zahraa',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 67,  'ar' => 'ميدان حولي',            'en' => 'Hawalli Maidan',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 68,  'ar' => 'الصديق',                'en' => 'Siddiq',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 69,  'ar' => 'الشهداء',               'en' => 'Shuhada',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 70,  'ar' => 'ضاحية مبارك العبدالله الجابر', 'en' => 'Mubarak Al-Abdullah Al-Jaber',
             'description_ar' => '',
             'description_en' => ''],

            // ═══════════════════════════════════════════
            // JAHRA GOVERNORATE — محافظة الجهراء
            // ═══════════════════════════════════════════

            ['id' => 5,   'ar' => 'الجهراء',               'en' => 'Jahra',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 29,  'ar' => 'مدينة الجهراء',         'en' => 'Jahra City',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 87,  'ar' => 'الصليبية',              'en' => 'Sulaibiya',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 88,  'ar' => 'تيماء',                 'en' => 'Tayma',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 89,  'ar' => 'الجهراء القديمة',        'en' => 'Old Jahra',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 90,  'ar' => 'كبد',                   'en' => 'Kabd',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 91,  'ar' => 'أمغرة',                 'en' => 'Amghara',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 92,  'ar' => 'النسيم',                'en' => 'Naseem',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 93,  'ar' => 'الجهراء الجديدة',        'en' => 'New Jahra',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 94,  'ar' => 'الروضتين',              'en' => 'Raudhatain',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 95,  'ar' => 'النعيم',                'en' => 'Naeem',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 96,  'ar' => 'العيون',                'en' => 'Uyoun',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 97,  'ar' => 'مدينة سعد العبدالله',   'en' => 'Saad Al-Abdullah City',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 98,  'ar' => 'الصبية',                'en' => 'Subbiya',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 99,  'ar' => 'القصر',                 'en' => 'Qasr',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 100, 'ar' => 'القصرية',               'en' => 'Qasriya',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 101, 'ar' => 'السالمي',               'en' => 'Salmi',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 102, 'ar' => 'الواحة',                'en' => 'Waha',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 103, 'ar' => 'العبدلي',               'en' => 'Abdali',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 104, 'ar' => 'المطلاع',               'en' => 'Mutlaa',
             'description_ar' => '',
             'description_en' => ''],

            // ═══════════════════════════════════════════
            // MUBARAK AL-KABEER — محافظة مبارك الكبير
            // ═══════════════════════════════════════════

            ['id' => 6,   'ar' => 'مبارك الكبير',          'en' => 'Mubarak Al-Kabeer',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 12,  'ar' => 'صباح السالم',           'en' => 'Sabah Al-Salem',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 32,  'ar' => 'العدان',                'en' => 'Adan',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 105, 'ar' => 'أبو فطيرة',             'en' => 'Abu Ftaira',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 106, 'ar' => 'القصور',                'en' => 'Qusour',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 107, 'ar' => 'صبحان',                 'en' => 'Sabhan',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 108, 'ar' => 'القرين',                'en' => 'Qurain',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 109, 'ar' => 'الفنيطيس',              'en' => 'Funaitees',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 111, 'ar' => 'المسيلة',               'en' => 'Masayel',
             'description_ar' => '',
             'description_en' => ''],

            ['id' => 112, 'ar' => 'أبو الحصانية',          'en' => 'Abu Al-Hasaniya',
             'description_ar' => '',
             'description_en' => ''],

        ];

        $updated = 0;
        foreach ($locations as $item) {
            if (empty($item['description_ar']) && empty($item['description_en'])) {
                continue; // skip empty entries
            }
            $loc = Location::find($item['id']);
            if (!$loc) continue;

            $loc->setTranslation('description', 'ar', $item['description_ar']);
            $loc->setTranslation('description', 'en', $item['description_en']);
            $loc->save();
            $updated++;
        }

        $this->command->info("Updated descriptions for {$updated} locations.");
    }
}
