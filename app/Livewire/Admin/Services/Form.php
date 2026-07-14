<?php

namespace App\Livewire\Admin\Services;

use App\Models\Service;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

#[Layout('layouts.admin')]
class Form extends Component
{
    public ?Service $service = null;

    public string $title_ar   = '';
    public string $title_en   = '';
    public string $slug_ar    = '';
    public string $slug_en    = '';
    public string $h1_ar      = '';
    public string $h1_en      = '';
    public string $intro_ar   = '';
    public string $intro_en   = '';
    public string $content_ar          = '';
    public string $content_en          = '';
    public string $meta_description_ar = '';
    public string $meta_description_en = '';
    public string $status              = 'active';
    public int    $sort_order = 0;
    public string $image_url  = '';

    public function updatedTitleAr(string $value): void
    {
        $this->slug_ar = $this->toArSlug($value);
    }

    public function updatedTitleEn(string $value): void
    {
        $this->slug_en = \Illuminate\Support\Str::slug($value);
    }

    private function toArSlug(string $text): string
    {
        $text = preg_replace('/[^\p{Arabic}\p{N}\s-]/u', '', $text);
        return trim(preg_replace('/[\s-]+/u', '-', $text), '-');
    }

    public function mount(?Service $service = null): void
    {
        if ($service && $service->exists) {
            $this->service    = $service;
            $this->title_ar   = $service->getTranslation('title', 'ar');
            $this->title_en   = $service->getTranslation('title', 'en');
            $this->slug_ar    = $service->getTranslation('slug', 'ar');
            $this->slug_en    = $service->getTranslation('slug', 'en');
            $this->h1_ar      = $service->getTranslation('h1', 'ar') ?? '';
            $this->h1_en      = $service->getTranslation('h1', 'en') ?? '';
            $this->intro_ar   = $service->getTranslation('intro', 'ar') ?? '';
            $this->intro_en   = $service->getTranslation('intro', 'en') ?? '';
            $this->content_ar          = $service->getTranslation('content', 'ar') ?? '';
            $this->content_en          = $service->getTranslation('content', 'en') ?? '';
            $this->meta_description_ar = $service->getTranslation('meta_description', 'ar') ?? '';
            $this->meta_description_en = $service->getTranslation('meta_description', 'en') ?? '';
            $this->status     = $service->status->value;
            $this->sort_order = (int) ($service->sort_order ?? 0);
            $this->image_url  = $service->image_url ?? '';
        }
    }

    #[On('image-picked-image_url')]
    public function mediaSelected(string $url): void
    {
        $this->image_url = $url;
    }

    public function save(): void
    {
        try {
        $this->validate([
            'title_ar'            => 'required|string|max:200',
            'title_en'            => 'required|string|max:200',
            'slug_ar'             => 'required|string|max:200',
            'slug_en'             => 'required|string|max:200',
            'content_ar'          => 'required|string',
            'content_en'          => 'required|string',
            'meta_description_ar' => 'required|string|max:320',
            'meta_description_en' => 'required|string|max:320',
            'image_url'           => 'required|string',
        ]);

        $data = [
            'title'    => ['ar' => $this->title_ar, 'en' => $this->title_en],
            'slug'     => ['ar' => $this->slug_ar,  'en' => $this->slug_en],
            'h1'       => ['ar' => $this->h1_ar,    'en' => $this->h1_en],
            'intro'    => ['ar' => $this->intro_ar,  'en' => $this->intro_en],
            'content'          => ['ar' => $this->content_ar, 'en' => $this->content_en],
            'meta_description' => ['ar' => $this->meta_description_ar, 'en' => $this->meta_description_en],
            'status'     => $this->status,
            'sort_order' => $this->sort_order,
            'image_url'  => $this->image_url ?: null,
        ];

        if ($this->service) {
            $this->service->update($data);
        } else {
            Service::create($data);
        }

        $this->redirect(route('admin.services.index'));
        } catch (ValidationException $e) {
            $this->dispatch('scroll-to-error');
            throw $e;
        }
    }

    public function render()
    {
        return view('livewire.admin.services.form');
    }
}
