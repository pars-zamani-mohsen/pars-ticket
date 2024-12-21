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
        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo([
            'view users',
            'create users',
            'edit users',
            'view roles',
            'view permissions',
            'view tickets',
            'create tickets',
        ]);

        $role = Role::create(['name' => 'user']);
        $role->givePermissionTo([
            'view tickets',
            'create tickets',
            'edit tickets',
        ]);

        $user = User::find(1);

        $user->assignRole('super-admin');
    }
}
