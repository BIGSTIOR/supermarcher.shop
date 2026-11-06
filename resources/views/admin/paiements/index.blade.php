<x-layouts.app>
    <x-slot:title>Paiements admin | Supermarché</x-slot:title>

    <div class="container py-5">
        @include('admin.partials.navigation')
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
                                <th>Gestion</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($payments as $payment)
                                <tr>
                                    <td>{{ $payment->commande?->numero_commande ?? '—' }}</td>
                                    <td>{{ $payment->mode_paiement }}</td>
                                    <td>{{ number_format($payment->montant, 2, ',', ' ') }} FCFA</td>
                                    <td>{{ $payment->statut }}</td>
                                    <td><form method="POST" action="{{ route('admin.paiements.update', $payment) }}" class="d-flex flex-column flex-lg-row gap-2">@csrf @method('PUT')<select class="form-select form-select-sm" name="statut">@foreach (['en_attente' => 'En attente', 'paye' => 'Payé', 'echoue' => 'Échoué', 'rembourse' => 'Remboursé'] as $value => $label)<option value="{{ $value }}" @selected($payment->statut === $value)>{{ $label }}</option>@endforeach</select><input class="form-control form-control-sm" name="reference_transaction" value="{{ $payment->reference_transaction }}" placeholder="Référence"><button class="btn btn-outline-success btn-sm">Enregistrer</button></form></td>
                                </tr>
                            @empty<tr><td colspan="5" class="text-center text-body-secondary">Aucun paiement.</td></tr>@endforelse
                        </tbody>
                    </table>
                </div>
                {{ $payments->links() }}
            </div>
        </div>
    </div>
</x-layouts.app>
