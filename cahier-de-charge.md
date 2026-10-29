# Cahier des charges - Supermarché en ligne

## 1. Contexte
Le projet consiste à développer une application de commerce en ligne permettant à un client de parcourir des produits, de les ajouter à un panier, de passer une commande et de gérer son compte. L’application doit aussi proposer un espace d’administration pour gérer les produits, catégories, commandes, paiements et livraisons.

## 2. Objectif
Créer une boutique e-commerce simple, fonctionnelle et facile à utiliser, avec une interface claire et une architecture Laravel robuste.

## 3. Public cible
- Clients souhaitant acheter en ligne
- Gestionnaires / administrateurs de la boutique
- Équipe de maintenance technique

## 4. Fonctionnalités attendues

### 4.1 Côté client
- Consultation des produits
- Filtrage par catégorie
- Recherche de produits
- Ajout au panier
- Modification de la quantité
- Suppression d’articles du panier
- Vérification avant commande
- Inscription / connexion
- Validation d’email
- Suivi des commandes

### 4.2 Côté administrateur
- Tableau de bord administratif
- Gestion des catégories
- Gestion des produits
- Gestion des clients
- Gestion des commandes
- Gestion des paiements
- Gestion des livraisons
- Accès protégé par rôle admin

## 5. Rôles utilisateurs
- Client : peut parcourir, acheter, gérer son panier, consulter ses commandes
- Admin : accès complet aux fonctionnalités de gestion du magasin

## 6. Exigences fonctionnelles
- L’application doit permettre la création de compte utilisateur.
- Une commande ne doit être validée que pour un client connecté.
- Le système doit bloquer l’accès au back-office aux utilisateurs non admin.
- Le panier doit rester cohérent et éviter les erreurs de quantité.
- Les produits doivent être associés à une catégorie.
- Les paiements et livraisons doivent être traçables par commande.

## 7. Exigences non fonctionnelles
- Interface simple et responsive
- Code structuré, maintenable et évolutif
- Sécurité des mots de passe et protections CSRF
- Validation des formulaires côté serveur
- Support multilingue de base (français)

## 8. Stack technique
- PHP 8.3+
- Laravel 13
- MySQL ou SQLite en environnement local
- Blade pour les vues
- Bootstrap pour l’interface
- Composer pour les dépendances
- Vite pour les assets front

## 9. Schéma de données
Le projet repose sur les tables suivantes :
- users
- categories
- produits
- paniers
- commandes
- detail_commandes
- paiements
- livraisons
- sessions

## 10. Sécurité
- Authentification Laravel
- Vérification de l’email
- Rôles utilisateur avec gate `access-admin`
- Validation des données entrantes
- Protection CSRF sur formulaires

## 11. Critères de succès
- Le site s’ouvre sans erreur de connexion à la base de données.
- Le client peut s’inscrire et se connecter.
- Le client peut ajouter des produits au panier et passer une commande.
- L’admin peut accéder au dashboard et gérer les données du magasin.
- L’application fonctionne correctement en local et est prête pour publication.

## 12. Échéancier proposé
### Phase 1 - Base fonctionnelle
- mise en place Laravel
- configuration base de données
- création des modèles et migrations
- auth / roles

### Phase 2 - Boutique
- liste des produits
- panier
- process de commande

### Phase 3 - Admin
- gestion des produits et catégories
- gestion des commandes, paiements et livraisons

### Phase 4 - Finalisation
- tests
- correction des bugs
- préparation du dépôt GitHub
- déploiement éventuel

## 13. Livrables
- Application fonctionnelle Laravel
- Base de données configurée
- Comptes de test admin/client
- Documentation de démarrage
- Dépôt GitHub prêt à être publié

## 14. Comptes de démonstration
- Admin : admin@supermarche.local / admin123
- Client : client@supermarche.local / client123
