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
<div dir="{{ $isAr ? 'rtl' : 'ltr' }}" style="background:var(--bg);min-height:100vh">

    {{-- Page header --}}
    <div class="eq8-page-hero" style="padding:48px 20px">
        <div class="eq8-page-hero__inner">
            <h1 class="eq8-page-hero__title">
                {{ $isAr ? 'سياسة الخصوصية والشروط والأحكام' : 'Privacy Policy & Terms of Service' }}
            </h1>
            <p style="color:#F3D9BB;font-size:.85rem;margin:0;font-family:'Cairo',sans-serif">
                {{ $isAr ? "آخر تحديث: {$updated}" : "Last updated: {$updated}" }}
            </p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-12" style="max-width:780px">

        <div x-data="{ tab: 'privacy' }">

            {{-- Tab buttons --}}
            <div class="eq8-privacy-tabs">
                <button type="button"
                    @click="tab = 'privacy'"
                    :class="tab === 'privacy' ? 'eq8-privacy-tab--active' : ''"
                    class="eq8-privacy-tab">
                    {{ $isAr ? 'سياسة الخصوصية' : 'Privacy Policy' }}
                </button>
                <button type="button"
                    @click="tab = 'terms'"
                    :class="tab === 'terms' ? 'eq8-privacy-tab--active' : ''"
                    class="eq8-privacy-tab">
                    {{ $isAr ? 'الشروط والأحكام' : 'Terms of Service' }}
                </button>
            </div>

            {{-- Privacy Policy --}}
            <div x-show="tab === 'privacy'" style="display:block"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0">

                <div class="eq8-privacy-content" dir="{{ $isAr ? 'rtl' : 'ltr' }}">
                    @if($isAr)
                    <p class="eq8-pc__lead">مرحبًا بك في موقع إلكتريك كويت. نحن نلتزم بحماية خصوصية زوار الموقع والحفاظ على سرية أي معلومات يتم مشاركتها معنا.</p>

                    <h2 class="eq8-pc__h2">المعلومات التي نجمعها</h2>
                    <p class="eq8-pc__p">لا يقوم موقع إلكتريك كويت بجمع معلومات شخصية من المستخدمين بشكل مباشر أثناء تصفح الموقع.</p>
                    <p class="eq8-pc__p">قد يتم جمع بعض المعلومات التقنية بشكل تلقائي، مثل:</p>
                    <ul class="eq8-pc__list">
                        <li>نوع المتصفح</li><li>نوع الجهاز المستخدم</li><li>عنوان IP</li>
                        <li>الصفحات التي تمت زيارتها</li><li>وقت وتاريخ الزيارة</li>
                    </ul>

                    <h2 class="eq8-pc__h2">التواصل معنا</h2>
                    <p class="eq8-pc__p">في حال قام المستخدم بالتواصل معنا، قد يتم استخدام المعلومات التي يشاركها فقط بغرض:</p>
                    <ul class="eq8-pc__list"><li>الرد على الاستفسارات</li><li>تقديم الخدمة المطلوبة</li><li>متابعة طلبات الدعم</li></ul>
                    <p class="eq8-pc__p">لا يتم بيع أو مشاركة هذه المعلومات مع أي طرف خارجي.</p>

                    <h2 class="eq8-pc__h2">ملفات تعريف الارتباط</h2>
                    <p class="eq8-pc__p">قد يستخدم الموقع ملفات تعريف الارتباط لتحسين تجربة الاستخدام. يمكن للمستخدم تعطيلها من خلال إعدادات المتصفح.</p>

                    <h2 class="eq8-pc__h2">روابط خارجية</h2>
                    <p class="eq8-pc__p">قد يحتوي الموقع على روابط لمواقع أو منصات خارجية. لسنا مسؤولين عن سياسات الخصوصية الخاصة بتلك المواقع.</p>

                    <h2 class="eq8-pc__h2">التواصل</h2>
                    <ul class="eq8-pc__list">
                        @if($phone)<li>الهاتف: <a href="tel:{{ $phone }}" class="eq8-pc__link">{{ $phone }}</a></li>@endif
                        @if($email)<li>البريد: <a href="mailto:{{ $email }}" class="eq8-pc__link">{{ $email }}</a></li>@endif
                        <li>واتساب: <a href="{{ \App\Helpers\WhatsAppHelper::url() }}" class="eq8-pc__link">تواصل مباشرة</a></li>
                    </ul>

                    @else
                    <p class="eq8-pc__lead">Welcome to the ElectricQ8 website. We are committed to protecting the privacy of our visitors.</p>

                    <h2 class="eq8-pc__h2">Information We Collect</h2>
                    <p class="eq8-pc__p">ElectricQ8 does not directly collect personal information from users while they browse. Some technical information may be collected automatically, such as:</p>
                    <ul class="eq8-pc__list"><li>Browser type</li><li>Device type</li><li>IP address</li><li>Pages visited</li><li>Date and time of visit</li></ul>

                    <h2 class="eq8-pc__h2">Contacting Us</h2>
                    <p class="eq8-pc__p">If a user contacts us, the information they share may be used solely to respond to enquiries, provide the requested service, or follow up on support requests.</p>
                    <p class="eq8-pc__p">This information is never sold or shared with any third party.</p>

                    <h2 class="eq8-pc__h2">Cookies</h2>
                    <p class="eq8-pc__p">The website may use cookies to improve the user experience. Users can disable them through their browser settings.</p>

                    <h2 class="eq8-pc__h2">External Links</h2>
                    <p class="eq8-pc__p">The website may contain links to external websites. We are not responsible for the privacy policies of those sites.</p>

                    <h2 class="eq8-pc__h2">Contact</h2>
                    <ul class="eq8-pc__list">
                        @if($phone)<li>Phone: <a href="tel:{{ $phone }}" class="eq8-pc__link">{{ $phone }}</a></li>@endif
                        @if($email)<li>Email: <a href="mailto:{{ $email }}" class="eq8-pc__link">{{ $email }}</a></li>@endif
                        <li>WhatsApp: <a href="{{ \App\Helpers\WhatsAppHelper::url() }}" class="eq8-pc__link">Contact directly</a></li>
                    </ul>
                    @endif
                </div>
            </div>

            {{-- Terms of Service --}}
            <div x-show="tab === 'terms'" style="display:none"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0">

                <div class="eq8-privacy-content" dir="{{ $isAr ? 'rtl' : 'ltr' }}">
                    @if($isAr)
                    <p class="eq8-pc__lead">مرحبًا بك في موقع إلكتريك كويت. باستخدامك لهذا الموقع فإنك توافق على الشروط والأحكام التالية.</p>

                    <h2 class="eq8-pc__h2">استخدام الموقع</h2>
                    <p class="eq8-pc__p">يوافق المستخدم على استخدام الموقع بشكل قانوني وعدم استخدامه في:</p>
                    <ul class="eq8-pc__list"><li>نشر محتوى ضار أو مخالف للقانون</li><li>محاولة اختراق الموقع أو التأثير على أمانه</li><li>تعطيل الخدمات</li><li>إساءة استخدام المحتوى</li></ul>

                    <h2 class="eq8-pc__h2">الخدمات المقدمة</h2>
                    <p class="eq8-pc__p">قد تختلف الأسعار ومدة تنفيذ الخدمات حسب: نوع الخدمة، المنطقة الجغرافية، حالة الجهاز، وتوفر قطع الغيار.</p>

                    <h2 class="eq8-pc__h2">دقة المعلومات</h2>
                    <p class="eq8-pc__p">نسعى لتوفير معلومات دقيقة ومحدثة على الموقع، لكننا لا نضمن خلو جميع المعلومات من الأخطاء.</p>

                    <h2 class="eq8-pc__h2">حقوق الملكية الفكرية</h2>
                    <p class="eq8-pc__p">جميع النصوص والمحتويات والشعارات والصور الموجودة على الموقع مملوكة لإلكتريك كويت. لا يجوز نسخها أو إعادة نشرها بدون إذن مسبق.</p>

                    <h2 class="eq8-pc__h2">تعديل الشروط</h2>
                    <p class="eq8-pc__p">يحتفظ الموقع بحق تعديل هذه الشروط في أي وقت. استمرار استخدامك للموقع يعني موافقتك على الشروط المعدّلة.</p>

                    <h2 class="eq8-pc__h2">القانون المعمول به</h2>
                    <p class="eq8-pc__p">تخضع هذه الشروط والأحكام لقوانين دولة الكويت.</p>

                    @else
                    <p class="eq8-pc__lead">Welcome to the ElectricQ8 website. By using this website you agree to the following Terms of Service.</p>

                    <h2 class="eq8-pc__h2">Use of the Website</h2>
                    <p class="eq8-pc__p">Users agree to use the website lawfully and not to publish harmful content, attempt to breach security, or misuse published content.</p>

                    <h2 class="eq8-pc__h2">Services Provided</h2>
                    <p class="eq8-pc__p">Prices and service timelines may vary depending on type of service, geographic area, condition of the unit, and availability of spare parts.</p>

                    <h2 class="eq8-pc__h2">Accuracy of Information</h2>
                    <p class="eq8-pc__p">We strive to provide accurate information but cannot guarantee that all information is error-free. Published information is for general guidance.</p>

                    <h2 class="eq8-pc__h2">Intellectual Property</h2>
                    <p class="eq8-pc__p">All text, content, logos and images are owned by ElectricQ8 and may not be copied or republished without prior written permission.</p>

                    <h2 class="eq8-pc__h2">Amendments</h2>
                    <p class="eq8-pc__p">ElectricQ8 reserves the right to amend these Terms at any time. Continued use of the website constitutes acceptance of the amended Terms.</p>

                    <h2 class="eq8-pc__h2">Governing Law</h2>
                    <p class="eq8-pc__p">These Terms are governed by the laws of the State of Kuwait.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

