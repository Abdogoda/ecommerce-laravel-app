<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class OrderController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $orders = Order::where('user_id', auth()->id())->withCount('items')->latest()->get();

        return view('pages.user.orders', compact('orders'));
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);
        
        $order->load('items', 'statuses');

        return view('pages.user.order', compact('order'));
    }
}