<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\Message;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $stats = [
            'users' => User::where('is_active', true)->count(),
            'verified_users' => User::whereNotNull('email_verified_at')->count(),
            'products' => Product::where('is_active', true)->count(),
            'categories' => Category::where('is_active', true)->count(),
            'orders' => Order::where('status', '!=', 'cancelled')->count(),
            'revenue' => Order::where('status', 'completed')->sum('total'),
            'messages' => Message::count(),
            'unread_messages' => Message::where('is_read', false)->count(),
        ];

        return view('pages.admin.dashboard', compact('stats'));
    }
}