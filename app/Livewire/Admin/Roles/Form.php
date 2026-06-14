<?php

namespace App\Livewire\Admin\Roles;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

#[Layout('layouts.admin')]
class Form extends Component
{
    public ?Role $role = null;

    public string $name                = '';
    public array  $selectedPermissions = [];

    public function mount(?Role $role = null): void
    {
        if ($role && $role->exists) {
            $this->role                = $role;
            $this->name                = $role->name;
            $this->selectedPermissions = $role->permissions->pluck('name')->toArray();
        }
    }

    public function save(): void
    {
        abort_unless(auth()->user()->hasRole('admin'), 403);

        $this->validate([
            'name'                  => 'required|string|max:100|unique:roles,name' . ($this->role ? ",{$this->role->id}" : ''),
            'selectedPermissions'   => 'array',
            'selectedPermissions.*' => 'string|exists:permissions,name',
        ]);

        if ($this->role) {
            $this->role->update(['name' => $this->name]);
            $this->role->syncPermissions($this->selectedPermissions);
        } else {
            $role = Role::create(['name' => $this->name]);
            $role->syncPermissions($this->selectedPermissions);
        }

        $this->redirect(route('admin.roles.index'));
    }

    public function render()
    {
        return view('livewire.admin.roles.form', [
            'permissions' => Permission::orderBy('name')->get(),
        ]);
    }
}
