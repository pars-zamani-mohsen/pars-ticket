<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\Actions\User\GetList;
use App\Services\Actions\User\RoleAndPermissionLevelAccess;
use App\Services\Cache\CategoryCache;
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
        $categories = CategoryCache::allActive(config('pars-ticket.cache.timeout-long'));

        return view('admin.users.create', compact('roles', 'categories'));
    }

    public function store(UserRequest $request)
    {
        $this->authorizeRoleOrPermission('create users');

        $validated = $request->validationData();
        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);
        if ($request->has('categories')) {
            $user->categories()->sync($request->categories);
        }

        if ($this->canAuthorizeRoleOrPermission('update users roles')) {
            $user->assignRole($request->roles);
        }


        return redirect()->route('admin.users.index')
            ->with('success', __('user.created_user_success'));
    }

    public function edit(User $user)
    {
        $this->authorizeRoleOrPermission('update users');

        $user->load('categories');
        $roles = (new RoleAndPermissionLevelAccess())->getRolesByAccessLevel(auth()->user());
        $categories = CategoryCache::allActive(config('pars-ticket.cache.timeout-long'));

        return view('admin.users.create', compact('user', 'roles', 'categories'));
    }

    public function update(UserRequest $request, User $user)
    {
        $this->authorizeRoleOrPermission('update users');

        if (! (new RoleAndPermissionLevelAccess())->CheckRoleInUpdate(auth()->user(), $user)) {
            return redirect()->route('admin.users.index')
                ->with('error', __('user.you_can_not_edit_this_user_message'));
        }

        $validated = $request->validationData();

        if ($validated['password'] ?? false) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);
        if ($request->has('categories')) {
            $user->categories()->sync($request->categories);
        }

        if ($this->canAuthorizeRoleOrPermission('update users roles')) {
            $user->syncRoles($request->roles);
        }

        return redirect()->route('admin.users.index')
            ->with('success', __('user.user_updated_success_message'));
    }

    public function destroy(User $user)
    {
        $this->authorizeRoleOrPermission('delete users');

        if (! (new RoleAndPermissionLevelAccess())->CheckRoleInUpdate(auth()->user(), $user)) {
            return redirect()->route('admin.users.index')
                ->with('error', __('user.you_can_not_deleted_user_message'));
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', __('user.user_deleted_success_message'));
    }
}
