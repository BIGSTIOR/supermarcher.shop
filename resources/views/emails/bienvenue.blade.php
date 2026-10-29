@component('mail::layout')

@slot('header')
@component('mail::header', ['url' => config('app.url')])
{{ config('app.name') }}
@endcomponent
@endslot

# Bienvenue chez {{ config('app.name') }}

Bonjour {{ $user->name }},

Votre inscription a bien été enregistrée. Nous sommes ravis de vous accueillir dans notre boutique en ligne.

Vous pouvez dès à présent :
- parcourir nos produits de qualité,
- ajouter vos articles préférés au panier,
- passer vos commandes en quelques clics,
- suivre vos achats avec simplicité.

@component('mail::button', ['url' => url('/'), 'color' => 'success'])
Commencer mes achats
@endcomponent

Merci de faire confiance à {{ config('app.name') }}. Nous mettons tout en œuvre pour vous offrir une expérience d’achat agréable, rapide et fiable.

Cordialement,  
L’équipe {{ config('app.name') }}

@slot('footer')
@component('mail::footer', ['url' => config('app.url')])
© {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.
@endcomponent
@endslot

@endcomponent
