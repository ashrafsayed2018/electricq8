<?php

namespace App\Livewire\Admin\Posts;

use App\Models\Post;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class Index extends Component
{
    use WithPagination;

    #[Url] public string $status = '';
    #[Url] public string $search = '';

    public function updatedSearch(): void { $this->resetPage(); }
    public function updatedStatus(): void { $this->resetPage(); }

    public function delete(Post $post): void
    {
        $post->delete();
    }

    public function render()
    {
        $posts = Post::when($this->status, fn ($q) => $q->where('status', $this->status))
            ->when($this->search, fn ($q) => $q
                ->where('title->ar', 'like', "%{$this->search}%")
                ->orWhere('title->en', 'like', "%{$this->search}%"))
            ->orderByDesc('published_at')
            ->orderBy('sort_order')
            ->paginate(15);

        return view('livewire.admin.posts.index', [
            'posts'          => $posts,
            'totalCount'     => Post::count(),
            'publishedCount' => Post::where('status', 'published')->count(),
            'draftCount'     => Post::where('status', 'draft')->count(),
        ]);
    }
}
