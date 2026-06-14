<?php

namespace Tests\Unit;

use App\Helpers\WhatsAppHelper;
use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WhatsAppHelperTest extends TestCase
{
    use RefreshDatabase;

    // Happy: returns URL with stored number and default message
    public function test_url_returns_whatsapp_link_with_number_and_default_arabic_message(): void
    {
        SiteSetting::create(['key' => 'whatsapp_number', 'value' => '96512345678', 'group' => 'contact']);

        app()->setLocale('ar');
        $url = WhatsAppHelper::url();

        $this->assertStringStartsWith('https://wa.me/96512345678', $url);
        $this->assertStringContainsString('text=', $url);
        $this->assertStringContainsString(urlencode('مرحباً'), $url);
    }

    // Happy: English locale uses English default message
    public function test_url_uses_english_default_message_for_en_locale(): void
    {
        SiteSetting::create(['key' => 'whatsapp_number', 'value' => '96512345678', 'group' => 'contact']);

        app()->setLocale('en');
        $url = WhatsAppHelper::url();

        $this->assertStringContainsString(urlencode('Hello'), $url);
    }

    // Happy: custom message overrides default
    public function test_url_uses_custom_message_when_provided(): void
    {
        SiteSetting::create(['key' => 'whatsapp_number', 'value' => '96512345678', 'group' => 'contact']);

        $url = WhatsAppHelper::url('I need electrical repair');

        $this->assertStringContainsString(urlencode('I need electrical repair'), $url);
    }

    // Unhappy: no whatsapp number stored returns URL with null in number position
    public function test_url_returns_url_with_null_when_no_number_stored(): void
    {
        app()->setLocale('ar');
        $url = WhatsAppHelper::url();

        $this->assertStringStartsWith('https://wa.me/', $url);
    }
}
