<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'category',
        'description',
        'Image',// Add 'Image' to
        'sell_price',
        'cost_price'

    ];

    /**
     * Get the images for the product.
     */
    public function images(): HasMany
    {
        return $this->hasMany(Product::class, 'product_id', 'id');
    }
}
