<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        SiteSetting::create(['key' => 'whatsapp_number', 'value' => '96512345678', 'group' => 'contact']);
        SiteSetting::create(['key' => 'phone_number',    'value' => '+965 1234 5678', 'group' => 'contact']);
        SiteSetting::create(['key' => 'site_name_ar',    'value' => 'إلكتريك كويت', 'group' => 'seo']);
        SiteSetting::create(['key' => 'site_name_en',    'value' => 'ElectricQ8', 'group' => 'seo']);
        SiteSetting::create(['key' => 'default_meta_ar', 'value' => 'كهرباء الكويت', 'group' => 'seo']);
        SiteSetting::create(['key' => 'default_meta_en', 'value' => 'AC Kuwait', 'group' => 'seo']);
    }

    public function test_the_application_returns_a_successful_response(): void
    {
        $this->get('/')->assertStatus(200);
    }
}
