@extends('layouts.admin-app')

@section('content')
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="flex gap-0 items-start flex-col sm:flex-row sm:gap-5 sm:items-center mb-2">
                    <h1 class="text-3xl font-bold text-white mb-2">
                        Settings
                    </h1>
                    <div class="flex items-center space-x-4">
                        <div id="breadcrumb" class="text-sm text-gray-400">
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:underline">Admin</a>
                            <i class="fas fa-chevron-right mx-2"></i>
                            <span class="text-white">Settings</span>
                        </div>
                    </div>
                </div>
                <p class="text-gray-400">
                    Manage your store's general, order, social, and notification settings
                </p>
            </div>
        </div>
    </div>

    <!-- Settings Card -->
    <div class="admin-card rounded-2xl animate-slide-in">
        <!-- Tab Navigation -->
        <div class="border-b border-white/10 px-8 pt-6">
            <nav class="flex space-x-8 overflow-x-auto">
                <button onclick="switchTab('generalTab')" id="generalTabBtn"
                    class="tab-button active py-3 px-1 text-blue-400 font-medium whitespace-nowrap">
                    <i class="fas fa-cogs mr-2"></i>General
                </button>
                <button onclick="switchTab('orderTab')" id="orderTabBtn"
                    class="tab-button py-3 px-1 text-gray-400 font-medium hover:text-white transition-colors whitespace-nowrap">
                    <i class="fas fa-shopping-cart mr-2"></i>Order
                </button>
                <button onclick="switchTab('socialTab')" id="socialTabBtn"
                    class="tab-button py-3 px-1 text-gray-400 font-medium hover:text-white transition-colors whitespace-nowrap">
                    <i class="fas fa-share-alt mr-2"></i>Social
                </button>
                <button onclick="switchTab('notificationTab')" id="notificationTabBtn"
                    class="tab-button py-3 px-1 text-gray-400 font-medium hover:text-white transition-colors whitespace-nowrap">
                    <i class="fas fa-bell mr-2"></i>Notifications
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="p-8">
            @include('pages.admin.settings.tabs.general', compact('general'))
            @include('pages.admin.settings.tabs.order', compact('order'))
            @include('pages.admin.settings.tabs.social', compact('social'))
            @include('pages.admin.settings.tabs.notification', compact('notification'))
        </div>
    </div>
@endsection
