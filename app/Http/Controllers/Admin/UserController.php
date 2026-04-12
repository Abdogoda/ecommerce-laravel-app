<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\SyncUserRolesRequest;
use App\Http\Requests\Admin\Users\CreateUserRequest;
use App\Http\Requests\Admin\Users\UpdateUserRequest;
use App\Http\Requests\PasswordRequiredRequest;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->paginate(20);
        $roles = Role::all();
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('is_active', true)->count(),
            'new_users_this_month' => User::where('created_at', '>=', now()->startOfMonth())->count(),
            'admin_users' => User::permission('view dashboard')->count(),
        ];

        return view('pages.admin.users.index', compact('users', 'roles', 'stats'));
    }

    public function show(User $user)
    {
        return view('pages.admin.users.show', compact('user'));
    }

    public function store(CreateUserRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = $validated['password'] ? bcrypt($validated['password']) : bcrypt('12345678');
        
        $user = User::create($validated);
        
        if(isset($validated['role'])){
            $user->assignRole($validated['role']);
        }
        
        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('pages.admin.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();
        $validated['is_active'] = $validated['is_active'] === '1';

        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        if($user->email !== $validated['email']){
            $user->email_verified_at = null;
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(PasswordRequiredRequest $request, User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    public function assignRole(SyncUserRolesRequest $request, User $user)
    {
        $validated = $request->validated();
        $user->syncRoles($validated['roles']);
        
        return redirect()->route('admin.users.index')->with('success', 'User roles updated successfully.');
    }
}