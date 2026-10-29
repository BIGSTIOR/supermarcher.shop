<x-layouts.app>
    <x-slot:title>Livraisons admin | Supermarché</x-slot:title>

    <div class="container py-5">
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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($deliveries as $delivery)
                                <tr>
                                    <td>{{ $delivery->commande?->numero_commande ?? '—' }}</td>
                                    <td>{{ $delivery->nom_livreur ?: 'Non assigné' }}</td>
                                    <td>{{ $delivery->telephone_livreur ?: '—' }}</td>
                                    <td>{{ $delivery->statut }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $deliveries->links() }}
            </div>
        </div>
    </div>
</x-layouts.app>
