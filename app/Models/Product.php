<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Product extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'title', 'slug', 'quantity' ,'description', 'published', 'inStock', 'price', 'created_by', 'updated_by', 'deleted_by'
    ];

    /**
     * Get the options for generating the slug.
     * (this code from Spatie\Sluggable)
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function product_images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    // filter logic for price, categories, brands
    public function scopeFiltered(Builder $query): void
    {
        $query
            ->when(request('brands'), function (Builder $q) {
                $q->whereIn('brand_id', request('brands'));
            })
            ->when(request('categories'), function (Builder $q) {
                $q->whereIn('category_id', request('categories'));
            })
            ->when(request('prices'), function (Builder $q) {
                $q->whereBetween('price', [
                    request('prices.from',0),
                    request('prices.to', 100000)
                ]);
            });
    }
}
