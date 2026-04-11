@extends('layouts.user-app')

@section('content')
<div class="max-w-7xl mx-auto">
        <!-- Page Header -->
        <div class="text-center mb-12 animate-fade-in-up">
          <h1 class="text-5xl font-bold text-white mb-4">
            <i class="fas fa-credit-card mr-4 text-green-400"></i>
            <span
              class="bg-gradient-to-r from-green-400 to-blue-500 bg-clip-text text-transparent"
            >
              Checkout
            </span>
          </h1>
          <div
            class="w-24 h-1 bg-gradient-to-r from-green-400 to-blue-500 mx-auto mt-4 rounded-full"
          ></div>
        </div>

        <!-- Checkout Form -->
        <form action="" method="post">
          <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Checkout Form -->
            <div class="lg:col-span-2 space-y-8">
              <!-- Billing Information -->
              <div
                class="bg-gray-800/50 backdrop-blur-sm rounded-2xl p-8 border border-gray-700/50 animate-fade-in-left card-hover"
              >
                <h2
                  class="text-2xl font-bold text-white mb-6 flex items-center"
                >
                  <i class="fas fa-user mr-3 text-blue-400"></i>
                  Billing Information
                </h2>
                <form class="space-y-6">
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                      <label
                        for="firstName"
                        class="block text-sm font-medium text-gray-300 mb-2"
                        >First Name</label
                      >
                      <input
                        type="text"
                        id="firstName"
                        name="firstName"
                        required
                        class="w-full p-4 rounded-xl bg-gray-700/50 text-gray-100 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                        placeholder="John"
                      />
                    </div>
                    <div>
                      <label
                        for="lastName"
                        class="block text-sm font-medium text-gray-300 mb-2"
                        >Last Name</label
                      >
                      <input
                        type="text"
                        id="lastName"
                        name="lastName"
                        required
                        class="w-full p-4 rounded-xl bg-gray-700/50 text-gray-100 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                        placeholder="Doe"
                      />
                    </div>
                  </div>
                  <div>
                    <label
                      for="email"
                      class="block text-sm font-medium text-gray-300 mb-2"
                      >Email Address</label
                    >
                    <input
                      type="email"
                      id="email"
                      name="email"
                      required
                      class="w-full p-4 rounded-xl bg-gray-700/50 text-gray-100 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                      placeholder="john@example.com"
                    />
                  </div>
                  <div>
                    <label
                      for="phone"
                      class="block text-sm font-medium text-gray-300 mb-2"
                      >Phone Number</label
                    >
                    <input
                      type="tel"
                      id="phone"
                      name="phone"
                      required
                      class="w-full p-4 rounded-xl bg-gray-700/50 text-gray-100 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                      placeholder="+1 (555) 123-4567"
                    />
                  </div>
                  <div>
                    <label
                      for="address"
                      class="block text-sm font-medium text-gray-300 mb-2"
                      >Street Address</label
                    >
                    <input
                      type="text"
                      id="address"
                      name="address"
                      required
                      class="w-full p-4 rounded-xl bg-gray-700/50 text-gray-100 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                      placeholder="123 Main Street"
                    />
                  </div>
                  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                      <label
                        for="city"
                        class="block text-sm font-medium text-gray-300 mb-2"
                        >City</label
                      >
                      <input
                        type="text"
                        id="city"
                        name="city"
                        required
                        class="w-full p-4 rounded-xl bg-gray-700/50 text-gray-100 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                        placeholder="New York"
                      />
                    </div>
                    <div>
                      <label
                        for="state"
                        class="block text-sm font-medium text-gray-300 mb-2"
                        >State</label
                      >
                      <select
                        id="state"
                        name="state"
                        required
                        class="w-full p-4 rounded-xl bg-gray-700/50 text-gray-100 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                      >
                        <option value="">Select State</option>
                        <option value="CA">California</option>
                        <option value="NY">New York</option>
                        <option value="TX">Texas</option>
                        <option value="FL">Florida</option>
                        <!-- Add more states as needed -->
                      </select>
                    </div>
                    <div>
                      <label
                        for="zipCode"
                        class="block text-sm font-medium text-gray-300 mb-2"
                        >ZIP Code</label
                      >
                      <input
                        type="text"
                        id="zipCode"
                        name="zipCode"
                        required
                        class="w-full p-4 rounded-xl bg-gray-700/50 text-gray-100 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                        placeholder="10001"
                      />
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
              <div
                class="bg-gray-800/50 backdrop-blur-sm rounded-2xl p-8 border border-gray-700/50 animate-fade-in-right sticky top-24 card-hover"
              >
                <h2
                  class="text-2xl font-bold text-white mb-6 flex items-center"
                >
                  <i class="fas fa-receipt mr-3 text-orange-400"></i>
                  Order Summary
                </h2>

                <!-- Cart Items -->
                <div class="space-y-4 mb-6">
                  <div
                    class="flex items-center space-x-4 p-4 bg-gray-700/30 rounded-xl"
                  >
                    <img
                      src="https://placehold.co/64x64"
                      alt="Product"
                      class="w-16 h-16 rounded-lg object-cover"
                    />
                    <div class="flex-grow">
                      <h3 class="text-white font-semibold">
                        Wireless Headphones
                      </h3>
                      <p class="text-gray-400 text-sm">Quantity: 1</p>
                    </div>
                    <span class="text-green-400 font-bold">$129.99</span>
                  </div>
                  <div
                    class="flex items-center space-x-4 p-4 bg-gray-700/30 rounded-xl"
                  >
                    <img
                      src="https://placehold.co/64x64"
                      alt="Product"
                      class="w-16 h-16 rounded-lg object-cover"
                    />
                    <div class="flex-grow">
                      <h3 class="text-white font-semibold">Smartphone Case</h3>
                      <p class="text-gray-400 text-sm">Quantity: 2</p>
                    </div>
                    <span class="text-green-400 font-bold">$39.98</span>
                  </div>
                </div>

                <!-- Order Totals -->
                <div class="border-t border-gray-700 pt-6 space-y-3">
                  <div class="flex justify-between text-gray-300">
                    <span>Subtotal:</span>
                    <span>$169.97</span>
                  </div>
                  <div class="flex justify-between text-gray-300">
                    <span>Shipping:</span>
                    <span>$9.99</span>
                  </div>
                  <div class="flex justify-between text-gray-300">
                    <span>Tax:</span>
                    <span>$17.00</span>
                  </div>
                  <div class="border-t border-gray-600 pt-3">
                    <div
                      class="flex justify-between text-xl font-bold text-white"
                    >
                      <span>Total:</span>
                      <span class="text-green-400">$196.96</span>
                    </div>
                  </div>
                </div>

                <!-- Place Order Button -->
                <button
                  type="submit"
                  class="w-full mt-8 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-4 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-green-500/25 text-lg"
                >
                  <i class="fas fa-lock mr-2"></i>
                  Place Order - $196.96
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
@endsection
