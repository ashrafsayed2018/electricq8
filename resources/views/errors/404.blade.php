<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 — الصفحة غير موجودة</title>
    @vite(['resources/css/app.css'])
    <style>
        :root {
            --bg:#FAF6F1;--cardBg:#FFFFFF;--border:#E7DCCC;--text:#2B211A;
            --muted:#7A6A5C;--primary:#6B3A17;--accent:#D97B2E;--accentTint:#F3D9BB;
        }
        @media(prefers-color-scheme:dark){
            :root{--bg:#1C140D;--cardBg:#2C2013;--border:#4A3826;--text:#F3E9DC;--muted:#C4AD95;}
        }
        :root[data-theme="light"]{--bg:#FAF6F1;--cardBg:#FFFFFF;--border:#E7DCCC;--text:#2B211A;--muted:#7A6A5C;}
        :root[data-theme="dark"]{--bg:#1C140D;--cardBg:#2C2013;--border:#4A3826;--text:#F3E9DC;--muted:#C4AD95;}

        *,*::before,*::after{box-sizing:border-box}
        body{margin:0;min-height:100vh;display:flex;align-items:center;justify-content:center;
             background:linear-gradient(135deg,#43230E 0%,#6B3A17 60%,#8B4D20 100%);
             font-family:'Cairo',system-ui,sans-serif;padding:24px}

        .e404{text-align:center;max-width:440px;width:100%}
        .e404__icon{width:88px;height:88px;border-radius:50%;
                    background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.15);
                    display:flex;align-items:center;justify-content:center;margin:0 auto 24px}
        .e404__icon svg{width:44px;height:44px;color:#F3D9BB}
        .e404__code{font-size:5rem;font-weight:900;color:rgba(255,255,255,.15);line-height:1;margin-bottom:8px}
        .e404__title{font-size:1.4rem;font-weight:800;color:#fff;margin-bottom:10px}
        .e404__msg{font-size:.85rem;color:#D8C7B4;line-height:1.7;margin-bottom:32px}
        .e404__actions{display:flex;flex-wrap:wrap;gap:10px;justify-content:center}
        .e404__btn{display:inline-flex;align-items:center;gap:6px;padding:10px 22px;
                   border-radius:10px;font-size:.85rem;font-weight:700;text-decoration:none;transition:opacity .2s;font-family:inherit}
        .e404__btn--primary{background:#D97B2E;color:#fff}
        .e404__btn--primary:hover{opacity:.88}
        .e404__btn--ghost{background:rgba(255,255,255,.08);color:#F3E9DC;border:1px solid rgba(255,255,255,.18)}
        .e404__btn--ghost:hover{background:rgba(255,255,255,.14)}
        .e404__btn svg{width:16px;height:16px}
    </style>
</head>
<body>

    <div class="e404">
        <div class="e404__icon">
            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 15.803 7.5 7.5 0 0015.803 15.803zM10.5 7.5v6m3-3h-6"/>
            </svg>
        </div>

        <div class="e404__code">404</div>
        <h1 class="e404__title">الصفحة غير موجودة</h1>
        <p class="e404__msg">الصفحة التي تبحث عنها غير موجودة أو تم نقلها.</p>

        <div class="e404__actions">
            @auth
                <a href="{{ route('admin.dashboard') }}" class="e404__btn e404__btn--primary">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    لوحة التحكم
                </a>
            @else
                <a href="{{ route('home') }}" class="e404__btn e404__btn--primary">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    الصفحة الرئيسية
                </a>
            @endauth
            <a href="javascript:history.back()" class="e404__btn e404__btn--ghost">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                الرجوع للخلف
            </a>
        </div>
    </div>

</body>
</html>
