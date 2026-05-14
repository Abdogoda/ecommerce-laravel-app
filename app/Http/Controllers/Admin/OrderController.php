<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $items_per_page = app(\App\Settings\GeneralSettings::class)->items_per_page ?? 12;

        $orders = Order::with('user')
            ->latest()
            ->paginate($items_per_page);

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

        // If the status is the same, no need to update
        if ($order->status === $validated['status']) {
            return redirect()->route('admin.orders.show', $order)->with('info', 'Order status is already ' . ucfirst($validated['status']) . '.');
        }

        // Prevent status changes if order is already cancelled or delivered
        if (in_array($order->status, ['cancelled', 'delivered'])) {
            return redirect()->route('admin.orders.show', $order)->with('warning', 'Cannot change status of an order that is already ' . ucfirst($order->status) . '.');
        }

        // Set shipped_at timestamp when order is marked as shipped
        if ($validated['status'] === 'shipped' && !$order->shipped_at) {
            $order->shipped_at = now();
        }

        // Decrease stock for each product when order moves from pending to processing
        if(in_array($validated['status'], ['processing', 'shipped', 'delivered']) && $order->status === 'pending') {
            foreach ($order->items as $item) {
                if ($item->product->stock < $item->quantity) {
                    return redirect()->route('admin.orders.show', $order)->with('error', 'Not enough stock for product: ' . $item->product_name);
                }
                $product = $item->product;
                $product->decrement('stock', $item->quantity);
            }
        }

        // Increase stock if order is cancelled after being processed
        if($validated['status'] === 'cancelled' && in_array($order->status, ['processing', 'shipped', 'delivered'])) {
            foreach ($order->items as $item) {
                $product = $item->product;
                $product->increment('stock', $item->quantity);
            }
        }

        // Update order status
        $order->update(['status' => $validated['status']]);

        // Send notification to user about status change
        $notificationSettings = app(\App\Settings\NotificationSettings::class);
        if($notificationSettings->notify_customer_order_status_changed) {
            $order->user->notify(new \App\Notifications\OrderStatusChangedNotification($order));
        }
        
        // Log status change in order statuses table
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