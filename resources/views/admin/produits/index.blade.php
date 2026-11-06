<x-layouts.app>
    <x-slot:title>Produits admin | Supermarché</x-slot:title>

    <div class="container py-5">
        @include('admin.partials.navigation')
        <h1 class="fw-bold mb-4">Gestion des produits</h1>
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h2 class="h5 fw-bold mb-3">Ajouter un produit</h2>
                <form method="POST" action="{{ route('admin.produits.store') }}" class="row g-3">
                    @csrf
                    <div class="col-md-4"><label class="form-label" for="nom">Nom</label><input class="form-control" id="nom" name="nom" value="{{ old('nom') }}" required maxlength="150"></div>
                    <div class="col-md-4"><label class="form-label" for="categorie_id">Catégorie</label><select class="form-select" id="categorie_id" name="categorie_id" required><option value="">Choisir…</option>@foreach ($categories as $category)<option value="{{ $category->id }}">{{ $category->nom }}</option>@endforeach</select></div>
                    <div class="col-md-2"><label class="form-label" for="prix">Prix (FCFA)</label><input class="form-control" id="prix" name="prix" type="number" min="0" step="0.01" required></div>
                    <div class="col-md-2"><label class="form-label" for="stock">Stock</label><input class="form-control" id="stock" name="stock" type="number" min="0" value="0" required></div>
                    <div class="col-md-3"><label class="form-label" for="unite">Unité</label><input class="form-control" id="unite" name="unite" value="pièce" maxlength="30" required></div>
                    <div class="col-md-5"><label class="form-label" for="image">URL de l’image</label><input class="form-control" id="image" name="image" type="url"></div>
                    <div class="col-md-4"><label class="form-label" for="description">Description</label><input class="form-control" id="description" name="description"></div>
                    <div class="col-12"><div class="form-check"><input class="form-check-input" id="actif" name="actif" type="checkbox" value="1" checked><label class="form-check-label" for="actif">Produit visible dans la boutique</label></div></div>
                    <div class="col-12"><button class="btn btn-success">Ajouter le produit</button></div>
                </form>
            </div>
        </div>
        <div class="card border-0 shadow-sm"><div class="card-body p-4">
            <div class="table-responsive"><table class="table table-striped align-middle"><thead><tr><th>Produit</th><th>Catégorie</th><th>Prix</th><th>Stock</th><th>Visibilité</th><th>Enregistrer</th></tr></thead><tbody>
                @forelse ($products as $product)
                    <tr>
                        <td><input form="product-{{ $product->id }}" class="form-control mb-2" name="nom" value="{{ $product->nom }}" required><textarea form="product-{{ $product->id }}" class="form-control" name="description" rows="2" placeholder="Description">{{ $product->description }}</textarea><input form="product-{{ $product->id }}" class="form-control mt-2" type="url" name="image" value="{{ $product->image }}" placeholder="URL image"></td>
                        <td><select form="product-{{ $product->id }}" class="form-select" name="categorie_id" required>@foreach ($categories as $category)<option value="{{ $category->id }}" @selected($product->categorie_id === $category->id)>{{ $category->nom }}</option>@endforeach</select><input form="product-{{ $product->id }}" class="form-control mt-2" name="unite" value="{{ $product->unite }}" required></td>
                        <td><input form="product-{{ $product->id }}" class="form-control" type="number" min="0" step="0.01" name="prix" value="{{ $product->prix }}" required></td>
                        <td><input form="product-{{ $product->id }}" class="form-control" type="number" min="0" name="stock" value="{{ $product->stock }}" required></td>
                        <td><div class="form-check"><input form="product-{{ $product->id }}" class="form-check-input" type="checkbox" name="actif" value="1" @checked($product->actif)><label class="form-check-label">Actif</label></div></td>
                        <td><form id="product-{{ $product->id }}" method="POST" action="{{ route('admin.produits.update', $product) }}">@csrf @method('PUT')<button class="btn btn-outline-success btn-sm">Enregistrer</button></form></td>
                    </tr>
                @empty<tr><td colspan="6" class="text-center text-body-secondary">Aucun produit enregistré.</td></tr>@endforelse
            </tbody></table></div>{{ $products->links() }}
        </div></div>
    </div>
</x-layouts.app>
