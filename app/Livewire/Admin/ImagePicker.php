<?php

namespace App\Livewire\Admin;

use App\Models\Media;
use Livewire\Component;
use Livewire\WithPagination;

class ImagePicker extends Component
{
    use WithPagination;

    public string $field     = '';
    public string $imageUrl  = '';
    public string $label     = 'الصورة';
    public bool   $inline    = false;   // true = button only, no card wrapper or thumbnail
    public bool   $open      = false;
    public string $search    = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function openModal(): void
    {
        $this->open = true;
    }

    public function closeModal(): void
    {
        $this->open = false;
        $this->search = '';
        $this->resetPage();
        $this->dispatch('image-picker-closed');
    }

    public function pick(int $id): void
    {
        $media = Media::findOrFail($id);
        $this->imageUrl = $media->url;
        $this->dispatch('image-picked-' . $this->field, url: $media->url);
        $this->closeModal();
    }

    public function clear(): void
    {
        $this->imageUrl = '';
        $this->dispatch('image-picked-' . $this->field, url: '');
    }

    public function render()
    {
        $items = $this->open
            ? Media::when($this->search, fn($q) => $q
                ->where('name->ar', 'like', "%{$this->search}%")
                ->orWhere('name->en', 'like', "%{$this->search}%"))
                ->latest()
                ->paginate(18)
            : collect();

        return view('livewire.admin.image-picker', compact('items'));
    }
}
