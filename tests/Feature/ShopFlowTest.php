<?php

namespace Tests\Feature;

use App\Models\Categorie;
use App\Models\Produit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ShopFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_displays_storefront_and_products(): void
    {
        $categorie = Categorie::create([
            'nom' => 'Fruits',
            'description' => 'Produits frais',
            'actif' => true,
        ]);

        Produit::create([
            'categorie_id' => $categorie->id,
            'nom' => 'Pommes Gala',
            'description' => 'Pommes croquantes',
            'prix' => 3.50,
            'stock' => 20,
            'unite' => 'kg',
            'actif' => true,
            'nombre_recherches' => 12,
        ]);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Boutique');
        $response->assertSee('Pommes Gala');
    }

    public function test_user_can_register(): void
    {
        Mail::fake();

        $response = $this->post('/register', [
            'name' => 'Alice',
            'email' => 'alice@example.com',
            'password' => 'Motdepasse!123',
            'password_confirmation' => 'Motdepasse!123',
        ]);

        $response->assertRedirect('/email/verify');
        $this->assertDatabaseHas('users', ['email' => 'alice@example.com']);
        Mail::assertSent(\App\Mail\BienvenueClient::class, function ($mail) {
            return $mail->hasTo('alice@example.com');
        });
    }

    public function test_authenticated_user_can_add_product_to_cart(): void
    {
        $user = User::factory()->create();
        $categorie = Categorie::create([
            'nom' => 'Légumes',
            'description' => 'Pour la cuisine',
            'actif' => true,
        ]);

        $produit = Produit::create([
            'categorie_id' => $categorie->id,
            'nom' => 'Carottes',
            'description' => 'Carottes bio',
            'prix' => 2.00,
            'stock' => 15,
            'unite' => 'kg',
            'actif' => true,
            'nombre_recherches' => 8,
        ]);

        $response = $this->actingAs($user)->post('/panier/ajouter/' . $produit->id, [
            'quantite' => 2,
        ]);

        $response->assertRedirect('/panier');
        $this->assertDatabaseHas('paniers', [
            'user_id' => $user->id,
            'produit_id' => $produit->id,
            'quantite' => 2,
        ]);
    }
}
