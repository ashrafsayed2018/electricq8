<?php

namespace App\Livewire\Admin\Roles;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Spatie\Permission\Models\Role;

#[Layout('layouts.admin')]
class Index extends Component
{
    public function delete(int $id): void
    {
        abort_unless(auth()->user()->hasRole('admin'), 403);

        $role = Role::find($id);

        abort_if($role === null, 404);

        if ($role->name === 'admin') {
            return;
        }

        $role->delete();
    }

    public function render()
    {
        return view('livewire.admin.roles.index', [
            'roles' => Role::withCount('users', 'permissions')->orderBy('name')->get(),
        ]);
    }
}
