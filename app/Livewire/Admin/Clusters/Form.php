<?php

namespace App\Livewire\Admin\Clusters;

use App\Models\Cluster;
use App\Models\Pillar;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.admin')]
class Form extends Component
{
    public ?Cluster $cluster = null;

    public int    $pillar_id     = 0;
    public string $title_ar      = '';
    public string $title_en      = '';
    public string $slug_ar       = '';
    public string $slug_en       = '';
    public string $content_ar    = '';
    public string $content_en    = '';
    public string $search_intent = 'commercial';
    public string $status        = 'active';
    public int    $sort_order    = 0;
    public string $image_url     = '';

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

    public function mount(?Cluster $cluster = null): void
    {
        if ($cluster && $cluster->exists) {
            $this->cluster       = $cluster;
            $this->pillar_id     = $cluster->pillar_id;
            $this->title_ar      = $cluster->getTranslation('title', 'ar');
            $this->title_en      = $cluster->getTranslation('title', 'en');
            $this->slug_ar       = $cluster->getTranslation('slug', 'ar');
            $this->slug_en       = $cluster->getTranslation('slug', 'en');
            $this->content_ar    = $cluster->getTranslation('content', 'ar') ?? '';
            $this->content_en    = $cluster->getTranslation('content', 'en') ?? '';
            $this->search_intent = $cluster->search_intent ?? 'commercial';
            $this->status        = $cluster->status;
            $this->sort_order    = (int) $cluster->sort_order;
            $this->image_url     = $cluster->image_url ?? '';
        }
    }

    #[On('image-picked-image_url')]
    public function mediaSelected(string $url): void
    {
        $this->image_url = $url;
    }

    public function save(): void
    {
        $this->validate([
            'pillar_id' => 'required|exists:pillars,id',
            'title_ar'  => 'required|string|max:200',
            'title_en'  => 'required|string|max:200',
            'slug_ar'   => 'required|string|max:200',
            'slug_en'   => 'required|string|max:200',
            'status'    => 'required|in:active,draft,archived',
        ]);

        $data = [
            'pillar_id'     => $this->pillar_id,
            'title'         => ['ar' => $this->title_ar,   'en' => $this->title_en],
            'slug'          => ['ar' => $this->slug_ar,    'en' => $this->slug_en],
            'content'       => ['ar' => $this->content_ar, 'en' => $this->content_en],
            'search_intent' => $this->search_intent,
            'status'        => $this->status,
            'sort_order'    => $this->sort_order,
            'image_url'     => $this->image_url ?: null,
        ];

        if ($this->cluster) {
            $this->cluster->update($data);
        } else {
            Cluster::create($data);
        }

        $this->redirect(route('admin.clusters.index'));
    }

    public function render()
    {
        return view('livewire.admin.clusters.form', [
            'pillars' => Pillar::orderBy('sort_order')->get(),
        ]);
    }
}
