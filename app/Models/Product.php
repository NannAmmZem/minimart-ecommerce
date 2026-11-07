<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'unit',
        'stock_quantity',
        'low_stock_alert',
        'image',
        'is_featured',
        'in_stock',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_featured' => 'boolean',
        'in_stock' => 'boolean',
    ];

    // Automatically generate slug from name
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });

        static::updating(function ($product) {
            // Auto update in_stock status based on quantity
            if ($product->stock_quantity <= 0) {
                $product->in_stock = false;
            }
        });
    }

    // Relationship with category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relationship with order items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Check if product is low on stock
    public function isLowStock()
    {
        return $this->stock_quantity <= $this->low_stock_alert && $this->stock_quantity > 0;
    }

    // Get formatted price with unit
    public function getFormattedPriceAttribute()
    {
        return '$' . number_format($this->price, 2) . ' / ' . $this->unit;
    }

    // Scope for featured products
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->where('in_stock', true);
    }

    // Scope for in stock products
    public function scopeInStock($query)
    {
        return $query->where('in_stock', true)->where('stock_quantity', '>', 0);
    }
}
