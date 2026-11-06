<nav class="mb-4" aria-label="Navigation administration">
    <div class="nav nav-pills flex-wrap gap-2">
        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Tableau de bord</a>
        <a class="nav-link {{ request()->routeIs('admin.produits*') ? 'active' : '' }}" href="{{ route('admin.produits') }}">Produits</a>
        <a class="nav-link {{ request()->routeIs('admin.categories*') ? 'active' : '' }}" href="{{ route('admin.categories') }}">Catégories</a>
        <a class="nav-link {{ request()->routeIs('admin.commandes*') ? 'active' : '' }}" href="{{ route('admin.commandes') }}">Commandes</a>
        <a class="nav-link {{ request()->routeIs('admin.paiements*') ? 'active' : '' }}" href="{{ route('admin.paiements') }}">Paiements</a>
        <a class="nav-link {{ request()->routeIs('admin.livraisons*') ? 'active' : '' }}" href="{{ route('admin.livraisons') }}">Livraisons</a>
        <a class="nav-link {{ request()->routeIs('admin.clients*') ? 'active' : '' }}" href="{{ route('admin.clients') }}">Clients</a>
    </div>
</nav>
