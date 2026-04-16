<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Models\Concerns\HasActivity;
use Spatie\Activitylog\Support\LogOptions;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Tags\HasTags;
use Spatie\Translatable\HasTranslations;

#[Fillable(['name', 'description', 'slug', 'icon', 'is_active'])]
class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory, HasActivity, HasSlug, HasTags, HasTranslations;

    public array $translatable = ['name', 'description'];

    public function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // ─── Helper Methods ────────────────────────────────────────────────────────
    public function isIconImage(): bool
    {
        return is_string($this->icon) && str_starts_with($this->icon, 'categories/');
    }

    // ─── Relationships ────────────────────────────────────────────────────────
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    // ─── Activity Log ────────────────────────────────────────────────────────
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'description', 'slug', 'icon', 'is_active'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(function(string $eventName){
                return "Category has been {$eventName}";
            });
    }

    // ─── Slug Options ────────────────────────────────────────────────────────
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
}