@extends('layouts.admin-app')

@section('content')
    <!-- Messages Header -->
    <div class="admin-card p-8 rounded-2xl mb-8 animate-bounce-in">
        <div class="flex flex-col lg:flex-row items-center lg:items-start justify-between gap-6">
            <!-- Header Info -->
            <div class="text-center lg:text-left flex-1">
                <div class="flex gap-0 items-start flex-col sm:flex-row sm:gap-5 sm:items-center mb-2">
                    <h1 class="text-3xl font-bold text-white mb-2">
                        Message Management
                    </h1>
                    <div class="flex items-center space-x-4">
                        <div id="breadcrumb" class="text-sm text-gray-400">
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:underline">Admin</a>
                            <i class="fas fa-chevron-right mx-2"></i>
                            <span class="text-white">Messages</span>
                        </div>
                    </div>
                </div>
                <p class="text-gray-400 text-lg mb-6">
                    Manage customer inquiries, support requests, and communications
                </p>

                <!-- Quick Stats -->
                <div class="flex flex-wrap gap-4 justify-center lg:justify-start">
                    <div class="glass px-4 py-2 rounded-xl">
                        <i class="fas fa-envelope text-blue-400 mr-2"></i>
                        <span class="text-sm">{{ $stats['total_messages'] }} Total</span>
                    </div>
                    <div class="glass px-4 py-2 rounded-xl">
                        <i class="fas fa-envelope-open-text text-yellow-400 mr-2"></i>
                        <span class="text-sm">{{ $stats['unread_messages'] }} Unread</span>
                    </div>
                    <div class="glass px-4 py-2 rounded-xl">
                        <i class="fas fa-calendar-day text-purple-400 mr-2"></i>
                        <span class="text-sm">{{ $stats['messages_today'] }} Today</span>
                    </div>
                    <div class="glass px-4 py-2 rounded-xl">
                        <i class="fas fa-calendar-alt text-green-400 mr-2"></i>
                        <span class="text-sm">{{ $stats['messages_this_month'] }} This Month</span>
                    </div>
                </div>
            </div>

            @if ($stats['unread_messages'] > 0)
                <!-- Action Buttons -->
                <div class="flex flex-wrap gap-3 justify-center lg:justify-end">
                    <form action="{{ route('admin.messages.markAllAsRead') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                            class="btn-success px-6 py-3 rounded-xl text-white font-bold hover:scale-105 transition-transform"
                            {{ $stats['unread_messages'] == 0 ? 'disabled' : '' }}>
                            <i class="fas fa-check-double mr-2"></i>
                            Mark All Read
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <!-- Messages List -->
    <div class="admin-card rounded-2xl animate-slide-in">
        <div class="p-6 border-b border-white/10">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h2 class="text-xl font-bold text-white">All Messages</h2>
            </div>
        </div>

        <!-- Messages List Container -->
        <div class="p-6">
            @forelse ($messages as $message)
                <div class="message-card {{ !$message->is_read ? 'unread' : '' }} admin-card p-6 rounded-xl cursor-pointer hover:shadow-xl hover:shadow-blue-500/20 transition-all mb-4 last:mb-0"
                    onclick="location.href='{{ route('admin.messages.show', $message) }}'">
                    <div class="flex items-start space-x-4">
                        <!-- Avatar -->
                        <div class="flex-shrink-0">
                            <div
                                class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-bold text-lg">
                                {{ substr($message->name, 0, 1) }}
                            </div>
                        </div>

                        <!-- Message Content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-lg font-semibold {{ $message->is_read ? 'text-gray-300' : 'text-white' }}">
                                    {{ $message->name }}
                                </h3>
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm text-gray-400">{{ $message->created_at->diffForHumans() }}</span>
                                    @if (!$message->is_read)
                                        <span class="bg-blue-500 text-white text-xs px-2 py-1 rounded-full animate-pulse">
                                            <i class="fas fa-envelope mr-1"></i>New
                                        </span>
                                    @else
                                        <span class="bg-green-500/20 text-green-400 text-xs px-2 py-1 rounded-full">
                                            <i class="fas fa-check mr-1"></i>Read
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <p class="text-blue-400 text-sm mb-3">
                                {{ $message->email }}
                            </p>
                            <p
                                class="text-gray-300 text-sm leading-relaxed {{ $message->is_read ? 'text-gray-400' : '' }} line-clamp-2">
                                @if ($message->subject)
                                    <strong>{{ $message->subject }}</strong><br>
                                @endif
                                {{ Str::limit($message->body, 150) }}
                            </p>
                            <div class="flex items-center mt-4 space-x-4 flex-wrap gap-2">
                                @if ($message->user_id)
                                    <div class="flex items-center text-gray-400 text-sm bg-gray-800/50 px-2 py-1 rounded">
                                        <i class="fas fa-user-circle mr-1"></i>
                                        <span>Registered User</span>
                                    </div>
                                @else
                                    <div class="flex items-center text-gray-400 text-sm bg-gray-800/50 px-2 py-1 rounded">
                                        <i class="fas fa-user mr-1"></i>
                                        <span>Guest</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex-shrink-0 flex flex-col gap-2" onclick="event.stopPropagation();">
                            <a href="{{ route('admin.messages.show', $message) }}"
                                class="px-3 py-1 bg-blue-500/20 text-blue-400 hover:bg-blue-500 hover:text-white rounded-lg text-xs font-semibold transition-all"
                                title="View Message">
                                <i class="fas fa-eye mr-1"></i>View
                            </a>
                            <form action="{{ route('admin.messages.destroy', $message) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full px-3 py-1 bg-red-500/20 text-red-400 hover:bg-red-500 hover:text-white rounded-lg text-xs font-semibold transition-all"
                                    title="Delete Message">
                                    <i class="fas fa-trash mr-1"></i>Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <i class="fas fa-inbox text-gray-600 text-5xl mb-4"></i>
                    <p class="text-gray-400 text-lg">No messages yet. Check back later!</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($messages->hasPages())
            <div class="p-6 border-t border-white/10">
                <div class="flex justify-center">
                    {{ $messages->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection
