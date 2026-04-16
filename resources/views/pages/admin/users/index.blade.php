@extends('layouts.admin-app')

@section('content')
    <div class="p-6 page-enter">
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <div class="flex gap-0 items-start flex-col sm:flex-row sm:gap-5 sm:items-center mb-2">
                        <h1 class="text-3xl font-bold text-white mb-2">
                            User Management
                        </h1>
                        <div class="flex items-center space-x-4">
                            <div id="breadcrumb" class="text-sm text-gray-400">
                                <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:underline">Admin</a>
                                <i class="fas fa-chevron-right mx-2"></i>
                                <span class="text-white">Users</span>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-400">
                        Manage user Users and permissions across the system
                    </p>
                </div>
                @can('create users')
                    <div class="mt-4 sm:mt-0 flex flex-col sm:flex-row gap-3">
                        <button onclick="openModal('addUserModal')"
                            class="btn-primary px-6 py-2 rounded-xl text-white font-medium flex items-center">
                            <i class="fas fa-plus mr-2"></i>
                            Add User
                        </button>
                    </div>
                @endcan
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="stats-card rounded-xl p-6 card-entrance ">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm font-medium">Total Users</p>
                        <p class="text-3xl font-bold text-white mt-2">{{ number_format($stats['total_users']) }}</p>
                    </div>
                    <div class="icon w-12 h-12 bg-blue-500/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-users text-blue-400 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="stats-card rounded-xl p-6 card-entrance ">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm font-medium">Active Users</p>
                        <p class="text-3xl font-bold text-white mt-2">{{ number_format($stats['active_users']) }}</p>
                    </div>
                    <div class="icon w-12 h-12 bg-green-500/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-user-check text-green-400 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="stats-card rounded-xl p-6 card-entrance ">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm font-medium">New This Month</p>
                        <p class="text-3xl font-bold text-white mt-2">{{ number_format($stats['new_users_this_month']) }}
                        </p>
                    </div>
                    <div class="icon w-12 h-12 bg-yellow-500/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-user-plus text-yellow-400 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="stats-card rounded-xl p-6 card-entrance ">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm font-medium">Admin Users</p>
                        <p class="text-3xl font-bold text-white mt-2">{{ number_format($stats['admin_users']) }}</p>
                    </div>
                    <div class="icon w-12 h-12 bg-purple-500/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-user-shield text-purple-400 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search & Filter Section -->
        <div class="admin-card rounded-xl p-6 mb-8 card-entrance">
            <form method="GET" action="{{ route('admin.users.index') }}" class="space-y-4">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-white">Search & Filter</h3>
                    @if (request()->hasAny(['search', 'status', 'role_id']))
                        <a href="{{ route('admin.users.index') }}" class="text-sm text-blue-400 hover:text-blue-300">
                            <i class="fas fa-times mr-1"></i>Clear Filters
                        </a>
                    @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <!-- Search Input -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Search Users</label>
                        <input type="text" name="search" placeholder="User name or email..."
                            value="{{ request('search') }}"
                            class="w-full px-4 py-2 bg-gray-700 text-white placeholder-gray-500 rounded-lg border border-gray-600 focus:outline-none focus:border-blue-500 transition-colors">
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Status</label>
                        <select name="status"
                            class="w-full px-4 py-2 bg-gray-700 text-white rounded-lg border border-gray-600 focus:outline-none focus:border-blue-500 transition-colors">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive
                            </option>
                        </select>
                    </div>

                    <!-- Role Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Role</label>
                        <select name="role_id"
                            class="w-full px-4 py-2 bg-gray-700 text-white rounded-lg border border-gray-600 focus:outline-none focus:border-blue-500 transition-colors">
                            <option value="">All Roles</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}"
                                    {{ request('role_id') == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Search Button -->
                <div class="flex gap-3">
                    <button type="submit"
                        class="btn-primary px-6 py-2 rounded-xl text-white font-medium flex items-center">
                        <i class="fas fa-search mr-2"></i>Search
                    </button>
                </div>
            </form>
        </div>

        <!-- Main Content Card -->
        <!-- Users Table -->
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-700">
                        <th class="text-left py-4 px-4 font-medium text-gray-300">
                            #
                        </th>
                        <th class="text-left py-4 px-4 font-medium text-gray-300">
                            User
                        </th>
                        <th class="text-left py-4 px-4 font-medium text-gray-300">
                            Email
                        </th>
                        <th class="text-left py-4 px-4 font-medium text-gray-300">
                            Status
                        </th>
                        <th class="text-left py-4 px-4 font-medium text-gray-300">
                            Roles
                        </th>
                        <th class="text-left py-4 px-4 font-medium text-gray-300">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="table-row border-b border-gray-700/50">
                            <td class="py-4 px-4 text-gray-300">{{ $loop->iteration }}</td>
                            <td class="py-4 px-4">
                                <div class="flex items-center space-x-3">
                                    @if ($user->avatar)
                                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}"
                                            class="user-avatar hidden md:flex w-10 h-10 rounded-full object-cover">
                                    @else
                                        <div
                                            class="user-avatar hidden md:flex w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 items-center justify-center text-white font-bold">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <p class="text-white font-medium">{{ $user->name }}</p>
                                        <p class="text-gray-400 text-sm">ID: #{{ $user->id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4 text-gray-300">{{ $user->email }}</td>
                            <td class="py-4 px-4">
                                @if ($user->is_active)
                                    <span
                                        class="px-3 py-1 bg-green-500/20 text-green-400 rounded-full text-sm font-medium flex items-center w-fit">
                                        <i class="fas fa-check-circle mr-1 text-xs"></i>
                                        Active
                                    </span>
                                @else
                                    <span
                                        class="px-3 py-1 bg-red-500/20 text-red-400 rounded-full text-sm font-medium flex items-center w-fit">
                                        <i class="fas fa-times mr-1 text-xs"></i>
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex flex-wrap gap-1">
                                    @forelse ($user->roles as $role)
                                        <span
                                            class="random-color-class role-badge px-2 py-1 rounded text-xs">{{ $role->name }}</span>
                                    @empty
                                        <span class="text-gray-500 text-sm">No roles assigned</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex items-center space-x-2">
                                    @can(\App\Enums\PermissionEnum::EDIT_USERS->value)
                                        <button
                                            onclick="openEditModal({{ $user->id }},'{{ $user->name }}','{{ $user->email }}','{{ $user->phone }}','{{ $user->is_active ? '1' : '0' }}')"
                                            class="p-2 bg-blue-600/20 hover:bg-blue-600/30 text-blue-400 rounded-lg transition-all hover:scale-110"
                                            title="Edit User">
                                            <i class="fas fa-edit text-sm"></i>
                                        </button>
                                    @endcan
                                    @can(\App\Enums\PermissionEnum::ASSIGN_ROLES->value)
                                        <button
                                            onclick="openRoleModal({{ $user->id }}, {{ $user->roles->pluck('id')->toJson() }})"
                                            class="p-2 bg-purple-600/20 hover:bg-purple-600/30 text-purple-400 rounded-lg transition-all hover:scale-110"
                                            title="Change Roles">
                                            <i class="fas fa-user-shield text-sm"></i>
                                        </button>
                                    @endcan
                                    @can(\App\Enums\PermissionEnum::DELETE_USERS->value)
                                        <button onclick="openDeleteModal({{ $user->id }}, '{{ $user->name }}')"
                                            class="p-2 bg-red-600/20 hover:bg-red-600/30 text-red-400 rounded-lg transition-all hover:scale-110"
                                            title="Delete User">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-4 px-4 text-center text-gray-500">
                                No users found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-white/10">
            {{ $users->links('pagination::tailwind') }}
        </div>
    </div>


    <!-- _____________ MODALS _____________ -->
    @can(\App\Enums\PermissionEnum::CREATE_USERS->value)
        <!-- Add User Modal -->
        <div id="addUserModal" class="hidden fixed inset-0 z-50 backdrop-blur-sm items-center justify-center">
            <div
                class="modal-content bg-black/90 rounded-xl p-6 w-full max-w-lg mx-4 animate-bounce-in transition-all duration-300">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-white">
                        <i class="fas fa-user-plus mr-2 text-blue-500"></i>
                        Add New User
                    </h3>
                    <button onclick="closeModal('addUserModal')"
                        class="text-gray-400 hover:text-white text-xl transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form action="{{ route('admin.users.store') }}" method="POST" id="addUserForm" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            Full Name
                            <span class="text-red-400 ml-1">*</span>
                        </label>
                        <input type="text" id="user_name" autofocus value="{{ old('name') }}" name="name" required
                            class="form-input w-full px-4 py-2 rounded-lg border border-gray-600 text-white placeholder-gray-400 focus:border-blue-500 focus:outline-none"
                            placeholder="Enter full name" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                Email Address
                                <span class="text-red-400 ml-1">*</span>
                            </label>
                            <input type="email" id="user_email" value="{{ old('email') }}" name="email" required
                                class="form-input w-full px-4 py-2 rounded-lg border border-gray-600 text-white placeholder-gray-400 focus:border-blue-500 focus:outline-none"
                                placeholder="Enter email address" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                Phone Number
                            </label>
                            <input type="tel" id="user_phone" value="{{ old('phone') }}" name="phone"
                                class="form-input w-full px-4 py-2 rounded-lg border border-gray-600 text-white placeholder-gray-400 focus:border-blue-500 focus:outline-none"
                                placeholder="Enter phone number" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                Password
                                <span class="text-gray-600 ml-1">Default: 12345678</span>
                            </label>
                            <input type="password" id="user_password" name="password"
                                title="Password must be at least 8 digits"
                                class="form-input w-full px-4 py-2 rounded-lg border border-gray-600 text-white placeholder-gray-400 focus:border-blue-500 focus:outline-none"
                                placeholder="Enter password" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">
                                Initial Role
                            </label>
                            <select id="user_role" name="role"
                                class="form-input w-full px-4 py-2 rounded-lg border border-gray-600 text-white focus:border-blue-500 focus:outline-none">
                                <option value="">Select Initial Role</option>
                                @foreach ($roles as $role)
                                    <option {{ old('role') == $role->name ? 'selected' : '' }} value="{{ $role->name }}">
                                        {{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" onclick="closeModal('addUserModal')"
                            class="px-6 py-2 bg-gray-600/50 hover:bg-gray-600/70 rounded-lg text-white font-medium transition-colors">
                            Cancel
                        </button>
                        <button type="submit" class="btn-primary px-6 py-2 rounded-lg text-white font-medium">
                            <i class="fas fa-plus mr-2"></i>
                            Add User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endcan

    @can(\App\Enums\PermissionEnum::EDIT_USERS->value)
        <!-- Edit User Modal -->
        <div id="editUserModal" class="hidden fixed inset-0 z-50 backdrop-blur-sm items-center justify-center">
            <div
                class="modal-content bg-black/90 rounded-xl p-6 w-full max-w-lg mx-4 animate-bounce-in transition-all duration-300">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-white">
                        <i class="fas fa-user-edit mr-2 text-yellow-500"></i>
                        Edit User
                    </h3>
                    <button onclick="closeModal('editUserModal')"
                        class="text-gray-400 hover:text-white text-xl transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form method="POST" id="editUserForm" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Full Name</label>
                            <input type="text" id="edit_user_name" name="name" required
                                class="form-input w-full px-4 py-2 rounded-lg border border-gray-600 text-white placeholder-gray-400 focus:border-blue-500 focus:outline-none"
                                placeholder="Enter full name" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Email Address</label>
                            <input type="email" id="edit_user_email" name="email" required
                                class="form-input w-full px-4 py-2 rounded-lg border border-gray-600 text-white placeholder-gray-400 focus:border-blue-500 focus:outline-none"
                                placeholder="Enter email address" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Phone Number</label>
                            <input type="tel" id="edit_user_phone" name="phone"
                                class="form-input w-full px-4 py-2 rounded-lg border border-gray-600 text-white placeholder-gray-400 focus:border-blue-500 focus:outline-none"
                                placeholder="Enter phone number" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Status</label>
                            <select id="edit_user_status" name="is_active"
                                class="form-input w-full px-4 py-2 rounded-lg border border-gray-600 text-white focus:border-blue-500 focus:outline-none">
                                <option selected value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            New Password
                            <span class="text-gray-600 ml-1">(leave empty to keep current)</span>
                        </label>
                        <input type="password" id="edit_user_password" name="password"
                            class="form-input w-full px-4 py-2 rounded-lg border border-gray-600 text-white placeholder-gray-400 focus:border-blue-500 focus:outline-none"
                            placeholder="Enter new password" />
                    </div>

                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" onclick="closeModal('editUserModal')"
                            class="px-6 py-2 bg-gray-600/50 hover:bg-gray-600/70 rounded-lg text-white font-medium transition-colors">
                            Cancel
                        </button>
                        <button type="submit" class="btn-warning px-6 py-2 rounded-lg text-white font-medium">
                            <i class="fas fa-save mr-2"></i>
                            Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endcan

    @can(\App\Enums\PermissionEnum::ASSIGN_ROLES->value)
        <!-- Role Management Modal -->
        <div id="roleModal" class="hidden fixed inset-0 z-50 backdrop-blur-sm items-center justify-center">
            <div
                class="modal-content bg-black/90 rounded-xl p-6 w-full max-w-md mx-4 animate-bounce-in transition-all duration-300">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-white">
                        <i class="fas fa-user-shield mr-2 text-purple-500"></i>
                        Change User Roles
                    </h3>
                    <button onclick="closeModal('roleModal')"
                        class="text-gray-400 hover:text-white text-xl transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form id="roleForm" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-3">Assign Roles</label>
                        @forelse ($roles as $role)
                            <div class="space-y-3 mb-3">
                                <label
                                    class="flex items-center space-x-3 cursor-pointer p-3 rounded-lg border border-gray-600 hover:border-blue-500 transition-colors">
                                    <input type="checkbox" id="role{{ $role->id }}" name="roles[]"
                                        value="{{ $role->name }}"
                                        class="w-4 h-4 text-red-600 bg-gray-800 border-gray-600 rounded focus:ring-red-500" />
                                    <div class="flex items-center space-x-2">
                                        <span class="text-white font-medium">{{ $role->name }}</span>
                                    </div>
                                    <span class="ml-auto text-xs text-gray-400">{{ $role->permissions->count() }}
                                        permissions</span>
                                </label>
                            </div>
                        @empty
                            <p class="text-gray-500 text-sm">No roles available. Please create roles first.</p>
                        @endforelse
                    </div>

                    <div class="bg-yellow-500/10 border border-yellow-500/20 rounded-lg p-3">
                        <div class="flex items-start space-x-2">
                            <i class="fas fa-exclamation-triangle text-yellow-500 mt-0.5"></i>
                            <div class="text-sm text-yellow-200">
                                <p class="font-medium">Important:</p>
                                <p>
                                    Changing roles will immediately affect user permissions. Make
                                    sure the user should have access to the selected roles.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" onclick="closeModal('roleModal')"
                            class="px-6 py-2 bg-gray-600/50 hover:bg-gray-600/70 rounded-lg text-white font-medium transition-colors">
                            Cancel
                        </button>
                        <button type="submit" class="btn-primary px-6 py-2 rounded-lg text-white font-medium">
                            <i class="fas fa-save mr-2"></i>
                            Update Roles
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endcan

    @can(\App\Enums\PermissionEnum::DELETE_USERS->value)
        <!-- Delete User Confirmation Modal -->
        <div id="deleteModal" class="hidden fixed inset-0 z-50 backdrop-blur-sm items-center justify-center">
            <div
                class="modal-content bg-black/90 rounded-xl p-6 w-full max-w-md mx-4 animate-bounce-in transition-all duration-300">
                <div>
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <div
                                class="w-10 h-10 bg-gradient-to-br from-red-500 to-pink-600 rounded-xl flex items-center justify-center mr-3">
                                <i class="fas fa-trash text-white"></i>
                            </div>
                            <h3 class="text-xl font-bold text-white">Delete User</h3>
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
                            Are you sure you want to delete this user?
                        </p>
                    </div>

                    <form method="POST">
                        @method('DELETE')
                        @csrf
                        <div class="mb-6">
                            <input type="password" name="password" required autofocus
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
                                class="px-6 py-2 bg-gray-600/50 hover:bg-gray-600/70 rounded-lg text-white font-medium transition-colors">
                                Cancel
                            </button>
                            <button type="submit" class="btn-danger px-6 py-2 rounded-lg text-white font-medium"
                                id="confirmDeleteBtn">
                                <i class="fas fa-trash mr-2"></i>
                                Delete User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan
@endsection

@push('scripts')
    <script>
        // Open Edit Modal
        function openEditModal(userId, userName, userEmail, userPhone, userStatus) {
            document.getElementById("edit_user_name").value = userName;
            document.getElementById("edit_user_email").value = userEmail;
            document.getElementById("edit_user_phone").value = userPhone;
            document.getElementById("edit_user_status").value = userStatus;
            console.log(userStatus);


            document.getElementById("editUserForm").action = `/admin/users/${userId}`;

            openModal("editUserModal");
            document.getElementById("edit_user_name").focus();
        }

        // Open Role Modal
        function openRoleModal(userId, userRoles) {
            document.getElementById("roleForm").action = `/admin/users/${userId}/roles`;

            document
                .querySelectorAll('input[name="roles[]"]')
                .forEach((checkbox) => {
                    checkbox.checked = false;
                });

            userRoles.forEach((roleId) => {
                const checkbox = document.getElementById("role" + roleId);
                if (checkbox) {
                    checkbox.checked = true;
                }
            });

            openModal("roleModal");
        }

        // Open Delete Modal
        function openDeleteModal(userId, userName) {
            document.getElementById("confirmDeleteBtn").formAction = `/admin/users/${userId}`;
            document.getElementById("deleteMessage").textContent =
                `Are you sure you want to delete "${userName}"? This action cannot be undone.`;
            openModal("deleteModal");
            document.querySelector("#deleteModal input[name='password']").focus();
        }
    </script>
@endpush
