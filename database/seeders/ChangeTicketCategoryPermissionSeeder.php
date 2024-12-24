<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class ChangeTicketCategoryPermissionSeeder extends Seeder
{
    public function run()
    {
        $permissionsArray = [
            ['name' => 'edit ticket category', 'guard_name' => 'web', 'description' => 'تغییر دسته بندی تیکت'],
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
