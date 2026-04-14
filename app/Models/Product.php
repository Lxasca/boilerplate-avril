<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductVariant;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'price', 'stock', 'is_active', 'tax_rate'
    ];


    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function productVariants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}
