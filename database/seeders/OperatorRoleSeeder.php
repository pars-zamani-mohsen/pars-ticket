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
        $role = Role::updateOrCreate(['name' => 'operator']);
        $role->givePermissionTo([
            'show tickets',
            'create tickets',
            'show tickets all-in-category',
            'create tickets for-user',
            'delete tickets files',
            'update tickets category',
            'show dashboard admin',
            'show users',
            'create users',
            '',
        ]);
    }
}
