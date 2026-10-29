<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Supermarché en ligne pour les courses quotidiennes et les commandes rapides.">
    <title>{{ $title ?? config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light-subtle text-body">
    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">{{ config('app.name') }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('produits.index') }}">Produits</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('assistant') }}">Assistant</a></li>
                </ul>
                <form class="d-flex me-3" action="{{ route('produits.index') }}" method="GET">
                    <input class="form-control me-2" type="search" name="q" value="{{ request('q') }}" placeholder="Recherche" aria-label="Recherche" />
                    <button class="btn btn-outline-light" type="submit">Chercher</button>
                </form>
                <ul class="navbar-nav align-items-lg-center gap-2">
                    @auth
                        <li class="nav-item"><a class="nav-link" href="{{ route('profil') }}">Profil</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('commandes.index') }}">Mes commandes</a></li>
                        @if (Auth::user()->isAdmin())
                            <li class="nav-item"><a class="btn btn-light btn-sm" href="{{ route('admin.dashboard') }}">Admin</a></li>
                        @endif
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="btn btn-outline-light btn-sm" type="submit">Déconnexion</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Connexion</a></li>
                        <li class="nav-item"><a class="btn btn-light" href="{{ route('register') }}">Inscription</a></li>
                    @endauth
                    <li class="nav-item"><a class="btn btn-warning text-dark" href="{{ route('panier') }}">Panier</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @if (session('success'))
            <div class="container mt-4">
                <div class="alert alert-success" role="alert">{{ session('success') }}</div>
            </div>
        @endif
        @if (session('error'))
            <div class="container mt-4">
                <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
            </div>
        @endif
        @if ($errors->any())
            <div class="container mt-4">
                <div class="alert alert-danger" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        {{ $slot }}
    </main>

    <footer class="bg-dark text-white mt-5 py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <h5 class="fw-bold">Supermarché</h5>
                    <p class="text-white-50">Des courses de qualité pour toute la famille, livrées rapidement et avec un service client fiable.</p>
                </div>
                <div class="col-md-4">
                    <h5 class="fw-bold">Liens utiles</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}" class="text-white-50 text-decoration-none">Accueil</a></li>
                        <li><a href="{{ route('produits.index') }}" class="text-white-50 text-decoration-none">Produits</a></li>
                        <li><a href="{{ route('assistant') }}" class="text-white-50 text-decoration-none">Assistant</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5 class="fw-bold">Contact</h5>
                    <ul class="list-unstyled text-white-50">
                        <li>+221 77 000 00 00</li>
                        <li>contact@supermarche.local</li>
                        <li>Lundi - Samedi : 8h - 18h</li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
