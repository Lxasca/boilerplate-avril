<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem;
use App\Models\PromoCode;
use App\Models\User;

class Order extends Model
{
    protected $fillable = ['user_id', 'promo_code_id', 'status', 'total_ht', 'total_ttc'];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function promoCode()
    {
        return $this->belongsTo(PromoCode::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
