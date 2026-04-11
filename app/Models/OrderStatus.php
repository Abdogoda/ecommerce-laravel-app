<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable('order_id', 'name', 'description')]
class OrderStatus extends Model
{
    // ─── Relationships ────────────────────────────────────────────────────────
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}