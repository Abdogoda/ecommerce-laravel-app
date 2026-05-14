@extends('layouts.admin-app')

@section('content')
    <!-- Back Button & Breadcrumb -->
    <div class="mb-6">
        <a href="{{ route('admin.notifications.index') }}"
            class="text-blue-400 hover:text-blue-300 text-sm flex items-center gap-2 transition-colors">
            <i class="fas fa-arrow-left"></i>
            <span>Back to Notifications</span>
        </a>
    </div>

    <!-- Notification Detail Card -->
    <div class="admin-card rounded-2xl p-8 animate-slide-in">
        <!-- Notification Header -->
        <div class="pb-6 border-b border-white/10 mb-6">
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-start space-x-4">
                    <div
                        class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white text-lg">
                        <i class="fas fa-bell"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-white mb-1">
                            {{ $notification->data['title'] ?? 'Notification' }}
                        </h1>
                        <p class="text-gray-400">
                            {{ $notification->created_at->format('M d, Y \a\t h:i A') }}
                        </p>
                    </div>
                </div>

                @if ($notification->unread())
                    <span class="bg-blue-500 text-white px-3 py-1 rounded-full text-sm font-medium animate-pulse">
                        <i class="fas fa-circle mr-1"></i>New
                    </span>
                @else
                    <span class="bg-green-500/20 text-green-400 px-3 py-1 rounded-full text-sm font-medium">
                        <i class="fas fa-check mr-1"></i>Read
                    </span>
                @endif
            </div>
        </div>

        <!-- Notification Content -->
        <div class="mb-8">
            <div class="glass p-6 rounded-xl mb-6">
                <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-2">Notification Details</h2>
                <p class="text-white text-lg leading-relaxed">
                    {{ $notification->data['message'] ?? 'No message provided' }}
                </p>
            </div>

            <!-- Notification Type & ID -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="glass p-4 rounded-xl">
                    <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Notification Type</p>
                    <p class="text-white font-medium capitalize">
                        {{ ucfirst($notification->data['type'] ?? 'system') }}
                    </p>
                </div>
                <div class="glass p-4 rounded-xl">
                    <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Notification ID</p>
                    <p class="text-white font-medium font-mono text-sm">{{ $notification->id }}</p>
                </div>
            </div>
        </div>

        <!-- Additional Data (if available) -->
        @if (isset($notification->data['url']) && $notification->data['url'])
            <div class="mb-8">
                <h3 class="text-white font-semibold mb-3">Related Action</h3>
                <a href="{{ $notification->data['url'] }}"
                    class="btn-primary px-4 py-2 rounded-xl text-white font-medium hover:scale-105 transition-transform inline-block">
                    <i class="fas fa-external-link-alt mr-2"></i>
                    View Related Item
                </a>
            </div>
        @endif

        <!-- Quick Stats -->
        @php
            $allNotifications = \Illuminate\Notifications\DatabaseNotification::count();
            $unreadNotifications = \Illuminate\Notifications\DatabaseNotification::whereNull('read_at')->count();
        @endphp
        <div class="glass p-6 rounded-xl mb-8">
            <h3 class="text-white font-semibold mb-4">System Notifications</h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                <div>
                    <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Total</p>
                    <p class="text-2xl font-bold text-white">{{ $allNotifications }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Unread</p>
                    <p class="text-2xl font-bold text-yellow-400">{{ $unreadNotifications }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Read</p>
                    <p class="text-2xl font-bold text-green-400">{{ $allNotifications - $unreadNotifications }}</p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-wrap gap-3 pt-6 border-t border-white/10">
            <a href="{{ route('admin.notifications.index') }}"
                class="btn-gray px-4 py-2 rounded-xl text-white font-medium hover:scale-105 transition-transform">
                <i class="fas fa-list mr-2"></i>
                Back to List
            </a>

            @if ($notification->unread())
                <form method="POST" action="{{ route('admin.notifications.markAllAsRead') }}" class="inline">
                    @csrf
                    <button type="submit"
                        class="btn-success px-4 py-2 rounded-xl text-white font-medium hover:scale-105 transition-transform">
                        <i class="fas fa-check mr-2"></i>
                        Mark as Read
                    </button>
                </form>
            @endif

            <form method="POST" action="{{ route('admin.notifications.destroy', $notification) }}" class="inline"
                onsubmit="return confirm('Delete this notification? This action cannot be undone.');">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="btn-danger px-4 py-2 rounded-xl text-white font-medium hover:scale-105 transition-transform">
                    <i class="fas fa-trash mr-2"></i>
                    Delete
                </button>
            </form>
        </div>
    </div>
@endsection
