@extends('layouts.admin-app')

@section('content')
    <div class="p-6">
        <!-- Page Header -->
        <div class="mb-8 fade-in-up">
            <div class="flex justify-between items-start flex-col sm:flex-row gap-6">
                <div class="flex-1">
                    <div class="flex gap-0 items-start flex-col sm:flex-row sm:gap-5 sm:items-center mb-2">
                        <h1 class="text-3xl font-bold text-white mb-2">
                            Activity Management
                        </h1>
                        <div class="flex items-center space-x-4">
                            <div id="breadcrumb" class="text-sm text-gray-400">
                                <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:underline">Admin</a>
                                <i class="fas fa-chevron-right mx-2"></i>
                                <span class="text-white">Activities</span>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-400">Monitor system activities and user actions across the platform</p>
                </div>
                @can(\App\Enums\PermissionEnum::CLEAR_ACTIVITIES->value)
                    <button onclick="openModal('clearActivitiesModal')"
                        class="btn-danger px-6 py-3 rounded-lg text-white font-medium hover:shadow-xl transition-all duration-300">
                        <i class="fas fa-trash mr-2"></i>
                        Clear Activities
                    </button>
                @endcan
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="stats-card admin-card rounded-xl p-6 fade-in-up delay-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Total Activities</p>
                        <p class="text-2xl font-bold text-white">{{ number_format($stats['total_activities']) }}</p>
                    </div>
                    <div class="icon w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-history text-blue-400 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="stats-card admin-card rounded-xl p-6 fade-in-up delay-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Today</p>
                        <p class="text-2xl font-bold text-white">
                            {{ number_format($stats['today_activities']) }}
                        </p>
                    </div>
                    <div class="icon w-12 h-12 bg-green-500/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-calendar-check text-green-400 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="stats-card admin-card rounded-xl p-6 fade-in-up delay-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">This Week</p>
                        <p class="text-2xl font-bold text-white">
                            {{ number_format($stats['this_week_activities']) }}
                        </p>
                    </div>
                    <div class="icon w-12 h-12 bg-yellow-500/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-chart-line text-yellow-400 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="stats-card admin-card rounded-xl p-6 fade-in-up delay-400">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Active Users</p>
                        <p class="text-2xl font-bold text-white">
                            {{ number_format($users->count()) }}
                        </p>
                    </div>
                    <div class="icon w-12 h-12 bg-purple-500/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-users text-purple-400 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        @can(\App\Enums\PermissionEnum::SEARCH_ACTIVITIES->value)
            <!-- Activities Table -->
            <div class="admin-card rounded-xl overflow-hidden fade-in-right mb-3">
                <!-- Filter Section -->
                <div class="p-6 border-b border-white/10">
                    <form action="{{ route('admin.activities.index') }}" method="GET">
                        <div class="flex flex-col sm:flex-row flex-wrap gap-4">
                            <!-- Search -->
                            <input type="text" name="search" placeholder="Search activities..."
                                value="{{ request('search') }}"
                                class="flex-1 glass bg-white/5 text-white border-0 rounded-lg px-4 py-2 text-sm placeholder-gray-500 focus:ring-2 focus:ring-blue-500">

                            <!-- User Filter -->
                            <select name="user_id"
                                class="glass bg-white/5 text-white border-0 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                                <option value="">All Users</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>

                            <!-- Date From -->
                            <input type="date" name="from" value="{{ request('from') }}"
                                class="glass bg-white/5 text-white border-0 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500">

                            <!-- Date To -->
                            <input type="date" name="to" value="{{ request('to') }}"
                                class="glass bg-white/5 text-white border-0 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500">

                            <!-- Filter Button -->
                            <button type="submit"
                                class="btn-primary px-4 py-2 rounded-lg text-white font-medium hover:shadow-xl transition-all duration-300">
                                <i class="fas fa-filter mr-2"></i>
                                Filter
                            </button>

                            <!-- Clear Filters -->
                            @if (request()->has('search') || request()->has('user_id') || request()->has('from') || request()->has('to'))
                                <a href="{{ route('admin.activities.index') }}"
                                    class="btn-secondary px-4 py-2 rounded-lg text-white font-medium hover:shadow-xl transition-all duration-300">
                                    <i class="fas fa-times mr-2"></i>
                                    Clear
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        @endcan

        <!-- Table -->
        <div class="relative overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-800/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                            User
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                            Action
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                            Subject
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                            Description
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                            Date & Time
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @if ($activities->count() > 0)
                        @foreach ($activities as $activity)
                            <tr class="table-row hover:bg-gray-800/50 transition-colors cursor-pointer"
                                onclick="openActivityDetailsModal({{ json_encode([
                                    'id' => $activity->id,
                                    'causer_name' => $activity->causer?->name ?? 'System',
                                    'causer_email' => $activity->causer?->email ?? 'system',
                                    'event' => $activity->event,
                                    'description' => $activity->description,
                                    'subject_type' => class_basename($activity->subject_type ?? 'Unknown'),
                                    'subject_id' => $activity->subject_id,
                                    'created_at' => $activity->created_at->format('M d, Y H:i:s'),
                                    'created_at_timestamp' => $activity->created_at->timestamp,
                                    'changes' => json_encode($activity->changes ?? []),
                                    'properties' => json_encode($activity->properties ?? []),
                                ]) }})">
                                <!-- User -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white text-xs font-bold">
                                            {{ substr($activity->causer?->name ?? 'S', 0, 1) }}
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-white text-sm font-medium">
                                                {{ $activity->causer?->name ?? 'System' }}
                                            </span>
                                            <span class="text-gray-500 text-xs">
                                                {{ $activity->causer?->email ?? 'system' }}
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                <!-- Action -->
                                <td class="px-6 py-4">
                                    @php
                                        $actionColors = [
                                            'created' => 'green',
                                            'updated' => 'blue',
                                            'deleted' => 'red',
                                            'viewed' => 'gray',
                                            'downloaded' => 'purple',
                                            'exported' => 'indigo',
                                        ];
                                        $color = $actionColors[$activity->event] ?? 'gray';
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-{{ $color }}-500/20 text-{{ $color }}-400">
                                        <i
                                            class="fas 
                                                @if ($activity->event === 'created') fa-plus
                                                @elseif ($activity->event === 'updated') fa-edit
                                                @elseif ($activity->event === 'deleted') fa-trash
                                                @elseif ($activity->event === 'viewed') fa-eye
                                                @elseif ($activity->event === 'downloaded') fa-download
                                                @elseif ($activity->event === 'exported') fa-share-alt
                                                @else fa-circle @endif mr-1"></i>
                                        {{ ucfirst($activity->event ?? 'Unknown') }}
                                    </span>
                                </td>

                                <!-- Subject -->
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-1">
                                        <span class="text-white text-sm">
                                            {{ class_basename($activity->subject_type ?? 'Unknown') }}
                                        </span>
                                        @if ($activity->subject)
                                            <span class="text-gray-500 text-xs">
                                                #{{ $activity->subject_id }}
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Description -->
                                <td class="px-6 py-4">
                                    <p class="text-gray-300 text-sm truncate max-w-xs"
                                        title="{{ $activity->description }}">
                                        {{ $activity->description }}
                                    </p>
                                </td>

                                <!-- Date & Time -->
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-1">
                                        <span class="text-white text-sm">
                                            {{ $activity->created_at->format('M d, Y') }}
                                        </span>
                                        <span class="text-gray-500 text-xs">
                                            {{ $activity->created_at->format('H:i:s') }}
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <i class="fas fa-inbox text-gray-600 text-3xl"></i>
                                    <p class="text-gray-400">No activities found</p>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        {{ $activities->withQueryString()->links() }}
    </div>
    </div>

    @can(\App\Enums\PermissionEnum::CLEAR_ACTIVITIES->value)
        <!-- Clear Activities Modal -->
        <div id="clearActivitiesModal" class="hidden fixed inset-0 z-50 backdrop-blur-sm items-center justify-center">
            <div
                class="modal-content bg-black/90 rounded-xl p-6 w-full max-w-md mx-4 animate-bounce-in transition-all duration-300">
                <!-- Modal Header -->
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center mr-3">
                            <i class="fas fa-trash text-xl text-white"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-white">Clear Activities</h3>
                    </div>
                    <button onclick="closeModal('clearActivitiesModal')"
                        class="text-gray-400 hover:text-white transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <!-- Modal Body -->
                <form id="clearActivitiesForm" action="{{ route('admin.activities.clear') }}" method="POST"
                    class="space-y-4">
                    @csrf

                    <!-- Info Alert -->
                    <div class="bg-red-500/20 border border-red-500/30 rounded-lg p-4 mb-4">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-exclamation-triangle text-red-400 text-lg mt-0.5"></i>
                            <div>
                                <p class="text-sm text-white font-medium">Warning</p>
                                <p class="text-xs text-red-200 mt-1">
                                    This action cannot be undone. Activities matching the selected filters will be permanently
                                    deleted.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- From Date -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">From Date <span
                                class="text-gray-500">(Optional)</span></label>
                        <input type="date" name="from_date"
                            class="w-full glass bg-white/5 text-white border border-white/10 rounded-lg px-4 py-2 text-sm placeholder-gray-500 focus:ring-2 focus:ring-red-500 focus:border-transparent focus:outline-none"
                            max="{{ today()->toDateString() }}">
                        @error('from_date')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- To Date -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">To Date <span
                                class="text-gray-500">(Optional)</span></label>
                        <input type="date" name="to_date"
                            class="w-full glass bg-white/5 text-white border border-white/10 rounded-lg px-4 py-2 text-sm placeholder-gray-500 focus:ring-2 focus:ring-red-500 focus:border-transparent focus:outline-none"
                            max="{{ today()->toDateString() }}">
                        @error('to_date')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- User Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">User <span
                                class="text-gray-500">(Optional)</span></label>
                        <select name="user_id"
                            class="w-full glass bg-white/5 text-white border border-white/10 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-red-500 focus:border-transparent focus:outline-none">
                            <option value="">All Users</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Required -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Confirm Password</label>
                        <input type="password" name="password" required placeholder="Enter your password"
                            class="w-full glass bg-white/5 text-white border border-white/10 rounded-lg px-4 py-2 text-sm placeholder-gray-500 focus:ring-2 focus:ring-red-500 focus:border-transparent focus:outline-none">
                        @error('password')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex gap-3 pt-4 border-t border-white/10">
                        <button type="button" onclick="closeModal('clearActivitiesModal')"
                            class="flex-1 px-4 py-2 bg-gray-800 text-white rounded-lg font-medium hover:bg-gray-700 transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                            class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition-colors">
                            <i class="fas fa-trash mr-2"></i>
                            Clear Activities
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endcan

    <!-- Activity Details Modal -->
    <div id="activityDetailsModal" class="hidden fixed inset-0 z-50 backdrop-blur-sm items-center justify-center">
        <div
            class="modal-content bg-black/90 rounded-xl p-6 w-full max-w-2xl mx-4 animate-bounce-in transition-all duration-300">
            <!-- Modal Header -->
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mr-3">
                        <i class="fas fa-info text-xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white">Activity Details</h3>
                </div>
                <button onclick="closeModal('activityDetailsModal')"
                    class="text-gray-400 hover:text-white transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="space-y-6 max-h-[calc(100vh-200px)] overflow-y-auto">
                <!-- Activity ID & Event -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Activity ID -->
                    <div class="bg-gray-800/50 rounded-lg p-4 border border-white/5">
                        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
                            Activity ID
                        </label>
                        <p id="detailsId" class="text-white font-mono text-sm break-all">-</p>
                    </div>

                    <!-- Event Type -->
                    <div class="bg-gray-800/50 rounded-lg p-4 border border-white/5">
                        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
                            Event Type
                        </label>
                        <div id="detailsEvent"
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-500/20 text-blue-400">
                            -
                        </div>
                    </div>
                </div>

                <!-- User Information -->
                <div class="bg-gradient-to-r from-blue-500/10 to-purple-500/10 rounded-lg p-4 border border-blue-500/20">
                    <h4 class="text-white font-semibold mb-4 flex items-center gap-2">
                        <i class="fas fa-user text-blue-400"></i>
                        User Information
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Name</label>
                            <p id="detailsCauserName" class="text-white mt-1">-</p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Email</label>
                            <p id="detailsCauserEmail" class="text-white mt-1 break-all">-</p>
                        </div>
                    </div>
                </div>

                <!-- Subject Information -->
                <div
                    class="bg-gradient-to-r from-green-500/10 to-emerald-500/10 rounded-lg p-4 border border-green-500/20">
                    <h4 class="text-white font-semibold mb-4 flex items-center gap-2">
                        <i class="fas fa-cube text-green-400"></i>
                        Subject Information
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Subject
                                Type</label>
                            <p id="detailsSubjectType" class="text-white mt-1">-</p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Subject ID</label>
                            <p id="detailsSubjectId" class="text-white mt-1">-</p>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="bg-gray-800/50 rounded-lg p-4 border border-white/5">
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
                        Description
                    </label>
                    <p id="detailsDescription" class="text-gray-300 text-sm leading-relaxed whitespace-pre-wrap">-</p>
                </div>

                <!-- Timestamp -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Date & Time -->
                    <div class="bg-gray-800/50 rounded-lg p-4 border border-white/5">
                        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
                            Created At
                        </label>
                        <div id="detailsCreatedAt" class="text-white">
                            <p class="font-medium">-</p>
                        </div>
                    </div>

                    <!-- Relative Time -->
                    <div class="bg-gray-800/50 rounded-lg p-4 border border-white/5">
                        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
                            Time Ago
                        </label>
                        <p id="detailsRelativeTime" class="text-gray-300">-</p>
                    </div>
                </div>

                <!-- Changes (if any) -->
                <div id="changesSection" class="hidden bg-orange-500/10 rounded-lg p-4 border border-orange-500/20">
                    <h4 class="text-white font-semibold mb-4 flex items-center gap-2">
                        <i class="fas fa-code-branch text-orange-400"></i>
                        Changes
                    </h4>
                    <div id="detailsChanges" class="space-y-3">
                        <!-- Changes will be inserted here -->
                    </div>
                </div>

                <!-- Properties (if any) -->
                <div id="propertiesSection" class="hidden bg-indigo-500/10 rounded-lg p-4 border border-indigo-500/20">
                    <h4 class="text-white font-semibold mb-4 flex items-center gap-2">
                        <i class="fas fa-sliders-h text-indigo-400"></i>
                        Properties
                    </h4>
                    <div id="detailsProperties" class="space-y-3">
                        <!-- Properties will be inserted here -->
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="p-6 border-t border-white/10 flex gap-3">
                <button type="button" onclick="closeModal('activityDetailsModal')"
                    class="flex-1 px-4 py-2 bg-gray-800 text-white rounded-lg font-medium hover:bg-gray-700 transition-colors">
                    <i class="fas fa-times mr-2"></i>
                    Close
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Open activity details modal with data
        function openActivityDetailsModal(data) {
            // Set basic information
            document.getElementById('detailsId').textContent = data.id;
            document.getElementById('detailsCauserName').textContent = data.causer_name;
            document.getElementById('detailsCauserEmail').textContent = data.causer_email;
            document.getElementById('detailsSubjectType').textContent = data.subject_type;
            document.getElementById('detailsSubjectId').textContent = data.subject_id || 'N/A';
            document.getElementById('detailsDescription').textContent = data.description;
            document.getElementById('detailsCreatedAt').innerHTML = `<p class="font-medium">${data.created_at}</p>`;

            // Set event type badge
            const eventElement = document.getElementById('detailsEvent');
            const eventColors = {
                'created': 'green',
                'updated': 'blue',
                'deleted': 'red',
                'viewed': 'gray',
                'downloaded': 'purple',
                'exported': 'indigo',
            };
            const eventColor = eventColors[data.event] || 'gray';
            eventElement.className =
                `inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-${eventColor}-500/20 text-${eventColor}-400`;

            const eventIcons = {
                'created': 'fa-plus',
                'updated': 'fa-edit',
                'deleted': 'fa-trash',
                'viewed': 'fa-eye',
                'downloaded': 'fa-download',
                'exported': 'fa-share-alt',
            };
            const eventIcon = eventIcons[data.event] || 'fa-circle';
            eventElement.innerHTML =
                `<i class="fas ${eventIcon} mr-1"></i>${data.event.charAt(0).toUpperCase() + data.event.slice(1)}`;

            // Calculate and set relative time
            const timestamp = data.created_at_timestamp * 1000;
            const now = new Date();
            const diff = now - new Date(timestamp);
            const seconds = Math.floor(diff / 1000);
            const minutes = Math.floor(seconds / 60);
            const hours = Math.floor(minutes / 60);
            const days = Math.floor(hours / 24);

            let relativeTime = '';
            if (seconds < 60) {
                relativeTime = 'Just now';
            } else if (minutes < 60) {
                relativeTime = `${minutes} minute${minutes !== 1 ? 's' : ''} ago`;
            } else if (hours < 24) {
                relativeTime = `${hours} hour${hours !== 1 ? 's' : ''} ago`;
            } else if (days < 30) {
                relativeTime = `${days} day${days !== 1 ? 's' : ''} ago`;
            } else {
                relativeTime = 'More than a month ago';
            }
            document.getElementById('detailsRelativeTime').textContent = relativeTime;

            // Handle changes
            try {
                const changes = JSON.parse(data.changes);
                if (Object.keys(changes).length > 0) {
                    document.getElementById('changesSection').classList.remove('hidden');
                    const changesHtml = Object.entries(changes).map(([key, value]) => {
                        if (typeof value === 'object' && value !== null && 'from' in value && 'to' in value) {
                            return `
                                <div class="bg-gray-800/50 rounded p-3 border border-orange-500/10">
                                    <p class="text-orange-400 font-semibold text-sm">${key}</p>
                                    <div class="mt-2 space-y-1 text-xs">
                                        <div><span class="text-red-400">From:</span> <span class="text-gray-300">${value.from || 'null'}</span></div>
                                        <div><span class="text-green-400">To:</span> <span class="text-gray-300">${value.to || 'null'}</span></div>
                                    </div>
                                </div>
                            `;
                        }
                        return '';
                    }).join('');
                    document.getElementById('detailsChanges').innerHTML = changesHtml;
                }
            } catch (e) {
                console.error('Error parsing changes:', e);
            }

            // Handle properties
            try {
                const properties = JSON.parse(data.properties);
                if (Object.keys(properties).length > 0) {
                    document.getElementById('propertiesSection').classList.remove('hidden');
                    const propertiesHtml = Object.entries(properties).map(([key, value]) => {
                        const valueStr = typeof value === 'object' ? JSON.stringify(value) : String(value);
                        return `
                            <div class="bg-gray-800/50 rounded p-3 border border-indigo-500/10">
                                <p class="text-indigo-400 font-semibold text-sm">${key}</p>
                                <p class="text-gray-300 text-xs mt-1 break-all">${Array.isArray(value) ? JSON.stringify(value, null, 2) : valueStr}</p>
                            </div>
                        `;
                    }).join('');
                    document.getElementById('detailsProperties').innerHTML = propertiesHtml;
                }
            } catch (e) {
                console.error('Error parsing properties:', e);
            }

            // Open modal
            openModal('activityDetailsModal');
        }

        // Validate date range on form submit
        document.getElementById('clearActivitiesForm').addEventListener('submit', function(e) {
            const fromDate = document.querySelector('input[name="from_date"]').value;
            const toDate = document.querySelector('input[name="to_date"]').value;

            if (fromDate && toDate && new Date(fromDate) > new Date(toDate)) {
                e.preventDefault();
                showToast('error', 'From Date must be before or equal to To Date');
            }
        });
    </script>
@endpush
