<?php

namespace Tests\Feature;

use App\Livewire\LanguageSwitcher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Tests for the language switcher after it was changed from two buttons
 * (AR + EN always visible) to a single toggle button showing the OTHER locale.
 */
class LanguageSwitcherSingleButtonTest extends TestCase
{
    use RefreshDatabase;

    // ══════════════════════════════════════════════════════
    // Single-button UI behaviour
    // ══════════════════════════════════════════════════════

    // Unhappy: when locale=ar, button should NOT show "العربية" (that was the old two-button design)
    public function test_when_locale_is_arabic_button_does_not_show_arabic_label(): void
    {
        app()->setLocale('ar');

        Livewire::test(LanguageSwitcher::class)
            ->assertDontSee('العربية');
    }

    // Unhappy: when locale=en, button should NOT show "EN" (user is already on EN)
    public function test_when_locale_is_english_button_does_not_show_english_label(): void
    {
        app()->setLocale('en');

        Livewire::test(LanguageSwitcher::class)
            ->assertDontSee('EN');
    }

    // Happy: when locale=ar the single button shows "EN" (the other locale)
    public function test_when_locale_is_arabic_button_shows_en(): void
    {
        app()->setLocale('ar');

        Livewire::test(LanguageSwitcher::class)
            ->assertSee('EN');
    }

    // Happy: when locale=en the single button shows "العربية" (the other locale)
    public function test_when_locale_is_english_button_shows_arabic_label(): void
    {
        app()->setLocale('en');

        Livewire::test(LanguageSwitcher::class)
            ->assertSee('العربية');
    }

    // Happy: exactly one button rendered (not two)
    public function test_only_one_button_is_rendered(): void
    {
        app()->setLocale('ar');

        $html = Livewire::test(LanguageSwitcher::class)->html();

        $this->assertEquals(1, substr_count($html, '<button'));
    }

    // Happy: clicking the button when on AR switches to EN
    public function test_clicking_button_when_on_arabic_switches_to_english(): void
    {
        app()->setLocale('ar');

        Livewire::test(LanguageSwitcher::class)
            ->call('switchTo', 'en');

        $this->assertEquals('en', session('locale'));
    }

    // Happy: clicking the button when on EN switches to AR
    public function test_clicking_button_when_on_english_switches_to_arabic(): void
    {
        app()->setLocale('en');

        Livewire::test(LanguageSwitcher::class)
            ->call('switchTo', 'ar');

        $this->assertEquals('ar', session('locale'));
    }

    // Unhappy: passing an invalid locale still does not change the session
    public function test_invalid_locale_is_rejected(): void
    {
        session(['locale' => 'ar']);

        Livewire::test(LanguageSwitcher::class)
            ->call('switchTo', 'fr');

        $this->assertEquals('ar', session('locale'));
    }
}
