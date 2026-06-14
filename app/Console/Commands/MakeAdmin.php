<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class MakeAdmin extends Command
{
    protected $signature   = 'admin:make {email} {--name=Admin} {--password=password}';
    protected $description = 'Create a user (if not exists) and assign the admin role';

    public function handle(): void
    {
        Role::firstOrCreate(['name' => 'admin']);

        $user = User::firstOrCreate(
            ['email' => $this->argument('email')],
            [
                'name'     => $this->option('name'),
                'password' => Hash::make($this->option('password')),
            ]
        );

        $user->syncRoles(['admin']);

        $this->info("✓ User [{$user->email}] now has the admin role.");
        if ($user->wasRecentlyCreated) {
            $this->line("  Account created with password: <comment>{$this->option('password')}</comment>");
            $this->line("  Change the password after first login.");
        }
    }
}
