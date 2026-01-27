<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Departments;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        $admin = Admin::firstOrCreate(
            ['email' => 'admin@leelija.com'],
            [
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'fname' => 'Admin',
                'lname' => 'User',
                'address' => '123 Admin Street',
                'image' => 'default_admin.png'

            ]
        );

        // $role = Role::firstOrCreate(['name' => 'superadmin']);

        // $defaultPermissions = [
        //     'create users',
        //     'edit users',
        //     'delete users',
        //     'view reports'
        // ];

        // foreach ($defaultPermissions as $perm) {
        //     Permission::firstOrCreate(['name' => $perm]);
        // }

        $role = Role::firstOrCreate([
            'name' => 'superadmin',
            'guard_name' => 'admin'
        ]);

        $permissions = [
            'create users',
            'edit users',
            'delete users',
            'view reports',
            'view page',
            'edit page',
            'create page',
            'delete page',
            'view permission',
            'edit permission',
            'create permission',
            'delete permission',
            'view roles',
            'edit roles',
            'create roles',
            'delete roles',
            'view contact',
            'edit contact',
            'create contact',
            'delete contact',
            'view job',
            'edit job',
            'create job',
            'delete job',
            'view services',
            'edit services',
            'create services',
            'delete services'
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate([
                'name' => $perm,
                'guard_name' => 'admin'
            ]);
        }

        // Optional: Create permissions
        // Permission::firstOrCreate(['name' => 'your-permission']);

        $permissions = Permission::all();
        $role->syncPermissions($permissions);

        $admin->assignRole($role);

          $departments = [
            ['departments' => 'Engineering', 'status' => 1],
            ['departments' => 'Design', 'status' => 1],
            ['departments' => 'Digital Marketing', 'status' => 1]
        ];

        foreach ($departments as $data) {
            Departments::firstOrCreate(
                ['departments' => $data['departments']], // prevent duplicates
                ['status' => $data['status']]
            );
        }


        $this->command->info('Superadmin user, role, permission and departments created.');
    }
}
