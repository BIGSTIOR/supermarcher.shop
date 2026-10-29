<x-layouts.app>
    <x-slot:title>Profil | Supermarché</x-slot:title>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4 p-lg-5">
                        <h1 class="fw-bold mb-4">Mon profil</h1>
                        <form action="{{ route('profil.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Nom</label>
                                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">E-mail</label>
                                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="telephone" class="form-label">Téléphone</label>
                                    <input type="text" id="telephone" name="telephone" value="{{ old('telephone', $user->telephone) }}" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="ville" class="form-label">Ville</label>
                                    <input type="text" id="ville" name="ville" value="{{ old('ville', $user->ville) }}" class="form-control">
                                </div>
                                <div class="col-12">
                                    <label for="adresse" class="form-label">Adresse</label>
                                    <textarea id="adresse" name="adresse" class="form-control" rows="3">{{ old('adresse', $user->adresse) }}</textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success mt-4">Enregistrer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
