<?php

declare(strict_types=1);

namespace App\Services\Actions\User;

use App\Models\Role;
use App\Models\User;

class RoleAndPermissionLevelAccess
{
    public function CheckRoleInUpdate(User $currentUser, User $targetUser): bool
    {
        if ($currentUser->hasRole('super-admin')) {
            return true;
        }

        if ($targetUser->hasRole('super-admin')) {
            return false;
        }

        if ($targetUser->hasRole('admin') && ! $currentUser->hasRole('super-admin')) {
            return false;
        }

        return true;
    }

    public function getRolesByAccessLevel(User $currentUser)
    {
        $roles = Role::all();

        if ($currentUser->hasRole('super-admin')) {
            return $roles;
        }

        if ($currentUser->hasRole('admin')) {
            return $roles->filter(function ($role) {
                return (
                    $role->name !== 'super-admin' &&
                    $role->name !== 'admin'
                );
            });
        }

        return $roles->filter(function ($role) use ($currentUser) {
            return $currentUser->hasRole($role->name);
        });
    }
}
