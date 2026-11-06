<x-layouts.app>
    <x-slot:title>Commandes admin | Supermarché</x-slot:title>

    <div class="container py-5">
        @include('admin.partials.navigation')
        <h1 class="fw-bold mb-4">Gestion des commandes</h1>
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Commande</th>
                                <th>Client</th>
                                <th>Montant</th>
                                <th>Statut</th>
                                <th>Livraison</th>
                                <th>Mettre à jour</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                                <tr>
                                    <td><div class="fw-semibold">{{ $order->numero_commande }}</div><details class="small mt-1"><summary>Détails</summary><div class="mt-2">@foreach ($order->details as $detail)<div>{{ $detail->quantite }} × {{ $detail->produit?->nom ?? 'Produit supprimé' }} — {{ number_format($detail->sous_total, 2, ',', ' ') }} FCFA</div>@endforeach<div class="mt-2">{{ $order->adresse_livraison }}<br>{{ $order->telephone_livraison }}</div></div></details></td>
                                    <td>{{ $order->user?->name ?? '—' }}</td>
                                    <td>{{ number_format($order->montant_total, 2, ',', ' ') }} FCFA</td>
                                    <td>{{ $order->statut }}</td>
                                    <td>{{ $order->livraison?->statut ?? '—' }}</td>
                                    <td><form method="POST" action="{{ route('admin.commandes.update', $order) }}" class="d-flex gap-2">@csrf @method('PUT')<select class="form-select form-select-sm" name="statut">@foreach (['en_attente' => 'En attente', 'confirmee' => 'Confirmée', 'en_preparation' => 'En préparation', 'expediee' => 'Expédiée', 'livree' => 'Livrée', 'annulee' => 'Annulée'] as $value => $label)<option value="{{ $value }}" @selected($order->statut === $value)>{{ $label }}</option>@endforeach</select><button class="btn btn-outline-success btn-sm">OK</button></form></td>
                                </tr>
                                @empty<tr><td colspan="6" class="text-center text-body-secondary">Aucune commande.</td></tr>@endforelse
                        </tbody>
                    </table>
                </div>
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</x-layouts.app>
