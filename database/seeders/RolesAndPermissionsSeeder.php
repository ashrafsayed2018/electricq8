<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'contacts.view',
            'services.manage',
            'areas.manage',
            'testimonials.manage',
            'settings.manage',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        Role::firstOrCreate(['name' => 'admin'])->syncPermissions(Permission::all());

        $admin = \App\Models\User::firstOrCreate(
            ['email' => 'admin@electricq8.com'],
            ['name' => 'Admin', 'password' => bcrypt('change_this_password_immediately')]
        );
        $admin->assignRole('admin');
    }
}
