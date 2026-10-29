<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/produits', [ProductController::class, 'index'])->name('produits.index');
Route::get('/produits/{produit}', [ProductController::class, 'show'])->name('produits.show');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/login')->with('success', 'Votre compte a été validé avec succès. Vous pouvez maintenant vous connecter.');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::middleware('auth')->group(function () {
    Route::get('/profil', [ProfileController::class, 'show'])->name('profil');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profil.update');

    Route::get('/panier', [CartController::class, 'index'])->name('panier');
    Route::post('/panier/ajouter/{produit}', [CartController::class, 'add'])->name('panier.ajouter');
    Route::patch('/panier/modifier/{produit}', [CartController::class, 'update'])->name('panier.modifier');
    Route::delete('/panier/supprimer/{produit}', [CartController::class, 'remove'])->name('panier.supprimer');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::get('/commandes', [OrderController::class, 'index'])->name('commandes.index');
    Route::get('/commandes/{commande}', [OrderController::class, 'show'])->name('commandes.show');

    Route::get('/assistant', [ChatController::class, 'index'])->name('assistant');
    Route::post('/assistant', [ChatController::class, 'store'])->name('assistant.store');
});

Route::middleware(['auth', 'can:access-admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/produits', [AdminController::class, 'products'])->name('admin.produits');
    Route::get('/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::get('/clients', [AdminController::class, 'customers'])->name('admin.clients');
    Route::get('/commandes', [AdminController::class, 'orders'])->name('admin.commandes');
    Route::get('/paiements', [AdminController::class, 'payments'])->name('admin.paiements');
    Route::get('/livraisons', [AdminController::class, 'deliveries'])->name('admin.livraisons');
});
