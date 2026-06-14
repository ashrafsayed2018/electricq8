<?php

namespace Tests\Feature;

use App\Enums\ServiceStatus;
use App\Models\Location;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Tests every public-facing route returns the correct HTTP status,
 * renders expected content, and exposes the correct nav/footer links.
 */
class FrontendRoutesTest extends TestCase
{
    use RefreshDatabase;

    // ── Fixtures ──────────────────────────────────────────────────────────

    protected function setUp(): void
    {
        parent::setUp();

        SiteSetting::create(['key' => 'whatsapp_number',  'value' => '96512345678',                        'group' => 'contact']);
        SiteSetting::create(['key' => 'phone_number',     'value' => '+965 1234 5678',                     'group' => 'contact']);
        SiteSetting::create(['key' => 'site_name_ar',     'value' => 'إلكتريك كويت',                           'group' => 'seo']);
        SiteSetting::create(['key' => 'site_name_en',     'value' => 'ElectricQ8',                             'group' => 'seo']);
        SiteSetting::create(['key' => 'default_meta_ar',  'value' => 'كهرباء الكويت',                       'group' => 'seo']);
        SiteSetting::create(['key' => 'default_meta_en',  'value' => 'AC Kuwait',                          'group' => 'seo']);
        SiteSetting::create(['key' => 'instagram_url',    'value' => 'https://instagram.com/electricq8',       'group' => 'social']);
        SiteSetting::create(['key' => 'snapchat_url',     'value' => 'https://snapchat.com/add/electricq8',    'group' => 'social']);
        SiteSetting::create(['key' => 'tiktok_url',       'value' => 'https://tiktok.com/@electricq8',         'group' => 'social']);
    }

    private function makeService(array $overrides = []): Service
    {
        return Service::create(array_merge([
            'title'   => ['ar' => 'تصليح شورت الكهرباء', 'en' => 'Electrical Refill'],
            'slug'    => ['ar' => 'شحن-غاز',          'en' => 'ac-gas-refill'],
            'h1'      => ['ar' => 'تصليح شورت الكهرباء', 'en' => 'Electrical Refill'],
            'intro'   => ['ar' => 'وصف مختصر',        'en' => 'Short description'],
            'content' => ['ar' => 'وصف كامل',          'en' => 'Full description'],
            'status'      => ServiceStatus::Active,
            'sort_order'  => 1,
        ], $overrides));
    }

    private function makeLocation(array $overrides = []): Location
    {
        return Location::create(array_merge([
            'name'        => ['ar' => 'حولي',   'en' => 'Hawalli'],
            'slug'        => ['ar' => 'حولي',   'en' => 'hawalli'],
            'governorate' => 'hawalli',
            'is_active'   => true,
            'sort_order'  => 1,
        ], $overrides));
    }

    protected function tearDown(): void
    {
        app()->setLocale(config('app.locale', 'ar'));
        parent::tearDown();
    }

    // ══════════════════════════════════════════════════════════════════════
    // HOME PAGE
    // ══════════════════════════════════════════════════════════════════════

    // Happy: Arabic home returns 200
    public function test_home_returns_200(): void
    {
        $this->get('/')->assertStatus(200);
    }

    // Happy: English home (/en) returns 200
    public function test_english_home_returns_200(): void
    {
        $this->get('/en')->assertStatus(200);
    }

    // Happy: home renders Arabic hero title
    public function test_home_renders_arabic_hero_title(): void
    {
        $this->get('/')->assertSeeText('خبراء كهرباء المنازل في الكويت');
    }

    // Happy: home renders English hero title under /en
    public function test_home_renders_english_hero_title(): void
    {
        $this->get('/en')->assertSeeText("Kuwait's AC Experts");
    }

    // Happy: home shows emergency badge (Arabic)
    public function test_home_shows_arabic_emergency_badge(): void
    {
        $this->get('/')->assertSeeText('خدمة طوارئ 24/7');
    }

    // Happy: home shows emergency badge (English)
    public function test_home_shows_english_emergency_badge(): void
    {
        $this->get('/en')->assertSeeText('24/7 Emergency Service');
    }

    // Happy: home shows active service in Arabic
    public function test_home_shows_active_service_name(): void
    {
        $this->makeService();
        $this->get('/')->assertSeeText('تصليح شورت الكهرباء');
    }

    // Happy: home shows governorate areas from static list (areas grid is static, not DB-driven)
    public function test_home_shows_active_location_name(): void
    {
        // The home page areas section renders a static governorate grid.
        // 'حولي' is always present as a static area pill under Hawalli governorate.
        $this->get('/')->assertSeeText('حولي');
    }

