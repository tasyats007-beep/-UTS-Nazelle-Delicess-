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
        'sku',
        'name',
        'description',
        'image_url',
        'purchase_price',
        'selling_price',
        'stock',
        'minimum_stock',
    ];

    protected $appends = [
        'aesthetic_image',
    ];

    public function getAestheticImageAttribute(): string
    {
        if (!empty($this->image_url)) {
            return $this->image_url;
        }

        $lower = strtolower($this->name);
        if (str_contains($lower, 'croissant') || str_contains($lower, 'viennoiserie')) {
            return 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?auto=format&fit=crop&w=600&q=80';
        }
        if (str_contains($lower, 'chocolat')) {
            return 'https://images.unsplash.com/photo-1608198093002-ad4e005484ec?auto=format&fit=crop&w=600&q=80';
        }
        if (str_contains($lower, 'cinnamon') || str_contains($lower, 'swirl')) {
            return 'https://images.unsplash.com/photo-1509365465985-25d11c17e812?auto=format&fit=crop&w=600&q=80';
        }
        if (str_contains($lower, 'sourdough') || str_contains($lower, 'boule')) {
            return 'https://images.unsplash.com/photo-1586444248902-2f64eddc13df?auto=format&fit=crop&w=600&q=80';
        }
        if (str_contains($lower, 'baguette')) {
            return 'https://images.unsplash.com/photo-1589367920969-ab8e050bbb04?auto=format&fit=crop&w=600&q=80';
        }
        if (str_contains($lower, 'tart') || str_contains($lower, 'berry') || str_contains($lower, 'strawberry')) {
            return 'https://images.unsplash.com/photo-1519869325930-281384150729?auto=format&fit=crop&w=600&q=80';
        }
        if (str_contains($lower, 'eclair') || str_contains($lower, 'mille-feuille')) {
            return 'https://images.unsplash.com/photo-1587314168485-3236d6710814?auto=format&fit=crop&w=600&q=80';
        }
        if (str_contains($lower, 'cake') || str_contains($lower, 'cheesecake') || str_contains($lower, 'opera')) {
            return 'https://images.unsplash.com/photo-1533134242443-d4fd215305ad?auto=format&fit=crop&w=600&q=80';
        }
        if (str_contains($lower, 'quiche') || str_contains($lower, 'savory') || str_contains($lower, 'beef')) {
            return 'https://images.unsplash.com/photo-1621996346565-e3d5d6281292?auto=format&fit=crop&w=600&q=80';
        }
        if (str_contains($lower, 'latte') || str_contains($lower, 'coffee') || str_contains($lower, 'matcha') || str_contains($lower, 'tea')) {
            return 'https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?auto=format&fit=crop&w=600&q=80';
        }

        return 'https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&w=600&q=80';
    }

    protected $casts = [
        'purchase_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'stock' => 'integer',
        'minimum_stock' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function purchaseItems(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function saleItems(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    public function isLowStock(): bool
    {
        return $this->stock <= $this->minimum_stock;
    }

    public function scopeLowStock($query)
    {
        return $query->whereColumn('stock', '<=', 'minimum_stock');
    }
}
