<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Tests for SEO meta tags added to layouts/app.blade.php:
 * robots, theme-color, OG image dimensions, og:url,
 * Twitter Card, favicon, sitemap link, and home schema improvements.
 */
class SeoLayoutTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        SiteSetting::create(['key' => 'whatsapp_number', 'value' => '96512345678', 'group' => 'contact']);
        SiteSetting::create(['key' => 'phone_number',    'value' => '+965 1234 5678', 'group' => 'contact']);
        SiteSetting::create(['key' => 'site_name_ar',    'value' => 'إلكتريك كويت',       'group' => 'seo']);
        SiteSetting::create(['key' => 'site_name_en',    'value' => 'ElectricQ8',         'group' => 'seo']);
        SiteSetting::create(['key' => 'default_meta_ar', 'value' => 'كهرباء الكويت',   'group' => 'seo']);
        SiteSetting::create(['key' => 'default_meta_en', 'value' => 'AC Kuwait',      'group' => 'seo']);
        SiteSetting::create(['key' => 'instagram_url',   'value' => 'https://instagram.com/electricq8', 'group' => 'social']);
        SiteSetting::create(['key' => 'snapchat_url',    'value' => 'https://snapchat.com/add/electricq8', 'group' => 'social']);
        SiteSetting::create(['key' => 'tiktok_url',      'value' => 'https://tiktok.com/@electricq8', 'group' => 'social']);
    }

    // ══════════════════════════════════════════════════════
    // robots meta
    // ══════════════════════════════════════════════════════

    // Unhappy: page was missing robots meta before — now it must be present
    public function test_page_has_robots_meta_tag(): void
    {
        $this->get('/')->assertSee('name="robots"', false);
    }

    // Happy: robots content is index, follow
    public function test_robots_meta_content_is_index_follow(): void
    {
        $this->get('/')
            ->assertSee('content="index, follow"', false);
    }

    // ══════════════════════════════════════════════════════
    // theme-color
    // ══════════════════════════════════════════════════════

    // Unhappy: theme-color was missing before
    public function test_page_has_theme_color_meta(): void
    {
        $this->get('/')->assertSee('name="theme-color"', false);
    }

    // Happy: theme-color value is brand blue
    public function test_theme_color_is_brand_blue(): void
    {
        $this->get('/')->assertSee('content="#ca8a04"', false);
    }

    // ══════════════════════════════════════════════════════
    // Open Graph — new tags
    // ══════════════════════════════════════════════════════

    // Unhappy: og:image:width was missing before
    public function test_page_has_og_image_width(): void
    {
        $this->get('/')->assertSee('og:image:width', false);
    }

    // Unhappy: og:image:height was missing before
    public function test_page_has_og_image_height(): void
    {
        $this->get('/')->assertSee('og:image:height', false);
    }

    // Happy: og:image:width is 1200
    public function test_og_image_width_is_1200(): void
    {
        $this->get('/')
            ->assertSee('property="og:image:width" content="1200"', false);
    }

    // Happy: og:image:height is 630
    public function test_og_image_height_is_630(): void
    {
        $this->get('/')
            ->assertSee('property="og:image:height" content="630"', false);
    }

    // Unhappy: og:url was missing before
    public function test_page_has_og_url(): void
    {
        $this->get('/')->assertSee('property="og:url"', false);
    }

    // Happy: og:title is populated (not blank)
    public function test_og_title_is_not_blank(): void
    {
        $html = $this->get('/')->content();
        preg_match('/property="og:title"\s+content="([^"]+)"/', $html, $m);
        $this->assertNotEmpty($m[1] ?? '');
    }

    // Happy: og:description is populated (not blank)
    public function test_og_description_is_not_blank(): void
    {
        $html = $this->get('/')->content();
        preg_match('/property="og:description"\s+content="([^"]+)"/', $html, $m);
        $this->assertNotEmpty($m[1] ?? '');
    }

    // Happy: og:locale is ar_KW on Arabic page
    public function test_og_locale_is_ar_kw_on_arabic_page(): void
    {
        $this->get('/')->assertSee('content="ar_KW"', false);
    }

    // Happy: og:locale is en_US on English page
    public function test_og_locale_is_en_us_on_english_page(): void
    {
        $this->get('/en')->assertSee('content="en_US"', false);
    }

    // ══════════════════════════════════════════════════════
    // Twitter Card
    // ══════════════════════════════════════════════════════

    // Unhappy: Twitter Card tags were missing before
    public function test_page_has_twitter_card_meta(): void
    {
        $this->get('/')->assertSee('name="twitter:card"', false);
    }

    // Happy: twitter:card is summary_large_image
    public function test_twitter_card_is_summary_large_image(): void
    {
        $this->get('/')
            ->assertSee('content="summary_large_image"', false);
    }

    // Happy: twitter:title is present and populated
    public function test_twitter_title_is_present(): void
    {
        $this->get('/')->assertSee('name="twitter:title"', false);
    }

    // Happy: twitter:description is present
    public function test_twitter_description_is_present(): void
    {
        $this->get('/')->assertSee('name="twitter:description"', false);
    }

    // Happy: twitter:image is present
    public function test_twitter_image_is_present(): void
    {
        $this->get('/')->assertSee('name="twitter:image"', false);
    }

    // ══════════════════════════════════════════════════════
    // Favicon & apple-touch-icon
    // ══════════════════════════════════════════════════════

    // Unhappy: favicon link was missing before
    public function test_page_has_favicon_link(): void
    {
        $this->get('/')->assertSee('rel="icon"', false);
    }

    // Unhappy: apple-touch-icon was missing before
    public function test_page_has_apple_touch_icon(): void
    {
        $this->get('/')->assertSee('rel="apple-touch-icon"', false);
    }

    // Unhappy: sitemap link was missing before
    public function test_page_has_sitemap_link(): void
    {
        $this->get('/')->assertSee('rel="sitemap"', false);
    }

    // ══════════════════════════════════════════════════════
    // Improved meta title & description
    // ══════════════════════════════════════════════════════

    // Unhappy: old title was just the site name ("إلكتريك كويت"), now must include keyword
    public function test_arabic_page_title_contains_primary_keyword(): void
    {
        $this->get('/')->assertSee('تركيب وإصلاح كهرباء الكويت', false);
    }

    // Unhappy: old English title was short, now must contain keyword
    public function test_english_page_title_contains_primary_keyword(): void
    {
        $this->get('/en')->assertSee('Electrical Installation', false);
    }

    // Happy: Arabic meta description is longer than 80 chars (was 30 before)
    public function test_arabic_meta_description_is_substantive(): void
    {
        $html = $this->get('/')->content();
        preg_match('/name="description"\s+content="([^"]+)"/', $html, $m);
        $this->assertGreaterThan(80, mb_strlen($m[1] ?? ''));
    }

    // Happy: English meta description is longer than 80 chars
    public function test_english_meta_description_is_substantive(): void
    {
        $html = $this->get('/en')->content();
        preg_match('/name="description"\s+content="([^"]+)"/', $html, $m);
        $this->assertGreaterThan(80, mb_strlen($m[1] ?? ''));
    }

    // ══════════════════════════════════════════════════════
    // Home page JSON-LD schema improvements
    // ══════════════════════════════════════════════════════

    // Unhappy: schema only had electricalBusiness before, now must also have LocalBusiness
    public function test_home_schema_includes_local_business_type(): void
    {
        $this->get('/')->assertSee('LocalBusiness', false);
    }

    // Unhappy: schema was missing geo coordinates
    public function test_home_schema_includes_geo_coordinates(): void
    {
        $this->get('/')->assertSee('GeoCoordinates', false);
    }

    // Unhappy: schema was missing priceRange
    public function test_home_schema_includes_price_range(): void
    {
        $this->get('/')->assertSee('priceRange', false);
    }

    // Unhappy: schema was missing url field
    public function test_home_schema_includes_url(): void
    {
        $html = $this->get('/')->content();
        // Extract the ld+json block
        preg_match('/<script type="application\/ld\+json">(.*?)<\/script>/s', $html, $m);
        $schema = json_decode($m[1] ?? '{}', true);
        $this->assertArrayHasKey('url', $schema);
    }

    // Happy: schema telephone is in E.164 format (starts with +965, no spaces)
    public function test_home_schema_telephone_is_e164(): void
    {
        $html = $this->get('/')->content();
        preg_match('/<script type="application\/ld\+json">(.*?)<\/script>/s', $html, $m);
        $schema = json_decode($m[1] ?? '{}', true);
        $this->assertMatchesRegularExpression('/^\+965\d+$/', $schema['telephone'] ?? '');
    }

    // Happy: schema openingHoursSpecification is present
    public function test_home_schema_includes_opening_hours(): void
    {
        $this->get('/')->assertSee('openingHoursSpecification', false);
    }

    // Happy: home page renders without errors (sanity check after schema fixes)
    public function test_home_page_renders_200_with_all_seo_tags(): void
    {
        $this->get('/')->assertStatus(200);
    }
}
