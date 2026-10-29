<x-layouts.app>
    <x-slot:title>Paiements admin | Supermarché</x-slot:title>

    <div class="container py-5">
        <h1 class="fw-bold mb-4">Gestion des paiements</h1>
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Commande</th>
                                <th>Mode</th>
                                <th>Montant</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                                <tr>
                                    <td>{{ $payment->commande?->numero_commande ?? '—' }}</td>
                                    <td>{{ $payment->mode_paiement }}</td>
                                    <td>{{ number_format($payment->montant, 2, ',', ' ') }} FCFA</td>
                                    <td>{{ $payment->statut }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $payments->links() }}
            </div>
        </div>
    </div>
</x-layouts.app>
