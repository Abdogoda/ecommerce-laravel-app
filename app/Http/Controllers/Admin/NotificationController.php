<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\NotificationExport;
use App\Services\ExportService;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function index()
    {
        $generalSettings = app(\App\Settings\GeneralSettings::class);
        $notifications = DatabaseNotification::latest()
            ->paginate($generalSettings->items_per_page ?? 12);

        $stats = [
            'total_notifications' => DatabaseNotification::count(),
            'unread_notifications' => DatabaseNotification::whereNull('read_at')->count(),
            'notifications_today' => DatabaseNotification::whereDate('created_at', today())->count(),
            'notifications_this_month' => DatabaseNotification::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
        ];

        return view('pages.admin.notifications.index', compact('notifications', 'stats'));
    }

    public function show(DatabaseNotification $notification)
    {
        // Mark as read if unread
        if ($notification->unread()) {
            $notification->markAsRead();
        }

        return view('pages.admin.notifications.show', compact('notification'));
    }

    public function markAllAsRead()
    {
        DatabaseNotification::whereNull('read_at')->update(['read_at' => now()]);
        
        return redirect()->route('admin.notifications.index')
            ->with('success', 'All notifications marked as read');
    }

    public function deleteMultiple()
    {
        $ids = request('ids', []);
        
        if (empty($ids)) {
            return back()->with('error', 'Please select notifications to delete');
        }

        DatabaseNotification::whereIn('id', $ids)->delete();

        return back()->with('success', count($ids) . ' notification(s) deleted');
    }

    public function destroy(DatabaseNotification $notification)
    {
        $notification->delete();
        
        return back()->with('success', 'Notification deleted');
    }

    public function exportFiltered()
    {
        $query = DatabaseNotification::latest();
        return ExportService::exportFiltered($query, NotificationExport::class);
    }

    public function exportAll()
    {
        return ExportService::exportAll(DatabaseNotification::class, NotificationExport::class);
    }
}