<?php

namespace App\Helpers;

use App\Models\SiteSetting;

class WhatsAppHelper
{
    public static function url(string $message = ''): string
    {
        $number  = SiteSetting::get('whatsapp_number');
        $default = app()->getLocale() === 'ar'
            ? 'مرحباً، أريد الاستفسار عن خدمات الكهرباء'
            : 'Hello, I need electrical service assistance';

        return 'https://wa.me/' . $number . '?text=' . urlencode($message ?: $default);
    }
}
