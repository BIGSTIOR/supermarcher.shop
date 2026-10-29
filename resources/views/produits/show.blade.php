<x-layouts.app>
    <x-slot:title>{{ $produit->nom }} | Supermarché</x-slot:title>

    <div class="container py-5">
        <div class="row g-5 align-items-start">
            <div class="col-lg-6">
                <img src="{{ $produit->image ?: 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=1200&q=80' }}" alt="{{ $produit->nom }}" class="img-fluid rounded-4 shadow-sm w-100" style="height: 500px; object-fit: cover;">
            </div>
            <div class="col-lg-6">
                <span class="badge bg-success-subtle text-success-emphasis mb-3">{{ $produit->categorie?->nom ?? 'Produit' }}</span>
                <h1 class="fw-bold mb-3">{{ $produit->nom }}</h1>
                <div class="fs-3 fw-bold text-success mb-3">{{ number_format($produit->prix, 2, ',', ' ') }} FCFA</div>
                <p class="text-body-secondary">{{ $produit->description }}</p>

                <ul class="list-unstyled my-4">
                    <li class="mb-2"><strong>Disponibilité :</strong> {{ $produit->stock > 0 ? $produit->stock . ' en stock' : 'Épuisé' }}</li>
                    <li><strong>Unité :</strong> {{ $produit->unite }}</li>
                </ul>

                @if ($produit->stock > 0)
                    <form action="{{ route('panier.ajouter', $produit) }}" method="POST" class="d-flex align-items-center gap-3">
                        @csrf
                        <input type="number" name="quantite" min="1" max="{{ $produit->stock }}" value="1" class="form-control" style="max-width: 110px;">
                        <button type="submit" class="btn btn-success btn-lg">Ajouter au panier</button>
                    </form>
                @else
                    <button class="btn btn-secondary btn-lg" disabled>Produit indisponible</button>
                @endif
            </div>
        </div>

        @if ($relatedProducts->isNotEmpty())
            <div class="mt-5">
                <h2 class="fw-bold mb-4">Produits similaires</h2>
                <div class="row g-4">
                    @foreach ($relatedProducts as $related)
                        <div class="col-md-6 col-lg-3">
                            @include('partials.product-card', ['product' => $related])
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-layouts.app>
