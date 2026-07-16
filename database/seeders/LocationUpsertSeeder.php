<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LocationUpsertSeeder extends Seeder
{
    public function run(): void
    {
        $governorates = [
            'capital' => [
                ['ar' => 'مدينة الكويت',            'en' => 'Kuwait City'],
                ['ar' => 'دسمان',                    'en' => 'Dasman'],
                ['ar' => 'شرق',                      'en' => 'Sharq'],
                ['ar' => 'القبلة',                   'en' => 'Qibla'],
                ['ar' => 'الصوابر',                  'en' => 'Sawaber'],
                ['ar' => 'المرقاب',                  'en' => 'Mirqab'],
                ['ar' => 'الصالحية',                 'en' => 'Salhiya'],
                ['ar' => 'الوطية',                   'en' => 'Watiya'],
                ['ar' => 'بنيد القار',               'en' => 'Bneid Al-Qar'],
                ['ar' => 'كيفان',                    'en' => 'Kaifan'],
                ['ar' => 'الدوحة',                   'en' => 'Doha'],
                ['ar' => 'الدسمة',                   'en' => 'Dasma'],
                ['ar' => 'الدعية',                   'en' => 'Daiya'],
                ['ar' => 'اليرموك',                  'en' => 'Yarmouk'],
                ['ar' => 'الصليبيخات',               'en' => 'Sulaibikhat'],
                ['ar' => 'الروضة',                   'en' => 'Rawda'],
                ['ar' => 'النزهة',                   'en' => 'Nuzha'],
                ['ar' => 'الفيحاء',                  'en' => 'Faiha'],
                ['ar' => 'الشامية',                  'en' => 'Shamiya'],
                ['ar' => 'الشويخ',                   'en' => 'Shuwaikh'],
                ['ar' => 'النهضة',                   'en' => 'Nahda'],
                ['ar' => 'عبدالله السالم',            'en' => 'Abdullah Al-Salem'],
                ['ar' => 'العديلية',                 'en' => 'Adailiya'],
                ['ar' => 'الخالدية',                 'en' => 'Khalidiya'],
                ['ar' => 'القادسية',                 'en' => 'Qadsiya'],
                ['ar' => 'الري',                     'en' => 'Rai'],
                ['ar' => 'القيروان',                 'en' => 'Qairawan'],
                ['ar' => 'السرة',                    'en' => 'Surra'],
                ['ar' => 'غرناطة',                   'en' => 'Granada'],
                ['ar' => 'قرطبة',                    'en' => 'Qurtuba'],
                ['ar' => 'شمال غرب الصليبيخات',      'en' => 'NW Sulaibikhat'],
                ['ar' => 'مدينة جابر الأحمد',        'en' => 'Jaber Al-Ahmad City'],
            ],
            'hawalli' => [
                ['ar' => 'حولي',                     'en' => 'Hawalli'],
                ['ar' => 'مشرف',                     'en' => 'Mishref'],
                ['ar' => 'سلوى',                     'en' => 'Salwa'],
                ['ar' => 'الشعب',                    'en' => 'Shaab'],
                ['ar' => 'بيان',                     'en' => 'Bayan'],
                ['ar' => 'جنوب السرة',               'en' => 'South Surra'],
                ['ar' => 'السالمية',                 'en' => 'Salmiya'],
                ['ar' => 'البدع',                    'en' => 'Bidaa'],
                ['ar' => 'حطين',                     'en' => 'Hittin'],
                ['ar' => 'السلام',                   'en' => 'Salam'],
                ['ar' => 'الجابرية',                 'en' => 'Jabriya'],
                ['ar' => 'الرميثية',                 'en' => 'Rumaithiya'],
                ['ar' => 'النقرة',                   'en' => 'Nuqra'],
                ['ar' => 'الزهراء',                  'en' => 'Zahraa'],
                ['ar' => 'ميدان حولي',               'en' => 'Hawalli Maidan'],
                ['ar' => 'الصديق',                   'en' => 'Siddiq'],
                ['ar' => 'الشهداء',                  'en' => 'Shuhada'],
                ['ar' => 'ضاحية مبارك العبدالله الجابر', 'en' => 'Mubarak Al-Abdullah Al-Jaber'],
            ],
            'farwaniya' => [
                ['ar' => 'أبرق خيطان',               'en' => 'Abraq Khaitan'],
                ['ar' => 'خيطان الجديدة',            'en' => 'New Khaitan'],
                ['ar' => 'العباسية',                 'en' => 'Abbasiya'],
                ['ar' => 'الرابية',                  'en' => 'Rabiya'],
                ['ar' => 'ضاحية عبدالله المبارك',    'en' => 'Abdullah Al-Mubarak'],
                ['ar' => 'الأندلس',                  'en' => 'Andalus'],
                ['ar' => 'العمرية',                  'en' => 'Omariya'],
                ['ar' => 'الفردوس',                  'en' => 'Firdous'],
                ['ar' => 'الرحاب',                   'en' => 'Rehab'],
                ['ar' => 'أشبيلية',                  'en' => 'Ishbiliya'],
                ['ar' => 'العارضية',                 'en' => 'Ardiya'],
                ['ar' => 'الفروانية',                'en' => 'Farwaniya'],
                ['ar' => 'الرقعي',                   'en' => 'Rigai'],
                ['ar' => 'غرب عبدالله المبارك',      'en' => 'West Abdullah Al-Mubarak'],
                ['ar' => 'خيطان',                    'en' => 'Khaitan'],
                ['ar' => 'الشدادية',                 'en' => 'Shadadiya'],
                ['ar' => 'ضاحية صباح الناصر',        'en' => 'Sabah Al-Naser'],
                ['ar' => 'الصبيح',                   'en' => 'Subaiha'],
                ['ar' => 'جليب الشيوخ',              'en' => 'Jleeb Al-Shuyoukh'],
                ['ar' => 'الحساوي',                  'en' => 'Hassawi'],
            ],
            'jahra' => [
                ['ar' => 'الصليبية',                 'en' => 'Sulaibiya'],
                ['ar' => 'تيماء',                    'en' => 'Tayma'],
                ['ar' => 'الجهراء القديمة',           'en' => 'Old Jahra'],
                ['ar' => 'كبد',                      'en' => 'Kabd'],
                ['ar' => 'أمغرة',                    'en' => 'Amghara'],
                ['ar' => 'النسيم',                   'en' => 'Naseem'],
                ['ar' => 'الجهراء الجديدة',           'en' => 'New Jahra'],
                ['ar' => 'الروضتين',                 'en' => 'Raudhatain'],
                ['ar' => 'النعيم',                   'en' => 'Naeem'],
                ['ar' => 'العيون',                   'en' => 'Uyoun'],
                ['ar' => 'مدينة سعد العبدالله',      'en' => 'Saad Al-Abdullah City'],
                ['ar' => 'الصبية',                   'en' => 'Subbiya'],
                ['ar' => 'القصر',                    'en' => 'Qasr'],
                ['ar' => 'القصرية',                  'en' => 'Qasriya'],
                ['ar' => 'السالمي',                  'en' => 'Salmi'],
                ['ar' => 'الواحة',                   'en' => 'Waha'],
                ['ar' => 'العبدلي',                  'en' => 'Abdali'],
                ['ar' => 'المطلاع',                  'en' => 'Mutlaa'],
                ['ar' => 'مدينة الجهراء',            'en' => 'Jahra City'],
            ],
            'mubarak_al_kabeer' => [
                ['ar' => 'العدان',                   'en' => 'Adan'],
                ['ar' => 'أبو فطيرة',                'en' => 'Abu Ftaira'],
                ['ar' => 'القصور',                   'en' => 'Qusour'],
                ['ar' => 'صبحان',                    'en' => 'Sabhan'],
                ['ar' => 'القرين',                   'en' => 'Qurain'],
                ['ar' => 'الفنيطيس',                 'en' => 'Funaitees'],
                ['ar' => 'ضاحية صباح السالم',        'en' => 'Sabah Al-Salem'],
                ['ar' => 'المسيلة',                  'en' => 'Masayel'],
                ['ar' => 'مبارك الكبير',             'en' => 'Mubarak Al-Kabeer'],
                ['ar' => 'أبو الحصانية',             'en' => 'Abu Al-Hasaniya'],
            ],
            'ahmadi' => [
                ['ar' => 'الفنطاس',                  'en' => 'Fintas'],
                ['ar' => 'الرقة',                    'en' => 'Ruqa'],
                ['ar' => 'المهبولة',                 'en' => 'Mahboula'],
                ['ar' => 'ضاحية جابر العلي',         'en' => 'Jaber Al-Ali'],
                ['ar' => 'ميناء عبدالله',            'en' => 'Abdullah Port'],
                ['ar' => 'العقيلة',                  'en' => 'Aqaila'],
                ['ar' => 'هدية',                     'en' => 'Hadiya'],
                ['ar' => 'الأحمدي',                  'en' => 'Ahmadi'],
                ['ar' => 'الوفرة الزراعية',          'en' => 'Wafra Agricultural'],
                ['ar' => 'ضاحية فهد الأحمد',         'en' => 'Fahad Al-Ahmad'],
                ['ar' => 'الفحيحيل',                 'en' => 'Fahaheel'],
                ['ar' => 'المنقف',                   'en' => 'Mangaf'],
                ['ar' => 'الخيران',                  'en' => 'Khairan'],
                ['ar' => 'أبو حليفة',                'en' => 'Abu Halifa'],
                ['ar' => 'الوفرة',                   'en' => 'Wafra'],
                ['ar' => 'الشعيبة',                  'en' => 'Shuaiba'],
                ['ar' => 'ميناء الأحمدي',            'en' => 'Ahmadi Port'],
                ['ar' => 'الظهر',                    'en' => 'Dhaher'],
                ['ar' => 'مدينة صباح الأحمد',        'en' => 'Sabah Al-Ahmad City'],
                ['ar' => 'ضاحية علي صباح السالم',   'en' => 'Ali Sabah Al-Salem'],
                ['ar' => 'النويصيب',                 'en' => 'Nuwaiseeb'],
                ['ar' => 'الزور',                    'en' => 'Zour'],
                ['ar' => 'الجليعة',                  'en' => 'Julaiaa'],
            ],
        ];

        $sort  = Location::max('sort_order') ?? 0;
        $added = 0;

        foreach ($governorates as $govKey => $areas) {
            // Build existing AR slugs for this governorate
            $existingSlugs = Location::where('governorate', $govKey)
                ->get()
                ->map(fn ($l) => $l->getTranslation('slug', 'ar'))
                ->filter()
                ->values()
                ->toArray();

            foreach ($areas as $area) {
                $slugAr = $this->arSlug($area['ar']);
                $slugEn = Str::slug($area['en']);

                // Skip if already present (match by AR slug)
                if (in_array($slugAr, $existingSlugs)) {
                    continue;
                }

                Location::create([
                    'name'        => ['ar' => $area['ar'], 'en' => $area['en']],
                    'slug'        => ['ar' => $slugAr,     'en' => $slugEn],
                    'description' => ['ar' => '', 'en' => ''],
                    'governorate' => $govKey,
                    'is_active'   => true,
                    'sort_order'  => ++$sort,
                ]);

                $added++;
            }
        }

        $this->command->info("Added {$added} new locations (skipped existing).");
    }

    private function arSlug(string $text): string
    {
        $text = preg_replace('/[^\p{Arabic}\p{N}\s-]/u', '', $text);
        return trim(preg_replace('/[\s-]+/u', '-', $text), '-');
    }
}
