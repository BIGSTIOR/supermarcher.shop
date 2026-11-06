<x-layouts.app>
    <x-slot:title>Catégories admin | Supermarché</x-slot:title>

    <div class="container py-5">
        @include('admin.partials.navigation')
        <h1 class="fw-bold mb-4">Gestion des catégories</h1>
        <div class="card border-0 shadow-sm mb-4"><div class="card-body p-4">
            <h2 class="h5 fw-bold mb-3">Ajouter une catégorie</h2>
            <form method="POST" action="{{ route('admin.categories.store') }}" class="row g-3">@csrf
                <div class="col-md-4"><label class="form-label" for="nom">Nom</label><input class="form-control" id="nom" name="nom" required maxlength="100"></div>
                <div class="col-md-4"><label class="form-label" for="description">Description</label><input class="form-control" id="description" name="description"></div>
                <div class="col-md-3"><label class="form-label" for="image">URL image</label><input class="form-control" id="image" name="image" type="url"></div>
                <div class="col-md-1 d-flex align-items-end"><button class="btn btn-success">Créer</button></div>
            </form>
        </div></div>
        <div class="card border-0 shadow-sm"><div class="card-body p-4"><div class="table-responsive"><table class="table table-striped align-middle">
            <thead><tr><th>Nom</th><th>Description</th><th>Image</th><th>Visible</th><th></th></tr></thead><tbody>
            @forelse ($categories as $category)
                <tr>
                    <td colspan="5"><form method="POST" action="{{ route('admin.categories.update', $category) }}" class="row g-2 align-items-center">@csrf @method('PUT')
                        <div class="col-md-3"><input class="form-control" name="nom" value="{{ $category->nom }}" required maxlength="100"></div>
                        <div class="col-md-3"><input class="form-control" name="description" value="{{ $category->description }}"></div>
                        <div class="col-md-3"><input class="form-control" name="image" type="url" value="{{ $category->image }}" placeholder="URL image"></div>
                        <div class="col-md-1"><input class="form-check-input" type="checkbox" name="actif" value="1" @checked($category->actif) aria-label="Catégorie visible"></div>
                        <div class="col-md-2"><button class="btn btn-outline-success btn-sm">Enregistrer</button></div>
                    </form></td>
                </tr>
            @empty<tr><td colspan="5" class="text-center text-body-secondary">Aucune catégorie enregistrée.</td></tr>@endforelse
            </tbody></table></div>{{ $categories->links() }}</div></div>
    </div>
</x-layouts.app>
