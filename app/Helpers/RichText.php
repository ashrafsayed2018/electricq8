<?php

namespace App\Helpers;

class RichText
{
    public static function clean(string $html): string
    {
        // Remove dir="ltr" and dir="rtl" inline attributes injected by TinyMCE
        $html = preg_replace('/\s+dir=["\'](?:ltr|rtl)["\']/i', '', $html);
        // Fix double-encoded entities like &amp;nbsp; → &nbsp;
        $html = preg_replace_callback('/&amp;([a-z]+|#[0-9]+);/i', fn($m) => '&' . $m[1] . ';', $html);
        return $html;
    }
}
