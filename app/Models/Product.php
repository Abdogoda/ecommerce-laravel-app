<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Tags\HasTags;

#[Fillable(['name', 'description', 'slug', 'price', 'stock', 'category_id', 'is_active', 'is_featured'])]
class Product extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory, HasSlug, InteractsWithMedia, HasTags;

    const MEDIA_FOLDER = 'products';

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function casts()
    {
        return [
            'price' => 'decimal:2',
            'is_active' => 'boolean',
            'is_featured' => 'boolean'
        ];
    }

    // ─── Relationships ────────────────────────────────────────────────────────
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // ─── Media ───────────────────────────────────────────────
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('gallery')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    public function getProductImageUrls(): array
    {
        return $this->getMedia('gallery')
            ->map(function ($media, $index) {
                return (object) [
                    'media' => $media,
                    'is_primary' => $index === 0 // First image is primary
                ];
            })
            ->toArray();
    }

    public function getPrimaryImageUrl(): ?string
    {
        $media = $this->getFirstMedia('gallery');
        return $media ? $media->getUrl() : null;
    }

    public function moveMediaToTop(Media $media): void
    {
        if ($media->model_id !== $this->id || $media->model_type !== self::class) {
            throw new \Exception('This media does not belong to this product.');
        }

        $allMediaIds = $this->getMedia($media->collection_name)
                            ->sortBy('order_column')
                            ->pluck('id')
                            ->toArray();

        $allMediaIds = array_filter($allMediaIds, fn($id) => $id !== $media->id);

        array_unshift($allMediaIds, $media->id);

        Media::setNewOrder($allMediaIds);
    }

    
    // ─── Slug Options ────────────────────────────────────────────────────────
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
}