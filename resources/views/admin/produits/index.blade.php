<x-layouts.app>
    <x-slot:title>Produits admin | Supermarché</x-slot:title>

    <div class="container py-5">
        <h1 class="fw-bold mb-4">Gestion des produits</h1>
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th>Catégorie</th>
                                <th>Prix</th>
                                <th>Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->nom }}</td>
                                    <td>{{ $product->categorie?->nom ?? '—' }}</td>
                                    <td>{{ number_format($product->prix, 2, ',', ' ') }} FCFA</td>
                                    <td>{{ $product->stock }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-layouts.app>
