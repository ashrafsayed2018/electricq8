<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 — غير مصرح</title>
    @vite(['resources/css/app.css'])
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        body{min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px;
             background:linear-gradient(135deg,#43230E 0%,#1C140D 100%);font-family:'Cairo',system-ui,sans-serif;color:#fff}
        .e403{text-align:center;max-width:420px;width:100%}
        .e403__icon-wrap{width:96px;height:96px;border-radius:50%;background:rgba(239,68,68,.12);
                         border:1px solid rgba(239,68,68,.3);display:flex;align-items:center;
                         justify-content:center;margin:0 auto 24px}
        .e403__icon{width:48px;height:48px;color:#f87171}
        .e403__code{font-size:5rem;font-weight:900;color:rgba(239,68,68,.25);line-height:1;margin-bottom:8px}
        .e403__h1{font-size:1.5rem;font-weight:800;margin-bottom:12px}
        .e403__p{color:#D8C7B4;font-size:.9rem;line-height:1.7;margin-bottom:32px}
        .e403__actions{display:flex;flex-wrap:wrap;gap:10px;justify-content:center}
        .e403__btn{display:inline-flex;align-items:center;gap:7px;padding:10px 22px;border-radius:10px;
                   font-size:.88rem;font-weight:700;text-decoration:none;transition:opacity .2s;border:none;cursor:pointer;font-family:inherit}
        .e403__btn--primary{background:#D97B2E;color:#fff}
        .e403__btn--primary:hover{opacity:.88}
        .e403__btn--ghost{background:rgba(255,255,255,.08);color:#F3E9DC;border:1px solid rgba(255,255,255,.15)}
        .e403__btn--ghost:hover{background:rgba(255,255,255,.14)}
        .e403__btn svg{width:16px;height:16px;flex-shrink:0}
    </style>
</head>
<body>

    <div class="e403">
        <div class="e403__icon-wrap">
            <svg class="e403__icon" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 9v3.75m0-10.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.25-8.25-3.286zm0 13.036h.008v.008H12v-.008z"/>
            </svg>
        </div>

        <p class="e403__code">403</p>
        <h1 class="e403__h1">غير مصرح بالوصول</h1>
        <p class="e403__p">
            ليس لديك الصلاحية للوصول إلى هذه الصفحة.<br>
            تواصل مع المدير إذا كنت تعتقد أن هذا خطأ.
        </p>

        <div class="e403__actions">
            @auth
                <a href="{{ route('admin.dashboard') }}" class="e403__btn e403__btn--primary">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    لوحة التحكم
                </a>
                <button type="button" onclick="history.back()" class="e403__btn e403__btn--ghost">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    الرجوع للخلف
                </button>
            @else
                <a href="{{ route('login') }}" class="e403__btn e403__btn--primary">
                    تسجيل الدخول
                </a>
            @endauth
        </div>
    </div>

</body>
</html>
