<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Commande;
use App\Models\Livraison;
use App\Models\Paiement;
use App\Models\Produit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
        $categories = Categorie::query()->orderBy('nom')->get();

        return view('admin.produits.index', compact('products', 'categories'));
    }

    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'categorie_id' => ['required', 'integer', Rule::exists('categories', 'id')],
            'nom' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'prix' => ['required', 'numeric', 'min:0', 'max:9999999999.99'],
            'stock' => ['required', 'integer', 'min:0'],
            'unite' => ['required', 'string', 'max:30'],
            'image' => ['nullable', 'url', 'max:255'],
            'actif' => ['sometimes', 'boolean'],
        ]);
        $validated['actif'] = $request->boolean('actif');
        Produit::create($validated);

        return back()->with('success', 'Le produit a été créé.');
    }

    public function updateProduct(Request $request, Produit $produit)
    {
        $validated = $request->validate([
            'categorie_id' => ['required', 'integer', Rule::exists('categories', 'id')],
            'nom' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'prix' => ['required', 'numeric', 'min:0', 'max:9999999999.99'],
            'stock' => ['required', 'integer', 'min:0'],
            'unite' => ['required', 'string', 'max:30'],
            'image' => ['nullable', 'url', 'max:255'],
            'actif' => ['sometimes', 'boolean'],
        ]);
        $validated['actif'] = $request->boolean('actif');
        $produit->update($validated);

        return back()->with('success', 'Le produit a été mis à jour.');
    }

    public function categories()
    {
        $categories = Categorie::query()->orderBy('nom')->paginate(15);

        return view('admin.categories.index', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:100', 'unique:categories,nom'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'url', 'max:255'],
            'actif' => ['sometimes', 'boolean'],
        ]);
        $validated['actif'] = $request->boolean('actif');
        Categorie::create($validated);

        return back()->with('success', 'La catégorie a été créée.');
    }

    public function updateCategory(Request $request, Categorie $categorie)
    {
        $validated = $request->validate([
            'nom' => ['required', 'string', 'max:100', Rule::unique('categories', 'nom')->ignore($categorie->id)],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'url', 'max:255'],
            'actif' => ['sometimes', 'boolean'],
        ]);
        $validated['actif'] = $request->boolean('actif');
        $categorie->update($validated);

        return back()->with('success', 'La catégorie a été mise à jour.');
    }

    public function customers()
    {
        $customers = User::query()->where('role', 'client')->orderByDesc('created_at')->paginate(15);

        return view('admin.clients.index', compact('customers'));
    }

    public function orders()
    {
        $orders = Commande::query()->with(['user', 'paiement', 'livraison', 'details.produit'])->orderByDesc('created_at')->paginate(15);

        return view('admin.commandes.index', compact('orders'));
    }

    public function updateOrder(Request $request, Commande $commande)
    {
        $validated = $request->validate([
            'statut' => ['required', Rule::in(['en_attente', 'confirmee', 'en_preparation', 'expediee', 'livree', 'annulee'])],
        ]);
        $commande->update($validated);

        return back()->with('success', 'Le statut de la commande a été mis à jour.');
    }

    public function payments()
    {
        $payments = Paiement::query()->with('commande')->orderByDesc('created_at')->paginate(15);

        return view('admin.paiements.index', compact('payments'));
    }

    public function updatePayment(Request $request, Paiement $paiement)
    {
        $validated = $request->validate([
            'statut' => ['required', Rule::in(['en_attente', 'paye', 'echoue', 'rembourse'])],
            'reference_transaction' => ['nullable', 'string', 'max:255'],
        ]);
        $paiement->update($validated);
        if ($validated['statut'] === 'paye' && $paiement->date_paiement === null) {
            $paiement->update(['date_paiement' => now()]);
        }

        return back()->with('success', 'Le paiement a été mis à jour.');
    }

    public function deliveries()
    {
        $deliveries = Livraison::query()->with('commande')->orderByDesc('created_at')->paginate(15);

        return view('admin.livraisons.index', compact('deliveries'));
    }

    public function updateDelivery(Request $request, Livraison $livraison)
    {
        $validated = $request->validate([
            'nom_livreur' => ['nullable', 'string', 'max:150'],
            'telephone_livreur' => ['nullable', 'string', 'max:30'],
            'statut' => ['required', Rule::in(['en_attente', 'en_preparation', 'expediee', 'livree', 'annulee'])],
            'commentaire' => ['nullable', 'string', 'max:2000'],
        ]);
        if ($validated['statut'] === 'expediee' && $livraison->date_expedition === null) {
            $validated['date_expedition'] = now();
        }
        if ($validated['statut'] === 'livree' && $livraison->date_livraison === null) {
            $validated['date_livraison'] = now();
        }
        $livraison->update($validated);

        return back()->with('success', 'La livraison a été mise à jour.');
    }
}
