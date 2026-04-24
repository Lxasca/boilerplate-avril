<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Collection extends Model
{
    protected $fillable = ['name', 'slug', 'is_active'];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
