<?php

namespace App\Livewire\Admin\Pillars;

use App\Models\Pillar;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.admin')]
class Form extends Component
{
    public ?Pillar $pillar = null;

    public string $title_ar   = '';
    public string $title_en   = '';
    public string $slug_ar    = '';
    public string $slug_en    = '';
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

    #[On('image-picked-image_url')]
    public function imageSelected(string $url): void
    {
        $this->image_url = $url;
    }

    public function mount(?Pillar $pillar = null): void
    {
        if ($pillar && $pillar->exists) {
            $this->pillar     = $pillar;
            $this->title_ar   = $pillar->getTranslation('title', 'ar');
            $this->title_en   = $pillar->getTranslation('title', 'en');
            $this->slug_ar    = $pillar->getTranslation('slug', 'ar');
            $this->slug_en    = $pillar->getTranslation('slug', 'en');
            $this->content_ar          = $pillar->getTranslation('content', 'ar') ?? '';
            $this->content_en          = $pillar->getTranslation('content', 'en') ?? '';
            $this->meta_description_ar = $pillar->getTranslation('meta_description', 'ar') ?? '';
            $this->meta_description_en = $pillar->getTranslation('meta_description', 'en') ?? '';
            $this->status     = $pillar->status;
            $this->sort_order = (int) $pillar->sort_order;
            $this->image_url  = $pillar->image_url ?? '';
        }
    }

    public function save(): void
    {
        $this->validate([
            'title_ar'           => 'required|string|max:200',
            'title_en'           => 'required|string|max:200',
            'slug_ar'            => 'required|string|max:200',
            'slug_en'            => 'required|string|max:200',
            'content_ar'         => 'required|string',
            'content_en'         => 'required|string',
            'meta_description_ar'=> 'required|string|max:320',
            'meta_description_en'=> 'required|string|max:320',
            'status'             => 'required|in:active,draft',
        ]);

        $data = [
            'title'      => ['ar' => $this->title_ar, 'en' => $this->title_en],
            'slug'       => ['ar' => $this->slug_ar,  'en' => $this->slug_en],
            'content'          => ['ar' => $this->content_ar, 'en' => $this->content_en],
            'meta_description' => ['ar' => $this->meta_description_ar, 'en' => $this->meta_description_en],
            'status'     => $this->status,
            'sort_order' => $this->sort_order,
            'image_url'  => $this->image_url ?: null,
        ];

        if ($this->pillar) {
            $this->pillar->update($data);
        } else {
            Pillar::create($data);
        }

        $this->redirect(route('admin.pillars.index'));
    }

    public function render()
    {
        return view('livewire.admin.pillars.form');
    }
}
