<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Roles\CreateRoleRequest;
use App\Http\Requests\Admin\Roles\UpdateRolePermissionsRequest;
use App\Http\Requests\Admin\Roles\UpdateRoleRequest;
use App\Http\Requests\PasswordRequiredRequest;
use App\Models\User;
use App\Exports\RoleExport;
use App\Services\ExportService;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with(['permissions', 'users'])->get();
        $permissions = Permission::all();
        $stats = [
            'total_roles' => $roles->count(),
            'total_users' => User::count(),
            'total_permissions' => $permissions->count(),
        ];
        
        return view('pages.admin.roles.index', compact('roles', 'permissions', 'stats'));
    }

    public function store(CreateRoleRequest $request)
    {
        Role::create($request->validated());
        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully.');
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->update($request->validated());
        return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully.');
    }

    public function updatePermissions(UpdateRolePermissionsRequest $request, Role $role)
    {
        $role->syncPermissions($request->input('permissions', []));
        return redirect()->route('admin.roles.index')->with('success', 'Role permissions updated successfully.');
    }

    public function destroy(PasswordRequiredRequest $request, Role $role)
    {
        Role::destroy($role->id);
        return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully.');
    }

    public function exportFiltered()
    {
        $query = Role::with(['permissions', 'users']);
        return ExportService::exportFiltered($query, RoleExport::class);
    }

    public function exportAll()
    {
        return ExportService::exportAll(Role::class, RoleExport::class);
    }
}