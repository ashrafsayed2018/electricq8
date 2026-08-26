<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Testimonial;
use App\Models\Faq;
use App\Models\Post;
use Illuminate\Support\Str;

echo "=== Fixing testimonials ===\n";

$testimonialReplacements = [
    'ركّبوا ثلاثة كهرباءات سبليت في شقتي. العمل كان نظيفاً وسريعاً وبسعر معقول.' => [
        'ar' => 'ركّبوا اللوحة الكهربائية بالكامل في شقتي الجديدة. العمل كان نظيفاً وسريعاً وبسعر معقول.',
        'en' => 'They installed the full electrical panel in my new apartment. The work was clean, fast, and reasonably priced.',
    ],
    'شخّصوا مشكلة الكهرباء المركزي وأعادوه للعمل بشكل مثالي خلال ساعتين. عمل رائع!' => [
        'ar' => 'شخّصوا مشكلة القاطع الذي يفصل باستمرار وأعادوا الدائرة للعمل بشكل مثالي خلال ساعة. عمل رائع!',
        'en' => 'They diagnosed a recurring breaker trip and had the whole circuit running perfectly within an hour. Great work!',
    ],
    'خدمة تصليح شورت ممتازة. كهرباءي يبرد بشكل مثالي الآن. الفني كان مؤدباً وفعالاً.' => [
        'ar' => 'خدمة تصليح شورت ممتازة. كل شيء يعمل بشكل مثالي الآن. الفني كان مؤدباً وفعالاً.',
        'en' => 'Excellent short circuit repair service. Everything works perfectly now. The technician was polite and efficient.',
    ],
    'أفضل خدمة تصليح كهرباء في الكويت. الكهرباء يعمل بكفاءة أكبر الآن. أنصح بشدة!' => [
        'ar' => 'أفضل خدمة صيانة كهرباء في الكويت. تمديدات منزلي أصبحت أكثر أماناً وكفاءة الآن. أنصح بشدة!',
        'en' => 'Best electrical maintenance service in Kuwait. My home wiring runs much more safely and efficiently now. Highly recommended!',
    ],
    'خدمة ممتازة! وصل الفني في الوقت المحدد وأصلح الكهرباء خلال ساعة. فريق محترف جداً.' => [
        'ar' => 'خدمة ممتازة! وصل الفني في الوقت المحدد وأصلح عطل الأسلاك خلال ساعة. فريق محترف جداً.',
        'en' => 'Excellent service! The technician arrived on time and fixed the wiring fault within an hour. Very professional team.',
    ],
    'خدمة سريعة وموثوقة. استبدلوا الكمبروسر في كهرباءي القديم ويعمل كالجديد مجدداً.' => [
        'ar' => 'خدمة سريعة وموثوقة. استبدلوا جميع الأسلاك القديمة في شقتي وأصبح كل شيء يعمل كالجديد مجدداً.',
        'en' => 'Fast and reliable service. They replaced all the old wiring in my apartment and everything works like new again.',
    ],
];

$updated = 0;
foreach (Testimonial::all() as $t) {
    $arBody = $t->getTranslation('body', 'ar');
    if (isset($testimonialReplacements[$arBody])) {
        $t->setTranslation('body', 'ar', $testimonialReplacements[$arBody]['ar']);
        $t->setTranslation('body', 'en', $testimonialReplacements[$arBody]['en']);
        $t->save();
        $updated++;
    }
}
echo "Updated {$updated} testimonial rows.\n";

echo "\n=== Fixing FAQs ===\n";

