<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class CreateTicketForUserSeeder extends Seeder
{
    public function run()
    {
        $permissionsArray = [
            ['name' => 'create ticket for-user', 'guard_name' => 'web', 'description' => 'ایجاد تیکت برای کاربر'],
        ];

        foreach ($permissionsArray as $permission) {
            $permission = Permission::updateOrCreate(
                ['name' => $permission['name']],
                $permission
            );

            $role = Role::findByName('super-admin');

            $role->givePermissionTo($permission);
        }
    }
}
