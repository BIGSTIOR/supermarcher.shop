<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Commande;
use App\Models\Livraison;
use App\Models\Paiement;
use App\Models\Produit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'can:access-admin']);
    }

    public function index()
    {
        $stats = [
            'produits' => Produit::count(),
            'categories' => Categorie::count(),
            'commandes' => Commande::count(),
            'clients' => User::where('role', 'client')->count(),
            'revenus' => Commande::sum('montant_total'),
        ];

        $recentOrders = Commande::query()
            ->with(['user', 'paiement', 'livraison'])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }

    public function products()
    {
        $products = Produit::query()->with('categorie')->orderByDesc('created_at')->paginate(15);

        return view('admin.produits.index', compact('products'));
    }

    public function categories()
    {
        $categories = Categorie::query()->orderBy('nom')->paginate(15);

        return view('admin.categories.index', compact('categories'));
    }

    public function customers()
    {
        $customers = User::query()->where('role', 'client')->orderByDesc('created_at')->paginate(15);

        return view('admin.clients.index', compact('customers'));
    }

    public function orders()
    {
        $orders = Commande::query()->with(['user', 'paiement', 'livraison'])->orderByDesc('created_at')->paginate(15);

        return view('admin.commandes.index', compact('orders'));
    }

    public function payments()
    {
        $payments = Paiement::query()->with('commande')->orderByDesc('created_at')->paginate(15);

        return view('admin.paiements.index', compact('payments'));
    }

    public function deliveries()
    {
        $deliveries = Livraison::query()->with('commande')->orderByDesc('created_at')->paginate(15);

        return view('admin.livraisons.index', compact('deliveries'));
    }
}
