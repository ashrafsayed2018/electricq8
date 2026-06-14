<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 — غير مصرح</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-[#0f1117] text-white min-h-screen flex items-center justify-center p-6">

    <div class="text-center max-w-md w-full">

        {{-- Icon --}}
        <div class="flex justify-center mb-6">
            <div class="w-24 h-24 rounded-full bg-red-500/10 border border-red-500/20 flex items-center justify-center">
                <svg class="w-12 h-12 text-red-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 9v3.75m0-10.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.25-8.25-3.286zm0 13.036h.008v.008H12v-.008z"/>
                </svg>
            </div>
        </div>

        {{-- Code --}}
        <p class="text-7xl font-black text-red-500/30 leading-none mb-2">403</p>

        {{-- Heading --}}
        <h1 class="text-2xl font-bold text-white mb-3">غير مصرح بالوصول</h1>

        {{-- Message --}}
        <p class="text-gray-400 text-sm leading-relaxed mb-8">
            ليس لديك الصلاحية للوصول إلى هذه الصفحة.<br>
            تواصل مع المدير إذا كنت تعتقد أن هذا خطأ.
        </p>

        {{-- Actions --}}
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            @auth
                <a href="{{ route('admin.dashboard') }}"
                   class="inline-flex items-center justify-center gap-2 bg-purple-600 hover:bg-purple-700 text-white px-6 py-2.5 rounded-lg text-sm font-semibold transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    لوحة التحكم
                </a>
                <a href="javascript:history.back()"
                   class="inline-flex items-center justify-center gap-2 bg-white/5 hover:bg-white/10 text-gray-300 hover:text-white px-6 py-2.5 rounded-lg text-sm font-semibold transition border border-white/10">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    الرجوع للخلف
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="inline-flex items-center justify-center gap-2 bg-purple-600 hover:bg-purple-700 text-white px-6 py-2.5 rounded-lg text-sm font-semibold transition">
                    تسجيل الدخول
                </a>
            @endauth
        </div>

    </div>

</body>
</html>
