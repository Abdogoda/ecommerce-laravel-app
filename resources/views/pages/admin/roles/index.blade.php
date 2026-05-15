@extends('layouts.admin-app')

@section('content')
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="flex gap-0 items-start flex-col sm:flex-row sm:gap-5 sm:items-center mb-2">
                    <h1 class="text-3xl font-bold text-white mb-2">
                        Role Management
                    </h1>
                    <div class="flex items-center space-x-4">
                        <div id="breadcrumb" class="text-sm text-gray-400">
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:underline">Admin</a>
                            <i class="fas fa-chevron-right mx-2"></i>
                            <span class="text-white">Roles</span>
                        </div>
                    </div>
                </div>
                <p class="text-gray-400">
                    Manage user roles and permissions across the system
                </p>
            </div>
            @can(\App\Enums\PermissionEnum::CREATE_ROLES->value)
                <div class="mt-4 sm:mt-0 flex flex-col sm:flex-row gap-3">
                    <button onclick="openModal('addModal')"
                        class="btn-primary px-6 py-2 rounded-xl text-white font-medium flex items-center">
                        <i class="fas fa-plus mr-2"></i>
                        Add Role
                    </button>
                </div>
            @endcan
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="admin-card rounded-xl p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-user-shield text-blue-500 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-400 text-sm">Total Roles</p>
                    <p class="text-2xl font-bold text-white">{{ $stats['total_roles'] }}</p>
                </div>
            </div>
        </div>

        <div class="admin-card rounded-xl p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-500/20 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-users text-green-500 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-400 text-sm">Total Users</p>
                    <p class="text-2xl font-bold text-white">{{ $stats['total_users'] }}</p>
                </div>
            </div>
        </div>

        <div class="admin-card rounded-xl p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-purple-500/20 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-key text-purple-500 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-400 text-sm">Permissions</p>
                    <p class="text-2xl font-bold text-white">{{ $stats['total_permissions'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Roles Table -->
    <div class="admin-card rounded-xl overflow-hidden">
        <div class="p-6 border-b border-white/10">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h2 class="text-xl font-semibold text-white">
                    System Roles
                </h2>
                <div class="flex gap-3">
                    <a href="{{ route('admin.roles.exportFiltered') }}"
                        class="btn-info px-6 py-2 rounded-lg text-white font-medium hover:shadow-xl transition-all duration-300"
                        title="Export currently displayed data">
                        <i class="fas fa-download mr-2"></i>Export Displayed
                    </a>
                    <a href="{{ route('admin.roles.exportAll') }}"
                        class="btn-success px-6 py-2 rounded-lg text-white font-medium hover:shadow-xl transition-all duration-300"
                        title="Export entire table">
                        <i class="fas fa-file-excel mr-2"></i>Export All
                    </a>
                </div>
            </div>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full">
                <thead class="bg-white/5">
                    <tr>
                        <th class="text-left py-4 px-6 text-gray-300 font-medium">
                            Role
                        </th>
                        <th class="text-left py-4 px-6 text-gray-300 font-medium">
                            Users
                        </th>
                        <th class="text-left py-4 px-6 text-gray-300 font-medium">
                            Permissions
                        </th>
                        <th class="text-left py-4 px-6 text-gray-300 font-medium">
                            Created
                        </th>
                        <th class="text-center py-4 px-6 text-gray-300 font-medium">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody id="rolesTableBody">
                    @forelse ($roles as $role)
                        <tr class="border-b border-white/5 hover:bg-white/5 transition-colors"
                            data-role-id="{{ $role->id }}">
                            <td class="py-4 px-6">
                                <p class="text-white font-medium">{{ $role->name }}</p>
                            </td>
                            <td class="py-4 px-6">
                                <span class="text-white">{{ $role->users->count() }}</span>
                            </td>
                            <td class="py-4 px-6">{{ $role->permissions->count() }}</td>
                            <td class="py-4 px-6">
                                <span class="text-gray-400">{{ $role->created_at->format('Y-m-d') }}</span>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center justify-center space-x-2">
                                    @can(\App\Enums\PermissionEnum::EDIT_ROLES->value)
                                        <button onclick="editRole({{ $role->id }}, {{ json_encode($role->name) }})"
                                            class="bg-yellow-500/20 text-yellow-400 p-2 rounded-lg hover:bg-yellow-500/30 transition-colors"
                                            title="Edit Role">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button
                                            onclick="managePermissions({{ $role->id }}, {{ json_encode($role->name) }}, {{ json_encode($role->permissions->pluck('name')) }})"
                                            class="bg-blue-500/20 text-blue-400 p-2 rounded-lg hover:bg-blue-500/30 transition-colors"
                                            title="Manage Permissions">
                                            <i class="fas fa-key"></i>
                                        </button>
                                    @endcan
                                    @can(\App\Enums\PermissionEnum::DELETE_ROLES->value)
                                        <button onclick="deleteRole({{ $role->id }}, {{ json_encode($role->name) }})"
                                            class="bg-red-500/20 text-red-400 p-2 rounded-lg hover:bg-red-500/30 transition-colors"
                                            title="Delete Role">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-4 px-6 text-center text-gray-400">
                                No roles found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- _____________ MODALS _____________ -->
    @can(\App\Enums\PermissionEnum::CREATE_ROLES->value)
        <!-- Add Role Modal -->
        <div id="addModal" class="hidden fixed inset-0 z-50 backdrop-blur-sm items-center justify-center">
            <div
                class="modal-content bg-black/90 rounded-xl p-6 w-full max-w-lg mx-4 animate-bounce-in transition-all duration-300">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center mr-3">
                            <i class="fas fa-plus text-white"></i>
                        </div>
                        <h3 class="text-xl font-bold text-white">Add New Role</h3>
                    </div>
                    <button onclick="closeModal('addModal')" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form action="{{ route('admin.roles.store') }}" method="POST" id="addForm" class="space-y-6">
                    @csrf
                    @method('POST')
                    <div>
                        <label for="roleName" class="block text-sm font-medium text-gray-300 mb-2">
                            Role Name <span class="text-red-400">*</span>
                        </label>
                        <input type="text" id="roleName" name="name" placeholder="Enter role name"
                            class="w-full px-4 py-3 glass bg-white/5 text-white placeholder-gray-400 rounded-xl border-0 focus:ring-2 focus:ring-blue-500 transition-all"
                            required />
                    </div>

                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" onclick="closeModal('addModal')"
                            class="px-6 py-2 glass bg-white/5 text-gray-300 rounded-xl hover:bg-white/10 transition-colors">
                            Cancel
                        </button>
                        <button type="submit" class="btn-primary px-6 py-2 rounded-xl text-white font-medium">
                            <i class="fas fa-plus mr-2"></i>
                            Create Role
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endcan

    @can(\App\Enums\PermissionEnum::EDIT_ROLES->value)
        <!-- Edit Role Modal -->
        <div id="editModal" class="hidden fixed inset-0 z-50 backdrop-blur-sm items-center justify-center">
            <div
                class="modal-content bg-black/90 rounded-xl p-6 w-full max-w-lg mx-4 animate-bounce-in transition-all duration-300">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-xl flex items-center justify-center mr-3">
                            <i class="fas fa-edit text-white"></i>
                        </div>
                        <h3 class="text-xl font-bold text-white">Edit Role</h3>
                    </div>
                    <button onclick="closeModal('editModal')" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form method="POST" id="editForm" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="editRoleName" class="block text-sm font-medium text-gray-300 mb-2">
                            Role Name <span class="text-red-400">*</span>
                        </label>
                        <input type="text" id="editRoleName" name="name" placeholder="Enter role name"
                            class="w-full px-4 py-3 glass bg-white/5 text-white placeholder-gray-400 rounded-xl border-0 focus:ring-2 focus:ring-blue-500 transition-all"
                            required />
                    </div>

                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" onclick="closeModal('editModal')"
                            class="px-6 py-2 glass bg-white/5 text-gray-300 rounded-xl hover:bg-white/10 transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                            class="bg-gradient-to-r from-yellow-500 to-orange-600 px-6 py-2 rounded-xl text-white font-medium hover:from-yellow-600 hover:to-orange-700 transition-all">
                            <i class="fas fa-save mr-2"></i>
                            Update Role
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endcan

    @can(\App\Enums\PermissionEnum::EDIT_ROLES->value)
        <!-- Manage Permissions Modal -->
        <div id="permissionsModal" class="hidden fixed inset-0 z-50 backdrop-blur-sm items-center justify-center">
            <form method="POST" id="permissionsForm"
                class="modal-content bg-black/90 rounded-xl p-6 w-full max-w-xl mx-4 animate-bounce-in transition-all duration-300 overflow-y-auto max-h-full">
                @csrf
                @method('PUT')
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl flex items-center justify-center mr-3">
                            <i class="fas fa-key text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">
                                Manage Role Permissions
                            </h3>
                            <p class="text-gray-400 text-sm" id="permissionRoleName">
                                Configure permissions for this role
                            </p>
                        </div>
                    </div>
                    <button type="button" onclick="closeModal('permissionsModal')"
                        class="text-gray-400 hover:text-white transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="flex items-start gap-3 flex-wrap">
                    @foreach ($permissions as $permission)
                        <div class="flex items-center">
                            <label
                                class="flex items-center gap-2 text-gray-300 px-4 py-2 border border-gray-600 hover:bg-gray-600 hover:text-white cursor-pointer transition-all rounded-lg has-[:checked]:bg-green-600 has-[:checked]:text-white has-[:checked]:border-green-600 capitalize">
                                <input type="checkbox" id="perm-{{ $permission->id }}" name="permissions[]"
                                    value="{{ $permission->name }}"
                                    class="appearance-none opacity-0 w-0 h-0 absolute cursor-pointer" />
                                {{ $permission->name }}
                            </label>
                        </div>
                    @endforeach
                </div>

                <div class="flex items-center justify-between mt-8 pt-6 border-t border-white/10">
                    <div class="flex items-center space-x-4">
                        <button type="button" onclick="selectAllPermissions()"
                            class="text-blue-400 hover:text-blue-300 text-sm font-medium">
                            Select All
                        </button>
                        <button type="button" onclick="clearAllPermissions()"
                            class="text-gray-400 hover:text-gray-300 text-sm font-medium">
                            Clear All
                        </button>
                    </div>
                    <div class="flex space-x-3">
                        <button type="button" onclick="closeModal('permissionsModal')"
                            class="px-6 py-2 glass bg-white/5 text-gray-300 rounded-xl hover:bg-white/10 transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                            class="bg-gradient-to-r from-purple-500 to-indigo-600 px-6 py-2 rounded-xl text-white font-medium hover:from-purple-600 hover:to-indigo-700 transition-all">
                            <i class="fas fa-save mr-2"></i>
                            Save Permissions
                        </button>
                    </div>
                </div>
            </form>
        </div>
    @endcan

    @can(\App\Enums\PermissionEnum::DELETE_ROLES->value)
        <!-- Delete Confirmation Modal -->
        <div id="deleteModal" class="hidden fixed inset-0 z-50 backdrop-blur-sm items-center justify-center">
            <form method="POST" id="delete-role-form"
                class="modal-content bg-black/90 rounded-xl p-6 w-full max-w-lg mx-4 animate-bounce-in transition-all duration-300">
                @csrf
                @method('DELETE')
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-red-500 to-pink-600 rounded-xl flex items-center justify-center mr-3">
                            <i class="fas fa-trash text-white"></i>
                        </div>
                        <h3 class="text-xl font-bold text-white">Delete Role</h3>
                    </div>
                    <button onclick="closeModal('deleteModal')" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="mb-6">
                    <div class="bg-red-500/10 border border-red-500/20 rounded-xl p-4 mb-4">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-triangle text-red-400 mr-3"></i>
                            <p class="text-red-400 font-medium">
                                Warning: This action cannot be undone!
                            </p>
                        </div>
                    </div>
                    <p class="text-gray-300" id="deleteMessage">
                        Are you sure you want to delete this role? All users with this role
                        will lose their permissions.
                    </p>
                </div>
                <div class="mb-6">
                    <input type="password" name="password" required id="password-required-input"
                        placeholder="Enter your password to confirm deletion"
                        class="w-full p-4 rounded-xl bg-gray-700/50 text-gray-100 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-300" />
                    @error('password')
                        <div class="text-red-300 text-sm mt-2 flex items-center">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('deleteModal')"
                        class="px-6 py-2 glass bg-white/5 text-gray-300 rounded-xl hover:bg-white/10 transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                        class="bg-gradient-to-r from-red-500 to-pink-600 px-6 py-2 rounded-xl text-white font-medium hover:from-red-600 hover:to-pink-700 transition-all">
                        <i class="fas fa-trash mr-2"></i>
                        Delete Role
                    </button>
                </div>
            </form>
        </div>
    @endcan
@endsection

@push('scripts')
    <script>
        // Role management functions
        function deleteRole(roleId, roleName) {
            document.getElementById('delete-role-form').action = `/admin/roles/${roleId}`;
            document.getElementById("deleteMessage").innerHTML =
                `Are you sure you want to delete the role "<strong>${roleName}</strong>"? All users with this role will lose their permissions.`;

            openModal("deleteModal");
        }

        function editRole(roleId, roleName) {
            document.getElementById('editForm').action = `/admin/roles/${roleId}`;
            document.getElementById("editRoleName").value = roleName;

            // Open the edit modal
            openModal("editModal");
        }

        function managePermissions(roleId, roleName, permissions) {
            document.getElementById('permissionsForm').action = `/admin/roles/${roleId}/permissions`;

            document.getElementById("permissionRoleName").textContent =
                `Configure permissions for ${roleName}`;

            const checkboxes = document.querySelectorAll(
                '#permissionsModal input[type="checkbox"]',
            );
            checkboxes.forEach((checkbox) => {
                if (permissions.includes(checkbox.value)) {
                    checkbox.checked = true;
                } else {
                    checkbox.checked = false;
                }
            });

            openModal("permissionsModal");
        }

        function selectAllPermissions() {
            const checkboxes = document.querySelectorAll(
                '#permissionsModal input[type="checkbox"]',
            );
            checkboxes.forEach((checkbox) => {
                checkbox.checked = true;
            });
        }

        function clearAllPermissions() {
            const checkboxes = document.querySelectorAll(
                '#permissionsModal input[type="checkbox"]',
            );
            checkboxes.forEach((checkbox) => {
                checkbox.checked = false;
            });
        }
    </script>
@endpush
