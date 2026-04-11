@extends('layouts.user-app')

@section('content')
    <!-- Main Content -->
    <section class="py-16 px-6 bg-gray-900">
        <div class="max-w-6xl mx-auto">
            <h1 class="text-5xl font-bold text-center mb-12 text-white animate-fade-in-up">
                <i class="fas fa-user-circle mr-4 text-blue-400"></i>
                <span class="bg-gradient-to-r from-blue-400 to-purple-500 bg-clip-text text-transparent">
                    My Profile
                </span>
                <div class="w-24 h-1 bg-gradient-to-r from-blue-400 to-purple-500 mx-auto mt-4 rounded-full"></div>
            </h1>

            <!-- Profile Header Card -->
            <div class="bg-gray-800/50 backdrop-blur-sm rounded-2xl p-8 mb-8 border border-gray-700/50 animate-fade-in-up">
                <div class="flex flex-col md:flex-row items-center space-y-6 md:space-y-0 md:space-x-8">
                    <div class="relative">
                        @if (Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Profile Image"
                                class="w-32 h-32 rounded-full object-cover border-2 border-blue-500">
                        @else
                            <div
                                class="w-32 h-32 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center text-4xl text-white font-bold shadow-2xl">
                                {{ substr(Auth::user()->name, 0, 2) }}
                            </div>
                        @endif
                        <button onclick="openModal('addImageModal')"
                            class="absolute -bottom-0 -right-0 bg-blue-500 hover:bg-blue-600 p-2 rounded-full text-white transition-colors">
                            <i class="fas fa-edit text-sm"></i>
                        </button>
                    </div>
                    <div class="text-center md:text-left">
                        <h2 class="text-3xl font-bold text-white mb-2">{{ Auth::user()->name }}</h2>
                        <p class="text-gray-400 mb-2">
                            <i class="fas fa-envelope mr-2"></i>{{ Auth::user()->email }}
                        </p>
                        <p class="text-gray-400 mb-4">
                            <i class="fas fa-phone mr-2"></i>{{ Auth::user()->phone }}
                        </p>
                        <div class="flex justify-center md:justify-start space-x-2">
                            @if (Auth::user()->email_verified_at)
                                <span class="bg-green-500/20 text-green-400 px-3 py-1 rounded-full text-sm font-semibold">
                                    <i class="fas fa-check-circle mr-1"></i>Verified
                                </span>
                            @else
                                <form action="{{ route('email.request', Auth::user()->email) }}" method="post">
                                    @csrf
                                    <button type="submit"
                                        class="bg-red-500/20 text-red-400 px-3 py-1 rounded-full text-sm font-semibold">
                                        <i class="fas fa-xmark-circle mr-1"></i>Unverified
                                    </button>
                                </form>
                            @endif
                            <span class="bg-blue-500/20 text-blue-400 px-3 py-1 rounded-full text-sm font-semibold">
                                <i class="fas fa-crown mr-1"></i>Premium
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Navigation -->
            <div
                class="bg-gray-800/50 backdrop-blur-sm rounded-2xl mb-8 border border-gray-700/50 animate-fade-in-up delay-200">
                <div class="flex flex-wrap">
                    <button id="profileTabButton" onclick="switchTab('profileTab')"
                        class="tab-button flex-1 px-6 py-4 text-center transition-all duration-300 hover:bg-gray-700/50 rounded-tl-2xl border-b-2 border-transparent hover:border-blue-500 text-gray-300 hover:text-white">
                        <i class="fas fa-user-edit mr-2"></i>Update Profile
                    </button>
                    <button id="passwordTabButton" onclick="switchTab('passwordTab')"
                        class="tab-button flex-1 px-6 py-4 text-center transition-all duration-300 hover:bg-gray-700/50 border-b-2 border-transparent hover:border-purple-500 text-gray-300 hover:text-white">
                        <i class="fas fa-lock mr-2"></i>Change Password
                    </button>
                    <button id="securityTabButton" onclick="switchTab('securityTab')"
                        class="tab-button flex-1 px-6 py-4 text-center transition-all duration-300 hover:bg-gray-700/50 border-b-2 border-transparent hover:border-green-500 text-gray-300 hover:text-white">
                        <i class="fas fa-shield-alt mr-2"></i>Security
                    </button>
                    <button id="ordersTabButton" onclick="switchTab('ordersTab')"
                        class="tab-button flex-1 px-6 py-4 text-center transition-all duration-300 hover:bg-gray-700/50 rounded-tr-2xl border-b-2 border-transparent hover:border-orange-500 text-gray-300 hover:text-white">
                        <i class="fas fa-shopping-bag mr-2"></i>My Orders
                    </button>
                </div>
            </div>

            <!-- Tab Content -->
            <div
                class="bg-gray-800/50 backdrop-blur-sm rounded-2xl p-8 border border-gray-700/50 animate-fade-in-up delay-300">
                <!-- Profile Tab -->
                <div id="profileTab" class="tab-content">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-2xl font-bold text-white flex items-center">
                            <i class="fas fa-user-edit mr-3 text-blue-400"></i>Update
                            Profile
                        </h3>
                    </div>
                    <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Full Name</label>
                                <input type="text" id="name" name="name" value="{{ Auth::user()->name }}"
                                    class="w-full p-4 rounded-xl bg-gray-700/50 text-gray-100 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300" />
                                @error('name')
                                    <div class="text-red-300 text-sm mt-2 flex items-center">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email
                                    Address</label>
                                <input type="email" id="email" name="email" value="{{ Auth::user()->email }}"
                                    class="w-full p-4 rounded-xl bg-gray-700/50 text-gray-100 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300" />
                                @error('email')
                                    <div class="text-red-300 text-sm mt-2 flex items-center">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-300 mb-2">Phone
                                    Number</label>
                                <input type="tel" id="phone" name="phone" value="{{ Auth::user()->phone }}"
                                    class="w-full p-4 rounded-xl bg-gray-700/50 text-gray-100 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300" />
                                @error('phone')
                                    <div class="text-red-300 text-sm mt-2 flex items-center">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                            <div>
                                <label for="country" class="block text-sm font-medium text-gray-300 mb-2">Country</label>
                                <input type="text" id="country" name="country" value="{{ Auth::user()->country }}"
                                    class="w-full p-4 rounded-xl bg-gray-700/50 text-gray-100 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300" />
                                @error('country')
                                    <div class="text-red-300 text-sm mt-2 flex items-center">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                            <div>
                                <label for="state" class="block text-sm font-medium text-gray-300 mb-2">State</label>
                                <input type="text" id="state" name="state" value="{{ Auth::user()->state }}"
                                    class="w-full p-4 rounded-xl bg-gray-700/50 text-gray-100 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300" />
                                @error('state')
                                    <div class="text-red-300 text-sm mt-2 flex items-center">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-300 mb-2">City</label>
                                <input type="text" id="city" name="city" value="{{ Auth::user()->city }}"
                                    autocomplete="off"
                                    class="w-full p-4 rounded-xl bg-gray-700/50 text-gray-100 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300" />
                                @error('city')
                                    <div class="text-red-300 text-sm mt-2 flex items-center">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                            <div>
                                <label for="zip_code" class="block text-sm font-medium text-gray-300 mb-2">Zip
                                    Code</label>
                                <input type="text" id="zip_code" name="zip_code"
                                    value="{{ Auth::user()->zip_code }}" autocomplete="off"
                                    class="w-full p-4 rounded-xl bg-gray-700/50 text-gray-100 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300" />
                                @error('zip_code')
                                    <div class="text-red-300 text-sm mt-2 flex items-center">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-300 mb-2">Address In
                                Details</label>
                            <textarea type="text" id="address" name="address" autocomplete="off"
                                class="w-full p-4 rounded-xl bg-gray-700/50 text-gray-100 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 min-h-[100px] resize-none">
                                {{ Auth::user()->address }}
                            </textarea>
                            @error('address')
                                <div class="text-red-300 text-sm mt-2 flex items-center">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                        <div class="flex justify-end">
                            <button type="submit"
                                class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold px-8 py-4 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-blue-500/25">
                                <i class="fas fa-save mr-2"></i>
                                Update Profile
                            </button>
                        </div>
                    </form>
                </div>

                <div id="passwordTab" class="tab-content hidden">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-2xl font-bold text-white flex items-center">
                            <i class="fas fa-lock mr-3 text-purple-400"></i>Change Password
                        </h3>
                    </div>
                    <form action="{{ route('password.change') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-300 mb-2">Current
                                    Password</label>
                                <div class="relative">
                                    <input type="password" id="current_password" name="current_password" autofocus
                                        autocomplete="current-password"
                                        class="w-full p-4 rounded-xl bg-gray-700/50 text-gray-100 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300 pr-12" />
                                    <button type="button" onclick="togglePassword('current_password')"
                                        class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white transition-colors">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('current_password')
                                    <div class="text-red-300 text-sm mt-2 flex items-center">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                            <div>
                                <label for="new_password" class="block text-sm font-medium text-gray-300 mb-2">New
                                    Password</label>
                                <div class="relative">
                                    <input type="password" id="new_password" name="new_password"
                                        autocomplete="new-password"
                                        class="w-full p-4 rounded-xl bg-gray-700/50 text-gray-100 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300 pr-12" />
                                    <button type="button" onclick="togglePassword('new_password')"
                                        class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white transition-colors">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('new_password')
                                    <div class="text-red-300 text-sm mt-2 flex items-center">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                            <div>
                                <label for="new_password_confirmation"
                                    class="block text-sm font-medium text-gray-300 mb-2">Confirm New Password</label>
                                <div class="relative">
                                    <input type="password" name="new_password_confirmation"
                                        id="new_password_confirmation"
                                        class="w-full p-4 rounded-xl bg-gray-700/50 text-gray-100 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300 pr-12" />
                                    <button type="button" onclick="togglePassword('new_password_confirmation')"
                                        class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white transition-colors">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                @error('new_password_confirmation')
                                    <div class="text-red-300 text-sm mt-2 flex items-center">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit"
                                class="bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white font-semibold px-8 py-4 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-purple-500/25">
                                <i class="fas fa-key mr-2"></i>
                                Change Password
                            </button>
                        </div>
                    </form>
                </div>

                <div id="securityTab" class="tab-content hidden">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-2xl font-bold text-white flex items-center">
                            <i class="fas fa-shield-alt mr-3 text-green-400"></i>Account &
                            Security
                        </h3>
                    </div>

                    <div class="space-y-6">
                        <div
                            class="bg-gray-700/50 backdrop-blur-sm p-6 rounded-xl border border-gray-600/50 transition-all duration-300 hover:border-gray-500/50">
                            <div class="flex items-start space-x-4">
                                <div
                                    class="w-12 h-12 bg-red-500/20 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-sign-out-alt text-red-400 text-lg"></i>
                                </div>
                                <div class="flex-grow">
                                    <h4 class="text-lg font-semibold text-white mb-2">
                                        Logout from Other Devices
                                    </h4>
                                    <p class="text-gray-400 text-sm mb-4">
                                        If you've logged in from another device and want to secure
                                        your account, you can log out from all devices except the
                                        current one.
                                    </p>
                                    <button onclick="openModal('logoutOtherDevicesModal')"
                                        class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-semibold px-6 py-3 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-red-500/25">
                                        <i class="fas fa-sign-out-alt mr-2"></i>
                                        Logout from Other Devices
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-gray-700/50 backdrop-blur-sm p-6 rounded-xl border border-gray-600/50 transition-all duration-300 hover:border-red-500/50">
                            <div class="flex items-start space-x-4">
                                <div
                                    class="w-12 h-12 bg-red-500/20 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-trash-alt text-red-400 text-lg"></i>
                                </div>
                                <div class="flex-grow">
                                    <h4 class="text-lg font-semibold text-red-400 mb-2">
                                        Delete Account
                                    </h4>
                                    <p class="text-gray-400 text-sm mb-4">
                                        Once you delete your account, there is no going back.
                                        Please be certain before proceeding.
                                    </p>
                                    <button onclick="openModal('deleteAccountModal')"
                                        class="bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-semibold px-6 py-3 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-red-600/25">
                                        <i class="fas fa-trash-alt mr-2"></i>
                                        Delete My Account
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="ordersTab" class="tab-content hidden">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-2xl font-bold text-white flex items-center">
                            <i class="fas fa-shopping-bag mr-3 text-orange-400"></i>My
                            Orders
                        </h3>
                    </div>

                    <div class="bg-gray-700/50 backdrop-blur-sm rounded-xl border border-gray-600/50 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-800/80 border-b border-gray-600">
                                    <tr>
                                        <th
                                            class="py-4 px-6 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                            #
                                        </th>
                                        <th
                                            class="py-4 px-6 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                            Order Number
                                        </th>
                                        <th
                                            class="py-4 px-6 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                            Date
                                        </th>
                                        <th
                                            class="py-4 px-6 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                            Total
                                        </th>
                                        <th
                                            class="py-4 px-6 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th
                                            class="py-4 px-6 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-600/50">
                                    <tr class="hover:bg-gray-600/30 transition-all duration-300">
                                        <td class="py-4 px-6 text-gray-300">1</td>
                                        <td class="py-4 px-6">
                                            <span class="font-bold text-white">#ORD-001</span>
                                        </td>
                                        <td class="py-4 px-6 text-gray-300">
                                            Dec 15, 2024 2:30 PM
                                        </td>
                                        <td class="py-4 px-6">
                                            <span class="text-green-400 font-semibold">$129.99</span>
                                        </td>
                                        <td class="py-4 px-6">
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-500/20 text-green-400 border border-green-500/30">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Completed
                                            </span>
                                        </td>
                                        <td class="py-4 px-6">
                                            <a href="../user/order.html"
                                                class="inline-flex items-center bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold px-4 py-2 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-blue-500/25">
                                                <i class="fas fa-eye mr-2"></i>
                                                View Details
                                            </a>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-600/30 transition-all duration-300">
                                        <td class="py-4 px-6 text-gray-300">2</td>
                                        <td class="py-4 px-6">
                                            <span class="font-bold text-white">#ORD-002</span>
                                        </td>
                                        <td class="py-4 px-6 text-gray-300">
                                            Dec 12, 2024 1:15 PM
                                        </td>
                                        <td class="py-4 px-6">
                                            <span class="text-green-400 font-semibold">$89.50</span>
                                        </td>
                                        <td class="py-4 px-6">
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-500/20 text-blue-400 border border-blue-500/30">
                                                <i class="fas fa-clock mr-1"></i>
                                                Processing
                                            </span>
                                        </td>
                                        <td class="py-4 px-6">
                                            <a href="../user/order.html"
                                                class="inline-flex items-center bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold px-4 py-2 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-blue-500/25">
                                                <i class="fas fa-eye mr-2"></i>
                                                View Details
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modals -->
    <div id="verifyAccountModal"
        class="modal-overlay hidden fixed inset-0 bg-gray-900/80 backdrop-blur-sm flex justify-center items-center z-50">
        <div
            class="modal-content bg-gray-800/95 backdrop-blur-sm p-8 rounded-2xl shadow-2xl w-96 border border-gray-700/50">
            <h3 class="text-2xl font-bold mb-4 text-white flex items-center">
                <i class="fas fa-shield-check mr-3 text-blue-400"></i>
                Verify Account?
            </h3>
            <p class="text-gray-300 mb-6">
                We will send you an OTP to your email in order to verify your account!
            </p>
            <form action="#" method="POST">
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('verifyAccountModal')"
                        class="bg-gray-600/80 hover:bg-gray-600 text-white font-semibold px-6 py-3 rounded-xl transition-all duration-300 transform hover:scale-105">
                        Cancel
                    </button>
                    <button type="submit"
                        class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold px-6 py-3 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-blue-500/25">
                        <i class="fas fa-check mr-2"></i>
                        Verify
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="logoutOtherDevicesModal"
        class="modal-overlay hidden fixed inset-0 bg-black/80 backdrop-blur-sm flex items-center justify-center z-50">
        <div
            class="modal-content bg-gray-800/95 backdrop-blur-sm p-8 rounded-2xl shadow-2xl w-96 border border-gray-700/50">
            <h3 class="text-2xl font-bold text-red-400 mb-4 flex items-center">
                <i class="fas fa-sign-out-alt mr-3"></i>
                Confirm Logout
            </h3>
            <p class="text-gray-300 text-sm mb-6">
                Are you sure you want to logout from other devices?
            </p>

            <form action="#" method="POST">
                <div class="mb-6">
                    <label for="logout_password" class="block text-sm font-medium text-gray-300 mb-2">Password</label>
                    <input type="password" id="logout_password" name="password" required
                        class="w-full p-4 rounded-xl bg-gray-700/50 text-gray-100 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-300" />
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeModal('logoutOtherDevicesModal')"
                        class="bg-gray-600/80 hover:bg-gray-600 text-white font-semibold px-6 py-3 rounded-xl transition-all duration-300 transform hover:scale-105">
                        Cancel
                    </button>
                    <button type="submit"
                        class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-semibold px-6 py-3 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-red-500/25">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        Logout
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="deleteAccountModal"
        class="modal-overlay hidden fixed inset-0 bg-black/80 backdrop-blur-sm flex items-center justify-center z-50">
        <div
            class="modal-content bg-gray-800/95 backdrop-blur-sm p-8 rounded-2xl shadow-2xl w-96 border border-gray-700/50">
            <h3 class="text-2xl font-bold text-red-400 mb-4 flex items-center">
                <i class="fas fa-exclamation-triangle mr-3"></i>
                Confirm Account Deletion
            </h3>
            <p class="text-gray-300 text-sm mb-6">
                Enter your password to confirm deletion. This action cannot be undone.
            </p>

            <form action="#" method="POST">
                <div class="mb-6">
                    <label for="delete_password" class="block text-sm font-medium text-gray-300 mb-2">Password</label>
                    <input type="password" id="delete_password" name="password" required
                        class="w-full p-4 rounded-xl bg-gray-700/50 text-gray-100 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-300" />
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeModal('deleteAccountModal')"
                        class="bg-gray-600/80 hover:bg-gray-600 text-white font-semibold px-6 py-3 rounded-xl transition-all duration-300 transform hover:scale-105">
                        Cancel
                    </button>
                    <button type="submit"
                        class="bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-semibold px-6 py-3 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-red-600/25">
                        <i class="fas fa-trash-alt mr-2"></i>
                        Delete Account
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Image Modal -->
    <div id="addImageModal"
        class="modal-overlay hidden fixed inset-0 bg-black/80 backdrop-blur-sm flex items-center justify-center z-50">
        <div
            class="modal-content bg-gray-800/95 backdrop-blur-sm p-8 rounded-2xl shadow-2xl w-96 border border-gray-700/50 animate-bounce-in transition-all duration-300">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-white">
                    <i class="fas fa-user-plus mr-2 text-blue-500"></i>
                    Update Profile Image
                </h3>
                <button onclick="closeModal('addImageModal')"
                    class="text-gray-400 hover:text-white text-xl transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form class="space-y-4">
                <!-- Image Upload Area -->
                <div id="dropZone"
                    class="border-2 border-dashed border-gray-600 rounded-lg p-8 text-center hover:border-blue-500 transition-colors">
                    <div id="imageUploadArea" class="space-y-4">
                        <div class="text-gray-400">
                            <i class="fas fa-cloud-upload-alt text-4xl mb-4"></i>
                            <p class="text-sm">Click to browse</p>
                        </div>
                        <input type="file" id="imageInput" accept="image/*" class="hidden"
                            onchange="handleImageUpload(this)" />
                        <button type="button" onclick="document.getElementById('imageInput').click()"
                            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg text-white font-medium transition-colors">
                            <i class="fas fa-folder-open mr-2"></i>
                            Choose File
                        </button>
                    </div>

                    <!-- Image Preview -->
                    <div id="imagePreview" class="hidden">
                        <img id="previewImg" src="" alt="Preview"
                            class="max-w-full h-48 object-contain mx-auto rounded-lg" />
                        <p id="fileName" class="text-gray-400 text-sm mt-2"></p>
                    </div>
                </div>

                <!-- Modal Actions -->
                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" onclick="closeModal('addImageModal')"
                        class="px-6 py-2 bg-gray-600/50 hover:bg-gray-600/70 rounded-lg text-white font-medium transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                        class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold px-6 py-3 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-blue-600/25"
                        id="addImageBtn" disabled>
                        <i class="fas fa-plus mr-2"></i>
                        Save Image
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