$faqReplacements = [
    'كم يستغرق إصلاح الكهرباء عادةً؟' => [
        'q_ar' => 'كم يستغرق إصلاح الكهرباء عادةً؟',
        'a_ar' => 'معظم الإصلاحات تستغرق بين 30 دقيقة وساعتين حسب نوع العطل. مشاكل التمديدات أو اللوحة الكهربائية المعقدة قد تأخذ وقتاً أطول.',
        'q_en' => 'How long does an electrical repair usually take?',
        'a_en' => 'Most repairs take between 30 minutes and 2 hours depending on the fault. Complex wiring or panel issues may take longer.',
    ],
    'كهرباءي يبرد لكنه يسرّب ماء بالداخل. ما السبب؟' => [
        'q_ar' => 'القاطع الكهربائي يفصل باستمرار. ما السبب؟',
        'a_ar' => 'الفصل المتكرر غالباً سببه حمل زائد على الدائرة أو جهاز تالف أو عطل في الأسلاك. يستطيع الفني تشخيص السبب بسرعة.',
        'q_en' => 'My circuit breaker keeps tripping. What is the cause?',
        'a_en' => 'Repeated tripping is usually caused by an overloaded circuit, a faulty appliance, or a wiring fault. A technician can diagnose the exact cause quickly.',
    ],
    'كم تكلفة إصلاح الكهرباء في الكويت؟' => [
        'q_ar' => 'كم تكلفة إصلاح الكهرباء في الكويت؟',
        'a_ar' => 'الإصلاحات البسيطة تبدأ من 10–20 دينار. الإصلاحات الكبرى كاستبدال اللوحة أو الأسلاك قد تكلف 80–200 دينار حسب حجم العمل.',
        'q_en' => 'How much does electrical repair cost in Kuwait?',
        'a_en' => 'Minor repairs start from KD 10–20. Major repairs like panel or wiring replacement can cost KD 80–200 depending on the scope of work.',
    ],
    'كم مرة يجب تنظيف الكهرباء في الكويت؟' => [
        'q_ar' => 'كم مرة يجب فحص كهرباء المنزل في الكويت؟',
        'a_ar' => 'ننصح بفحص شامل للوحة والقواطع والأسلاك مرة واحدة سنوياً على الأقل، أو كل 6 أشهر للمنازل القديمة.',
        'q_en' => 'How often should I inspect my home\'s electrical system in Kuwait?',
        'a_en' => 'We recommend a full inspection of the panel, breakers and wiring at least once a year, or every 6 months for older properties.',
    ],
    'ماذا يشمل التنظيف العميق الاحترافي للكهرباء؟' => [
        'q_ar' => 'ماذا تشمل زيارة صيانة اللوحة الكهربائية الاحترافية؟',
        'a_ar' => 'تشمل زيارة الصيانة: إحكام الوصلات، اختبار القواطع والتأريض، تنظيف اللوحة من الداخل، وتقرير سلامة كامل.',
        'q_en' => 'What is included in a professional electrical panel maintenance visit?',
        'a_en' => 'A maintenance visit includes tightening connections, testing breakers and earthing, cleaning the panel internally, and a full safety report.',
    ],
    'كم يستغرق تركيب كهرباء السبليت؟' => [
        'q_ar' => 'كم يستغرق تمديد كهرباء شقة جديدة؟',
        'a_ar' => 'تمديد الكهرباء لشقة معيارية يستغرق 2–3 أيام حسب المساحة. الفلل أو الوحدات التجارية قد تستغرق وقتاً أطول.',
        'q_en' => 'How long does a new apartment wiring installation take?',
        'a_en' => 'A standard apartment wiring job takes 2–3 days depending on size. Villas or commercial units may take longer.',
    ],
    'ما حجم البي تي يو المناسب لغرفتي؟' => [
        'q_ar' => 'ما سعة اللوحة الكهربائية المناسبة لعقاري؟',
        'a_ar' => 'يعتمد ذلك على إجمالي الحمل الكهربائي: الشقة المعيارية تحتاج غالباً لوحة 60–100 أمبير، بينما الفلل أو العقارات الأكبر قد تحتاج 150 أمبير أو أكثر. فنيونا يحددون ذلك خلال الزيارة الميدانية.',
        'q_en' => 'What size electrical panel do I need for my property?',
        'a_en' => 'It depends on the total electrical load: a standard apartment usually needs a 60–100A panel, while villas or larger properties may need 150A or more. Our technicians calculate this during the site visit.',
    ],
    'هل تخدمون جميع ماركات الكهرباءات؟' => [
        'q_ar' => 'هل تخدمون جميع أنواع الأعمال الكهربائية؟',
        'a_ar' => 'نعم، فنيونا مدرّبون على جميع الأعمال الكهربائية الشائعة: التمديدات، اللوحات، القواطع، الإضاءة، والإصلاحات الطارئة.',
        'q_en' => 'Do you handle all types of electrical work?',
        'a_en' => 'Yes, our technicians are trained to handle all common electrical work: wiring, panels, breakers, lighting, and emergency repairs.',
    ],
];

