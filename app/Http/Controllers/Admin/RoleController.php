<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Services\Actions\Role\GetList;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $this->authorizeRoleOrPermission('show roles');
        $roles = GetList::handle();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $this->authorizeRoleOrPermission('create roles');
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(RoleRequest $request)
    {
        $this->authorizeRoleOrPermission('create roles');

        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        return redirect()->route('admin.roles.index')
            ->with('success', 'نقش با موفقیت ایجاد شد.');
    }

    public function edit(Role $role)
    {
        $this->authorizeRoleOrPermission('update roles');
        $permissions = Permission::all();
        return view('admin.roles.create', compact('role', 'permissions'));
    }

    public function update(RoleRequest $request, Role $role)
    {
        $this->authorizeRoleOrPermission('update roles');

        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        return redirect()->route('admin.roles.index')
            ->with('success', 'نقش با موفقیت ویرایش شد.');
    }

    public function destroy(Role $role)
    {
        $this->authorizeRoleOrPermission('delete roles');

        $role->delete();

        return redirect()->route('admin.roles.index')
            ->with('success', 'نقش با موفقیت حذف شد.');
    }
}
