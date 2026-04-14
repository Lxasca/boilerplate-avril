<?php

namespace App\Http\Controllers\Ecom;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PromoCode;
use App\Traits\CalculTrait;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use CalculTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cart = Cart::with('items.product')->findOrFail($request->cart_id);
        $totals =  $this->calculTotal($cart);

        if ($cart->promo_code_id) {
            $promoCode = PromoCode::where([
                ['id', $cart->promo_code_id],
                ['is_active', true],
                ['expires_at', '>', now()]
            ])->first();

            if ($promoCode) {
                $totals = $this->applyPromoCode($totals, $promoCode);
            }
        }

        $order = Order::create([
            'total_ht' => $totals['totalHT'],
            'total_ttc' => $totals['totalTTC'],
            'promo_code_id' => $cart->promo_code_id,
            'status' => 'pending',
        ]);

        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
            $item->product->decrement('stock', $item->quantity);
        }

        $cart->delete();

        return response()->json($order);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
