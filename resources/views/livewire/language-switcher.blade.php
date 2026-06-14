@php
$current = app()->getLocale();
$next    = $current === 'ar' ? 'en' : 'ar';
$label   = $next === 'en' ? 'EN' : 'العربية';
@endphp

<a
    href="{{ route('locale.switch', $next) }}"
    class="lang-toggle"
    aria-label="{{ $current === 'ar' ? 'Switch to English' : 'التبديل إلى العربية' }}"
    title="{{ $current === 'ar' ? 'Switch to English' : 'التبديل إلى العربية' }}"
>
    <span class="lang-toggle__globe" aria-hidden="true">🌐</span>
    {{ $label }}
</a>