$updated = 0;
foreach (Faq::all() as $f) {
    $arQ = $f->getTranslation('question', 'ar');
    if (isset($faqReplacements[$arQ])) {
        $r = $faqReplacements[$arQ];
        $f->setTranslation('question', 'ar', $r['q_ar']);
        $f->setTranslation('question', 'en', $r['q_en']);
        $f->setTranslation('answer', 'ar', $r['a_ar']);
        $f->setTranslation('answer', 'en', $r['a_en']);
        $f->save();
        $updated++;
    }
}
echo "Updated {$updated} FAQ rows.\n";

echo "\n=== Fixing blog posts #4 and #5 (matched by old AC-themed title, not hardcoded ID) ===\n";

$post4 = Post::whereJsonContains('title->en', 'The Complete Guide to Electrical Refill in Kuwait')->first();
if ($post4) {
    $titleAr = 'الدليل الشامل لتصليح شورت الكهرباء في الكويت';
    $titleEn = 'The Complete Guide to Short Circuit Repair in Kuwait';
    $post4->setTranslation('title', 'ar', $titleAr);
    $post4->setTranslation('title', 'en', $titleEn);
    $post4->setTranslation('h1', 'ar', $titleAr);
    $post4->setTranslation('h1', 'en', $titleEn);
    $post4->setTranslation('slug', 'ar', Str::slug($titleAr, '-', 'ar'));
    $post4->setTranslation('slug', 'en', Str::slug($titleEn));
    $post4->setTranslation('excerpt', 'ar', 'كل ما تحتاج معرفته عن أسباب الماس الكهربائي، خطورته، وكيفية إصلاحه بأمان.');
    $post4->setTranslation('excerpt', 'en', 'Everything you need to know about the causes of short circuits, the danger they pose, and how to repair them safely.');

    $contentAr = <<<HTML
<p>التماس الكهربائي (الشورت) من أخطر أعطال الكهرباء في المنزل، وقد يتسبب في انقطاع التيار المفاجئ أو حتى نشوب حريق إذا لم يُعالج بسرعة واحترافية. في هذا الدليل نشرح أسباب الشورت الشائعة، علامات التحذير، وخطوات الإصلاح الآمن.</p>

<h2>ما هو التماس الكهربائي؟</h2>
<p>يحدث الشورت عندما يتلامس سلكان مكهربان بشكل مباشر خارج المسار الطبيعي للدائرة، مما يؤدي إلى تدفق تيار كهربائي مفاجئ وكبير يفوق قدرة الأسلاك على تحمّله.</p>

<h2>أشهر أسباب الماس الكهربائي</h2>
<ul>
<li>أسلاك قديمة أو تالفة بسبب التآكل</li>
<li>وصلات كهربائية رطبة أو غير محكمة</li>
<li>حمل زائد على دائرة كهربائية واحدة</li>
<li>قوارض أو حشرات تتلف عزل الأسلاك</li>
</ul>

<h2>علامات تدل على وجود شورت كهربائي</h2>
<ul>
<li>رائحة احتراق أو دخان من المقابس أو اللوحة الكهربائية</li>
<li>قاطع يفصل فور إعادة تشغيله مباشرة</li>
<li>شرر ظاهر عند توصيل أو فصل أي جهاز</li>
<li>سخونة ملحوظة في الجدار حول الأسلاك</li>
</ul>

<h2>كيف نتعامل مع الشورت الكهربائي؟</h2>
<p>يبدأ فنيونا بفصل الدائرة المتضررة فوراً لضمان السلامة، ثم نستخدم أجهزة تتبع أعطال متقدمة لتحديد موقع التماس بدقة، قبل إصلاح أو استبدال الأسلاك التالفة واختبار الدائرة بالكامل قبل إعادة التشغيل.</p>

<h3>هل يمكنني إصلاح الشورت بنفسي؟</h3>
<p>لا ننصح بذلك إطلاقاً. التعامل مع تماس كهربائي دون خبرة أو أدوات مناسبة يعرّضك لخطر الصعق أو الحريق. تواصل مع فني كهربائي معتمد فور ملاحظة أي من العلامات المذكورة أعلاه.</p>
HTML;

    $contentEn = <<<HTML
<p>A short circuit is one of the most dangerous electrical faults a home can face, potentially causing sudden power loss or even a fire if not handled quickly and professionally. This guide covers the common causes, warning signs, and safe repair steps.</p>

<h2>What Is a Short Circuit?</h2>
<p>A short circuit happens when two live wires touch directly outside their normal circuit path, causing a sudden surge of current far beyond what the wiring is rated to handle.</p>

<h2>Common Causes of Short Circuits</h2>
<ul>
<li>Old or worn-out wiring</li>
<li>Damp or loose electrical connections</li>
<li>Overloading a single circuit</li>
<li>Rodents or insects damaging wire insulation</li>
</ul>

<h2>Signs You Have a Short Circuit</h2>
<ul>
<li>A burning smell or smoke from outlets or the panel</li>
<li>A breaker that trips again immediately after being reset</li>
<li>Visible sparks when plugging in or unplugging a device</li>
<li>Noticeable heat in the wall around wiring</li>
</ul>

<h2>How We Handle Short Circuit Repairs</h2>
<p>Our technicians start by safely isolating the affected circuit, then use advanced fault-tracing equipment to pinpoint the exact location of the short before repairing or replacing the damaged wiring and fully testing the circuit before restoring power.</p>

<h3>Can I Fix a Short Circuit Myself?</h3>
<p>We strongly advise against it. Handling a short circuit without proper training or tools puts you at risk of electric shock or fire. Contact a certified electrician as soon as you notice any of the warning signs above.</p>
HTML;

    $post4->setTranslation('content', 'ar', $contentAr);
    $post4->setTranslation('content', 'en', $contentEn);
    $post4->save();
    echo "Fixed post: {$post4->id}\n";
} else {
    echo "Post 'Electrical Refill' not found (already fixed or doesn't exist) — skipping.\n";
}

