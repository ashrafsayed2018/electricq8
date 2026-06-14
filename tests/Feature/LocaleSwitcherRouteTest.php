<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocaleSwitcherRouteTest extends TestCase
{
    use RefreshDatabase;

    // ═══════════════════════════════════════════════════════════
    // HAPPY — valid locales are accepted
    // ═══════════════════════════════════════════════════════════

    public function test_switching_to_ar_sets_session_locale(): void
    {
        $this->get(route('locale.switch', 'ar'));

        $this->assertEquals('ar', session('locale'));
    }

    public function test_switching_to_en_sets_session_locale(): void
    {
        $this->get(route('locale.switch', 'en'));

        $this->assertEquals('en', session('locale'));
    }

    public function test_locale_switch_redirects_back(): void
    {
        $this->get(route('locale.switch', 'en'))
            ->assertRedirect();
    }

    public function test_switching_locale_redirects_to_previous_page(): void
    {
        $this->from(route('home'))
            ->get(route('locale.switch', 'en'))
            ->assertRedirect(route('home'));
    }

    // ═══════════════════════════════════════════════════════════
    // UNHAPPY — invalid locales are ignored
    // ═══════════════════════════════════════════════════════════

    public function test_invalid_locale_does_not_update_session(): void
    {
        session(['locale' => 'ar']);

        $this->get(route('locale.switch', 'fr'));

        $this->assertEquals('ar', session('locale'));
    }

    public function test_invalid_locale_still_redirects(): void
    {
        $this->get(route('locale.switch', 'de'))
            ->assertRedirect();
    }

    public function test_switching_locale_does_not_require_authentication(): void
    {
        // No actingAs — guest can switch locale without logging in
        $this->get(route('locale.switch', 'en'))
            ->assertRedirect();
    }

    // ═══════════════════════════════════════════════════════════
    // PERSISTENCE — locale survives across requests
    // ═══════════════════════════════════════════════════════════

    public function test_locale_session_persists_to_next_request(): void
    {
        $this->get(route('locale.switch', 'en'));

        // Follow-up request in the same session should still have 'en'
        $response = $this->get(route('home'));
        $this->assertEquals('en', session('locale'));
    }

    public function test_switching_locale_twice_keeps_last_value(): void
    {
        $this->get(route('locale.switch', 'en'));
        $this->get(route('locale.switch', 'ar'));

        $this->assertEquals('ar', session('locale'));
    }

    public function test_ar_to_en_switch_updates_session(): void
    {
        session(['locale' => 'ar']);

        $this->get(route('locale.switch', 'en'));

        $this->assertEquals('en', session('locale'));
    }

    public function test_en_to_ar_switch_updates_session(): void
    {
        session(['locale' => 'en']);

        $this->get(route('locale.switch', 'ar'));

        $this->assertEquals('ar', session('locale'));
    }
}
