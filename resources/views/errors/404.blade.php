<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 — الصفحة غير موجودة</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-[#0f1117] text-white min-h-screen flex items-center justify-center p-6">

    <div class="text-center max-w-md w-full">

        {{-- Icon --}}
        <div class="flex justify-center mb-6">
            <div class="w-24 h-24 rounded-full bg-purple-500/10 border border-purple-500/20 flex items-center justify-center">
                <svg class="w-12 h-12 text-purple-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 15.803 7.5 7.5 0 0015.803 15.803zM10.5 7.5v6m3-3h-6"/>
                </svg>
            </div>
        </div>

        {{-- Code --}}
        <p class="text-7xl font-black text-purple-500/30 leading-none mb-2">404</p>

        {{-- Heading --}}
        <h1 class="text-2xl font-bold text-white mb-3">الصفحة غير موجودة</h1>

        {{-- Message --}}
        <p class="text-gray-400 text-sm leading-relaxed mb-8">
            الصفحة التي تبحث عنها غير موجودة أو تم نقلها.
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
            @else
                <a href="{{ route('home') }}"
                   class="inline-flex items-center justify-center gap-2 bg-purple-600 hover:bg-purple-700 text-white px-6 py-2.5 rounded-lg text-sm font-semibold transition">
                    الصفحة الرئيسية
                </a>
            @endauth
            <a href="javascript:history.back()"
               class="inline-flex items-center justify-center gap-2 bg-white/5 hover:bg-white/10 text-gray-300 hover:text-white px-6 py-2.5 rounded-lg text-sm font-semibold transition border border-white/10">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                الرجوع للخلف
            </a>
        </div>

    </div>

</body>
</html>
