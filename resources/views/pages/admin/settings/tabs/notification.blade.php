<!-- Notification Settings Tab -->
<div id="notificationTab" class="tab-content hidden">
    <h3 class="text-xl font-bold text-white mb-6">Notification Settings</h3>

    <form action="{{ route('admin.settings.updateNotifications') }}" method="POST" class="space-y-6">
        @csrf

        <p class="text-gray-400 text-sm mb-6">Configure email notifications sent to admins and customers</p>

        <!-- Admin Notifications Section -->
        <div class="bg-gray-700/30 p-6 rounded-xl border border-white/10">
            <div class="flex items-center mb-6">
                <i class="fas fa-envelope text-blue-400 mr-3 text-lg"></i>
                <h4 class="text-lg font-semibold text-white">Admin Notifications</h4>
            </div>

            <!-- Admin Email -->
            <div class="form-group mb-6">
                <label for="admin_notification_email" class="text-gray-400 mb-2 block">
                    Admin Email Address
                </label>
                <input type="email" id="admin_notification_email" name="admin_notification_email"
                    class="form-input w-full px-4 py-3 glass rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="admin@example.com"
                    value="{{ isset($notification) && isset($notification->admin_notification_email) ? $notification->admin_notification_email : '' }}"
                    required />
                <p class="text-gray-500 text-sm mt-2">Where admin notifications will be sent</p>
                @error('admin_notification_email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- New Order Notification -->
            <div class="flex items-center justify-between p-4 bg-gray-800/50 rounded-lg mb-4">
                <div>
                    <h5 class="text-white font-medium mb-1">
                        <i class="fas fa-shopping-cart text-amber-400 mr-2"></i>
                        New Order Received
                    </h5>
                    <p class="text-gray-400 text-sm">Get notified when a customer places an order</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="notify_admin_new_order" id="notify_admin_new_order"
                        class="sr-only peer"
                        {{ isset($notification) && isset($notification->notify_admin_new_order) && $notification->notify_admin_new_order ? 'checked' : '' }} />
                    <div
                        class="w-11 h-6 bg-gray-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-500/50 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                    </div>
                </label>
            </div>

            <!-- New Message Notification -->
            <div class="flex items-center justify-between p-4 bg-gray-800/50 rounded-lg mb-4">
                <div>
                    <h5 class="text-white font-medium mb-1">
                        <i class="fas fa-comment text-purple-400 mr-2"></i>
                        New Message Received
                    </h5>
                    <p class="text-gray-400 text-sm">Get notified when a customer sends a message</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="notify_admin_new_message" id="notify_admin_new_message"
                        class="sr-only peer"
                        {{ isset($notification) && isset($notification->notify_admin_new_message) && $notification->notify_admin_new_message ? 'checked' : '' }} />
                    <div
                        class="w-11 h-6 bg-gray-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-500/50 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                    </div>
                </label>
            </div>

            <!-- Low Stock Notification -->
            <div class="flex items-center justify-between p-4 bg-gray-800/50 rounded-lg">
                <div>
                    <h5 class="text-white font-medium mb-1">
                        <i class="fas fa-exclamation-triangle text-red-400 mr-2"></i>
                        Low Stock Alert
                    </h5>
                    <p class="text-gray-400 text-sm">Get notified when product stock is running low</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="notify_admin_low_stock" id="notify_admin_low_stock"
                        class="sr-only peer"
                        {{ isset($notification) && isset($notification->notify_admin_low_stock) && $notification->notify_admin_low_stock ? 'checked' : '' }} />
                    <div
                        class="w-11 h-6 bg-gray-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-500/50 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                    </div>
                </label>
            </div>
        </div>

        <!-- Customer Notifications Section -->
        <div class="bg-gray-700/30 p-6 rounded-xl border border-white/10">
            <div class="flex items-center mb-6">
                <i class="fas fa-users text-green-400 mr-3 text-lg"></i>
                <h4 class="text-lg font-semibold text-white">Customer Notifications</h4>
            </div>

            <!-- Order Status Changed Notification -->
            <div class="flex items-center justify-between p-4 bg-gray-800/50 rounded-lg mb-4">
                <div>
                    <h5 class="text-white font-medium mb-1">
                        <i class="fas fa-check-circle text-green-400 mr-2"></i>
                        Order Status Changed
                    </h5>
                    <p class="text-gray-400 text-sm">Send notification when order status changes</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="notify_customer_order_status_changed"
                        id="notify_customer_order_status_changed" class="sr-only peer"
                        {{ isset($notification) && isset($notification->notify_customer_order_status_changed) && $notification->notify_customer_order_status_changed ? 'checked' : '' }} />
                    <div
                        class="w-11 h-6 bg-gray-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-500/50 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                    </div>
                </label>
            </div>
        </div>

        <!-- Info Box -->
        <div class="bg-blue-500/10 border border-blue-500/30 p-6 rounded-xl">
            <div class="flex items-start">
                <i class="fas fa-info-circle text-blue-400 mt-1 mr-3"></i>
                <div>
                    <h4 class="text-sm font-semibold text-blue-400 mb-2">Notification Tips</h4>
                    <ul class="text-sm text-gray-400 space-y-1">
                        <li>• Make sure to set a valid admin email address</li>
                        <li>• Customers will receive order updates automatically</li>
                        <li>• Check your email spam folder if you don't see notifications</li>
                        <li>• Configure your mail settings in .env for production</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end pt-4">
            <button type="submit"
                class="bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-bold py-3 px-8 rounded-xl transition-all duration-300 transform hover:scale-105">
                <i class="fas fa-save mr-2"></i>
                Save Notification Settings
            </button>
        </div>
    </form>
</div>
