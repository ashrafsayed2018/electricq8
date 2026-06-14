<?php

namespace App\Livewire\Admin\Settings;

use App\Models\SiteSetting;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.admin')]
class Index extends Component
{
    public array $settings = [];

    // Image URL properties — kept separate so the ImagePicker events can update them
    public string $logo_url    = '';
    public string $favicon_url = '';
    public string $hero_url    = '';

    public function mount(): void
    {
        $this->settings = SiteSetting::all()->pluck('value', 'key')->toArray();

        $this->logo_url    = SiteSetting::get('logo_url', '');
        $this->favicon_url = SiteSetting::get('favicon_url', '');
        $this->hero_url    = SiteSetting::get('hero_image_url', '');
    }

    #[On('image-picked-logo_url')]
    public function logoSelected(string $url): void
    {
        $this->logo_url = $url;
    }

    #[On('image-picked-favicon_url')]
    public function faviconSelected(string $url): void
    {
        $this->favicon_url = $url;
    }

    #[On('image-picked-hero_image_url')]
    public function heroSelected(string $url): void
    {
        $this->hero_url = $url;
    }

    public function save(): void
    {
        foreach ($this->settings as $key => $value) {
            SiteSetting::set($key, (string) $value);
        }

        SiteSetting::set('logo_url',       $this->logo_url);
        SiteSetting::set('favicon_url',    $this->favicon_url);
        SiteSetting::set('hero_image_url', $this->hero_url);

        session()->flash('success', 'تم حفظ الإعدادات بنجاح.');
    }

    public function render()
    {
        return view('livewire.admin.settings.index');
    }
}
