<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Exports\OrderExport;
use App\Services\ExportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Settings\NotificationSettings;
use App\Notifications\OrderStatusChangedNotification;

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
            'status' => 'required|string|in:processing,shipped,delivered,cancelled'
        ]);

        // If the status is the same, no need to update
        if ($order->status === $validated['status']) {
            return redirect()->route('admin.orders.show', $order)->with('info', 'Order status is already ' . ucfirst($validated['status']) . '.');
        }

        // Prevent status changes if order is already cancelled
        if ($order->status == 'cancelled') {
            return redirect()->route('admin.orders.show', $order)->with('warning', 'Cannot change status of a cancelled order.');
        }

        // Prevent status changes if order is delivered (except to cancelled)
        if ($order->status == 'delivered' && $validated['status'] != 'cancelled') {
            return redirect()->route('admin.orders.show', $order)->with('warning', 'Cannot change status of a delivered order.');
        }

        DB::beginTransaction();
        try {
            // Handle stock decrease: only when moving from pending to a processing state for the first time
            if(in_array($validated['status'], ['processing', 'shipped', 'delivered']) && $order->status === 'pending') {
                foreach ($order->items as $item) {
                    if ($item->product->stock < $item->quantity) {
                        DB::rollBack();
                        return redirect()->route('admin.orders.show', $order)->with('error', 'Not enough stock for product: ' . $item->product_name);
                    }
                    $product = $item->product;
                    $product->decrement('stock', $item->quantity);
                }
            }

            // Handle stock increase: only when cancelling an order that was already processing
            if($validated['status'] === 'cancelled' && in_array($order->status, ['processing', 'shipped', 'delivered'])) {
                foreach ($order->items as $item) {
                    $product = $item->product;
                    $product->increment('stock', $item->quantity);
                }
            }

            // If skipping steps, create entries for intermediate statuses (except cancelled)
            $statusSequence = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
            $currentStatusIndex = array_search($order->status, $statusSequence);
            $newStatusIndex = array_search($validated['status'], $statusSequence);
            
            if ($newStatusIndex > $currentStatusIndex + 1 && $validated['status'] !== 'cancelled') {
                for ($i = $currentStatusIndex + 1; $i < $newStatusIndex; $i++) {
                    $skippedStatus = $statusSequence[$i];
                    
                    $order->statuses()->create([
                        'name' => $skippedStatus,
                        'description' => "Status auto-progressed (skipped from " . ucfirst($order->status) . ")"
                    ]);
                    
                    if ($skippedStatus === 'shipped') {
                        $order->shipped_at = now();
                    } elseif ($skippedStatus === 'delivered') {
                        $order->delivered_at = now();
                    }
                }
            }
            
            // Log the final status change in order statuses table (before updating order status)
            $order->statuses()->create([
                'name' => $validated['status'],
                'description' => "Status changed to " . ucfirst($validated['status'])
            ]);

            // Set shipped_at and delivered_at timestamps if applicable
            if ($validated['status'] === 'shipped' && !$order->shipped_at) {
                $order->shipped_at = now();
            }

            if ($validated['status'] === 'delivered' && !$order->delivered_at) {
                $order->delivered_at = now();
            }


            // Update order status
            $order->update(['status' => $validated['status']]);

            // Send notification to user about status change
            $notifyCustomer = app(NotificationSettings::class)->notify_customer_order_status_changed;
            if($notifyCustomer) {
                $order->user->notify(new OrderStatusChangedNotification($order));
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.orders.show', $order)->with('error', 'Failed to update order status: ' . $e->getMessage());
        }

        return redirect()->route('admin.orders.show', $order)->with('success', 'Order status updated successfully.');
    }

    public function destroy(Order $order)
    {
        $order->items()->delete();
        $order->statuses()->delete();
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully.');
    }

    public function exportFiltered()
    {
        $query = Order::with('user');
        return ExportService::exportFiltered($query, OrderExport::class);
    }

    public function exportAll()
    {
        return ExportService::exportAll(Order::class, OrderExport::class);
    }
}