<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string  $name;
    public string  $email;
    public string  $phone;
    public string  $address;
    public string  $currency;           // 'EGP', 'USD'
    public string  $currency_symbol;    // 'ج.م', '$'
    public string  $currency_position;  // 'before', 'after'
    public float   $tax_rate;           // 0.14 = 14%
    public bool    $tax_included;       // is tax included in price or added on top
    public bool    $maintenance_mode;
    public int     $items_per_page;
    public ?string $logo;               // media path or URL
    public ?string $favicon;

    public static function group(): string{ return 'general'; }
}