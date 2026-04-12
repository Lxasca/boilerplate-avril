<?php

namespace App\Http\Controllers\Ecom;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
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
    // méthode pour supprimer un produit du panier (peu importe sa quantité)
    // méthode pour vider le panier
    // méthode pour calculer le total HT
    // méthode pour calculer le total TTC
    // méthode pour appliquer un code-promo
}
