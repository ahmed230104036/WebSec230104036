<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            ['name' => 'add_products', 'display_name' => 'Add Products', 'guard_name' => 'web'],
            ['name' => 'edit_products', 'display_name' => 'Edit Products', 'guard_name' => 'web'],
            ['name' => 'delete_products', 'display_name' => 'Delete Products', 'guard_name' => 'web'],
            ['name' => 'show_users', 'display_name' => 'Show Users', 'guard_name' => 'web'],
            ['name' => 'edit_users', 'display_name' => 'Edit Users', 'guard_name' => 'web'],
            ['name' => 'delete_users', 'display_name' => 'Delete Users', 'guard_name' => 'web'],
            ['name' => 'admin_users', 'display_name' => 'Admin Users', 'guard_name' => 'web'],
        ];

        foreach ($permissions as $permissionData) {
            Permission::firstOrCreate([
                'name' => $permissionData['name'],
                'guard_name' => $permissionData['guard_name']
            ], [
                'display_name' => $permissionData['display_name']
            ]);
        }

        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $employeeRole = Role::firstOrCreate(['name' => 'Employee', 'guard_name' => 'web']);

        // Assign permissions to roles
        $adminRole->givePermissionTo([
            'add_products',
            'edit_products',
            'delete_products',
            'show_users',
            'edit_users',
            'delete_users',
            'admin_users'
        ]);

        $employeeRole->givePermissionTo([
            'show_users',
            'edit_users'
        ]);

        // Assign Admin role to the first user
        $user = User::first();
        if ($user) {
            $user->assignRole('Admin');
        }
    }
}
