@extends('layouts.admin-app')

@section('content')
    <!-- Profile Header -->
    <div class="admin-card p-8 rounded-2xl mb-8 animate-bounce-in">
        <div class="flex flex-col lg:flex-row items-center lg:items-start gap-8">
            <!-- Profile Image -->
            <div class="relative">
                <div class="profile-image-container w-32 h-32 p-1">
                    @if (Auth::user()->avatar)
                        <img src="{{ asset('storage/avatars/' . Auth::user()->avatar) }}" alt="Avatar"
                            class="w-full h-full rounded-full object-cover">
                    @else
                        <div
                            class="w-full h-full rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-xl">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                    @endif
                </div>
                <button onclick="openModal('addImageModal')"
                    class="absolute -bottom-0 -right-0 bg-blue-500 hover:bg-blue-600 p-2 rounded-full text-white transition-colors">
                    <i class="fas fa-edit text-sm"></i>
                </button>
            </div>

            <!-- Profile Info -->
            <div class="flex-1 text-center lg:text-left">
                <h1 class="text-3xl font-bold text-white mb-2">{{ Auth::user()->name }}</h1>
                <p class="text-gray-400 mb-4">{{ Auth::user()->email }}</p>
                <div class="flex flex-wrap gap-4 justify-center lg:justify-start">
                    <div class="glass px-4 py-2 rounded-xl">
                        <i class="fas fa-calendar text-green-400 mr-2"></i>
                        <span class="text-sm">Joined {{ Auth::user()->created_at->format('M Y') }}</span>
                    </div>
                    @forelse (Auth::user()->roles as $role)
                        <div class="glass px-4 py-2 rounded-xl">
                            <i class="fas fa-shield-alt text-purple-400 mr-2"></i>
                            <span class="text-sm">{{ $role->name }}</span>
                        </div>
                    @empty
                        <div class="glass px-4 py-2 rounded-xl">
                            <span class="text-sm">User</span>
                        </div>
                    @endforelse
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
                    <div class="space-y-6">
                        <!-- Name -->
                        <div class="form-group">
                            <label for="name" class="text-gray-400 mb-1 block">Your Name</label>
                            <input type="text" id="name" name="name"
                                class="form-input w-full px-4 py-3 glass rounded-xl text-white placeholder-transparent focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Your Name" value="{{ Auth::user()->name }}" />
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Email -->
                            <div class="form-group">
                                <label for="email" class="text-gray-400 mb-1 block">Email Address</label>
                                <input type="email" id="email" name="email"
                                    class="form-input w-full px-4 py-3 glass rounded-xl text-white placeholder-transparent focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Email Address" value="{{ Auth::user()->email }}" />
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div class="form-group">
                                <label for="phone" class="text-gray-400 mb-1 block">Phone Number</label>
                                <input type="tel" id="phone" name="phone"
                                    class="form-input w-full px-4 py-3 glass rounded-xl text-white placeholder-transparent focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Phone Number" value="{{ Auth::user()->phone }}" />
                                @error('phone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
                            <!-- Country -->
                            <div class="form-group">
                                <label for="country" class="text-gray-400 mb-1 block">Country</label>
                                <input type="text" id="country" name="country"
                                    class="form-input w-full px-4 py-3 glass rounded-xl text-white placeholder-transparent focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Country" value="{{ Auth::user()->country }}" />
                                @error('country')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- State -->
                            <div class="form-group">
                                <label for="state" class="text-gray-400 mb-1 block">State</label>
                                <input type="text" id="state" name="state"
                                    class="form-input w-full px-4 py-3 glass rounded-xl text-white placeholder-transparent focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="State" value="{{ Auth::user()->state }}" />
                                @error('state')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- City -->
                            <div class="form-group">
                                <label for="city" class="text-gray-400 mb-1 block">City</label>
                                <input type="text" id="city" name="city"
                                    class="form-input w-full px-4 py-3 glass rounded-xl text-white placeholder-transparent focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="City" value="{{ Auth::user()->city }}" />
                                @error('city')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Zip Code -->
                            <div class="form-group">
                                <label for="zip" class="text-gray-400 mb-1 block">Zip Code</label>
                                <input type="text" id="zip" name="zip_code"
                                    class="form-input w-full px-4 py-3 glass rounded-xl text-white placeholder-transparent focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Zip Code" value="{{ Auth::user()->zip_code }}" />
                                @error('zip_code')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="form-group">
                            <label for="address" class="text-gray-400 mb-1 block">Address</label>
                            <textarea id="address" name="address"
                                class="form-input w-full px-4 py-3 glass rounded-xl text-white placeholder-transparent focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Address">{{ Auth::user()->address }}</textarea>
                            @error('address')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit"
                                class="bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-bold py-3 px-8 rounded-xl transition-all duration-300 transform hover:scale-105">
                                <i class="fas fa-save mr-2"></i>
                                Update Profile
                            </button>
                        </div>
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
                            <label for="currentPassword" class="text-gray-400 mb-1 block">Current Password</label>
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
                            <label for="newPassword" class="text-gray-400 mb-1 block">New Password</label>
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
                            <label for="confirmPassword" class="text-gray-400 mb-1 block">Confirm New Password</label>
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
@endsection
