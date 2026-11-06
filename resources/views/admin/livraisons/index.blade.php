<x-layouts.app>
    <x-slot:title>Livraisons admin | Supermarché</x-slot:title>

    <div class="container py-5">
        @include('admin.partials.navigation')
        <h1 class="fw-bold mb-4">Gestion des livraisons</h1>
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Commande</th>
                                <th>Livreur</th>
                                <th>Téléphone</th>
                                <th>Statut</th>
                                <th>Gestion</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($deliveries as $delivery)
                                <tr>
                                    <td>{{ $delivery->commande?->numero_commande ?? '—' }}</td>
                                    <td>{{ $delivery->nom_livreur ?: 'Non assigné' }}</td>
                                    <td>{{ $delivery->telephone_livreur ?: '—' }}</td>
                                    <td>{{ $delivery->statut }}</td>
                                    <td><form method="POST" action="{{ route('admin.livraisons.update', $delivery) }}" class="d-flex flex-column gap-2">@csrf @method('PUT')<div class="d-flex gap-2"><input class="form-control form-control-sm" name="nom_livreur" value="{{ $delivery->nom_livreur }}" placeholder="Livreur"><input class="form-control form-control-sm" name="telephone_livreur" value="{{ $delivery->telephone_livreur }}" placeholder="Téléphone"></div><div class="d-flex gap-2"><select class="form-select form-select-sm" name="statut">@foreach (['en_attente' => 'En attente', 'en_preparation' => 'En préparation', 'expediee' => 'Expédiée', 'livree' => 'Livrée', 'annulee' => 'Annulée'] as $value => $label)<option value="{{ $value }}" @selected($delivery->statut === $value)>{{ $label }}</option>@endforeach</select><button class="btn btn-outline-success btn-sm">Enregistrer</button></div><input class="form-control form-control-sm" name="commentaire" value="{{ $delivery->commentaire }}" placeholder="Commentaire"></form></td>
                                </tr>
                            @empty<tr><td colspan="5" class="text-center text-body-secondary">Aucune livraison.</td></tr>@endforelse
                        </tbody>
                    </table>
                </div>
                {{ $deliveries->links() }}
            </div>
        </div>
    </div>
</x-layouts.app>
