<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FaqFactory extends Factory
{
    private static array $faqs = [
        // repair
        ['cat' => 'repair',
         'en'  => ['q' => 'How long does an electrical repair usually take?',                        'a' => 'Most repairs take between 30 minutes and 2 hours depending on the fault. Complex wiring or panel issues may take longer.'],
         'ar'  => ['q' => 'كم يستغرق إصلاح الكهرباء عادةً؟',                                  'a' => 'معظم الإصلاحات تستغرق بين 30 دقيقة وساعتين حسب نوع العطل. مشاكل التمديدات أو اللوحة الكهربائية المعقدة قد تأخذ وقتاً أطول.'],
        ],
        ['cat' => 'repair',
         'en'  => ['q' => 'My circuit breaker keeps tripping. What is the cause?',   'a' => 'Repeated tripping is usually caused by an overloaded circuit, a faulty appliance, or a wiring fault. A technician can diagnose the exact cause quickly.'],
         'ar'  => ['q' => 'القاطع الكهربائي يفصل باستمرار. ما السبب؟',                  'a' => 'الفصل المتكرر غالباً سببه حمل زائد على الدائرة أو جهاز تالف أو عطل في الأسلاك. يستطيع الفني تشخيص السبب بسرعة.'],
        ],
        ['cat' => 'repair',
         'en'  => ['q' => 'How much does electrical repair cost in Kuwait?',                          'a' => 'Minor repairs start from KD 10–20. Major repairs like panel or wiring replacement can cost KD 80–200 depending on the scope of work.'],
         'ar'  => ['q' => 'كم تكلفة إصلاح الكهرباء في الكويت؟',                               'a' => 'الإصلاحات البسيطة تبدأ من 10–20 دينار. الإصلاحات الكبرى كاستبدال اللوحة أو الأسلاك قد تكلف 80–200 دينار حسب حجم العمل.'],
        ],
        // maintenance
        ['cat' => 'cleaning',
         'en'  => ['q' => 'How often should I inspect my home\'s electrical system in Kuwait?',                        'a' => 'We recommend a full inspection of the panel, breakers and wiring at least once a year, or every 6 months for older properties.'],
         'ar'  => ['q' => 'كم مرة يجب فحص كهرباء المنزل في الكويت؟',                             'a' => 'ننصح بفحص شامل للوحة والقواطع والأسلاك مرة واحدة سنوياً على الأقل، أو كل 6 أشهر للمنازل القديمة.'],
        ],
        ['cat' => 'cleaning',
         'en'  => ['q' => 'What is included in a professional electrical panel maintenance visit?',                'a' => 'A maintenance visit includes tightening connections, testing breakers and earthing, cleaning the panel internally, and a full safety report.'],
         'ar'  => ['q' => 'ماذا تشمل زيارة صيانة اللوحة الكهربائية الاحترافية؟',                     'a' => 'تشمل زيارة الصيانة: إحكام الوصلات، اختبار القواطع والتأريض، تنظيف اللوحة من الداخل، وتقرير سلامة كامل.'],
        ],
        // installation
        ['cat' => 'installation',
         'en'  => ['q' => 'How long does a new apartment wiring installation take?',                      'a' => 'A standard apartment wiring job takes 2–3 days depending on size. Villas or commercial units may take longer.'],
         'ar'  => ['q' => 'كم يستغرق تمديد كهرباء شقة جديدة؟',                                  'a' => 'تمديد الكهرباء لشقة معيارية يستغرق 2–3 أيام حسب المساحة. الفلل أو الوحدات التجارية قد تستغرق وقتاً أطول.'],
        ],
        ['cat' => 'installation',
         'en'  => ['q' => 'What size electrical panel do I need for my property?',                             'a' => 'It depends on the total electrical load: a standard apartment usually needs a 60–100A panel, while villas or larger properties may need 150A or more. Our technicians calculate this during the site visit.'],
         'ar'  => ['q' => 'ما سعة اللوحة الكهربائية المناسبة لعقاري؟',                               'a' => 'يعتمد ذلك على إجمالي الحمل الكهربائي: الشقة المعيارية تحتاج غالباً لوحة 60–100 أمبير، بينما الفلل أو العقارات الأكبر قد تحتاج 150 أمبير أو أكثر. فنيونا يحددون ذلك خلال الزيارة الميدانية.'],
        ],
        // spare_parts
        ['cat' => 'spare_parts',
         'en'  => ['q' => 'Do you use original spare parts?',                                 'a' => 'Yes, we use only genuine OEM electrical components — breakers, switches and cables. We can also source compatible high-quality alternatives if the original is unavailable.'],
         'ar'  => ['q' => 'هل تستخدمون قطع غيار أصلية؟',                                    'a' => 'نعم، نستخدم فقط مكونات كهربائية أصلية OEM — قواطع ومفاتيح وكابلات. يمكننا أيضاً توفير بدائل عالية الجودة متوافقة إذا لم يكن الأصلي متاحاً.'],
        ],
        // general
        ['cat' => 'general',
         'en'  => ['q' => 'Do you offer a warranty on repairs?',                              'a' => 'Yes, all our repair and installation work comes with a 3-month labour warranty. Replaced parts carry the manufacturer\'s warranty.'],
         'ar'  => ['q' => 'هل تقدمون ضماناً على الإصلاحات؟',                                'a' => 'نعم، جميع أعمال الإصلاح والتركيب تأتي مع ضمان عمالة لمدة 3 أشهر. القطع المستبدلة تحمل ضمان الشركة المصنّعة.'],
        ],
        ['cat' => 'general',
         'en'  => ['q' => 'Do you handle all types of electrical work?',                                    'a' => 'Yes, our technicians are trained to handle all common electrical work: wiring, panels, breakers, lighting, and emergency repairs.'],
         'ar'  => ['q' => 'هل تخدمون جميع أنواع الأعمال الكهربائية؟',                                'a' => 'نعم، فنيونا مدرّبون على جميع الأعمال الكهربائية الشائعة: التمديدات، اللوحات، القواطع، الإضاءة، والإصلاحات الطارئة.'],
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
