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
            'show users',
            'create users',
            'update tickets',
            'delete users',

            // مدیریت نقش‌ها
            'show roles',
            'create roles',
            'update roles',
            'delete roles',

            // مدیریت دسترسی‌ها
            'show permissions',
            'create permissions',
            'update permissions',
            'delete permissions',

            // مدیریت تیکت ها
            'show tickets',
            'create tickets',
            'update tickets',
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
            'show users',
            'create users',
            'update tickets',
            'show roles',
            'show permissions',
            'show tickets',
            'create tickets',
        ]);

        $user = User::firstOrCreate(
            ['email' => 'superadmin@pars.com'],
            [
                'name' => 'مدیر سیستم',
                'email' => config('pars-ticket.super_admin_user.username'),
                'mobile' => '09011292890',
                'password' => bcrypt(config('pars-ticket.super_admin_user.password')),
            ]
        );

        $user->assignRole('super-admin');
    }
}
