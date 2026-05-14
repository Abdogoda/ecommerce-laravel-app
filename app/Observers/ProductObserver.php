<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class ProductObserver
{
    public function updated(Product $product): void
    {
        Log::info("Product updated: ID {$product->id}, Name: {$product->name}, Changed Attributes: " . implode(', ', array_keys($product->getChanges())));
        if ($product->wasChanged('stock')) {
            $orderSettings = app(\App\Settings\OrderSettings::class);
            $adminEmail = app(\App\Settings\NotificationSettings::class)->admin_notification_email;
            if ($adminEmail && $product->stock <= $orderSettings->low_stock_threshold && $product->stock > 0) {
                Notification::route('mail', $adminEmail)->notify(new \App\Notifications\LowStockNotification($product));
            }
        }
    }
}