<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\ServiceLocationPage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        // Clear dependent data first
        ServiceLocationPage::query()->delete();
        Location::query()->delete();

        $governorates = [
            'capital' => [
                'ar' => 'محافظة العاصمة',
                'en' => 'Capital Governorate',
                'areas' => [
                    ['ar' => 'مدينة الكويت',              'en' => 'Kuwait City'],
                    ['ar' => 'دسمان',                      'en' => 'Dasman'],
                    ['ar' => 'كيفان',                      'en' => 'Kaifan'],
                    ['ar' => 'الوطية',                     'en' => 'Al-Watiya'],
                    ['ar' => 'بنيد القار',                 'en' => 'Bnaid Al-Gar'],
                    ['ar' => 'الدسمة',                     'en' => 'Dasmah'],
                    ['ar' => 'الدعية',                     'en' => 'Al-Daiya'],
                    ['ar' => 'ضاحية عبد الله السالم',      'en' => 'Abdullah Al-Salem'],
                    ['ar' => 'الشامية',                    'en' => 'Al-Shamiya'],
                    ['ar' => 'الفيحاء',                    'en' => 'Al-Faiha'],
                    ['ar' => 'النزهة',                     'en' => 'Al-Nuzha'],
                    ['ar' => 'المنصورية',                  'en' => 'Al-Mansouriya'],
                    ['ar' => 'الروضة',                     'en' => 'Al-Rawda'],
                    ['ar' => 'القادسية',                   'en' => 'Al-Qadsiya'],
                    ['ar' => 'العديلية',                   'en' => 'Al-Adailiya'],
                    ['ar' => 'الخالدية',                   'en' => 'Al-Khalidiya'],
                    ['ar' => 'القيروان',                   'en' => 'Al-Qairawan'],
                    ['ar' => 'النهضة',                     'en' => 'Al-Nahda'],
                    ['ar' => 'مدينة جابر الأحمد',          'en' => 'Jaber Al-Ahmad City'],
                    ['ar' => 'الصليبيخات',                 'en' => 'Al-Sulaibikhat'],
                    ['ar' => 'الدوحة',                     'en' => 'Al-Doha'],
                    ['ar' => 'الري',                       'en' => 'Al-Rai'],
                    ['ar' => 'غرناطة',                     'en' => 'Gharnata'],
                    ['ar' => 'السرة',                      'en' => 'Al-Surra'],
                    ['ar' => 'اليرموك',                    'en' => 'Al-Yarmouk'],
                    ['ar' => 'قرطبة',                      'en' => 'Qurtuba'],
                    ['ar' => 'شمال غرب الصليبيخات',        'en' => 'NW Sulaibikhat'],
                ],
            ],
            'jahra' => [
                'ar' => 'محافظة الجهراء',
                'en' => 'Jahra Governorate',
                'areas' => [
                    ['ar' => 'النعيم',                     'en' => 'Al-Naeem'],
                    ['ar' => 'القصر',                      'en' => 'Al-Qasr'],
                    ['ar' => 'الواحة',                     'en' => 'Al-Waha'],
                    ['ar' => 'تيماء',                      'en' => 'Taima'],
                    ['ar' => 'النسيم',                     'en' => 'Al-Nassem'],
                    ['ar' => 'العيون',                     'en' => 'Al-Oyoun'],
                    ['ar' => 'القيصرية',                   'en' => 'Al-Qaisariya'],
                    ['ar' => 'الكاظمة',                    'en' => 'Al-Kadhema'],
                    ['ar' => 'جهراء القديمة',              'en' => 'Old Jahra'],
                    ['ar' => 'جهراء الجديدة',              'en' => 'New Jahra'],
                    ['ar' => 'مدينة سعد العبد الله',       'en' => 'Saad Al-Abdullah City'],
                    ['ar' => 'المطلاع',                    'en' => 'Al-Mutlaa'],
                    ['ar' => 'الصليبية',                   'en' => 'Al-Sulaibiya'],
                ],
            ],
            'farwaniya' => [
                'ar' => 'محافظة الفروانية',
                'en' => 'Farwaniya Governorate',
                'areas' => [
                    ['ar' => 'أبرق خيطان',                 'en' => 'Abraq Khaitan'],
                    ['ar' => 'الأندلس',                    'en' => 'Al-Andalus'],
                    ['ar' => 'خيطان',                      'en' => 'Khaitan'],
                    ['ar' => 'خيطان الجديدة',              'en' => 'New Khaitan'],
                    ['ar' => 'إشبيلية',                    'en' => 'Ishbiliya'],
                    ['ar' => 'جليب الشيوخ',                'en' => 'Jleeb Al-Shuyoukh'],
                    ['ar' => 'العمرية',                    'en' => 'Al-Omariya'],
                    ['ar' => 'العارضية',                   'en' => 'Al-Ardiya'],
                    ['ar' => 'العباسية',                   'en' => 'Al-Abbasiya'],
                    ['ar' => 'الفردوس',                    'en' => 'Al-Firdous'],
                    ['ar' => 'الفروانية',                  'en' => 'Farwaniya'],
                    ['ar' => 'الحساوي',                    'en' => 'Al-Hassawi'],
                    ['ar' => 'الشدادية',                   'en' => 'Al-Shadadiya'],
                    ['ar' => 'الرابية',                    'en' => 'Al-Rabiya'],
                    ['ar' => 'الرحاب',                     'en' => 'Al-Rehab'],
                    ['ar' => 'الرقعي',                     'en' => 'Al-Ruqai'],
                    ['ar' => 'الضجيج',                     'en' => 'Al-Dajeej'],
                    ['ar' => 'ضاحية صباح الناصر',          'en' => 'Sabah Al-Nasser'],
                    ['ar' => 'ضاحية عبد الله المبارك',     'en' => 'Abdullah Al-Mubarak'],
                ],
            ],
            'hawalli' => [
                'ar' => 'محافظة حولي',
                'en' => 'Hawalli Governorate',
                'areas' => [
                    ['ar' => 'حولي',                       'en' => 'Hawalli'],
                    ['ar' => 'الشعب',                      'en' => 'Al-Shaab'],
                    ['ar' => 'السالمية',                   'en' => 'Salmiya'],
                    ['ar' => 'الرميثية',                   'en' => 'Rumaithiya'],
                    ['ar' => 'الجابرية',                   'en' => 'Jabriya'],
                    ['ar' => 'مشرف',                       'en' => 'Mishref'],
                    ['ar' => 'بيان',                       'en' => 'Bayan'],
                    ['ar' => 'البدع',                      'en' => 'Al-Bidaa'],
                    ['ar' => 'النقرة',                     'en' => 'Al-Naqra'],
                    ['ar' => 'ميدان حولي',                 'en' => 'Hawalli Square'],
                    ['ar' => 'ضاحية مبارك العبد الله الجابر', 'en' => 'Mubarak Al-Abdullah Al-Jaber'],
                    ['ar' => 'سلوى',                       'en' => 'Salwa'],
                    ['ar' => 'جنوب السرة',                 'en' => 'South Surra'],
                    ['ar' => 'الزهراء',                    'en' => 'Al-Zahra'],
                    ['ar' => 'الصديق',                     'en' => 'Al-Siddiq'],
                    ['ar' => 'حطين',                       'en' => 'Hitteen'],
                    ['ar' => 'السلام',                     'en' => 'Al-Salam'],
                    ['ar' => 'الشهداء',                    'en' => 'Al-Shuhada'],
                ],
            ],
            'ahmadi' => [
                'ar' => 'محافظة الأحمدي',
                'en' => 'Ahmadi Governorate',
                'areas' => [
                    ['ar' => 'الفنطاس',                    'en' => 'Fintas'],
                    ['ar' => 'العقيلة',                    'en' => 'Aqeela'],
                    ['ar' => 'المهبولة',                   'en' => 'Mahboula'],
                    ['ar' => 'الرقة',                      'en' => 'Al-Ruqqa'],
                    ['ar' => 'هدية',                       'en' => 'Hadiya'],
                    ['ar' => 'أبو حليفة',                  'en' => 'Abu Halifa'],
                    ['ar' => 'الصباحية',                   'en' => 'Al-Sabahiya'],
                    ['ar' => 'الفحيحيل',                   'en' => 'Fahaheel'],
                    ['ar' => 'المنقف',                     'en' => 'Mangaf'],
                    ['ar' => 'الأحمدي',                    'en' => 'Ahmadi'],
                    ['ar' => 'الوفرة',                     'en' => 'Al-Wafra'],
                    ['ar' => 'الزور',                      'en' => 'Al-Zour'],
                    ['ar' => 'الخيران',                    'en' => 'Al-Khairan'],
                    ['ar' => 'الوفرة الزراعية',            'en' => 'Al-Wafra Agricultural'],
                    ['ar' => 'ضاحية جابر العلي',           'en' => 'Jaber Al-Ali'],
                    ['ar' => 'ضاحية فهد الأحمد',           'en' => 'Fahad Al-Ahmad'],
                    ['ar' => 'مدينة صباح الأحمد',          'en' => 'Sabah Al-Ahmad City'],
                    ['ar' => 'ضاحية علي صباح السالم',      'en' => 'Ali Sabah Al-Salem'],
                    ['ar' => 'مدينة صباح الأحمد البحرية',  'en' => 'Sabah Al-Ahmad Marine City'],
                ],
            ],
            'mubarak_al_kabeer' => [
                'ar' => 'محافظة مبارك الكبير',
                'en' => 'Mubarak Al-Kabeer Governorate',
                'areas' => [
                    ['ar' => 'العدان',                     'en' => 'Al-Adan'],
                    ['ar' => 'القصور',                     'en' => 'Al-Qusour'],
                    ['ar' => 'القرين',                     'en' => 'Al-Qurain'],
                    ['ar' => 'ضاحية صباح السالم',          'en' => 'Sabah Al-Salem'],
                    ['ar' => 'المسيلة',                    'en' => 'Al-Masayel'],
                    ['ar' => 'المسايل',                    'en' => 'Al-Masayil'],
                    ['ar' => 'أبو فطيرة',                  'en' => 'Abu Fatira'],
                    ['ar' => 'أبو الحصانية',               'en' => 'Abu Al-Hasaniya'],
                    ['ar' => 'صبحان',                      'en' => 'Sabhan'],
                    ['ar' => 'الفنيطيس',                   'en' => 'Al-Funaitees'],
                    ['ar' => 'ضاحية مبارك الكبير',         'en' => 'Mubarak Al-Kabeer'],
                ],
            ],
        ];

        $sort = 1;
        foreach ($governorates as $govKey => $gov) {
            foreach ($gov['areas'] as $area) {
                $slugAr = $this->arSlug($area['ar']);
                $slugEn = Str::slug($area['en']);

                Location::create([
                    'name'        => ['ar' => $area['ar'], 'en' => $area['en']],
                    'slug'        => ['ar' => $slugAr,     'en' => $slugEn],
                    'description' => ['ar' => '', 'en' => ''],
                    'governorate' => $govKey,
                    'is_active'   => true,
                    'sort_order'  => $sort++,
                ]);
            }
        }

        $this->command->info('✓ Seeded ' . ($sort - 1) . ' locations across ' . count($governorates) . ' governorates.');
    }

    private function arSlug(string $text): string
    {
        // Keep Arabic letters, numbers, spaces, hyphens — replace spaces with hyphens
        $text = preg_replace('/[^\p{Arabic}\p{N}\s-]/u', '', $text);
        return trim(preg_replace('/[\s-]+/u', '-', $text), '-');
    }
}
