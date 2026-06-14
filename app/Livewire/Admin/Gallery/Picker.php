<?php

namespace App\Livewire\Admin\Gallery;

use App\Models\Media;
use Livewire\Component;
use Livewire\WithPagination;

class Picker extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function select(int $id): void
    {
        $media = Media::findOrFail($id);
        $this->dispatch('media-selected', id: $media->id, url: $media->url);
    }

    public function render()
    {
        $items = Media::when($this->search, function ($q) {
                $q->where('name->ar', 'like', "%{$this->search}%")
                  ->orWhere('name->en', 'like', "%{$this->search}%");
            })
            ->latest()
            ->paginate(18);

        return view('livewire.admin.gallery.picker', compact('items'));
    }
}