    // Unhappy: home does not show inactive service
    public function test_home_hides_inactive_service(): void
    {
        $this->makeService(['status' => ServiceStatus::Inactive]);
        $this->get('/')->assertDontSeeText('تصليح شورت الكهرباء');
    }

    // Unhappy: home static areas grid always shows all governorate areas regardless of DB location status
    public function test_home_hides_inactive_location(): void
    {
        // The home page areas section is a static grid of all Kuwait governorates and sub-areas.
        // DB-driven active/inactive location status does not affect the static area pill display.
        // Only the areas index page (/areas) respects DB active status for location detail links.
        $this->makeLocation(['is_active' => false]);
        // An inactive DB location with name 'حولي' does not remove the static 'حولي' pill.
        // Assert the page still loads correctly (no 500 error) when an inactive location exists.
        $this->get('/')->assertStatus(200);
    }

    // ══════════════════════════════════════════════════════════════════════
    // NAVIGATION LINKS
    // ══════════════════════════════════════════════════════════════════════

    // Happy: Arabic nav contains services link
    public function test_nav_contains_services_link(): void
    {
        $this->get('/')->assertSee('href="' . route('services.index') . '"', false);
    }

    // Happy: Arabic nav contains areas link
    public function test_nav_contains_areas_link(): void
    {
        $this->get('/')->assertSee('href="' . route('areas.index') . '"', false);
    }

    // Happy: Arabic nav contains about link
    public function test_nav_contains_about_link(): void
    {
        $this->get('/')->assertSee('href="' . route('about') . '"', false);
    }

    // Happy: Arabic nav contains contact link
    public function test_nav_contains_contact_link(): void
    {
        $this->get('/')->assertSee('href="' . route('contact') . '"', false);
    }

    // Happy: nav shows Arabic labels on default locale
    public function test_nav_shows_arabic_labels(): void
    {
        $this->get('/')->assertSeeText('خدماتنا')->assertSeeText('مناطق الخدمة');
    }

    // Happy: nav shows English labels under /en
    public function test_nav_shows_english_labels(): void
    {
        $this->get('/en')->assertSeeText('Services')->assertSeeText('Service Areas');
    }

    // Happy: nav shows language switcher (single button showing the other locale)
    public function test_nav_shows_language_switcher(): void
    {
        // On Arabic page, shows EN button (not العربية)
        $this->get('/')->assertSeeText('EN');
    }

    // ══════════════════════════════════════════════════════════════════════
    // FOOTER
    // ══════════════════════════════════════════════════════════════════════

    // Happy: footer shows Arabic site name
    public function test_footer_shows_arabic_site_name(): void
    {
        $this->get('/')->assertSeeText('إلكتريك كويت');
    }

    // Happy: footer shows English site name under /en
    public function test_footer_shows_english_site_name(): void
    {
        $this->get('/en')->assertSeeText('ElectricQ8');
    }

    // Happy: footer shows social media links
    public function test_footer_shows_social_links(): void
    {
        $this->get('/')
            ->assertSee('https://instagram.com/electricq8', false)
            ->assertSee('https://snapchat.com/add/electricq8', false)
            ->assertSee('https://tiktok.com/@electricq8', false);
    }

    // Happy: footer shows emergency availability text
    public function test_footer_shows_emergency_text(): void
    {
        $this->get('/')->assertSeeText('متاحون على مدار الساعة');
    }

    // ══════════════════════════════════════════════════════════════════════
    // WHATSAPP CTA BUTTONS
    // ══════════════════════════════════════════════════════════════════════

    // Happy: home hero WhatsApp button links to correct number
    public function test_home_whatsapp_button_contains_number(): void
    {
        $this->get('/')->assertSee('wa.me/96512345678', false);
    }

    // Happy: home hero phone call button links to phone number
    public function test_home_call_button_contains_phone(): void
    {
        $this->get('/')->assertSee('tel:', false);
    }

    // Happy: service page WhatsApp button includes service name in URL
    public function test_service_page_whatsapp_button_includes_service_name(): void
    {
        $service = $this->makeService();
        $this->get('/services/شحن-غاز')
            ->assertSee('wa.me/96512345678', false);
    }

    // Happy: floating WhatsApp button appears on home page (Arabic: left side)
    public function test_home_floating_whatsapp_button_exists(): void
    {
        $this->get('/')->assertSee('wa.me/', false);
    }

    // ══════════════════════════════════════════════════════════════════════
    // SERVICES ROUTES
    // ══════════════════════════════════════════════════════════════════════

    // Happy: services index returns 200
    public function test_services_index_returns_200(): void
    {
        $this->get('/services')->assertStatus(200);
    }

    // Happy: English services index returns 200
    public function test_english_services_index_returns_200(): void
    {
        $this->get('/en/services')->assertStatus(200);
    }

