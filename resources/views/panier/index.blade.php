<x-layouts.app>
    <x-slot:title>Panier | Supermarché</x-slot:title>

    <div class="container py-5">
        <h1 class="fw-bold mb-4">Mon panier</h1>

        @if (empty($items))
            <div class="alert alert-light border">Votre panier est vide pour le moment.</div>
        @else
            <div class="row g-4">
                <div class="col-lg-8">
                    @foreach ($items as $item)
                        <div class="card shadow-sm border-0 mb-3">
                            <div class="card-body d-flex flex-column flex-md-row align-items-center gap-3">
                                <img src="{{ $item['product']->image ?: 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=800&q=80' }}" alt="{{ $item['product']->nom }}" class="img-fluid rounded" style="width: 120px; height: 120px; object-fit: cover;">
                                <div class="flex-grow-1">
                                    <h5 class="mb-1">{{ $item['product']->nom }}</h5>
                                    <p class="text-body-secondary mb-2">{{ number_format($item['product']->prix, 2, ',', ' ') }} FCFA / unité</p>
                                    <form action="{{ route('panier.modifier', $item['product']) }}" method="POST" class="d-flex gap-2 align-items-center">
                                        @csrf
                                        @method('PATCH')
                                        <label for="quantite-{{ $item['product']->id }}" class="form-label mb-0">Qté</label>
                                        <input id="quantite-{{ $item['product']->id }}" type="number" name="quantite" min="1" max="{{ $item['product']->stock }}" value="{{ $item['quantity'] }}" class="form-control" style="max-width: 90px;">
                                        <button type="submit" class="btn btn-outline-success btn-sm">Mettre à jour</button>
                                    </form>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold fs-5">{{ number_format($item['line_total'], 2, ',', ' ') }} FCFA</div>
                                    <form action="{{ route('panier.supprimer', $item['product']) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link text-danger text-decoration-none">Supprimer</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="col-lg-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h4 class="fw-bold mb-3">Résumé</h4>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Sous-total</span>
                                <span>{{ number_format($total, 2, ',', ' ') }} FCFA</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Livraison</span>
                                <span>0 FCFA</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between fw-bold fs-5">
                                <span>Total</span>
                                <span>{{ number_format($total, 2, ',', ' ') }} FCFA</span>
                            </div>
                            <a href="{{ route('checkout') }}" class="btn btn-success w-100 mt-4">Valider la commande</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-layouts.app>
