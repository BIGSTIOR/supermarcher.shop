<x-layouts.app>
    <x-slot:title>Administration | Supermarché</x-slot:title>

    <div class="container py-5">
        <h1 class="fw-bold mb-4">Tableau de bord</h1>

        <div class="row g-4 mb-4">
            <div class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-body-secondary">Produits</div>
                        <div class="fs-3 fw-bold text-success">{{ $stats['produits'] }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-body-secondary">Catégories</div>
                        <div class="fs-3 fw-bold text-success">{{ $stats['categories'] }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-body-secondary">Commandes</div>
                        <div class="fs-3 fw-bold text-success">{{ $stats['commandes'] }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="text-body-secondary">Revenus</div>
                        <div class="fs-3 fw-bold text-success">{{ number_format($stats['revenus'], 2, ',', ' ') }} FCFA</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h2 class="h4 fw-bold mb-3">Commandes récentes</h2>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Commande</th>
                                <th>Client</th>
                                <th>Montant</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentOrders as $order)
                                <tr>
                                    <td>{{ $order->numero_commande }}</td>
                                    <td>{{ $order->user?->name ?? 'Client' }}</td>
                                    <td>{{ number_format($order->montant_total, 2, ',', ' ') }} FCFA</td>
                                    <td><span class="badge bg-light text-dark">{{ $order->statut }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
