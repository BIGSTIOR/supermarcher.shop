<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Produit;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'categorie_id' => [
                'nullable',
                'integer',
                Rule::exists('categories', 'id'),
            ],
            'prix_min' => ['nullable', 'numeric', 'min:0'],
            'prix_max' => ['nullable', 'numeric', 'min:0', 'gte:prix_min'],
            'disponibilite' => ['nullable', Rule::in(['disponible'])],
            'tri' => [
                'nullable',
                Rule::in([
                    'popularite',
                    'prix_croissant',
                    'prix_decroissant',
                    'nom',
                ]),
            ],
        ]);

        $search = trim($filters['q'] ?? '');
        $categoryId = $filters['categorie_id'] ?? null;
        $prixMin = $filters['prix_min'] ?? null;
        $prixMax = $filters['prix_max'] ?? null;
        $disponibilite = $filters['disponibilite'] ?? null;
        $tri = $filters['tri'] ?? 'popularite';

        $query = Produit::query()
            ->where('actif', true)
            ->with('categorie');

        // Recherche par nom ou description.
        if ($search !== '') {
            $query->where(function ($where) use ($search) {
                $where->where('nom', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filtre par catégorie.
        if ($categoryId !== null) {
            $query->where('categorie_id', $categoryId);
        }

        // Filtre par prix minimum et maximum.
        if ($prixMin !== null && $prixMin !== '') {
            $query->where('prix', '>=', $prixMin);
        }

        if ($prixMax !== null && $prixMax !== '') {
            $query->where('prix', '<=', $prixMax);
        }

        // Afficher uniquement les produits en stock.
        if ($disponibilite === 'disponible') {
            $query->where('stock', '>', 0);
        }

        // Tri choisi par le client.
        switch ($tri) {
            case 'prix_croissant':
                $query->orderBy('prix', 'asc');
                break;

            case 'prix_decroissant':
                $query->orderBy('prix', 'desc');
                break;

            case 'nom':
                $query->orderBy('nom', 'asc');
                break;

            default:
                $query->orderByDesc('nombre_recherches')
                    ->orderBy('nom');
                break;
        }

        $products = $query->paginate(12)->withQueryString();

        $categories = Categorie::query()
            ->where('actif', true)
            ->orderBy('nom')
            ->get();

        return view('produits.index', compact(
            'products',
            'categories',
            'search',
            'categoryId',
            'prixMin',
            'prixMax',
            'disponibilite',
            'tri'
        ));
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

        return view('produits.show', compact(
            'produit',
            'relatedProducts'
        ));
    }
}
