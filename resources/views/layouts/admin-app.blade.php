<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @php
        $storeName = $generalSettings->name ?? 'E-Commerce';
        $favicon =
            $generalSettings->favicon ?? null
                ? asset('storage/' . $generalSettings->favicon)
                : asset('assets/icon.png');
    @endphp
    <title>@yield('title', $storeName . ' - Admin')</title>
    <link rel="shortcut icon" href="{{ $favicon }}" type="image/png" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/admin/styles.css') }}" />

    <!-- Scripts -->
    <script src="{{ asset('assets/js/admin/main.js') }}"></script>
    <script src="{{ asset('assets/js/admin/tags.js') }}"></script>

    <!-- Additional CSS will be inserted here -->
    @stack('styles')
</head>

<body class="admin-bg text-white flex min-h-screen">
    <!-- Toastr Notifications -->
    @include('components.toastr')

    <!-- Sidebar -->
    <sidebar id="sidebar"
        class="glass w-64 min-h-screen fixed transition-all duration-300 transform -translate-x-full md:translate-x-0 z-50 border-r border-white/10 flex flex-col">
        <!-- Logo Section -->
        <div class="p-6 pb-4 flex-shrink-0">
            <div class="animate-bounce-in">
                <div class="flex flex-col items-center space-y-2">
                    @if (isset($generalSettings) && $generalSettings->logo)
                        <img src="{{ asset('storage/' . $generalSettings->logo) }}" alt="Logo"
                            class="w-12 h-12 rounded-xl object-contain" />
                    @else
                        <i class="fas fa-store text-blue-400 text-lg"></i>
                    @endif
                    <h2 class="text-xl font-bold text-white">{{ $storeName ?? 'E-Commerce' }}</h2>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 overflow-y-auto px-6 pb-6">
            <div class="space-y-2">
                <!-- Main Navigation -->
                <div class="mb-8">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">
                        Main
                    </p>
                    <ul class="space-y-1">
                        <!-- Dashboard -->
                        <li>
                            <a href="{{ route('admin.dashboard') }}"
                                class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }} flex items-center p-3 rounded-xl text-gray-300 hover:text-white group">
                                <i
                                    class="fas fa-chart-line text-blue-500 w-5 mr-3 group-hover:scale-110 transition-transform"></i>
                                <span class="font-medium">Dashboard</span>
                            </a>
                        </li>

                        @can(\App\Enums\PermissionEnum::VIEW_USERS->value)
                            <!-- Users Management -->
                            <li>
                                <a href="{{ route('admin.users.index') }}"
                                    class="sidebar-item {{ request()->routeIs('admin.users.index') ? 'active' : '' }} flex items-center p-3 rounded-xl text-gray-300 hover:text-white group">
                                    <i
                                        class="fas fa-users text-green-500 w-5 mr-3 group-hover:scale-110 transition-transform"></i>
                                    <span class="font-medium">Users</span>
                                </a>
                            </li>
                        @endcan

                        @can(\App\Enums\PermissionEnum::VIEW_ROLES->value)
                            <!-- Roles -->
                            <li>
                                <a href="{{ route('admin.roles.index') }}"
                                    class="sidebar-item {{ request()->routeIs('admin.roles.index') ? 'active' : '' }} flex items-center p-3 rounded-xl text-gray-300 hover:text-white group">
                                    <i
                                        class="fas fa-user-shield text-purple-500 w-5 mr-3 group-hover:scale-110 transition-transform"></i>
                                    <span class="font-medium">Roles</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </div>

                <!-- Catalog Management -->
                <div class="mb-8">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">
                        Catalog
                    </p>
                    <ul class="space-y-1">

                        @can(\App\Enums\PermissionEnum::VIEW_CATEGORIES->value)
                            <!-- Categories -->
                            <li>
                                <a href="{{ route('admin.categories.index') }}"
                                    class="sidebar-item {{ request()->routeIs('admin.categories.index') ? 'active' : '' }} flex items-center p-3 rounded-xl text-gray-300 hover:text-white group">
                                    <i
                                        class="fas fa-tags text-yellow-500 w-5 mr-3 group-hover:scale-110 transition-transform"></i>
                                    <span class="font-medium">Categories</span>
                                </a>
                            </li>
                        @endcan


                        @can(\App\Enums\PermissionEnum::VIEW_PRODUCTS->value)
                            <!-- Products -->
                            <li>
                                <a href="{{ route('admin.products.index') }}"
                                    class="sidebar-item {{ request()->routeIs('admin.products.index') ? 'active' : '' }} flex items-center p-3 rounded-xl text-gray-300 hover:text-white group">
                                    <i
                                        class="fas fa-box text-orange-500 w-5 mr-3 group-hover:scale-110 transition-transform"></i>
                                    <span class="font-medium">Products</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </div>

                <!-- Sales & Communication -->
                @can(\App\Enums\PermissionEnum::VIEW_ORDERS->value)
                    <div class="mb-8">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">
                            Sales
                        </p>
                        <ul class="space-y-1">
                            <!-- Orders -->
                            <li>
                                <a href="{{ route('admin.orders.index') }}"
                                    class="sidebar-item {{ request()->routeIs('admin.orders.index') ? 'active' : '' }} flex items-center p-3 rounded-xl text-gray-300 hover:text-white group">
                                    <i
                                        class="fas fa-shopping-cart text-red-500 w-5 mr-3 group-hover:scale-110 transition-transform"></i>
                                    <span class="font-medium">Orders</span>
                                    @if ($pendingOrderCount > 0)
                                        <span
                                            class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full animate-pulse">{{ $pendingOrderCount }}</span>
                                    @endif
                                </a>
                            </li>
                        </ul>
                    </div>
                @endcan

                <!-- Reports -->
                <div class="mb-8">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">
                        Reports
                    </p>
                    <ul class="space-y-1">

                        <!-- Notifications -->
                        <li>
                            <a href="{{ route('admin.notifications.index') }}"
                                class="sidebar-item {{ request()->routeIs('admin.notifications.index') ? 'active' : '' }} flex items-center p-3 rounded-xl text-gray-300 hover:text-white group">
                                <i
                                    class="fas fa-bell text-orange-500 w-5 mr-3 group-hover:scale-110 transition-transform"></i>
                                <span class="font-medium">Notifications</span>
                                @if ($unreadNotificationCount > 0)
                                    <span
                                        class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full animate-pulse">{{ $unreadNotificationCount }}</span>
                                @endif
                            </a>
                        </li>

                        @can(\App\Enums\PermissionEnum::VIEW_MESSAGES->value)
                            <!-- Messages -->
                            <li>
                                <a href="{{ route('admin.messages.index') }}"
                                    class="sidebar-item {{ request()->routeIs('admin.messages.index') ? 'active' : '' }} flex items-center p-3 rounded-xl text-gray-300 hover:text-white group">
                                    <i
                                        class="fas fa-envelope text-cyan-500 w-5 mr-3 group-hover:scale-110 transition-transform"></i>
                                    <span class="font-medium">Messages</span>
                                    @if ($unreadMessageCount > 0)
                                        <span
                                            class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full animate-pulse">{{ $unreadMessageCount }}</span>
                                    @endif
                                </a>
                            </li>
                        @endcan


                        @can(\App\Enums\PermissionEnum::VIEW_ACTIVITIES->value)
                            <!-- Activities -->
                            <li>
                                <a href="{{ route('admin.activities.index') }}"
                                    class="sidebar-item {{ request()->routeIs('admin.activities.index') ? 'active' : '' }} flex items-center p-3 rounded-xl text-gray-300 hover:text-white group">
                                    <i
                                        class="fas fa-history text-pink-500 w-5 mr-3 group-hover:scale-110 transition-transform"></i>
                                    <span class="font-medium">Activities</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </div>

                <!-- Account -->
                <div class="border-t border-white/10 pt-4">
                    <ul class="space-y-1">
                        <li>
                            <a href="{{ route('admin.settings.index') }}"
                                class="sidebar-item {{ request()->routeIs('admin.settings.index') ? 'active' : '' }} flex items-center p-3 rounded-xl text-gray-300 hover:text-white group">
                                <i
                                    class="fas fa-cogs text-emerald-500 w-5 mr-3 group-hover:scale-110 transition-transform"></i>
                                <span class="font-medium">Settings</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.profile') }}"
                                class="sidebar-item {{ request()->routeIs('admin.profile') ? 'active' : '' }} flex items-center p-3 rounded-xl text-gray-300 hover:text-white group">
                                <i
                                    class="fas fa-user-circle text-indigo-500 w-5 mr-3 group-hover:scale-110 transition-transform"></i>
                                <span class="font-medium">Profile</span>
                            </a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                <button type="submit"
                                    class="sidebar-item flex items-center p-3 rounded-xl text-gray-300 hover:text-red-400 group w-full text-left">
                                    <i
                                        class="fas fa-sign-out-alt text-red-500 w-5 mr-3 group-hover:scale-110 transition-transform"></i>
                                    <span class="font-medium">Logout</span>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </sidebar>

    <!-- Main Content -->
    <main class="max-w-full flex-1 md:ml-64 min-h-screen">
        <!-- Top Header -->
        <header class="glass border-b border-white/10 sticky top-0 z-40">
            <!-- Desktop Search + Actions Row -->
            <div class="p-4 flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <!-- Branding (Mobile Only) -->
                    <div class="block md:hidden animate-bounce-in">
                        <div class="flex items-center space-x-3">
                            <div>
                                <a href="{{ route('admin.dashboard') }}"
                                    class="text-xl font-bold text-white hover:text-purple-600 transition-colors">
                                    {{ $storeName ?? 'E-Commerce' }}
                                </a>
                                <p class="text-xs text-gray-400">Admin Panel</p>
                            </div>
                        </div>
                    </div>
                    <!-- Global Search Component -->
                    @include('components.admin.global-search')
                </div>

                <!-- Header Actions -->
                <div class="flex items-center space-x-3">
                    <!-- Mobile Menu Button -->
                    <button id="toggleSidebar"
                        class="md:hidden glass p-2 rounded-xl text-gray-400 hover:text-white hover:bg-white/5 transition-colors">
                        <i class="fas fa-bars"></i>
                    </button>
                    <!-- Mobile Search Button -->
                    <button id="searchToggle"
                        class="md:hidden glass p-2 rounded-xl text-gray-400 hover:text-white hover:bg-white/5 transition-colors"
                        title="Search">
                        <i class="fas fa-search"></i>
                    </button>
                    <!-- Notifications -->
                    <a href="{{ route('admin.notifications.index') }}"
                        class="glass p-2 rounded-xl text-gray-400 hover:text-white hover:bg-white/5 transition-colors relative"
                        title="Notifications">
                        <i class="fas fa-bell"></i>
                        @if ($unreadNotificationCount > 0)
                            <span
                                class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center animate-pulse">{{ $unreadNotificationCount }}</span>
                        @endif
                    </a>

                    <!-- User Profile -->
                    <a href="{{ route('admin.profile') }}" title="Profile"
                        class="flex items-center space-x-2 glass px-3 py-2 rounded-xl">
                        @if (Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar"
                                class="w-8 h-8 rounded-full object-cover">
                        @else
                            <div
                                class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                        @endif
                        <div class="hidden sm:block">
                            <p class="text-sm font-medium text-white">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-400">Administrator</p>
                        </div>
                    </a>
                </div>
            </div>
        </header>

        <!-- Mobile Sidebar Overlay -->
        <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden" onclick="closeSidebar()">
        </div>

        <!-- Page Content -->
        <div class="p-6 animate-fade-in">
            @yield('content')
        </div>
    </main>

    <!-- Additional Scripts -->
    @stack('scripts')
</body>

</html>
