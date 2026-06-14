<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function delete(User $user): void
    {
        if ($user->id === auth()->id()) {
            return;
        }

        $user->delete();
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, fn ($q) => $q
                ->where('name', 'like', "%{$this->search}%")
                ->orWhere('email', 'like', "%{$this->search}%")
            )
            ->latest()
            ->paginate(15);

        return view('livewire.admin.users.index', compact('users'));
    }
}
