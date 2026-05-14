@extends('layouts.user-app')

@section('content')
    <main class="min-h-screen bg-gradient-to-br from-gray-900 to-gray-800 px-6 py-16">
        <div class="max-w-6xl mx-auto">
            <!-- Page Header -->
            <div class="text-center mb-12 animate-fade-in-up">
                <div
                    class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full mb-6 shadow-lg animate-float">
                    <i class="fas fa-shopping-bag text-2xl text-white"></i>
                </div>
                <h1 class="text-4xl lg:text-5xl font-bold text-white mb-4">
                    <span class="bg-gradient-to-r from-blue-400 to-purple-500 bg-clip-text text-transparent">
                        My Orders
                    </span>
                </h1>
                <p class="text-xl text-gray-300 mb-2">View and manage all your orders</p>
                <div class="w-24 h-1 bg-gradient-to-r from-blue-400 to-purple-500 mx-auto rounded-full"></div>
            </div>

            @if ($orders->count() > 0)
                <div class="space-y-6">
                    @foreach ($orders as $order)
                        <div
                            class="bg-gray-800/50 backdrop-blur-sm rounded-2xl p-6 md:p-8 border border-gray-700/50 hover:border-blue-500/50 transition-all duration-300 hover:shadow-lg hover:shadow-blue-500/10 group cursor-pointer">
                            <a href="{{ route('orders.show', $order) }}" class="block">
                                <div class="grid grid-cols-1 md:grid-cols-5 gap-6 items-center">
                                    <!-- Order Number & Date -->
                                    <div class="md:col-span-2">
                                        <h3
                                            class="text-xl font-bold text-white mb-2 group-hover:text-blue-400 transition-colors">
                                            {{ $order->order_number }}
                                        </h3>
                                        <p class="text-sm text-gray-400">
                                            <i class="fas fa-calendar mr-2"></i>
                                            {{ $order->created_at->format('M d, Y \a\t h:i A') }}
                                        </p>
                                        <div class="mt-3">
                                            @php
                                                $statusConfig = [
                                                    'pending' => ['color' => 'yellow', 'icon' => 'clock'],
                                                    'processing' => ['color' => 'blue', 'icon' => 'cog'],
                                                    'shipped' => ['color' => 'purple', 'icon' => 'truck'],
                                                    'delivered' => ['color' => 'green', 'icon' => 'check-circle'],
                                                    'cancelled' => ['color' => 'red', 'icon' => 'times-circle'],
                                                ];
                                                $config = $statusConfig[$order->status] ?? [
                                                    'color' => 'gray',
                                                    'icon' => 'question-circle',
                                                ];
                                            @endphp
                                            <span
                                                class="inline-flex items-center px-3 py-1 bg-{{ $config['color'] }}-500/20 text-{{ $config['color'] }}-400 rounded-full text-sm font-semibold">
                                                <i class="fas fa-{{ $config['icon'] }} mr-1"></i>
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Items Count -->
                                    <div class="text-center">
                                        <p class="text-gray-400 text-sm mb-1">Items</p>
                                        <p class="text-3xl font-bold text-white">{{ $order->items_count }}</p>
                                    </div>

                                    <!-- Subtotal -->
                                    <div class="text-center">
                                        <p class="text-gray-400 text-sm mb-1">Subtotal</p>
                                        <p class="text-2xl font-bold text-gray-300">
                                            ${{ number_format($order->subtotal, 2) }}</p>
                                    </div>

                                    <!-- Total -->
                                    <div class="text-center">
                                        <p class="text-gray-400 text-sm mb-1">Total</p>
                                        <p class="text-3xl font-bold text-green-400">${{ number_format($order->total, 2) }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Shipping Address Preview -->
                                <div class="mt-6 pt-6 border-t border-gray-700/50">
                                    <p class="text-sm text-gray-400 mb-2">
                                        <i class="fas fa-map-marker-alt mr-2"></i>Shipping to:
                                    </p>
                                    <p class="text-white">
                                        {{ $order->first_name }} {{ $order->last_name }}<br />
                                        {{ $order->street_address }}, {{ $order->city }}, {{ $order->state }}
                                        {{ $order->zip_code }}
                                    </p>
                                </div>

                                <!-- View Details Link -->
                                <div
                                    class="mt-4 flex items-center text-blue-400 group-hover:text-blue-300 transition-colors">
                                    <span class="text-sm font-medium">View Details</span>
                                    <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-16">
                    <div class="inline-flex items-center justify-center w-24 h-24 bg-gray-800/50 rounded-full mb-6">
                        <i class="fas fa-shopping-cart text-4xl text-gray-600"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-white mb-2">No Orders Yet</h2>
                    <p class="text-gray-400 mb-8">You haven't placed any orders yet. Start shopping now!</p>
                    <a href="{{ route('products.index') }}"
                        class="inline-flex items-center bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold py-3 px-8 rounded-xl transition-all duration-300 hover:shadow-lg hover:shadow-blue-500/25 transform hover:scale-105">
                        <i class="fas fa-shopping-bags mr-2"></i>
                        Continue Shopping
                    </a>
                </div>
            @endif
        </div>
    </main>
@endsection
