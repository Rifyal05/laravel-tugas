<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2', 
        'is_active' => 'boolean',
        'stock' => 'integer',
    ];

    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }

    public function getImageUrlAttribute(): ?string 
    {
        if ($this->image) {
            return Storage::disk('public')->url($this->image);
        }
        // Opsional: Kembalikan URL gambar placeholder default jika tidak ada gambar
        // return asset('images/placeholder-product.png');
        return null;
    }
}