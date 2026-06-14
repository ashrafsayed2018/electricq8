<?php

namespace Tests\Feature;

use App\Livewire\LanguageSwitcher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LanguageSwitcherLivewireTest extends TestCase
{
    use RefreshDatabase;

    // Happy: component renders
    public function test_language_switcher_renders(): void
    {
        Livewire::test(LanguageSwitcher::class)
            ->assertStatus(200);
    }

    // Happy: switching to 'ar' sets session locale to ar
    public function test_switch_to_ar_sets_session_locale(): void
    {
        Livewire::test(LanguageSwitcher::class)
            ->call('switchTo', 'ar');

        $this->assertEquals('ar', session('locale'));
    }

    // Happy: switching to 'en' sets session locale to en
    public function test_switch_to_en_sets_session_locale(): void
    {
        Livewire::test(LanguageSwitcher::class)
            ->call('switchTo', 'en');

        $this->assertEquals('en', session('locale'));
    }

    // Unhappy: invalid locale does not update session
    public function test_invalid_locale_does_not_update_session(): void
    {
        session(['locale' => 'ar']);

        Livewire::test(LanguageSwitcher::class)
            ->call('switchTo', 'fr');

        $this->assertEquals('ar', session('locale'));
    }

    // Happy: component shows single button for the OTHER locale (when on AR, shows EN)
    public function test_component_shows_single_button_for_other_locale(): void
    {
        app()->setLocale('ar');

        Livewire::test(LanguageSwitcher::class)
            ->assertSee('EN')
            ->assertDontSee('العربية');
    }
}