$post5 = Post::whereJsonContains('title->en', 'Central AC vs Split AC: Which Is Better for Kuwait?')->first();
if ($post5) {
    $titleAr = 'اللوحة الكهربائية القديمة مقابل الجديدة: متى يجب التبديل في الكويت؟';
    $titleEn = 'Old vs New Electrical Panel: When Should You Replace It in Kuwait?';
    $post5->setTranslation('title', 'ar', $titleAr);
    $post5->setTranslation('title', 'en', $titleEn);
    $post5->setTranslation('h1', 'ar', $titleAr);
    $post5->setTranslation('h1', 'en', $titleEn);
    $post5->setTranslation('slug', 'ar', Str::slug($titleAr, '-', 'ar'));
    $post5->setTranslation('slug', 'en', Str::slug($titleEn));
    $post5->setTranslation('excerpt', 'ar', 'مقارنة تساعدك على معرفة متى تحتاج لوحتك الكهربائية القديمة إلى تحديث أو استبدال كامل.');
    $post5->setTranslation('excerpt', 'en', 'A comparison to help you know when your old electrical panel needs an upgrade or a full replacement.');

    $contentAr = <<<HTML
<p>لوحة التوزيع الكهربائي هي قلب المنظومة الكهربائية في أي منزل، ومع مرور الوقت قد تصبح غير قادرة على التعامل مع احتياجات الأسرة المتزايدة من الكهرباء. في هذا المقال نوضح الفرق بين اللوحات القديمة والحديثة، ومتى يجب التفكير في التبديل.</p>

<h2>مشاكل اللوحات الكهربائية القديمة</h2>
<ul>
<li>سعة محدودة لا تتناسب مع الأجهزة الحديثة</li>
<li>قواطع قديمة قد لا تفصل بشكل صحيح عند حدوث عطل</li>
<li>غياب قواطع الحماية من التسرب الأرضي (RCCB)</li>
<li>وصلات متآكلة تزيد من خطر الحريق</li>
</ul>

<h2>مميزات اللوحات الكهربائية الحديثة</h2>
<ul>
<li>سعة أكبر تدعم الأجهزة والتكييف والإضاءة الحديثة</li>
<li>قواطع دقيقة تفصل فوراً عند أي حمل زائد أو تسرب</li>
<li>تصنيف أفضل يقلل من مخاطر الحرائق الكهربائية</li>
<li>إمكانية إضافة دوائر جديدة بسهولة مستقبلاً</li>
</ul>

<h2>متى يجب تبديل اللوحة الكهربائية؟</h2>
<p>ننصح بالتفكير في التبديل إذا كان عمر اللوحة يتجاوز 15-20 سنة، أو إذا لاحظت فصلاً متكرراً للقواطع، أو عند إضافة أجهزة كهربائية كبيرة كوحدات تكييف مركزية جديدة تتطلب حملاً أعلى.</p>

<h3>كيف نساعدك في اتخاذ القرار؟</h3>
<p>يقوم فنيونا بزيارة ميدانية لفحص اللوحة الحالية وقياس الحمل الكهربائي الفعلي للمنزل، ثم يقدمون توصية واضحة مع عرض سعر شفاف قبل البدء بأي عمل.</p>
HTML;

    $contentEn = <<<HTML
<p>The electrical panel is the heart of a home's electrical system, and over time it may struggle to keep up with a household's growing power needs. This article explains the difference between old and modern panels, and when you should consider replacing yours.</p>

<h2>Problems With Old Electrical Panels</h2>
<ul>
<li>Limited capacity that can't handle modern appliances</li>
<li>Old breakers that may not trip correctly during a fault</li>
<li>No residual current protection (RCCB)</li>
<li>Corroded connections that increase fire risk</li>
</ul>

<h2>Benefits of Modern Electrical Panels</h2>
<ul>
<li>Higher capacity to support modern appliances, AC units, and lighting</li>
<li>Precise breakers that trip instantly on overload or leakage</li>
<li>Better ratings that reduce the risk of electrical fires</li>
<li>Easy to add new circuits in the future</li>
</ul>

<h2>When Should You Replace Your Panel?</h2>
<p>Consider replacing your panel if it's over 15-20 years old, if you notice breakers tripping repeatedly, or when adding major appliances such as a new central AC unit that requires a higher load.</p>

<h3>How We Help You Decide</h3>
<p>Our technicians visit your property to inspect the current panel and measure your home's actual electrical load, then provide a clear recommendation with a transparent quote before any work begins.</p>
HTML;

    $post5->setTranslation('content', 'ar', $contentAr);
    $post5->setTranslation('content', 'en', $contentEn);
    $post5->save();
    echo "Fixed post: {$post5->id}\n";
} else {
    echo "Post 'Central AC vs Split AC' not found (already fixed or doesn't exist) — skipping.\n";
}

echo "\nDone.\n";
