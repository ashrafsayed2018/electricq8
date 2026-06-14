<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Spatie\Permission\Models\Role;

#[Layout('layouts.admin')]
class Form extends Component
{
    public ?User $user = null;

    public string $name     = '';
    public string $email    = '';
    public string $password = '';
    public string $role     = 'admin';

    public function mount(?User $user = null): void
    {
        if ($user && $user->exists) {
            $this->user  = $user;
            $this->name  = $user->name;
            $this->email = $user->email;
            $this->role  = $user->roles->first()?->name ?? 'admin';
        }
    }

    public function save(): void
    {
        $rules = [
            'name'  => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:users,email' . ($this->user ? ",{$this->user->id}" : ''),
            'role'  => 'required|exists:roles,name',
        ];

        if (! $this->user) {
            $rules['password'] = 'required|string|min:8';
        } elseif ($this->password !== '') {
            $rules['password'] = 'string|min:8';
        }

        $this->validate($rules);

        if ($this->user) {
            $data = ['name' => $this->name, 'email' => $this->email];
            if ($this->password !== '') {
                $data['password'] = $this->password;
            }
            $this->user->update($data);
            $this->user->syncRoles([$this->role]);
        } else {
            $user = User::create([
                'name'     => $this->name,
                'email'    => $this->email,
                'password' => $this->password,
            ]);
            $user->assignRole($this->role);
        }

        $this->redirect(route('admin.users.index'));
    }

    public function render()
    {
        return view('livewire.admin.users.form', [
            'roles' => Role::orderBy('name')->pluck('name'),
        ]);
    }
}
