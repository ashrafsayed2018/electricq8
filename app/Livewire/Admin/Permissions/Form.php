<?php

namespace App\Livewire\Admin\Permissions;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

#[Layout('layouts.admin')]
class Form extends Component
{
    public ?Permission $permission = null;

    public string $name = '';

    public function mount(?Permission $permission = null): void
    {
        if ($permission && $permission->exists) {
            $this->permission = $permission;
            $this->name       = $permission->name;
        }
    }

    public function save(): void
    {
        abort_unless(auth()->user()->hasRole('admin'), 403);

        $this->validate([
            'name' => 'required|string|max:100|unique:permissions,name' . ($this->permission ? ",{$this->permission->id}" : ''),
        ]);

        if ($this->permission) {
            $this->permission->update(['name' => $this->name]);
        } else {
            Permission::create(['name' => $this->name]);
        }

        $this->redirect(route('admin.permissions.index'));
    }

    public function render()
    {
        return view('livewire.admin.permissions.form');
    }
}
