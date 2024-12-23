<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // ایجاد دسترسی‌ها
        $permissions = [
            // مدیریت کاربران
            'view users',
            'create users',
            'edit users',
            'delete users',

            // مدیریت نقش‌ها
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',

            // مدیریت دسترسی‌ها
            'view permissions',
            'create permissions',
            'edit permissions',
            'delete permissions',

            // مدیریت تیکت ها
            'view tickets',
            'create tickets',
            'edit tickets',
            'delete tickets',
        ];

        foreach ($permissions as $permission) {
            $data = ['name' => $permission, 'guard_name' => 'web'];
            Permission::updateOrCreate(['name' => $data['name']], $data);
        }

        // ایجاد نقش‌های پایه
        $role = Role::updateOrCreate(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());

        $role = Role::updateOrCreate(['name' => 'admin']);
        $role->givePermissionTo([
            'view users',
            'create users',
            'edit users',
            'view roles',
            'view permissions',
            'view tickets',
            'create tickets',
        ]);

        $user = User::firstOrCreate(
            ['email' => 'superadmin@pars.com'],
            [
                'name' => 'مدیر سیستم',
                'email' => 'superadmin@pars.com',
                'mobile' => '09011292890',
                'password' => bcrypt('85gZ#X5&CE<W/j%UX)$C*p£')
            ]
        );

        $user->assignRole('super-admin');
    }
}
