<?php

namespace App\Http\Controllers;

use App\Models\Panier;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $items = [];
        $total = 0;

        foreach ($this->cart() as $productId => $cartItem) {
            $product = Produit::where('actif', true)->find($productId);

            if (! $product) {
                continue;
            }

            $quantity = (int) (is_array($cartItem) ? ($cartItem['quantite'] ?? 0) : $cartItem);
            $lineTotal = $product->prix * $quantity;
            $items[] = [
                'product' => $product,
                'quantity' => $quantity,
                'line_total' => $lineTotal,
            ];
            $total += $lineTotal;
        }

        return view('panier.index', compact('items', 'total'));
    }

    public function add(Produit $produit, Request $request)
    {
        $validated = $request->validate([
            'quantite' => ['required', 'integer', 'min:1'],
        ]);

        $quantity = (int) $validated['quantite'];

        if ($produit->stock < $quantity) {
            return back()->withErrors(['quantite' => 'Le stock disponible est insuffisant pour cette quantité.']);
        }

        $cart = $this->cart();
        $existing = (int) ($cart[$produit->id]['quantite'] ?? 0);
        $newQuantity = $existing + $quantity;

        if ($newQuantity > $produit->stock) {
            return back()->withErrors(['quantite' => 'La quantité totale dépasse le stock disponible.']);
        }

        $cart[$produit->id] = ['quantite' => $newQuantity];
        session()->put('cart', $cart);

        if (Auth::check()) {
            Panier::updateOrCreate(
                ['user_id' => Auth::id(), 'produit_id' => $produit->id],
                ['quantite' => $newQuantity]
            );
        }

        return redirect()->route('panier')->with('success', 'Le produit a été ajouté au panier.');
    }

    public function update(Produit $produit, Request $request)
    {
        $validated = $request->validate([
            'quantite' => ['required', 'integer', 'min:1'],
        ]);

        $quantity = (int) $validated['quantite'];

        if ($quantity > $produit->stock) {
            return back()->withErrors(['quantite' => 'La quantité demandée est supérieure au stock disponible.']);
        }

        $cart = $this->cart();
        $cart[$produit->id] = ['quantite' => $quantity];
        session()->put('cart', $cart);

        if (Auth::check()) {
            Panier::updateOrCreate(
                ['user_id' => Auth::id(), 'produit_id' => $produit->id],
                ['quantite' => $quantity]
            );
        }

        return redirect()->route('panier')->with('success', 'Le panier a été mis à jour.');
    }

    public function remove(Produit $produit)
    {
        $cart = $this->cart();
        unset($cart[$produit->id]);
        session()->put('cart', $cart);

        if (Auth::check()) {
            Panier::where('user_id', Auth::id())->where('produit_id', $produit->id)->delete();
        }

        return redirect()->route('panier')->with('success', 'Le produit a été retiré du panier.');
    }

    protected function cart(): array
    {
        $cart = session('cart', []);

        if (Auth::check()) {
            $dbCart = Panier::where('user_id', Auth::id())->get();
            foreach ($dbCart as $item) {
                $cart[$item->produit_id] = ['quantite' => $item->quantite];
            }
        }

        return $cart;
    }
}
