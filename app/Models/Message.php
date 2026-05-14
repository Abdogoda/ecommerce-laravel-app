<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\HasActivity;
use Spatie\Activitylog\Support\LogOptions;

#[Fillable('user_id', 'name', 'email', 'subject', 'body', 'is_read')]
class Message extends Model
{
    /** @use HasFactory<\Database\Factories\MessageFactory> */
    use HasFactory, HasActivity;

    // ─── Relationships ────────────────────────────────────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // ─── Activity Log ────────────────────────────────────────────────────────
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email', 'subject', 'body', 'is_read'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(function(string $eventName){
                return "Message has been {$eventName}";
            });
    }
}