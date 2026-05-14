<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Models\Concerns\HasActivity;
use Spatie\Activitylog\Support\LogOptions;

#[Fillable([
    'order_number', 'user_id', 'status', 
    'subtotal', 'tax', 'shipping_cost', 'total', 
    'first_name', 'last_name', 'email', 'phone', 
    'street_address', 'city', 'state', 'country', 'zip_code', 
    'notes', 'shipped_at'
])]
class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory, HasActivity;

    public function casts()
    {
        return [
            'subtotal' => 'decimal:2',
            'tax' => 'decimal:2',
            'shipping_cost' => 'decimal:2',
            'total' => 'decimal:2',
            'shipped_at' => 'datetime',
        ];
    }

    public function getRouteKeyName()
    {
        return 'order_number';
    }

    // ___ Activity Log ────────────────────────────────────────────────────────
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['order_number', 'user_id', 'status', 'total'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(function(string $eventName){
                return "Order has been {$eventName}";
            });
    }

    // ─── Relationships ────────────────────────────────────────────────────────
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function statuses(): HasMany
    {
        return $this->hasMany(OrderStatus::class);
    }

    // ─── Helper Methods ───────────────────────────────────────────────────────
    public function getStatusBadgeClass(): string
    {
        return match($this->status) {
            'pending' => 'bg-yellow-500/20 text-yellow-400 border-yellow-500/30',
            'processing' => 'bg-blue-500/20 text-blue-400 border-blue-500/30',
            'shipped' => 'bg-purple-500/20 text-purple-400 border-purple-500/30',
            'delivered' => 'bg-green-500/20 text-green-400 border-green-500/30',
            'cancelled' => 'bg-red-500/20 text-red-400 border-red-500/30',
            default => 'bg-gray-500/20 text-gray-400 border-gray-500/30',
        };
    }

    public function getStatusIcon(): string
    {
        return match($this->status) {
            'pending' => 'fa-clock',
            'processing' => 'fa-cog',
            'shipped' => 'fa-truck',
            'delivered' => 'fa-check-circle',
            'cancelled' => 'fa-times-circle',
            default => 'fa-info-circle',
        };
    }

    public function getStatusLabel(): string
    {
        return ucfirst($this->status);
    }
}