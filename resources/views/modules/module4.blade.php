<x-layouts.app>
    <x-slot:title>Module 4 : Finalisation | Supermarché</x-slot:title>

    <section class="bg-success-subtle border-bottom py-5">
        <div class="container py-4">
            <span class="badge bg-success text-white mb-3">Phase 4</span>
            <h1 class="display-5 fw-bold">Finalisation du projet</h1>
            <p class="lead text-body-secondary col-lg-8 mb-0">
                Cette étape vérifie les parcours essentiels, prépare le projet à être repris par une autre équipe
                et rassemble les éléments nécessaires à sa publication.
            </p>
        </div>
    </section>

    <section class="container py-5">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4 p-lg-5">
                        <h2 class="h3 fw-bold mb-4">Travaux de finalisation</h2>
                        <div class="d-flex gap-3 mb-4">
                            <span class="badge rounded-pill bg-success-subtle text-success-emphasis fs-6 align-self-start">1</span>
                            <div>
                                <h3 class="h5 fw-bold">Vérifier les fonctionnalités</h3>
                                <p class="text-body-secondary mb-0">Les tests couvrent les principaux parcours de la boutique. Les 6 tests existants ont réussi.</p>
                            </div>
                        </div>
                        <div class="d-flex gap-3 mb-4">
                            <span class="badge rounded-pill bg-success-subtle text-success-emphasis fs-6 align-self-start">2</span>
                            <div>
                                <h3 class="h5 fw-bold">Contrôler les ressources du site</h3>
                                <p class="text-body-secondary mb-0">La compilation de production avec Vite a réussi et a généré les fichiers CSS, JavaScript et le manifeste.</p>
                            </div>
                        </div>
                        <div class="d-flex gap-3 mb-4">
                            <span class="badge rounded-pill bg-success-subtle text-success-emphasis fs-6 align-self-start">3</span>
                            <div>
                                <h3 class="h5 fw-bold">Préparer la reprise du projet</h3>
                                <p class="text-body-secondary mb-0">Le README décrit l’installation, la configuration de l’environnement, les commandes utiles et les services à configurer.</p>
                            </div>
                        </div>
                        <div class="d-flex gap-3">
                            <span class="badge rounded-pill bg-warning-subtle text-warning-emphasis fs-6 align-self-start">4</span>
                            <div>
                                <h3 class="h5 fw-bold">Publication et déploiement</h3>
                                <p class="text-body-secondary mb-0">Le déploiement est une étape facultative. Il reste à choisir et configurer un hébergeur avant toute mise en ligne.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="alert alert-info border-0 rounded-4 mb-0" role="status">
                    <strong>État actuel :</strong> tests et compilation vérifiés en local. Aucun déploiement n’a été effectué.
                </div>
            </div>

            <aside class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4">
                        <h2 class="h4 fw-bold mb-4">Résultats vérifiés</h2>
                        <ul class="list-unstyled d-grid gap-3 mb-4">
                            <li class="d-flex justify-content-between gap-3"><span>Tests automatisés</span><span class="badge text-bg-success">6 réussis</span></li>
                            <li class="d-flex justify-content-between gap-3"><span>Build Vite</span><span class="badge text-bg-success">Réussi</span></li>
                            <li class="d-flex justify-content-between gap-3"><span>Déploiement</span><span class="badge text-bg-secondary">À planifier</span></li>
                        </ul>
                        <a href="{{ route('produits.index') }}" class="btn btn-success w-100">Retour à la boutique</a>
                    </div>
                </div>
            </aside>
        </div>
    </section>
</x-layouts.app>
