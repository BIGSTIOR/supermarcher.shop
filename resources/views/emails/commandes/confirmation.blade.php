@component('mail::message')
# Confirmation de commande

Bonjour,

Votre commande **{{ $commande->numero_commande }}** a bien été enregistrée.

### Détails
- Montant total : **{{ number_format($commande->montant_total, 2, ',', ' ') }} FCFA**
- Statut : **{{ $commande->statut }}**
- Adresse de livraison : **{{ $commande->adresse_livraison }}**

Merci d’avoir choisi notre supermarché.

@component('mail::button', ['url' => url('/commandes/' . $commande->id)])
Voir ma commande
@endcomponent

Merci,
{{ config('app.name') }}
@endcomponent
