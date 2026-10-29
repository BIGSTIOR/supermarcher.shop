<x-layouts.app>
    <x-slot:title>Connexion | Supermarché</x-slot:title>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4 p-lg-5">
                        <h1 class="h3 fw-bold mb-3">Connexion</h1>
                        <p class="text-body-secondary">Accédez à votre compte pour suivre vos commandes.</p>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control" required autocomplete="email">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Mot de passe</label>
                                <input id="password" type="password" name="password" class="form-control" required autocomplete="current-password">
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label" for="remember">Se souvenir de moi</label>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Se connecter</button>
                        </form>

                        <p class="mt-3 mb-0 text-center">Pas encore inscrit ? <a href="{{ route('register') }}" class="text-success text-decoration-none">Créer un compte</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
