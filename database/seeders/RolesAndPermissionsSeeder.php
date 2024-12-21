<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

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
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // ایجاد نقش‌های پایه
        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo([
            'view users',
            'create users',
            'edit users',
            'view roles',
            'view permissions'
        ]);

        $role = Role::create(['name' => 'user']);
        $role->givePermissionTo([
            'view users'
        ]);
    }
}
