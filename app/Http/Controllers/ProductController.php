<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Produit;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q', ''));
        $categoryId = $request->query('categorie_id');

        $query = Produit::query()
            ->where('actif', true)
            ->with('categorie');

        if ($search !== '') {
            $query->where(function ($where) use ($search) {
                $where->where('nom', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($categoryId) {
            $query->where('categorie_id', $categoryId);
        }

        $products = $query->orderByDesc('nombre_recherches')->paginate(12)->withQueryString();
        $categories = Categorie::query()->where('actif', true)->orderBy('nom')->get();

        return view('produits.index', compact('products', 'categories', 'search', 'categoryId'));
    }

    public function show(Produit $produit)
    {
        abort_if(! $produit->actif, 404);

        $produit->increment('nombre_recherches');
        $produit->load('categorie');

        $relatedProducts = Produit::query()
            ->where('actif', true)
            ->where('categorie_id', $produit->categorie_id)
            ->where('id', '!=', $produit->id)
            ->limit(4)
            ->get();

        return view('produits.show', compact('produit', 'relatedProducts'));
    }
}
