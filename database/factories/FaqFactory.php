<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FaqFactory extends Factory
{
    private static array $faqs = [
        // repair
        ['cat' => 'repair',
         'en'  => ['q' => 'How long does an electrical repair usually take?',                        'a' => 'Most repairs take between 30 minutes and 2 hours depending on the fault. Complex compressor or PCB issues may take longer.'],
         'ar'  => ['q' => 'كم يستغرق إصلاح الكهرباء عادةً؟',                                  'a' => 'معظم الإصلاحات تستغرق بين 30 دقيقة وساعتين حسب نوع العطل. مشاكل الكمبروسر أو اللوحة الإلكترونية قد تأخذ وقتاً أطول.'],
        ],
        ['cat' => 'repair',
         'en'  => ['q' => 'My AC is electrical but leaking water inside. What is the cause?',   'a' => 'Water leaks are usually caused by a clogged drain pipe, dirty filter, or low refrigerant gas. A technician can diagnose the exact cause quickly.'],
         'ar'  => ['q' => 'كهرباءي يبرد لكنه يسرّب ماء بالداخل. ما السبب؟',                  'a' => 'تسريبات الماء غالباً سببها انسداد أنبوب الصرف أو فلتر متسخ أو نقص غاز التبريد. يستطيع الفني تشخيص السبب بسرعة.'],
        ],
        ['cat' => 'repair',
         'en'  => ['q' => 'How much does electrical repair cost in Kuwait?',                          'a' => 'Minor repairs start from KD 10–20. Major repairs like compressor replacement can cost KD 80–200 depending on brand and capacity.'],
         'ar'  => ['q' => 'كم تكلفة إصلاح الكهرباء في الكويت؟',                               'a' => 'الإصلاحات البسيطة تبدأ من 10–20 دينار. الإصلاحات الكبرى كاستبدال الكمبروسر قد تكلف 80–200 دينار حسب الماركة والسعة.'],
        ],
        // cleaning
        ['cat' => 'cleaning',
         'en'  => ['q' => 'How often should I clean my AC in Kuwait?',                        'a' => 'Due to Kuwait\'s dusty climate, we recommend cleaning your AC filters every month and a full deep-clean every 3–4 months.'],
         'ar'  => ['q' => 'كم مرة يجب تنظيف الكهرباء في الكويت؟',                             'a' => 'بسبب المناخ الغباري في الكويت، ننصح بتنظيف فلاتر الكهرباء شهرياً وإجراء تنظيف عميق كامل كل 3–4 أشهر.'],
        ],
        ['cat' => 'cleaning',
         'en'  => ['q' => 'What is included in a professional AC deep-clean?',                'a' => 'A deep-clean includes filter washing, coil cleaning, drain pipe flushing, disinfection, and performance testing after service.'],
         'ar'  => ['q' => 'ماذا يشمل التنظيف العميق الاحترافي للكهرباء؟',                     'a' => 'يشمل التنظيف العميق: غسل الفلاتر، تنظيف الكويل، تطهير أنبوب الصرف، التعقيم، واختبار الأداء بعد الخدمة.'],
        ],
        // installation
        ['cat' => 'installation',
         'en'  => ['q' => 'How long does a split electrical installation take?',                      'a' => 'A standard split electrical installation takes 2–3 hours. Multi-unit or central electrical installations may take a full day.'],
         'ar'  => ['q' => 'كم يستغرق تركيب كهرباء السبليت؟',                                  'a' => 'تركيب كهرباء السبليت المعياري يستغرق 2–3 ساعات. تركيب عدة وحدات أو الكهرباء المركزي قد يستغرق يوماً كاملاً.'],
        ],
        ['cat' => 'installation',
         'en'  => ['q' => 'What BTU size do I need for my room?',                             'a' => 'As a rule of thumb: 9,000 BTU for rooms up to 15 m², 12,000 BTU up to 20 m², 18,000 BTU up to 30 m², and 24,000 BTU for larger rooms.'],
         'ar'  => ['q' => 'ما حجم البي تي يو المناسب لغرفتي؟',                               'a' => 'كقاعدة عامة: 9,000 BTU للغرف حتى 15 م²، 12,000 BTU حتى 20 م²، 18,000 BTU حتى 30 م²، و24,000 BTU للغرف الأكبر.'],
        ],
        // spare_parts
        ['cat' => 'spare_parts',
         'en'  => ['q' => 'Do you use original spare parts?',                                 'a' => 'Yes, we use only genuine OEM spare parts. We can also source compatible high-quality alternatives if the original is unavailable.'],
         'ar'  => ['q' => 'هل تستخدمون قطع غيار أصلية؟',                                    'a' => 'نعم، نستخدم فقط قطع الغيار الأصلية OEM. يمكننا أيضاً توفير بدائل عالية الجودة متوافقة إذا لم يكن الأصلي متاحاً.'],
        ],
        // general
        ['cat' => 'general',
         'en'  => ['q' => 'Do you offer a warranty on repairs?',                              'a' => 'Yes, all our repair and installation work comes with a 3-month labour warranty. Replaced parts carry the manufacturer\'s warranty.'],
         'ar'  => ['q' => 'هل تقدمون ضماناً على الإصلاحات؟',                                'a' => 'نعم، جميع أعمال الإصلاح والتركيب تأتي مع ضمان عمالة لمدة 3 أشهر. القطع المستبدلة تحمل ضمان الشركة المصنّعة.'],
        ],
        ['cat' => 'general',
         'en'  => ['q' => 'Do you service all AC brands?',                                    'a' => 'Yes, our technicians are trained to service all major brands including Samsung, LG, Daikin, Carrier, Toshiba, Midea, and Panasonic.'],
         'ar'  => ['q' => 'هل تخدمون جميع ماركات الكهرباءات؟',                                'a' => 'نعم، فنيونا مدرّبون على خدمة جميع الماركات الكبرى بما فيها سامسونغ، LG، داينكن، كاريير، توشيبا، ميديا، وباناسونيك.'],
        ],
        ['cat' => 'general',
         'en'  => ['q' => 'Is there a call-out fee for visiting my home?',                    'a' => 'We charge a small visit fee that is waived if you proceed with the repair. Our team will quote the repair cost before starting any work.'],
         'ar'  => ['q' => 'هل هناك رسوم زيارة للمنزل؟',                                     'a' => 'نفرض رسوم زيارة بسيطة تُلغى إذا أكملت الإصلاح معنا. سيقدّم فريقنا عرض سعر قبل البدء بأي عمل.'],
        ],
    ];

    private static int $index = 0;

    public function definition(): array
    {
        $faq = static::$faqs[static::$index % count(static::$faqs)];
        static::$index++;

        return [
            'question'   => ['en' => $faq['en']['q'], 'ar' => $faq['ar']['q']],
            'answer'     => ['en' => $faq['en']['a'], 'ar' => $faq['ar']['a']],
            'category'   => $faq['cat'],
            'status'     => 'active',
            'sort_order' => static::$index,
        ];
    }
}
