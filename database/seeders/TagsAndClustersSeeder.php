<?php

namespace Database\Seeders;

use App\Models\Cluster;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagsAndClustersSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            // نوع العقار
            ['key' => 'home',          'ar' => 'كهرباء المنازل',           'en' => 'Home Electrical'],
            ['key' => 'apartment',     'ar' => 'كهرباء الشقق',              'en' => 'Apartment Electrical'],
            ['key' => 'villa',         'ar' => 'كهرباء الفلل',              'en' => 'Villa Electrical'],
            ['key' => 'company',       'ar' => 'كهرباء الشركات والمكاتب',   'en' => 'Company & Office Electrical'],
            ['key' => 'complex',       'ar' => 'كهرباء المجمعات السكنية',   'en' => 'Residential Complex Electrical'],
            ['key' => 'new_building',  'ar' => 'كهرباء المباني الجديدة',    'en' => 'New Building Electrical'],
            ['key' => 'commercial',    'ar' => 'كهرباء المحلات والمصانع',   'en' => 'Shops & Factories Electrical'],

            // المشكلات
            ['key' => 'sudden_fault',  'ar' => 'أعطال الكهرباء المفاجئة',   'en' => 'Sudden Electrical Faults'],
            ['key' => 'breaker_trip',  'ar' => 'مشاكل فصل القاطع',          'en' => 'Circuit Breaker Tripping'],
            ['key' => 'weak_current',  'ar' => 'ضعف التيار الكهربائي',      'en' => 'Weak Electrical Current'],
            ['key' => 'overload',      'ar' => 'ارتفاع الأحمال الكهربائية', 'en' => 'High Electrical Load'],
            ['key' => 'short_circuit', 'ar' => 'الماس الكهربائي',           'en' => 'Short Circuit'],
            ['key' => 'burnt_wiring',  'ar' => 'احتراق الأسلاك',            'en' => 'Burnt Wiring'],
            ['key' => 'hazards',       'ar' => 'مخاطر الكهرباء المنزلية',   'en' => 'Home Electrical Hazards'],

            // الهدف / الخدمة
            ['key' => 'safety',        'ar' => 'السلامة الكهربائية',        'en' => 'Electrical Safety'],
            ['key' => 'maintenance',   'ar' => 'الصيانة الوقائية',          'en' => 'Preventive Maintenance'],
            ['key' => 'inspection',    'ar' => 'فحص وتشخيص الأعطال',        'en' => 'Fault Inspection & Diagnosis'],
            ['key' => 'installation',  'ar' => 'تأسيس وتمديدات جديدة',      'en' => 'New Installation & Wiring'],
            ['key' => 'panels',        'ar' => 'اللوحات الكهربائية',        'en' => 'Electrical Panels'],
            ['key' => 'breakers',      'ar' => 'القواطع الكهربائية',        'en' => 'Circuit Breakers'],
            ['key' => 'emergency',     'ar' => 'خدمة طوارئ 24 ساعة',        'en' => '24-Hour Emergency Service'],
            ['key' => 'pricing',       'ar' => 'أسعار وتكاليف الخدمة',      'en' => 'Pricing & Costs'],

            // مواقع تركيب محددة
            ['key' => 'kitchen',       'ar' => 'كهرباء المطابخ',            'en' => 'Kitchen Electrical'],
            ['key' => 'bathroom',      'ar' => 'كهرباء الحمامات',           'en' => 'Bathroom Electrical'],
            ['key' => 'outdoor',       'ar' => 'كهرباء الأماكن الخارجية',   'en' => 'Outdoor Electrical'],
            ['key' => 'three_phase',   'ar' => 'تمديد ثلاث فاز',            'en' => 'Three Phase Wiring'],
            ['key' => 'smart',         'ar' => 'أنظمة الكهرباء الذكية',     'en' => 'Smart Electrical Systems'],
            ['key' => 'lighting',      'ar' => 'تركيب الإضاءة والإنارة',    'en' => 'Lighting Installation'],
        ];

        $tagIds = [];

        foreach ($tags as $tag) {
            $model = Tag::updateOrCreate(
                ['slug->en' => Str::slug($tag['en'])],
                [
                    'name' => ['ar' => $tag['ar'], 'en' => $tag['en']],
                    'slug' => ['ar' => Str::slug($tag['ar'], '-', 'ar'), 'en' => Str::slug($tag['en'])],
                ]
            );
            $tagIds[$tag['key']] = $model->id;
        }

        // tag key => Arabic keyword(s) to match against a cluster's Arabic title.
        $rules = [
            'home'          => ['منزل', 'منازل', 'منزلي', 'بيت'],
            'apartment'     => ['شقة', 'شقق'],
            'villa'         => ['فلل', 'فيلا'],
            'company'       => ['شركة', 'شركات', 'مكتب', 'مكاتب'],
            'complex'       => ['مجمع', 'مجمعات'],
            'new_building'  => ['مبنى جديد', 'منزل جديد', 'شقة جديدة'],
            'commercial'    => ['محلات', 'مستودع', 'مستودعات', 'مصنع', 'مصانع'],

            'sudden_fault'  => ['عطل', 'أعطال', 'انقطاع'],
            'breaker_trip'  => ['يفصل', 'فصل الكهرباء', 'القاطع'],
            'weak_current'  => ['ضعف الكهرباء', 'ضعف التيار'],
            'overload'      => ['أحمال', 'الحمل الكهربائي'],
            'short_circuit' => ['ماس', 'شورت', 'شرارة'],
            'burnt_wiring'  => ['احتراق', 'رائحة احتراق'],
            'hazards'       => ['خطر', 'مخاطر', 'صدمة'],

            'safety'        => ['سلامة', 'أمان', 'RCCB'],
            'maintenance'   => ['صيانة'],
            'inspection'    => ['فحص', 'تشخيص', 'كشف'],
            'installation'  => ['تأسيس', 'تمديد', 'تمديدات'],
            'panels'        => ['لوحة', 'لوحات'],
            'breakers'      => ['قاطع', 'قواطع', 'RCCB'],
            'emergency'     => ['طوارئ', '24 ساعة'],
            'pricing'       => ['سعر', 'أسعار', 'تكلفة', 'رخيص'],

            'kitchen'       => ['مطبخ', 'المطبخ'],
            'bathroom'      => ['حمام', 'الحمامات'],
            'outdoor'       => ['ملحق خارجي', 'خارجي'],
            'three_phase'   => ['ثلاث فاز'],
            'smart'         => ['ذكي', 'ذكية', 'سمارت'],
            'lighting'      => ['إضاءة', 'إنارة', 'سبوت لايت', 'ثريات', 'LED'],
        ];

        Cluster::query()
            ->select(['id', 'title'])
            ->chunkById(100, function ($clusters) use ($rules, $tagIds) {
                foreach ($clusters as $cluster) {
                    $title = $cluster->getTranslation('title', 'ar') ?? '';
                    $relatedTagIds = [];

                    foreach ($rules as $tagKey => $keywords) {
                        if (! isset($tagIds[$tagKey])) {
                            continue;
                        }
                        foreach ($keywords as $keyword) {
                            if (Str::contains($title, $keyword)) {
                                $relatedTagIds[] = $tagIds[$tagKey];
                                break;
                            }
                        }
                    }

                    // syncWithoutDetaching so this seeder never removes tags
                    // that were linked manually from the admin panel.
                    $cluster->tags()->syncWithoutDetaching(array_unique($relatedTagIds));
                }
            });
    }
}
