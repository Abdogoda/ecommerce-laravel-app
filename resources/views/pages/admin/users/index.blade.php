@extends('layouts.admin-app')

@section('content')
<div class="p-6 page-enter">
        <!-- Page Header -->
        <div class="mb-8">
          <div
            class="flex flex-col sm:flex-row sm:items-center sm:justify-between"
          >
            <div>
              <div
                class="flex gap-0 items-start flex-col sm:flex-row sm:gap-5 sm:items-center mb-2"
              >
                <h1 class="text-3xl font-bold text-white mb-2">
                  User Management
                </h1>
                <div class="flex items-center space-x-4">
                  <div id="breadcrumb" class="text-sm text-gray-400">
                    <a
                      href="../dashboard.html"
                      class="text-gray-400 hover:underline"
                      >Admin</a
                    >
                    <i class="fas fa-chevron-right mx-2"></i>
                    <span class="text-white">Users</span>
                  </div>
                </div>
              </div>
              <p class="text-gray-400">
                Manage user Users and permissions across the system
              </p>
            </div>
            <div class="mt-4 sm:mt-0 flex flex-col sm:flex-row gap-3">
              <button
                onclick="openModal('addUserModal')"
                class="btn-primary px-6 py-2 rounded-xl text-white font-medium flex items-center"
              >
                <i class="fas fa-plus mr-2"></i>
                Add User
              </button>
            </div>
          </div>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
          <div class="stats-card rounded-xl p-6 card-entrance delay-0">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-gray-400 text-sm font-medium">Total Users</p>
                <p class="text-3xl font-bold text-white mt-2">1,234</p>
                <p class="text-green-400 text-sm mt-1">
                  <i class="fas fa-arrow-up mr-1"></i>12% from last month
                </p>
              </div>
              <div
                class="icon w-12 h-12 bg-blue-500/20 rounded-full flex items-center justify-center"
              >
                <i class="fas fa-users text-blue-400 text-xl"></i>
              </div>
            </div>
          </div>

          <div class="stats-card rounded-xl p-6 card-entrance delay-100">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-gray-400 text-sm font-medium">Active Users</p>
                <p class="text-3xl font-bold text-white mt-2">982</p>
                <p class="text-green-400 text-sm mt-1">
                  <i class="fas fa-arrow-up mr-1"></i>8% from last month
                </p>
              </div>
              <div
                class="icon w-12 h-12 bg-green-500/20 rounded-full flex items-center justify-center"
              >
                <i class="fas fa-user-check text-green-400 text-xl"></i>
              </div>
            </div>
          </div>

          <div class="stats-card rounded-xl p-6 card-entrance delay-200">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-gray-400 text-sm font-medium">New This Month</p>
                <p class="text-3xl font-bold text-white mt-2">156</p>
                <p class="text-yellow-400 text-sm mt-1">
                  <i class="fas fa-arrow-up mr-1"></i>24% from last month
                </p>
              </div>
              <div
                class="icon w-12 h-12 bg-yellow-500/20 rounded-full flex items-center justify-center"
              >
                <i class="fas fa-user-plus text-yellow-400 text-xl"></i>
              </div>
            </div>
          </div>

          <div class="stats-card rounded-xl p-6 card-entrance delay-300">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-gray-400 text-sm font-medium">Admin Users</p>
                <p class="text-3xl font-bold text-white mt-2">12</p>
                <p class="text-purple-400 text-sm mt-1">
                  <i class="fas fa-minus mr-1"></i>No change
                </p>
              </div>
              <div
                class="icon w-12 h-12 bg-purple-500/20 rounded-full flex items-center justify-center"
              >
                <i class="fas fa-user-shield text-purple-400 text-xl"></i>
              </div>
            </div>
          </div>
        </div>

        <!-- Main Content Card -->
        <div class="admin-card rounded-xl p-6 slide-up delay-400">
          <!-- Header with Search and Add Button -->
          <div
            class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 space-y-4 sm:space-y-0"
          >
            <div>
              <h2 class="text-2xl font-bold text-white mb-2">
                User Management
              </h2>
              <p class="text-gray-400">Manage user accounts and permissions</p>
            </div>
          </div>

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
                    Joined
                  </th>
                  <th class="text-left py-4 px-4 font-medium text-gray-300">
                    Actions
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr class="table-row border-b border-gray-700/50">
                  <td class="py-4 px-4 text-gray-300">1</td>
                  <td class="py-4 px-4">
                    <div class="flex items-center space-x-3">
                      <div
                        class="user-avatar hidden md:flex w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold"
                      >
                        JD
                      </div>
                      <div>
                        <p class="text-white font-medium">John Doe</p>
                        <p class="text-gray-400 text-sm">ID: #001</p>
                      </div>
                    </div>
                  </td>
                  <td class="py-4 px-4 text-gray-300">john@example.com</td>
                  <td class="py-4 px-4">
                    <span
                      class="px-3 py-1 bg-green-500/20 text-green-400 rounded-full text-sm font-medium flex items-center w-fit"
                    >
                      <i class="fas fa-check-circle mr-1 text-xs"></i>
                      Verified
                    </span>
                  </td>
                  <td class="py-4 px-4">
                    <div class="flex flex-wrap gap-1">
                      <span
                        class="role-badge px-2 py-1 bg-red-500/20 text-red-400 rounded text-xs"
                        >Admin</span
                      >
                      <span
                        class="role-badge px-2 py-1 bg-blue-500/20 text-blue-400 rounded text-xs"
                        >User</span
                      >
                    </div>
                  </td>
                  <td class="py-4 px-4 text-gray-300">Jan 15, 2024</td>
                  <td class="py-4 px-4">
                    <div class="flex items-center space-x-2">
                      <button
                        onclick="
                          openEditModal(
                            1,
                            'John Doe',
                            'john@example.com',
                            [1, 2],
                          )
                        "
                        class="p-2 bg-blue-600/20 hover:bg-blue-600/30 text-blue-400 rounded-lg transition-all hover:scale-110"
                        title="Edit User"
                      >
                        <i class="fas fa-edit text-sm"></i>
                      </button>
                      <button
                        onclick="openRoleModal(1, [1, 2])"
                        class="p-2 bg-purple-600/20 hover:bg-purple-600/30 text-purple-400 rounded-lg transition-all hover:scale-110"
                        title="Change Roles"
                      >
                        <i class="fas fa-user-shield text-sm"></i>
                      </button>
                      <button
                        onclick="openDeleteModal(1, 'John Doe')"
                        class="p-2 bg-red-600/20 hover:bg-red-600/30 text-red-400 rounded-lg transition-all hover:scale-110"
                        title="Delete User"
                      >
                        <i class="fas fa-trash text-sm"></i>
                      </button>
                    </div>
                  </td>
                </tr>

                <tr class="table-row border-b border-gray-700/50">
                  <td class="py-4 px-4 text-gray-300">2</td>
                  <td class="py-4 px-4">
                    <div class="flex items-center space-x-3">
                      <div
                        class="user-avatar hidden md:flex w-10 h-10 rounded-full bg-gradient-to-br from-green-500 to-blue-600 flex items-center justify-center text-white font-bold"
                      >
                        JS
                      </div>
                      <div>
                        <p class="text-white font-medium">Jane Smith</p>
                        <p class="text-gray-400 text-sm">ID: #002</p>
                      </div>
                    </div>
                  </td>
                  <td class="py-4 px-4 text-gray-300">jane@example.com</td>
                  <td class="py-4 px-4">
                    <span
                      class="px-3 py-1 bg-green-500/20 text-green-400 rounded-full text-sm font-medium flex items-center w-fit"
                    >
                      <i class="fas fa-check-circle mr-1 text-xs"></i>
                      Verified
                    </span>
                  </td>
                  <td class="py-4 px-4">
                    <div class="flex flex-wrap gap-1">
                      <span
                        class="role-badge px-2 py-1 bg-blue-500/20 text-blue-400 rounded text-xs"
                        >User</span
                      >
                    </div>
                  </td>
                  <td class="py-4 px-4 text-gray-300">Feb 3, 2024</td>
                  <td class="py-4 px-4">
                    <div class="flex items-center space-x-2">
                      <button
                        onclick="
                          openEditModal(
                            2,
                            'Jane Smith',
                            'jane@example.com',
                            [2],
                          )
                        "
                        class="p-2 bg-blue-600/20 hover:bg-blue-600/30 text-blue-400 rounded-lg transition-all hover:scale-110"
                        title="Edit User"
                      >
                        <i class="fas fa-edit text-sm"></i>
                      </button>
                      <button
                        onclick="openRoleModal(2, [2])"
                        class="p-2 bg-purple-600/20 hover:bg-purple-600/30 text-purple-400 rounded-lg transition-all hover:scale-110"
                        title="Change Roles"
                      >
                        <i class="fas fa-user-shield text-sm"></i>
                      </button>
                      <button
                        onclick="openDeleteModal(2, 'Jane Smith')"
                        class="p-2 bg-red-600/20 hover:bg-red-600/30 text-red-400 rounded-lg transition-all hover:scale-110"
                        title="Delete User"
                      >
                        <i class="fas fa-trash text-sm"></i>
                      </button>
                    </div>
                  </td>
                </tr>

                <tr class="table-row border-b border-gray-700/50">
                  <td class="py-4 px-4 text-gray-300">3</td>
                  <td class="py-4 px-4">
                    <div class="flex items-center space-x-3">
                      <div
                        class="user-avatar hidden md:flex w-10 h-10 rounded-full bg-gradient-to-br from-red-500 to-orange-600 flex items-center justify-center text-white font-bold"
                      >
                        MW
                      </div>
                      <div>
                        <p class="text-white font-medium">Mike Wilson</p>
                        <p class="text-gray-400 text-sm">ID: #003</p>
                      </div>
                    </div>
                  </td>
                  <td class="py-4 px-4 text-gray-300">mike@example.com</td>
                  <td class="py-4 px-4">
                    <span
                      class="px-3 py-1 bg-yellow-500/20 text-yellow-400 rounded-full text-sm font-medium flex items-center w-fit"
                    >
                      <i class="fas fa-clock mr-1 text-xs"></i>
                      Pending
                    </span>
                  </td>
                  <td class="py-4 px-4">
                    <div class="flex flex-wrap gap-1">
                      <span
                        class="role-badge px-2 py-1 bg-blue-500/20 text-blue-400 rounded text-xs"
                        >User</span
                      >
                    </div>
                  </td>
                  <td class="py-4 px-4 text-gray-300">Mar 12, 2024</td>
                  <td class="py-4 px-4">
                    <div class="flex items-center space-x-2">
                      <button
                        onclick="
                          openEditModal(
                            3,
                            'Mike Wilson',
                            'mike@example.com',
                            [2],
                          )
                        "
                        class="p-2 bg-blue-600/20 hover:bg-blue-600/30 text-blue-400 rounded-lg transition-all hover:scale-110"
                        title="Edit User"
                      >
                        <i class="fas fa-edit text-sm"></i>
                      </button>
                      <button
                        onclick="openRoleModal(3, [2])"
                        class="p-2 bg-purple-600/20 hover:bg-purple-600/30 text-purple-400 rounded-lg transition-all hover:scale-110"
                        title="Change Roles"
                      >
                        <i class="fas fa-user-shield text-sm"></i>
                      </button>
                      <button
                        onclick="openDeleteModal(3, 'Mike Wilson')"
                        class="p-2 bg-red-600/20 hover:bg-red-600/30 text-red-400 rounded-lg transition-all hover:scale-110"
                        title="Delete User"
                      >
                        <i class="fas fa-trash text-sm"></i>
                      </button>
                    </div>
                  </td>
                </tr>

                <tr class="table-row border-b border-gray-700/50">
                  <td class="py-4 px-4 text-gray-300">4</td>
                  <td class="py-4 px-4">
                    <div class="flex items-center space-x-3">
                      <div
                        class="user-avatar hidden md:flex w-10 h-10 rounded-full bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center text-white font-bold"
                      >
                        SJ
                      </div>
                      <div>
                        <p class="text-white font-medium">Sarah Johnson</p>
                        <p class="text-gray-400 text-sm">ID: #004</p>
                      </div>
                    </div>
                  </td>
                  <td class="py-4 px-4 text-gray-300">sarah@example.com</td>
                  <td class="py-4 px-4">
                    <span
                      class="px-3 py-1 bg-green-500/20 text-green-400 rounded-full text-sm font-medium flex items-center w-fit"
                    >
                      <i class="fas fa-check-circle mr-1 text-xs"></i>
                      Verified
                    </span>
                  </td>
                  <td class="py-4 px-4">
                    <div class="flex flex-wrap gap-1">
                      <span
                        class="role-badge px-2 py-1 bg-yellow-500/20 text-yellow-400 rounded text-xs"
                        >Manager</span
                      >
                      <span
                        class="role-badge px-2 py-1 bg-blue-500/20 text-blue-400 rounded text-xs"
                        >User</span
                      >
                    </div>
                  </td>
                  <td class="py-4 px-4 text-gray-300">Feb 28, 2024</td>
                  <td class="py-4 px-4">
                    <div class="flex items-center space-x-2">
                      <button
                        onclick="
                          openEditModal(
                            4,
                            'Sarah Johnson',
                            'sarah@example.com',
                            [2, 3],
                          )
                        "
                        class="p-2 bg-blue-600/20 hover:bg-blue-600/30 text-blue-400 rounded-lg transition-all hover:scale-110"
                        title="Edit User"
                      >
                        <i class="fas fa-edit text-sm"></i>
                      </button>
                      <button
                        onclick="openRoleModal(4, [2, 3])"
                        class="p-2 bg-purple-600/20 hover:bg-purple-600/30 text-purple-400 rounded-lg transition-all hover:scale-110"
                        title="Change Roles"
                      >
                        <i class="fas fa-user-shield text-sm"></i>
                      </button>
                      <button
                        onclick="openDeleteModal(4, 'Sarah Johnson')"
                        class="p-2 bg-red-600/20 hover:bg-red-600/30 text-red-400 rounded-lg transition-all hover:scale-110"
                        title="Delete User"
                      >
                        <i class="fas fa-trash text-sm"></i>
                      </button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Pagination -->
          <div
            class="flex flex-col sm:flex-row justify-between items-center mt-6 space-y-4 sm:space-y-0"
          >
            <div class="text-gray-400 text-sm">
              Showing 1 to 4 of 1,234 users
            </div>
            <nav class="flex items-center space-x-2">
              <button
                class="pagination-item px-3 py-2 bg-gray-700/50 hover:bg-gray-600/50 text-gray-300 hover:text-white rounded-lg transition-all"
              >
                <i class="fas fa-chevron-left"></i>
              </button>
              <button
                class="pagination-item px-3 py-2 bg-blue-600 text-white rounded-lg font-medium"
              >
                1
              </button>
              <button
                class="pagination-item px-3 py-2 bg-gray-700/50 hover:bg-gray-600/50 text-gray-300 hover:text-white rounded-lg transition-all"
              >
                2
              </button>
              <button
                class="pagination-item px-3 py-2 bg-gray-700/50 hover:bg-gray-600/50 text-gray-300 hover:text-white rounded-lg transition-all"
              >
                3
              </button>
              <span class="px-3 py-2 text-gray-400">...</span>
              <button
                class="pagination-item px-3 py-2 bg-gray-700/50 hover:bg-gray-600/50 text-gray-300 hover:text-white rounded-lg transition-all"
              >
                309
              </button>
              <button
                class="pagination-item px-3 py-2 bg-gray-700/50 hover:bg-gray-600/50 text-gray-300 hover:text-white rounded-lg transition-all"
              >
                <i class="fas fa-chevron-right"></i>
              </button>
            </nav>
          </div>
        </div>
      </div>
@endsection
