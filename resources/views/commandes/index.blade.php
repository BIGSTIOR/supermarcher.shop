<x-layouts.app>
    <x-slot:title>Mes commandes | Supermarché</x-slot:title>

    <div class="container py-5">
        <h1 class="fw-bold mb-4">Historique des commandes</h1>

        @if ($orders->isEmpty())
            <div class="alert alert-light border">Aucune commande n’a été passée pour le moment.</div>
        @else
            <div class="list-group">
                @foreach ($orders as $order)
                    <a href="{{ route('commandes.show', $order) }}" class="list-group-item list-group-item-action">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div>
                                <div class="fw-bold">Commande {{ $order->numero_commande }}</div>
                                <small class="text-body-secondary">{{ $order->created_at->translatedFormat('d F Y') }}</small>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold text-success">{{ number_format($order->montant_total, 2, ',', ' ') }} FCFA</div>
                                <span class="badge text-bg-light">{{ $order->statut }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="mt-4">{{ $orders->links() }}</div>
        @endif
    </div>
</x-layouts.app>
