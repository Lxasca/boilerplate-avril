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

    public function checkout(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        
        $cart = Cart::with('items.product', 'items.productVariant.product')->findOrFail($request->cart_id);
        $totals = $this->calculTotal($cart);
        
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

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'mode' => 'payment',
            'success_url' => url('/panier/paiement/succes?session_id={CHECKOUT_SESSION_ID}'),
            'cancel_url' => url('/panier/confirmation'),
            'line_items' => $this->buildLineItems($cart, $totals),
            'metadata' => [
                'cart_id' => $cart->id,
            ],
        ]);

        return response()->json(['url' => $session->url]);
    }

    private function buildLineItems($cart, $totals)
    {
        return [[
            'price_data' => [
                'currency' => 'eur',
                'unit_amount' => (int)($totals['totalTTC'] * 100),
                'product_data' => [
                    'name' => 'Commande',
                ],
            ],
            'quantity' => 1,
        ]];
    }

    public function webhook(Request $request)
    {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $secret = config('services.stripe.webhook_secret');
        
        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
        
        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;
            $cartId = $session->metadata->cart_id;
            
            $cart = Cart::with('items.product', 'items.productVariant.product')->find($cartId);
            
            if ($cart) {
                $this->createOrder($cart, $session->payment_intent);
            }
        }
        
        return response()->json(['status' => 'ok']);
    }

    public function store(Request $request)
    {
        $cart = Cart::with('items.product', 'items.productVariant.product')->findOrFail($request->cart_id);
        $totals = $this->calculTotal($cart);

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
            $isVariant = $item->productVariant !== null;
            $price = $isVariant ? $item->productVariant->price : $item->product->price;

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $isVariant ? $item->productVariant->product->id : $item->product->id,
                'product_variant_id' => $isVariant ? $item->productVariant->id : null,
                'quantity' => $item->quantity,
                'price' => $price,
            ]);

            if ($isVariant) {
                $item->productVariant->decrement('stock', $item->quantity);
            } else {
                $item->product->decrement('stock', $item->quantity);
            }
        }

        $cart->delete();
        return response()->json($order);
    }

    private function createOrder($cart, $paymentIntentId)
    {
        $totals = $this->calculTotal($cart);

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
            'status' => 'paid',
            'stripe_payment_id' => $paymentIntentId,
        ]);

        foreach ($cart->items as $item) {
            $isVariant = $item->productVariant !== null;
            $price = $isVariant ? $item->productVariant->price : $item->product->price;

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $isVariant ? $item->productVariant->product->id : $item->product->id,
                'product_variant_id' => $isVariant ? $item->productVariant->id : null,
                'quantity' => $item->quantity,
                'price' => $price,
            ]);

            if ($isVariant) {
                $item->productVariant->decrement('stock', $item->quantity);
            } else {
                $item->product->decrement('stock', $item->quantity);
            }
        }

        $cart->delete();
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