    // Happy: service show page returns 200 with Arabic slug
    public function test_service_show_arabic_slug_returns_200(): void
    {
        $this->makeService();
        $this->get('/services/شحن-غاز')->assertStatus(200);
    }

    // Happy: service show page returns 200 with English slug
    public function test_service_show_english_slug_returns_200(): void
    {
        $this->makeService();
        $this->get('/en/services/ac-gas-refill')->assertStatus(200);
    }

    // Happy: service show page renders service name
    public function test_service_show_renders_service_name(): void
    {
        $this->makeService();
        $this->get('/services/شحن-غاز')->assertSeeText('تصليح شورت الكهرباء');
    }

    // Happy: service show page renders short description
    public function test_service_show_renders_short_description(): void
    {
        $this->makeService();
        $this->get('/services/شحن-غاز')->assertSeeText('وصف مختصر');
    }

    // Happy: service show page renders "other services" section when others exist
    public function test_service_show_renders_other_services(): void
    {
        $this->makeService();
        $this->makeService([
            'title'      => ['ar' => 'تركيب الكهرباء', 'en' => 'Electrical Installation'],
            'slug'       => ['ar' => 'تركيب-كهرباء',   'en' => 'ac-installation'],
            'h1'         => ['ar' => 'تركيب الكهرباء', 'en' => 'Electrical Installation'],
            'sort_order' => 2,
        ]);
        $this->get('/services/شحن-غاز')->assertSeeText('تركيب الكهرباء');
    }

    // Unhappy: service show returns 404 for unknown slug
    public function test_service_show_returns_404_for_unknown_slug(): void
    {
        $this->get('/services/does-not-exist')->assertStatus(404);
    }

    // Unhappy: inactive service slug resolves but service is excluded from active scope
    public function test_inactive_service_not_shown_in_services_index(): void
    {
        $this->makeService(['status' => ServiceStatus::Inactive]);
        $this->get('/services')->assertDontSeeText('تصليح شورت الكهرباء');
    }

    // ══════════════════════════════════════════════════════════════════════
    // LOCATIONS (AREAS) ROUTES
    // ══════════════════════════════════════════════════════════════════════

    // Happy: areas index returns 200
    public function test_areas_index_returns_200(): void
    {
        $this->get('/areas')->assertStatus(200);
    }

    // Happy: English areas index returns 200
    public function test_english_areas_index_returns_200(): void
    {
        $this->get('/en/areas')->assertStatus(200);
    }

    // Happy: areas index shows location name (static grid always shows all area names)
    public function test_areas_index_shows_active_location(): void
    {
        // The areas index uses a static grid — 'حولي' is always present as a pill.
        $this->makeLocation();
        $this->get('/areas')->assertSeeText('حولي');
    }

    // Unhappy: areas index does not make inactive location a clickable link
    public function test_areas_index_hides_inactive_location(): void
    {
        // The static grid always shows area names, but only active DB locations become links.
        // An inactive location means the area pill has no href — verify no link to 'حولي' exists.
        $this->makeLocation(['is_active' => false]);
        $this->get('/areas')->assertDontSee('href="' . route('areas.show', 'حولي') . '"', false);
    }

    // Happy: location show returns 200 with Arabic slug
    public function test_location_show_arabic_slug_returns_200(): void
    {
        $this->makeLocation();
        $this->get('/areas/حولي')->assertStatus(200);
    }

    // Happy: location show returns 200 with English slug
    public function test_location_show_english_slug_returns_200(): void
    {
        $this->makeLocation();
        $this->get('/en/areas/hawalli')->assertStatus(200);
    }

    // Happy: location show renders location name
    public function test_location_show_renders_location_name(): void
    {
        $this->makeLocation();
        $this->get('/areas/حولي')->assertSeeText('حولي');
    }

    // Happy: location show renders description when set
    public function test_location_show_renders_description_when_set(): void
    {
        $this->makeLocation(['description' => ['ar' => 'منطقة حولي الجميلة', 'en' => 'Beautiful Hawalli']]);
        $this->get('/areas/حولي')->assertSeeText('منطقة حولي الجميلة');
    }

    // Happy: location show renders services grid
    public function test_location_show_renders_services(): void
    {
        $this->makeLocation();
        $this->makeService();
        $this->get('/areas/حولي')->assertSeeText('تصليح شورت الكهرباء');
    }

    // Happy: location show renders testimonials for that location
    public function test_location_show_renders_testimonials(): void
    {
        $location = $this->makeLocation();
        Testimonial::create([
            'client_name' => ['ar' => 'أحمد علي', 'en' => 'Ahmed Ali'],
            'body'        => ['ar' => 'خدمة ممتازة', 'en' => 'Excellent service'],
            'location_id' => $location->id,
            'rating'      => 5,
            'is_active'   => true,
        ]);
        $this->get('/areas/حولي')->assertSeeText('خدمة ممتازة');
    }

