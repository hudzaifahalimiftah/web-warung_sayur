<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'product_name',
        'description',
        'price',
        'unit',
        'stock',
        'image',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getImageUrlAttribute(): string
    {
        if (!$this->image) {
            return 'https://images.unsplash.com/photo-1540420773420-3366772f4999?w=400&q=80';
        }

        // URL eksternal (Unsplash, dll)
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }

        // File lokal di storage
        if (file_exists(public_path('storage/' . $this->image))) {
            return asset('storage/' . $this->image);
        }

        return 'https://images.unsplash.com/photo-1540420773420-3366772f4999?w=400&q=80';
    }
}
