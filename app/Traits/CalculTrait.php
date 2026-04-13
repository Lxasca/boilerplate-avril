<?php

namespace App\Traits;

trait CalculTrait
{
    private function calculTotal($cart)
    {
        $totalHT = 0;
        $totalTTC = 0;
        foreach ($cart->items as $item) {
            $totalHT += $item->product->price * $item->quantity;
            $totalTTC += $item->product->price * $item->quantity * (1 + $item->product->tax_rate / 100);
        }
        return ['totalHT' => $totalHT, 'totalTTC' => $totalTTC];
    }
}