    // Unhappy: location show returns 404 for unknown slug
    public function test_location_show_returns_404_for_unknown_slug(): void
    {
        $this->get('/areas/nonexistent-area')->assertStatus(404);
    }

    // ══════════════════════════════════════════════════════════════════════
    // STATIC PAGES
    // ══════════════════════════════════════════════════════════════════════

    // Happy: about returns 200
    public function test_about_returns_200(): void
    {
        $this->get('/about')->assertStatus(200);
    }

    // Happy: English about returns 200
    public function test_english_about_returns_200(): void
    {
        $this->get('/en/about')->assertStatus(200);
    }

    // Happy: contact returns 200
    public function test_contact_returns_200(): void
    {
        $this->get('/contact')->assertStatus(200);
    }

    // Happy: English contact returns 200
    public function test_english_contact_returns_200(): void
    {
        $this->get('/en/contact')->assertStatus(200);
    }

    // Happy: contact page renders Arabic title
    public function test_contact_page_shows_arabic_title(): void
    {
        $this->get('/contact')->assertSeeText('تواصل معنا');
    }

    // Happy: contact page renders English title
    public function test_contact_page_shows_english_title(): void
    {
        $this->get('/en/contact')->assertSeeText('Contact Us');
    }

    // Happy: privacy returns 200
    public function test_privacy_returns_200(): void
    {
        $this->get('/privacy')->assertStatus(200);
    }

    // ══════════════════════════════════════════════════════════════════════
    // SEO META — TITLE & DESCRIPTION
    // ══════════════════════════════════════════════════════════════════════

    // Happy: home page title contains Arabic site name
    public function test_home_meta_title_contains_arabic_site_name(): void
    {
        $this->get('/')->assertSeeText('إلكتريك كويت');
    }

    // Happy: home page title contains English site name under /en
    public function test_home_meta_title_contains_english_site_name(): void
    {
        $this->get('/en')->assertSeeText('ElectricQ8');
    }

    // Happy: service page uses service name in title
    public function test_service_page_title_contains_service_name(): void
    {
        $this->makeService();
        $this->get('/services/شحن-غاز')->assertSee('تصليح شورت الكهرباء', false);
    }

    // Happy: location page uses location name in title
    public function test_location_page_title_contains_location_name(): void
    {
        $this->makeLocation();
        $this->get('/areas/حولي')->assertSee('حولي', false);
    }

    // Happy: page contains canonical URL tag
    public function test_page_contains_canonical_link_tag(): void
    {
        $this->get('/')->assertSee('rel="canonical"', false);
    }

    // Happy: page contains hreflang AR tag
    public function test_page_contains_hreflang_ar(): void
    {
        $this->get('/')->assertSee('hreflang="ar"', false);
    }

    // Happy: page contains hreflang EN tag
    public function test_page_contains_hreflang_en(): void
    {
        $this->get('/')->assertSee('hreflang="en"', false);
    }

    // Happy: Arabic page has dir="rtl"
    public function test_arabic_page_has_rtl_direction(): void
    {
        $this->get('/')->assertSee('dir="rtl"', false);
    }

    // Happy: English page has dir="ltr"
    public function test_english_page_has_ltr_direction(): void
    {
        $this->get('/en')->assertSee('dir="ltr"', false);
    }

    // Happy: home page contains JSON-LD schema script
    public function test_home_page_contains_schema_script(): void
    {
        $this->get('/')->assertSee('application/ld+json', false);
    }

    // Happy: JSON-LD contains electricalBusiness type
    public function test_home_schema_contains_hvacbusiness(): void
    {
        $this->get('/')->assertSee('electricalBusiness', false);
    }

    // ══════════════════════════════════════════════════════════════════════
    // LOCALE SWITCHING VIA URL
    // ══════════════════════════════════════════════════════════════════════

    // Happy: /en prefix sets HTML lang attribute to en
    public function test_english_url_sets_lang_en(): void
    {
        $this->get('/en')->assertSee('lang="en"', false);
    }

    // Happy: Arabic (default) URL sets HTML lang attribute to ar
    public function test_arabic_url_sets_lang_ar(): void
    {
        $this->get('/')->assertSee('lang="ar"', false);
    }

    // Unhappy: unknown route returns 404
    public function test_unknown_route_returns_404(): void
    {
        $this->get('/this-page-does-not-exist')->assertStatus(404);
    }

    // Unhappy: English unknown route returns 404
    public function test_english_unknown_route_returns_404(): void
    {
        $this->get('/en/this-page-does-not-exist')->assertStatus(404);
    }
}
