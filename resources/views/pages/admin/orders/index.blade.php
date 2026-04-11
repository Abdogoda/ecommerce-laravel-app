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
                  Order Management
                </h1>
                <div class="flex items-center space-x-4">
                  <div id="breadcrumb" class="text-sm text-gray-400">
                    <a
                      href="../dashboard.html"
                      class="text-gray-400 hover:underline"
                      >Admin</a
                    >
                    <i class="fas fa-chevron-right mx-2"></i>
                    <span class="text-white">Orders</span>
                  </div>
                </div>
              </div>
              <p class="text-gray-400">
                Track and manage customer orders across the platform
              </p>
            </div>
            <div class="mt-4 sm:mt-0">
              <!-- Removed export and refresh buttons -->
            </div>
          </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
          <div class="admin-card rounded-xl p-6">
            <div class="flex items-center">
              <div
                class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center mr-4"
              >
                <i class="fas fa-shopping-cart text-blue-500 text-xl"></i>
              </div>
              <div>
                <p class="text-gray-400 text-sm">Total Orders</p>
                <p class="text-2xl font-bold text-white">48</p>
              </div>
            </div>
          </div>

          <div class="admin-card rounded-xl p-6">
            <div class="flex items-center">
              <div
                class="w-12 h-12 bg-green-500/20 rounded-xl flex items-center justify-center mr-4"
              >
                <i class="fas fa-dollar-sign text-green-500 text-xl"></i>
              </div>
              <div>
                <p class="text-gray-400 text-sm">Total Revenue</p>
                <p class="text-2xl font-bold text-white">$12,486</p>
              </div>
            </div>
          </div>

          <div class="admin-card rounded-xl p-6">
            <div class="flex items-center">
              <div
                class="w-12 h-12 bg-yellow-500/20 rounded-xl flex items-center justify-center mr-4"
              >
                <i class="fas fa-clock text-yellow-500 text-xl"></i>
              </div>
              <div>
                <p class="text-gray-400 text-sm">Pending Orders</p>
                <p class="text-2xl font-bold text-white">8</p>
              </div>
            </div>
          </div>

          <div class="admin-card rounded-xl p-6">
            <div class="flex items-center">
              <div
                class="w-12 h-12 bg-purple-500/20 rounded-xl flex items-center justify-center mr-4"
              >
                <i class="fas fa-truck text-purple-500 text-xl"></i>
              </div>
              <div>
                <p class="text-gray-400 text-sm">Shipped Orders</p>
                <p class="text-2xl font-bold text-white">15</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Orders Table -->
        <div class="admin-card rounded-xl overflow-hidden">
          <div class="p-6 border-b border-white/10">
            <div
              class="flex flex-col sm:flex-row sm:items-center sm:justify-between"
            >
              <h2 class="text-xl font-semibold text-white mb-4 sm:mb-0">
                Recent Orders
              </h2>
              <div class="flex items-center space-x-3">
                <select
                  id="statusFilter"
                  onchange="filterByStatus(this.value)"
                  class="glass bg-white/5 text-white border-0 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500"
                >
                  <option value="">All Status</option>
                  <option value="pending">Pending</option>
                  <option value="processing">Processing</option>
                  <option value="shipped">Shipped</option>
                  <option value="delivered">Delivered</option>
                  <option value="cancelled">Cancelled</option>
                </select>
              </div>
            </div>
          </div>

          <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full">
              <thead class="bg-white/5">
                <tr>
                  <th class="text-left py-4 px-6 text-gray-300 font-medium">
                    Order
                  </th>
                  <th class="text-left py-4 px-6 text-gray-300 font-medium">
                    Customer
                  </th>
                  <th class="text-left py-4 px-6 text-gray-300 font-medium">
                    Date
                  </th>
                  <th class="text-left py-4 px-6 text-gray-300 font-medium">
                    Total
                  </th>
                  <th class="text-left py-4 px-6 text-gray-300 font-medium">
                    Status
                  </th>
                </tr>
              </thead>
              <tbody id="ordersTableBody">
                <tr
                  class="border-b border-white/5 hover:bg-white/5 transition-colors"
                  data-order-id="1"
                >
                  <td class="py-4 px-6 text-nowrap">
                    <a
                      href="./show.html"
                      class="flex items-center text-white hover:text-purple-400 transition-colors"
                    >
                      <div
                        class="hidden md:flex w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center mr-3"
                      >
                        <i class="fas fa-receipt text-white"></i>
                      </div>
                      <div>
                        <p class="font-medium">#ORD-2024-001</p>
                      </div>
                    </a>
                  </td>
                  <td class="py-4 px-6">
                    <div class="flex items-center">
                      <div>
                        <a
                          href="../profile.html"
                          class="text-white hover:text-blue-400 transition-colors font-medium"
                          >John Doe</a
                        >
                        <p class="text-gray-400 text-sm">john@example.com</p>
                      </div>
                    </div>
                  </td>
                  <td class="py-4 px-6 text-nowrap">
                    <span class="text-white">Jan 15, 2024</span>
                    <br />
                    <span class="text-gray-400 text-sm">2:30 PM</span>
                  </td>
                  <td class="py-4 px-6">
                    <span class="text-green-400 font-semibold">$1,248.00</span>
                  </td>
                  <td class="py-4 px-6">
                    <span
                      class="inline-flex items-center gap-2 bg-yellow-500/20 text-yellow-400 px-3 py-1.5 rounded-full text-xs font-semibold border border-yellow-500/30 hover:bg-yellow-500/30 transition-colors cursor-default"
                    >
                      <i class="fas fa-clock text-xs"></i>
                      Pending
                    </span>
                  </td>
                </tr>

                <tr
                  class="border-b border-white/5 hover:bg-white/5 transition-colors"
                  data-order-id="2"
                >
                  <td class="py-4 px-6 text-nowrap">
                    <a
                      href="./show.html"
                      class="flex items-center text-white hover:text-purple-400 transition-colors"
                    >
                      <div
                        class="hidden md:flex w-10 h-10 bg-gradient-to-br from-green-500 to-teal-600 rounded-xl flex items-center justify-center mr-3"
                      >
                        <i class="fas fa-receipt text-white"></i>
                      </div>
                      <div>
                        <p class="font-medium">#ORD-2024-002</p>
                      </div>
                    </a>
                  </td>
                  <td class="py-4 px-6">
                    <div class="flex items-center">
                      <div>
                        <a
                          href="../profile.html"
                          class="text-white hover:text-blue-400 transition-colors font-medium"
                          >Jane Smith</a
                        >
                        <p class="text-gray-400 text-sm">jane@example.com</p>
                      </div>
                    </div>
                  </td>
                  <td class="py-4 px-6 text-nowrap">
                    <span class="text-white">Jan 14, 2024</span>
                    <br />
                    <span class="text-gray-400 text-sm">11:45 AM</span>
                  </td>
                  <td class="py-4 px-6">
                    <span class="text-green-400 font-semibold">$459.99</span>
                  </td>
                  <td class="py-4 px-6">
                    <span
                      class="inline-flex items-center gap-2 bg-blue-500/20 text-blue-400 px-3 py-1.5 rounded-full text-xs font-semibold border border-blue-500/30 hover:bg-blue-500/30 transition-colors cursor-default"
                    >
                      <i class="fas fa-cog text-xs"></i>
                      Processing
                    </span>
                  </td>
                </tr>

                <tr
                  class="border-b border-white/5 hover:bg-white/5 transition-colors"
                  data-order-id="3"
                >
                  <td class="py-4 px-6 text-nowrap">
                    <a
                      href="./show.html"
                      class="flex items-center text-white hover:text-purple-400 transition-colors"
                    >
                      <div
                        class="hidden md:flex w-10 h-10 bg-gradient-to-br from-purple-500 to-violet-600 rounded-xl flex items-center justify-center mr-3"
                      >
                        <i class="fas fa-receipt text-white"></i>
                      </div>
                      <div>
                        <p class="font-medium">#ORD-2024-003</p>
                      </div>
                    </a>
                  </td>
                  <td class="py-4 px-6">
                    <div class="flex items-center">
                      <div>
                        <a
                          href="../profile.html"
                          class="text-white hover:text-blue-400 transition-colors font-medium"
                          >Mike Johnson</a
                        >
                        <p class="text-gray-400 text-sm">mike@example.com</p>
                      </div>
                    </div>
                  </td>
                  <td class="py-4 px-6 text-nowrap">
                    <span class="text-white">Jan 13, 2024</span>
                    <br />
                    <span class="text-gray-400 text-sm">4:20 PM</span>
                  </td>
                  <td class="py-4 px-6">
                    <span class="text-green-400 font-semibold">$129.99</span>
                  </td>
                  <td class="py-4 px-6">
                    <span
                      class="inline-flex items-center gap-2 bg-green-500/20 text-green-400 px-3 py-1.5 rounded-full text-xs font-semibold border border-green-500/30 hover:bg-green-500/30 transition-colors cursor-default"
                    >
                      <i class="fas fa-check text-xs"></i>
                      Delivered
                    </span>
                  </td>
                </tr>

                <tr
                  class="border-b border-white/5 hover:bg-white/5 transition-colors"
                  data-order-id="4"
                >
                  <td class="py-4 px-6 text-nowrap">
                    <a
                      href="./show.html"
                      class="flex items-center text-white hover:text-purple-400 transition-colors"
                    >
                      <div
                        class="hidden md:flex w-10 h-10 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl flex items-center justify-center mr-3"
                      >
                        <i class="fas fa-receipt text-white"></i>
                      </div>
                      <div>
                        <p class="font-medium">#ORD-2024-004</p>
                      </div>
                    </a>
                  </td>
                  <td class="py-4 px-6">
                    <div class="flex items-center">
                      <div>
                        <a
                          href="../profile.html"
                          class="text-white hover:text-blue-400 transition-colors font-medium"
                          >Sarah Wilson</a
                        >
                        <p class="text-gray-400 text-sm">sarah@example.com</p>
                      </div>
                    </div>
                  </td>
                  <td class="py-4 px-6 text-nowrap">
                    <span class="text-white">Jan 12, 2024</span>
                    <br />
                    <span class="text-gray-400 text-sm">9:15 AM</span>
                  </td>
                  <td class="py-4 px-6">
                    <span class="text-green-400 font-semibold">$2,999.00</span>
                  </td>
                  <td class="py-4 px-6">
                    <span
                      class="inline-flex items-center gap-2 bg-blue-500/20 text-blue-400 px-3 py-1.5 rounded-full text-xs font-semibold border border-blue-500/30 hover:bg-blue-500/30 transition-colors cursor-default"
                    >
                      <i class="fas fa-truck text-xs"></i>
                      Shipped
                    </span>
                  </td>
                </tr>

                <tr
                  class="border-b border-white/5 hover:bg-white/5 transition-colors"
                  data-order-id="5"
                >
                  <td class="py-4 px-6 text-nowrap">
                    <a
                      href="./show.html"
                      class="flex items-center text-white hover:text-purple-400 transition-colors"
                    >
                      <div
                        class="hidden md:flex w-10 h-10 bg-gradient-to-br from-gray-500 to-slate-600 rounded-xl flex items-center justify-center mr-3"
                      >
                        <i class="fas fa-receipt text-white"></i>
                      </div>
                      <div>
                        <p class="font-medium">#ORD-2024-005</p>
                      </div>
                    </a>
                  </td>
                  <td class="py-4 px-6">
                    <div class="flex items-center">
                      <div>
                        <a
                          href="../profile.html"
                          class="text-white hover:text-blue-400 transition-colors font-medium"
                          >David Brown</a
                        >
                        <p class="text-gray-400 text-sm">david@example.com</p>
                      </div>
                    </div>
                  </td>
                  <td class="py-4 px-6 text-nowrap">
                    <span class="text-white">Jan 11, 2024</span>
                    <br />
                    <span class="text-gray-400 text-sm">6:45 PM</span>
                  </td>
                  <td class="py-4 px-6">
                    <span class="text-green-400 font-semibold">$89.99</span>
                  </td>
                  <td class="py-4 px-6">
                    <span
                      class="inline-flex items-center gap-2 bg-red-500/20 text-red-400 px-3 py-1.5 rounded-full text-xs font-semibold border border-red-500/30 hover:bg-red-500/30 transition-colors cursor-default"
                    >
                      <i class="fas fa-times text-xs"></i>
                      Cancelled
                    </span>
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
                Showing 1-5 of 48 orders
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
                class="glass px-3 py-1 rounded-lg text-gray-400 hover:text-white"
              >
                2
              </button>
              <button
                class="glass px-3 py-1 rounded-lg text-gray-400 hover:text-white"
              >
                3
              </button>
              <button
                class="glass px-3 py-1 rounded-lg text-gray-400 hover:text-white"
              >
                <i class="fas fa-chevron-right"></i>
              </button>
            </div>
          </div>
        </div>
@endsection
