@extends('layouts.admin-app')

@section('content')
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="flex gap-0 items-start flex-col sm:flex-row sm:gap-5 sm:items-center mb-2">
                    <h1 class="text-3xl font-bold text-white mb-2">
                        Order Management
                    </h1>
                    <div class="flex items-center space-x-4">
                        <div id="breadcrumb" class="text-sm text-gray-400">
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:underline">Admin</a>
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
                <div class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-shopping-cart text-blue-500 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-400 text-sm">Total Orders</p>
                    <p class="text-2xl font-bold text-white">{{ $stats['total'] }}</p>
                </div>
            </div>
        </div>

        <div class="admin-card rounded-xl p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-500/20 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-dollar-sign text-green-500 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-400 text-sm">Total Revenue</p>
                    <p class="text-2xl font-bold text-white">${{ number_format($stats['revenue'], 2) }}</p>
                </div>
            </div>
        </div>

        <div class="admin-card rounded-xl p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-yellow-500/20 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-clock text-yellow-500 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-400 text-sm">Pending Orders</p>
                    <p class="text-2xl font-bold text-white">{{ $stats['pending'] }}</p>
                </div>
            </div>
        </div>

        <div class="admin-card rounded-xl p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-purple-500/20 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-truck text-purple-500 text-xl"></i>
                </div>
                <div>
                    <p class="text-gray-400 text-sm">Shipped Orders</p>
                    <p class="text-2xl font-bold text-white">{{ $stats['shipped'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="admin-card rounded-xl overflow-hidden">
        <div class="p-6 border-b border-white/10">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-xl font-semibold text-white mb-4 sm:mb-0">
                    All Orders
                </h2>
                <div class="flex items-center space-x-3">
                    <form method="GET" class="flex items-center space-x-3 flex-wrap">
                        <select name="status" onchange="this.form.submit()"
                            class="glass bg-white/5 text-white border-0 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing
                            </option>
                            <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered
                            </option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled
                            </option>
                        </select>

                        <!-- Export Buttons -->
                        <a href="{{ route('admin.orders.exportFiltered', request()->query()) }}"
                            class="btn-info px-6 py-2 rounded-lg text-white font-medium hover:shadow-xl transition-all duration-300"
                            title="Export currently displayed data">
                            <i class="fas fa-download mr-2"></i>Export Displayed
                        </a>
                        <a href="{{ route('admin.orders.exportAll') }}"
                            class="btn-success px-6 py-2 rounded-lg text-white font-medium hover:shadow-xl transition-all duration-300"
                            title="Export entire table">
                            <i class="fas fa-file-excel mr-2"></i>Export All
                        </a>
                    </form>
                    </form>
                </div>
            </div>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            @if ($orders->count() > 0)
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
                            <th class="text-left py-4 px-6 text-gray-300 font-medium">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody id="ordersTableBody">
                        @foreach ($orders as $order)
                            <tr class="border-b border-white/5 hover:bg-white/5 transition-colors"
                                data-order-id="{{ $order->id }}">
                                <td class="py-4 px-6 text-nowrap">
                                    <a href="{{ route('admin.orders.show', $order) }}"
                                        class="flex items-center text-white hover:text-purple-400 transition-colors">
                                        <div
                                            class="hidden md:flex w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl items-center justify-center mr-3">
                                            <i class="fas fa-receipt text-white"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium">#{{ $order->order_number }}</p>
                                        </div>
                                    </a>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center">
                                        <div>
                                            @if ($order->user)
                                                <a href="{{ route('admin.users.show', $order->user) }}"
                                                    class="text-white hover:text-blue-400 transition-colors font-medium">{{ $order->user->name }}</a>
                                                <p class="text-gray-400 text-sm">{{ $order->user->email }}</p>
                                            @else
                                                <p class="text-white font-medium">{{ $order->first_name }}
                                                    {{ $order->last_name }}</p>
                                                <p class="text-gray-400 text-sm">{{ $order->email }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-nowrap">
                                    <span class="text-white">{{ $order->created_at->format('M d, Y') }}</span>
                                    <br />
                                    <span class="text-gray-400 text-sm">{{ $order->created_at->format('g:i A') }}</span>
                                </td>
                                <td class="py-4 px-6">
                                    <span
                                        class="text-green-400 font-semibold">${{ number_format($order->total, 2) }}</span>
                                </td>
                                <td class="py-4 px-6">
                                    <span
                                        class="inline-flex items-center gap-2 {{ $order->getStatusBadgeClass() }} px-3 py-1.5 rounded-full text-xs font-semibold border hover:opacity-80 transition-opacity cursor-default">
                                        <i class="fas {{ $order->getStatusIcon() }} text-xs"></i>
                                        {{ $order->getStatusLabel() }}
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center space-x-2">
                                        <button
                                            onclick="updateOrderStatus('{{ $order->order_number }}', '{{ $order->status }}')"
                                            class="text-yellow-400 hover:text-yellow-300 transition-colors"
                                            title="Update Status">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('admin.orders.destroy', $order) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Are you sure you want to delete this order?')"
                                                class="text-red-400 hover:text-red-300 transition-colors"
                                                title="Delete Order">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-center py-16">
                    <i class="fas fa-inbox text-6xl text-gray-500/20 mb-4"></i>
                    <p class="text-gray-400">No orders found</p>
                </div>
            @endif
        </div>

        <!-- Table Footer with Pagination -->
        @if ($orders->count() > 0)
            <div class="p-4 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center space-x-4">
                    <span class="text-gray-400 text-sm">
                        Showing {{ $orders->firstItem() }}-{{ $orders->lastItem() }} of {{ $orders->total() }} orders
                    </span>
                </div>

                <div class="flex items-center space-x-2">
                    {{ $orders->links() }}
                </div>
            </div>
        @endif
    </div>
    <!-- Update Status Modal -->
    <div id="updateStatusModal" class="hidden fixed inset-0 z-50 backdrop-blur-sm items-center justify-center">
        <div
            class="modal-content bg-black/90 rounded-xl p-6 w-full max-w-md mx-4 animate-bounce-in transition-all duration-300">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-xl flex items-center justify-center mr-3">
                        <i class="fas fa-edit text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white">Update Order Status</h3>
                </div>
                <button onclick="closeModal('updateStatusModal')"
                    class="text-gray-400 hover:text-white transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form id="updateStatusForm" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="newStatus" class="block text-sm font-medium text-gray-300 mb-2">
                        New Status <span class="text-red-400">*</span>
                    </label>
                    <select id="newStatus" name="status"
                        class="w-full px-4 py-3 glass bg-white/5 text-white rounded-xl border-0 focus:ring-2 focus:ring-blue-500 transition-all"
                        required>
                        <option value="">Select Status</option>
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="shipped">Shipped</option>
                        <option value="delivered">Delivered</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>

                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" onclick="closeModal('updateStatusModal')"
                        class="px-6 py-2 glass bg-white/5 text-gray-300 rounded-xl hover:bg-white/10 transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                        class="bg-gradient-to-r from-yellow-500 to-orange-600 px-6 py-2 rounded-xl text-white font-medium hover:from-yellow-600 hover:to-orange-700 transition-all">
                        <i class="fas fa-save mr-2"></i>
                        Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function updateOrderStatus(orderNumber, status) {
            document.getElementById("updateStatusForm").action = `/admin/orders/${orderNumber}/status`;
            document.getElementById("newStatus").value = status;
            openModal("updateStatusModal");
        }
    </script>
@endpush
