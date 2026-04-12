<?php

namespace App\Http\Controllers\Ecom;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // méthode pour afficher le contenu du panier (produits x quantités)
    public function cart()
    {
        $cart = Cart::with('items.product')->firstOrFail();
        return response()->json($cart);
    }

    // méthode pour calculer le nombre total de produits dans le panier
    // méthode pour ajouter / incrémenter un produit
    public function add(Request $request)
    {
        $cart = Cart::first() ?? Cart::create();

        $item = CartItem::firstOrCreate(
            // les champs qui permettent de retrouver l'instance en bdd :
            ['cart_id' => $cart->id, 'product_id' => $request->product_id],
            // et si aucune instance n'est trouvé, on create et on met la quantité à 0
            ['quantity' => 0]
        );

        // dans les deux cas, on +1 
        if ($item->product->stock > 1) {
            $item->increment('quantity');
        }

        return response()->json($cart);
    }

    // méthode pour décrémenter un produit
    public function decrement(Request $request)
    {
        $cart = Cart::firstOrFail();

        $item = CartItem::where(
            ['cart_id' => $cart->id, 'product_id' => $request->product_id]
        )->first();

        if ($item->quantity > 1) {
            $item->decrement('quantity');
        } else {
            $item->delete();
        }

        return response()->json($cart);
    }

    // méthodes pour supprimer un produit du panier (peu importe sa quantité)
   
    public function removeItem(Request $request)
    {
        $cart = Cart::firstOrFail();

        $item = CartItem::where(
            ['cart_id' => $cart->id, 'product_id' => $request->product_id]
        )->first();

        $item->delete();
        
        return response()->json($cart);
    }

    // méthode pour vider le panier
    public function removeCart(Request $request) {
        $cart = Cart::find($request->cart_id);
        $cart->delete();

        return response()->json([]);
    }

    // méthode pour calculer le total HT
    // méthode pour calculer le total TTC
    // méthode pour appliquer un code-promo
}
