<?php

namespace App\Traits;

trait CalculTrait
{
    private function calculTotal($cart)
    {
        $totalHT = 0;
        $totalTTC = 0;
        foreach ($cart->items as $item) {
            $product = $item->productVariant !== null ? $item->productVariant->product : $item->product;
            $price = $item->productVariant !== null ? $item->productVariant->price : $item->product->price;
            
            $totalHT += $price * $item->quantity;
            $totalTTC += $price * $item->quantity * (1 + $product->tax_rate / 100);
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

        // garde-fou pour que le prix ne passe jamais en-deça de 0e si le panier < discount        
        $totals['totalHT'] = max(0, $totals['totalHT']);
        $totals['totalTTC'] = max(0, $totals['totalTTC']);

        return $totals;
    }
}