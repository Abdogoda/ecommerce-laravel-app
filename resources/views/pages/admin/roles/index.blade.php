@extends('layouts.admin-app')

@section('content')
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
                  Role Management
                </h1>
                <div class="flex items-center space-x-4">
                  <div id="breadcrumb" class="text-sm text-gray-400">
                    <a
                      href="../dashboard.html"
                      class="text-gray-400 hover:underline"
                      >Admin</a
                    >
                    <i class="fas fa-chevron-right mx-2"></i>
                    <span class="text-white">Roles</span>
                  </div>
                </div>
              </div>
              <p class="text-gray-400">
                Manage user roles and permissions across the system
              </p>
            </div>
            <div class="mt-4 sm:mt-0 flex flex-col sm:flex-row gap-3">
              <button
                onclick="openModal('addModal')"
                class="btn-primary px-6 py-2 rounded-xl text-white font-medium flex items-center"
              >
                <i class="fas fa-plus mr-2"></i>
                Add Role
              </button>
            </div>
          </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
          <div class="admin-card rounded-xl p-6">
            <div class="flex items-center">
              <div
                class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center mr-4"
              >
                <i class="fas fa-user-shield text-blue-500 text-xl"></i>
              </div>
              <div>
                <p class="text-gray-400 text-sm">Total Roles</p>
                <p class="text-2xl font-bold text-white">3</p>
              </div>
            </div>
          </div>

          <div class="admin-card rounded-xl p-6">
            <div class="flex items-center">
              <div
                class="w-12 h-12 bg-green-500/20 rounded-xl flex items-center justify-center mr-4"
              >
                <i class="fas fa-users text-green-500 text-xl"></i>
              </div>
              <div>
                <p class="text-gray-400 text-sm">Total Users</p>
                <p class="text-2xl font-bold text-white">158</p>
              </div>
            </div>
          </div>

          <div class="admin-card rounded-xl p-6">
            <div class="flex items-center">
              <div
                class="w-12 h-12 bg-purple-500/20 rounded-xl flex items-center justify-center mr-4"
              >
                <i class="fas fa-key text-purple-500 text-xl"></i>
              </div>
              <div>
                <p class="text-gray-400 text-sm">Permissions</p>
                <p class="text-2xl font-bold text-white">14</p>
              </div>
            </div>
          </div>

          <div class="admin-card rounded-xl p-6">
            <div class="flex items-center">
              <div
                class="w-12 h-12 bg-orange-500/20 rounded-xl flex items-center justify-center mr-4"
              >
                <i class="fas fa-shield-alt text-orange-500 text-xl"></i>
              </div>
              <div>
                <p class="text-gray-400 text-sm">Active Roles</p>
                <p class="text-2xl font-bold text-white">3</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Roles Table -->
        <div class="admin-card rounded-xl overflow-hidden">
          <div class="p-6 border-b border-white/10">
            <div
              class="flex flex-col sm:flex-row sm:items-center sm:justify-between"
            >
              <h2 class="text-xl font-semibold text-white mb-4 sm:mb-0">
                System Roles
              </h2>
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
                    Status
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
                <tr
                  class="border-b border-white/5 hover:bg-white/5 transition-colors"
                  data-role-id="1"
                >
                  <td class="py-4 px-6">
                    <div class="flex items-center">
                      <div class="flex items-center">
                        <div
                          class="hidden md:flex w-10 h-10 bg-gradient-to-br from-red-500 to-pink-600 rounded-xl flex items-center justify-center mr-3"
                        >
                          <i class="fas fa-crown text-white"></i>
                        </div>
                        <div>
                          <p class="text-white font-medium">Admin</p>
                          <p class="text-gray-400 text-sm">
                            Full system access
                          </p>
                        </div>
                      </div>
                    </div>
                  </td>
                  <td class="py-4 px-6">
                    <span class="text-white">3</span>
                  </td>
                  <td class="py-4 px-6">14</td>
                  <td class="py-4 px-6">
                    <span
                      class="bg-green-500/20 text-green-400 px-2 py-1 rounded-lg text-sm"
                    >
                      Active
                    </span>
                  </td>
                  <td class="py-4 px-6">
                    <span class="text-gray-400">2024-01-15</span>
                  </td>
                  <td class="py-4 px-6">
                    <div class="flex items-center justify-center space-x-2">
                      <button
                        onclick="editRole(1, 'Admin')"
                        class="bg-yellow-500/20 text-yellow-400 p-2 rounded-lg hover:bg-yellow-500/30 transition-colors"
                        title="Edit Role"
                      >
                        <i class="fas fa-edit"></i>
                      </button>
                      <button
                        onclick="managePermissions(1)"
                        class="bg-blue-500/20 text-blue-400 p-2 rounded-lg hover:bg-blue-500/30 transition-colors"
                        title="Manage Permissions"
                      >
                        <i class="fas fa-key"></i>
                      </button>
                      <button
                        onclick="deleteRole(1)"
                        class="bg-red-500/20 text-red-400 p-2 rounded-lg hover:bg-red-500/30 transition-colors"
                        title="Delete Role"
                      >
                        <i class="fas fa-trash"></i>
                      </button>
                    </div>
                  </td>
                </tr>

                <tr
                  class="border-b border-white/5 hover:bg-white/5 transition-colors"
                  data-role-id="2"
                >
                  <td class="py-4 px-6">
                    <div class="flex items-center">
                      <div class="flex items-center">
                        <div
                          class="hidden md:flex w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center mr-3"
                        >
                          <i class="fas fa-user-tie text-white"></i>
                        </div>
                        <div>
                          <p class="text-white font-medium">Manager</p>
                          <p class="text-gray-400 text-sm">Management access</p>
                        </div>
                      </div>
                    </div>
                  </td>
                  <td class="py-4 px-6">
                    <span class="text-white">5</span>
                  </td>
                  <td class="py-4 px-6">8</td>
                  <td class="py-4 px-6">
                    <span
                      class="bg-green-500/20 text-green-400 px-2 py-1 rounded-lg text-sm"
                    >
                      Active
                    </span>
                  </td>
                  <td class="py-4 px-6">
                    <span class="text-gray-400">2024-01-20</span>
                  </td>
                  <td class="py-4 px-6">
                    <div class="flex items-center justify-center space-x-2">
                      <button
                        onclick="editRole(2, 'Manager')"
                        class="bg-yellow-500/20 text-yellow-400 p-2 rounded-lg hover:bg-yellow-500/30 transition-colors"
                        title="Edit Role"
                      >
                        <i class="fas fa-edit"></i>
                      </button>
                      <button
                        onclick="managePermissions(2)"
                        class="bg-blue-500/20 text-blue-400 p-2 rounded-lg hover:bg-blue-500/30 transition-colors"
                        title="Manage Permissions"
                      >
                        <i class="fas fa-key"></i>
                      </button>
                      <button
                        onclick="deleteRole(2)"
                        class="bg-red-500/20 text-red-400 p-2 rounded-lg hover:bg-red-500/30 transition-colors"
                        title="Delete Role"
                      >
                        <i class="fas fa-trash"></i>
                      </button>
                    </div>
                  </td>
                </tr>

                <tr
                  class="border-b border-white/5 hover:bg-white/5 transition-colors"
                  data-role-id="3"
                >
                  <td class="py-4 px-6">
                    <div class="flex items-center">
                      <div class="flex items-center">
                        <div
                          class="hidden md:flex w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center mr-3"
                        >
                          <i class="fas fa-user text-white"></i>
                        </div>
                        <div>
                          <p class="text-white font-medium">Customer</p>
                          <p class="text-gray-400 text-sm">Basic user access</p>
                        </div>
                      </div>
                    </div>
                  </td>
                  <td class="py-4 px-6">
                    <span class="text-white">150</span>
                  </td>
                  <td class="py-4 px-6">5</td>
                  <td class="py-4 px-6">
                    <span
                      class="bg-green-500/20 text-green-400 px-2 py-1 rounded-lg text-sm"
                    >
                      Active
                    </span>
                  </td>
                  <td class="py-4 px-6">
                    <span class="text-gray-400">2024-01-10</span>
                  </td>
                  <td class="py-4 px-6">
                    <div class="flex items-center justify-center space-x-2">
                      <button
                        onclick="editRole(3, 'Customer')"
                        class="bg-yellow-500/20 text-yellow-400 p-2 rounded-lg hover:bg-yellow-500/30 transition-colors"
                        title="Edit Role"
                      >
                        <i class="fas fa-edit"></i>
                      </button>
                      <button
                        onclick="managePermissions(3)"
                        class="bg-blue-500/20 text-blue-400 p-2 rounded-lg hover:bg-blue-500/30 transition-colors"
                        title="Manage Permissions"
                      >
                        <i class="fas fa-key"></i>
                      </button>
                      <button
                        onclick="deleteRole(3)"
                        class="bg-red-500/20 text-red-400 p-2 rounded-lg hover:bg-red-500/30 transition-colors"
                        title="Delete Role"
                      >
                        <i class="fas fa-trash"></i>
                      </button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Table Footer -->
          <div
            class="p-4 border-t border-white/10 flex items-center justify-between"
          >
            <div class="flex items-center space-x-4">
              <span class="text-gray-400 text-sm">
                Showing 1-3 of 3 roles
              </span>
              <select
                class="glass bg-white/5 text-white border-0 rounded-lg px-3 py-1 text-sm"
              >
                <option value="10">10 per page</option>
                <option value="25">25 per page</option>
                <option value="50">50 per page</option>
              </select>
            </div>

            <div class="flex items-center space-x-2">
              <button
                class="glass px-3 py-1 rounded-lg text-gray-400 hover:text-white disabled:opacity-50"
                disabled
              >
                <i class="fas fa-chevron-left"></i>
              </button>
              <span class="glass px-3 py-1 rounded-lg text-white">1</span>
              <button
                class="glass px-3 py-1 rounded-lg text-gray-400 hover:text-white disabled:opacity-50"
                disabled
              >
                <i class="fas fa-chevron-right"></i>
              </button>
            </div>
          </div>
        </div>
@endsection
