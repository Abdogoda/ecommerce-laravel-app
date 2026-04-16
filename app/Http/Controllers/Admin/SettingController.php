<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Settings\UpdateGeneralSettingsRequest;
use App\Http\Requests\Admin\Settings\UpdateNotificationSettingsRequest;
use App\Http\Requests\Admin\Settings\UpdateOrderSettingsRequest;
use App\Http\Requests\Admin\Settings\UpdateSocialSettingsRequest;
use App\Settings\GeneralSettings;
use App\Settings\NotificationSettings;
use App\Settings\OrderSettings;
use App\Settings\SocialSettings;

class SettingController extends Controller
{
    public function index(
        GeneralSettings $general,
        NotificationSettings $notification,
        OrderSettings $order,
        SocialSettings $social
    )
    {
        return view('pages.admin.settings.index', compact('general', 'notification', 'order', 'social'));
    }

    public function updateGeneral(UpdateGeneralSettingsRequest $request, GeneralSettings $general)
    {
        $validated = $request->validated();

        foreach ($validated as $key => $value) {
            $general->$key = $value;
        }

        $general->maintenance_mode = $request->has('maintenance_mode');
        $general->tax_included = $request->has('tax_included');

        $general->save();

        return redirect()->back()->with('success', 'General settings updated successfully.');
    }

    public function updateOrder(UpdateOrderSettingsRequest $request, OrderSettings $orders)
    {
        $orders->auto_confirm         = $request->boolean('auto_confirm');
        $orders->cancel_after_minutes = $request->cancel_after_minutes;
        $orders->allow_guest_orders   = $request->boolean('allow_guest_orders');
        $orders->free_shipping_above  = $request->free_shipping_above;
        $orders->default_shipping_fee = $request->default_shipping_fee;
        $orders->low_stock_threshold  = $request->low_stock_threshold;
        $orders->allow_out_of_stock   = $request->boolean('allow_out_of_stock');
        $orders->save();

        return redirect()->back()->with('success', 'Order settings updated successfully.');
    }

    public function updateSocial(UpdateSocialSettingsRequest $request, SocialSettings $social)
    {
        $social->facebook  = $request->facebook;
        $social->instagram = $request->instagram;
        $social->twitter   = $request->twitter;
        $social->youtube   = $request->youtube;
        $social->whatsapp  = $request->whatsapp;
        $social->tiktok    = $request->tiktok;
        $social->save();

        return redirect()->back()->with('success', 'Social settings updated successfully.');
    }

    public function updateNotifications(UpdateNotificationSettingsRequest $request, NotificationSettings $notifications)
    {
        $notifications->notify_admin_new_order = $request->has('notify_admin_new_order');
        $notifications->notify_admin_new_message = $request->has('notify_admin_new_message');
        $notifications->notify_admin_low_stock = $request->has('notify_admin_low_stock');
        $notifications->notify_customer_order_confirmed = $request->has('notify_customer_order_confirmed');
        $notifications->notify_customer_order_shipped = $request->has('notify_customer_order_shipped');
        $notifications->admin_notification_email = $request->input('admin_notification_email');

        $notifications->save();

        return redirect()->back()->with('success', 'Notification settings updated successfully.');
    }
}