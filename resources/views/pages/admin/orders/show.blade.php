@extends('layouts.admin-app')

@section('content')
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center space-x-4">
            <div class="p-3 bg-gradient-to-br from-red-500 to-pink-600 rounded-xl">
                <i class="fas fa-receipt text-white text-xl"></i>
            </div>
            <div>
                <div class="flex gap-0 items-start flex-col mb-2">
                    <h1 class="text-3xl font-bold text-white mb-2">
                        Order #{{ $order->order_number }}
                    </h1>
                    <div class="flex items-center space-x-4">
                        <div id="breadcrumb" class="text-sm text-gray-400">
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:underline">Admin</a>
                            <i class="fas fa-chevron-right mx-2"></i>
                            <a href="{{ route('admin.orders.index') }}" class="text-gray-400 hover:underline">
                                Orders
                            </a>
                            <i class="fas fa-chevron-right mx-2"></i>
                            <span class="text-white">#{{ $order->order_number }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex space-x-3">
            <button onclick="openModal('updateStatusModal')"
                class="btn-primary px-6 py-3 rounded-xl text-white font-bold hover:scale-105 transition-transform">
                <i class="fas fa-edit mr-2"></i>
                Update Status
            </button>
            <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Are you sure you want to delete this order?')"
                    class="px-6 py-3 rounded-xl text-white font-bold bg-red-500 hover:bg-red-600 transition-colors">
                    <i class="fas fa-trash mr-2"></i>
                    Delete Order
                </button>
            </form>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="animate-slide-up">
        <div class="flex space-x-1 p-1 bg-white/5 rounded-xl mb-6">
            <button id="infoTabBtn" onclick="switchTab('infoTab')"
                class="tab-button active flex-1 py-3 px-4 rounded-lg text-white font-medium transition-all">
                <i class="fas fa-info-circle mr-2"></i>
                Order Info
            </button>
            <button id="itemsTabBtn" onclick="switchTab('itemsTab')"
                class="tab-button flex-1 py-3 px-4 rounded-lg text-gray-400 font-medium transition-all">
                <i class="fas fa-shopping-bag mr-2"></i>
                Order Items
            </button>
            <button id="statusesTabBtn" onclick="switchTab('statusesTab')"
                class="tab-button flex-1 py-3 px-4 rounded-lg text-gray-400 font-medium transition-all">
                <i class="fas fa-history mr-2"></i>
                Status History
            </button>
        </div>

        <!-- Order Information Tab -->
        <div id="infoTab" class="tab-content">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Order Details Card -->
                <div class="glass p-6 rounded-xl">
                    <div class="flex items-center mb-4">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-file-invoice text-white"></i>
                        </div>
                        <h3 class="text-xl font-bold text-white">
                            Order Information
                        </h3>
                    </div>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-2 border-b border-white/10">
                            <span class="text-gray-400">Order Number:</span>
                            <span class="font-bold text-blue-400">#{{ $order->order_number }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-white/10">
                            <span class="text-gray-400">Customer:</span>
                            <span class="text-white font-medium">
                                @if ($order->user)
                                    <a href="{{ route('admin.users.show', $order->user) }}"
                                        class="hover:text-blue-400">{{ $order->user->name }}</a>
                                @else
                                    {{ $order->first_name }} {{ $order->last_name }}
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-white/10">
                            <span class="text-gray-400">Email:</span>
                            <span class="text-white">{{ $order->email }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-white/10">
                            <span class="text-gray-400">Order Date:</span>
                            <span class="text-white">{{ $order->created_at->format('M d, Y g:i A') }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-white/10">
                            <span class="text-gray-400">Subtotal:</span>
                            <span class="text-white">${{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-white/10">
                            <span class="text-gray-400">Tax:</span>
                            <span class="text-white">${{ number_format($order->tax, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-white/10">
                            <span class="text-gray-400">Shipping:</span>
                            <span class="text-white">${{ number_format($order->shipping_cost, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-white/10">
                            <span class="text-gray-400">Total Amount:</span>
                            <span class="text-green-400 font-bold text-lg">${{ number_format($order->total, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-gray-400">Status:</span>
                            <span
                                class="px-3 py-1 text-sm font-medium rounded-full {{ $order->getStatusBadgeClass() }} border">
                                <i class="fas {{ $order->getStatusIcon() }} mr-1"></i>
                                {{ $order->getStatusLabel() }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Shipping Information Card -->
                <div class="glass p-6 rounded-xl">
                    <div class="flex items-center mb-4">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-green-500 to-teal-600 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-shipping-fast text-white"></i>
                        </div>
                        <h3 class="text-xl font-bold text-white">
                            Shipping Information
                        </h3>
                    </div>

                    <div class="space-y-4">
                        <div class="flex justify-between items-start py-2 border-b border-white/10">
                            <span class="text-gray-400">Name:</span>
                            <span class="text-white text-right">{{ $order->first_name }} {{ $order->last_name }}</span>
                        </div>
                        <div class="flex justify-between items-start py-2 border-b border-white/10">
                            <span class="text-gray-400">Address:</span>
                            <span class="text-white text-right">{{ $order->street_address }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-white/10">
                            <span class="text-gray-400">City:</span>
                            <span class="text-white">{{ $order->city }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-white/10">
                            <span class="text-gray-400">State:</span>
                            <span class="text-white">{{ $order->state }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-white/10">
                            <span class="text-gray-400">Country:</span>
                            <span class="text-white">{{ $order->country }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-white/10">
                            <span class="text-gray-400">ZIP Code:</span>
                            <span class="text-white">{{ $order->zip_code }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-gray-400">Phone:</span>
                            <span class="text-white">{{ $order->phone }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Items Tab -->
        <div id="itemsTab" class="tab-content hidden">
            <div class="glass p-6 rounded-xl">
                <div class="flex items-center mb-6">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-orange-500 to-red-600 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-shopping-bag text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white">Order Items</h3>
                </div>

                <!-- Order Items List -->
                <div class="space-y-4">
                    @forelse($order->items as $item)
                        <div class="glass p-4 rounded-xl border border-white/10">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    @if ($item->product && $item->product->getFirstMediaUrl('images'))
                                        <img src="{{ $item->product->getFirstMediaUrl('images') }}"
                                            class="w-16 h-16 rounded-lg object-cover" alt="{{ $item->product_name }}" />
                                    @else
                                        <div class="w-16 h-16 rounded-lg bg-gray-600 flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="text-lg font-semibold text-white">
                                                {{ $item->product_name }}
                                            </h4>
                                            @if ($item->product)
                                                <p class="text-sm text-gray-400">
                                                    <a href="{{ route('admin.products.show', $item->product) }}"
                                                        class="hover:text-blue-400">View Product</a>
                                                </p>
                                            @endif
                                        </div>
                                        <div class="text-right">
                                            <p class="font-bold text-green-400">${{ number_format($item->unit_price, 2) }}
                                            </p>
                                            <p class="text-sm text-gray-400">Qty: {{ $item->quantity }}</p>
                                            <p class="text-sm text-gray-300">Subtotal:
                                                ${{ number_format($item->unit_price * $item->quantity, 2) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <p class="text-gray-400">No items in this order</p>
                        </div>
                    @endforelse
                </div>

                <!-- Order Summary -->
                <div class="mt-6 pt-6 border-t border-white/10">
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">Subtotal:</span>
                            <span class="text-white">${{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">Tax:</span>
                            <span class="text-white">${{ number_format($order->tax, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">Shipping:</span>
                            <span class="text-white">${{ number_format($order->shipping_cost, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center pt-2 border-t border-white/10">
                            <span class="text-xl font-semibold text-white">Total Amount:</span>
                            <span class="text-2xl font-bold text-green-400">${{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status History Tab -->
        <div id="statusesTab" class="tab-content hidden">
            <div class="glass p-6 rounded-xl">
                <div class="flex items-center mb-6">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-history text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white">Status History</h3>
                </div>

                <!-- Status Timeline -->
                <div class="space-y-6">
                    @forelse($order->statuses()->latest('id')->get() as $index => $status)
                        @php
                            $isLatest = $index === 0;
                            $statusClasses = match ($status->name) {
                                'pending' => [
                                    'ringColor' => 'ring-yellow-500/20',
                                    'borderColor' => 'border-yellow-500',
                                    'textColor' => 'text-yellow-400',
                                    'bgColor' => 'bg-yellow-500/20',
                                    'icon' => 'fa-clock',
                                ],
                                'processing' => [
                                    'ringColor' => 'ring-blue-500/20',
                                    'borderColor' => 'border-blue-500',
                                    'textColor' => 'text-blue-400',
                                    'bgColor' => 'bg-blue-500/20',
                                    'icon' => 'fa-cog',
                                ],
                                'shipped' => [
                                    'ringColor' => 'ring-purple-500/20',
                                    'borderColor' => 'border-purple-500',
                                    'textColor' => 'text-purple-400',
                                    'bgColor' => 'bg-purple-500/20',
                                    'icon' => 'fa-truck',
                                ],
                                'delivered' => [
                                    'ringColor' => 'ring-green-500/20',
                                    'borderColor' => 'border-green-500',
                                    'textColor' => 'text-green-400',
                                    'bgColor' => 'bg-green-500/20',
                                    'icon' => 'fa-check-circle',
                                ],
                                'cancelled' => [
                                    'ringColor' => 'ring-red-500/20',
                                    'borderColor' => 'border-red-500',
                                    'textColor' => 'text-red-400',
                                    'bgColor' => 'bg-red-500/20',
                                    'icon' => 'fa-times-circle',
                                ],
                                default => [
                                    'ringColor' => 'ring-gray-500/20',
                                    'borderColor' => 'border-gray-500',
                                    'textColor' => 'text-gray-400',
                                    'bgColor' => 'bg-gray-500/20',
                                    'icon' => 'fa-info-circle',
                                ],
                            };
                        @endphp
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 flex flex-col items-center">
                                <div
                                    class="w-4 h-4 {{ $statusClasses['bgColor'] }} rounded-full ring-4 {{ $statusClasses['ringColor'] }}">
                                </div>
                            </div>
                            <div class="flex-1 glass p-4 rounded-xl border-l-4 {{ $statusClasses['borderColor'] }}">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <span
                                            class="inline-flex items-center gap-2 font-semibold cursor-default text-lg {{ $statusClasses['textColor'] }}">
                                            <i class="fas {{ $statusClasses['icon'] }}"></i>
                                            {{ ucfirst($status->name) }}
                                        </span>
                                        <p class="text-sm text-gray-400">
                                            {{ $status->created_at->format('M d, Y g:i A') }}
                                        </p>
                                    </div>
                                    @if ($isLatest)
                                        <span
                                            class="px-2 py-1 text-xs font-medium rounded-full {{ $statusClasses['bgColor'] }} {{ $statusClasses['textColor'] }} border"
                                            style="border-color: currentColor; border-opacity: 0.3;">
                                            Current
                                        </span>
                                    @endif
                                </div>
                                @if ($status->description)
                                    <p class="text-gray-300">
                                        {{ $status->description }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <p class="text-gray-400">No status history available</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Update Status Modal -->
    <div id="updateStatusModal"
        class="hidden fixed inset-0 bg-black/50 z-50 backdrop-blur-sm items-center justify-center">
        <div class="p-4 w-full max-w-md">
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

                <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-300 mb-2">Status <span
                                class="text-red-400">*</span></label>
                        <select id="status" name="status"
                            class="w-full glass px-4 py-3 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                            <option value="">Select Status</option>
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing
                            </option>
                            <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered
                            </option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled
                            </option>
                        </select>
                    </div>

                    <div class="flex items-center space-x-3 pt-4">
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
    </div>
@endsection
