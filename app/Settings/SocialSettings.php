<?php 

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class SocialSettings extends Settings
{
    public ?string $facebook;
    public ?string $twitter;
    public ?string $instagram;
    public ?string $tiktok;
    public ?string $youtube;
    public ?string $whatsapp;

    public static function group(): string { return 'social'; }
}