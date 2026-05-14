<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Http\Requests\CheckoutRequest;

class CheckoutController extends Controller
{
    public function __invoke(CheckoutRequest $request)
    {
        $validated = $request->validated();

        try {
            $cartItems = json_decode($validated['cart_items'], true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return back()->withErrors(['cart_items' => 'Invalid cart data. Please refresh and try again.']);
            }
            
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => 'ORD-' . time(),
                'first_name' => explode(' ', $validated['name'])[0],
                'last_name' => count(explode(' ', $validated['name'])) > 1 ? implode(' ', array_slice(explode(' ', $validated['name']), 1)) : '',
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'street_address' => $validated['address'],
                'city' => $validated['city'],
                'state' => $validated['state'],
                'zip_code' => $validated['zip_code'],
                'country' => $validated['country'] ?? 'Egypt',
                'status' => 'pending',
                'subtotal' => 0,
                'tax' => 0,
                'shipping_cost' => 0,
                'total' => 0,
            ]);

            $subtotal = 0;

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'product_name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);

                $subtotal += $item['price'] * $item['quantity'];
            }

            $generalSettings = app(\App\Settings\GeneralSettings::class);
            $orderSettings = app(\App\Settings\OrderSettings::class);

            $tax = 0;
            if ($generalSettings->tax_included && $generalSettings->tax_rate > 0) {
                $tax = $subtotal * $generalSettings->tax_rate / 100;
            }

            $shipping = 0;
            if ($orderSettings->free_shipping_above > 0 && $subtotal >= $orderSettings->free_shipping_above) {
                $shipping = 0;
            } else {
                $shipping = $orderSettings->default_shipping_fee;
            }

            $total = $subtotal + $tax + $shipping;

            // Update order with calculated totals
            $order->update([
                'subtotal' => $subtotal,
                'tax' => $tax,
                'shipping_cost' => $shipping,
                'total' => $total,
            ]);

            $order->statuses()->create([
                'name' => 'pending',
                'description' => 'Order created and pending shipment.',
            ]);

            return redirect()->route('orders.show', $order)->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['checkout' => 'An error occurred while processing your order: ' . $e->getMessage()]);
        }
    }
}