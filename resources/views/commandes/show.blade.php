<x-layouts.app>
    <x-slot:title>Détail commande | Supermarché</x-slot:title>

    <div class="container py-5">
        <h1 class="fw-bold mb-4">Commande {{ $commande->numero_commande }}</h1>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                            <h2 class="h4 fw-bold mb-0">Produits</h2>
                            <span class="badge bg-light text-dark">{{ $commande->statut }}</span>
                        </div>
                        @foreach ($commande->details as $detail)
                            <div class="d-flex justify-content-between align-items-center border-bottom py-3">
                                <div>
                                    <div class="fw-semibold">{{ $detail->produit?->nom ?? 'Produit supprimé' }}</div>
                                    <small class="text-body-secondary">Quantité : {{ $detail->quantite }}</small>
                                </div>
                                <div>{{ number_format($detail->sous_total, 2, ',', ' ') }} FCFA</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm border-0 mb-3">
                    <div class="card-body p-4">
                        <h3 class="h5 fw-bold mb-3">Livraison</h3>
                        <p class="mb-1"><strong>Adresse :</strong> {{ $commande->adresse_livraison }}</p>
                        <p class="mb-1"><strong>Téléphone :</strong> {{ $commande->telephone_livraison }}</p>
                        <p class="mb-0"><strong>Statut :</strong> {{ $commande->livraison?->statut ?? 'Non renseigné' }}</p>
                    </div>
                </div>
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h3 class="h5 fw-bold mb-3">Paiement</h3>
                        <p class="mb-1"><strong>Mode :</strong> {{ $commande->paiement?->mode_paiement ?? 'Non renseigné' }}</p>
                        <p class="mb-0"><strong>Montant :</strong> {{ number_format($commande->montant_total, 2, ',', ' ') }} FCFA</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
