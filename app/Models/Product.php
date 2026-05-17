<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'image',
        'base_price',
        'is_active',
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function activeVariants(): HasMany
    {
        return $this->hasMany(ProductVariant::class)->where('stock_status', true);
    }

    public function getStartingPriceAttribute(): ?float
    {
        $minVariantPrice = $this->activeVariants->min('price');
        return $minVariantPrice !== null ? (float) $minVariantPrice : ($this->base_price ? (float) $this->base_price : null);
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image && (filter_var($this->image, FILTER_VALIDATE_URL) || str_starts_with($this->image, 'http'))) {
            return $this->image;
        }

        return $this->image ? asset('storage/' . $this->image) : 'https://placehold.co/600x400?text=' . urlencode($this->name);
    }

    public function finishings(): HasMany
    {
        return $this->hasMany(ProductFinishing::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}