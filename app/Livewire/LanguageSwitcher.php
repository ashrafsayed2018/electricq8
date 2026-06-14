<?php

namespace App\Livewire;

use Livewire\Component;

class LanguageSwitcher extends Component
{
    public function switchTo(string $locale): void
    {
        if (! in_array($locale, config('app.available_locales'))) {
            return;
        }

        session(['locale' => $locale]);

        $referer = request()->header('Referer', '/');
        $path    = parse_url($referer, PHP_URL_PATH) ?? '/';

        // Strip any existing locale prefix (/en/...) from the referer path
        $stripped = preg_replace('#^/en(/|$)#', '/', $path);

        // For English, add /en prefix; for Arabic, use stripped path (no prefix)
        $target = $locale === 'en' ? '/en' . $stripped : $stripped;

        // Normalise double slash edge case
        $target = preg_replace('#/{2,}#', '/', $target) ?: '/';

        $this->redirect($target, navigate: false);
    }

    public function render()
    {
        return view('livewire.language-switcher');
    }
}
