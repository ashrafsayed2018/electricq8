<?php

namespace Tests\Feature;

use App\Enums\ServiceStatus;
use App\Models\Location;
use App\Models\Service;
use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        SiteSetting::create(['key' => 'whatsapp_number',  'value' => '96512345678', 'group' => 'contact']);
        SiteSetting::create(['key' => 'phone_number',      'value' => '+965 1234 5678', 'group' => 'contact']);
        SiteSetting::create(['key' => 'site_name_ar',      'value' => 'إلكتريك كويت', 'group' => 'seo']);
        SiteSetting::create(['key' => 'site_name_en',      'value' => 'ElectricQ8', 'group' => 'seo']);
        SiteSetting::create(['key' => 'default_meta_ar',   'value' => 'كهرباء الكويت', 'group' => 'seo']);
        SiteSetting::create(['key' => 'default_meta_en',   'value' => 'AC Kuwait', 'group' => 'seo']);
        SiteSetting::create(['key' => 'instagram_url',     'value' => 'https://instagram.com/electricq8', 'group' => 'social']);
        SiteSetting::create(['key' => 'snapchat_url',      'value' => 'https://snapchat.com/add/electricq8', 'group' => 'social']);
        SiteSetting::create(['key' => 'tiktok_url',        'value' => 'https://tiktok.com/@electricq8', 'group' => 'social']);
    }

    protected function tearDown(): void
    {
        app()->setLocale(config('app.locale', 'ar'));
        parent::tearDown();
    }

    private function makeService(array $overrides = []): Service
    {
        return Service::create(array_merge([
            'title'   => ['ar' => 'تصليح شورت الكهرباء', 'en' => 'Electrical Refill'],
            'slug'    => ['ar' => 'شحن-غاز', 'en' => 'ac-gas-refill'],
            'h1'      => ['ar' => 'تصليح شورت الكهرباء', 'en' => 'Electrical Refill'],
            'intro'   => ['ar' => 'وصف', 'en' => 'Short description'],
            'content' => ['ar' => 'وصف كامل', 'en' => 'Full description'],
            'status'  => ServiceStatus::Active,
            'sort_order' => 1,
        ], $overrides));
    }

    private function makeLocation(array $overrides = []): Location
    {
        return Location::create(array_merge([
            'name'        => ['ar' => 'حولي', 'en' => 'Hawalli'],
            'slug'        => ['ar' => 'حولي', 'en' => 'hawalli'],
            'governorate' => 'hawalli',
            'is_active'   => true,
            'sort_order'  => 1,
        ], $overrides));
    }

    // Happy: home page loads with 200
    public function test_home_page_returns_200(): void
    {
        $this->get('/')->assertStatus(200);
    }

    // Happy: home page shows hero title in Arabic
    public function test_home_page_shows_arabic_hero_title(): void
    {
        $this->get('/')->assertSeeText('خبراء كهرباء المنازل في الكويت');
    }

    // Happy: home page shows active services (Arabic locale is default)
    public function test_home_page_shows_active_services(): void
    {
        $this->makeService();
        $this->get('/')->assertSeeText('تصليح شورت الكهرباء');
    }

    // Unhappy: home page does NOT show inactive services
    public function test_home_page_hides_inactive_services(): void
    {
        $this->makeService(['status' => ServiceStatus::Inactive]);
        $this->get('/')->assertDontSeeText('تصليح شورت الكهرباء');
    }

    // Happy: services index returns 200
    public function test_services_index_returns_200(): void
    {
        $this->get('/services')->assertStatus(200);
    }

    // Happy: service show returns 200 with valid Arabic slug
    public function test_service_show_returns_200_for_arabic_slug(): void
    {
        $this->makeService();
        $this->get('/services/شحن-غاز')->assertStatus(200);
    }

    // Happy: service show returns 200 with valid English slug under /en
    public function test_service_show_returns_200_for_english_slug(): void
    {
        $this->makeService();
        $this->get('/en/services/ac-gas-refill')->assertStatus(200);
    }

    // Unhappy: service show returns 404 for unknown slug
    public function test_service_show_returns_404_for_unknown_slug(): void
    {
        $this->get('/services/nonexistent-service')->assertStatus(404);
    }

    // Happy: areas index returns 200
    public function test_areas_index_returns_200(): void
    {
        $this->get('/areas')->assertStatus(200);
    }

    // Happy: area show returns 200 with valid Arabic slug
    public function test_area_show_returns_200_for_arabic_slug(): void
    {
        $this->makeLocation();
        $this->get('/areas/حولي')->assertStatus(200);
    }

    // Happy: area show returns 200 for English slug under /en
    public function test_area_show_returns_200_for_english_slug(): void
    {
        $this->makeLocation();
        $this->get('/en/areas/hawalli')->assertStatus(200);
    }

    // Unhappy: area show returns 404 for unknown slug
    public function test_area_show_returns_404_for_unknown_slug(): void
    {
        $this->get('/areas/unknown-area')->assertStatus(404);
    }

    // Happy: about page returns 200
    public function test_about_page_returns_200(): void
    {
        $this->get('/about')->assertStatus(200);
    }

    // Happy: contact page returns 200
    public function test_contact_page_returns_200(): void
    {
        $this->get('/contact')->assertStatus(200);
    }

    // Happy: privacy page returns 200
    public function test_privacy_page_returns_200(): void
    {
        $this->get('/privacy')->assertStatus(200);
    }

    // Happy: /en/ prefix routes return 200
    public function test_english_home_returns_200(): void
    {
        $this->get('/en')->assertStatus(200);
    }

    // Happy: /en/about returns 200
    public function test_english_about_returns_200(): void
    {
        $this->get('/en/about')->assertStatus(200);
    }
}
