<?php

namespace Database\Factories;

use App\Enums\PostStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    private function arSlug(string $text): string
    {
        $text = preg_replace('/[^\p{Arabic}\p{N}\s-]/u', '', $text);
        return trim(preg_replace('/[\s-]+/u', '-', $text), '-');
    }

    private static array $posts = [
        [
            'en' => ['title' => 'How to Choose the Right AC for Your Kuwait Home',          'excerpt' => 'A complete guide to selecting the best air conditioner for Kuwait\'s extreme heat.'],
            'ar' => ['title' => 'كيف تختار الكهرباء المناسب لمنزلك في الكويت',               'excerpt' => 'دليل شامل لاختيار أفضل جهاز كهرباء لمواجهة حرارة الكويت الشديدة.'],
        ],
        [
            'en' => ['title' => '5 Signs Your AC Needs Immediate Repair',                   'excerpt' => 'Recognise warning signs early to avoid costly breakdowns in the summer heat.'],
            'ar' => ['title' => '5 علامات تدل على أن كهرباءك يحتاج إصلاحاً فورياً',          'excerpt' => 'تعرّف على علامات التحذير مبكراً لتجنب الأعطال المكلفة في حرارة الصيف.'],
        ],
        [
            'en' => ['title' => 'Why Regular AC Cleaning Is Essential in Kuwait',            'excerpt' => 'Dust and humidity make electrical maintenance more critical in Kuwait than almost anywhere else.'],
            'ar' => ['title' => 'لماذا تنظيف الكهرباء بانتظام ضروري في الكويت',              'excerpt' => 'الغبار والرطوبة يجعلان تنظيف الكهرباء أكثر أهمية في الكويت مقارنةً بأي مكان آخر.'],
        ],
        [
            'en' => ['title' => 'The Complete Guide to Electrical Refill in Kuwait',             'excerpt' => 'Everything you need to know about refrigerant types, costs, and when to refill.'],
            'ar' => ['title' => 'الدليل الشامل لتصليح شورت الكهرباء في الكويت',                'excerpt' => 'كل ما تحتاج معرفته عن أنواع غاز التبريد والتكاليف ومتى تحتاج إلى الشحن.'],
        ],
        [
            'en' => ['title' => 'Central AC vs Split AC: Which Is Better for Kuwait?',      'excerpt' => 'A side-by-side comparison to help you decide between central and split AC systems.'],
            'ar' => ['title' => 'الكهرباء المركزي مقابل السبليت: أيهما أفضل في الكويت؟',    'excerpt' => 'مقارنة جانبية تساعدك على الاختيار بين أنظمة الكهرباء المركزي والسبليت.'],
        ],
        [
            'en' => ['title' => 'How to Reduce Electricity Bills with Proper Electrical Maintenance','excerpt' => 'Smart maintenance tips that keep your AC efficient and your electricity bills low.'],
            'ar' => ['title' => 'كيف تخفض فاتورة الكهرباء بصيانة الكهرباء الصحيحة',        'excerpt' => 'نصائح صيانة ذكية تحافظ على كفاءة كهرباءك وتخفض فاتورة الكهرباء.'],
        ],
        [
            'en' => ['title' => 'Emergency Electrical Repair: What to Do When Your AC Breaks Down',  'excerpt' => 'Step-by-step guide on handling an AC emergency before the technician arrives.'],
            'ar' => ['title' => 'إصلاح طارئ للكهرباء: ماذا تفعل حين يتعطل كهرباءك',          'excerpt' => 'دليل خطوة بخطوة للتعامل مع طوارئ الكهرباء قبل وصول الفني.'],
        ],
        [
            'en' => ['title' => 'Top 10 AC Brands Available in Kuwait and Their Service Costs','excerpt' => 'A comprehensive review of popular AC brands sold in Kuwait with maintenance pricing.'],
            'ar' => ['title' => 'أفضل 10 ماركات كهرباءات متوفرة في الكويت وتكاليف صيانتها', 'excerpt' => 'مراجعة شاملة لأشهر ماركات الكهرباءات في الكويت مع أسعار الصيانة.'],
        ],
    ];

    private static int $index = 0;

    public function definition(): array
    {
        $post  = static::$posts[static::$index % count(static::$posts)];
        static::$index++;

        $enSlug = Str::slug($post['en']['title']);
        $arSlug = $this->arSlug($post['ar']['title']);
        $isPublished = $this->faker->boolean(70);

        return [
            'title'            => ['en' => $post['en']['title'], 'ar' => $post['ar']['title']],
            'slug'             => ['en' => $enSlug, 'ar' => $arSlug],
            'h1'               => ['en' => $post['en']['title'], 'ar' => $post['ar']['title']],
            'excerpt'          => ['en' => $post['en']['excerpt'], 'ar' => $post['ar']['excerpt']],
            'content'          => [
                'en' => '<p>' . implode('</p><p>', $this->faker->paragraphs(6)) . '</p>',
                'ar' => '<p>' . implode('</p><p>', $this->faker->paragraphs(6)) . '</p>',
            ],
            'meta_title'       => [
                'en' => $post['en']['title'] . ' | ElectricQ8 Blog',
                'ar' => $post['ar']['title'] . ' | مدونة إلكتريك كويت',
            ],
            'meta_description' => [
                'en' => $post['en']['excerpt'],
                'ar' => $post['ar']['excerpt'],
            ],
            'canonical_url'    => ['en' => '/en/blog/' . $enSlug, 'ar' => '/ar/مدونة/' . $arSlug],
            'featured_image'   => null,
            'status'           => $isPublished ? PostStatus::Published : PostStatus::Draft,
            'published_at'     => $isPublished ? $this->faker->dateTimeBetween('-6 months', 'now') : null,
            'sort_order'       => static::$index,
        ];
    }

    public function published(): static
    {
        return $this->state(fn () => [
            'status'       => PostStatus::Published,
            'published_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
        ]);
    }
}
