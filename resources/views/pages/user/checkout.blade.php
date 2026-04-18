@extends('layouts.user-app')

@section('content')
    <main class="min-h-screen bg-gradient-to-br from-gray-900 to-gray-800 px-6 py-16">
        <div class="max-w-7xl mx-auto">
            <!-- Page Header -->
            <div class="text-center mb-12 animate-fade-in-up">
                <h1 class="text-5xl font-bold text-white mb-4">
                    <i class="fas fa-credit-card mr-4 text-green-400"></i>
                    <span class="bg-gradient-to-r from-green-400 to-blue-500 bg-clip-text text-transparent">
                        Checkout
                    </span>
                </h1>
                <div class="w-24 h-1 bg-gradient-to-r from-green-400 to-blue-500 mx-auto mt-4 rounded-full"></div>
            </div>

            <form action="{{ route('checkout.process') }}" onsubmit="checkoutOrder(event)" method="post">
                @csrf
                <!-- Hidden field for cart items -->
                <input type="hidden" id="cartItemsInput" name="cart_items" value="">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Checkout Form -->
                    <div class="lg:col-span-2 space-y-8">
                        <!-- Billing Information -->
                        <div
                            class="bg-gray-800/50 backdrop-blur-sm rounded-2xl p-8 border border-gray-700/50 animate-fade-in-left card-hover">
                            <h2 class="text-2xl font-bold text-white mb-6 flex items-center">
                                <i class="fas fa-user mr-3 text-blue-400"></i>
                                Billing Information
                            </h2>
                            <div class="space-y-6">
                                <div class="mb-6">
                                    <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Full
                                        Name</label>
                                    <input type="text" id="name" name="name" required
                                        value="{{ auth()->user()?->name ?? '' }}"
                                        class="w-full p-4 rounded-xl bg-gray-700/50 text-gray-100 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                        placeholder="John" />
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="mb-6">
                                        <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email
                                            Address</label>
                                        <input type="email" id="email" name="email" required
                                            value="{{ auth()->user()?->email ?? '' }}"
                                            class="w-full p-4 rounded-xl bg-gray-700/50 text-gray-100 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                            placeholder="john@example.com" />
                                    </div>
                                    <div class="mb-6">
                                        <label for="phone" class="block text-sm font-medium text-gray-300 mb-2">Phone
                                            Number</label>
                                        <input type="tel" id="phone" name="phone" required
                                            value="{{ auth()->user()?->phone ?? '' }}"
                                            class="w-full p-4 rounded-xl bg-gray-700/50 text-gray-100 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                            placeholder="+1 (555) 123-4567" />
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div class="mb-6">
                                        <label for="city"
                                            class="block text-sm font-medium text-gray-300 mb-2">City</label>
                                        <input type="text" id="city" name="city" required
                                            value="{{ auth()->user()?->city ?? '' }}"
                                            class="w-full p-4 rounded-xl bg-gray-700/50 text-gray-100 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                            placeholder="New York" />
                                    </div>
                                    <div class="mb-6">
                                        <label for="state"
                                            class="block text-sm font-medium text-gray-300 mb-2">State</label>
                                        <input type="text" id="state" name="state" required
                                            value="{{ auth()->user()?->state ?? '' }}"
                                            class="w-full p-4 rounded-xl bg-gray-700/50 text-gray-100 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                            placeholder="NY" />
                                    </div>
                                    <div class="mb-6">
                                        <label for="zipCode" class="block text-sm font-medium text-gray-300 mb-2">ZIP
                                            Code</label>
                                        <input type="text" id="zipCode" name="zip_code" required
                                            value="{{ auth()->user()?->zip_code ?? '' }}"
                                            class="w-full p-4 rounded-xl bg-gray-700/50 text-gray-100 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                            placeholder="10001" />
                                    </div>
                                </div>
                                <div class="mb-6">
                                    <label for="address" class="block text-sm font-medium text-gray-300 mb-2">Street
                                        Address</label>
                                    <input type="text" id="address" name="address" required
                                        value="{{ auth()->user()?->address ?? '' }}"
                                        class="w-full p-4 rounded-xl bg-gray-700/50 text-gray-100 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                        placeholder="123 Main Street" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <div
                            class="bg-gray-800/50 backdrop-blur-sm rounded-2xl p-8 border border-gray-700/50 animate-fade-in-right sticky top-24 card-hover">
                            <h2 class="text-2xl font-bold text-white mb-6 flex items-center">
                                <i class="fas fa-receipt mr-3 text-orange-400"></i>
                                Order Summary
                            </h2>

                            <!-- Cart Items -->
                            <div id="orderSummaryItems" class="space-y-4 mb-6">
                                <!-- Items will be dynamically loaded here -->
                            </div>

                            <!-- Order Totals -->
                            <div class="border-t border-gray-700 pt-6 space-y-3">
                                <div class="flex justify-between text-gray-300">
                                    <span>Subtotal:</span>
                                    <span id="subtotalAmount">$0.00</span>
                                </div>
                                <div class="flex justify-between text-gray-300">
                                    <span>Shipping:</span>
                                    <span id="shippingAmount">$0.00</span>
                                </div>
                                <div class="flex justify-between text-gray-300">
                                    <span>Tax:</span>
                                    <span id="taxAmount">$0.00</span>
                                </div>
                                <div class="border-t border-gray-600 pt-3">
                                    <div class="flex justify-between text-xl font-bold text-white">
                                        <span>Total:</span>
                                        <span class="text-green-400" id="totalAmount">$0.00</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Place Order Button -->
                            <button type="submit" id="placeOrderBtn"
                                class="w-full mt-8 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-4 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-green-500/25 text-lg">
                                <i class="fas fa-lock mr-2"></i>
                                <span id="placeOrderText">Place Order - $0.00</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
    </main>

    <script>
        // Get settings from data attributes
        const container = document.getElementById('checkoutContainer');
        const taxRate = {{ $generalSettings->tax_rate }} || 0;
        const taxIncluded = {{ $generalSettings->tax_included ? 'true' : 'false' }};
        const defaultShipping = {{ $orderSettings->default_shipping_fee }} || 0;
        const freeShippingAbove = {{ $orderSettings->free_shipping_above }} || 0;
        const cart = getCart();

        // Load and display cart items
        function loadOrderSummary() {
            const container = document.getElementById('orderSummaryItems');

            if (cart.length === 0) {
                container.innerHTML = '<p class="text-center text-gray-400">Your cart is empty</p>';
                updateOrderTotals();
                return;
            }

            container.innerHTML = '';
            cart.forEach(item => {
                const itemTotal = item.price * item.quantity;
                container.innerHTML += `
                    <div class="flex items-center space-x-4 p-4 bg-gray-700/30 rounded-xl">
                        <img src="${item.image || 'https://placehold.co/64x64'}" alt="${item.name}"
                            class="w-16 h-16 rounded-lg object-cover" />
                        <div class="flex-grow">
                            <h3 class="text-white font-semibold">${item.name}</h3>
                            <p class="text-gray-400 text-sm">Quantity: ${item.quantity}</p>
                        </div>
                        <span class="text-green-400 font-bold">$${itemTotal.toFixed(2)}</span>
                    </div>
                `;
            });

            updateOrderTotals();
        }

        // Update order totals
        function updateOrderTotals() {
            const subtotal = getSubtotal();
            const tax = calculateTax(subtotal, taxRate, taxIncluded);
            const shipping = getShippingFee(subtotal, defaultShipping, freeShippingAbove);
            const total = subtotal + tax + shipping;

            document.getElementById('subtotalAmount').innerText = `$${subtotal.toFixed(2)}`;
            document.getElementById('taxAmount').innerText = `$${tax.toFixed(2)}`;
            document.getElementById('shippingAmount').innerText = `$${shipping.toFixed(2)}`;
            document.getElementById('totalAmount').innerText = `$${total.toFixed(2)}`;
            document.getElementById('placeOrderText').innerText = `Place Order - $${total.toFixed(2)}`;
        }

        // Load order summary on page load
        document.addEventListener('DOMContentLoaded', () => {
            if (cart.length === 0) {
                {{ session()->forget('info') }}
                {{ session()->flash('warning', 'Your cart is empty. Please add items to your cart before checking out.') }}
                window.location.href =
                    "{{ route('products.index') }}";
            } else {
                {{ session()->forget('warning') }}
                {{ session()->flash('info', 'Your cart has been loaded successfully. You can proceed to checkout.') }}
            }

            loadOrderSummary();

            // Watch for changes from other tabs
            window.addEventListener('storage', () => {
                loadOrderSummary();
            });
        });

        // Checkout order
        function checkoutOrder(e) {
            e.preventDefault(); // Prevent default form submission
            console.log("order processing");

            const btn = document.getElementById('placeOrderBtn');
            btn.disabled = true;
            btn.innerHTML = `<i class="fas fa-spinner fa-spin mr-2"></i> Processing Order...`;

            const cartItemsInput = document.getElementById('cartItemsInput');
            cartItemsInput.value = JSON.stringify(cart);

            e.target.submit();
        }
    </script>
@endsection
