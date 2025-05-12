<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage; 

class Categories extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image', 
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // Tidak ada cast khusus yang diperlukan untuk field di atas
        // kecuali punya field boolean atau date lain.
    ];

    /**
     * Get all of the products for the Category.
     * Mendefinisikan relasi one-to-many: Satu kategori memiliki banyak produk.
     */
    public function products()
    {

        return $this->hasMany(Product::class, 'category_id');
    }

    /**
     * Accessor untuk mendapatkan URL gambar lengkap.
     * Akan dipanggil di Blade dengan: $category->image_url
     *
     * @return string|null
     */
    public function getImageUrlAttribute(): ?string
    {
        if ($this->image && Storage::disk('public')->exists($this->image)) {
            return Storage::disk('public')->url($this->image);
        }
        return null;
    }
}