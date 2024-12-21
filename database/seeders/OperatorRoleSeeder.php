<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class OperatorRoleSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        // ایجاد نقش‌های پایه
        $role = Role::create(['name' => 'operator']);
        $role->givePermissionTo([
            'view users',
            'view tickets',
            'create tickets',
        ]);
    }
}
