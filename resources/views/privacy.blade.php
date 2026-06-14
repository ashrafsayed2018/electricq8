@extends('layouts.app')

@php
    $isAr   = app()->getLocale() === 'ar';
    $locale = $isAr ? 'ar' : 'en';
    $phone  = \App\Models\SiteSetting::get('phone_number');
    $email  = \App\Models\SiteSetting::get('email');
    $updated = $isAr ? 'مايو 2026' : 'May 2026';
@endphp

@section('meta_title')
    {{ $isAr
        ? 'سياسة الخصوصية والشروط والأحكام | إلكتريك كويت'
        : 'Privacy Policy & Terms of Service | ElectricQ8' }}
@endsection

@section('meta_description')
    {{ $isAr
        ? 'سياسة الخصوصية والشروط والأحكام لموقع إلكتريك كويت لخدمات الكهرباء بالكويت.'
        : 'Privacy Policy and Terms of Service for ElectricQ8 electrical services Kuwait.' }}
@endsection

@section('content')
<div dir="{{ $isAr ? 'rtl' : 'ltr' }}" class="bg-gray-50 min-h-screen">

    {{-- Page header --}}
    <div class="bg-yellow-700 text-white py-12 text-center">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-extrabold mb-2">
                {{ $isAr ? 'سياسة الخصوصية والشروط والأحكام' : 'Privacy Policy & Terms of Service' }}
            </h1>
            <p class="opacity-80 text-sm">
                {{ $isAr ? "آخر تحديث: {$updated}" : "Last updated: {$updated}" }}
            </p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-12 max-w-3xl">

        {{-- Tab switcher --}}
        <div class="flex bg-white rounded-xl border border-gray-200 p-1 gap-1 mb-10 shadow-sm"
             x-data="{ tab: 'privacy' }">
            <button type="button"
                @click="tab = 'privacy'"
                :class="tab === 'privacy' ? 'bg-yellow-700 text-white' : 'text-gray-500 hover:text-gray-800'"
                class="flex-1 py-2.5 rounded-lg font-bold text-sm transition">
                {{ $isAr ? 'سياسة الخصوصية' : 'Privacy Policy' }}
            </button>
            <button type="button"
                @click="tab = 'terms'"
                :class="tab === 'terms' ? 'bg-yellow-700 text-white' : 'text-gray-500 hover:text-gray-800'"
                class="flex-1 py-2.5 rounded-lg font-bold text-sm transition">
                {{ $isAr ? 'الشروط والأحكام' : 'Terms of Service' }}
            </button>

            {{-- ═══════════════════════════════════════════════════════
                 PRIVACY POLICY
            ══════════════════════════════════════════════════════════ --}}
            <div x-show="tab === 'privacy'" x-cloak
                 class="hidden"
                 style="display:none"
                 x-bind:style="tab === 'privacy' ? 'display:none' : ''">
            </div>
        </div>

        <div x-data="{ tab: 'privacy' }">

            {{-- Tab buttons (visible) --}}
            <div class="flex bg-white rounded-xl border border-gray-200 p-1 gap-1 mb-10 shadow-sm">
                <button type="button"
                    @click="tab = 'privacy'"
                    :class="tab === 'privacy' ? 'bg-yellow-700 text-white shadow' : 'text-gray-500 hover:text-gray-800'"
                    class="flex-1 py-2.5 rounded-lg font-bold text-sm transition">
                    {{ $isAr ? 'سياسة الخصوصية' : 'Privacy Policy' }}
                </button>
                <button type="button"
                    @click="tab = 'terms'"
                    :class="tab === 'terms' ? 'bg-yellow-700 text-white shadow' : 'text-gray-500 hover:text-gray-800'"
                    class="flex-1 py-2.5 rounded-lg font-bold text-sm transition">
                    {{ $isAr ? 'الشروط والأحكام' : 'Terms of Service' }}
                </button>
            </div>

            {{-- ═══════════════════════════════════════════════════════
                 PRIVACY POLICY CONTENT
            ══════════════════════════════════════════════════════════ --}}
            <div x-show="tab === 'privacy'" style="display:block"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0">

                <div class="bg-white rounded-2xl border border-gray-200 p-8 shadow-sm prose prose-gray max-w-none"
                     dir="{{ $isAr ? 'rtl' : 'ltr' }}">

                    @if($isAr)

                    <p class="text-gray-500 text-sm mb-8">مرحبًا بك في موقع إلكتريك كويت. نحن نلتزم بحماية خصوصية زوار الموقع والحفاظ على سرية أي معلومات يتم مشاركتها معنا.</p>

                    <h2 class="text-lg font-extrabold text-gray-900 mt-8 mb-3">المعلومات التي نجمعها</h2>
                    <p class="text-gray-600 leading-relaxed mb-3">لا يقوم موقع إلكتريك كويت بجمع معلومات شخصية من المستخدمين بشكل مباشر أثناء تصفح الموقع.</p>
                    <p class="text-gray-600 leading-relaxed mb-3">قد يتم جمع بعض المعلومات التقنية بشكل تلقائي من خلال مزود الاستضافة أو أدوات تشغيل الموقع، مثل:</p>
                    <ul class="list-disc {{ $isAr ? 'pr-6' : 'pl-6' }} space-y-1 text-gray-600 mb-4">
                        <li>نوع المتصفح</li>
                        <li>نوع الجهاز المستخدم</li>
                        <li>عنوان IP</li>
                        <li>الصفحات التي تمت زيارتها</li>
                        <li>وقت وتاريخ الزيارة</li>
                    </ul>
                    <p class="text-gray-600 leading-relaxed">يتم استخدام هذه المعلومات لأغراض تشغيل وتحسين أداء الموقع فقط.</p>

                    <h2 class="text-lg font-extrabold text-gray-900 mt-8 mb-3">التواصل معنا</h2>
                    <p class="text-gray-600 leading-relaxed mb-3">في حال قام المستخدم بالتواصل معنا عبر واتساب أو الهاتف أو البريد الإلكتروني أو نماذج التواصل، فقد يتم استخدام المعلومات التي يشاركها المستخدم فقط بغرض:</p>
                    <ul class="list-disc {{ $isAr ? 'pr-6' : 'pl-6' }} space-y-1 text-gray-600 mb-4">
                        <li>الرد على الاستفسارات</li>
                        <li>تقديم الخدمة المطلوبة</li>
                        <li>متابعة طلبات الدعم</li>
                    </ul>
                    <p class="text-gray-600 leading-relaxed">لا يتم بيع أو مشاركة هذه المعلومات مع أي طرف خارجي.</p>

                    <h2 class="text-lg font-extrabold text-gray-900 mt-8 mb-3">ملفات تعريف الارتباط (Cookies)</h2>
                    <p class="text-gray-600 leading-relaxed">قد يستخدم الموقع ملفات تعريف الارتباط لتحسين تجربة الاستخدام وأداء الموقع. يمكن للمستخدم تعطيلها من خلال إعدادات المتصفح.</p>

                    <h2 class="text-lg font-extrabold text-gray-900 mt-8 mb-3">روابط خارجية</h2>
                    <p class="text-gray-600 leading-relaxed">قد يحتوي الموقع على روابط لمواقع أو منصات خارجية. لسنا مسؤولين عن سياسات الخصوصية الخاصة بتلك المواقع.</p>

                    <h2 class="text-lg font-extrabold text-gray-900 mt-8 mb-3">تحديث سياسة الخصوصية</h2>
                    <p class="text-gray-600 leading-relaxed">قد يتم تحديث هذه السياسة من وقت لآخر. أي تعديلات يتم نشرها على هذه الصفحة تصبح سارية فور نشرها.</p>

                    <h2 class="text-lg font-extrabold text-gray-900 mt-8 mb-3">التواصل</h2>
                    <p class="text-gray-600 leading-relaxed">إذا كانت لديك أي استفسارات بخصوص سياسة الخصوصية، تواصل معنا عبر:</p>
                    <ul class="list-disc {{ $isAr ? 'pr-6' : 'pl-6' }} space-y-1 text-gray-600">
                        @if($phone) <li>الهاتف: <a href="tel:{{ $phone }}" class="text-yellow-700 font-semibold">{{ $phone }}</a></li> @endif
                        @if($email) <li>البريد: <a href="mailto:{{ $email }}" class="text-yellow-700 font-semibold">{{ $email }}</a></li> @endif
                        <li>واتساب: <a href="{{ \App\Helpers\WhatsAppHelper::url() }}" class="text-yellow-700 font-semibold">تواصل مباشرة</a></li>
                    </ul>

                    @else

                    <p class="text-gray-500 text-sm mb-8">Welcome to the ElectricQ8 website. We are committed to protecting the privacy of our visitors and maintaining the confidentiality of any information shared with us.</p>

                    <h2 class="text-lg font-extrabold text-gray-900 mt-8 mb-3">Information We Collect</h2>
                    <p class="text-gray-600 leading-relaxed mb-3">ElectricQ8 does not directly collect personal information from users while they browse the website.</p>
                    <p class="text-gray-600 leading-relaxed mb-3">Some technical information may be collected automatically by our hosting provider or website tools, such as:</p>
                    <ul class="list-disc pl-6 space-y-1 text-gray-600 mb-4">
                        <li>Browser type</li>
                        <li>Device type</li>
                        <li>IP address</li>
                        <li>Pages visited</li>
                        <li>Date and time of visit</li>
                    </ul>
                    <p class="text-gray-600 leading-relaxed">This information is used solely for the purpose of operating and improving the website.</p>

                    <h2 class="text-lg font-extrabold text-gray-900 mt-8 mb-3">Contacting Us</h2>
                    <p class="text-gray-600 leading-relaxed mb-3">If a user contacts us via WhatsApp, phone, email or a contact form, the information they share may be used solely to:</p>
                    <ul class="list-disc pl-6 space-y-1 text-gray-600 mb-4">
                        <li>Respond to enquiries</li>
                        <li>Provide the requested service</li>
                        <li>Follow up on support requests</li>
                    </ul>
                    <p class="text-gray-600 leading-relaxed">This information is never sold or shared with any third party.</p>

                    <h2 class="text-lg font-extrabold text-gray-900 mt-8 mb-3">Cookies</h2>
                    <p class="text-gray-600 leading-relaxed">The website may use cookies to improve the user experience and website performance. Users can disable cookies through their browser settings.</p>

                    <h2 class="text-lg font-extrabold text-gray-900 mt-8 mb-3">External Links</h2>
                    <p class="text-gray-600 leading-relaxed">The website may contain links to external websites or platforms. We are not responsible for the privacy policies of those sites.</p>

                    <h2 class="text-lg font-extrabold text-gray-900 mt-8 mb-3">Policy Updates</h2>
                    <p class="text-gray-600 leading-relaxed">This policy may be updated from time to time. Any changes are published on this page and take effect immediately upon publication.</p>

                    <h2 class="text-lg font-extrabold text-gray-900 mt-8 mb-3">Contact</h2>
                    <p class="text-gray-600 leading-relaxed">For any queries about this Privacy Policy, contact us via:</p>
                    <ul class="list-disc pl-6 space-y-1 text-gray-600">
                        @if($phone) <li>Phone: <a href="tel:{{ $phone }}" class="text-yellow-700 font-semibold">{{ $phone }}</a></li> @endif
                        @if($email) <li>Email: <a href="mailto:{{ $email }}" class="text-yellow-700 font-semibold">{{ $email }}</a></li> @endif
                        <li>WhatsApp: <a href="{{ \App\Helpers\WhatsAppHelper::url() }}" class="text-yellow-700 font-semibold">Contact directly</a></li>
                    </ul>

                    @endif
                </div>
            </div>

            {{-- ═══════════════════════════════════════════════════════
                 TERMS OF SERVICE CONTENT
            ══════════════════════════════════════════════════════════ --}}
            <div x-show="tab === 'terms'" style="display:none"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0">

                <div class="bg-white rounded-2xl border border-gray-200 p-8 shadow-sm prose prose-gray max-w-none"
                     dir="{{ $isAr ? 'rtl' : 'ltr' }}">

                    @if($isAr)

                    <p class="text-gray-500 text-sm mb-8">مرحبًا بك في موقع إلكتريك كويت. باستخدامك لهذا الموقع فإنك توافق على الشروط والأحكام التالية.</p>

                    <h2 class="text-lg font-extrabold text-gray-900 mt-8 mb-3">استخدام الموقع</h2>
                    <p class="text-gray-600 leading-relaxed mb-3">يوافق المستخدم على استخدام الموقع بشكل قانوني وعدم استخدامه في:</p>
                    <ul class="list-disc pr-6 space-y-1 text-gray-600">
                        <li>نشر محتوى ضار أو مخالف للقانون</li>
                        <li>محاولة اختراق الموقع أو التأثير على أمانه</li>
                        <li>تعطيل الخدمات أو إبطاء أداء الموقع</li>
                        <li>إساءة استخدام المحتوى المنشور أو نسخه دون إذن</li>
                    </ul>

                    <h2 class="text-lg font-extrabold text-gray-900 mt-8 mb-3">الخدمات المقدمة</h2>
                    <p class="text-gray-600 leading-relaxed mb-3">يوفر موقع إلكتريك كويت معلومات وخدمات مرتبطة بمجال الكهرباء والصيانة داخل الكويت. قد تختلف الأسعار ومدة تنفيذ الخدمات حسب:</p>
                    <ul class="list-disc pr-6 space-y-1 text-gray-600">
                        <li>نوع الخدمة المطلوبة</li>
                        <li>المنطقة الجغرافية</li>
                        <li>حالة الجهاز ودرجة العطل</li>
                        <li>توفر قطع الغيار</li>
                    </ul>

                    <h2 class="text-lg font-extrabold text-gray-900 mt-8 mb-3">دقة المعلومات</h2>
                    <p class="text-gray-600 leading-relaxed">نسعى لتوفير معلومات دقيقة ومحدثة على الموقع، لكننا لا نضمن خلو جميع المعلومات من الأخطاء. المعلومات المنشورة للإرشاد العام ولا تُغني عن التواصل المباشر للحصول على تفاصيل الأسعار أو توافر الخدمة.</p>

                    <h2 class="text-lg font-extrabold text-gray-900 mt-8 mb-3">حقوق الملكية الفكرية</h2>
                    <p class="text-gray-600 leading-relaxed">جميع النصوص والمحتويات والشعارات والصور الموجودة على الموقع مملوكة لإلكتريك كويت أو مرخص باستخدامها. لا يجوز نسخها أو إعادة نشرها أو استخدامها تجاريًا دون إذن مسبق وخطي.</p>

                    <h2 class="text-lg font-extrabold text-gray-900 mt-8 mb-3">روابط الجهات الخارجية</h2>
                    <p class="text-gray-600 leading-relaxed">قد يحتوي الموقع على روابط لمواقع أو خدمات خارجية. لسنا مسؤولين عن محتواها أو سياساتها أو مستوى خدماتها.</p>

                    <h2 class="text-lg font-extrabold text-gray-900 mt-8 mb-3">تعديل الشروط</h2>
                    <p class="text-gray-600 leading-relaxed">يحتفظ موقع إلكتريك كويت بحق تعديل هذه الشروط في أي وقت. يصبح التعديل ساريًا بمجرد نشره على هذه الصفحة. استمرار استخدامك للموقع يعني موافقتك على الشروط المعدّلة.</p>

                    <h2 class="text-lg font-extrabold text-gray-900 mt-8 mb-3">القانون المعمول به</h2>
                    <p class="text-gray-600 leading-relaxed">تخضع هذه الشروط والأحكام لقوانين دولة الكويت، وتختص المحاكم الكويتية بالنظر في أي نزاع ينشأ عنها.</p>

                    <h2 class="text-lg font-extrabold text-gray-900 mt-8 mb-3">التواصل معنا</h2>
                    <p class="text-gray-600 leading-relaxed">في حال وجود استفسارات حول الشروط والأحكام، تواصل معنا عبر وسائل الاتصال المتوفرة بالموقع.</p>

                    @else

                    <p class="text-gray-500 text-sm mb-8">Welcome to the ElectricQ8 website. By using this website you agree to the following Terms of Service.</p>

                    <h2 class="text-lg font-extrabold text-gray-900 mt-8 mb-3">Use of the Website</h2>
                    <p class="text-gray-600 leading-relaxed mb-3">Users agree to use the website lawfully and not to use it to:</p>
                    <ul class="list-disc pl-6 space-y-1 text-gray-600">
                        <li>Publish harmful or unlawful content</li>
                        <li>Attempt to breach or compromise website security</li>
                        <li>Disrupt services or degrade website performance</li>
                        <li>Misuse or copy published content without permission</li>
                    </ul>

                    <h2 class="text-lg font-extrabold text-gray-900 mt-8 mb-3">Services Provided</h2>
                    <p class="text-gray-600 leading-relaxed mb-3">ElectricQ8 provides information and services related to electrical services and maintenance within Kuwait. Prices and service timelines may vary depending on:</p>
                    <ul class="list-disc pl-6 space-y-1 text-gray-600">
                        <li>Type of service required</li>
                        <li>Geographic area</li>
                        <li>Condition of the unit and severity of the fault</li>
                        <li>Availability of spare parts</li>
                    </ul>

                    <h2 class="text-lg font-extrabold text-gray-900 mt-8 mb-3">Accuracy of Information</h2>
                    <p class="text-gray-600 leading-relaxed">We strive to provide accurate and up-to-date information on the website, but we cannot guarantee that all information is free of errors. Published information is for general guidance and does not replace direct contact for pricing details or service availability.</p>

                    <h2 class="text-lg font-extrabold text-gray-900 mt-8 mb-3">Intellectual Property</h2>
                    <p class="text-gray-600 leading-relaxed">All text, content, logos and images on the website are owned by ElectricQ8 or used under licence. They may not be copied, republished or used commercially without prior written permission.</p>

                    <h2 class="text-lg font-extrabold text-gray-900 mt-8 mb-3">Third-Party Links</h2>
                    <p class="text-gray-600 leading-relaxed">The website may contain links to external websites or services. We are not responsible for their content, policies or quality of service.</p>

                    <h2 class="text-lg font-extrabold text-gray-900 mt-8 mb-3">Amendments</h2>
                    <p class="text-gray-600 leading-relaxed">ElectricQ8 reserves the right to amend these Terms at any time. Amendments take effect immediately upon publication on this page. Continued use of the website constitutes acceptance of the amended Terms.</p>

                    <h2 class="text-lg font-extrabold text-gray-900 mt-8 mb-3">Governing Law</h2>
                    <p class="text-gray-600 leading-relaxed">These Terms are governed by the laws of the State of Kuwait, and Kuwaiti courts have exclusive jurisdiction over any dispute arising from them.</p>

                    <h2 class="text-lg font-extrabold text-gray-900 mt-8 mb-3">Contact</h2>
                    <p class="text-gray-600 leading-relaxed">For any queries about these Terms, contact us via the communication channels provided on the website.</p>

                    @endif
                </div>
            </div>

        </div>{{-- /x-data --}}
    </div>
</div>
@endsection
