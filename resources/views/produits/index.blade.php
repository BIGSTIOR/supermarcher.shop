<x-layouts.app>
    <x-slot:title>Produits | Supermarché</x-slot:title>

    <div class="container py-5">
        <div class="row g-4">
            <aside class="col-lg-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Filtres</h5>

                        <form action="{{ route('produits.index') }}" method="GET" class="row g-3">
                            <div class="col-12">
                                <label class="form-label" for="q">Recherche</label>
                                <input id="q" type="text" name="q" value="{{ $search }}" class="form-control" placeholder="Produit...">
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="categorie_id">Catégorie</label>
                                <select id="categorie_id" name="categorie_id" class="form-select">
                                    <option value="">Toutes les catégories</option>
                                    @foreach ($categories as $categorie)
                                        <option value="{{ $categorie->id }}" @selected((string) $categoryId === (string) $categorie->id)>{{ $categorie->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-success w-100">Appliquer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </aside>

            <section class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                    <h1 class="fw-bold mb-0">Nos produits</h1>
                    <span class="badge bg-light text-dark border">{{ $products->total() }} produits</span>
                </div>

                <div class="row g-4">
                    @forelse ($products as $product)
                        <div class="col-md-6 col-xl-4">
                            @include('partials.product-card', ['product' => $product])
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-light border">Aucun produit ne correspond à votre recherche.</div>
                        </div>
                    @endforelse
                </div>

                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            </section>
        </div>
    </div>
</x-layouts.app>
