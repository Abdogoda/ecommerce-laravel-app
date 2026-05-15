<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Activities\ClearActivityRequest;
use App\Http\Requests\PasswordRequiredRequest;
use App\Models\User;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::with(['causer', 'subject'])->latest();

        // Statistics for cards
        $stats = [
            'total_activities' => Activity::count(),
            'today_activities' => Activity::whereDate('created_at', today())->count(),
            'this_week_activities' => Activity::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
        ];
        
        $users = User::orderBy('name')->get();

        // Get all users for the filter dropdown
        if($request->anyFilled(['search', 'user_id', 'from', 'to']) && Auth::user()->cannot(PermissionEnum::SEARCH_ACTIVITIES->value)){
            $activities = $query->get(50);
            return redirect()->route('admin.activities.index', compact('stats', 'activities', 'users'))->with('warning', 'You do not have permission to search activities. Showing latest 50 activities instead.');
        }

        // Search by description
        if ($search = $request->input('search')) {
            $query->where('description', 'like', "%{$search}%");
        }

        // Filter by causer (user)
        if ($causerId = $request->input('user_id')) {
            $query->where('causer_type', User::class)->where('causer_id', $causerId);
        }

        // Filter by date range
        if ($from = $request->input('from')) {
            $query->whereDate('created_at', '>=', $from);
        }
        if ($to = $request->input('to')) {
            $query->whereDate('created_at', '<=', $to);
        }

        $items_per_page = app(\App\Settings\GeneralSettings::class)->items_per_page ?? 12;

        $activities = $query->paginate($items_per_page)->withQueryString();
        return view('pages.admin.activities.index', compact('activities', 'users', 'stats'));
    }

    public function clear(PasswordRequiredRequest $passwordRequiredRequest, ClearActivityRequest $clearActivityRequest)
    {
        $query = Activity::query();

        // Apply filters if provided
        if ($clearActivityRequest->filled('user_id')) {
            $query->where('causer_type', User::class)->where('causer_id', $clearActivityRequest->input('user_id'));
        }
        if ($clearActivityRequest->filled('from_date')) {
            $query->whereDate('created_at', '>=', $clearActivityRequest->input('from_date'));
        }
        if ($clearActivityRequest->filled('to_date')) {
            $query->whereDate('created_at', '<=', $clearActivityRequest->input('to_date'));
        }

        $deletedCount = $query->delete();

        activity()->causedBy(auth()->user())->event('ActivitiesCleared')->log("Cleared {$deletedCount} activities with filters - User ID: ". ($clearActivityRequest->input('user_id') ?? 'None') .", From: ". ($clearActivityRequest->input('from_date') ?? 'Any') .", To: ". ($clearActivityRequest->input('to_date') ?? 'Any'));

        return redirect()->route('admin.activities.index')->with('success', "{$deletedCount} activity logs were deleted successfully.");
    }
}