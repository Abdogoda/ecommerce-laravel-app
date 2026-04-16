<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class OrderSettings extends Settings
{
    public bool    $auto_confirm;          // auto-move Pending → Processing on payment
    public int     $cancel_after_minutes;  // cancel unpaid orders after N minutes
    public bool    $allow_guest_orders;
    public float   $free_shipping_above;   // 0 = never free
    public float   $default_shipping_fee;
    public int     $low_stock_threshold;   // alert when stock <= this
    public bool    $allow_out_of_stock;    // can customers order when stock = 0

    public static function group(): string { return 'order'; }
}