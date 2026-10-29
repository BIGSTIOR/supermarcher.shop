<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Commande::query()
            ->with(['details.produit', 'paiement', 'livraison'])
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('commandes.index', compact('orders'));
    }

    public function show(Commande $commande)
    {
        abort_unless($commande->user_id === Auth::id(), 403);

        $commande->load(['details.produit', 'paiement', 'livraison']);

        return view('commandes.show', compact('commande'));
    }

    public function adminIndex()
    {
        abort_unless(Auth::check() && Auth::user()->isAdmin(), 403);

        $orders = Commande::query()
            ->with(['user', 'paiement', 'livraison'])
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin.commandes.index', compact('orders'));
    }
}
