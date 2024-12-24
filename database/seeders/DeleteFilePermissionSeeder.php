<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class DeleteFilePermissionSeeder extends Seeder
{
    public function run()
    {
        $permissionsArray = [
            ['name' => 'delete ticket file', 'guard_name' => 'web', 'description' => 'امکان حذف فایل در تیکت ها']
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