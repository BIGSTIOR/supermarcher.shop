<div class="card h-100 border-0 shadow-sm product-card">
    <a href="{{ route('produits.show', $product) }}" class="text-decoration-none text-reset">
        <img src="{{ $product->image ?: 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=800&q=80' }}" class="card-img-top" alt="{{ $product->nom }}" style="height: 220px; object-fit: cover;">
    </a>
    <div class="card-body d-flex flex-column">
        <span class="badge text-bg-light align-self-start mb-2">{{ $product->categorie?->nom ?? 'Produit' }}</span>
        <h5 class="card-title"><a href="{{ route('produits.show', $product) }}" class="text-decoration-none text-dark">{{ $product->nom }}</a></h5>
        <p class="card-text text-body-secondary small mb-3">{{ Str::limit($product->description ?? 'Produit de qualité', 80) }}</p>
        <div class="mt-auto d-flex justify-content-between align-items-center">
            <div>
                <div class="fw-bold text-success fs-5">{{ number_format($product->prix, 2, ',', ' ') }} FCFA</div>
                <small class="text-body-secondary">{{ $product->stock }} en stock</small>
            </div>
            <form action="{{ route('panier.ajouter', $product) }}" method="POST">
                @csrf
                <input type="hidden" name="quantite" value="1">
                <button type="submit" class="btn btn-success">+ Panier</button>
            </form>
        </div>
    </div>
</div>
