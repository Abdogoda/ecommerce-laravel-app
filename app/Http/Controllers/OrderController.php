<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())->latest()->get();

        return view('pages.user.orders', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items');

        return view('pages.user.order', compact('order'));
    }
}