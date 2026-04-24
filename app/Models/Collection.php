<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'is_active'];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
