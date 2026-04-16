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
    <link rel="stylesheet" href="{{ asset('assets/css/auth/styles.css') }}" />

    <!-- Scripts -->
    <script src="{{ asset('assets/js/auth/main.js') }}"></script>

    <!-- Additional CSS will be inserted here -->
    @stack('styles')
</head>

<body class="auth-bg min-h-screen relative">
    <!-- Toastr Notifications -->
    @include('components.toastr')

    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-white/10 rounded-full blur-3xl float-animation"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-blue-400/10 rounded-full blur-3xl float-animation"
            style="animation-delay: 2s"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-purple-400/5 rounded-full blur-3xl float-animation"
            style="animation-delay: 4s"></div>
    </div>

    <!-- Main Content -->
    <main class="min-h-screen flex items-center justify-center py-20 px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="w-full max-w-md animate-scale-in">
            <!-- Content -->
            @yield('content')
        </div>
    </main>

    <!-- Additional Scripts will be inserted here -->
    @stack('scripts')
</body>

</html>
