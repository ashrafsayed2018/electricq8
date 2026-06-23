<?php

namespace App\Livewire;

use App\Models\Media;
use Livewire\Component;
use Livewire\WithPagination;

class GallerySearch extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $images = Media::when($this->search, function ($q) {
                $q->where('name->ar', 'like', "%{$this->search}%")
                  ->orWhere('name->en', 'like', "%{$this->search}%");
            })
            ->latest()
            ->paginate(12);

        $total = Media::count();

        return view('livewire.gallery-search', compact('images', 'total'));
    }
}
