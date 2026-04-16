@extends('layouts.admin-app')

@section('content')
    <div class="p-6 page-enter">
        <!-- Breadcrumb & Back Button -->
        <div class="mb-6 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.users.index') }}" class="text-gray-400 hover:text-white transition-colors">
                    <i class="fas fa-arrow-left"></i> Users
                </a>
                <i class="fas fa-chevron-right text-gray-600"></i>
                <span class="text-white font-medium">{{ $user->name }}</span>
            </div>
            <div id="breadcrumb" class="text-sm text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:underline">Admin</a>
                <i class="fas fa-chevron-right mx-2"></i>
                <a href="{{ route('admin.users.index') }}" class="text-gray-400 hover:underline">Users</a>
                <i class="fas fa-chevron-right mx-2"></i>
                <span class="text-white">{{ $user->name }}</span>
            </div>
        </div>

        <!-- User Header Card -->
        <div class="admin-card rounded-xl p-6 mb-8 card-entrance">
            <div class="flex flex-col md:flex-row md:items-start gap-6">
                <!-- Avatar -->
                <div class="flex-shrink-0">
                    @if ($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}"
                            class="w-24 h-24 rounded-xl object-cover border-2 border-blue-500/50">
                    @else
                        <div
                            class="w-24 h-24 rounded-xl bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white text-4xl font-bold border-2 border-blue-500/50">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                    @endif
                </div>

                <!-- User Info -->
                <div class="flex-1 min-w-0">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h1 class="text-3xl font-bold text-white mb-2">{{ $user->name }}</h1>
                            <p class="text-gray-400 mb-4">
                                <i class="fas fa-envelope mr-2"></i>
                                <a href="mailto:{{ $user->email }}" class="hover:text-blue-400 transition-colors">
                                    {{ $user->email }}
                                </a>
                            </p>
                            @if ($user->phone)
                                <p class="text-gray-400 mb-4">
                                    <i class="fas fa-phone mr-2"></i>
                                    <a href="tel:{{ $user->phone }}" class="hover:text-blue-400 transition-colors">
                                        {{ $user->phone }}
                                    </a>
                                </p>
                            @endif
                        </div>
                        <div class="flex flex-col gap-2">
                            @if ($user->is_active)
                                <span class="px-4 py-2 bg-green-500/20 text-green-400 rounded-lg font-medium text-center">
                                    <i class="fas fa-check-circle mr-2"></i>Active
                                </span>
                            @else
                                <span class="px-4 py-2 bg-red-500/20 text-red-400 rounded-lg font-medium text-center">
                                    <i class="fas fa-times-circle mr-2"></i>Inactive
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Two Column Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Left Column - User Details (2 cols) -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Account Information -->
                <div class="admin-card rounded-xl p-6 card-entrance">
                    <h2 class="text-xl font-bold text-white mb-6 flex items-center">
                        <i class="fas fa-user-circle text-blue-500 mr-3"></i>
                        Account Information
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-gray-400 text-sm mb-2">Full Name</p>
                            <p class="text-white font-medium">{{ $user->name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm mb-2">Email Address</p>
                            <p class="text-white font-medium break-all">{{ $user->email }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm mb-2">Phone Number</p>
                            <p class="text-white font-medium">{{ $user->phone ?? 'Not provided' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm mb-2">Email Verified</p>
                            @if ($user->email_verified_at)
                                <p class="text-green-400 font-medium">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    {{ $user->email_verified_at->format('M d, Y H:i') }}
                                </p>
                            @else
                                <p class="text-yellow-400 font-medium">
                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                    Not verified
                                </p>
                            @endif
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm mb-2">User ID</p>
                            <p class="text-white font-medium font-mono">#{{ $user->id }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm mb-2">Status</p>
                            <p class="text-white font-medium">
                                {{ $user->is_active ? 'Active' : 'Inactive' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Dates Information -->
                <div class="admin-card rounded-xl p-6 card-entrance">
                    <h2 class="text-xl font-bold text-white mb-6 flex items-center">
                        <i class="fas fa-calendar-alt text-purple-500 mr-3"></i>
                        Timeline
                    </h2>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between pb-4 border-b border-white/10">
                            <div>
                                <p class="text-gray-400 text-sm">Account Created</p>
                                <p class="text-white font-medium">{{ $user->created_at->format('M d, Y') }}</p>
                            </div>
                            <span class="text-gray-500 text-sm">{{ $user->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="flex items-center justify-between pt-4">
                            <div>
                                <p class="text-gray-400 text-sm">Last Updated</p>
                                <p class="text-white font-medium">{{ $user->updated_at->format('M d, Y') }}</p>
                            </div>
                            <span class="text-gray-500 text-sm">{{ $user->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Roles & Actions (1 col) -->
            <div class="space-y-6">
                <!-- User Roles -->
                <div class="admin-card rounded-xl p-6 card-entrance">
                    <h2 class="text-xl font-bold text-white mb-6 flex items-center">
                        <i class="fas fa-user-shield text-orange-500 mr-3"></i>
                        Roles
                    </h2>
                    @if ($user->roles->count() > 0)
                        <div class="space-y-2">
                            @foreach ($user->roles as $role)
                                <div
                                    class="px-3 py-2 bg-orange-500/20 text-orange-400 rounded-lg text-sm font-medium flex items-center">
                                    <i class="fas fa-shield-alt mr-2"></i>
                                    {{ ucfirst($role->name) }}
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-400 text-sm text-center py-4">No roles assigned</p>
                    @endif
                </div>

                <!-- Quick Actions -->
                <div class="admin-card rounded-xl p-6 card-entrance">
                    <h2 class="text-xl font-bold text-white mb-6 flex items-center">
                        <i class="fas fa-bolt text-yellow-500 mr-3"></i>
                        Actions
                    </h2>
                    <div class="space-y-2">
                        @can(\App\Enums\PermissionEnum::EDIT_USERS->value)
                            <button onclick="openModal('editUserModal')"
                                class="block w-full px-4 py-2 bg-blue-600/20 hover:bg-blue-600/30 text-blue-400 rounded-lg transition-colors text-center font-medium">
                                <i class="fas fa-edit mr-2"></i>Edit User
                            </button>
                        @endcan
                        @can(\App\Enums\PermissionEnum::ASSIGN_ROLES->value)
                            <button onclick="openRoleModal({{ $user->id }}, {{ $user->roles->pluck('id')->toJson() }})"
                                class="w-full px-4 py-2 bg-purple-600/20 hover:bg-purple-600/30 text-purple-400 rounded-lg transition-colors font-medium">
                                <i class="fas fa-user-shield mr-2"></i>Manage Roles
                            </button>
                        @endcan
                        @can(\App\Enums\PermissionEnum::DELETE_USERS->value)
                            <button onclick="openDeleteModal({{ $user->id }}, '{{ $user->name }}')"
                                class="w-full px-4 py-2 bg-red-600/20 hover:bg-red-600/30 text-red-400 rounded-lg transition-colors font-medium">
                                <i class="fas fa-trash mr-2"></i>Delete User
                            </button>
                        @endcan
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Modals for Actions -->
    @can(\App\Enums\PermissionEnum::ASSIGN_ROLES->value)
        <!-- Role Assignment Modal -->
        <div id="roleModal" class="hidden fixed inset-0 z-50 backdrop-blur-sm items-center justify-center">
            <div class="modal-content bg-black/90 rounded-xl p-6 w-full max-w-md mx-4 animate-bounce-in">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-white">
                        <i class="fas fa-user-shield mr-2 text-purple-500"></i>
                        Assign Roles
                    </h3>
                    <button onclick="closeModal('roleModal')" class="text-gray-400 hover:text-white text-xl">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form action="{{ route('admin.users.assignRole', $user) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-3">Select Roles</label>
                        <div id="rolesList" class="space-y-2 max-h-64 overflow-y-auto">
                            <!-- Roles will be populated by JavaScript -->
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <button type="submit"
                            class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                            <i class="fas fa-save mr-2"></i>Save Roles
                        </button>
                        <button type="button" onclick="closeModal('roleModal')"
                            class="flex-1 px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg font-medium transition-colors">
                            Cancel
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

                <form method="POST" action="{{ route('admin.users.update', $user) }}" id="editUserForm" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Full Name</label>
                            <input type="text" id="edit_user_name" name="name" required value="{{ $user->name }}"
                                class="form-input w-full px-4 py-2 rounded-lg border border-gray-600 text-white placeholder-gray-400 focus:border-blue-500 focus:outline-none"
                                placeholder="Enter full name" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Email Address</label>
                            <input type="email" id="edit_user_email" name="email" required value="{{ $user->email }}"
                                class="form-input w-full px-4 py-2 rounded-lg border border-gray-600 text-white placeholder-gray-400 focus:border-blue-500 focus:outline-none"
                                placeholder="Enter email address" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Phone Number</label>
                            <input type="tel" id="edit_user_phone" name="phone" value="{{ $user->phone }}"
                                class="form-input w-full px-4 py-2 rounded-lg border border-gray-600 text-white placeholder-gray-400 focus:border-blue-500 focus:outline-none"
                                placeholder="Enter phone number" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Status</label>
                            <select id="edit_user_status" name="is_active"
                                class="form-input w-full px-4 py-2 rounded-lg border border-gray-600 text-white focus:border-blue-500 focus:outline-none">
                                <option {{ $user->is_active ? 'selected' : '' }} value="1">Active</option>
                                <option {{ !$user->is_active ? 'selected' : '' }} value="0">Inactive</option>
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


    @can(\App\Enums\PermissionEnum::DELETE_USERS->value)
        <!-- Delete User Modal -->
        <div id="deleteModal" class="hidden fixed inset-0 z-50 backdrop-blur-sm items-center justify-center">
            <div class="modal-content bg-black/90 rounded-xl p-6 w-full max-w-md mx-4 animate-bounce-in">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-white">
                        <i class="fas fa-exclamation-triangle mr-2 text-red-500"></i>
                        Delete User
                    </h3>
                    <button onclick="closeModal('deleteModal')" class="text-gray-400 hover:text-white text-xl">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <p class="text-gray-300 mb-6">Are you sure you want to delete <span id="deleteUserName"
                        class="font-bold"></span>? This action cannot be undone.</p>

                <form id="deleteForm" method="POST" class="space-y-4">
                    @csrf
                    @method('DELETE')
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Confirm with your password</label>
                        <input type="password" name="password" required
                            class="w-full px-4 py-2 bg-gray-700 text-white rounded-lg border border-gray-600 focus:outline-none focus:border-red-500"
                            placeholder="Enter your password" />
                    </div>
                    <div class="flex gap-3">
                        <button type="submit"
                            class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors">
                            <i class="fas fa-trash mr-2"></i>Delete User
                        </button>
                        <button type="button" onclick="closeModal('deleteModal')"
                            class="flex-1 px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg font-medium transition-colors">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endcan

    <script>
        // Available roles
        const availableRoles = @json(\Spatie\Permission\Models\Role::all());
        const userRoleIds = new Set();

        function openRoleModal(userId, roleIds) {
            userRoleIds.clear();
            roleIds.forEach(id => userRoleIds.add(id));

            // Build roles list
            const rolesList = document.getElementById('rolesList');
            rolesList.innerHTML = availableRoles.map(role => `
                <label class="flex items-center p-3 rounded-lg bg-white/5 hover:bg-white/10 transition-colors cursor-pointer">
                    <input type="checkbox" name="roles[]" value="${role.id}" 
                        ${userRoleIds.has(role.id) ? 'checked' : ''}
                        class="w-4 h-4 rounded border-gray-600 text-blue-600 focus:ring-blue-500 cursor-pointer">
                    <span class="ml-3 text-white font-medium">${role.name.charAt(0).toUpperCase() + role.name.slice(1)}</span>
                </label>
            `).join('');

            openModal('roleModal');
        }

        function openDeleteModal(userId, userName) {
            document.getElementById('deleteUserName').textContent = userName;
            document.getElementById('deleteForm').action = `{{ route('admin.users.destroy', ':id') }}`.replace(':id',
                userId);
            openModal('deleteModal');
        }

        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
            document.getElementById(modalId).classList.add('flex');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
            document.getElementById(modalId).classList.remove('flex');
        }

        // Close modals when clicking outside
        document.querySelectorAll('[id$="Modal"]').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModal(this.id);
                }
            });
        });
    </script>
@endsection
