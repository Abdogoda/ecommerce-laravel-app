<!-- Order Settings Tab -->
<div id="orderTab" class="tab-content hidden">
    <h3 class="text-xl font-bold text-white mb-6">Order Settings</h3>

    <form action="{{ route('admin.settings.updateOrder') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Auto Confirm Orders -->
        <div class="bg-gray-700/30 p-6 rounded-xl border border-white/10">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="text-lg font-semibold text-white mb-1">Auto Confirm Orders</h4>
                    <p class="text-gray-400 text-sm">Automatically move orders from Pending to Processing when payment is
                        confirmed</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="auto_confirm" id="auto_confirm" class="sr-only peer"
                        {{ isset($order) && isset($order->auto_confirm) && $order->auto_confirm ? 'checked' : '' }} />
                    <div
                        class="w-11 h-6 bg-gray-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-500/50 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                    </div>
                </label>
            </div>
        </div>

        <!-- Allow Guest Orders -->
        <div class="bg-gray-700/30 p-6 rounded-xl border border-white/10">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="text-lg font-semibold text-white mb-1">Allow Guest Orders</h4>
                    <p class="text-gray-400 text-sm">Allow customers to place orders without creating an account</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="allow_guest_orders" id="allow_guest_orders" class="sr-only peer"
                        {{ isset($order) && isset($order->allow_guest_orders) && $order->allow_guest_orders ? 'checked' : '' }} />
                    <div
                        class="w-11 h-6 bg-gray-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-500/50 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                    </div>
                </label>
            </div>
        </div>

        <!-- Allow Out of Stock -->
        <div class="bg-gray-700/30 p-6 rounded-xl border border-white/10">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="text-lg font-semibold text-white mb-1">Allow Out of Stock Orders</h4>
                    <p class="text-gray-400 text-sm">Allow customers to order products when stock is zero</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="allow_out_of_stock" id="allow_out_of_stock" class="sr-only peer"
                        {{ isset($order) && isset($order->allow_out_of_stock) && $order->allow_out_of_stock ? 'checked' : '' }} />
                    <div
                        class="w-11 h-6 bg-gray-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-500/50 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                    </div>
                </label>
            </div>
        </div>

        <!-- Cancel Orders Setting -->
        <div class="form-group">
            <label for="cancel_after_minutes" class="text-gray-400 mb-2 block">
                Cancel Unpaid Orders After (minutes)
            </label>
            <input type="number" id="cancel_after_minutes" name="cancel_after_minutes"
                class="form-input w-full px-4 py-3 glass rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                placeholder="0 (disabled)"
                value="{{ isset($order) && isset($order->cancel_after_minutes) ? $order->cancel_after_minutes : 0 }}"
                min="0" />
            <p class="text-gray-500 text-sm mt-2">Set to 0 to disable automatic cancellation</p>
            @error('cancel_after_minutes')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Shipping Settings -->
        <div class="bg-gray-700/30 p-6 rounded-xl border border-white/10">
            <h4 class="text-lg font-semibold text-white mb-4">Shipping Settings</h4>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="form-group">
                    <label for="default_shipping_fee" class="text-gray-400 mb-2 block">
                        Default Shipping Fee
                    </label>
                    <div class="relative">
                        <input type="number" id="default_shipping_fee" name="default_shipping_fee" step="0.01"
                            class="form-input w-full px-4 py-3 glass rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="0.00"
                            value="{{ isset($order) && isset($order->default_shipping_fee) ? $order->default_shipping_fee : 0 }}" />
                    </div>
                    @error('default_shipping_fee')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="free_shipping_above" class="text-gray-400 mb-2 block">
                        Free Shipping Above Amount
                    </label>
                    <div class="relative">
                        <input type="number" id="free_shipping_above" name="free_shipping_above" step="0.01"
                            class="form-input w-full px-4 py-3 glass rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="0 (disabled)"
                            value="{{ isset($order) && isset($order->free_shipping_above) ? $order->free_shipping_above : 0 }}" />
                    </div>
                    <p class="text-gray-500 text-sm mt-2">Set to 0 to disable free shipping</p>
                    @error('free_shipping_above')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Stock Management -->
        <div class="bg-gray-700/30 p-6 rounded-xl border border-white/10">
            <h4 class="text-lg font-semibold text-white mb-4">Stock Management</h4>

            <div class="form-group">
                <label for="low_stock_threshold" class="text-gray-400 mb-2 block">
                    Low Stock Alert Threshold
                </label>
                <input type="number" id="low_stock_threshold" name="low_stock_threshold"
                    class="form-input w-full px-4 py-3 glass rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="10"
                    value="{{ isset($order) && isset($order->low_stock_threshold) ? $order->low_stock_threshold : 10 }}"
                    min="0" />
                <p class="text-gray-500 text-sm mt-2">Alert will trigger when stock reaches this level</p>
                @error('low_stock_threshold')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end pt-4">
            <button type="submit"
                class="bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-bold py-3 px-8 rounded-xl transition-all duration-300 transform hover:scale-105">
                <i class="fas fa-save mr-2"></i>
                Save Order Settings
            </button>
        </div>
    </form>
</div>
