<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SetLocaleMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        SiteSetting::create(['key' => 'whatsapp_number', 'value' => '96512345678', 'group' => 'contact']);
        SiteSetting::create(['key' => 'phone_number',     'value' => '+965 1234 5678', 'group' => 'contact']);
        SiteSetting::create(['key' => 'site_name_ar',     'value' => 'إلكتريك كويت', 'group' => 'seo']);
        SiteSetting::create(['key' => 'site_name_en',     'value' => 'ElectricQ8', 'group' => 'seo']);
        SiteSetting::create(['key' => 'default_meta_ar',  'value' => 'كهرباء', 'group' => 'seo']);
        SiteSetting::create(['key' => 'default_meta_en',  'value' => 'AC', 'group' => 'seo']);
        SiteSetting::create(['key' => 'instagram_url',    'value' => 'https://instagram.com/electricq8', 'group' => 'social']);
        SiteSetting::create(['key' => 'snapchat_url',     'value' => 'https://snapchat.com', 'group' => 'social']);
        SiteSetting::create(['key' => 'tiktok_url',       'value' => 'https://tiktok.com', 'group' => 'social']);
    }

    // Happy: /en prefix sets locale to English
    public function test_en_prefix_sets_locale_to_english(): void
    {
        $this->get('/en');

        $this->assertEquals('en', app()->getLocale());
    }

    // Happy: root / path uses Arabic locale (default)
    public function test_root_path_uses_arabic_locale_by_default(): void
    {
        $this->get('/');

        $this->assertEquals('ar', app()->getLocale());
    }

    // Happy: session locale is remembered — AR session stays AR
    public function test_session_locale_persists_across_requests(): void
    {
        $this->withSession(['locale' => 'en'])->get('/');

        $this->assertEquals('en', app()->getLocale());
    }

    // Happy: /en route sets session locale to en
    public function test_visiting_en_route_saves_locale_in_session(): void
    {
        $response = $this->get('/en');

        $response->assertSessionHas('locale', 'en');
    }

    // Unhappy: invalid locale segment does not override locale — falls back to session/default
    public function test_unknown_locale_segment_falls_back_to_default(): void
    {
        $this->withSession([])->get('/fr');

        // /fr is not a valid locale, so it falls back to config default 'ar'
        $this->assertEquals('ar', app()->getLocale());
    }
}
