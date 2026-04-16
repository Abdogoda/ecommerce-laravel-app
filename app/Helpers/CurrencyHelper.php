<?php

namespace App\Helpers;

use App\Settings\GeneralSettings;

class CurrencyHelper
{
    /**
     * Format a price with the store's currency settings
     *
     * @param float|int $price
     * @param bool $includeTax
     * @return string
     */
    public static function formatPrice($price, $includeTax = false): string
    {
        try {
            $general = app(GeneralSettings::class);
            
            // Calculate tax if needed
            if ($includeTax && !($general->tax_included ?? false)) {
                $price = $price * (1 + ($general->tax_rate ?? 0));
            }
            
            $symbol = $general->currency_symbol ?? '$';
            $position = $general->currency_position ?? 'before';
            
            // Format the price with 2 decimal places
            $formattedPrice = number_format($price, 2, '.', ',');
            
            // Position the symbol
            if ($position === 'before') {
                return "{$symbol}{$formattedPrice}";
            } else {
                return "{$formattedPrice}{$symbol}";
            }
        } catch (\Exception $e) {
            // Fallback to default formatting
            return '$' . number_format($price, 2);
        }
    }

    /**
     * Get the currency code from settings
     *
     * @return string
     */
    public static function getCurrencyCode(): string
    {
        try {
            $general = app(GeneralSettings::class);
            return $general->currency ?? 'USD';
        } catch (\Exception $e) {
            return 'USD';
        }
    }

    /**
     * Get the currency symbol from settings
     *
     * @return string
     */
    public static function getCurrencySymbol(): string
    {
        try {
            $general = app(GeneralSettings::class);
            return $general->currency_symbol ?? '$';
        } catch (\Exception $e) {
            return '$';
        }
    }

    /**
     * Get tax rate from settings
     *
     * @return float
     */
    public static function getTaxRate(): float
    {
        try {
            $general = app(GeneralSettings::class);
            return $general->tax_rate ?? 0;
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Check if tax is included in prices
     *
     * @return bool
     */
    public static function isTaxIncluded(): bool
    {
        try {
            $general = app(GeneralSettings::class);
            return $general->tax_included ?? false;
        } catch (\Exception $e) {
            return false;
        }
    }
}
