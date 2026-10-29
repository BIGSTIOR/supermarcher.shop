<?php

namespace App\Http\Controllers;

use App\Mail\CommandeConfirmee;
use App\Models\Commande;
use App\Models\DetailCommande;
use App\Models\Livraison;
use App\Models\Paiement;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);

        if ($cart === []) {
            return redirect()->route('panier')->with('error', 'Votre panier est vide.');
        }

        $items = [];
        $total = 0;

        foreach ($cart as $productId => $line) {
            $produit = Produit::where('actif', true)->find($productId);

            if (! $produit) {
                continue;
            }

            $quantity = (int) $line['quantite'];
            $lineTotal = $produit->prix * $quantity;
            $items[] = [
                'product' => $produit,
                'quantity' => $quantity,
                'line_total' => $lineTotal,
            ];
            $total += $lineTotal;
        }

        if ($items === []) {
            return redirect()->route('panier')->with('error', 'Votre panier ne contient plus de produits disponibles.');
        }

        return view('commande.index', compact('items', 'total'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'adresse_livraison' => ['required', 'string', 'max:255'],
            'telephone_livraison' => ['required', 'string', 'max:30'],
            'notes' => ['nullable', 'string', 'max:500'],
            'mode_paiement' => ['required', 'in:livraison,mobile_money,carte_bancaire'],
        ]);

        $cart = session('cart', []);

        if ($cart === []) {
            return redirect()->route('panier')->with('error', 'Votre panier est vide.');
        }

        $items = [];
        $total = 0;

        foreach ($cart as $productId => $line) {
            $produit = Produit::where('actif', true)->find($productId);
            if (! $produit) {
                continue;
            }
            $quantity = (int) $line['quantite'];
            if ($quantity > $produit->stock) {
                return redirect()->route('panier')->with('error', sprintf('Le produit %s n\'a plus assez de stock.', $produit->nom));
            }
            $lineTotal = $produit->prix * $quantity;
            $total += $lineTotal;
            $items[] = [
                'produit' => $produit,
                'quantite' => $quantity,
                'prix_unitaire' => $produit->prix,
                'sous_total' => $lineTotal,
            ];
        }

        if ($items === []) {
            return redirect()->route('panier')->with('error', 'Aucun produit valide n\'est disponible dans le panier.');
        }

        return DB::transaction(function () use ($validated, $items, $total, $request) {
            $commande = Commande::create([
                'user_id' => Auth::id(),
                'numero_commande' => 'CMD-'. strtoupper(Str::random(8)),
                'montant_total' => $total,
                'statut' => 'en_attente',
                'adresse_livraison' => $validated['adresse_livraison'],
                'telephone_livraison' => $validated['telephone_livraison'],
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($items as $item) {
                DetailCommande::create([
                    'commande_id' => $commande->id,
                    'produit_id' => $item['produit']->id,
                    'quantite' => $item['quantite'],
                    'prix_unitaire' => $item['prix_unitaire'],
                    'sous_total' => $item['sous_total'],
                ]);

                $item['produit']->decrement('stock', $item['quantite']);
            }

            Paiement::create([
                'commande_id' => $commande->id,
                'mode_paiement' => $validated['mode_paiement'],
                'montant' => $total,
                'statut' => 'en_attente',
                'reference_transaction' => 'AUTO-'. strtoupper(Str::random(10)),
            ]);

            Livraison::create([
                'commande_id' => $commande->id,
                'adresse' => $validated['adresse_livraison'],
                'statut' => 'en_attente',
            ]);

            session()->forget('cart');

            if (Auth::check() && Auth::user()->email) {
                Mail::to(Auth::user()->email)->send(new CommandeConfirmee($commande));
            }

            return redirect()->route('commandes.show', $commande)->with('success', 'Votre commande a bien été enregistrée.');
        });
    }
}
