@extends('layouts.admin-app')

@section('content')
    <!-- Profile Header -->
    <div class="admin-card p-8 rounded-2xl mb-8 animate-bounce-in">
        <div class="flex flex-col lg:flex-row items-center lg:items-start gap-8">
            <!-- Profile Image -->
            <div class="relative">
                <div class="profile-image-container w-32 h-32 p-1">
                    <div
                        class="w-full h-full rounded-full bg-gradient-to-br from-blue-600 to-purple-700 flex items-center justify-center text-white font-bold text-4xl">
                        Admin User
                    </div>
                </div>
                <button onclick="openModal('addImageModal')"
                    class="absolute -bottom-0 -right-0 bg-blue-500 hover:bg-blue-600 p-2 rounded-full text-white transition-colors">
                    <i class="fas fa-edit text-sm"></i>
                </button>
            </div>

            <!-- Profile Info -->
            <div class="flex-1 text-center lg:text-left">
                <h1 class="text-3xl font-bold text-white mb-2">Admin User</h1>
                <p class="text-gray-400 mb-4">System Administrator</p>
                <div class="flex flex-wrap gap-4 justify-center lg:justify-start">
                    <div class="glass px-4 py-2 rounded-xl">
                        <i class="fas fa-envelope text-blue-400 mr-2"></i>
                        <span class="text-sm">admin@ecommerce.com</span>
                    </div>
                    <div class="glass px-4 py-2 rounded-xl">
                        <i class="fas fa-calendar text-green-400 mr-2"></i>
                        <span class="text-sm">Joined Dec 2023</span>
                    </div>
                    <div class="glass px-4 py-2 rounded-xl">
                        <i class="fas fa-shield-alt text-purple-400 mr-2"></i>
                        <span class="text-sm">Super Admin</span>
                    </div>
                </div>
            </div>

            <!-- Profile Stats -->
            <div class="grid grid-cols-3 gap-4 text-center">
                <div class="glass p-4 rounded-xl">
                    <p class="text-2xl font-bold text-blue-400">245</p>
                    <p class="text-xs text-gray-400">Orders</p>
                </div>
                <div class="glass p-4 rounded-xl">
                    <p class="text-2xl font-bold text-green-400">89</p>
                    <p class="text-xs text-gray-400">Products</p>
                </div>
                <div class="glass p-4 rounded-xl">
                    <p class="text-2xl font-bold text-purple-400">156</p>
                    <p class="text-xs text-gray-400">Users</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Management Section -->
    <div class="admin-card rounded-2xl animate-slide-in">
        <!-- Tab Navigation -->
        <div class="border-b border-white/10 px-8 pt-6">
            <nav class="flex space-x-8">
                <button onclick="switchTab('personalTab')" id="personalTabBtn"
                    class="tab-button active py-3 px-1 text-blue-400 font-medium">
                    <i class="fas fa-user mr-2"></i>Personal Info
                </button>
                <button onclick="switchTab('passwordTab')" id="passwordTabBtn"
                    class="tab-button py-3 px-1 text-gray-400 font-medium hover:text-white transition-colors">
                    <i class="fas fa-shield-alt mr-2"></i>Change Password
                </button>
                <button onclick="switchTab('securityTab')" id="securityTabBtn"
                    class="tab-button py-3 px-1 text-gray-400 font-medium hover:text-white transition-colors">
                    <i class="fas fa-shield-alt mr-2"></i>Security
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="p-8">
            <!-- Personal Info Tab -->
            <div id="personalTab" class="tab-content">
                <h3 class="text-xl font-bold text-white mb-6">Personal Information</h3>
                <form onsubmit="updateProfile(event)" class="space-y-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- First Name -->
                        <div class="form-group">
                            <input type="text" id="firstName"
                                class="form-input w-full px-4 py-3 glass rounded-xl text-white placeholder-transparent focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="First Name" value="Admin User" />
                            <label for="firstName" class="floating-label">First Name</label>
                        </div>

                        <!-- Last Name -->
                        <div class="form-group">
                            <input type="text" id="lastName"
                                class="form-input w-full px-4 py-3 glass rounded-xl text-white placeholder-transparent focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Last Name" value="User" />
                            <label for="lastName" class="floating-label">Last Name</label>
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <input type="email" id="email"
                                class="form-input w-full px-4 py-3 glass rounded-xl text-white placeholder-transparent focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Email Address" value="admin@ecommerce.com" />
                            <label for="email" class="floating-label">Email Address</label>
                        </div>

                        <!-- Phone -->
                        <div class="form-group">
                            <input type="tel" id="phone"
                                class="form-input w-full px-4 py-3 glass rounded-xl text-white placeholder-transparent focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Phone Number" value="+1 (555) 123-4567" />
                            <label for="phone" class="floating-label">Phone Number</label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-bold py-3 px-8 rounded-xl transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-save mr-2"></i>
                            Update Profile
                        </button>
                    </div>
                </form>
            </div>

            <!-- Change Password Tab -->
            <div id="passwordTab" class="tab-content hidden">
                <h3 class="text-xl font-bold text-white mb-6">Change Password</h3>

                <!-- Change Password Form -->
                <form onsubmit="changePassword(event)" class="space-y-6 mb-8">
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Current Password -->
                        <div class="form-group relative">
                            <input type="password" id="currentPassword"
                                class="form-input w-full px-4 py-3 pr-12 glass rounded-xl text-white placeholder-transparent focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Current Password" />
                            <label for="currentPassword" class="floating-label">Current Password</label>
                            <button type="button" onclick="togglePassword('currentPassword')"
                                class="absolute right-3 top-3 text-gray-400 hover:text-white">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>

                        <!-- New Password -->
                        <div class="form-group relative">
                            <input type="password" id="newPassword"
                                class="form-input w-full px-4 py-3 pr-12 glass rounded-xl text-white placeholder-transparent focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="New Password" />
                            <label for="newPassword" class="floating-label">New Password</label>
                            <button type="button" onclick="togglePassword('newPassword')"
                                class="absolute right-3 top-3 text-gray-400 hover:text-white">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-group relative">
                            <input type="password" id="confirmPassword"
                                class="form-input w-full px-4 py-3 pr-12 glass rounded-xl text-white placeholder-transparent focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Confirm New Password" />
                            <label for="confirmPassword" class="floating-label">Confirm New Password</label>
                            <button type="button" onclick="togglePassword('confirmPassword')"
                                class="absolute right-3 top-3 text-gray-400 hover:text-white">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit"
                        class="bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-key mr-2"></i>
                        Change Password
                    </button>
                </form>
            </div>

            <!-- Security Tab -->
            <div id="securityTab" class="tab-content hidden">
                <h3 class="text-xl font-bold text-white mb-6">Security Settings</h3>

                <!-- Session Management -->
                <div class="glass p-6 rounded-2xl mb-6 border border-blue-500/20">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-devices text-blue-400 mr-3 text-lg"></i>
                                <h4 class="text-lg font-semibold text-white">Active Sessions</h4>
                            </div>
                            <p class="text-gray-400 text-sm">Logout from all other devices and sessions for enhanced
                                security</p>
                            <div class="mt-3 flex items-center text-sm text-gray-300">
                                <i class="fas fa-info-circle text-blue-400 mr-2"></i>
                                <span>Currently active on 3 devices</span>
                            </div>
                        </div>
                        <button onclick="openModal('logoutDevicesModal')"
                            class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-blue-500/25">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            Logout Other Devices
                        </button>
                    </div>
                </div>

                <!-- Account Security -->
                <div class="glass p-6 rounded-2xl mb-6 border border-yellow-500/20">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-shield-alt text-yellow-400 mr-3 text-lg"></i>
                        <h4 class="text-lg font-semibold text-white">Account Security</h4>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 glass rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-key text-green-400 mr-3"></i>
                                <div>
                                    <p class="text-white font-medium">Password</p>
                                    <p class="text-gray-400 text-sm">Last changed 30 days ago</p>
                                </div>
                            </div>
                            <button onclick="switchTab('passwordTab')"
                                class="text-green-400 hover:text-green-300 font-medium">Change</button>
                        </div>
                        <div class="flex items-center justify-between p-3 glass rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-envelope text-blue-400 mr-3"></i>
                                <div>
                                    <p class="text-white font-medium">Email Verification</p>
                                    <p class="text-gray-400 text-sm">Verified and secure</p>
                                </div>
                            </div>
                            <div class="flex items-center text-green-400">
                                <i class="fas fa-check-circle mr-1"></i>
                                <span class="text-sm font-medium">Verified</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Danger Zone -->
                <div class="glass p-6 rounded-2xl border border-red-500/20">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-exclamation-triangle text-red-400 mr-3 text-lg"></i>
                        <h4 class="text-lg font-semibold text-red-400">Danger Zone</h4>
                    </div>
                    <div class="bg-red-500/10 border border-red-500/20 rounded-xl p-4 mb-4">
                        <p class="text-gray-300 text-sm mb-2">
                            <strong class="text-red-400">Warning:</strong> This action cannot be undone.
                        </p>
                        <p class="text-gray-400 text-sm">Once you delete your account, all your data will be permanently
                            removed from our servers.</p>
                    </div>
                    <button onclick="openModal('deleteAccountModal')"
                        class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-red-500/25">
                        <i class="fas fa-trash-alt mr-2"></i>
                        Delete Account
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals will be included here -->


    <script>
        function switchTab(tabName) {
            const tabs = document.querySelectorAll('.tab-content');
            const buttons = document.querySelectorAll('.tab-button');

            tabs.forEach(tab => tab.classList.add('hidden'));
            buttons.forEach(btn => {
                btn.classList.remove('text-blue-400');
                btn.classList.add('text-gray-400');
            });

            document.getElementById(tabName).classList.remove('hidden');
            event.target.closest('.tab-button').classList.add('text-blue-400');
            event.target.closest('.tab-button').classList.remove('text-gray-400');
        }

        function changePassword(event) {
            event.preventDefault();
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            if (newPassword !== confirmPassword) {
                toastr.error('Passwords do not match!');
                return;
            }

            if (newPassword.length < 8) {
                toastr.error('Password must be at least 8 characters long!');
                return;
            }

            event.target.submit();
        }
    </script>
@endsection
