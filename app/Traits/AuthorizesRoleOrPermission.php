<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

trait AuthorizesRoleOrPermission
{
    public function authorizeRoleOrPermission($roleOrPermission, $isAnd = false, $guard = null): void
    {
        if (Auth::guard($guard)->guest()) {
            throw UnauthorizedException::notLoggedIn();
        }

        $rolesOrPermissions = is_array($roleOrPermission)
            ? $roleOrPermission
            : explode('|', $roleOrPermission);

        if ($isAnd) {
            if (
                ! Auth::guard($guard)->user()->hasAllRoles($roleOrPermission) &&
                ! Auth::guard($guard)->user()->hasAllPermissions($rolesOrPermissions)
            ) {
                throw UnauthorizedException::forRolesOrPermissions($roleOrPermission);
            }
        } elseif (
            ! Auth::guard($guard)->user()->hasAnyRole($rolesOrPermissions) &&
            ! Auth::guard($guard)->user()->hasAnyPermission($rolesOrPermissions)
        ) {
            throw UnauthorizedException::forRolesOrPermissions($rolesOrPermissions);
        }
    }

    public function canAuthorizeRoleOrPermission($roleOrPermission, $isAnd = false, $guard = null): bool
    {
        if (Auth::guard($guard)->guest()) {
            return false;
        }
        $rolesOrPermissions = is_array($roleOrPermission)
            ? $roleOrPermission
            : explode('|', $roleOrPermission);

        if ($isAnd) {
            if (
                ! Auth::guard($guard)->user()->hasAllRoles($roleOrPermission) &&
                ! Auth::guard($guard)->user()->hasAllPermissions($rolesOrPermissions)
            ) {
                return false;
            }
        } elseif (
            ! Auth::guard($guard)->user()->hasAnyRole($rolesOrPermissions) &&
            ! Auth::guard($guard)->user()->hasAnyPermission($rolesOrPermissions)
        ) {
            return false;
        }

        return true;
    }

    public function isAdmin($roles = ['admin']): bool
    {
        return Auth::check() and Auth::user()->hasRole($roles);
    }
}
