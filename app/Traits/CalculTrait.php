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

        private function applyPromoCode($totals, $promoCode)
    {
        $discount = $promoCode->discount;
        if ($promoCode->type === 'percent') {
            $totals['totalHT'] = $totals['totalHT'] * (1 - $discount / 100);
            $totals['totalTTC'] = $totals['totalTTC'] * (1 - $discount / 100);
        } else {
            $totals['totalHT'] = $totals['totalHT'] - $discount;
            $totals['totalTTC'] = $totals['totalTTC'] - $discount;
        }
        return $totals;
    }
}