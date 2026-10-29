<?php

namespace Database\Seeders;

use App\Models\Categorie;
use App\Models\Produit;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@supermarche.local'],
            [
                'name' => 'Administrateur',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'client@supermarche.local'],
            [
                'name' => 'Client Test',
                'password' => bcrypt('client123'),
                'role' => 'client',
                'email_verified_at' => now(),
            ]
        );

        $categories = [
            ['nom' => 'Fruits et légumes', 'description' => 'Produits frais du jour', 'image' => null, 'actif' => true],
            ['nom' => 'Boissons', 'description' => 'Boissons rafraîchissantes et jus', 'image' => null, 'actif' => true],
            ['nom' => 'Épicerie', 'description' => 'Produits de base et de cuisine', 'image' => null, 'actif' => true],
            ['nom' => 'Maison', 'description' => 'Produits pour la maison', 'image' => null, 'actif' => true],
        ];

        foreach ($categories as $category) {
            Categorie::firstOrCreate(['nom' => $category['nom']], $category);
        }

        $fruits = Categorie::where('nom', 'Fruits et légumes')->first();
        $boissons = Categorie::where('nom', 'Boissons')->first();
        $epicerie = Categorie::where('nom', 'Épicerie')->first();
        $maison = Categorie::where('nom', 'Maison')->first();

        $products = [
            ['categorie_id' => $fruits?->id, 'nom' => 'Pommes', 'description' => 'Pommes bio, croquantes et sucrées.', 'prix' => 2.50, 'stock' => 80, 'unite' => 'kg', 'image' => null, 'actif' => true, 'nombre_recherches' => 32],
            ['categorie_id' => $fruits?->id, 'nom' => 'Bananes', 'description' => 'Bananes mûres, idéales pour le petit déjeuner.', 'prix' => 1.80, 'stock' => 60, 'unite' => 'kg', 'image' => null, 'actif' => true, 'nombre_recherches' => 28],
            ['categorie_id' => $fruits?->id, 'nom' => 'Carottes', 'description' => 'Carottes fraîches et bien goûteuses.', 'prix' => 1.60, 'stock' => 70, 'unite' => 'kg', 'image' => null, 'actif' => true, 'nombre_recherches' => 21],
            ['categorie_id' => $boissons?->id, 'nom' => 'Eau minérale 1L', 'description' => 'Eau naturelle, rafraîchissante et légère.', 'prix' => 0.90, 'stock' => 120, 'unite' => 'bouteille', 'image' => null, 'actif' => true, 'nombre_recherches' => 41],
            ['categorie_id' => $boissons?->id, 'nom' => 'Jus d’orange', 'description' => 'Jus de fruits 100% pur jus.', 'prix' => 3.20, 'stock' => 55, 'unite' => 'bouteille', 'image' => null, 'actif' => true, 'nombre_recherches' => 18],
            ['categorie_id' => $epicerie?->id, 'nom' => 'Riz blanc', 'description' => 'Riz de qualité pour tous vos repas.', 'prix' => 2.10, 'stock' => 90, 'unite' => 'kg', 'image' => null, 'actif' => true, 'nombre_recherches' => 25],
            ['categorie_id' => $epicerie?->id, 'nom' => 'Huile d’olive', 'description' => 'Huile d’olive extra vierge de grande qualité.', 'prix' => 6.80, 'stock' => 40, 'unite' => 'bouteille', 'image' => null, 'actif' => true, 'nombre_recherches' => 17],
            ['categorie_id' => $maison?->id, 'nom' => 'Lessive', 'description' => 'Lessive pour linge délicat et efficace.', 'prix' => 5.40, 'stock' => 36, 'unite' => 'flacon', 'image' => null, 'actif' => true, 'nombre_recherches' => 12],
        ];

        foreach ($products as $product) {
            if (! empty($product['categorie_id'])) {
                Produit::firstOrCreate(
                    ['nom' => $product['nom'], 'categorie_id' => $product['categorie_id']],
                    $product
                );
            }
        }
    }
}
