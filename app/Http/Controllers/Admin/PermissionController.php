<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Services\Actions\Permission\GetList;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $this->authorizeRoleOrPermission('show permissions');

        $permissions = GetList::handle();

        $roles = Role::all();

        return view('admin.permissions.index', compact('permissions', 'roles'));
    }

    public function create()
    {
        $this->authorizeRoleOrPermission('create permissions');
        return view('admin.permissions.create');
    }

    public function store(PermissionRequest $request)
    {
        $this->authorizeRoleOrPermission('create permissions');

        $validated = $request->validationData();
        Permission::create($validated);

        return redirect()->route('admin.permissions.index')
            ->with('success', __('permission.permission_created_success'));
    }

    public function edit(Permission $permission)
    {
        $this->authorizeRoleOrPermission('update permissions');
        return view('admin.permissions.create', compact('permission'));
    }

    public function update(PermissionRequest $request, Permission $permission)
    {
        $this->authorizeRoleOrPermission('update permissions');

        $validated = $request->validationData();
        $permission->update($validated);

        return redirect()->route('admin.permissions.index')
            ->with('success', __('permission.permission_updated_success'));
    }

    public function destroy(Permission $permission)
    {
        $this->authorizeRoleOrPermission('delete permissions');
        $permission->delete();

        return redirect()->route('admin.permissions.index')
            ->with('success', __('permission.permission_is_deleted_success'));
    }
}
