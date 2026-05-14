<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @php
        $storeName = $generalSettings->name ?? 'E-Commerce';
        $favicon =
            $generalSettings->favicon ?? null
                ? asset('storage/' . $generalSettings->favicon)
                : asset('assets/icon.png');
    @endphp
    <title>@yield('title', $storeName)</title>
    <link rel="shortcut icon" href="{{ $favicon }}" type="image/png" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/user/styles.css') }}" />

    <!-- Scripts -->
    <script src="{{ asset('assets/js/user/main.js') }}"></script>
    <script src="{{ asset('assets/js/user/cart.js') }}"></script>

    <!-- Additional Styles -->
    @stack('styles')
</head>

<body class="bg-gray-900 text-white">
    <!-- Toastr Notifications -->
    @include('components.toastr')

    <!-- Header -->
    <header class="bg-gray-800/95 backdrop-blur-sm py-6 px-6 animate-fade-in-down shadow-2xl sticky top-0 z-50">
        <div class="w-full md:max-w-7xl mx-auto flex justify-between items-center gap-3">
            <h1 class="text-2xl font-bold animate-fade-in-left">
                <a href="" class="hover:text-blue-400 transition-colors duration-300 flex items-center gap-2">
                    @if (isset($generalSettings) && $generalSettings->logo)
                        <img src="{{ asset('storage/' . $generalSettings->logo) }}" alt="Logo"
                            class="w-10 h-10 rounded-xl object-contain" />
                    @else
                        <i class="fas fa-store text-blue-400"></i>
                    @endif
                    {{ $storeName ?? 'E-Commerce' }}
                </a>
            </h1>

            <!-- Mobile Menu Toggle Button -->
            <button id="mobile-menu-toggle"
                class="md:hidden relative w-10 h-10 flex flex-col justify-center items-center space-y-1.5 cursor-pointer group"
                aria-label="Toggle navigation menu">
                <span
                    class="w-6 h-0.5 bg-white transition-all duration-300 transform group-hover:bg-blue-400 origin-center"></span>
                <span class="w-6 h-0.5 bg-white transition-all duration-300 transform group-hover:bg-blue-400"></span>
                <span
                    class="w-6 h-0.5 bg-white transition-all duration-300 transform group-hover:bg-blue-400 origin-center"></span>
            </button>

            <!-- Navigation Menu -->
            <nav id="mobile-nav"
                class="hidden md:block absolute md:relative top-full left-0 right-0 md:top-auto md:left-auto md:right-auto w-full md:w-auto bg-gray-800/95 md:bg-transparent backdrop-blur-sm md:backdrop-blur-none p-4 md:p-0 rounded-b-lg md:rounded-none shadow-2xl md:shadow-none z-40 animate-fade-in-right">
                <ul
                    class="flex flex-col md:flex-row w-full md:w-auto md:space-x-6 md:items-center space-y-3 md:space-y-0">
                    <li class="animate-fade-in-up delay-100">
                        <a href="{{ route('home') }}"
                            class="hover:text-blue-400 {{ request()->routeIs('home') ? 'text-blue-400' : '' }} transition-all duration-300 relative group block py-2 md:py-0">
                            <span>Home</span>
                            <span
                                class="absolute -bottom-1 left-0 w-0 h-0.5 bg-blue-400 transition-all duration-300 group-hover:w-full {{ request()->routeIs('home') ? 'w-full' : '' }}"></span>
                        </a>
                    </li>
                    <li class="animate-fade-in-up delay-200">
                        <a href="{{ route('categories.index') }}"
                            class="hover:text-blue-400 {{ request()->routeIs('categories.index') ? 'text-blue-400' : '' }} transition-all duration-300 relative group block py-2 md:py-0">
                            <span>Categories</span>
                            <span
                                class="absolute -bottom-1 left-0 w-0 h-0.5 bg-blue-400 transition-all duration-300 group-hover:w-full {{ request()->routeIs('categories.index') ? 'w-full' : '' }}"></span>
                        </a>
                    </li>
                    <li class="animate-fade-in-up delay-200">
                        <a href="{{ route('products.index') }}"
                            class="hover:text-blue-400 {{ request()->routeIs('products.index') ? 'text-blue-400' : '' }} transition-all duration-300 relative group block py-2 md:py-0">
                            <span>Products</span>
                            <span
                                class="absolute -bottom-1 left-0 w-0 h-0.5 bg-blue-400 transition-all duration-300 group-hover:w-full {{ request()->routeIs('products.index') ? 'w-full' : '' }}"></span>
                        </a>
                    </li>
                    <li class="relative animate-fade-in-up delay-300">
                        <a href="{{ route('cart') }}" title="View Cart"
                            class="hover:text-blue-400 transition-all duration-300 hover:scale-105 transform py-2 md:py-0 flex items-center">
                            <i class="fa fa-shopping-cart text-lg"></i>
                            <span class="md:hidden ml-2">Cart</span>
                            <span id="cart-badge"
                                class="w-5 h-5 absolute -top-2 -right-2 md:-top-2 md:-right-2 bg-red-500 text-sm text-white p-1 rounded-full flex items-center justify-center animate-pulse">0</span>
                        </a>
                    </li>
                    @auth
                        @can('view dashboard')
                            <!-- Admin Dashboard Link (conditional) -->
                            <li class="animate-fade-in-up delay-500">
                                <a href="{{ route('admin.dashboard') }}" title="Admin Dashboard"
                                    class="hover:text-blue-400 transition-all duration-300 hover:scale-105 transform py-2 md:py-0 flex items-center"><i
                                        class="fa fa-user-gear text-lg"></i><span class="md:hidden ml-2">Admin Panel</span></a>
                            </li>
                        @endcan
                        <!-- User Profile Link -->
                        <li class="animate-fade-in-up delay-700">
                            <a href="{{ route('profile') }}" title="User Profile"
                                class="hover:text-blue-400 transition-all duration-300 hover:scale-105 transform py-2 md:py-0 flex items-center"><i
                                    class="fa fa-user text-lg"></i><span class="md:hidden ml-2">Profile</span></a>
                        </li>
                        <!-- Logout Button -->
                        <li class="animate-fade-in-up delay-700">
                            <form method="POST" action="{{ route('logout') }}" class="w-full md:w-auto">
                                @csrf
                                <button type="submit"
                                    class="w-full md:w-auto bg-red-600 text-sm text-white px-4 py-2 rounded-lg hover:bg-red-700 hover:shadow-lg hover:shadow-red-500/50 transition-all duration-300 hover:scale-105 transform">
                                    <i class="fas fa-sign-out-alt mr-1"></i>Logout
                                </button>
                            </form>
                        </li>
                    @endauth
                    @guest
                        <li class="animate-fade-in-up delay-700">
                            <a href="{{ route('login') }}"
                                class="w-full md:w-auto bg-blue-600 text-sm text-white px-4 py-2 rounded-lg hover:bg-blue-700 hover:shadow-lg hover:shadow-blue-500/50 transition-all duration-300 hover:scale-105 transform inline-block">
                                <i class="fas fa-sign-in-alt mr-1"></i>Login
                            </a>
                        </li>
                    @endguest
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    @yield('content')


    <!-- Additional Scripts -->
    @stack('scripts')
</body>

</html>
