<x-layouts.app>
    <x-slot:title>Accueil | Supermarché</x-slot:title>

    <section class="bg-success-subtle py-5 border-bottom">
        <div class="container py-5">
            <div class="row align-items-center g-4">
                <div class="col-lg-6">
                    <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle px-3 py-2 mb-3">Nouvelle offre</span>
                    <h1 class="display-5 fw-bold mb-3">Boutique en ligne pour des courses simples et rapides</h1>
                    <p class="lead text-body-secondary mb-4">Découvrez les meilleurs produits frais, essentiels et maison, livrés à domicile avec fiabilité.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('produits.index') }}" class="btn btn-success btn-lg">Découvrir nos produits</a>
                        <a href="{{ route('assistant') }}" class="btn btn-outline-success btn-lg">Parler à l’assistant</a>
                    </div>
                    <div class="d-flex gap-4 mt-4 text-secondary">
                        <div>
                            <div class="fw-bold fs-4 text-success">2 000+</div>
                            <small>Clients satisfaits</small>
                        </div>
                        <div>
                            <div class="fw-bold fs-4 text-success">48h</div>
                            <small>Livraison rapide</small>
                        </div>
                        <div>
                            <div class="fw-bold fs-4 text-success">4.9/5</div>
                            <small>Note moyenne</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=1200&q=80" class="img-fluid w-100" alt="Produits du supermarché" style="height: 440px; object-fit: cover;">
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if($search !== '')
        <section class="container py-4">
            <div class="alert alert-info mb-0">Résultats de recherche pour : <strong>{{ $search }}</strong></div>
        </section>
    @endif

    <section class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Catégories</h2>
        </div>
        <div class="row g-4">
            @forelse ($categories as $categorie)
                <div class="col-12 col-sm-6 col-lg-3">
                    <a href="{{ route('produits.index', ['categorie_id' => $categorie->id]) }}" class="text-decoration-none text-reset">
                        <div class="card h-100 border-0 shadow-sm hover-shadow transition">
                            <img src="{{ $categorie->image ?: 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=600&q=80' }}" class="card-img-top" alt="{{ $categorie->nom }}" style="height: 180px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">{{ $categorie->nom }}</h5>
                                <p class="card-text text-body-secondary mb-0">{{ Str::limit($categorie->description ?? 'Produits de qualité', 80) }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-light border">Aucune catégorie disponible pour le moment.</div>
                </div>
            @endforelse
        </div>
    </section>

    <section class="container py-3">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Produits populaires</h2>
            <a href="{{ route('produits.index') }}" class="btn btn-link text-success text-decoration-none">Voir tout</a>
        </div>
        <div class="row g-4">
            @forelse ($popularProducts as $product)
                <div class="col-12 col-sm-6 col-lg-3">
                    @include('partials.product-card', ['product' => $product])
                </div>
            @empty
                <div class="col-12"><div class="alert alert-light border">Aucun produit populaire pour le moment.</div></div>
            @endforelse
        </div>
    </section>

    <section class="container py-3">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Produits les plus recherchés</h2>
        </div>
        <div class="row g-4">
            @forelse ($featuredProducts as $product)
                <div class="col-12 col-sm-6 col-lg-3">
                    @include('partials.product-card', ['product' => $product])
                </div>
            @empty
                <div class="col-12"><div class="alert alert-light border">Aucun produit disponible.</div></div>
            @endforelse
        </div>
    </section>

    @if (!empty($searchResults))
        <section class="container py-3 pb-5">
            <h2 class="fw-bold mb-4">Résultats rapides</h2>
            <div class="row g-4">
                @foreach ($searchResults as $product)
                    <div class="col-md-6 col-lg-3">
                        @include('partials.product-card', ['product' => $product])
                    </div>
                @endforeach
            </div>
        </section>
    @endif
</x-layouts.app>
