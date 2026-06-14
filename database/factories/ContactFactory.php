<?php

namespace Database\Factories;

use App\Enums\ContactStatus;
use App\Models\Location;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    private static array $arNames = [
        'أحمد الراشدي', 'محمد العازمي', 'خالد الهاجري', 'فيصل المطيري',
        'عبدالله الكندري', 'سارة الشمري', 'نورة العنزي', 'فاطمة الصباح',
        'مريم القطان', 'دلال الحربي', 'يوسف الرشيد', 'طارق العتيبي',
    ];

    private static array $enNames = [
        'Ahmed Al-Rashidi', 'Mohammed Al-Azmi', 'Khalid Al-Hajri', 'Faisal Al-Mutairi',
        'Abdullah Al-Kandari', 'Sara Al-Shammari', 'Nora Al-Enezi', 'Fatima Al-Sabah',
        'Maryam Al-Qattan', 'Dalal Al-Harbi', 'Yousef Al-Rasheed', 'Tariq Al-Otaibi',
    ];

    private static array $arMessages = [
        'أحتاج إلى إصلاح كهرباءي في أقرب وقت ممكن، يوجد تسريب ماء.',
        'كهرباءي لا يبرد بشكل جيد، أرجو إرسال فني لفحصه.',
        'أريد تنظيف جميع كهرباءات المنزل، كم التكلفة؟',
        'أحتاج إلى تصليح شورت الكهرباء، متى يمكن المجيء؟',
        'صوت غريب يصدر من الكهرباء، أرجو المساعدة.',
        'أريد تركيب كهرباء جديد في غرفة النوم.',
        'الكهرباء المركزي لا يعمل منذ البارحة، طارئ.',
        'أحتاج صيانة دورية لجميع كهرباءات المكتب.',
    ];

    private static array $enMessages = [
        'My AC is leaking water and needs urgent repair.',
        'The AC is not electrical properly, please send a technician.',
        'I need all home ACs cleaned. What is the cost?',
        'Need short circuit repair for my AC, when can you come?',
        'Strange noise coming from the AC unit, please help.',
        'I want to install a new AC in the bedroom.',
        'Central AC stopped working since yesterday, urgent.',
        'Need routine maintenance for all office ACs.',
    ];

    public function definition(): array
    {
        $isArabic = $this->faker->boolean(60);
        $locale   = $isArabic ? 'ar' : 'en';

        $name = $isArabic
            ? $this->faker->randomElement(static::$arNames)
            : $this->faker->randomElement(static::$enNames);

        $message = $isArabic
            ? $this->faker->randomElement(static::$arMessages)
            : $this->faker->randomElement(static::$enMessages);

        return [
            'name'        => $name,
            'phone'       => '+965 ' . $this->faker->numerify('####-####'),
            'email'       => $this->faker->optional(0.6)->safeEmail(),
            'service_id'  => Service::inRandomOrder()->value('id'),
            'location_id' => Location::inRandomOrder()->value('id'),
            'message'     => $message,
            'status'      => $this->faker->randomElement([
                ContactStatus::New, ContactStatus::New, ContactStatus::Read, ContactStatus::Replied,
            ]),
            'locale'      => $locale,
            'ip_address'  => $this->faker->ipv4(),
        ];
    }
}
