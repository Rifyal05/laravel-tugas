<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Binafy\LaravelCart\Cartable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Product extends Model implements Cartable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'sku',
        'price',
        'stock',
        'category_id', 
        'image',    
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2', 
        'is_active' => 'boolean',
        'stock' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getImageUrlAttribute(): ?string 
    {
        if ($this->image) {
            return Storage::disk('public')->url($this->image);
        }
        // return asset('images/placeholder-product.png');
        return null;
    }
}
