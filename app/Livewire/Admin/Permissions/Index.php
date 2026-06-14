<?php

namespace App\Livewire\Admin\Permissions;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

#[Layout('layouts.admin')]
class Index extends Component
{
    public function delete(int $id): void
    {
        abort_unless(auth()->user()->hasRole('admin'), 403);

        Permission::findOrFail($id)->delete();
    }

    public function render()
    {
        return view('livewire.admin.permissions.index', [
            'permissions' => Permission::withCount('roles')->orderBy('name')->get(),
        ]);
    }
}
