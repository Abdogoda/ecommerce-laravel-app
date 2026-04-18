@extends('layouts.user-app')

@section('content')
    <main class="min-h-screen bg-gradient-to-br from-gray-900 to-gray-800 px-6 py-16">
        <div class="max-w-6xl mx-auto">
            <!-- Success Message and Cart Clear -->
            @if (session('success'))
                <div class="bg-green-500/10 border border-green-500/30 rounded-2xl p-6 mb-8 animate-fade-in">
                    <div class="flex items-start">
                        <i class="fas fa-check-circle text-green-400 text-xl mt-1 mr-4"></i>
                        <div>
                            <h3 class="text-green-400 font-semibold text-lg">Success!</h3>
                            <p class="text-green-300 mt-1">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
                <script>
                    // Clear cart on successful order
                    if (typeof localStorage !== 'undefined') {
                        localStorage.removeItem('cart');
                        // Dispatch event to update cart count across the page
                        window.dispatchEvent(new Event('cartUpdated'));
                    }
                </script>
            @endif

            <!-- Page Header -->
            <div class="text-center mb-12 animate-fade-in-up">
                <div
                    class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full mb-6 shadow-lg animate-float">
                    <i class="fas fa-receipt text-2xl text-white"></i>
                </div>
                <h1 class="text-4xl lg:text-5xl font-bold text-white mb-4">
                    <span class="bg-gradient-to-r from-blue-400 to-purple-500 bg-clip-text text-transparent">
                        Order Details
                    </span>
                </h1>
                <p class="text-xl text-gray-300 mb-2">Order #{{ $order->order_number }}</p>
                <div class="w-24 h-1 bg-gradient-to-r from-blue-400 to-purple-500 mx-auto rounded-full"></div>
            </div>

            <!-- Tab Navigation -->
            <div class="flex flex-wrap justify-center gap-4 mb-8 animate-fade-in-up delay-200">
                <button
                    class="tab-button glass px-6 py-3 rounded-xl text-white font-semibold transition-all duration-300 hover:bg-white/20 hover:scale-105 transform focus:outline-none focus:ring-2 focus:ring-blue-500/50"
                    onclick="showTab('info')">
                    <i class="fas fa-info-circle mr-2"></i>Order Info
                </button>
                <button
                    class="tab-button glass px-6 py-3 rounded-xl text-white font-semibold transition-all duration-300 hover:bg-white/20 hover:scale-105 transform focus:outline-none focus:ring-2 focus:ring-blue-500/50"
                    onclick="showTab('items')">
                    <i class="fas fa-shopping-bag mr-2"></i>Order Items
                </button>
                <button
                    class="tab-button glass px-6 py-3 rounded-xl text-white font-semibold transition-all duration-300 hover:bg-white/20 hover:scale-105 transform focus:outline-none focus:ring-2 focus:ring-blue-500/50"
                    onclick="showTab('statuses')">
                    <i class="fas fa-truck mr-2"></i>Order Status
                </button>
            </div>

            <!-- Order Information Tab -->
            <div id="infoTab" class="order-tab-content animate-fade-in-up delay-300">
                <div class="glass rounded-2xl p-8 shadow-2xl">
                    <h3 class="text-2xl font-bold text-white mb-8 flex items-center">
                        <i class="fas fa-file-invoice text-blue-400 mr-3"></i>
                        Order Information
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 bg-gray-800/50 rounded-xl">
                                <span class="text-gray-400 font-medium">Order Number:</span>
                                <span class="text-white font-bold">{{ $order->order_number }}</span>
                            </div>
                            <div class="flex items-center justify-between p-4 bg-gray-800/50 rounded-xl">
                                <span class="text-gray-400 font-medium">Placed on:</span>
                                <span class="text-white">{{ $order->created_at->format('M d, Y \a\t h:i A') }}</span>
                            </div>
                            <div class="flex items-center justify-between p-4 bg-gray-800/50 rounded-xl">
                                <span class="text-gray-400 font-medium">Total:</span>
                                <span
                                    class="text-2xl font-bold text-green-400">${{ number_format($order->total, 2) }}</span>
                            </div>
                            <div class="flex items-center justify-between p-4 bg-gray-800/50 rounded-xl">
                                <span class="text-gray-400 font-medium">Status:</span>
                                @php
                                    $statusConfig = [
                                        'pending' => ['color' => 'yellow', 'icon' => 'clock'],
                                        'processing' => ['color' => 'blue', 'icon' => 'cog'],
                                        'shipped' => ['color' => 'purple', 'icon' => 'truck'],
                                        'completed' => ['color' => 'green', 'icon' => 'check-circle'],
                                        'cancelled' => ['color' => 'red', 'icon' => 'times-circle'],
                                    ];
                                    $config = $statusConfig[$order->status] ?? [
                                        'color' => 'gray',
                                        'icon' => 'question-circle',
                                    ];
                                @endphp
                                <span
                                    class="px-3 py-1 bg-{{ $config['color'] }}-500/20 text-{{ $config['color'] }}-400 rounded-full text-sm font-semibold">
                                    <i class="fas fa-{{ $config['icon'] }} mr-1"></i>{{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="p-4 bg-gray-800/50 rounded-xl">
                                <h4 class="text-gray-400 font-medium mb-3">Shipping Address:</h4>
                                <p class="text-white leading-relaxed">
                                    {{ $order->first_name }} {{ $order->last_name }}<br />
                                    {{ $order->street_address }}<br />
                                    {{ $order->city }}, {{ $order->state }} {{ $order->zip_code }}<br />
                                    {{ $order->country }}
                                </p>
                            </div>
                            <div class="p-4 bg-gray-800/50 rounded-xl">
                                <h4 class="text-gray-400 font-medium mb-3">Contact Information:</h4>
                                <p class="text-white">
                                    <i class="fas fa-envelope mr-2"></i>{{ $order->email }}<br />
                                    <i class="fas fa-phone mr-2"></i>{{ $order->phone }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-4 mt-8">
                        <a href="{{ route('orders.index') }}"
                            class="bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white px-6 py-3 rounded-xl transition-all duration-300 hover:shadow-lg">
                            <i class="fas fa-arrow-left mr-2"></i>Back to Orders
                        </a>
                        <a href="{{ route('products.index') }}"
                            class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-6 py-3 rounded-xl transition-all duration-300 hover:shadow-lg hover:shadow-blue-500/25">
                            <i class="fas fa-shopping-bags mr-2"></i>Continue Shopping
                        </a>
                    </div>
                </div>
            </div>

            <!-- Order Items Tab -->
            <div id="itemsTab" class="order-tab-content hidden animate-fade-in-up delay-400">
                <div class="glass rounded-2xl p-8 shadow-2xl">
                    <h3 class="text-2xl font-bold text-white mb-8 flex items-center">
                        <i class="fas fa-shopping-bag text-purple-400 mr-3"></i>
                        Order Items
                    </h3>

                    @if ($order->items->count() > 0)
                        <div class="space-y-4">
                            @foreach ($order->items as $item)
                                <div
                                    class="bg-gray-800/50 backdrop-blur-sm rounded-xl p-6 hover:bg-gray-800/70 transition-all duration-300">
                                    <div class="flex items-center space-x-6">
                                        <div class="flex-shrink-0">
                                            @if ($item->product && $item->product->media->first())
                                                <img src="{{ $item->product->media->first()->getUrl() }}"
                                                    class="w-20 h-20 object-cover rounded-xl shadow-lg"
                                                    alt="{{ $item->product_name }}" />
                                            @else
                                                <div
                                                    class="w-20 h-20 bg-gray-700 rounded-xl flex items-center justify-center">
                                                    <i class="fas fa-image text-gray-600"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="text-lg font-semibold text-white mb-2">
                                                {{ $item->product_name }}
                                            </h4>
                                            <div class="flex items-center space-x-4 text-sm text-gray-400">
                                                <span>Quantity:
                                                    <span
                                                        class="text-white font-medium">{{ $item->quantity }}</span></span>
                                                <span>Price:
                                                    <span
                                                        class="text-green-400 font-bold">${{ number_format($item->unit_price, 2) }}</span></span>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-2xl font-bold text-green-400">
                                                ${{ number_format($item->subtotal, 2) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <!-- Order Summary -->
                            <div class="border-t border-gray-700 pt-6 mt-6 space-y-3">
                                <div class="flex justify-between text-gray-300">
                                    <span>Subtotal:</span>
                                    <span>${{ number_format($order->subtotal, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-gray-300">
                                    <span>Shipping:</span>
                                    <span>${{ number_format($order->shipping_cost, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-gray-300">
                                    <span>Tax:</span>
                                    <span>${{ number_format($order->tax, 2) }}</span>
                                </div>
                                <div class="border-t border-gray-600 pt-3">
                                    <div class="flex justify-between items-center text-xl">
                                        <span class="font-semibold text-white">Total Amount:</span>
                                        <span
                                            class="font-bold text-3xl text-green-400">${{ number_format($order->total, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-400">No items in this order</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Order Status Tab -->
            <div id="statusesTab" class="order-tab-content hidden animate-fade-in-up delay-500">
                <div class="glass rounded-2xl p-8 shadow-2xl">
                    <h3 class="text-2xl font-bold text-white mb-8 flex items-center">
                        <i class="fas fa-truck text-orange-400 mr-3"></i>
                        Order Status History
                    </h3>

                    <div class="relative">
                        <!-- Status Timeline -->
                        @php
                            $statusProgression = ['pending', 'processing', 'shipped', 'completed'];
                            $statusConfig = [
                                'pending' => ['color' => 'yellow', 'icon' => 'clock', 'label' => 'Pending', 'message' => 'Order has been placed and is awaiting confirmation'],
                                'processing' => ['color' => 'blue', 'icon' => 'cog', 'label' => 'Processing', 'message' => 'Order is being prepared for shipment'],
                                'shipped' => ['color' => 'purple', 'icon' => 'truck', 'label' => 'Shipped', 'message' => 'Your order is on the way'],
                                'completed' => ['color' => 'green', 'icon' => 'check-circle', 'label' => 'Completed', 'message' => 'Order has been delivered successfully'],
                            ];
                            
                            // Get current status index
                            $currentStatusIndex = array_search($order->status, $statusProgression);
                            // Get statuses that have happened (up to current status)
                            $completedStatuses = array_slice($statusProgression, 0, $currentStatusIndex + 1);
                        @endphp

                        @if (count($completedStatuses) > 0)
                            <div class="space-y-8">
                                @foreach ($completedStatuses as $index => $status)
                                    <div class="relative flex items-start">
                                        <div
                                            class="flex-shrink-0 w-16 h-16 bg-gradient-to-br from-{{ $statusConfig[$status]['color'] }}-500 to-{{ $statusConfig[$status]['color'] }}-600 rounded-full flex items-center justify-center shadow-lg">
                                            <i class="fas fa-{{ $statusConfig[$status]['icon'] }} {{ $status === 'processing' && $order->status === 'processing' ? 'fa-spin' : '' }} text-white text-xl"></i>
                                        </div>
                                        <div class="ml-6 bg-gray-800/50 backdrop-blur-sm rounded-xl p-6 flex-1">
                                            <div class="flex items-center justify-between mb-2">
                                                <h4 class="text-lg font-semibold text-{{ $statusConfig[$status]['color'] }}-400">
                                                    {{ $statusConfig[$status]['label'] }}
                                                </h4>
                                                <span class="text-sm text-gray-400">
                                                    @if ($status === 'pending')
                                                        {{ $order->created_at->format('M d, Y h:i A') }}
                                                    @else
                                                        {{ now()->format('M d, Y h:i A') }}
                                                    @endif
                                                </span>
                                            </div>
                                            <p class="text-gray-300">
                                                {{ $statusConfig[$status]['message'] }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <p class="text-gray-400">No status history available</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Return to Orders Button -->
            <div class="text-center mt-12">
                <a href="{{ route('orders.index') }}"
                    class="inline-flex items-center bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold py-3 px-8 rounded-xl transition-all duration-300 hover:shadow-lg hover:shadow-blue-500/25 transform hover:scale-105">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to My Orders
                </a>
            </div>
        </div>
    </main>

    <script>
        function showTab(tabName) {
            // Hide all tabs
            document.querySelectorAll('.order-tab-content').forEach(tab => {
                tab.classList.add('hidden');
            });

            // Show selected tab
            const selectedTab = document.getElementById(tabName + 'Tab');
            if (selectedTab) {
                selectedTab.classList.remove('hidden');
            }
        }
    </script>
@endsection
