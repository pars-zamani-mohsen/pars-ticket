<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class CustomPermissionsSeeder extends Seeder
{
    public function run()
    {
        $permissionsArray = [
            ['name' => 'show tickets all', 'guard_name' => 'web', 'description' => 'نمایش همه تیکت ها'],
            ['name' => 'create tickets for-user', 'guard_name' => 'web', 'description' => 'ایجاد تیکت برای کاربر'],
            ['name' => 'update tickets category', 'guard_name' => 'web', 'description' => 'تغییر دسته بندی تیکت'],
            ['name' => 'delete tickets files', 'guard_name' => 'web', 'description' => 'امکان حذف فایل در تیکت ها'],
            ['name' => 'show dashboard admin', 'guard_name' => 'web', 'description' => 'نمایش پنل مدیریتی'],
            ['name' => 'update users roles', 'guard_name' => 'web', 'description' => 'اعطای نقش به کاربر'],
        ];

        foreach ($permissionsArray as $permission) {
            $permission = Permission::updateOrCreate(
                ['name' => $permission['name']],
                $permission
            );

            $role = Role::findByName('super-admin');

            $role->givePermissionTo($permission);

            $role = Role::findByName('admin');

            $role->givePermissionTo($permission);
        }
    }
}
