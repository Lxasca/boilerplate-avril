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
        $item->increment('quantity');

        return response()->json($item);
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
            return response()->json($item);
        } else {
            return $this->removeItem($item);
            
        }
    }

    // méthode pour supprimer un produit du panier (peu importe sa quantité)
    public function removeItem($item) {
        $item->delete();

        return response()->json(['message' => 'Produit supprimé du panier']);
    }
    // méthode pour vider le panier
    // méthode pour calculer le total HT
    // méthode pour calculer le total TTC
    // méthode pour appliquer un code-promo
}
