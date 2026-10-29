<x-layouts.app>
    <x-slot:title>Commandes admin | Supermarché</x-slot:title>

    <div class="container py-5">
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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->numero_commande }}</td>
                                    <td>{{ $order->user?->name ?? '—' }}</td>
                                    <td>{{ number_format($order->montant_total, 2, ',', ' ') }} FCFA</td>
                                    <td>{{ $order->statut }}</td>
                                    <td>{{ $order->livraison?->statut ?? '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</x-layouts.app>
