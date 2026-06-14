<?php

namespace App\Livewire\Admin\Areas;

use App\Models\Location;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class Form extends Component
{
    public ?Location $location = null;

    public string $name_ar        = '';
    public string $name_en        = '';
    public string $slug_ar        = '';
    public string $slug_en        = '';
    public string $description_ar = '';
    public string $description_en = '';
    public string $governorate    = 'hawalli';
    public bool   $is_active      = true;
    public int    $sort_order     = 0;

    public function mount(?Location $location = null): void
    {
        if ($location && $location->exists) {
            $this->location       = $location;
            $this->name_ar        = $location->getTranslation('name', 'ar');
            $this->name_en        = $location->getTranslation('name', 'en');
            $this->slug_ar        = $location->getTranslation('slug', 'ar');
            $this->slug_en        = $location->getTranslation('slug', 'en');
            $this->description_ar = $location->getTranslation('description', 'ar') ?? '';
            $this->description_en = $location->getTranslation('description', 'en') ?? '';
            $this->governorate    = $location->governorate;
            $this->is_active      = $location->is_active;
            $this->sort_order     = $location->sort_order;
        }
    }

    public function updatedNameAr(string $value): void
    {
        $this->slug_ar = $this->toArSlug($value);
    }

    public function updatedNameEn(string $value): void
    {
        $this->slug_en = \Illuminate\Support\Str::slug($value);
    }

    private function toArSlug(string $text): string
    {
        $text = preg_replace('/[^\p{Arabic}\p{N}\s-]/u', '', $text);
        return trim(preg_replace('/[\s-]+/u', '-', $text), '-');
    }

    public function save(): void
    {
        $this->validate([
            'name_ar'     => 'required|string|max:200',
            'name_en'     => 'required|string|max:200',
            'slug_ar'     => 'required|string|max:200',
            'slug_en'     => 'required|string|max:200',
            'governorate' => 'required|string',
        ]);

        $data = [
            'name'        => ['ar' => $this->name_ar, 'en' => $this->name_en],
            'slug'        => ['ar' => $this->slug_ar, 'en' => $this->slug_en],
            'description' => ['ar' => $this->description_ar, 'en' => $this->description_en],
            'governorate' => $this->governorate,
            'is_active'   => $this->is_active,
            'sort_order'  => $this->sort_order,
        ];

        if ($this->location) {
            $this->location->update($data);
        } else {
            Location::create($data);
        }

        $this->redirect(route('admin.areas.index'));
    }

    public function render()
    {
        return view('livewire.admin.areas.form');
    }
}
