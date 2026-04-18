<?php

namespace App\Http\Controllers;

use App\Models\Order;

class ProfileController extends Controller
{
    public function show()
    {
        $orders = Order::where('user_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();

        return view('pages.user.profile', compact('orders'));
    }
}
