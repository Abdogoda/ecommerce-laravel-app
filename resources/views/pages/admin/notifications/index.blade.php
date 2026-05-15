@extends('layouts.admin-app')

@section('content')
    <!-- Notifications Header -->
    <div class="admin-card p-8 rounded-2xl mb-8 animate-bounce-in">
        <div class="flex flex-col lg:flex-row items-center lg:items-start justify-between gap-6">
            <!-- Header Info -->
            <div class="text-center lg:text-left flex-1">
                <div class="flex gap-0 items-start flex-col sm:flex-row sm:gap-5 sm:items-center mb-2">
                    <h1 class="text-3xl font-bold text-white mb-2">
                        Notification Center
                    </h1>
                    <div class="flex items-center space-x-4">
                        <div id="breadcrumb" class="text-sm text-gray-400">
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:underline">Admin</a>
                            <i class="fas fa-chevron-right mx-2"></i>
                            <span class="text-white">Notifications</span>
                        </div>
                    </div>
                </div>
                <p class="text-gray-400 text-lg mb-6">
                    Stay updated with system alerts, order updates, and important notifications
                </p>

                <!-- Quick Stats -->
                <div class="flex flex-wrap gap-4 justify-center lg:justify-start">
                    <div class="glass px-4 py-2 rounded-xl">
                        <i class="fas fa-bell text-blue-400 mr-2"></i>
                        <span class="text-sm">{{ $stats['total_notifications'] }} Total</span>
                    </div>
                    <div class="glass px-4 py-2 rounded-xl">
                        <i class="fas fa-bell text-yellow-400 mr-2"></i>
                        <span class="text-sm">{{ $stats['unread_notifications'] }} Unread</span>
                    </div>
                    <div class="glass px-4 py-2 rounded-xl">
                        <i class="fas fa-calendar-day text-purple-400 mr-2"></i>
                        <span class="text-sm">{{ $stats['notifications_today'] }} Today</span>
                    </div>
                    <div class="glass px-4 py-2 rounded-xl">
                        <i class="fas fa-calendar-alt text-green-400 mr-2"></i>
                        <span class="text-sm">{{ $stats['notifications_this_month'] }} This Month</span>
                    </div>
                </div>
            </div>

            @if ($stats['unread_notifications'] > 0)
                <!-- Action Buttons -->
                <div class="flex flex-wrap gap-3 justify-center lg:justify-end">
                    <form action="{{ route('admin.notifications.markAllAsRead') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                            class="btn-success px-6 py-3 rounded-xl text-white font-bold hover:scale-105 transition-transform"
                            {{ $stats['unread_notifications'] == 0 ? 'disabled' : '' }}>
                            <i class="fas fa-check-double mr-2"></i>
                            Mark All Read
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <!-- Notifications List -->
    <div class="admin-card rounded-2xl animate-slide-in">
        <div class="p-6 border-b border-white/10">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h2 class="text-xl font-bold text-white">All Notifications</h2>
                <x-export-button :table="'notifications'" />
            </div>
        </div>

        <!-- Notifications List Container -->
        <div class="p-6">
            @forelse ($notifications as $notification)
                <div class="notification-card {{ $notification->unread() ? 'unread' : '' }} admin-card p-6 rounded-xl cursor-pointer hover:shadow-xl hover:shadow-blue-500/20 transition-all mb-4 last:mb-0"
                    onclick="location.href='{{ route('admin.notifications.show', $notification) }}'">
                    <div class="flex items-start space-x-4">
                        <!-- Notification Icon -->
                        <div class="flex-shrink-0">
                            <div
                                class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-bold text-lg">
                                <i class="fas fa-bell"></i>
                            </div>
                        </div>

                        <!-- Notification Content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-2">
                                <h3
                                    class="text-lg font-semibold {{ $notification->unread() ? 'text-white' : 'text-gray-300' }}">
                                    {{ $notification->data['title'] ?? 'Notification' }}
                                </h3>
                                <div class="flex items-center space-x-2">
                                    <span
                                        class="text-sm text-gray-400">{{ $notification->created_at->diffForHumans() }}</span>
                                    @if ($notification->unread())
                                        <span class="bg-blue-500 text-white text-xs px-2 py-1 rounded-full animate-pulse">
                                            <i class="fas fa-circle mr-1"></i>New
                                        </span>
                                    @else
                                        <span class="bg-green-500/20 text-green-400 text-xs px-2 py-1 rounded-full">
                                            <i class="fas fa-check mr-1"></i>Read
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Notification Body -->
                            <p class="text-gray-300 text-sm mb-3 line-clamp-2">
                                {{ $notification->data['message'] ?? 'No message' }}
                            </p>

                            <!-- Notification Footer -->
                            <div class="flex items-center justify-between">
                                <div class="text-xs text-gray-500">
                                    <span class="bg-gray-700/50 px-2 py-1 rounded">
                                        {{ ucfirst($notification->data['type'] ?? 'system') }}
                                    </span>
                                </div>
                                <form onclick="event.stopPropagation();" method="POST"
                                    action="{{ route('admin.notifications.destroy', $notification) }}" class="inline"
                                    onsubmit="return confirm('Delete this notification?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300 text-sm">
                                        <i class="fas fa-trash mr-1"></i>Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <i class="fas fa-bell-slash text-4xl text-gray-600 mb-4 inline-block"></i>
                    <p class="text-gray-400 text-lg">No notifications yet</p>
                    <p class="text-gray-500 text-sm mt-2">When you receive notifications, they'll appear here</p>
                </div>
            @endforelse

            <!-- Pagination -->
            @if ($notifications->hasPages())
                <div class="mt-6 flex justify-center">
                    {{ $notifications->links('pagination::tailwind') }}
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Add smooth scroll behavior
                document.querySelectorAll('.notification-card').forEach(card => {
                    card.addEventListener('click', function(e) {
                        if (e.target.closest('form') || e.target.closest('button')) {
                            e.stopPropagation();
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
