<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Create permissions
        $permissions = [
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',
            'activities.view',
            'activities.create',
            'activities.edit',
            'activities.delete',
            'assignments.view',
            'assignments.create',
            'assignments.edit',
            'assignments.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission]);
        }

        // Create roles
        $adminRole = Role::updateOrCreate(['name' => 'admin']);
        $userRole = Role::updateOrCreate(['name' => 'user']);

        // Assign permissions to roles
        $adminRole->givePermissionTo(Permission::all());
        $userRole->givePermissionTo(['assignments.view']);

        // Create admin user
        $admin = User::updateOrCreate(
            ['email' => 'admin@aseofamiliar.com'],
            [
                'name' => 'Administrador',
                'email' => 'admin@aseofamiliar.com',
                'password' => Hash::make('admin123'),
                'is_active' => true
            ]
        );

        $admin->assignRole('admin');
    }
}
