<?php

namespace App\Livewire\Admin\Tags;

use App\Models\Tag;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class Index extends Component
{
    use WithPagination;

    public string $search      = '';
    public bool   $showForm    = false;
    public ?int   $editingId   = null;
    public string $name_ar       = '';
    public string $name_en       = '';
    public string $content_ar    = '';
    public string $content_en    = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatedNameAr(string $value): void
    {
        if (! $this->editingId) {
            $this->name_en = $this->name_en ?: $value;
        }
    }

    public function openCreate(): void
    {
        $this->reset('editingId', 'name_ar', 'name_en', 'content_ar', 'content_en');
        $this->showForm = true;
        $this->dispatch('tag-form-opened', content_ar: '', content_en: '');
    }

    public function openEdit(int $id): void
    {
        $tag = Tag::findOrFail($id);
        $this->editingId   = $id;
        $this->name_ar     = $tag->getTranslation('name', 'ar');
        $this->name_en     = $tag->getTranslation('name', 'en');
        $this->content_ar  = $tag->getTranslation('content', 'ar') ?? '';
        $this->content_en  = $tag->getTranslation('content', 'en') ?? '';
        $this->showForm    = true;
        $this->dispatch('tag-form-opened', content_ar: $this->content_ar, content_en: $this->content_en);
    }

    public function save(): void
    {
        $this->validate([
            'name_ar' => 'required|string|max:100',
            'name_en' => 'required|string|max:100',
        ]);

        $data = [
            'name'    => ['ar' => $this->name_ar,    'en' => $this->name_en],
            'slug'    => ['ar' => Str::slug($this->name_ar), 'en' => Str::slug($this->name_en)],
            'content' => ['ar' => $this->content_ar, 'en' => $this->content_en],
        ];

        if ($this->editingId) {
            Tag::findOrFail($this->editingId)->update($data);
        } else {
            Tag::create($data);
        }

        $this->reset('showForm', 'editingId', 'name_ar', 'name_en', 'content_ar', 'content_en');
    }

    public function delete(int $id): void
    {
        Tag::findOrFail($id)->delete();
    }

    public function cancelForm(): void
    {
        $this->reset('showForm', 'editingId', 'name_ar', 'name_en', 'content_ar', 'content_en');
    }

    public function render()
    {
        $tags = Tag::withCount('posts')
            ->when($this->search, fn($q) =>
                $q->where('name->ar', 'like', "%{$this->search}%")
                  ->orWhere('name->en', 'like', "%{$this->search}%")
            )
            ->latest()
            ->paginate(20);

        return view('livewire.admin.tags.index', compact('tags'));
    }
}
