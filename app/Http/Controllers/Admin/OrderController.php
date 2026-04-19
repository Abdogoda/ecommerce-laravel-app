<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')
            ->latest()
            ->paginate(15);

        $stats = [
            'total' => Order::count(),
            'revenue' => Order::sum('total'),
            'pending' => Order::where('status', 'pending')->count(),
            'shipped' => Order::where('status', 'shipped')->count(),
        ];

        return view('pages.admin.orders.index', compact('orders', 'stats'));
    }
    
    public function show(Order $order)
    {
        $order->load('user', 'items', 'statuses');
        return view('pages.admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:pending,processing,shipped,delivered,cancelled'
        ]);

        if ($order->status === $validated['status']) {
            return redirect()->route('admin.orders.show', $order)->with('info', 'Order status is already ' . ucfirst($validated['status']) . '.');
        }

        if ($validated['status'] === 'shipped' && !$order->shipped_at) {
            $order->shipped_at = now();
        }

        if (in_array($order->status, ['cancelled', 'delivered'])) {
            return redirect()->route('admin.orders.show', $order)->with('warning', 'Cannot change status of an order that is already ' . ucfirst($order->status) . '.');
        }

        $order->update(['status' => $validated['status']]);
        
        $order->statuses()->create([
            'name' => $validated['status'],
            'description' => "Status changed to " . ucfirst($validated['status'])
        ]);

        return redirect()->route('admin.orders.show', $order)->with('success', 'Order status updated successfully.');
    }

    public function destroy(Order $order)
    {
        // Delete related order items first
        $order->items()->delete();
        // Delete related statuses
        $order->statuses()->delete();
        // Delete the order
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully.');
    }
}