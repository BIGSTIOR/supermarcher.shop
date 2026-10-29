<x-layouts.app>
    <x-slot:title>Commande | Supermarché</x-slot:title>

    <div class="container py-5">
        <h1 class="fw-bold mb-4">Validation de la commande</h1>

        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h2 class="h4 fw-bold mb-3">Informations de livraison</h2>
                        <form method="POST" action="{{ route('checkout.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="adresse_livraison" class="form-label">Adresse de livraison</label>
                                <textarea id="adresse_livraison" name="adresse_livraison" class="form-control" required rows="4"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="telephone_livraison" class="form-label">Téléphone</label>
                                <input id="telephone_livraison" type="text" name="telephone_livraison" value="{{ Auth::user()->telephone ?? old('telephone_livraison') }}" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="notes" class="form-label">Notes supplémentaires</label>
                                <textarea id="notes" name="notes" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="mode_paiement" class="form-label">Mode de paiement</label>
                                <select id="mode_paiement" name="mode_paiement" class="form-select" required>
                                    <option value="livraison">Paiement à la livraison</option>
                                    <option value="mobile_money">Mobile Money</option>
                                    <option value="carte_bancaire">Carte bancaire</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success btn-lg">Confirmer la commande</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h2 class="h4 fw-bold mb-3">Récapitulatif</h2>
                        @foreach ($items as $item)
                            <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                <div>
                                    <div class="fw-semibold">{{ $item['product']->nom }}</div>
                                    <small class="text-body-secondary">Qté : {{ $item['quantity'] }}</small>
                                </div>
                                <div>{{ number_format($item['line_total'], 2, ',', ' ') }} FCFA</div>
                            </div>
                        @endforeach
                        <div class="d-flex justify-content-between fw-bold fs-5 mt-3">
                            <span>Total</span>
                            <span>{{ number_format($total, 2, ',', ' ') }} FCFA</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
