<?php

namespace Tests\Unit;

use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SiteSettingTest extends TestCase
{
    use RefreshDatabase;

    // Happy: get returns existing value
    public function test_get_returns_value_for_existing_key(): void
    {
        SiteSetting::create(['key' => 'phone_number', 'value' => '+965 1234 5678', 'group' => 'contact']);

        $this->assertSame('+965 1234 5678', SiteSetting::get('phone_number'));
    }

    // Happy: get returns default when key missing
    public function test_get_returns_default_when_key_does_not_exist(): void
    {
        $this->assertSame('fallback', SiteSetting::get('nonexistent_key', 'fallback'));
    }

    // Happy: get returns null default by default
    public function test_get_returns_null_by_default_when_key_missing(): void
    {
        $this->assertNull(SiteSetting::get('nonexistent_key'));
    }

    // Happy: set creates new record
    public function test_set_creates_new_setting(): void
    {
        SiteSetting::set('new_key', 'new_value');

        $this->assertDatabaseHas('site_settings', ['key' => 'new_key', 'value' => 'new_value']);
    }

    // Happy: set updates existing record
    public function test_set_updates_existing_setting(): void
    {
        SiteSetting::create(['key' => 'site_name_en', 'value' => 'Old Name', 'group' => 'seo']);

        SiteSetting::set('site_name_en', 'New Name');

        $this->assertSame('New Name', SiteSetting::get('site_name_en'));
        $this->assertDatabaseCount('site_settings', 1);
    }

    // Unhappy: duplicate key constraint — only one row per key
    public function test_set_does_not_create_duplicate_keys(): void
    {
        SiteSetting::set('dupe_key', 'first');
        SiteSetting::set('dupe_key', 'second');

        $this->assertDatabaseCount('site_settings', 1);
        $this->assertSame('second', SiteSetting::get('dupe_key'));
    }
}