<style>
.eq8-page-hero { background:linear-gradient(135deg,#43230E 0%,#6B3A17 60%,#8B4D20 100%); color:#fff; text-align:center; }
.eq8-page-hero__inner { max-width:700px; margin:0 auto; }
.eq8-page-hero__title { font-size:clamp(1.4rem,3.5vw,2rem); font-weight:800; margin:0 0 10px; font-family:'Cairo',system-ui,sans-serif; }

.eq8-privacy-tabs { display:flex; background:var(--cardBg); border:1px solid var(--border); border-radius:14px; padding:5px; gap:5px; margin-bottom:28px; }
.eq8-privacy-tab { flex:1; padding:10px; border:none; border-radius:10px; font-family:'Cairo',sans-serif; font-size:.88rem; font-weight:700; color:var(--muted); background:transparent; cursor:pointer; transition:background .2s,color .2s; }
.eq8-privacy-tab:hover { color:var(--text); }
.eq8-privacy-tab--active { background:var(--primary); color:#fff; }

.eq8-privacy-content { background:var(--cardBg); border:1px solid var(--border); border-radius:16px; padding:36px; }
.eq8-pc__lead { font-size:.88rem; color:var(--muted); line-height:1.75; margin:0 0 24px; font-family:'Cairo',sans-serif; }
.eq8-pc__h2 { font-size:1rem; font-weight:800; color:var(--text); margin:28px 0 10px; font-family:'Cairo',sans-serif; }
.eq8-pc__p { font-size:.85rem; color:var(--body); line-height:1.8; margin:0 0 12px; font-family:'Cairo',sans-serif; }
.eq8-pc__list { font-size:.85rem; color:var(--body); line-height:1.75; padding-inline-start:20px; margin:0 0 12px; font-family:'Cairo',sans-serif; }
.eq8-pc__list li { margin-bottom:4px; }
.eq8-pc__link { color:var(--primary); font-weight:600; text-decoration:none; }
.eq8-pc__link:hover { text-decoration:underline; }
</style>
@endsection
