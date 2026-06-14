<?php

return [
    'ga4_measurement_id' => env('GA4_MEASUREMENT_ID'),
    'ga4_api_secret'     => env('GA4_API_SECRET'),
    'ga4_debug_mode'     => (bool) env('GA4_DEBUG_MODE', false),
    'display_timezone'   => env('ANALYTICS_DISPLAY_TIMEZONE', env('APP_TIMEZONE', 'UTC')),

    'visitor_cookie_name'        => env('ANALYTICS_VISITOR_COOKIE', '_vid'),
    'visitor_cookie_ttl_minutes' => (int) env('ANALYTICS_VISITOR_COOKIE_TTL', 60 * 24 * 365),

    'session_storage_key' => env('ANALYTICS_SESSION_STORAGE_KEY', '_sid'),
    'session_ttl_minutes' => (int) env('ANALYTICS_SESSION_TTL', 30),

    /*
    |--------------------------------------------------------------------------
    | Allowed locales for the collect endpoint validation.
    | Extend this list if your site supports more than Arabic and English.
    |--------------------------------------------------------------------------
    */
    'allowed_locales' => ['en', 'ar'],

    'geolocation' => [
        'enabled'                    => (bool) env('ANALYTICS_GEOLOCATION_ENABLED', true),
        'endpoint'                   => env('ANALYTICS_GEOLOCATION_ENDPOINT', 'https://ipwho.is'),
        'timeout_seconds'            => (int) env('ANALYTICS_GEOLOCATION_TIMEOUT', 3),
        'cache_minutes'              => (int) env('ANALYTICS_GEOLOCATION_CACHE_MINUTES', 1440),
        'local_fallback_enabled'     => (bool) env('ANALYTICS_GEOLOCATION_LOCAL_FALLBACK_ENABLED', false),
        'local_fallback_country'     => env('ANALYTICS_GEOLOCATION_LOCAL_FALLBACK_COUNTRY', 'Kuwait'),
        'local_fallback_governorate' => env('ANALYTICS_GEOLOCATION_LOCAL_FALLBACK_GOVERNORATE', 'Hawalli'),
    ],

    'collect' => [
        'enabled' => (bool) env('ANALYTICS_COLLECT_ENABLED', true),

        /*
        |----------------------------------------------------------------------
        | Paths that should never be tracked. Any request whose `path` field
        | starts with one of these prefixes will be silently ignored.
        | Add '/admin' to suppress tracking on all admin pages.
        |----------------------------------------------------------------------
        */
        'excluded_paths' => [
            '/admin',
        ],

        /*
        |----------------------------------------------------------------------
        | Add or remove event names your site fires.
        | Any event_name not in this list will be rejected by the collect endpoint.
        |----------------------------------------------------------------------
        */
        'allowed_events' => [
            'page_view',
            'whatsapp_click',
            'phone_click',
            'contact_form_submit',
            'cta_click',
            'service_view',
            'post_view',
            'tag_view',
            'social_click',
            'share_click',
            'locale_switch',
            'scroll_depth',
            'admin_login',
            'writer_login',
            'post_created',
            'post_updated',
            'post_published',
            'post_preview_created',
            'post_preview_opened',
            'category_created',
            'category_updated',
            'category_deleted',
            'tag_created',
            'tag_updated',
            'tag_deleted',
            'gallery_uploaded',
            'gallery_updated',
            'gallery_deleted',
            'settings_updated',
        ],

        'throttle' => [
            'max_attempts'  => (int) env('ANALYTICS_COLLECT_THROTTLE_MAX_ATTEMPTS', 30),
            'decay_seconds' => (int) env('ANALYTICS_COLLECT_THROTTLE_DECAY_SECONDS', 60),
        ],

        'bot_signatures' => [
            'bot',
            'crawl',
            'crawler',
            'spider',
            'slurp',
            'facebookexternalhit',
            'whatsapp',
            'telegrambot',
            'linkedinbot',
            'headlesschrome',
        ],
    ],
];
