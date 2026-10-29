<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Produit;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q', ''));

        $categories = Categorie::query()
            ->where('actif', true)
            ->orderBy('nom')
            ->get();

        $popularProducts = Produit::query()
            ->where('actif', true)
            ->orderByDesc('nombre_recherches')
            ->limit(4)
            ->get();

        $featuredProducts = Produit::query()
            ->where('actif', true)
            ->orderByDesc('created_at')
            ->limit(8)
            ->get();

        $searchResults = [];
        if ($search !== '') {
            $searchResults = Produit::query()
                ->where('actif', true)
                ->where(function ($query) use ($search) {
                    $query->where('nom', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                })
                ->with('categorie')
                ->take(8)
                ->get();
        }

        return view('home', compact('categories', 'popularProducts', 'featuredProducts', 'searchResults', 'search'));
    }
}
