<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;
use App\Services\Actions\User\GetList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $this->authorizeRoleOrPermission('view users');
        $users = GetList::handle();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $this->authorizeRoleOrPermission('create users');
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(UserRequest $request)
    {
        $this->authorizeRoleOrPermission('create users');

        $validated = $request->validationData();
        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);
        $user->assignRole($request->roles);


        return redirect()->route('admin.users.index')
            ->with('success', 'کاربر با موفقیت ایجاد شد.');
    }

    public function edit(User $user)
    {
        $this->authorizeRoleOrPermission('edit users');
        $roles = Role::all();
        return view('admin.users.create', compact('user', 'roles'));
    }

    public function update(UserRequest $request, User $user)
    {
        $this->authorizeRoleOrPermission('edit users');

        $validated = $request->validationData();

        if ($validated['password'] ?? false) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);
        $user->syncRoles($request->roles);

        return redirect()->route('admin.users.index')
            ->with('success', 'کاربر با موفقیت بروزرسانی شد.');
    }

    public function destroy(User $user)
    {
        $this->authorizeRoleOrPermission('delete users');
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'کاربر با موفقیت حذف شد.');
    }
}
