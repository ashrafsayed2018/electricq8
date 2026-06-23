<?php

namespace App\Livewire\Admin\Gallery;

use App\Models\Media;
use App\Services\ImageConverter;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class Index extends Component
{
    use WithFileUploads;
    use WithPagination;

    public string $search  = '';
    public string $name_ar = '';
    public string $name_en = '';
    public string $alt_ar  = '';
    public string $alt_en  = '';
    public mixed $image = null;

    public function saveImage(): void
    {
        $this->validate([
            'image'   => ['required', 'image', 'mimes:webp', 'max:5120'],
            'name_ar' => ['required', 'string', 'max:255'],
            'name_en' => ['required', 'string', 'max:255'],
            'alt_ar'  => ['nullable', 'string', 'max:255'],
            'alt_en'  => ['nullable', 'string', 'max:255'],
        ]);

        $size = $this->image->getSize();
        $path = ImageConverter::store($this->image);

        Media::create([
            'name'      => ['ar' => $this->name_ar, 'en' => $this->name_en],
            'alt'       => ['ar' => $this->alt_ar,  'en' => $this->alt_en],
            'file_name' => basename($path),
            'path'      => $path,
            'mime_type' => 'image/webp',
            'size'      => $size,
        ]);

        $this->reset(['name_ar', 'name_en', 'alt_ar', 'alt_en', 'image']);
    }

    public function delete(int $id): void
    {
        $media = Media::findOrFail($id);
        Storage::disk('public')->delete($media->path);
        $media->delete();
    }

    public function selectMedia(int $id): void
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
            ->paginate(24);

        return view('livewire.admin.gallery.index', compact('items'));
    }
}
