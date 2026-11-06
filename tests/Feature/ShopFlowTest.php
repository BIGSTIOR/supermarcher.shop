<?php

namespace Tests\Feature;

use App\Mail\BienvenueClient;
use App\Models\Categorie;
use App\Models\Commande;
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
        Mail::assertSent(BienvenueClient::class, function ($mail) {
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

        $response = $this->actingAs($user)->post('/panier/ajouter/'.$produit->id, [
            'quantite' => 2,
        ]);

        $response->assertRedirect('/panier');
        $this->assertDatabaseHas('paniers', [
            'user_id' => $user->id,
            'produit_id' => $produit->id,
            'quantite' => 2,
        ]);
    }

    public function test_catalog_search_and_detail_pages_are_available(): void
    {
        $categorie = Categorie::create([
            'nom' => 'Épicerie',
            'description' => 'Produits secs',
            'actif' => true,
        ]);

        $produit = Produit::create([
            'categorie_id' => $categorie->id,
            'nom' => 'Riz local',
            'description' => 'Riz parfumé pour le quotidien',
            'prix' => 4700,
            'stock' => 24,
            'unite' => 'kg',
            'actif' => true,
            'nombre_recherches' => 10,
        ]);

        $response = $this->get('/produits?categorie_id='.$categorie->id.'&tri=prix_croissant&q=riz');
        $response->assertOk();
        $response->assertSee('Riz local');

        $detailResponse = $this->get('/produits/'.$produit->id);
        $detailResponse->assertOk();
        $detailResponse->assertSee('Riz local');
    }

    public function test_client_can_complete_checkout_and_view_order(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'role' => 'client',
            'email_verified_at' => now(),
        ]);

        $categorie = Categorie::create([
            'nom' => 'Produits frais',
            'description' => 'Fruits et légumes',
            'actif' => true,
        ]);

        $produit = Produit::create([
            'categorie_id' => $categorie->id,
            'nom' => 'Tomates',
            'description' => 'Tomates fraîches',
            'prix' => 3.20,
            'stock' => 12,
            'unite' => 'kg',
            'actif' => true,
            'nombre_recherches' => 4,
        ]);

        $this->actingAs($user)->post('/panier/ajouter/'.$produit->id, ['quantite' => 2]);

        $response = $this->actingAs($user)->post('/checkout', [
            'adresse_livraison' => '12 Rue de la Paix, Abidjan',
            'telephone_livraison' => '+225 0700000000',
            'notes' => 'Livraison rapide',
            'mode_paiement' => 'mobile_money',
        ]);

        $response->assertRedirect();

        $commande = Commande::query()->where('user_id', $user->id)->first();
        $this->assertNotNull($commande);
        $this->assertDatabaseHas('commandes', ['user_id' => $user->id, 'adresse_livraison' => '12 Rue de la Paix, Abidjan']);
        $this->assertDatabaseHas('paiements', ['commande_id' => $commande->id, 'mode_paiement' => 'mobile_money']);
        $this->assertDatabaseHas('livraisons', ['commande_id' => $commande->id, 'adresse' => '12 Rue de la Paix, Abidjan']);

        $detailResponse = $this->actingAs($user)->get('/commandes/'.$commande->id);
        $detailResponse->assertOk();
        $detailResponse->assertSee($commande->numero_commande);
    }

    public function test_admin_access_is_protected_and_dashboard_is_available_for_admin(): void
    {
        $client = User::factory()->create([
            'role' => 'client',
            'email_verified_at' => now(),
        ]);

        $admin = User::factory()->create([
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $this->actingAs($client)->get('/admin')->assertForbidden();

        $response = $this->actingAs($admin)->get('/admin');
        $response->assertOk();
        $response->assertSee('Tableau de bord');
    }
}
