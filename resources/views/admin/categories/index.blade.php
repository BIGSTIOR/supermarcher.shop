<x-layouts.app>
    <x-slot:title>Catégories admin | Supermarché</x-slot:title>

    <div class="container py-5">
        <h1 class="fw-bold mb-4">Gestion des catégories</h1>
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Description</th>
                                <th>Actif</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->nom }}</td>
                                    <td>{{ $category->description ?? '—' }}</td>
                                    <td>{{ $category->actif ? 'Oui' : 'Non' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</x-layouts.app>
