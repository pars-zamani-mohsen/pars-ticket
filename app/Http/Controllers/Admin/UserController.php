<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\Actions\User\GetList;
use App\Services\Actions\User\RoleAndPermissionLevelAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $this->authorizeRoleOrPermission('show users');
        $users = GetList::handle();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $this->authorizeRoleOrPermission('create users');

        $roles = (new RoleAndPermissionLevelAccess())->getRolesByAccessLevel(auth()->user());

        return view('admin.users.create', compact('roles'));
    }

    public function store(UserRequest $request)
    {
        $this->authorizeRoleOrPermission('create users');

        $validated = $request->validationData();
        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        if ($this->canAuthorizeRoleOrPermission('update users roles')) {
            $user->assignRole($request->roles);
        }


        return redirect()->route('admin.users.index')
            ->with('success', 'کاربر با موفقیت ایجاد شد.');
    }

    public function edit(User $user)
    {
        $this->authorizeRoleOrPermission('update tickets');

        $roles = (new RoleAndPermissionLevelAccess())->getRolesByAccessLevel(auth()->user());

        return view('admin.users.create', compact('user', 'roles'));
    }

    public function update(UserRequest $request, User $user)
    {
        $this->authorizeRoleOrPermission('update tickets');

        if (! (new RoleAndPermissionLevelAccess())->CheckRoleInUpdate(auth()->user(), $user)) {
            return redirect()->route('admin.users.index')
                ->with('error', 'شما اجازه ویرایش این کاربر را ندارید.');
        }

        $validated = $request->validationData();

        if ($validated['password'] ?? false) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        if ($this->canAuthorizeRoleOrPermission('update users roles')) {
            $user->syncRoles($request->roles);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'کاربر با موفقیت بروزرسانی شد.');
    }

    public function destroy(User $user)
    {
        $this->authorizeRoleOrPermission('delete users');

        if (! (new RoleAndPermissionLevelAccess())->CheckRoleInUpdate(auth()->user(), $user)) {
            return redirect()->route('admin.users.index')
                ->with('error', 'شما اجازه حذف این کاربر را ندارید.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'کاربر با موفقیت حذف شد.');
    }
}
