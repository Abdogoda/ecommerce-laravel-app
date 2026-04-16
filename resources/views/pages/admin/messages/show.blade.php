@extends('layouts.admin-app')

@section('content')
    <!-- Message Details Header -->
    <div class="admin-card p-8 rounded-2xl mb-8 animate-bounce-in">
        <div class="flex flex-col lg:flex-row items-start justify-between gap-6">
            <!-- Header Info -->
            <div class="flex-1">
                <div class="flex gap-0 items-start flex-col sm:flex-row sm:gap-5 sm:items-center mb-2">
                    <h1 class="text-3xl font-bold text-white mb-2">
                        Message Details
                    </h1>
                    <div class="flex items-center space-x-4">
                        <div id="breadcrumb" class="text-sm text-gray-400">
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:underline">Admin</a>
                            <i class="fas fa-chevron-right mx-2"></i>
                            <a href="{{ route('admin.messages.index') }}" class="text-gray-400 hover:underline">Messages</a>
                            <i class="fas fa-chevron-right mx-2"></i>
                            <span class="text-white">{{ $message->name }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap gap-3">
                @if (!$message->is_read)
                    <form action="{{ route('admin.messages.update', $message) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="is_read" value="1">
                        <button type="submit"
                            class="btn-success px-6 py-3 rounded-xl text-white font-bold hover:scale-105 transition-transform">
                            <i class="fas fa-check-circle mr-2"></i>
                            Mark as Read
                        </button>
                    </form>
                @endif
                <a href="{{ route('admin.messages.index') }}"
                    class="px-6 py-3 bg-gray-700 hover:bg-gray-600 rounded-xl text-white font-bold transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Back
                </a>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Main Message Content -->
        <div class="lg:col-span-2">
            <!-- Message Card -->
            <div class="admin-card rounded-2xl p-8 animate-slide-in">
                <!-- Sender Info -->
                <div class="flex items-start gap-6 mb-8 pb-8 border-b border-white/10">
                    <div class="flex-shrink-0">
                        <div
                            class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-bold text-2xl">
                            {{ substr($message->name, 0, 1) }}
                        </div>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-white mb-2">
                            {{ $message->name }}
                        </h2>
                        <p class="text-blue-400 text-lg mb-3">
                            {{ $message->email }}
                        </p>
                        <div class="flex flex-wrap gap-3">
                            @if (!$message->is_read)
                                <span
                                    class="inline-flex items-center bg-blue-500/20 text-blue-400 px-3 py-1 rounded-lg text-sm font-semibold">
                                    <i class="fas fa-envelope mr-2"></i>Unread
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center bg-green-500/20 text-green-400 px-3 py-1 rounded-lg text-sm font-semibold">
                                    <i class="fas fa-check mr-2"></i>Read
                                </span>
                            @endif
                            @if ($message->user_id)
                                <span
                                    class="inline-flex items-center bg-purple-500/20 text-purple-400 px-3 py-1 rounded-lg text-sm font-semibold">
                                    <i class="fas fa-user-circle mr-2"></i>Registered User
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center bg-gray-500/20 text-gray-400 px-3 py-1 rounded-lg text-sm font-semibold">
                                    <i class="fas fa-user mr-2"></i>Guest
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Message Subject -->
                @if ($message->subject)
                    <div class="mb-6">
                        <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-2">Subject</h3>
                        <p class="text-xl text-white">{{ $message->subject }}</p>
                    </div>
                @endif

                <!-- Message Body -->
                <div class="mb-6">
                    <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Message</h3>
                    <div class="bg-gray-800/50 rounded-lg p-6 border border-gray-700">
                        <p class="text-gray-300 leading-relaxed whitespace-pre-wrap">{{ $message->body }}</p>
                    </div>
                </div>

                <!-- Message Metadata -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-6 border-t border-white/10">
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Received</p>
                        <p class="text-white mt-1">{{ $message->created_at->format('M d, Y') }}</p>
                        <p class="text-xs text-gray-500">{{ $message->created_at->format('H:i A') }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Last Updated</p>
                        <p class="text-white mt-1">{{ $message->updated_at->format('M d, Y') }}</p>
                        <p class="text-xs text-gray-500">{{ $message->updated_at->format('H:i A') }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Message ID</p>
                        <p class="text-white mt-1 font-mono text-sm">#{{ $message->id }}</p>
                    </div>
                    @if ($message->user_id)
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">From User</p>
                            <a href="{{ route('admin.users.show', $message->user) }}"
                                class="text-blue-400 hover:text-blue-300 mt-1 inline-block">
                                {{ $message->user->name }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="lg:col-span-1">
            <!-- Quick Actions -->
            <div class="admin-card rounded-2xl p-6 mb-6 animate-slide-in">
                <h3 class="text-lg font-bold text-white mb-4">Actions</h3>
                <div class="space-y-3">
                    <a href="mailto:{{ $message->email }}"
                        class="w-full btn-primary px-4 py-3 rounded-lg text-white font-semibold hover:scale-105 transition-transform text-center flex items-center justify-center gap-2">
                        <i class="fas fa-reply"></i>Reply
                    </a>
                    <a href="mailto:{{ $message->email }}?subject=Re: {{ urlencode($message->subject ?? $message->name) }}&body=Hi {{ $message->name }},%0D%0A%0D%0A"
                        class="w-full px-4 py-3 bg-gray-700 hover:bg-gray-600 rounded-lg text-white font-semibold transition-colors text-center flex items-center justify-center gap-2">
                        <i class="fas fa-pen"></i>Draft Reply
                    </a>
                    <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" style="display: block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full px-4 py-3 bg-red-500/20 hover:bg-red-500 text-red-400 hover:text-white rounded-lg font-semibold transition-colors flex items-center justify-center gap-2">
                            <i class="fas fa-trash"></i>Delete Message
                        </button>
                    </form>
                </div>
            </div>

            <!-- Sender Information -->
            <div class="admin-card rounded-2xl p-6 animate-slide-in">
                <h3 class="text-lg font-bold text-white mb-4">Sender Information</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Name</p>
                        <p class="text-white">{{ $message->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Email</p>
                        <a href="mailto:{{ $message->email }}" class="text-blue-400 hover:text-blue-300">
                            {{ $message->email }}
                        </a>
                    </div>
                    @if ($message->user_id)
                        <div class="pt-4 border-t border-white/10">
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">User Account</p>
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-purple-500/20 flex items-center justify-center">
                                    <i class="fas fa-user-circle text-purple-400"></i>
                                </div>
                                <div>
                                    <a href="{{ route('admin.users.show', $message->user) }}"
                                        class="text-white hover:text-blue-400 font-semibold">
                                        {{ $message->user->name }}
                                    </a>
                                    <p class="text-xs text-gray-500">User ID: #{{ $message->user->id }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
