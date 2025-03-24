<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User; 
use Illuminate\Support\Facades\Hash; 

class RoleSeeder extends Seeder
{
    public function run()
    {


        $employee = User::create([
            'name' => 'Employee User',
            'email' => 'employee@example.com',
            'password' => Hash::make('password123'),
            'role' => 'Employee',
        ]);
    
        $viewUsers = Permission::firstOrCreate(['name' => 'view_users']);
        $editUsers = Permission::firstOrCreate(['name' => 'edit_users']);
        $deleteUsers = Permission::firstOrCreate(['name' => 'delete_users']);

        
        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $employee = Role::firstOrCreate(['name' => 'Employee']);
        $user = Role::firstOrCreate(['name' => 'User']);

        
        $admin->givePermissionTo([$viewUsers, $editUsers, $deleteUsers]);
        $employee->givePermissionTo([$viewUsers, $editUsers]);
        $user->givePermissionTo([$viewUsers]);

        
        if (!User::where('email', 'admin@admin.com')->exists()) {
            $adminUser = User::create([
                'name' => 'Admin User',
                'email' => 'admin@admin.com',
                'password' => Hash::make('password123'),
                'role' => 'Admin',
            ]);
            $adminUser->assignRole('Admin');
        }
    }
}


