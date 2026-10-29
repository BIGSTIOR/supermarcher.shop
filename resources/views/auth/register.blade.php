<x-layouts.app>
    <x-slot:title>Inscription | Supermarché</x-slot:title>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4 p-lg-5">
                        <h1 class="h3 fw-bold mb-3">Créer un compte</h1>
                        <p class="text-body-secondary">Complétez vos informations pour passer vos commandes plus rapidement.</p>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Nom complet</label>
                                    <input id="name" type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">E-mail</label>
                                    <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="password" class="form-label">Mot de passe</label>
                                    <input id="password" type="password" name="password" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label">Confirmation</label>
                                    <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success w-100 mt-4">S'inscrire</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
