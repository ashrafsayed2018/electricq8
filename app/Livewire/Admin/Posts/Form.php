<?php

namespace App\Livewire\Admin\Posts;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.admin')]
class Form extends Component
{
    public ?Post $post = null;

    public string $title_ar        = '';
    public string $title_en        = '';
    public string $slug_ar         = '';
    public string $slug_en         = '';
    public string $h1_ar           = '';
    public string $h1_en           = '';
    public string $excerpt_ar      = '';
    public string $excerpt_en      = '';
    public string $content_ar      = '';
    public string $content_en      = '';
    public string $meta_title_ar   = '';
    public string $meta_title_en   = '';
    public string $meta_desc_ar    = '';
    public string $meta_desc_en    = '';
    public string $featured_image  = '';
    public string $status          = 'draft';
    public string $published_at    = '';
    public int    $sort_order      = 0;

    public ?int   $category_id     = null;
    public array  $selected_tags   = [];
    public string $tag_search      = '';

    #[On('image-picked-featured_image')]
    public function mediaSelected(string $url): void
    {
        $this->featured_image = $url;
    }

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

    public function mount(?Post $post = null): void
    {
        if ($post && $post->exists) {
            $this->post           = $post;
            $this->title_ar       = $post->getTranslation('title', 'ar');
            $this->title_en       = $post->getTranslation('title', 'en');
            $this->slug_ar        = $post->getTranslation('slug', 'ar');
            $this->slug_en        = $post->getTranslation('slug', 'en');
            $this->h1_ar          = $post->getTranslation('h1', 'ar') ?? '';
            $this->h1_en          = $post->getTranslation('h1', 'en') ?? '';
            $this->excerpt_ar     = $post->getTranslation('excerpt', 'ar') ?? '';
            $this->excerpt_en     = $post->getTranslation('excerpt', 'en') ?? '';
            $this->content_ar     = $post->getTranslation('content', 'ar') ?? '';
            $this->content_en     = $post->getTranslation('content', 'en') ?? '';
            $this->meta_title_ar  = $post->getTranslation('meta_title', 'ar') ?? '';
            $this->meta_title_en  = $post->getTranslation('meta_title', 'en') ?? '';
            $this->meta_desc_ar   = $post->getTranslation('meta_description', 'ar') ?? '';
            $this->meta_desc_en   = $post->getTranslation('meta_description', 'en') ?? '';
            $this->featured_image = $post->featured_image ?? '';
            $this->status         = $post->status->value;
            $this->published_at   = $post->published_at?->format('Y-m-d') ?? '';
            $this->sort_order     = (int) $post->sort_order;
            $this->category_id    = $post->category_id;
            $this->selected_tags  = $post->tags->pluck('id')->map(fn($id) => (string) $id)->toArray();
        }
    }

    public function save(): void
    {
        $this->validate([
            'title_ar' => 'required|string|max:200',
            'title_en' => 'required|string|max:200',
            'slug_ar'  => 'required|string|max:200',
            'slug_en'  => 'required|string|max:200',
            'status'   => 'required|in:draft,published',
        ]);

        $data = [
            'title'            => ['ar' => $this->title_ar,      'en' => $this->title_en],
            'slug'             => ['ar' => $this->slug_ar,       'en' => $this->slug_en],
            'h1'               => ['ar' => $this->h1_ar,         'en' => $this->h1_en],
            'excerpt'          => ['ar' => $this->excerpt_ar,    'en' => $this->excerpt_en],
            'content'          => ['ar' => $this->content_ar,    'en' => $this->content_en],
            'meta_title'       => ['ar' => $this->meta_title_ar, 'en' => $this->meta_title_en],
            'meta_description' => ['ar' => $this->meta_desc_ar,  'en' => $this->meta_desc_en],
            'featured_image'   => $this->featured_image ?: null,
            'status'           => $this->status,
            'published_at'     => $this->published_at ?: null,
            'sort_order'       => $this->sort_order,
            'category_id'      => $this->category_id ?: null,
        ];

        $post = $this->post ? tap($this->post)->update($data) : Post::create($data);

        $post->tags()->sync($this->selected_tags);

        $this->redirect(route('admin.posts.index'));
    }

    public function render()
    {
        $allTags = Tag::when($this->tag_search, fn($q) =>
                $q->where('name->ar', 'like', "%{$this->tag_search}%")
                  ->orWhere('name->en', 'like', "%{$this->tag_search}%")
            )->orderBy('id')->get();

        return view('livewire.admin.posts.form', [
            'allTags'       => $allTags,
            'allCategories' => Category::orderBy('id')->get(),
        ]);
    }
}
