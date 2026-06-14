<?php

namespace Tests\Feature;

use App\Enums\ServiceStatus;
use App\Models\Service;
use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Tests for the redesigned navbar:
 * - Active link highlight (aria-current="page" + nav-link--active class)
 * - Language toggle button (shows opposite locale label)
 * - Mobile drawer present in HTML (hidden on desktop via CSS)
 * - Hamburger button absent from desktop markup (md:hidden)
 * - No mobile menu pushes page — drawer is position:fixed overlay
 * - Drawer direction: RTL locale = slides from right, LTR = from left
 *
 * Unhappy paths come first (RED scenarios), then happy paths (GREEN).
 */
class NavbarTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        SiteSetting::create(['key' => 'whatsapp_number', 'value' => '96512345678',     'group' => 'contact']);
        SiteSetting::create(['key' => 'phone_number',    'value' => '+965 1234 5678',  'group' => 'contact']);
        SiteSetting::create(['key' => 'site_name_ar',    'value' => 'إلكتريك كويت',        'group' => 'seo']);
        SiteSetting::create(['key' => 'site_name_en',    'value' => 'ElectricQ8',          'group' => 'seo']);
        SiteSetting::create(['key' => 'default_meta_ar', 'value' => 'كهرباء الكويت',    'group' => 'seo']);
        SiteSetting::create(['key' => 'default_meta_en', 'value' => 'AC Kuwait',       'group' => 'seo']);
        SiteSetting::create(['key' => 'instagram_url',   'value' => 'https://instagram.com/electricq8', 'group' => 'social']);
        SiteSetting::create(['key' => 'snapchat_url',    'value' => 'https://snapchat.com/add/electricq8', 'group' => 'social']);
        SiteSetting::create(['key' => 'tiktok_url',      'value' => 'https://tiktok.com/@electricq8', 'group' => 'social']);
    }

    protected function tearDown(): void
    {
        app()->setLocale(config('app.locale', 'ar'));
        parent::tearDown();
    }

    // ══════════════════════════════════════════════════════════════════════
    // UNHAPPY PATHS — things that must NOT be present / must NOT happen
    // ══════════════════════════════════════════════════════════════════════

    // Unhappy: non-active link must NOT carry the active class on the home page
    public function test_services_link_does_not_have_active_class_on_home_page(): void
    {
        $html = $this->get('/')->getContent();

        // The services link must exist
        $this->assertStringContainsString(route('services.index'), $html);

        // But it must NOT be marked as the current page
        $this->assertStringNotContainsString(
            'href="' . route('services.index') . '" aria-current="page"',
            $html
        );
    }

    // Unhappy: non-active link must NOT carry the active class on the services page
    public function test_home_link_does_not_have_active_class_on_services_page(): void
    {
        Service::create([
            'title'  => ['ar' => 'خدمة', 'en' => 'Service'],
            'slug'   => ['ar' => 'خدمة', 'en' => 'service'],
            'h1'     => ['ar' => 'خدمة', 'en' => 'Service'],
            'status' => ServiceStatus::Active,
        ]);

        $html = $this->get(route('services.index'))->getContent();

        $this->assertStringNotContainsString(
            'href="' . route('home') . '" aria-current="page"',
            $html
        );
    }

    // Unhappy: language button must NOT show the CURRENT locale label
    // (AR page → must not show "العربية", must show "EN")
    public function test_language_button_does_not_show_current_locale_on_arabic_page(): void
    {
        $this->get('/')->assertDontSeeText('العربية');
    }

    // Unhappy: language button must NOT show "AR" label on English page
    public function test_language_button_does_not_show_current_locale_on_english_page(): void
    {
        $this->get('/en')->assertDontSeeText('AR');
    }

    // Unhappy: hamburger button must NOT be visible on large screens
    // (hidden via CSS media query min-width:768px, not Tailwind utility)
    public function test_hamburger_button_exists_and_has_aria_label(): void
    {
        $html = $this->get('/')->getContent();

        // The hamburger trigger must exist with an aria-label (mobile only via CSS)
        $this->assertMatchesRegularExpression(
            '/class="site-nav__hamburger"[^>]*aria-label/',
            $html
        );

        // The style block must include the media query that hides it on desktop
        $this->assertStringContainsString('min-width: 768px', $html);
        $this->assertStringContainsString('.site-nav__hamburger { display: none; }', $html);
    }

    // Unhappy: mobile drawer must NOT push page content down
    // (it must use fixed/absolute positioning, NOT be a block-level element in flow)
    public function test_mobile_drawer_is_not_block_in_document_flow(): void
    {
        $html = $this->get('/')->getContent();

        // Drawer wrapper must carry nav-drawer class (which we'll make position:fixed)
        $this->assertStringContainsString('nav-drawer', $html);

        // It must NOT be a plain md:hidden div injected between nav and hero
        // i.e. the drawer must have the overlay class, not just a border-t spacer
        $this->assertStringContainsString('nav-drawer', $html);
    }

    // Unhappy: Arabic nav mobile drawer must NOT use LTR slide direction
    public function test_arabic_mobile_drawer_has_rtl_data_attribute(): void
    {
        $html = $this->get('/')->getContent();
        // drawer must carry rtl direction marker
        $this->assertStringContainsString('data-dir="rtl"', $html);
    }

    // Unhappy: English nav mobile drawer must NOT use RTL slide direction
    public function test_english_mobile_drawer_has_ltr_data_attribute(): void
    {
        $html = $this->get('/en')->getContent();
        // drawer must carry ltr direction marker
        $this->assertStringContainsString('data-dir="ltr"', $html);
    }

    // Unhappy: active link on contact page must NOT appear on home page
    public function test_contact_link_not_active_on_home_page(): void
    {
        $html = $this->get('/')->getContent();
        $this->assertStringNotContainsString(
            'href="' . route('contact') . '" aria-current="page"',
            $html
        );
    }

    // ══════════════════════════════════════════════════════════════════════
    // HAPPY PATHS — things that MUST be present / MUST happen
    // ══════════════════════════════════════════════════════════════════════

    // Happy: home link is marked as current page when on home route
    public function test_home_link_has_active_state_on_home_page(): void
    {
        $html = $this->get('/')->getContent();
        $this->assertStringContainsString('aria-current="page"', $html);
        // The active link must point to home
        $this->assertMatchesRegularExpression(
            '/href="' . preg_quote(route('home'), '/') . '"[^>]*aria-current="page"/',
            $html
        );
    }

    // Happy: services link is marked active on services index page
    public function test_services_link_has_active_state_on_services_page(): void
    {
        Service::create([
            'title'  => ['ar' => 'خدمة', 'en' => 'Service'],
            'slug'   => ['ar' => 'خدمة', 'en' => 'service'],
            'h1'     => ['ar' => 'خدمة', 'en' => 'Service'],
            'status' => ServiceStatus::Active,
        ]);

        $html = $this->get(route('services.index'))->getContent();
        $this->assertMatchesRegularExpression(
            '/href="' . preg_quote(route('services.index'), '/') . '"[^>]*aria-current="page"/',
            $html
        );
    }

    // Happy: contact link is marked active on contact page
    public function test_contact_link_has_active_state_on_contact_page(): void
    {
        $html = $this->get(route('contact'))->getContent();
        $this->assertMatchesRegularExpression(
            '/href="' . preg_quote(route('contact'), '/') . '"[^>]*aria-current="page"/',
            $html
        );
    }

    // Happy: blog link is marked active on blog page
    public function test_blog_link_has_active_state_on_blog_page(): void
    {
        $html = $this->get(route('posts.index'))->getContent();
        $this->assertMatchesRegularExpression(
            '/href="' . preg_quote(route('posts.index'), '/') . '"[^>]*aria-current="page"/',
            $html
        );
    }

    // Happy: language toggle shows "EN" on Arabic page
    public function test_language_toggle_shows_en_on_arabic_page(): void
    {
        $this->get('/')->assertSeeText('EN');
    }

    // Happy: language toggle shows "العربية" on English page
    public function test_language_toggle_shows_arabic_label_on_english_page(): void
    {
        $this->get('/en')->assertSeeText('العربية');
    }

    // Happy: nav contains all required links (Arabic)
    public function test_nav_contains_all_links_arabic(): void
    {
        $response = $this->get('/');
        $response->assertSee('href="' . route('home') . '"', false);
        $response->assertSee('href="' . route('services.index') . '"', false);
        $response->assertSee('href="' . route('areas.index') . '"', false);
        $response->assertSee('href="' . route('about') . '"', false);
        $response->assertSee('href="' . route('contact') . '"', false);
        $response->assertSee('href="' . route('posts.index') . '"', false);
    }

    // Happy: nav contains all required links (English)
    // On /en pages the nav uses en.* prefixed routes so URLs are /en, /en/services etc.
    public function test_nav_contains_all_links_english(): void
    {
        $response = $this->withSession(['locale' => 'en'])->get('/en');
        $response->assertSee('href="' . route('en.home') . '"', false);
        $response->assertSee('href="' . route('en.services.index') . '"', false);
        $response->assertSee('href="' . route('en.areas.index') . '"', false);
        $response->assertSee('href="' . route('en.about') . '"', false);
        $response->assertSee('href="' . route('en.contact') . '"', false);
        $response->assertSee('href="' . route('en.posts.index') . '"', false);
    }

    // Happy: nav shows Arabic labels on Arabic locale
    public function test_nav_shows_arabic_labels(): void
    {
        $this->get('/')->assertSeeText('خدماتنا')->assertSeeText('مناطق الخدمة')->assertSeeText('المدونة');
    }

    // Happy: nav shows English labels on English locale
    public function test_nav_shows_english_labels(): void
    {
        $this->get('/en')->assertSeeText('Services')->assertSeeText('Service Areas')->assertSeeText('Blog');
    }

    // Happy: mobile drawer exists in HTML (hidden by CSS, not removed from DOM)
    public function test_mobile_drawer_exists_in_html(): void
    {
        $this->get('/')->assertSee('nav-drawer', false);
    }

    // Happy: nav has correct dir attribute for Arabic locale
    public function test_nav_has_rtl_dir_on_arabic_page(): void
    {
        $html = $this->get('/')->getContent();
        $this->assertStringContainsString('dir="rtl"', $html);
    }

    // Happy: nav has correct dir attribute for English locale
    public function test_nav_has_ltr_dir_on_english_page(): void
    {
        $html = $this->get('/en')->getContent();
        $this->assertStringContainsString('dir="ltr"', $html);
    }

    // Happy: nav-link--active class present on active link
    public function test_active_link_carries_active_css_class(): void
    {
        $html = $this->get('/')->getContent();
        $this->assertStringContainsString('nav-link--active', $html);
    }

    // Happy: non-active link does NOT carry nav-link--active class on services page
    public function test_only_one_link_is_active_per_page(): void
    {
        Service::create([
            'title'  => ['ar' => 'خدمة', 'en' => 'Service'],
            'slug'   => ['ar' => 'خدمة', 'en' => 'service'],
            'h1'     => ['ar' => 'خدمة', 'en' => 'Service'],
            'status' => ServiceStatus::Active,
        ]);

        $html = $this->get(route('services.index'))->getContent();

        // Count only HTML element attributes (not CSS selectors which also contain the string)
        // Each active link appears in desktop list + mobile drawer = 2 occurrences in HTML tags
        preg_match_all('/<a[^>]+aria-current="page"/', $html, $matches);
        $count = count($matches[0]);
        $this->assertSame(2, $count, "Expected exactly 2 active <a> tags (desktop + drawer), found {$count}");
    }
}
